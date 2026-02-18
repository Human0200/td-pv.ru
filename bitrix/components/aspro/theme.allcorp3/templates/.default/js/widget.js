// selected thematic is current value by default
var selectedThematic = arAsproOptions.THEMATICS.VALUE;

// select current thematic value
var restoreThematics = function () {
  selectedThematic = arAsproOptions.THEMATICS.VALUE;
  selectThematic(selectedThematic, false);
};

// select thematic
var selectThematic = function (thematic, bShowPresets) {
  var $thematic = ($thematic = $(".presets .thematik .item[data-code=" + thematic + "]"));
  if ($thematic.length) {
    if (typeof arAsproOptions.THEMATICS.LIST[thematic] === "object") {
      // thematic found

      // save selected value
      selectedThematic = thematic;

      // mark as current
      $thematic.addClass("active").siblings().removeClass("active");

      // set "-" on presets`s subtab
      $(".presets .presets_subtabs .presets_subtab .desc").html("&mdash;");

      // set thematic title on thematics`s subtab
      $(".presets .presets_subtabs .presets_subtab:first .desc").text(arAsproOptions.THEMATICS.LIST[thematic].TITLE);

      // hide all presets
      $(".presets .presets_block .conf .item").addClass("hidden");

      // show add new preset in preset editor
      $(".presets .presets_block .conf .item .js-addpreset").closest(".item").removeClass("hidden"); //

      if (typeof BX.admin !== "object") {
        // if user is not admin, than hide APPLY buttons of all presets
        $(".presets .presets_block .conf .apply_conf_block").addClass("hidden");
      }

      // unmark current preset
      $(".presets .presets_block .conf .item .preset-block.current").removeClass("current");

      for (var i in arAsproOptions.THEMATICS.LIST[thematic].PRESETS.LIST) {
        //each thematic`s preset

        var preset = arAsproOptions.THEMATICS.LIST[thematic].PRESETS.LIST[i];
        var $presetBlock = $(".presets .presets_block .conf .item .preset-block[data-id=" + preset + "]");

        if ($presetBlock.length) {
          if (typeof arAsproOptions.PRESETS.LIST[preset] === "object") {
            // show preset
            $presetBlock.closest(".item").removeClass("hidden");

            // if selected thematic is without URL, than hide APPLY buttons of it`s presets
            if (arAsproOptions.THEMATICS.LIST[thematic].URL.length) {
              // show APPLY button
              $presetBlock.find(".apply_conf_block").removeClass("hidden");
            }

            if (arAsproOptions.THEMATICS.VALUE == thematic) {
              // selected current thematic

              // show APPLY button
              $presetBlock.find(".apply_conf_block").removeClass("hidden");

              if (arAsproOptions.PRESETS.VALUE == preset) {
                // current preset

                // mark as current preset
                $presetBlock.addClass("current");

                // set preset title on presets`s subtab
                $(".presets .presets_subtabs .presets_subtab:last .desc").text(
                  arAsproOptions.PRESETS.LIST[preset].TITLE
                );
              }
            }
          }
        }
      }

      if (typeof bShowPresets !== "undefined" && bShowPresets) {
        // open presets list
        $(".presets .presets_subtabs .presets_subtab").last().trigger("click");
      }

      return;
    }
  }
};

// select preset
var selectPreset = function (preset) {
  var $preset = $(".style-switcher .presets .preset-block[data-id=" + preset + "]");

  if ($preset.length) {
    if (
      // selected preset is current already or editing
      $preset.hasClass("current") ||
      $preset.hasClass("editing")
    ) {
      return;
    }

    if (typeof arAsproOptions.PRESETS.LIST[preset] === "object") {
      // is dev
      var bDev = location.hostname.indexOf("dev.aspro.ru") !== -1;

      // is demo
      var bDemo =
        !bDev &&
        typeof arAsproOptions.THEMATICS.LIST[selectedThematic] === "object" &&
        arAsproOptions.THEMATICS.LIST[selectedThematic].URL.length &&
        arAsproOptions.USE_DEMO_LINK === "Y";

      // is selected thematic not current
      var bPrepareWizard = !bDev && !bDemo && selectedThematic != arAsproOptions.THEMATICS.VALUE;

      if (bPrepareWizard) {
        // install new thematic
        prepareWizard(selectedThematic, preset);
      } else {
        // unmark current preset
        $(".style-switcher .presets .preset-block.current").removeClass("current");

        // mark as current
        $preset.addClass("current");

        // set preset title on presets`s subtab
        $preset.closest(".presets").find(".presets_subtab.active .desc").text($preset.find(".info .title").text());

        // apply preset configuration
        setConfiguration(selectedThematic, preset);
      }
    }
  }
};

var setConfiguration = function (thematic, preset) {
  if (typeof arAsproOptions.THEMATICS.LIST[thematic] === "object") {
    if (typeof arAsproOptions.PRESETS.LIST[preset] === "object") {
      // is dev
      var bDev = location.hostname.indexOf("dev.aspro.ru") !== -1;

      // is demo
      var bDemo = !bDev && arAsproOptions.THEMATICS.LIST[thematic].URL.length;

      if (bDemo && thematic !== arAsproOptions.THEMATICS.VALUE) {
        location.href = arAsproOptions.THEMATICS.LIST[thematic].URL + "?preset=" + preset;
      } else {
        $.ajax({
          type: "POST",
          data: {
            thematic: thematic,
            preset: preset,
          },
          success: function () {
            // close switcher
            $(".style-switcher .presets_action").trigger("click");

            setTimeout(function () {
              // go to main page
              location.href = location.href;
            }, 300);
          },
        });
      }
    }
  }
};

// show prepare wizard page, can redefine
if (typeof prepareWizard === "undefined") {
  prepareWizard = function (thematic, preset) {
    if (typeof arAsproOptions.THEMATICS.LIST[thematic] === "object") {
      if (typeof arAsproOptions.PRESETS.LIST[preset] === "object") {
        $.ajax({
          url: $(".style-switcher .contents.wizard").data("script"),
          type: "POST",
          data: {
            action: "getform",
            thematic: thematic,
            preset: preset,
            lang: BX.message.LANGUAGE_ID,
          },
          success: function (response) {
            // put response to content
            $(".style-switcher .contents.wizard").html(response);

            // show prepare wizard page
            $(".style-switcher .contents.wizard").addClass("active");
          },
        });
      }
    }
  };
}

$(document).ready(function () {
  //sort order for main page
  $(".refresh-block.sup-params .values .inner-wrapper").each(function () {
    var _th = $(this),
      sort_block = _th[0];
    Sortable.create(sort_block, {
      handle: ".drag",
      animation: 150,
      forceFallback: true,
      filter: ".no_drag",
      preventOnFilter: false,
      // Element dragging started
      onStart: function (/**Event*/ evt) {
        evt.oldIndex; // element index within parent
        window.getSelection().removeAllRanges();

        $(evt.item).find(".template_block, .bottom-options").addClass("hidden");
      },
      // Element dragging ended
      onEnd: function (/**Event*/ evt) {
        $(evt.item).find(".template_block, .bottom-options").removeClass("hidden");
      },
      onMove: function (evt) {
        return evt.related.className.indexOf("no_drag") === -1;
      },
      // Changed sorting within list
      onUpdate: function (/**Event*/ evt) {
        var itemEl = evt.item; // dragged HTMLElement
        var order = [],
          current_type = _th.data("key"),
          name = "SORT_ORDER_INDEX_TYPE_" + current_type;
        $(itemEl).find(".template_block, .bottom-options").removeClass("hidden");

        _th.find(".option-wrapper").each(function () {
          order.push(
            $(this)
              .find('.blocks input[type="checkbox"]')
              .attr("name")
              .replace(current_type + "_", "")
          );
          let orderIndex = $(this).index() + 1;
          let dragBlock = $(
            'div[data-class="' +
              $(this)
                .find('.blocks input[type="checkbox"]')
                .attr("name")
                .toLowerCase()
                .replace(current_type + "_", "") +
              '_drag"]'
          );

          dragBlock.attr("data-order", orderIndex);
					if (dragBlock[0]) {
						dragBlock[0].style.setProperty('--order-index', orderIndex);
					}
        });

        $("input[name=" + name + "]").val(order.join(","));

        $(".sharepreset-part--export").removeClass("sharepreset-part--exported2Link");

        //save option
        $.post(arAsproOptions["SITE_DIR"] + "ajax/options_save_mainpage.php", {
          VALUE: order.join(","),
          NAME: name,
        }).done(function() {
          $(".style-switcher .parametrs .action_block").addClass('can_save');
          $(".style-switcher .right-block .inner-content").addClass("with-action-block");
        });

        var eventdata = { action: "jsLoadBlock" };
        BX.onCustomEvent("onCompleteAction", [eventdata]);
      },
    });
  });

  if ($(".color_custom input[type=hidden]").length) {
    $(".color_custom input[type=hidden]").each(function () {
      var _this = $(this),
        parent = $(this).closest(".color_custom"),
        options = $(this).closest(".options");

      _this.spectrum({
        preferredFormat: "hex",
        showButtons: true,
        showInput: true,
        showPalette: false,
        appendTo: parent,
        chooseText: BX.message("CUSTOM_COLOR_CHOOSE"),
        cancelText: BX.message("CUSTOM_COLOR_CANCEL"),
        containerClassName: "custom_picker_container",
        replacerClassName: "custom_picker_replacer",
        clickoutFiresChange: false,
        move: function (color) {
          var colorCode = color.toHexString();
          parent.find("span span.bg").attr("style", "background:" + colorCode);
        },
        hide: function (color) {
          var colorCode = color.toHexString();
          parent.find("span span.bg").attr("style", "background:" + colorCode);
        },
        change: function (color) {
          var colorCode = color.toHexString();
          parent.addClass("current").siblings().removeClass("current");

          parent.find("span span.vals").text(colorCode);
          parent.find("span.animation-all").attr("style", "border-color:" + colorCode);

          checkDelay(options);

          $("form[name=style-switcher] input[name=" + parent.find(".click_block").data("option-id") + "]").val(
            parent.find(".click_block").data("option-value")
          );
          $("form[name=style-switcher]").submit();
        },
      });
    });
  }

  $(".color_custom").click(function (e) {
    e.preventDefault();
    $("input[name=" + $(this).data("name") + "]").spectrum("toggle");
    return false;
  });

  if ($(".base_color.current").length) {
    $(".base_color.current").each(function () {
      var color_block = $(this).closest(".options").find(".color_custom"),
        curcolor = $(this).data("color");
      if (curcolor != undefined && curcolor.length) {
        $("input[name=" + color_block.data("name") + "]").spectrum("set", curcolor);
        color_block.find("span span").attr("style", "background:" + curcolor);
      }
    });
  }

  $(".style-switcher .on-off-switch").on("click", function () {
    var $checkbox = $(this).prev();
    if ($checkbox.is("input[type=checkbox]")) {
      var name = $checkbox.attr("name");
      var bChecked = !$checkbox.prop("checked");

      if ($(this).hasClass('wait')) {
        return false;
      }

      $(this).addClass('wait');
      $checkbox.prop("checked", bChecked).trigger("change");

      setTimeout(function () {
        if (window.array.indexOf(name) == -1) {
          window.array.push(name);
          setTimeout(function () {
            window.array.splice(window.array.indexOf(name), 1);
          }, 500);

          var bNested =
            ($checkbox.closest(".values").length && !$checkbox.closest(".subs").length) ||
            $checkbox.closest(".option-ajax").length;

          var $options = $checkbox.closest(".options");

          if (bChecked) {
            $checkbox.val("Y");
          } else {
            $checkbox.val("N");
          }

          if (bNested) {
            var ajax_btn = $('<div class="btn-ajax-block animation-opacity"></div>'),
              option_wrapper = $checkbox.closest(".option-wrapper"),
              pos = BX.pos(option_wrapper[0], true),
              current_index = $checkbox.closest(".inner-wrapper").data("key"),
              div_class = name.replace(current_index + "_", ""),
              top = 0;

            ajax_btn.html($(".values > .apply-block").html());
            top = pos.top + $(".style-switcher .header").actual("outerHeight");
            ajax_btn.css("top", top);
            if ($(".btn-ajax-block").length) $(".btn-ajax-block").remove();
            ajax_btn.appendTo($(".style-switcher"));
            ajax_btn.addClass("opacity1");

            if (bChecked) {
              if (div_class == "WITH_LEFT_BLOCK") {
                $(".wrapper_inner.front").removeClass("wide_page");
                $(".wrapper1.front_page").addClass("with_left_block");
                $(".wrapper_inner.front .container_inner > .right_block").removeClass("wide_Y").addClass("wide_N");
                $(".wrapper_inner.front .container_inner > .left_block").removeClass("hidden");

                if (typeof window["stickySidebar"] !== "undefined") {
                  window["stickySidebar"].updateSticky();
                }
              }
              $(".drag-block[data-class=" + div_class.toLowerCase() + "_drag]").removeClass("hidden");
              $(".templates_block .item." + name + "").removeClass("hidden");

              //   InitFlexSlider();
              $(window).resize();

              if (div_class == "BIG_BANNER_INDEX") {
                $("body").addClass("header_opacity");
                $(window).resize();
              } else if (div_class == "MAPS" && typeof map !== "undefined" && typeof clusterer !== "undefined") {
                setTimeout(function () {
                  map.setBounds(clusterer.getBounds(), {
                    zoomMargin: 40,
                    // checkZoomRange: true
                  });
                }, 200);
              }
            } else {
              $(".drag-block[data-class=" + div_class.toLowerCase() + "_drag]").addClass("hidden");
              $(".templates_block .item." + name + "").addClass("hidden");

              if (div_class == "WITH_LEFT_BLOCK") {
                $(".wrapper_inner.front").addClass("wide_page");
                $(".wrapper1.front_page").removeClass("with_left_block");
                $(".wrapper_inner.front .container_inner > .right_block")
                  .removeClass("wide_N wide_")
                  .addClass("wide_Y");
                $(".wrapper_inner.front .container_inner > .left_block").addClass("hidden");
                $(window).resize();
              }

              if (div_class == "BIG_BANNER_INDEX") {
                $("body").removeClass("header_opacity");
              }
            }

            var eventdata = { action: "jsLoadBlock" };
            BX.onCustomEvent("onCompleteAction", [eventdata]);

            var options = {
              element: $(this.el),
              ajaxParent: $(this.el).closest(".option-ajax"),
              checked: bChecked,
              parent: $(this.el).closest(".option-ajax-target"),
            };
          }

          checkDelay($options);

          setTimeout(function () {
            if (!bNested) $("form[name=style-switcher]").submit();
          }, 200);
        } else {
          return false;
        }
      }, 300);
    }
  });

  const onScrollHandler = throttle(function (e) {
    var topPositionRightBlock = e.target.scrollTop;
    $.cookie("STYLE_SWITCHER_SCROLL_PARAMETERS", topPositionRightBlock, { path: arAsproOptions["SITE_DIR"] });
  }, 500);

  $(".style-switcher .contents.parametrs .right-block").on("scroll", onScrollHandler);

  if ($.cookie("STYLE_SWITCHER_SCROLL_PARAMETERS")) {
    document.querySelector(".right-block.scrollbar").scrollTop = $.cookie("STYLE_SWITCHER_SCROLL_PARAMETERS");
  }

  $(".style-switcher .item input[type=checkbox]").on("change", function () {
    $(".sharepreset-part--export").removeClass("sharepreset-part--exported2Link");

    var _this = $(this),
        option_wrapper = _this.closest('.option-wrapper'),
        bDisable = !_this.closest('.sub-item').length && !_this.closest('.filter').length;

    if (_this.is(":checked")) {
      _this.val("Y");
      option_wrapper.removeClass('disabled');
    } else {
      _this.val("N");

      if (bDisable) {
        option_wrapper.addClass('disabled');
      }
    }

    var bAjax = _this.data("dynamic") !== undefined || _this.closest(".option-ajax");
    if (!bAjax) {
      $("form[name=style-switcher]").submit();
    } else {
      if (_this.data("index_block") && _this.data("index_class")) {
        $(".drag-block.container." + _this.data("index_block") + " .index-block").toggleClass(
          "index-block--" + _this.data("index_class")
        );
      }

      //save option
      $.post(
        arAsproOptions["SITE_DIR"] + "ajax/options_save_mainpage.php",
        {
          VALUE: _this.val(),
          NAME: _this.attr("name"),
        },
        function () {
          var options = {
            element: _this,
            ajaxParent: _this.closest(".option-ajax"),
            checked: _this.is(":checked"),
          };
          reloadBlock(options);
          
          $(".style-switcher .parametrs .action_block").addClass('can_save');
          $(".style-switcher .right-block .inner-content").addClass("with-action-block");

          _this.next().removeClass('wait');
        }
      );
    }
  });
  $(".sup-params .values .subtitle").click(function () {
    var _this = $(this),
      wrapper = _this.closest(".option-wrapper");
    if (wrapper.find(".template_block > .item").is(":visible"))
      $.removeCookie("STYLE_SWITCHER_TEMPLATE" + wrapper.index(), { path: arAsproOptions["SITE_DIR"] });
    else $.cookie("STYLE_SWITCHER_TEMPLATE" + wrapper.index(), "Y", { path: arAsproOptions["SITE_DIR"] });

    wrapper.find(".template_block .item").slideToggle();
    wrapper.find(".bottom-options").slideToggle();
    wrapper.find(".bottom-options").toggleClass("active");
  });

  $(".presets .presets_subtabs .presets_subtab").on("click", function () {
    var _this = $(this);
    _this.siblings().removeClass("active");
    _this.addClass("active");

    $(".presets .presets_block .options").removeClass("active");
    _this
      .closest(".presets")
      .find(".options:eq(" + _this.index() + ")")
      .addClass("active");

    // $('.dynamic_left_side .cl').click();
    if (_this.index() == 0) {
      restoreThematics();
    }

    $.cookie("STYLE_SWITCHER_CONFIG_BLOCK", _this.index(), { path: arAsproOptions["SITE_DIR"] });
  });

  $(".style-switcher").on("click", ".can_save .save_btn", function () {
    var _this = $(this);

    if (timerHide) {
      clearTimeout(timerHide);
      timerHide = false;
    }

    $.ajax({
      type: "POST",
      url: arAsproOptions["SITE_DIR"] + "ajax/options_save.php",
      data: { SAVE_OPTIONS: "Y" },
      dataType: "json",
      success: function (response) {
        if ("STATUS" in response) {
          if (!$(".save_config_status").length)
            $('<div class="save_config_status" style="display:none"><span></span></div>').appendTo(_this.parent());
          if (response.STATUS === "OK") $(".save_config_status").addClass("success");
          else $(".save_config_status").addClass("error");

          $(".save_config_status span").text(BX.message(response.MESSAGE));

          $(".save_config_status").fadeIn(600, function () {
            timerHide = setTimeout(function () {
              // here delayed functions in event
              $(".save_config_status").fadeOut(600, function () {
                $(this).remove();

                $(".style-switcher .parametrs .action_block").removeClass('can_save');
                $(".style-switcher .right-block .inner-content").removeClass("with-action-block");
              });
            }, 1000);
          });
        }
      },
    });
  });
  $('.item.groups-tab a[data-toggle="tab"].linked').on("shown.bs.tab", function (e) {
    var _this = $(this);

    $.cookie("styleSwitcherTabs" + _this.closest(".tabs").data("parent"), _this.parent().index(), { path: "/" });
  });

  $(".style-switcher .section-block").on("click", function () {
    var $tab = $(this);

    $tab.addClass("active").siblings().removeClass("active");
    $(".style-switcher .right-block .contents." + $tab.data("type"))
      .addClass("active")
      .siblings()
      .removeClass("active");

    // save switcher as open
    $.cookie("styleSwitcher", "open", { path: "/" });

    // save switcher opened tab
    $.cookie("styleSwitcherType", $tab.data("type"), { path: "/" });

    if ($tab.hasClass("share_tab") || $tab.hasClass("demos_tab") || $tab.hasClass("updates_tab")) {
      $.removeCookie("styleSwitcherType", { path: "/" });
      $.removeCookie("styleSwitcher", { path: "/" });

      if ($tab.is(".share_tab.loading_state")) {
        if ($(".style-switcher .contents.share").length) {
          $.ajax({
            url: $(".style-switcher .contents.share").data("script"),
            type: "POST",
            data: {
              siteId: arAsproOptions["SITE_ID"],
              siteDir: arAsproOptions["SITE_DIR"],
              lang: BX.message.LANGUAGE_ID,
            },
            beforeSend: function () {
              $tab.addClass("loading_state");
              $(".style-switcher .contents.share").addClass("form sending");
            },
            success: function (response) {
              // put response to content
              $(".style-switcher .contents.share").html(response);
            },
            error: function (jqXhr) {
              console.log(jqXhr);
            },
            complete: function () {
              $tab.removeClass("loading_state");
              $(".style-switcher .contents.share").removeClass("form sending");
            },
          });
        }
      }
    }
  });

  $(".style-switcher .subsection-block").on("click", function () {
    $(this).siblings().removeClass("active");
    $(this).addClass("active");

    $(".style-switcher .right-block .contents .content-body .block-item").removeClass("active");
    $(".style-switcher .right-block .contents .content-body .block-item:eq(" + $(this).index() + ")").addClass(
      "active"
    );

    $(".style-switcher [class*=_BACK_BUTTON]").hide();

    $.cookie("styleSwitcherSubType", $(this).index(), { path: "/" });
  });

  $(".style-switcher .reset").click(function (e) {
    $("form[name=style-switcher]").append('<input type="hidden" name="THEME" value="default" />');
    $("form[name=style-switcher]").submit();

    $.removeCookie("styleSwitcherTabsCatalog", { path: "/" });
  });

  $(".style-switcher .ext_hint_title").click(function () {
    var _this = $(this);

    if ($(".dynamic_left_side").length) $(".dynamic_left_side").remove();

    $('<div class="dynamic_left_side scrollbar"><div class="items_inner"></div></div>').appendTo(
      _this.closest(".contents.parametrs > .right-block")
    );
    $(
      '<div class="cl" title="' + BX.message("FANCY_CLOSE") + '">' + $(".close_block .closes").html() + "</div>"
    ).appendTo($(".dynamic_left_side"));

    $(".ext_hint_desc").find("iframe").attr("src", $(".ext_hint_desc").find("iframe").data("src"));

    $(".dynamic_left_side .items_inner").html(_this.siblings(".ext_hint_desc").html());

    /*$(".dynamic_left_side").mCustomScrollbar({
      mouseWheel: {
        scrollAmount: 150,
        preventDefault: true,
      },
      ignoreTouchIntent: true,
    });*/
    if (timerDynamicLeftSide) {
      clearTimeout(timerDynamicLeftSide);
      timerDynamicLeftSide = false;
    }
    timerDynamicLeftSide = setTimeout(function () {
      $(".dynamic_left_side").addClass("active");
    }, 100);
  });
  $(".style-switcher .sup-params.options .block-title").click(function () {
    $(this).next().slideToggle();
  });
  $(
    ".style-switcher .options > .link-item,.style-switcher .options > div:not(.color_custom) .link-item,.style-switcher .options > div:not(.color_custom) .click_block"
  ).click(function (e) {
    var _this = $(this);
    var bMulti = _this.data("type") == "multi";
    var bCurrent = _this.hasClass("current");
    var options = _this.closest(".options");

    // clicked on toggle options
    if (e && e.target && $(e.target).closest(".toggle-parent").length) {
      return;
    }

    if (
      !bCurrent ||
      (e &&
        e.target &&
        ($(e.target).closest(".switcher-select").length || $(e.target).closest(".checkbox-wrapper").length))
    ) {
      // set cookie for scroll block
      if (typeof $(this).data("option-type") != "undefined") $.cookie("scroll_block", $(this).data("option-type"));

      // set action form for redirect
      if (typeof $(this).data("option-url") != "undefined")
        $("form[name=style-switcher]").prepend(
          '<input type="hidden" name="backurl" value=' + $(this).data("option-url") + " />"
        );
    }

    if (!bMulti && bCurrent) return;

    if (e && e.target && !bCurrent && $(e.target).closest(".switcher-select").length) {
      return;
    }

    if (bMulti) {
      _this.toggleClass("current");
    } else {
      if (!_this.closest(".subs").length) _this.closest(".options").find(".link-item").removeClass("current");

      _this.addClass("current").siblings().removeClass("current");
    }

    if (bMulti) {
      var input = $("form[name=style-switcher] input[name=" + _this.data("option-id") + "]");
      var inputVal = input.val();

      if (!inputVal) {
        input.val(_this.data("option-value"));
      } else {
        inputVal = inputVal.split(",");
        if (bCurrent) {
          inputVal.splice(inputVal.indexOf(_this.data("option-value")), 1);
        } else {
          inputVal.push(_this.data("option-value"));
        }
        inputVal = inputVal.join();
        input.val(inputVal);
      }
    } else {
      $("form[name=style-switcher] input[name=" + _this.data("option-id") + "]").val(_this.data("option-value"));
    }

    if (_this.closest(".sup-params").length) $.removeCookie("styleSwitcher", { path: "/" });

    checkDelay(options);

    if (options.data("ajax") === "Y" || _this.data('ajax') === "Y") {
      const value = _this.data("option-value").toLowerCase();

      if (_this.data("option-id") === "THEME_VIEW_COLOR") {
        $("body").removeClass("theme-default theme-dark theme-light");
        $("body").addClass("theme-" + value);

        $(".jqmOverlay").trigger("click");
      }

      var saveParams = {
        VALUE: _this.data("option-value"),
        NAME: _this.data("option-id"),
        SHOW_ACTION_PANEL: true,
      };
      saveFrontParameter(saveParams);

      // trigger theme color changed event only after saving options
      if (_this.data("option-id") === "THEME_VIEW_COLOR") {
        BX.onCustomEvent("onChangeThemeColor", [{ value: value }]);
      }
    } else {
      if (_this.closest(".options").hasClass("refresh-block")) {
        if (!_this.closest(".options").hasClass("sup-params")) var index = _this.index() - 1;
        _this.closest(".item").find(".sup-params.options").removeClass("active");
        _this
          .closest(".item")
          .find(".sup-params.options.s_" + _this.data("option-value") + "")
          .addClass("active");
        $("form[name=style-switcher]").submit();
      } else {
        $("form[name=style-switcher]").submit();
      }
    }
  });

  $(".tooltip-link").on("shown.bs.tooltip", function (e) {
    var tooltip_block = $(this).next(),
      wihdow_height = $(window).height(),
      scroll = $(this).closest("form").scrollTop(),
      pos = BX.pos($(this)[0], true),
      pos_tooltip = BX.pos(tooltip_block[0], true),
      pos_item_wrapper = BX.pos($(this).closest(".item")[0], true);

    if (!$(this).closest(".item").next().length && pos_tooltip.bottom > pos_item_wrapper.bottom) {
      tooltip_block.removeClass("bottom").addClass("top");
      tooltip_block.css({ top: pos.top - tooltip_block.actual("outerHeight") });
    }
  });
});

var timerHide = false;
var timerDynamicLeftSide = false;
var timerResponse = false;
var hoveredSwitcher = false;
window.array = [];

function checkDelay(parent) {
  window.NO_WIDGET_TIMEOUT = false;

  if (parent && parent.data("no-delay") === "Y") {
    window.NO_WIDGET_TIMEOUT = true;
  }
}

function saveFrontParameter(params) {
  paramsDefault = {
    VALUE: "",
    NAME: "",
    OPTIONS: {},
    RELOAD: false,
  };
  params = Object.assign({}, paramsDefault, params);

  $(".sharepreset-part--export").removeClass("sharepreset-part--exported2Link");

  //save option
  $.post(
    arAsproOptions["SITE_DIR"] + "ajax/options_save_mainpage.php",
    {
      VALUE: params.VALUE,
      NAME: params.NAME,
    },
    function () {
      reloadBlock(params.OPTIONS);

      if (params.SHOW_ACTION_PANEL) {
        $(".style-switcher .parametrs .action_block").addClass('can_save');
        $(".style-switcher .right-block .inner-content").addClass("with-action-block");
      }
    }
  );
  if (params.RELOAD) {
    setTimeout(function () {
      $("form[name=style-switcher]").submit();
    }, 200);
  }
}

function reloadBlock(options) {
  $(".sharepreset-part--export").removeClass("sharepreset-part--exported2Link");

  if (options.ajaxParent && options.ajaxParent.length) {
    if (options.parent && options.parent.length) {
      if (options.checked) {
        options.parent.removeClass("disabled");
      } else {
        options.parent.addClass("disabled");
      }
    }

    var pageBlock = options.ajaxParent.data("pageBlock");
    var target = options.element.closest(".option-ajax-target");
    if (target.length) {
      var targetSelector = target.data("needBlock");
    }
    if (pageBlock) {
      BX.ajax({
        url: location.href,
        method: "POST",
        data: {
          BLOCK: targetSelector,
          IS_AJAX: "Y",
        },
        onsuccess: function (html) {
          if (html) {
            var targetBlock = $('[data-ajax-load-block="' + targetSelector + '"]');
            if (targetBlock.length) {
              var callback = options.ajaxParent.data("ajaxCallback");
              if (callback && typeof window[callback] === "function") {
                setTimeout(function () {
                  window[callback](targetBlock);
                }, 0);
              }
              targetBlock.replaceWith(html);
              if (
                !!~targetSelector.indexOf('EYED') &&
                typeof JEyed === 'function' &&
                BX('eyed-panel') &&
                typeof BX('eyed-panel').eyed === 'object'
              ) {
                BX('eyed-panel').eyed.checkState();
              }
            }
          }
        },
      });
    }
  }
}

$(document).ready(function () {
  checkNeedRequest = function () {
    return $(".style-switcher-body.loading_block").length;
  };

  /* get updates for solutions from aspro.ru */
  getExternalNews = function () {
    if (!$(".section-block.updates_tab").hasClass("hidden")) {
      return;
    }
    $.ajax({
      url: "https://aspro.ru/demo/updates/index.php",
      type: "POST",
      data: { AJAX_FORM: "Y" },
      success: function (html) {
        $(".section-block.updates_tab").removeClass("hidden");
        $(".right-block .inner-content .contents.updates .body_block").html(html);
      },
      error: function (jqXhr) {
        console.log(jqXhr);
      },
    });
  };
  /**/

  getWidgetHtml = function (callback) {
    if (checkNeedRequest()) {
      if ($(".top_block_switch").hasClass("loading")) {
        if (typeof callback === "function") {
          let t = setInterval(function() {
            if (!$(".top_block_switch").hasClass("loading")) {
              clearInterval(t);
              callback();
            }
          }, 100);

          return;
        } 
        else {
          return;
        }
      }
    }
    else {
      if (typeof callback === "function") {
        callback();
      }
      
      return;
    }
    
    $(".top_block_switch").addClass("loading");

    try {
      BX.ajax({
        url: arAsproOptions["SITE_DIR"] + "?BLOCK=widget",
        method: "POST",
        data: BX.ajax.prepareData({ ajax: "Y" }),
        dataType: "html",
        processData: false,
        start: true,
        headers: [{ name: "X-Requested-With", value: "XMLHttpRequest" }],
        onfailure: function (error) {
          console.error(error);
        },
        onsuccess: function (html) {
          var ob = BX.processHTML(html);

          BX.loadCSS(ob.STYLE);

          setTimeout(function () {
            $(".top_block_switch").removeClass("loading");
            $(".style-switcher-body").removeClass("loading_block").html(ob.HTML);
            BX.ajax.processScripts(ob.SCRIPT);

            var eventdata = { action: "widgetLoaded" };
            BX.onCustomEvent("onWidgedLoaded", [eventdata]);
          }, 100);

          if (typeof callback === "function") {
            setTimeout(function () {
              callback();
            }, 150);
          }
        },
      });
    } catch (error) {
      console.error(error);
    }
  };

  HideHintBlock = function (bHideOverlay) {
    if (typeof bHideOverlay === "undefined" || bHideOverlay) {
      HideOverlay();
    }
    $.cookie("clickedSwitcher", "Y", { path: "/" });
    if ($(".hint-theme").length) {
      $(".hint-theme").fadeIn(300, function () {
        $(".hint-theme").remove();
      });
    }
  };

  var submitTimer = false;
  var bCanSubmit = false;
  $("form[name=style-switcher]").submit(function (e) {
    var $form = $(this);

    if (!bCanSubmit) {
      e.preventDefault();

      if (submitTimer) {
        clearTimeout(submitTimer);
        submitTimer = false;
      }

      if (window.NO_WIDGET_TIMEOUT) {
        bCanSubmit = true;
        $form.submit();
      } else {
        submitTimer = setTimeout(function () {
          bCanSubmit = true;
          $form.submit();
        }, 1500);
      }
    }
  });

  $(".top_block_switch").mouseenter(function () {
    getWidgetHtml();
    hoveredSwitcher = true;
  });

  /* close search block */
  $("html, body").on("mousedown", function (e) {
    if (typeof e.target.className == "string" && e.target.className.indexOf("adm") < 0) {
      e.stopPropagation();
      if (!$(e.target).closest(".style-switcher .dynamic_left_side").length) {
        $(".style-switcher .dynamic_left_side").removeClass("active");
      }

      if (!$(e.target).closest(".style-switcher .contents.wizard").length) {
        $(".style-switcher .contents.wizard").removeClass("active");
      }
    }
  });

  $(".dynamic_left_side")
    .find("*")
    .on("mousedown", function (e) {
      e.stopPropagation();
    });

  $(document).on("click", ".presets .thematik .item", function () {
    var thematic = $(this).data("code");
    selectThematic(thematic, true);
  });

  $(document).on("click", ".style-switcher .presets .preset-block .apply_conf_block", function (e) {
    var preset = $(this).closest(".preset-block").data("id");
    selectPreset(preset);
  });

  /*if ($.cookie("styleSwitcherType") === "presets") {
    $(".style-switcher .presets").addClass("active");
  }*/

  $(document).on("click", ".style-switcher .switch", function (e) {
    e.preventDefault();

    var _this = $(this);
    var styleswitcher = _this.closest(".style-switcher");
    var bSwitchPresets = _this.hasClass("presets_action");

    if (_this.hasClass("loadings")) return;
    _this.addClass("loadings");

    setWidgetHtml(styleswitcher, _this, bSwitchPresets);
  });

  setWidgetHtml = function (styleswitcher, _this, bSwitchPresets) {
    getWidgetHtml(function () {
      //var styleswitcher = $(this).closest(".style-switcher");
      var presets = styleswitcher.find(".presets");
      var parametrs = styleswitcher.find(".parametrs");
      //var bSwitchPresets = $(this).hasClass("presets_action");

      styleswitcher.find(".section-block").removeClass("active");
      _this.removeClass("loadings");

      getExternalNews();

      if (typeof getAjaxForm === "function") {
        //   getAjaxForm();
        getAjaxForm(function () {
          $(".section-block.demos_tab").removeClass("hidden");
        });
      }
      
      if (styleswitcher.hasClass("active")) {
        if (typeof restoreThematics === 'function') {
          restoreThematics();
        }

        // current switch type
        var typeSwitcher = $.cookie("styleSwitcherType");

        // change switcher bgcolor
        styleswitcher.find(".switch").removeClass("active");
        styleswitcher.find(".presets_action").removeClass("active");

        if ((bSwitchPresets && typeSwitcher === "presets") || (!bSwitchPresets && typeSwitcher === "parametrs")) {
          HideHintBlock(true);

          // remove switcher type
          $.removeCookie("styleSwitcherType", { path: "/" });

          // save switcher as hidden
          $.removeCookie("styleSwitcher", { path: "/" });

          // hide switcher with transition
          styleswitcher.addClass("closes");
          setTimeout(function () {
            styleswitcher.removeClass("active");
          }, 300);
        } else {
          HideHintBlock(false);

          // save switcher type
          $.cookie("styleSwitcherType", bSwitchPresets ? "presets" : "parametrs", { path: "/" });

          // hide switcher title
          styleswitcher.find(".header .title").hide();
          
          // set presets visible or hidden with transition and change switcher bgcolor
          if (bSwitchPresets) {
            // styleswitcher.find('.header .title.title-presets').show();
            $(".section-block.presets_tab").addClass("active");
            presets.addClass("active");
            parametrs.removeClass("active");
          } else if ($(this).hasClass("demo_action")) {
            $(".section-block.demos_tab").removeClass("hidden").addClass("active");
            $(".inner-content .contents").removeClass("active");
            $(".inner-content .contents.demos").removeClass("hidden").addClass("active");

            $.removeCookie("styleSwitcherType", { path: "/" });
            $.removeCookie("styleSwitcher", { path: "/" });
          } else {
            // styleswitcher.find('.header .title.title-parametrs').show();
            $(".section-block.parametrs_tab").addClass("active");
            presets.removeClass("active");
            parametrs.addClass("active");
          }
          $(this).addClass("active");
        }
      } else {
        HideHintBlock(true);
        
        // change switcher bgcolor
        _this.addClass("active");

        // save switcher type
        $.cookie("styleSwitcherType", bSwitchPresets ? "presets" : "parametrs", { path: "/" });

        // save switcher as open
        $.cookie("styleSwitcher", "open", { path: "/" });

        // set presets visible or hidden immediately before adding .active to .style-switcher
        if (bSwitchPresets) {
          // styleswitcher.find('.header .title.title-presets').show();
          $(".section-block.presets_tab").addClass("active");
          presets.addClass("active");
          parametrs.removeClass("active");
        } else if (_this.hasClass("demo_action")) {
          $(".section-block.demos_tab").removeClass("hidden").addClass("active");
          $(".inner-content .contents").removeClass("active");
          $(".inner-content .contents.demos").removeClass("hidden").addClass("active");

          $.removeCookie("styleSwitcherType", { path: "/" });
          $.removeCookie("styleSwitcher", { path: "/" });
        } else {
          // styleswitcher.find('.header .title.title-parametrs').show();
          $(".section-block.parametrs_tab").addClass("active");
          presets.removeClass("active");
          parametrs.addClass("active");
        }

        // show overlay
        ShowOverlay();

        // show switcher with transition
        styleswitcher.removeClass("closes").addClass("active");
      }

      if (typeof $(this).data("option-type") != "undefined")
        // set cookie for scroll block
        $.cookie("scroll_block", $(this).data("option-type"));
    });
  };

  $(document).on("click", ".close-overlay", function () {
    HideHintBlock();
  });

  $(".close_block").click(function () {
    $(".jqmOverlay").trigger("click");
  });

  $(document).on("click", ".jqmOverlay", function () {
    var styleswitcher = $(".style-switcher");

    if (!$(".hint-theme").length) {
      HideOverlay();
    }

    styleswitcher.each(function () {
      var _this = $(this);
      _this.addClass("closes");

      setTimeout(function () {
        _this.removeClass("active");
      }, 300);

      $(".form_demo-switcher")
        .animate(
          {
            left: "-" + $(".form_demo-switcher").outerWidth() + "px",
          },
          100
        )
        .removeClass("active abs");
    });

    $(".style-switcher .switch,.style-switcher .presets_action").removeClass("active");

    typeof restoreThematics === 'function' && restoreThematics();

    $.removeCookie("styleSwitcherType", { path: "/" });
    $.removeCookie("styleSwitcher", { path: "/" });
  });

  $(document).on("click", ".sharepreset-trigger-open", function (e) {
    e.preventDefault();
    $(".section-block.share_tab").trigger("click");
  });

  $(document).on("click", ".style-switcher .apply", function () {
    $("form[name=style-switcher]").submit();
  });

  $(document).on("click", ".style-switcher .preview_conf_block .btn", function () {
    var _this = $(this);

    if ($(".dynamic_left_side").length) $(".dynamic_left_side").remove();

    $('<div class="dynamic_left_side"><div class="items_inner"><div class="titles_block"></div></div></div>').appendTo(
      _this.closest(".contents.presets .presets_block")
    );
    $(".dynamic_left_side .titles_block").html(
      '<div class="title">' +
        _this.closest(".preset-block").find(".info .title").text() +
        "</div>" +
        '<div class="blocks_wrapper">' +
        '<div class="cl" title="' +
        BX.message("FANCY_CLOSE") +
        '">' +
        $(".close_block .closes").html() +
        "</div>" +
        (_this.closest(".preset-block").find(".apply_conf_block").hasClass("hidden")
          ? ""
          : '<div class="ch" data-id="' +
            _this.closest(".preset-block").data("id") +
            '">' +
            _this.closest(".preset-block").find(".apply_conf_block").html() +
            "</div>") +
        "</div>"
    );

    $('<div class="desc">' + _this.closest(".preset-block").find(".info .description").text() + "</div>").appendTo(
      $(".dynamic_left_side .items_inner")
    );
    if (_this.closest(".preset-block").find(".info .description").data("img"))
      $(
        '<div class="img"><img src="' +
          _this.closest(".preset-block").find(".info .description").data("img") +
          '" /></div>'
      ).appendTo($(".dynamic_left_side .items_inner"));

    if (timerDynamicLeftSide) {
      clearTimeout(timerDynamicLeftSide);
      timerDynamicLeftSide = false;
    }
    timerDynamicLeftSide = setTimeout(function () {
      $(".dynamic_left_side").addClass("active scrollbar");
    }, 100);
  });

  $(document).on("click", ".dynamic_left_side .ch .btn", function (e) {
    var preset = $(this).parent().data("id");
    selectPreset(preset);
    $(".dynamic_left_side").removeClass("active");
  });

  $(document).on("click", ".dynamic_left_side .cl", function (e) {
    $(".dynamic_left_side").removeClass("active");
  });

  $(document).on("click", ".style-switcher .toggle-options__link", function () {
    var _this = $(this);
    var tab = _this.data("tab");
    if (tab) {
      var targetTab = $(".style-switcher .subsection-block[data-code=" + tab + "]");
      if (targetTab.length) {
        targetTab.trigger("click");

        var backButton = $(".block-item." + tab + " ." + tab + "_BACK_BUTTON");
        if (backButton.length) {
          backButton.show();
        }
      }
    }
  });

  $(document).on("click", ".style-switcher .switcher__back-button", function () {
    var _this = $(this);
    var targetTab = $(".style-switcher .subsection-block[data-code=HEADER]");
    if (targetTab.length) {
      _this.closest(".item").hide();
      targetTab.trigger("click");
    }
  });

  $(document).on("click", ".style-switcher .toggle-parent", function (e) {
    var _this = $(this);
    var target = _this.siblings(".toggle-target");
    target = target.length ? target : _this.find(".toggle-target");
    if (target.length) {
      target.slideToggle();
    }
  });

  function closeActiveSwitcherPopups() {
    var activePopup = $(".switcher-select__popup.active");
    if (activePopup.length) {
      activePopup.removeClass("active");
    }
  }

  $(document).on("click", ".switcher-select__current", function () {
    var _this = $(this);
    var popup = _this.siblings(".switcher-select__popup");
    var bActive = popup.hasClass("active");

    closeActiveSwitcherPopups();

    if (popup.length) {
      bCanSubmit = false;
      if (submitTimer) {
        clearTimeout(submitTimer);
        submitTimer = false;
      }

      if (bActive) {
        popup.removeClass("active");
      } else {
        popup.addClass("active");
      }
    }
  });

  $(document).on("click", function (e) {
    var _target = $(e.target);
    if (!_target.hasClass("switcher-select__popup-item") && !_target.hasClass("switcher-select__current")) {
      closeActiveSwitcherPopups();
    }
  });

  $(document).on("click", ".switcher-select__popup-item", function () {
    var _this = $(this);
    var value = _this.data("value");
    var title = _this.data("title");
    var parent = _this.closest(".switcher-select");
    var current = _this.hasClass("switcher-select__popup-item--current");

    if (!current && parent.length) {
      var input = parent.find(".switcher-select__input");
      if (input.length) {
        input.val(value);

        if (_this.closest(".link-item").length) {
          if (_this.closest(".link-item.current").length) {
            var saveParams = {
              VALUE: value,
              NAME: input.attr("name"),
              RELOAD: true,
            };
            saveFrontParameter(saveParams);
          } else {
            _this.closest(".link-item").trigger("click");
          }
        } else {
          var saveParams = {
            VALUE: value,
            NAME: input.attr("name"),
            RELOAD: true,
          };
          saveFrontParameter(saveParams);
        }
      }

      var current = parent.find(".switcher-select__current");
      if (current.length) {
        current.text(title);
      }

      parent.find(".switcher-select__popup-item--current").removeClass("switcher-select__popup-item--current");
      _this.addClass("switcher-select__popup-item--current");
    }

    var popup = _this.closest(".switcher-select__popup");
    if (popup.length) {
      popup.toggleClass("active");
    }
  });

  $(document).on("change", ".bottom-options input", function () {
    var _this = $(this);
    var value = _this.val();
    var saveParams = {
      VALUE: value,
      NAME: _this.attr("name"),
      RELOAD: true,
    };
    saveFrontParameter(saveParams);
  });

  /*menu position with side header*/
  //$(".style-switcher [data-option-id=SIDE_MENU]").on("click", function () {
  $(document).on("click", ".style-switcher [data-option-id=SIDE_MENU]", function () {
    $.cookie("side_menu", "Y");
  });
});

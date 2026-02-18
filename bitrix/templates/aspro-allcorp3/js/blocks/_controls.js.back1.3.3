$(document).ready(function () {
  // dropdown-select
  $(document).on("click", ".dropdown-select .dropdown-select__title", function () {
    var _this = $(this),
      menu = _this.parent().find("> .dropdown-select__list");

    if (!_this.hasClass("clicked")) {
      _this.addClass("clicked");

      _this.toggleClass("opened");
      menu.stop().slideToggle(100, function () {
        _this.removeClass("clicked");
      });
    }
  });

  // dropdown-select change item
  $(document).on("click", ".dropdown-select__list .mixitup-item", function () {
    var $select = $(this).closest(".dropdown-select");

    $select.find(".dropdown-select__list-link").removeClass("dropdown-select__list-link--current");
    $(this).find(".dropdown-select__list-link").addClass("dropdown-select__list-link--current");

    $select.find(".dropdown-select__title span").text($(this).text());
    $select.find(".dropdown-select__title.opened").click();

    const eventData = {
      type: "change",
      payload: {
        item: $(this),
      },
    };
    BX.onCustomEvent("onChangeOptionSelect", [eventData]);

  });

  // close select
  $("html, body").on("mousedown", function (e) {
    if (typeof e.target.className == "string" && e.target.className.indexOf("adm") < 0) {
      e.stopPropagation();

      $(".dropdown-select .dropdown-select__title.opened").each(function () {
        var $select = $(this).closest(".dropdown-select");
        if (!$(e.target).closest($select).length) {

          $(this).click();
        }
      });
    }
  });

  // hint
  $(document).on("click", ".hint__icon", function (e) {
    e.stopImmediatePropagation();
    var tooltipWrapp = $(this).closest(".hint");
    if (tooltipWrapp.hasClass("active")) {
      tooltipWrapp.removeClass("active").find(".tooltip").slideUp(200);
    } else {
      tooltipWrapp.addClass("active");
      tooltipWrapp.find(".tooltip").slideDown(200);
      tooltipWrapp.find(".tooltip_close").click(function (e) {
        e.stopPropagation();
        e.stopImmediatePropagation();
        tooltipWrapp.removeClass("active").find(".tooltip").slideUp(100);
      });
    }
    e.stopPropagation();
  });

  // mixitUp
  const containerEl = document.querySelector(".mixitup-container");
  if (containerEl) {
    var config = {
      selectors: {
        target: '[data-ref="mixitup-target"]',
      },
      /*animation: {
        effects: "fade scale stagger(150ms)", // Set a 'stagger' effect for the loading animation
      },*/
      animation: {
        effects: "", // Set a 'stagger' effect for the loading animation
      },
      load: {
        filter: "none", // Ensure all targets start from hidden (i.e. display: none;)
      },
      animation: {
        duration: 350,
      },
      controls: {
        scope: "local",
      },
      callbacks: {
        onMixStart: function (state) {
          // console.log(state);
        },
        onMixClick: function (state, event) {
          let $item = event.target.children.length ? event.target : event.target.parentElement;
          $($item).siblings().removeClass("color-theme head-block__item--active active");
          $($item).addClass("color-theme head-block__item--active active");
        },
        onMixEnd: function () {
          // InitLazyLoad();
        },
      },
    };
    var mixer = mixitup(containerEl, config);

    containerEl.classList.add("mixitup-ready");

    mixer.show().then(function () {
      // Remove the stagger effect for any subsequent operations
      mixer.configure({
        animation: {
          effects: "fade scale",
        },
      });
    });
  }

  /*show password*/
  $(".form-group:not(.eye-password-ignore) [type=password]").each(function (item) {
    let passBlock = $(this).closest(".form-group");
    let labelBlock = passBlock.find(".label_block");
    if (labelBlock.length) {
      labelBlock.addClass("eye-password");
    } else {
      passBlock.addClass("eye-password");
    }
  });
  $(document).on("click", ".eye-password:not(.eye-password-ignore)", function (event) {
    let input = this.querySelector("input");
    let eyeWidth = 56;
    if (this.clientWidth - eyeWidth < event.offsetX) {
      if (input.type == "password") {
        input.type = "text";
        this.classList.add("password-show");
      } else if (input.type == "text") {
        input.type = "password";
        this.classList.remove("password-show");
      }
      event.stopPropagation();
    }
  });
  /**/
});

// gallery switch
$(document).on("click", ".gallery-view_switch__icons:not(.active)", function () {
  var $this = $(this);
  var animationTime = 200;
  var bSmall = $this.hasClass("gallery-view_switch__icons--small");
  var $switchGallery = $this.closest(".gallery-view_switch");
  var $bigGallery = (
    $this.closest(".big_gallery").length ? $this.closest(".big_gallery") : $this.closest(".gallery")
  ).find(".gallery-big");
  var $bigGalleryCounter = $switchGallery.find(".gallery-view_switch__count-wrapper--big");
  var $smallGallery = (
    $this.closest(".big_gallery").length ? $this.closest(".big_gallery") : $this.closest(".gallery")
  ).find(".gallery-small");
  var $smallGalleryCounter = $switchGallery.find(".gallery-view_switch__count-wrapper--small");
  var $toHideGallery = bSmall ? $bigGallery : $smallGallery;
  var $toHideGalleryCounter = bSmall ? $bigGalleryCounter : $smallGalleryCounter;
  var $toShowGallery = bSmall ? $smallGallery : $bigGallery;
  var $toShowGalleryCounter = bSmall ? $smallGalleryCounter : $bigGalleryCounter;

  $this.addClass("active");
  $this.siblings(".active").removeClass("active");

  $toHideGalleryCounter.fadeOut(animationTime, function () {
    $toShowGalleryCounter.fadeIn(animationTime);
  });

  $toHideGallery.fadeOut(animationTime, function () {
    $toShowGallery.fadeIn(animationTime);
  });
});

/*buy opt table items*/
function optBuyBasketAction(basketItems, itemsToNotice) {
  const basketParams = {
    type: "multiple",
    ajaxPost: "Y",
    // iblock_id: _this.data("iblock_id"),
    action: "buy",
    items: [],
  };
  if (basketItems) {
    basketParams["items"] = basketItems;
  }

  var bBasketTop =
    typeof arAsproOptions["THEME"]["ORDER_BASKET_VIEW"] !== "undefined" &&
    $.trim(arAsproOptions["THEME"]["ORDER_BASKET_VIEW"]) === "HEADER" &&
    $(".basket.top").length;
  var bBasketFly =
    typeof arAsproOptions["THEME"]["ORDER_BASKET_VIEW"] !== "undefined" && !bBasketTop && $(".basket.fly").length;

  if (basketParams["items"].length) {
    $.ajax({
      url: arAsproOptions["SITE_DIR"] + "include/footer/basket.php",
      type: "POST",
      data: basketParams,
    }).done(function (html) {
      if (bBasketTop) {
        $(".ajax_basket").replaceWith(html);
      } else if (bBasketFly) {
        $(".ajax_basket").html($($.trim(html)).html());
      }

      // show cart or notice
      if (typeof JNoticeSurface === "undefined") {
        if (bBasketTop) {
          $(".header-cart").addClass("opened");

          if (typeof headerCartHideTimer !== "undefined") {
            clearTimeout(headerCartHideTimer);
          }

          headerCartHideTimer = setTimeout(function () {
            $(".header-cart").removeClass("opened");
          }, 2000);
        } else if (bBasketFly) {
          setTimeout(function () {
            if (!$(".ajax_basket").hasClass("opened")) {
              $(".ajax_basket").addClass("opened");
            }
          }, 50);
        }
      } else {
        JNoticeSurface.get().onAdd2cart(itemsToNotice);
      }

      var eventdata = { action: "loadBasket" };
      BX.onCustomEvent("onCompleteAction", [eventdata, $(html)]);
      setBasketItemsClasses();
    });
  }
}

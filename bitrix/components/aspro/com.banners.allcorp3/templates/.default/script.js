function checkNavColor(slider) {
  var nav_color_flex = slider.find(".swiper-slide-active").data("nav_color"),
    menu_color = slider.find(".swiper-slide-active").data("color");

  const allowChangeBySlider = typeof window.headerLogo !== 'undefined' && window.headerLogo.allowChangeBySlider;

  if (nav_color_flex == "dark") slider.find(".swiper-pagination").addClass("flex-dark");
  else slider.find(".swiper-pagination").removeClass("flex-dark");
  if (typeof checkNavColor.hasLongBanner === "undefined") {
    checkNavColor.hasLongBanner = $(".header_opacity").length;
  }
  // if (checkNavColor.hasLongBanner && typeof logo_depend_banners === 'function') logo_depend_banners(menu_color);
  if (checkNavColor.hasLongBanner) {
    var logoOpacity =
      $("body.header_opacity").length &&
      (!$("header.header--offset").length ||
        $("header .logo").closest(".header__top-part").length ||
        ($("header.header--offset").length &&
          ($("header .header__main-inner.bg_none").length || $("header .header__sub-inner.bg_none").length)));
    var bLogoImg = $("body:not(.left_header_column) header .logo img").length && logoOpacity;
    if (bLogoImg && allowChangeBySlider) {
      $("header .logo img").attr("src", arAsproOptions.THEME.LOGO_IMAGE);
    }
    $("header").removeClass("light dark");
    if (menu_color == "light") {
      $("header").addClass(menu_color);
      if (bLogoImg && allowChangeBySlider) {
        if (arAsproOptions.THEME.LOGO_IMAGE_WHITE)
          $("header .logo img").attr("src", arAsproOptions.THEME.LOGO_IMAGE_WHITE);
      }
    }
  }

  var eventdata = { slider: slider };
  BX.onCustomEvent("onSlide", [eventdata]);
}

readyDOM(function () {
  $(".main-slider").mouseenter(function () {
    if (!$(this).hasClass("video_visible") && $(this).data("swiper")) {
      if ($(this).data("swiper").params.autoplay.enabled) {
        $(this).data("swiper").autoplay.stop();
      }
    }
  });

  $(".main-slider").mouseleave(function () {
    if (!$(this).hasClass("video_visible") && $(this).data("swiper")) {
      if ($(this).data("swiper").params.autoplay.enabled) {
        $(this).data("swiper").autoplay.start();
      }
    }
  });
});

BX.addCustomEvent("onSetSliderOptions", function (options) {
  if ("type" in options && options.type === "main_banner") {
    if (typeof arAsproOptions["THEME"] != "undefined") {
      const slideshowSpeed = Math.abs(parseInt(arAsproOptions["THEME"]["BIGBANNER_SLIDESSHOWSPEED"]));
      const animationSpeed = Math.abs(parseInt(arAsproOptions["THEME"]["BIGBANNER_ANIMATIONSPEED"]));

      options.autoplay = slideshowSpeed && arAsproOptions["THEME"]["BIGBANNER_ANIMATIONTYPE"].length ? {} : false;
      // options.autoplay.pauseOnMouseEnter = true;
      // options.autoplay.disableOnInteraction = false;
      options.effect = arAsproOptions["THEME"]["BIGBANNER_ANIMATIONTYPE"] === "FADE" ? "fade" : "slide";
      if (animationSpeed >= 0) {
        options.speed = animationSpeed;
      }
      if (slideshowSpeed >= 0) {
        options.autoplay.delay = slideshowSpeed;
      }
      /*if (arAsproOptions["THEME"]["BIGBANNER_ANIMATIONTYPE"] !== "FADE") {
          options.direction =
            arAsproOptions["THEME"]["BIGBANNER_ANIMATIONTYPE"] === "SLIDE_VERTICAL" ? "vertical" : "horizontal";
        }*/
    }

    if ("CURRENT_BANNER_INDEX" in arAsproOptions && arAsproOptions["CURRENT_BANNER_INDEX"]) {
      currentBannerIndex = arAsproOptions["CURRENT_BANNER_INDEX"] - 1;
      if (currentBannerIndex < options.countSlides) {
        options.initialSlide = currentBannerIndex;
        // options.autoplay = false;
      }
    }
  }
});

BX.addCustomEvent("onSlideChanges", function (eventdata) {
  if ("slider" in eventdata && eventdata.slider) {
    const slider = eventdata.slider;
    if (slider && slider.params) {
      if ("type" in slider.params && slider.params.type === "main_banner") {
        setTimeout(function () {
          checkNavColor($(slider.el));
        }, 100);
      }
    }
  }
});

function initSwiperSlider(selector) {
  const $slider = selector instanceof Node
    ? $(selector)
    : $((selector || ".slider-solution" || ".swiper-container") + ":not(.swiper-initialized):not(.appear-block)");

  $slider.each(function () {
    const _this = $(this);
		const itemsGap = getComputedStyle(document.documentElement).getPropertyValue('--theme-items-gap');
    let options = {
      grabCursor: true,
      //   longSwipes: false,
      navigation: {
        nextEl: _this.parent().find(".swiper-button-next")[0],
        prevEl: _this.parent().find(".swiper-button-prev")[0],
      },
      pagination: {
        el: _this.parent().find(".swiper-pagination")[0],
        type: "bullets",
        clickable: true,
      },
    };
    options.spaceBetween = parseInt(itemsGap) || -1;
    if ($slider.hasClass('slider-solution--no-gap')) {
      if (!$slider.find('.bordered').length) {
        options.spaceBetween = 0;
      } else {
        options.spaceBetween = -1;
      }
    }

    if (_this.data("pluginOptions")) {
      options = deepMerge({}, options, _this.data("pluginOptions"));
    }

    BX.onCustomEvent("onSetSliderOptions", [options]);
    const swiper = new Swiper(this, options);
    const mainSwiper = options.mainSwiper ? $(options.mainSwiper).data("swiper") : false;

    if (mainSwiper) {
      mainSwiper.thumbs.swiper = swiper;

      if (options.init !== false) mainSwiper.thumbs.init();
    }

    swiper.on("slideChange", function (swiper) {
      const eventdata = { slider: swiper };
      var currentSlideIndex = this.activeIndex + 1;
      $(this.el).find(".gallery-count-info__js-text").text(currentSlideIndex);
      BX.onCustomEvent("onSlideChanges", [eventdata]);
    });

    if (options.init === false) {
      swiper.on("init", function (swiper) {
        const eventdata = { slider: swiper, options: options };
        BX.onCustomEvent("onInitSlider", [eventdata]);
        if (swiper.slides.length === 1) BX.onCustomEvent("onSlideChanges", [{ slider: swiper }]);
      });
      // init Swiper
      swiper.init();
      if (mainSwiper) {
        mainSwiper.thumbs.init();
      }
    }

    _this.data("swiper", swiper);
  });
}

function deepMerge() {
  const arr = [].slice.call(arguments);
  let destination = arr[0];
  const other = arr.slice(1);

  other.forEach(function (params) {
    for (let param in params) {
      if (typeof params[param] === "object") {
        for (let param2 in params[param]) {
          if (typeof destination[param] !== "object") {
            destination[param] = {};
          }
          destination[param][param2] = params[param][param2];
        }
      } else {
        destination[param] = params[param];
      }
    }
  });
  return destination;
}
readyDOM(function () {
  initSwiperSlider("#gallery-thumbs");
  initSwiperSlider();
});

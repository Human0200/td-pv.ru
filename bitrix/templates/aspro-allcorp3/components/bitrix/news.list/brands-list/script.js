BX.addCustomEvent('onSetSliderOptions', function(options) {
    if (options.type && options.type === 'main_brands') {
        if (!options.on) {
            options.on = {};
        }

        options.on.init = function(swiper) {
            if (swiper.navigation.nextEl) {
                swiper.navigation.nextEl.style.display = ''
            }
            if (swiper.navigation.prevEl) {
                swiper.navigation.prevEl.style.display = ''
            }
        }

        options.on.lock = function (swiper) {
            swiper.wrapperEl.classList.add('brand-list__items--centered');
        }
        
        options.on.unlock = function (swiper) {
            swiper.wrapperEl.classList.remove('brand-list__items--centered');
        }
    }
})
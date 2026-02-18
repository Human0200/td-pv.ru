$(document).on('click', '.tariffs-list__tabs__item', function(){
    var $this = $(this);

    if(!$this.hasClass('current')){
        var index = $this.index();
        $this.addClass('current').siblings().removeClass('current');

        var $price = $this.closest('.tariffs-list__tabs').next('.tariffs-list__tabs-content').find('.tariffs-list__tabs-content__item').eq(index);
        $price.removeClass('hidden').siblings().addClass('hidden');

        var name = $this.data('name');
        var $popupBlock = $this.closest('.js-popup-block');

        var $data = $popupBlock.find('[data-item]');
        if($data.length){
            var data = $data.data('item');
            if(typeof data !== 'undefined' && data){
                data.NAME = name;
                data.PROPERTY_FILTER_PRICE_VALUE = $this.data('filter_price');
                data.PROPERTY_PRICE_VALUE = $this.data('price');
                data.PROPERTY_PRICEOLD_VALUE = $this.data('oldprice');
                $data.data('item', data);
            }
        }

        var $buttonForm = $popupBlock.find('.btn-actions__inner .btn[data-event=jqm]');
        if($buttonForm.length){
            $buttonForm.each(function(){
                $(this).attr("data-autoload-need_product", name);
                $(this).attr("data-autoload-product", name);
                $(this).attr("data-autoload-service", name);
                $(this).attr("data-autoload-project", name);
                $(this).attr("data-autoload-news", name);
                $(this).attr("data-autoload-sale", name);
                $(this).clone().insertAfter($(this));
                $(this).remove();
            });
        }
    }
});

$(document).on('click', '.tariffs-list .tab-nav__item', function (){
    var $this = $(this);

    if(!$this.hasClass('active')){
        var price_key = $this.data('price_key');

        if(typeof price_key !== 'undefined' && price_key.toString().length){
            $tab = $this.closest('.tariffs-list').find('.tab-content-block[data-price_key=' + price_key + ']');

            if($tab.length){
                $this.addClass('active').siblings().removeClass('active');
                $tab.addClass('active').siblings().removeClass('active');

                if(!$this.hasClass('clicked')){
                    $this.addClass('clicked');

                    $.ajax({
                        url: '?BLOCK=tariffs&AJAX_REQUEST=Y&ajax_get=Y',
                        type: 'POST',
                        data: {
                            tariffs_price_key: price_key,
                        },
                        success: function(response){
                            $tab.removeClass('loading-state');

                            var obData = BX.processHTML(response);

                            $tab[0].innerHTML = obData.HTML;
                            setTimeout(function () {
                                BX.ajax.processScripts(obData.SCRIPT);
                            }, 0);
                        }
                    });
                }
            }
        }
    }
});

$(document).on('click', '.tariffs-list__item-properties-item-more', function(e) {
    e.stopImmediatePropagation();

    var $this = $(this);
    var $collapsed = $this.closest('.tariffs-list__item-text-top-part').find('.collapsed');

    if($collapsed.length) {
        $collapsed.slideToggle(200);
        var toggletext = $this.data('toggletext');
        var toggletextNew = $this.text();
        $this.text(toggletext).data('toggletext', toggletextNew);
    }
});

$(document).ready(function(){
    $('.tariffs-list .tab-nav-wrapper').scrollTab({
        tabs_wrapper: ".tab-nav",
        tab_item: "> .tab-nav__item",
        width_grow: 3,
        outer_wrapper: ".tariffs-list .index-block__title-wrapper",
        onResize: function (options) {
            const top_wrapper = options.outer_wrapper_node;
            let all_width = top_wrapper[0].getBoundingClientRect().width;
            if (top_wrapper.length) {
            const tabs_wrapper = options.scrollTab;

            if (window.matchMedia("(max-width: 767px)").matches) {
                tabs_wrapper.css({
                // 'width': '100%',
                "max-width": all_width,
                });
                return true;
            }

            const title = top_wrapper.find(".index-block__title-wrapper .index-block__part--left");
            const right_link = top_wrapper.find(".index-block__part--right");
            if (title.length) {
                all_width -= title.outerWidth(true);
            }

            if (right_link.length) {
                all_width -= right_link.outerWidth(true);
            }

            all_width -= Number.parseInt(tabs_wrapper.css("margin-left"));
            all_width -= Number.parseInt(tabs_wrapper.css("margin-right"));

            tabs_wrapper.css({
                "max-width": all_width,
                width: "",
            });
            }
            options.width = all_width;
        },
    });
});
$(document).on("click", ".detail-info__tabs__item", function () {
    var $this = $(this);

    if (!$this.hasClass("current")) {
        var index = $this.index();
        $this.addClass("current").siblings().removeClass("current");

        var $price = $this
            .closest(".detail-info__tabs")
            .next(".detail-info__tabs-content")
            .find(".detail-info__tabs-content__item")
            .eq(index);

        $price.removeClass("hidden").siblings().addClass("hidden");

        var name = $this.data("name");
        var $popupBlock = $this.closest(".js-popup-block");

        var $data = $popupBlock.find("[data-item]");
        if ($data.length) {
            var data = $data.data("item");
            if (typeof data !== "undefined" && data) {
                data.NAME = name;
                data.PROPERTY_FILTER_PRICE_VALUE = $this.data("filter_price");
                data.PROPERTY_PRICE_VALUE = $this.data("price");
                data.PROPERTY_PRICEOLD_VALUE = $this.data("oldprice");
                $data.data("item", data);
            }
        }

        var $buttonForm = $popupBlock.find(".btn-actions__inner .btn[data-event=jqm]");
        if ($buttonForm.length) {
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
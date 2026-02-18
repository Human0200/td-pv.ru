/*sku change props*/
if (!("SelectOfferProp" in window) && typeof window.SelectOfferProp != "function") {
  SelectOfferProp = function () {
    // return false;
    var _this = $(this),
      obParams = {},
      obSelect = {},
      objUrl = parseUrlQuery(),
      add_url = "",
      container = _this.closest(".sku-props"),
      item = _this.closest(".js-popup-block"),
			bDetail = !_this.closest('.catalog-items').length;

    /* request params */
    obParams = {
      PARAMS: (
				bDetail 
					? $(".js-sku-config:first").data("value") 
					: _this.closest('.catalog-items').find(".js-sku-config").data("value")
			),
      BASKET_PARAMS: item.find(".js-config-btns").data("btn-config"),
      IMG_PARAMS: item.find(".js-config-img").data("img-config"),
      PRICE_PARAMS: item.find(".js-popup-price").data("price-config"),
      ID: container.data("item-id"),
      OFFER_ID: container.data("offer-id"),
      SITE_ID: container.data("site-id"),
      IBLOCK_ID: container.data("iblockid"),
      SKU_IBLOCK_ID: container.data("offer-iblockid"),
      DEPTH: _this.closest(".sku-props__inner").index(),
      VALUE: _this.data("onevalue"),
      SHOW_GALLERY: arAsproOptions["THEME"]["SHOW_CATALOG_GALLERY_IN_LIST"],
      MAX_GALLERY_ITEMS: arAsproOptions["THEME"]["MAX_GALLERY_ITEMS"],
      OID: arAsproOptions["THEME"]["CATALOG_OID"],
      IS_DETAIL: (bDetail ? 'Y' : 'N'),
    };
    /**/

    if ("clear_cache" in objUrl) {
      if (objUrl.clear_cache == "Y") add_url += "?clear_cache=Y";
    }

    let isActiveContainer = container.hasClass("js-selected");

    // set active
    $(".sku-props").removeClass("js-selected");
    container.addClass("js-selected");
    _this.closest(".sku-props__values").find(".sku-props__value").removeClass("sku-props__value--active");
    _this.addClass("sku-props__value--active");
    _this.closest(".sku-props__item").find(".sku-props__js-size").text(_this.data("title"));

    /* save selected values */
    for (i = 0; i < obParams.DEPTH + 1; i++) {
      strName = "PROP_" + container.find(".sku-props__inner:eq(" + i + ")").data("id");

      obSelect[strName] = container.find(".sku-props__inner:eq(" + i + ") .sku-props__value--active").data("onevalue");
      obParams[strName] = container.find(".sku-props__inner:eq(" + i + ") .sku-props__value--active").data("onevalue");
    }
    obParams.SELECTED = JSON.stringify(obSelect);
    /**/

    /* get sku */
    if (window.obOffers && typeofExt(obOffers) === "array" && isActiveContainer) {
      //from /ajax/js_item_detail.php
      selectedValues = obSelect;
      strPropValue = obParams["VALUE"];
      depth = obParams["DEPTH"];
      wrapper = item;
      arFilter = {};
      tmpFilter = [];

      UpdateSKUInfoByProps();
    } else {
      $.ajax({
        url: arAsproOptions["SITE_DIR"] + "ajax/js_item_detail.php" + add_url,
        type: "POST",
				contentType: 'application/json',
				data: JSON.stringify(obParams),
      }).done(function (html) {
        var ob = BX.processHTML(html);
        BX.ajax.processScripts(ob.SCRIPT);
      });
    }
  };
  $(document).on("click", ".sku-props__value:not(.sku-props__value--active)", SelectOfferProp);
}

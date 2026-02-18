$(document).on("change", ".toggle-checkbox__input", function () {
  let that = $(this),
    currency = that.closest(".complects-list__item-text-top-part").data("currency"),
    $parent = that.closest(".toggle-checkbox"),
    price = +$parent.data("price"),
    priceOld = +$parent.data("oldprice"),
    $pricesBlock = that
      .closest(".complects-list__item-text-wrapper")
      .find(".complects-list__item-text-bottom-part .price"),
    $priceNew = $pricesBlock.find(".price__new-val"),
    $priceOld = $pricesBlock.find(".price__old-val"),
    $priceDiff = $pricesBlock.find(".price__economy-val");

  let summPrice = +$priceNew.text().replace(/\D/g, ""),
    summPriceOld = +$priceOld.text().replace(/\D/g, "");

  if (that.is(":checked")) {
    summPrice += price;
    summPriceOld += priceOld;
  } else {
    summPrice -= price;
    summPriceOld -= priceOld;
  }

  $priceNew.html(number_format(summPrice, 0, ".", " ") + " " + currency);
  $priceOld.html(number_format(summPriceOld, 0, ".", " ") + " " + currency);

  if ($priceDiff.length) {
    $priceDiff.html(number_format(summPriceOld - summPrice, 0, ".", " ") + " " + currency);
  }
});

/*buy opt table items*/
$(document).on("click", ".opt_action", function () {
  const _this = $(this),
    $parent = _this.closest(".complects-list__item-text-wrapper"),
    $serviceParent = $parent.find(".services-complect");

  if (!_this.hasClass("no-action")) {
    setTimeout(function () {
      const basketItems = [],
        itemsToNotice = [$parent[0]];

      const obj = $parent.data("item");
      obj.QUANTITY = 1;
      basketItems.push(obj);

      if ($serviceParent.length) {
        $serviceParent.find(".complect-props__name").each(function () {
          const _this = $(this);
          const add = _this.find(".toggle-checkbox__input").is(":checked");
          if (add) {
            itemsToNotice.push(_this[0]);

            const obj = _this.data("item");
            obj.QUANTITY = 1;
            basketItems.push(obj);
          }
        });
      }

      basketItems.forEach(function (obj) {
        if (typeofExt(arBasketItems) === "object" || typeofExt(arBasketItems) === "array") {
          if (typeofExt(arBasketItems[obj.ID]) === "undefined") {
            arBasketItems[obj.ID] = { ID: obj.ID, QUANTITY: obj.QUANTITY };
            if (obj.PARENT_ID) {
              arBasketItems[obj.ID]["PARENT_ID"] = obj.PARENT_ID;
            }
          } else {
            const quantity = +arBasketItems[obj.ID]["QUANTITY"];
            arBasketItems[obj.ID]["QUANTITY"] = quantity + obj.QUANTITY;
          }
        }
      });
      optBuyBasketAction(basketItems, itemsToNotice);
    }, 0);
  }
});

BX.addCustomEvent("onCompleteAction", function (eventdata, _this) {
  if (eventdata.action && eventdata.action === "loadBasket") {
    $(".opt_action").parent().removeClass("loadings");
  }
});

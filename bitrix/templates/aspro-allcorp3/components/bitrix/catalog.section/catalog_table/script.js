/*check all opt table items*/
$(document).on("change", "input#check_all_item", function () {
  const buyItemsCount = $(".catalog-table__item .to_cart").length;

  if ($(this).is(":checked") && buyItemsCount) {
    $(".opt_action").addClass("animate-load").removeClass("no-action");
    $(".opt_action .opt-buy__item-text").remove();

    //buy
    $('<div class="opt-buy__item-text">(<span>' + buyItemsCount + "</span>)</div>").appendTo(
      $(".opt_action[data-action=buy]")
    );

    //compare
    $('<div class="opt-buy__item-text">(<span>' + buyItemsCount + "</span>)</div>").appendTo(
      $(".opt_action[data-action=compare]")
    );

    $('input[name="check_item"]').prop("checked", "checked");
  } else {
    $(".opt_action").addClass("no-action");
    $(".opt_action").removeClass("animate-load");
    $(".opt_action .opt-buy__item-text").remove();

    $('input[name="check_item"]').prop("checked", "");
  }
});

/*check opt table item*/
$(document).on("change", "input[name='check_item']", function () {
  const _this = $(this);

  if (_this.is(":checked")) {
    $(".opt_action").each(function () {
      const _this = $(this);

      if (_this.find(".opt-buy__item-text").length) {
        let count = parseInt(_this.find(".opt-buy__item-text span").text());
        _this.find(".opt-buy__item-text span").text(++count);
      } else {
        _this.removeClass("no-action");
        _this.addClass("animate-load");
        $('<div class="opt-buy__item-text">(<span>1</span>)</div>').appendTo(_this);
      }
    });
  } else {
    $(".opt_action").each(function () {
      const _this = $(this);

      if (_this.find(".opt-buy__item-text").length) {
        let count = parseInt(_this.find(".opt-buy__item-text span").text());
        --count;
        _this.find(".opt-buy__item-text span").text(count);

        if (!count) {
          _this.addClass("no-action");
          _this.removeClass("animate-load");
          _this.find(".opt-buy__item-text").remove();
        }
      }
    });
  }
});

/*buy opt table items*/
$(document).on("click", ".opt_action", function () {
  const _this = $(this),
    action = _this.data("action"),
    basketParams = {
      type: "multiple",
      ajaxPost: "Y",
      IBLOCK_ID: _this.data("iblock_id"),
      action: action,
      items: [],
    };

  if (!_this.hasClass("no-action")) {
    setTimeout(function () {
      var items2add = [];

      $(".catalog-table__item").each(function () {
        const _this = $(this);
        const canBuy = _this.find(".btn-actions .to_cart").length;
        const add = _this.find('input[name="check_item"]').is(":checked") && canBuy;
        if (add) {
          items2add.push(_this.find(".catalog-table__info")[0]);

          const obj = _this.find(".catalog-table__info").data("item");
          let quantityInput = _this.find(".counter__count").val() || 1;
          obj.QUANTITY = +quantityInput;
          basketParams["items"].push(obj);

          if (typeofExt(arBasketItems) === "object" || typeofExt(arBasketItems) === "array") {
            if (typeofExt(arBasketItems[obj.ID]) === "undefined") {
              arBasketItems[obj.ID] = { ID: obj.ID, QUANTITY: obj.QUANTITY };
            } else {
              const quantity = +arBasketItems[obj.ID]["QUANTITY"];
              arBasketItems[obj.ID]["QUANTITY"] = quantity + obj.QUANTITY;
            }
          }
        }
      });

      var bBasketTop =
        typeof arAsproOptions["THEME"]["ORDER_BASKET_VIEW"] !== "undefined" &&
        $.trim(arAsproOptions["THEME"]["ORDER_BASKET_VIEW"]) === "HEADER" &&
        $(".basket.top").length;
      var bBasketFly =
        typeof arAsproOptions["THEME"]["ORDER_BASKET_VIEW"] !== "undefined" && !bBasketTop && $(".basket.fly").length;

      if (basketParams["items"].length) {
        if (action === "compare") {

          //Replacing the offer ID with the product ID
          for (var key in basketParams["items"]) {
            id = basketParams["items"][key]["ID"];
            configItemID = $(".catalog-table__info[data-id=" + id + "] [data-action=compare]").data("id");

            if(id != configItemID) {
              basketParams["items"][key]["ID"] = configItemID;
            } 
          }

          $.ajax({
            url: arAsproOptions["SITE_DIR"] + "ajax/item.php",
            type: "POST",
            dataType: "json",
            sessid: BX.bitrix_sessid(),
            data: $.extend(basketParams, { sessid: BX.bitrix_sessid() }),
          })
            .done(function (data) {
              arAsproOptions["COMPARE_ITEMS"] = data.items;
              setCompareItemsClass();

              if (arAsproOptions["COMPARE_ITEMS"].length > 0) {
                $(".js-compare-block").addClass("icon-block-with-counter--count");
              } else {
                $(".js-compare-block").removeClass("icon-block-with-counter--count");
              }
              $(".js-compare-block .count").text(arAsproOptions["COMPARE_ITEMS"].length);

              var eventdata = { action: "loadCompare", items: items2add };
              BX.onCustomEvent("onNoticeCompare", [eventdata, arAsproOptions["COMPARE_ITEMS"]]);
            })
            .fail(function (res) {
              console.error(res);
            });
        } else {
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
              JNoticeSurface.get().onAdd2cart(items2add);
            }

            var eventdata = { action: "loadBasket" };
            BX.onCustomEvent("onCompleteAction", [eventdata, $(html)]);
            setBasketItemsClasses();
          });
        }
      }
    }, 0);
  }
});

$(document).ready(function () {
  //check oid
  if (!location.hash) {
    if ("scrollRestoration" in history) {
      history.scrollRestoration = "manual";
    }
    if (typeof arAsproOptions !== "undefined" && arAsproOptions["OID"]) {
      let url, oid;
      if (BX.browser.IsIE()) {
        url = parseUrlQuery();
        oid = arAsproOptions["OID"] ? url[arAsproOptions["OID"]] : null;
      } else {
        url = new URL(window.location);
        oid = arAsproOptions["OID"] ? url.searchParams.get(arAsproOptions["OID"]) : null;
      }
      if (oid) {
        scrollToBlock('[data-id="' + oid + '"]');
      }
    }
  }
});

BX.addCustomEvent("onCompleteAction", function (eventdata) {
  if (eventdata.action === "ajaxContentLoaded") {
    if (typeof window.tableScrollerOb === "object" && window.tableScrollerOb) {
      window.tableScrollerOb.toggle();
    }
  }
});

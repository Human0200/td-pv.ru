$(document).ready(function () {
  setBasketItemsClasses();

  setTimeout(function () {
    function checkStickyPanelContent() {
      if (window.matchMedia("(min-width:992px)").matches) {
        $title = $(".catalog-detail__sticky-panel .catalog-detail__title");
        if ($title.length) {
          $right = $(".catalog-detail__right-info");
          if ($right.length) {
            var bVisible = $title.hasClass("show");
            var headerFixedHeight = $("#headerfixed.fixed").length ? 112 : 32;

            if ($right[0].getBoundingClientRect().top <= headerFixedHeight) {
              if (!bVisible) {
                $title.addClass("show");

                if ($title.data("timer")) {
                  clearTimeout($title.data("timer"));
                  $title.data("timer", false);
                }

                $title.css("height", "");
                var h = $title.actual("height");
                $title.height(0);
                $title.addClass("active");
                $title.height(h);

                $title.data(
                  "timer",
                  setTimeout(function () {
                    $title.css("height", "");
                  }, 2000)
                );
              }
            } else {
              if (bVisible) {
                $title.removeClass("show");

                if ($title.data("timer")) {
                  clearTimeout($title.data("timer"));
                  $title.data("timer", false);
                }

                var h = $title.actual("height");
                $title.height(h);
                $title.height(0);
                $title.data(
                  "timer",
                  setTimeout(function () {
                    $title.removeClass("active");
                    $title.css("height", "");
                  }, 700)
                );
              }
            }
          }
        }

        setTimeout(function () {
          var $sale = $(".catalog-detail__sticky-panel .catalog-detail__sale:not(.show)");
          if ($sale.length) {
            var h = $sale.actual("height");
            $sale.height(0);
            $sale.addClass("show");
            $sale.height(h);
            setTimeout(function () {
              $sale.css("height", "");
            }, 2000);
          }
        }, 2000);
      }
    }
    checkStickyPanelContent();

    $(document).resize(function () {
      checkStickyPanelContent();
    });

    $(document).scroll(function () {
      checkStickyPanelContent();
    });
  }, 1000);
});

BX.addCustomEvent("onChangeOptionSelect", function (eventData) {
  if (eventData && typeof eventData === "object" && eventData.type === "change") {
    if (eventData.payload && eventData.payload.item) {
      const $item = eventData.payload.item;

      setSelectedText($item);
      setCurrentInDropdown($item);
      setPrice($item);
      setPropsForBasket($item);
      setButton($item);

      processOrderAction($item);
      processBasketAction($item);
    }
  }
});
function setSelectedText(item) {
  $(".dropdown-select__title span").text(item.text().trim());
  setTitle(item);
}
function setTitle(item) {
  $(".dropdown-select__title").attr("title", item.text().trim());
}
function setCurrentInDropdown(item) {
  $(".dropdown-select__list-link").removeClass("dropdown-select__list-link--current");
  $(".dropdown-select__list-item[data-id='" + item.data("id") + "'] .dropdown-select__list-link").addClass(
    "dropdown-select__list-link--current"
  );
}
function setPrice(item) {
  const price = item.data("price");
  try {
    $(".catalog-detail__price.js-popup-price").html(JSON.parse(price));
  } catch (e) {
    console.error(e);
  }
}
function setPropsForBasket(item) {
  if (item.data("data")) {
    $(".catalog-detail__buy-block").data("item", item.data("data"));
    $(".catalog-detail__buy-block").data("id", item.data("id"));
  }
}
function setButton(item) {
  if (item.hasClass("change_btn")) {
    $('.buy_block[data-id="' + item.data("id") + '"]')
      .siblings(".buy_block")
      .addClass("hidden");
    $('.buy_block[data-id="' + item.data("id") + '"]').removeClass("hidden");
  }
}
function processOrderAction(item) {
  const $orderBtn = $(".catalog-detail__cart .to-order");
  if ($orderBtn) {
    $orderBtn.data("autoload-product", item.text().trim());
  }
}
function processBasketAction(item) {
  $(".catalog-detail__buy-block").find(".buy_block").removeClass("in");
  setBasketItemsClasses();
}

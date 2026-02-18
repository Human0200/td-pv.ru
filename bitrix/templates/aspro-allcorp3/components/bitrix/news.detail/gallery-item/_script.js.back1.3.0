$(document).on("click", ".gallery-list__item-text-cross-part", function () {
  var bSlider = $(this).closest(".owl-carousel").length;
  var index = $(this)
    .closest(bSlider ? ".owl-item" : ".gallery-list__wrapper")
    .index();
  var arItems = [];

  $(this)
    .closest(bSlider ? ".owl-stage" : ".grid-list")
    .find(".gallery-list__item-link[data-big]")
    .each(function () {
      var that = $(this);
      arItems.push({
        src: that.data("big"),
        opts: {
          caption: that.attr("title"),
        },
      });
    });

  if (arItems.length) {
    $.fancybox.open(arItems, { loop: false }, index);
  }
});

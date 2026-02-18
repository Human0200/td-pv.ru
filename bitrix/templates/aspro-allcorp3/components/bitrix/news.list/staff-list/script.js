$(document).ready(function () {
  $(".staff-list__item--scroll-text-hover").on("mouseenter click touchstart", function () {
    var _this = $(this);
    var text = _this.find(".staff-list__item-text-wrapper");
    if (text.length) {
      text.mCustomScrollbar({
        mouseWheel: {
          scrollAmount: 150,
          preventDefault: true,
        },
      });
    }
  });
});

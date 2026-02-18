$(document).ready(function () {
  $(document).on("mouseenter click touchstart", '.staff-block-inner [data-toggle="custom-scrollbar"]', function () {
    var _this = $(this);
    var text = _this.find("[scrollbar-wrapper]");
    if (text.length) {
      text.mCustomScrollbar({
        mouseWheel: {
          scrollAmount: 150,
          preventDefault: true,
        },
      });
    }
  });

  $(document).on("click", ".staff-block-inner__item", function (e) {
    if (e && e.target && e.target.tagName !== "A" && !$(e.target).closest(".mCSB_scrollTools").length) {
      var $link = $(this).find("a.staff-block-inner__item-link");
      if ($link.length) {
        if (
          (window.getSelection && !window.getSelection().toString()) ||
          (document.selection && !document.selection.createRange().text)
        ) {
          location.href = $link.attr("href");
        }
      }
    }
  });
});

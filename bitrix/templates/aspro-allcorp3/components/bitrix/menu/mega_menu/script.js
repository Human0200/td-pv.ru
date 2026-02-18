$(document).ready(function () {
  $(".burger-menu").mCustomScrollbar({
    mouseWheel: {
      scrollAmount: 150,
      preventDefault: true,
    },
  });

  $(".burger-menu__dropdown-right-arrow").on("click", function () {
    var _this = $(this);
    var bOpen = !_this.hasClass("opened");
    var parent = _this.closest(".burger-menu__dropdown-item--with-dropdown");
    if (parent.length) {
      var dropdown = parent.find(".burger-menu__dropdown--bottom");
      if (dropdown.length) {
        if (bOpen) {
          var parentWrapper = _this.closest(".burger-menu__dropdown--right");
          if (parentWrapper.length) {
            var dropdowns = parentWrapper.find(".burger-menu__dropdown--bottom.opened");
            if (dropdowns.length) {
              dropdowns.slideUp();
              dropdowns.removeClass("opened");
            }

            var arrows = parentWrapper.find(".burger-menu__dropdown-right-arrow.opened");
            if (arrows.length) {
              arrows.removeClass("opened");
            }
          }
        }

        dropdown.slideToggle();
        dropdown.toggleClass("opened");
        _this.toggleClass("opened");
      }
    }
  });

  $(".burger-menu__item--large").on("mouseenter", function () {
    var _this = $(this);
    if (!_this.hasClass("burger-menu__item--current")) {
      var megaMenuTimer = setTimeout(function () {
        var siblings = _this.siblings(".burger-menu__item--current");
        if (siblings.length) {
          siblings.removeClass("burger-menu__item--current");
        }
        _this.addClass("burger-menu__item--current");

        var dropdown = _this.find(".burger-menu__dropdown--right");
        if (dropdown.length) {
          dropdown.mCustomScrollbar({
            mouseWheel: {
              scrollAmount: 150,
              preventDefault: true,
            },
          });
        }
      }, 200);

      _this.one("mouseleave", function () {
        if (megaMenuTimer) {
          clearTimeout(megaMenuTimer);
        }
      });
    }
  });
});

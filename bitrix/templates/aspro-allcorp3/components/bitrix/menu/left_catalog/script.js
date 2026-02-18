const calculateMenuHeight = function () {
  if (window.matchMedia("(min-width: 992px)").matches) {
    try {
      var menu = $(".menu-side-column");
      if (menu.length) {
        var menuHeight = document.documentElement.clientHeight - 64; // minus paddings
        var bottomPart = $(".header__side-bottom");
        if (bottomPart.length) {
          menuHeight -= bottomPart.outerHeight(true);
        }

        var topPart = $(".header__side-top");
        var topPartHeight = 0;
        if (topPart.length) {
          topPartHeight = topPart.outerHeight(true);
          menuHeight -= topPartHeight;
        }
        menuHeight -= 80; // margins
        menu.css("max-height", menuHeight);

        var box = menu.find(".mCustomScrollBox");
        if (box.length) {
          box.css("max-height", menuHeight);
        }

        var childMenu = menu.find(
          ".menu-side-column__dropdown:not(.menu-side-column__dropdown--wide)"
        );
        if (childMenu.length) {
          childMenu.css({
            "padding-top": topPartHeight + 63,
            "padding-bottom": topPartHeight + 63,
          });
        }
      }
    } catch (e) {
      console.log(e);
    }
  }
};

$(document).ready(function () {
  $(".menu-side-column").mCustomScrollbar({
    mouseWheel: {
      scrollAmount: 150,
      preventDefault: true,
    },
  });
  $(".menu-side-column__item, .menu-side-column__dropdown-item").on(
    "mouseenter",
    function () {
      calculateMenuHeight();

      var _this = $(this);
      var bWide = _this.hasClass("menu-side-column__item--wide");
      var dropdown = _this.find("> .menu-side-column__dropdown");
      var silder = _this
        .closest(".menu-side-column")
        .find(".menu-side-column__bottom-banners");
      var bSlider = silder.length && bWide;
      if (bSlider) {
        silder.data("currentDropdown", dropdown);
      }

      if (dropdown.length) {
        dropdown.mCustomScrollbar({
          mouseWheel: {
            scrollAmount: 150,
            preventDefault: true,
          },
        });

        setTimeout(function () {
          var scrollBox = dropdown.find(".mCustomScrollBox");
          if (scrollBox.length) {
            scrollBox.css("max-height", "auto");
          }
        }, 1);

        dropdown.addClass("active");
        if (bSlider) {
          silder.addClass("active");
        }

        _this.one("mouseleave", function () {
          dropdown.removeClass("active");
          if (bSlider) {
            silder.removeClass("active");
          }
        });
      }
    }
  );

  $(".menu-side-column__bottom-banners").on("mouseenter", function () {
    var _this = $(this);
    var dropdown = _this.data("currentDropdown");

    dropdown.addClass("active");
    _this.addClass("active");

    _this.one("mouseleave", function () {
      dropdown.removeClass("active");
      _this.removeClass("active");
    });
  });

  $(document).on(
    "click",
    ".header-menu-side__wide-submenu-item-inner .toggle_block",
    function (e) {
      e.preventDefault();

      var _this = $(this),
        menu = _this
          .closest(".header-menu-side__wide-submenu-item-inner")
          .find("> .submenu-wrapper");

      if (!_this.hasClass("clicked")) {
        _this.addClass("clicked");

        menu.slideToggle(150, function () {
          _this.removeClass("clicked");
        });

        _this
          .closest(".header-menu-side__wide-submenu-item-inner")
          .toggleClass("opened");
      }
    }
  );

  $(document).on(
    "click",
    ".header-menu-side__wide-submenu-item--more_items",
    function (e) {
      e.stopImmediatePropagation();

      var _this = $(this);
      var bOpened = _this.hasClass("opened");
      var childSpan = _this.find("span");
      var childSvg = childSpan.find(".svg");
      var parent = _this.closest(".header-menu-side__wide-submenu");
      var collapsed = parent.find(".collapsed");
      var useDelimetr = parent.hasClass(
        "header-menu-side__wide-submenu--delimiter"
      );
      var lastSeparator = parent.find(".last-visible");

      if (collapsed.length) {
        if (useDelimetr) {
          collapsed.fadeToggle(200);
          if (lastSeparator.length) lastSeparator.fadeToggle(200);
        } else {
          collapsed.slideToggle(200);
        }

        if (bOpened) {
          childSpan.text(BX.message("SHOW")).append(childSvg);
        } else {
          childSpan.text(BX.message("HIDE")).append(childSvg);
        }
        _this.toggleClass("opened");
      }
    }
  );
});

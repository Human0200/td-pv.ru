$(document).ready(function () {
  $(document).on(
    "click",
    ".header-menu__wide-submenu-item-inner .toggle_block",
    function (e) {
      e.preventDefault();
      const $menuContainer = e.target.closest(
        ".header-menu__dropdown-menu-inner.header-menu__dropdown-menu--grids"
      );
      const $parentContainer = e.target.closest(".header-menu__wide-limiter");
      const menuContainerCurrentWidth = $menuContainer.offsetWidth;

      const _this = $(this),
        $menu = _this
          .closest(".header-menu__wide-submenu-item-inner")
          .find("> .submenu-wrapper");

      if (!_this.hasClass("clicked")) {
        _this.addClass("clicked");
        $menu.slideToggle({
          duration: 150,
          done: function () {
            _this.removeClass("clicked");
          },
          step: function () {
            if (menuContainerCurrentWidth !== $menuContainer.offsetWidth) {
              const paddingRight = window.getComputedStyle(
                $parentContainer,
                null
              ).paddingRight;
              $parentContainer.style.paddingRight =
                parseInt(paddingRight) -
                (menuContainerCurrentWidth - $menuContainer.offsetWidth) +
                "px";
            }
          },
        });

        _this
          .closest(".header-menu__wide-submenu-item-inner")
          .toggleClass("opened");
      }
    }
  );

  $(document).on(
    "click",
    ".header-menu__wide-submenu-item--more_items",
    function (e) {
      e.stopImmediatePropagation();

      const $menuContainer = e.target.closest(
        ".header-menu__dropdown-menu-inner.header-menu__dropdown-menu--grids"
      );
      const $parentContainer = e.target.closest(".header-menu__wide-limiter");
      const menuContainerCurrentWidth = $menuContainer.offsetWidth;

      const _this = $(this),
        bOpened = _this.hasClass("opened"),
        childSpan = _this.find("span"),
        childSvg = childSpan.find(".svg"),
        parent = _this.closest(".header-menu__wide-submenu"),
        collapsed = parent.find(".collapsed"),
        useDelimetr = parent.hasClass("header-menu__wide-submenu--delimiter"),
        lastSeparator = parent.find(".last-visible");

      const obAnimation = {
        duration: 200,
        step: function () {
          if (menuContainerCurrentWidth !== $menuContainer.offsetWidth) {
            const paddingRight = window.getComputedStyle(
              $parentContainer,
              null
            ).paddingRight;
            $parentContainer.style.paddingRight =
              parseInt(paddingRight) -
              (menuContainerCurrentWidth - $menuContainer.offsetWidth) +
              "px";
          }
        },
      };

      if (collapsed.length) {
        if (useDelimetr) {
          collapsed.fadeToggle(obAnimation);

          if (lastSeparator.length) {
            lastSeparator.fadeToggle(obAnimation);
          }
        } else {
          collapsed.slideToggle(obAnimation);
        }

        childSpan.text(BX.message(bOpened ? "SHOW" : "HIDE")).append(childSvg);

        _this.toggleClass("opened");
      }
    }
  );
});

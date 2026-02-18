function logo_depend_banners(menu_color) {
  menu_color =
    menu_color || $(".banners-big--detail .banners-big__item").data("color");

  let bLightMenu = menu_color && menu_color === "light";

  const $header = document.querySelector('header');
  const $headerLogo = document.querySelector("header .logo img");

  // set header color if there is banner
  if (document.querySelector(".banners-big")) {
    $header.classList.remove('light', 'dark');

    if (bLightMenu) {
      $header.classList.add(menu_color);
    }
  } else {
    bLightMenu = !!$header.classList.contains('light');
  }

  if ($headerLogo && arAsproOptions.THEME.LOGO_IMAGE_WHITE) {
    // get color scheme
    const bDarkMode = !!~document.querySelector("body").className.indexOf("theme-default")
      ? window.matchMedia("(prefers-color-scheme: dark)").matches
      : !!~document.querySelector("body").className.indexOf("theme-dark");
  
    // set main logo image
    const bLogoOpacity = // when logotype on transparent background
      $("body.header_opacity:not(.left_header_column)").length &&
      (
        !$("header.header--offset").length ||
        $("header .logo").closest(".header__top-part").length || 
        (
          $("header.header--offset").length && 
          $("header .header__main-inner.bg_none, header .header__sub-inner.bg_none").length
        )
      );
    const bLogoWhite = !!document.querySelector(
      ".header__main-inner.header--color_colored .logo, .header__main-inner.header--color_dark .logo, .header__main-part.header--color_dark .logo, .header__main-part.header--color_colored .logo, .header__inner--parted.dark .logo, .header__sub-inner.header--color_colored .logo, .header__sub-inner.header--color_dark .logo"
    ); // when logo is permanent white
    const logoImage =
        (bLogoOpacity && bLightMenu) || // logo on transparent banner
        (!bLogoOpacity && (bDarkMode || (!bDarkMode && bLogoWhite))) // logo on painted banner
          ? arAsproOptions.THEME.LOGO_IMAGE_WHITE
          : arAsproOptions.THEME.LOGO_IMAGE;
    $headerLogo.setAttribute("src", logoImage);
  
    // // set other logotypes
    // const $logotypes = document.querySelectorAll(
    //   "#headerfixed .logo img, .mobileheader--color-white .logo img, .mobileheader--color-grey .logo img, #mobilemenu .logo img"
    // );
    // if ($logotypes.length) {
    //   for (let i = 0; i < $logotypes.length; i++) {
    //     $logotypes[i].setAttribute(
    //       "src",
    //       bDarkMode && arAsproOptions.THEME.LOGO_IMAGE_WHITE
    //         ? arAsproOptions.THEME.LOGO_IMAGE_WHITE
    //         : arAsproOptions.THEME.LOGO_IMAGE
    //     );
    //   }
    // }
  }
}

BX.addCustomEvent("onChangeThemeColor", function (e) {
  const menu_color = document.querySelector('.main-slider__item.swiper-slide-active') && document.querySelector('.main-slider__item.swiper-slide-active').dataset.color;
  logo_depend_banners(menu_color);
});

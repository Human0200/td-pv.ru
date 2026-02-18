$(document).ready(function () {
  $(".confirm_region .aprove").on("click", function (e) {
    var _this = $(this);
    $.removeCookie("current_region");

    if (arAllcorp3Options["SITE_ADDRESS"].indexOf(",") != "-1") {
      var arDomains = arAllcorp3Options["SITE_ADDRESS"].split(",");
      if (arDomains) {
        for (var i in arDomains) {
          var domain_name = arDomains[i].replace("\n", "");
          domain_name = arDomains[i].replace("'", "");
          $.cookie("current_region", _this.data("id"), { path: "/", domain: domain_name });
        }
      }
    } else $.cookie("current_region", _this.data("id"), { path: "/", domain: arAllcorp3Options["SITE_ADDRESS"] });

    $(".confirm_region").remove();
    if (typeof _this.data("href") !== "undefined") location.href = _this.data("href");
  });
  $(".js_city_change").on("click", function () {
    var _this = $(this);
    $(".region_wrapper .dropdown").fadeToggle(100);
    if (_this.closest(".top_mobile_region").length && window.matchMedia("(max-width:991px)").matches) {
      $("#mobileheader .burger").click();

      $(".mobilemenu__menu--regions > ul > li > div > a").click();
    }
    $(".confirm_region").remove();
  });
  $(".js_city_chooser").on("click", function () {
    var _this = $(this);
    $(".confirm_region").remove();
    $(".region_wrapper .dropdown").removeClass("active");
    _this.closest(".region_wrapper").find(".dropdown").toggleClass("active").fadeToggle(100);
    $(".region_wrapper .dropdown:not(.active)").hide();
  });
  /* close search block */
  $("html, body").on("mousedown", function (e) {
    e.stopPropagation();
    if (!$(e.target).hasClass("dropdown")) {
      $(".region_wrapper .dropdown").fadeOut(100);
    }
  });
  $(".region_wrapper")
    .find("*")
    .on("mousedown", function (e) {
      e.stopPropagation();
    });
  $(".region_wrapper .more_item:not(.current) span").on("click", function (e) {
    $.removeCookie("current_region");
    if (arAllcorp3Options["SITE_ADDRESS"].indexOf(",") != "-1") {
      var arDomains = arAllcorp3Options["SITE_ADDRESS"].split(",");
      if (arDomains) {
        for (var i in arDomains) {
          var domain_name = arDomains[i].replace("\n", "");
          domain_name = arDomains[i].replace("'", "");
          $.cookie("current_region", $(this).data("region_id"), { path: "/", domain: domain_name });
        }
      }
    } else $.cookie("current_region", $(this).data("region_id"), { path: "/", domain: arAllcorp3Options["SITE_ADDRESS"] });

    location.href = $(this).data("href");
  });
});

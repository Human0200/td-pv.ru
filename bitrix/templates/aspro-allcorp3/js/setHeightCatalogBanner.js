const setHeightBanner = function () {
	const $bannerClosestItems = document.querySelectorAll(
		".catalog_banner__wrapper .catalog_banner__item"
	);

  if ($bannerClosestItems.length) {
		for (let i = 0; i < $bannerClosestItems.length; i++) {
			const $tabActive = $bannerClosestItems[i].closest(".line-block");

			if ($tabActive) {
				const $firstItem = $tabActive.querySelector(
					".tab-content-block.active .catalog-block__item:first-child"
				);

				if ($firstItem) {
					const height = $firstItem.offsetHeight;
					$bannerClosestItems[i].style.height = height + "px";
				}
			}
		}
	}
};
BX.addCustomEvent("onSetHeightBanner", function (eventdata) {
	setHeightBanner();
});
$(document).ready(function () {
	setHeightBanner();
});
BX.addCustomEvent("onWindowResize", function (eventdata) {
	setHeightBanner();
});

<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $arRegion;

$arResult["ELEMENTS"] = array();
$arResult["SEARCH"] = array();
foreach ($arResult["CATEGORIES"] as $category_id => $arCategory) {
	foreach ($arCategory["ITEMS"] as $i => $arItem) {
		if (isset($arItem["ITEM_ID"])) {
			$arResult["SEARCH"][] = &$arResult["CATEGORIES"][$category_id]["ITEMS"][$i];
			if ($arItem["MODULE_ID"] === "iblock" && strpos($arItem["ITEM_ID"], "S") === false) {
				$arResult["ELEMENTS"][$arItem["ITEM_ID"]] = $arItem["ITEM_ID"];
				if (array_key_exists($arItem["PARAM2"], (array)$arCatalogs)) {
					$arResult["CATALOG_ELEMENTS"][$arItem["ITEM_ID"]] = $arItem["ITEM_ID"];
				}
			}
		}
	}
}

if (!empty($arResult["ELEMENTS"]) && CModule::IncludeModule("iblock")) {
	$arSelect = array(
		"ID",
		"IBLOCK_ID",
		"PREVIEW_TEXT",
		"PREVIEW_PICTURE",
		"DETAIL_PICTURE",
		"DETAIL_PAGE_URL",
		"ACTIVE_FROM",
		"PROPERTY_REDIRECT",
	);
	$arFilter = array(
		"IBLOCK_LID" => SITE_ID,
		"IBLOCK_ACTIVE" => "Y",
		"ACTIVE_DATE" => "Y",
		"ACTIVE" => "Y",
		"CHECK_PERMISSIONS" => "Y",
		"MIN_PERMISSION" => "R",
	);

	$arFilter["=ID"] = $arResult["ELEMENTS"];
	$arNoPictureElements = [];

	$rsElements = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
	while ($arElement = $rsElements->Fetch()) {
		TSolution\Product\Image::addElementWithNoImage($arElement, $arNoPictureElements);
		
		$arResult["ELEMENTS"][$arElement["ID"]] = $arElement;
		
		$arRegionProps = array();
		$rsPropRegion = CIBlockElement::GetProperty($arElement["IBLOCK_ID"], $arElement["ID"], array("sort" => "asc"), array("CODE" => "LINK_REGION"));
		while ($arPropRegion = $rsPropRegion->Fetch()) {
			if ($arPropRegion['VALUE']) {
				$arRegionProps[] = $arPropRegion['VALUE'];
			}
		}

		if ($arRegionProps && $arRegion) {
			if (!in_array($arRegion['ID'], $arRegionProps)) {
				$arDeleteIDs[$arElement["ID"]] = $arElement["ID"];
				unset($arResult["ELEMENTS"][$arElement["ID"]]);
				continue;
			}
		}
	}

	if(!empty($arNoPictureElements)){
		$arSectionImages = TSolution\Product\DetailGallery::getSectionsImages([
			'ITEMS' => $arNoPictureElements,
		]);

		foreach($arNoPictureElements as $element){
			$arPicture = TSolution\Product\Image::getPictureOrDetailPicture($arSectionImages, $element);

			$arResult['ELEMENTS'][$element['ID']]['PREVIEW_PICTURE'] = $arPicture['id'];
		}
	}

	// replace year in url
	foreach ($arResult["CATEGORIES"] as $category_id => $arCategory) {
		foreach ($arCategory["ITEMS"] as $i => $arItem) {
			if (isset($arItem["ITEM_ID"])) {
				if ($arResult["ELEMENTS"][$arItem["ITEM_ID"]]["PROPERTY_REDIRECT_VALUE"]) {
					$arResult["CATEGORIES"][$category_id]["ITEMS"][$i]["URL"] = $arResult["ELEMENTS"][$arItem["ITEM_ID"]]["PROPERTY_REDIRECT_VALUE"];
				} elseif (strpos($arItem["URL"], "#YEAR#") !== false) {
					if ($arResult["ELEMENTS"][$arItem["ITEM_ID"]]["ACTIVE_FROM"]) {
						if ($arDateTime = ParseDateTime($arResult["ELEMENTS"][$arItem["ITEM_ID"]]["ACTIVE_FROM"], FORMAT_DATETIME)) {
							$url = str_replace("#YEAR#", $arDateTime['YYYY'], $arItem['URL']);
							$arResult["CATEGORIES"][$category_id]["ITEMS"][$i]["URL"] = $url;
						}
					}
				}
			}

			if ($arDeleteIDs) {
				if ($arDeleteIDs[$arItem["ITEM_ID"]]) {
					unset($arResult["CATEGORIES"][$category_id]["ITEMS"][$i]);
				}
			}
		}
	}
}

foreach ($arResult["SEARCH"] as $i => $arItem) {
	if ($arRegion) {
		$arRegionProps = array();
		$rsPropRegion = CIBlockElement::GetProperty($arItem["PARAM2"], $arItem["ITEM_ID"], array("sort" => "asc"), array("CODE" => "LINK_REGION"));
		while ($arPropRegion = $rsPropRegion->Fetch()) {
			if ($arPropRegion['VALUE']) {
				$arRegionProps[] = $arPropRegion['VALUE'];
			}
		}

		if ($arRegionProps) {
			if (!in_array($arRegion['ID'], $arRegionProps)) {
				unset($arResult["SEARCH"][$i]);
			}
		}
	}
	switch ($arItem["MODULE_ID"]) {
		case "iblock":
			if (array_key_exists($arItem["ITEM_ID"], $arResult["ELEMENTS"])) {
				$arElement = &$arResult["ELEMENTS"][$arItem["ITEM_ID"]];
				if ($arParams["SHOW_PREVIEW"] == "Y") {
					if ($arElement["PREVIEW_PICTURE"] > 0) {
						$arElement["PICTURE"] = CFile::ResizeImageGet($arElement["PREVIEW_PICTURE"], array("width" => 80, "height" => 80), BX_RESIZE_IMAGE_PROPORTIONAL, true);
					}
					elseif ($arElement["DETAIL_PICTURE"] > 0) {
						$arElement["PICTURE"] = CFile::ResizeImageGet($arElement["DETAIL_PICTURE"], array("width" => 80, "height" => 80), BX_RESIZE_IMAGE_PROPORTIONAL, true);
					}
				}
			}
			break;
	}

	$arResult["SEARCH"][$i]["ICON"] = true;
}
?>

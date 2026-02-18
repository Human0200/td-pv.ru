<?
global $arTheme, $APPLICATION;

if(strlen($arParams["FILTER_NAME"])){

	$GLOBALS[$arParams["FILTER_NAME"]] = array_merge((array)$GLOBALS[$arParams["FILTER_NAME"]], (array)$arElementFilter);
}
else{
	$arParams["FILTER_NAME"] = "arrFilter";
	$GLOBALS[$arParams["FILTER_NAME"]] = $arElementFilter;
}

if($arTheme['SHOW_SMARTFILTER']['VALUE'] !== 'N' && $itemsCnt){
	$bCompactView = $arParams['FILTER_VIEW'] == "COMPACT";
	if($bCompactView){
		$template = 'main_compact';
	} else {
		$template = 'catalog';
	}
	if(!$bCompactView){
		$this->__component->__template->SetViewTarget('under_sidebar_content');
	}

	$GLOBALS['preFilterCatalog'] = TSolution\Regionality::mergeSmartPreFilterWithRegionFilter($GLOBALS['preFilterCatalog'] ?? []);

	TSolution\CacheableUrl::addSmartFilterNameParam($arParams['FILTER_NAME']);
	
	$APPLICATION->IncludeComponent(
		'bitrix:catalog.smart.filter', $template,
		array(
			'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
			'IBLOCK_ID' => $arParams['IBLOCK_ID'],
			'SECTION_ID' => $arSection['ID'],
			'PREFILTER_NAME' => 'preFilterCatalog',
			'FILTER_NAME' => $arParams['FILTER_NAME'],
			'PRICE_CODE' => $arParams['PRICE_CODE'],
			'CACHE_TYPE' => $arParams['CACHE_TYPE'],
			'CACHE_TIME' => $arParams['CACHE_TIME'],
			'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
			'SAVE_IN_SESSION' => 'N',
			'FILTER_VIEW_MODE' => ($arTheme['FILTER_VIEW']['VALUE'] == 'HORIZONTAL' ? 'HORIZONTAL' : 'VERTICAL'),
			'DISPLAY_ELEMENT_COUNT' => 'Y',
			'POPUP_POSITION' => ($arTheme['SIDE_MENU']['VALUE'] == 'LEFT' ? 'right' : 'left'),
			'INSTANT_RELOAD' => 'Y',
			'XML_EXPORT' => 'N',
			'HIDE_NOT_AVAILABLE' => 'N',
			'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
			'SHOW_HINTS' => $arParams['SHOW_HINTS'],
			"SEF_MODE" => (strlen($arResult["URL_TEMPLATES"]["smart_filter"]) ? "Y" : "N"),
			"SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
			"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
			"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
			"SEF_RULE_FILTER" => $arResult["URL_TEMPLATES"]["smart_filter"],
		),
		$component
	);
	
	if(!$bCompactView){
		$this->__component->__template->EndViewTarget();
	}
}
?>
<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

require_once($_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/vendor/php/solution.php');

if (!class_exists('TSolution') || !CModule::IncludeModule(TSolution::moduleID)) {
	ShowError(GetMessage('ASPRO_MODULE_NOT_INSTALLED'));
	return;
}

global $arTheme, $APPLICATION;

/*Prepare params*/
$arParams["ELEMENT_COUNT"] = ($arParams["ELEMENT_COUNT"] ? $arParams["ELEMENT_COUNT"] : 5);
$arParams['FILTER_NAME'] = ($arParams['FILTER_NAME'] ? $arParams['FILTER_NAME'] : 'arFilterWrapper');

$arParams["COMPONENT_NAME"] = $componentName;
$arParams["TEMPLATE"] = $componentTemplate;

$arParams["IS_AJAX"] = TSolution::checkAjaxRequest();

$context = \Bitrix\Main\Application::getInstance()->getContext();
$request = $context->getRequest();

/*fix global filter in ajax*/
if ($_SESSION['ASPRO_FILTER'][$arParams['FILTER_NAME']]) {
	$GLOBALS[$arParams['FILTER_NAME']] = $_SESSION['ASPRO_FILTER'][$arParams['FILTER_NAME']];
}

if ($arParams['FILTER_NAME'] == 'arrPopularSections') {
	$GLOBALS[$arParams['FILTER_NAME']] = array('UF_POPULAR' => 1);
}
/**/


if ($arParams["IS_AJAX"] != 'Y') {
	$this->IncludeComponentTemplate();
} else {
	// $APPLICATION->ShowCss();
	// $APPLICATION->ShowHeadScripts();
	$APPLICATION->ShowAjaxHead();

	// not load core.js in CJSCore:Init()
	CJSCore::markExtensionLoaded('core');

	global $arRegion;
	$arRegion = TSolution\Regionality::getCurrentRegion();

	if ($arRegion) {
		if ($arRegion['LIST_PRICES']) {
			if (reset($arRegion['LIST_PRICES']) != 'component') {
				$arParams['PRICE_CODE'] = array_keys($arRegion['LIST_PRICES']);
			}
		}

		if ($arRegion['LIST_STORES']) {
			if (reset($arRegion['LIST_STORES']) != 'component') {
				$arParams['STORES'] = $arRegion['LIST_STORES'];
			}
		}

		if ($arParams['FILTER_NAME'] == 'arRegionality' && $arParams['STORES']) {
			if (TSolution::GetFrontParametrValue('STORES_SOURCE') != 'IBLOCK') {
				$GLOBALS[$arParams['FILTER_NAME']] = array('ID' => $arRegion['LIST_STORES']);
			} else {
				$GLOBALS[$arParams['FILTER_NAME']] = array('PROPERTY_STORE_ID' => $arRegion['LIST_STORES']);
			}
		}
		if ($arParams['FILTER_NAME'] == 'arRegionLink' && TSolution::GetFrontParametrValue('REGIONALITY_FILTER_ITEM') == 'Y') {
			$GLOBALS[$arParams['FILTER_NAME']] = array('PROPERTY_LINK_REGION' => $arRegion['ID']);
		}
	}
	$this->IncludeComponentTemplate('ajax');
}


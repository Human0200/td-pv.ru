<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
global $arTheme, $APPLICATION;

require_once($_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/vendor/php/solution.php');

if (!class_exists('TSolution') || !CModule::IncludeModule(TSolution::moduleID)) {
	ShowError(GetMessage('ASPRO_MODULE_NOT_INSTALLED'));
	return;
}

/*Prepare params*/
$arParams['ELEMENT_COUNT'] = ($arParams['ELEMENT_COUNT'] ? $arParams['ELEMENT_COUNT'] : 5);
$arParams['FILTER_NAME'] = ($arParams['FILTER_NAME'] ? $arParams['FILTER_NAME'] : 'arFilterWrapper');
$arParams['COMPONENT_NAME'] = $componentName;
$arParams['TEMPLATE'] = $componentTemplate;

$arResult = array(
	'IS_AJAX' =>
		$arParams['SHOW_FORM'] === 'Y' &&
		(
			TSolution::checkAjaxRequest() ||
			(
				isset($_REQUEST['AJAX_CALL']) &&
				$_REQUEST['AJAX_CALL'] === 'Y'
			)
		),
);

$context = \Bitrix\Main\Application::getInstance()->getContext();
$request = $context->getRequest();

/*fix global filter in ajax*/
if($_SESSION['ASPRO_FILTER'][$arParams['FILTER_NAME']]){
	$GLOBALS[$arParams['FILTER_NAME']] = $_SESSION['ASPRO_FILTER'][$arParams['FILTER_NAME']];
}

if($arResult['IS_AJAX']){
	$APPLICATION->ShowAjaxHead();
}

if(!$arResult['IS_AJAX']){
	$ob = new TSolution\MarketingPopup();
	$rules = $ob->getRules();

	if(
		$rules &&
		isset($rules['ALL']) &&
		$rules['ALL']
	){

		$arResult['ITEMS'] = $rules['ALL'];
	}

	$this->IncludeComponentTemplate();
}
else{
	if($request['id']){
		$dbRes = CIblockElement::GetList(array(), array('ID' => $request['id']), false, false, array('ID', 'IBLOCK_ID'));
		if($arItem = $dbRes->Fetch()){
			$arFilter = array(
				"IBLOCK_ID" => $arItem['IBLOCK_ID'],
				"ACTIVE" => "Y",
				"ID" => $arItem['ID']
			);
			$arSelect = array(
				"ID",
				"NAME",
				"PREVIEW_TEXT",
				"PREVIEW_PICTURE",
				"PROPERTY_BTN1_LINK",
				"PROPERTY_BTN1_TEXT",
				"PROPERTY_BTN1_CLASS",
				"PROPERTY_BTN2_LINK",
				"PROPERTY_BTN2_TEXT",
				"PROPERTY_BTN2_CLASS",
				"PROPERTY_MODAL_TYPE",
				"PROPERTY_POSITION",
				"PROPERTY_HIDE_TITLE",
				"PROPERTY_LINK_WEB_FORM",
			);

			$arResult['ITEM'] = TSolution\Cache::CIBLockElement_GetList(array(
				'CACHE' => array(
					'TAG' => TSolution\Cache::GetIBlockCacheTag($arItem['IBLOCK_ID']),
					'MULTI' => 'N'
				)),
				$arFilter,
				false,
				false,
				$arSelect
			);

			if($arResult['ITEM']){
				$type = $arResult['ITEM']['PROPERTY_MODAL_TYPE_ENUM_ID'];
				$type = $type ? CIBlockPropertyEnum::GetByID($type)['XML_ID'] : 'MAIN';
				$arResult['ITEM']['PROPERTY_MODAL_TYPE_XML_ID'] = $type;

				if($type === 'WEBFORM'){
					$arResult['ITEM']['PROPERTY_LINK_WEB_FORM_ID'] = intval(TSolution::getFormID($arResult['ITEM']['PROPERTY_LINK_WEB_FORM_VALUE']));
				}

				$arResult['ITEM']['BTN1_CLASS_INFO'] = $arResult['ITEM']['BTN2_CLASS_INFO'] = array();

				if($arResult['ITEM']['PROPERTY_BTN1_CLASS_ENUM_ID']){
					$arResult['ITEM']['BTN1_CLASS_INFO'] = CIBlockPropertyEnum::GetByID($arResult['ITEM']['PROPERTY_BTN1_CLASS_ENUM_ID']);
				}

				if($arResult['ITEM']['PROPERTY_BTN2_CLASS_ENUM_ID']){
					$arResult['ITEM']['BTN2_CLASS_INFO'] = CIBlockPropertyEnum::GetByID($arResult['ITEM']['PROPERTY_BTN2_CLASS_ENUM_ID']);
				}

				$this->IncludeComponentTemplate(strtolower($request['template']));
			}
		}
	}
}
?>
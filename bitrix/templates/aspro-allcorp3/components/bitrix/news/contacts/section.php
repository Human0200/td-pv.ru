<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

global $arTheme, $APPLICATION;

$bUseMap = CAllcorp3::GetFrontParametrValue('CONTACTS_USE_MAP', SITE_ID) != 'N';
$typeMap = CAllcorp3::GetFrontParametrValue('CONTACTS_TYPE_MAP', SITE_ID);
$bUseFeedback = CAllcorp3::GetFrontParametrValue('CONTACTS_USE_FEEDBACK', SITE_ID) != 'N';
$bUseTabs = $bUseMap && CAllcorp3::GetFrontParametrValue('CONTACTS_USE_TABS', SITE_ID) != 'N';

$arSectionFilter = CAllcorp3::GetCurrentSectionFilter($arResult["VARIABLES"], $arParams);
$arSection = CAllcorp3Cache::CIblockSection_GetList(array("CACHE" => array("TAG" => CAllcorp3Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]), "MULTI" => "N")), $arSectionFilter, false, array('ID', 'NAME', 'DESCRIPTION', 'PICTURE', 'DETAIL_PICTURE', 'IBLOCK_ID'));

$arItemFilter = CAllcorp3::GetCurrentSectionElementFilter($arResult["VARIABLES"], $arParams, $arSection['ID']);

// get section items count
$itemsCnt = CAllcorp3Cache::CIblockElement_GetList(array("CACHE" => array("TAG" => CAllcorp3Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), $arItemFilter, array());

$arItemSelect = array('ID', 'NAME', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'DETAIL_PAGE_URL', 'PROPERTY_ADDRESS', 'PROPERTY_MAP', 'PROPERTY_SCHEDULE', 'PROPERTY_EMAIL', 'PROPERTY_METRO', 'PROPERTY_PHONE');
$arItems = CAllcorp3Cache::CIBlockElement_GetList(
	array(
		"CACHE" => array("
			TAG" => CAllcorp3Cache::GetIBlockCacheTag($arParams['IBLOCK_ID'])
		)
	),
	$arItemFilter,
	false,
	false,
	$arItemSelect
);

$GLOBALS[$arParams['FILTER_NAME']]['SECTION_ID'] = $arSection['ID'];
$GLOBALS[$arParams['FILTER_NAME']]['INCLUDE_SUBSECTIONS'] = 'Y';
?>
<?if(!$arSection && ($arParams['SET_STATUS_404'] !== 'Y' || $_SERVER['REQUEST_METHOD'] === 'POST')):?>
	<div class="alert alert-warning"><?=GetMessage('SECTION_NOTFOUND')?></div>
<?elseif(!$arSection && $arParams['SET_STATUS_404'] === 'Y'):?>
	<?CAllcorp3::goto404Page();?>
<?else:?>
	<?
	CAllcorp3::AddMeta(
		array(
			'og:description' => $arSection['DESCRIPTION'],
			'og:image' => (($arSection['PICTURE'] || $arSection['DETAIL_PICTURE']) ? CFile::GetPath(($arSection['PICTURE'] ? $arSection['PICTURE'] : $arSection['DETAIL_PICTURE'])) : false),
		)
	);

	CAllcorp3::CheckComponentTemplatePageBlocksParams($arParams, __DIR__);

	$sViewElementsTemplate = ($arParams["SECTIONS_TYPE_VIEW"] == "FROM_MODULE" ? 'sections_'.$arTheme["PAGE_CONTACTS"]["VALUE"] : $arParams["SECTIONS_TYPE_VIEW"]);
	@include_once('page_blocks/'.$sViewElementsTemplate.'.php');

	if (CAllcorp3::checkAjaxRequest()){
		die();
	}
	?>
<?endif;?>
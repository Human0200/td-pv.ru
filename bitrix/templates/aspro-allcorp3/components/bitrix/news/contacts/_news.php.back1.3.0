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

$arItemFilter = CAllcorp3::GetIBlockAllElementsFilter($arParams);

$arItemSelect = array('ID', 'NAME', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'DETAIL_PAGE_URL', 'PROPERTY_ADDRESS', 'PROPERTY_MAP', 'PROPERTY_SCHEDULE', 'PROPERTY_EMAIL', 'PROPERTY_METRO', 'PROPERTY_PHONE');

// section
$arSection = array();
$sectionId = isset($_POST['SECTION_ID']) ? intval($_POST['SECTION_ID']) : false;
if($sectionId){
	$arSection = CAllcorp3Cache::CIBlockSection_GetList(
		array(
			'CACHE' => array(
				'MULTI' => 'N',
				'TAG' => CAllcorp3Cache::GetIBlockCacheTag($arParams['IBLOCK_ID'])
			)
		),
		array(
			'GLOBAL_ACTIVE' => 'Y',
			'ID' => $sectionId,
			'IBLOCK_ID' => $arParams['IBLOCK_ID']
		),
		false,
		array('ID')
	);

	$arItems = CAllcorp3Cache::CIBlockElement_GetList(
		array(
			"CACHE" => array("
				TAG" => CAllcorp3Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']),
				'URL_TEMPLATE' => $arParams['SEF_URL_TEMPLATES']['detail'],
			)
		),
		array_merge(
			$arItemFilter,
			array('SECTION_ID' => $sectionId)
		),
		false,
		false,
		$arItemSelect
	);

	$GLOBALS[$arParams['FILTER_NAME']]['SECTION_ID'] = $sectionId;
	$GLOBALS[$arParams['FILTER_NAME']]['INCLUDE_SUBSECTIONS'] = 'Y';
}
else{
	$arItems = CAllcorp3Cache::CIblockElement_GetList(
		array(
			"CACHE" => array(
				"TAG" => CAllcorp3Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']),
				'URL_TEMPLATE' => $arParams['SEF_URL_TEMPLATES']['detail'],
			)
		),
		$arItemFilter,
		false,
		false,
		$arItemSelect
	);
}

$itemsCnt = count($arItems);

CAllcorp3::CheckComponentTemplatePageBlocksParams($arParams, __DIR__);
?>
<?if($sectionId):?>
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

		$sViewElementsTemplate = ($arParams["SECTIONS_TYPE_VIEW"] == "FROM_MODULE" ? 'sections_'.$arTheme["PAGE_CONTACTS"]["VALUE"] : $arParams["SECTIONS_TYPE_VIEW"]);
		@include_once('page_blocks/'.$sViewElementsTemplate.'.php');

		if (CAllcorp3::checkAjaxRequest()){
			die();
		}
		?>
	<?endif;?>
<?else:?>
<?
$sViewElementsTemplate = ($arParams["SECTIONS_TYPE_VIEW"] == "FROM_MODULE" ? 'sections_'.$arTheme["PAGE_CONTACTS"]["VALUE"] : $arParams["SECTIONS_TYPE_VIEW"]);
@include_once('page_blocks/'.$sViewElementsTemplate.'.php');
?>
<?endif;?>
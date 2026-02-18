<?
global $is404, $bActiveTheme, $arSite, $isMenu, $isForm, $isBlog, $isCabinet, $isIndex, $isCatalog;
global $sMenuContent;
$sMenuContent = '';

$is404 = defined("ERROR_404") && ERROR_404 === "Y";
$bActiveTheme = ($arTheme["THEME_SWITCHER"]["VALUE"] == 'Y');
$arSite = CSite::GetByID(SITE_ID)->Fetch();
$isMenu = ($APPLICATION->GetProperty('MENU') !== "N" ? true : false);
$isForm = CSite::inDir(SITE_DIR.'form/');
$isBlog = (CSite::inDir(SITE_DIR.'articles/') || $APPLICATION->GetProperty("BLOG_PAGE") == "Y");
$isCabinet = CAllcorp3::isPersonalPage();
$isIndex = CAllcorp3::IsMainPage();
$isCatalog = CSite::InDir($arTheme["CATALOG_PAGE_URL"]["VALUE"]);

$GLOBALS['arrPopularSections'] = array('UF_SHOW_ON_INDEX_PAG' => 1);
$GLOBALS['arFrontFilter'] = array('PROPERTY_SHOW_ON_INDEX_PAGE_VALUE' => 'Y');
$GLOBALS['arFilterLeftBlock'] = array('PROPERTY_SHOW_ON_LEFT_BLOCK_VALUE' => 'Y');
$GLOBALS['arFilterBestItem'] = array('PROPERTY_BEST_ITEM_VALUE' => 'Y');
$GLOBALS['arRegionLinkFront'] = $GLOBALS['arRegionLink'] = [];

global $arRegion;
if($isIndex)
{
	$GLOBALS['arRegionLinkFront'] = array('PROPERTY_SHOW_ON_INDEX_PAGE_VALUE' => 'Y');
}

if($arRegion && $arTheme['USE_REGIONALITY']['DEPENDENT_PARAMS']['REGIONALITY_FILTER_ITEM']['VALUE'] == 'Y')
{
	$GLOBALS['arRegionLink'] = array('PROPERTY_LINK_REGION' => $arRegion['ID']);
	if($isIndex)
	{
		$GLOBALS['arRegionLinkFront'] = array_merge($GLOBALS['arRegionLinkFront'], $GLOBALS['arRegionLink']);
	}
}

<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
// need for solution class and variables
if (!include_once($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/vendor/php/solution.php')) {
	die(Json::encode(['error' => 'Error include solution constants']));
}

$codeBlock = 'YOUTUBE';
$indexType = TSolution::GetFrontParametrValue('INDEX_TYPE');
$blockType = TSolution::GetFrontParametrValue($indexType.'_'.$codeBlock.'_TEMPLATE');


if($arParams['WIDE'] === 'FROM_THEME'){
	$arParams['WIDE'] = TSolution::GetFrontParametrValue($indexType.'_'.$codeBlock.'_WIDE_'.$blockType);
}

if($arParams['ITEMS_OFFSET'] === 'FROM_THEME'){
	$arParams['ITEMS_OFFSET'] = TSolution::GetFrontParametrValue($indexType.'_'.$codeBlock.'_ITEMS_OFFSET_'.$blockType);
}

if($arParams['BORDERED'] === 'FROM_THEME'){
	$arParams['BORDERED'] = TSolution::GetFrontParametrValue($indexType.'_'.$codeBlock.'_BORDERED_'.$blockType);
}

if($arParams['COUNT_VIDEO_YOUTUBE'] === 'FROM_THEME'){
	$arParams['COUNT_VIDEO_YOUTUBE'] = TSolution::GetFrontParametrValue($indexType.'_'.$codeBlock.'_ELEMENTS_COUNT_'.$blockType);
} elseif($arParams['COUNT_VIDEO_YOUTUBE'] === 'FROM_SETTINGS_YOUTUBE') {
	$arParams['COUNT_VIDEO_YOUTUBE'] = TSolution::GetFrontParametrValue('COUNT_VIDEO_'.$codeBlock);
}

if($arParams['COUNT_VIDEO_ON_LINE_YOUTUBE'] === 'FROM_THEME'){
	$arParams['COUNT_VIDEO_ON_LINE_YOUTUBE'] = TSolution::GetFrontParametrValue($indexType.'_'.$codeBlock.'_ELEMENTS_COUNT_'.$blockType);
} elseif($arParams['COUNT_VIDEO_ON_LINE_YOUTUBE'] === 'FROM_SETTINGS_YOUTUBE') {
	$arParams['COUNT_VIDEO_ON_LINE_YOUTUBE'] = TSolution::GetFrontParametrValue('COUNT_VIDEO_ON_LINE_'.$codeBlock);
}

if($arParams['SHOW_TITLE'] === 'FROM_THEME'){
	$arParams['SHOW_TITLE'] = TSolution::GetFrontParametrValue('SHOW_TITLE_'.$codeBlock.'_'.$indexType);
}

if($arParams['TITLE_POSITION'] === 'FROM_THEME'){
	$arParams['TITLE_POSITION'] = TSolution::GetFrontParametrValue('TITLE_POSITION_'.$codeBlock.'_'.$indexType);
}

$arParams['RIGHT_TITLE'] = TSolution::GetFrontParametrValue('YOTUBE_TITLE_ALL_BLOCK');

foreach($arParams as $code => $value) {
	if ( $value === 'FROM_THEME' && strpos($code, "~") === false ) {
		$arParams[$code] = TSolution::GetFrontParametrValue($code);
	}
}
$arParams['RIGHT_LINK_EXTERNAL'] = true;
?>

<?$APPLICATION->IncludeComponent(
	"aspro:youtube",
	"main",
	Array(
		"API_TOKEN_YOUTUBE" => $arParams['API_TOKEN_YOUTUBE'],
		"CHANNEL_ID_YOUTUBE" => $arParams['CHANNEL_ID_YOUTUBE'],
		"SORT_YOUTUBE" => $arParams['SORT_YOUTUBE'],
		"PLAYLIST_ID_YOUTUBE" => $arParams['PLAYLIST_ID_YOUTUBE'],
		"COUNT_VIDEO_YOUTUBE" => $arParams['COUNT_VIDEO_YOUTUBE'],
		"COUNT_VIDEO_ON_LINE_YOUTUBE" => $arParams['COUNT_VIDEO_ON_LINE_YOUTUBE'],
		"TITLE" => $arParams['TITLE'],
		"SHOW_TITLE" => $arParams['SHOW_TITLE']==="Y",
		"ITEMS_OFFSET" => $arParams['ITEMS_OFFSET'],
		"TITLE_POSITION" => $arParams['TITLE_POSITION'],
		"SUBTITLE" => $arParams['SUBTITLE'],
		"RIGHT_TITLE" => $arParams["RIGHT_TITLE"],
		"WIDE" => $arParams["WIDE"],
		"MOBILE_SCROLLED" => $arParams["MOBILE_SCROLLED"],
		"MAXWIDTH_WRAP" => $arParams["MAXWIDTH_WRAP"],
		"COMPOSITE_FRAME_MODE" => $arParams['COMPOSITE_FRAME_MODE'],
		"COMPOSITE_FRAME_TYPE" => $arParams['COMPOSITE_FRAME_TYPE'],
		"CACHE_TYPE" => $arParams['CACHE_TYPE'],
		"CACHE_TIME" => $arParams['CACHE_TIME'],
		"CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
		"RIGHT_LINK_EXTERNAL" => $arParams['RIGHT_LINK_EXTERNAL'],
	)
);?>
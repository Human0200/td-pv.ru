<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? $this->setFrameMode(true); ?>
<?
$arItemFilter = TSolution::GetIBlockAllElementsFilter($arParams);
$itemsCnt = TSolution\Cache::CIblockElement_GetList(array("CACHE" => array("TAG" => TSolution\Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), $arItemFilter, array());
?>
<? if (!$itemsCnt): ?>
	<div class="alert alert-warning"><?= GetMessage("SECTION_EMPTY") ?></div>
<? else: ?>
	<? global $arTheme; ?>
	<? TSolution::CheckComponentTemplatePageBlocksParams($arParams, __DIR__); ?>

	<?// rss?>
	<?if($arParams['USE_RSS'] !== 'N'):?>
		<?$this->SetViewTarget('cowl_buttons');?>
		<?TSolution\Functions::ShowRSSIcon(
			array(
				'URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['rss']
			)
		);?>
		<?$this->EndViewTarget();?>
	<?endif;?>

	<? // section elements?>
	<? if (strlen($arParams["FILTER_NAME"])): ?>
		<? $GLOBALS[$arParams["FILTER_NAME"]] = array_merge((array)$GLOBALS[$arParams["FILTER_NAME"]], $arItemFilter); ?>
	<? else: ?>
		<? $arParams["FILTER_NAME"] = "arrFilter"; ?>
		<? $GLOBALS[$arParams["FILTER_NAME"]] = $arItemFilter; ?>
	<? endif; ?>
	<div class="text_before_items">
	<? $APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		array(
			"AREA_FILE_SHOW" => "page",
			"AREA_FILE_SUFFIX" => "inc",
			"EDIT_TEMPLATE" => ""
		)
	); ?>
	</div>
	<? $sViewElementsTemplate = ($arParams["SECTION_ELEMENTS_TYPE_VIEW"] == "FROM_MODULE" ? $arTheme["BRANDS_PAGE"]["VALUE"] : $arParams["SECTION_ELEMENTS_TYPE_VIEW"]); ?>
	<? @include_once('page_blocks/' . $sViewElementsTemplate . '.php'); ?>
<? endif; ?>
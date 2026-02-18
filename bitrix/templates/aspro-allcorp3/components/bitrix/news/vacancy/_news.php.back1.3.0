<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$this->setFrameMode(true);

$arItemFilter = TSolution::GetIBlockAllElementsFilter($arParams);
$arItemFilter['SECTION_GLOBAL_ACTIVE'] = 'Y';
$itemsCnt = TSolution\Cache::CIblockElement_GetList(['CACHE' => ['TAG' => TSolution\Cache::GetIBlockCacheTag($arParams['IBLOCK_ID'])]], $arItemFilter, []);
?>
<? if (!$itemsCnt): ?>
	<div class="alert alert-warning"><?= Loc::getMessage('SECTION_EMPTY') ?></div>
<? else: ?>
	<?
	global $arTheme;
	TSolution::CheckComponentTemplatePageBlocksParams($arParams, __DIR__);
	?>

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

	<?
	// section elements
	if (strlen($arParams['FILTER_NAME'])) {
		$GLOBALS[$arParams['FILTER_NAME']] = array_merge((array)$GLOBALS[$arParams['FILTER_NAME']], $arItemFilter);
	} else {
		$arParams['FILTER_NAME'] = 'arrFilter';
		$GLOBALS[$arParams['FILTER_NAME']] = $arItemFilter;
	}

	if ($arParams['SHOW_TOP_VACANCY_BLOCK'] == 'Y') {
		include('include_top_block.php');
	}
	?>

	<? $sViewElementsTemplate = ($arParams['SECTION_ELEMENTS_TYPE_VIEW'] == 'FROM_MODULE' ? $arTheme['VACANCY_PAGE']['VALUE'] : $arParams['SECTION_ELEMENTS_TYPE_VIEW']); ?>
	<? @include_once('page_blocks/' . $sViewElementsTemplate . '.php'); ?>
<? endif; ?>
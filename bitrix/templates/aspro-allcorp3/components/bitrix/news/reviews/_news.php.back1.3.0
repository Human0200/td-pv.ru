<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

use \Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);

Loc::loadMessages(__FILE__);

$arItemFilter = TSolution::GetIBlockAllElementsFilter($arParams);
$arItemFilter[] = [
	'LOGIC' => 'OR',
	[
		'!PROPERTY_LINK_STAFF' => false,
		'PROPERTY_SHOW_IN_LIST_VALUE' => 'Y',
	],
	[
		'PROPERTY_LINK_STAFF' => false,
	]
];
$itemsCnt = TSolution\Cache::CIblockElement_GetList(['CACHE' => ['TAG' => TSolution\Cache::GetIBlockCacheTag($arParams['IBLOCK_ID'])]], $arItemFilter, []);
$GLOBALS[$arParams['FILTER_NAME']] = $arItemFilter;

// feedback form button
TSolution\Functions::showBlockHtml([
	'FILE' => 'review/review_button.php',
	'PARAMS' => [
		'FORM_ID' => 'feedback',
		'BUTTON_TITLE' => ($arParams['S_FEEDBACK'] ?: Loc::getMessage('REVIEWS__BTN__SEND')),
		'DESCRIPTION' => Loc::getMessage('REVIEWS__DESCRIPTION'),
	],
]);
?>

<? if (!$itemsCnt): ?>
	<div class="alert alert-warning"><?= Loc::getMessage('REVIEWS__SECTION_EMPTY') ?></div>
<? else : ?>
	<?TSolution::CheckComponentTemplatePageBlocksParams($arParams, __DIR__);?>
	<?// section elements?>
	<?@include_once('page_blocks/'.$arParams["SECTION_ELEMENTS_TYPE_VIEW"].'.php');?>
<? endif ?>


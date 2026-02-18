<?php
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
global $arTheme, $APPLICATION;

CJSCore::Init('aspro_fancybox');

$arExtensions = ['catalog_detail', 'gallery'];

if (
    $templateData['CURRENT_SKU']
    && $arParams['CHANGE_TITLE_ITEM_DETAIL'] === 'Y'
) {
    $GLOBALS['currentOffer'] = $templateData['CURRENT_SKU'];
}

// top banner
TSolution\Banner\Transparency::setHeaderClasses($templateData);

// can order?
$bOrderViewBasket = $templateData['ORDER'];

if ($arParams['DISPLAY_COMPARE'] || $arParams['ORDER_VIEW']) {
    $arExtensions[] = 'item_action';
}

if ($arExtensions) {
    TSolution\Extensions::init($arExtensions);
}

// use tabs?
if ($arParams['USE_DETAIL_TABS'] === 'Y') {
    $bUseDetailTabs = true;
} elseif ($arParams['USE_DETAIL_TABS'] === 'N') {
    $bUseDetailTabs = false;
} else {
    $bUseDetailTabs = $arTheme['USE_DETAIL_TABS']['VALUE'] != 'N';
}

// blocks order
$arTabOrder = [];
if (
    !$bUseDetailTabs
    && array_key_exists('DETAIL_BLOCKS_ALL_ORDER', $arParams)
    && $arParams['DETAIL_BLOCKS_ALL_ORDER']
) {
    $arBlockOrder = explode(',', $arParams['DETAIL_BLOCKS_ALL_ORDER']);
} else {
    $arBlockOrder = explode(',', $arParams['DETAIL_BLOCKS_ORDER']);
    $arTabOrder = explode(',', $arParams['DETAIL_BLOCKS_TAB_ORDER']);
}

$arEpilogBlocks = new TSolution\Template\Epilog\Blocks(
    arBlocks: ['ORDERED' => $arBlockOrder, 'TABS' => ($arTabOrder ?? [])],
    templatePath: __DIR__,
    customBlocks: ($customBlocks ?? null)
);
?>
<div class="catalog-detail__bottom-info">
    <?foreach ($arEpilogBlocks->beforeOrdered as $path):?>
        <?include $path;?>
    <?endforeach;?>

    <?foreach ($arEpilogBlocks->ordered as $code => $path):?>
        <?include $path;?>
    <?endforeach;?>
</div>

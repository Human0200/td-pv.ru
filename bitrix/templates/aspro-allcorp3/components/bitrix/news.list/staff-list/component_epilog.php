<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

if ($templateData['VIEW_TYPE']) {
    $APPLICATION->oAsset->addCss($templateData['TEMPLATE_FOLDER'].'/types/css/'.$templateData['VIEW_TYPE'].'.css');
}

$arExtensions = [];
if ($templateData['ITEMS']) {
    $APPLICATION->oAsset->addCss($templateData['TEMPLATE_FOLDER'].'/assets/css/slider.css');
    $arExtensions[] = 'swiper';
} else {
    $GLOBALS['APPLICATION']->SetPageProperty('BLOCK_STAFF', 'hidden');
}

if ($arExtensions) {
    TSolution\Extensions::init($arExtensions);
}

<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

$arExtensions = [];
if ($templateData['ITEMS']) {
    $APPLICATION->oAsset->addCss($templateData['TEMPLATE_FOLDER'].'/assets/css/slider.css');
    $arExtensions[] = 'swiper';
} else {
    $GLOBALS['APPLICATION']->SetPageProperty('BLOCK_REVIEWS', 'hidden');
}

if ($arExtensions) {
    TSolution\Extensions::init($arExtensions);
}

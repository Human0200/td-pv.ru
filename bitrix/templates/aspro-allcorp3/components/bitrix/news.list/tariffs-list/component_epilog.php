<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

$arExtensions = [];
if (
    $templateData['ITEMS']
    && $templateData['IS_SLIDER']
) {
    $APPLICATION->oAsset->addCss($templateData['TEMPLATE_FOLDER'].'/assets/css/slider.css');
    $arExtensions[] = 'swiper';
}
if ($arExtensions) {
    TSolution\Extensions::init($arExtensions);
}

<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

$arExtensions = [];
if (isset($templateData['ITEMS'])) {
    $arExtensions[] = 'swiper';
}
if ($arExtensions) {
    TSolution\Extensions::init($arExtensions);
}

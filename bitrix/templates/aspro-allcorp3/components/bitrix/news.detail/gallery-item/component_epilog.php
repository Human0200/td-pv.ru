<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

$arExtensions = [];
if ($templateData['ITEMS']) {
    $arExtensions = array_merge($arExtensions, ['swiper', 'fancybox', 'gallery']);
}

if ($arExtensions) {
    TSolution\Extensions::init($arExtensions);
}

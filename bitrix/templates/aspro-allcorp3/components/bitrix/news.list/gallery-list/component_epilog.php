<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}
$arExtensions = [];

if($arParams['SLIDER'] === true){
    $arExtensions[] = 'swiper';
    $GLOBALS['APPLICATION']->oAsset->addCss($templateData['TEMPLATE_FOLDER'].'/assets/css/slider.css');
}

if($arParams['ITEMS_TYPE'] === 'PHOTOS'){
    $arExtensions = array_merge($arExtensions, ['fancybox', 'gallery']);
}

if ($arExtensions) {
    TSolution\Extensions::init($arExtensions);
}
?>

<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arExtensions = [];
if ($templateData['ITEMS']) {
    $arExtensions[] = 'fancybox';
    $arExtensions[] = 'gallery';
}

if ($arExtensions) {
    TSolution\Extensions::init($arExtensions);
}

?>

<?
if (!$templateData['ITEMS']) {
	$GLOBALS['APPLICATION']->SetPageProperty('BLOCK_BRANDS', 'hidden');
}

$arExtensions = ['swiper'];
if ($arExtensions) {
	\Aspro\Allcorp3\Functions\Extensions::init($arExtensions);
}
?>
<?
if ($arParams['TYPE_BLOCK'] != 'IMG_BOTTOM') {
	if ($arResult['DISPLAY_PROPERTIES']['IMG2']['VALUE']) {
		$arResult['FIELDS']['PREVIEW_PICTURE'] = CFile::getFileArray($arResult['DISPLAY_PROPERTIES']['IMG2']['VALUE']);
	}
}
if ($arParams['TYPE_BLOCK'] === 'IMG_SIDE2') {
	$arParams['IMAGE_WIDE'] = 'N';
}
?>
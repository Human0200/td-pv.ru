<?
foreach($arResult['ITEMS'] as $key => $arItem){
	CAllcorp3::getFieldImageData($arResult['ITEMS'][$key], array('PREVIEW_PICTURE'));
}
?>
<?
foreach($arResult['ITEMS'] as $key => $arItem){
	CAllcorp3::getFieldImageData($arResult['ITEMS'][$key], array('PREVIEW_PICTURE'));
}

if($arParams['SLIDER']){
	$arParams['DISPLAY_BOTTOM_PAGER'] = false;
}
?>
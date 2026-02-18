<?
foreach($arResult['ITEMS'] as $key => &$arItem){
	$arItem['DETAIL_PAGE_URL'] = CAllcorp3::FormatNewsUrl($arItem);

	CAllcorp3::getFieldImageData($arResult['ITEMS'][$key], array('PREVIEW_PICTURE'));
}
unset($arItem);
?>
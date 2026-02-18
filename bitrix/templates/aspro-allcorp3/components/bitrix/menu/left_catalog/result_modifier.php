<?
$arResult = CAllcorp3::getChilds2($arResult);
global $arTheme;
$MENU_TYPE = $arTheme['MEGA_MENU_TYPE']['VALUE'];

if ($MENU_TYPE == 3) {
	CAllcorp3::replaceMenuChilds($arResult, $arParams);
}
?>
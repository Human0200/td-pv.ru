<?php
$bLinkedMode = (isset($arParams['LINKED_MODE']) && $arParams['LINKED_MODE'] == 'Y');
$arSectionsIDs = [];

foreach($arResult['ITEMS'] as $arItem){
	if(!$bLinkedMode){
		if($SID = $arItem['IBLOCK_SECTION_ID']){
			$arSectionsIDs[] = $SID;
		}
	}
}

if ($arSectionsIDs) {
	$arResult['SECTIONS'] = TSolution\Cache::CIBLockSection_GetList(array('SORT' => 'ASC', 'NAME' => 'ASC', 'CACHE' => array('TAG' => TSolution\Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'GROUP' => array('ID'), 'MULTI' => 'N')), array('ID' => $arSectionsIDs));
}

if($arResult['SECTIONS']){
	$arItemSectionsIDs = array_column($arResult['SECTIONS'], 'ID');
}

if(!$arItemSectionsIDs) {
	$bLinkedMode = true;
}

$arParams['SHOW_NAVIGATION_PAGER'] = 'N';
$arParams['LINKED_MODE'] = $bLinkedMode ? 'Y' : 'N';
if($bLinkedMode) {
	$arParams['SHOW_NAVIGATION_PAGER'] = 'Y';
}

foreach ($arResult['ITEMS'] as $arItem) {
	$SID = ($arItem['IBLOCK_SECTION_ID'] && !$bLinkedMode ? $arItem['IBLOCK_SECTION_ID'] : 0);

	$arResult['SECTIONS'][$SID]['ITEMS'][$arItem['ID']] = $arItem;

}


if(is_array($arResult['SECTIONS'])){
	foreach($arResult['SECTIONS'] as $i => $arSection){
		if(!$arSection['ITEMS']){
			unset($arResult['SECTIONS'][$i]);
		}
	}

    ksort($arResult['SECTIONS']);
}
?>

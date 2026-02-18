<?php
$bLinkedMode = (isset($arParams['LINKED_MODE']) && $arParams['LINKED_MODE'] == 'Y');

foreach($arResult['ITEMS'] as $arItem){
	if(!$bLinkedMode){
		if($SID = $arItem['IBLOCK_SECTION_ID']){
			$arSectionsIDs[] = $SID;
		}
	}
}

if ($arSectionsIDs) {
	$arResult['SECTIONS'] = CAllcorp3Cache::CIBLockSection_GetList(array('SORT' => 'ASC', 'NAME' => 'ASC', 'CACHE' => array('TAG' => CAllcorp3Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'GROUP' => array('ID'), 'MULTI' => 'N')), array('ID' => $arSectionsIDs));
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

	if ($arItem['PROPERTIES']) {
		$arItem['CONTACT_PROPERTIES'] = [];

		foreach ($arItem['PROPERTIES'] as $propertyCode => $property) {
			if ($propertyCode == 'PHONE' && $arItem['DISPLAY_PROPERTIES'][$propertyCode] && $property['VALUE']) {
				$tel = $property['VALUE'] ? preg_replace('/[^\d]/', '', $property['VALUE']) : '';
				$arItem['CONTACT_PROPERTIES'][$propertyCode] = [
					'NAME' => $property['NAME'],
					'VALUE' => $property['VALUE'],
					'TYPE' => 'LINK',
					'HREF' => 'tel:+' . $tel,
					'ATTR' => '',
					'SORT' => 100,
				];
			}

			if ($propertyCode == 'SITE' && $arItem['DISPLAY_PROPERTIES'][$propertyCode] && $property['VALUE']) {
				$value = preg_replace('#(http|https)(://)|((\?.*)|(\/\?.*))#', '', $property['VALUE']);
				$arItem['CONTACT_PROPERTIES'][$propertyCode] = [
					'NAME' => $property['NAME'],
					'VALUE' => $value,
					'TYPE' => 'LINK',
					'HREF' =>  $property['VALUE'],
					'ATTR' => 'target="_blank"',
					'SORT' => 200,
				];
			}

			if ($propertyCode == 'EMAIL' && $arItem['DISPLAY_PROPERTIES'][$propertyCode] && $property['VALUE']) {
				$mailto = $property['VALUE'];
				$arItem['CONTACT_PROPERTIES'][$propertyCode] = [
					'NAME' => $property['NAME'],
					'VALUE' => $property['VALUE'],
					'TYPE' => 'LINK',
					'HREF' => 'mailto:' . $mailto,
					'ATTR' => '',
					'SORT' => 300,
				];
			}
		}

		if($arItem['CONTACT_PROPERTIES']) {
			usort($arItem['CONTACT_PROPERTIES'], function($a, $b) {
				return ($a['SORT'] > $b['SORT']);
			});
		}
	}

	if(in_array($arItem['IBLOCK_SECTION_ID'], (array)$arItemSectionsIDs) || $bLinkedMode){
		$arResult['SECTIONS'][$SID]['ITEMS'][$arItem['ID']] = $arItem;
	}
}

// unset empty sections
if(is_array($arResult['SECTIONS'])){
	foreach($arResult['SECTIONS'] as $i => $arSection){
		if(!$arSection['ITEMS']){
			unset($arResult['SECTIONS'][$i]);
		}
	}
}
?>
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
					'SORT' => 100,
				];
			}

			if ($propertyCode == 'EMAIL' && $arItem['DISPLAY_PROPERTIES'][$propertyCode] && $property['VALUE']) {
				$mailto = $property['VALUE'];
				$arItem['CONTACT_PROPERTIES'][$propertyCode] = [
					'NAME' => $property['NAME'],
					'VALUE' => $property['VALUE'],
					'TYPE' => 'LINK',
					'HREF' => 'mailto:' . $mailto,
					'SORT' => 200,
				];
			}

			if ($arParams['USE_SHARE'] == 'Y' && strpos($propertyCode, 'SOCIAL') !== false && $property['VALUE']) {
				$socialCode = str_replace('SOCIAL_', '', $propertyCode);
				$arItem['SOCIAL_PROPERTIES'][$propertyCode] = [
					'VALUE' => $property['VALUE'],
					'CODE' => $socialCode,
					'PATH' => SITE_TEMPLATE_PATH. '/images/svg/social/' . $socialCode . '.svg',
				];
			}
		}

		if($arItem['CONTACT_PROPERTIES']) {
			usort($arItem['CONTACT_PROPERTIES'], function($a, $b) {
				return ($a['SORT'] > $b['SORT']);
			});
		}
	}

	if(in_array($arItem['IBLOCK_SECTION_ID'], $arItemSectionsIDs) || $bLinkedMode){
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
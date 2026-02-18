<?php
$bLinkedMode = (isset($arParams['LINKED_MODE']) && $arParams['LINKED_MODE'] == 'Y');

foreach ($arResult['ITEMS'] as $arItem) {
	if (!$bLinkedMode) {
		if ($SID = $arItem['IBLOCK_SECTION_ID']) {
			$arSectionsIDs[] = $SID;
		}
	}
}

if ($arSectionsIDs) {
	$arResult['SECTIONS'] = CAllcorp3Cache::CIBLockSection_GetList(array('SORT' => 'ASC', 'NAME' => 'ASC', 'CACHE' => array('TAG' => CAllcorp3Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'GROUP' => array('ID'), 'MULTI' => 'N')), array('ID' => $arSectionsIDs));
}

if ($arResult['SECTIONS']) {
	$arItemSectionsIDs = array_column((array)$arResult['SECTIONS'], 'ID');
}

if (!$arItemSectionsIDs) {
	$bLinkedMode = true;
}

$arParams['SHOW_NAVIGATION_PAGER'] = 'N';
$arParams['LINKED_MODE'] = $bLinkedMode ? 'Y' : 'N';
if ($bLinkedMode && $arParams['DISPLAY_BOTTOM_PAGER']) {
	$arParams['SHOW_NAVIGATION_PAGER'] = 'Y';
}

foreach ($arResult['ITEMS'] as $arItem) {
	$SID = ($arItem['IBLOCK_SECTION_ID'] && !$bLinkedMode ? $arItem['IBLOCK_SECTION_ID'] : 0);

	if ($arItem['PROPERTIES']) {
		$arItem['CONTACT_PROPERTIES'] = [];

		foreach ($arItem['DISPLAY_PROPERTIES'] as $propertyCode => $property) {
			if($propertyCode == 'PAY') {
				continue;
			}

			if ($propertyCode == 'QUALITY' && $property['VALUE']) {
				$arItem['CONTACT_PROPERTIES'][$propertyCode] = [
					'NAME' => $property['NAME'],
					'VALUE' => $property['NAME'] . ': ' . $property['DISPLAY_VALUE'],
					'TYPE' => 'TEXT',
					'HREF' => '',
					'ATTR' => '',
					'SORT' => $property['SORT'],
				];

				continue;
			}

			$arItem['CONTACT_PROPERTIES'][$propertyCode] = [
				'NAME' => $property['NAME'],
				'VALUE' => $property['DISPLAY_VALUE'],
				'TYPE' => 'TEXT',
				'HREF' => '',
				'ATTR' => '',
				'SORT' => $property['SORT'],
			];
		}

		if ($arItem['CONTACT_PROPERTIES']) {
			usort($arItem['CONTACT_PROPERTIES'], function ($a, $b) {
				return ($a['SORT'] > $b['SORT']);
			});
		}
	}

	if (in_array($arItem['IBLOCK_SECTION_ID'], (array)$arItemSectionsIDs) || $bLinkedMode) {
		$arResult['SECTIONS'][$SID]['ITEMS'][$arItem['ID']] = $arItem;
	}
}

// unset empty sections
if (is_array($arResult['SECTIONS'])) {
	foreach ($arResult['SECTIONS'] as $i => $arSection) {
		if (!$arSection['ITEMS']) {
			unset($arResult['SECTIONS'][$i]);
		}
	}
}
?>
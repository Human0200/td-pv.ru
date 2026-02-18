<?php

$arResult['CONTACT_PROPERTIES'] = [];

foreach ($arResult['PROPERTIES'] as $propertyCode => $property) {
	if ($propertyCode == 'PHONE' && $arResult['DISPLAY_PROPERTIES'][$propertyCode] && $property['VALUE']) {
		$tel = $property['VALUE'] ? preg_replace('/[^\d]/', '', $property['VALUE']) : '';
		$arResult['CONTACT_PROPERTIES'][$propertyCode] = [
			'NAME' => $property['NAME'],
			'VALUE' => $property['VALUE'],
			'TYPE' => 'LINK',
			'HREF' => 'tel:+' . $tel,
			'SORT' => 100,
		];
	}

	if ($propertyCode == 'EMAIL' && $arResult['DISPLAY_PROPERTIES'][$propertyCode] && $property['VALUE']) {
		$mailto = $property['VALUE'];
		$arResult['CONTACT_PROPERTIES'][$propertyCode] = [
			'NAME' => $property['NAME'],
			'VALUE' => $property['VALUE'],
			'TYPE' => 'LINK',
			'HREF' => 'mailto:' . $mailto,
			'SORT' => 200,
		];
	}

	if ($arParams['USE_SHARE'] == 'Y' && strpos($propertyCode, 'SOCIAL') !== false && $property['VALUE']) {
		$socialCode = str_replace('SOCIAL_', '', $propertyCode);
		$arResult['SOCIAL_PROPERTIES'][$propertyCode] = [
			'VALUE' => $property['VALUE'],
			'CODE' => $socialCode,
			'PATH' => SITE_TEMPLATE_PATH . '/images/svg/social/' . $socialCode . '.svg',
		];
	}
}

if ($arResult['CONTACT_PROPERTIES']) {
	usort($arResult['CONTACT_PROPERTIES'], function ($a, $b) {
		return ($a['SORT'] > $b['SORT']);
	});
}

$arResult['IMAGE'] = null;

if ($arParams['DISPLAY_PICTURE'] != "N") {
	$pictureField = ($arResult['FIELDS']['DETAIL_PICTURE'] ? 'DETAIL_PICTURE' : 'PREVIEW_PICTURE');
	CAllcorp3::getFieldImageData($arResult, [$pictureField]);
	$picture = $arResult[$pictureField];
	$preview = CFile::ResizeImageGet($picture['ID'], ['width' => 500, 'height' => 500], BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
	if ($picture) {
		$arResult['IMAGE'] = [
			'DETAIL_SRC' => $picture['SRC'],
			'PREVIEW_SRC' => $preview['src'],
			'TITLE' => (strlen($picture['DESCRIPTION']) ? $picture['DESCRIPTION'] : (strlen($picture['TITLE']) ? $picture['TITLE'] : $arResult['NAME'])),
			'ALT' => (strlen($picture['DESCRIPTION']) ? $picture['DESCRIPTION'] : (strlen($picture['ALT']) ? $picture['ALT'] : $arResult['NAME'])),
		];
	}
}
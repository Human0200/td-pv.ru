<?php
foreach ($arResult['PROPERTIES'] as $propertyCode => $property) {
	if ($propertyCode == 'PHONE' && $arResult['DISPLAY_PROPERTIES'][$propertyCode] && $property['VALUE']) {
		$tel = $property['VALUE'] ? preg_replace('/[^\d]/', '', $property['VALUE']) : '';
		$arResult['CONTACT_PROPERTIES'][$propertyCode] = [
			'NAME' => $property['NAME'],
			'VALUE' => $property['VALUE'],
			'TYPE' => 'LINK',
			'HREF' => 'tel:+' . $tel,
			'ATTR' => '',
			'SORT' => 100,
		];

		continue;
	}

	if ($propertyCode == 'SITE' && $arResult['DISPLAY_PROPERTIES'][$propertyCode] && $property['VALUE']) {
		$value = preg_replace('#(http|https)(://)|((\?.*)|(\/\?.*))#', '', $property['VALUE']);
		$arResult['CONTACT_PROPERTIES'][$propertyCode] = [
			'NAME' => $property['NAME'],
			'VALUE' => $value,
			'TYPE' => 'LINK',
			'HREF' => $property['VALUE'],
			'ATTR' => 'target="_blank"',
			'SORT' => 200,
		];

		continue;
	}

	if ($propertyCode == 'EMAIL' && $arResult['DISPLAY_PROPERTIES'][$propertyCode] && $property['VALUE']) {
		$mailto = $property['VALUE'];
		$arResult['CONTACT_PROPERTIES'][$propertyCode] = [
			'NAME' => $property['NAME'],
			'VALUE' => $property['VALUE'],
			'TYPE' => 'LINK',
			'HREF' => 'mailto:' . $mailto,
			'ATTR' => '',
			'SORT' => 300,
		];
	}
}

if ($arResult['CONTACT_PROPERTIES']) {
	usort($arResult['CONTACT_PROPERTIES'], function ($a, $b) {
		return ($a['SORT'] > $b['SORT']);
	});
}

$arResult['IMAGE'] = null;
$pictureField = ($arResult['FIELDS']['DETAIL_PICTURE'] ? 'DETAIL_PICTURE' : 'PREVIEW_PICTURE');
CAllcorp3::getFieldImageData($arResult, [$pictureField]);
$picture = $arResult[$pictureField];
$preview = CFile::ResizeImageGet($picture['ID'], ['width' => 150, 'height' => 90], BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
if ($picture) {
	$arResult['IMAGE'] = [
		'DETAIL_SRC' => $picture['SRC'],
		'PREVIEW_SRC' => $preview['src'],
		'TITLE' => (strlen($picture['DESCRIPTION']) ? $picture['DESCRIPTION'] : (strlen($picture['TITLE']) ? $picture['TITLE'] : $arResult['NAME'])),
		'ALT' => (strlen($picture['DESCRIPTION']) ? $picture['DESCRIPTION'] : (strlen($picture['ALT']) ? $picture['ALT'] : $arResult['NAME'])),
	];
}

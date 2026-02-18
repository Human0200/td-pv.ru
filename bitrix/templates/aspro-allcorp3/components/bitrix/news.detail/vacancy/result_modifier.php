<?php

foreach ($arResult['DISPLAY_PROPERTIES'] as $propertyCode => $property) {
	$arResult['CONTACT_PROPERTIES'][$propertyCode] = [
		'NAME' => $property['NAME'],
		'VALUE' => $property['DISPLAY_VALUE'],
		'TYPE' => 'TEXT',
		'HREF' => '',
		'ATTR' => '',
		'SORT' => $property['SORT'],
	];
}

if ($arResult['CONTACT_PROPERTIES']) {
	usort($arResult['CONTACT_PROPERTIES'], function ($a, $b) {
		return ($a['SORT'] > $b['SORT']);
	});
}
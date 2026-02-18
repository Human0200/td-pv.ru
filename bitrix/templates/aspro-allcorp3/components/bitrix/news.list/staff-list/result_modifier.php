<?
foreach($arResult['ITEMS'] as $key => &$arItem){
	CAllcorp3::getFieldImageData($arResult['ITEMS'][$key], array('PREVIEW_PICTURE'));

	foreach($arItem['PROPERTIES'] as $propKey => $arProp) {
		if( strpos($propKey, 'SOCIAL_') !== false ) {
			if($arProp['VALUE']) {
				$socialCode = str_replace('SOCIAL_', '', $propKey);
				$arItem['SOCIAL_INFO'][$propKey] = array(
					'VALUE' => $arProp['VALUE'],
					'CODE' => $socialCode,
					'PATH' => SITE_TEMPLATE_PATH."/images/svg/social/".$socialCode.".svg",
				);
			}
		}
	}
}
unset($arItem);
?>
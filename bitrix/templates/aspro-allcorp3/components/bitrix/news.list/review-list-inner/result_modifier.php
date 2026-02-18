<?php
/**
 * Get Staff Items
 */
$staffLinkIblockId = null;
$staffElementIds = [];
if ($arResult['ITEMS']) {
	foreach ($arResult['ITEMS'] as $arItem) {

		if (isset($arItem['PROPERTIES']['STAFF']) && $arItem['PROPERTIES']['STAFF']['VALUE'] && $arItem['FIELDS']['DETAIL_TEXT']) {
			if (!$staffLinkIblockId) {
				$staffLinkIblockId = $arItem['PROPERTIES']['STAFF']['LINK_IBLOCK_ID'];
			}
		}
	}

	$staffList = CAllcorp3Cache::CIblockElement_GetList(['CACHE' => ['TAG' => CAllcorp3Cache::GetIBlockCacheTag('reviews_' . $staffLinkIblockId)]], [
		'IBLOCK_ID' => $staffLinkIblockId,
		'ID' => $staffElementIds,
	], false, false, ['ID', 'NAME', 'PREVIEW_PICTURE', 'PROPERTY_POST']);

	foreach ($staffList as $staff) {
		$previewPicture = null;
		if ($staff['PREVIEW_PICTURE']) {
			$previewPicture = CFile::ResizeImageGet($staff['PREVIEW_PICTURE'], ['width' => 40, 'height' => 40], BX_RESIZE_IMAGE_EXACT, true);
		}

		$arResult['STAFF'][$staff['ID']] = [
			'ID' => $staff['ID'],
			'PREVIEW_PICTURE_SRC' => $previewPicture['src'],
			'LABEL' => implode(', ', [$staff['NAME'], $staff['PROPERTY_POST_VALUE']]),
		];
	}
}
?>
<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();

$arParams = array_merge(
	array(
		'ROW_VIEW' => false,
		'BORDER' => false,
		'ITEM_HOVER_SHADOW' => false,
		'DARK_HOVER' => false,
		'ROUNDED' => true,
		'ROUNDED_IMAGE' => false,
		'ITEM_PADDING' => false,
		'ELEMENTS_ROW' => 4,
		'COMPACT' => false,
		'MAXWIDTH_WRAP' => false,
		'MOBILE_SCROLLED' => false,
		'NARROW' => false,
		'ITEMS_OFFSET' => true,
		'IMAGES' => 'ROUND_PICTURES',
		'IMAGE_POSITION' => 'TOP',
		'SHOW_PREVIEW' => true,
		'SHOW_CHILDS' => true,
		'SHOW_TITLE' => false,
		'TITLE_POSITION' => '',
		'TITLE' => '',
		'RIGHT_TITLE' => '',
		'RIGHT_LINK' => '',
		'NAME_SIZE' => 22,
		'SUBTITLE' => '',
		'SHOW_PREVIEW_TEXT' => 'N',
		'LINKED' => false,
		'IS_AJAX' => false,
	),
	$arParams
);

if (!$arParams['LINKED'] && !($arParams['FRONT_PAGE'] && !$arParams['SHOW_CHILDS'])) {
	$arRootItems = $arChildItems = array();
	
	foreach($arResult['SECTIONS'] as $key => $arSection){
		if($arSection['DEPTH_LEVEL'] == $arResult['SECTION']['DEPTH_LEVEL'] + 1){
			$arSection['ITEMS'] = array();
			$arRootItems[$arSection['ID']] = $arSection;
		}
		else{
			$arChildItems[$arSection['ID']] = $arSection;
		}
	
		unset($arResult['SECTIONS'][$key]);
	}
	
	if($arChildItems){
		foreach($arChildItems as $key => $arSection){
			$arRootSection = TSolution\Cache::CIBlockSection_GetList(array('SORT' => 'ASC','NAME' => 'ASC','CACHE' => array('MULTI' =>'N', 'TAG' => TSolution\Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']))), array('GLOBAL_ACTIVE' => 'Y', '<=LEFT_BORDER' => $arSection['LEFT_MARGIN'], '>=RIGHT_BORDER' => $arSection['RIGHT_MARGIN'], 'DEPTH_LEVEL' => $arResult['SECTION']['DEPTH_LEVEL'] + 1, 'IBLOCK_ID' => $arParams['IBLOCK_ID']), false, array('ID', 'NAME', 'IBLOCK_ID', 'SORT', 'SECTION_PAGE_URL', 'PICTURE', 'UF_TOP_SEO'));
			if(!isset($arRootItems[$arRootSection['ID']])){
				$arRootItems[$arRootSection['ID']] = $arRootSection;
			}
	
			$arRootItems[$arRootSection['ID']]['ITEMS'][] = $arSection;
		}
	}
	
	if($arParams['FRONT_PAGE'])
	{ 
		$arRootSection2ShowOnIndexPage = TSolution\Cache::CIBlockSection_GetList(
			array(
				'SORT' => 'ASC',
				'NAME' => 'ASC',
				'CACHE' => array(
					'TAG' => TSolution\Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']),
					'MULTI' => 'Y', 
					'RESULT' => array('ID'),
				)
			),
			array(
				'ID' => array_keys($arRootItems),
				'IBLOCK_ID' => $arParams['IBLOCK_ID'],
				'UF_SHOW_ON_INDEX_PAG' => true,
			),
			false,
			array(
				'ID',
				'IBLOCK_ID',
				'UF_SHOW_ON_INDEX_PAG',
			)
		);
	
		foreach($arRootItems as $sectionId => $arSection){
			if(!in_array($sectionId, $arRootSection2ShowOnIndexPage)){
				unset($arRootItems[$sectionId]);
			}
		}
	}
	
	\Bitrix\Main\Type\Collection::sortByColumn($arRootItems, array('SORT' => array(SORT_NUMERIC, SORT_ASC), 'NAME' => SORT_ASC));
	if(isset($arParams['TOP_SECTION_COUNT']) && $arParams['TOP_SECTION_COUNT']>0){
		$arRootItems = array_slice($arRootItems, 0, $arParams['TOP_SECTION_COUNT'], true);
	}
	$arResult['SECTIONS'] = $arRootItems;
}
else {
	\Bitrix\Main\Type\Collection::sortByColumn($arResult['SECTIONS'], array('SORT' => array(SORT_NUMERIC, SORT_ASC), 'NAME' => SORT_ASC));
}
?>
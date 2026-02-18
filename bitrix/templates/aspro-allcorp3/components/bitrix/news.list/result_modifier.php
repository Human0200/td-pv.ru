<?
use Bitrix\Main\Localization\Loc;

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();

$arParams = array_merge(
	array(
		'USE_DETAIL' => 'N',
		'VISIBLE_PROP_COUNT' => 4,
		'VIEW_TYPE' => 'type_1',
		'ROW_VIEW' => false,
		'BORDER' => true,
		'ITEM_HOVER_SHADOW' => true,
		'DARK_HOVER' => false,
		'ROUNDED' => true,
		'ROUNDED_IMAGE' => false,
		'ELEMENTS_ROW' => 4,
		'MAXWIDTH_WRAP' => false,
		'MOBILE_SCROLLED' => true,
		'NARROW' => false,
		'SLIDER' => true,
		'ITEMS_OFFSET' => true,
		'IMAGES' => 'BIG_PICTURES',
		'SHOW_PREVIEW' => true,
		'HIDE_PAGINATION' => 'Y',
		'TABS' => 'INSIDE',
		'DEFAULT_PRICE_KEY' => 'DEFAULT',
		'DEFAULT_ITEM_NAME' => '',
		'GRID_GAP' => '32',
		'SHOW_TITLE' => false,
		'SHOW_SECTION' => 'Y',
		'TITLE_POSITION' => '',
		'TITLE' => '',
		'RIGHT_TITLE' => '',
		'RIGHT_LINK' => '',
		'NAME_SIZE' => 20,
		'SUBTITLE' => '',
		'SHOW_PREVIEW_TEXT' => 'N',
		'IS_AJAX' => false,
	),
	$arParams
);

$arSections = $arSectionsIDs = array();

// $arHideProps = array('PRICE', 'FORM_ORDER', 'FILTER_PRICE');
// $arPlusValue = array('+', 1, 'true', 'y', GetMessage('YES'), GetMessage('TRUE'));
// $arMinusValue = array('-', 0, 'false', 'n', GetMessage('NO'), GetMessage('FALSE'));

if ($arParams['TABS'] === 'TOP') {
	// get all top tabs
	$arResult['TABS'] = TSolution\Property\TariffItem::collectTabs($arParams['IBLOCK_ID'], $arParams['FILTER_NAME']);

	if(strpos($arResult['NAV_STRING'], 'tariffs_price_key') === false){
		$arResult['NAV_STRING'] = str_replace('?', '?tariffs_price_key='.$arParams['DEFAULT_PRICE_KEY'].'&', $arResult['NAV_STRING']);
	}
}

$maxCntPeriod = 12;
$arParams['DEFAULT_PRICE_KEY'] = $arParams['DEFAULT_PRICE_KEY'] ?: 'DEFAULT';
$arParams['DEFAULT_ITEM_NAME'] = TSolution\Property\TariffItem::translit($arParams['DEFAULT_ITEM_NAME'] ?: '');
$arParams['DEFAULT_FALLBACK'] = $arParams['DEFAULT_FALLBACK'] ?? 'LAST';

$arInherites = [];
foreach($arResult['ITEMS'] as $key => &$arItem){
	$defaultPriceKey = $arParams['DEFAULT_PRICE_KEY'];
	$defaultItemName = $arParams['DEFAULT_ITEM_NAME'];
	$defaultFallback = $arParams['DEFAULT_FALLBACK'];

	if ($arParams['TABS'] !== 'TOP') {
		if (!isset($arInherites[$arItem['IBLOCK_SECTION_ID']])) {
			$arInherite = TSolution::getSectionInheritedUF(array(
				'sectionId' => $arItem['IBLOCK_SECTION_ID'],
				'iblockId' => $arItem['IBLOCK_ID'],
				'select' => array(
					'UF_DEFAULT_PRICE_KEY',
					'UF_DEFAULT_ITEM_NAME',
					'UF_DEFAULT_FALLBACK',
				),
				'filter' => array(
					'GLOBAL_ACTIVE' => 'Y', 
				),
				'enums' => array(
					'UF_DEFAULT_PRICE_KEY',
					'UF_DEFAULT_FALLBACK',
				),
			));

			$arInherites[$arItem['IBLOCK_SECTION_ID']] = $arInherite;
		}
		else {
			$arInherite = $arInherites[$arItem['IBLOCK_SECTION_ID']];
		}		

		if ($arInherite) {
			if (isset($arInherite['UF_DEFAULT_PRICE_KEY']) && $arInherite['UF_DEFAULT_PRICE_KEY']) {
				$defaultPriceKey = $arInherite['UF_DEFAULT_PRICE_KEY'];
			}
			
			if (isset($arInherite['UF_DEFAULT_ITEM_NAME']) && $arInherite['UF_DEFAULT_ITEM_NAME']) {
				$defaultItemName = $arInherite['UF_DEFAULT_ITEM_NAME'];
			}
		
			if (isset($arInherite['UF_DEFAULT_FALLBACK']) && $arInherite['UF_DEFAULT_FALLBACK']) {
				$defaultFallback = $arInherite['UF_DEFAULT_FALLBACK'];
			}
		}
	}

	$arItem['DETAIL_PAGE_URL'] = TSolution::FormatNewsUrl($arItem);

	$arItem['FORMAT_PROPS'] = $arItem['MIDDLE_PROPS'] = $arItem['PRICES'] = array();
	if($arItem['DISPLAY_PROPERTIES']){
		$arItem['HAS_ITEMS'] = false;
		if ($arItem['DISPLAY_PROPERTIES']['TARIF_ITEM']) {
			$arItem['DISPLAY_PROPERTIES']['TARIF_ITEM']['VALUE'] = TSolution\Property\TariffItem::decodePropertyValue($arItem['DISPLAY_PROPERTIES']['TARIF_ITEM']['VALUE']);
			$arItem['HAS_ITEMS'] = (boolean)$arItem['DISPLAY_PROPERTIES']['TARIF_ITEM']['VALUE'];
		}

		// price currency
		$arItem['CURRENCY'] = isset($arItem['PROPERTIES']['PRICE_CURRENCY']) ? $arItem['PROPERTIES']['PRICE_CURRENCY']['VALUE'] : '';

		// min period price (one month)
		if(
			isset($arItem['PROPERTIES']['TARIF_PRICE_1']) &&
			strlen($arItem['PROPERTIES']['TARIF_PRICE_1']['VALUE'])
		){
			$priceOldOne = str_replace('#CURRENCY#', $arItem['CURRENCY'], $arItem['PROPERTIES']['TARIF_PRICE_1']['VALUE']);
		}
		else{
			$priceOldOne = false;
		}

		foreach($arItem['DISPLAY_PROPERTIES'] as $key2 => &$arProp){
			if(
				$arProp['VALUE'] ||
				strlen($arProp['VALUE'])
			){
				if(($key2 === 'MULTI_PROP' || $key2 === 'MULTI_PROP_BOTTOM_PROPS')){
					$arItem['MIDDLE_PROPS'][$key2] = $arProp;
					unset($arItem['DISPLAY_PROPERTIES'][$key2]);
				}
				elseif(strpos($key2, 'TARIF_PRICE') !== false){
					if(
						!$arItem['HAS_ITEMS'] &&
						strpos($key2, '_DISC') === false &&
						strpos($key2, '_ECONOMY') === false &&
						strpos($key2, '_ONE') === false
					){
						$arPropCode = explode('_', $key2);
						$propKey = $arProp['KEY'] = $arPropCode[count($arPropCode) - 1];

						// price title
						$priceTitle = str_replace(Loc::getMessage('REPLACE_PRICE_NAME'), '', $arProp['NAME']);
						$priceTitle = str_replace(
							array(
								Loc::getMessage('REPLACE_MONTH6'),
								Loc::getMessage('REPLACE_MONTH2'),
								Loc::getMessage('REPLACE_MONTH1'),
							),
							Loc::getMessage('REPLACE_MONTH_SHORT'),
							$priceTitle
						);
						$priceTitle = str_replace(Loc::getMessage('REPLACE_ONE_YEAR'), Loc::getMessage('REPLACE_YEAR'), $priceTitle);

						// period count
						$cntPeriods =  $propKey == 1 ? 1 : ($propKey == 2 ? 3 : ($propKey == 3 ? 6 : $maxCntPeriod));

						// filter price
						$priceFilter = isset($arItem['PROPERTIES']['FILTER_PRICE_'.$propKey]) ? $arItem['PROPERTIES']['FILTER_PRICE_'.$propKey]['VALUE'] : false;

						// has discount
						$bDiscount = isset($arItem['PROPERTIES']['TARIF_PRICE_'.$propKey.'_DISC']);

						// old price without discount
						$priceOld = $bDiscount ? str_replace('#CURRENCY#', $arItem['CURRENCY'], $arProp['VALUE']) : false;

						// full price with discount
						if(
							$bDiscount &&
							strlen($arItem['PROPERTIES']['TARIF_PRICE_'.$propKey.'_DISC']['VALUE'])
						){
							$price = $arItem['PROPERTIES']['TARIF_PRICE_'.$propKey.'_DISC']['VALUE'];
						}
						else{
							$price = $arProp['VALUE'];
							$priceOld = false;
						}
						$price = str_replace('#CURRENCY#', $arItem['CURRENCY'], $price);

						// economy
						if(
							isset($arItem['PROPERTIES']['TARIF_PRICE_'.$propKey.'_ECONOMY']) &&
							strlen($arItem['PROPERTIES']['TARIF_PRICE_'.$propKey.'_ECONOMY']['VALUE'])
						){
							$economy = str_replace('#CURRENCY#', $arItem['CURRENCY'], $arItem['PROPERTIES']['TARIF_PRICE_'.$propKey.'_ECONOMY']['VALUE']);
						}
						else{
							$economy = false;
						}

						// price to one period
						if(
							isset($arItem['PROPERTIES']['TARIF_PRICE_'.$propKey.'_ONE']) &&
							strlen($arItem['PROPERTIES']['TARIF_PRICE_'.$propKey.'_ONE']['VALUE'])
						){
							$priceOne = str_replace('#CURRENCY#', $arItem['CURRENCY'], $arItem['PROPERTIES']['TARIF_PRICE_'.$propKey.'_ONE']['VALUE']);
						}
						else{
							$priceOne = false;
						}

						$arPrice = array(
							'TITLE' => $priceTitle,
							'CNT_PERIODS' => $cntPeriods,
							'FILTER_PRICE' => $priceFilter,
							'PRICE' => $price,
							'OLDPRICE' => $priceOld,
							'ECONOMY' => $economy,
							'PRICE_ONE' => $priceOne,
							'OLDPRICE_ONE' => ($cntPeriods > 1 && strlen($economy)) ? $priceOldOne : false,
							'DEFAULT' => $propKey === $defaultPriceKey, // !need strong ===
						);

						$arItem['PRICES'][$cntPeriods] = $arPrice;

						// default price
						if($propKey === $defaultPriceKey){ // !need strong ===
							$arItem['DEFAULT_PRICE'] = $arPrice;
						}
					}

					unset($arItem['DISPLAY_PROPERTIES'][$key2]);
				}
				elseif ($key2 === 'TARIF_ITEM') {
					foreach ($arProp['VALUE'] as $i => $value) {
						$itemTitle = $value['TITLE'];
						$price_key = TSolution\Property\TariffItem::translit($itemTitle);

						// filter price
						$priceFilter = $value['FILTER_PRICE'] ?: false;

						// old price without discount
						$priceOld = str_replace('#CURRENCY#', $arItem['CURRENCY'], $value['PRICE']);

						// full price with discount
						if(strlen($value['PRICE_DISCOUNT'])){
							$price = $value['PRICE_DISCOUNT'];
						}
						else{
							$price = $value['PRICE'];
							$priceOld = false;
						}
						$price = str_replace('#CURRENCY#', $arItem['CURRENCY'], $price);

						// economy
						if(strlen($value['ECONOMY'])){
							$economy = str_replace('#CURRENCY#', $arItem['CURRENCY'], $value['ECONOMY']);
						}
						else{
							$economy = false;
						}

						$arTariffItem = array(
							'TITLE' => $itemTitle,
							'KEY' => $price_key,
							'CNT_PERIODS' => 0,
							'FILTER_PRICE' => $priceFilter,
							'PRICE' => $price,
							'OLDPRICE' => $priceOld,
							'ECONOMY' => $economy,
							'DEFAULT' => $price_key === $defaultItemName,
						);

						$arItem['PRICES'][$price_key] = $arTariffItem;

						// default item
						if($price_key === $defaultItemName){
							$arItem['DEFAULT_PRICE'] = $arTariffItem;
						}
					}
				}
			}
		}
		unset($arProp);

		if($arItem['PRICES']){
			if (!$arItem['HAS_ITEMS']) {
				// sort prices by count of periods
				ksort($arItem['PRICES']);
			}

			if($arParams['TABS'] === 'TOP'){
				if($arItem['DEFAULT_PRICE']){
					if ($arItem['HAS_ITEMS']) {
						$arItem['PRICES'] = array($arItem['DEFAULT_PRICE']['KEY'] => $arItem['DEFAULT_PRICE']);
					}
					else {
						$arItem['PRICES'] = array($arItem['DEFAULT_PRICE']['CNT_PERIODS'] => $arItem['DEFAULT_PRICE']);
					}
				}
			}
			else{
				// no default price
				if (!$arItem['DEFAULT_PRICE']) {
					if ($defaultFallback === 'FIRST') {
						$firstKey = reset(array_keys($arItem['PRICES']));
						$arItem['PRICES'][$firstKey]['DEFAULT'] = true;
						$arItem['DEFAULT_PRICE'] = $arItem['PRICES'][$firstKey];
					}
					else {
						$lastKey = end(array_keys($arItem['PRICES']));
						$arItem['PRICES'][$lastKey]['DEFAULT'] = true;
						$arItem['DEFAULT_PRICE'] = $arItem['PRICES'][$lastKey];
					}
				}
			}
		}
	}

	$arItem['FORMAT_PROPS'] = TSolution::PrepareItemProps($arItem['DISPLAY_PROPERTIES']);

	TSolution::getFieldImageData($arItem, array('PREVIEW_PICTURE'));

	if($arItem['IBLOCK_SECTION_ID']){
		$dbRes = CIBlockElement::GetElementGroups($arItem['ID'], true, array('ID'));
		while($arSection = $dbRes->Fetch()){
			$arItem['SECTIONS'][$arSection['ID']] = $arSection['ID'];
			$arSectionsIDs[$arSection['ID']] = $arSection['ID'];
		}
	}
}
unset($arItem);

if($arSectionsIDs){
	$arSections = TSolution\Cache::CIBLockSection_GetList(
		array(
			'SORT' => 'ASC',
			'NAME' => 'ASC',
			'CACHE' => array(
				'TAG' => TSolution\Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']),
				'GROUP' => array('ID'),
				'MULTI' => 'N',
				'RESULT' => array('NAME')
			)
		),
		array('ID' => $arSectionsIDs),
		false,
		array(
			'ID',
			'NAME'
		)
	);

	foreach($arResult['ITEMS'] as $key => &$arItem){
		if($arItem['IBLOCK_SECTION_ID']){
			foreach($arItem['SECTIONS'] as $id => $name){
				$arItem['SECTIONS'][$id] = $arSections[$id];
			}
		}
	}
	unset($arItem);
}

if($arParams['HIDE_PAGINATION'] === 'Y'){
	unset($arResult['NAV_STRING']);
}
?>
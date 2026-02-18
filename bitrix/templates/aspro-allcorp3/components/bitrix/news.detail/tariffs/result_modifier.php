<?
use Bitrix\Main\Localization\Loc;

TSolution::getFieldImageData($arResult, array('DETAIL_PICTURE'));

// sef folder to include files
$sefFolder = rtrim($arParams["SEF_FOLDER"] ?? dirname($_SERVER['REAL_FILE_PATH']), '/');

// dops tab
if($arParams['SHOW_DOPS'] === 'Y'){
	$this->SetViewTarget('PRODUCT_DOPS_INFO');
	$APPLICATION->IncludeFile($sefFolder."/index_dops.php", array(), array("MODE" => "html", "NAME" => GetMessage('T_DOPS')));
	$this->EndViewTarget();
}

$arResult['CHARACTERISTICS'] = $arResult['VIDEO'] = $arResult['VIDEO_IFRAME'] = [];

/* docs property code */
$docsProp = $arParams['DETAIL_DOCS_PROP'] ? $arParams['DETAIL_DOCS_PROP'] : 'DOCUMENTS';

if(
	array_key_exists($docsProp, $arResult["DISPLAY_PROPERTIES"]) &&
	is_array($arResult["DISPLAY_PROPERTIES"][$docsProp]) &&
	$arResult["DISPLAY_PROPERTIES"][$docsProp]["VALUE"]
){
	foreach($arResult['DISPLAY_PROPERTIES'][$docsProp]['VALUE'] as $key => $value){
		if(!intval($value)){
			unset($arResult['DISPLAY_PROPERTIES'][$docsProp]['VALUE'][$key]);
		}
	}

	if($arResult['DISPLAY_PROPERTIES'][$docsProp]['VALUE']){
		$arResult['DOCUMENTS'] = array_values($arResult['DISPLAY_PROPERTIES'][$docsProp]['VALUE']);
	}
}

$maxCntPeriod = 12;
$arParams['DEFAULT_PRICE_KEY'] = $arParams['DEFAULT_PRICE_KEY'] ?: 'DEFAULT';
$arParams['DEFAULT_ITEM_NAME'] = TSolution\Property\TariffItem::translit($arParams['DEFAULT_ITEM_NAME'] ?: '');
$arParams['DEFAULT_FALLBACK'] = $arParams['DEFAULT_FALLBACK'] ?? 'LAST';

if($arResult['DISPLAY_PROPERTIES']){
	$arResult['HAS_ITEMS'] = false;
	if ($arResult['DISPLAY_PROPERTIES']['TARIF_ITEM']) {
		$arResult['DISPLAY_PROPERTIES']['TARIF_ITEM']['VALUE'] = TSolution\Property\TariffItem::decodePropertyValue($arResult['DISPLAY_PROPERTIES']['TARIF_ITEM']['VALUE']);
		$arResult['HAS_ITEMS'] = (boolean)$arResult['DISPLAY_PROPERTIES']['TARIF_ITEM']['VALUE'];
	}

	// price currency
	$arResult['CURRENCY'] = isset($arResult['PROPERTIES']['PRICE_CURRENCY']) ? $arResult['PROPERTIES']['PRICE_CURRENCY']['VALUE'] : '';

	// min period price (one month)
	if(
		isset($arResult['PROPERTIES']['TARIF_PRICE_1']) &&
		strlen($arResult['PROPERTIES']['TARIF_PRICE_1']['VALUE'])
	){
		$priceOldOne = str_replace('#CURRENCY#', $arResult['CURRENCY'], $arResult['PROPERTIES']['TARIF_PRICE_1']['VALUE']);
	}
	else{
		$priceOldOne = false;
	}

	$arResult['FORMAT_PROPS'] = $arResult['MIDDLE_PROPS'] = $arResult['PRICES'] = array();
	foreach($arResult['DISPLAY_PROPERTIES'] as $key2 => &$arProp){
		if(
			$arProp['VALUE'] ||
			strlen($arProp['VALUE'])
		){
			if(($key2 === 'MULTI_PROP' || $key2 === 'MULTI_PROP_BOTTOM_PROPS')){
				$arResult['MIDDLE_PROPS'][$key2] = $arProp;
				unset($arResult['DISPLAY_PROPERTIES'][$key2]);
			}
			elseif(strpos($key2, 'TARIF_PRICE') !== false){
				if(
					!$arResult['HAS_ITEMS'] &&
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
					$priceFilter = isset($arResult['PROPERTIES']['FILTER_PRICE_'.$propKey]) ? $arResult['PROPERTIES']['FILTER_PRICE_'.$propKey]['VALUE'] : false;

					// has discount
					$bDiscount = isset($arResult['PROPERTIES']['TARIF_PRICE_'.$propKey.'_DISC']);

					// old price without discount
					$priceOld = $bDiscount ? str_replace('#CURRENCY#', $arResult['CURRENCY'], $arProp['VALUE']) : false;

					// full price with discount
					if(
						$bDiscount &&
						strlen($arResult['PROPERTIES']['TARIF_PRICE_'.$propKey.'_DISC']['VALUE'])
					){
						$price = $arResult['PROPERTIES']['TARIF_PRICE_'.$propKey.'_DISC']['VALUE'];
					}
					else{
						$price = $arProp['VALUE'];
						$priceOld = false;
					}
					$price = str_replace('#CURRENCY#', $arResult['CURRENCY'], $price);

					// economy
					if(
						isset($arResult['PROPERTIES']['TARIF_PRICE_'.$propKey.'_ECONOMY']) &&
						strlen($arResult['PROPERTIES']['TARIF_PRICE_'.$propKey.'_ECONOMY']['VALUE'])
					){
						$economy = str_replace('#CURRENCY#', $arResult['CURRENCY'], $arResult['PROPERTIES']['TARIF_PRICE_'.$propKey.'_ECONOMY']['VALUE']);
					}
					else{
						$economy = false;
					}

					// price to one period
					if(
						isset($arResult['PROPERTIES']['TARIF_PRICE_'.$propKey.'_ONE']) &&
						strlen($arResult['PROPERTIES']['TARIF_PRICE_'.$propKey.'_ONE']['VALUE'])
					){
						$priceOne = str_replace('#CURRENCY#', $arResult['CURRENCY'], $arResult['PROPERTIES']['TARIF_PRICE_'.$propKey.'_ONE']['VALUE']);
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
						'DEFAULT' => $propKey === $arParams['DEFAULT_PRICE_KEY'], // !need strong ===
					);

					$arResult['PRICES'][$cntPeriods] = $arPrice;

					// default price
					if($propKey === $arParams['DEFAULT_PRICE_KEY']){ // !need strong ===
						$arResult['DEFAULT_PRICE'] = $arPrice;
					}
				}

				unset($arResult['DISPLAY_PROPERTIES'][$key2]);
			}
			elseif ($key2 === 'TARIF_ITEM') {
				foreach ($arProp['VALUE'] as $i => $value) {
					$itemTitle = $value['TITLE'];
					$price_key = TSolution\Property\TariffItem::translit($itemTitle);

					// filter price
					$priceFilter = $value['FILTER_PRICE'] ?: false;

					// old price without discount
					$priceOld = str_replace('#CURRENCY#', $arResult['CURRENCY'], $value['PRICE']);

					// full price with discount
					if(strlen($value['PRICE_DISCOUNT'])){
						$price = $value['PRICE_DISCOUNT'];
					}
					else{
						$price = $value['PRICE'];
						$priceOld = false;
					}
					$price = str_replace('#CURRENCY#', $arResult['CURRENCY'], $price);

					// economy
					if(strlen($value['ECONOMY'])){
						$economy = str_replace('#CURRENCY#', $arResult['CURRENCY'], $value['ECONOMY']);
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
						'DEFAULT' => $price_key === $arParams['DEFAULT_ITEM_NAME'],
					);

					$arResult['PRICES'][$price_key] = $arTariffItem;

					// default price
					if ($price_key === $arParams['DEFAULT_ITEM_NAME']) {
						$arResult['DEFAULT_PRICE'] = $arTariffItem;
					}
				}
			}
			elseif($arProp['USER_TYPE'] === 'video') {
				if(count($arProp['PROPERTY_VALUE_ID']) >= 1) {
					foreach($arProp['VALUE'] as $val){
						if($val['path']){
							$arResult['VIDEO'][] = $val;
						}
					}
				}
				elseif($arProp['VALUE']['path']){
					$arResult['VIDEO'][] = $arProp['VALUE'];
				}
			}
			elseif($arProp['CODE'] === 'VIDEO_IFRAME'){
				$arResult['VIDEO'] = $arResult['VIDEO'] + (array)$arProp["~VALUE"];
			}
			elseif($arProp['CODE'] === 'POPUP_VIDEO'){
				$arResult['POPUP_VIDEO'] = $arProp["VALUE"];
			}
		}
	}
	unset($arProp);

	$arResult['CHARACTERISTICS'] = TSolution::PrepareItemProps($arResult['DISPLAY_PROPERTIES']);

	if($arResult['PRICES']){
		if (!$arResult['HAS_ITEMS']) {
			// sort prices by count of periods
			ksort($arResult['PRICES']);
		}

		if($arParams['TABS'] === 'TOP'){
			if($arResult['DEFAULT_PRICE']){
				if ($arResult['HAS_ITEMS']) {
					$arResult['PRICES'] = array($arResult['DEFAULT_PRICE']['KEY'] => $arResult['DEFAULT_PRICE']);
				}
				else {
					$arResult['PRICES'] = array($arResult['DEFAULT_PRICE']['CNT_PERIODS'] => $arResult['DEFAULT_PRICE']);
				}
			}
		}
		else{
			// no default price
			if (!$arResult['DEFAULT_PRICE']) {
				if ($arParams['DEFAULT_PRICE_KEY'] === 'min') {
					$firstKey = reset(array_keys($arResult['PRICES']));
					$arResult['PRICES'][$firstKey]['DEFAULT'] = true;
					$arResult['DEFAULT_PRICE'] = $arResult['PRICES'][$firstKey];
				}
				else {
					if ($arParams['DEFAULT_FALLBACK'] === 'FIRST') {
						$firstKey = reset(array_keys($arResult['PRICES']));
						$arResult['PRICES'][$firstKey]['DEFAULT'] = true;
						$arResult['DEFAULT_PRICE'] = $arResult['PRICES'][$firstKey];
					}
					else {
						$lastKey = end(array_keys($arResult['PRICES']));
						$arResult['PRICES'][$lastKey]['DEFAULT'] = true;
						$arResult['DEFAULT_PRICE'] = $arResult['PRICES'][$lastKey];
					}
				}
			}
		}
	}
}

$arResult['CATEGORY_ITEM'] = '';

if ($arResult['SECTION'] && $arResult['SECTION']['PATH']) {
	$arTmpPath = array();
	foreach ($arResult['SECTION']['PATH'] as $arSection) {
		$arTmpPath[] = $arSection['NAME'];
	}
	if ($arTmpPath) {
		$arResult['CATEGORY_ITEM'] = implode('/', $arTmpPath);
	}
}
elseif($arResult['IBLOCK_SECTION_ID']) {
	$arSectionsIDs = [];
	$dbRes = CIBlockElement::GetElementGroups($arResult['ID'], true, array('ID'));
	while ($arSection = $dbRes->Fetch()) {
		$arSectionsIDs[$arSection['ID']] = $arSection['ID'];
	}

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
		if ($arSections) {
			$arResult['CATEGORY_ITEM'] = implode('/', array_values($arSections));
		}
	}
}
?>
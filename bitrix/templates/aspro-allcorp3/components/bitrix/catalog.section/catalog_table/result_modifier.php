<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?
use Bitrix\Main\Loader; // <--- ДОБАВЛЕНО

// <--- ДОБАВЛЕНО: Проверка и подключение модуля инфоблоков
if (!Loader::includeModule('iblock')) {
	return;
}
// --->

$arParams['ITEMS_OFFSET'] = false;
$arParams['SHOW_GALLERY'] = 'N';
$arResult['SHOW_COLS_PROP'] = false;
$arResult['COLS_PROP'] = [];
$arResult['SHOW_IMAGE'] =  $bHideImg = true;
$arNewItemsList = [];

// <--- ДОБАВЛЕНО: Кэш для кодов корневых разделов
$rootSectionCodeCache = []; // Локальный кэш для текущего вызова
// --->

if (!empty($arResult['ITEMS'])) {
	/* get sku tree props */
	$obSKU = new TSolution\SKU($arParams);
	if ($arParams['SKU_IBLOCK_ID'] && $arParams['SKU_TREE_PROPS']) {
		$obSKU->getTreePropsByFilter([
			'=IBLOCK_ID' => $arParams['SKU_IBLOCK_ID'],
			'CODE' => $arParams['SKU_TREE_PROPS']
		]);
		$arResult['SKU_CONFIG'] = $obSKU->config;
		$arResult['SKU_CONFIG']['ADD_PICT_PROP'] = $arParams['ADD_PICT_PROP'];
		$arResult['SKU_CONFIG']['SHOW_GALLERY'] = $arParams['SHOW_GALLERY'];
	}
	/* */
	
	/* get sections images */
	$arSections = TSolution\Product\Image::getSectionsImages([
		'ITEMS' => $arResult['ITEMS'],
	]);
	/* */

	foreach ($arResult['ITEMS'] as $key => $arItem) {	

if (isset($arItem['MIN_PRICE']['VALUE']) && $arItem['MIN_PRICE']['VALUE'] >= 1000000) {
    // заменяем поле для вывода цены
    $arResult['ITEMS'][$key]['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] = 'Цена по запросу';
    // или если вывод идет из другого поля — замени его аналогично
}

		if (is_array($arItem['PROPERTIES']['CML2_ARTICLE']['VALUE'])) {
			$arItem['PROPERTIES']['CML2_ARTICLE']['VALUE'] = reset($arItem['PROPERTIES']['CML2_ARTICLE']['VALUE']);
			$arResult['ITEMS'][$key]['PROPERTIES']['CML2_ARTICLE']['VALUE'] = $arItem['PROPERTIES']['CML2_ARTICLE']['VALUE'];
			if ($arItem['DISPLAY_PROPERTIES']['CML2_ARTICLE']) {
				$arItem['DISPLAY_PROPERTIES']['CML2_ARTICLE']['VALUE'] = reset($arItem['DISPLAY_PROPERTIES']['CML2_ARTICLE']['VALUE']);
				$arResult['ITEMS'][$key]['DISPLAY_PROPERTIES']['CML2_ARTICLE']['VALUE'] = $arItem['DISPLAY_PROPERTIES']['CML2_ARTICLE']['VALUE'];
			}
		}

		if ($arItem['DISPLAY_PROPERTIES']['DEMO_URL']) {
			$arProp = $arItem['DISPLAY_PROPERTIES']['DEMO_URL'];
			$arItem['DISPLAY_PROPERTIES']['DEMO_URL']['DISPLAY_VALUE'] = '<a rel="nofollow noopener" href="'.$arProp["VALUE"].'" target="_blank">'.$arProp["VALUE"].'</a>';
		}

		if (($arItem['DETAIL_PICTURE'] && $arItem['PREVIEW_PICTURE']) || (!$arItem['DETAIL_PICTURE'] && $arItem['PREVIEW_PICTURE'])) {
			$arItem['DETAIL_PICTURE'] = $arItem['PREVIEW_PICTURE'];
		}

		if ($arItem['PREVIEW_PICTURE'] || $arItem['DETAIL_PICTURE']) {
			$bHideImg = false;
		}

		if (!empty($arItem['DISPLAY_PROPERTIES'])) {
			foreach ($arItem['DISPLAY_PROPERTIES'] as $propKey => $arDispProp) {
				if ('F' == $arDispProp['PROPERTY_TYPE']) {
					unset($arItem['DISPLAY_PROPERTIES'][$propKey]);
				}
			}
		}

		$arItem['ARTICLE']=false;
		$arItem['PROPS'] = [];

		if (!empty($arItem['DISPLAY_PROPERTIES'])) {
			foreach ($arItem['DISPLAY_PROPERTIES'] as $propKey => $arDispProp) {
				if ($propKey=="CML2_ARTICLE") {
					$arItem['ARTICLE']=$arDispProp;
					unset($arItem['DISPLAY_PROPERTIES'][$propKey]);
				}
				if ('F' == $arDispProp['PROPERTY_TYPE'] || $arDispProp["CODE"] == $arParams["STIKERS_PROP"]) {
					unset($arItem['DISPLAY_PROPERTIES'][$propKey]);
				}
			}
			$arItem['PROPS'] = TSolution::PrepareItemProps($arItem['DISPLAY_PROPERTIES']);

			if ($arItem['PROPS']) {
				$arResult['SHOW_COLS_PROP'] = true;
				foreach ($arItem['PROPS'] as $code => $arProp) {
					$arResult['COLS_PROP'][$code] = [
						'NAME' => $arProp['NAME'],
						'ID' => $arProp['ID'],
						'SORT' => $arProp['SORT']
					];
				}
			}
		}

		// Закомментируем или изменим этот блок, если он конфликтует с нашей логикой URL
		/*
		if ($arParams['REPLACED_DETAIL_LINK']) {
			$arItem['DETAIL_PAGE_URL'] = $arParams['REPLACED_DETAIL_LINK'];
			$oid = TSolution::GetFrontParametrValue('CATALOG_OID');
			if ($oid) {
				$arItem['DETAIL_PAGE_URL'] .= '?'.$oid.'='.$arItem['ID'];
			}
		}
		*/

		// $arItem['LAST_ELEMENT'] = 'N'; // Переместим после нашего блока
		
		/* get SKU for item */
		$obSKU->setLinkedPropFromDisplayProps($arItem['DISPLAY_PROPERTIES']);
		// $obSKU->setSelectedItem(1996);
		$obSKU->getItemsByProperty();
		$arItem['SKU'] = [
			'CURRENT' => $obSKU->currentItem,
			'OFFERS' => $obSKU->items,
			'PROPS' => $obSKU->treeProps
		];
		/* */

		/* replace no-image with section picture */
		if (
			$arParams["REPLACE_NOIMAGE_WITH_SECTION_PICTURE"]
			&& !$arItem['PREVIEW_PICTURE'] && !$arItem['DETAIL_PICTURE'] 
			&& ($arSections[$arItem['~IBLOCK_SECTION_ID']]['PICTURE']['src'] ?? false)
		) {
			$arPicture = TSolution\Product\Image::getPictureOrDetailPicture($arSections, $arItem);
			if (is_array($arPicture)) {
				$arItem['NO_IMAGE'] = [
					'ID' => $arPicture['id'],
					'SRC' => $arPicture['src'],
				];

				if (isset($arItem['SKU']['CURRENT'])) {
					$arItem['SKU']['CURRENT']['NO_IMAGE'] = $arItem['NO_IMAGE'];
				}
			}
		}
		/* */
		
        // ================== НАЧАЛО ВАШЕГО БЛОКА ДЛЯ ИЗМЕНЕНИЯ URL ==================
        // Проверяем, не был ли URL уже заменен логикой Aspro ($arParams['REPLACED_DETAIL_LINK'])
        // Если да, то, возможно, наша логика не нужна или должна применяться иначе.
        // Пока что применяем нашу логику, если $arParams['REPLACED_DETAIL_LINK'] не установлен.
        if (empty($arParams['REPLACED_DETAIL_LINK'])) { // <--- ДОБАВЛЕНА ПРОВЕРКА
            if (!empty($arItem['IBLOCK_SECTION_ID']) && !empty($arItem['CODE']) && $arItem['IBLOCK_ID'] == 70) { // Уточнено IBLOCK_ID
                $currentSectionIdForElement = $arItem['IBLOCK_SECTION_ID'];
                $rootSectionCodeValue = null; 

                if (isset($rootSectionCodeCache[$currentSectionIdForElement])) {
                    $rootSectionCodeValue = $rootSectionCodeCache[$currentSectionIdForElement];
                } else {
                    $navChain = CIBlockSection::GetNavChain(
                        $arItem['IBLOCK_ID'],
                        $currentSectionIdForElement,
                        array('ID', 'CODE', 'DEPTH_LEVEL', 'IBLOCK_SECTION_ID')
                    );

                    $foundRootSection = null;
                    $pathSectionsToCache = []; 

                    while ($arNavSection = $navChain->Fetch()) {
                        $pathSectionsToCache[$arNavSection['ID']] = $arNavSection;
                        if ($arNavSection['DEPTH_LEVEL'] == 1) {
                            $foundRootSection = $arNavSection;
                        }
                    }

                    if ($foundRootSection && !empty($foundRootSection['CODE'])) {
                        $rootSectionCodeValue = $foundRootSection['CODE'];
                        foreach ($pathSectionsToCache as $pathSection) {
                            $rootSectionCodeCache[$pathSection['ID']] = $rootSectionCodeValue;
                        }
                    }
                }

                if ($rootSectionCodeValue) {
                    $sefFolder = rtrim($arParams['SEF_FOLDER'] ?? '/product/', '/') . '/';
                    $elementSefTemplate = $arParams['SEF_URL_TEMPLATES']['element'] ?? '#SECTION_CODE#/#ELEMENT_CODE#/';
                    
                    // Если есть сомнения в $arParams['SEF_URL_TEMPLATES']['element'], можно переопределить:
                    // $elementSefTemplate = '#SECTION_CODE#/#ELEMENT_CODE#/'; 

                    $newDetailUrl = str_replace(
                        ['#SECTION_CODE#', '#ELEMENT_CODE#'],
                        [$rootSectionCodeValue, $arItem['CODE']],
                        $elementSefTemplate
                    );

                    $arItem['DETAIL_PAGE_URL'] = $sefFolder . $newDetailUrl;
                    $arItem['DETAIL_PAGE_URL'] = preg_replace('~/{2,}~', '/', $arItem['DETAIL_PAGE_URL']);
                }
            }
        } elseif ($arParams['REPLACED_DETAIL_LINK']) { // Если Aspro заменил URL, просто добавим OID если он есть
            $oid = TSolution::GetFrontParametrValue('CATALOG_OID');
			if ($oid && strpos($arItem['DETAIL_PAGE_URL'], $oid.'=') === false) { // Проверяем, что OID еще не добавлен
				$arItem['DETAIL_PAGE_URL'] .= (strpos($arItem['DETAIL_PAGE_URL'], '?') === false ? '?' : '&') . $oid.'='.$arItem['ID'];
			}
        }
        // ================== КОНЕЦ ВАШЕГО БЛОКА ДЛЯ ИЗМЕНЕНИЯ URL ===================

		$arItem['LAST_ELEMENT'] = 'N'; // Теперь эта строка после вашего блока
		$arNewItemsList[$key] = $arItem;
	}
	
    if (isset($key) && isset($arNewItemsList[$key])) { // Проверка на существование ключа
	    $arNewItemsList[$key]['LAST_ELEMENT'] = 'Y';
    }
	$arResult['ITEMS'] = $arNewItemsList;

	unset($arNewItemsList);

	if ($arResult['COLS_PROP']) {
		\Bitrix\Main\Type\Collection::sortByColumn($arResult['COLS_PROP'],[
			'SORT' => array(SORT_NUMERIC, SORT_ASC),
			'ID' => array(SORT_NUMERIC, SORT_ASC)
		], '', null, true);
	}

	if ($arParams['HIDE_NO_IMAGE'] === 'Y') {
		$arResult['SHOW_IMAGE'] = $bHideImg ? false : true;
	}

	$arResult['CUSTOM_RESIZE_OPTIONS'] = array();
	if ($arParams['USE_CUSTOM_RESIZE_LIST'] == 'Y') { // В оригинале было USE_CUSTOM_RESIZE_LIST, оставил так
		$arIBlockFields = CIBlock::GetFields($arParams["IBLOCK_ID"]);
		if ($arIBlockFields['PREVIEW_PICTURE'] && $arIBlockFields['PREVIEW_PICTURE']['DEFAULT_VALUE']) {
			if ($arIBlockFields['PREVIEW_PICTURE']['DEFAULT_VALUE']['WIDTH'] && $arIBlockFields['PREVIEW_PICTURE']['DEFAULT_VALUE']['HEIGHT']) {
				$arResult['CUSTOM_RESIZE_OPTIONS'] = $arIBlockFields['PREVIEW_PICTURE']['DEFAULT_VALUE'];
			}
		}
	}
}?>
<?
if($arResult['ITEMS'])
{
	$arSectionsIDs = array();

	foreach($arResult['ITEMS'] as $key => $arItem)
	{
		$arItem['DETAIL_PAGE_URL'] = CAllcorp3::FormatNewsUrl($arItem);
	    CAllcorp3::getFieldImageData($arResult['ITEMS'][$key], array('PREVIEW_PICTURE'));
        if ($SID = $arItem['IBLOCK_SECTION_ID']) {
            $arSectionsIDs[] = $SID;
        }

        if($arParams['USE_SECTIONS_TABS'] == 'Y'){
		    if($arItem['IBLOCK_SECTION_ID']){
			    $resGroups = CIBlockElement::GetElementGroups($arItem['ID'], true, array('ID'));
			    while($arGroup = $resGroups->Fetch())
			    {
				    $arResult['ITEMS'][$key]['SECTIONS'][$arGroup['ID']] = $arGroup['ID'];
				    $arGoodsSectionsIDs[$arGroup['ID']] = $arGroup['ID'];
			    }
		    }
	    }

	    if($arSectionsIDs && $arParams['USE_SECTIONS_TABS'] != 'Y')
	    {
		    $arSectionsFilter = ['IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arSectionsIDs, 'ACTIVE' => 'Y', 'GLOBAL_ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y'];
            TSolution::makeSectionFilterInRegion($arSectionsFilter);
            $arResult['SECTIONS'] = CAllcorp3Cache::CIBLockSection_GetList(array('SORT' => 'ASC', 'NAME' => 'ASC', 'CACHE' => array('TAG' => CAllcorp3Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'GROUP' => 'ID', 'MULTI' => 'N')), $arSectionsFilter, false, array('ID', 'NAME'));
	    } elseif ($arGoodsSectionsIDs && $arParams['USE_SECTIONS_TABS'] == 'Y')
        {
		    $arResult['SECTIONS'] = CAllcorp3Cache::CIBLockSection_GetList(array('SORT' => 'ASC', 'NAME' => 'ASC', 'CACHE' => array('TAG' => CAllcorp3Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'GROUP' => 'ID', 'MULTI' => 'N')), array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arGoodsSectionsIDs, 'ACTIVE' => 'Y', 'GLOBAL_ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y'), false, array('ID', 'NAME'));
	    }
    }
}
?>

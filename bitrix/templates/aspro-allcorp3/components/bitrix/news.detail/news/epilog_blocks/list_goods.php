<?
use \Bitrix\Main\Localization\Loc;
?>
<?//show news block?>
<?if($templateData['FILTER_URL']):?>
    <?$catalogIBlockID = $arParams['CATALOG_IBLOCK_ID'] ?: TSolution::getFrontParametrValue('CATALOG_IBLOCK_ID');?>
    <?$filterName = 'arFilterCatalog'?>
    <?include_once('catalog/filter.php')?>

    <?
    $arFilter = [
        'IBLOCK_ID' => $catalogIBlockID, 
        'ACTIVE' => 'Y'
    ];
    if ($templateData['SECTIONS']) {
        $arFilter['SECTION_ID'] = $templateData['SECTIONS'];
        $arFilter['INCLUDE_SUBSECTIONS'] = 'Y';
    }
    $iCountElement = TSolution\Cache::CIblockElement_GetList(
        [
            'CACHE' => [
                'TAG' => TSolution\Cache::GetIBlockCacheTag($catalogIBlockID),
                'MULTI' => 'N'
            ]
        ], 
        array_merge($arFilter, $GLOBALS[$filterName]), 
        []
    );?>

    <?if($iCountElement):?>
        <?
        $GLOBALS[$filterName.'ITEMS'] = array_merge($arFilter, $GLOBALS[$filterName]);
        $GLOBALS[$filterName.'ITEMS'] = array_merge($GLOBALS[$filterName.'ITEMS'], (array)$GLOBALS['arRegionLink']);
        ?>

        <div class="detail-block ordered-block list_items">
            <?$isAjax = (TSolution::checkAjaxRequest() ? 'Y' : 'N');?>
            <?if ($templateData['H3_GOODS']):?>
                <h3 class="ordered-block__title switcher-title font_22"><?=$templateData['H3_GOODS']?></h3>
            <?endif;?>

            <?if($isAjax == "N"):?>
				<?$frame = new \Bitrix\Main\Page\FrameHelper('catalog-elements-landing-block');
				$frame->begin();
				$frame->setAnimation(true);
				?>
            <?endif;?>
            
            <?include_once('catalog/sort.php')?>

            <?if($isAjax == "Y"):?>
				<?$APPLICATION->RestartBuffer();?>
            <?endif;?>
            
            <?if($isAjax == "N"):?>
				<div class="ajax_load <?=$display;?>-view">
			<?endif;?>
            
            <?TSolution\Functions::showBlockHtml([
                'FILE' => '/detail_list_goods.php',
                'PARAMS' => array_merge(
                    $arParams,
                    array(
                        'ORDER_VIEW' => $templateData['ORDER'],
                        'OPT_BUY' => $arParams['OPT_BUY'],
                        'SHOW_DISCOUNT' => $arParams['SHOW_DISCOUNT'],
                        'FILTER_NAME' => $filterName.'ITEMS',
                        'DISPLAY' => 'catalog_'.($display == 'price' ? 'table' : ($display == 'table' ? 'block' : $display)),
                        'AJAX' => $isAjax,
                        'LINE_TO_ROW' => $linerow,
                        'ELEMENT_IN_ROW' => $APPLICATION->GetProperty('MENU') === 'Y' ? 4 : 5,
                        'LINKED_CATALOG_COUNT' => $arParams['LINKED_CATALOG_COUNT'] ?? "20",
                        "ELEMENT_SORT_FIELD" => $arAvailableSort[$sort]["SORT"],
                        "ELEMENT_SORT_ORDER" => strtoupper($order),
                        "SHOW_PROPS_TABLE" => strtolower(TSolution::GetFrontParametrValue('SHOW_TABLE_PROPS')),
                        "SKU_IBLOCK_ID"	=>	$arParams["SKU_IBLOCK_ID"],
                        "SKU_TREE_PROPS"	=>	$arParams["SKU_TREE_PROPS"],
                        "SKU_PROPERTY_CODE"	=>	$arParams["SKU_PROPERTY_CODE"],
                        "SKU_SORT_FIELD" => $arParams["SKU_SORT_FIELD"],
                        "SKU_SORT_ORDER" => $arParams["SKU_SORT_ORDER"],
                        "SKU_SORT_FIELD2" => $arParams["SKU_SORT_FIELD2"],
                        "SKU_SORT_ORDER2" =>$arParams["SKU_SORT_ORDER2"],
                        "ITEM_HOVER_SHADOW" =>true,
                    )
                )
            ]);?>

            <?if($isAjax == "N"):?>
				</div>
				<?$frame->end();?>
			<?else:?>
				<?die();?>
			<?endif;?>
        </div>
    <?endif;?>
<?endif;?>
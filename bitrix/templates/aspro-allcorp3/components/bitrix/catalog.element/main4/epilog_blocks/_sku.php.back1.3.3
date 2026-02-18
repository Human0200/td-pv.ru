<?
use \Bitrix\Main\Localization\Loc;

$bTab = isset($tabCode) && $tabCode === 'sku';
?>
<?//show sku block?>
<?if($templateData['SKU']['VALUE'] && $templateData['SKU']['IBLOCK_ID'] && $arParams['TYPE_SKU'] === 'TYPE_2'):?>
    <?if(!isset($html_sku)):?>
        <?$GLOBALS['arrSkuFilter'] = array('ID' => $templateData['SKU']['VALUE']);?>
        <?ob_start();?>
            <?$APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
	            "catalog_table",
                array(
                    "IBLOCK_TYPE" => "aspro_allcorp3_catalog",
                    "IBLOCK_ID" => $templateData['SKU']['IBLOCK_ID'],
                    "PAGE_ELEMENT_COUNT" => 999,
		            "PROPERTY_CODE"	=>	$arParams["SKU_PROPERTY_CODE"],
                    "ELEMENT_SORT_FIELD" => $arParams["SKU_SORT_FIELD"],
                    "ELEMENT_SORT_ORDER" => $arParams["SKU_SORT_ORDER"],
                    "ELEMENT_SORT_FIELD2" => $arParams["SKU_SORT_FIELD2"],
                    "ELEMENT_SORT_ORDER2" =>$arParams["SKU_SORT_ORDER2"],
                    "FILTER_NAME" => "arrSkuFilter",
                    "FIELD_CODE" => array(
                        0 => "NAME",
                        1 => "PREVIEW_TEXT",
                        2 => "PREVIEW_PICTURE",
                        3 => "DETAIL_TEXT",
                        4 => "",
                    ),
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "CACHE_TYPE"	=>	$arParams["CACHE_TYPE"],
                    "CACHE_TIME"	=>	$arParams["CACHE_TIME"],
                    "CACHE_FILTER"	=>	$arParams["CACHE_FILTER"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "ACTIVE_DATE_FORMAT" => "j F Y",
                    "SET_TITLE" => "N",
                    "SET_STATUS_404" => "N",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "PARENT_SECTION" => "",
                    "PARENT_SECTION_CODE" => "",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "PAGER_TEMPLATE" => ".default",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "Y",
                    "PAGER_TITLE" => "",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "COUNT_IN_LINE" => "3",
                    "SHOW_DATE" => "N",

                    "ORDER_VIEW" => CAllcorp3::GetFrontParametrValue('ORDER_VIEW') == 'Y',
		            "SHOW_PROPS_TABLE" => 'ROWS',
		            "REPLACED_DETAIL_LINK" => $templateData['DETAIL_PAGE_URL'],

                    "SHOW_SECTION_PREVIEW_DESCRIPTION" => "N",
                    "SHOW_SECTION_NAME" => "N",
                    "SHOW_ONE_CLINK_BUY" => $arParams["SHOW_ONE_CLINK_BUY"],
                    "OPT_BUY" => "N",
                    "HIDE_NO_IMAGE" => "Y",
                    "DETAIL" => "Y",
                    "MOBILE_SCROLLED" => false,
                    "USE_FAST_VIEW_PAGE_DETAIL" => "NO",
                ),
                false, array("HIDE_ICONS" => "Y")
            );?>
        <?$html_sku = trim(ob_get_clean());?>
    <?endif;?>

    <?if($html_sku && strpos($html_sku, 'error') === false):?>
        <?if($bTab):?>
            <?if(!isset($bShow_sku)):?>
                <?$bShow_sku = true;?>
            <?else:?>
                <div class="tab-pane <?=(!($iTab++) ? 'active' : '')?>" id="sku">
                    <div class="ordered-block__title switcher-title font_22"><?=$arParams["T_SKU"]?></div>
                    <?=$html_sku?>
                </div>
            <?endif;?>
        <?else:?>
            <div class="detail-block ordered-block sku">
                <div class="ordered-block__title switcher-title font_22"><?=$arParams["T_SKU"]?></div>
                <?=$html_sku?>
            </div>
        <?endif;?>
    <?endif;?>
<?endif;?>
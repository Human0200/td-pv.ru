<?
use \Bitrix\Main\Localization\Loc;

$bTab = isset($tabCode) && $tabCode === 'partners';
?>
<?//show partners block?>
<?if($templateData['PARTNERS']['VALUE'] && $templateData['PARTNERS']['IBLOCK_ID']):?>
    <?if(!isset($html_partners)):?>
        <?
        $GLOBALS['arrPartnersFilter'] = array('ID' => $templateData['PARTNERS']['VALUE']);
        $GLOBALS['arrPartnersFilter'] = array_merge($GLOBALS['arrPartnersFilter'], (array)$GLOBALS['arRegionLink']);

        $bCheckAjaxBlock = CAllcorp3::checkRequestBlock("partners-list-inner");
        ?>
        <?ob_start();?>
            <?$APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "partner-list-inner",
                array(
                    "IBLOCK_TYPE" => "aspro_allcorp3_content",
                    "IBLOCK_ID" => $templateData['PARTNERS']['IBLOCK_ID'],
                    "NEWS_COUNT" => "30",
                    "SORT_BY1" => "SORT",
                    "SORT_ORDER1" => "DESC",
                    "SORT_BY2" => "",
                    "SORT_ORDER2" => "ASC",
                    "FILTER_NAME" => "arrPartnersFilter",
                    "FIELD_CODE" => array(
                        0 => "NAME",
                        1 => "PREVIEW_TEXT",
                        2 => "PREVIEW_PICTURE",
                        3 => "",
                    ),
                    "PROPERTY_CODE" => array(
                        0 => "EMAIL",
                        1 => "POST",
                        2 => "PHONE",
                        3 => "",
                    ),
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "360000",
                    "CACHE_FILTER" => "Y",
                    "CACHE_GROUPS" => "N",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "SET_TITLE" => "N",
                    "SET_STATUS_404" => "N",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "PARENT_SECTION" => "",
                    "PARENT_SECTION_CODE" => "",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "PAGER_TEMPLATE" => "",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "PAGER_TITLE" => "",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "IS_STAFF" => "Y",
                    "SHOW_TABS" => "N",
                    "SHOW_SECTION_PREVIEW_DESCRIPTION" => "N",

                    "DOTS_0" => "Y",
                    "DOTS_380" => "Y",
                    "DOTS_768" => "Y",
                    "DOTS_1200" => "Y",
                    "SHOW_SECTION_PREVIEW_DESCRIPTION" => "N",
                    "SHOW_SECTION_NAME" => "N",
                    "IS_AJAX" => CAllcorp3::checkAjaxRequest() && $bCheckAjaxBlock,
                    'CHECK_REQUEST_BLOCK' => $bCheckAjaxBlock,
                    "LINKED_MODE" => "Y",
                    "MOBILE_SCROLLED" => false,
                    "VIEW_TYPE" => "only-logo",
                    "ITEMS_OFFSET" => "Y",
                    "SLIDER" => "Y",
                    "ELEMENT_IN_ROW" => "4",
                    "ITEM_380" => "2",
                    "ITEM_768" => "3",
                    "GRID_GAP" => 20,
                    "NARROW" => "Y",
                    "BORDER" => "Y",
                    "SLIDER_BUTTONS_BORDERED" => "N",
                ),
                false, array("HIDE_ICONS" => "Y")
            );?>
        <?$html_partners = trim(ob_get_clean());?>
    <?endif;?>

    <?if($html_partners && strpos($html_partners, 'error') === false):?>
        <?if($bTab):?>
            <?if(!isset($bShow_partners)):?>
                <?$bShow_partners = true;?>
            <?else:?>
                <div class="tab-pane <?=(!($iTab++) ? 'active' : '')?>" id="partners">
                    <div class="ordered-block__title switcher-title font_22"><?=$arParams["T_PARTNERS"]?></div>
                    <?=$html_partners?>
                </div>
            <?endif;?>
        <?else:?>
            <div class="detail-block ordered-block partners">
                <div class="ordered-block__title switcher-title font_22"><?=$arParams["T_PARTNERS"]?></div>
                <?=$html_partners?>
            </div>
        <?endif;?>
    <?endif;?>
<?endif;?>
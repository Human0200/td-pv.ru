<?
use \Bitrix\Main\Localization\Loc;

$bTab = isset($tabCode) && $tabCode === 'vacancy';
?>
<?//show vacancy block?>
<?if($templateData['VACANCY']['VALUE'] && $templateData['VACANCY']['IBLOCK_ID']):?>
    <?if(!isset($html_vacancy)):?>
        <?
        $GLOBALS['arrVacancyFilter'] = array('ID' => $templateData['VACANCY']['VALUE']);
        $GLOBALS['arrVacancyFilter'] = array_merge($GLOBALS['arrVacancyFilter'], (array)$GLOBALS['arRegionLink']);
        ?>
        <?ob_start();?>
            <?$bCheckAjaxBlock = CAllcorp3::checkRequestBlock("vacancy-list-inner");?>
            <?$APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "vacancy-accordion-inner",
                array(
                    "IBLOCK_TYPE" => "aspro_allcorp3_content",
                    "IBLOCK_ID" => $templateData['VACANCY']['IBLOCK_ID'],
                    "NEWS_COUNT" => "20",
                    "SORT_BY1" => "ACTIVE_FROM",
                    "SORT_ORDER1" => "DESC",
                    "SORT_BY2" => "SORT",
                    "SORT_ORDER2" => "ASC",
                    "FILTER_NAME" => "arrVacancyFilter",
                    "FIELD_CODE" => array(
                        0 => "NAME",
                        1 => "PREVIEW_TEXT",
                        2 => "PREVIEW_PICTURE",
                        3 => "DETAIL_TEXT",
                        4 => "",
                    ),
                    "PROPERTY_CODE" => array(
                        0 => "LINK_REGION",
                        1 => "PAY",
                        2 => "QUALITY",
                        3 => "WORK_TYPE",
                        4 => "",
                    ),
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_FILTER" => "Y",
                    "CACHE_GROUPS" => "N",
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
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "PAGER_TITLE" => "",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "COUNT_IN_LINE" => "3",
                    "SHOW_DATE" => "N",

                    "SHOW_SECTION_PREVIEW_DESCRIPTION" => "N",
                    "SHOW_SECTION_NAME" => "N",
                    "IS_AJAX" => CAllcorp3::checkAjaxRequest() && $bCheckAjaxBlock,
                    "LINKED_MODE" => "Y",
                    "VIEW_TYPE" => "list",
                    "ITEMS_OFFSET" => "N",
                    "MOBILE_SCROLLED" => false,
                ),
                false, array("HIDE_ICONS" => "Y")
            );?>
        <?$html_vacancy = trim(ob_get_clean());?>
    <?endif;?>

    <?if($html_vacancy && strpos($html_vacancy, 'error') === false):?>
        <?if($bTab):?>
            <?if(!isset($bShow_vacancy)):?>
                <?$bShow_vacancy = true;?>
            <?else:?>
                <div class="tab-pane <?=(!($iTab++) ? 'active' : '')?>" id="vacancy">
                    <div class="ordered-block__title switcher-title font_22"><?=$arParams["T_VACANCY"]?></div>
                    <?=$html_vacancy?>
                </div>
            <?endif;?>
        <?else:?>
            <div class="detail-block ordered-block vacancy">
                <div class="ordered-block__title switcher-title font_22"><?=$arParams["T_VACANCY"]?></div>
                <?=$html_vacancy?>
            </div>
        <?endif;?>
    <?endif;?>
<?endif;?>
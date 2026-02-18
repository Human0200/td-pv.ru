<?

use \Bitrix\Main\Localization\Loc;

$bTab = isset($tabCode) && $tabCode === 'complects';
?>
<? //show news block
?>

<? if ($templateData['COMPLECTS']['VALUE'] && $templateData['COMPLECTS']['LINK_IBLOCK_ID']) : ?>
    <? if (!isset($html_complects)) : ?>
        <?
        $GLOBALS['arrComplectsFilter'] = array('ID' => $templateData['COMPLECTS']['VALUE']);
        $GLOBALS['arrComplectsFilter'] = array_merge($GLOBALS['arrComplectsFilter'], (array)$GLOBALS['arRegionLink']);

        $bCheckAjaxBlock = CAllcorp3::checkRequestBlock("complects-list-inner");
        ?>
        <? ob_start(); ?>
        <? $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "complect-list",
            array(
                "IBLOCK_TYPE" => "aspro_allcorp3_catalog",
                "IBLOCK_ID" => $templateData['COMPLECTS']['LINK_IBLOCK_ID'],
                "NEWS_COUNT" => "20",
                "SORT_BY1" => "ACTIVE_FROM",
                "SORT_ORDER1" => "DESC",
                "SORT_BY2" => "SORT",
                "SORT_ORDER2" => "ASC",
                "FILTER_NAME" => "arrComplectsFilter",
                "FIELD_CODE" => array(
                    0 => "NAME",
                    2 => "PREVIEW_PICTURE",
                ),
                "PROPERTY_CODE" => $arParams['PROPERTY_CODE'],
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
                "VISIBLE_PROP_COUNT" => "4",
                "ROW_VIEW" => false,
                "BORDER" => true,
                "ITEM_HOVER_SHADOW" => true,
                "DARK_HOVER" => false,
                "ROUNDED" => true,
                "ITEM_1200" => 3,
                "VIEW_TYPE" => "type_2",
                "ORDER_VIEW" => CAllcorp3::GetFrontParametrValue('ORDER_VIEW') == 'Y',
                "ITEMS_OFFSET" => true,
                "DETAIL_PAGE_URL" => $templateData['DETAIL_PAGE_URL'],
                "NARROW" => true,
                "ELEMENTS_ROW" => "4",
                "MAXWIDTH_WRAP" => false,
                "MOBILE_SCROLLED" => false,
                "HIDE_PAGINATION" => "N",
                "SLIDER" => true,
                "CHECK_REQUEST_BLOCK" => $bCheckAjaxBlock,
                "IS_AJAX" => CAllcorp3::checkAjaxRequest() && $bCheckAjaxBlock,
            ),
            false,
            array("HIDE_ICONS" => "Y")
        ); ?>
        <? $html_complects = trim(ob_get_clean()); ?>
    <? endif; ?>

    <? if ($html_complects && strpos($html_complects, 'error') === false) : ?>
        <? if ($bTab) : ?>
            <? if (!isset($bShow_complects)) : ?>
                <? $bShow_complects = true; ?>
            <? else : ?>
                <div class="tab-pane <?= (!($iTab++) ? 'active' : '') ?>" id="complects">
                    <div class="ordered-block__title switcher-title font_22"><?= $arParams["T_COMPLECTS"] ?></div>
                    <?= $html_complects ?>
                </div>
            <? endif; ?>
        <? else : ?>
            <div class="detail-block ordered-block complects">
                <div class="ordered-block__title switcher-title font_22"><?= $arParams["T_COMPLECTS"] ?></div>
                <?= $html_complects ?>
            </div>
        <? endif; ?>
    <? endif; ?>
<? endif; ?>
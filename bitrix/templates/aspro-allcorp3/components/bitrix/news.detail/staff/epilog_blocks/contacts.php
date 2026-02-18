<?php

use \Bitrix\Main\Localization\Loc;
$GLOBALS['arrContactsFilter'] = ['ID' => $templateData['CONTACTS']['VALUE']];
$GLOBALS['arrContactsFilter'] = array_merge($GLOBALS['arrContactsFilter'], (array)$GLOBALS['arRegionLink']);
?>

<?if ($templateData['CONTACTS'] && $templateData['CONTACTS']['IBLOCK_ID'] && $templateData['CONTACTS']['VALUE']):?>
<?ob_start();?>
<?$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "contacts-list",
    array(
        "IBLOCK_TYPE" => "aspro_allcorp3_content",
        "IBLOCK_ID" => $templateData['CONTACTS']['IBLOCK_ID'],
        "NEWS_COUNT" => "20",
        "SORT_BY1" => "SORT",
        "SORT_ORDER1" => "ASC",
        "SORT_BY2" => "ID",
        "SORT_ORDER2" => "DESC",
        "FILTER_NAME" => "arrContactsFilter",
        "FIELD_CODE" => array(
            0 => "NAME",
            2 => "PREVIEW_PICTURE",
        ),
        "PROPERTY_CODE" => array(
			0 => "ADDRESS",
			1 => "METRO",
			2 => "PHONE",
			3 => "EMAIL",
			4 => "SCHEDULE",
			5 => "PAY_TYPE",
			6 => "MAP",
			7 => "",
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
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
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
        "COUNT_IN_LINE" => "2",
        "ROW_VIEW" => true,
        "BORDER" => true,
        "DARK_HOVER" => false,
        "ITEM_HOVER_SHADOW" => true,
        "ROUNDED" => true,
        "ROUNDED_IMAGE" => true,
        "ITEM_PADDING" => true,
        "ELEMENTS_ROW" => 1,
        "MAXWIDTH_WRAP" => false,
        "MOBILE_SCROLLED" => false,
        "NARROW" => false,
        "ITEMS_OFFSET" => false,
        "IMAGES" => "PICTURE",
        "IMAGE_POSITION" => "LEFT",
        "SHOW_PREVIEW" => true,
        "SHOW_TITLE" => false,
        "SHOW_SECTION" => "N",
        "PRICE_POSITION" => "RIGHT",
        "TITLE_POSITION" => "",
        "LINK_POSITION_BLOCK" => "Y",
    ),
    false,
    array("HIDE_ICONS" => "Y")
);?>
    <?$html = trim(ob_get_clean());?>
    <?if ($html && strpos($html, 'error') === false) :?>
        <div class="detail-block ordered-block">
            <div class="ordered-block__title switcher-title font_22"><?=$arParams['T_CONTACTS'] ?: GetMessage('T_CONTACTS')?></div>
            <?=$html?>
        </div>
    <?endif;?>
<?endif;?>
<?global $sMenuContent, $isCabinet, $arTheme;?>
<div class="left_block">
	<div class="sticky-block sticky-block--show-<?=CAllcorp3::GetFrontParametrValue('STICKY_SIDEBAR')?>">
		<?if($isCabinet):?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:menu",
				"left",
				array(
					"ROOT_MENU_TYPE" => "cabinet",
					"MENU_CACHE_TYPE" => "A",
					"MENU_CACHE_TIME" => "3600000",
					"MENU_CACHE_USE_GROUPS" => "Y",
					"MENU_CACHE_GET_VARS" => array(
					),
					"MAX_LEVEL" => "4",
					"CHILD_MENU_TYPE" => "left",
					"USE_EXT" => "Y",
					"DELAY" => "N",
					"ALLOW_MULTI_SELECT" => "Y",
					"COMPONENT_TEMPLATE" => "left"
				),
				false
			);?>
		<?else:?>
			<?=$sMenuContent;?>
		<?endif;?>
		<div class="sidearea">
			<?$APPLICATION->ShowViewContent('under_sidebar_content');?>
			<?CAllcorp3::get_banners_position('SIDE');?>
			<?/*$APPLICATION->IncludeComponent(
				"bitrix:news.list",
				"tizers2",
				array(
					"IBLOCK_TYPE" => "aspro_allcorp3_content",
					"IBLOCK_ID" => CAllcorp3Cache::$arIBlocks[SITE_ID]["aspro_allcorp3_content"]["aspro_allcorp3_front_tizers"][0],
					"NEWS_COUNT" => "100",
					"SORT_BY1" => "SORT",
					"SORT_ORDER1" => "ASC",
					"SORT_BY2" => "ID",
					"SORT_ORDER2" => "ASC",
					"ONE_ROW" => "Y",
					"FIELD_CODE" => array(
						0 => "NAME",
						2 => "PREVIEW_PICTURE",
					),
					"PROPERTY_CODE" => array(
						0 => "LINK",
						1 => "",
					),
					"CHECK_DATES" => "Y",
					"USE_FILTER_ELEMENTS" => "Y",
					"FILTER_NAME" => "arFilterLeftBlock",
					"PAGE" => $APPLICATION->GetCurPage(),
					"DETAIL_URL" => "",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N",
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "3600000",
					"CACHE_FILTER" => "Y",
					"CACHE_GROUPS" => "N",
					"PREVIEW_TRUNCATE_LEN" => "150",
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
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "3600000",
					"PAGER_SHOW_ALL" => "N",
					"AJAX_OPTION_ADDITIONAL" => "",
					"SHOW_DETAIL_LINK" => "N",
					"SET_BROWSER_TITLE" => "N",
					"SET_META_KEYWORDS" => "N",
					"SET_META_DESCRIPTION" => "N",
					"COMPONENT_TEMPLATE" => "banners",
					"SET_LAST_MODIFIED" => "N",
					"COMPOSITE_FRAME_MODE" => "A",
					"COMPOSITE_FRAME_TYPE" => "AUTO",
					"PAGER_BASE_LINK_ENABLE" => "N",
					"SHOW_404" => "N",
					"MESSAGE_404" => ""
				),
				false, array('ACTIVE_COMPONENT' => 'Y')
			);*/?>
			<?$APPLICATION->IncludeComponent(
		"bitrix:news.list", 
		"catalog_table", 
		array(
			"IBLOCK_TYPE" => "aspro_allcorp3_catalog",
			"IBLOCK_ID" => "311",
			"NEWS_COUNT" => "1",
			"COUNT_IN_LINE" => "1",
			"SORT_BY1" => "RAND",
			"SORT_ORDER1" => "ASC",
			"SORT_BY2" => "SORT",
			"SORT_ORDER2" => "ASC",
			"TITLE_BEST" => "Товар дня",
			"ONE_ROW" => "Y",
			"FIELD_CODE" => array(
				0 => "NAME",
				1 => "PREVIEW_PICTURE",
				2 => "DETAIL_TEXT",
				3 => "",
			),
			"PROPERTY_CODE" => array(
				0 => "FORM_ORDER",
				1 => "PRICE",
				2 => "PRICEOLD",
				3 => "STATUS",
				4 => "ARTICLE",
				5 => "LINK",
				6 => "",
			),
			"CHECK_DATES" => "Y",
			"FILTER_NAME" => "arFilterBestItem",
			"DETAIL_URL" => "",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"AJAX_OPTION_HISTORY" => "N",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "600",
			"CACHE_FILTER" => "Y",
			"CACHE_GROUPS" => "N",
			"PREVIEW_TRUNCATE_LEN" => "150",
			"ACTIVE_DATE_FORMAT" => "d.m.Y",
			"SET_TITLE" => "N",
			"SET_STATUS_404" => "N",
			"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
			"ADD_SECTIONS_CHAIN" => "N",
			"HIDE_LINK_WHEN_NO_DETAIL" => "N",
			"SHOW_DETAIL_LINK" => "Y",
			"PARENT_SECTION" => "",
			"PARENT_SECTION_CODE" => "",
			"INCLUDE_SUBSECTIONS" => "Y",
			"PAGER_TEMPLATE" => ".default",
			"DISPLAY_TOP_PAGER" => "N",
			"DISPLAY_BOTTOM_PAGER" => "N",
			"PAGER_TITLE" => "",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "3600000",
			"PAGER_SHOW_ALL" => "N",
			"AJAX_OPTION_ADDITIONAL" => "",
			"SET_BROWSER_TITLE" => "N",
			"SET_META_KEYWORDS" => "N",
			"SET_META_DESCRIPTION" => "N",
			"COMPONENT_TEMPLATE" => "catalog_table",
			"SET_LAST_MODIFIED" => "N",
			"COMPOSITE_FRAME_MODE" => "A",
			"COMPOSITE_FRAME_TYPE" => "AUTO",
			"PAGER_BASE_LINK_ENABLE" => "N",
			"ORDER_VIEW" => (trim($arTheme["ORDER_VIEW"]["VALUE"])==="Y"),
			"SHOW_404" => "N",
			"MESSAGE_404" => "",
			"STRICT_SECTION_CHECK" => "N"
		),
		false,
		array(
			"ACTIVE_COMPONENT" => "Y"
		)
	);?>
			<div class="include">
			<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "sect", "AREA_FILE_SUFFIX" => "sidebar", "AREA_FILE_RECURSIVE" => "Y"), false);?>
			</div>
		</div>
	</div>
</div>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$APPLICATION->IncludeComponent(
	"aspro:instargam.allcorp3",
	"",
	Array(
		"COMPOSITE_FRAME_MODE" => $arParams['COMPOSITE_FRAME_MODE'],
		"COMPOSITE_FRAME_TYPE" => $arParams['COMPOSITE_FRAME_TYPE'],
		"WIDE" => $arParams['~WIDE'],
		"ITEMS_OFFSET" => $arParams['~ITEMS_OFFSET'],
		"LINES_COUNT" => $arParams['~LINES_COUNT'],
		"ELEMENTS_ROW" => $arParams['~ELEMENTS_ROW'],
		"TYPE_BLOCK" => $arParams['~TYPE_BLOCK'],
		"SHOW_TITLE" => $arParams['~SHOW_TITLE'],
		"TITLE_POSITION" => $arParams['~TITLE_POSITION'],
		"SHOW_PREVIEW_TEXT" => $arParams['~SHOW_PREVIEW_TEXT'],
		"SUBTITLE" => $arParams['~SUBTITLE'],
		"CACHE_TYPE" => $arParams['CACHE_TYPE'],
		"CACHE_TIME" => $arParams['CACHE_TIME'],
		"CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
	)
);?>
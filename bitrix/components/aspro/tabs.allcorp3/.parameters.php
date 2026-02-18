<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */

if(!CModule::IncludeModule("iblock"))
	return;

$arTypesEx = CIBlockParameters::GetIBlockTypes(array("-"=>" "));
$arIBlocks=array();
$db_iblock = CIBlock::GetList(array("SORT"=>"ASC"), array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")));
while($arRes = $db_iblock->Fetch())
	$arIBlocks[$arRes["ID"]] = $arRes["NAME"];

$arSorts = array("ASC"=>GetMessage("T_IBLOCK_DESC_ASC"), "DESC"=>GetMessage("T_IBLOCK_DESC_DESC"));
$arSortFields = array(
		"ID"=>GetMessage("T_IBLOCK_DESC_FID"),
		"NAME"=>GetMessage("T_IBLOCK_DESC_FNAME"),
		"ACTIVE_FROM"=>GetMessage("T_IBLOCK_DESC_FACT"),
		"SORT"=>GetMessage("T_IBLOCK_DESC_FSORT"),
		"TIMESTAMP_X"=>GetMessage("T_IBLOCK_DESC_FTSAMP")
	);

if (0 < intval($arCurrentValues['IBLOCK_ID']))
{
	$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"], "ACTIVE"=>"Y"));
	while ($arr=$rsProp->Fetch())
	{
		if($arr["PROPERTY_TYPE"] != "F")
			$arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];

		if($arr["PROPERTY_TYPE"]=="N")
			$arProperty_N[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
		if($arr["PROPERTY_TYPE"]=="S")
			$arProperty_S[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
		if($arr["PROPERTY_TYPE"]=="F")
			$arProperty_F[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];

		if($arr["PROPERTY_TYPE"]!="F")
		{
			if($arr["MULTIPLE"] == "Y" && $arr["PROPERTY_TYPE"] == "L")
				$arProperty_XL[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
			elseif($arr["PROPERTY_TYPE"] == "L")
				$arProperty_X[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
			elseif($arr["PROPERTY_TYPE"] == "E" && $arr["LINK_IBLOCK_ID"] > 0)
				$arProperty_X[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
		}
	}
}

$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		"IBLOCK_TYPE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("T_IBLOCK_DESC_LIST_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => $arTypesEx,
			"DEFAULT" => "news",
			"REFRESH" => "Y",
		),
		"IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("T_IBLOCK_DESC_LIST_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"DEFAULT" => '={$_REQUEST["ID"]}',
			"ADDITIONAL_VALUES" => "Y",
			"REFRESH" => "Y",
		),
		"PAGE_ELEMENT_COUNT" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("T_IBLOCK_DESC_LIST_CONT"),
			"TYPE" => "LIST",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => ['FROM_THEME'  => GetMessage("FROM_THEME")],
			"DEFAULT" => "FROM_THEME",
		),
		"TABS_FILTER" => array(
			"NAME" => GetMessage("T_TABS_FILTER"),
			"TYPE" => "LIST",
			"VALUES" => array(
				"PROPERTY" => GetMessage("T_TABS_FILTER_PROPERTY"),
				"SECTION" => GetMessage("T_TABS_FILTER_SECTION"),
			),
			"DEFAULT" => "PROPERTY",
			"PARENT" => "BASE",
		),
		"ELEMENT_SORT_FIELD" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("T_IBLOCK_DESC_IBORD1"),
			"TYPE" => "LIST",
			"DEFAULT" => "ACTIVE_FROM",
			"VALUES" => $arSortFields,
			"ADDITIONAL_VALUES" => "Y",
		),
		"ELEMENT_SORT_ORDER" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("T_IBLOCK_DESC_IBBY1"),
			"TYPE" => "LIST",
			"DEFAULT" => "DESC",
			"VALUES" => $arSorts,
			"ADDITIONAL_VALUES" => "Y",
		),
		"ELEMENT_SORT_FIELD2" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("T_IBLOCK_DESC_IBORD2"),
			"TYPE" => "LIST",
			"DEFAULT" => "SORT",
			"VALUES" => $arSortFields,
			"ADDITIONAL_VALUES" => "Y",
		),
		"ELEMENT_SORT_ORDER2" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("T_IBLOCK_DESC_IBBY2"),
			"TYPE" => "LIST",
			"DEFAULT" => "ASC",
			"VALUES" => $arSorts,
			"ADDITIONAL_VALUES" => "Y",
		),
		"FILTER_NAME" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("T_IBLOCK_FILTER"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"PROPERTY_CODE" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("T_IBLOCK_PROPERTY"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"VALUES" => $arProperty,
			"ADDITIONAL_VALUES" => "Y",
		),
		"FIELD_CODE" => CIBlockParameters::GetFieldCode(GetMessage("IBLOCK_FIELD"), "DATA_SOURCE"),
		"DETAIL_URL" => CIBlockParameters::GetPathTemplateParam(
			"DETAIL",
			"DETAIL_URL",
			GetMessage("T_IBLOCK_DESC_DETAIL_PAGE_URL"),
			"",
			"URL_TEMPLATES"
		),
		"SECTION_ID" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("IBLOCK_SECTION_ID"),
			"TYPE" => "STRING",
			"DEFAULT" => '',
		),
		"SECTION_CODE" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("IBLOCK_SECTION_CODE"),
			"TYPE" => "STRING",
			"DEFAULT" => '',
		),
		"CACHE_TIME"  =>  array("DEFAULT"=>36000000),
		"CACHE_FILTER" => array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("IBLOCK_CACHE_FILTER"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"CACHE_GROUPS" => array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("CP_BNL_CACHE_GROUPS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		'HIT_PROP' => array(
			'NAME' => GetMessage('HIT_PROP'),
			'DEFAULT' => 'HIT',
			"TYPE" => "LIST",
			"MULTIPLE" => "N",
			"VALUES" => $arProperty_XL,
			"ADDITIONAL_VALUES" => "Y",
		),
		'SHOW_SECTION' => array(
			'NAME' => GetMessage('S_SHOW_SECTION'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y',
		),
		"SHOW_DISCOUNT_TIME" => Array(
			"NAME" => GetMessage("SHOW_DISCOUNT_TIME"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"SHOW_OLD_PRICE" => Array(
			"NAME" => GetMessage("SHOW_OLD_PRICE_NAME"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
			"REFRESH" => "Y",
		),
		"SHOW_DISCOUNT_PRICE" => Array(
			"NAME" => GetMessage("T_SHOW_DISCOUNT_PRICE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
			"HIDDEN" => ($arCurrentValues["SHOW_OLD_PRICE"] == "Y" ? "N" : "Y"),
		),
		// "SHOW_GALLERY" => Array(
		// 	"NAME" => GetMessage("SHOW_GALLERY_NAME"),
		// 	"TYPE" => "CHECKBOX",
		// 	"DEFAULT" => "Y",
		// 	"REFRESH" => "Y",
		// ),
		// "ADD_PICT_PROP" => Array(
		// 	"NAME" => GetMessage("ADD_PICT_PROP_NAME"),
		// 	"TYPE" => "LIST",
		// 	"VALUES" => $arProperty_F,
		// 	"DEFAULT" => "PHOTOS",
		// 	"HIDDEN" => ($arCurrentValues["SHOW_GALLERY"] == "Y" ? "N" : "Y"),
		// ),
		// "MAX_GALLERY_ITEMS" => Array(
		// 	"NAME" => GetMessage("MAX_GALLERY_ITEMS_NAME"),
		// 	"TYPE" => "SELECTBOX",
		// 	"VALUES" => array(2=>2, 3=>3, 4=>4, 5=>5),
		// 	"DEFAULT" => "5",
		// 	"HIDDEN" => ($arCurrentValues["SHOW_GALLERY"] == "Y" ? "N" : "Y"),
		// ),
		'TITLE' => array(
			'NAME' => GetMessage('TITLE'),
			'TYPE' => 'STRING',
			'DEFAULT' => GetMessage('TITLE_DEFAULT'),
		),
		/*'S_ORDER_PRODUCT' => array(
			'NAME' => GetMessage('S_ORDER_PRODUCT'),
			'TYPE' => 'STRING',
			'DEFAULT' => GetMessage('S_ORDER_PRODUCT_TEXT'),
		),
		'S_MORE_PRODUCT' => array(
			'NAME' => GetMessage('S_MORE_PRODUCT'),
			'TYPE' => 'STRING',
			'DEFAULT' => GetMessage('S_MORE_PRODUCT_TEXT'),
		),*/
	),
);

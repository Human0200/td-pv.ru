<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arLongBannerType = [];

$arFromTheme = [];
/* check for custom option */
if (isset($_REQUEST['src_path'])) {
	$_SESSION['src_path_component'] = $_REQUEST['src_path'];
}
if (strpos($_SESSION['src_path_component'], 'custom') === false) {
	$arFromTheme = ["FROM_THEME" => GetMessage("T_FROM_THEME")];
	$arLongBannerType = ["type_1" => GetMessage("T_BANNER_TYPE_TYPE_1")];
}

$arTemplateParameters = array(
	"BANNER_TYPE" => Array(
		"NAME" => GetMessage("T_BANNER_TYPE"),
		"TYPE" => "LIST",
		"REFRESH" => "Y",
		"VALUES" => array_merge(
			$arLongBannerType,
			[
				"type_2" => GetMessage("T_BANNER_TYPE_TYPE_2"),
				"type_3" => GetMessage("T_BANNER_TYPE_TYPE_3"),
				"type_4" => GetMessage("T_BANNER_TYPE_TYPE_4"),
				"type_5" => GetMessage("T_BANNER_TYPE_TYPE_5"),
			],
		),
		"DEFAULT" => "type_2",
	),
	"HEIGHT_BANNER" => Array(
		"NAME" => GetMessage("T_HEIGHT_BANNER"),
		"TYPE" => "LIST",
		"VALUES" => array_merge(
			$arFromTheme,
			[
				"HIGH" => GetMessage("T_HEIGHT_BANNER_TYPE_1"),
				"NORMAL" => GetMessage("T_HEIGHT_BANNER_TYPE_2"),
				"LOW" => GetMessage("T_HEIGHT_BANNER_TYPE_3"),
			],
		),
		"DEFAULT" => "HIGH",
	),
);

if ($arCurrentValues["BANNER_TYPE"] === 'type_1') {
	$arTemplateParameters += array(
		"TIZERS_IBLOCK_ID" => Array(
			"NAME" => GetMessage("TIZERS_IBLOCK_ID_NAME"),
			"TYPE" => "STRING",
		),
		"WIDE_TEXT" => Array(
			"NAME" => GetMessage("T_WIDE_TEXT"),
			"TYPE" => "LIST",
			"VALUES" => array_merge(
				$arFromTheme,
				[
					"Y" => GetMessage("T_YES"),
					"N" => GetMessage("T_NO"),
				],
			),
			"DEFAULT" => "Y",
		),
	);
}
if (!$arCurrentValues["BANNER_TYPE"] || $arCurrentValues["BANNER_TYPE"] === 'type_2') {
	$arTemplateParameters += array(
		"NO_OFFSET_BANNER" => Array(
			"NAME" => GetMessage("T_NO_OFFSET_BANNER"),
			"TYPE" => "LIST",
			"VALUES" => array_merge(
				$arFromTheme,
				[
					"Y" => GetMessage("T_YES"),
					"N" => GetMessage("T_NO"),
				],
			),
			"DEFAULT" => "Y",
		),
		// "SLIDER_ITEMS" => Array(
		// 	"NAME" => GetMessage("T_SLIDER_ITEMS"),
		// 	"TYPE" => "LIST",
		// 	"VALUES" => [
		// 			"1" => 1,
		// 			"2" => 2,
		// 			"3" => 3,
		// 			"4" => 4,
		// 	],
		// 	"DEFAULT" => "3",
		// ),
	);
}
if ($arCurrentValues["BANNER_TYPE"] === 'type_3') {
	$arTemplateParameters += array(
		"NARROW_BANNER" => Array(
			"NAME" => GetMessage("T_NARROW_BANNER"),
			"TYPE" => "LIST",
			"VALUES" => array_merge(
				$arFromTheme,
				[
					"Y" => GetMessage("T_YES"),
					"N" => GetMessage("T_NO"),
				],
			),
			"DEFAULT" => "Y",
		),
		"NO_OFFSET_BANNER" => Array(
			"NAME" => GetMessage("T_NO_OFFSET_BANNER"),
			"TYPE" => "LIST",
			"VALUES" => array_merge(
				$arFromTheme,
				[
					"Y" => GetMessage("T_YES"),
					"N" => GetMessage("T_NO"),
				],
			),
			"DEFAULT" => "Y",
		),
		"BANNER_TYPE_THEME_CHILD" => Array(
			"NAME" => GetMessage("T_BANNER_TYPE_THEME_CHILD"),
			"TYPE" => "STRING",
		),
		"NEWS_COUNT2" => Array(
			"NAME" => GetMessage("T_NEWS_COUNT2"),
			"TYPE" => "STRING",
			"DEFAULT" => "2",
		),
	);
}
if ($arCurrentValues["BANNER_TYPE"] === 'type_4') {
	$arTemplateParameters += array(
		"NARROW_BANNER" => Array(
			"NAME" => GetMessage("T_NARROW_BANNER"),
			"TYPE" => "LIST",
			"VALUES" => array_merge(
				$arFromTheme,
				[
					"Y" => GetMessage("T_YES"),
					"N" => GetMessage("T_NO"),
				],
			),
			"DEFAULT" => "Y",
		),
		"NO_OFFSET_BANNER" => Array(
			"NAME" => GetMessage("T_NO_OFFSET_BANNER"),
			"TYPE" => "LIST",
			"VALUES" => array_merge(
				$arFromTheme,
				[
					"Y" => GetMessage("T_YES"),
					"N" => GetMessage("T_NO"),
				],
			),
			"DEFAULT" => "Y",
		),
		"WIDE_TEXT" => Array(
			"NAME" => GetMessage("T_WIDE_TEXT"),
			"TYPE" => "LIST",
			"VALUES" => array_merge(
				$arFromTheme,
				[
					"Y" => GetMessage("T_YES"),
					"N" => GetMessage("T_NO"),
				],
			),
			"DEFAULT" => "Y",
		),
	);
}
if ($arCurrentValues["BANNER_TYPE"] === 'type_5') {
	$arTemplateParameters += array(
		"NARROW_BANNER" => Array(
			"NAME" => GetMessage("T_NARROW_BANNER"),
			"TYPE" => "LIST",
			"VALUES" => array_merge(
				$arFromTheme,
				[
					"Y" => GetMessage("T_YES"),
					"N" => GetMessage("T_NO"),
				],
			),
			"DEFAULT" => "Y",
		),
		"NO_OFFSET_BANNER" => Array(
			"NAME" => GetMessage("T_NO_OFFSET_BANNER"),
			"TYPE" => "LIST",
			"VALUES" => array_merge(
				$arFromTheme,
				[
					"Y" => GetMessage("T_YES"),
					"N" => GetMessage("T_NO"),
				],
			),
			"DEFAULT" => "Y",
		),
	);
}
?>

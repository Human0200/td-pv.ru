<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arFromTheme = $arTmpConfig = [];
/* check for custom option */
if (isset($_REQUEST['src_path'])) {
	$_SESSION['src_path_component'] = $_REQUEST['src_path'];
}
if (strpos($_SESSION['src_path_component'], 'custom') === false) {
	$arFromTheme = ["FROM_THEME" => GetMessage("V_FROM_THEME")];
	$arTmpConfig["CODE_BLOCK"] = array(
		"NAME" => GetMessage("T_CODE_BLOCK"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	);
}

$arTemplateParameters = array_merge(
	$arTmpConfig,
	array(
		"WIDE" => Array(
			"NAME" => GetMessage("T_NARROW"),
			"TYPE" => "LIST",
			"VALUES" => array_merge(
				$arFromTheme,
				[
					'Y' => GetMessage('V_YES'),
					'N' => GetMessage('V_NO'),
				],
			),
			"DEFAULT" => "N",
		),
		"ITEMS_OFFSET" => Array(
			"NAME" => GetMessage("T_ITEMS_OFFSET"),
			"TYPE" => "LIST",
			"VALUES" => array_merge(
				$arFromTheme,
				[
					'Y' => GetMessage('V_YES'),
					'N' => GetMessage('V_NO'),
				],
			),
			"DEFAULT" => "Y",
		),
		/*"LINES_COUNT" => Array(
			"NAME" => GetMessage("T_LINES_COUNT"),
			"TYPE" => "LIST",
			"VALUES" => $arFromTheme + [
				1 => 1,
				2 => 2,
				3 => 3,
				'ALL' => GetMessage('V_LINES_COUNT_ALL'),
			],
			"DEFAULT" => "1",
		),*/
		"TYPE_BLOCK" => Array(
			"NAME" => GetMessage("T_TYPE_BLOCK"),
			"TYPE" => "LIST",
			"VALUES" => [
				'BIG_BANNER' => GetMessage('V_BIG_BANNER'),
				'BOTTOM_IMG' => GetMessage('V_BOTTOM_IMG'),
				'SM_BANNER' => GetMessage('V_SM_BANNER'),
			],
			"REFRESH" => "Y",
			"DEFAULT" => "BIG_BANNER",
		),
	)
);
if (isset($arCurrentValues['TYPE_BLOCK']) && $arCurrentValues['TYPE_BLOCK'] == 'BOTTOM_IMG') {
	$arTemplateParameters["ELEMENTS_ROW"] = array(
		"NAME" => GetMessage("T_ELEMENTS_ROW"),
		"TYPE" => "LIST",
		"VALUES" => [
			'FROM_THEME' => GetMessage('V_FROM_THEME'),
			2 => 2,
			3 => 3,
			4 => 4
		],
		"HIDDEN" => (isset($arCurrentValues['TYPE_BLOCK']) && $arCurrentValues['TYPE_BLOCK'] == 'BOTTOM_IMG' ? 'N' : 'Y'),
		"DEFAULT" => "2",
	);
}
?>

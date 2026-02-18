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
		"TEXT_CENTER" => Array(
			"NAME" => GetMessage("T_TEXT_CENTER"),
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
		"SHORT_BLOCK" => Array(
			"NAME" => GetMessage("T_SHORT_BLOCK"),
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
		"ELEMENTS_ROW" => Array(
			"NAME" => GetMessage("T_ELEMENTS_ROW"),
			"TYPE" => "LIST",
			"VALUES" => $arFromTheme + 
				[
					'2' => 2,
					'3' => 3,
					'4' => 4
				],
			"DEFAULT" => "2",
		),
		/*"LINES_COUNT" => Array(
			"NAME" => GetMessage("T_LINES_COUNT"),
			"TYPE" => "LIST",
			"VALUES" => array_merge(
				$arFromTheme,
				[
					1 => 1,
					2 => 2,
					3 => 3,
					'ALL' => GetMessage('V_LINES_COUNT_ALL'),
				],
			),
			"DEFAULT" => "1",
		),*/
		"TEXT_POSITION" => Array(
			"NAME" => GetMessage("T_TEXT_POSITION"),
			"TYPE" => "LIST",
			"VALUES" => array_merge(
				$arFromTheme,
				[
					'BG' => GetMessage('V_TEXT_POSITION_BG'),
					'BOTTOM' => GetMessage('V_TEXT_POSITION_BOTTOM'),
				],
			),
			"DEFAULT" => "BG",
		),
	)
);
?>

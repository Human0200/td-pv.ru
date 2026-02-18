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
			"DEFAULT" => "Y",
		),
	)
);
?>

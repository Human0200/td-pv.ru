<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arFromTheme = [];
/* check for custom option */
if (isset($_REQUEST['src_path'])) {
	$_SESSION['src_path_component'] = $_REQUEST['src_path'];
}
if (strpos($_SESSION['src_path_component'], 'custom') === false) {
	$arFromTheme = ["FROM_THEME" => GetMessage("V_FROM_THEME")];
}

$arTemplateParameters = array(
	"WIDE" => Array(
		"NAME" => GetMessage("T_WIDE"),
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
		"DEFAULT" => "N",
    ),
     "ELEMENTS_ROW" => Array(
		"NAME" => GetMessage("T_ELEMENTS_ROW"),
		"TYPE" => "LIST",
		"VALUES" => [1 => 1, 2 => 2],
		"DEFAULT" => "1",
	),
);
?>

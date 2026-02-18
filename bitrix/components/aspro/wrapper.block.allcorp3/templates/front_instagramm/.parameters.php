<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"WIDE" => Array(
		"NAME" => GetMessage("T_NARROW"),
		"TYPE" => "LIST",
		"VALUES" => [
			'FROM_THEME' => GetMessage('V_FROM_THEME'),
			'Y' => GetMessage('V_YES'),
			'N' => GetMessage('V_NO'),
		],
		"DEFAULT" => "N",
    ),
    "ITEMS_OFFSET" => Array(
		"NAME" => GetMessage("T_ITEMS_OFFSET"),
		"TYPE" => "LIST",
		"VALUES" => [
			'FROM_THEME' => GetMessage('V_FROM_THEME'),
			'Y' => GetMessage('V_YES'),
			'N' => GetMessage('V_NO'),
		],
		"DEFAULT" => "Y",
	),
	"SHOW_TITLE" => Array(
		"NAME" => GetMessage("T_SHOW_TITLE"),
		"TYPE" => "LIST",
		"VALUES" => [
			'FROM_THEME' => GetMessage('V_FROM_THEME'),
			'Y' => GetMessage('V_YES'),
			'N' => GetMessage('V_NO'),
		],
		"DEFAULT" => "Y",
	),
	"TITLE_POSITION" => Array(
		"NAME" => GetMessage("T_TITLE_POSITION"),
		"TYPE" => "LIST",
		"VALUES" => [
			'FROM_THEME' => GetMessage('V_FROM_THEME'),
			'NORMAL' => GetMessage('V_TITLE_POSITION_NORMAL'),
			'CENTERED' => GetMessage('V_TITLE_POSITION_CENTER'),
			'LEFT' => GetMessage('V_TITLE_POSITION_LEFT'),
		],
		"DEFAULT" => "Y",
	),
	'SUBTITLE' => array(
		'NAME' => GetMessage('T_SUBTITLE'),
		'TYPE' => 'STRING',
		'DEFAULT' => '',
	),
	"SHOW_PREVIEW_TEXT" => Array(
		"NAME" => GetMessage("T_SHOW_PREVIEW_TEXT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),
	"TYPE_BLOCK" => Array(
		"NAME" => GetMessage("T_TYPE_BLOCK"),
		"TYPE" => "LIST",
		"VALUES" => [
			'TO_ROW' => GetMessage('V_TO_ROW'),
			'WITH_BIG_BLOCK' => GetMessage('V_WITH_BIG_BLOCK'),
		],
		"REFRESH" => "Y",
		"DEFAULT" => "TO_ROW",
	),
);
if (isset($arCurrentValues['TYPE_BLOCK']) && $arCurrentValues['TYPE_BLOCK'] == 'TO_ROW') {
	$arTemplateParameters["ELEMENTS_ROW"] = array(
		"NAME" => GetMessage("T_ELEMENTS_ROW"),
		"TYPE" => "LIST",
		"VALUES" => [
			'FROM_THEME' => GetMessage('V_FROM_THEME'),
			4 => 4,
			5 => 5
		],
		"HIDDEN" => (isset($arCurrentValues['TYPE_BLOCK']) && $arCurrentValues['TYPE_BLOCK'] == 'TO_ROW' ? 'N' : 'Y'),
		"DEFAULT" => "4",
	);
	$arTemplateParameters["LINES_COUNT"] = array(
		"NAME" => GetMessage("T_LINES_COUNT"),
		"TYPE" => "LIST",
		"VALUES" => [
			'FROM_THEME' => GetMessage('V_FROM_THEME'),
			1 => 1,
			2 => 2,
			3 => 3,
			// 'ALL' => GetMessage('V_LINES_COUNT_ALL'),
		],
		"HIDDEN" => (isset($arCurrentValues['TYPE_BLOCK']) && $arCurrentValues['TYPE_BLOCK'] == 'TO_ROW' ? 'N' : 'Y'),
		"DEFAULT" => "1",
	);
}
?>

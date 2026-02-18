<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

$arSort = CIBlockParameters::GetElementSortFields(
	array('SHOWS', 'SORT', 'TIMESTAMP_X', 'NAME', 'ID', 'ACTIVE_FROM', 'ACTIVE_TO'),
	array('KEY_LOWERCASE' => 'Y')
);

$arAscDesc = array(
	"asc" => GetMessage("IBLOCK_SORT_ASC"),
	"desc" => GetMessage("IBLOCK_SORT_DESC"),
);

$arFromTheme = [];
if (isset($_REQUEST['src_path'])) {
	$_SESSION['src_path_component'] = $_REQUEST['src_path'];
}

if (strpos($_SESSION['src_path_component'], 'custom') === false) {
	$arFromTheme = ["FROM_THEME" => GetMessage("V_FROM_THEME")];
}

$arTemplateParameters= Array(
	"API_TOKEN_VK" => array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("API_TOKEN_VK"),
		"TYPE" => "LIST",
		"VALUES" => $arFromTheme,
		"DEFAULT" => "154c43af95f0f92276bc083a7b9556131efe26e0c2543fa59412c38fec6f34757b818084ea505d9c6a819",
		"ADDITIONAL_VALUES" => "Y",
	),
	"GROUP_ID_VK" => array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("COMMUNITY_ID_VK"),
		"TYPE" => "LIST",
		"VALUES" => $arFromTheme,
		"DEFAULT" => "26208053",
		"ADDITIONAL_VALUES" => "Y",
	),
	"VK_TITLE_BLOCK" => array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("VK_TITLE_BLOCK"),
		"TYPE" => "LIST",
		"VALUES" => $arFromTheme,
		"DEFAULT" => GetMessage("VK_TITLE_BLOCK_DEFAULT"),
		"ADDITIONAL_VALUES" => "Y",
	),
	"VK_TITLE_ALL_BLOCK" => array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("VK_TITLE_ALL_BLOCK"),
		"TYPE" => "LIST",
		"VALUES" => $arFromTheme,
		"DEFAULT" => GetMessage("VK_TITLE_ALL_BLOCK_DEFAULT"),
		"ADDITIONAL_VALUES" => "Y",
	),
	"VK_TEXT_LENGTH" => array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("VK_TEXT_LENGTH"),
		"TYPE" => "LIST",
		"VALUES" => $arFromTheme,
		"DEFAULT" => "800",
		"ADDITIONAL_VALUES" => "Y",
	),
	"WIDE" => Array(
		"NAME" => GetMessage("T_NARROW"),
		"TYPE" => "LIST",
		"VALUES" => array_merge(
			$arFromTheme,
			[
				'Y' => GetMessage('V_YES'),
				'N' => GetMessage('V_NO'),
			]
		),
		"DEFAULT" => "N",
    ),
	'TITLE_POSITION' => array(
		"NAME" => GetMessage('TITLE_POSITION'),
		"TYPE" => "LIST",
		"VALUES" => array_merge(
			$arFromTheme,
			[
				'NORMAL' => GetMessage('TITLE_POSITION_NORMAL'),
				'CENTERED' => GetMessage('TITLE_POSITION_CENTER'),
			]
		),
		"DEFAULT" => "FROM_THEME",
	),
	"SHOW_TITLE" => array(
		"NAME" => GetMessage("T_SHOW_TITLE"),
		"TYPE" => "LIST",
		"VALUES" => array_merge(
			$arFromTheme, 
			[
				'Y' => GetMessage('V_YES'),
				'N' => GetMessage('V_NO'),
			]
		),
		"DEFAULT" => true,
	),
	"LINE_ELEMENT_COUNT" => array(
		"NAME" => GetMessage("T_LINE_ELEMENT_COUNT"),
		"TYPE" => "LIST",
		"VALUES" => $arFromTheme + [3 => 3, 4 => 4],
		'DEFAULT' => "4",
	),
);?>
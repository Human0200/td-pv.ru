<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Loader,
	Bitrix\Main\ModuleManager,
	Bitrix\Main\Web\Json,
	Bitrix\Iblock,
	Aspro\Allcorp3\Functions\ExtComponentParameter;

if(
	!Loader::includeModule('iblock') ||
	!Loader::includeModule('aspro.allcorp3')
){
	return;
}

$arFromTheme = [];
/* check for custom option */
if (isset($_REQUEST['src_path'])) {
	$_SESSION['src_path_component'] = $_REQUEST['src_path'];
}
if (strpos($_SESSION['src_path_component'], 'custom') === false) {
	$arFromTheme = ["FROM_THEME" => GetMessage("T_FROM_THEME")];
}

$arAscDesc = array(
	'asc' => GetMessage('IBLOCK_SORT_ASC'),
	'desc' => GetMessage('IBLOCK_SORT_DESC'),
);

$arIBlocks = [];
$rsIBlock = CIBlock::GetList(
	[
		'ID' => 'ASC'
	],
	[
		'TYPE' => $arCurrentValues['IBLOCK_TYPE'], 
		'ACTIVE' => 'Y'
	]
);
while ($arIBlock = $rsIBlock->Fetch()) {
	$arIBlocks[$arIBlock['ID']] = "[{$arIBlock['ID']}] {$arIBlock['NAME']}";
}

$arSKUProperty = $arSKUProperty_X = [];
if ($arCurrentValues['SKU_IBLOCK_ID']) {
	$propertyIterator = Iblock\PropertyTable::getList(array(
		'select' => array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_TYPE', 'MULTIPLE', 'LINK_IBLOCK_ID', 'USER_TYPE', 'SORT'),
		'filter' => array(
			'=IBLOCK_ID' => $arCurrentValues['SKU_IBLOCK_ID'],
			'=ACTIVE' => 'Y'
		),
		'order' => array(
			'SORT' => 'ASC',
			'NAME' => 'ASC'
		)
	));
	while($property = $propertyIterator->fetch()){
		$propertyCode =(string)$property['CODE'];

		if($propertyCode == '')
			$propertyCode = $property['ID'];

		$propertyName = '['.$propertyCode.'] '.$property['NAME'];

		if($property['PROPERTY_TYPE'] != Iblock\PropertyTable::TYPE_FILE){
			$arSKUProperty[$propertyCode] = $propertyName;

			if($property['MULTIPLE'] != 'Y' && $property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_LIST){
				$arSKUProperty_X[$propertyCode] = $propertyName;
			}
		}
	}
	unset($propertyCode, $propertyName, $property, $propertyIterator);

	$arSkuSort = CIBlockParameters::GetElementSortFields(
		array('SHOWS', 'SORT', 'TIMESTAMP_X', 'NAME', 'ID', 'ACTIVE_FROM', 'ACTIVE_TO'),
		array('KEY_LOWERCASE' => 'Y')
	);
}
ExtComponentParameter::init(__DIR__, $arCurrentValues);

$arTemplateFiles = file_exists(__DIR__."/page_blocks") 
	? array_diff(scandir(__DIR__."/page_blocks"), ['..', '.']) 
	: false;

$arComponentTemplates = [];
if ($arTemplateFiles) {
	foreach ($arTemplateFiles as $key => $value) {
		$value = str_replace('.php', '', $value);
		$langName = 'V_TYPE_TEMPLATE_'.strtoupper(str_replace('-', '_', $value));
		$langValue = GetMessage($langName);

		$arComponentTemplates[$value] = $langValue ?  $langValue." (".$value.")" : $value;
	}
}

ExtComponentParameter::addSelectParameter('TYPE_TEMPLATE', [
	'PARENT' => ExtComponentParameter::PARENT_GROUP_BASE,
	'VALUES' => $arComponentTemplates,
	'DEFAULT' => $arComponentTemplates ? reset($arComponentTemplates) : '',
	'REFRESH' => 'Y',
	'SORT' => 999
]);
ExtComponentParameter::addSelectParameter('SKU_SORT_FIELD', [
	'PARENT' => ExtComponentParameter::PARENT_GROUP_ADDITIONAL,
	'VALUES' => $arSkuSort,
	'DEFAULT' => 'name',
	'ADDITIONAL_VALUES' => 'Y',
	'SORT' => 999
]);
ExtComponentParameter::addSelectParameter('SKU_SORT_ORDER', [
	'PARENT' => ExtComponentParameter::PARENT_GROUP_ADDITIONAL,
	'VALUES' => $arAscDesc,
	'SORT' => 999
]);
ExtComponentParameter::addSelectParameter('SKU_SORT_FIELD2', [
	'PARENT' => ExtComponentParameter::PARENT_GROUP_ADDITIONAL,
	'VALUES' => $arSkuSort,
	'ADDITIONAL_VALUES' => 'Y',
	'DEFAULT' => 'sort',
	'SORT' => 999
]);
ExtComponentParameter::addSelectParameter('SKU_SORT_ORDER2', [
	'PARENT' => ExtComponentParameter::PARENT_GROUP_ADDITIONAL,
	'VALUES' => $arAscDesc,
	'SORT' => 999
]);
ExtComponentParameter::appendTo($arTemplateParameters);
$arTemplateParameters = array_merge(
	$arTemplateParameters,
	array(
		'SUBTITLE' => array(
			'NAME' => GetMessage('T_SUBTITLE'),
			'TYPE' => 'STRING',
			'DEFAULT' => '',
		),
		'RIGHT_TITLE' => array(
			'NAME' => GetMessage('T_RIGHT_TITLE'),
			'TYPE' => 'STRING',
			'DEFAULT' => GetMessage('V_RIGHT_TITLE'),
		),
		'RIGHT_LINK' => array(
			'NAME' => GetMessage('T_RIGHT_LINK'),
			'TYPE' => 'STRING',
			'DEFAULT' => 'product/',
		),
		'SHOW_PREVIEW_TEXT' => array(
			'NAME' => GetMessage('T_SHOW_PREVIEW_TEXT'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y',
		),
	)
);
// $arTemplateParameters["SKU_IBLOCK_ID"] = array(
// 	"NAME" => GetMessage("T_SKU_IBLOCK_ID"),
// 	"TYPE" => "LIST",
// 	"VALUES" => $arIBlocks,
// 	"DEFAULT" => "",
// 	"PARENT" => "BASE",
// 	"REFRESH" => "Y",
// );
$arTemplateParameters["PAGE_ELEMENT_COUNT"] = array(
	"NAME" => GetMessage("T_PAGE_ELEMENT_COUNT"),
	"TYPE" => "LIST",
	"VALUES" => $arFromTheme,
	"ADDITIONAL_VALUES" => "Y",
	"DEFAULT" => "",
	"PARENT" => "BASE",
);

if (strpos($arCurrentValues["TYPE_TEMPLATE"], 'catalog_block') !== false || !$arCurrentValues["TYPE_TEMPLATE"]) {
	$arTemplateParameters += array(
		"NARROW" => Array(
			"NAME" => GetMessage("T_NARROW"),
			"TYPE" => "LIST",
			"VALUES" => array_merge(
				$arFromTheme,
				[
					"Y" => GetMessage("T_YES"),
					"N" => GetMessage("T_NO"),
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
					"Y" => GetMessage("T_YES"),
					"N" => GetMessage("T_NO"),
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
					"Y" => GetMessage("T_YES"),
					"N" => GetMessage("T_NO"),
				],
			),
			"DEFAULT" => "N",
		),
		"IMG_CORNER" => Array(
			"NAME" => GetMessage("T_IMG_CORNER"),
			"TYPE" => "LIST",
			"VALUES" => array_merge(
				$arFromTheme,
				[
					"Y" => GetMessage("T_YES"),
					"N" => GetMessage("T_NO"),
				],
			),
			"DEFAULT" => "N",
		),
		"ADVERTISING_ON_MAIN_PAGE" => Array(
			"NAME" => GetMessage("T_ADVERTISING_ON_MAIN_PAGE"),
			"TYPE" => "LIST",
			"VALUES" => array_merge(
				$arFromTheme,
				[
					"Y" => GetMessage("T_YES"),
					"N" => GetMessage("T_NO"),
				],
			),
			"DEFAULT" => "N",
		),
		"ELEMENT_IN_ROW" => Array(
			"NAME" => GetMessage("T_ELEMENT_IN_ROW"),
			"TYPE" => "LIST",
			"VALUES" => array_merge(
				$arFromTheme,
				[
					"3" => GetMessage("V_ELEMENT_IN_ROW_3"),
					"4" => GetMessage("V_ELEMENT_IN_ROW_4"),
				],
			),
			"DEFAULT" => "4",
		),
		"COUNT_ROWS" => Array(
			"NAME" => GetMessage("T_COUNT_ROWS"),
			"TYPE" => "LIST",
			"VALUES" => array_merge(
				$arFromTheme,
				[
					"1" => GetMessage("V_COUNT_ROWS_1"),
					"2" => GetMessage("V_COUNT_ROWS_2"),
					"3" => GetMessage("V_COUNT_ROWS_3"),
					"SHOW_MORE" => GetMessage("V_COUNT_ROWS_SHOW_MORE"),
				],
			),
			"DEFAULT" => "1",
		),
	);
} elseif (strpos($arCurrentValues["TYPE_TEMPLATE"], 'catalog_list') !== false) {
	$arTemplateParameters += array(
		"NARROW" => Array(
			"NAME" => GetMessage("T_NARROW"),
			"TYPE" => "LIST",
			"VALUES" => array_merge(
				$arFromTheme,
				[
					"Y" => GetMessage("T_YES"),
					"N" => GetMessage("T_NO"),
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
					"Y" => GetMessage("T_YES"),
					"N" => GetMessage("T_NO"),
				],
			),
			"DEFAULT" => "Y",
		),
		"COUNT_ROWS" => Array(
			"NAME" => GetMessage("T_COUNT_ROWS"),
			"TYPE" => "LIST",
			"VALUES" => array_merge(
				$arFromTheme,
				[
					"1" => GetMessage("V_COUNT_ROWS_1"),
					"2" => GetMessage("V_COUNT_ROWS_2"),
					"3" => GetMessage("V_COUNT_ROWS_3"),
					"4" => GetMessage("V_COUNT_ROWS_4"),
					"SHOW_MORE" => GetMessage("V_COUNT_ROWS_SHOW_MORE"),
				],
			),
			"DEFAULT" => "1",
		),
		"IMAGES_POSITION" => Array(
			"NAME" => GetMessage("T_IMAGES_POSITION"),
			"TYPE" => "LIST",
			"VALUES" => array_merge(
				$arFromTheme,
				[
					'LEFT' => GetMessage('V_IMAGES_POSITION_LEFT'),
					'RIGHT' => GetMessage('V_IMAGES_POSITION_RIGHT'),
					'RANDOM' => GetMessage('V_IMAGES_POSITION_RANDOM_IMG'),
				],
			),
			"DEFAULT" => "1",
		),
	);
}
?>
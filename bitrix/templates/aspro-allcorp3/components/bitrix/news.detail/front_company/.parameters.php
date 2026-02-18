<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arTmpConfig = [];
/* check for custom option */
if (isset($_REQUEST['src_path'])) {
	$_SESSION['src_path_component'] = $_REQUEST['src_path'];
}
if (strpos($_SESSION['src_path_component'], 'custom') === false) {
	$arTmpConfig = ["ADDITIONAL_VALUES" => "Y"];
}

$arTemplateParameters = array(
	'TYPE_BLOCK' => Array(
		'NAME' => GetMessage('TYPE_BLOCK_NAME'),
		'TYPE' => 'LIST',
		'VALUES' => array(
			'IMG_BOTTOM' => GetMessage('TYPE_BLOCK_TYPE1'),
			'IMG_SIDE' => GetMessage('TYPE_BLOCK_TYPE2'),
			'IMG_SIDE2' => GetMessage('TYPE_BLOCK_TYPE3'),
		),
		'DEFAULT' => 'IMG_BOTTOM',
		'REFRESH' => 'Y',
	),
	'SUBTITLE' => array(
		'NAME' => GetMessage('T_SUBTITLE'),
		'TYPE' => 'STRING',
		'DEFAULT' => '',
	),
	'REGION' => array(
		'NAME' => GetMessage('REGION'),
		'TYPE' => 'STRING',
		'DEFAULT' => '={$arRegion}',
	),
);
if($arCurrentValues["TYPE_BLOCK"] == "IMG_BOTTOM")
{
	$arTemplateParameters["IMAGE_WIDE"] = Array(
		"NAME" => GetMessage("T_WIDE_PICTURE"),
		"TYPE" => "LIST",
		"VALUES" => [
			'Y' => GetMessage('V_YES'),
			'N' => GetMessage('V_NO'),
		],
		"DEFAULT" => "N",
	)+$arTmpConfig;
	$arTemplateParameters["IMAGE_OFFSET"] = Array(
		"NAME" => GetMessage("T_ITEMS_OFFSET"),
		"TYPE" => "LIST",
		"VALUES" => [
			'Y' => GetMessage('V_YES'),
			'N' => GetMessage('V_NO'),
		],
		"DEFAULT" => "N",
	)+$arTmpConfig;
} elseif($arCurrentValues["TYPE_BLOCK"] == "IMG_SIDE") {
	$arTemplateParameters["IMAGE_WIDE"] = Array(
		"NAME" => GetMessage("T_WIDE_PICTURE"),
		"TYPE" => "LIST",
		"VALUES" => [
			'Y' => GetMessage('V_YES'),
			'N' => GetMessage('V_NO'),
		],
		"DEFAULT" => "N",
	)+$arTmpConfig;
	$arTemplateParameters["POSITION_IMAGE_BLOCK"] = Array(
		"NAME" => GetMessage("T_POSITION_IMAGE_BLOCK"),
		"TYPE" => "LIST",
		"VALUES" => [
			'LEFT' => GetMessage('V_POSITION_IMAGE_BLOCK_LEFT'),
			'RIGHT' => GetMessage('V_POSITION_IMAGE_BLOCK_RIGHT'),
		],
		"DEFAULT" => "RIGHT",
	)+$arTmpConfig;
} 
if($arCurrentValues["TYPE_BLOCK"] != "IMG_SIDE") {
	$arTemplateParameters['TIZERS_IBLOCK_ID'] = array(
		'NAME' => GetMessage('TIZERS_IBLOCK_ID_NAME'),
		'TYPE' => 'STRING',
		'DEFAULT' => '',
	);
	$arTemplateParameters['COUNT_BENEFIT'] = array(
		'NAME' => GetMessage('COUNT_BENEFIT_NAME'),
		'TYPE' => 'STRING',
		'DEFAULT' => '4',
	);
	$arTemplateParameters['IMAGE_POSITION_TIZERS'] = array(
		'NAME' => GetMessage('T_IMAGE_POSITION_TIZERS'),
		'TYPE' => 'LIST',
		'VALUES' => array(
			'LEFT' => GetMessage('LEFT'),
			'TOP' => GetMessage('TOP'),
		),
		'DEFAULT' => 'LEFT',
	);
	$arTemplateParameters["IMAGES_TIZERS"] = Array(
		"NAME" => GetMessage("T_IMAGES_TIZERS"),
		"TYPE" => "LIST",
		"VALUES" => [
			'TEXT' => GetMessage('V_IMAGES_TIZERS_TEXT'),
			'PICTURES' => GetMessage('V_IMAGES_TIZERS_PICTURES'),
			'ICONS' => GetMessage('V_IMAGES_TIZERS_ICONS'),
		],
		"DEFAULT" => "ICONS",
	)+$arTmpConfig;
}
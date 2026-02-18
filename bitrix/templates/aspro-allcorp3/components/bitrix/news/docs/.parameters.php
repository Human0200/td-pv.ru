<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/* get component template pages & params array */
$arPageBlocksParams = array();
if(\Bitrix\Main\Loader::includeModule('aspro.allcorp3')){
	$arPageBlocks = CAllcorp3::GetComponentTemplatePageBlocks(__DIR__);
	$arPageBlocksParams = CAllcorp3::GetComponentTemplatePageBlocksParams($arPageBlocks);
	CAllcorp3::AddComponentTemplateModulePageBlocksParams(__DIR__, $arPageBlocksParams); // add option value FROM_MODULE
}

$arTemplateParameters = array_merge($arPageBlocksParams, [
	'SHOW_SECTION_PREVIEW_DESCRIPTION' => [
		'NAME' => Loc::getMessage('SHOW_SECTION_PREVIEW_DESCRIPTION'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
	],
]);

?>
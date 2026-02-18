<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
use \Bitrix\Main\Localization\Loc;

$arTemplateParameters = [
	'SHOW_DETAIL_LINK' => [
		'NAME' => Loc::getMessage('SHOW_DETAIL_LINK'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
	],
	'SHOW_SECTION_PREVIEW_DESCRIPTION' => [
		'NAME' => Loc::getMessage('SHOW_SECTION_PREVIEW_DESCRIPTION'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
	],
	'ITEMS_OFFSET' => [
		'PARENT' => 'LIST_SETTINGS',
		'NAME' => Loc::getMessage('ITEMS_OFFSET'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
	],
];
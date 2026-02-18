<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arTemplateParameters = array(
	'SHOW_DETAIL_LINK' => array(
		'NAME' => GetMessage('T_SHOW_DETAIL_LINK'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
	),
	'TITLE' => array(
		'NAME' => GetMessage('T_TITLE'),
		'TYPE' => 'STRING',
		'DEFAULT' => GetMessage('V_TITLE'),
	),
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
		'DEFAULT' => 'tariffs/',
	),
	'SHOW_PREVIEW_TEXT' => array(
		'NAME' => GetMessage('T_SHOW_PREVIEW_TEXT'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
	),
	'VISIBLE_PROP_COUNT' => array(
		'NAME' => GetMessage('T_VISIBLE_PROP_COUNT'),
		'TYPE' => 'STRING',
		'DEFAULT' => '4',
	),
);
?>

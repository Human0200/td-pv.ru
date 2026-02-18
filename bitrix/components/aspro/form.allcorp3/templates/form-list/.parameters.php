<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
     "TYPE_BLOCK" => Array(
		"NAME" => GetMessage("T_TYPE_BLOCK"),
		'PARENT' => 'FORM_PARAMS',
		"TYPE" => "LIST",
		"VALUES" => [
			"BG_IMG" => GetMessage("BG_IMG"),
			"SIDE_IMG" => GetMessage("SIDE_BG"),
			"COMPACT" => GetMessage("COMPACT"),
		],
		"DEFAULT" => "1",
	),
	'SUBTITLE' => array(
		'PARENT' => 'FORM_PARAMS',
		'NAME' => GetMessage('T_SUBTITLE'),
		'TYPE' => 'STRING',
		'DEFAULT' => '',
	),
	'TITLE' => array(
		'PARENT' => 'FORM_PARAMS',
		'NAME' => GetMessage('T_TITLE'),
		'TYPE' => 'STRING',
		'DEFAULT' => 'Heading',
	),
);
?>

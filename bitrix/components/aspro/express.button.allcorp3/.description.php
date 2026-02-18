<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arComponentDescription = array(
	'NAME' => GetMessage('T_EB_NAME'),
	'DESCRIPTION' => GetMessage('T_EB_DESCRIPTION'),
	'ICON' => '/images/express.button.gif',
	'CACHE_PATH' => 'Y',
	'SORT' => 1011,
	'PATH' => array(
		'ID' => 'aspro',
		'NAME' => GetMessage('T_EB_ASPRO'),
		'SORT' => 2,
	),
);

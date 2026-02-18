<?
use Bitrix\Main\Localization\Loc;

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
Loc::loadMessages(__FILE__);

$arComponentParameters = array(
	'GROUPS' => array(
		'CONFIG' => array(
			'NAME' => GetMessage('TS_P_GROUP_CONFIG_TITLE'),
			'SORT' => '500',
		),
	),
	'PARAMETERS' => array(
	),
);
?>
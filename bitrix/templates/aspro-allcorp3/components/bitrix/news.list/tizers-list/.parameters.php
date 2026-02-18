<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$page = 1;
$arTemplateParameters = array(
	'USE_FILTER_ELEMENTS' => array(
		'NAME' => GetMessage('USE_FILTER_ELEMENTS'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'Y',
	),
);
if($arCurrentValues['USE_FILTER_ELEMENTS'] == 'Y')
{
	$arTemplateParameters['PAGE'] = array(
		'NAME' => GetMessage('PAGE_FILTER_TITLE'),
		'TYPE' => 'TEXT',
		'DEFAULT' => '={$APPLICATION->GetCurPage()}',
	);
}
?>

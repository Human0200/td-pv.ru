<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Web\Json;

if (!Loader::includeModule('iblock'))
	return;

CBitrixComponent::includeComponentClass('bitrix:catalog.section');

/* get component template pages & params array */
$arPageBlocksParams = array();
if(\Bitrix\Main\Loader::includeModule('aspro.allcorp3')){
	$arPageBlocks = CAllcorp3::GetComponentTemplatePageBlocks(__DIR__);
	$arPageBlocksParams = CAllcorp3::GetComponentTemplatePageBlocksParams($arPageBlocks);
	CAllcorp3::AddComponentTemplateModulePageBlocksParams(__DIR__, $arPageBlocksParams, array('SECTION' => 'GALLERY_PAGE', 'OPTION' => 'GALLERY_LIST_PAGE'), 'SECTION_ELEMENTS_TYPE_VIEW'); // add option value FROM_MODULE
	CAllcorp3::AddComponentTemplateModulePageBlocksParams(__DIR__, $arPageBlocksParams, array('SECTION' => 'GALLERY_PAGE', 'OPTION' => 'GALLERY_DETAIL_PAGE'), 'ELEMENT_TYPE_VIEW'); // add option value FROM_MODULE
}

$arTemplateParameters = array_merge($arPageBlocksParams, array(
	'SHOW_FILTER_DATE' => array(
		'PARENT' => 'LIST_SETTINGS',
		'NAME' => GetMessage('SHOW_FILTER_DATE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
	),
));

if(strpos($arCurrentValues['SECTION_ELEMENTS_TYPE_VIEW'], 'list_elements_1') !== false){
	$arTemplateParameters = array_merge($arTemplateParameters, array(
		'ELEMENTS_ITEMS_OFFSET' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTION-ELEMENTS_ITEMS_OFFSET'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y',
		),
		'ELEMENTS_COUNT' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTION-ELEMENTS_ELEMENTS_COUNT'),
			'TYPE' => 'LIST',
			'VALUES' => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
			),
			'DEFAULT' => '3',
		),
		'ITEMS_TYPE' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('ITEMS_TYPE'),
			'TYPE' => 'LIST',
			'VALUES' => array(
				'PHOTOS' => GetMessage('ITEMS_TYPE_PHOTOS'),
				'ALBUM' => GetMessage('ITEMS_TYPE_ALBUM'),
			),
			'DEFAULT' => 'ALBUM',
		),
	));
}

$arTemplateParameters = array_merge($arTemplateParameters, array(
	/*'SET_ELEMENTS_COUNT_FROM_THEME' => array(
		'PARENT' => 'BASE',
		'NAME' => GetMessage('T_SET_ELEMENTS_COUNT_FROM_THEME'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
	),*/
	
	'USE_SHARE' => array(
		'PARENT' => 'DETAIL_SETTINGS',
		'SORT' => 600,
		'NAME' => GetMessage('USE_SHARE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
	),
));
?>
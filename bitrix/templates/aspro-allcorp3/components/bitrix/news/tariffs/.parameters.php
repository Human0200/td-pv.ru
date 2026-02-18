<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader,
	Bitrix\Main\ModuleManager,
	Bitrix\Main\Web\Json,
	Bitrix\Iblock,
	Bitrix\Main\Localization\Loc,
	Aspro\Allcorp3\Functions\ExtComponentParameter;

if(
	!Loader::includeModule('iblock') ||
	!Loader::includeModule('aspro.allcorp3')
){
	return;
}

CBitrixComponent::includeComponentClass('bitrix:catalog.section');

$arTemplateParametersParts = [];

ExtComponentParameter::init(__DIR__, $arCurrentValues);
ExtComponentParameter::addBaseParameters(array(
	array(
		array('SECTION' => 'TARIFFS_PAGE', 'OPTION' => 'SECTIONS_TYPE_VIEW_TARIFFS'),
		'SECTIONS_TYPE_VIEW',
	),
	array(
		array('SECTION' => 'TARIFFS_PAGE', 'OPTION' => 'SECTION_TYPE_VIEW_TARIFFS'),
		'SECTION_TYPE_VIEW',
	),
	array(
		array('SECTION' => 'TARIFFS_PAGE', 'OPTION' => 'ELEMENTS_PAGE_TARIFFS'),
		'SECTION_ELEMENTS_TYPE_VIEW'
	),
	array(
		array('SECTION' => 'TARIFFS_PAGE', 'OPTION' => 'TARIFFS_PAGE_DETAIL'),
		'ELEMENT_TYPE_VIEW'
	),
));

ExtComponentParameter::addRelationBlockParameters(array(
	ExtComponentParameter::RELATION_BLOCK_DESC,
	ExtComponentParameter::RELATION_BLOCK_CHAR,
	ExtComponentParameter::RELATION_BLOCK_DOCS,
	ExtComponentParameter::RELATION_BLOCK_FAQ,
	ExtComponentParameter::RELATION_BLOCK_REVIEWS,
	ExtComponentParameter::RELATION_BLOCK_SALE,
	ExtComponentParameter::RELATION_BLOCK_NEWS,
	ExtComponentParameter::RELATION_BLOCK_ARTICLES,
	ExtComponentParameter::RELATION_BLOCK_SERVICES,
	ExtComponentParameter::RELATION_BLOCK_PROJECTS,
	ExtComponentParameter::RELATION_BLOCK_GOODS,
	array(
		ExtComponentParameter::RELATION_BLOCK_DOPS,
		'additionalParams' => [
			'toggle' => false,
		],		
	),
	ExtComponentParameter::RELATION_BLOCK_COMMENTS,
));

ExtComponentParameter::addOrderBlockParameters(array(
	ExtComponentParameter::ORDER_BLOCK_SALE,
	ExtComponentParameter::ORDER_BLOCK_TABS,
	ExtComponentParameter::ORDER_BLOCK_GALLERY,
	ExtComponentParameter::ORDER_BLOCK_SKU,
	ExtComponentParameter::ORDER_BLOCK_SERVICES,
	ExtComponentParameter::ORDER_BLOCK_PROJECTS,
	ExtComponentParameter::ORDER_BLOCK_NEWS,
	ExtComponentParameter::ORDER_BLOCK_ARTICLES,
	ExtComponentParameter::ORDER_BLOCK_STAFF,
	ExtComponentParameter::ORDER_BLOCK_PARTNERS,
	ExtComponentParameter::ORDER_BLOCK_VACANCY,
	ExtComponentParameter::ORDER_BLOCK_GOODS,
	ExtComponentParameter::ORDER_BLOCK_COMMENTS,
));

ExtComponentParameter::addOrderTabParameters(array(
	ExtComponentParameter::ORDER_BLOCK_DESC,
	ExtComponentParameter::ORDER_BLOCK_CHAR,
	ExtComponentParameter::ORDER_BLOCK_TARIFFS,
	ExtComponentParameter::ORDER_BLOCK_VIDEO,
	ExtComponentParameter::ORDER_BLOCK_DOCS,
	ExtComponentParameter::ORDER_BLOCK_FAQ,
	ExtComponentParameter::ORDER_BLOCK_REVIEWS,
	ExtComponentParameter::ORDER_BLOCK_BUY,
	ExtComponentParameter::ORDER_BLOCK_PAYMENT,
	ExtComponentParameter::ORDER_BLOCK_DELIVERY,
	ExtComponentParameter::ORDER_BLOCK_DOPS,
	ExtComponentParameter::RELATION_BLOCK_COMPLECTS,
));

ExtComponentParameter::addOrderAllParameters(array(
	ExtComponentParameter::ORDER_BLOCK_SALE,
	ExtComponentParameter::ORDER_BLOCK_DESC,
	ExtComponentParameter::ORDER_BLOCK_CHAR,
	ExtComponentParameter::ORDER_BLOCK_REVIEWS,
	ExtComponentParameter::ORDER_BLOCK_GALLERY,
	ExtComponentParameter::ORDER_BLOCK_VIDEO,
	ExtComponentParameter::ORDER_BLOCK_SKU,
	ExtComponentParameter::ORDER_BLOCK_TARIFFS,
	ExtComponentParameter::ORDER_BLOCK_SERVICES,
	ExtComponentParameter::ORDER_BLOCK_PROJECTS,
	ExtComponentParameter::ORDER_BLOCK_NEWS,
	ExtComponentParameter::ORDER_BLOCK_ARTICLES,
	ExtComponentParameter::ORDER_BLOCK_DOCS,
	ExtComponentParameter::ORDER_BLOCK_STAFF,
	ExtComponentParameter::ORDER_BLOCK_FAQ,
	ExtComponentParameter::ORDER_BLOCK_PARTNERS,
	ExtComponentParameter::ORDER_BLOCK_VACANCY,
	ExtComponentParameter::ORDER_BLOCK_GOODS,
	ExtComponentParameter::ORDER_BLOCK_BUY,
	ExtComponentParameter::ORDER_BLOCK_PAYMENT,
	ExtComponentParameter::ORDER_BLOCK_DELIVERY,
	ExtComponentParameter::ORDER_BLOCK_DOPS,
	ExtComponentParameter::ORDER_BLOCK_COMMENTS,
));

ExtComponentParameter::addUseTabParameter('USE_DETAIL_TABS_TARIFFS');

ExtComponentParameter::addCheckBoxParameter('USE_SHARE', [
	"DEFAULT" => "N"
]);
ExtComponentParameter::addCheckBoxParameter('DETAIL_USE_TAGS', [
	"DEFAULT" => "N"
]);
ExtComponentParameter::addCheckBoxParameter('SHOW_CATEGORY', [
	"DEFAULT" => "N"
]);

ExtComponentParameter::appendTo($arTemplateParameters);

if (strpos($arCurrentValues['SECTIONS_TYPE_VIEW'], 'sections_1') !== false) {
	$arTemplateParametersParts[] = array(
		'SECTIONS_ITEMS_OFFSET' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTIONS_ITEMS_OFFSET'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y',
		),
		'SECTIONS_ELEMENTS_COUNT' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTIONS_ELEMENTS_COUNT'),
			'TYPE' => 'LIST',
			'VALUES' => array(
				'2' => '2',
				'3' => '3',
			),
			'DEFAULT' => '2',
		),
		'SECTIONS_IMAGES' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTIONS_IMAGES'),
			'TYPE' => 'LIST',
			'VALUES' => array(
				'ICONS' => GetMessage('IMAGES_ICONS'),
				'ROUND_PICTURES' => GetMessage('IMAGES_ROUND_PICTURES'),
			),
			'DEFAULT' => 'ROUND_PICTURES',
		),
		'SECTIONS_IMAGE_POSITION' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTIONS_IMAGE_POSITION'),
			'TYPE' => 'LIST',
			'VALUES' => array(
				'RIGHT' => GetMessage('IMAGE_POSITION_RIGHT'),
				'LEFT' => GetMessage('IMAGE_POSITION_LEFT'),
			),
			'DEFAULT' => 'LEFT',
		),
	);
}

if (strpos($arCurrentValues['SECTION_TYPE_VIEW'], 'section_1') !== false) {
	$arTemplateParametersParts[] = array(
		'SECTION_ITEMS_OFFSET' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTION_ITEMS_OFFSET'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y',
		),
		'SECTION_ELEMENTS_COUNT' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTION_ELEMENTS_COUNT'),
			'TYPE' => 'LIST',
			'VALUES' => array(
				'2' => '2',
				'3' => '3',
			),
			'DEFAULT' => '2',
		),
		'SECTIONS_IMAGES' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTIONS_IMAGES'),
			'TYPE' => 'LIST',
			'VALUES' => array(
				'ICONS' => GetMessage('IMAGES_ICONS'),
				'ROUND_PICTURES' => GetMessage('IMAGES_ROUND_PICTURES'),
			),
			'DEFAULT' => 'ROUND_PICTURES',
		),
		'SECTION_IMAGE_POSITION' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTION_IMAGE_POSITION'),
			'TYPE' => 'LIST',
			'VALUES' => array(
				'RIGHT' => GetMessage('IMAGE_POSITION_RIGHT'),
				'LEFT' => GetMessage('IMAGE_POSITION_LEFT'),
			),
			'DEFAULT' => 'LEFT',
		),
	);
}

if(strpos($arCurrentValues['SECTION_ELEMENTS_TYPE_VIEW'], 'list_elements_1') !== false) {
	$arTemplateParametersParts[] = array(
		'ELEMENTS_ITEMS_OFFSET' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTION-ELEMENTS_ITEMS_OFFSET'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y',
		),
	);
}
elseif(strpos($arCurrentValues['SECTION_ELEMENTS_TYPE_VIEW'], 'list_elements_2') !== false) {
	$arTemplateParametersParts[] = array(
		'ELEMENTS_ITEMS_OFFSET' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTION-ELEMENTS_ITEMS_OFFSET'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y',
		),
		'ELEMENTS_IMAGES' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTION-ELEMENTS_IMAGES'),
			'TYPE' => 'LIST',
			'VALUES' => array(
				'ICONS' => GetMessage('IMAGES_ICONS'),
				'ROUND_PICTURES' => GetMessage('IMAGES_ROUND_PICTURES'),
			),
			'DEFAULT' => 'ROUND_PICTURES',
		),
	);
}
elseif(strpos($arCurrentValues['SECTION_ELEMENTS_TYPE_VIEW'], 'list_elements_3') !== false) {
	$arTemplateParametersParts[] = array(
		'ELEMENTS_ITEMS_OFFSET' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTION-ELEMENTS_ITEMS_OFFSET'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y',
		),
		'ELEMENTS_IMAGES' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTION-ELEMENTS_IMAGES'),
			'TYPE' => 'LIST',
			'VALUES' => array(
				'ICONS' => GetMessage('IMAGES_ICONS'),
				'ROUND_PICTURES' => GetMessage('IMAGES_ROUND_PICTURES'),
			),
			'DEFAULT' => 'ROUND_PICTURES',
		),
	);
}

$arTemplateParameters['SHOW_DETAIL_LINK'] = [
	'PARENT' => ExtComponentParameter::PARENT_GROUP_LIST,
	'NAME' => Loc::getMessage('SHOW_DETAIL_LINK'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y',
];

$arTemplateParameters = array_merge($arTemplateParameters, array(
	'SHOW_SECTION_PREVIEW_DESCRIPTION' => array(
		'PARENT' => ExtComponentParameter::PARENT_GROUP_LIST,
		'SORT' => 700,
		'NAME' => Loc::getMessage('T_SHOW_SECTION_PREVIEW_DESCRIPTION'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
	),
	'SHOW_SECTION_DESCRIPTION' => array(
		'PARENT' => ExtComponentParameter::PARENT_GROUP_LIST,
		'SORT' => 700,
		'NAME' => Loc::getMessage('T_SHOW_SECTION_DESCRIPTION'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
	),
	'SHOW_SECTION' => array(
		'PARENT' => ExtComponentParameter::PARENT_GROUP_LIST,
		'SORT' => 700,
		'NAME' => Loc::getMessage('T_SHOW_SECTION'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
	),
	"INCLUDE_SUBSECTIONS" => array(
		"PARENT" => ExtComponentParameter::PARENT_GROUP_LIST,
		"NAME" => Loc::getMessage("CP_BC_INCLUDE_SUBSECTIONS"),
		"TYPE" => "LIST",
		"VALUES" => array(
			"Y" => Loc::getMessage('CP_BC_INCLUDE_SUBSECTIONS_ALL'),
			"A" => Loc::getMessage('CP_BC_INCLUDE_SUBSECTIONS_ACTIVE'),
			"N" => Loc::getMessage('CP_BC_INCLUDE_SUBSECTIONS_NO'),
		),
		"DEFAULT" => "Y",
	),
	'SHOW_CHILD_SECTIONS' => array(
		'PARENT' => ExtComponentParameter::PARENT_GROUP_LIST,
		'SORT' => 700,
		'NAME' => Loc::getMessage('SHOW_CHILD_SECTIONS'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
	),
	'SHOW_CHILD_ELEMENTS' => array(
		'PARENT' => ExtComponentParameter::PARENT_GROUP_LIST,
		'SORT' => 700,
		'NAME' => Loc::getMessage('SHOW_CHILD_ELEMENTS'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'Y',
	),
	'LIST_VISIBLE_PROP_COUNT' => array(
		'PARENT' => ExtComponentParameter::PARENT_GROUP_LIST,
		'NAME' => Loc::getMessage('T_LIST_VISIBLE_PROP_COUNT'),
		'TYPE' => 'STRING',
		'DEFAULT' => '4',
		'SORT' => 700,
	),
	'S_ASK_QUESTION' => array(
		'PARENT' => ExtComponentParameter::PARENT_GROUP_DETAIL,
		'SORT' => 700,
		'NAME' => Loc::getMessage('S_ASK_QUESTION'),
		'TYPE' => 'TEXT',
		'DEFAULT' => '',
	),
	'S_ORDER_SERVISE' => array(
		'PARENT' => ExtComponentParameter::PARENT_GROUP_DETAIL,
		'SORT' => 701,
		'NAME' => Loc::getMessage('S_ORDER_SERVISE'),
		'TYPE' => 'TEXT',
		'DEFAULT' => '',
	),
	'FORM_ID_ORDER_SERVISE' => array(
		'PARENT' => ExtComponentParameter::PARENT_GROUP_DETAIL,
		'SORT' => 701,
		'NAME' => Loc::getMessage('T_FORM_ID_ORDER_SERVISE'),
		'TYPE' => 'TEXT',
		'DEFAULT' => '',
	),
	'DETAIL_VISIBLE_PROP_COUNT' => array(
		'PARENT' => ExtComponentParameter::PARENT_GROUP_DETAIL,
		'NAME' => Loc::getMessage('T_DETAIL_VISIBLE_PROP_COUNT'),
		'TYPE' => 'STRING',
		'DEFAULT' => '6',
		'SORT' => 710,
	),
));

if($arCurrentValues['SHOW_CHILD_ELEMENTS'] == 'Y'){
	$arTemplateParameters['SHOW_ELEMENTS_IN_LAST_SECTION'] = array(
		'PARENT' => ExtComponentParameter::PARENT_GROUP_LIST,
		'SORT' => 700,
		'NAME' => Loc::getMessage('SHOW_ELEMENTS_IN_LAST_SECTION'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
	);
}

//merge parameters to one array
foreach ($arTemplateParametersParts as $i => $part) {
	$arTemplateParameters = array_merge($arTemplateParameters, $part);
}?>
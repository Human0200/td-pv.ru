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

$arAscDesc = array(
	'asc' => GetMessage('IBLOCK_SORT_ASC'),
	'desc' => GetMessage('IBLOCK_SORT_DESC'),
);

$arIBlocks = [];
$rsIBlock = CIBlock::GetList(
	[
		'ID' => 'ASC'
	],
	[
		// 'TYPE' => $arCurrentValues['IBLOCK_TYPE'], 
		'ACTIVE' => 'Y'
	]
);
while ($arIBlock = $rsIBlock->Fetch()) {
	$arIBlocks[$arIBlock['ID']] = "[{$arIBlock['ID']}] {$arIBlock['NAME']}";
}

$arSKUProperty = $arSKUProperty_X = [];
if ($arCurrentValues['SKU_IBLOCK_ID']) {
	$propertyIterator = Iblock\PropertyTable::getList(array(
		'select' => array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_TYPE', 'MULTIPLE', 'LINK_IBLOCK_ID', 'USER_TYPE', 'SORT'),
		'filter' => array(
			'=IBLOCK_ID' => $arCurrentValues['SKU_IBLOCK_ID'],
			'=ACTIVE' => 'Y'
		),
		'order' => array(
			'SORT' => 'ASC',
			'NAME' => 'ASC'
		)
	));
	while($property = $propertyIterator->fetch()){
		$propertyCode =(string)$property['CODE'];

		if($propertyCode == '')
			$propertyCode = $property['ID'];

		$propertyName = '['.$propertyCode.'] '.$property['NAME'];

		if($property['PROPERTY_TYPE'] != Iblock\PropertyTable::TYPE_FILE){
			$arSKUProperty[$propertyCode] = $propertyName;

			if($property['MULTIPLE'] != 'Y' && $property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_LIST){
				$arSKUProperty_X[$propertyCode] = $propertyName;
			}
		}
	}
	unset($propertyCode, $propertyName, $property, $propertyIterator);

	$arSkuSort = CIBlockParameters::GetElementSortFields(
		array('SHOWS', 'SORT', 'TIMESTAMP_X', 'NAME', 'ID', 'ACTIVE_FROM', 'ACTIVE_TO'),
		array('KEY_LOWERCASE' => 'Y')
	);
}

$arTemplateParametersParts = [];

ExtComponentParameter::init(__DIR__, $arCurrentValues);
ExtComponentParameter::addBaseParameters(array(
	array(
		array('SECTION' => 'SERVICES_PAGE', 'OPTION' => 'SECTIONS_TYPE_VIEW_SERVICES'),
		'SECTIONS_TYPE_VIEW',
	),
	array(
		array('SECTION' => 'SERVICES_PAGE', 'OPTION' => 'SECTION_TYPE_VIEW_SERVICES'),
		'SECTION_TYPE_VIEW',
	),
	array(
		array('SECTION' => 'SERVICES_PAGE', 'OPTION' => 'ELEMENTS_PAGE_SERVICES'),
		'SECTION_ELEMENTS_TYPE_VIEW'
	),
	array(
		array('SECTION' => 'SERVICES_PAGE', 'OPTION' => 'SERVICES_PAGE_DETAIL'),
		'ELEMENT_TYPE_VIEW'
	),
));

ExtComponentParameter::addRelationBlockParameters(array(
	ExtComponentParameter::RELATION_BLOCK_DESC,
	ExtComponentParameter::RELATION_BLOCK_CHAR,
	array(
		ExtComponentParameter::RELATION_BLOCK_GALLERY,
		'additionalParams' => array(
			'toggle' => true,
			'type' => array(
				ExtComponentParameter::GALLERY_TYPE_BIG,
				ExtComponentParameter::GALLERY_TYPE_SMALL,
			)
		),	
	),
	ExtComponentParameter::RELATION_BLOCK_VIDEO,
	ExtComponentParameter::RELATION_BLOCK_DOCS,
	ExtComponentParameter::RELATION_BLOCK_FAQ,
	ExtComponentParameter::RELATION_BLOCK_REVIEWS,
	ExtComponentParameter::RELATION_BLOCK_VACANCY,
	ExtComponentParameter::RELATION_BLOCK_STAFF,
	ExtComponentParameter::RELATION_BLOCK_SALE,
	ExtComponentParameter::RELATION_BLOCK_NEWS,
	ExtComponentParameter::RELATION_BLOCK_ARTICLES,
	ExtComponentParameter::RELATION_BLOCK_SERVICES,
	ExtComponentParameter::RELATION_BLOCK_PROJECTS,
	ExtComponentParameter::RELATION_BLOCK_PARTNERS,
	ExtComponentParameter::RELATION_BLOCK_GOODS,
	ExtComponentParameter::RELATION_BLOCK_TARIFFS,
	array(
		ExtComponentParameter::RELATION_BLOCK_DOPS,
		'additionalParams' => [
			'toggle' => false,
		],		
	),
	ExtComponentParameter::RELATION_BLOCK_COMMENTS,
));

ExtComponentParameter::addOrderBlockParameters(array(
	ExtComponentParameter::ORDER_BLOCK_ORDER_FORM,
	ExtComponentParameter::ORDER_BLOCK_SALE,
	ExtComponentParameter::ORDER_BLOCK_TIZERS,
	ExtComponentParameter::ORDER_BLOCK_TABS,
	ExtComponentParameter::ORDER_BLOCK_GALLERY,
	ExtComponentParameter::ORDER_BLOCK_SERVICES,
	ExtComponentParameter::ORDER_BLOCK_PROJECTS,
	ExtComponentParameter::ORDER_BLOCK_NEWS,
	ExtComponentParameter::ORDER_BLOCK_ARTICLES,
	ExtComponentParameter::ORDER_BLOCK_STAFF,
	ExtComponentParameter::ORDER_BLOCK_PARTNERS,
	ExtComponentParameter::ORDER_BLOCK_VACANCY,
	ExtComponentParameter::ORDER_BLOCK_GOODS,
	ExtComponentParameter::ORDER_BLOCK_COMMENTS,
	ExtComponentParameter::ORDER_BLOCK_TARIFFS,
));

ExtComponentParameter::addOrderTabParameters(array(
	ExtComponentParameter::ORDER_BLOCK_DESC,
	ExtComponentParameter::ORDER_BLOCK_CHAR,
	ExtComponentParameter::ORDER_BLOCK_VIDEO,
	ExtComponentParameter::ORDER_BLOCK_DOCS,
	ExtComponentParameter::ORDER_BLOCK_FAQ,
	ExtComponentParameter::ORDER_BLOCK_REVIEWS,
	ExtComponentParameter::ORDER_BLOCK_DOPS,
));

ExtComponentParameter::addOrderAllParameters(array(
	ExtComponentParameter::ORDER_BLOCK_ORDER_FORM,
	ExtComponentParameter::ORDER_BLOCK_SALE,
	ExtComponentParameter::ORDER_BLOCK_TIZERS,
	ExtComponentParameter::ORDER_BLOCK_DESC,
	ExtComponentParameter::ORDER_BLOCK_CHAR,
	ExtComponentParameter::ORDER_BLOCK_REVIEWS,
	ExtComponentParameter::ORDER_BLOCK_GALLERY,
	ExtComponentParameter::ORDER_BLOCK_VIDEO,
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
	ExtComponentParameter::ORDER_BLOCK_DOPS,
	ExtComponentParameter::ORDER_BLOCK_COMMENTS,
));

// ExtComponentParameter::addSelectParameter('SKU_PROPERTY_CODE', [
// 	'PARENT' => ExtComponentParameter::PARENT_GROUP_ADDITIONAL,
// 	'VALUES' => $arSKUProperty,
// 	'MULTIPLE' => 'Y',
// 	'SORT' => 999
// ]);
// ExtComponentParameter::addSelectParameter('SKU_TREE_PROPS', [
// 	'PARENT' => ExtComponentParameter::PARENT_GROUP_ADDITIONAL,
// 	'VALUES' => $arSKUProperty_X,
// 	'MULTIPLE' => 'Y',
// 	'SORT' => 999
// ]);
// ExtComponentParameter::addSelectParameter('SKU_SORT_FIELD', [
// 	'PARENT' => ExtComponentParameter::PARENT_GROUP_ADDITIONAL,
// 	'VALUES' => $arSkuSort,
// 	'DEFAULT' => 'name',
// 	'ADDITIONAL_VALUES' => 'Y',
// 	'SORT' => 999
// ]);
ExtComponentParameter::addSelectParameter('SKU_SORT_ORDER', [
	'PARENT' => ExtComponentParameter::PARENT_GROUP_ADDITIONAL,
	'VALUES' => $arAscDesc,
	'SORT' => 999
]);
ExtComponentParameter::addSelectParameter('SKU_SORT_FIELD2', [
	'PARENT' => ExtComponentParameter::PARENT_GROUP_ADDITIONAL,
	'VALUES' => $arSkuSort,
	'ADDITIONAL_VALUES' => 'Y',
	'DEFAULT' => 'sort',
	'SORT' => 999
]);
ExtComponentParameter::addSelectParameter('SKU_SORT_ORDER2', [
	'PARENT' => ExtComponentParameter::PARENT_GROUP_ADDITIONAL,
	'VALUES' => $arAscDesc,
	'SORT' => 999
]);

ExtComponentParameter::addUseTabParameter('USE_DETAIL_TABS_SERVICES');

ExtComponentParameter::addCheckBoxParameter('USE_SHARE', [
	"DEFAULT" => "N"
]);
ExtComponentParameter::addCheckBoxParameter('DETAIL_USE_TAGS', [
	"DEFAULT" => "N"
]);
ExtComponentParameter::addCheckBoxParameter('SHOW_CATEGORY', [
	"DEFAULT" => "N"
]);
ExtComponentParameter::addSelectParameter('PROPERTIES_DISPLAY_TYPE', [
	'VALUES' => [
		"BLOCK" => GetMessage("PROPERTIES_DISPLAY_TYPE_BLOCK"),
		"TABLE" => GetMessage("PROPERTIES_DISPLAY_TYPE_TABLE")
	],
	"DEFAULT" => "TABLE"
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
				'4' => '4',
			),
			'DEFAULT' => '2',
		),
	);
}
elseif (strpos($arCurrentValues['SECTIONS_TYPE_VIEW'], 'sections_2') !== false) {
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
				'4' => '4',
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
				'TRANSPARENT_PICTURES' => GetMessage('IMAGES_TRANSPARENT_PICTURES'),
			),
			'DEFAULT' => 'ROUND_PICTURES',
		),
	);
}
elseif (strpos($arCurrentValues['SECTIONS_TYPE_VIEW'], 'sections_3') !== false) {
	$arTemplateParametersParts[] = array(
		'SECTIONS_ITEMS_OFFSET' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTIONS_ITEMS_OFFSET'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y',
		),
		'SECTIONS_IMAGES' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTIONS_IMAGES'),
			'TYPE' => 'LIST',
			'VALUES' => array(
				'ICONS' => GetMessage('IMAGES_ICONS'),
				'ROUND_PICTURES' => GetMessage('IMAGES_ROUND_PICTURES'),
				'BIG_PICTURES' => GetMessage('IMAGES_BIG_PICTURES'),
				'TRANSPARENT_PICTURES' => GetMessage('IMAGES_TRANSPARENT_PICTURES'),
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
			'DEFAULT' => 'RIGHT',
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
				'4' => '4',
			),
			'DEFAULT' => '2',
		),
	);
}
elseif (strpos($arCurrentValues['SECTION_TYPE_VIEW'], 'section_2') !== false) {
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
				'4' => '4',
			),
			'DEFAULT' => '2',
		),
		'SECTION_IMAGES' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTION_IMAGES'),
			'TYPE' => 'LIST',
			'VALUES' => array(
				'ICONS' => GetMessage('IMAGES_ICONS'),
				'ROUND_PICTURES' => GetMessage('IMAGES_ROUND_PICTURES'),
				'TRANSPARENT_PICTURES' => GetMessage('IMAGES_TRANSPARENT_PICTURES'),
			),
			'DEFAULT' => 'ROUND_PICTURES',
		),
	);
}
elseif (strpos($arCurrentValues['SECTION_TYPE_VIEW'], 'section_3') !== false) {
	$arTemplateParametersParts[] = array(
		'SECTION_ITEMS_OFFSET' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTION_ITEMS_OFFSET'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y',
		),
		'SECTION_IMAGES' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTION_IMAGES'),
			'TYPE' => 'LIST',
			'VALUES' => array(
				'ICONS' => GetMessage('IMAGES_ICONS'),
				'ROUND_PICTURES' => GetMessage('IMAGES_ROUND_PICTURES'),
				'BIG_PICTURES' => GetMessage('IMAGES_BIG_PICTURES'),
				'TRANSPARENT_PICTURES' => GetMessage('IMAGES_TRANSPARENT_PICTURES'),
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
			'DEFAULT' => 'RIGHT',
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
		'ELEMENTS_COUNT' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTION-ELEMENTS_ELEMENTS_COUNT'),
			'TYPE' => 'LIST',
			'VALUES' => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
			),
			'DEFAULT' => '2',
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
		'ELEMENTS_COUNT' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTION-ELEMENTS_ELEMENTS_COUNT'),
			'TYPE' => 'LIST',
			'VALUES' => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
			),
			'DEFAULT' => '2',
		),
		'ELEMENTS_IMAGES' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTION-ELEMENTS_IMAGES'),
			'TYPE' => 'LIST',
			'VALUES' => array(
				'ICONS' => GetMessage('IMAGES_ICONS'),
				'ROUND_PICTURES' => GetMessage('IMAGES_ROUND_PICTURES'),
				'TRANSPARENT_PICTURES' => GetMessage('IMAGES_TRANSPARENT_PICTURES'),
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
				'BIG_PICTURES' => GetMessage('IMAGES_BIG_PICTURES'),
				'TRANSPARENT_PICTURES' => GetMessage('IMAGES_TRANSPARENT_PICTURES'),
			),
			'DEFAULT' => 'ROUND_PICTURES',
		),
		'ELEMENTS_IMAGE_POSITION' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTION-ELEMENTS_IMAGE_POSITION'),
			'TYPE' => 'LIST',
			'VALUES' => array(
				'RIGHT' => GetMessage('IMAGE_POSITION_RIGHT'),
				'LEFT' => GetMessage('IMAGE_POSITION_LEFT'),
			),
			'DEFAULT' => 'RIGHT',
		),
	);
}

$arTemplateParameters['SHOW_DETAIL_LINK'] = [
	'PARENT' => ExtComponentParameter::PARENT_GROUP_LIST,
	'NAME' => Loc::getMessage('SHOW_DETAIL_LINK'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y',
];

$arTemplateParameters["SKU_IBLOCK_ID"] = array(
	"NAME" => GetMessage("T_SKU_IBLOCK_ID"),
	"TYPE" => "LIST",
	"VALUES" => $arIBlocks,
	"DEFAULT" => "",
	"PARENT" => "BASE",
	"REFRESH" => "Y",
);

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
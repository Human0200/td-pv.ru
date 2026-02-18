<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

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
ExtComponentParameter::addBaseParameters([
	[
		 'EXT_PARAMS' => ['SECTION' => 'PROJECT_PAGE', 'OPTION' => 'PROJECTS_PAGE'],
		 'LIST_PARAMS' => 'SECTION_ELEMENTS_TYPE_VIEW',
	],
	[
		'EXT_PARAMS' => ['SECTION' => 'PROJECT_PAGE', 'OPTION' => 'PROJECTS_PAGE_DETAIL'],
		'LIST_PARAMS' => 'ELEMENT_TYPE_VIEW'
	],
]);

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
	array(
		ExtComponentParameter::RELATION_BLOCK_DOPS,
		'additionalParams' => [
			'toggle' => false,
		],		
	),
	ExtComponentParameter::RELATION_BLOCK_COMMENTS,
	ExtComponentParameter::RELATION_BLOCK_TOP_GALLERY,
));

ExtComponentParameter::addOrderBlockParameters(array(
	ExtComponentParameter::ORDER_BLOCK_TIZERS ,
	ExtComponentParameter::ORDER_BLOCK_ORDER_FORM,
	ExtComponentParameter::ORDER_BLOCK_SALE,
	ExtComponentParameter::ORDER_BLOCK_TABS,
	ExtComponentParameter::ORDER_BLOCK_GALLERY,
	ExtComponentParameter::ORDER_BLOCK_SERVICES,
	ExtComponentParameter::ORDER_BLOCK_PROJECTS,
	ExtComponentParameter::ORDER_BLOCK_NEWS,
	ExtComponentParameter::ORDER_BLOCK_ARTICLES,
	ExtComponentParameter::ORDER_BLOCK_STAFF,
	ExtComponentParameter::ORDER_BLOCK_PARTNERS,
	ExtComponentParameter::ORDER_BLOCK_VACANCY,
	ExtComponentParameter::ORDER_BLOCK_MAP,
	ExtComponentParameter::ORDER_BLOCK_GOODS,
	ExtComponentParameter::ORDER_BLOCK_COMMENTS,
));

ExtComponentParameter::addOrderTabParameters(array(
	ExtComponentParameter::ORDER_BLOCK_DESC,
	ExtComponentParameter::ORDER_BLOCK_CHAR,
	ExtComponentParameter::ORDER_BLOCK_VIDEO,
	ExtComponentParameter::ORDER_BLOCK_DOCS,
	ExtComponentParameter::ORDER_BLOCK_FAQ,
	ExtComponentParameter::ORDER_BLOCK_REVIEWS,
	ExtComponentParameter::ORDER_BLOCK_BUY,
	ExtComponentParameter::ORDER_BLOCK_PAYMENT,
	ExtComponentParameter::ORDER_BLOCK_DELIVERY,
	ExtComponentParameter::ORDER_BLOCK_DOPS,
));

ExtComponentParameter::addOrderAllParameters(array(
	ExtComponentParameter::ORDER_BLOCK_TIZERS,
	ExtComponentParameter::ORDER_BLOCK_ORDER_FORM,
	ExtComponentParameter::ORDER_BLOCK_SALE,
	ExtComponentParameter::ORDER_BLOCK_DESC,
	ExtComponentParameter::ORDER_BLOCK_CHAR,
	ExtComponentParameter::ORDER_BLOCK_REVIEWS,
	ExtComponentParameter::ORDER_BLOCK_GALLERY,
	ExtComponentParameter::ORDER_BLOCK_VIDEO,
	ExtComponentParameter::ORDER_BLOCK_SERVICES,
	ExtComponentParameter::ORDER_BLOCK_PROJECTS,
	ExtComponentParameter::ORDER_BLOCK_NEWS,
	ExtComponentParameter::ORDER_BLOCK_ARTICLES,
	ExtComponentParameter::ORDER_BLOCK_DOCS,
	ExtComponentParameter::ORDER_BLOCK_STAFF,
	ExtComponentParameter::ORDER_BLOCK_FAQ,
	ExtComponentParameter::ORDER_BLOCK_PARTNERS,
	ExtComponentParameter::ORDER_BLOCK_VACANCY,
	ExtComponentParameter::ORDER_BLOCK_MAP,
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
ExtComponentParameter::addSelectParameter('SKU_SORT_FIELD', [
	'PARENT' => ExtComponentParameter::PARENT_GROUP_ADDITIONAL,
	'VALUES' => $arSkuSort,
	'DEFAULT' => 'name',
	'ADDITIONAL_VALUES' => 'Y',
	'SORT' => 999
]);
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

ExtComponentParameter::addUseTabParameter('USE_DETAIL_TABS_PROJECTS');
ExtComponentParameter::addTextParameter('T_MAP');

ExtComponentParameter::addCheckBoxParameter('USE_SHARE', [
	"DEFAULT" => "N"
]);
ExtComponentParameter::addCheckBoxParameter('SHOW_CATEGORY', [
	"DEFAULT" => "Y"
]);
ExtComponentParameter::addCheckBoxParameter('DETAIL_USE_TAGS', [
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

if (strpos($arCurrentValues['SECTION_ELEMENTS_TYPE_VIEW'], 'list_elements_1') !== false) {
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
				'3' => '3',
				'4' => '4',
			),
			'DEFAULT' => '3',
		),
	);
}
if (strpos($arCurrentValues['SECTION_ELEMENTS_TYPE_VIEW'], 'list_elements_2') !== false) {
	$arTemplateParametersParts[] = array(
		'ELEMENTS_ITEMS_OFFSET' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTION-ELEMENTS_ITEMS_OFFSET'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y',
		),
		
	);
}
if (strpos($arCurrentValues['SECTION_ELEMENTS_TYPE_VIEW'], 'list_elements_3') !== false) {
	$arTemplateParametersParts[] = array(
		'ELEMENTS_ITEMS_OFFSET' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTION-ELEMENTS_ITEMS_OFFSET'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y',
		),
		'ELEMENTS_IMAGE_POSITION' => array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('SECTION-ELEMENTS_IMAGE_POSITION'),
			'TYPE' => 'LIST',
			'VALUES' => array(
				'LEFT' => GetMessage('IMAGE_POSITION_LEFT'),
				'RIGHT' => GetMessage('IMAGE_POSITION_RIGHT'),
			),
			'DEFAULT' => 'LEFT',
		),
	);
}

$arTemplateParameters['SHOW_DETAIL_LINK'] = [
	'PARENT' => ExtComponentParameter::PARENT_GROUP_LIST,
	'NAME' => Loc::getMessage('SHOW_DETAIL_LINK'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y',
];
// $arTemplateParameters["SKU_IBLOCK_ID"] = array(
// 	"NAME" => GetMessage("T_SKU_IBLOCK_ID"),
// 	"TYPE" => "LIST",
// 	"VALUES" => $arIBlocks,
// 	"DEFAULT" => "",
// 	"PARENT" => "BASE",
// 	"REFRESH" => "Y",
// );

$arTemplateParameters = array_merge($arTemplateParameters, array(
	'MAP_TYPE' => array(
		'PARENT' => ExtComponentParameter::PARENT_GROUP_BASE,
		'SORT' => 250,
		'NAME' => GetMessage('T_MAP_TYPE'),
		'TYPE' => 'LIST',
		'VALUES' => array(
			'YANDEX' => 'Yandex',
			'GOOGLE' => 'Google',
		),
		'DEFAULT' => 'YANDEX',
	),
	"TYPE_HEAD_BLOCK" => array(
		"PARENT" => ExtComponentParameter::PARENT_GROUP_LIST,
		"NAME" => GetMessage("TYPE_HEAD_BLOCK_NAME"),
		"TYPE" => "LIST",
		"VALUES" => array(
			"FROM_MODULE" => GetMessage("FROM_MODULE_PARAMS"), 
			"none" => GetMessage("T_NONE"), 
			"years_mix" => GetMessage("T_YEARS_MIX"), 
			"years_links" => GetMessage("T_YEARS_LINKS"), 
			"sections_mix" => GetMessage("T_SECTIONS_MIX"), 
			"sections_links" => GetMessage("T_SECTIONS_LINKS")
		),
		"DEFAULT" => "FROM_MODULE",
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
	"VISIBLE_PROP_COUNT" => array(
		"PARENT" => ExtComponentParameter::PARENT_GROUP_DETAIL,
		"NAME" => GetMessage("VISIBLE_PROP_COUNT_TITLE"),
		"TYPE" => "STRING",
		"DEFAULT" => "6",
	),
	"TAKE_FILTER_FROM" => array(
		"PARENT" => FILTER_SETTINGS,
		"SORT" => 1,
		"NAME" => GetMessage("TAKE_FILTER_FROM_TITLE"),
		'TYPE' => 'LIST',
		'VALUES' => array(
			"FROM_MODULE" => GetMessage("FROM_MODULE_PARAMS"), 
			'FROM_PARAMETERS' => GetMessage("FROM_PARAMETERS"),
		),
		"DEFAULT" => "FROM_MODULE",
	),
	

));

//merge parameters to one array
foreach ($arTemplateParametersParts as $i => $part) {
	$arTemplateParameters = array_merge($arTemplateParameters, $part);
}?>
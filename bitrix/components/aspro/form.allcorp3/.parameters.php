<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if(!CModule::IncludeModule('iblock')) return;

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock = array();
$rsIBlock = CIBlock::GetList( array('sort' => 'asc'), array('TYPE' => $arCurrentValues['IBLOCK_TYPE'], 'ACTIVE' => 'Y') );
while($arr = $rsIBlock->Fetch()){
	$arIBlock[$arr['CODE']] = '['.$arr['ID'].'] '.$arr['NAME'];
}

if (\Bitrix\Main\Loader::includeModule('form')) {
	$arForms = array();
	$arFilter = [
		'ACTIVE' => 'Y',
	];
	$rsForms = CForm::GetList($by='s_sort', $order='ask', $arFilter, $is_filtered);
	while($arForm = $rsForms->Fetch()){
		$arSid = explode('_', $arForm['SID']);
		$sideID = array_pop($arSid);
		$sid = implode('_', $arSid);

		$arForms[$sid] = '['.$sid.'] '.$arForm['NAME'];
	}
}

$arComponentParameters = array(
	'GROUPS' => array(
		'IBLOCK_PARAMS' => array(
			'SORT' => 110,
			'NAME' => GetMessage('IBLOCK_PARAMS'),
		),
		'FORM_PARAMS' => array(
			'SORT' => 120,
			'NAME' => GetMessage('FORM_PARAMS'),
		),
		'BUTTON_PARAMS' => array(
			'SORT' => 130,
			'NAME' => GetMessage('BUTTON_PARAMS'),
		),
	),
	'PARAMETERS' => array(
		'AJAX_MODE' => array(),
		'IBLOCK_TYPE' => array(
			'PARENT' => 'IBLOCK_PARAMS',
			'NAME' => GetMessage('BN_P_IBLOCK_TYPE'),
			'TYPE' => 'LIST',
			'VALUES' => $arIBlockType,
			'REFRESH' => 'Y',
		),
		'IBLOCK_ID' => array(
			'PARENT' => 'IBLOCK_PARAMS',
			'NAME' => GetMessage('BN_P_IBLOCK'),
			'TYPE' => 'LIST',
			'VALUES' => $arIBlock,
			'REFRESH' => 'Y',
			'ADDITIONAL_VALUES' => 'Y',
		),
		'WEBFORM_ID' => array(
			'PARENT' => 'IBLOCK_PARAMS',
			'NAME' => GetMessage('T_WEBFORM_ID'),
			'TYPE' => 'LIST',
			'VALUES' => $arForms,
			'REFRESH' => 'N',
			'ADDITIONAL_VALUES' => 'Y',
		),
		'CACHE_TIME' => array('DEFAULT' => '3600'),
		"CACHE_GROUPS" => array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("CP_BNL_CACHE_GROUPS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		/*'USE_CAPTCHA' => array(
			'PARENT' => 'FORM_PARAMS',
			'NAME' => GetMessage('USE_CAPTCHA'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'N',
		),
		'IS_PLACEHOLDER' => array(
			'PARENT' => 'FORM_PARAMS',
			'NAME' => GetMessage('IS_PLACEHOLDER'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'N',
		),*/
		/*'SUCCESS_MESSAGE' => array(
			'PARENT' => 'FORM_PARAMS',
			'NAME' => GetMessage('SUCCESS_MESSAGE'),
			'TYPE' => 'STRING',
			'DEFAULT' => GetMessage('DEFAULT_SUCCESS_MESSAGE'),
		),*/
		'SHOW_PREVIEW_TEXT' => array(
			'PARENT' => 'FORM_PARAMS',
			'NAME' => GetMessage('T_SHOW_PREVIEW_TEXT'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y',
		),
		'SEND_BUTTON_NAME' => array(
			'PARENT' => 'BUTTON_PARAMS',
			'NAME' => GetMessage('SEND_BUTTON_NAME'),
			'TYPE' => 'STRING',
			'DEFAULT' => GetMessage('DEFAULT_SEND_BUTTON_NAME'),
		),
		'SEND_BUTTON_CLASS' => array(
			'PARENT' => 'BUTTON_PARAMS',
			'NAME' => GetMessage('SEND_BUTTON_CLASS'),
			'TYPE' => 'STRING',
			'DEFAULT' => 'btn btn-primary',
		),
		/*'DISPLAY_CLOSE_BUTTON' => array(
			'PARENT' => 'BUTTON_PARAMS',
			'NAME' => GetMessage('DISPLAY_CLOSE_BUTTON'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y',
			'REFRESH' => 'Y',
		),*/
	)
);

if (\Bitrix\Main\Loader::includeModule('form')) {
	$arComponentParameters['PARAMETERS']['WEBFORM_ID'] = array(
		'PARENT' => 'IBLOCK_PARAMS',
		'NAME' => GetMessage('T_WEBFORM_ID'),
		'TYPE' => 'LIST',
		'VALUES' => $arForms,
		'REFRESH' => 'N',
		'ADDITIONAL_VALUES' => 'Y',
	);
}
?>
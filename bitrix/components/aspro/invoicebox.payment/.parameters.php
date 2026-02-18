<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/**
 * @var array $arCurrentValues
 */
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentParameters = array(
	"PARAMETERS" => array(
	    'PARTICIPANT_ID' => array(
            'PARENT'    => 'DATA_SOURCE',
            'NAME'      => Loc::getMessage('T_PARTICIPANT_ID'),
            'TYPE'      => 'TEXT',
            'DEFAULT'   => ''
        ),
        'PARTICIPANT_IDENT' => array(
            'PARENT'    => 'DATA_SOURCE',
            'NAME'      => Loc::getMessage('T_PARTICIPANT_IDENT'),
            'TYPE'      => 'TEXT',
            'DEFAULT'   => ''
        ),
        'PARTICIPANT_SIGN' => array(
            'PARENT'    => 'DATA_SOURCE',
            'NAME'      => Loc::getMessage('T_PARTICIPANT_SIGN'),
            'TYPE'      => 'TEXT',
            'DEFAULT'   => ''
        ),
        'ORDER_ID' => array(
            'PARENT'    => 'DATA_SOURCE',
            'NAME'      => Loc::getMessage('T_ORDER_ID'),
            'TYPE'      => 'TEXT',
            'DEFAULT'   => ''
        ),
        'ORDER_AMOUNT' => array(
            'PARENT'    => 'DATA_SOURCE',
            'NAME'      => Loc::getMessage('T_ORDER_AMOUNT'),
            'TYPE'      => 'TEXT',
            'DEFAULT'   => ''
        ),
        'ORDER_CURRENCY_IDENT' => array(
            'PARENT'    => 'DATA_SOURCE',
            'NAME'      => Loc::getMessage('T_ORDER_CURRENCY_IDENT'),
            'TYPE'      => 'TEXT',
            'DEFAULT'   => ''
        ),
        'TESTMODE' => array(
            'PARENT'    => 'DATA_SOURCE',
            'NAME'      => Loc::getMessage('T_TESTMODE'),
            'TYPE'      => 'CHECKBOX',
            'DEFAULT'   => 'Y'
        ),
        /*'URL_RETURNSUCCESS' => array(
            'PARENT'    => 'DATA_SOURCE',
            'NAME'      => Loc::getMessage('T_URL_RETURNSUCCESS'),
            'TYPE'      => 'TEXT',
            'DEFAULT'   => ''
        ),*/
        /*'FAIL_URL' => array(
            'PARENT'    => 'DATA_SOURCE',
            'NAME'      => Loc::getMessage('rover-t__payform-FAIL_URL'),
            'TYPE'      => 'TEXT',
            'DEFAULT'   => ''
        ),
        'REDIRECT_URLS' => array(
            'PARENT'    => 'DATA_SOURCE',
            'NAME'      => Loc::getMessage('rover-t__payform-REDIRECT_URLS'),
            'TYPE'      => 'TEXT',
            'DEFAULT'   => ''
        ),*/
    ),
);
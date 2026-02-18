<?php

use Bitrix\Main\Loader;
use Bitrix\Main\EventManager;

Loader::includeModule('iblock');

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler(
    "iblock",
    "OnBeforeIBlockElementAdd",
    "AddDefaultProperties"
);

function AddDefaultProperties(&$arFields)
{

    $IBLOCK_ID = 70;

    if ($arFields["IBLOCK_ID"] == $IBLOCK_ID) {

        $PROPERTY_FAQ_ID = 781;
        $FAQ_ELEMENT_IDS = [3319,3321,3322,3324,3325,3317];
        if(!empty($arFields["PROPERTY_VALUES"][$PROPERTY_FAQ_ID])) {
            $arFields["PROPERTY_VALUES"][$PROPERTY_FAQ_ID] = array_merge($arFields["PROPERTY_VALUES"][$PROPERTY_FAQ_ID], $FAQ_ELEMENT_IDS);
        }else{
            $arFields["PROPERTY_VALUES"][$PROPERTY_FAQ_ID] = $FAQ_ELEMENT_IDS;
        }

        $PROPERTY_TIZERS_ID = 776;
        $TIZERS_ELEMENT_IDS = [161,164,163];
        if(!empty($arFields["PROPERTY_VALUES"][$PROPERTY_TIZERS_ID])) {
            $arFields["PROPERTY_VALUES"][$PROPERTY_TIZERS_ID] = array_merge($arFields["PROPERTY_VALUES"][$PROPERTY_TIZERS_ID], $TIZERS_ELEMENT_IDS);
        }else{
            $arFields["PROPERTY_VALUES"][$PROPERTY_TIZERS_ID] = $TIZERS_ELEMENT_IDS;
        }

    }

    return true;
}
<?php

include 'custom_aspro.php';
include 'events.php';

// use Bitrix\Sale\Basket;

// AddEventHandler("sale", "OnBasketAdd", "HidePriceForRequest");
// AddEventHandler("sale", "OnBasketUpdate", "HidePriceForRequest");

// function HidePriceForRequest(&$arFields)
// {
//     if (isset($arFields["PRICE"]) && (string)$arFields["PRICE"] === "Цена по запросу") {
//         $arFields["PRICE"] = 0;
//         $arFields["CUSTOM_PRICE"] = "Y";
//     }
// }
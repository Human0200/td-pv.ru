<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

$bGroups = is_array($arResult['GROUPS']) && !empty($arResult['GROUPS']);
$bUseSchema = ($arParams['USE_SCHEMA'] ?? 'Y') !== 'N';
$bOffersMode = $arParams['OFFERS_MODE'] === 'Y';

$template = 'table';
if ($bGroups) {
    $template = 'table-groups';
} elseif ($arResult['DISPLAY_TYPE'] != 'TABLE') {
    $template = 'grid';
}

include 'view/'.$template.'.php';

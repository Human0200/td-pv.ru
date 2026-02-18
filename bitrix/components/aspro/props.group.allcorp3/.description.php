<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

$arComponentDescription = [
    'NAME' => GetMessage('T_ASPRO_PROPS_GROUP_NAME'),
    'DESCRIPTION' => GetMessage('T_ASPRO_PROPS_GROUP_DESCRIPTION'),
    'ICON' => '',
    'CACHE_PATH' => 'Y',
    'PATH' => [
        'ID' => 'aspro',
        'NAME' => GetMessage('ASPRO'),
    ],
    'COMPLEX' => 'N',
];

<?
$arComponentParams = $arParams;
$arGlobalFilter = $bAjax ? $request->getPost("GLOBAL_FILTER") : $request->getQuery('GLOBAL_FILTER');

if (!is_array($arGlobalFilter) && strlen($arGlobalFilter)) {
    $arGlobalFilter = $signer->unsignParameters($this->__component->getName(), $arGlobalFilter);
}

if ($request['GLOBAL_FILTER']) {
    $GLOBALS[$arComponentParams['FILTER_NAME']] = $signer->unsignParameters($this->__component->getName(), $request['GLOBAL_FILTER']);
}

if (is_array($arGlobalFilter) && $arGlobalFilter) {
    $GLOBALS[$arComponentParams["FILTER_NAME"]] = $arGlobalFilter;
}

if ($bAjax && $request->getPost("FILTER_HIT_PROP")) {
    $arComponentParams["FILTER_HIT_PROP"] = $request->getPost("FILTER_HIT_PROP");
}

/* hide compare link from module options */
if (TSolution::GetFrontParametrValue('CATALOG_COMPARE') === 'N') {
    $arComponentParams["DISPLAY_COMPARE"] = 'N';
}


if (TSolution::checkAjaxRequest() && $request['ajax'] === 'y') {
    $arComponentParams['AJAX_REQUEST'] = 'Y';
}

$arComponentParams = array_merge($arComponentParams, [
    'COMPONENT_TEMPLATE' => $arComponentParams['TYPE_TEMPLATE'],
    'SECTION_ID' => $GLOBALS[$arComponentParams["FILTER_NAME"]]['SECTION_ID'],
]);


$APPLICATION->IncludeComponent(
    "bitrix:catalog.section",
    $arComponentParams['TYPE_TEMPLATE'],
    $arComponentParams,
    false, 
    [
        "HIDE_ICONS" => "Y"
    ]
);
?>
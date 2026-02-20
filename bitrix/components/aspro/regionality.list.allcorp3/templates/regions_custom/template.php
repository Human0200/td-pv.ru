<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
if ($arResult['POPUP']) return;
if (!$arResult['CURRENT_REGION']) return;

use \Bitrix\Main\Localization\Loc;
global $arTheme;

$flat      = empty($arResult['SECTION_LEVEL1']) && empty($arResult['SECTION_LEVEL2']);
$currentId = $arResult['CURRENT_REGION']['ID'] ?? null;

$isSameDomain = (
    isset($arTheme['USE_REGIONALITY']['DEPENDENT_PARAMS']['REGIONALITY_TYPE']['VALUE']) &&
    $arTheme['USE_REGIONALITY']['DEPENDENT_PARAMS']['REGIONALITY_TYPE']['VALUE'] === 'SUBDOMAIN' &&
    ($arResult['HOST'] . $_SERVER['HTTP_HOST'] . $arResult['URI'] === ($arResult['REGIONS'][$arResult['REAL_REGION']['ID']]['URL'] ?? ''))
);

$jsRegions = \Bitrix\Main\Config\Option::get(VENDOR_MODULE_ID, 'REGIONALITY_SEARCH_ROW', 'N') != 'Y'
    ? CUtil::PhpToJsObject($arResult['JS_REGIONS'])
    : '{}';

$cities = [];
foreach (($arResult['REGIONS'] ?? []) as $city) {
    $cities[] = [
        'id'        => (int)$city['ID'],
        'name'      => $city['NAME'],
        'url'       => $city['URL'],
        'secId'     => (isset($city['IBLOCK_SECTION_ID']) && $city['IBLOCK_SECTION_ID']) ? (int)$city['IBLOCK_SECTION_ID'] : 0,
        'isCurrent' => ($currentId && $city['ID'] == $currentId),
    ];
}

$sections1 = [];
foreach (($arResult['SECTION_LEVEL1'] ?? []) as $sId => $sec) {
    $sections1[] = ['id' => (int)$sId, 'name' => $sec['NAME']];
}

$sections2 = [];
foreach (($arResult['SECTION_LEVEL2'] ?? []) as $pId => $secs) {
    $children = [];
    foreach ($secs as $sId2 => $sec2) {
        $children[] = ['id' => (int)$sId2, 'name' => $sec2['NAME']];
    }
    $sections2[] = ['pid' => (int)$pId, 'children' => $children];
}

$favs = [];
foreach (($arResult['FAVORITS'] ?? []) as $fav) {
    $favs[] = ['id' => (int)$fav['ID'], 'name' => $fav['NAME'], 'url' => $fav['URL']];
}

$confirmUrl = !$isSameDomain ? ($arResult['REGIONS'][$arResult['REAL_REGION']['ID']]['URL'] ?? '') : '';
?>

<button class="rc-trigger" id="rc-trigger" type="button" onclick="rcOpenModal()">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
    </svg>
    <span class="rc-trigger__name"><?= htmlspecialcharsbx($arResult['CURRENT_REGION']['NAME']) ?></span>
</button>

<script>
var RC = {
    regions:   <?= $jsRegions ?>,
    cities:    <?= json_encode($cities, JSON_UNESCAPED_UNICODE) ?>,
    sections1: <?= json_encode($sections1, JSON_UNESCAPED_UNICODE) ?>,
    sections2: <?= json_encode($sections2, JSON_UNESCAPED_UNICODE) ?>,
    favs:      <?= json_encode($favs, JSON_UNESCAPED_UNICODE) ?>,
    flat:      <?= $flat ? 'true' : 'false' ?>,
    confirm: {
        show:       <?= $arResult['SHOW_REGION_CONFIRM'] ? 'true' : 'false' ?>,
        regionName: <?= json_encode($arResult['REAL_REGION']['NAME'] ?? '', JSON_UNESCAPED_UNICODE) ?>,
        regionId:   <?= (int)($arResult['REAL_REGION']['ID'] ?? 0) ?>,
        regionUrl:  <?= json_encode($confirmUrl, JSON_UNESCAPED_UNICODE) ?>
    }
};
rcShowConfirm();
</script>
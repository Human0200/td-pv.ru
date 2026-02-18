<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>

<?if ($arTheme['PROJECTS_SHOW_HEAD_BLOCK']['VALUE'] == 'Y' && $arParams['TAKE_FILTER_FROM'] !== "FROM_PARAMETERS") {
    $arParams['USE_FILTER'] = "Y";
    if($arParams["FILTER_NAME"] == '' || !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $arParams["FILTER_NAME"])) {
		$arParams["FILTER_NAME"] = "arrFilter";
    }
}elseif ($arParams['TAKE_FILTER_FROM'] === "FROM_PARAMETERS") {
    $arTheme['PROJECTS_SHOW_HEAD_BLOCK']['VALUE'] = $arParams['USE_FILTER'];
}
?>
<? if ($arTheme['PROJECTS_SHOW_HEAD_BLOCK']['VALUE'] == 'Y' && $arParams['USE_FILTER'] !== 'N') : ?>
    <? $bShowYears = in_array($arTheme["PROJECTS_SHOW_HEAD_BLOCK"]["DEPENDENT_PARAMS"]['SHOW_HEAD_BLOCK_TYPE']['VALUE'], ['years_links', 'years_mix']) ?>

    <?
    $bFilterSectionTab = $arTheme["PROJECTS_SHOW_HEAD_BLOCK"]["DEPENDENT_PARAMS"]['SHOW_HEAD_BLOCK_TYPE']['VALUE'] == 'sections_mix';
    $bFilterSectionLink = $arTheme["PROJECTS_SHOW_HEAD_BLOCK"]["DEPENDENT_PARAMS"]['SHOW_HEAD_BLOCK_TYPE']['VALUE'] == 'sections_links';
    $bShowSections = $bFilterSectionTab || $bFilterSectionLink;
    $type = ($bUseMixLink && !$arSection ? 'tab' : 'link') ?>

    <? if ($bShowYears) : ?>
        <? // show years
        ?>
        <? if ($arYears = TSolution\Functions::getItemsYear([
            'FILTER' => $arItemFilter,
            'PARAMS' => $arParams
        ])) {
            $bHasYear = (isset($_GET['year']) && (int)$_GET['year']);
            $year = ($bHasYear ? (int)$_GET['year'] : 0); ?>

            <? TSolution\Functions::showBlockHtml([
                'FILE' => '/filter/years_'.($bUseMixLink && !$bHasYear ? 'tab' : 'link') . '.php',
                'PARAMS' => [
                    'HAS_YEAR' => $bHasYear,
                    'ITEMS' => $arYears,
                    'YEAR' => $year,
                    'ALL_ITEMS_LANG' => 'ALL_TIME',
                ],
            ]) ?>

            <? if ($bHasYear) {
                $GLOBALS[$arParams["FILTER_NAME"]][] = array(
                    ">=DATE_ACTIVE_FROM" => ConvertDateTime("01.01." . $year, FORMAT_DATE, ''),
                    "<DATE_ACTIVE_FROM" => ConvertDateTime("01.01." . ($year + 1), FORMAT_DATE, ''),
                );
            } ?>
        <? } ?>
    <? elseif (
        $bShowSections &&
        (
            (!$arSection && (!$bShowLeftBlock || ($bShowLeftBlock && $bFilterSectionTab))) ||
            ($arSection && !$bShowLeftBlock)
        )
    ) : ?>
        <? // show sections
        ?>
        <? $arFilter = [
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            'ACTIVE' => 'Y',
            'DEPTH_LEVEL' => 1
        ];
        TSolution::makeSectionFilterInRegion($arFilter);
        $arSelect = array('ID', 'SORT', 'IBLOCK_ID', 'NAME', 'SECTION_PAGE_URL');
        $arParentSections = TSolution\Cache::CIBLockSection_GetList(
            array(
                'SORT' => 'ASC',
                'NAME' => 'ASC',
                'CACHE' => array(
                    'TAG' => TSolution\Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']),
                    'MULTI' => 'Y'
                )
            ),
            $arFilter,
            false,
            $arSelect
        ); ?>
        <? if (count($arParentSections) > 1) : ?>
            <? TSolution\Functions::showBlockHtml([
                'FILE' => '/filter/sections_' . $type . '.php',
                'PARAMS' => [
                    'ITEMS' => $arParentSections,
                    'ALL_ITEMS_LANG' => 'ALL_SECTIONS_PROJECT',
                    'BASE_URL' => $arParams['SEF_FOLDER'],
                    'SECTION' => $arSection ?: []
                ],
            ]) ?>
        <? endif; ?>
    <? endif; ?>
    <? if ($bUseMixLink && !$bHasYear && !$arSection) : ?>
        <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/mixitup.min.js'); ?>
        <? $arParams['NEWS_COUNT'] = 9999; ?>
    <? elseif ($type == 'link') : ?>
        <? TSolution\Extensions::init('link_scroll'); ?>
    <? endif; ?>
<? endif; ?>

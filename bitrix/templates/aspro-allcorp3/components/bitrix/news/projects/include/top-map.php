<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>

<?if ($arTheme['SHOW_PROJECTS_MAP']['VALUE'] == 'Y'):?>
    <?
    $mapLAT = $mapLON = $iCountShops =0;
    $arItems = $arSections = $arPlacemarks = [];
    $arItems = CAllcorp3Cache::CIblockElement_GetList(
        array(
            "CACHE" => array(
                "TAG" => CAllcorp3Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"])
            )
        ), 
        $arItemFilter,
        false, 
        false, 
        array('ID', 'NAME', 'PREVIEW_PICTURE', 'PROPERTY_MAP', 'DETAIL_PAGE_URL', 'IBLOCK_SECTION_ID', 'PROPERTY_INFO')
    );

    foreach ($arItems as $arItem) {
        if (!in_array($arItem['IBLOCK_SECTION_ID'] ,$arSections)) {
            if (is_array($arItem['IBLOCK_SECTION_ID'])) {
                foreach ($arItem['IBLOCK_SECTION_ID'] as $tmpSection) {
                    if (!in_array($tmpSection,$arSections)) {
                        $arSections[] = $tmpSection;
                    }
                }
            } else {
                $arSections[] = $arItem['IBLOCK_SECTION_ID'];
            }
        }
    }

    if ($arSections) {
        $arSections = CAllcorp3Cache::CIBlockSection_GetList(
            array(
                "CACHE" => array(
                    "TAG" => CAllcorp3Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]), 
                    "MULTI" => "N", 
                    'GROUP' => 'ID'
                )
            ), 
            array(
                'IBLOCK_ID' => $arParams['IBLOCK_ID'], 
                'ID' => $arSections
            ), 
            false,
            array("ID", 'NAME')
        );
    }

    if ($arItems) {
        foreach ($arItems as $arItem) {
            if ($arItem['PROPERTY_MAP_VALUE']) {
                $arCoords = explode(',', $arItem['PROPERTY_MAP_VALUE']);
                $mapLAT += $arCoords[0];
                $mapLON += $arCoords[1];
                $html = '<div class="pane_info_wrapper"><div class="pane_info clearfix">';
                if ($arItem['PREVIEW_PICTURE']) {
                    $html .= '<div class="image"><a href="'.$arItem['DETAIL_PAGE_URL'].'"><span style="background: url('.CFile::GetPath($arItem['PREVIEW_PICTURE']).') center/cover no-repeat;" data-src></span></a></div>';
                }
                $html .= '<div class="body-info'.(!$arItem['PREVIEW_PICTURE'] ? ' wti' : '').'">';

                if (is_array($arItem['IBLOCK_SECTION_ID']) || is_array($arItem['DETAIL_PAGE_URL'])) {
                    if (is_array($arItem['IBLOCK_SECTION_ID'])) {
                        $firstKey = array_keys($arItem['IBLOCK_SECTION_ID'])[0];
                        if(isset($arSections[$arItem['IBLOCK_SECTION_ID'][$firstKey]]) && $arSections[$arItem['IBLOCK_SECTION_ID'][$firstKey]]['NAME']){
                            $html .= '<div class="section_name font_13 color_999">'.$arSections[$arItem['IBLOCK_SECTION_ID'][$firstKey]]['NAME'].'</div>';
                        }
                    }
                    if (is_array($arItem['DETAIL_PAGE_URL'])) {
                        $firstKey = array_keys($arItem['DETAIL_PAGE_URL'])[0];
                        $html .= '<div class="title font_14 font_bold">'.'<div class="name"><a class="dark-color" href="'.$arItem['DETAIL_PAGE_URL'][$firstKey].'">'.$arItem['NAME'].'</a></div></div>';
                        if (isset($arItem['PROPERTY_INFO_VALUE']) && $arItem['PROPERTY_INFO_VALUE']['TEXT']) {
                            $html .= '<div class="info font_14 color_999">'.$arItem['~PROPERTY_INFO_VALUE']['TEXT'].'</div>';
                        }
                    }
                } else {
                    if (
                        isset($arSections[$arItem['IBLOCK_SECTION_ID']]) && 
                        $arSections[$arItem['IBLOCK_SECTION_ID']]['NAME']
                    ) {
                        $html .= '<div class="section_name font_13 color_999">'.$arSections[$arItem['IBLOCK_SECTION_ID']]['NAME'].'</div>';
                    }
                    $html .= '<div class="title font_14 font_bold">'.'<div class="name"><a class="dark_link" href="'.$arItem['DETAIL_PAGE_URL'].'">'.$arItem['NAME'].'</a></div></div>';
                    if (isset($arItem['PROPERTY_INFO_VALUE']) && $arItem['PROPERTY_INFO_VALUE']['TEXT']) {
                        $html .= '<div class="info font_14 color_999">'.$arItem['~PROPERTY_INFO_VALUE']['TEXT'].'</div>';
                    }
                }
        
                
                $html .= '</div></div></div>';
                $arPlacemarks[] = array(
                    "ID" => $arItem["ID"],
                    "LAT" => $arCoords[0],
                    "LON" => $arCoords[1],
                    "TITLE" => $arItem['NAME'],
                    "TEXT" => $html,
                    "HTML" => $html
                );
                ++$iCountShops;
            }
        }
        if ($iCountShops) {
            $mapLAT = floatval($mapLAT / $iCountShops);
            $mapLON = floatval($mapLON / $iCountShops);?>
            <?ob_start()?>
                <div class="contacts-page-map-top projects no-bottom-margin1">
                    <div class="maxwidth-theme">
                        <div class="bordered rounded-4 map-view">
                            <?if ($arParams['MAP_TYPE'] == 'YANDEX'):?>
                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:map.yandex.view",
                                    "map",
                                    array(
                                        "INIT_MAP_TYPE" => "MAP",
                                        "MAP_DATA" => serialize(array("yandex_lat" => $mapLAT, "yandex_lon" => $mapLON, "yandex_scale" => 19, "PLACEMARKS" => $arPlacemarks)),
                                        "MAP_WIDTH" => "100%",
                                        "MAP_HEIGHT" => "400",
                                        "CONTROLS" => array(
                                            0 => "ZOOM",
                                            1 => "TYPECONTROL",
                                            2 => "SCALELINE",
                                        ),
                                        "OPTIONS" => array(
                                            0 => "ENABLE_DBLCLICK_ZOOM",
                                            1 => "ENABLE_DRAGGING",
                                        ),
                                        "MAP_ID" => "MAP_v33",
                                        "COMPONENT_TEMPLATE" => "map"
                                    ),
                                    false, ['HIDE_ICONS' => 'Y']
                                );?>
                            <?else:?>
                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:map.google.view",
                                    "map",
                                    array(
                                        "INIT_MAP_TYPE" => "MAP",
                                        "MAP_DATA" => serialize(array("google_lat" => $mapLAT, "google_lon" => $mapLON, "google_scale" => 19, "PLACEMARKS" => $arPlacemarks)),
                                        "MAP_WIDTH" => "100%",
                                        "MAP_HEIGHT" => "400",
                                        "CONTROLS" => array(
                                            0 => "ZOOM",
                                            1 => "TYPECONTROL",
                                            2 => "SCALELINE",
                                        ),
                                        "OPTIONS" => array(
                                            0 => "ENABLE_DBLCLICK_ZOOM",
                                            1 => "ENABLE_DRAGGING",
                                        ),
                                        "MAP_ID" => "MAP_v33",
                                        "COMPONENT_TEMPLATE" => "map"
                                    ),
                                    false, ['HIDE_ICONS' => 'Y']
                                );?>
                            <?endif;?>
                        </div>
                    </div>
                </div>
            <?$html=ob_get_clean();?>
            <?$APPLICATION->AddViewContent('top_section_filter_content', $html);?>
        <?}?>
    <?}?>
<?endif;?>
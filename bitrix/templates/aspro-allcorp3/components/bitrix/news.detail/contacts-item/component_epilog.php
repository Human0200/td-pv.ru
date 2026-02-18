<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

CJSCore::Init('aspro_fancybox');
$arExtensions = [];
if ($templateData['PHOTO']) {
    $arExtensions[] = 'owl_gallery';
}

if ($arExtensions) {
    TSolution\Extensions::init($arExtensions);
}
?>

<?$arBlockOrder = explode(",", $arParams['DETAIL_BLOCKS_ORDER']);?>
	<?foreach($arBlockOrder as $code):?>
		<?if(file_exists(__DIR__ . '/epilog_blocks/' . $code . '.php')) :?>
			<?include 'epilog_blocks/'.$code.'.php';?>
		<?endif;?>
	<?endforeach;?>
</div>

<?if($arParams['USE_MAP'] === 'Y'):?>
<?ob_start()?>
<div class="contacts__map-wrapper">
    <div class="sticky-block contacts_map-sticky rounded-4 bordered">
        <?if($typeMap == 'GOOGLE'):?>
            <?$APPLICATION->IncludeComponent(
                "bitrix:map.google.view",
                "map",
                array(
                    "API_KEY" => \Bitrix\Main\Config\Option::get('fileman', 'google_map_api_key', ''),
                    "INIT_MAP_TYPE" => "ROADMAP",
                    "COMPONENT_TEMPLATE" => "map",
                    "COMPOSITE_FRAME_MODE" => "A",
                    "COMPOSITE_FRAME_TYPE" => "AUTO",
                    "CONTROLS" => array(
                        0 => "SMALL_ZOOM_CONTROL",
                        1 => "TYPECONTROL",
                    ),
                    "OPTIONS" => array(
                        0 => "ENABLE_DBLCLICK_ZOOM",
                        1 => "ENABLE_DRAGGING",
                    ),
                    "MAP_DATA" => serialize(array("google_lat" => $templateData['MAP']["mapLAT"], "google_lon" => $templateData['MAP']["mapLON"], "google_scale" => 17, "PLACEMARKS" => $templateData['MAP']["PLACEMARKS"])),
                    "MAP_HEIGHT" => "550px",
                    "MAP_WIDTH" => "100%",
                    "MAP_ID" => "",
                    "ZOOM_BLOCK" => array(
                        "POSITION" => "right center",
                    )
                ),
                false
            );?>
        <?else:?>
            <?$APPLICATION->IncludeComponent(
                "bitrix:map.yandex.view",
                "map",
                array(
                    "API_KEY" => \Bitrix\Main\Config\Option::get('fileman', 'yandex_map_api_key', ''),
                    "INIT_MAP_TYPE" => "MAP",
                    "COMPONENT_TEMPLATE" => "map",
                    "COMPOSITE_FRAME_MODE" => "A",
                    "COMPOSITE_FRAME_TYPE" => "AUTO",
                    "CONTROLS" => array(
                        0 => "ZOOM",
                        1 => "SMALLZOOM",
                        2 => "TYPECONTROL",
                    ),
                    "OPTIONS" => array(
                        0 => "ENABLE_DBLCLICK_ZOOM",
                        1 => "ENABLE_DRAGGING",
                    ),
                    "MAP_DATA" => serialize(array("yandex_lat" => $templateData['MAP']["mapLAT"], "yandex_lon" => $templateData['MAP']["mapLON"], "yandex_scale" => 17, "PLACEMARKS" => $templateData['MAP']["PLACEMARKS"])),
                    "MAP_HEIGHT" => "550px",
                    "MAP_WIDTH" => "100%",
                    "MAP_ID" => "",
                    "ZOOM_BLOCK" => array(
                        "POSITION" => "right center",
                    )
                ),
                false
            );?>
        <?endif;?>
    </div>
</div>
<?$html=ob_get_clean();?>
<?echo $html;?>
<?endif;?>
</div>
</div>


<?$arShop=TSolution\Functions::prepareShopListArray($templateData['MAP_ITEMS'], $arParams);?>
<?$bWide = $arParams['WIDE'] == 'Y';?>
<?$bOffset = $arParams['OFFSET'] == 'Y';?>
<?if($templateData['MAP_ITEMS']):?>

	<?if($arParams['WIDE'] != 'Y'):?>
		<div class="maxwidth-theme">
	<?endif;?>

	<div class="map-view bordered map-view--side-left">
		<?Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID('shops-map-block');?>
			<?if($arParams["MAP_TYPE"] == 1):?>
				<?$APPLICATION->IncludeComponent(
					"bitrix:map.google.view",
					"map",
					array(
						"INIT_MAP_TYPE" => "ROADMAP",
						"MAP_DATA" => serialize(array("google_lat" => $arShop["POINTS"]["LAT"], "google_lon" => $arShop["POINTS"]["LON"], "google_scale" => 16, "PLACEMARKS" => $arShop["PLACEMARKS"])),
						"MAP_WIDTH" => "100%",
						"MAP_HEIGHT" => "600",
						"CONTROLS" => array(
                            0 => "SMALL_ZOOM_CONTROL",
                            1 => "TYPECONTROL",
                        ),
						"OPTIONS" => array(
							0 => "ENABLE_DBLCLICK_ZOOM",
							1 => "ENABLE_DRAGGING",
						),
						"MAP_ID" => "",
						"ZOOM_BLOCK" => array(
							"POSITION" => "right center",
						),
						"COMPONENT_TEMPLATE" => "map",
						"API_KEY" => \Bitrix\Main\Config\Option::get('fileman', 'google_map_api_key', ''),
						"COMPOSITE_FRAME_MODE" => "A",
						"COMPOSITE_FRAME_TYPE" => "AUTO"
					),
					false, array("HIDE_ICONS" =>"Y")
				);?>
			<?else:?>
				<?$APPLICATION->IncludeComponent(
					"bitrix:map.yandex.view",
					"map",
					array(
						"INIT_MAP_TYPE" => "ROADMAP",
						"MAP_DATA" => serialize(array("yandex_lat" => $arShop["POINTS"]["LAT"], "yandex_lon" => $arShop["POINTS"]["LON"], "yandex_scale" => 17, "PLACEMARKS" => $arShop["PLACEMARKS"])),
						"MAP_WIDTH" => "100%",
						"MAP_HEIGHT" => "600",
						"CONTROLS" => array(
                            0 => "ZOOM",
                            1 => "SMALLZOOM",
                            2 => "TYPECONTROL",
                        ),
						"OPTIONS" => array(
							0 => "ENABLE_DBLCLICK_ZOOM",
							1 => "ENABLE_DRAGGING",
						),
						"MAP_ID" => "",
						"ZOOM_BLOCK" => array(
							"POSITION" => "right center",
						),
						"COMPONENT_TEMPLATE" => "map",
						"API_KEY" => \Bitrix\Main\Config\Option::get('fileman', 'yandex_map_api_key', ''),
						"COMPOSITE_FRAME_MODE" => "A",
						"COMPOSITE_FRAME_TYPE" => "AUTO"
					),
					false, array("HIDE_ICONS" =>"Y")
				);?>
			<?endif;?>
		<?Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID('shops-map-block', '');?>
	</div>

	<?if($arParams['WIDE'] != 'Y'):?>
		</div>
	<?endif;?>

		</div>

		<? if($bWide && $bOffset) : ?>
			</div><!-- maxwidth-theme maxwidth-theme--no-maxwidth map-wrapper-offset -->
		<? endif ?>

	</div>
<?endif;?>
<?global $sMenuContent, $isCabinet;?>
<div class="left_block">
	<div class="sticky-block sticky-block--show-<?=CAllcorp3::GetFrontParametrValue('STICKY_SIDEBAR')?>">
		<?if($isCabinet):?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:menu",
				"left",
				array(
					"ROOT_MENU_TYPE" => "cabinet",
					"MENU_CACHE_TYPE" => "A",
					"MENU_CACHE_TIME" => "3600000",
					"MENU_CACHE_USE_GROUPS" => "Y",
					"MENU_CACHE_GET_VARS" => array(
					),
					"MAX_LEVEL" => "4",
					"CHILD_MENU_TYPE" => "left",
					"USE_EXT" => "Y",
					"DELAY" => "N",
					"ALLOW_MULTI_SELECT" => "Y",
					"COMPONENT_TEMPLATE" => "left"
				),
				false
			);?>
		<?else:?>
			<?=$sMenuContent;?>
		<?endif;?>
		<div class="sidearea">
			<?$APPLICATION->ShowViewContent('under_sidebar_content');?>
			<?CAllcorp3::get_banners_position('SIDE');?>
			<div class="include">
			<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "sect", "AREA_FILE_SUFFIX" => "sidebar", "AREA_FILE_RECURSIVE" => "Y"), false);?>
			</div>
		</div>
	</div>
</div>
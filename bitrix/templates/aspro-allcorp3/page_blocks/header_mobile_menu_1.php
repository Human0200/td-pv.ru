<?
include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
include($_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/header/settings.php');

// sites list 
$arShowSites = TSolution\Functions::getShowSites();
$countSites = count($arShowSites);

global $arTheme, $arRegion;
?>
<?if($ajaxBlock === 'MOBILE_MENU_MAIN_PART' && $bAjax){
	$APPLICATION->restartBuffer();
}?>
<div class="mobilemenu mobilemenu_1" data-ajax-load-block="MOBILE_MENU_MAIN_PART">
	<?// close icon?>
	<span class="mobilemenu__close stroke-theme-hover" title="<?=\Bitrix\Main\Localization\Loc::getMessage('CLOSE_BLOCK');?>">
		<?=TSolution::showIconSvg('', SITE_TEMPLATE_PATH.'/images/svg/Close.svg')?>
	</span>

	<div class="mobilemenu__inner">
		<div class="mobilemenu__item">
			<div class="mobilemenu__item-wrapper mobilemenu__item-wrapper--top line-block flexbox--justify-beetwen flexbox--wrap">
				<?// logo?>
				<div class="line-block__item logo no-shrinked <?=$logoClass?>">
					<?TSolution::ShowBufferedMobileLogo();?>
				</div>
				
				<?//show theme selector?>
				<?=TSolution\Functions::showMobileMenuBlock(
					array(
						'PARAM_NAME' => 'MOBILE_MENU_TOGGLE_THEME_SELECTOR',
						'BLOCK_TYPE' => 'THEME_SELECTOR',
						'IS_AJAX' => $bAjax,
						'AJAX_BLOCK' => $ajaxBlock,
						'VISIBLE' => $bShowThemeSelectorMobileMenu,
						'WRAPPER' => 'line-block__item mobilemenu__theme-selector',
					)
				);?>
			</div>
		</div>
		
		<?// top items?>
		<?if(
			($bShowLangMobileMenu && $bShowLangUpMobileMenu && $countSites > 1) ||
			(boolval($arRegion) && $bShowRegionUpMobileMenu) ||
			($bCabinet && $bShowCabinetUpMobileMenu) ||
			($bCompare && $bShowCompareUpMobileMenu) ||
			($bShowCartMobileMenu && $bShowCartUpMobileMenu)
		):?>
			<div class="mobilemenu__item">
				<?=TSolution\Functions::showMobileMenuBlock(
					array(
						'PARAM_NAME' => 'MOBILE_MENU_TOGGLE_LANG',
						'BLOCK_TYPE' => 'LANG',
						'IS_AJAX' => $bAjax,
						'AJAX_BLOCK' => $ajaxBlock,
						'VISIBLE' => $bShowLangMobileMenu && $bShowLangUpMobileMenu && $countSites > 1,
						'WRAPPER' => '',
						'SITE_SELECTOR_NAME' => $siteSelectorName,
						'TEMPLATE' => 'mobile',
						'SITE_LIST' => $arShowSites,
					)
				);?>

				<?// regions?>
				<?=TSolution\Functions::showMobileMenuBlock(
					array(
						'PARAM_NAME' => 'MOBILE_MENU_TOGGLE_REGION',
						'BLOCK_TYPE' => 'REGION',
						'IS_AJAX' => $bAjax,
						'AJAX_BLOCK' => $ajaxBlock,
						'VISIBLE' => boolval($arRegion) && $bShowRegionUpMobileMenu,
						'WRAPPER' => '',
					)
				);?>

				<?// cabinet?>
				<?=TSolution\Functions::showMobileMenuBlock(
					array(
						'PARAM_NAME' => 'MOBILE_MENU_TOGGLE_PERSONAL',
						'BLOCK_TYPE' => 'CABINET',
						'IS_AJAX' => $bAjax,
						'AJAX_BLOCK' => $ajaxBlock,
						'VISIBLE' => $bCabinet && $bShowCabinetUpMobileMenu,
						'WRAPPER' => '',
					)
				);?>
				
				<?// compare?>
				<?=TSolution\Functions::showMobileMenuBlock(
					array(
						'PARAM_NAME' => 'MOBILE_MENU_TOGGLE_COMPARE',
						'BLOCK_TYPE' => 'COMPARE',
						'IS_AJAX' => $bAjax,
						'AJAX_BLOCK' => $ajaxBlock,
						'VISIBLE' => $bCompare && $bShowCompareUpMobileMenu,
						'WRAPPER' => '',
					)
				);?>

				<?// cart?>
				<?=TSolution\Functions::showMobileMenuBlock(
					array(
						'PARAM_NAME' => 'MOBILE_MENU_TOGGLE_CART',
						'BLOCK_TYPE' => 'BASKET',
						'IS_AJAX' => $bAjax,
						'AJAX_BLOCK' => $ajaxBlock,
						'VISIBLE' => $bShowCartMobileMenu && $bShowCartUpMobileMenu && !TSolution::IsBasketPage() && !TSolution::IsOrderPage(),
						'WRAPPER' => '',
					)
				);?>
				
				<div class="mobilemenu__separator"></div>
			</div>
		<?endif;?>

		<div class="mobilemenu__item">
			<?if(TSolution::nlo('menu-mobile', 'class="loadings" style="height:47px;"')):?>
			<!-- noindex -->
			<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
				array(
					"COMPONENT_TEMPLATE" => ".default",
					"PATH" => SITE_DIR."include/header/menu_mobile.php",
					"AREA_FILE_SHOW" => "file",
					"AREA_FILE_SUFFIX" => "",
					"AREA_FILE_RECURSIVE" => "Y",
					"EDIT_TEMPLATE" => "include_area.php"
				),
				false, array("HIDE_ICONS" => "Y")
			);?>	
			<!-- /noindex -->
			<?endif;?>
			<?TSolution::nlo('menu-mobile');?>

			<?// button?>
			<?=TSolution\Functions::showMobileMenuBlock(
				array(
					'PARAM_NAME' => 'MOBILE_MENU_TOGGLE_BUTTON',
					'BLOCK_TYPE' => 'BUTTON',
					'IS_AJAX' => $bAjax,
					'AJAX_BLOCK' => $ajaxBlock,
					'VISIBLE' => $bShowButtonMobileMenu,
					'WRAPPER' => '',
					'CLASS' => 'font_14',
				)
			);?>
		
			<?=TSolution\Functions::showMobileMenuBlock(
				array(
					'PARAM_NAME' => 'MOBILE_MENU_TOGGLE_LANG',
					'BLOCK_TYPE' => 'LANG',
					'IS_AJAX' => $bAjax,
					'AJAX_BLOCK' => $ajaxBlock,
					'VISIBLE' => $bShowLangMobileMenu && !$bShowLangUpMobileMenu && $countSites > 1,
					'WRAPPER' => '',
					'SITE_SELECTOR_NAME' => $siteSelectorName,
					'TEMPLATE' => 'mobile',
					'SITE_LIST' => $arShowSites,
				)
			);?>

			<?// regions?>
			<?=TSolution\Functions::showMobileMenuBlock(
				array(
					'PARAM_NAME' => 'MOBILE_MENU_TOGGLE_REGION',
					'BLOCK_TYPE' => 'REGION',
					'IS_AJAX' => $bAjax,
					'AJAX_BLOCK' => $ajaxBlock,
					'VISIBLE' => boolval($arRegion) && !$bShowRegionUpMobileMenu,
					'WRAPPER' => '',
				)
			);?>

			<?// cabinet?>
			<?=TSolution\Functions::showMobileMenuBlock(
				array(
					'PARAM_NAME' => 'MOBILE_MENU_TOGGLE_PERSONAL',
					'BLOCK_TYPE' => 'CABINET',
					'IS_AJAX' => $bAjax,
					'AJAX_BLOCK' => $ajaxBlock,
					'VISIBLE' => $bCabinet && !$bShowCabinetUpMobileMenu,
					'WRAPPER' => '',
				)
			);?>

			<?// compare?>
			<?=TSolution\Functions::showMobileMenuBlock(
				array(
					'PARAM_NAME' => 'MOBILE_MENU_TOGGLE_COMPARE',
					'BLOCK_TYPE' => 'COMPARE',
					'IS_AJAX' => $bAjax,
					'AJAX_BLOCK' => $ajaxBlock,
					'VISIBLE' => $bCompare && !$bShowCompareUpMobileMenu,
					'WRAPPER' => '',
				)
			);?>

			<?// cart?>
			<?=TSolution\Functions::showMobileMenuBlock(
				array(
					'PARAM_NAME' => 'MOBILE_MENU_TOGGLE_CART',
					'BLOCK_TYPE' => 'BASKET',
					'IS_AJAX' => $bAjax,
					'AJAX_BLOCK' => $ajaxBlock,
					'VISIBLE' => $bShowCartMobileMenu && !$bShowCartUpMobileMenu && !TSolution::IsBasketPage() && !TSolution::IsOrderPage(),
					'WRAPPER' => '',
				)
			);?>
			
			<?foreach(GetModuleEvents(TSolution::moduleID, 'OnAsproHeaderMobileMenuWidget', true) as $arEvent) // event for manipulation widget
				echo ExecuteModuleEventEx($arEvent, array($bAjax, $ajaxBlock, $bShowWidgetMobileMenu));?>

			<?if(
				$bShowPhoneMobileMenu ||
				$bShowAddressMobileMenu ||
				$bShowEmailMobileMenu ||
				$bShowScheduleMobileMenu ||
				$bShowSocialMobileMenu
			):?>
				<div class="mobilemenu__separator"></div>
			<?endif;?>
		</div>

		<?// top items?>
		<?if(
			$bShowPhoneMobileMenu ||
			$bShowAddressMobileMenu ||
			$bShowEmailMobileMenu ||
			$bShowScheduleMobileMenu ||
			$bShowSocialMobileMenu
		):?>
			<div class="mobilemenu__item">
				<?=TSolution\Functions::showMobileMenuBlock(
					array(
						'PARAM_NAME' => 'MOBILE_MENU_TOGGLE_CONTACTS',
						'BLOCK_TYPE' => 'CONTACTS',
						'IS_AJAX' => $bAjax,
						'AJAX_BLOCK' => $ajaxBlock,
						'VISIBLE' => $bShowPhoneMobileMenu || $bShowAddressMobileMenu || $bShowEmailMobileMenu || $bShowScheduleMobileMenu,
						'WRAPPER' => '',
						'PHONES' => $bShowPhoneMobileMenu,
						'CALLBACK' => $bShowCallbackMobileMenu,
						'ADDRESS' => $bShowAddressMobileMenu,
						'EMAIL' => $bShowEmailMobileMenu,
						'SCHEDULE' => $bShowScheduleMobileMenu,
					)
				);?>

				<?// social?>
				<?=TSolution\Functions::showMobileMenuBlock(
					array(
						'PARAM_NAME' => 'MOBILE_MENU_TOGGLE_SOCIAL',
						'BLOCK_TYPE' => 'SOCIAL',
						'IS_AJAX' => $bAjax,
						'AJAX_BLOCK' => $ajaxBlock,
						'VISIBLE' => $bShowSocialMobileMenu,
						'WRAPPER' => '',
						'HIDE_MORE' => false,
					)
				);?>
			</div>
		<?endif;?>
	</div>
</div>
<?if($ajaxBlock === 'MOBILE_MENU_MAIN_PART' && $bAjax){
	?>
	<script>
		BX.onCustomEvent('onChangeThemeColor', [{}])
	</script>
	<?
	die();
}?>
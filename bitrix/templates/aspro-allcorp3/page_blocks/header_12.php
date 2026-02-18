<?
include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
include($_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/header/settings.php');

global $bodyDopClass, $bHideLeftBlock, $sideMenuHeader, $arMergeOptions;
$sideMenuHeader = true;
$bSwitcher = $arTheme['THEME_SWITCHER']['VALUE'] == 'Y';
if( $_COOKIE["side_menu"] !== "Y" && $bSwitcher ){
	$arMergeOptions['SIDE_MENU'] = 'RIGHT';
}

$bodyDopClass .= ' header_padding-100';
$bodyDopClass .= ' left_header_column';

/* set classes for header parts */
$mainPartClasses = '';
$mainPartClasses .= ' header--color_'.$mainBlockColor;
$mainPartClasses .= ' header__main-part--can-transparent';
$mainPartClasses .= ' header__main-part--bordered bg_none';

/* hide left_menu in catalog list */
$bHideLeftBlock = true;
$innerClasses = ' bg_none';
?>

<header class="header_12 z-max header <?=($arRegion ? 'header--with_regions' : '')?> <?=TSolution::ShowPageProps('HEADER_COLOR')?>">
	<div class="header__inner">

		<?if($ajaxBlock == "HEADER_MAIN_PART" && $bAjax) {
			$APPLICATION->restartBuffer();
		}?>

		<div class="header__main-part  <?=$mainPartClasses?> sliced"  data-ajax-load-block="HEADER_MAIN_PART">

			<?if($bNarrowHeader):?>
				<div class="maxwidth-theme">
			<?endif;?>

			<div class="header__main-inner <?=$innerClasses?>">

				<div class="header__flex-part header__flex-part--left">
					<?//check slogan text?>
					<?
					$blockOptions = array(
						'PARAM_NAME' => 'HEADER_TOGGLE_SLOGAN',
						'BLOCK_TYPE' => 'SLOGAN',
						'IS_AJAX' => $bAjax,
						'AJAX_BLOCK' => $ajaxBlock,
						'VISIBLE' => $bShowSlogan,
						'WRAPPER' => 'header__main-item hide-1600',
					);
					?>
					<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

					<div class="header__main-item">
						<div class="line-block line-block--40">
							<?if($arRegion):?>
								<?//regions?>
								<div class="line-block__item icon-block--with_icon icon-block--only_icon-1100">
									<?
									$arRegionsParams = array();
									if($bAjax) {
										$arRegionsParams['POPUP'] = 'N';
									}
									TSolution::ShowListRegions($arRegionsParams);?>
								</div>
							<?endif;?>

							<?//show phone and callback?>
							<?
							$arDropdownCallback = explode(",", $arTheme['SHOW_DROPDOWN_CALLBACK']['VALUE']);
							$bDropdownCallback =  in_array('HEADER', $arDropdownCallback) ? 'Y' : 'N';
			
							$arDropdownEmail = explode(",", $arTheme['SHOW_DROPDOWN_EMAIL']['VALUE']);
							$bDropdownEmail =  in_array('HEADER', $arDropdownEmail) ? 'Y' : 'N';
			
							$arDropdownSocial = explode(",", $arTheme['SHOW_DROPDOWN_SOCIAL']['VALUE']);
							$bDropdownSocial =  in_array('HEADER', $arDropdownSocial) ? 'Y' : 'N';
			
							$arDropdownAddress = explode(",", $arTheme['SHOW_DROPDOWN_ADDRESS']['VALUE']);
							$bDropdownAddress =  in_array('HEADER', $arDropdownAddress) ? 'Y' : 'N';
			
							$arDropdownSchedule = explode(",", $arTheme['SHOW_DROPDOWN_SCHEDULE']['VALUE']);
							$bDropdownSchedule =  in_array('HEADER', $arDropdownSchedule) ? 'Y' : 'N';

							$blockOptions = array(
								'PARAM_NAME' => 'HEADER_TOGGLE_PHONE',
								'BLOCK_TYPE' => 'PHONE',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bShowPhone && $bPhone,
								'WRAPPER' => 'line-block__item no-shrinked icon-block--only_icon-1100',
								'CALLBACK' => $bShowCallback && $bCallback,
								'CALLBACK_CLASS' => 'hide-1300',
								'MESSAGE' => GetMessage("S_CALLBACK"),
								'DROPDOWN_CALLBACK' =>  $bDropdownCallback,
								'DROPDOWN_EMAIL' => $bDropdownEmail,
								'DROPDOWN_SOCIAL' =>  $bDropdownSocial,
								'DROPDOWN_ADDRESS' =>  $bDropdownAddress,
								'DROPDOWN_SCHEDULE' =>  $bDropdownSchedule,
							);
							?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>
						</div>
					</div>
				</div>

				<div class="header__flex-part header__flex-part--right">
					<div class="header__main-item">
						<div class="line-block line-block--40  line-block--24-1200">
							<?//show site list?>
							<?
							$arShowSites = TSolution\Functions::getShowSites();
							$countSites = count($arShowSites);
							$blockOptions = array(
								'PARAM_NAME' => 'HEADER_TOGGLE_LANG',
								'BLOCK_TYPE' => 'LANG',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bShowLang && $countSites > 1,
								'WRAPPER' => 'line-block__item icon-block--only_icon-1300',
								'ONLY_ICON' => true,
								'SITE_SELECTOR_NAME' => $siteSelectorName,
								'TEMPLATE' => 'main',
								'SITE_LIST' => $arShowSites,
							);
							?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

							<?//show theme selector?>
							<?
							$blockOptions = array(
								'PARAM_NAME' => 'HEADER_TOGGLE_THEME_SELECTOR',
								'BLOCK_TYPE' => 'THEME_SELECTOR',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bShowThemeSelector,
								'WRAPPER' => 'line-block__item',
							);
							?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

							<?
							$blockOptions = array(
								'PARAM_NAME' => 'HEADER_TOGGLE_EYED',
								'BLOCK_TYPE' => 'EYED',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bShowEyed,
								'WRAPPER' => 'line-block__item',
							);
							?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

							<?
							$blockOptions = array(
								'PARAM_NAME' => 'HEADER_TOGGLE_SEARCH',
								'BLOCK_TYPE' => 'SEARCH',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bShowSearch,
								'WRAPPER' => 'line-block__item',
							);
							?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

							<?$blockOptions = array(
								'PARAM_NAME' => 'HEADER_TOGGLE_CABINET',
								'BLOCK_TYPE' => 'CABINET',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bCabinet,
								'WRAPPER' => 'line-block__item  hide-name-narrow',
							);?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>
							
							<?$blockOptions = array(
								'PARAM_NAME' => 'HEADER_TOGGLE_COMPARE',
								'BLOCK_TYPE' => 'COMPARE',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bCompare,
								'WRAPPER' => 'line-block__item hide-name-narrow',
								'MESSAGE' => \Bitrix\Main\Localization\Loc::getMessage('COMPARE_TEXT'),
								'CLASS_LINK' => 'light-opacity-hover fill-theme-hover banner-light-icon-fill',
								'CLASS_ICON' => 'menu-light-icon-fill ',
							);?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

							<?$blockOptions = array(
								'PARAM_NAME' => 'HEADER_TOGGLE_BASKET',
								'BLOCK_TYPE' => 'BASKET',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bOrder && !TSolution::IsBasketPage() && !TSolution::IsOrderPage(),
								'WRAPPER' => 'line-block__item',
								'MESSAGE' => '',
							);?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

							<?
							$blockOptions = array(
								'PARAM_NAME' => 'HEADER_TOGGLE_BUTTON',
								'BLOCK_TYPE' => 'BUTTON',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bShowButton,
								'WRAPPER' => 'line-block__item',
								'MESSAGE' => GetMessage("S_CALLBACK"),
							);
							?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

							<?
							$blockOptions = array(
								'PARAM_NAME' => 'HEADER_TOGGLE_MEGA_MENU_RIGHT',
								'BLOCK_TYPE' => 'MEGA_MENU',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bShowMegaMenu && $bRightMegaMenu,
								'WRAPPER' => 'line-block__item',
							);
							?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>
						</div>
					</div>
				

					
				</div>
			</div>

			<?if($bNarrowHeader):?>
				</div>
			<?endif;?>	
		</div>

		<?if($ajaxBlock == "HEADER_MAIN_PART" && $bAjax) {
			die();
		}?>

		<?if($ajaxBlock == "HEADER_SIDE_COLUMN_PART" && $bAjax) {
			$APPLICATION->restartBuffer();
		}?>

		<div class="header__side-column-part"  data-ajax-load-block="HEADER_SIDE_COLUMN_PART">
			<div class="header__side-item">
				<div class="header__side-item--row header__side-top">
					<?//show logo?>
					<div class="logo no-shrinked <?=$logoClass?>">
						<?TSolution::ShowBufferedLogo();?>
					</div>

					<?
					$blockOptions = array(
						'PARAM_NAME' => 'HEADER_TOGGLE_MEGA_MENU',
						'BLOCK_TYPE' => 'MEGA_MENU',
						'IS_AJAX' => $bAjax,
						'AJAX_BLOCK' => $ajaxBlock,
						'VISIBLE' => $bShowMegaMenu,
						// 'WRAPPER' => 'header__top-item',
					);
					?>
					<?=TSolution\Functions::showHeaderBlock($blockOptions);?>
				</div>
			
				<div class="header__side-item--margin">
					<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
						array(
							"COMPONENT_TEMPLATE" => ".default",
							"PATH" => SITE_DIR."include/header/menu_left_catalog.php",
							"AREA_FILE_SHOW" => "file",
							"AREA_FILE_SUFFIX" => "",
							"AREA_FILE_RECURSIVE" => "Y",
							"EDIT_TEMPLATE" => "include_area.php"
						),
						false, array("HIDE_ICONS" => "Y")
					);?>
				</div>
			</div>
			
			<div class="header__side-item--margined header__side-bottom">
				<?//check address text?>
				<?
				$blockOptions = array(
					'PARAM_NAME' => 'HEADER_TOGGLE_ADDRESS',
					'BLOCK_TYPE' => 'ADDRESS',
					'IS_AJAX' => $bAjax,
					'AJAX_BLOCK' => $ajaxBlock,
					'VISIBLE' => $bShowAddress,
					'NO_ICON' => true,
					'WRAPPER' => 'header__side-item--paddings',
				);
				?>
				<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

				<?//show social?>
				<?
				$blockOptions = array(
					'PARAM_NAME' => 'HEADER_TOGGLE_SOCIAL',
					'BLOCK_TYPE' => 'SOCIAL',
					'IS_AJAX' => $bAjax,
					'AJAX_BLOCK' => $ajaxBlock,
					'VISIBLE' => $bShowSocial,
					'WRAPPER' => 'header__side-item--paddings',
					'HIDE_MORE' => false,
				);
				?>
				<?=TSolution\Functions::showHeaderBlock($blockOptions);?>
			</div>
		</div>

		<?if($ajaxBlock == "HEADER_SIDE_COLUMN_PART" && $bAjax) {
			die();
		}?>

	</div>
</header>
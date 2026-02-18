<?
include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
include($_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/header/settings.php');

global $bodyDopClass;
$bodyDopClass .= ' header_padding-91';

/* set classes for header parts */
$mainPartClasses = '';
$mainPartClasses .= ' header__main-part--height_91';
$mainPartClasses .= ' header__main-part--can-transparent';

if($bNarrowHeader) {
	if($bMarginHeader) {
	} else {
		$mainPartClasses .= ' header--color_'.$mainBlockColor;
		$mainPartClasses .= ' header__main-part--bordered';
	}
} else {
	$mainPartClasses .= ' header--color_'.$mainBlockColor;
	if($bMarginHeader) {
		$mainPartClasses .= ' header__main-part--shadow';
	} else {
		$mainPartClasses .= ' header__main-part--bordered';
	}
}


$innerClasses = ' header__main-inner--height_91';
if($bNarrowHeader) {
	if($bMarginHeader) {
		$innerClasses .= ' header--color_'.$mainBlockColor;
		$innerClasses .= ' header__main-inner--margin';
		$innerClasses .= ' header__main-inner--shadow';
	} else {
		$innerClasses .= ' header__main-inner--margin';
	}
}

if(!$bMarginHeader) {
	$mainPartClasses .= ' bg_none';
	$innerClasses .= ' bg_none';
}

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
?>

<header class="header_10 header <?=($bHeaderFon ? 'header--fon' : '')?> <?=($arRegion ? 'header--with_regions' : '')?> <?=$bNarrowHeader ? 'header--narrow' : ''?> <?=$bMarginHeader ? 'header--offset header--save-margin' : ''?> <?=($bMarginHeader && $whiteBreadcrumbs) ? 'header--white' : '' ;?> <?=TSolution::ShowPageProps('HEADER_COLOR')?>">
	<div class="header__inner <?=$bMarginHeader ? 'header__inner--paddings' : ''?>">

		<?if($ajaxBlock == "HEADER_MAIN_PART" && $bAjax) {
			$APPLICATION->restartBuffer();
		}?>

		<div class="header__main-part  <?=$mainPartClasses?> sliced"  data-ajax-load-block="HEADER_MAIN_PART">

			<?if($bNarrowHeader):?>
				<div class="maxwidth-theme">
			<?endif;?>

			<div class="header__main-inner <?=$innerClasses?>">

			<?if(!$bCenteredHeader):?>
				<div class="header__flex-part header__flex-part--left">
					<div class="header__main-item">
						<div class="line-block line-block--40">
							<div class="line-block line-block__item">
								<?
								$blockOptions = array(
									'PARAM_NAME' => 'HEADER_TOGGLE_MEGA_MENU_LEFT',
									'BLOCK_TYPE' => 'MEGA_MENU',
									'IS_AJAX' => $bAjax,
									'AJAX_BLOCK' => $ajaxBlock,
									'VISIBLE' => $bShowMegaMenu && !$bRightMegaMenu,
									'WRAPPER' => 'line-block__item',
								);
								?>
								<?=TSolution\Functions::showHeaderBlock($blockOptions);?>
							
								<?//show logo?>
								<div class="line-block__item no-shrinked">
									<div class="logo <?=$logoClass?>">
										<?TSolution::ShowBufferedLogo();?>
									</div>
								</div>
							</div>

							<?//check slogan text?>
							<?
							$blockOptions = array(
								'PARAM_NAME' => 'HEADER_TOGGLE_SLOGAN',
								'BLOCK_TYPE' => 'SLOGAN',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bShowSlogan,
								'WRAPPER' => 'line-block__item hide-narrow hide-1600',
							);
							?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>
						</div>
					</div>

					
				</div>
				
				<div class="header__flex-part header__flex-part--right">
					<div class="header__main-item">
						<div class="line-block line-block--40 line-block--24-1300 hide-basket-message">
							<?//show phone and callback?>
							<?
							$blockOptions = array(
								'PARAM_NAME' => 'HEADER_TOGGLE_PHONE',
								'BLOCK_TYPE' => 'PHONE',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bShowPhone && $bPhone,
								'WRAPPER' => 'line-block__item no-shrinked icon-block--only_icon-1300',
								'CALLBACK' => $bShowCallback && $bCallback,
								'MESSAGE' => GetMessage("S_CALLBACK"),
								'DROPDOWN_CALLBACK' =>  $bDropdownCallback,
								'DROPDOWN_EMAIL' => $bDropdownEmail,
								'DROPDOWN_SOCIAL' =>  $bDropdownSocial,
								'DROPDOWN_ADDRESS' =>  $bDropdownAddress,
								'DROPDOWN_SCHEDULE' =>  $bDropdownSchedule,
							);
							?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

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

							<?if($arRegion):?>
								<?//regions?>
								<div class="line-block__item icon-block--with_icon icon-block--only_icon">
									<?
									$arRegionsParams = array();
									$arRegionsParams['ONLY_ICON'] = 'Y';
									if($bAjax) {
										$arRegionsParams['POPUP'] = 'N';
									}
									TSolution::ShowListRegions($arRegionsParams);?>
								</div>
							<?endif;?>

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
								'WRAPPER' => 'line-block__item hide-name-narrow',
								'CABINET_PARAMS' => array(
									'TEXT_LOGIN' => '',
									'TEXT_NO_LOGIN' => '',
								),
							);?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

							<?$blockOptions = array(
								'PARAM_NAME' => 'HEADER_TOGGLE_COMPARE',
								'BLOCK_TYPE' => 'COMPARE',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bCompare,
								'WRAPPER' => 'line-block__item',
								'MESSAGE' => '',
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

			<?else:?>
				<div class="header__flex-part header__flex-part--left">
					<div class="header__main-item">
						<div class="line-block">
							<?
							$blockOptions = array(
								'PARAM_NAME' => 'HEADER_TOGGLE_MEGA_MENU_LEFT',
								'BLOCK_TYPE' => 'MEGA_MENU',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bShowMegaMenu && !$bRightMegaMenu,
								'WRAPPER' => 'line-block__item',
							);
							?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>
							
							<div class="header__top-item line-block left-part-icons-block">
								<?if($arRegion):?>
									<?//regions?>
									<div class="line-block__item icon-block--only_icon-1200">
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
								$blockOptions = array(
									'PARAM_NAME' => 'HEADER_TOGGLE_PHONE',
									'BLOCK_TYPE' => 'PHONE',
									'IS_AJAX' => $bAjax,
									'AJAX_BLOCK' => $ajaxBlock,
									'VISIBLE' => $bShowPhone && $bPhone,
									'WRAPPER' => 'line-block__item no-shrinked icon-block--only_icon-1200',
									'NO_ICON' => true,
									'CALLBACK' => $bShowCallback && $bCallback,
									'CALLBACK_CLASS' => 'hide-1400',
									'MESSAGE' => GetMessage("S_CALLBACK"),
									'DROPDOWN_CALLBACK' =>  $bDropdownCallback,
									'DROPDOWN_EMAIL' => $bDropdownEmail,
									'DROPDOWN_SOCIAL' =>  $bDropdownSocial,
									'DROPDOWN_ADDRESS' =>  $bDropdownAddress,
									'DROPDOWN_SCHEDULE' =>  $bDropdownSchedule,
								);
								?>
								<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

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
									'SITE_SELECTOR_NAME' => $siteSelectorName,
									'TEMPLATE' => 'main',
									'SITE_LIST' => $arShowSites,
								);
								?>
								<?=TSolution\Functions::showHeaderBlock($blockOptions);?>
							</div>
						</div>
					</div>
				</div>

				<div class="header__flex-part header__flex-part--center">
					<?//show logo?>
					<div class="header__main-item no-shrinked">
						<div class="logo <?=$logoClass?>">
							<?TSolution::ShowBufferedLogo();?>
						</div>
					</div>
				</div>

				<div class="header__flex-part header__flex-part--right">

					<div class="header__main-item">
						<div class="line-block line-block--40 line-block--24-1300 hide-basket-message">
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
								'WRAPPER' => 'line-block__item hide-name-narrow',
								'CABINET_PARAMS' => array(
									'TEXT_LOGIN' => '',
									'TEXT_NO_LOGIN' => '',
								),
							);?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>
									
							<?$blockOptions = array(
								'PARAM_NAME' => 'HEADER_TOGGLE_COMPARE',
								'BLOCK_TYPE' => 'COMPARE',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bCompare,
								'WRAPPER' => 'line-block__item',
								'MESSAGE' => '',
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
			<?endif;?>

			</div>

			<?if($bNarrowHeader):?>
				</div>
			<?endif;?>	
		</div>

		<?if($ajaxBlock == "HEADER_MAIN_PART" && $bAjax) {
			die();
		}?>
	</div>
</header>
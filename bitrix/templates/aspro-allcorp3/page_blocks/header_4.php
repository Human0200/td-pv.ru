<?
include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
include($_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/header/settings.php');

global $bodyDopClass;
if($bMarginHeader) {
	$bodyDopClass .= ' header_padding-154';
} else {
	$bodyDopClass .= ' header_padding-122';
}



$topPartClasses = '';
if($bMarginHeader) {
} else {
	$topPartClasses .= ' ';
}
$topPartClasses .= ' header__top-part--paddings';
$topPartClasses .= ' header__top-part--bordered';
$topPartClasses .= ' nopadding-left';
$topPartClasses .= ' header__top-part--height_56';
$topPartClasses .= ' hide-dotted';


$mainPartClasses = ' pos-static';
if($bMarginHeader) {
} else {
	$mainPartClasses .= ' ';
}
$mainPartClasses .= ' header__main-part--offset-left';
$mainPartClasses .= ' header__main-part--height_66';
$mainPartClasses .= ' hide-dotted';


$innerClasses = '';

$headerInnerClasses = ''.$mainBlockColor;
if($bMarginHeader) {
} else {
	$headerInnerClasses .= ' block_with_bg header--color_'.$mainBlockColor;
	$headerInnerClasses .= ' bg_none';
}


$subInnerClasses = '';
if($bMarginHeader) {
	$subInnerClasses .= 'block_with_bg header--color_'.$mainBlockColor;
}
?>

<header class="header_4 header <?=($bHeaderFon ? 'header--fon' : '')?> <?=($arRegion ? 'header--with_regions' : '')?>  <?=$bMarginHeader ? 'header--offset' : ''?> <?=($bMarginHeader && $whiteBreadcrumbs) ? 'header--white' : '' ;?> <?=TSolution::ShowPageProps('HEADER_COLOR')?>">
	<div class="header__inner header__inner--parted <?=$headerInnerClasses;?> header__inner--can-transparent <?=$bMarginHeader ? 'header__inner--margins' : 'header__inner--bordered'?>">
		<div class="header__sub-inner <?=$subInnerClasses;?> <?=$bMarginHeader ? ' header--shadow' : ''?>">
			<div class="header__left-part <?=$bMarginHeader ? '' : 'header__left-part--color_light1'?>">
				<div class="header__main-item">
					<div class="line-block line-block--40">
						<div class="line-block line-block__item">
							<?
							$blockOptions = array(
								'PARAM_NAME' => 'HEADER_TOGGLE_MEGA_MENU',
								'BLOCK_TYPE' => 'MEGA_MENU',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bShowMegaMenu,
								'WRAPPER' => 'line-block__item banner-light-icon-fill',
							);
							?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

							<?//show logo?>
							<div class="line-block__item">
								<div class="logo no-shrinked <?=$logoClass?>">
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
							'WRAPPER' => 'line-block__item banner-light-text hide-1600',
						);
						?>
						<?=TSolution\Functions::showHeaderBlock($blockOptions);?>
					</div>
				</div>

			</div>

			<div class="header__right-part">

				<?if($ajaxBlock == "HEADER_TOP_PART" && $bAjax) {
					$APPLICATION->restartBuffer();
				}?>

				<div class="header__top-part <?=$topPartClasses?>" data-ajax-load-block="HEADER_TOP_PART">
					<?if($bNarrowHeader):?>
						<div class="maxwidth-theme">
					<?endif;?>
						
					<div class="header__top-inner">

						<div class="header__flex-part header__flex-part--left">
							<?//show topest menu?>
							<div class="header__top-item menus">
								<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
									array(
										"COMPONENT_TEMPLATE" => ".default",
										"PATH" => SITE_DIR."include/header/menu.topest.php",
										"AREA_FILE_SHOW" => "file",
										"AREA_FILE_SUFFIX" => "",
										"AREA_FILE_RECURSIVE" => "Y",
										"EDIT_TEMPLATE" => "include_area.php"
									),
									false
								);?>
							</div>
						</div>

						<div class="header__top-item">
							<div class="line-block line-block--40">
								<?if($arRegion):?>
									<?//regions?>
									<div class="line-block__item icon-block--with_icon">
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
									'WRAPPER' => 'line-block__item no-shrinked',
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
									'WRAPPER' => 'line-block__item',
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
							</div>
						</div>
						
					</div>

					<?if($bNarrowHeader):?>
						</div>
					<?endif;?>
				</div>

				<?if($ajaxBlock == "HEADER_TOP_PART" && $bAjax) {
					die();
				}?>


				<?if($ajaxBlock == "HEADER_MAIN_PART" && $bAjax) {
					$APPLICATION->restartBuffer();
				}?>

				<div class="header__main-part  <?=$mainPartClasses?> sliced"  data-ajax-load-block="HEADER_MAIN_PART">

					<?if($bNarrowHeader):?>
						<div class="maxwidth-theme">
					<?endif;?>

					<div class="header__main-inner <?=$innerClasses?>">			

						<div class="header__flex-part header__flex-part--left">
							<?//show menu?>
							<div class="header__main-item header__main-item--shinked header-menu header-menu--height_66">
								<nav class="mega-menu sliced">
									<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
										array(
											"COMPONENT_TEMPLATE" => ".default",
											"PATH" => SITE_DIR."include/header/menu_new.php",
											"AREA_FILE_SHOW" => "file",
											"AREA_FILE_SUFFIX" => "",
											"AREA_FILE_RECURSIVE" => "Y",
											"EDIT_TEMPLATE" => "include_area.php"
										),
										false, array("HIDE_ICONS" => "Y")
									);?>
								</nav>
							</div>
						</div>

						<div class="header__main-item">
							<div class="line-block line-block--40 line-block--24-narrow hide-basket-message">
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
									'WRAPPER' => 'line-block__item',
									'CABINET_PARAMS' => array(
										'TEXT_LOGIN' => '',
										'TEXT_NO_LOGIN' => '',
									),
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

								<?
								$blockOptions = array(
									'PARAM_NAME' => 'HEADER_TOGGLE_BUTTON',
									'BLOCK_TYPE' => 'BUTTON',
									'IS_AJAX' => $bAjax,
									'AJAX_BLOCK' => $ajaxBlock,
									'VISIBLE' => $bShowButton,
									'WRAPPER' => 'line-block__item',
									'MESSAGE' => GetMessage("S_CALLBACK"),
									'CLASS' => 'btn-sm',
								);
								?>
								<?=TSolution\Functions::showHeaderBlock($blockOptions);?>
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

			</div>
		</div>
	</div>
</header>
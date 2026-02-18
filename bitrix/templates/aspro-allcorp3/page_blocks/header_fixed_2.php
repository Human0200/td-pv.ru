<?
include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
include($_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/header/settings.php');

global $arTheme;

$topPartClasses = '';
$topPartClasses .= ' header__top-part--height_81';
if(!$bNarrowHeader) {
	$topPartClasses .= ' header__top-part--paddings';
}

$bSideHeader = $arTheme['HEADER_TYPE']['VALUE'] == 12;

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
<div class="header header--fixed-2 <?=$bNarrowHeader ? 'header--narrow' : ''?>">
	<div class="header__inner header--color_light header__inner--shadow-fixed">
		<?if($ajaxBlock == "HEADER_FIXED_TOP_PART" && $bAjax) {
			$APPLICATION->restartBuffer();
		}?>

		<div class="header__top-part <?=$topPartClasses?>" data-ajax-load-block="HEADER_FIXED_TOP_PART">
			<?if($bNarrowHeader):?>
				<div class="maxwidth-theme">
			<?endif;?>

			<div class="header__top-inner">
				<?if($bCenteredHeader):?>
					<div class="header__flex-part header__flex-part--left">
						<div class="header__top-item">
							<div class="line-block line-block--40">
								<?$blockOptions = array(
									'PARAM_NAME' => 'HEADER_FIXED_TOGGLE_MEGA_MENU',
									'BLOCK_TYPE' => 'MEGA_MENU',
									'IS_AJAX' => $bAjax,
									'AJAX_BLOCK' => $ajaxBlock,
									'VISIBLE' => $bShowMegaMenuFixed,
									'WRAPPER' => 'line-block__item',
								);?>
								<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

								<?if($arRegion):?>
									<?//regions?>
									<div class="line-block__item icon-block--with_icon icon-block--no_icon-1100">
										<?
										$arRegionsParams = array();
										if($bAjax) {
											$arRegionsParams['POPUP'] = 'N';
										}
										TSolution::ShowListRegions($arRegionsParams);?>
									</div>
								<?endif;?>

								<?//show phone and callback?>
								<?$blockOptions = array(
									'PARAM_NAME' => 'HEADER_FIXED_TOGGLE_PHONE',
									'BLOCK_TYPE' => 'PHONE',
									'IS_AJAX' => $bAjax,
									'AJAX_BLOCK' => $ajaxBlock,
									'VISIBLE' => $bShowPhoneFixed && $bPhone,
									'WRAPPER' => 'line-block__item no-shrinked icon-block--no_icon-1100',
									'CALLBACK' => $bShowCallbackFixed && $bCallback,
									'CALLBACK_CLASS' => 'hide-1400',
									'MESSAGE' => GetMessage("S_CALLBACK"),
									'DROPDOWN_CALLBACK' =>  $bDropdownCallback,
									'DROPDOWN_EMAIL' => $bDropdownEmail,
									'DROPDOWN_SOCIAL' =>  $bDropdownSocial,
									'DROPDOWN_ADDRESS' =>  $bDropdownAddress,
									'DROPDOWN_SCHEDULE' =>  $bDropdownSchedule,
								);?>
								<?=TSolution\Functions::showHeaderBlock($blockOptions);?>
							</div>
						</div>
					</div>

					<? if(!$bSideHeader) : ?>
					<div class="header__flex-part">
						<?//show logo?>
						<div class="header__top-item">
							<div class="logo no-shrinked <?=$logoClass?>">
								<?TSolution::ShowBufferedLogo();?>
							</div>
						</div>
					</div>
					<? endif ?>

					<div class="header__flex-part header__flex-part--right">
						<div class="header__top-item">
							<div class="line-block line-block--40 line-block--24-1100">
								<?//show site list?>
								<?
								$arShowSites = TSolution\Functions::getShowSites();
								$countSites = count($arShowSites);
								$blockOptions = array(
									'PARAM_NAME' => 'HEADER_FIXED_TOGGLE_LANG',
									'BLOCK_TYPE' => 'LANG',
									'IS_AJAX' => $bAjax,
									'AJAX_BLOCK' => $ajaxBlock,
									'VISIBLE' => $bShowLangFixed && $countSites > 1,
									'WRAPPER' => 'line-block__item icon-block--only_icon-1200',
									'SITE_SELECTOR_NAME' => $siteSelectorName,
									'TEMPLATE' => 'main',
									'SITE_LIST' => $arShowSites,
								);?>
								<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

								<?
								$blockOptions = array(
									'PARAM_NAME' => 'HEADER_FIXED_TOGGLE_EYED',
									'BLOCK_TYPE' => 'EYED',
									'IS_AJAX' => $bAjax,
									'AJAX_BLOCK' => $ajaxBlock,
									'VISIBLE' => $bShowEyedFixed,
									'WRAPPER' => 'line-block__item hide-name-narrow hide-name-1600',
									'MESSAGE' => GetMessage('EYED_TITLE'),
								);
								?>
								<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

								<?$blockOptions = array(
									'PARAM_NAME' => 'HEADER_FIXED_TOGGLE_SEARCH',
									'BLOCK_TYPE' => 'SEARCH',
									'IS_AJAX' => $bAjax,
									'AJAX_BLOCK' => $ajaxBlock,
									'VISIBLE' => $bShowSearchFixed,
									'WRAPPER' => 'line-block__item hide-name-narrow hide-name-1600',
									'MESSAGE' => GetMessage('SEARCH_TITLE'),
								);?>
								<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

								<?$blockOptions = array(
									'PARAM_NAME' => 'HEADER_FIXED_TOGGLE_CABINET',
									'BLOCK_TYPE' => 'CABINET',
									'IS_AJAX' => $bAjax,
									'AJAX_BLOCK' => $ajaxBlock,
									'VISIBLE' => $bCabinet,
									'WRAPPER' => 'line-block__item hide-name-narrow hide-name-1600',
								);?>
								<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

								<?$blockOptions = array(
									'PARAM_NAME' => 'HEADER_FIXED_TOGGLE_COMPARE',
									'BLOCK_TYPE' => 'COMPARE',
									'IS_AJAX' => $bAjax,
									'AJAX_BLOCK' => $ajaxBlock,
									'VISIBLE' => $bCompare,
									'WRAPPER' => 'line-block__item',
									'MESSAGE' => '',
								);?>
								<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

								<?$blockOptions = array(
									'PARAM_NAME' => 'HEADER_FIXED_TOGGLE_BASKET',
									'BLOCK_TYPE' => 'BASKET',
									'IS_AJAX' => $bAjax,
									'AJAX_BLOCK' => $ajaxBlock,
									'VISIBLE' => $bOrder && !TSolution::IsBasketPage() && !TSolution::IsOrderPage(),
									'WRAPPER' => 'line-block__item hide-name-narrow hide-name-1600',
									'MESSAGE' => GetMessage('BASKET'),
								);?>
								<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

								<?$blockOptions = array(
									'PARAM_NAME' => 'HEADER_FIXED_TOGGLE_BUTTON',
									'BLOCK_TYPE' => 'BUTTON',
									'IS_AJAX' => $bAjax,
									'AJAX_BLOCK' => $ajaxBlock,
									'VISIBLE' => $bShowButtonFixed,
									'WRAPPER' => 'line-block__item',
									'MESSAGE' => GetMessage("S_CALLBACK"),
								);?>
								<?=TSolution\Functions::showHeaderBlock($blockOptions);?>
							</div>
						</div>
					</div>
				<?else:?>
					<?if(!$bSideHeader):?>
						<div class="header__top-item">
							<div class="line-block">
								<?$blockOptions = array(
									'PARAM_NAME' => 'HEADER_FIXED_TOGGLE_MEGA_MENU_LEFT',
									'BLOCK_TYPE' => 'MEGA_MENU',
									'IS_AJAX' => $bAjax,
									'AJAX_BLOCK' => $ajaxBlock,
									'VISIBLE' => $bShowMegaMenuFixed && !$bRightMegaMenuFixed,
									'WRAPPER' => 'line-block__item',
								);?>
								<?=TSolution\Functions::showHeaderBlock($blockOptions);?>
								<?//show logo?>
								<div class="line-block__item">
									<div class="logo no-shrinked <?=$logoClass?>">
										<?TSolution::ShowBufferedLogo();?>
									</div>
								</div>
							</div>
						</div>
					<?endif;?>

					<div class="header__top-item">
						<div class="line-block line-block--48">
							<?if($arRegion):?>
								<?//regions?>
								<div class="line-block__item icon-block--with_icon icon-block--only_icon-1200">
									<?
									$arRegionsParams = array();
									if($bAjax) {
										$arRegionsParams['POPUP'] = 'N';
									}
									TSolution::ShowListRegions($arRegionsParams);?>
								</div>
							<?endif;?>

							<?//show phone and callback?>
							<?$blockOptions = array(
								'PARAM_NAME' => 'HEADER_FIXED_TOGGLE_PHONE',
								'BLOCK_TYPE' => 'PHONE',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bShowPhoneFixed && $bPhone,
								'WRAPPER' => 'line-block__item no-shrinked icon-block--only_icon-1200',
								'CALLBACK' => $bShowCallbackFixed && $bCallback,
								'CALLBACK_CLASS' => 'hide-1400',
								'MESSAGE' => GetMessage("S_CALLBACK"),
								'DROPDOWN_CALLBACK' =>  $bDropdownCallback,
								'DROPDOWN_EMAIL' => $bDropdownEmail,
								'DROPDOWN_SOCIAL' =>  $bDropdownSocial,
								'DROPDOWN_ADDRESS' =>  $bDropdownAddress,
								'DROPDOWN_SCHEDULE' =>  $bDropdownSchedule,
							);?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

							<? if($bSideHeader) : ?>
								</div><!-- line-block line-block--48 -->
							</div><!-- header__top-item -->
							<div class="header__top-item">
								<div class="line-block line-block--48">
							<? endif ?>

							<?//show site list?>
							<?
							$arShowSites = TSolution\Functions::getShowSites();
							$countSites = count($arShowSites);
							$blockOptions = array(
								'PARAM_NAME' => 'HEADER_FIXED_TOGGLE_LANG',
								'BLOCK_TYPE' => 'LANG',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bShowLangFixed && $countSites > 1,
								'WRAPPER' => 'line-block__item icon-block--only_icon-1200',
								'SITE_SELECTOR_NAME' => $siteSelectorName,
								'TEMPLATE' => 'main',
								'SITE_LIST' => $arShowSites,
							);?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

							<?
							$blockOptions = array(
								'PARAM_NAME' => 'HEADER_FIXED_TOGGLE_EYED',
								'BLOCK_TYPE' => 'EYED',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bShowEyedFixed,
								'WRAPPER' => 'line-block__item hide-name-narrow hide-name-1600',
								'MESSAGE' => GetMessage('EYED_TITLE'),
							);
							?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>


							<?$blockOptions = array(
								'PARAM_NAME' => 'HEADER_FIXED_TOGGLE_SEARCH',
								'BLOCK_TYPE' => 'SEARCH',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bShowSearchFixed,
								'WRAPPER' => 'line-block__item hide-name-narrow hide-name-1600',
								'MESSAGE' => GetMessage('SEARCH_TITLE'),
							);?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

							<?$blockOptions = array(
								'PARAM_NAME' => 'HEADER_FIXED_TOGGLE_CABINET',
								'BLOCK_TYPE' => 'CABINET',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bCabinet,
								'WRAPPER' => 'line-block__item hide-name-narrow hide-name-1600',
							);?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

							<?$blockOptions = array(
								'PARAM_NAME' => 'HEADER_FIXED_TOGGLE_COMPARE',
								'BLOCK_TYPE' => 'COMPARE',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bCompare,
								'WRAPPER' => 'line-block__item',
								'MESSAGE' => '',
							);?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

							<?$blockOptions = array(
								'PARAM_NAME' => 'HEADER_FIXED_TOGGLE_BASKET',
								'BLOCK_TYPE' => 'BASKET',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bOrder,
								'WRAPPER' => 'line-block__item hide-name-narrow hide-name-1600',
								'MESSAGE' => GetMessage('BASKET'),
							);?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

							<?$blockOptions = array(
								'PARAM_NAME' => 'HEADER_FIXED_TOGGLE_BUTTON',
								'BLOCK_TYPE' => 'BUTTON',
								'IS_AJAX' => $bAjax,
								'AJAX_BLOCK' => $ajaxBlock,
								'VISIBLE' => $bShowButtonFixed,
								'WRAPPER' => 'line-block__item',
								'MESSAGE' => GetMessage("S_CALLBACK"),
							);?>
							<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

							<?if(!$bSideHeader):?>
								<?$blockOptions = array(
									'PARAM_NAME' => 'HEADER_TOGGLE_MEGA_MENU_RIGHT',
									'BLOCK_TYPE' => 'MEGA_MENU',
									'IS_AJAX' => $bAjax,
									'AJAX_BLOCK' => $ajaxBlock,
									'VISIBLE' => $bShowMegaMenuFixed && $bRightMegaMenuFixed,
									'WRAPPER' => 'line-block__item',
								);?>
								<?=TSolution\Functions::showHeaderBlock($blockOptions);?>
							<?endif;?>
						</div>
					</div>
				<?endif;?>
			</div>

			<?if($bNarrowHeader):?>
				</div>
			<?endif;?>
		</div>

		<?if($ajaxBlock == "HEADER_FIXED_TOP_PART" && $bAjax) {
			die();
		}?>
	</div>
</div>
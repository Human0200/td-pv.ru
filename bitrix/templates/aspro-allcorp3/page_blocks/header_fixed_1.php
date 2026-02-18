<?
include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
include($_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/header/settings.php');

global $arTheme;

$topPartClasses = '';
$topPartClasses .= ' header__top-part--height_81';
$topPartClasses .= ' hide-dotted';
if(!$bNarrowHeader) {
	$topPartClasses .= ' header__top-part--paddings';
}

$bSideHeader = $arTheme['HEADER_TYPE']['VALUE'] == 12;
?>
<div class="header header--fixed-1 <?=$bNarrowHeader ? 'header--narrow' : ''?>">
	<div class="header__inner header--color_light header__inner--shadow-fixed">
		<?if($ajaxBlock == "HEADER_FIXED_TOP_PART" && $bAjax) {
			$APPLICATION->restartBuffer();
		}?>

		<div class="header__top-part <?=$topPartClasses?>" data-ajax-load-block="HEADER_FIXED_TOP_PART">
			<?if($bNarrowHeader):?>
				<div class="maxwidth-theme">
			<?endif;?>

			<div class="header__top-inner">
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
									<?=TSolution::ShowBufferedFixedLogo();?>
								</div>
							</div>
						</div>
					</div>
				<?endif;?>

				<?//show menu?>
				<div class="header__top-item header__top-item--shinked header-menu <?= $bSideHeader ? 'header-menu--left' : 'header-menu--centered' ?> header-menu--height_81">
					<?if(TSolution::nlo('menu-fixed')):?>
					<!-- noindex -->
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
					<!-- /noindex -->
					<?endif;?>
					<?TSolution::nlo('menu-fixed');?>
				</div>

				<div class="header__top-item">
					<div class="line-block line-block--48 line-block--24-1100">
						<?$blockOptions = array(
							'PARAM_NAME' => 'HEADER_FIXED_TOGGLE_EYED',
							'BLOCK_TYPE' => 'EYED',
							'IS_AJAX' => $bAjax,
							'AJAX_BLOCK' => $ajaxBlock,
							'VISIBLE' => $bShowEyedFixed,
							'WRAPPER' => 'line-block__item icon-block--only_icon',
						);?>
						<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

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
							'WRAPPER' => 'line-block__item',
							'ONLY_ICON' => true,
							'SITE_SELECTOR_NAME' => $siteSelectorName,
							'TEMPLATE' => 'main',
							'SITE_LIST' => $arShowSites,
						);?>
						<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

						<?if($arRegion):?>
							<?//regions?>
							<div class="line-block__item icon-block--only_icon">
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
							'PARAM_NAME' => 'HEADER_FIXED_TOGGLE_PHONE',
							'BLOCK_TYPE' => 'PHONE',
							'IS_AJAX' => $bAjax,
							'AJAX_BLOCK' => $ajaxBlock,
							'VISIBLE' => $bShowPhoneFixed && $bPhone,
							'WRAPPER' => 'line-block__item no-shrinked',
							'CALLBACK' => false,
							'ONLY_ICON' => true,
							'DROPDOWN_CALLBACK' =>  $bDropdownCallback,
							'DROPDOWN_EMAIL' => $bDropdownEmail,
							'DROPDOWN_SOCIAL' =>  $bDropdownSocial,
							'DROPDOWN_ADDRESS' =>  $bDropdownAddress,
							'DROPDOWN_SCHEDULE' =>  $bDropdownSchedule,
						);?>
						<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

						<?$blockOptions = array(
							'PARAM_NAME' => 'HEADER_FIXED_TOGGLE_SEARCH',
							'BLOCK_TYPE' => 'SEARCH',
							'IS_AJAX' => $bAjax,
							'AJAX_BLOCK' => $ajaxBlock,
							'VISIBLE' => $bShowSearchFixed,
							'WRAPPER' => 'line-block__item icon-block--only_icon',
						);?>
						<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

						<?$blockOptions = array(
							'PARAM_NAME' => 'HEADER_FIXED_TOGGLE_CABINET',
							'BLOCK_TYPE' => 'CABINET',
							'IS_AJAX' => $bAjax,
							'AJAX_BLOCK' => $ajaxBlock,
							'VISIBLE' => $bCabinet,
							'CABINET_PARAMS' => array(
								'TEXT_LOGIN' => '',
								'TEXT_NO_LOGIN' => '',
							),
							'WRAPPER' => 'line-block__item',
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
							'WRAPPER' => 'line-block__item',
							'MESSAGE' => '',
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
<?
include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
include($_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/header/settings.php');

global $bodyDopClass, $arTheme;
$bodyDopClass .= ' header_padding-146';

$topPartClasses = '';
$topPartClasses .= ' header__top-part--height_46';
$topPartClasses .= ' header__top-part--can-transparent';
if($bNarrowHeader) {
	if($bMarginHeader) {
	} else {
		$topPartClasses .= ' header--color_'.$topBlockColor;
		$topPartClasses .= ' header__top-part--bordered';
	}
} else {
	if($bMarginHeader) {
	} else {
		$topPartClasses .= ' header--color_'.$topBlockColor;
		$topPartClasses .= ' header__top-part--bordered';
	}
	$topPartClasses .= ' header__top-part--paddings';
}


$mainPartClasses = '';
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
		$mainPartClasses .= ' header__main-part--margin';
		$mainPartClasses .= ' header__main-part--shadow';
	} else {
		$mainPartClasses .= ' header__main-part--bordered';
	}
}

$innerClasses = '';
$innerClasses .= ' hide-dotted';
if($bNarrowHeader) {
	if($bMarginHeader) {
		$innerClasses .= ' header__main-inner--color_'.$mainBlockColor;
		$innerClasses .= ' header__main-inner--shadow';
		$innerClasses .= ' header--color_'.$mainBlockColor;
	} else {
		$innerClasses .= ' header__main-inner--margin';
	}
}
if(!$bMarginHeader) {
	$innerClasses .= ' bg_none';
	$mainPartClasses .= ' bg_none';
}
?>

<header class="header_1 header <?=($bHeaderFon ? 'header--fon' : '')?> <?=($arRegion ? 'header--with_regions' : '')?> <?=$bNarrowHeader ? 'header--narrow' : ''?> <?=$bMarginHeader ? 'header--offset' : ''?> <?=($bMarginHeader && $whiteBreadcrumbs) ? 'header--white' : '' ;?> <?=TSolution::ShowPageProps('HEADER_COLOR')?>">
	<div class="header__inner">

		<?if($ajaxBlock == "HEADER_TOP_PART" && $bAjax) {
			$APPLICATION->restartBuffer();
		}?>

		<div class="header__top-part <?=$topPartClasses?>" data-ajax-load-block="HEADER_TOP_PART">
			<?if($bNarrowHeader):?>
				<div class="maxwidth-theme">
			<?endif;?>
				
			<div class="header__top-inner">
				<?if($arRegion):?>
					<?//regions?>
					<div class="header__top-item icon-block--with_icon">
						<?
						$arRegionsParams = array();
						if($bAjax) {
							$arRegionsParams['POPUP'] = 'N';
						}
						TSolution::ShowListRegions($arRegionsParams);?>
					</div>
				<?endif;?>

				<?//check address text?>
				<?
				$blockOptions = array(
					'PARAM_NAME' => 'HEADER_TOGGLE_ADDRESS',
					'BLOCK_TYPE' => 'ADDRESS',
					'IS_AJAX' => $bAjax,
					'AJAX_BLOCK' => $ajaxBlock,
					'VISIBLE' => $bShowAddress,
					'WRAPPER' => 'header__top-item hide-1300',
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
					'WRAPPER' => 'header__top-item',
				);
				?>
				<?=TSolution\Functions::showHeaderBlock($blockOptions);?>

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
					'WRAPPER' => 'header__top-item no-shrinked',
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
				<?$visible = ($bShowLang || $bCompare || $bCabinet || $bOrder || $bShowThemeSelector);?>
				<?$arShowSites = TSolution\Functions::getShowSites();
				$countSites = count($arShowSites);?>
				<?$blockOptions = array(
					'PARAM_NAME' => 'HEADER_RIGHT_BLOCK',
					'BLOCK_TYPE' => 'HEADER_RIGHT_BLOCK',
					'IS_AJAX' => $bAjax,
					'AJAX_BLOCK' => $ajaxBlock,
					'VISIBLE' => $visible,
					'WRAPPER' => 'header__top-item',
					'INNER_WRAPPER' => 'line-block line-block--24',
					'ITEMS' => [
						[ //show site list
							'PARAM_NAME' => 'HEADER_TOGGLE_LANG',
							'BLOCK_TYPE' => 'LANG',
							'VISIBLE' => $bShowLang && $countSites > 1,
							'WRAPPER' => 'line-block__item',
							'SITE_SELECTOR_NAME' => $siteSelectorName,
							'TEMPLATE' => 'main',
							'SITE_LIST' => $arShowSites,
						],
						[ //show theme selector
							'PARAM_NAME' => 'HEADER_TOGGLE_THEME_SELECTOR',
							'BLOCK_TYPE' => 'THEME_SELECTOR',
							'VISIBLE' => $bShowThemeSelector,
							'WRAPPER' => 'line-block__item',
						],
						[ //show cabinet
							'PARAM_NAME' => 'HEADER_TOGGLE_CABINET',
							'BLOCK_TYPE' => 'CABINET',
							'VISIBLE' => $bCabinet,
							'WRAPPER' => 'line-block__item hide-name-1600',
						],
						[ //show compare
							'PARAM_NAME' => 'HEADER_TOGGLE_COMPARE',
							'BLOCK_TYPE' => 'COMPARE',
							'VISIBLE' => $bCompare,
							'WRAPPER' => 'line-block__item hide-name-1600',
							'MESSAGE' => \Bitrix\Main\Localization\Loc::getMessage('COMPARE_TEXT'),
							'CLASS_LINK' => 'light-opacity-hover fill-theme-hover banner-light-icon-fill',
							'CLASS_ICON' => 'menu-light-icon-fill ',
						],
						[ //show basket
							'PARAM_NAME' => 'HEADER_TOGGLE_BASKET',
							'BLOCK_TYPE' => 'BASKET',
							'VISIBLE' => $bOrder && !TSolution::IsBasketPage() && !TSolution::IsOrderPage(),
							'WRAPPER' => 'line-block__item hide-name-1600',
							'MESSAGE' => GetMessage('BASKET'),
						]
					]
				);?>
				<?=TSolution\Functions::showHeaderBlock($blockOptions);?>
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
							'WRAPPER' => 'line-block__item hide-1300',
						);
						?>
						<?=TSolution\Functions::showHeaderBlock($blockOptions);?>
					</div>
				</div>

				<?//show menu?>
				<div class="header__main-item header__main-item--shinked header-menu header-menu--centered">
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
				
				<div class="header__main-item">
					<div class="line-block">
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

			<?if($bNarrowHeader):?>
				</div>
			<?endif;?>	
		</div>

		<?if($ajaxBlock == "HEADER_MAIN_PART" && $bAjax) {
			die();
		}?>
	</div>
</header>
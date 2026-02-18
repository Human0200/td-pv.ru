<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->setFrameMode(true);?>
<?
global $arTheme;
$iVisibleItemsMenu = ($arTheme['MAX_VISIBLE_ITEMS_MENU']['VALUE'] ? $arTheme['MAX_VISIBLE_ITEMS_MENU']['VALUE'] : 10);
//$sViewTypeMenu = $arTheme['VIEW_TYPE_MENU']['VALUE'];
$sCountElementsMenu = "count_".$arTheme['COUNT_ITEMS_IN_LINE_MENU']['VALUE'];
$bRightPart = $arTheme['SHOW_RIGHT_SIDE']['VALUE'] == 'Y';
?>
<?if($arResult):?>
	<div class="catalog_icons_<?=$arTheme['SHOW_CATALOG_SECTIONS_ICONS']['VALUE'];?>">
		<div class="header-menu__wrapper">
			<?
			// if($bRightPart) {
			// 	include('side_banners.php'); // get $bannersHTML
			// }
			
			$counter = 1;
			foreach($arResult as $arItem):?>
				<?
				$bShowChilds = $arItem["CHILD"] && $arParams["MAX_LEVEL"] > 1;
				$bWideMenu = ($arItem["PARAMS"]["WIDE_MENU"] == "Y");
				?>
				<div class="header-menu__item unvisible   <?=($counter == 1 ? "header-menu__item--first" : "")?> <?=($counter == count($arResult) ? "header-menu__item--last" : "")?> <?=($bShowChilds ? "header-menu__item--dropdown" : "")?><?=($bWideMenu ? " header-menu__item--wide" : "")?><?=($arItem["SELECTED"] ? " active" : "")?>">
					<a class="header-menu__link light-opacity-hover fill-theme-hover menu-light-text banner-light-text dark_link" href="<?=$arItem["LINK"]?>"<?=$arItem['ATTRIBUTE']?>>
						<span class="header-menu__title font_12">
							<?=$arItem["TEXT"]?>
						</span>
						<?if($bShowChilds):?>
							<?=CAllcorp3::showIconSvg(' header-menu__wide-submenu-right-arrow fill-dark-light-block', SITE_TEMPLATE_PATH.'/images/svg/Arrow_right_small.svg');?>
						<?endif;?>
					</a>
					<?if($bShowChilds):?>
						<div class="header-menu__dropdown-menu <?=($bWideMenu && $arParams['NARROW'] ? 'maxwidth-theme' : '')?>">
							<div class="dropdown <?=$bWideMenu ? 'dropdown--relative dropdown--no-shadow' : ''?>">
								<?if($bWideMenu):?>
									<div class="header-menu__wide-limiter scrollbar<?= $arParams['NARROW'] ? ' maxwidth-theme' : '';?>">
								<?endif;?>

								<?if($bRightPart && $bWideMenu):?>
									<?
									$GLOBALS['rightBannersFilter'] = array('PROPERTY_SHOW_MENU' => $arItem["LINK"]);
									include('side_banners.php');
									?>
									<?if($bannersHTML):?>
										<div class="header-menu__wide-right-part">
											<?=$bannersHTML?>
										</div>
									<?endif;?>
								<?endif;?>

								<ul class="header-menu__dropdown-menu-inner <?=$bWideMenu ? ' header-menu__dropdown-menu--grids' : ''?>">
									<?foreach($arItem["CHILD"] as $arSubItem):?>
										<?$bShowChilds = $arSubItem["CHILD"] && $arParams["MAX_LEVEL"] > 2;?>
										<?if($bWideMenu) {
											$bIcon = $arTheme['IMAGES_WIDE_MENU']['VALUE'] == 'ICONS' && $arSubItem['PARAMS']['ICON'];
											$bTransparentPicture = array_key_exists('TRANSPARENT_PICTURE', (array)$arSubItem['PARAMS']) && $arSubItem['PARAMS']['TRANSPARENT_PICTURE'] && ($arTheme['IMAGES_WIDE_MENU']['VALUE'] == 'TRANSPARENT_PICTURES' || ($arTheme['IMAGES_WIDE_MENU']['VALUE'] == 'ICONS' && !$bIcon)) ? $arSubItem['PARAMS']['TRANSPARENT_PICTURE'] : false;
											$bPicture = array_key_exists('PICTURE', (array)$arSubItem['PARAMS']) && $arSubItem['PARAMS']['PICTURE'] && ($arTheme['IMAGES_WIDE_MENU']['VALUE'] == 'PICTURES' || ($arTheme['IMAGES_WIDE_MENU']['VALUE'] == 'TRANSPARENT_PICTURES' && !$bTransparentPicture) || ($arTheme['IMAGES_WIDE_MENU']['VALUE'] == 'ICONS' && !$bIcon && !$bTransparentPicture)) ? $arSubItem['PARAMS']['PICTURE'] : false;
											$bHasPicture = $bIcon || $bTransparentPicture || $bPicture;

											include('wide_menu.php');
										} else {?>
											<li class="header-menu__dropdown-item <?=($bShowChilds ? "header-menu__dropdown-item--with-dropdown" : "")?> <?=$sCountElementsMenu;?> <?=($arSubItem["SELECTED"] ? "active" : "")?>">
												<a class="font_15 dark_link fill-theme-hover1 menu-light-text1 fill-dark-light-block svg" href="<?=$arSubItem["LINK"]?>">
													<?=$arSubItem["TEXT"]?>
													<?if($arSubItem["CHILD"] && count($arSubItem["CHILD"]) && $bShowChilds):?>
														<?=CAllcorp3::showIconSvg(' header-menu__dropdown-right-arrow fill-dark-light-block', SITE_TEMPLATE_PATH.'/images/svg/Arrow_right_small.svg');?>
													<?endif;?>
												</a>
												<?if($bShowChilds):?>
													<?$iCountChilds = count($arSubItem["CHILD"]);?>
													<div class="header-menu__dropdown-menu header-menu__dropdown-menu--submenu ">
														<ul class="dropdown">
															<?foreach($arSubItem["CHILD"] as $key => $arSubSubItem):?>
																<?$bShowChilds = $arSubSubItem["CHILD"] && $arParams["MAX_LEVEL"] > 3;?>
																<li class="<?=(++$key > $iVisibleItemsMenu ? 'collapsed' : '');?> header-menu__dropdown-item <?=($bShowChilds ? "header-menu__dropdown-item--with-dropdown" : "")?> <?=($arSubSubItem["SELECTED"] ? "active" : "")?>">
																	<a class="font_15 dark_link fill-dark-light-block svg" href="<?=$arSubSubItem["LINK"]?>">
																		<?=$arSubSubItem["TEXT"]?>
																		<?if(count($arSubItem["CHILD"]) && $bShowChilds):?>
																			<?=CAllcorp3::showIconSvg(' header-menu__dropdown-right-arrow fill-dark-light-block', SITE_TEMPLATE_PATH.'/images/svg/Arrow_right_small.svg');?>
																		<?endif;?>
																	</a>
																	<?if($bShowChilds):?>
																		<ul class="header-menu__dropdown-menu header-menu__dropdown-menu--submenu dropdown">
																			<?foreach($arSubSubItem["CHILD"] as $arSubSubSubItem):?>
																				<li class="header-menu__dropdown-item <?=($arSubSubSubItem["SELECTED"] ? "active" : "")?>">
																					<a class="font_15 dark_link" href="<?=$arSubSubSubItem["LINK"]?>"><?=$arSubSubSubItem["TEXT"]?></a>
																				</li>
																			<?endforeach;?>
																		</ul>
																		
																	<?endif;?>
																</li>
															<?endforeach;?>
															<?if($iCountChilds > $iVisibleItemsMenu && $bWideMenu):?>
																<li>
																	<span class="colored more_items with_dropdown">
																		<?=\Bitrix\Main\Localization\Loc::getMessage("S_MORE_ITEMS");?>
																		<?=CAllcorp3::showIconSvg("", SITE_TEMPLATE_PATH."/images/svg/more_arrow.svg", "", "", false);?>
																	</span>
																</li>
															<?endif;?>
														</ul>
													</div>
												<?endif;?>
											</li>
										<?}?>
									<?endforeach;?>
								</ul>

								<?if($bWideMenu):?>
									</div>
								<?endif;?>
							</div>
						</div>
					<?endif;?>
				</div>
				<?$counter++;?>
			<?endforeach;?>

			<div class="header-menu__item header-menu__item--more-items unvisible">
				<div class="header-menu__link menu-light-icon-fill banner-light-icon-fill fill-dark-light-block">
					<svg xmlns="http://www.w3.org/2000/svg" width="17" height="3" viewBox="0 0 17 3">
						<path class="cls-1" d="M923.5,178a1.5,1.5,0,1,1-1.5,1.5A1.5,1.5,0,0,1,923.5,178Zm7,0a1.5,1.5,0,1,1-1.5,1.5A1.5,1.5,0,0,1,930.5,178Zm7,0a1.5,1.5,0,1,1-1.5,1.5A1.5,1.5,0,0,1,937.5,178Z" transform="translate(-922 -178)"/>
					</svg>
				</div>
				<ul class="header-menu__dropdown-menu dropdown"></ul>
			</div>
		</div>
	</div>
	<script data-skip-moving="true">
		function topMenuAction() {
			CheckTopMenuPadding();
			CheckTopMenuOncePadding();
			if(typeof CheckTopMenuDotted !== 'function'){
				let timerID = setInterval(function(){
					if(typeof CheckTopMenuDotted === 'function'){
						CheckTopMenuDotted();
						clearInterval(timerID);
					}
				}, 100);
			} else {
				CheckTopMenuDotted();
			}
		}
	</script>
<?endif;?>
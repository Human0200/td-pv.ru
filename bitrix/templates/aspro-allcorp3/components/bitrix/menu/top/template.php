<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->setFrameMode(true);?>
<?
global $arTheme;
$iVisibleItemsMenu = ($arTheme['MAX_VISIBLE_ITEMS_MENU']['VALUE'] ? $arTheme['MAX_VISIBLE_ITEMS_MENU']['VALUE'] : 10);
//$sViewTypeMenu = $arTheme['VIEW_TYPE_MENU']['VALUE'];
$sCountElementsMenu = "count_".$arTheme['COUNT_ITEMS_IN_LINE_MENU']['VALUE'];
?>
<?if($arResult):?>
	<div class="table-menu catalog_icons_<?=$arTheme['SHOW_CATALOG_SECTIONS_ICONS']['VALUE'];?>">
		<div class="marker-nav"></div>
		<table>
			<tr>
				<?foreach($arResult as $arItem):?>
					<?$bShowChilds = $arParams["MAX_LEVEL"] > 1;?>
					<?$bWideMenu = ($arItem["PARAMS"]["WIDE_MENU"] == "Y");?>
					<td class="menu-item unvisible <?=($arItem["CHILD"] ? "dropdown" : "")?><?=($bWideMenu ? " wide_menu" : "")?><?=($arItem["SELECTED"] ? " active" : "")?>">
						<div class="wrap">
							<a class="<?=($arItem["CHILD"] && $bShowChilds ? "dropdown-toggle" : "")?>" href="<?=$arItem["LINK"]?><?=$arItem['ATTRIBUTE']?>">
								<?=$arItem["TEXT"]?>
								<i class="fa fa-angle-down"></i>
								<div class="line-wrapper"><span class="line"></span></div>
							</a>
							<?if($arItem["CHILD"] && $bShowChilds):?>
								<span class="tail"></span>
								<ul class="dropdown-menu">
									<?foreach($arItem["CHILD"] as $arSubItem):?>
										<?$bShowChilds = $arParams["MAX_LEVEL"] > 2;?>
										<?$bHasPicture = (isset($arSubItem['PARAMS']['PICTURE']) && $arSubItem['PARAMS']['PICTURE'] && $arTheme['SHOW_CATALOG_SECTIONS_ICONS']['VALUE'] == 'Y');?>
										<li class="<?=($arSubItem["CHILD"] && $bShowChilds ? "dropdown-submenu" : "")?> <?=$sCountElementsMenu;?> <?=($arSubItem["SELECTED"] ? "active" : "")?> <?=($bHasPicture ? "has_img" : "")?>">
											<?if($bHasPicture && $bWideMenu):
												$arImg = CFile::ResizeImageGet($arSubItem['PARAMS']['PICTURE'], array('width' => 60, 'height' => 60), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
												if(is_array($arImg)):?>
													<div class="menu_img"><img src="<?=$arImg["src"]?>" alt="<?=$arSubItem["TEXT"]?>" title="<?=$arSubItem["TEXT"]?>" /></div>
												<?endif;?>
											<?endif;?>
											<a href="<?=$arSubItem["LINK"]?>" title="<?=$arSubItem["TEXT"]?>"><?=$arSubItem["TEXT"]?><?=($arSubItem["CHILD"] && $bShowChilds ? '<span class="arrow"><i></i></span>' : '')?></a>
											<?if($arSubItem["CHILD"] && $bShowChilds):?>
												<?$iCountChilds = count($arSubItem["CHILD"]);?>
												<ul class="dropdown-menu toggle_menu">
													<?foreach($arSubItem["CHILD"] as $key => $arSubSubItem):?>
														<?$bShowChilds = $arParams["MAX_LEVEL"] > 3;?>
														<li class="<?=(++$key > $iVisibleItemsMenu ? 'collapsed' : '');?> <?=($arSubSubItem["CHILD"] && $bShowChilds ? "dropdown-submenu" : "")?> <?=($arSubSubItem["SELECTED"] ? "active" : "")?>">
															<a href="<?=$arSubSubItem["LINK"]?>" title="<?=$arSubSubItem["TEXT"]?>"><?=$arSubSubItem["TEXT"]?></a>
															<?if($arSubSubItem["CHILD"] && $bShowChilds):?>
																<ul class="dropdown-menu">
																	<?foreach($arSubSubItem["CHILD"] as $arSubSubSubItem):?>
																		<li class="<?=($arSubSubSubItem["SELECTED"] ? "active" : "")?>">
																			<a href="<?=$arSubSubSubItem["LINK"]?>" title="<?=$arSubSubSubItem["TEXT"]?>"><?=$arSubSubSubItem["TEXT"]?></a>
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
											<?endif;?>
										</li>
									<?endforeach;?>
								</ul>
							<?endif;?>
						</div>
					</td>
				<?endforeach;?>

				<td class="menu-item dropdown js-dropdown nosave unvisible">
					<div class="wrap">
						<a class="dropdown-toggle more-items" href="#">
							<span>
								<svg xmlns="http://www.w3.org/2000/svg" width="17" height="3" viewBox="0 0 17 3">
								  <defs>
								    <style>
								      .cls-1 {
								        fill-rule: evenodd;
								      }
								    </style>
								  </defs>
								  <path class="cls-1" d="M923.5,178a1.5,1.5,0,1,1-1.5,1.5A1.5,1.5,0,0,1,923.5,178Zm7,0a1.5,1.5,0,1,1-1.5,1.5A1.5,1.5,0,0,1,930.5,178Zm7,0a1.5,1.5,0,1,1-1.5,1.5A1.5,1.5,0,0,1,937.5,178Z" transform="translate(-922 -178)"/>
								</svg>
							</span>
						</a>
						<span class="tail"></span>
						<ul class="dropdown-menu"></ul>
					</div>
				</td>

			</tr>
		</table>
	</div>
<?endif;?>
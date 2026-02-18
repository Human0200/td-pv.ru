<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

use Bitrix\Main\Localization\Loc;
global $USER;
?>
<?if($arResult):?>
	<?
	$bParent = $arResult && $USER->IsAuthorized();
	?>
	<div class="mobilemenu__menu mobilemenu__menu--cabinet">
		<ul class="mobilemenu__menu-list">
			<li class="mobilemenu__menu-item mobilemenu__menu-item--with-icon mobilemenu__menu-item--parent<?=(CAllcorp3::isPersonalPage() ? ' mobilemenu__menu-item--selected' : '')?>">
				<div class="link-wrapper bg-opacity-theme-parent-hover fill-theme-parent-all color-theme-parent-all">
					<?$link = CAllcorp3::GetFrontParametrValue('PERSONAL_PAGE_URL', SITE_ID);?>
					<a class="dark_link" href="<?=$link;?>" title="<?=Loc::getMessage('MY_CABINET')?>">
						<?=CAllcorp3::showIconSvg('cabinet mobilemenu__menu-item-svg fill-theme-target', SITE_TEMPLATE_PATH."/images/svg/".($USER->IsAuthorized() ? 'User' : 'Lock')."_black.svg");?>
						<span class="font_15"><?=Loc::getMessage('MY_CABINET')?></span>
						<?if($bParent):?>
							<?=CAllcorp3::showIconSvg(' down menu-arrow bg-opacity-theme-target fill-theme-target fill-dark-light-block', SITE_TEMPLATE_PATH.'/images/svg/Triangle_right.svg', '', '', true, false);?>
						<?endif;?>
					</a>
					<span class="toggle_block"></span>
				</div>
				<?if($bParent):?>
					<ul class="mobilemenu__menu-dropdown dropdown">
						<li class="mobilemenu__menu-item mobilemenu__menu-item--back">
							<div class="link-wrapper stroke-theme-parent-all colored_theme_hover_bg-block animate-arrow-hover color-theme-parent-all">
								<a class="arrow-all arrow-all--wide stroke-theme-target" href="" rel="nofollow">
									<?=CAllcorp3::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH.'/images/svg/Arrow_lg.svg');?>
									<div class="arrow-all__item-line colored_theme_hover_bg-el"></div>
								</a>
							</div>
						</li>
						<li class="mobilemenu__menu-item mobilemenu__menu-item--title">
							<div class="link-wrapper">
								<a class="dark_link" href="<?=$link;?>">
									<span class="font_18 font_bold"><?=Loc::getMessage('MY_CABINET')?></span>
								</a>
							</div>
						</li>
						<?foreach($arResult as $arItem):?>
							<?$bShowChilds = $arParams['MAX_LEVEL'] > 1;?>
							<?$bParent = $arItem['CHILD'] && $bShowChilds;?>
							<li class="mobilemenu__menu-item<?=($arItem['SELECTED'] ? ' mobilemenu__menu-item--selected' : '')?><?=($bParent ? ' mobilemenu__menu-item--parent' : '')?>">
								<div class="link-wrapper bg-opacity-theme-parent-hover fill-theme-parent-all">
									<?if( strpos($arItem["LINK"] ,'?logout=yes') !== false ){
										$arItem["LINK"].= '&'.bitrix_sessid_get();
									}?>
									<a class="dark_link" href="<?=$arItem["LINK"]?>" title="<?=htmlspecialcharsbx($arItem["TEXT"])?>"<?=$arItem['ATTRIBUTE']?>>
										<span class="font_15"><?=$arItem['TEXT']?></span>
										<?if($bParent):?>
											<?=CAllcorp3::showIconSvg('down menu-arrow bg-opacity-theme-target fill-theme-target', SITE_TEMPLATE_PATH.'/images/svg/Triangle_right.svg', '', '', true, false);?>
										<?endif;?>
									</a>
									<?if($bParent):?>
										<span class="toggle_block"></span>
									<?endif;?>
								</div>
								<?if($bParent):?>
									<ul class="mobilemenu__menu-dropdown dropdown">
										<li class="mobilemenu__menu-item mobilemenu__menu-item--back">
											<div class="link-wrapper stroke-theme-parent-all colored_theme_hover_bg-block animate-arrow-hover color-theme-parent-all">
												<a class="arrow-all arrow-all--wide stroke-theme-target" href="" rel="nofollow">
													<?=CAllcorp3::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH.'/images/svg/Arrow_lg.svg');?>
													<div class="arrow-all__item-line colored_theme_hover_bg-el"></div>
												</a>
											</div>
										</li>
										<li class="mobilemenu__menu-item mobilemenu__menu-item--title">
											<div class="link-wrapper">
												<a class="dark_link" href="<?=$arItem['LINK']?>">
													<span class="font_18 font_bold"><?=$arItem['TEXT']?></span>
												</a>
											</div>
										</li>
										<?foreach($arItem['CHILD'] as $arSubItem):?>
											<?$bShowChilds = $arParams['MAX_LEVEL'] > 2;?>
											<?$bParent = $arSubItem['CHILD'] && $bShowChilds;?>
											<li class="mobilemenu__menu-item<?=($arSubItem['SELECTED'] ? ' mobilemenu__menu-item--selected' : '')?><?=($bParent ? ' mobilemenu__menu-item--parent' : '')?>">
												<div class="link-wrapper stroke-theme-parent-all colored_theme_hover_bg-block animate-arrow-hover color-theme-parent-all">
													<a class="dark_link" href="<?=$arSubItem["LINK"]?>" title="<?=htmlspecialcharsbx($arSubItem["TEXT"])?>">
														<span class="font_15"><?=$arSubItem['TEXT']?></span>
														<?if($bParent):?>
															<?=CAllcorp3::showIconSvg('down menu-arrow bg-opacity-theme-target fill-theme-target', SITE_TEMPLATE_PATH.'/images/svg/Triangle_right.svg', '', '', true, false);?>
														<?endif;?>
													</a>
													<?if($bParent):?>
														<span class="toggle_block"></span>
													<?endif;?>
												</div>
												<?if($bParent):?>
													<ul class="mobilemenu__menu-dropdown dropdown">
														<li class="mobilemenu__menu-item mobilemenu__menu-item--back">
															<div class="link-wrapper stroke-theme-parent-all colored_theme_hover_bg-block animate-arrow-hover color-theme-parent-all">
																<a class="arrow-all arrow-all--wide stroke-theme-target" href="" rel="nofollow">
																	<?=CAllcorp3::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH.'/images/svg/Arrow_lg.svg');?>
																	<div class="arrow-all__item-line colored_theme_hover_bg-el"></div>
																</a>
															</div>
														</li>
														<li class="mobilemenu__menu-item mobilemenu__menu-item--title">
															<div class="link-wrapper">
																<a class="dark_link" href="<?=$arSubItem['LINK']?>">
																	<span class="font_18 font_bold"><?=$arSubItem['TEXT']?></span>
																</a>
															</div>
														</li>
														<?foreach($arSubItem["CHILD"] as $arSubSubItem):?>
															<?$bShowChilds = $arParams['MAX_LEVEL'] > 3;?>
															<?$bParent = $arSubSubItem['CHILD'] && $bShowChilds;?>
															<li class="mobilemenu__menu-item<?=($arSubSubItem['SELECTED'] ? ' mobilemenu__menu-item--selected' : '')?><?=($bParent ? ' mobilemenu__menu-item--parent' : '')?>">
																<div class="link-wrapper stroke-theme-parent-all 
																	<a class="dark_link" href="<?=$arSubSubItem["LINK"]?>" title="<?=htmlspecialcharsbx($arSubSubItem["TEXT"])?>">
																		<span class="font_15"><?=$arSubSubItem['TEXT']?></span>
																		<?if($bParent):?>
																			<?=CAllcorp3::showIconSvg('down menu-arrow bg-opacity-theme-target fill-theme-target', SITE_TEMPLATE_PATH.'/images/svg/Triangle_right.svg', '', '', true, false);?>
																		<?endif;?>
																	</a>
																	<?if($bParent):?>
																		<span class="toggle_block"></span>
																	<?endif;?>
																</div>
																<?if($bParent):?>
																	<ul class="mobilemenu__menu-dropdown dropdown">
																		<li class="mobilemenu__menu-item mobilemenu__menu-item--back">
																			<div class="link-wrapper stroke-theme-parent-all colored_theme_hover_bg-block animate-arrow-hover color-theme-parent-all">
																				<a class="arrow-all arrow-all--wide stroke-theme-target" href="" rel="nofollow">
																					<?=CAllcorp3::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH.'/images/svg/Arrow_lg.svg');?>
																					<div class="arrow-all__item-line colored_theme_hover_bg-el"></div>
																				</a>
																			</div>
																		</li>
																		<li class="mobilemenu__menu-item mobilemenu__menu-item--title">
																			<div class="link-wrapper">
																				<a class="dark_link" href="<?=$arSubSubItem['LINK']?>">
																					<span class="font_18 font_bold"><?=$arSubSubItem['TEXT']?></span>
																				</a>
																			</div>
																		</li>
																		<?foreach($arSubSubItem["CHILD"] as $arSubSubSubItem):?>
																			<li class="mobilemenu__menu-item<?=($arSubSubSubItem['SELECTED'] ? ' mobilemenu__menu-item--selected' : '')?>">
																				<div class="link-wrapper stroke-theme-parent-all 
																					<a class="dark_link" href="<?=$arSubSubSubItem["LINK"]?>" title="<?=htmlspecialcharsbx($arSubSubSubItem["TEXT"])?>">
																						<span class="font_15"><?=$arSubSubSubItem['TEXT']?></span>
																					</a>
																				</div>
																			</li>
																		<?endforeach;?>
																	</ul>
																<?endif;?>
															</li>
														<?endforeach;?>
													</ul>
												<?endif;?>
											</li>
										<?endforeach;?>
									</ul>
								<?endif;?>
							</li>
						<?endforeach;?>
					</ul>
				<?endif;?>
			</li>
		</ul>
	</div>
<?endif;?>
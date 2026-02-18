<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->setFrameMode(true);?>
<?
?>
<?if($arResult):?>
	<div class="burger-menu <?=$arParams['DARK'] ? 'burger-menu--dark' : ''?>">
		<?
		$counter = 1;
		foreach($arResult as $arItem):?>
			<?$bShowChilds = $arItem["CHILD"] && $arParams["MAX_LEVEL"] > 1;?>
			<div class="burger-menu__item--large  <?=($counter == 1 ? "burger-menu__item--first burger-menu__item--current" : "")?> <?=($counter == count($arResult) ? "burger-menu__item--last" : "")?> <?=($bShowChilds ? "burger-menu__item--dropdown" : "")?> <?=($arItem["SELECTED"] ? " burger-menu__item--active" : "")?>">
				<a class="burger-menu__link--large burger-menu__link--light switcher-title dark_link" href="<?=$arItem["LINK"]?>"<?=$arItem['ATTRIBUTE']?>>
					<?=$arItem["TEXT"]?>
				</a>
				<span class="burger-menu__item-delimiter"></span>
				<?if($bShowChilds):?>
					<ul class="burger-menu__dropdown--right">
						<?foreach($arItem["CHILD"] as $arSubItem):?>
							<?$bShowChilds = $arSubItem["CHILD"] && $arParams["MAX_LEVEL"] > 2;?>
							<li class="burger-menu__dropdown-item--middle <?=($bShowChilds ? "burger-menu__dropdown-item--with-dropdown" : "")?> <?=($arSubItem["SELECTED"] ? "burger-menu__dropdown-item--active" : "")?>">
								<div class="burger-menu__link-wrapper">
									<a class="burger-menu__link--middle burger-menu__link--light font_18 dark_link" href="<?=$arSubItem["LINK"]?>" title="<?=$arSubItem["TEXT"]?>">
										<?=$arSubItem["TEXT"]?>
									</a>
									
									<?if($bShowChilds):?>
										<?=CAllcorp3::showIconSvg(' burger-menu__dropdown-right-arrow bg-theme-hover', SITE_TEMPLATE_PATH.'/images/svg/Arrow_right_small.svg');?>
									<?endif;?>
								</div>
								<?if($bShowChilds):?>
									<ul class="burger-menu__dropdown--bottom">
										<?foreach($arSubItem["CHILD"] as $key => $arSubSubItem):?>
											<li class="burger-menu__dropdown-item--small <?=($arSubSubItem["SELECTED"] ? "burger-menu__dropdown-item--active" : "")?>">
												<a class="burger-menu__link--small burger-menu__link--light font_14 dark_link" href="<?=$arSubSubItem["LINK"]?>" title="<?=$arSubSubItem["TEXT"]?>">
													<?=$arSubSubItem["TEXT"]?>
												</a>
											</li>
										<?endforeach;?>
									</ul>
								<?endif;?>
							</li>
						<?endforeach;?>
					</ul>
				<?endif;?>
			</div>
			<?$counter++;?>
		<?endforeach;?>
	</div>
<?endif;?>
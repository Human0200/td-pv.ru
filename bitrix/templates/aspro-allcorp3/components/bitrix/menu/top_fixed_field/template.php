<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->setFrameMode(true);?>
<?if($arResult):?>
	<ul class="nav nav-pills responsive-menu" id="mainMenuF">
		<?foreach($arResult as $arItem):?>
			<?$bShowChilds = ($arParams["MAX_LEVEL"] > 1 && $arItem["PARAMS"]["CHILD"]!="N");?>
			<li class="<?=($arItem["CHILD"] && $bShowChilds ? "dropdown" : "")?> <?=($arItem["SELECTED"] ? "active" : "")?>">
				<a class="dark-color <?=($arItem["CHILD"] && $bShowChilds ? "dropdown-toggle" : "")?>" href="<?=$arItem["LINK"]?>" title="<?=$arItem["TEXT"]?>">
					<?=$arItem["TEXT"]?><?if($arItem["CHILD"] && $bShowChilds):?><i class="fa fa-angle-right"></i><?endif;?>
				</a>
				<?if($arItem["CHILD"] && $bShowChilds):?>
					<ul class="dropdown-menu fixed_menu_ext">
						<?foreach($arItem["CHILD"] as $arSubItem):?>
							<?$bShowChilds = $arParams["MAX_LEVEL"] > 2;?>
							<li class="<?=($arSubItem["CHILD"] && $bShowChilds ? "dropdown-submenu dropdown-toggle" : "")?> <?=($arSubItem["SELECTED"] ? "active" : "")?>">
								<a href="<?=$arSubItem["LINK"]?>" title="<?=$arSubItem["TEXT"]?>" class="dark-color"<?=$arItem['ATTRIBUTE']?>>
									<?=$arSubItem["TEXT"]?><?if($arSubItem["CHILD"] && $bShowChilds):?><i class="fa fa-angle-right"></i><?endif;?>
								</a>
								<?if($arSubItem["CHILD"] && $bShowChilds):?>
									<ul class="dropdown-menu fixed_menu_ext">
										<?foreach($arSubItem["CHILD"] as $arSubSubItem):?>
											<?$bShowChilds = $arParams["MAX_LEVEL"] > 3;?>
											<li class="<?=($arSubSubItem["CHILD"] && $bShowChilds ? "dropdown-submenu dropdown-toggle" : "")?> <?=($arSubSubItem["SELECTED"] ? "active" : "")?>">
												<a href="<?=$arSubSubItem["LINK"]?>" title="<?=$arSubSubItem["TEXT"]?>" class="dark-color">
													<?=$arSubSubItem["TEXT"]?><?if($arSubSubItem["CHILD"] && $bShowChilds):?><i class="fa fa-angle-right"></i><?endif;?>
												</a>
												<?if($arSubSubItem["CHILD"] && $bShowChilds):?>
													<ul class="dropdown-menu fixed_menu_ext">
														<?foreach($arSubSubItem["CHILD"] as $arSubSubSubItem):?>
															<li class="<?=($arSubSubSubItem["SELECTED"] ? "active" : "")?>">
																<a href="<?=$arSubSubSubItem["LINK"]?>" title="<?=$arSubSubSubItem["TEXT"]?>" class="dark-color"><?=$arSubSubSubItem["TEXT"]?></a>
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
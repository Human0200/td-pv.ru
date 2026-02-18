<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();?>
<?$this->setFrameMode(true);?>
<?use \Bitrix\Main\Localization\Loc;?>
<?
if(!function_exists("ShowSubItemsLeft")){
	function ShowSubItemsLeft($arItem){
		?>
		<?if(/*$arItem["SELECTED"] &&*/ $arItem["CHILD"]):?>
			<?$noMoreSubMenuOnThisDepth = false;?>
			<div class="submenu-wrapper">
				<ul class="submenu">
					<?foreach($arItem["CHILD"] as $arSubItem):?>
						<li class="<?=($arSubItem["SELECTED"] ? "active opened" : "")?><?=($arSubItem["CHILD"] ? " child" : "")?>">
							<span class="bg-opacity-theme-parent-hover link-wrapper fill-theme-parent-all">
								<a href="<?=$arSubItem["LINK"]?>" class="dark_link font_<?=($arSubItem['PARAMS']['DEPTH_LEVEL'] == 2 ? 14 : 13);?> sublink <?=($arSubItem["CHILD"] ? " sublink--child" : "")?> <?=($arSubItem["SELECTED"] ? " link--active" : "")?>">
									<?if($arSubItem["CHILD"]):?>
										<?=CAllcorp3::showIconSvg("down menu-arrow bg-opacity-theme-target fill-theme-target fill-dark-light-block", SITE_TEMPLATE_PATH.'/images/svg/Triangle_down.svg', '', '', true, false);?>
									<?endif;?>
									<?=$arSubItem["TEXT"]?>
								</a>
								<?if($arSubItem["CHILD"]):?>
									<span class="toggle_block"></span>
								<?endif;?>
							</span>
							<?if(!$noMoreSubMenuOnThisDepth):?>
								<?ShowSubItemsLeft($arSubItem);?>
							<?endif;?>
						</li>
						<?$noMoreSubMenuOnThisDepth |= CAllcorp3::isChildsSelected($arSubItem["CHILD"]);?>
					<?endforeach;?>
				</ul>
			</div>
		<?endif;?>
		<?
	}
}
?>
<?if($arResult):?>
	<?$bCatalog = CAllcorp3::IsCatalogPage();?>
	<aside class="sidebar">
		<?if ($bCatalog):?>
			<div class="slide-block">
				<div class="slide-block__head title-menu stroke-theme-parent-all color_333 text-upper font_12 bordered rounded-4 <?=($_COOKIE['MENU_CLOSED'] == 'Y' ? ' closed' : '');?>" data-id="MENU">
					<?=Loc::getMessage('CATALOG_LINK');?>
					<?=CAllcorp3::showIconSvg("down stroke-theme-target", SITE_TEMPLATE_PATH.'/images/svg/arrow_catalogcloser.svg', '', '', true, false);?>
				</div>
				<div class="slide-block__body">
			<?endif;?>
				
		<ul class="nav nav-list side-menu bordered rounded-4">
			<?foreach($arResult as $arItem):?>
				<li class="<?=($arItem["SELECTED"] ? "active opened" : "")?> <?=($arItem["CHILD"] && !isset($arItem["NO_PARENT"]) ? "child" : "")?>">
					<span class="bg-opacity-theme-parent-hover link-wrapper fill-theme-parent-all">
						<?if( strpos($arItem["LINK"] ,'?logout=yes') !== false ){
							$arItem["LINK"].= '&'.bitrix_sessid_get();
						}?>
						<a href="<?=$arItem["LINK"]?>" class="dark_link top-level-link <?=($arItem["SELECTED"] ? " link--active" : "")?> link-with-flag"<?=$arItem['ATTRIBUTE']?>><?=(isset($arItem["PARAMS"]["BLOCK"]) && $arItem["PARAMS"]["BLOCK"] ? $arItem["PARAMS"]["BLOCK"] : "");?>
							<?if($arItem["CHILD"] && !isset($arItem["NO_PARENT"])):?>
								<?=CAllcorp3::showIconSvg("down menu-arrow bg-opacity-theme-target fill-theme-target fill-dark-light-block", SITE_TEMPLATE_PATH.'/images/svg/Triangle_down.svg', '', '', true, false);?>
							<?endif;?>
							<?=$arItem["TEXT"]?>
						</a>
						<?if($arItem["CHILD"] && !isset($arItem["NO_PARENT"])):?>
							<span class="toggle_block"></span>
						<?endif;?>
					</span>
					<?ShowSubItemsLeft($arItem);?>
				</li>
			<?endforeach;?>
		</ul>
		<?if ($bCatalog):?>
			</div>
			</div>
		<?endif;?>
	</aside>
<?endif;?>
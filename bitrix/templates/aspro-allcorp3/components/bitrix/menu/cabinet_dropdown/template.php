<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();?>
<?$this->setFrameMode(true);?>
<?
if(!function_exists("ShowSubItems")){
	function ShowSubItems($arItem){
		?>
		<?if($arItem["SELECTED"] && $arItem["CHILD"]):?>
			<?$noMoreSubMenuOnThisDepth = false;?>
			<div class="submenu-wrapper">
				<ul class="submenu">
					<?foreach($arItem["CHILD"] as $arSubItem):?>
						<li class="<?=($arSubItem["SELECTED"] ? "active" : "")?><?=($arSubItem["CHILD"] ? " child" : "")?>">
							<a href="<?=$arSubItem["LINK"]?>"><?=$arSubItem["TEXT"]?></a>
							<?if(!$noMoreSubMenuOnThisDepth):?>
								<?ShowSubItems($arSubItem);?>
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
	<div class="cabinet-dropdown <?=$arParams['DROPDOWN_TOP'] ? 'cabinet-dropdown--top' : ''?>">
		<div class="dropdown dropdown--relative">
			<?$counter = 1;?>
			<?foreach($arResult as $arItem):?>
				<div class="cabinet-dropdown__item <?=($arItem["SELECTED"] ? "active" : "")?> <?=($arItem["CHILD"] ? "child" : "")?> <?=($counter == 1 ? "cabinet-dropdown__item--first" : "")?> <?=($counter == count($arResult) ? "cabinet-dropdown__item--last stroke-theme-hover stroke-dark-light-block" : "")?>">
					<?if( strpos($arItem["LINK"] ,'?logout=yes') !== false ){
						$arItem["LINK"].= '&'.bitrix_sessid_get();
					}?>
					<a class="font_13 dark_link" href="<?=$arItem["LINK"]?>"<?=$arItem['ATTRIBUTE']?>><?=(isset($arItem["PARAMS"]["BLOCK"]) && $arItem["PARAMS"]["BLOCK"] ? $arItem["PARAMS"]["BLOCK"] : "");?><?=$arItem["TEXT"]?></a>
					<?ShowSubItems($arItem);?>
				</div>
				<?$counter++;?>
			<?endforeach;?>
		</div>
	</div>
<?endif;?>
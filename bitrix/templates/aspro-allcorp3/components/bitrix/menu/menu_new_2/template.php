<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->setFrameMode(true);?>
<?
global $arTheme;
$iVisibleItemsMenu = ($arTheme['MAX_VISIBLE_ITEMS_MENU']['VALUE'] ? $arTheme['MAX_VISIBLE_ITEMS_MENU']['VALUE'] : 10);
//$sViewTypeMenu = $arTheme['VIEW_TYPE_MENU']['VALUE'];
$sCountElementsMenu = "count_".$arTheme['COUNT_ITEMS_IN_LINE_MENU']['VALUE'];
?>
<?if($arResult):?>
	<div class="catalog_icons_<?=$arTheme['SHOW_CATALOG_SECTIONS_ICONS']['VALUE'];?>">
		<div class="header-menu-view2__wrapper">
			<?foreach($arResult as $arItem):?>
				<?
				$bWideMenu = ($arItem["PARAMS"]["WIDE_MENU"] == "Y");
				?>
				<div class="header-menu-view2__item unvisible <?=($bShowChilds ? "header-menu-view2__item--dropdown" : "")?><?=($bWideMenu ? " header-menu-view2__item--wide" : "")?><?=($arItem["SELECTED"] ? " active" : "")?>">
					<a class="header-menu-view2__link menu-light-text banner-light-text dark_link light-opacity-hover" href="<?=$arItem["LINK"]?>"<?=$arItem['ATTRIBUTE']?>>
						<div class="header-menu-view2__title font_14">
							<?=$arItem["TEXT"]?>
						</div>
					</a>
				</div>
			<?endforeach;?>
		</div>
	</div>
<?endif;?>
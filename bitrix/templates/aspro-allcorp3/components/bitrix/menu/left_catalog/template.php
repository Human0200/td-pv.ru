<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? $this->setFrameMode( true ); ?>
<?if( !empty( $arResult ) ){
	global $arTheme;
	$iVisibleItemsMenu = ($arTheme['MAX_VISIBLE_ITEMS_MENU']['VALUE'] ? $arTheme['MAX_VISIBLE_ITEMS_MENU']['VALUE'] : 10);
	$bRightSide = $arTheme['SHOW_RIGHT_SIDE']['VALUE'] == 'Y';
	$RightContent = $arTheme['SHOW_RIGHT_SIDE']['DEPENDENT_PARAMS']['RIGHT_CONTENT']['VALUE'];
	$bRightBanner = $bRightSide && $RightContent == 'BANNER';
	$bRightBrand = $bRightSide && $RightContent == 'BRANDS';
	$bRightPart = $arTheme['SHOW_RIGHT_SIDE']['VALUE'] == 'Y';
	?>
	<div class="menu-side-column">
		<ul class="menu-side-column__inner">
			<?
			$counter = 1;
			if($bRightPart) {
				include('bottom_banners.php'); // get $bannersHTML
			}
				
			foreach( $arResult as $key => $arItem ){
				$bWideMenu = isset($arItem["PARAMS"]['WIDE_MENU']) && $arItem["PARAMS"]['WIDE_MENU'] == 'Y';
				?>
				<li class="menu-side-column__item <?=$bWideMenu ? 'menu-side-column__item--wide' : ''?> fill-theme-parent <?=($counter == 1 ? "menu-side-column__item--first" : "");?> <?=($counter == count($arResult) ? "menu-side-column__item--last" : "");?> <?=($arItem["CHILD"] ? "has-child" : "");?> <?=($arItem["SELECTED"] ? "current opened" : "");?> m_<?=strtolower($arTheme["MENU_POSITION"]["VALUE"]);?> v_<?=strtolower($arTheme["MENU_TYPE_VIEW"]["VALUE"]);?>">
					<a class="menu-side-column__item-link font_15 dark_link <?=($arItem["CHILD"] ? "parent" : "");?>" href="<?=$arItem["LINK"]?>"<?=$arItem['ATTRIBUTE']?>>
						<span class="name"><?=$arItem["TEXT"]?></span>
					</a>
					<?if($arItem["CHILD"]){?>
						<?=TSolution::showIconSvg(' fill-theme-target header-menu-side__wide-submenu-right-arrow fill-dark-light-block', SITE_TEMPLATE_PATH.'/images/svg/Arrow_right_small.svg');?>
						<div class="menu-side-column__dropdown <?=$bWideMenu ? 'menu-side-column__dropdown--wide' : ''?> <?=$bWideMenu && $bannersHTML ? 'menu-side-column__dropdown--with-banners' : ''?> <?=strtolower($arTheme["MENU_TYPE_VIEW"]["VALUE"]) == 'bottom' ? 'dropdown' : ''?>">
							<?if($bWideMenu):?>
								<?include('wide_menu.php');?>
							<?else:?>
								<?include('menu_columns.php');?>
							<?endif;?>
						</div>
					<?}?>
				</li>
			<?
			$counter++;
			}?>
		</ul>
		
		<?if($bannersHTML):?>
			<div class="menu-side-column__bottom-banners">
				<?=$bannersHTML?>
			</div>
		<?endif;?>
	</div>
<?}?>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<!--noindex-->
	<?$count=count($arResult);?>
	<a class="icon-block-with-counter compare-link <?=$arParams["CLASS_LINK"];?>" href="<?=$arParams["COMPARE_URL"]?>" title="<?=\Bitrix\Main\Localization\Loc::getMessage('CATALOG_COMPARE_ELEMENTS_ALL');?>">
		<span class="compare-block icon-block-with-counter__inner <?=$arParams["CLASS_ICON"];?> fill-use-888 fill-theme-use-svg-hover">
			
			<span class="js-compare-block <?=($count ? 'icon-block-with-counter--count' : '');?>">
				<?global $compare_items;
				$compare_items = array_keys($arResult);?>
				<script>
					if (typeof arAsproOptions === 'object' && arAsproOptions) {
						arAsproOptions['COMPARE_ITEMS'] = <?=CUtil::PhpToJsObject($compare_items)?>
					}
					if (typeof setCompareItemsClass === 'function') setCompareItemsClass()
				</script>
					
				<span class="icon-count icon-count--compare bg-more-theme count"><?=$count;?></span>
			</span>

			<?=\CAllcorp3::showSpriteIconSvg(SITE_TEMPLATE_PATH."/images/svg/catalog/item_icons.svg#compare", "compare", ['WIDTH' => 14,'HEIGHT' => 18]);?>
			
			<?if ($arParams['MESSAGE']):?>
				<span class="header__icon-name title dark_link menu-light-text banner-light-text"><?=$arParams['MESSAGE'];?></span>
			<?endif;?>
				
		</span>
	</a>
<!--/noindex-->
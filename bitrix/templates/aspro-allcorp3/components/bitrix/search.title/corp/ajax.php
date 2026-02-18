<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?if (empty($arResult["CATEGORIES"])) return;?>
<div class="searche-result scroll-deferred1 srollbar-custom">
	<?foreach($arResult["CATEGORIES"] as $category_id => $arCategory):?>
		<?foreach($arCategory["ITEMS"] as $i => $arItem):?>
			<?//=$arCategory["TITLE"]?>
			<?if($category_id === "all"):?>
				<div class="searche-result__item searche-result__item--find">
					<div class="searche-result__inner maxwidth-theme flexbox flexbox--direction-row">
						<div class="searche-result__item-text">
							<a class="all_result_title btn btn-transparent-border" href="<?=$arItem["URL"]?>"><?=$arItem["NAME"]?></a>
						</div>
					</div>
				</div>
			<?elseif(isset($arResult["ELEMENTS"][$arItem["ITEM_ID"]])):
				$arElement = $arResult["ELEMENTS"][$arItem["ITEM_ID"]];?>
				<a class="searche-result__item dark_link" href="<?=$arItem["URL"]?>">
					<span class="searche-result__inner maxwidth-theme flexbox flexbox--direction-row">
						<span class="searche-result__item-image">
							<?if(is_array($arElement["PICTURE"])):?>
								<img class="img-responsive" src="<?=$arElement["PICTURE"]["src"]?>"/>
							<?else:?>
								<img class="img-responsive" src="<?=SITE_TEMPLATE_PATH?>/images/svg/search_sm.svg"/>
							<?endif;?>
						</span>
						<span class="searche-result__item-text">
							<span><?=$arItem["NAME"]?></span>
						</span>
					</span>
				</a>
			<?else:?>
				<?if($arItem["MODULE_ID"]):?>
					<a class="searche-result__item dark_link others_result" href="<?=$arItem["URL"]?>">
						<span class="searche-result__inner maxwidth-theme flexbox flexbox--direction-row">
							<span class="searche-result__item-image">
								<img class="img-responsive" src="<?=SITE_TEMPLATE_PATH?>/images/svg/search_sm.svg"/>
							</span>
							<span class="searche-result__item-text">
								<span><?=$arItem["NAME"]?></span>
							</span>
						</span>
					</a>
				<?endif;?>
			<?endif;?>
		<?endforeach;?>
	<?endforeach;?>
</div>
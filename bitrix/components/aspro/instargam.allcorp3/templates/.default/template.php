<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */

$this->setFrameMode(true);?>
<?if($arResult['ITEMS']):?>
	<?
	$bWide = $arParams['WIDE'] == 'Y';
	$bItemsOffset = $arParams['ITEMS_OFFSET'] == 'Y';
	$bWidePictureBlock = $arParams['TYPE_BLOCK'] == 'WITH_BIG_BLOCK';
	$gridClass = 'grid-list';

	$gridClass .= ' mobile-scrolled mobile-scrolled--items-2 mobile-offset grid-list--items-3-991';
	if (!$bItemsOffset) {
		$gridClass .= ' grid-list--no-gap';
	}
	if ($arParams['NO_GRID']) {
		$gridClass .= ' grid-list--no-grid';
	}

	if ($bWidePictureBlock) {
		$arParams['ELEMENTS_ROW'] = 5;
	}

	if ($bWide) {
		$gridClass .= ' grid-list--items-'.$arParams['ELEMENTS_ROW'].'-wide';
	} else {
		$gridClass .= ' grid-list--items-'.$arParams['ELEMENTS_ROW'];
	}

	$itemWrapperClasses = ' grid-list__item';
	if (!$bItemsOffset) {
		$itemWrapperClasses .= ' grid-list-border-outer';
	}

	$itemClasses = 'dark-block-hover';
	if ($bItemsOffset) {
		$itemClasses .= ' rounded-4';
	}
	?>
	<?$obParser = new CTextParser;?>

	<div class="instagramm-list <?=$templateName?>-template type-<?=$arParams['TYPE_BLOCK']?>">
		<?=TSolution\Functions::showTitleBlock([
			'PATH' => 'instagramm-list',
			'PARAMS' => $arParams,
		]);?>
		<?if(!$bWide):?>
			<div class="maxwidth-theme">
		<?elseif ($bItemsOffset):?>
			<div class="maxwidth-theme maxwidth-theme--no-maxwidth">
		<?endif;?>

		<div class="<?=$gridClass?>">
			<?$counter = 1;?>
			<?foreach($arResult['ITEMS'] as $i => $arItem):?>
				<?$arItem['LINK'] = $arItem['thumbnail_url'] ? $arItem['thumbnail_url'] : $arItem['media_url'];?>
				<div class="instagramm-list__wrapper <?=$itemWrapperClasses;?>">
					<div class="instagramm-list__item <?=$itemClasses?>">
						<div class="instagramm-list__item-image " style="background:url(<?=$arItem['LINK'];?>) center center/cover no-repeat;"></div>
						<div class="instagramm-list__item-info item-link-absolute animate-arrow-hover">
							<div class="instagramm-list__item-inner color_light scroll-deferred srollbar-custom">
								<div class="instagramm-list__item-wrapper">
									<a href="<?=$arItem['permalink']?>" target="_blank" class="item-link-absolute"></a>
									<div class="instagramm-list__item-date font_13"><span><?=FormatDate('d.m.Y', strtotime($arItem['timestamp']), 'SHORT');?></span></div>
									<div class="arrow-all">
										<?=TSolution::showIconSvg(' arrow-all__item-arrow arrow-all--light-stroke', SITE_TEMPLATE_PATH.'/images/svg/Arrow_map.svg');?>
										<div class="arrow-all__item-line arrow-all--light-bgcolor"></div>
									</div>
									<?if ($arItem['caption']):?>
										<div class="instagramm-list__item-text font_14 font_large"><?=($obParser->html_cut($arItem['caption'], $arResult['TEXT_LENGTH']));?></div>
									<?endif;?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?$counter++;?>
			<?endforeach;?>
		</div>

		<?if(!$bWide || $bItemsOffset):?>
			</div>
		<?endif;?>

	</div>
<?endif;?>
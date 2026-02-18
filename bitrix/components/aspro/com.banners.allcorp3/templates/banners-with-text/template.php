<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>

<?if($arResult['ITEMS']):?>
	<?
	$bNarrow = $arParams['WIDE'] !== 'Y';
	$bItemOffset = $arParams['ITEMS_OFFSET'] === 'Y';
	$bShortBlock = $arParams['SHORT_BLOCK'] === 'Y';
	$bTextBG = $arParams['TEXT_POSITION'] === 'BG';

	$gridClass = ['grid-list grid-list--items-2-991 mobile-scrolled mobile-scrolled--items-2 elements-count-'.$arParams['ELEMENTS_ROW']];

	if (!$bItemOffset) {
		$gridClass[] = 'grid-list--no-gap';
	}

	if ($bNarrow) {
		$gridClass[] = 'mobile-offset';

		if (!$bItemOffset) {
			$gridClass[] = 'mobile-offset--right';
		}
	} else if ($bItemOffset) {
		$gridClass[] = 'mobile-offset';
	}

	if ($arParams['NO_GRID']) {
		$gridClass[] = 'grid-list--no-grid';
	}
	if (!$bNarrow) {
		$gridClass[] = 'grid-list--items-'.$arParams['ELEMENTS_ROW'].'-wide grid-list--wide';
	} else {
		$gridClass[] = 'grid-list--items-'.$arParams['ELEMENTS_ROW'];
	}

	$itemClass = ' hover_zoom';
	if ($bTextBG) {
		$itemClass .= ' shadow-hovered shadow-no-border-hovered';
	} else {
		$itemClass .= ' color-theme-parent-all';
		$gridClass[] = 'grid-list--gap-row';
	}
	if ($bItemOffset) {
		$itemClass .= ' rounded-4';
	}
	if ($bShortBlock) {
		$itemClass .= ' banners-img-with-text-list__item--short';
	}

	$imageClass = '';
	if ($bTextBG) {
		$imageClass .= ' dark-block-after';
	}
	if ($bShortBlock) {
		$imageClass .= ' banners-img-with-text-list__item-image--short';
	}

	$itemTextClass = '';
	if ($bTextBG) {
		$itemTextClass .= ' banners-img-with-text-list__item-text--absolute';
	}
	if ($arParams['TEXT_CENTER'] === 'Y') {
		$itemTextClass .= ' banners-img-with-text-list__item-text--centered';
	}

	$fontClass = 'font_';
	if ($arParams['ELEMENTS_ROW'] == 2) {
		$fontClass .= '24';
	} elseif ($arParams['ELEMENTS_ROW'] == 3) {
		$fontClass .= '20';
	} elseif ($arParams['ELEMENTS_ROW'] == 4) {
		$fontClass .= '18';
	}

	$gridClass = TSolution\Utils::implodeClasses($gridClass);
	?>

	<div class="banners-img-with-text-list <?=$templateName?>-template">

		<?if($bNarrow):?>
			<div class="maxwidth-theme">
		<?elseif ($bItemOffset):?>
			<div class="maxwidth-theme maxwidth-theme--no-maxwidth">
		<?endif;?>

			<div class="<?=$gridClass?>">
				<?foreach ($arResult['ITEMS'] as $arItem) {
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
					$url = $arItem['DISPLAY_PROPERTIES']['URL']['VALUE'] ?? '';
					?>
					<?ob_start();?>
						<?if($bTextBG && $url):?>
							<a class="banners-img-with-text-list__item-link item-link-absolute" href="<?=$url?>"></a>
						<?endif;?>
					<?$linkHtml = ob_get_clean();?>
					<div class="banners-img-with-text-list__wrapper grid-list__item">
						<div class="banners-img-with-text-list__item <?=$itemClass;?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
							<?if ($url && !$bTextBG):?>
								<a href="<?=$url;?>" class="banners-img-with-text-list__item-link<?=($bItemOffset ? ' rounded-4' : '');?>" title="<?=($arItem['PREVIEW_PICTURE']['TITLE']?$arItem['PREVIEW_PICTURE']['TITLE']:$arItem['NAME']);?>">
							<?endif;?>
							<span class="banners-img-with-text-list__item-image <?=($url ? ' shine' : '');?> <?=$imageClass?>" style="background-image:url(<?=$arItem['PREVIEW_PICTURE']['SRC'];?>)"></span>
							<?if ($url && !$bTextBG):?>
								</a>
							<?endif;?>

							<?=$linkHtml;?>

							<div class="banners-img-with-text-list__item-text<?=$itemTextClass;?>">
								<?if($arItem['DISPLAY_PROPERTIES']['TOP_TEXT'] && $arItem['DISPLAY_PROPERTIES']['TOP_TEXT']['VALUE']):?>
									<div class="banners-img-with-text-list__item-top-text font_13"><?=$arItem['DISPLAY_PROPERTIES']['TOP_TEXT']['VALUE'];?></div>
								<?endif;?>
								<div class="banners-img-with-text-list__item-title switcher-title <?=$fontClass;?>">
									<?if($url):?>
										<a href="<?=$url;?>" class="dark_link color-theme-target" title="<?=($arItem['PREVIEW_PICTURE']['TITLE']?$arItem['PREVIEW_PICTURE']['TITLE']:$arItem['NAME']);?>">
									<?endif;?>
									<?=$arItem['NAME'];?>
									<?if($url):?>
										</a>
									<?endif;?>
								</div>
								<?=$linkHtml;?>
							</div>
						</div>
					</div>
				<?}?>
			</div>

		<?if($bNarrow || $bItemOffset):?>
			</div>
		<?endif;?>

	</div>
<?endif;?>

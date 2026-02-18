<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>

<?if($arResult['ITEMS']):?>
	<?
	$bNarrow = $arParams['WIDE'] !== 'Y';
	$bItemOffset = $arParams['ITEMS_OFFSET'] === 'Y';
	$bShortBlock = $arParams['SHORT_BLOCK'] === 'Y';
	$bTextBG = true;

	$gridClass = 'grid-list grid-list--items-2-991 mobile-scrolled mobile-scrolled--items-2 grid-list--no-grid';
	if ($bItemOffset) {
		$gridClass .= ' mobile-offset';
	} else {
		$gridClass .= ' grid-list--no-gap';
	}

	$itemClass = ' hover_zoom';
	if ($bTextBG) {
		$itemClass .= ' shadow-hovered shadow-no-border-hovered';
	} else {
		$itemClass .= ' color-theme-parent-all';
	}
	if ($bItemOffset) {
		$itemClass .= ' rounded-4';
	}
	if ($bShortBlock) {
		$itemClass .= ' banners-with-text-mixed-list__item--short';
	}
	
	$imageClass = '';
	if ($bTextBG) {
		$imageClass .= ' dark-block-after';
	}
	if ($bShortBlock) {
		$imageClass .= ' banners-with-text-mixed-list__item-image--short';
	}
	
	$itemTextClass = ' banners-with-text-mixed-list__item-text--absolute';
	if ($arParams['TEXT_CENTER'] === 'Y') {
		$itemTextClass .= ' banners-with-text-mixed-list__item-text--centered';
	}

	$fontClass = 'font_'.($bNarrow ? 18 : 24);
	?>

	<div class="banners-with-text-mixed-list <?=$templateName?>-template">

		<?if($bNarrow):?>
			<div class="maxwidth-theme">
		<?elseif ($bItemOffset):?>
			<div class="maxwidth-theme maxwidth-theme--no-maxwidth">
		<?endif;?>

			<div class="<?=$gridClass?>">
				<?foreach ($arResult['ITEMS'] as $arItem) {
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
					$bUrl = (isset($arItem['DISPLAY_PROPERTIES']['URL']) && $arItem['DISPLAY_PROPERTIES']['URL']['VALUE']);
					// $sUrl = ($bUrl ? str_replace('//', '/', SITE_DIR.$arItem['DISPLAY_PROPERTIES']['URL']['VALUE']) : '');
					$sUrl = ($bUrl ? str_replace('//', '/', $arItem['DISPLAY_PROPERTIES']['URL']['VALUE']) : '');

					$widthItem = $arItem['PROPERTIES']['TYPE_BLOCK']['VALUE_XML_ID'] ?: 'item-w25';
					?>
					<?ob_start();?>
						<?if($bTextBG && $sUrl):?>
							<a class="banners-with-text-mixed-list__item-link item-link-absolute" href="<?=$sUrl?>"></a>
						<?endif;?>
					<?$linkHtml = ob_get_clean();?>
					<div class="banners-with-text-mixed-list__wrapper grid-list__item <?=$widthItem;?>">
						<div class="banners-with-text-mixed-list__item <?=$itemClass;?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
							<?if ($sUrl && !$bTextBG):?>
								<a href="<?=$sUrl;?>" class="banners-with-text-mixed-list__item-link<?=($bItemOffset ? ' rounded-4' : '');?>" title="<?=($arItem['PREVIEW_PICTURE']['TITLE']?$arItem['PREVIEW_PICTURE']['TITLE']:$arItem['NAME']);?>">
							<?endif;?>
							<span class="banners-with-text-mixed-list__item-image <?=($sUrl ? ' shine' : '');?> <?=$imageClass?>" style="background-image:url(<?=$arItem['PREVIEW_PICTURE']['SRC'];?>)"></span>
							<?if ($sUrl && !$bTextBG):?>
								</a>
							<?endif;?>

							<?=$linkHtml;?>

							<div class="banners-with-text-mixed-list__item-text<?=$itemTextClass;?>">
								<?if($arItem['DISPLAY_PROPERTIES']['TOP_TEXT'] && $arItem['DISPLAY_PROPERTIES']['TOP_TEXT']['VALUE']):?>
									<div class="banners-with-text-mixed-list__item-top-text font_13"><?=$arItem['DISPLAY_PROPERTIES']['TOP_TEXT']['VALUE'];?></div>
								<?endif;?>
								<div class="banners-with-text-mixed-list__item-title <?=$fontClass;?>">
									<?if($sUrl):?>
										<a href="<?=$sUrl;?>" class="dark_link color-theme-target" title="<?=($arItem['PREVIEW_PICTURE']['TITLE']?$arItem['PREVIEW_PICTURE']['TITLE']:$arItem['NAME']);?>">
									<?endif;?>
									<?=$arItem['NAME'];?>
									<?if($sUrl):?>
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
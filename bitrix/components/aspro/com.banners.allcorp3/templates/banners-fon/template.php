<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>

<?if($arResult['ITEMS']):?>
	<?
	$bNarrow = $arParams['WIDE'] !== 'Y';
	$bItemOffset = $arParams['ITEMS_OFFSET'] === 'Y';
	$bShortBlock = $arParams['SHORT_BLOCK'] === 'Y';
	$bBannerBigImg = $arParams['TYPE_BLOCK'] === 'BIG_BANNER';
	$bBannerSmallImg = $arParams['TYPE_BLOCK'] === 'SM_BANNER';
	$bBottomImg = $arParams['TYPE_BLOCK'] === 'BOTTOM_IMG';

	$minHeightClass = ' banners-fon-list__item--min-height';
	$flexboxClass = ' flexbox--direction-row flexbox--column-t991';
	$fontTitleClass = 'font_38';
	$fontSubTitleClass = 'font_14';

	if(count($arResult['ITEMS']) == 1) {
		$gridClass = 'grid-list';
	} else {
		$gridClass = 'grid-list grid-list--items-2-991 mobile-scrolled mobile-scrolled--items-2 mobile-offset elements-count-'.$arParams['ELEMENTS_ROW'];
	}

	if (!$bItemOffset) {
		$gridClass .= ' grid-list--no-gap';
	}
	if ($arParams['NO_GRID']) {
		$gridClass .= ' grid-list--no-grid';
	}
	if ($bBannerBigImg) {
		$gridClass .= ' grid-list--items-1';
	} elseif ($bBannerSmallImg) {
		$gridClass .= ' grid-list--items-2';
		$fontTitleClass = 'font_26';
		$fontSubTitleClass = 'font_13';
	} elseif (isset($arParams['ELEMENTS_ROW']) && $arParams['ELEMENTS_ROW']) {
		$gridClass .= ' grid-list--items-'.$arParams['ELEMENTS_ROW'];
	}
	if (!$bBannerBigImg && !$bNarrow) {
		$gridClass .= '-wide';
	}

	$itemClass = ' hover_zoom1 height-100 banners-fon-list__item--'.$arParams['TYPE_BLOCK'].$minHeightClass;
	$itemClass .= ' animate-arrow-hover bg-theme-parent-hover stroke-theme-parent-all';
	if ($bItemOffset) {
		$itemClass .= ' rounded-4';
	}
	if (!$bNarrow) {
		$itemClass .= ' banners-fon-list__item--wide';
	}

	$imageClass = ' banners-fon-list__item-image--absolute';

	$itemTextClass = '';

	if ($bBottomImg) {
		$flexboxClass = '';

		$fontTitleClass = 'font_34';
		if ($arParams['ELEMENTS_ROW'] == '3') {
			$fontTitleClass = 'font_24';
		}

		$itemClass .= ' text-center';
		$imageClass = ' banners-fon-list__item-image--static';
	}
	$flexboxClass .= ' height-100';

	$itemInnerClass = '';
	if ($bBannerSmallImg) {
		$itemInnerClass .= ' banners-fon-list__item-inner--FLEX';
	}?>

	<div class="banners-fon-list <?=$templateName?>-template">

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

					$bActivePicture = $arItem['PREVIEW_PICTURE'] && $arItem['PREVIEW_PICTURE']['SRC'];
					$bFonPicture = $arItem['DETAIL_PICTURE'] && $arItem['DETAIL_PICTURE']['SRC'];
					$bShowLink = ($arItem['DISPLAY_PROPERTIES']['BTN_LINK']['VALUE'] || $arItem['DISPLAY_PROPERTIES']['BTN_FORM_ID']['VALUE'] );

					if (!$bBannerSmallImg) {
						$bShowBtn = $arItem['DISPLAY_PROPERTIES']['BTN_TEXT']['VALUE'] && $bShowLink;
					} else {
						$bShowBtn = $bShowLink;
					}

					$classTextColor = 'color_dark';
					$style = '';

					if ($bFonPicture) {
						if (isset($arItem['PROPERTIES']['TEXTCOLOR']) && $arItem['PROPERTIES']['TEXTCOLOR']['VALUE_XML_ID']) {
							$classTextColor = 'color_' . $arItem['PROPERTIES']['TEXTCOLOR']['VALUE_XML_ID'];

							if ($arItem['PROPERTIES']['TEXTCOLOR']['VALUE_XML_ID'] === 'dark') {
								$style = 'style="--white_text_black: #333;--fill_dark_light_hover: var(--theme-base-color)"';
							}
						}
					}

					?>
					<?ob_start();?>
						<?if($url):?>
							<a class="banners-fon-list__item-link item-link-absolute" href="<?=$url?>"></a>
						<?endif;?>
					<?$linkHtml = ob_get_clean();?>
					<div class="banners-fon-list__wrapper grid-list__item">
						<div class="banners-fon-list__item <?=$itemClass;?> <?=($url && $bBannerSmallImg ? 'color-theme-parent-all hover_blink' : '');?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>" <?if ($bFonPicture):?>style="background-image:url(<?=$arItem['DETAIL_PICTURE']['SRC'];?>)"<?endif;?>>
							<?if (!$bActivePicture && !$bNarrow):?>
								<div class="maxwidth-theme maxwidth-theme--no-padding<?=$minHeightClass;?>">
							<?endif;?>
							<div class="flexbox <?=$flexboxClass;?> <?=$minHeightClass;?>">
								<?=$linkHtml;?>

								<div class="banners-fon-list__item-text<?=$itemTextClass;?>">
									<div class="banners-fon-list__item-inner <?=$itemInnerClass;?> <?=(!$bNarrow && $bActivePicture ? 'maxwidth-theme--half' : '');?>">
										<div class="banners-fon-list__item-info" <?=$style;?>>
											<?if($arItem['DISPLAY_PROPERTIES']['TOP_TEXT'] && $arItem['DISPLAY_PROPERTIES']['TOP_TEXT']['VALUE']):?>
												<div class="banners-fon-list__item-top-text <?=$fontSubTitleClass;?> <?= $classTextColor ?>--opacity"><?=$arItem['DISPLAY_PROPERTIES']['TOP_TEXT']['VALUE'];?></div>
											<?endif;?>
											<div class="banners-fon-list__item-title color-theme-target <?=$fontTitleClass;?> switcher-title <?= $classTextColor ?>">
												<?=$arItem['NAME'];?>
											</div>
											<?=$linkHtml;?>
											<?if ($arItem['FIELDS']['PREVIEW_TEXT'] && !$bBottomImg):?>
												<div class="banners-fon-list__item-description <?= $classTextColor ?>">
													<?=$arItem['PREVIEW_TEXT'];?>
												</div>
											<?endif;?>
										</div>
										<?if ($bShowBtn && !$bBottomImg):?>
											<div class="banners-fon-list__item-btn">
												<?
												$btnClass = 'btn btn-lg ';
												$btnClass .= $arItem['PROPERTIES']['BTN_CLASS']['VALUE'] ?: 'btn-default';
												if ($bBannerSmallImg) {
													$btnClass = 'banners-fon-list__item-btn-action animate-arrow-hover';
												}
												?>
												<?ob_start();?>
													<div class="arrow-all arrow-all--wide arrow-all--animate-right banners-arrow-action">
														<?=TSolution::showIconSvg(' arrow-all__item-arrow arrow-all--dark-stroke stroke-theme-target ', SITE_TEMPLATE_PATH.'/images/svg/Arrow_lg.svg');?>
														<div class="arrow-all__item-line arrow-all--dark-bgcolor bg-theme-target"></div>
													</div>
												<?$arrowHtml = ob_get_clean()?>
												<?if ($arItem['DISPLAY_PROPERTIES']['BTN_FORM_ID']['VALUE']):?>
													<span class="<?=$btnClass;?> animate-load" data-event="jqm" data-param-id="<?=TSolution::getFormID($arItem['DISPLAY_PROPERTIES']['BTN_FORM_ID']['VALUE'])?>" data-name="form">
														<?if ($bBannerSmallImg):?>
															<?=$arrowHtml;?>
														<?else:?>
															<?=$arItem['DISPLAY_PROPERTIES']['BTN_TEXT']['VALUE'];?>
														<?endif;?>
													</span>
												<?elseif ($arItem['DISPLAY_PROPERTIES']['BTN_LINK']['VALUE']):?>
													<a href="<?=str_replace('//', '/', $arItem['DISPLAY_PROPERTIES']['BTN_LINK']['VALUE'])?>" class="<?=$btnClass;?>">
														<?if ($bBannerSmallImg):?>
															<?=$arrowHtml;?>
														<?else:?>
															<?=$arItem['DISPLAY_PROPERTIES']['BTN_TEXT']['VALUE'];?>
														<?endif;?>
													</a>
												<?endif;?>
											</div>
										<?endif;?>
									</div>
								</div>

								<?if ($bActivePicture):?>
									<div class="banners-fon-list__image-wrapper shine <?=$bBannerBigImg ? 'banners-fon-list__image--fit_image' : '';?>">
										<?$pictureName = ($arItem['PREVIEW_PICTURE']['TITLE']?$arItem['PREVIEW_PICTURE']['TITLE']:$arItem['NAME']);?>
										<div class="banners-fon-list__image-inner">
											<img src="<?=$arItem['PREVIEW_PICTURE']['SRC'];?>" class="banners-fon-list__item-image <?=$imageClass?>" alt="<?=$pictureName;?>" title="<?=$pictureName;?>">
										</div>
									</div>
								<?endif;?>

							</div>
							<?if (!$bActivePicture && !$bNarrow):?>
								</div>
							<?endif;?>
						</div>
					</div>
				<?}?>
			</div>

		<?if($bNarrow || $bItemOffset):?>
			</div>
		<?endif;?>

	</div>
<?endif;?>

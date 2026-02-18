<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();?>
<?$this->setFrameMode(true);?>
<?use \Bitrix\Main\Localization\Loc;?>
<?if($arResult['ITEMS']):?>
	<?
	$templateData['ITEMS'] = true;

	$bShowTitle = $arParams['TITLE'] && $arParams['SHOW_TITLE'];
	$bShowTitleLink = $arParams['RIGHT_TITLE'] && $arParams['RIGHT_LINK'];
	$bMobileScrolledItems = (
		!isset($arParams['MOBILE_SCROLLED']) || 
		(isset($arParams['MOBILE_SCROLLED']) && $arParams['MOBILE_SCROLLED'])
	);
	$bMaxWidthWrap = (
		!isset($arParams['MAXWIDTH_WRAP']) ||
		(isset($arParams['MAXWIDTH_WRAP']) && $arParams['MAXWIDTH_WRAP'])
	);
	?>
	
	<?
	$qntyItems = count($arResult['ITEMS']);
	
	global $arTheme;

	$blockClasses = '';
	if (!$arParams['ITEMS_OFFSET']) {
		$blockClasses .= ' sale-list--items-close';
	}
	if ($arParams['ITEMS_OFFSET']) {
		$blockClasses .= ' sale-list--items-offset';
	}

	$gridClass = ['grid-list'];

	if ($bMobileScrolledItems) {
		$gridClass[] = 'mobile-scrolled mobile-scrolled--items-2';

		if ($arParams['NARROW']) {
			$gridClass[] = 'mobile-offset';

			if (!$arParams['ITEMS_OFFSET']) {
				$gridClass[] = 'mobile-offset--right';
			}
		} else if ($arParams['ITEMS_OFFSET']) {
			$gridClass[] = 'mobile-offset';
		}
	}

	if (!$arParams['ITEMS_OFFSET']) {
		$gridClass[] = 'grid-list--no-gap';
	}

	if (!$arParams['NARROW']) {
		$gridClass[] = 'grid-list--items-'.$arParams['ELEMENTS_ROW'].'-wide';
	} else {
		$gridClass[] = 'grid-list--items-'.$arParams['ELEMENTS_ROW'];
	}

	if ($arParams['ELEMENTS_ROW'] == 2) {
		$gridClass[] = 'grid-list--items-1-991';
	}

	$itemClasses = 'height-100 flexbox';
	if ($arParams['ROW_VIEW']) {
		$itemClasses .= ' flexbox--direction-row-reverse';
	}
	if ($arParams['COLUMN_REVERSE']) {
		$itemClasses .= ' flexbox--direction-column-reverse';
	}
	if ($arParams['BORDER']) {
		$itemClasses .= ' bordered';
	}
	if ($arParams['ROUNDED'] && $arParams['ITEMS_OFFSET']) {
		$itemClasses .= ' rounded-4';
	}
	if ($arParams['TEXT_POSITION'] == 'LEFT') {
		$itemClasses .= ' sale-list__item--big-padding';
	}
	if ($arParams['ITEM_HOVER_SHADOW']) {
		$itemClasses .= ' shadow-hovered shadow-no-border-hovered';
	}
	if ($arParams['DARK_HOVER']) {
		$itemClasses .= ' dark-block-hover';
	}

	$imageClasses = '';
	if ($arParams['ROUNDED_IMAGE']) {
		$imageClasses .= ' rounded';
	}
	if ($arParams['ABSOLUTE_IMAGE']) {
		$imageClasses .= ' sale-list__item-image--absolute';
	}

	$bFonImg = $arParams['IMAGE_POSITION'] === 'BG';

	$gridClass = TSolution\Utils::implodeClasses($gridClass);
	?>
	<?if (!$arParams['IS_AJAX']):?>
	
		<div class="sale-list <?=$blockClasses?> <?=$templateName?>-template">
			<?=TSolution\Functions::showTitleBlock([
				'PATH' => 'sale-list',
				'PARAMS' => $arParams
			]);?>

		<?if($bMaxWidthWrap):?>
			<?if($arParams['NARROW']):?>
				<div class="maxwidth-theme">
			<?elseif ($arParams['ITEMS_OFFSET']):?>
				<div class="maxwidth-theme maxwidth-theme--no-maxwidth">
			<?endif;?>
		<?endif;?>

	
		<div class="<?=$gridClass?>">
	<?endif;?>
			<?
			$counter = 1;
			foreach($arResult['ITEMS'] as $i => $arItem):?>
				<?
				// edit/add/delete buttons for edit mode
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

				// preview image
				$bImage = (isset($arItem['FIELDS']['PREVIEW_PICTURE']) && $arItem['PREVIEW_PICTURE']['SRC']);
				$nImageID = ($bImage ? (is_array($arItem['FIELDS']['PREVIEW_PICTURE']) ? $arItem['FIELDS']['PREVIEW_PICTURE']['ID'] : $arItem['FIELDS']['PREVIEW_PICTURE']) : "");
				$imageSrc = ($bImage ? CFile::getPath($nImageID) : SITE_TEMPLATE_PATH.'/images/svg/noimage_product.svg');

				// show active date period
				$bActiveDate = strlen($arItem['DISPLAY_PROPERTIES']['PERIOD']['VALUE']) || ($arItem['DISPLAY_ACTIVE_FROM'] && in_array('DATE_ACTIVE_FROM', $arParams['FIELD_CODE']));
				$bDiscountCounter = ($arItem['ACTIVE_TO'] && in_array('ACTIVE_TO', $arParams['FIELD_CODE']));
				?>

				<?ob_start()?>
					<?if($arItem['DISPLAY_PROPERTIES']['SALE_NUMBER']['VALUE'] || $bDiscountCounter):?>
						<div class="sale-list__item-sticker sale-list__item-sticker--<?=$arParams['DISCOUNT_POSITION']?>">
							<?if($arItem['DISPLAY_PROPERTIES']['SALE_NUMBER']['VALUE']):?>
								<div class="sale-list__item-sticker-value rounded-3"><?=$arItem['DISPLAY_PROPERTIES']['SALE_NUMBER']['VALUE'];?></div>
							<?endif;?>
							<?if ($bDiscountCounter):?>
								<?TSolution\Functions::showDiscountCounter(['ITEM' => $arItem]);?>
							<?endif;?>
						</div>
					<?endif;?>
				<?$htmlDiscount = ob_get_clean()?>

				<div class="sale-list__wrapper grid-list__item <?=(!$arParams['ITEMS_OFFSET'] && $arParams['BORDER'] ? ' grid-list-border-outer' : '');?>">
					<div class="sale-list__item <?=$itemClasses?> <?=($arItem['DISPLAY_PROPERTIES']['SALE_NUMBER']['VALUE'] || $bDiscountCounter ? 'sale-list__item--with-discount' : '');?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
						<?if($imageSrc):?>
							<div class="sale-list__item-image-wrapper <?='sale-list__item-image-wrapper--'.$arParams['IMAGE_POSITION']?>">
								<a class="sale-list__item-link" href="<?=$arItem['DETAIL_PAGE_URL']?>">
									<span class="sale-list__item-image<?=($arParams['ROUNDED_IMAGE'] ? ' rounded' : '');?><?=$imageClasses?>" style="background-image: url(<?=$imageSrc?>);"></span>
								</a>
							</div>
						<?endif;?>

						<?if($bFonImg):?>
							<a class="sale-list__item-link sale-list__item-link--absolute" href="<?=$arItem['DETAIL_PAGE_URL']?>"></a>
						<?endif;?>

						<div class="sale-list__item-text-wrapper <?='sale-list__item-text-wrapper--'.$arParams['TEXT_POSITION']?> flex-grow-1">
							<div class="sale-list__item-text-top-part">

								<?// date active period?>
								<?if($bActiveDate):?>
									<div class="sale-list__item-period<?=($bFonImg ? ' sale-list__item-period--FON' : ' color_999');?> font_13<?=($arItem['ACTIVE_TO'] ? ' red' : '');?>">
										<?=TSolution::showIconSvg("sale", SITE_TEMPLATE_PATH.'/images/svg/Sale_discount.svg', '', '', true, false);?>
										<?if(strlen($arItem['DISPLAY_PROPERTIES']['PERIOD']['VALUE'])):?>
											<span class="sale-list__item-period-date"><?=$arItem['DISPLAY_PROPERTIES']['PERIOD']['VALUE']?></span>
										<?else:?>
											<span class="sale-list__item-period-date"><?=$arItem['DISPLAY_ACTIVE_FROM']?></span>
										<?endif;?>
									</div>
								<?endif;?>

								<div class="sale-list__item-title switcher-title font_<?=$arParams['NAME_SIZE']?>">
									<a class="dark_link" href="<?=$arItem['DETAIL_PAGE_URL']?>">
										<?=$arItem['NAME'];?>
									</a>
								</div>	

								<?if(strlen($arItem['FIELDS']['PREVIEW_TEXT']) && $arParams['SHOW_PREVIEW']):?>
									<div class="sale-list__item-preview-wrapper">
										<div class="sale-list__item-preview color_666">
											<?=$arItem['FIELDS']['PREVIEW_TEXT'];?>
										</div>
									</div>
								<?endif;?>

							</div>

						</div>

						<?=$htmlDiscount?>
					</div>
				</div>
			<?
			$counter++;
			endforeach;?>

			<?if ($bMobileScrolledItems):?>
				<?if($arParams['IS_AJAX']):?>
					<div class="wrap_nav bottom_nav_wrapper">
						<script>initCountdown();</script>
				<?endif;?>
					<?$bHasNav = (strpos($arResult["NAV_STRING"], 'more_text_ajax') !== false);?>
					<div class="bottom_nav mobile_slider <?=($bHasNav ? '' : ' hidden-nav');?>" data-parent=".sale-list" data-append=".grid-list" <?=($arParams["IS_AJAX"] ? "style='display: none; '" : "");?>>
						<?if ($bHasNav):?>
							<?=$arResult["NAV_STRING"]?>
						<?endif;?>
					</div>

				<?if($arParams['IS_AJAX']):?>
					</div>
				<?endif;?>
			<?endif;?>

	<?if (!$arParams['IS_AJAX']):?>
		</div>
	<?endif;?>

		<?// bottom pagination?>
		<?if($arParams['IS_AJAX']):?>
			<div class="wrap_nav bottom_nav_wrapper">
		<?endif;?>

		<div class="bottom_nav_wrapper nav-compact">
			<div class="bottom_nav <?=($bMobileScrolledItems ? 'hide-600' : '');?>" <?=($arParams['IS_AJAX'] ? "style='display: none; '" : "");?> data-parent=".sale-list" data-append=".grid-list">
				<?if($arParams['DISPLAY_BOTTOM_PAGER']):?>
					<?=$arResult['NAV_STRING']?>
				<?endif;?>
			</div>
		</div>

		<?if($arParams['IS_AJAX']):?>
			</div>
		<?endif;?>

	<?if (!$arParams['IS_AJAX']):?>
		<?if($bMaxWidthWrap):?>
			<?if($arParams['NARROW']):?>
				</div>
			<?elseif ($arParams['ITEMS_OFFSET']):?>
				</div>
			<?endif;?>
		<?endif;?>
		
		
	</div>
	<?endif;?>
<?endif;?>
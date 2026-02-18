<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();?>
<?$this->setFrameMode(true);?>
<?use \Bitrix\Main\Localization\Loc;?>
<?if($arResult['ITEMS']):?>	
	<?
	$templateData['ITEMS'] = true;

	$qntyItems = count($arResult['ITEMS']);
	$bMobileScrolledItems = (
		!isset($arParams['MOBILE_SCROLLED']) || 
		(isset($arParams['MOBILE_SCROLLED']) && $arParams['MOBILE_SCROLLED'])
	);
	$bMaxWidthWrap = (
		!isset($arParams['MAXWIDTH_WRAP']) ||
		(isset($arParams['MAXWIDTH_WRAP']) && $arParams['MAXWIDTH_WRAP'])
	);
	
	global $arTheme;

	$blockClasses = '';
	if (!$arParams['ITEMS_OFFSET']) {
		$blockClasses .= ' blog-list--items-close';
	}
	if ($arParams['ITEMS_OFFSET']) {
		$blockClasses .= ' blog-list--items-offset';
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
	} else {
		$gridClass[] = 'grid-list--normal';
	}

	if (!$arParams['ITEMS_OFFSET']) {
		$gridClass[] = 'grid-list--no-gap';
	}
	if ($arParams['NO_GRID']) {
		$gridClass[] = 'grid-list--no-grid';
	}
	if ($arParams['WIDE_FIRST']) {
		$gridClass[] = 'grid-list--wide-first';
	}
	if ($arParams['ITEMS_TEMPLATE']) {
		$gridClass[] = 'grid-list--items-'.$arParams['ITEMS_TEMPLATE'];
	}

	if (!$arParams['NARROW']) {
		$gridClass[] = 'grid-list--items-'.$arParams['ELEMENTS_ROW'].'-wide';
	} else {
		$gridClass[] = 'grid-list--items-'.$arParams['ELEMENTS_ROW'];
	}

	$itemWrapperClasses = ' grid-list__item';
	if (!$arParams['ITEMS_OFFSET'] && $arParams['BORDER']) {
		$itemWrapperClasses .= ' grid-list-border-outer';
	}
	if ($arParams['NO_GRID']) {
		$itemWrapperClasses .= ' item-w'.floor(100/$arParams['ELEMENTS_ROW']);
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
		$itemClasses .= ' blog-list__item--big-padding';
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
		$imageClasses .= ' blog-list__item-image--absolute';
	}

	$bFonImg = $arParams['IMAGE_POSITION'] === 'BG';

	$gridClass = TSolution\Utils::implodeClasses($gridClass);
	?>
	<?if (!$arParams['IS_AJAX']):?>
	
		<div class="blog-list <?=$blockClasses?> <?=$templateName?>-template">
			<?=TSolution\Functions::showTitleBlock([
				'PATH' => 'blog-list',
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
				$imageSrc = ($bImage ? CFile::getPath($nImageID) : SITE_TEMPLATE_PATH.'/images/svg/noimage_content.svg');

				// show date
				$bActiveDate = (
					$arItem['ACTIVE_FROM'] && 
					(
						in_array('DATE_ACTIVE_FROM', $arParams['FIELD_CODE']) ||
						in_array('ACTIVE_FROM', $arParams['FIELD_CODE'])
					)
				);

				$bShowSection = ($arParams['SHOW_SECTION_NAME'] == 'Y' && ($arItem['IBLOCK_SECTION_ID'] && $arResult['SECTIONS'][$arItem['IBLOCK_SECTION_ID']]));

				$itemWrapperClassesExt = '';
				if ($arParams['WIDE_FIRST'] && $counter === 1 && !$arParams['IS_AJAX']) {
					$itemWrapperClassesExt .= ($arParams['ELEMENTS_ROW'] == 4 ? ' item-w50' : ' item-w66');
				}
				?>

				<div class="blog-list__wrapper <?=$itemWrapperClasses;?> <?=$itemWrapperClassesExt;?>">
					<div class="blog-list__item <?=$itemClasses?> <?=($arItem['DISPLAY_PROPERTIES']['SALE_NUMBER']['VALUE'] || $bDiscountCounter ? 'blog-list__item--with-discount' : '');?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
						<?if($imageSrc):?>
							<div class="blog-list__item-image-wrapper <?='blog-list__item-image-wrapper--'.$arParams['IMAGE_POSITION']?>">
								<a class="blog-list__item-link" href="<?=$arItem['DETAIL_PAGE_URL']?>">
									<span class="blog-list__item-image<?=($arParams['ROUNDED_IMAGE'] ? ' rounded' : '');?><?=$imageClasses?>" style="background-image: url(<?=$imageSrc?>);"></span>
								</a>
								
							</div>
						<?endif;?>

						<?if($bFonImg):?>
							<a class="blog-list__item-link blog-list__item-link--absolute" href="<?=$arItem['DETAIL_PAGE_URL']?>"></a>
						<?endif;?>

						<div class="blog-list__item-text-wrapper <?='blog-list__item-text-wrapper--'.$arParams['TEXT_POSITION']?> flex-grow-1 flexbox">
							<?if($bShowSection):?>
								<div class="blog-list__item-sticker blog-list__item-sticker--normal sticker">
									<div class="sticker__item font_12 sticker__item--bordered<?=($bFonImg ? ' sticker__item--fon' : '');?>"><?=$arResult['SECTIONS'][$arItem['IBLOCK_SECTION_ID']]['NAME'];?></div>
								</div>
							<?endif;?>
							<div class="blog-list__item-text-top-part flexbox flexbox--justify-beetwen flexbox--direction-column-reverse">

								<?// date active period?>
								<?if($bActiveDate):?>
									<div class="blog-list__item-period<?=($bFonImg ? ' blog-list__item-period--FON' : ' color_999 blog-list__item-period--mt-19');?> font_13">
										<span class="blog-list__item-period-date"><?=$arItem['DISPLAY_ACTIVE_FROM']?></span>
									</div>
								<?endif;?>

								<div class="blog-list__item-title switcher-title font_<?=$arParams['NAME_SIZE']?>">
									<a class="dark_link" href="<?=$arItem['DETAIL_PAGE_URL']?>">
										<?=$arItem['NAME'];?>
									</a>
								</div>	

								<?if(strlen($arItem['FIELDS']['PREVIEW_TEXT']) && $arParams['SHOW_PREVIEW']):?>
									<div class="blog-list__item-preview-wrapper">
										<div class="blog-list__item-preview color_666">
											<?=$arItem['FIELDS']['PREVIEW_TEXT'];?>
										</div>
									</div>
								<?endif;?>

							</div>

						</div>

					</div>
				</div>
			<?
			$counter++;
			endforeach;?>

			<?if ($bMobileScrolledItems):?>
				<?if($arParams['IS_AJAX']):?>
					<div class="wrap_nav bottom_nav_wrapper">
				<?endif;?>
					<?$bHasNav = (strpos($arResult["NAV_STRING"], 'more_text_ajax') !== false);?>
					<div class="bottom_nav mobile_slider <?=($bHasNav ? '' : ' hidden-nav');?>" data-parent=".blog-list" data-append=".grid-list" <?=($arParams["IS_AJAX"] ? "style='display: none; '" : "");?>>
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
			<div class="bottom_nav <?=($bMobileScrolledItems ? 'hide-600' : '');?>" <?=($arParams['IS_AJAX'] ? "style='display: none; '" : "");?> data-parent=".blog-list" data-append=".grid-list">
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
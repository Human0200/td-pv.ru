<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();?>
<?$this->setFrameMode(true);?>
<?use \Bitrix\Main\Localization\Loc;?>
<?if($arResult['ITEMS']):?>
	<?
	$templateData['ITEMS'] = true;

	$qntyItems = count($arResult['ITEMS']);
	$bShowLeftBlock = $arParams['HIDE_LEFT_TEXT_BLOCK'] !== 'Y';


	$bViewType1 = $arParams['VIEW_TYPE'] === 'TYPE_1';
	$bViewType2 = $arParams['VIEW_TYPE'] === 'TYPE_2';
	$bViewType3 = $arParams['VIEW_TYPE'] === 'TYPE_3';

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
		$blockClasses .= ' project-list--items-close';
	}
	if ($arParams['ITEMS_OFFSET']) {
		$blockClasses .= ' project-list--items-offset';
	}
	if ($arParams['VIEW_TYPE']) {
		$blockClasses .= ' projects-list__view-type--'.strtolower($arParams['VIEW_TYPE']);
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

	if (!$arParams['NARROW']) {
		$gridClass[] = 'grid-list--items-'.$arParams['ELEMENTS_ROW'].'-wide';
	} else {
		$gridClass[] = 'grid-list--items-'.$arParams['ELEMENTS_ROW'];
	}

	$itemWrapperClasses = ' grid-list__item';
	if (!$arParams['ITEMS_OFFSET'] && $arParams['BORDER']) {
		$itemWrapperClasses .= ' grid-list-border-outer';
	}

	$itemClasses = 'height-100 flexbox scrollbar-parent animate-arrow-hover';
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
		$itemClasses .= ' project-list__item--big-padding';
	}
	if ($arParams['ITEM_HOVER_SHADOW']) {
		$itemClasses .= ' shadow-hovered shadow-no-border-hovered';
	}
	if ($arParams['DARK_HOVER'] && !$bViewType2) {
		$itemClasses .= ' dark-block-hover';
	}
	if ($arParams['ELEMENTS_ROW'] == 1) {
		$itemClasses .= ' project-list__item--wide';
		if ($bShowLeftBlock) {
			$itemClasses .= ' project-list__item--with-left-block';
		}
	}

	$gridClass = TSolution\Utils::implodeClasses($gridClass);
	?>
	<?if (!$arParams['IS_AJAX']):?>

		<div class="project-list <?=$blockClasses?> <?=$templateName?>-template">
			<?=TSolution\Functions::showTitleBlock([
				'PATH' => 'project-list',
				'PARAMS' => $arParams,
				'VISIBLE' => !$bShowLeftBlock
			]);?>

		<?if($bMaxWidthWrap):?>
			<?if($arParams['NARROW']):?>
				<div class="maxwidth-theme">
			<?elseif ($arParams['ITEMS_OFFSET']):?>
				<div class="maxwidth-theme maxwidth-theme--no-maxwidth">
			<?endif;?>
		<?endif;?>

		<?//need for showed left block?>
		<div class="flexbox flexbox--direction-row flexbox--column-t991">
			<?=TSolution\Functions::showTitleInLeftBlock([
				'PATH' => 'project-list',
				'PARAMS' => $arParams,
				'VISIBLE' => $bShowLeftBlock
			]);?>
			<div class="flex-grow-1">

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

				// show date
				$bActiveDate = ($arItem['ACTIVE_FROM'] && in_array('ACTIVE_FROM', $arParams['FIELD_CODE']));

				$bShowSection = ($arParams['SHOW_SECTION_NAME'] == 'Y' && ($arItem['IBLOCK_SECTION_ID'] && $arResult['SECTIONS'][$arItem['IBLOCK_SECTION_ID']]));
				$bShowPreview = ($arItem['DISPLAY_PROPERTIES']['TASK_PROJECT']['VALUE']['TEXT'] && $arParams['SHOW_PREVIEW']);
				$bDarkText = !$bViewType1 && isset($arItem['DISPLAY_PROPERTIES']['TEXT_COLOR']) && $arItem['DISPLAY_PROPERTIES']['TEXT_COLOR']['VALUE_XML_ID'] === 'dark';

				// additional class for mixitUp jquery plugin
				$mixitup_class = '';
				if (
					$arItem['IBLOCK_SECTION_ID'] &&
					(isset($arResult['SECTIONS']) && $arResult['SECTIONS'][$arItem['IBLOCK_SECTION_ID']])
				) {
					if(isset($arItem['SECTIONS']) && $arItem['SECTIONS'])
					{
						foreach($arItem['SECTIONS'] as $id => $name)
						{
							$mixitup_class .= ' s-'.$id;
						}
					}
				}

				if ($arItem['ACTIVE_FROM']) {
					if ($arDateTime = ParseDateTime($arItem['ACTIVE_FROM'], FORMAT_DATETIME)) {
						$mixitup_class .= ' d-'.$arDateTime['YYYY'];
					}
				}

				?>
				<div class="project-list__wrapper <?=$itemWrapperClasses;?> <?=$mixitup_class;?>" data-ref="mixitup-target">
					<?
					$projectItemClass = $itemClasses;
					if ($bShowPreview) {
						$projectItemClass .= ' project-list__item--with-preview';
					}
					if (isset($arParams['VIEW_TYPE']) && !$bViewType1) {
						$projectItemClass .= ' project-list__item--colored';
						$projectItemClass .= $arItem['BACKGROUND_COLOR'] === 'base'
							? ' project-list__item--colored-base'
							: '';
					}
					?>
					<div class="project-list__item <?= $projectItemClass; ?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
						<?if($imageSrc):?>
							<div class="project-list__item-image-wrapper<?= !$bViewType2 ? ' dark-block-after' : ''; ?>">
								<a class="project-list__item-link" href="<?=$arItem['DETAIL_PAGE_URL']?>">
									<?
										$itemImageClasses = $arParams['ROUNDED_IMAGE'] ? ' rounded' : '';
									?>
									<span class="project-list__item-image<?= $itemImageClasses; ?>" style="background-image: url(<?= $imageSrc; ?>); "></span>
								</a>
							</div>
						<?endif;?>
						<div class="project-list__item-content"
							<?=isset($arParams['VIEW_TYPE']) && !$bViewType1 && $arItem['BACKGROUND_COLOR'] !== 'base' ? "style='background-color: ".$arItem['BACKGROUND_COLOR']."'" : '';?>
						>
							<a class="project-list__item-link project-list__item-link--absolute" href="<?=$arItem['DETAIL_PAGE_URL']?>"></a>

							<?if (!isset($arParams['VIEW_TYPE']) || !$bViewType2):?>
								<div class="project-list__item-additional-text">
									<?// section?>
									<?if($bShowSection):?>
										<div class="project-list__item-section project-list__item-section--FON font_13 <?= $bDarkText ? 'color_dark--opacity' : 'color_light--opacity'; ?>">
											<?=$arResult['SECTIONS'][$arItem['IBLOCK_SECTION_ID']]['NAME'];?>
										</div>
									<?endif;?>

									<div class="project-list__item-title switcher-title font_<?=$arParams['NAME_SIZE']?>">
									<a class="<?=$bDarkText ? 'color_dark' : 'color_light';?>" href="<?=$arItem['DETAIL_PAGE_URL']?>">
											<?=$arItem['NAME'];?>
										</a>
									</div>
								</div>
							<?endif;?>

							<?if ($arItem['LOGO']):?>
								<div class="project-list__item-logo">
									<img src="<?=$arItem['LOGO']['src'];?>" alt="" title="" />
								</div>
							<?endif;?>

							<?if ($arParams['ELEMENTS_ROW'] == 1):?>
								<div class="arrow-all arrow-all--wide">
									<?=TSolution::showIconSvg(' arrow-all__item-arrow arrow-all--'.($bDarkText ? "dark" : "light").'-stroke', SITE_TEMPLATE_PATH.'/images/svg/Arrow_lg.svg');?>
									<div class="arrow-all__item-line arrow-all--<?= $bDarkText ? 'dark' : 'light'; ?>-bgcolor"></div>
								</div>
							<?endif;?>
							<?if($bShowPreview):?>
								<div class="project-list__item-text-wrapper">
									<div class="project-list__item-text-top-part scrollbar">
										<a class="project-list__item-link project-list__item-link--absolute" href="<?=$arItem['DETAIL_PAGE_URL'];?>"></a>
										<!-- noindex -->
										<?// section?>
										<?if($bShowSection):?>
											<div class="project-list__item-section project-list__item-section--FON font_13 <?=$bDarkText ? 'color_dark--opacity' : 'color_light--opacity ';?>">
												<?=$arResult['SECTIONS'][$arItem['IBLOCK_SECTION_ID']]['NAME'];?>
											</div>
										<?endif;?>

										<div class="project-list__item-title switcher-title font_<?=$arParams['NAME_SIZE']?>">
										<a class="<?=$bDarkText ? 'color_dark' : 'color_light';?><?=!$bViewType1 ? ' linecamp-2' : '';?>" href="<?=$arItem['DETAIL_PAGE_URL']?>">
												<?=$arItem['NAME'];?>
											</a>
										</div>
										<!-- /noindex -->

										<?if ($arItem['TEXT_BELOW_TITLE']):?>
											<div class="project-list__item-preview-wrapper<?=!$bViewType1 ? ' linecamp-3' : '';?>">
												<div class="project-list__item-preview project-list__item-text--color-<?=$bDarkText ? 'dark-opacity' : 'light-opacity';?>">
													<?if (is_array($arItem['TEXT_BELOW_TITLE'])):?>
														<?foreach($arItem['TEXT_BELOW_TITLE'] as $key => $tag):?>
															<a href="<?= SITE_DIR; ?>search/index.php?tags=<?=htmlspecialcharsex($tag);?>"
																class="project-list__item-preview__tag">
																<?=$tag;?><?=$key+1 !== count($arItem['TEXT_BELOW_TITLE']) ? ', ' : '';?>
															</a>
														<?endforeach;?>
													<?else:?>
														<?=$arItem['TEXT_BELOW_TITLE'];?>
													<?endif;?>
												</div>
											</div>
										<?endif;?>
									</div>
								</div>
							<?endif;?>
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
					<div class="bottom_nav mobile_slider <?=($bHasNav ? '' : ' hidden-nav');?>" data-parent=".project-list" data-append=".grid-list" <?=($arParams["IS_AJAX"] ? "style='display: none; '" : "");?>>
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
			<div class="bottom_nav <?=($bMobileScrolledItems ? 'hide-600' : '');?>" <?=($arParams['IS_AJAX'] ? "style='display: none; '" : "");?> data-parent=".project-list" data-append=".grid-list">
				<?if($arParams['DISPLAY_BOTTOM_PAGER']):?>
					<?=$arResult['NAV_STRING']?>
				<?endif;?>
			</div>
		</div>

		<?if($arParams['IS_AJAX']):?>
			</div>
		<?endif;?>

	<?if (!$arParams['IS_AJAX']):?>
				</div> <?// .flex-grow-1?>
			</div> <?// .flexbox?>

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

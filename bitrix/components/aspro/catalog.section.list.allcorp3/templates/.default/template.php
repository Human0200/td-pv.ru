<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();
$this->setFrameMode(true);
use \Bitrix\Main\Localization\Loc;

global $arTheme;

$arItems = $arResult['SECTIONS'];
?>
<?if($arItems):?>
	<?
	$bShowTitle = $arParams['TITLE'] && $arParams['SHOW_TITLE'];
	$bShowTitleLink = $arParams['RIGHT_TITLE'] && $arParams['RIGHT_LINK'];

	$bCompact = $arParams['COMPACT'] === true;
	$bIcons = $arParams['IMAGES'] === 'ICONS';
	$bFonImg = $arParams['IMAGE_POSITION'] === 'BG';
	$bTopImg = $arParams['IMAGE_POSITION'] === 'TOP';
	$bSRLImg = $arParams['IMAGE_POSITION'] === 'RIGHT' || $arParams['IMAGE_POSITION'] === 'LEFT';
	$bNarrow = $arParams['NARROW'];

	$blockClasses = ($arParams['ITEMS_OFFSET'] ? 'sections-list--items-offset' : 'sections-list--items-close');
	if($bSRLImg){
		$blockClasses .= ' sections-list--img-srl';
	}

	$gridClass = ['grid-list'];
	if($arParams['MOBILE_SCROLLED']){
		$gridClass[] = 'mobile-scrolled mobile-scrolled--items-2';
	
		if ($bNarrow) {
			$gridClass[] = 'mobile-offset';

			if (!$arParams['ITEMS_OFFSET']) {
				$gridClass[] = 'mobile-offset--right';
			}
		} else if ($arParams['ITEMS_OFFSET']) {
			$gridClass[] = 'mobile-offset';
		}
	}
	if(!$arParams['ITEMS_OFFSET']){
		$gridClass[] = 'grid-list--no-gap';
	}
	if($arParams['GRID_GAP']){
		$gridClass[] = 'grid-list--gap-'.$arParams['GRID_GAP'];
	}
	if($bNarrow){
		$gridClass[] = 'grid-list--items-'.$arParams['ELEMENTS_ROW'];
	}
	else{
		$gridClass[] = 'grid-list--wide grid-list--items-'.$arParams['ELEMENTS_ROW'].'-wide';
	}

	$itemWrapperClasses = ' grid-list__item stroke-theme-parent-all colored_theme_hover_bg-block animate-arrow-hover';
	if(!$arParams['ITEMS_OFFSET'] && $arParams['BORDER']){
		$itemWrapperClasses .= ' grid-list-border-outer';
	}

	$itemClasses = 'height-100 flexbox';
	if($arParams['ROW_VIEW']){
		if($arParams['IMAGE_POSITION'] !== 'LEFT'){
			$itemClasses .= ' flexbox--direction-row-reverse';
		}
		else{
			$itemClasses .= ' flexbox--direction-row';
		}
	}
	if($arParams['COLUMN_REVERSE']){
		$itemClasses .= ' flexbox--direction-column-reverse';
	}
	if($arParams['BORDER']){
		$itemClasses .= ' bordered';
	}
	if($arParams['ROUNDED'] && $arParams['ITEMS_OFFSET']){
		$itemClasses .= ' rounded-4';
	}
	if($arParams['ITEM_HOVER_SHADOW']){
		$itemClasses .= ' shadow-hovered shadow-no-border-hovered';
	}
	if($arParams['DARK_HOVER']){
		$itemClasses .= ' dark-block-hover';
	}
	if ($arParams['ITEM_PADDING']) {
		if ($bCompact) {
			$itemClasses .= ' sections-list__item--compact';
		} else {
			$itemClasses .= ' sections-list__item--big-padding';
		}
	} else {
		$itemClasses .= ' sections-list__item--has-additional-text';
		
		if ($bTopImg) {
			$itemClasses .= ' shadow-parent-all';
		}
	}
	if($bFonImg){
		$itemClasses .= ' sections-list__item--has-bg';
	}
	else{
		$itemClasses .= ' color-theme-parent-all';
	}

	$imageWrapperClasses = 'sections-list__item-image-wrapper--'.($arParams['IMAGES'] === 'TRANSPARENT_PICTURES' ? 'PICTURES' : $arParams['IMAGES']).' sections-list__item-image-wrapper--'.$arParams['IMAGE_POSITION'];
	$imageClasses = $arParams['IMAGES'] === 'ROUND_PICTURES' ? 'rounded' : ($arParams['IMAGES'] === 'TRANSPARENT_PICTURES' ? '' : 'rounded-4');

	$gridClass = TSolution\Utils::implodeClasses($gridClass);
	?>
	<?if(!$arParams['IS_AJAX']):?>
		<div class="sections-list <?=$blockClasses?> <?=$templateName?>-template">
			<?=TSolution\Functions::showTitleBlock([
				'PATH' => 'sections-list',
				'PARAMS' => $arParams,
			]);?>

		<?if($arParams['MAXWIDTH_WRAP']):?>
			<?if($bNarrow):?>
				<div class="maxwidth-theme">
			<?elseif($arParams['ITEMS_OFFSET']):?>
				<div class="maxwidth-theme maxwidth-theme--no-maxwidth">
			<?endif;?>
		<?endif;?>

		<div class="<?=$gridClass?>">
	<?endif;?>
			<?
			$bShowImage = 
				!$arParams['ITEM_PADDING'] || 
				$bIcons || 
				(
					$arParams['IMAGES'] !== 'TRANSPARENT_PICTURES' &&
					in_array('PICTURE', $arParams['SECTION_FIELDS'])
				) ||
				(
					$arParams['IMAGES'] === 'TRANSPARENT_PICTURES' &&
					in_array('UF_TRANSPARENT_PICTURE', $arParams['SECTION_USER_FIELDS'])
				);

			$counter = 1;
			foreach($arItems as $i => $arItem):?>
				<?
				// edit/add/delete buttons for edit mode
				$arSectionButtons = CIBlock::GetPanelButtons($arItem['IBLOCK_ID'], 0, $arItem['ID'], array('SESSID' => false, 'CATALOG' => true));
				$this->AddEditAction($arItem['ID'], $arSectionButtons['edit']['edit_section']['ACTION_URL'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'SECTION_EDIT'));
				$this->AddDeleteAction($arItem['ID'], $arSectionButtons['edit']['delete_section']['ACTION_URL'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'SECTION_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

				// detail url
				$detailUrl = $arItem['SECTION_PAGE_URL'];
				if ($arParams['USE_FILTER_SECTION'] == 'Y' && $arParams['BRAND_NAME'] && $arParams['BRAND_CODE']) {
					$detailUrl .= "filter/brand-is-".$arParams['BRAND_CODE']."/apply/";
				}

				// preview text
				$previewText = $arItem['~UF_TOP_SEO'];

				// preview image
				if($bShowImage){
					if($bIcons){
						$nImageID = $arItem['~UF_SECTION_ICON'] ?: $arItem['~UF_ICON'];
					}
					else{
						if($arParams['IMAGES'] === 'TRANSPARENT_PICTURES'){
							$nImageID = $arItem['~UF_TRANSPARENT_PICTURE'];
						}
						else{
							$nImageID = is_array($arItem['PICTURE']) ? $arItem['PICTURE']['ID'] : $arItem['~PICTURE'];
						}
					}

					$imageSrc = ($nImageID ? CFile::getPath($nImageID) : SITE_TEMPLATE_PATH.'/images/svg/noimage_product.svg');
				}
				?>
				<div class="sections-list__wrapper <?=$itemWrapperClasses?>">
					<div class="sections-list__item <?=$itemClasses?><?=(!$bShowImage || !$imageSrc ? ' sections-list__item-without-image' : '')?>" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
					<?if($bShowImage && $imageSrc):?>
							<div class="sections-list__item-image-wrapper <?=$imageWrapperClasses?>">
								<a class="sections-list__item-link" href="<?=$detailUrl?>">
									<?if($bIcons && $nImageID):?>
										<?$arOptions['PATH'] = $imageSrc?>
										<?$arItem["PICTURE"]["TITLE"] = $arItem['PREVIEW_PICTURE']['TITLE'];?>
										<?$arItem["PICTURE"]["ALT"] = $arItem['PREVIEW_PICTURE']['ALT'];?>
										<?=CAllcorp3::showSectionSvg($arOptions, $bIcons, $arItem);?>
									<?else:?>
										<span class="sections-list__item-image <?=$imageClasses?>" style="background-image: url(<?=$imageSrc?>);"></span>
									<?endif;?>
								</a>
								<?if($bSRLImg && $arParams['IMAGES'] !== 'BIG_PICTURES'):?>
									<a class="arrow-all stroke-theme-target" href="<?=$detailUrl?>">
										<?=TSolution::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH.'/images/svg/Arrow_map.svg');?>
										<div class="arrow-all__item-line colored_theme_hover_bg-el"></div>
									</a>
								<?endif;?>
							</div>
						<?endif;?>					

						<?if(!$arParams['ITEM_PADDING'] && !$bCompact):?>
							<a class="sections-list__item-link sections-list__item-link--absolute" href="<?=$detailUrl?>"></a>

							<div class="sections-list__item-additional-text-wrapper flex-grow-1">
								<div class="sections-list__item-additional-text-top-part flexbox flexbox--justify-beetwen">
									<div class="sections-list__item-title switcher-title font_<?=$arParams['NAME_SIZE']?> <?=($bFonImg ? 'color_light' : 'color_333')?>">
										<span><?=$arItem['NAME']?></span>
									</div>

									<?if($arParams['COUNT_ELEMENTS']):?>
										<div class="sections-list__item-products-count font_13 <?=($bFonImg ? 'color_light--opacity' : 'color_999')?>"><?=TSolution\Functions::declOfNum(
											$arItem['ELEMENT_CNT'], 
											array(
												Loc::getMessage('GOODS_COUNT_1'), 
												Loc::getMessage('GOODS_COUNT_2'),
												Loc::getMessage('GOODS_COUNT_5')
											)
										)?></div>
									<?endif;?>
								</div>
							</div>
						<?endif;?>

						<div class="sections-list__item-text-wrapper flexbox">
							<?if(!$arParams['ITEM_PADDING']):?>
								<a class="sections-list__item-link sections-list__item-link--absolute" href="<?=$detailUrl?>"></a>
							<?endif;?>

							<div class="sections-list__item-text-top-part <?=(!$arParams['ITEM_PADDING'] ? 'srollbar-custom scroll-deferred'.($bTopImg ? ' shadow-target rounded-4' : '') : '')?> <?=($bSRLImg && !$arParams['NARROW'] && !($bShowImage && $imageSrc)) ? 'flex-1' : ''?>">
								<div class="sections-list__item-title switcher-title font_<?=$arParams['NAME_SIZE']?>">
									<a class="dark_link color-theme-target" href="<?=$detailUrl?>"><?=$arItem['NAME']?></a>

									<?if(
										$bSRLImg && 
										$arParams['IMAGE_POSITION'] === 'LEFT' && !$bCompact
									):?>
										<?if($arParams['ELEMENTS_ROW'] == 1):?>
											<a class="arrow-all arrow-all--wide stroke-theme-target" href="<?=$detailUrl?>">
												<?=TSolution::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH.'/images/svg/Arrow_lg.svg');?>
												<div class="arrow-all__item-line colored_theme_hover_bg-el"></div>
											</a>
										<?else:?>
											<a class="arrow-all stroke-theme-target" href="<?=$detailUrl?>">
												<?=TSolution::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH.'/images/svg/Arrow_map.svg');?>
												<div class="arrow-all__item-line colored_theme_hover_bg-el"></div>
											</a>
										<?endif;?>
									<?endif;?>
								</div>

								<?if($arParams['COUNT_ELEMENTS']):?>
									<div class="sections-list__item-products-count font_13 <?=($bFonImg ? 'color_light--opacity' : 'color_999')?>"><?=TSolution\Functions::declOfNum(
										$arItem['ELEMENT_CNT'], 
										array(
											Loc::getMessage('GOODS_COUNT_1'), 
											Loc::getMessage('GOODS_COUNT_2'),
											Loc::getMessage('GOODS_COUNT_5')
										)
									)?></div>
								<?endif;?>

								<?if(
									$arParams['SHOW_CHILDS'] &&
									$arItem['ITEMS']
								):?>
									<div class="sections-list__item-childs font_15">
										<ul class="list-unstyled">
											<?foreach($arItem['ITEMS'] as $i => $arChild):?>
												<li class="sections-list__item-childs-item-wraper">
													<a class="sections-list__item-childs-item <?=($bFonImg ? 'dark_link color_light--opacity' : '')?>" href="<?=$arChild['SECTION_PAGE_URL']?>">
														<span class="sections-list__item-childs-item-name"><?=$arChild['NAME']?></span>
														<?if($i < (count($arItem['ITEMS']) - 1)):?>
															<span class="sections-list__item-childs-item-separator">&mdash;</span>
														<?endif;?>
													</a>
												</li>
											<?endforeach;?>
										</ul>
									</div>
								<?endif;?>

								<?if(
									in_array('UF_TOP_SEO', $arParams['SECTION_USER_FIELDS']) &&
									$arParams['SHOW_PREVIEW'] &&
									strlen($previewText)
								):?>
									<div class="sections-list__item-preview-wrapper">
										<div class="sections-list__item-preview font_15 <?=($bFonImg ? 'color_light--opacity' : 'color_666')?>">
											<?=$previewText?>
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

			<?if($arParams['IS_AJAX']):?>
				<div class="wrap_nav bottom_nav_wrapper">
					<script>InitScrollBar();</script>
			<?endif;?>
				<?$bHasNav = (strpos($arResult["NAV_STRING"], 'more_text_ajax') !== false);?>
				<div class="bottom_nav mobile_slider <?=($bHasNav ? '' : ' hidden-nav');?>" data-parent=".sections-list" data-append=".grid-list" <?=($arParams["IS_AJAX"] ? "style='display: none; '" : "");?>>
					<?if($bHasNav):?>
						<?=$arResult["NAV_STRING"]?>
					<?endif;?>
				</div>

			<?if($arParams['IS_AJAX']):?>
				</div>
			<?endif;?>

	<?if(!$arParams['IS_AJAX']):?>
		</div>
	<?endif;?>

		<?// bottom pagination?>
		<?if($arParams['IS_AJAX']):?>
			<div class="wrap_nav bottom_nav_wrapper">
		<?endif;?>

		<div class="bottom_nav_wrapper nav-compact">
			<div class="bottom_nav hide-600" <?=($arParams['IS_AJAX'] ? "style='display: none; '" : "");?> data-parent=".sections-list" data-append=".grid-list">
				<?if($arParams['DISPLAY_BOTTOM_PAGER']):?>
					<?=$arResult['NAV_STRING']?>
				<?endif;?>
			</div>
		</div>

		<?if($arParams['IS_AJAX']):?>
			</div>
		<?endif;?>

	<?if(!$arParams['IS_AJAX']):?>
		<?if($arParams['MAXWIDTH_WRAP']):?>
			<?if($bNarrow):?>
				</div>
			<?elseif($arParams['ITEMS_OFFSET']):?>
				</div>
			<?endif;?>
		<?endif;?>

		</div> <?// .sections-list?>
	<?endif;?>
<?endif;?>
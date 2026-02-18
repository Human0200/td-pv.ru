<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();
$this->setFrameMode(true);
use Bitrix\Main\Web\Json;
use \Bitrix\Main\Localization\Loc;

global $arTheme;

$bItemsTypeAlbums = $arParams['ITEMS_TYPE'] !== 'PHOTOS';
?>
<?if($arResult['ITEMS']):?>
	<?
    $templateData['TEMPLATE_FOLDER'] = $this->__folder;
	$bShowTitle = $arParams['TITLE'] && $arParams['SHOW_TITLE'];
	$bShowTitleLink = $arParams['RIGHT_TITLE'] && $arParams['RIGHT_LINK'];
	$bSlider = $arParams['SLIDER'] === true;
    $bNarrow = $arParams['NARROW'];
    $bItemsOffset = $arParams['ITEMS_OFFSET'] === true || $arParams['ITEMS_OFFSET'] === 'Y';

	$blockClasses = ($arParams['ITEMS_OFFSET'] ? 'gallery-list--items-offset' : 'gallery-list--items-close').' gallery-list--'.$arParams['TEMPLATE_VIEW'];
	if(!$arParams['ITEMS_OFFSET']) {
		$blockClasses .= ' gallery-list--items-close';
	}

	$bMobileScrolledItems = (
		!isset($arParams['MOBILE_SCROLLED']) ||
		(isset($arParams['MOBILE_SCROLLED']) && $arParams['MOBILE_SCROLLED'])
	);
	$bMaxWidthWrap = (
		!isset($arParams['MAXWIDTH_WRAP']) ||
		(isset($arParams['MAXWIDTH_WRAP']) && $arParams['MAXWIDTH_WRAP'])
	);

	if($bSlider){
		$sliderClassList = ['swiper slider-solution mobile-offset appear-block slider-item-width-260-to-600 swipeignore mobile-offset--right'];
        $sliderClassList[] = 'slider-solution-items-by-'.$arParams['ELEMENT_IN_ROW'];

        if (!$arParams['ITEMS_OFFSET']) {
            $sliderClassList[] = 'slider-solution--no-gap';
        }

		if($arParams['SHOW_NEXT']) {
            $sliderClassList[] = 'overflow-visible';
            $sliderClassList[] = 'slider-solution--show-next';
		}

	}
	else{
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

		if(!$arParams['ITEMS_OFFSET']){
			$gridClass[] = 'grid-list--no-gap';
		}
		if($arParams['NARROW']){
			$gridClass[] = 'grid-list--items-'.$arParams['ELEMENT_IN_ROW'];
		}
		else{
			$gridClass[] = 'grid-list--wide grid-list--items-'.$arParams['ELEMENT_IN_ROW'].'-wide';
		}

		$gridClass = TSolution\Utils::implodeClasses($gridClass);
	}

	$itemWrapperClasses = ' grid-list__item';
	if(!$arParams['ITEMS_OFFSET'] && $arParams['BORDER']){
		$itemWrapperClasses .= ' grid-list-border-outer';
	}
	if($bItemsTypeAlbums){
		$itemWrapperClasses .= ' stroke-theme-parent-all colored_theme_hover_bg-block animate-arrow-hover';
	}

	$itemClasses = 'height-100 flexbox';
	if($arParams['ROW_VIEW']){
		$itemClasses .= ' flexbox--direction-row';
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
	$itemClasses .= ' gallery-list__item--has-additional-text gallery-list__item--has-bg';
	if(!$bItemsTypeAlbums){
		$itemClasses .= ' gallery-list__item--photos';
	}

	$imageWrapperClasses = 'gallery-list__item-image-wrapper--'.$arParams['IMAGE_POSITION'];
	$imageClasses = $arParams['ITEMS_OFFSET'] ? 'rounded-4' : '';

	?>
	<?if(!$arParams['IS_AJAX']):?>
		<div class="gallery-list overflow-block <?=$blockClasses?> <?=$templateName?>-template">
			<?=TSolution\Functions::showTitleBlock([
				'PATH' => 'gallery-list',
				'PARAMS' => $arParams,
				'VISIBLE' => !$bShowLeftBlock
			]);?>

		<?if($bMaxWidthWrap):?>
			<?if($bSlider):?>
				<?if($arParams['NARROW']):?>
					<div class="maxwidth-theme">
				<?endif;?>
			<?elseif($arParams['NARROW']):?>
				<div class="maxwidth-theme">
			<?elseif($arParams['ITEMS_OFFSET']):?>
				<div class="maxwidth-theme maxwidth-theme--no-maxwidth">
			<?endif;?>
		<?endif;?>

		<?if($bSlider):?>
			<?
            $countSlides = count($arResult['ITEMS']);
            $arOptions = [
                'preloadImages' => false,
                'keyboard' => true,
                'init' => false,
                'countSlides' => $countSlides,
                'rewind'=> true,
                'freeMode' => [
                    'enabled' => true,
                    'momentum' => true,
                    // 'sticky' => true,
                ],
                'watchSlidesProgress' => true, // fix slide on click on slide link in mobile template
                'slidesPerView' => 'auto',
                'spaceBetween' => ($arParams['ITEMS_OFFSET'] ? '32' : '0'),
                'breakpoints' => [
                    601 => [
                        'slidesPerView' => $arParams['ELEMENT_IN_ROW'] == 1 ? 1 : 2,
                        'freeMode' => false,
                    ],
                    992 => [
                        'slidesPerView' => $arParams['ELEMENT_IN_ROW']-1 < 2 ? 2 : $arParams['ELEMENT_IN_ROW']-1,
                        'freeMode' => false,
                    ],
                    1200 => [
                        'slidesPerView' => ($arParams['ELEMENT_IN_ROW'] > 4 ? 4 : $arParams['ELEMENT_IN_ROW']),
                        'freeMode' => false,
                    ],
                ],
                'type' => 'main_tariffs',
            ];
            ?>
            <div class="relative slider-solution-outer <?if ($bItemsOffset || (!$bItemsOffset && $bNarrow)):?>slide-nav-offset<?endif;?>">
                <div class="<?=TSolution\Utils::implodeClasses($sliderClassList);?>" data-plugin-options='<?=Json::encode($arOptions)?>'>
                    <div class="swiper-wrapper">
		<?else:?>
			<div class="<?=$gridClass?>">
		<?endif;?>
	<?endif;?>
			<?
			foreach($arResult['ITEMS'] as $i => $arItem):?>
				<?
				// edit/add/delete buttons for edit mode
				if($bItemsTypeAlbums){
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				}

				// detail url
				$detailUrl = $arItem['DETAIL_PAGE_URL'];

				// photos
				$arPhotos = (array_key_exists('PHOTOS', (array)$arItem['PROPERTIES']) && $arItem['PROPERTIES']['PHOTOS']['VALUE']) ? (array)$arItem['PROPERTIES']['PHOTOS']['VALUE'] : (array)$arItem['PROPERTY_PHOTOS_VALUE'];

				// preview image
				$nImageID = is_array($arItem['FIELDS']['PREVIEW_PICTURE']) ? $arItem['FIELDS']['PREVIEW_PICTURE']['ID'] : $arItem['FIELDS']['PREVIEW_PICTURE'];
				if(
					!$nImageID &&
					$arPhotos
				){
					$nImageID = reset($arPhotos);
				}

				$imageSrc = ($nImageID ? CFile::getPath($nImageID) : SITE_TEMPLATE_PATH.'/images/noimage.png');
				$imageDescr = is_array($arItem['FIELDS']['PREVIEW_PICTURE']) ? $arItem['FIELDS']['PREVIEW_PICTURE']['DESCRIPTION'] : '';
				?>
				<div class="gallery-list__wrapper <?=$itemWrapperClasses?> <?=($bSlider ? 'swiper-slide swiper-slide--height-auto' : '');?>">
					<div class="gallery-list__item <?=$itemClasses?>" <?=($bItemsTypeAlbums ? 'id="'.$this->GetEditAreaId($arItem['ID']).'"' : '')?>>
						<?if($imageSrc):?>
							<div class="gallery-list__item-image-wrapper <?=$imageWrapperClasses?>">
								<a class="gallery-list__item-link" href="<?=$detailUrl?>" <?=($bItemsTypeAlbums ? '' : 'title="'.htmlspecialcharsbx($imageDescr).'" data-big="'.$imageSrc.'"')?>>
									<span class="gallery-list__item-image <?=$imageClasses?>" style="background-image: url(<?=$imageSrc?>);"></span>
								</a>
							</div>
						<?endif;?>

						<?if($bItemsTypeAlbums):?>
							<a class="gallery-list__item-link gallery-list__item-link--absolute" href="<?=$detailUrl?>"></a>

							<div class="gallery-list__item-additional-text-wrapper">
								<div class="gallery-list__item-additional-text-top-part">
									<?if(
										$bItemsTypeAlbums &&
										$arPhotos
									):?>
										<div class="gallery-list__item-photos-count font_13 color_light--opacity"><?=TSolution\Functions::declOfNum(
												count($arPhotos),
												array(
													Loc::getMessage('PHOTOS_COUNT_1'),
													Loc::getMessage('PHOTOS_COUNT_2'),
													Loc::getMessage('PHOTOS_COUNT_5')
												)
											)?></div>
									<?endif;?>

									<div class="gallery-list__item-title switcher-title font_<?=$arParams['NAME_SIZE']?> color_light">
										<span class="line-clamp line-clamp--2"><?=$arItem['NAME']?></span>

										<?if($arParams['ELEMENT_IN_ROW'] > 2):?>
											<div class="arrow-all arrow-all--light-stroke">
												<?=TSolution::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH.'/images/svg/Arrow_map.svg');?>
												<div class="arrow-all__item-line arrow-all--light-bgcolor"></div>
											</div>
										<?else:?>
											<a class="arrow-all arrow-all--wide arrow-all--light-stroke" href="<?=$detailUrl?>">
												<?=TSolution::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH.'/images/svg/Arrow_lg.svg');?>
												<div class="arrow-all__item-line arrow-all--light-bgcolor"></div>
											</a>
										<?endif;?>
									</div>
								</div>
							</div>
						<?endif;?>

						<?if(!$bItemsTypeAlbums):?>
							<div class="gallery-list__item-text-wrapper flexbox ">
								<div class="gallery-list__item-text-cross-part animate-cross-hover fancy fancy-thumbs" data-fancybox="item_slider" data-src="<?=$imageSrc?>" data-big="<?=$imageSrc?>">
									<div class="cross <?=($arParams['ELEMENT_IN_ROW'] > 3 ? '' : ($arParams['ELEMENT_IN_ROW'] > 1 ? 'cross--wide34' : 'cross--wide42'))?>"></div>
								</div>

								<div class="gallery-list__item-text-top-part stroke-theme-parent-all colored_theme_hover_bg-block animate-arrow-hover">
									<a class="gallery-list__item-link gallery-list__item-link--absolute" href="<?=$detailUrl?>"></a>

									<div class="gallery-list__item-title switcher-title font_<?=$arParams['NAME_SIZE']?>">
										<a class="dark_link color-theme-target line-clamp line-clamp--2" href="<?=$detailUrl?>"><?=Loc::getMessage('ALBUM_LINK', array('#NAME#' => $arItem['NAME']))?></a>

										<?if(
											$arParams['ELEMENT_IN_ROW'] > 2 ||
											(
												$bSlider &&
												$arParams['ELEMENT_IN_ROW'] > 1
											)
										):?>
											<div class="arrow-all arrow-all--light-stroke">
												<?=TSolution::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH.'/images/svg/Arrow_map.svg');?>
												<div class="arrow-all__item-line arrow-all--light-bgcolor"></div>
											</div>
										<?else:?>
											<a class="arrow-all arrow-all--wide arrow-all--light-stroke" href="<?=$detailUrl?>">
												<?=TSolution::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH.'/images/svg/Arrow_lg.svg');?>
												<div class="arrow-all__item-line arrow-all--light-bgcolor"></div>
											</a>
										<?endif;?>
									</div>
								</div>
							</div>
						<?endif;?>
					</div>
				</div>
			<?
			endforeach;?>

            <?if($bSlider):?>
                    </div>
                </div>
                <?if ($arOptions['countSlides'] > 1):?>
                    <?TSolution\Functions::showBlockHtml([
                        'FILE' => 'ui/slider-pagination.php',
                        'PARAMS' => [
                            'CLASSES' => 'swiper-pagination--small line-block--justify-center static mt mt--20 slider-pagination--visible-600',
                        ]
                    ]);?>

                    <?TSolution\Functions::showBlockHtml([
                        'FILE' => 'ui/slider-navigation.php',
                        'PARAMS' => [
                            'CLASSES' => 'slider-nav--shadow slider-nav--center hide-600',
                        ],
                    ]);?>
                <?endif;?>
            <?endif;?>

			<?if(!$bSlider):?>
				<?if($bMobileScrolledItems):?>
					<?if($arParams['IS_AJAX']):?>
						<div class="wrap_nav bottom_nav_wrapper">
					<?endif;?>
						<?$bHasNav = (strpos($arResult["NAV_STRING"], 'more_text_ajax') !== false);?>
						<div class="bottom_nav mobile_slider <?=($bHasNav ? '' : ' hidden-nav');?>" data-parent=".gallery-list" data-append=".grid-list" <?=($arParams["IS_AJAX"] ? "style='display: none; '" : "");?>>
							<?if($bHasNav):?>
								<?=$arResult["NAV_STRING"]?>
							<?endif;?>
						</div>

					<?if($arParams['IS_AJAX']):?>
						</div>
					<?endif;?>
				<?endif;?>
			<?endif;?>

	<?if(!$arParams['IS_AJAX']):?>
		</div>
	<?endif;?>

		<?// bottom pagination?>
		<?if($arParams['IS_AJAX']):?>
			<div class="wrap_nav bottom_nav_wrapper">
		<?endif;?>

		<div class="bottom_nav_wrapper nav-compact <?=($bSlider ? 'hidden' : '')?>">
			<div class="bottom_nav <?=($bMobileScrolledItems ? 'hide-600' : '');?>" <?=($arParams['IS_AJAX'] ? "style='display: none; '" : "");?> data-parent=".gallery-list" data-append=".grid-list">
				<?if($arParams['DISPLAY_BOTTOM_PAGER']):?>
					<?=$arResult['NAV_STRING']?>
				<?endif;?>
			</div>
		</div>

		<?if($arParams['IS_AJAX']):?>
			</div>
		<?endif;?>

	<?if(!$arParams['IS_AJAX']):?>
		<?if($bMaxWidthWrap):?>
			<?if($bSlider):?>
				<?if($arParams['NARROW']):?>
					</div>
				<?endif;?>
			<?elseif($arParams['NARROW']):?>
				</div>
			<?elseif($arParams['ITEMS_OFFSET']):?>
				</div>
			<?endif;?>
		<?endif;?>
		</div>
	<?endif;?>
<?endif;?>

<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();?>
<?
$this->setFrameMode(true);
if($arResult['ITEMS']){
	foreach($arResult['ITEMS'] as $i => $arItem){
		if(!is_array($arItem['FIELDS']['PREVIEW_PICTURE'])){
			unset($arResult['ITEMS'][$i]);
		}
	}
}
?>
<?if($arResult['ITEMS']):?>
	<?
	global $arTheme;
	$slideshowSpeed = abs(intval($arTheme['PARTNERSBANNER_SLIDESSHOWSPEED']['VALUE']));
	$animationSpeed = abs(intval($arTheme['PARTNERSBANNER_ANIMATIONSPEED']['VALUE']));

	$templateData['ITEMS'] = true;

	$bTextCentered = $arParams['TEXT_CENTER'] == 'Y';
	$bSlider = isset($arParams['SLIDER']) && $arParams['SLIDER'] !== "N";

	$bShowTitle = $arParams['TITLE'] && $arParams['FRONT_PAGE'] && $arParams['SHOW_TITLE'];
	$bShowTitleLink = $arParams['RIGHT_TITLE'] && $arParams['RIGHT_LINK'];

	$bTopNav = (!$arParams['TITLE_CENTER'] && $arParams['SHOW_TITLE']) && $arParams['NARROW'] && $bSlider;
	$bHaveMore = count($arResult['ITEMS']) > $arParams['ITEMS_COUNT_SLIDER'];

	$items1200 = $arParams['NARROW'] ? 5 : 6;
	$items992 = 4;
	$items768 = 3;

	$blockClasses = '';
	if($arParams['TEXT_CENTER']) {
		$blockClasses .= ' brands-list--text-center';
	}
	if(!$arParams['ITEMS_OFFSET']) {
		$blockClasses .= ' brands-list--items-close';
	}
	if($bShowTitle) {
		$blockClasses .= ' brands-list--with-text';
	}
	if($arParams['NARROW']) {
		$blockClasses .= ' brands-list--narrow';
	} else {
		$blockClasses .= ' brands-list--wide';
	}

	$sliderClasses = ' slider-solution--buttons-bordered';
	$sliderClasses .= ' slider-solution--items-width-230-adaptive';

	$itemClasses = ' shine';
	if (!$bSlider) {
		$itemClasses = ' shadow-hovered shadow-no-border-hovered';
	}
	if($arParams['BORDER']) {
		$itemClasses .= ' bordered';
	}
	if($arParams['ITEM_PADDING']) {
		$itemClasses .= ' brands-list__item--padding-'.$arParams['ITEM_PADDING'];
	}
	if(!$arParams['ITEMS_OFFSET'] && $arParams['BORDER'] && ($arParams['ITEMS_COUNT_SLIDER'] > 1) ) {
		$itemClasses .= ' brands-list__item--no-radius';
	}
	if($arParams['ITEMS_WHITE']) {
		$itemClasses .= ' brands-list__item--bg-white';
	}
	if($arParams['ITEMS_BY_LEFT_SIDE_ADAPTIVE']) {
		$itemClasses .= ' brands-list__item--left-side-adaptive';
	}
	if($bSlider) {
		$itemClasses .= ' brands-list__item--no-offset-y';
	}
	?>
	<?if (!$arParams['IS_AJAX']):?>
	<div class="brands-list <?=$blockClasses?>">
		<?=TSolution\Functions::showTitleBlock([
			'PATH' => 'brands-list',
			'PARAMS' => $arParams,
		]);?>

		<?if ($arParams['NARROW']):?>
			<div class="maxwidth-theme">
		<?elseif($arParams['ITEMS_OFFSET'] && !$bSlider):?>
			<div class="maxwidth-theme maxwidth-theme--no-maxwidth">
		<?endif;?>

			<?if ($bSlider):?>
				<?
				$countSlides = count($arResult['ITEMS']);
				$arOptions = [
					'countSlides' => $countSlides,
					'init' => false,
					'keyboard' => true,
					'pagination' => false,
					'rewind'=> true,
					'slidesPerView' => 'auto',
					'type' => 'main_brands',
					'freeMode' => [
						'enabled' => true, 
						'momentum' => true,
						'sticky' => true,
					],
					'breakpoints' => [
						'768' => [
							'freeMode' => false,
							'slidesPerView' => $items768
						], 
						'992' => [
							'slidesPerView' => $items992
						], 
						'1200' => [
							'slidesPerView' => $items1200
						],
					],
				];

				if ($slideshowSpeed) {
					$arOptions['autoplay'] = ['delay' => $slideshowSpeed];
				}
				?>
				<?/*<div class="owl-carousel appear-block <?=$owlClasses?> brands-list__items-wrapper" data-plugin-options='{"nav": true, "rewind": true, "dots": false, "loop": false, <?=($slideshowSpeed >= 0 ? '"autoplay": true, "autoplayTimeout": '.$slideshowSpeed.',' : '')?> <?=($animationSpeed >= 0 ? '"smartSpeed": '.$animationSpeed.',' : '')?> "marginMove": true, "margin": <?=$arParams['ITEMS_OFFSET'] ? '32' : '0'?>, "responsive" : {"0": {"autoWidth": true, "lightDrag": true, "items": 1}, "768": { "autoWidth": false, "lightDrag": false, "items": <?=$items768?> }, "992": {"items": <?=$items992?>}, "1200": {"items": <?=$items1200?>} }}'>*/?>
				<div class="brands-list__slider-wrap swiper-nav-offset <?=$sliderClasses;?>">
					<div class="swiper slider-solution" data-plugin-options='<?=json_encode($arOptions);?>'>
						<div class="swiper-wrapper">
			<?else:?>
				<?
				$gridClass = ['grid-list mobile-scrolled mobile-scrolled--items-2'];

				if ($arParams['NARROW']) {
					$gridClass[] = 'mobile-offset';
		
					if (!$arParams['ITEMS_OFFSET']) {
						$gridClass[] = 'mobile-offset--right';
					}
				} else if ($arParams['ITEMS_OFFSET']) {
					$gridClass[] = 'mobile-offset';
				}
				
				if ($arParams['NARROW']) {
					$gridClass[] = 'grid-list--items-5';
				} else {
					$gridClass[] = 'grid-list--items-5-wide';
				}

				if (!$arParams['ITEMS_OFFSET']) {
					$gridClass[] = 'grid-list--no-gap';
				}

				$listClass = ['brands-list__items-wrapper'];
				if ($arParams['WRAPPER_OFFSET']) {
					$listClass[] = 'brands-list__items-wrapper--offset';
				}
				if ($arParams['ITEMS_OFFSET'] && !$arParams['NARROW']) {
					$listClass[] = 'brands-list__items-wrapper--items-offset';
				}

				$listClass = TSolution\Utils::implodeClasses($gridClass);
				$gridClass = TSolution\Utils::implodeClasses($gridClass);
				?>
				<div class="<?=$listClass;?> <?=$gridClass;?>">
			<?endif;?>
	<?endif;?>
				<?foreach($arResult['ITEMS'] as $itemKey => $arItem):?>
					<?
					// edit/add/delete buttons for edit mode
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
					// use detail link?
					$bDetailLink = $arParams['SHOW_DETAIL_LINK'] != 'N' && (!strlen($arItem['DETAIL_TEXT']) ? ($arParams['HIDE_LINK_WHEN_NO_DETAIL'] !== 'Y' && $arParams['HIDE_LINK_WHEN_NO_DETAIL'] != 1) : true);
					// preview image
					$bImage = (isset($arItem['FIELDS']['PREVIEW_PICTURE']) && $arItem['PREVIEW_PICTURE']['SRC']);
					$nImageID = ($bImage ? (is_array($arItem['FIELDS']['PREVIEW_PICTURE']) ? $arItem['FIELDS']['PREVIEW_PICTURE']['ID'] : $arItem['FIELDS']['PREVIEW_PICTURE']) : "");
					$arImage = ($bImage ? CFile::ResizeImageGet($nImageID, array('width' => 186, 'height' => 90), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true) : array());
					$imageSrc = ($bImage ? $arImage['src'] : SITE_TEMPLATE_PATH.'/images/svg/noimage_brand.svg');
					?>
					<div class="grid-list__item <?=($bSlider ? 'slider-item swiper-slide hover_blink' : '');?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
						<div class="brands-list__item <?=$itemClasses?>">
							<?if($bDetailLink):?><a  class="brands-list__item-link item-link-absolute" href="<?=$arItem['DETAIL_PAGE_URL']?>"><span class="not-eyed-images-off--hidden"><?=$arItem['NAME']?></span></a><?endif;?>
							<div class="brands-list__image-wrapper">
								<img class="brands-list__image" src="<?=$imageSrc?>" alt="<?=($bImage ? $arItem['PREVIEW_PICTURE']['ALT'] : $arItem['NAME'])?>" title="<?=($bImage ? $arItem['PREVIEW_PICTURE']['TITLE'] : $arItem['NAME'])?>" />
							</div>
						</div>
					</div>
				<?endforeach;?>

				<?if ($arParams["DISPLAY_BOTTOM_PAGER"]):?>
					<?if($arParams['IS_AJAX']):?>
						<div class="wrap_nav bottom_nav_wrapper">
					<?endif;?>
						<?$bHasNav = (strpos($arResult["NAV_STRING"], 'more_text_ajax') !== false);?>
						<div class="bottom_nav mobile_slider <?=($bHasNav ? '' : ' hidden-nav');?>" data-parent=".brands-list" data-append=".grid-list" <?=($arParams["IS_AJAX"] ? "style='display: none; '" : "");?>>
							<?if ($bHasNav):?>
								<?=$arResult["NAV_STRING"]?>
							<?endif;?>
						</div>

					<?if($arParams['IS_AJAX']):?>
						</div>
					<?endif;?>
				<?endif;?>
			<?if (!$arParams['IS_AJAX']):?>
				<?if($bSlider):?>
						</div>
					</div>
					<?if ($arOptions['countSlides'] > 1):?>
						<div class="slider-navigation hide-768">
							<?TSolution\Functions::showBlockHtml([
								'FILE' => 'ui/slider-navigation.php',
								'PARAMS' => [
									'CLASSES' => ($arParams['NARROW'] ? 'slider-nav--offset-half' : ''),
								],
							]);?>
						</div>
					<?endif;?>
				<?endif;?>
			</div>
			<?endif;?>
			
			<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
				<?// bottom pagination?>
				<?if($arParams['IS_AJAX']):?>
					<div class="wrap_nav bottom_nav_wrapper">
				<?endif;?>

				<div class="bottom_nav_wrapper nav-compact">
					<div class="bottom_nav hide-600" <?=($arParams['IS_AJAX'] ? "style='display: none; '" : "");?> data-parent=".brands-list" data-append=".grid-list">
						<?if($arParams['DISPLAY_BOTTOM_PAGER']):?>
							<?=$arResult['NAV_STRING']?>
						<?endif;?>
					</div>
				</div>

				<?if($arParams['IS_AJAX']):?>
					</div>
				<?endif;?>
			<?endif;?>
		
	<?if (!$arParams['IS_AJAX']):?>
		<?if ($arParams['NARROW']):?>
			</div>
		<?elseif($arParams['ITEMS_OFFSET'] && !$bSlider):?>
			</div>
		<?endif;?>
	</div>
	<?endif?>
<?endif;?>
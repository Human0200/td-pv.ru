<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
$this->setFrameMode(true);

use \Bitrix\Main\Localization\Loc;

$bHasNav = (strpos($arResult["NAV_STRING"], 'more_text_ajax') !== false);
$bMobileScrolled = $arParams['MOBILE_SCROLLED'] === true || $arParams['MOBILE_SCROLLED'] === 'Y';
$bSlider = ($arParams['SLIDER'] === true || $arParams['SLIDER'] === 'Y') && $arParams['VIEW_TYPE'] === 'only-logo';
$bItemsOffset = $arParams['ITEMS_OFFSET'] === 'Y';
$bNarrow = $arParams['NARROW'] === 'Y';

if($bSlider){
	$bDots1200 = $arParams['DOTS_1200'] === 'Y' ? 1 : 0;
	if($arParams['ITEM_1200']) {
		$items1200 = intval($arParams['ITEM_1200']);
	}
	else{
		$items1200 = $arParams['ELEMENT_IN_ROW'] ? $arParams['ELEMENT_IN_ROW'] : 1;
	}

	$bDots768 = $arParams['DOTS_768'] === 'Y' ? 1 : 0;
	if($arParams['ITEM_768']) {
		$items768 = intval($arParams['ITEM_768']);
	}
	else{
		$items768 = 
			$arParams['ELEMENT_IN_ROW'] > 1 ? 2 : 1;
	}

	$bDots380 = $arParams['DOTS_380'] === 'Y' ? 1 : 0;
	if($arParams['ITEM_380']) {
			$items380 = intval($arParams['ITEM_380']);
		}
		else{
			$items380 = 1;
		}

	$bDots0 = $arParams['DOTS_0'] === 'Y' ? 1 : 0;
	if($arParams['ITEM_0']) {
		$items0 = intval($arParams['ITEM_0']);
	}
	else{
		$items0 = 1;
	}

	$owlClasses = ' owl-carousel--light owl-carousel--outer-dots owl-carousel--button-wide owl-carousel--items-'.$arParams['ELEMENT_IN_ROW'];
	if ($bNarrow) {
		$owlClasses .= ' owl-carousel--button-offset-half';
	}
	else{
		$owlClasses .= ' owl-carousel--button-offset-none';
	}

	if(!array_key_exists('SLIDER_BUTTONS_BORDERED', $arParams) || $arParams['SLIDER_BUTTONS_BORDERED'] === 'Y'){
		$owlClasses .= ' owl-carousel--buttons-bordered';
	}
	
	if ($bItemsOffset && !$bNarrow) {
		$owlClasses .= ' owl-carousel--padding-left-32';
		$owlClasses .= ' owl-carousel--padding-right-32';
	}
	if($arParams['SHOW_NEXT'] === 'Y') {
		$owlClasses .= ' owl-carousel--show-next';
		if ($bNarrow) {
			$owlClasses .= ' owl-carousel--narrow';
		}
	}
	if (!$bNarrow) {
		$owlClasses .= ' owl-carousel--wide-view';
	}
	if($arParams['BORDER'] === 'Y') {
		$owlClasses .= ' owl-carousel--after-offset-1';
	}
	if (!$bItemsOffset){
		$owlClasses .= ' owl-carousel--no-gap';
	}
	if ($arParams['ITEM_HOVER_SHADOW'] !== 'N'){
		$owlClasses .= ' owl-carousel--with-shadow';
	}
}
else{
	$gridClass = ['grid-list'];
	if ($bMobileScrolled) {
		$gridClass[] = 'mobile-scrolled mobile-scrolled--items-2';

		if ($bNarrow) {
			$gridClass[] = 'mobile-offset';

			if (!$bItemsOffset) {
				$gridClass[] = 'mobile-offset--right';
			}
		} else if ($bItemsOffset) {
			$gridClass[] = 'mobile-offset';
		}
	}
	if ($arParams['VIEW_TYPE'] == 'block') {
		$gridClass[] = 'grid-list--items-4 grid-list--gap-32';
	}
	if ($arParams['VIEW_TYPE'] == 'list') {
		$gridClass[] = 'grid-list--items-1';
	}
	if ($arParams['VIEW_TYPE'] == 'only-logo') {
		$gridClass[] = 'grid-list--items-4';
	}
	if ($bItemsOffset) {
		$gridClass[] = 'grid-list--gap-32';
	} else {
		$gridClass[] = 'grid-list--no-gap';
	}

	$gridClass = TSolution\Utils::implodeClasses($gridClass);
}
?>
<?php if ($arResult['SECTIONS']) : ?>
	<div class="partner-list-inner partner-list-inner--view-<?=$arParams['VIEW_TYPE'] ?: 'list';?> <?=$bItemsOffset ? ' partner-list-inner--offset' : '';?>">
		<? foreach ($arResult['SECTIONS'] as $arSection): ?>
			<?
			$areaSectionId = '';
			if ($arParams['LINKED_MODE'] !== 'Y') {
				$panelButtons = CIBlock::GetPanelButtons($arSection['IBLOCK_ID'], 0, $arSection['ID'], ['SESSID' => false, 'CATALOG' => true]);
				//var_dump($panelButtons);
				$this->AddEditAction($arSection['ID'], $panelButtons['edit']['edit_section']['ACTION_URL'], CIBlock::GetArrayByID($arSection['IBLOCK_ID'], 'SECTION_EDIT'));
				$this->AddDeleteAction($arSection['ID'], $panelButtons['edit']['delete_section']['ACTION_URL'], CIBlock::GetArrayByID($arSection['IBLOCK_ID'], 'SECTION_DELETE'), ['CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);

				$areaSectionId = $this->GetEditAreaId($arSection['ID']);
			}

			?>
			<div id="<?= $areaSectionId ?>" class="partner-list-inner__section">
				<? if ($arSection['NAME']) : ?>
					<div class="partner-list-inner__section-content">
						<? if ($arParams['SHOW_SECTION_NAME'] != 'N') : ?>
							<? if (strlen($arSection['NAME'])) : ?>
								<div class="partner-list-inner__section-title switcher-title">
									<?= $arSection['NAME'] ?>
								</div>
							<? endif; ?>
						<? endif; ?>

						<? if ($arParams['SHOW_SECTION_PREVIEW_DESCRIPTION'] === 'Y' && strlen($arSection['DESCRIPTION']) && strpos($_SERVER['REQUEST_URI'], 'PAGEN') === false) : ?>
							<div class="partner-list-inner__section-description">
								<?= $arSection['DESCRIPTION'] ?>
							</div>
						<? endif; ?>
					</div>
				<? endif; ?>

				<?if($bSlider):?>
					<div class="owl-carousel appear-block <?=$owlClasses?>" data-plugin-options='{"nav": true, "rewind": true, "dots": true, "dotsContainer": false, "loop": false, "autoplay": false, "marginMove": true, "margin": <?=($bItemsOffset ? ($arParams['GRID_GAP'] ? $arParams['GRID_GAP'] : "32") : ($arParams['BORDER'] === 'Y' ? "-1" : "0"))?>, "responsive" : {"0": {"autoWidth": false, "lightDrag": false, "dots": <?=$bDots0?>, "items": <?=$items0?>}, "380": {"autoWidth": false, "lightDrag": false, "dots": <?=$bDots380?>, "items": <?=$items380?>}, "768": {"autoWidth": false, "lightDrag": false, "dots": <?=$bDots768?>, "items": <?=$items768?>}, "1200": {"autoWidth": false, "lightDrag": false, "dots": <?=$bDots1200?>, "items": <?=$items1200?>} }}'>
				<?else:?>
					<div class="partner-list-inner__list <?=$gridClass;?>">
				<?endif;?>
					<? if ($arParams['IS_AJAX']) : ?>
						<? $APPLICATION->RestartBuffer(); ?>
					<? endif; ?>

					<? foreach ($arSection['ITEMS'] as $i => $arItem) : ?>
						<?
						$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
						$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), ['CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);

						$previewImageId = isset($arItem['FIELDS']['PREVIEW_PICTURE']) && $arItem['FIELDS']['PREVIEW_PICTURE']
							? $arItem['FIELDS']['PREVIEW_PICTURE']['ID']
							: null;

						$previewImageSrc = '';
						if ($previewImageId) {
							$image = CFile::ResizeImageGet($previewImageId, ['width' => 150, 'height' => 90], BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
							$previewImageSrc = $image['src'];
						} else {
							$previewImageSrc = SITE_TEMPLATE_PATH . '/images/svg/noimage_brand.svg';
						}

						$bDetailLink = $arParams['SHOW_DETAIL_LINK'] != 'N' && (!strlen($arItem['DETAIL_TEXT']) ? ($arParams['HIDE_LINK_WHEN_NO_DETAIL'] !== 'Y' && $arParams['HIDE_LINK_WHEN_NO_DETAIL'] != 1) : true);

						?>
						<div class="partner-list-inner__wrapper  grid-list__item stroke-theme-parent-all colored_theme_hover_bg-block animate-arrow-hover grid-list-border-outer">
							<div id="<?= $this->GetEditAreaId($arItem['ID']) ?>"
								 class="partner-list-inner__item   height-100 shadow-hovered shadow-no-border-hovered<?=$bItemsOffset ? ' rounded-4' : '' ?>">
								<? if ($arItem['FIELDS']['PREVIEW_PICTURE'] && $previewImageSrc) : ?>
									<div class="partner-list-inner__image-wrapper">
										<? if ($bDetailLink) : ?>
											<a class="partner-list-inner__image"
											   title="<?= htmlspecialchars($arItem['FIELDS']['PREVIEW_PICTURE']['TITLE']) ?>"
											   href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
											<span class="partner-list-inner__image-bg"
												  style="background-image: url(<?= $previewImageSrc ?>);"></span>
											</a>
										<? else : ?>
											<div class="partner-list-inner__image"
												 title="<?= htmlspecialchars($arItem['FIELDS']['PREVIEW_PICTURE']['TITLE']) ?>">
											<span class="partner-list-inner__image-bg"
												  style="background-image: url(<?= $previewImageSrc ?>);"></span>
											</div>
										<? endif ?>
										<? if ($bDetailLink): ?>
											<a class="partner-list-inner__arrow partner-list-inner__arrow--mobile  arrow-all stroke-theme-target"
											   href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
												<?= CAllcorp3::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH . '/images/svg/Arrow_map.svg'); ?>
												<div class="arrow-all__item-line colored_theme_hover_bg-el"></div>
											</a>
										<? endif; ?>
									</div>
								<? endif ?>
								<div class="partner-list-inner__content-wrapper">
									<div class="partner-list-inner__top">
										<? if ($bDetailLink) : ?>
											<a class="partner-list-inner__name   dark_link color-theme-target <?= $arParams['VIEW_TYPE'] != 'only-logo' ? 'switcher-title' : '' ?>"
											   href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
												<?= $arItem['NAME'] ?>
											</a>
										<? else : ?>
											<div class="partner-list-inner__name  <?= $arParams['VIEW_TYPE'] != 'only-logo' ? 'switcher-title' : '' ?>">
												<?= $arItem['NAME'] ?>
											</div>
										<? endif ?>
										<? if ($bDetailLink): ?>
											<a class="partner-list-inner__arrow partner-list-inner__arrow--desktop  arrow-all stroke-theme-target"
											   href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
												<?= CAllcorp3::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH . '/images/svg/Arrow_map.svg'); ?>
												<div class="arrow-all__item-line colored_theme_hover_bg-el"></div>
											</a>
										<? endif; ?>
									</div>
									<? if ($arParams['VIEW_TYPE'] == 'list' || $arParams['VIEW_TYPE'] == 'block') : ?>
										<div class="partner-list-inner__bottom">
											<? // element preview text?>
											<? if (strlen($arItem['FIELDS']['PREVIEW_TEXT'])): ?>
												<div class="partner-list-inner__description">
													<? if ($arItem['PREVIEW_TEXT_TYPE'] == 'text'): ?>
														<p><?= $arItem['FIELDS']['PREVIEW_TEXT'] ?></p>
													<? else: ?>
														<?= $arItem['FIELDS']['PREVIEW_TEXT'] ?>
													<? endif; ?>
												</div>
											<? endif; ?>

											<div class="partner-list-inner__properties  line-block line-block--40">
												<? if ($arItem['CONTACT_PROPERTIES']) : ?>
													<? foreach ($arItem['CONTACT_PROPERTIES'] as $property) : ?>
														<div class="partner-list-inner__property  line-block__item">
															<div class="partner-list-inner__property-label">
																<?= $property['NAME'] ?>
															</div>
															<div class="partner-list-inner__property-value">
																<? if ($property['TYPE'] == 'LINK') : ?>
																	<a rel="nofollow" href="<?= $property['HREF'] ?>"
																	   class="dark_link" <?= $property['ATTR'] ?>>
																		<?= $property['VALUE'] ?>
																	</a>
																<? else : ?>
																	<?= $property['VALUE'] ?>
																<? endif ?>
															</div>
														</div>
													<? endforeach ?>
												<? endif ?>
											</div>
										</div>
									<? endif //if($arParams['VIEW_TYPE'] != 'only-logo') :?>
								</div>
							</div>
						</div>
					<? endforeach ?>

					<? if ($arParams['SHOW_NAVIGATION_PAGER'] === 'Y' && $arParams['IS_AJAX']) : ?>
						<div class="bottom_nav_wrapper nav-compact">
							<div class="bottom_nav hide-600" <?= ($arParams['IS_AJAX'] ? "style='display: none; '" : ""); ?>
								 data-parent=".partner-list-inner" data-append=".partner-list-inner__list">
								<? if ($arParams['DISPLAY_BOTTOM_PAGER']): ?>
									<?= $arResult['NAV_STRING'] ?>
								<? endif; ?>
							</div>
						</div>
						<? die(); ?>
					<? endif; ?>

					<? if ($bMobileScrolled && $arParams['SHOW_NAVIGATION_PAGER'] === 'Y') : ?>
						<div class="bottom_nav mobile_slider <?= ($bHasNav ? '' : ' hidden-nav'); ?>"
							 data-parent=".partner-list-inner"
							 data-append=".partner-list-inner__list" <?= ($arParams['IS_AJAX'] ? "style='display: none; '" : ""); ?>>
							<? if ($bHasNav): ?>
								<?= $arResult['NAV_STRING'] ?>
							<? endif; ?>
						</div>
					<? endif ?>
				</div>
			</div>
		<? endforeach ?>

		<? // bottom pagination?>
		<? if ($arParams['SHOW_NAVIGATION_PAGER'] === 'Y' && $arParams['DISPLAY_BOTTOM_PAGER']): ?>
			<div class="wrap_nav bottom_nav_wrapper">
				<div class="bottom_nav_wrapper nav-compact">
					<div class="bottom_nav hide-600" <?= ($arParams['IS_AJAX'] ? "style='display: none; '" : ""); ?>
						 data-parent=".partner-list-inner" data-append=".partner-list-inner__list">
						<?= $arResult['NAV_STRING'] ?>

					</div>
				</div>
			</div>
		<? endif; ?>
	</div>
<?php endif //if($arResult['SECTIONS']) ?>
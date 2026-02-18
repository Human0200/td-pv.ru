<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
$this->setFrameMode(true);

use \Bitrix\Main\Localization\Loc;

$bHasNav = (strpos($arResult["NAV_STRING"], 'more_text_ajax') !== false);
$bMobileScrolled = $arParams['MOBILE_SCROLLED'] === true || $arParams['MOBILE_SCROLLED'] === 'Y';
$bItemsOffset = $arParams['ITEMS_OFFSET'] == 'Y';

$gridClass = ['grid-list grid-list--items-1'];
if ($bMobileScrolled) {
	$gridClass[] = 'mobile-scrolled mobile-scrolled--items-2';

	if ($arParams['NARROW']) {
		$gridClass[] = 'mobile-offset';

		if (!$bItemsOffset) {
			$gridClass[] = 'mobile-offset--right';
		}
	} else if ($bItemsOffset) {
		$gridClass[] = 'mobile-offset';
	}
}
if ($bItemsOffset) {
	$gridClass[] = 'grid-list--gap-32';
} else {
	$gridClass[] = 'grid-list--no-gap vacancy-list-inner__list--border-edging';
}

$gridClass = TSolution\Utils::implodeClasses($gridClass);
?>
<?php if ($arResult['SECTIONS']) : ?>
	<div class="vacancy-list-inner">
		<? foreach ($arResult['SECTIONS'] as $arSection): ?>
			<?
			$panelButtons = CIBlock::GetPanelButtons($arSection['IBLOCK_ID'], 0, $arSection['ID'], ['SESSID' => false, 'CATALOG' => true]);
			$this->AddEditAction($arSection['ID'], $panelButtons['edit']['edit_section']['ACTION_URL'], CIBlock::GetArrayByID($arSection['IBLOCK_ID'], 'SECTION_EDIT'));
			$this->AddDeleteAction($arSection['ID'], $panelButtons['edit']['delete_section']['ACTION_URL'], CIBlock::GetArrayByID($arSection['IBLOCK_ID'], 'SECTION_DELETE'), ['CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);
			$areaSectionId = $this->GetEditAreaId($arSection['ID']);
			?>
			<div class="vacancy-list-inner__section">
				<? if ($arSection['NAME']) : ?>
					<div id="<?= $areaSectionId ?>" class="vacancy-list-inner__section-content">
						<? if ($arParams['SHOW_SECTION_NAME'] != 'N') : ?>
							<? if (strlen($arSection['NAME'])) : ?>
								<div class="vacancy-list-inner__section-title switcher-title">
									<?= $arSection['NAME'] ?>
								</div>
							<? endif; ?>
						<? endif; ?>

						<? if ($arParams['SHOW_SECTION_PREVIEW_DESCRIPTION'] == 'Y' && strlen($arSection['DESCRIPTION']) && strpos($_SERVER['REQUEST_URI'], 'PAGEN') === false) : ?>
							<div class="vacancy-list-inner__section-description">
								<?= $arSection['DESCRIPTION'] ?>
							</div>
						<? endif; ?>
					</div>
				<? endif; ?>

				<div class="vacancy-list-inner__list <?=$gridClass;?>">
					<? if ($arParams['IS_AJAX']) : ?>
						<? $APPLICATION->RestartBuffer(); ?>
					<? endif; ?>

					<? foreach ($arSection['ITEMS'] as $i => $arItem) : ?>
						<?
						$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
						$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), ['CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);
						$areaElementId = $this->GetEditAreaId($arItem['ID']);
						$bDetailLink = $arParams['SHOW_DETAIL_LINK'] != 'N' && (!strlen($arItem['DETAIL_TEXT']) ? ($arParams['HIDE_LINK_WHEN_NO_DETAIL'] !== 'Y' && $arParams['HIDE_LINK_WHEN_NO_DETAIL'] != 1) : true);
						?>
						<div class="vacancy-list-inner__wrapper  grid-list__item stroke-theme-parent-all colored_theme_hover_bg-block animate-arrow-hover grid-list-border-outer">
							<div id="<?= $areaElementId ?>" class="vacancy-list-inner__item  height-100 rounded-4 shadow-hovered shadow-no-border-hovered">
								<div class="vacancy-list-inner__top">
									<div class="vacancy-list-inner__head">
										<? if ($bDetailLink) : ?>
											<a class="vacancy-list-inner__name  dark_link color-theme-target switcher-title"
											   href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
												<?= $arItem['NAME'] ?>
											</a>
										<? else : ?>
											<div class="vacancy-list-inner__name  switcher-title">
												<?= $arItem['NAME'] ?>
											</div>
										<? endif ?>
										<? if($arItem['DISPLAY_PROPERTIES']['PAY']) : ?>
											<span class="vacancy-list-inner__pay vacancy-list-inner__pay--visible-desktop switcher-title"><?= $arItem['DISPLAY_PROPERTIES']['PAY']['DISPLAY_VALUE'] ?></span>
										<? endif ?>
									</div>
									<? if ($arItem['CONTACT_PROPERTIES']) : ?>
										<div class="vacancy-list-inner__properties">
											<? foreach ($arItem['CONTACT_PROPERTIES'] as $key => $property) : ?>
												<? if ($key > 0) : ?>
													<div class="vacancy-list-inner__delimiter">&mdash;</div>
												<? endif ?>
												<div class="vacancy-list-inner__property">
													<div class="vacancy-list-inner__property-value">
														<? if ($property['TYPE'] == 'LINK') : ?>
															<a rel="nofollow" href="<?= $property['HREF'] ?>">
																<?= $property['VALUE'] ?>
															</a>
														<? elseif (is_array($property['VALUE'])) : ?>
															<?= strip_tags(implode(', ', $property['VALUE'])) ?>
														<? else : ?>
															<?= strip_tags($property['VALUE']) ?>
														<? endif ?>
													</div>
												</div>
											<? endforeach ?>
										</div>
									<? endif ?>

									<? if($arItem['DISPLAY_PROPERTIES']['PAY']) : ?>
										<span class="vacancy-list-inner__pay vacancy-list-inner__pay--visible-mobile  switcher-title"><?= $arItem['DISPLAY_PROPERTIES']['PAY']['DISPLAY_VALUE'] ?></span>
									<? endif ?>

									<? if ($bDetailLink): ?>
										<a class="vacancy-list-inner__arrow vacancy-list-inner__arrow  arrow-all stroke-theme-target"
										   href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
											<?= CAllcorp3::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH . '/images/svg/Arrow_map.svg'); ?>
											<div class="arrow-all__item-line colored_theme_hover_bg-el"></div>
										</a>
									<? endif; ?>
								</div>
								<div class="vacancy-list-inner__bottom">
									<? if($arItem['FIELDS']['PREVIEW_TEXT']) : ?>
										<div class="vacancy-list-inner__preview-text">
											<? if ($arItem['PREVIEW_TEXT_TYPE'] == 'text') : ?>
												<p><?= $arItem['FIELDS']['PREVIEW_TEXT'] ?></p>
											<? else: ?>
												<?= $arItem['FIELDS']['PREVIEW_TEXT'] ?>
											<? endif; ?>
										</div>
									<? endif ?>
								</div>
							</div>
						</div>
					<? endforeach ?>

					<? if ($arParams['SHOW_NAVIGATION_PAGER'] == 'Y' && $arParams['IS_AJAX']) : ?>
						<div class="bottom_nav_wrapper nav-compact">
							<div class="bottom_nav hide-600" <?= ($arParams['IS_AJAX'] ? "style='display: none; '" : ""); ?>
								 data-parent=".vacancy-list-inner" data-append=".vacancy-list-inner__list">
								<? if ($arParams['DISPLAY_BOTTOM_PAGER']): ?>
									<?= $arResult['NAV_STRING'] ?>
								<? endif; ?>
							</div>
						</div>
						<? die(); ?>
					<? endif; ?>
				</div>
			</div>
		<? endforeach ?>

		<? // bottom pagination?>
		<? if ($arParams['SHOW_NAVIGATION_PAGER'] == 'Y' && $arParams['DISPLAY_BOTTOM_PAGER']): ?>
			<div class="wrap_nav bottom_nav_wrapper">
				<div class="bottom_nav_wrapper nav-compact">
					<div class="bottom_nav hide-600" <?= ($arParams['IS_AJAX'] ? "style='display: none; '" : ""); ?>
						 data-parent=".vacancy-list-inner" data-append=".vacancy-list-inner__list">
						<?= $arResult['NAV_STRING'] ?>
					</div>
				</div>
			</div>
		<? endif; ?>
	</div>
<?php endif //if($arResult['SECTIONS']) ?>
<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
$this->setFrameMode(true);

use \Bitrix\Main\Localization\Loc;

$bHasNav = (strpos($arResult["NAV_STRING"], 'more_text_ajax') !== false);
$bMobileScrolled = $arParams['MOBILE_SCROLLED'] === true || $arParams['MOBILE_SCROLLED'] === 'Y';
$bItemsOffset = $arParams['ITEMS_OFFSET'] == 'Y';

$gridClass = ['grid-list grid-list--items-1 grid-list--no-gap'];
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
	$gridClass[] = 'grid-list--no-gap staff-list-inner__list--border-edging';
}

$gridClass = TSolution\Utils::implodeClasses($gridClass);
?>
<?php if ($arResult['SECTIONS']) : ?>
	<div class="staff-list-inner">
		<? foreach ($arResult['SECTIONS'] as $arSection): ?>
			<?
			$areaSectionId = '';
			if ($arParams['LINKED_MODE'] == 'Y') {
				$panelButtons = CIBlock::GetPanelButtons($arSection['IBLOCK_ID'], 0, $arSection['ID'], ['SESSID' => false, 'CATALOG' => true]);
				$this->AddEditAction($arSection['ID'], $panelButtons['edit']['edit_section']['ACTION_URL'], CIBlock::GetArrayByID($arSection['IBLOCK_ID'], 'SECTION_EDIT'));
				$this->AddDeleteAction($arSection['ID'], $panelButtons['edit']['delete_section']['ACTION_URL'], CIBlock::GetArrayByID($arSection['IBLOCK_ID'], 'SECTION_DELETE'), ['CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);

				$areaSectionId = $this->GetEditAreaId($arSection['ID']);
			}

			?>
			<div id="<?= $areaSectionId ?>" class="staff-list-inner__section">
				<? if ($arSection['NAME']) : ?>
					<div class="staff-list-inner__section-content">
						<? if ($arParams['SHOW_SECTION_NAME'] != 'N') : ?>
							<? if (strlen($arSection['NAME'])) : ?>
								<div class="staff-list-inner__section-title switcher-title">
									<?= $arSection['NAME'] ?>
								</div>
							<? endif; ?>
						<? endif; ?>

						<? if ($arParams['SHOW_SECTION_PREVIEW_DESCRIPTION'] == 'Y' && strlen($arSection['DESCRIPTION']) && strpos($_SERVER['REQUEST_URI'], 'PAGEN') === false) : ?>
							<div class="staff-list-inner__section-description">
								<?= $arSection['DESCRIPTION'] ?>
							</div>
						<? endif; ?>
					</div>
				<? endif; ?>

				<div class="staff-list-inner__list staff-list-inner__list--items-1 <?=$gridClass;?>">
					<? if ($arParams['IS_AJAX']) : ?>
						<? $APPLICATION->RestartBuffer(); ?>
					<? endif; ?>

					<? foreach ($arSection['ITEMS'] as $i => $arItem) : ?>
						<?
						$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
						$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), ['CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);

						$previewImageSrc = isset($arItem['PREVIEW_PICTURE']) && $arItem['PREVIEW_PICTURE']['SRC']
							? $arItem['PREVIEW_PICTURE']['SRC']
							: SITE_TEMPLATE_PATH . '/images/svg/noimage_staff.svg';
						$bDetailLink = $arParams['SHOW_DETAIL_LINK'] != 'N' && (!strlen($arItem['DETAIL_TEXT']) ? ($arParams['HIDE_LINK_WHEN_NO_DETAIL'] !== 'Y' && $arParams['HIDE_LINK_WHEN_NO_DETAIL'] != 1) : true);

						?>
						<div class="staff-list-inner__wrapper grid-list__item stroke-theme-parent-all colored_theme_hover_bg-block animate-arrow-hover grid-list-border-outer">
							<div id="<?= $this->GetEditAreaId($arItem['ID']) ?>"
								 class="staff-list-inner__item   height-100 rounded-4 shadow-hovered shadow-no-border-hovered">
								<? if ($arItem['FIELDS']['PREVIEW_PICTURE'] && $previewImageSrc) : ?>
									<div class="staff-list-inner__image-wrapper">
										<? if ($bDetailLink) : ?>
											<a class="staff-list-inner__image"
											   href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
											<span class="staff-list-inner__image-bg  rounded"
												  style="background-image: url(<?= $previewImageSrc ?>);"></span>
											</a>
										<? else : ?>
											<div class="staff-list-inner__image">
											<span class="staff-list-inner__image-bg  rounded"
												  style="background-image: url(<?= $previewImageSrc ?>);"></span>
											</div>
										<? endif ?>
										<? if ($bDetailLink): ?>
											<a class="staff-list-inner__arrow staff-list-inner__arrow--mobile  arrow-all stroke-theme-target"
											   href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
												<?= CAllcorp3::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH . '/images/svg/Arrow_map.svg'); ?>
												<div class="arrow-all__item-line colored_theme_hover_bg-el"></div>
											</a>
										<? endif; ?>
									</div>
								<? endif ?>
								<div class="staff-list-inner__content-wrapper">
									<div class="staff-list-inner__top">
										<div class="staff-list-inner__label">
											<?= $arItem['PROPERTIES']['POST']['VALUE'] ?>
										</div>
										<? if ($bDetailLink) : ?>
											<a class="staff-list-inner__name   dark_link color-theme-target switcher-title"
											   href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
												<?= $arItem['NAME'] ?>
											</a>
										<? else : ?>
											<div class="staff-list-inner__name  switcher-title">
												<?= $arItem['NAME'] ?>
											</div>
										<? endif ?>
										<? if ($bDetailLink): ?>
											<a class="staff-list-inner__arrow staff-list-inner__arrow--desktop  arrow-all stroke-theme-target"
											   href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
												<?= CAllcorp3::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH . '/images/svg/Arrow_map.svg'); ?>
												<div class="arrow-all__item-line colored_theme_hover_bg-el"></div>
											</a>
										<? endif; ?>
									</div>
									<div class="staff-list-inner__bottom">
										<div class="staff-list-inner__properties  line-block line-block--40">
											<? if (isset($arItem['PROPERTIES']['SEND_MESS']) && $arItem['PROPERTIES']['SEND_MESS']['VALUE_XML_ID'] == 'Y') : ?>
												<div class="staff-list-inner__property staff-list-inner__property--feedback  line-block__item">
													<div class="staff-list-inner__feedback">
														<div class="btn btn-default btn btn-default btn-transparent-border animate-load has-ripple btn-md animate-load"
															 data-event="jqm"
															 data-name="staff"
															 data-autoload-staff="<?= CAllcorp3::formatJsName($arItem['NAME']) ?>"
															 data-autoload-staff_email_hidden="<?= isset($arItem['PROPERTIES']['EMAIL']) && $arItem['PROPERTIES']['EMAIL']['VALUE']
																 ? CAllcorp3::formatJsName($arItem['PROPERTIES']['EMAIL']['VALUE'])
																 : '' ?>"
															 data-param-id="<?= CAllcorp3::getFormID("aspro_allcorp3_callstaff"); ?>"
														>
															<?= Loc::getMessage('SLI__BNT__FEEDBACK') ?>
														</div>
													</div>
												</div>
											<? endif ?>
											<? if ($arItem['CONTACT_PROPERTIES']) : ?>
												<? foreach ($arItem['CONTACT_PROPERTIES'] as $property) : ?>
													<div class="staff-list-inner__property  line-block__item">
														<div class="staff-list-inner__property-label">
															<?= $property['NAME'] ?>
														</div>
														<div class="staff-list-inner__property-value">
															<? if ($property['TYPE'] == 'LINK') : ?>
																<a rel="nofollow" href="<?= $property['HREF'] ?>"
																   class="dark_link">
																	<?= $property['VALUE'] ?>
																</a>
															<? else : ?>
																<?= $property['VALUE'] ?>
															<? endif ?>
														</div>
													</div>
												<? endforeach ?>
											<? endif ?>
											<? if ($arItem['SOCIAL_PROPERTIES']) : ?>
												<div class="staff-list-inner__property staff-list-inner__property--socials  line-block__item">
													<div class="staff-list-inner__socials">
														<div class="social__items">
															<? foreach ($arItem['SOCIAL_PROPERTIES'] as $social): ?>
																<div class="social__item">
																	<a class="social__link fill-theme-hover banner-light-icon-fill"
																	   rel="nofollow" href="<?= $social['VALUE'] ?>">
																		<?= CAllcorp3::showIconSvg('', $social['PATH']); ?>
																	</a>
																</div>
															<? endforeach; ?>
														</div>
													</div>
												</div>
											<? endif ?>
										</div>

										<? // element preview text?>
										<? if (strlen($arItem['FIELDS']['PREVIEW_TEXT'])): ?>
											<div class="staff-list-inner__description">
												<? if ($arItem['PREVIEW_TEXT_TYPE'] == 'text'): ?>
													<p><?= $arItem['FIELDS']['PREVIEW_TEXT'] ?></p>
												<? else: ?>
													<?= $arItem['FIELDS']['PREVIEW_TEXT'] ?>
												<? endif; ?>
											</div>
										<? endif; ?>
									</div>
								</div>
							</div>
						</div>
					<? endforeach ?>

					<? if ($arParams['SHOW_NAVIGATION_PAGER'] == 'Y' && $arParams['IS_AJAX']) : ?>
						<div class="bottom_nav_wrapper nav-compact">
							<div class="bottom_nav hide-600" <?= ($arParams['IS_AJAX'] ? "style='display: none; '" : ""); ?>
								 data-parent=".staff-list-inner" data-append=".staff-list-inner__list">
								<? if ($arParams['DISPLAY_BOTTOM_PAGER']): ?>
									<?= $arResult['NAV_STRING'] ?>
								<? endif; ?>
							</div>
						</div>
						<? die(); ?>
					<? endif; ?>

					<? if ($bMobileScrolled && $arParams['SHOW_NAVIGATION_PAGER'] == 'Y') : ?>
						<div class="bottom_nav mobile_slider <?= ($bHasNav ? '' : ' hidden-nav'); ?>"
							 data-parent=".staff-list-inner"
							 data-append=".staff-list-inner__list" <?= ($arParams['IS_AJAX'] ? "style='display: none; '" : ""); ?>>
							<? if ($bHasNav): ?>
								<?= $arResult['NAV_STRING'] ?>
							<? endif; ?>
						</div>
					<? endif ?>
				</div>
			</div>
		<? endforeach ?>

		<? // bottom pagination?>
		<? if ($arParams['SHOW_NAVIGATION_PAGER'] == 'Y' && $arParams['DISPLAY_BOTTOM_PAGER']): ?>
			<div class="wrap_nav bottom_nav_wrapper">
				<div class="bottom_nav_wrapper nav-compact">
					<div class="bottom_nav hide-600" <?= ($arParams['IS_AJAX'] ? "style='display: none; '" : ""); ?>
						 data-parent=".staff-list-inner" data-append=".staff-list-inner__list">
						<?= $arResult['NAV_STRING'] ?>

					</div>
				</div>
			</div>
		<? endif; ?>
	</div>
<?php endif //if($arResult['SECTIONS']) ?>
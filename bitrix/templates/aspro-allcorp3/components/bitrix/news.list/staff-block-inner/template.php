<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
$this->setFrameMode(true);

use \Bitrix\Main\Localization\Loc;

global $APPLICATION;

$bHasNav = (strpos($arResult["NAV_STRING"], 'more_text_ajax') !== false);
$bMobileScrolled = $arParams['MOBILE_SCROLLED'] === true || $arParams['MOBILE_SCROLLED'] === 'Y';

$gridClass = ['grid-list grid-list--items-4 grid-list--gap-32'];
if ($bMobileScrolled) {
	$gridClass[] = 'mobile-scrolled mobile-scrolled--items-2 mobile-offset';
}

$gridClass = TSolution\Utils::implodeClasses($gridClass);
?>
<?php if ($arResult['SECTIONS']) : ?>
	<div class="staff-block-inner">
		<? foreach ($arResult['SECTIONS'] as $i => $arSection) : ?>
			<?
			$areaSectionId = '';
			if ($arParams['LINKED_MODE'] == 'Y') {
				$panelButtons = CIBlock::GetPanelButtons($arSection['IBLOCK_ID'], 0, $arSection['ID'], ['SESSID' => false, 'CATALOG' => true]);
				$this->AddEditAction($arSection['ID'], $panelButtons['edit']['edit_section']['ACTION_URL'], CIBlock::GetArrayByID($arSection['IBLOCK_ID'], 'SECTION_EDIT'));
				$this->AddDeleteAction($arSection['ID'], $panelButtons['edit']['delete_section']['ACTION_URL'], CIBlock::GetArrayByID($arSection['IBLOCK_ID'], 'SECTION_DELETE'), ['CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);

				$areaSectionId = $this->GetEditAreaId($arSection['ID']);
			}
			?>
			<div class="staff-block-inner__section"<?=$areaSectionId ? ' id="'.$areaSectionId.'"' : '';?>>
				<? if ($arSection['NAME']) : ?>
					<div class="staff-block-inner__section-content">
						<? if ($arParams['SHOW_SECTION_NAME'] != 'N') : ?>
							<? if (strlen($arSection['NAME'])) : ?>
								<div class="staff-block-inner__section-title switcher-title">
									<?= $arSection['NAME'] ?>
								</div>
							<? endif; ?>
						<? endif; ?>

						<? if ($arParams['SHOW_SECTION_PREVIEW_DESCRIPTION'] == 'Y' && strlen($arSection['DESCRIPTION']) && strpos($_SERVER['REQUEST_URI'], 'PAGEN') === false) : ?>
							<div class="staff-block-inner__section-description">
								<?= $arSection['DESCRIPTION'] ?>
							</div>
						<? endif; ?>
					</div>
				<? endif; ?>

				<div class="staff-block-inner__list <?=$gridClass;?>">
					<? if ($arParams['IS_AJAX']) : ?>
						<? $APPLICATION->RestartBuffer(); ?>
					<? endif; ?>

					<? foreach ($arSection['ITEMS'] as $i => $arItem) : ?>
						<?
						$bDetailLink = $arParams['SHOW_DETAIL_LINK'] != 'N' && (!strlen($arItem['DETAIL_TEXT']) ? ($arParams['HIDE_LINK_WHEN_NO_DETAIL'] !== 'Y' && $arParams['HIDE_LINK_WHEN_NO_DETAIL'] != 1) : true);
						$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
						$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), ['CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);

						$previewImageSrc = isset($arItem['PREVIEW_PICTURE']) && $arItem['PREVIEW_PICTURE']['SRC']
							? $arItem['PREVIEW_PICTURE']['SRC']
							: null;

						$previewNoimageSrc = SITE_TEMPLATE_PATH . '/images/svg/noimage_staff.svg';
						$bDetailLink = $arParams['SHOW_DETAIL_LINK'] != 'N' && (!strlen($arItem['DETAIL_TEXT']) ? ($arParams['HIDE_LINK_WHEN_NO_DETAIL'] !== 'Y' && $arParams['HIDE_LINK_WHEN_NO_DETAIL'] != 1) : true);

						?>

						<div class="staff-block-inner__wrapper grid-list__item">
							<div data-toggle="custom-scrollbar" class="staff-block-inner__item ">
								<?if ($bDetailLink) { ?>
									<a class="staff-block-inner__item-link staff-block-inner__item-link--absolute" href="<?= $arItem['DETAIL_PAGE_URL'] ?>"></a>
								<?}?>
								<div class="staff-block-inner__image-wrapper">
									<div class="staff-block-inner__image">
										<? if ($previewImageSrc) : ?>
											<span class="staff-block-inner__image-bg"
												  style="background-image:url(<?= $previewImageSrc ?>);"></span>
										<? else : ?>
											<span class="staff-block-inner__no-image"
												  style="background-image:url(<?= $previewNoimageSrc ?>);"></span>
										<? endif ?>
									</div>
								</div>
								<div class="staff-block-inner__preview-wrapper">
									<div class="staff-block-inner__label">
										<?= $arItem['PROPERTIES']['POST']['VALUE'] ?>
									</div>
									<a class="staff-block-inner__name  switcher-title"
									   href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
										<?= $arItem['NAME'] ?>
									</a>
								</div>
								<div scrollbar-wrapper class="staff-block-inner__content-wrapper">
									<div class="staff-block-inner__properties">
										<div class="staff-block-inner__property staff-block-inner__property--name">
											<div class="staff-block-inner__label">
												<?= $arItem['PROPERTIES']['POST']['VALUE'] ?>
											</div>
											<? if ($bDetailLink) : ?>
												<a class="staff-block-inner__name  switcher-title"
												   href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
													<?= $arItem['NAME'] ?>
												</a>
											<? else : ?>
												<div class="staff-block-inner__name  switcher-title">
													<?= $arItem['NAME'] ?>
												</div>
											<? endif ?>
										</div>
										<? if ($arItem['CONTACT_PROPERTIES']) : ?>
											<? foreach ($arItem['CONTACT_PROPERTIES'] as $property) : ?>
												<div class="staff-block-inner__property">
													<div class="staff-block-inner__property-label">
														<?= $property['NAME'] ?>
													</div>
													<div class="staff-block-inner__property-value">
														<? if ($property['TYPE'] == 'LINK') : ?>
															<a rel="nofollow" href="<?= $property['HREF'] ?>">
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
											<div class="staff-block-inner__property staff-block-inner__property--social">
												<div class="staff-block-inner__socials">
													<div class="social__items">
														<? foreach ($arItem['SOCIAL_PROPERTIES'] as $social): ?>
															<div class="staff-block-inner__social  social__item">
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
										<? if (isset($arItem['PROPERTIES']['SEND_MESS']) && $arItem['PROPERTIES']['SEND_MESS']['VALUE_XML_ID'] == 'Y') : ?>
											<div class="staff-block-inner__property staff-block-inner__property--feedback">
												<div class="staff-block-inner__feedback">
													<div class="btn btn-default animate-load has-ripple"
														 data-event="jqm"
														 data-name="staff"
														 data-autoload-staff="<?= CAllcorp3::formatJsName($arItem['NAME']) ?>"
														 data-autoload-staff_email_hidden="<?= isset($arItem['PROPERTIES']['EMAIL']) && $arItem['PROPERTIES']['EMAIL']['VALUE']
															 ? CAllcorp3::formatJsName($arItem['PROPERTIES']['EMAIL']['VALUE'])
															 : '' ?>"
														 data-param-id="<?= CAllcorp3::getFormID("aspro_allcorp3_callstaff"); ?>"
													>
														<?= Loc::getMessage('SCI__BNT__FEEDBACK') ?>
													</div>
												</div>
											</div>
										<? endif ?>
									</div>
								</div>
							</div>
						</div>
					<? endforeach ?>

					<? if ($arParams['SHOW_NAVIGATION_PAGER'] == 'Y' && $arParams['IS_AJAX']) : ?>
						<div class="bottom_nav_wrapper nav-compact">
							<div class="bottom_nav hide-600" <?= ($arParams['IS_AJAX'] ? "style='display: none; '" : ""); ?>
								 data-parent=".staff-block-inner" data-append=".staff-block-inner__list">
								<? if ($arParams['DISPLAY_BOTTOM_PAGER']): ?>
									<?= $arResult['NAV_STRING'] ?>
								<? endif; ?>
							</div>
						</div>
						<? die(); ?>
					<? endif; ?>

					<? if ($bMobileScrolled && $arParams['SHOW_NAVIGATION_PAGER'] == 'Y') : ?>
						<div class="bottom_nav mobile_slider <?= ($bHasNav ? '' : ' hidden-nav'); ?>"
							 data-parent=".staff-block-inner"
							 data-append=".staff-block-inner__list" <?= ($arParams['IS_AJAX'] ? "style='display: none; '" : ""); ?>>
							<? if ($bHasNav): ?>
								<?= $arResult['NAV_STRING'] ?>
							<? endif; ?>
						</div>
					<? endif ?>
				</div>
			</div>
		<? endforeach; ?>

		<? // bottom pagination?>
		<? if ($arParams['SHOW_NAVIGATION_PAGER'] == 'Y' && $arParams['DISPLAY_BOTTOM_PAGER']): ?>
			<div class="wrap_nav bottom_nav_wrapper">
				<div class="bottom_nav_wrapper nav-compact">
					<div class="bottom_nav hide-600" <?= ($arParams['IS_AJAX'] ? "style='display: none; '" : ""); ?>
						 data-parent=".staff-block-inner" data-append=".staff-block-inner__list">
						<?= $arResult['NAV_STRING'] ?>

					</div>
				</div>
			</div>
		<? endif; ?>
	</div>
<?php endif //if($arResult['ITEMS']) ?>
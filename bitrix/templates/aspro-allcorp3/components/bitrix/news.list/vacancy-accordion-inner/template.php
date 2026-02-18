<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
$this->setFrameMode(true);

use \Bitrix\Main\Localization\Loc;

$bHasNav = (strpos($arResult["NAV_STRING"], 'more_text_ajax') !== false);

$listClasses = 'grid-list--items-1';
if ($arParams['ITEMS_OFFSET'] == 'Y') {
	$listClasses .= ' grid-list--gap-32';
} else {
	$listClasses .= ' grid-list--no-gap';
}

?>
<?php if ($arResult['SECTIONS']) : ?>
	<div class="vacancy-accordion">
		<? foreach ($arResult['SECTIONS'] as $arSection): ?>
			<?
			$panelButtons = CIBlock::GetPanelButtons($arSection['IBLOCK_ID'], 0, $arSection['ID'], ['SESSID' => false, 'CATALOG' => true]);
			$this->AddEditAction($arSection['ID'], $panelButtons['edit']['edit_section']['ACTION_URL'], CIBlock::GetArrayByID($arSection['IBLOCK_ID'], 'SECTION_EDIT'));
			$this->AddDeleteAction($arSection['ID'], $panelButtons['edit']['delete_section']['ACTION_URL'], CIBlock::GetArrayByID($arSection['IBLOCK_ID'], 'SECTION_DELETE'), ['CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);
			$areaSectionId = $this->GetEditAreaId($arSection['ID']);
			?>
			<div class="vacancy-accordion__section">
				<? if ($arSection['NAME']) : ?>
					<div id="<?= $areaSectionId ?>" class="vacancy-accordion__section-content">
						<? if ($arParams['SHOW_SECTION_NAME'] != 'N') : ?>
							<? if (strlen($arSection['NAME'])) : ?>
								<div class="vacancy-accordion__section-title switcher-title">
									<?= $arSection['NAME'] ?>
								</div>
							<? endif; ?>
						<? endif; ?>

						<? if ($arParams['SHOW_SECTION_PREVIEW_DESCRIPTION'] == 'Y' && strlen($arSection['DESCRIPTION']) && strpos($_SERVER['REQUEST_URI'], 'PAGEN') === false) : ?>
							<div class="vacancy-accordion__section-description">
								<?= $arSection['DESCRIPTION'] ?>
							</div>
						<? endif; ?>
					</div>
				<? endif; ?>

				<div class="vacancy-accordion__list  accordion-type-1 grid-list <?= $listClasses ?>">
					<? if ($arParams['IS_AJAX']) : ?>
						<? $APPLICATION->RestartBuffer(); ?>
					<? endif; ?>

					<? foreach ($arSection['ITEMS'] as $i => $arItem) : ?>
						<?
						$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
						$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), ['CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);
						$areaElementId = $this->GetEditAreaId($arItem['ID']);
						$hasDetailText =  isset($arItem['FIELDS']['DETAIL_TEXT']) && $arItem['FIELDS']['DETAIL_TEXT'];
						?>
						<div class="grid-list__item item-accordion-wrapper <?= $hasDetailText ? 'shadow-hovered shadow-no-border-hovered' : '' ?>  vacancy-accordion__wrapper">
							<div id="<?= $areaElementId ?>" class="vacancy-accordion__item">
								<div class="accordion-head accordion-close stroke-theme-hover" <?= $hasDetailText ? 'data-toggle="collapse"' : '' ?>
									 data-parent="#accordion-<?= $areaElementId ?>"
									 href="#accordion-<?= $areaElementId ?>">
									<div class="vacancy-accordion__head">
										<span class="vacancy-accordion__name switcher-title"><?= $arItem['NAME'] ?></span>
										<? if($arItem['DISPLAY_PROPERTIES']['PAY']) : ?>
										<span class="vacancy-accordion__pay vacancy-accordion__pay--visible-desktop  switcher-title"><?= $arItem['DISPLAY_PROPERTIES']['PAY']['DISPLAY_VALUE'] ?></span>
										<? endif ?>
									</div>

									<? if ($arItem['CONTACT_PROPERTIES']) : ?>
										<div class="vacancy-accordion__properties">
											<? foreach ($arItem['CONTACT_PROPERTIES'] as $key => $property) : ?>
												<? if ($key > 0) : ?>
													<div class="vacancy-accordion__delimiter">&mdash;</div>
												<? endif ?>
												<div class="vacancy-accordion__property">
													<div class="vacancy-accordion__property-value">
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
										<span class="vacancy-accordion__pay vacancy-accordion__pay--visible-mobile  switcher-title"><?= $arItem['DISPLAY_PROPERTIES']['PAY']['DISPLAY_VALUE'] ?></span>
									<? endif ?>

									<? if($arItem['FIELDS']['PREVIEW_TEXT']) : ?>
									<div class="vacancy-accordion__preview-text">
										<? if ($arItem['PREVIEW_TEXT_TYPE'] == 'text') : ?>
											<p><?= $arItem['FIELDS']['PREVIEW_TEXT'] ?></p>
										<? else: ?>
											<?= $arItem['FIELDS']['PREVIEW_TEXT'] ?>
										<? endif; ?>
									</div>
									<? endif ?>

									<? if ($hasDetailText) : ?>
									<i class="svg inline  svg-inline-right-arrow" aria-hidden="true">
										<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
											 xmlns="http://www.w3.org/2000/svg">
											<path d="M8 1V15M1 8H15" stroke="#999999" stroke-width="2"
												  stroke-linecap="round" stroke-linejoin="round"></path>
										</svg>
									</i>
									<? endif ?>
								</div>
								<div id="accordion-<?= $areaElementId ?>" class="panel-collapse collapse">
									<div class="accordion-body color_666">
										<div class="accordion-preview">
											<div class="vacancy-accordion__detail-text">
												<? if ($hasDetailText) : ?>
													<? if ($arItem['DETAIL_TEXT_TYPE'] == 'text') : ?>
														<p><?= $arItem['FIELDS']['DETAIL_TEXT'] ?></p>
													<? else: ?>
														<?= $arItem['FIELDS']['DETAIL_TEXT'] ?>
													<? endif; ?>
												<? endif; ?>
											</div>
											<?if($arParams['FORM'] == 'Y') : ?>
											<div class="vacancy-accordion__btn-wrapper">
												<span>
													<span class="btn btn-default btn-lg animate-load"
														  data-event="jqm"
														  data-name="resume"
														  data-param-id="<?= $arParams['FORM_ID'] ?: CAllcorp3::getFormID('aspro_allcorp3_resume'); ?>"
														  data-autoload-POST="<?=CAllcorp3::formatJsName($arItem['NAME']);?>">
														<?=$arParams['FORM_BUTTON_TITLE'] ?: Loc::getMessage('VAI__BTN__SEND') ?>
													</span>
												</span>
											</div>
											<? endif ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					<? endforeach ?>

					<? if ($arParams['SHOW_NAVIGATION_PAGER'] == 'Y' && $arParams['IS_AJAX']) : ?>
						<div class="bottom_nav_wrapper nav-compact">
							<div class="bottom_nav hide-600" <?= ($arParams['IS_AJAX'] ? "style='display: none; '" : ""); ?>
								 data-parent=".vacancy-accordion" data-append=".vacancy-accordion__list">
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
						 data-parent=".vacancy-accordion" data-append=".vacancy-accordion__list">
						<?= $arResult['NAV_STRING'] ?>
					</div>
				</div>
			</div>
		<? endif; ?>
	</div>
<?php endif //if($arResult['SECTIONS']) ?>
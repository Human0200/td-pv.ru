<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}
$this->setFrameMode(true);

use \Bitrix\Main\Localization\Loc;

?>
<div class="vacancy-detail">
	<div class="vacancy-detail__card">
		<div class="vacancy-detail__properties-wrapper">
			<div class="vacancy-detail__properties ">
				<? foreach ($arResult['CONTACT_PROPERTIES'] as $property) : ?>
					<div class="vacancy-detail__property flex-1">
						<div class="vacancy-detail__property-label">
							<?= $property['NAME'] ?>
						</div>
						<div class="vacancy-detail__property-value">
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
				<? endforeach; ?>
			</div>
		</div>
	</div>
	<div class="vacancy-detail__content">
		<? if ($arResult['FIELDS']['PREVIEW_TEXT'] || $arResult['FIELDS']['DETAIL_TEXT']): ?>
			<div class="vacancy-detail__text-wrapper">
				<?
				$code = $arResult['FIELDS']['DETAIL_TEXT'] ? 'DETAIL' : 'PREVIEW';
				$text = $arResult['FIELDS']['DETAIL_TEXT'] ?: $arResult['FIELDS']['PREVIEW_TEXT'];
				?>
				<div class="vacancy-detail__text">
					<? if ($arResult[$code . '_TEXT_TYPE'] == 'text'): ?>
						<p><?= $text ?></p>
					<? else: ?>
						<?= $text ?>
					<? endif; ?>
				</div>
			</div>
		<? endif; ?>
	</div>

	<? if ($arParams['FORM'] == 'Y') : ?>
		<div class="vacancy-detail__btn-wrapper">
			<span>
				<span class="btn btn-default btn-lg animate-load"
					  data-event="jqm"
					  data-name="resume"
					  data-param-id="<?= $arParams['FORM_ID'] ?: CAllcorp3::getFormID('aspro_allcorp3_resume'); ?>"
					  data-autoload-POST="<?= CAllcorp3::formatJsName($arResult['NAME']); ?>">
					<?= $arParams['FORM_BUTTON_TITLE'] ?: Loc::getMessage('VACANCY__BTN__SEND') ?>
				</span>
			</span>
		</div>
	<? endif ?>
</div>

<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

$this->setFrameMode(true);

use \Bitrix\Main\Localization\Loc;

$templateData = array_filter([
	'ELEMENT_CODE' => $arResult['CODE'],
	'DOCUMENTS' => $arResult['DISPLAY_PROPERTIES']['DOCUMENTS']['VALUE'],
	'PROJECTS' => [
		'IBLOCK_ID' => $arResult['DISPLAY_PROPERTIES']['LINK_PROJECTS']['LINK_IBLOCK_ID'],
		'VALUE' => $arResult['DISPLAY_PROPERTIES']['LINK_PROJECTS']['VALUE'],
	],
	'SERVICES' => [
		'IBLOCK_ID' => $arResult['DISPLAY_PROPERTIES']['LINK_SERVICES']['LINK_IBLOCK_ID'],
		'VALUE' => $arResult['DISPLAY_PROPERTIES']['LINK_SERVICES']['VALUE'],
	],
]);
$propsPartners = (isset($arResult['IMAGE']) && $arResult['IMAGE']) || (isset($arResult['CONTACT_PROPERTIES']) && $arResult['CONTACT_PROPERTIES']);
?>
<div class="partner-detail">
	<?if ($propsPartners) { ?>
		<div class="partner-detail__card">
			<div class="partner-detail__card-image">
				<div class="partner-detail__image-wrapper">
					<div class="partner-detail__image">
					<span class="partner-detail__image-bg" title="<?= htmlspecialchars($arResult['IMAGE']['TITLE']) ?>"
						style="background-image: url(<?= $arResult['IMAGE']['PREVIEW_SRC'] ?>);"></span>
					</div>
				</div>
			</div>
			<div class="partner-detail__card-info">
				<div class="partner-detail__properties">
					<? if ($arResult['CONTACT_PROPERTIES']) : ?>
						<? foreach ($arResult['CONTACT_PROPERTIES'] as $property) : ?>
							<div class="partner-detail__property">
								<div class="partner-detail__property-label">
									<?= $property['NAME'] ?>
								</div>
								<div class="partner-detail__property-value">
									<? if ($property['TYPE'] == 'LINK') : ?>
										<a rel="nofollow" target="_blank" href="<?= $property['HREF'] ?>"
										class="dark_link">
											<?= $property['VALUE'] ?>
										</a>
									<? else : ?>
										<?= $property['VALUE'] ?>
									<? endif ?>
								</div>
							</div>
						<? endforeach; ?>
					<? endif ?>				
				</div>
			</div>
		</div>
	<?}?>	
	<div class="partner-detail__content<?=$propsPartners ? "" : " marginone" ?>">
		<? if ($arResult['FIELDS']['PREVIEW_TEXT'] || $arResult['FIELDS']['DETAIL_TEXT']): ?>
			<div class="partner-detail__text-wrapper">
				<? if($arResult['FIELDS']['PREVIEW_TEXT']) : ?>
				<div class="partner-detail__preview-text">
					<? if ($arResult['PREVIEW_TEXT_TYPE'] == 'text'): ?>
						<p><?= $arResult['FIELDS']['PREVIEW_TEXT'] ?></p>
					<? else: ?>
						<?= $arResult['FIELDS']['PREVIEW_TEXT'] ?>
					<? endif; ?>
				</div>
				<? endif ?>
				<div class="partner-detail__text">
					<? if ($arResult['DETAIL_TEXT_TYPE'] == 'text'): ?>
						<p><?= $arResult['FIELDS']['DETAIL_TEXT'] ?></p>
					<? else: ?>
						<?= $arResult['FIELDS']['DETAIL_TEXT'] ?>
					<? endif; ?>
				</div>
			</div>
		<? endif; ?>
	</div>
</div>


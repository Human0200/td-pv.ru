<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

$this->setFrameMode(true);

use \Bitrix\Main\Localization\Loc;

$templateData = array_filter([
	'DOCUMENTS' => $arResult['DISPLAY_PROPERTIES']['DOCUMENTS']['VALUE'],
	'PROJECTS' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_PROJECTS'), array('LINK_STAFF'), $arParams),
	'SERVICES' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_SERVICES'), array('LINK_STAFF'), $arParams),
	'GOODS' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_GOODS', 'LINK_GOODS_FILTER'), array('LINK_STAFF'), $arParams),
	'REVIEWS' => [
		'IBLOCK_ID' => $arResult['DISPLAY_PROPERTIES']['LINK_REVIEWS']['LINK_IBLOCK_ID'],
		'VALUE' => $arResult['DISPLAY_PROPERTIES']['LINK_REVIEWS']['VALUE'],
	],
	'CONTACTS' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_CONTACT'), array('LINK_STAFF'), $arParams),
]);

?>

<div class="staff-detail">
	<div class="staff-detail__card <?= $arResult['IMAGE'] ? 'staff-detail__card--with-picture' : '' ?>">
		<div class="staff-detail__card-info">
			<div class="staff-detail__card-row staff-detail__card-row--border-bottom staff-detail__top-wrapper">
				<div class="staff-detail__line staff-detail__line--between">
					<div class="staff-detail__name-wrapper">
						<? if ($arResult['PROPERTIES']['POST']['VALUE']) : ?>
							<div class="staff-detail__label">
								<?= Loc::getMessage('STAFF_DETAIL__LABEL__POST') ?>
							</div>
							<div class="staff-detail__post">
								<?= $arResult['PROPERTIES']['POST']['VALUE'] ?>
							</div>
						<? endif ?>
					</div>
					<div>
						<? if (isset($arResult['PROPERTIES']['SEND_MESS']) && $arResult['PROPERTIES']['SEND_MESS']['VALUE_XML_ID'] == 'Y') : ?>
							<div class="staff-detail__feedback">
								<div class="btn btn-default btn-transparent-border animate-load has-ripple animate-load"
									 data-event="jqm"
									 data-name="staff"
									 data-autoload-staff="<?= TSolution::formatJsName($arResult['NAME']) ?>"
									 data-autoload-staff_email_hidden="<?= isset($arResult['PROPERTIES']['EMAIL']) && $arResult['PROPERTIES']['EMAIL']['VALUE']
										 ? TSolution::formatJsName($arResult['PROPERTIES']['EMAIL']['VALUE'])
										 : '' ?>"
									 data-param-id="<?= TSolution::getFormID("callstaff"); ?>"
								>
									<?= Loc::getMessage('STAFF_DETAIL__BTN__FEEDBACK') ?>
								</div>
							</div>
						<? endif ?>
					</div>
				</div>

			</div>
			<div class="staff-detail__card-row staff-detail__bottom-wrapper">
				<div class="staff-detail__properties-wrapper">
					<div class="staff-detail__properties  line-block line-block--40">
						<? if ($arResult['CONTACT_PROPERTIES']) : ?>
							<? foreach ($arResult['CONTACT_PROPERTIES'] as $property) : ?>
								<div class="staff-detail__property  line-block__item">
									<div class="staff-detail__property-label">
										<?= $property['NAME'] ?>
									</div>
									<div class="staff-detail__property-value">
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
							<? endforeach; ?>
						<? endif ?>
						<? if ($arResult['SOCIAL_PROPERTIES']) : ?>
							<div class="staff-detail__property staff-list-inner__property--socials  line-block__item">
								<div class="staff-detail__property-value">
									<div class="social__items">
										<? foreach ($arResult['SOCIAL_PROPERTIES'] as $social): ?>
											<div class="social__item">
												<a class="social__link fill-theme-hover banner-light-icon-fill"
												   rel="nofollow" href="<?= $social['VALUE'] ?>">
													<?= TSolution::showIconSvg('', $social['PATH']); ?>
												</a>
											</div>
										<? endforeach; ?>
									</div>
								</div>
							</div>
						<? endif ?>
					</div>
				</div>
				<? if ($arResult['FIELDS']['PREVIEW_TEXT'] || $arResult['FIELDS']['DETAIL_TEXT']): ?>
					<div class="staff-detail__text-wrapper">
						<?
						$code = $arResult['FIELDS']['DETAIL_TEXT'] ? 'DETAIL' : 'PREVIEW';
						$text = $arResult['FIELDS']['DETAIL_TEXT'] ?: $arResult['FIELDS']['PREVIEW_TEXT'];
						?>
						<div class="staff-detail__text">
							<? if ($arResult[$code . '_TEXT_TYPE'] == 'text'): ?>
								<p><?= $text ?></p>
							<? else: ?>
								<?= $text ?>
							<? endif; ?>
						</div>
					</div>
				<? endif; ?>
			</div>
		</div>
		<? if($arResult['IMAGE']) : ?>
		<div class="staff-detail__card-image">
			<div class="staff-detail__image-wrapper">
				<div class="staff-detail__image">
				<span class="staff-detail__image-bg" title="<?= htmlspecialchars($arResult['IMAGE']['TITLE']) ?>"
					  style="background-image: url(<?= $arResult['IMAGE']['PREVIEW_SRC'] ?>);"></span>
				</div>
			</div>
		</div>
		<? endif ?>
	</div>
</div>


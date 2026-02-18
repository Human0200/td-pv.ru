<?php

use \Bitrix\Main\Localization\Loc,
	\Bitrix\Main\Application;

$currentDir = SITE_DIR . 'include/vacancy_page/';
$currentDocumentRoot = str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'] . $currentDir);

$isSendForm = $arParams['FORM'] === 'Y';

$contactParams = [
	[
		'LABEL' => Loc::getMessage('VACANCY__CONTACT_NAME'),
		'ABSOLUTE_PATH' => $currentDocumentRoot . 'contact_person.php',
		'RELATIVE_PATH' => $currentDir . 'contact_person.php',
	],
	[
		'LABEL' => Loc::getMessage('VACANCY__CONTACT_EMAIL'),
		'ABSOLUTE_PATH' => $currentDocumentRoot . 'contact_email.php',
		'RELATIVE_PATH' => $currentDir . 'contact_email.php',
	],
	[
		'LABEL' => Loc::getMessage('VACANCY__CONTACT_PHONE'),
		'ABSOLUTE_PATH' => $currentDocumentRoot . 'contact_phone.php',
		'RELATIVE_PATH' => $currentDir . 'contact_phone.php',
	],
];

$hasContactDetail = false;
if (file_exists($currentDocumentRoot . 'contact_detail.php')) {
	$hasContactDetail = trim(file_get_contents($currentDocumentRoot . 'contact_detail.php')) != '';
}

?>

<div class="vacancy-info grey-bg">
	<div class="vacancy-info__top">
		<div class="vacancy-info__line">
			<?php if ($isSendForm) : ?>
				<div class="vacancy-info__btn-wrapper">
					<div class="btn btn-default btn btn-default animate-load has-ripple animate-load"
						 data-event="jqm"
						 data-name="resume"
						 data-param-id="<?= $arParams['FORM_ID'] ? $arParams['FORM_ID'] : CAllcorp3::getFormID("aspro_allcorp3_resume")?>"
					>
						<?= $arParams['FORM_BUTTON_TITLE'] ?: Loc::getMessage('VACANCY__BTN__SEND') ?>
					</div>
				</div>
			<?php endif ?>
			<div class="vacancy-info__properties">
				<? foreach ($contactParams as $property) : ?>
					<?
					$hasFileContent = false;
					if (file_exists($property['ABSOLUTE_PATH'])) {
						$hasFileContent = trim(file_get_contents($property['ABSOLUTE_PATH'])) != '';
					}
					?>
					<div class="vacancy-info__property <?= !$hasFileContent ? 'vacancy-info__property--hidden' : '' ?>">
						<div class="vacancy-info__property-label">
							<?= $property['LABEL'] ?>
						</div>
						<div class="vacancy-info__property-value">
							<? $APPLICATION->IncludeFile($property['RELATIVE_PATH'], [], [
									'MODE' => 'text',
									'NAME' => $property['LABEL'],
									'TEMPLATE' => 'include_area.php',
								]
							); ?>
						</div>
					</div>
				<? endforeach; ?>
			</div>
		</div>
	</div>
	<div class="vacancy-info__bottom <?= !$hasContactDetail ? 'vacancy-info__bottom--hidden' : '' ?>">
		<div class="vacancy-info__text">
			<? $APPLICATION->IncludeFile($currentDir . 'contact_detail.php', [], [
					'MODE' => 'text',
					'NAME' => Loc::getMessage('VACANCY__CONTACT_DESCRIPTION'),
					'TEMPLATE' => 'include_area.php',
				]
			); ?>
		</div>
	</div>
</div>

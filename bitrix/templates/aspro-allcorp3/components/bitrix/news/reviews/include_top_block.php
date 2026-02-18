<?php

use \Bitrix\Main\Localization\Loc,
	\Bitrix\Main\Application;

	$file = SITE_DIR . 'include/reviews.php';
	$fileDocumentRoot = str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'] . $file);

	$hasReviewFile = false;

	if(file_exists($fileDocumentRoot)) {
		$hasReviewFile = trim(file_get_contents($fileDocumentRoot)) != '';
	}

?>

<div class="reviews-info">
	<div class="reviews-info__top">
		<div class="reviews-info__line">
			<? if($hasReviewFile) : ?>
			<div class="reviews-info__col">
				<div class="reviews-info__icon">
					<?= CAllcorp3::showIconSvg('review stroke-theme', SITE_TEMPLATE_PATH . '/images/svg/review_bubble_large.svg'); ?>
				</div>

				<div class="reviews-info__text">
					<? $APPLICATION->IncludeFile(SITE_DIR . 'include/reviews.php', [], [
							'MODE' => 'text',
							'NAME' => Loc::getMessage('REVIEWS__DESCRIPTION'),
							'TEMPLATE' => 'include_area.php',
						]
					); ?>
				</div>
			</div>
			<? endif; ?>
			<div class="reviews-info__col">
				<div class="reviews-info__btn-wrapper <?= !$hasReviewFile ? 'reviews-info__btn-wrapper--singleton' : '' ?>">
					<div>
						<div class="btn btn-default btn btn-default animate-load has-ripple animate-load"
							 data-event="jqm"
							 data-name="feedback"
							 data-param-id="<?= CAllcorp3::getFormID("aspro_allcorp3_feedback"); ?>"
						>
							<?= $arParams['S_FEEDBACK'] ?: Loc::getMessage('REVIEWS__BTN__SEND') ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

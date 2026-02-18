<?php

use \Bitrix\Main\Localization\Loc;

?>
<? if ($templateData['DOCUMENTS']) : ?>
	<div class="detail-block ordered-block">
		<div class="ordered-block__title switcher-title font_22"><?= $arParams['T_DOCS'] ?: Loc::getMessage('EPILOG_BLOCK__DOCS') ?></div>
		<div class="doc-list-inner__list  grid-list  grid-list--items-1 grid-list--no-gap ">
			<? foreach ($templateData['DOCUMENTS'] as $arItem): ?>
				<?
				$arDocFile = CAllcorp3::GetFileInfo($arItem);
				$docFileDescr = $arDocFile['DESCRIPTION'];
				$docFileSize = $arDocFile['FILE_SIZE_FORMAT'];
				$docFileType = $arDocFile['TYPE'];
				$bDocImage = false;
				if ($docFileType == 'jpg' || $docFileType == 'jpeg' || $docFileType == 'bmp' || $docFileType == 'gif' || $docFileType == 'png') {
					$bDocImage = true;
				}
				?>
				<div class="doc-list-inner__wrapper grid-list__item colored_theme_hover_bg-block grid-list-border-outer fill-theme-parent-all">
					<div class="doc-list-inner__item height-100 rounded-4 shadow-hovered shadow-no-border-hovered">
						<? if ($arDocFile): ?>
							<div class="doc-list-inner__icon-wrapper">
								<a class="file-type doc-list-inner__icon">
									<i class="file-type__icon file-type__icon--<?= $docFileType ?>"></i>
								</a>
							</div>
						<? endif; ?>
						<div class="doc-list-inner__content-wrapper">
							<div class="doc-list-inner__top">
								<? if ($arDocFile): ?>
									<? if ($bDocImage): ?>
										<a href="<?= $arDocFile['SRC'] ?>"
										   class="doc-list-inner__name fancy dark_link color-theme-target switcher-title"
										   data-caption="<?= htmlspecialchars($docFileDescr) ?>"><?= $docFileDescr ?></a>
									<? else: ?>
										<a href="<?= $arDocFile['SRC'] ?>" target="_blank"
										   class="doc-list-inner__name dark_link color-theme-target switcher-title"
										   title="<?= htmlspecialchars($docFileDescr) ?>">
											<?= $docFileDescr ?>
										</a>
									<? endif; ?>
									<div class="doc-list-inner__label"><?= $docFileSize ?></div>
								<? else: ?>
									<div class="doc-list-inner__name switcher-title"><?= $docFileDescr ?></div>
								<? endif; ?>
								<? if ($arDocFile): ?>
									<? if ($bDocImage): ?>
										<a class="doc-list-inner__icon-preview-image doc-list-inner__link-file fancy fill-theme-parent"
										   data-caption="<?= htmlspecialchars($docFileDescr) ?>"
										   href="<?= $arDocFile['SRC'] ?>">
											<?= CAllcorp3::showIconSvg('image-preview fill-theme-target', SITE_TEMPLATE_PATH . '/images/svg/preview_image.svg'); ?>
										</a>
									<? else: ?>
										<a class="doc-list-inner__icon-preview-image doc-list-inner__link-file fill-theme-parent"
										   target="_blank" href="<?= $arDocFile['SRC'] ?>">
											<?= CAllcorp3::showIconSvg('image-preview fill-theme-target', SITE_TEMPLATE_PATH . '/images/svg/file_download.svg'); ?>
										</a>
									<? endif; ?>
								<? endif; ?>
							</div>
						</div>
					</div>
				</div>
			<? endforeach; ?>
		</div>
	</div>
<? endif ?>

<a href="#" class="jqmClose top-close stroke-theme-hover"><?=TSolution::showIconSvg('', SITE_TEMPLATE_PATH.'/images/svg/Close.svg')?></a>
<?if($arResult):?>
	<?
	// preview image
	$bImage = (isset($arResult['FIELDS']['PREVIEW_PICTURE']) && $arResult['PREVIEW_PICTURE']['SRC']) || (isset($arResult['FIELDS']['DETAIL_PICTURE']) && $arResult['DETAIL_PICTURE']['SRC']);
	$nImageID = ($bImage ? ($arResult['PREVIEW_PICTURE']['ID'] ?: $arResult['DETAIL_PICTURE']['ID']) : '');
	$imageSrc = $bImage ? ($arResult['PREVIEW_PICTURE']['SRC'] ?:  $arResult['DETAIL_PICTURE']['SRC']) : '';

	// discount value
	$bSaleNumber = strlen($arResult['DISPLAY_PROPERTIES']['SALE_NUMBER']['VALUE']);

	// dicount counter
	$bDiscountCounter = ($arResult['ACTIVE_TO'] && in_array('ACTIVE_TO', $arParams['FIELD_CODE']));

	// discount date period
	$bActiveDate = strlen($arResult['DISPLAY_PROPERTIES']['PERIOD']['VALUE']) || ($arResult['DISPLAY_ACTIVE_FROM'] && in_array('DATE_ACTIVE_FROM', $arParams['FIELD_CODE']));
	?>
	<div class="popup-sale">
		<div class="popup-sale__item">
			<div class="popup-sale__item-title color_333 font_24 font_bold"><?=$arResult["NAME"]?></div>
			<div class="popup-sale__item-text color_666">
				<?// preview or detail image?>
				<?if($imageSrc):?>
					<div class="popup-sale__item-image-wrapper">
						<a class="popup-sale__item-link" href="<?=$arResult['DETAIL_PAGE_URL']?>">
							<span class="popup-sale__item-image rounded-4" style="background-image: url(<?=$imageSrc?>);"></span>
						</a>
					</div>
				<?endif;?>

				<?// date active period?>
				<?if(
					$bSaleNumber ||
					$bDiscountCounter ||
					$bActiveDate
				):?>
					<div class="popup-sale__item-info color_999 line-block line-block--24 line-block--8-vertical flexbox--wrap <?=($bDiscountCounter ? 'red' : '');?>">
						<?if(
							$bSaleNumber || 
							$bDiscountCounter
						):?>
							<div class="line-block__item">
								<div class="popup-sale__item-timer">
									<?if($bSaleNumber):?>
										<div class="popup-sale__item-sticker-value rounded-3"><?=$arResult['DISPLAY_PROPERTIES']['SALE_NUMBER']['VALUE']?></div>
									<?endif;?>
									<?if($bDiscountCounter):?>
										<?TSolution\Functions::showDiscountCounter(['ITEM' => $arResult]);?>
									<?endif;?>
								</div>
							</div>
						<?endif;?>

						<?if($bActiveDate):?>
							<div class="line-block__item">
								<div class="popup-sale__item-period font_13<?=($arResult['ACTIVE_TO'] ? ' red' : '');?>">
									<?=TSolution::showIconSvg("sale", SITE_TEMPLATE_PATH.'/images/svg/Sale_discount.svg', '', '', true, false);?>
									<?if(strlen($arResult['DISPLAY_PROPERTIES']['PERIOD']['VALUE'])):?>
										<span class="popup-sale__item-period-date"><?=$arResult['DISPLAY_PROPERTIES']['PERIOD']['VALUE']?></span>
									<?else:?>
										<span class="popup-sale__item-period-date"><?=$arResult['DISPLAY_ACTIVE_FROM']?></span>
									<?endif;?>
								</div>
							</div>
						<?endif;?>
					</div>
				<?endif;?>

				<?$obParser = new CTextParser;?>
				<?=$obParser->html_cut($arResult["DETAIL_TEXT"], 500);?>

				<div class="popup-sale__item-btn">
					<a class="btn btn-default btn-lg btn-transparent-border" href="<?=$arResult["DETAIL_PAGE_URL"]?>"><?=\Bitrix\Main\Localization\Loc::getMessage("MORE_TEXT_LINK")?></a>
				</div>
			</div>
			<script>
				initCountdown();
			</script>
		</div>
	</div>
<?endif;?>
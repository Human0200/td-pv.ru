<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>

<?if($arResult['ERRORS']):?>
	<?
	global $USER;
	if($USER->IsAdmin()):?>
		<div class="alert alert-danger">
			<?=$arResult['ERRORS']['MESSAGE']?>
		</div>
	<?endif;?>
<?else:?>
	<?if($arResult['ITEMS']):

		$bItemsOffset = $arParams['ITEMS_OFFSET'] === 'Y';
		$bWide = $arParams['WIDE'] === 'Y';
		// $iframeHeight = 500;
		// $iframeWidth  = 900;
		$margin = 0;

		$owlClasses = " owl-carousel--button-wide owl-carousel--buttons-bordered owl-carousel--light owl-carousel--buttons-bordered owl-carousel--outer-dots owl-carousel--static-dots owl-carousel--dots-padding-top-20";

		if(!$bItemsOffset) {
			$owlClasses .= " youtube-list__item--no-radius";
		}

		if ($bWide) {
			$owlClasses .= ' owl-carousel--no-hidden';
		} else {
			$owlClasses .= ' owl-carousel--button-offset-half';
		}

		if($bItemsOffset && $bWide) {
			$owlClasses .= ' owl-carousel--padding-left-32';
			$owlClasses .= ' owl-carousel--padding-right-32';
		}

		if(!$arParams['NARROW'] && $bWide) {
			$owlClasses .= ' owl-carousel--buttons-size-48 owl-carousel--button-offset-none';
		}

		$typeBlock = $arParams['TYPE_BLOCK'] ?? "normal";
		$arParams['RIGHT_LINK'] = isset($arParams["CHANNEL_ID_YOUTUBE"]) && !empty($arParams["CHANNEL_ID_YOUTUBE"]) ? $arResult['RIGHT_LINK'].$arParams["CHANNEL_ID_YOUTUBE"] : "";

		$bDots1200 = $arParams['DOTS_1200'] === 'Y' ? 1 : 0;
		if($arParams['ITEM_1200']) {
			$items1200 = intval($arParams['ITEM_1200']);
		}
		else{
			$items1200 = $arParams['COUNT_VIDEO_ON_LINE_YOUTUBE'] ? $arParams['COUNT_VIDEO_ON_LINE_YOUTUBE'] : 1;
		}

		$bDots768 = $arParams['DOTS_768'] === 'Y' ? 1 : 0;
		if($arParams['ITEM_768']) {
			$items768 = intval($arParams['ITEM_768']);
		}
		else{
			$items768 = $arParams['COUNT_VIDEO_ON_LINE_YOUTUBE'] > 1 ? 2 : 1;
		}

		$bDots380 = $arParams['DOTS_380'] === 'Y' ? 1 : 0;
		if($arParams['ITEM_380']) {
			$items380 = intval($arParams['ITEM_380']);
		}
		else{
			$items380 = 1;
		}

		if($arParams['ITEM_0']) {
			$items0 = intval($arParams['ITEM_0']);
		}
		else{
			$items0 = 1;
		}

		// if( intval($arParams['COUNT_VIDEO_ON_LINE_YOUTUBE']) === 2 &&  $bWide && !$bItemsOffset) {
		// 	$iframeHeight = 550;
		// 	$iframeWidth = 1000;
		// } elseif(intval($arParams['COUNT_VIDEO_ON_LINE_YOUTUBE']) === 2 &&  $bWide && $bItemsOffset) {
		// 	$iframeHeight = 565;
		// 	$iframeWidth = 1000;
		// }

		if($bWide){
			$margin = -1;
		}

		?>

		<div class="youtube-list <?=$templateName?>-template type-<?=$typeBlock?>">
			<?=TSolution\Functions::showTitleBlock([
				'PATH' => '',
				'PARAMS' => $arParams,
			]);?>

			<?if(!$bWide):?>
				<div class="maxwidth-theme">
			<?endif;?>
				<div class="carousel-youtube">
					<div class="item-views-youtube front blocks">
						<div class="owl-carousel <?=$owlClasses?>" data-plugin-options='{"items": <?=$arParams['COUNT_VIDEO_ON_LINE_YOUTUBE']?>, "nav": true, "autoplay": false, "rewind": true, "marginMove": true, "margin": <?=($bItemsOffset ? '32' : $margin)?>, "loop": false, "touchDrag": false, "mouseDrag": false, "dots": true, "dotsContainer": false, "responsive" : {"0": {<?=($arParams['TEXT_CENTER'] ? '' : '"autoWidth": false, "lightDrag": false,')?> "items": <?=$items0?>, "margin": <?=($bItemsOffset ? '24' : '0')?>}, "380": {<?=($arParams['TEXT_CENTER'] ? '' : '"autoWidth": false, "lightDrag": false,')?> "items": <?=$items380?>, "dots": 1, "margin": <?=($bItemsOffset ? '24' : '0')?>}, "768": {"autoWidth": false, "lightDrag": false, "dots": <?=$bDots768?>, "items": <?=$items768?> }, "1200": {"items": <?=$items1200?>, "dots": <?=$bDots1200?>}}}'>
							<?foreach ($arResult['ITEMS'] as $item):?>
								<div class="video_wrapper">
									<div class="youtube-list__item">
										<div class="youtube-list__item-video_wrapper-iframe youtube-list__item-preview" style="background:url(<?=$item['IMAGE']?>) center center/cover no-repeat;" data-video-id="<?=$item['ID']?>">
											<div id="youtube-player-id-<?=$item['ID']?>"></div>
										</div>	
									</div>
								</div>
							<?endforeach;?>
						</div>
					</div>
				</div>
			<?if(!$bWide):?>
				</div>
			<?endif;?>
		</div>
		<script>
			$(document).ready(function() {
				InitOwlSlider();
				//CheckObjectsSizes();
			});
		</script>
	<?endif;?>
<?endif;?>
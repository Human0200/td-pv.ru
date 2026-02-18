<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */

$this->setFrameMode(true);?>
<?if($arResult['ITEMS']):?>
	<?
	$sGroupLink = 'https://vk.com/'.$arResult['GROUP']['screen_name'];
	$arParams['RIGHT_LINK'] = $sGroupLink;
	$arParams["SHOW_TITLE"] = ($arParams["SHOW_TITLE"] === "Y");

	$bWide = $arParams['WIDE'] == 'Y';
	$bItemsOffset = $arParams['ITEMS_OFFSET'] != 'N';
	$bWidePictureBlock = $arParams['TYPE_BLOCK'] == 'WITH_BIG_BLOCK';
	$gridClass = ['grid-list'];

	$gridClass[] = 'mobile-scrolled mobile-scrolled--items-2 grid-list--items-3-991';

	if (!$bWide) {
		$gridClass[] = 'mobile-offset';

		if (!$bItemsOffset) {
			$gridClass[] = 'mobile-offset--right';
		}
	} else if ($bItemsOffset) {
		$gridClass[] = 'mobile-offset';
	}
	
	if ($arParams['NO_GRID']) {
		$gridClass[] = 'grid-list--no-grid';
	}

	if ($bWidePictureBlock) {
		$arParams['ELEMENTS_ROW'] = 5;
	}
	
	if ($bWide) {
		$gridClass[] = 'grid-list--items-'.$arParams['ELEMENTS_ROW'].'-wide';
	} else {
		$gridClass[] = 'grid-list--items-'.$arParams['ELEMENTS_ROW'];
	}

	$itemWrapperClasses = ' grid-list__item';

	$gridClass = TSolution\Utils::implodeClasses($gridClass);
	?>
	<?if (!$arParams['IS_AJAX']):?>
		<div class="vk-list <?=$blockClasses?> <?=$templateName?>-template">
			<?$obParser = new CTextParser;?>
			<?=TSolution\Functions::showTitleBlock([
				'PATH' => 'vk-list',
				'PARAMS' => $arParams,
				'VISIBLE' => !$bShowLeftBlock
			]);?>
			<?if(!$bWide):?>
				<div class="maxwidth-theme">
			<?else:?>
				<div class="maxwidth-theme maxwidth-theme--no-maxwidth">
			<?endif;?>
					<div class="<?=$gridClass?>">
	<?endif;?>
						<?foreach($arResult['ITEMS'] as $arItem):?>
							<?
								$arItem['permalink'] = $sGroupLink.'?w=wall'.$arItem['owner_id']."_".$arItem['id'];
								$arItem['LINK'] = '';
								if (isset($arItem['attachments']) && count($arItem['attachments'])) {
									$arItem['attachments'] = array_filter($arItem['attachments'], function($attachment){
										return in_array($attachment['type'], ['video', 'photo']);
									});

									switch ($arItem['attachments'][0]['type']) {
										case "photo":
											$maxWidth = 0;
											foreach($arItem['attachments'][0]['photo']['sizes'] as $key => $arImagePamrasSize) {
												if($arImagePamrasSize['width'] > $maxWidth){
													$maxWidth = $arImagePamrasSize['width'];
													$arItem['LINK'] = $arItem['attachments'][0]['photo']['sizes'][$key]['url'];
												}
											}
											break;
										case "video":
											$maxWidth = 0;
											foreach($arItem['attachments'][0]['video']['image'] as $key => $arVideoPamrasSize) {
												if($arVideoPamrasSize['width'] > $maxWidth) {
													$maxWidth = $arVideoPamrasSize['width'];
													$arItem['LINK'] = $arItem['attachments'][0]['video']['image'][$key]['url'];
												}
											}
											break;
									}
								}
								$bImage = !empty($arItem['LINK']) ?? "";
							?>
							<div class="vk-list__wrapper <?=$itemWrapperClasses?>">
								<div class="vk-list__item rounded-4 height-100">
									<a class="vk-list__item-link dark_link shadow-hovered shadow-no-border-hovered height-100 flexbox <?=$bShowScrollbar ? ' scrollbar' : ''; ?>" href="<?=$arItem['permalink']?>" target="_blank" rel="nofollow">
										<span class="vk-list__item-text-wrapper height-100 <?=!$bImage ? "not-image" : "";?>">
											<span class="vk-list__item-text-post-wrapper">
												<span class="vk-list__item-period-date font_13">
													<span class="color_999"><?=FormatDate('d.m.Y', $arItem['date'], 'SHORT');?></span>
													
													<? if ($arItem['copy_history']) {?>
													<span class="vk-list__item-period-icon">
													<?= TSolution::showSpriteIconSvg(SITE_TEMPLATE_PATH."/images/svg/content_icons_sprite.svg#icon-repost", 'svg-repost', [
																	'WIDTH' => 14,
																	'HEIGHT' => 16,
																]); ?>
													</span>
													<?}?>
												</span>

												<?if($arItem['text']):?>
													<span class="vk-list__item-text-post <?= $bImage ? "linecamp-3" : "linecamp-12";?>">
														<?=($obParser->html_cut($arItem['text'], $arResult['TEXT_LENGTH']));?>
													</span>
												<?endif;?>
											</span>
										</span>
										<?if($bImage):?>
											<span class="vk-list__item-image-wrapper">
												<span class="vk-list__item-image-post">
													<span class="image shine rounded-x" style="background:url(<?=$arItem['LINK']?>) center center/cover no-repeat;"></span>
												</span>
											</span>
										<?endif;?>
									</a>
								</div>
							</div>
						<?endforeach;?>
			<?if(!$bWide):?>
				</div>
			<?endif;?>
			</div>
	<?if (!$arParams['IS_AJAX']):?>
		</div>
	<?endif;?>
<?endif;?>
<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<?
$templateData = array(
	'MAP_ITEMS' => $arResult['MAP_ITEMS']
);
?>
<?if($arResult['ITEMS']):?>
	<?
	$bShowTitle = $arParams['TITLE'];
	$bShowTitleLink = $arParams['RIGHT_TITLE'] && $arParams['RIGHT_LINK'];
	$bNarrow = $arParams['WIDE'] != 'Y';
	$arParams['SHOW_PREVIEW_TEXT'] = 'N';
	
	$arParams['BTN_CLASS'] = 'btn-lg';
	$bWide = $arParams['WIDE'] == 'Y';
	$bOffset = $arParams['OFFSET'] == 'Y';
	?>
	<div class="map-list map2 <?=$templateName;?>-template">
		<? if($bWide && $bOffset) : ?>
			<div class="maxwidth-theme maxwidth-theme--no-maxwidth map-wrapper-offset">
		<? endif ?>

		<?ob_start();?>
			<?if($bShowTitle):?>
				<div class="index-block__title-wrapper index-block__title-wrapper--align-baseline <?=$arParams['TITLE_CENTER'] ? 'index-block__title-wrapper--centered' : ''?>">
					<div class="index-block__part--left">
						<div class="index-block__title switcher-title"><?=$arParams['TITLE'];?></div>
					</div>
					<div class="index-block__part--right">
						<?if($bShowTitleLink):?>
							<a class="index-block__link dark_link" href="<?=SITE_DIR.$arParams['RIGHT_LINK']?>" class="right_link_block"><?=$arParams['RIGHT_TITLE'];?></a>
						<?endif;?>
					</div>
				</div>
			<?endif;?>
		<?$title_block = ob_get_clean();?>

		<?if ($bNarrow):?>
			<?=TSolution\Functions::showTitleBlock([
				'PATH' => 'map-list',
				'PARAMS' => $arParams,
			]);?>
		<?endif;?>

		<div class="map-wrapper">
			<div class="maxwidth-theme maxwidth-theme--relative map-items-wrapper">
				<?$nCountItems = count($arResult['ITEMS']);?>
				
				<?if (!$bNarrow):?>
					<div class="map-with-title<?=($nCountItems == 1 ? ' map-with-title--one' : '');?>">
						<?=TSolution\Functions::showTitleBlock([
							'WRAPPER' => false,
							'PATH' => 'map-list',
							'PARAMS' => $arParams,
						]);?>
				<?endif;?>

				<div class="map-container <?=($nCountItems == 1 ? 'one' : '');?><?=($bNarrow ? ' map-container--absolute' : ' map-container--inline');?>">

					<div class="map-items scroll-deferred srollbar-custom" <?=($nCountItems == 1 ? "style='display:none;'" : "")?>>
						<div class="map-items__inner">
							<?foreach($arResult['ITEMS'] as $arItem):?>
								<?
								// edit/add/delete buttons for edit mode
								$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
								$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
								?>
								<div class="map-items__item stroke-theme-hover colored_theme_hover_bg-block" data-coordinates="<?=$arItem['DISPLAY_PROPERTIES']['MAP']['VALUE'];?>" id="<?=$this->GetEditAreaId($arItem['ID'])?>" data-id="<?=$arItem['ID']?>">
									<div class="map-items__item-title switcher-title color_333"><?=$arItem['NAME']?></div>
									<?if($arItem['DISPLAY_PROPERTIES']['PHONE']['VALUE']):?>
										<div class="map-items__item-phones">
											<?if(is_array($arItem['DISPLAY_PROPERTIES']['PHONE']['VALUE'])):?>
												<?foreach($arItem['DISPLAY_PROPERTIES']['PHONE']['VALUE'] as $value):?>
													<div class="value font_13"><a class="color_666" rel= "nofollow" href="tel:<?=str_replace(array('+', ' ', ',', '-', '(', ')'), '', $value)?>"><?=$value;?></a></div>
												<?endforeach;?>
											<?else:?>
												<div class="value font_13"><a class="color_666" rel= "nofollow" href="tel:<?=str_replace(array('+', ' ', ',', '-', '(', ')'), '', $arItem['DISPLAY_PROPERTIES']['PHONE']['VALUE'])?>"><?=$arItem['DISPLAY_PROPERTIES']['PHONE']['VALUE'];?></a></div>
											<?endif;?>
										</div>
									<?endif;?>
									<?=TSolution::showIconSvg(' map-items__item-right-arrow', SITE_TEMPLATE_PATH.'/images/svg/Arrow_map.svg');?>
									<div class="map-items__item-line colored_theme_hover_bg-el"></div>
								</div>
							<?endforeach;?>
						</div>
					</div>

					<div class="map-detail-items scroll-deferred srollbar-custom" <?=($nCountItems == 1 ? "style='display:block;'" : "")?>>
						<?foreach($arResult['ITEMS'] as $arItem):?>
							<div class="map-detail-items__item map-detail-items__item--hidden" <?=($nCountItems == 1 ? "style='display:block;'" : "")?> data-coordinates="<?=$arItem['DISPLAY_PROPERTIES']['MAP']['VALUE'];?>" data-id="<?=$arItem['ID']?>">
								<?=TSolution\Functions::getItemMapHtml([
									'ITEM' => $arItem,
									'PARAMS' => $arParams,
									'SHOW_TITLE' => 'Y',
									'SHOW_SOCIAL' => 'Y',
									'SHOW_QUESTION_BTN' => 'Y',
									'SHOW_CLOSE' => ($nCountItems == 1 ? 'N' : 'Y'),
								])?>
							</div>
						<?endforeach;?>
					</div>

					<?if (!$bNarrow):?>
						<div class="map-detail-items__item-svg muted fill-theme-hover map-detail-items__item-svg--cross"><svg class="map-detail-items__item-close fill-999" width="14" height="14" viewBox="0 0 14 14"><path data-name="Rounded Rectangle 568 copy 16" class="cls-1" d="M1009.4,953l5.32,5.315a0.987,0.987,0,0,1,0,1.4,1,1,0,0,1-1.41,0L1008,954.4l-5.32,5.315a0.991,0.991,0,0,1-1.4-1.4L1006.6,953l-5.32-5.315a0.991,0.991,0,0,1,1.4-1.4l5.32,5.315,5.31-5.315a1,1,0,0,1,1.41,0,0.987,0.987,0,0,1,0,1.4Z" transform="translate(-1001 -946)"></path></svg></div>
					<?endif;?>
				</div>

				<?if (!$bNarrow):?>
					</div>
				<?endif;?>
			</div>
<?endif;?>
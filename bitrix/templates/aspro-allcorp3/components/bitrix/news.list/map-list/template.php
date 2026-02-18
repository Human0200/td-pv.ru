<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<?
$templateData = array(
	'MAP_ITEMS' => $arResult['MAP_ITEMS']
);
?>
<?if($arResult['ITEMS']):?>
	<?$bWide = $arParams['WIDE'] == 'Y';?>
	<?$bOffset = $arParams['OFFSET'] == 'Y';?>
	<div class="map-list <?=$templateName;?>-template">
		<?=TSolution\Functions::showTitleBlock([
			'PATH' => 'map-list',
			'PARAMS' => $arParams,
		]);?>

		<? if($bWide && $bOffset) : ?>
			<div class="maxwidth-theme maxwidth-theme--no-maxwidth map-wrapper-offset">
		<? endif ?>

		<div class="map-wrapper map-wrapper--overflow-hidden">
			<div class="maxwidth-theme<?=($bWide ? '' : ' maxwidth-theme--relative')?> map-items-wrapper">
				<?$nCountItems = count($arResult['ITEMS']);?>
				<div class="map-container <?=($nCountItems == 1 ? 'one' : '');?> map-container--sticky-right<?=(!$bWide ? ' map-container--right-33' : '')?>">

					<div class="map-items scroll-deferred srollbar-custom" <?=($nCountItems == 1 ? "style='display:none;'" : "")?>>
						<div class="map-items__inner">
							<?foreach($arResult['ITEMS'] as $arItem):?>
								<?
								// edit/add/delete buttons for edit mode
								$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
								$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
								?>
								<div class="map-items__item fill-theme-hover" data-coordinates="<?=$arItem['DISPLAY_PROPERTIES']['MAP']['VALUE'];?>" id="<?=$this->GetEditAreaId($arItem['ID'])?>" data-id="<?=$arItem['ID']?>">
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
									<?=TSolution::showIconSvg(' map-items__item-right-arrow fill-dark-light-block', SITE_TEMPLATE_PATH.'/images/svg/Arrow_right_small.svg');?>
								</div>
							<?endforeach;?>
						</div>
					</div>

					<div class="map-detail-items scroll-deferred srollbar-custom" <?=($nCountItems == 1 ? "style='display:block;'" : "")?>>
						<?foreach($arResult['ITEMS'] as $arItem):?>
							<div class="map-detail-items__item map-detail-items__item--hidden" <?=($nCountItems == 1 ? "style='display:block;'" : "")?> data-coordinates="<?=$arItem['DISPLAY_PROPERTIES']['MAP']['VALUE'];?>" data-id="<?=$arItem['ID']?>">
								<?=TSolution\Functions::getItemMapHtml([
									'ITEM' => $arItem,
									'SHOW_QUESTION_BTN' => 'Y',
									'SHOW_CLOSE' => ($nCountItems == 1 ? 'N' : 'Y'),
								])?>
							</div>
						<?endforeach;?>
					</div>
				</div>
			</div>
<?endif;?>
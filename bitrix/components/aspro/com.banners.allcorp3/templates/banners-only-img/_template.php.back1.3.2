<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>

<?if($arResult['ITEMS']):?>
	<?
	$bNarrow = $arParams['WIDE'] !== 'Y';
	$bItemOffset = $arParams['ITEMS_OFFSET'] === 'Y';
	$bOneItem = $arParams['ELEMENTS_ROW'] == '1';

	$gridClass = 'grid-list';

	if (!$bItemOffset) {
		$gridClass .= ' grid-list--no-gap';
	}
	if ($arParams['NO_GRID']) {
		$gridClass .= ' grid-list--no-grid';
	}
	if (!$bNarrow) {
		$gridClass .= ' grid-list--items-'.$arParams['ELEMENTS_ROW'].'-wide';
	} else {
		$gridClass .= ' grid-list--items-'.$arParams['ELEMENTS_ROW'];
	}

	$imageClass = '';
	if ($bOneItem) {
		$imageClass .= ' banners-img-list__item-image--one';
	} else {
		$imageClass .= ' banners-img-list__item-image--more';
	}
	if ($bItemOffset) {
		$imageClass .= ' rounded-4';
	}

	?>

	<div class="banners-img-list <?=$templateName?>-template">

		<?if($bNarrow):?>
			<div class="maxwidth-theme">
		<?elseif ($bItemOffset):?>
			<div class="maxwidth-theme maxwidth-theme--no-maxwidth">
		<?endif;?>

			<div class="<?=$gridClass?>">
				<?foreach ($arResult['ITEMS'] as $arItem) {
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
					$bUrl = (isset($arItem['DISPLAY_PROPERTIES']['URL']) && $arItem['DISPLAY_PROPERTIES']['URL']['VALUE']);
					// $sUrl = ($bUrl ? str_replace('//', '/', SITE_DIR.$arItem['DISPLAY_PROPERTIES']['URL']['VALUE']) : '');
					$sUrl = ($bUrl ? str_replace('//', '/', $arItem['DISPLAY_PROPERTIES']['URL']['VALUE']) : '');
					?>
					<div class="banners-img-list__wrapper grid-list__item">
						<div class="banners-img-list__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
							<?if ($sUrl):?>
								<a href="<?=$sUrl;?>" class="banners-img-list__item-link hover_blink" title="<?=($arItem['PREVIEW_PICTURE']['TITLE']?$arItem['PREVIEW_PICTURE']['TITLE']:$arItem['NAME']);?>">
							<?endif;?>
							<span class="not-eyed-images-off--hidden"><?=($arItem['PREVIEW_PICTURE']['TITLE']?$arItem['PREVIEW_PICTURE']['TITLE']:$arItem['NAME']);?></span>
							<span class="banners-img-list__item-image <?=($sUrl ? ' shine' : '');?> <?=$imageClass?>" style="background-image:url(<?=$arItem['PREVIEW_PICTURE']['SRC'];?>)"></span>
							<?if ($sUrl):?>
								</a>
							<?endif;?>
						</div>
					</div>
				<?}?>
			</div>

		<?if($bNarrow || $bItemOffset):?>
			</div>
		<?endif;?>

	</div>
<?endif;?>
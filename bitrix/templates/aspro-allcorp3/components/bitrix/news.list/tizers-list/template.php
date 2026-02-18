<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? $this->setFrameMode( true ); ?>

<?if($arResult["ITEMS"]):?>
	<?
	$templateData['ITEMS'] = true;
	
	$bTextCentered = $arParams['TEXT_CENTERED'] == 'Y';

	$blockClasses = '';
	if($bTextCentered) {
		$blockClasses .= ' tizers-list--text-center';
	}
	if($arParams['NARROW']) {
		$blockClasses .= ' tizers-list--narrow';
	} else {
		$blockClasses .= ' tizers-list--wide';
	}

	$gridClass = ['grid-list'];
	if ($arParams['NARROW']) {
		$gridClass[] = 'grid-list--items-'.$arParams['ITEMS_COUNT'];
	} else {
		$gridClass[] = 'grid-list--items-'.$arParams['ITEMS_COUNT'].'-wide';
	}

	if (!$arParams['ITEMS_OFFSET']) {
		$gridClass[] = 'grid-list--no-gap';
	}

	if ($arParams['MOBILE_SCROLLED']) {
		$gridClass[] = 'mobile-scrolled mobile-scrolled--items-2';

		if ($arParams['NARROW']) {
			$gridClass[] = 'mobile-offset';

			if (!$arParams['ITEMS_OFFSET']) {
				$gridClass[] = 'mobile-offset--right';
			}
		} else if ($arParams['ITEMS_OFFSET']) {
			$gridClass[] = 'mobile-offset';
		}
	}

	$itemClasses = '';
	$itemClasses .= ' tizers-list__item--images-'.$arParams['IMAGES'];
	$itemClasses .= ' tizers-list__item--images-position-'.$arParams['IMAGE_POSITION'];

	if($arParams['ITEMS_BG']) {
		if($arParams['NARROW']) {
			$itemClasses .= ' tizers-list__item--with-bg tizers-list__item--narrow-with-bg';
		} else {
			$itemClasses .= ' tizers-list__item--with-bg tizers-list__item--wide-with-bg';
		}
	}
	if(!$arParams['ITEMS_OFFSET'] && $arParams['BORDER']) {
		$itemClasses .= ' tizers-list__item--no-radius';
	}
	if($arParams['TEXT_CENTERED']) {
		$itemClasses .= ' tizers-list__item--centered';
	}
	if($arParams['IMAGE_POSITION'] == 'TOP') {
		$itemClasses .= ' tizers-list__item--column';
	}

	$wrapperClasses = ' grid-list__item';
	if($arParams['BORDER']) {
		$itemClasses .= ' bordered';
	}

	$gridClass = TSolution\Utils::implodeClasses($gridClass);
	?>
	<div class="tizers-list <?=$blockClasses?>">
		<?if($arParams['NARROW'] || ($arParams['ITEMS_BG'] && $arParams['ITEMS_OFFSET'])):?>
			<div class="maxwidth-theme <?= !$arParams['NARROW'] ? 'maxwidth-theme--no-maxwidth' : ''?>">
		<?endif;?>

		<div class="tizers-list__items-wrapper <?=$gridClass;?>">
			<?foreach($arResult["ITEMS"] as $arItem){
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				$name = $arItem['NAME'];
				$link = $arItem["PROPERTIES"]["LINK"]["VALUE"];
				?>
				<div class="tizers-list__item-wrapper <?=$wrapperClasses?>">
					<div class="tizers-list__item <?=$itemClasses?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
						<?
						switch($arParams['IMAGES']) {
							case 'TEXT':
								$bText = true;
								$image = $arItem['FIELDS']['PREVIEW_TEXT'];
								break;
							case 'PICTURES':
								$bPicture = true;
								$image = $arItem["DETAIL_PICTURE"]['ID'];
								break;
							case 'ICONS':
								$bIcon = true;
								$image = $arItem["PROPERTIES"]["TIZER_ICON"]["VALUE"];
								break;
							default:
								$image = false;
						}

						if($image && !$bText) {
							$imagePath = CFile::GetPath($image);
						}
						?>

						<?if($image){?>
							<div class="tizers-list__item-image-wrapper tizers-list__item-image-wrapper--<?=$arParams['IMAGES']?> tizers-list__item-image-wrapper--position-<?=$arParams['IMAGE_POSITION']?>">
								<?if($link):?>
									<a class="tizers-list__item-link" href="<?=$link?>">
								<?endif;?>
									<?if($bText):?>
										<div class="tizers-list__item-image-text switcher-title color-theme <?=$arParams['TOP_TEXT_SIZE'] ? 'tizers-list__item-image-text--size-'.$arParams['TOP_TEXT_SIZE'] : ''?>"><?=$image?></div>
									<?elseif($bIcon):?>
										<?=CAllcorp3::showIconSvg(' fill-theme tizers-list__item-image-icon', $imagePath);?>
									<?else:?>
										<div class="tizers-list__item-image-picture" style="background-image: url(<?=$imagePath?>);"></div>
									<?endif;?>
								<?if($link):?>
									</a>
								<?endif;?>
							</div>
						<?}?>

						<div class="tizers-list__item-text-wrapper color_333">
							<?if(!$bText):?>
								<?if($link):?>
									<a class="tizers-list__item-link dark_link" href="<?=$link?>">
								<?endif;?>
										<span class="tizers-list__item-name font_17 switcher-title"><?=$name;?></span>
								<?if($link):?>
									</a>
								<?endif;?>
							<?endif;?>
							
							<?if($arItem['FIELDS']["DETAIL_TEXT"]):?>
								<span class="tizers-list__item-descr font_14 color_666"><?=$arItem["DETAIL_TEXT"];?></span>
							<?endif;?>
						</div>
					</div>
				</div>
			<?}?>
		</div>

		<?if($arParams['NARROW'] || ($arParams['ITEMS_BG'] && $arParams['ITEMS_OFFSET'])):?>
			</div>
		<?endif;?>
	</div>
<?endif;?>
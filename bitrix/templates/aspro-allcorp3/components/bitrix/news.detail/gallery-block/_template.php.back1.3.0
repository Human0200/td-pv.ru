<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();
$this->setFrameMode(true);
use \Bitrix\Main\Localization\Loc;
?>
<?if($arResult && $arResult['PROPERTIES']['PHOTOS']['VALUE']):?>
	<?
	$blockClasses = 'grid-list grid-list--items-2 grid-list--items-exact-2';

	$itemWrapperClasses = ' grid-list__item';
	if(!$arParams['ITEMS_OFFSET'] && $arParams['BORDER']){
		$itemWrapperClasses .= ' grid-list-border-outer';
	}
	if($bItemsTypeAlbums){
		$itemWrapperClasses .= ' animate-arrow-hover';
	}

	$itemClasses = 'height-100 flexbox dark-block-hover gallery-list__item--has-bg gallery-list__item--photos rounded-4 gallery-list__item--has-additional-text';
	$imageWrapperClasses = 'gallery-list__item-image-wrapper--PICTURES gallery-list__item-image-wrapper--BG';
	$imageClasses = 'rounded-4';
	?>
	<div class="gallery-item <?=$templateName?>-template">
		<?if($arParams['NARROW']):?>
			<div class="maxwidth-theme">
		<?endif;?>

		<div class="<?=$blockClasses;?>">
			<?foreach($arResult['PROPERTIES']['PHOTOS']['VALUE'] as $photoId):?>
				<?
				$arImage = CFile::GetFileArray($photoId);
				$imageSrc = $arImage['SRC'];
				$imageDescr = $arImage['DESCRIPTION'];
				?>
				<div class="gallery-list__wrapper <?=$itemWrapperClasses?>">
					<div class="gallery-list__item <?=$itemClasses?>">
						<div class="gallery-list__item-image-wrapper <?=$imageWrapperClasses?>">
							<a class="gallery-list__item-link" href="javascript:void(0);" title="<?=htmlspecialcharsbx($imageDescr)?>" data-big="<?=$imageSrc?>">
								<span class="gallery-list__item-image <?=$imageClasses?>" style="background-image: url(<?=$imageSrc?>);"></span>
							</a>
						</div>

						<div class="gallery-list__item-text-wrapper flexbox ">
							<div class="gallery-list__item-text-cross-part animate-cross-hover">
								<div class="cross cross--wide42"></div>
							</div>
						</div>
					</div>
				</div>
			<?endforeach;?>
		</div>

		<?if($arParams['NARROW']):?>
			</div>
		<?endif;?>
	</div>
<?else:?>
	<div class="alert alert-warning"><?=GetMessage("ELEMENT_PROPERTY_ERROR")?></div>
<?endif;?>
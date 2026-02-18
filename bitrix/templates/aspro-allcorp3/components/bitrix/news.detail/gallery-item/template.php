<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();
$this->setFrameMode(true);
use \Bitrix\Main\Localization\Loc;
use Bitrix\Main\Web\Json;

global $arTheme;
?>
<?if($arResult):?>
	<?
    $templateData['ITEMS'] = true;
	$blockClasses = '';

	$sliderClassList = ['appear-block swipeignore slider-solution-items-by-'.$arParams['ELEMENTS_ROW']];

	$itemWrapperClasses = ' grid-list__item';
	if(!$arParams['ITEMS_OFFSET'] && $arParams['BORDER']){
		$itemWrapperClasses .= ' grid-list-border-outer';
	}
	if($bItemsTypeAlbums){
		$itemWrapperClasses .= ' stroke-theme-parent-all colored_theme_hover_bg-block animate-arrow-hover';
	}

	$itemClasses = 'height-100 flexbox dark-block-hover gallery-list__item--has-additional-text gallery-list__item--has-bg gallery-list__item--photos';
	$imageWrapperClasses = 'gallery-list__item-image-wrapper--PICTURES gallery-list__item-image-wrapper--BG';
	$imageClasses = 'rounded-4';
	?>
	<div class="gallery-item <?=$blockClasses?> <?=$templateName?>-template">
		<?if($arParams['NARROW']):?>
			<div class="maxwidth-theme">
		<?endif;?>

		<?//need for showed left block?>
		<div class="flexbox flexbox--direction-row flexbox--column-t991">
			<?=TSolution\Functions::showTitleInLeftBlock([
				'PARAMS' => array_merge($arParams, [
					'TITLE' => $arResult['NAME'],
					'PREVIEW_TEXT' => $arResult['PREVIEW_TEXT'],
				]),
			]);?>

			<div class="flex-grow-1">
				<?if($arResult['PROPERTIES']['PHOTOS']['VALUE']):?>
                    <?
                    $countPhoto = count($arResult['PROPERTIES']['PHOTOS']['VALUE']);
                    $arOptionsGallery = [
                        'rewind'=> true,
                        'preloadImages' => false,
                        'keyboard' => true,
                        'navigation' => [
                            'nextEl' => '.gallery-item  .swiper-button-next',
                            'prevEl' => '.gallery-item  .swiper-button-prev',
                        ],
                        'spaceBetween' => 0,
                        'pagination' => [
                            'el' => '.gallery-item .swiper-pagination',
                            'clickable' => true,
                        ],
                    ];
                    ?>
                    <div class="<?if($arParams['NARROW']):?>slide-nav-offset<?endif;?> relative">
                        <div class="swiper slider-solution rounded-4 <?=TSolution\Utils::implodeClasses($sliderClassList);?>" data-plugin-options='<?=Json::encode($arOptionsGallery)?>'>
                            <div class="swiper-wrapper">
                                <?foreach($arResult['PROPERTIES']['PHOTOS']['VALUE'] as $photoId):?>
                                    <?
                                    $arImage = CFile::GetFileArray($photoId);
                                    $imageSrc = $arImage['SRC'];
                                    $imageDescr = $arImage['DESCRIPTION'];
                                    ?>
                                    <div class="swiper-slide swiper-autoheight gallery-list__wrapper <?=$itemWrapperClasses?>">
                                        <div class="gallery-list__item <?=$itemClasses?>">
                                            <div class="gallery-list__item-image-wrapper <?=$imageWrapperClasses?>">
                                                <a class="gallery-list__item-link" href="javascript:void(0);" title="<?=htmlspecialcharsbx($imageDescr)?>" data-big="<?=$imageSrc?>">
                                                    <span class="gallery-list__item-image <?=$imageClasses?>" style="background-image: url(<?=$imageSrc?>);"></span>
                                                </a>
                                            </div>

                                            <div class="gallery-list__item-text-wrapper flexbox ">
                                                <div class="gallery-list__item-text-cross-part animate-cross-hover fancy fancy-thumbs" data-fancybox="item_slider_favorite" data-src="<?=$imageSrc?>" data-big="<?=$imageSrc?>">
                                                    <div class="cross cross--wide42"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?endforeach;?>
                            </div>
                        </div>
                        <?if ($countPhoto > 1):?>
                            <?TSolution\Functions::showBlockHtml([
                                'FILE' => 'ui/slider-pagination.php',
                                'PARAMS' => [
                                    'CLASSES' => 'line-block--justify-center',
                                ]
                            ]);?>

                            <?TSolution\Functions::showBlockHtml([
                                'FILE' => 'ui/slider-navigation.php',
                                'PARAMS' => [
                                    'CLASSES' => 'slider-nav--shadow slider-nav--center hide-600',
                                ]
                            ]);?>
                        <?endif;?>
                    </div>
				<?endif;?>
			</div>
		</div>

		<?if($arParams['NARROW']):?>
			</div>
		<?endif;?>
	</div>
<?endif;?>

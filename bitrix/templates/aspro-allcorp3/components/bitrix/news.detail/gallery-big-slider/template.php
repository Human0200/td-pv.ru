<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();
$this->setFrameMode(true);
use \Bitrix\Main\Localization\Loc;

$templateData['ITEMS'] = false;
?>
<?if($arResult && $arResult['PROPERTIES']['PHOTOS']['VALUE']):?>
	<?
    $countPhoto = count($arResult['PROPERTIES']['PHOTOS']['VALUE']);
    $arOptionsGalleryBig = [
        'navigation' => [
            'nextEl' => '.gallery-big  .swiper-button-next',
            'prevEl' => '.gallery-big  .swiper-button-prev',
        ],
        'spaceBetween' => 15,
        'pagination' => [
            'el' => '.gallery-big .swiper-pagination',
            'clickable' => true,
        ],
        'thumbs' => [
            'swiper' => '#gallery-thumbs',
        ],
    ];

    $arOptionsGallerySmall = [
        'spaceBetween' => 30,
        'slidesPerView' => "auto",
        'freeMode' => true,
        'watchSlidesProgress' => true,
        'type' => 'gallery-thumbs',
        'navigation' => [
         'nextEl' => '.gallery-thumbs .swiper-button-next',
         'prevEl' => '.gallery-thumbs .swiper-button-prev',
        ],
        'breakpoints' => [
			601 => [
				'slidesPerView' => 4
			],
			992 => [
				'slidesPerView' => 5,
				'freeMode' => false,
			],
			1251 => [
				'slidesPerView' => 7,
				'freeMode' => false,
			],
		],
    ];
    $templateData['ITEMS'] = true;
	$blockClasses = 'bordered rounded-4';
	?>
	<div class="gallery-item <?=$templateName?>-template">
		<?if($arParams['NARROW']):?>
			<div class="maxwidth-theme">
		<?endif;?>

		<div class="gallery-item__inner <?=$blockClasses;?>">
			<div class="gallery-big">
                <div class="slide-nav-offset relative">
                    <div id="gallery" class="swiper slider-solution gallery-big__swiper" data-plugin-options='<?=json_encode($arOptionsGalleryBig)?>'>
                        <div class="swiper-wrapper">
                            <?foreach($arResult['PROPERTIES']['PHOTOS']['VALUE'] as $photoId):?>
                                <?
                                $arImage = CFile::GetFileArray($photoId);
                                $imageSrc = $arImage['SRC'].'?v=1.2.10';
                                $imageDescr = $arImage['DESCRIPTION'] ?: $arResult["NAME"];
                                ?>
                                <div class="item text-center swiper-slide swiper-autoheight">
                                    <div class="flexbox flexbox--justify-center height-100">
                                        <a class="fancy gallery-big__link fancy-thumbs" data-fancybox="big-gallery" href="<?=$imageSrc?>" title="<?=htmlspecialcharsbx($imageDescr)?>">
                                            <img class="img-responsive rounded-4" src="<?=$imageSrc?>" alt="<?= htmlspecialcharsbx($imageDescr)?>"/>
                                        </a>
                                    </div>
                                </div>
                            <?endforeach;?>
                        </div>
                        <div class="gallery-count-info font_13 color_999 text-center hidden-xs">
                            <span class="gallery-count-info__js-text">1</span>/<span><?=$countPhoto;?></span>
                        </div>
                    </div>
                    <?if ($countPhoto > 1):?>
                        <?TSolution\Functions::showBlockHtml([
                            'FILE' => 'ui/slider-pagination.php',
                            'PARAMS' => [
                                'CLASSES' => 'line-block--justify-center static slider-pagination--visible-600 swiper-pagionation-bullet--line-to-600',
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
			</div>
			<?if ($countPhoto > 1):?>
				<div class="gallery-thumbs relative hide-600">
                    <div class="relative slide-nav-offset">
                        <div id="gallery-thumbs" class="swiper slider-solution gallery-thumbs__swiper" data-plugin-options='<?=json_encode($arOptionsGallerySmall)?>' >
                            <div class="swiper-wrapper">
                                <?foreach($arResult['PROPERTIES']['PHOTOS']['VALUE'] as $photoId):?>
                                    <?
                                    $arImage = CFile::GetFileArray($photoId);
                                    $imageSrc = $arImage['SRC']."?v=1.2.10";
                                    $imageDescr = $arImage['DESCRIPTION'] ?: $arResult["NAME"];
                                    ?>
                                    <div id="photo-<?=$photoId?>" class="gallery-thumbs__item rounded-4 swiper-slide">
                                        <img class="gallery-thumbs__picture rounded-4" src="<?=$imageSrc?>" title="<?=htmlspecialcharsbx($imageDescr)?>" alt="<?= htmlspecialcharsbx($imageDescr) ?>"/>
                                    </div>
                                <?endforeach;?>
                            </div>
                        </div>
                        <?TSolution\Functions::showBlockHtml([
                            'FILE' => 'ui/slider-navigation.php',
                            'PARAMS' => [
                                'CLASSES' => 'slider-nav--shadow slider-nav--center slider-nav-thumbs',
                            ]
                        ]);?>
                    </div>
				</div>
			<?endif;?>
		</div>

		<?if($arParams['NARROW']):?>
			</div>
		<?endif;?>
	</div>
<?else:?>
	<div class="alert alert-warning"><?=GetMessage("ELEMENT_PROPERTY_ERROR")?></div>
<?endif;?>

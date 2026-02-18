<?php

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Web\Json;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}
$this->setFrameMode(true);

if (empty($arResult['ITEMS'])) {
    return;
}


$templateData['ITEMS'] = true;
$templateData['TEMPLATE_FOLDER'] = $this->__folder;

$bTextCentered = $arParams['TEXT_CENTER'] == 'Y';

$bShowTitle = $arParams['TITLE'] && $arParams['FRONT_PAGE'] && $arParams['SHOW_TITLE'];
$bShowTitleLink = $arParams['RIGHT_TITLE'] && $arParams['RIGHT_LINK'];

$bShowRating = in_array('RATING', $arParams['PROPERTY_CODE']);
$bHaveMore = count($arResult['ITEMS']) > $arParams['ELEMENT_IN_ROW'];
$bTopNav = (!$arParams['TITLE_CENTER'] && $arParams['SHOW_TITLE']) && $arParams['NARROW'];

$arParams['SHOW_NEXT'] = $arParams['SHOW_NEXT'] && $bHaveMore;

$blockClassList = ['reviews-list'];
if ($arParams['TEXT_CENTER']) {
    $blockClassList[] = 'reviews-list--text-center';
}
if (!$arParams['ITEMS_OFFSET']) {
    $blockClassList[] = 'reviews-list--items-close';
}
if ($arParams['ITEMS_OFFSET'] || (!$arParams['ITEMS_OFFSET'] && $arParams['NARROW'])) {
    $blockClassList[] = 'slide-nav-offset';
}

$sliderClassList = ['reviews-list-slider swiper slider-solution mobile-offset mobile-offset--right appear-block slider-item-width-360-to-600'];
$sliderClassList[] = 'slider-solution-items-by-'.$arParams['ELEMENT_IN_ROW'];
if (!$arParams['ITEMS_OFFSET']) {
    $sliderClassList[] = 'slider-solution--no-gap';
}
if ($arParams['SHOW_NEXT']) {
    $sliderClassList[] = 'overflow-visible';
}

$itemClassList = ['reviews-list__item height-100'];
if ($arParams['BORDER']) {
    $itemClassList[] = 'bordered bg-theme-parent-hover';

    if ($arParams['ITEMS_OFFSET']) {
        $itemClassList[] = 'rounded-4';
    }
}
if ($arParams['ITEM_ROW']) {
    $itemClassList[] = 'reviews-list__item--row';
}
if ($arParams['ITEM_PADDING']) {
    $itemClassList[] = 'reviews-list__item--padding-'.$arParams['ITEM_PADDING'];
}
if (!$arParams['ITEMS_OFFSET'] && $arParams['BORDER'] && ($arParams['ELEMENT_IN_ROW'] > 1 || $arParams['SHOW_NEXT'])) {
    $itemClassList[] = 'reviews-list__item--no-radius';
}
if ($arParams['TEXT_CENTER']) {
    $itemClassList[] = 'reviews-list__item--column';
    $itemClassList[] = 'reviews-list__item--centered-vertical';
}

$maxwidthClasses = [];
if (!isset($arParams['MAXWIDTH_THEME']) || $arParams['MAXWIDTH_THEME']) {
    if ($arParams['NARROW']) {
        $maxwidthClasses[] = 'maxwidth-theme';
    } else if ($arParams['ITEMS_OFFSET']) {
        $maxwidthClasses[] = 'maxwidth-theme maxwidth-theme--no-maxwidth';
    }
}
?>

<div class="<?=TSolution\Utils::implodeClasses($blockClassList);?>">
    <?=TSolution\Functions::showTitleBlock([
        'PATH' => 'reviews-list',
        'PARAMS' => $arParams,
    ]);?>

    <div class="<?=TSolution\Utils::implodeClasses($maxwidthClasses);?>">
        <div class="relative">
            <?
            $arOptions = [
                'preloadImages' => false,
                'keyboard' => true,
                'init' => false,
                'countSlides' => count($arResult['ITEMS']),
                'rewind'=> true,
                'freeMode' => [
                    'enabled' => true,
                    'momentum' => true,
                    // 'sticky' => true,
                ],
                'watchSlidesProgress' => true, // fix slide on click on slide link in mobile template
                'slidesPerView' => 'auto',
                'type' => 'main_reviews',
                'spaceBetween' => $arParams['ITEMS_OFFSET']
                    ? '32'
                    : ($arParams['BORDER'] ? '-1' : 0),
            ];

            if ($arParams['ELEMENT_IN_ROW'] > 1) {
                $arOptions['breakpoints'] = [
                    601 => [
                        'slidesPerView' => 2,
                        'freeMode' => false,
                    ],
                    768 => [
                        'slidesPerView' => $arParams['ELEMENT_IN_ROW']-1,
                        'freeMode' => false,
                    ],
                    992 => [
                        'slidesPerView' => $arParams['ELEMENT_IN_ROW'],
                        'freeMode' => false,
                    ],
                ];
            } else {
                $arOptions['breakpoints'] = [
                    '601' => [
                        'slidesPerView' => 1,
                        'freeMode' => false,
                    ]
                ];
            }
            ?>
            <div class="<?=TSolution\Utils::implodeClasses($sliderClassList);?>" data-plugin-options='<?=Json::encode($arOptions);?>'>
                <div class="swiper-wrapper">
                    <?foreach ($arResult['ITEMS'] as $i => $arItem):?>
                        <?
                        $counter++;
                        // edit/add/delete buttons for edit mode
                        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
                        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                        // preview image
                        $bLogoImage = isset($arItem['FIELDS']['DETAIL_PICTURE']) && $arItem['DETAIL_PICTURE']['SRC'];
                        $arImageTemp = $bLogoImage
                            ? $arItem['FIELDS']['DETAIL_PICTURE']
                            : (
                                (isset($arItem['FIELDS']['PREVIEW_PICTURE']) && $arItem['PREVIEW_PICTURE']['SRC'])
                                ? $arItem['FIELDS']['PREVIEW_PICTURE']
                                : []
                            );
                        $bImage = $arImageTemp;
                        $nImageID = ($bImage ? $arImageTemp['ID'] : false);
                        $imageSrc = SITE_TEMPLATE_PATH.'/images/svg/noimage_staff.svg';
                        if ($bImage) {
                            $arImage = $bLogoImage
                                ? CFile::GetFileArray($nImageID)
                                : CFile::ResizeImageGet($nImageID, array('width' => 80, 'height' => 80), BX_RESIZE_IMAGE_EXACT, true);
                            $imageSrc = $bLogoImage ? $arImage['SRC'] : $arImage['src'];
                        }
                        ?>
                        <div class="grid-list__item swiper-slide swiper-slide--height-auto">
                            <div class="<?=TSolution\Utils::implodeClasses($itemClassList);?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                                <div class="reviews-list__item-top-part <?=$arParams['TEXT_CENTER'] ? 'reviews-list__item-top-part--centered' : ''?> <?=$arParams['ITEM_ROW'] ? '' : 'reviews-list__item-top-part--centered-vertical'?> <?=$arParams['ITEM_TOP_PART_ROW'] ? 'reviews-list__item-top-part--row' : ''?> <?=$arParams['TOP_PART_COLUMN'] ? 'reviews-list__item-top-part--column' : ''?>">
                                    <div class="reviews-list__item-info-wrapper <?=$arParams['IMAGE_RIGHT'] ? 'reviews-list__item-info-wrapper--image-right' : ''?>">
                                        <?if ($arParams['IMAGE'] && $imageSrc):?>
                                            <?
                                            $imageClassList = ['reviews-list__item-image-wrapper'];
                                            if ($bLogoImage) {
                                                $imageClassList[] = 'reviews-list__item-image-wrapper--logo';
                                            }
                                            if ($arParams['LOGO_CENTER']) {
                                                $imageClassList[] = 'reviews-list__item-image-wrapper--logo-center';
                                            }
                                            if (!$bImage) {
                                                $imageClassList[] = 'reviews-list__item-image--no-image';
                                            }
                                            if ($arParams['IMAGE_SIZE']) {
                                                $imageClassList[] = 'reviews-list__item-image-wrapper--image-'.$arParams['IMAGE_SIZE'];
                                            }
                                            ?>
                                            <div class="<?=TSolution\Utils::implodeClasses($imageClassList);?>">
                                                <?if ($bLogoImage):?>
                                                    <img alt="<?=$arItem['NAME']?>" title="<?=$arItem['NAME']?>" src="<?=$imageSrc?>" />
                                                <?else:?>
                                                    <div class="reviews-list__item-image" style="background-image: url(<?=$imageSrc?>);"></div>
                                                <?endif;?>
                                            </div>
                                        <?endif;?>

                                        <div class="reviews-list__item-info <?=$arParams['RATING_RIGHT'] ? 'reviews-list__item-info--centered-vertical' : ''?>">
                                            <div class="reviews-list__item-text">
                                                <?if ($arItem['DISPLAY_PROPERTIES']['POST']['VALUE'] || $arItem['DISPLAY_ACTIVE_FROM']) : ?>
                                                    <div class="reviews-list__item-company font_13 color_999">
                                                        <?= implode('<span class="reviews-list__separator">&mdash;</span>', array_filter([
                                                            $arItem['PROPERTIES']['POST']['VALUE'] ? '<span>' . $arItem['PROPERTIES']['POST']['VALUE'] . '</span>' : null,
                                                            $arItem['DISPLAY_ACTIVE_FROM'] ? '<span class="reviews-list__item-date-active ">' . $arItem['DISPLAY_ACTIVE_FROM'] . '</span>' : null
                                                        ])) ?>
                                                    </div>
                                                <?endif;?>
                                                <div class="reviews-list__item-title switcher-title <?=$arParams['NAME_LARGE'] ? ' font_22' : ' font_18'?>">
                                                    <?=$arItem['NAME'];?>
                                                </div>
                                            </div>

                                            <?if ($bShowRating && !$arParams['RATING_RIGHT']):?>
                                                <?$itemRating = $arItem['DISPLAY_PROPERTIES']['RATING']['VALUE'];?>
                                                <div class="rating reviews-list__rating">
                                                    <?for ($i = 0;$i < 5;$i++):?>
                                                        <div class="rating__star">
                                                            <?$svgClass = $i < $itemRating ? ' rating__star-svg rating__star-svg--filled' : ' rating__star-svg';?>
                                                            <?=TSolution::showIconSvg($svgClass, SITE_TEMPLATE_PATH.'/images/svg/rating_star_20.svg');?>
                                                        </div>
                                                    <?endfor;?>
                                                </div>
                                            <?endif;?>
                                        </div>
                                    </div>

                                    <?if ($bShowRating && $arParams['RATING_RIGHT']):?>
                                        <?$itemRating = $arItem['DISPLAY_PROPERTIES']['RATING']['VALUE'];?>
                                        <div class="rating reviews-list__rating">
                                            <?for ($i = 0;$i < 5;$i++):?>
                                                <div class="rating__star">
                                                    <?$svgClass = $i < $itemRating ? ' rating__star-svg rating__star-svg--filled' : ' rating__star-svg';?>
                                                    <?=TSolution::showIconSvg($svgClass, SITE_TEMPLATE_PATH.'/images/svg/rating_star_20.svg');?>
                                                </div>
                                            <?endfor;?>
                                        </div>
                                    <?endif;?>
                                </div>

                                <?if (strlen($arItem['FIELDS']['PREVIEW_TEXT'])):?>
                                    <div class="reviews-list__item-preview-wrapper">
                                        <div class="reviews-list__item-preview font_15 font_large">
                                            <?if ($arItem['PREVIEW_TEXT_TYPE'] == 'text'):?>
                                                <p><?=$arItem['FIELDS']['PREVIEW_TEXT'];?></p>
                                            <?else:?>
                                                <?=$arItem['FIELDS']['PREVIEW_TEXT'];?>
                                            <?endif;?>
                                        </div>
                                        <?if (strlen($arParams['PREVIEW_TRUNCATE_LEN']) && strlen($arItem['~PREVIEW_TEXT']) > $arParams['PREVIEW_TRUNCATE_LEN']):?>
                                            <div class="reviews-list__item-more">
                                                <button type="button"
                                                    class="btn btn-default bg-theme-target <?=$arParams['MORE_BTN_CLASS'] ?: ''?> btn-transparent-border animate-load"
                                                    data-event="jqm"
                                                    data-param-id="<?=$arItem['ID'];?>"
                                                    data-param-type="review"
                                                    data-name="review"
                                                ><?=Loc::getMessage('MORE');?></button>
                                            </div>
                                        <?endif;?>
                                    </div>
                                <?endif;?>
                            </div>
                        </div>
                    <?endforeach;?>
                </div>
            </div>

            <?if ($arOptions['countSlides'] > 1):?>
                <?TSolution\Functions::showBlockHtml([
                    'FILE' => 'ui/slider-pagination.php',
                    'PARAMS' => [
                        'CLASSES' => 'swiper-pagination--small line-block--justify-center static mt mt--20 slider-pagination--visible-600',
                    ]
                ]);?>

                <?TSolution\Functions::showBlockHtml([
                    'FILE' => 'ui/slider-navigation.php',
                    'PARAMS' => [
                        'CLASSES' => 'slider-nav--shadow slider-nav--center hide-600',
                    ],
                ]);?>
            <?endif;?>
        </div>
    </div>
</div>

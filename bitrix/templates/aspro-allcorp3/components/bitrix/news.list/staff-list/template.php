<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Web\Json;

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
$bHaveMore = count($arResult['ITEMS']) > $arParams['ELEMENT_IN_ROW'];

$arParams['SHOW_NEXT'] = $arParams['SHOW_NEXT'] && $bHaveMore;

$blockClassList = ['staff-list overflow-block'];
if (!$arParams['ITEMS_OFFSET']) {
    $blockClassList[] = 'staff-list--items-close';
}
if ($arParams['ITEMS_OFFSET']) {
    $blockClassList[] = 'staff-list--items-offset';
}

$itemClassList = ['grid-list__item staff-list__item swiper-slide swiper-slide--height-auto'];
if ($arParams['BORDER']) {
    $itemClassList[] = 'bordered';
}
if (!$arParams['ITEMS_OFFSET'] && ($arParams['ELEMENT_IN_ROW'] > 1 || $arParams['SHOW_NEXT'])) {
    $itemClassList[] = 'staff-list__item--no-radius';
}
if ($arParams['TEXT_POSITION'] == 'BOTTOM' || $arParams['TEXT_POSITION'] == 'BOTTOM_RELATIVE') {
    $itemClassList[] = 'staff-list__item--scroll-text-hover';
}
if ($arParams['TEXT_POSITION'] == 'BOTTOM') {
    $itemClassList[] = 'staff-list__item--dark-text-hover';
}
if ($arParams['ITEM_HOVER_SHADOW']) {
    $itemClassList[] = 'staff-list__item--shadow';
}
if ($arParams['ITEM_ROW']) {
    $itemClassList[] = 'staff-list__item--row';
}
if ($arParams['ITEM_ROW_REVERSE']) {
    $itemClassList[] = 'staff-list__item--row-reverse';
}
if ($arParams['ITEM_FLEX']) {
    $itemClassList[] = 'staff-list__item--flex';
}

$bottomClass = '';
if ($arParams['TYPE_VIEW'] === 'VIEW1' || $arParams['TYPE_VIEW'] === 'DETAIL') {
    $templateData['VIEW_TYPE'] = 'type_1';

    $blockClassList[] = 'staff-list--view1';
    $itemClassList[] = 'staff-list__item--scroll-text-hover';
}

if ($arParams['TYPE_VIEW'] === 'VIEW2') {
    $templateData['VIEW_TYPE'] = 'type_2';

    $blockClassList[] = 'staff-list--view2';
}

if ($arParams['TYPE_VIEW'] === 'VIEW3') {
    $templateData['VIEW_TYPE'] = 'type_3';

    $blockClassList[] = 'staff-list--view3';
    $bottomClass = ' btn btn-default btn--white-space-normal btn-transparent-border animate-load has-ripple';
}

if ($arParams['TYPE_VIEW'] === 'VIEW4') {
    $templateData['VIEW_TYPE'] = 'type_4';

    $blockClassList[] = 'staff-list--view4';
    $itemClassList[] = 'staff-list__item--scroll-text-hover';
}

if ($arParams['ITEMS_OFFSET'] || (!$arParams['ITEMS_OFFSET'] && $arParams['NARROW'])) {
    $blockClassList[] = 'slide-nav-offset';
}

$sliderClassList = ['swiper slider-solution mobile-offset appear-block slider-item-width-260-to-600 swipeignore mobile-offset--right'];
$sliderClassList[] = 'slider-solution-items-by-'.$arParams['ELEMENT_IN_ROW'];

if (!$arParams['ITEMS_OFFSET']) {
    $sliderClassList[] = 'slider-solution--no-gap';
}

if ($arParams['SHOW_NEXT']) {
    $sliderClassList[] = 'overflow-visible';
}

$maxwidthClasses = [];
if ($arParams['TYPE_VIEW'] !== 'DETAIL') {
    if ($arParams['NARROW']) {
        $maxwidthClasses[] = 'maxwidth-theme';
    } else if ($arParams['ITEMS_OFFSET']) {
        $maxwidthClasses[] = 'maxwidth-theme maxwidth-theme--no-maxwidth';
    }
}
?>

<div class="<?=TSolution\Utils::implodeClasses($blockClassList);?>">
    <?=TSolution\Functions::showTitleBlock([
        'PATH' => 'staff-list',
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
                'watchSlidesProgress' => true,
                'slidesPerView' => 'auto',
                'type' => 'main_staff',
                'spaceBetween' => ($arParams['ITEMS_OFFSET'] ? '32' : '0'),
                'freeMode' => [
                    'enabled' => true,
                    'momentum' => true,
                    // 'sticky' => true,
                ],
                'breakpoints' => [
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
                ],
            ];

            $counter = 0;
            ?>
            <div id="carousel_staff" class="<?=TSolution\Utils::implodeClasses($sliderClassList);?>" data-plugin-options='<?=Json::encode($arOptions);?>'>
                <div class="swiper-wrapper">
                    <?foreach ($arResult['ITEMS'] as $i => $arItem):?>
                        <?
                        // edit/add/delete buttons for edit mode
                        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
                        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                        // preview image
                        $bImage = (isset($arItem['FIELDS']['PREVIEW_PICTURE']) && $arItem['PREVIEW_PICTURE']['SRC']);
                        $nImageID = ($bImage ? (is_array($arItem['FIELDS']['PREVIEW_PICTURE']) ? $arItem['FIELDS']['PREVIEW_PICTURE']['ID'] : $arItem['FIELDS']['PREVIEW_PICTURE']) : "");
                        $imageSrc = ($bImage ? CFile::getPath($nImageID) : SITE_TEMPLATE_PATH.'/images/svg/noimage_staff.svg');

                        $counter++;

                        $currentItemClassList = $itemClassList;
                        if ($counter === $arOptions['countSlides']) {
                            $currentItemClassList[] = 'staff-list__item--last';
                        }
                        if ($counter === 1) {
                            $currentItemClassList[] = 'staff-list__item--first';
                        }
                        ?>
                        <div class="<?=TSolution\Utils::implodeClasses($currentItemClassList);?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                            <?if ($imageSrc):?>
                                <div class="staff-list__item-image-wrapper">
                                    <div class="staff-list__item-image" style="background-image: url(<?=$imageSrc?>);"></div>
                                    <a class="staff-list__item-link" href="<?=$arItem['DETAIL_PAGE_URL'];?>"></a>

                                    <?if ($arParams['TYPE_VIEW'] === 'VIEW2'):?>
                                        <?if ($arItem['PROPERTIES']['SEND_MESS']['VALUE_XML_ID'] == 'Y'):?>
                                            <div class="staff-list__item-button--on-image line-block line-block--gap line-block--justify-center">
                                                <button type="button"
                                                    class=" btn btn-default btn--white-space-normal <?=$arParams['BUTTON_SIZE'] ? $arParams['BUTTON_SIZE'] : '';?> animate-load"
                                                    data-event="jqm"
                                                    data-name="staff"
                                                    data-autoload-staff="<?=TSolution::formatJsName($arItem['NAME']);?>"
                                                    data-autoload-staff_email_hidden="<?=TSolution::formatJsName($arItem['DISPLAY_PROPERTIES']['EMAIL']['VALUE']);?>"
                                                    data-param-id="<?=TSolution::getFormID("callstaff");?>"
                                                    >
                                                    <?=GetMessage('SEND_MESSAGE');?>
                                                </button>
                                            </div>
                                        <?endif;?>
                                    <?endif;?>
                                </div>
                            <?endif;?>

                            <?if (in_array($arParams['TYPE_VIEW'], ['VIEW1', 'DETAIL', 'VIEW4'])):?>
                                <div class="staff-list__item-additional-text-wrapper staff-list__item-additional-text-wrapper--<?=$arParams['ADDITIONAL_TEXT_POSITION'];?>">
                                    <?if ($arItem['DISPLAY_PROPERTIES']['POST']['VALUE']):?>
                                        <div class="staff-list__item-company font_13 <?=$arParams['ADDITIONAL_TEXT_COLOR'] == 'DARK' ? 'color_333 opacity_5' : 'color_light--opacity';?>">
                                            <?=($arItem['PROPERTIES']['POST']['VALUE'] = mb_strtoupper(mb_substr($arItem['PROPERTIES']['POST']['VALUE'], 0, 1)).mb_substr($arItem['PROPERTIES']['POST']['VALUE'], 1));?>
                                        </div>
                                    <?endif;?>
                                    <div class="staff-list__item-title switcher-title font_<?=$arParams['NAME_SIZE'];?> <?=$arParams['ADDITIONAL_TEXT_COLOR'] == 'DARK' ? 'color_333' : 'color_light';?>">
                                        <?=$arItem['NAME'];?>
                                    </div>
                                </div>
                            <?endif;?>

                            <div class="staff-list__item-text-wrapper">
                                <div class="staff-list__item-text-top-part">
                                    <?if ($arItem['DISPLAY_PROPERTIES']['POST']['VALUE']):?>
                                        <div class="staff-list__item-company font_13 color_333 opacity_5">
                                            <?=($arItem['PROPERTIES']['POST']['VALUE'] = mb_strtoupper(mb_substr($arItem['PROPERTIES']['POST']['VALUE'], 0, 1)).mb_substr($arItem['PROPERTIES']['POST']['VALUE'], 1));?>
                                        </div>
                                    <?endif;?>

                                    <a class="dark_link" href="<?=$arItem['DETAIL_PAGE_URL'];?>">
                                        <div class="staff-list__item-title switcher-title font_<?=$arParams['NAME_SIZE'];?>">
                                            <?=$arItem['NAME'];?>
                                        </div>
                                    </a>

                                    <?if (strlen($arItem['FIELDS']['PREVIEW_TEXT'])):?>
                                        <div class="staff-list__item-preview-wrapper">
                                            <div class="staff-list__item-preview font_<?=$arParams['PREVIEW_SIZE'] ? $arParams['PREVIEW_SIZE'] : '13';?> color_666">
                                                <?=$arItem['FIELDS']['PREVIEW_TEXT'];?>
                                            </div>
                                        </div>
                                    <?endif;?>

                                    <?
                                    $phone = $arItem['DISPLAY_PROPERTIES']['PHONE']['VALUE'];
                                    $phoneFormatted = $phone ? preg_replace('/[^\d]/', '', $phone) : '';

                                    $email = $arItem['DISPLAY_PROPERTIES']['EMAIL']['VALUE'];

                                    if ($phone || $email || $arItem['SOCIAL_INFO']):?>
                                        <div class="staff-list__info-wrapper">
                                            <?if ($phone || $email):?>
                                                <div class="staff-list__item-props">
                                                    <?if ($phone):?>
                                                        <div class="staff-list__item-prop">
                                                            <div class="staff-list__item-prop-title font_13 color_999">
                                                                <?=GetMessage('PHONE');?>
                                                            </div>
                                                            <a rel="nofollow" href="tel:+<?=$phoneFormatted?>"
                                                                class="staff-list__item-phone font_14 dark_link">
                                                                <?=$phone?>
                                                            </a>
                                                        </div>
                                                    <?endif;?>

                                                    <?if ($email):?>
                                                        <div class="staff-list__item-prop">
                                                            <div class="staff-list__item-prop-title font_13 color_999">
                                                                <?=GetMessage('EMAIL');?>
                                                            </div>
                                                            <a rel="nofollow" href="mailto:<?=$email?>"
                                                                class="staff-list__item-email font_14 dark_link">
                                                                <?=$email?>
                                                            </a>
                                                        </div>
                                                    <?endif;?>
                                                </div>
                                            <?endif;?>

                                            <?if ($arItem['SOCIAL_INFO']):?>
                                                <div class="staff-list__item-socials">
                                                    <?foreach ($arItem['SOCIAL_INFO'] as $arSoc):?>
                                                        <a class="staff-list__item-social fill-theme-hover"
                                                            rel="nofollow" href="<?=$arSoc['VALUE'];?>">
                                                            <?=TSolution::showIconSvg('', $arSoc['PATH']);?>
                                                        </a>
                                                    <?endforeach;?>
                                                </div>
                                            <?endif;?>
                                        </div>
                                    <?endif;?>
                                </div>

                                <div class="staff-list__item-text-bottom-part">
                                    <?if ($arItem['PROPERTIES']['SEND_MESS']['VALUE_XML_ID'] == 'Y'):?>
                                        <div class="staff-list__item-button">
                                            <button type="button"
                                                class="btn btn-default btn--white-space-normal animate-load<?=$bottomClass;?><?=$arParams['BUTTON_SIZE'] ? ' '.$arParams['BUTTON_SIZE'] : '';?>"
                                                data-event="jqm"
                                                data-name="staff"
                                                data-autoload-staff="<?=TSolution::formatJsName($arItem['NAME']);?>"
                                                data-autoload-staff_email_hidden="<?=TSolution::formatJsName($arItem['DISPLAY_PROPERTIES']['EMAIL']['VALUE']);?>"
                                                data-param-id="<?=TSolution::getFormID("callstaff");?>"
                                                >
                                                <?=GetMessage('SEND_MESSAGE');?>
                                            </button>
                                        </div>
                                    <?endif;?>
                                </div>
                            </div>
                        </div>
                    <?endforeach;?>
                </div>
            </div>

            <?if ($arOptions['countSlides'] > 1):?>
                <?TSolution\Functions::showBlockHtml([
                    'FILE' => 'ui/slider-pagination.php',
                    'PARAMS' => [
                        'CLASSES' => 'swiper-pagination--small line-block--justify-center static mt mt--20'.($arParams['TYPE_VIEW'] !== 'VIEW2' ? ' slider-pagination--visible-600' : ''),
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

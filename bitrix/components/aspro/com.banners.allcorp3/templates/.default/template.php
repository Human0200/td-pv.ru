<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

$this->setFrameMode(true);

if (empty($arResult['ITEMS']['TOP']['ITEMS'])) {
    return;
}

$currentBannerIndex = intval($arParams['CURRENT_BANNER_INDEX']) > 0 ? intval($arParams['CURRENT_BANNER_INDEX']) - 1 : 0;
$templateData = [
    'BANNERS_COUNT' => count($arResult['ITEMS']['TOP']['ITEMS']),
    'CURRENT_BANNER_INDEX' => $currentBannerIndex,
    'CURRENT_BANNER_COLOR' => '',
    'TEMPLATE_FOLDER' => $this->__folder,
];

$bannerMobile = $arParams['BIGBANNER_MOBILE'];
$bHideOnNarrow = $arParams['BIGBANNER_HIDEONNARROW'] === 'Y';
$slideshowSpeed = abs(intval($arParams['BIGBANNER_SLIDESSHOWSPEED']));
$animationSpeed = abs(intval($arParams['BIGBANNER_ANIMATIONSPEED']));
$bAnimation = $slideshowSpeed && strlen($arParams['BIGBANNER_ANIMATIONTYPE']);
$bOneSlide = count($arResult['ITEMS']['TOP']['ITEMS']) == 1;
if ($arParams['BIGBANNER_ANIMATIONTYPE'] === 'FADE') {
    $animationType = 'fade';
} else {
    $animationType = 'slide';
    $animationDirection = 'horizontal';
    if ($arParams['BIGBANNER_ANIMATIONTYPE'] === 'SLIDE_VERTICAL') {
        $animationDirection = 'vertical';
    }
}

$bBgImage = !$arParams['IMG_POSITION'] || $arParams['IMG_POSITION'] == 'COVER';
$bWideText = $arParams['WIDE_TEXT'];
$sliderItems = $arParams['SLIDER_ITEMS'] ? (int) $arParams['SLIDER_ITEMS'] : 1;
$bSmallPreview = $sliderItems > 1 || $arResult['HAS_CHILD_BANNERS'];

$bLowBanner = $arParams['HEIGHT_BANNER'] === 'LOW';
$bNormalBanner = $arParams['HEIGHT_BANNER'] === 'NORMAL';
$bHighBanner = !$bLowBanner && !$bNormalBanner;

$titleSizeClass = 'banners-big__title--small';
if (
    $bWideText
    && $bHighBanner
) {
    $titleSizeClass = 'banners-big__title--large';
} elseif (
    $bHighBanner
    || $bWideText
) {
    $titleSizeClass = 'banners-big__title--middle';
    $textClass = ' banners-big__text-block--margin-top-more';
}

if ($sliderItems > 1) {
    if ($bHighBanner) {
        $titleSizeClass = 'banners-big__title--xs';
    } else {
        $titleSizeClass = 'banners-big__title--xxs';
    }
}

$bannerClasses = ' swipeignore';
if ($bHighBanner) {
    $bannerClasses .= ' banners-big--high';
} else {
    $bannerClasses .= ' banners-big--nothigh';

    if ($bNormalBanner) {
        $bannerClasses .= ' banners-big--normal';
    } else {
        $bannerClasses .= ' banners-big--low';
    }
}
if ($arParams['NARROW_BANNER']) {
    $bannerClasses .= ' banners-big--narrow';
}
if ($sliderItems > 1) {
    $bannerClasses .= ' banners-big--multi-slide';
}
if (!$arParams['NO_OFFSET_BANNER']) {
    $bannerClasses .= ' banners-big--paddings-32';
}
if ($arResult['HAS_CHILD_BANNERS']) {
    $bannerClasses .= ' banners-big--side-banners';
}
if ($sliderItems < 2) {
    $bannerClasses .= ' banners-big--adaptive-'.$bannerMobile;
    if ($bannerMobile != 1) {
        $bannerClasses .= ' banners-big--contrast-cover-desktop';
    }
} else {
    $bannerClasses .= ' banners-big--adaptive-1';
}
if ($arParams['IMG_POSITION'] == 'SQUARE') {
    $bannerClasses .= ' banners-big--img-square';
}

$sliderWrapperClassList = ['swiper-wrapper main-slider__wrapper'];
$carouselClasses = 'banners-big__depend-height';

if (!$arParams['HEADER_OPACITY']) {
    $bannerClasses .= ' banners-no-header-opacity';
} else {
    $carouselClasses .= ' banners-big__depend-padding';
}

if ($sliderItems > 1 && !$arParams['NO_OFFSET_BANNER']) {
    $carouselClasses .= ' slide-nav-offset';
}

$bShowH1 = false;

$arOptions = [
    // Disable preloading of all images
    'preloadImages' => false,
    'keyboard' => true,
    'init' => false,
    'countSlides' => count($arResult['ITEMS'][$arParams['BANNER_TYPE_THEME']]['ITEMS']),
    'type' => 'main_banner',
];
if ($arOptions['countSlides'] > 10) {
    $arOptions['pagination']['dynamicBullets'] = true;
    $arOptions['pagination']['dynamicMainBullets'] = 3;
}
if ($arOptions['countSlides'] > 1) {
    $arOptions['loop'] = true;
}
if ($sliderItems > 1) {
    $arOptions['slidesPerView'] = 'auto';
    $arOptions['breakpoints'] = [
        '768' => [
            'slidesPerView' => ($sliderItems - 1),
        ],
        '992' => [
            'slidesPerView' => $sliderItems,
        ],
    ];
    $arOptions['pagination'] = [
        'bulletActiveClass' => 'pagination-bullet-active',
    ];
}
?>
<div class="banners-big front<?=($bHideOnNarrow ? ' hidden_narrow' : '')?> <?=$bannerClasses?>">
    <div class="maxwidth-banner <?=$arParams['NARROW_BANNER'] ? 'maxwidth-theme' : ''?>">
        <div class="banners-big__wrapper">
            <div class="slider-solution swiper swiper-container main-slider slider-solution-items-by-<?=$sliderItems;?> <?=$carouselClasses?>"  data-plugin-options='<?=json_encode($arOptions)?>'>
                <div class="<?=TSolution\Utils::implodeClasses($sliderWrapperClassList);?>">
                <?foreach ($arResult['ITEMS']['TOP']['ITEMS'] as $i => $arItem):?>
                    <?
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), ['CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);

                    $bHasUrl = boolval(strlen($arItem['PROPERTIES']['LINKIMG']['VALUE']));
                    $target = $arItem['PROPERTIES']['TARGETS']['VALUE_XML_ID'];

                    $imageBgSrc = $this->GetFolder().'/images/background.jpg';

                    if (is_array($arItem['DETAIL_PICTURE'])) {
                        $imageBgSrc = $arItem['DETAIL_PICTURE']['SRC'];
                    }
                    if (!$bHighBanner && $arItem['PROPERTIES']['NORMAL_BG_IMAGE']['VALUE']) {
                        $imageBgSrc = CFile::GetPath($arItem['PROPERTIES']['NORMAL_BG_IMAGE']['VALUE']);
                    }
                    if ($bLowBanner && $arItem['PROPERTIES']['LOW_BG_IMAGE']['VALUE']) {
                        $imageBgSrc = CFile::GetPath($arItem['PROPERTIES']['LOW_BG_IMAGE']['VALUE']);
                    }

                    $type = $arItem['PROPERTIES']['BANNERTYPE']['VALUE_XML_ID'];
                    $bOnlyImage = $type == 'T1' || !$type;
                    $bLinkOnName = strlen($arItem['PROPERTIES']['LINKIMG']['VALUE']);
                    $bOpacity = $arItem['PROPERTIES']['BANNER_OPACITY']['VALUE_XML_ID'] == 'Y';
                    $bCenterText = $arItem['PROPERTIES']['TEXT_CENTER']['VALUE_XML_ID'] == 'Y';

                    if ($sliderItems < 2) {
                        include 'video.php';
                    }

                    $bannerColor = $arItem['PROPERTIES']['MAIN_COLOR']['VALUE'] ? $arItem['PROPERTIES']['MAIN_COLOR']['VALUE_XML_ID'] : '';

                    $bannerItemClasses = ['banners-big__item banners-big__depend-height'];
                    if ($bShowVideo) {
                        $bannerItemClasses[] = 'vvideo';
                    }
                    if ($bannerColor) {
                        if ($arParams['IMG_POSITION'] == 'SQUARE') {
                            $bannerItemClasses[] = 'banners-big__item--'.$bannerColor.'-767';
                            $bannerItemClasses[] = 'banners-big__item--video-half';
                        } else {
                            $bannerItemClasses[] = 'banners-big__item--'.$bannerColor;
                        }
                    }
                    if ($sliderItems > 1) {
                        $bannerItemClasses[] = 'banners-big__item--opacity-bottom';
                        $bannerItemClasses[] = 'banners-big__item--light';
                        $bannerItemClasses[] = 'content-row-hidden-hover overflow-block';
                    } elseif ($bOpacity) {
                        if ($arParams['IMG_POSITION'] == 'SQUARE') {
                            $bannerItemClasses[] = 'banners-big__item--opacity-767';
                        } else {
                            $bannerItemClasses[] = 'banners-big__item--opacity';
                        }
                    }
                    if ($bHasUrl) {
                        $bannerItemClasses[] = 'wurl';
                    }
                    if ($arParams['HEADER_OPACITY']) {
                        $bannerItemClasses[] = 'banners-big__depend-padding';
                    }
                    if ($bOnlyImage && $bShowVideo) {
                        $bannerItemClasses[] = 'banners-big__item--img-with-video';
                    }

                    $bannerInnerClasses = '';
                    if ($arParams['INNER_PADDING_NARROW'] && $arParams['NARROW_BANNER']) {
                        $bannerInnerClasses .= ' banners-big__inner--padding-left-narrow';
                    }
                    if ($type == 'T3') {
                        $bannerInnerClasses .= ' banners-big__inner--righttext';
                    }
                    if ($arParams['IMG_POSITION'] == 'SQUARE') {
                        $bannerInnerClasses .= 'banners-big__inner--paddings-24-767';
                    }

                    // first visible slide is the first item or $currentBannerIndex
                    // saving his color for to usage in component_epilog
                    $dataSrc = '';
                    if (
                        $bannerColor
                        && (
                            $i == $currentBannerIndex
                            || !$i
                        )
                    ) {
                        $templateData['CURRENT_BANNER_COLOR'] = $bannerColor;
                        $dataSrc = 'data-src=""';
                    }

                    if (
                        $sliderItems > 1
                        && in_array($i, range($currentBannerIndex, $currentBannerIndex + $sliderItems - 1))
                    ) {
                        $dataSrc = 'data-src=""';
                    }
                    ?>
                    <?$needShowBG = $arParams['IMG_POSITION'] == 'SQUARE' && $bOnlyImage;?>
                    <div class="grid-list__item swiper-slide main-slider__item box <?=($bShowVideo ? 'vvideo' : '');?>"
                        <?=$bBgImage || $needShowBG ? 'style="background-image:url('.$imageBgSrc .') !important;"' : ''?>
                        data-slide_index="<?=$i?>"
                        <?=($bannerColor ? ' data-color="'.$bannerColor.'"' : '')?>
                        <?=$videoInfoItem?>
                        data-background="<?=$imageBgSrc;?>"
                        <?=$dataSrc?>
                    >
                        <div class="<?=TSolution\Utils::implodeClasses($bannerItemClasses);?>">
                            <?if ($bHasUrl):?>
                                <a class="target" href="<?=$arItem["PROPERTIES"]["LINKIMG"]["VALUE"]?>" <?=(strlen($target) ? 'target="'.$target.'"' : '')?>></a>
                            <?endif;?>
                            <div id="<?=$this->GetEditAreaId($arItem['ID'])?>"
                                class="<?=$arParams['NO_MAXWITH_THEME_WIDE'] ? '' : 'maxwidth-theme'?> pos-static <?=($bOnlyImage && $bLinkOnName ? ' fulla' : '')?> <?=($bVideoAutoStart ? 'loading' : '');?>"
                                <?=$bannerMobile == 2 && ($bBgImage || $needShowBG) ? 'style="background-image:url('.$imageBgSrc .')"' : ''?>
                                <?=$dataSrc?>
                            >
                                <div class="banners-big__inner <?=$bannerInnerClasses?>">
                                    <?$name = ($arItem['DETAIL_TEXT'] ? $arItem['DETAIL_TEXT'] : strip_tags($arItem["~NAME"], "<br><br/>"));?>
                                    <?ob_start();?>
                                    <?if (!$bOnlyImage):?>
                                        <?if ($arItem['PROPERTIES']['TOP_TEXT']['VALUE']):?>
                                            <div class="banners-big__top-text <?=$bSmallPreview ? 'banners-big__top-text--small' : ''?>"><?=$arItem['PROPERTIES']['TOP_TEXT']['VALUE']?></div>
                                        <?endif;?>

                                        <?if ($bLinkOnName):?>
                                            <a href="<?=$arItem['PROPERTIES']['LINKIMG']['VALUE']?>" class="banners-big__title-link">
                                        <?endif;?>

                                            <?if ($arItem['PROPERTIES']['TITLE_H1']['VALUE_XML_ID'] == 'Y' && !$bShowH1):?>
                                                <?$bShowH1 = true;?>
                                                <h1 class="banners-big__title switcher-title <?=$titleSizeClass?>"><?=$name?></h1>
                                            <?else:?>
                                                <div class="banners-big__title switcher-title <?=$titleSizeClass?>"><?=$name?></div>
                                            <?endif;?>

                                        <?if ($bLinkOnName):?>
                                            </a>
                                        <?endif;?>

                                        <?if ($sliderItems > 1):?>
                                        <div class="banner-big__text-wrapper-scrollblock content-row-hidden overflow-block">
                                            <div class="min-height-0">
                                        <?endif;?>

                                                <div class="banners-big__text-wrapper <?=$bWideText && !$bCenterText && $type !== "T3" ? 'banners-big__text-wrapper--row' : ''?>">
                                                    <?if (strlen($arItem['PREVIEW_TEXT'])):?>
                                                        <div class="banners-big__text-block <?=$bSmallPreview ? 'banners-big__text-block--small' : ''?> <?=$textClass?>">
                                                            <?=$arItem['PREVIEW_TEXT']?>
                                                        </div>
                                                    <?endif;?>

                                                    <?if ($sliderItems < 2) {
                                                        include('tizers.php');
                                                    }?>
                                                </div>

                                                <?include('buttons.php');?>

                                        <?if ($sliderItems > 1):?>
                                            </div>
                                        </div>
                                        <?endif;?>
                                    <?endif;?>
                                    <?$text = ob_get_clean();?>

                                    <?ob_start();?>
                                        <?
                                        $image = false;
                                        if (array_key_exists('SRC', (array)$arItem['PREVIEW_PICTURE']) ) {
                                            $image = $arItem['PREVIEW_PICTURE'];
                                        }
                                        if (!$bHighBanner && $arItem['PROPERTIES']['NORMAL_BANNER_IMAGE']['VALUE']) {
                                            $image = CFile::GetFileArray($arItem['PROPERTIES']['NORMAL_BANNER_IMAGE']['VALUE']);
                                        }
                                        if ($bLowBanner && $arItem['PROPERTIES']['LOW_BANNER_IMAGE']['VALUE']) {
                                            $image = CFile::GetFileArray($arItem['PROPERTIES']['LOW_BANNER_IMAGE']['VALUE']);
                                        }
                                        ?>
                                        <?if ($image):?>
                                            <?$arImage1080 = CFile::ResizeImageGet($image['ID'], ['width' => 1080, 'height' => 10000], BX_RESIZE_IMAGE_PROPORTIONAL_ALT);?>
                                            <?if ($bLinkOnName):?>
                                                <a href="<?=$arItem['PROPERTIES']['LINKIMG']['VALUE']?>" class="image">
                                            <?endif;?>
                                                    <img class="plaxy banners-big__img <?=$arParams['IMG_POSITION'] == 'SQUARE' ? 'banners-big__img--center' : ''?>"
                                                        src="<?= $arImage1080['src']; ?>"
                                                        <?=$dataSrc?>
                                                        alt="<?=($image['ALT'] ?: $arItem['NAME'])?>"
                                                        title="<?=($image['TITLE'] ?: $arItem['NAME'])?>"
                                                    >
                                            <?if ($bLinkOnName):?>
                                                </a>
                                            <?endif;?>

                                        <?endif;?>
                                    <?$img = ob_get_clean();?>

                                    <?if (!$bOnlyImage):?>
                                        <div class="banners-big__text scrollbar <?=$bWideText && $type !== "T3" ?  'banners-big__text--wide' : ''?> <?=$bCenterText ? 'banners-big__text--center' : ''?> <?=$sliderItems > 1 ? 'banners-big__text--bottom' : 'banners-big__depend-height'?> <?=$arParams['TEXT_PADDING_RIGHT'] ? 'banners-big__text--padding-right' : ''?> <?=$arParams['TEXT_PADDING_LEFT_WIDE'] && !$arParams['NARROW_BANNER'] ? ' banners-big__text--padding-left-wide' : ''?> <?=$arParams['TEXT_PADDING_LEFT_NARROW'] && $arParams['NARROW_BANNER'] ? ' banners-big__text--padding-left-narrow' : ''?>">
                                            <?=$text?>
                                        </div>
                                        <?if ($image || $arParams['IMG_POSITION'] == 'SQUARE'):?>
                                            <?if ($i == $currentBannerIndex):?>
                                                <link href="<?=$imageBgSrc?>" rel="preload" as="image">
                                            <?endif;?>

                                            <div class="banners-big__img-wrapper banners-big__depend-height <?=$bWideText && $type !== "T3"  ? 'banners-big__img-wrapper--back-right' : ''?> <?=$sliderItems > 1 ? 'banners-big__img-wrapper--back-center' : ''?> <?=$arParams['IMG_POSITION'] == 'SQUARE' ? 'banners-big__img-wrapper--square' : ''?>" <?=$arParams['IMG_POSITION'] == 'SQUARE' ? 'style="background-image: url('.$imageBgSrc.');"' : ''?> <?=$dataSrc?>>
                                                <?=$image ? $img : ''?>
                                            </div>
                                        <?endif;?>
                                    <?elseif ($bOnlyImage && $bLinkOnName):?>
                                        <a href="<?=$arItem['PROPERTIES']['LINKIMG']['VALUE']?>"></a>
                                    <?elseif ($bOnlyImage):?>
                                        <?if ($bShowVideo):?>
                                            <div class="video_block only_img--video ">
                                                <span class="play btn-video bg-theme-after <?=($bVideoAutoStart ? 'loading' : '');?> <?=$buttonVideoClass;?>" title="<?=$buttonVideoText?>"></span>
                                            </div>
                                        <?endif;?>
                                    <?endif;?>
                                </div>

                            </div>
                            <?if ($sliderItems < 2):?>
                                <?if ($bannerMobile == 2):?>
                                    <?if (strlen($text)):?>
                                        <div class="banners-big__adaptive-block">
                                            <!--noindex-->
                                            <?=str_replace(['<h1', 'h1>'], ['<div', 'div>'], $text);?>
                                            <!--/noindex-->
                                        </div>
                                    <?endif;?>
                                <?elseif ($bannerMobile == 3):?>
                                    <?$tabletImgSrc = ($arItem["PROPERTIES"]['TABLET_IMAGE']['VALUE'] ? CFile::GetPath($arItem["PROPERTIES"]['TABLET_IMAGE']['VALUE']) : $background);?>
                                            <?if ($i == $currentBannerIndex):?>
                                                <link href="<?=$tabletImgSrc?>" rel="preload" as="image" media="(max-width: 767px)">
                                            <?endif;?>
                                        <div
                                            class="banners-big__adaptive-img"
                                            style="background-image:url(<?=$tabletImgSrc?>);"
                                            data-background="<?=$tabletImgSrc;?>"
                                            <?=$dataSrc?>
                                        ></div>
                                <?endif;?>
                            <?endif;?>
                        </div>
                    </div>

                    <?//from here?>
                <?endforeach;?>
                </div>
            </div>
            <?if ($arOptions['countSlides'] > 1):?>
                <?
                $navigationContainerClassList = ['navigation-wrapper', 'mb'];
                if ($arResult['HAS_CHILD_BANNERS']) {
                    $navigationContainerClassList[] = 'mb--32';
                } else {
                    $navigationContainerClassList[] = 'mb--56';
                    if ($arParams['NARROW_BANNER']) {
                        $navigationContainerClassList[] = 'mi mi--24';
                    }
                }

                $paginationClassList = [];
                $sliderNavigationClassList = ['hide-768'];
                $sliderNavigationWrapperClassList = [];

                if ($sliderItems === 1) {
                    $paginationClassList[] = 'slider-pagination--pull-right';
                    $sliderNavigationClassList[] = 'static';
                    $sliderNavigationWrapperClassList[] = 'navigation navigation--bottom-right hide-768';
                } else {
                    if (!$arParams['NO_OFFSET_BANNER']) {
                        $sliderNavigationClassList[] = 'slider-nav--shadow';
                    }
                    if ($arParams['ALL_WIDTH_BUTTONS']) {
                        $paginationClassList[] = 'slider-pagination--line mb mb--32 outer-rounded-x';
                    }
                }
                ?>
                <?if ($sliderItems === 1):?>
                <div class="navigation-container maxwidth-theme<?=$arParams['IMG_POSITION'] === 'SQUARE' ? ' maxwidth-theme--no-maxwidth' : '';?>">
                    <div class="navigation-outer height-100 relative">
                        <div class="<?=TSolution\Utils::implodeClasses($navigationContainerClassList)?>">
                <?endif;?>
                            <?TSolution\Functions::showBlockHtml([
                                'FILE' => 'ui/slider-pagination.php',
                                'PARAMS' => [
                                    'CLASSES' => TSolution\Utils::implodeClasses($paginationClassList),
                                ],
                            ]);?>

                            <?TSolution\Functions::showBlockHtml([
                                'FILE' => 'ui/slider-navigation.php',
                                'PARAMS' => [
                                    'CLASSES' => TSolution\Utils::implodeClasses($sliderNavigationClassList),
                                    'WRAPPER_CLASS' => TSolution\Utils::implodeClasses($sliderNavigationWrapperClassList),
                                ],
                            ]);?>
                <?if ($sliderItems === 1):?>
                        </div>
                    </div>
                </div>
                <?endif;?>
            <?endif;?>
        </div>

        <?if ($arResult['HAS_CHILD_BANNERS']):?>
            <?include('float_banners.php');?>
        <?endif;?>
    </div>
</div>

<?if ($bInitYoutubeJSApi):?>
    <script type="text/javascript">
    BX.ready(function(){
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    });
    </script>
<?endif;?>

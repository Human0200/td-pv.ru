<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

// define global template name for body class
global $bodyDopClass, $USER, $bigBannersIndexClass;
if (strpos($bigBannersIndexClass, 'hidden') === false && $templateData['BANNERS_COUNT']) {
    if ($arParams['HEADER_OPACITY']) {
        $bodyDopClass .= ' header_opacity';

        $arOptions = [
            'PREFER_COLOR' => $templateData['CURRENT_BANNER_COLOR'] ?: ($_COOKIE['prefers-color-scheme'] ?? ''),
        ];
        if ($logoPosition = $APPLICATION->GetPageProperty('LOGO_POSITION')) {
            $arOptions['LOGO_POSITION'] = $logoPosition;
        }

        TSolution::setLogoColor($arOptions);
    } elseif ($arParams['NO_OFFSET_BANNER'] && $arParams['NARROW_BANNER']) {
        $bodyDopClass .= ' header-no-border';
    }

    if ($templateData['CURRENT_BANNER_INDEX']) {
        $bannerIndexStyle = '<style>
        .main-slider:not(.swiper-initialized) .swiper-slide:not([data-slide_index="'.$templateData['CURRENT_BANNER_INDEX'].'"]) {
            display: none;
        }
        </style>';
        $APPLICATION->AddHeadString($bannerIndexStyle);
    }
}

// for subscribe button in banner
if (isset($templateData['IS_SUBSCRIBE']) && $templateData['IS_SUBSCRIBE']) {
    Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID('banners-subscribe-'.$arParams['IBLOCK_ID']);

    $arSubscription = [];
    $email = '';
    $subscrId = '';
    if (CModule::IncludeModule('subscribe')) {
        // get current user subscription from cookies
        $arSubscription = CSubscription::GetUserSubscription();
    }
    if ($arSubscription['ID']) {
        $email = $arSubscription['EMAIL'];
        $subscrId = $arSubscription['ID'];
    } elseif ($USER->IsAuthorized()) {
        $email = $USER->GetEmail();
    }
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            try {
                $('.banners-big .subscribe-edit__form input[name=EMAIL]').val('<?= $email; ?>');
                $('.banners-big .subscribe-edit__form input[name=ID]').val('<?= $subscrId; ?>');
                $('.banners-big .subscribe-edit__form input[name=sessid]').val('<?= bitrix_sessid(); ?>');
            } catch(e){}
        });
    </script>
    <?php
    Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID('banners-subscribe-'.$arParams['IBLOCK_ID'], '');
}

if ($arParams['SLIDER_ITEMS'] > 1) {
    $APPLICATION->oAsset->addCss($templateData['TEMPLATE_FOLDER'].'/assets/css/slider.css');
}

$arExtensions = ['swiper', 'swiper_main_styles', 'top_banner', 'grid_row_toggle'];
if ($templateData['HAS_VIDEO']) {
    $arExtensions[] = 'video_banner';
}
if ($arParams['HEADER_OPACITY'] && $templateData['BANNERS_COUNT']) {
    $arExtensions[] = 'header_opacity';
}
TSolution\Extensions::init($arExtensions);
?>

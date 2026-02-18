<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

$this->setFrameMode(true);

use Bitrix\Main\Localization\Loc;

?>
<?if ($arResult['ITEMS']):?>
    <?php
    $templateData['ITEMS'] = true;

    $bHasBottomPager = $arParams['DISPLAY_BOTTOM_PAGER'] == 'Y' && $arResult['NAV_STRING'];
    $bUseSchema = !(isset($arParams['NO_USE_SHCEMA_ORG']) && $arParams['NO_USE_SHCEMA_ORG'] == 'Y');
    $bAjax = $arParams['AJAX_REQUEST'] == 'Y';
    $bMobileScrolledItems = $arParams['MOBILE_SCROLLED'];
    $bMobileOneRow = $arParams['MOBILE_ONE_ROW'];
    $bCompactView = $arParams['PRICE_VIEW_COMPACT'] == 'Y';

    $bOrderViewBasket = $arParams['ORDER_VIEW'];
    $basketURL = (strlen(trim($arTheme['ORDER_VIEW']['DEPENDENT_PARAMS']['URL_BASKET_SECTION']['VALUE'])) ? trim($arTheme['ORDER_VIEW']['DEPENDENT_PARAMS']['URL_BASKET_SECTION']['VALUE']) : '');

    if ($bCompactView) {
        $arParams['SHOW_PROPS_TABLE'] = 'not';
    }

    $bHideProps = $arParams['SHOW_PROPS_TABLE'] == 'not';
    $bRowProps = $arParams['SHOW_PROPS_TABLE'] == 'rows';
    $bColProps = $arParams['SHOW_PROPS_TABLE'] == 'cols';

    $gridClass = ['grid-list grid-list--items-1'];

    if (!$bHideProps) {
        $gridClass[] = 'table-props-rows';
    }
    if ($bColProps && $arResult['SHOW_COLS_PROP']) {
        $gridClass[] = 'table-props-cols bordered rounded-4 scrollbar scroller';
    }

    if ($bMobileScrolledItems) {
        $gridClass[] = 'mobile-scrolled mobile-scrolled--items-2';

        if ($arParams['NARROW']) {
            $gridClass[] = 'mobile-offset';

            if (!$arParams['ITEMS_OFFSET']) {
                $gridClass[] = 'mobile-offset--right';
            }
        } elseif ($arParams['ITEMS_OFFSET']) {
            $gridClass[] = 'mobile-offset';
        }
    } elseif (!$bCompactView && !$bMobileOneRow) {
        $gridClass[] = 'grid-list--compact';
    }

    if (!$arParams['ITEMS_OFFSET']) {
        $gridClass[] = 'grid-list--no-gap';
    } elseif ($arParams['GRID_GAP']) {
        $gridClass[] = 'grid-list--gap-'.$arParams['GRID_GAP'];
    }

    $itemClass = ' bordered shadow-hovered shadow-hovered-f600 shadow-no-border-hovered side-icons-hover bg-theme-parent-hover border-theme-parent-hover js-popup-block';
    $itemClass .= ' rounded-4';

    $bBottomButtons = (isset($arParams['POSITION_BTNS']) && $arParams['POSITION_BTNS'] == '4');
    $bShowCompare = $arParams['DISPLAY_COMPARE'];

    $gridClass = TSolution\Utils::implodeClasses($gridClass);
    ?>
    <?$bOptBuy = ($arParams['OPT_BUY'] != 'N' && $bOrderViewBasket);?>
    <?if (!$bAjax):?>
    <div class="catalog-items <?=$templateName;?>_template <?=$arParams['IS_COMPACT_SLIDER'] ? 'compact-catalog-slider' : '';?>">
        <template class="props-template"><?TSolution\Product\Template::showPropView(['VIEW' => TSolution\Product\Template::VIEW_TABLE]);?></template>
        <div class="fast_view_params" data-params="<?=urlencode(serialize($arTransferParams));?>"></div>
        <?if ($arResult['SKU_CONFIG']):?><div class="js-sku-config" data-value='<?=str_replace('\'', '"', CUtil::PhpToJSObject($arResult['SKU_CONFIG'], false, true));?>'></div><?endif;?>
        <div class="catalog-table <?= $bColProps ? ' catalog-table--hidden' : '';?>" <?if ($bUseSchema):?>itemscope itemtype="http://schema.org/ItemList"<?endif;?> >
            <?if ($bOptBuy):?>
                <div class="product-info-headnote opt-buy bordered rounded-4">
                    <div class="line-block flexbox--justify-beetwen flex-1">
                        <div class="line-block__item">
                            <div class="form-checkbox">
                                <input type="checkbox" class="form-checkbox__input" id="check_all_item" name="check_all_item" value="Y">
                                <label for="check_all_item" class="form-checkbox__label form-checkbox__label--sm">
                                    <span>
                                        <?=Loc::getMessage('SELECT_ALL_ITEMS');?>
                                    </span>
                                    <span class="form-checkbox__box"></span>
                                </label>
                            </div>
                        </div>
                        <div class="line-block__item opt-buy__buttons">
                            <span class="opt_action btn btn-default btn-md btn-wide no-action" data-action="buy" data-iblock_id="<?=$arParams['IBLOCK_ID'];?>">
                                <span>
                                    <?=Bitrix\Main\Config\Option::get(VENDOR_MODULE_ID, 'EXPRESSION_ADDTOBASKET_BUTTON_DEFAULT', GetMessage('BUTTON_TO_CART'));?>
                                </span>
                            </span>
                            <?if ($bShowCompare):?>
                                    <div class="side-icons static side-icons--lg">
                                        <div class="opt_action side-icons__item side-icons__item--compare side-icons__item--fill bordered rounded-4 no-action color_999" data-action="compare" data-iblock_id="<?=$arParams['IBLOCK_ID'];?>">
                                            <?=TSolution::showSpriteIconSvg(SITE_TEMPLATE_PATH.'/images/svg/catalog/item_icons.svg#compare_small', 'compare', [
                                            'WIDTH' => 14,
                                            'HEIGHT' => 14,
                                        ]);?>
                                        </div>
                                    </div>
                            <?endif;?>
                        </div>
                    </div>
                </div>
            <?endif;?>
            <div id="table-scroller-wrapper" class="js_append ajax_load list <?=$gridClass;?>">
                <div id="table-scroller-wrapper__header" class="hide-600">

                    <?if ($arResult['SHOW_COLS_PROP'] && $bColProps):?>
                        <div class="product-info-head catalog-table__item bordered rounded-4 grey-bg hide-991">
                            <div class="flexbox flexbox--direction-row">
                                <?if ($bOptBuy):?>
                                    <div class="catalog-table__item-wrapper">
                                        <div class="form-checkbox">
                                            <label class="form-checkbox__label form-checkbox__label--no-text"></label>
                                        </div>
                                    </div>
                                <?endif;?>
                                <div class="catalog-table__item-wrapper"><div class="image-list"></div></div>
                                <div class="flex-1 flexbox flexbox--direction-row">
                                    <div class="catalog-table__info-top">
                                        <div class="catalog-table__item-wrapper">
                                            <div class="font_13 color_999"><?=Loc::getMessage('NAME_PRODUCT');?></div>
                                        </div>
                                    </div>
                                    <?foreach ($arResult['COLS_PROP'] as $arProp):?>
                                        <div class="catalog-table__item-wrapper props hide-991">
                                            <div class="font_13 color_999 font_short"><?=$arProp['NAME'];?></div>
                                        </div>
                                    <?endforeach;?>
                                    <div class="catalog-table__info-bottom">
                                        <div class="catalog-table__item-wrapper">
                                            <div class="font_13 color_999"><?=Loc::getMessage('PRICE_PRODUCT');?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?endif;?>
                </div>
    <?endif;?>
        <?foreach ($arResult['ITEMS'] as $arItem):?>
            <?php
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE'), ['CONFIRM' => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')]);

            $item_id = $arItem['ID'];

            if (isset($arParams['ID_FOR_TABS']) && $arParams['ID_FOR_TABS'] == 'Y') {
                $arItem['strMainID'] = $this->GetEditAreaId($arItem['ID']).'_'.$arParams['FILTER_HIT_PROP'];
            } else {
                $arItem['strMainID'] = $this->GetEditAreaId($arItem['ID']);
            }

            $dataItem = ($bOrderViewBasket ? TSolution::getDataItem($arItem) : false);

            $article = $arItem['DISPLAY_PROPERTIES']['ARTICLE']['VALUE'];
            $status = $arItem['DISPLAY_PROPERTIES']['STATUS']['VALUE'];
            $statusCode = $arItem['DISPLAY_PROPERTIES']['STATUS']['VALUE_XML_ID'];
            $bShowDetailLink = (!strlen($arItem['DETAIL_TEXT']) ? !$arResult['HIDE_LINK_WHEN_NO_DETAIL'] : true);

            /* sku replace start */
            $arCurrentOffer = $arItem['SKU']['CURRENT'];

            if ($arCurrentOffer) {
                $arItem['PARENT_IMG'] = '';
                if ($arItem['PREVIEW_PICTURE']) {
                    $arItem['PARENT_IMG'] = $arItem['PREVIEW_PICTURE'];
                } elseif ($arItem['DETAIL_PICTURE']) {
                    $arItem['PARENT_IMG'] = $arItem['DETAIL_PICTURE'];
                }

                $oid = Bitrix\Main\Config\Option::get(VENDOR_MODULE_ID, 'CATALOG_OID', 'oid');
                if ($oid) {
                    $arItem['DETAIL_PAGE_URL'] .= '?'.$oid.'='.$arCurrentOffer['ID'];
                    $arCurrentOffer['DETAIL_PAGE_URL'] = $arItem['DETAIL_PAGE_URL'];
                }

                if ($arParams['SHOW_GALLERY'] === 'Y') {
                    $pictureID = $arCurrentOffer['PREVIEW_PICTURE'] ?? $arCurrentOffer['DETAIL_PICTURE'];
                    if ($pictureID) {
                        $arPicture = CFile::GetFileArray($pictureID);

                        $alt = $arParams['CHANGE_TITLE_ITEM_LIST'] === 'Y' ? $arCurrentOffer['NAME'] : $arItem['NAME'];
                        $title = $arParams['CHANGE_TITLE_ITEM_LIST'] === 'Y' ? $arCurrentOffer['NAME'] : $arItem['NAME'];
                        if ($arResult['ALT_TITLE_GET'] == 'SEO') {
                            $alt = $arPicture['ALT'] ?: $alt;
                            $title = $arPicture['TITLE'] ?: $title;
                        } else {
                            $alt = $arPicture['DESCRIPTION'] ?: $arPicture['ALT'] ?: $alt;
                            $title = $arPicture['DESCRIPTION'] ?: $arPicture['TITLE'] ?: $title;
                        }

                        $arPicture['TITLE'] = $title;
                        $arPicture['ALT'] = $alt;

                        array_unshift($arItem['GALLERY'], $arPicture);
                        array_splice($arItem['GALLERY'], $arParams['MAX_GALLERY_ITEMS']);
                    }
                } else {
                    if ($arCurrentOffer['PREVIEW_PICTURE'] || $arCurrentOffer['DETAIL_PICTURE']) {
                        if ($arCurrentOffer['PREVIEW_PICTURE']) {
                            $arItem['PREVIEW_PICTURE'] = $arCurrentOffer['PREVIEW_PICTURE'];
                        } elseif ($arCurrentOffer['DETAIL_PICTURE']) {
                            $arItem['PREVIEW_PICTURE'] = $arCurrentOffer['DETAIL_PICTURE'];
                        }
                    }
                    if (!$arCurrentOffer['PREVIEW_PICTURE'] && !$arCurrentOffer['DETAIL_PICTURE']) {
                        if ($arItem['PREVIEW_PICTURE']) {
                            $arCurrentOffer['PREVIEW_PICTURE'] = $arItem['PREVIEW_PICTURE'];
                        } elseif ($arItem['DETAIL_PICTURE']) {
                            $arCurrentOffer['PREVIEW_PICTURE'] = $arItem['DETAIL_PICTURE'];
                        }
                    }
                }

                if ($arCurrentOffer['DISPLAY_PROPERTIES']['ARTICLE']['VALUE']) {
                    $article = $arCurrentOffer['DISPLAY_PROPERTIES']['ARTICLE']['VALUE'];
                }
                if ($arCurrentOffer['DISPLAY_PROPERTIES']['STATUS']['VALUE']) {
                    $status = $arCurrentOffer['DISPLAY_PROPERTIES']['STATUS']['VALUE'];
                    $statusCode = $arCurrentOffer['DISPLAY_PROPERTIES']['STATUS']['VALUE_XML_ID'];
                }

                $arItem['DISPLAY_PROPERTIES']['FORM_ORDER'] = $arCurrentOffer['DISPLAY_PROPERTIES']['FORM_ORDER'];
                $arItem['DISPLAY_PROPERTIES']['PRICE'] = $arCurrentOffer['DISPLAY_PROPERTIES']['PRICE'];
                $arItem['NAME'] = $arCurrentOffer['NAME'];

                $arItem['OFFER_PROP'] = TSolution::PrepareItemProps($arCurrentOffer['DISPLAY_PROPERTIES']);

                $dataItem = ($bOrderViewBasket ? TSolution::getDataItem($arCurrentOffer) : false);

                if ($arParams['CHANGE_TITLE_ITEM_LIST'] === 'Y') {
                    $arItem['NAME'] = $arCurrentOffer['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] ?? $arCurrentOffer['NAME'];
                    $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] = $arItem['NAME'];
                }
            }

            $elementName = ((isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arItem['NAME']);

            $bOrderButton = ($arItem['DISPLAY_PROPERTIES']['FORM_ORDER']['VALUE_XML_ID'] == 'YES');
            /* sku replace end */
            ?>

            <div class="catalog-table__wrapper grid-list__item grid-list-border-outer">
                <div class="catalog-table__item <?=$itemClass;?>" id="<?=$arItem['strMainID'];?>">
                    <div class="catalog-table__inner flexbox flexbox--direction-row height-100" <?if ($bUseSchema):?>itemprop="itemListElement" itemscope="" itemtype="http://schema.org/Product"<?endif;?>>
                        <?if ($bUseSchema):?>
                            <?/* <meta itemprop="position" content="<?=(++$positionProduct)?>" /> */?>
                            <meta itemprop="description" content="<?=htmlspecialcharsbx(strip_tags($arItem['PREVIEW_TEXT'] ?: $arItem['NAME']));?>" />
                        <?endif;?>

                        <?if ($bOptBuy):?>
                            <div class="catalog-table__item-wrapper <?= !($bOrderViewBasket && $bOrderButton) ? 'opacity0 no-opt-action' : '';?>">
                                <div class="form-checkbox">
                                    <input type="checkbox" class="form-checkbox__input" id="check_item_<?=$arItem['ID'];?>" name="check_item" value="Y" <?= !($bOrderViewBasket && $bOrderButton) ? 'disabled' : '';?>>
                                    <label for="check_item_<?=$arItem['ID'];?>" class="form-checkbox__label form-checkbox__label--no-text">
                                        <span>

                                        </span>
                                        <span class="form-checkbox__box"></span>
                                    </label>
                                </div>
                            </div>
                        <?endif;?>

                        <?php
                        $arImgConfig = [
                            'TYPE' => 'catalog_table',
                            'ADDITIONAL_IMG_CLASS' => 'js-replace-img',
                        ];
                        if ($arItem['NO_IMAGE']) {
                            $arImgConfig['NO_IMAGE'] = $arItem['NO_IMAGE'];
                        }
                        ?>
                        <div class="catalog-table__item-wrapper js-config-img <?=($arResult['SHOW_IMAGE']) ? '' : 'catalog-table__item-wrapper--no-padding';?>" data-img-config='<?=str_replace('\'', '"', CUtil::PhpToJSObject($arImgConfig, false, true));?>'>
                            <?if ($arResult['SHOW_IMAGE']):?>
                                <?=TSolution\Functions::showImage(
                                    array_merge(
                                        [
                                            'ITEM' => $arItem,
                                            'PARAMS' => $arParams,
                                        ],
                                        $arImgConfig
                                    )
                                );?>
                            <?endif;?>
                        </div>

                        <?if ($bUseSchema):?>
                            <meta itemprop="name" content="<?=$arItem['NAME'];?>">
                            <link itemprop="url" href="<?=$arItem['DETAIL_PAGE_URL'];?>">
                        <?endif;?>
                        <div class="catalog-table__info flex-1 flexbox flexbox--direction-row1" data-id="<?=$arCurrentOffer ? $arCurrentOffer['ID'] : $arItem['ID'];?>" <?if ($bUseSchema):?>itemprop="offers" itemscope itemtype="http://schema.org/Offer"<?endif;?><?= $bOrderViewBasket ? ' data-item="'.$dataItem.'"' : '';?>>
                            <div class="flex-1 flexbox flexbox--direction-row catalog-table__info-wrapper">
                                <div class="catalog-table__info-top">
                                    <div class="catalog-table__info-inner catalog-table__item-wrapper">
                                        <?// element title?>
                                        <div class="catalog-table__info-title linecamp-4 height-auto-t600 font_16 font_large">
                                            <?if ($bUseSchema):?>
                                                <link itemprop="url" href="<?=$arItem['DETAIL_PAGE_URL'];?>">
                                            <?endif;?>
                                            <?if ($arItem['DETAIL_PAGE_URL']):?>
                                                <?if (!$arParams['DETAIL']):?><a href="<?=$arItem['DETAIL_PAGE_URL'];?>" class="dark_link switcher-title js-popup-title js-replace-link"><?endif;?>
                                                    <span><?=$elementName;?></span>
                                                <?if (!$arParams['DETAIL']):?></a><?endif;?>
                                            <?else:?>
                                                <div class="color_333 switcher-title js-popup-title"><span><?=$elementName;?></span></div>
                                            <?endif;?>
                                        </div>
                                        <?if (strlen($status) || strlen($article)):?>
                                            <div class="catalog-table__info-tech compact-hidden-t600">
                                                <div class="line-block line-block--20 flexbox--wrap js-popup-info">
                                                    <?// element status?>
                                                    <?if (strlen($status)):?>
                                                        <div class="line-block__item font_13">
                                                            <?if ($bUseSchema):?>
                                                                <?=TSolution\Functions::showSchemaAvailabilityMeta($statusCode);?>
                                                            <?endif;?>
                                                            <span
                                                             class="status-icon <?=$statusCode;?> js-replace-status"
                                                             data-state="<?=$statusCode;?>"
                                                             data-code="<?=$arItem['DISPLAY_PROPERTIES']['STATUS']['VALUE_XML_ID'];?>"
                                                             data-value="<?=$arItem['DISPLAY_PROPERTIES']['STATUS']['VALUE'];?>"
                                                            ><?=$status;?></span>
                                                        </div>
                                                    <?endif;?>
                                                    <?// element article?>
                                                    <?if (strlen($article)):?>
                                                        <div class="line-block__item font_13 color_999">
                                                            <span class="article"><?=GetMessage('S_ARTICLE');?>&nbsp;<span
                                                             class="js-replace-article"
                                                             data-value="<?=$arItem['DISPLAY_PROPERTIES']['ARTICLE']['VALUE'];?>"
                                                            ><?=$article;?></span></span>
                                                        </div>
                                                    <?endif;?>
                                                </div>
                                            </div>
                                        <?endif;?>
                                    </div>
                                </div>
                                <?if ($arItem['PROPS'] && $bColProps):?>
                                    <?foreach ($arResult['COLS_PROP'] as $key => $arProp):?>
                                        <div class="catalog-table__item-wrapper props hide-991">
                                            <?if ($arItem['PROPS'] && $arItem['PROPS'][$key]):?>
                                                <div class="properties__value color_333 font_14 font_short">
                                                    <?if (is_array($arItem['PROPS'][$key]['DISPLAY_VALUE']) && count($arItem['PROPS'][$key]['DISPLAY_VALUE']) > 1):?>
                                                        <?=implode(', ', $arItem['PROPS'][$key]['DISPLAY_VALUE']);?>
                                                    <?else:?>
                                                        <?=$arItem['PROPS'][$key]['DISPLAY_VALUE'];?>
                                                    <?endif;?>
                                                </div>
                                            <?endif;?>
                                        </div>
                                    <?endforeach;?>
                                <?endif;?>
                                <?$bDetail = (isset($arParams['DETAIL']) && $arParams['DETAIL'] === 'Y');?>
                                <div class="catalog-table__info-bottom flexbox flexbox--direction-row<?= $bDetail && !$bOrderButton ? ' catalog-table__info-bottom--center' : '';?>">
                                    <?// element price?>
                                    <div class="js-popup-price catalog-table__item-wrapper">
                                        <?=TSolution\Functions::showPrice([
                                            'ITEM' => ($arCurrentOffer ? $arCurrentOffer : $arItem),
                                            'PARAMS' => $arParams,
                                            'SHOW_SCHEMA' => $bUseSchema,
                                            'BASKET' => $bOrderViewBasket,
                                            'PRICE_FONT' => $bCompactView ? 14 : 17,
                                            'PRICEOLD_FONT' => $bCompactView ? 10 : 13,
                                            'ECONOMY_FONT' => $bCompactView ? 9 : 11,
                                        ]);?>
                                    </div>
                                    <?// element btns?>
                                    <?$arBtnConfig = [
                                        'WRAPPER' => ($bDetail && !$bOrderButton ? false : true),
                                        'WRAPPER_CLASS' => 'catalog-table__item-wrapper',
                                        'BASKET_URL' => $basketURL,
                                        'DETAIL_PAGE' => $bDetail,
                                        'BASKET' => $bOrderViewBasket,
                                        'BTN_CLASS' => $bCompactView ? 'btn-md ' : 'btn-md btn-wide',
                                        'BTN_IN_CART_CLASS' => 'btn-md btn-wide',
                                        'QUESTION_BTN' => false,
                                        'INFO_BTN_ICONS' => true,
                                        'ONE_CLICK_BUY' => $arParams['SHOW_ONE_CLINK_BUY'] != 'N',
                                        'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
                                        'SHOW_COUNTER' => $bCompactView,
                                        'CATALOG_IBLOCK_ID' => $arItem['IBLOCK_ID'],
                                        'ITEM_ID' => $arItem['ID'],
                                        'ASK_FORM_ID' => $arParams['ASK_FORM_ID'],
                                    ];?>
                                    <div class="js-config-btns hide-600" data-btn-config='<?=str_replace('\'', '"', CUtil::PhpToJSObject($arBtnConfig, false, true));?>'></div>
                                    <?=TSolution\Functions::showBasketButton(
                                        array_merge(
                                            $arBtnConfig,
                                            [
                                                'ITEM' => ($arCurrentOffer ? $arCurrentOffer : $arItem),
                                                'PARAMS' => array_merge($arParams, ['USE_FAST_VIEW_PAGE_DETAIL' => 'NO']),
                                                'ORDER_BTN' => $bOrderButton,
                                                'JS_CLASS' => 'js-replace-btns '.($arCurrentOffer ? 'hide-600' : ''),
                                            ]
                                        )
                                    );?>
                                    <?if ($arCurrentOffer):?>
                                        <div class="visible-600">
                                            <?=TSolution\Functions::showBasketButton([
                                                'ORDER_BTN' => false,
                                                'ITEM' => $arCurrentOffer,
                                            ]);?>
                                        </div>
                                    <?endif;?>
                                </div>
                            </div>
                            <?if ($arItem['SKU']['PROPS']/* && !$bHideProps */):?>
                                <div class="catalog-table__item-wrapper hide-600">
                                    <div
                                     class="sku-props sku-props--list"
                                     data-site-id="<?=SITE_ID;?>"
                                     data-item-id="<?=$arItem['ID'];?>"
                                     data-iblockid="<?=$arItem['IBLOCK_ID'];?>"
                                     data-offer-id="<?=$arCurrentOffer['ID'];?>"
                                     data-offer-iblockid="<?=$arCurrentOffer['IBLOCK_ID'];?>"
                                    >
                                        <div class="line-block line-block--flex-wrap line-block--40 line-block--align-normal">
                                            <?=TSolution\CSKUTemplate::showSkuPropsHtml($arItem['SKU']['PROPS']);?>
                                        </div>

                                    </div>
                                </div>
                            <?endif;?>
                            <?if (!$bHideProps):?>
                                <div class="visible-by-item-presence">
                                    <div class="catalog-table__item-wrapper hide-600 <?= $bColProps ? 'visible-991' : '';?>">
                                        <div class="properties">
                                            <div class="line-block line-block--align-normal flexbox--wrap js-offers-prop">
                                                <?php
                                                TSolution\Product\Template::showProps(
                                                    [
                                                        'VIEW' => TSolution\Product\Template::VIEW_TABLE,
                                                        'ITEM_PROP' => true,
                                                    ],
                                                    $arItem['PROPS']
                                                );

                                                TSolution\Product\Template::showProps(
                                                    [
                                                        'VIEW' => TSolution\Product\Template::VIEW_TABLE,
                                                    ],
                                                    $arItem['OFFER_PROP']
                                                );
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?endif;?>
                        </div>

                    </div>
                </div>

            </div>
        <?endforeach;?>

        <?if ($bHasBottomPager && $bMobileScrolledItems):?>
            <?if ($bAjax):?>
                <div class="wrap_nav bottom_nav_wrapper">
            <?endif;?>

                <?$bHasNav = (strpos($arResult['NAV_STRING'], 'more_text_ajax') !== false);?>
                <div class="bottom_nav mobile_slider <?= $bHasNav ? '' : ' hidden-nav';?>" data-parent=".catalog-table" data-append=".grid-list" <?= $bAjax ? "style='display: none; '" : '';?>>
                    <?=$arResult['NAV_STRING'];?>
                </div>

            <?if ($bAjax):?>
                </div>
            <?endif;?>
        <?endif;?>

    <?if (!$bAjax):?>
            </div> <?// .js_append ajax_load block grid-list?>
    <?endif;?>

        <?if ($bAjax):?>
            <div class="wrap_nav bottom_nav_wrapper">
        <?endif;?>

        <?if ($arParams['IS_CATALOG_PAGE'] == 'Y' && $arParams['SECTION_COUNT_ELEMENTS'] == 'Y'):?>
            <?if ((int) $arResult['NAV_RESULT']->NavRecordCount > 0):?>
                <?$this->SetViewTarget('more_text_title');?>
                    <span class="element-count-wrapper"><span class="element-count color_999 rounded-4"><?=$arResult['NAV_RESULT']->NavRecordCount;?></span></span>
                <?$this->EndViewTarget();?>
            <?endif;?>
        <?endif;?>

        <div class="bottom_nav_wrapper nav-compact">
            <div class="bottom_nav <?= $bMobileScrolledItems ? 'hide-600' : '';?>" <?= $arParams['AJAX_REQUEST'] == 'Y' ? "style='display: none; '" : '';?> data-parent=".catalog-table" data-append=".grid-list">
                <?if ($arParams['DISPLAY_BOTTOM_PAGER']):?>
                    <?=$arResult['NAV_STRING'];?>
                <?endif;?>
            </div>
        </div>

    <?if ($bAjax):?>
        </div>
    <?endif;?>

    <?if (!$bAjax):?>
        </div> <?// .catalog-block?>
    </div> <?// .catalog-items?>
    <script><?if ($bColProps):?>var tableScrollerOb= new TableScroller('table-scroller-wrapper');<?endif;?></script>
    <?endif;?>
    <script>
        if (typeof initCountdown === "function") initCountdown();
        if (typeof setBasketItemsClasses === "function") setBasketItemsClasses();
        if (typeof setCompareItemsClass === "function") setCompareItemsClass();
    </script>
<?elseif ($arParams['IS_CATALOG_PAGE'] == 'Y'):?>
    <div class="no_goods catalog_block_view">
        <div class="no_products">
            <div class="wrap_text_empty">
                <?if ($_REQUEST['set_filter']):?>
                    <?$APPLICATION->IncludeFile(SITE_DIR.'include/section_no_products_filter.php', [], ['MODE' => 'html',  'NAME' => GetMessage('EMPTY_CATALOG_DESCR')]);?>
                <?else:?>
                    <?$APPLICATION->IncludeFile(SITE_DIR.'include/section_no_products.php', [], ['MODE' => 'html',  'NAME' => GetMessage('EMPTY_CATALOG_DESCR')]);?>
                <?endif;?>
            </div>
        </div>
    </div>
<?endif;?>

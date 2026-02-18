<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

$this->setFrameMode(true);

?>
<?if ($arResult['ITEMS']):?>
    <?php
    $templateData['ITEMS'] = true;

    $bHasBottomPager = $arParams['DISPLAY_BOTTOM_PAGER'] == 'Y' && $arResult['NAV_STRING'];
    $bUseSchema = !(isset($arParams['NO_USE_SHCEMA_ORG']) && $arParams['NO_USE_SHCEMA_ORG'] == 'Y');
    $bAjax = $arParams['AJAX_REQUEST'] == 'Y';
    $bMobileScrolledItems = $arParams['MOBILE_SCROLLED'];
    $bMobileOneRow = $arParams['MOBILE_ONE_ROW'];

    $bOrderViewBasket = $arParams['ORDER_VIEW'];
    $basketURL = (strlen(trim($arTheme['ORDER_VIEW']['DEPENDENT_PARAMS']['URL_BASKET_SECTION']['VALUE'])) ? trim($arTheme['ORDER_VIEW']['DEPENDENT_PARAMS']['URL_BASKET_SECTION']['VALUE']) : '');

    $gridClass = ['grid-list grid-list--items-1'];

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
    } elseif (!$bMobileOneRow) {
        $gridClass[] = 'grid-list--compact';
    }

    if (!$arParams['ITEMS_OFFSET']) {
        $gridClass[] = 'grid-list--no-gap';
    } elseif ($arParams['GRID_GAP']) {
        $gridClass[] = 'grid-list--gap-'.$arParams['GRID_GAP'];
    }

    $itemClass = ' bordered shadow-hovered shadow-hovered-f600 shadow-no-border-hovered side-icons-hover bg-theme-parent-hover border-theme-parent-hover js-popup-block';
    if ($arParams['ITEMS_OFFSET']) {
        $itemClass .= ' rounded-4';
    }
    if ($arParams['TEXT_CENTER']) {
        $itemClass .= ' catalog-block__item--centered';
    }

    $bBottomButtons = (isset($arParams['POSITION_BTNS']) && $arParams['POSITION_BTNS'] == '4');

    $gridClass = TSolution\Utils::implodeClasses($gridClass);
    ?>
    <?if (!$bAjax):?>
    <div class="catalog-items <?=$templateName;?>_template <?=$arParams['IS_COMPACT_SLIDER'] ? 'compact-catalog-slider' : '';?>">
        <template class="props-template"><?TSolution\Product\Template::showPropView(['VIEW' => TSolution\Product\Template::VIEW_LIST]);?></template>
        <div class="fast_view_params" data-params="<?=urlencode(serialize($arTransferParams));?>"></div>
        <?if ($arResult['SKU_CONFIG']):?><div class="js-sku-config" data-value='<?=str_replace('\'', '"', CUtil::PhpToJSObject($arResult['SKU_CONFIG'], false, true));?>'></div><?endif;?>
        <div class="catalog-list" <?if ($bUseSchema):?>itemscope itemtype="http://schema.org/ItemList"<?endif;?> >
            <div class="js_append ajax_load list <?=$gridClass;?>">
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

            <?ob_start();?>
                <?if ($arParams['SHOW_DISCOUNT_TIME'] == 'Y' && $arParams['SHOW_COUNTER_LIST'] != 'N' && $arItem['DISPLAY_PROPERTIES']['DATE_COUNTER']['VALUE']):?>
                    <?TSolution\Functions::showDiscountCounter([
                        'TYPE' => 'list-list-image',
                        'ICONS' => true,
                        'DATE' => $arItem['DISPLAY_PROPERTIES']['DATE_COUNTER']['VALUE'],
                        'ITEM' => $arItem,
                    ]);?>
                <?endif;?>
            <?$itemDiscount = ob_get_clean();?>

            <div class="catalog-list__wrapper grid-list__item grid-list-border-outer">
                <div class="catalog-list__item <?=$itemClass;?>" id="<?=$arItem['strMainID'];?>">
                    <div class="catalog-list__inner flexbox flexbox--direction-row height-100" <?if ($bUseSchema):?>itemprop="itemListElement" itemscope="" itemtype="http://schema.org/Product"<?endif;?>>
                        <?php
                        $arImgConfig = [
                            'TYPE' => 'catalog_list',
                            'ADDITIONAL_IMG_CLASS' => 'js-replace-img',
                        ];
                        if ($arItem['NO_IMAGE']) {
                            $arImgConfig['NO_IMAGE'] = $arItem['NO_IMAGE'];
                        }
                        ?>
                        <div class="js-config-img" data-img-config='<?=str_replace('\'', '"', CUtil::PhpToJSObject($arImgConfig, false, true));?>'></div>
                        <?if ($bUseSchema):?>
                            <?/* <meta itemprop="position" content="<?=(++$positionProduct)?>" /> */?>
                            <meta itemprop="description" content="<?=htmlspecialcharsbx(strip_tags($arItem['PREVIEW_TEXT'] ?: $arItem['NAME']));?>" />
                        <?endif;?>
                        <?=TSolution\Functions::showImage(
                            array_merge(
                                [
                                    'ITEM' => $arItem,
                                    'PARAMS' => $arParams,
                                    'STICKY' => true,
                                ],
                                $arImgConfig
                            )
                        );?>

                        <?if ($bUseSchema):?>
                            <meta itemprop="name" content="<?=$arItem['NAME'];?>">
                            <link itemprop="url" href="<?=$arItem['DETAIL_PAGE_URL'];?>">
                        <?endif;?>
                        <div class="catalog-list__info flex-1 flexbox flexbox--direction-row"
                            data-id="<?= $arCurrentOffer ? $arCurrentOffer['ID'] : $arItem['ID'];?>"
                            <?if ($bUseSchema):?>itemprop="offers" itemscope itemtype="http://schema.org/Offer"<?endif;?>
                            <?= $bOrderViewBasket ? ' data-item="'.$dataItem.'"' : '';?>
                            >
                            <div class="catalog-list__info-top">
                                <?// element section?>
                                <?if ($arItem['SECTIONS']):?>
                                    <div class="catalog-list__info-section color_999 font_12 linecamp-2"><?=implode('/', $arItem['SECTIONS']);?></div>
                                <?endif;?>
                                <div class="catalog-list__info-inner">
                                    <?// element title?>
                                    <div class="catalog-list__info-title linecamp-4 height-auto-t600 font_18 font_large">
                                        <?if ($bUseSchema):?>
                                            <link itemprop="url" href="<?=$arItem['DETAIL_PAGE_URL'];?>">
                                        <?endif;?>
                                        <?if ($arItem['DETAIL_PAGE_URL'] && $bShowDetailLink):?>
                                        <a href="<?=$arItem['DETAIL_PAGE_URL'];?>" class="dark_link switcher-title js-popup-title"><span><?=$elementName;?></span></a>
                                        <?else:?>
                                            <div class="color_333 switcher-title js-popup-title"><span><?=$elementName;?></span></div>
                                        <?endif;?>
                                    </div>
                                    <?if (strlen($status) || strlen($article)):?>
                                        <div class="catalog-list__info-tech compact-hidden-t600">
                                            <div class="line-block line-block--20 flexbox--wrap js-popup-info">
                                                <?// element status?>
                                                <?if (strlen($status)):?>
                                                    <div class="line-block__item font_13">
                                                        <?if ($bUseSchema):?>
                                                            <?=TSolution\Functions::showSchemaAvailabilityMeta($statusCode);?>
                                                        <?endif;?>
                                                        <span class="status-icon <?=$statusCode;?> js-replace-status"
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
                                    <?if ($arItem['SKU']['PROPS']):?>
                                        <div class="catalog-table__item-wrapper hide-600">
                                            <div class="sku-props sku-props--list"
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
                                    <?if ($arItem['PREVIEW_TEXT']):?>
                                        <div class="catalog-list__info-text font_13 color_666"
                                            itemprop="description"
                                            >
                                            <?=$arItem['PREVIEW_TEXT'];?>
                                        </div>
                                    <?endif;?>
                                    <div class="properties properties--mt-13 visible-by-item-presence js-offers-prop">
                                        <?php
                                        TSolution\Product\Template::showProps(
                                            [
                                                'VIEW' => TSolution\Product\Template::VIEW_LIST,
                                                'ITEM_PROP' => true,
                                            ],
                                            $arItem['PROPS']
                                        );

                                        TSolution\Product\Template::showProps(
                                            [
                                                'VIEW' => TSolution\Product\Template::VIEW_LIST,
                                            ],
                                            $arItem['OFFER_PROP']
                                        );
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="catalog-list__info-bottom">
                                <?=$itemDiscount;?>
                                <?// element price?>
                                <div class="js-popup-price">
                                    <?=TSolution\Functions::showPrice([
                                        'ITEM' => ($arCurrentOffer ? $arCurrentOffer : $arItem),
                                        'PARAMS' => $arParams,
                                        'SHOW_SCHEMA' => $bUseSchema,
                                        'BASKET' => $bOrderViewBasket,
                                    ]);?>
                                </div>
                                <?// element btns?>
                                <?$arBtnConfig = [
                                    'BASKET_URL' => $basketURL,
                                    'BASKET' => $bOrderViewBasket,
                                    'ORDER_BTN' => $bOrderButton,
                                    'BTN_CLASS' => 'btn-wide',
                                    'QUESTION_BTN' => $arItem['PROPERTIES']['FORM_QUESTION']['VALUE'] == 'Y',
                                    'ONE_CLICK_BUY' => $arParams['SHOW_ONE_CLINK_BUY'] != 'N',
                                    'BTN_IN_CART_CLASS' => 'btn-wide',
                                    'SHOW_COUNTER' => false,
                                    'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
                                    'CATALOG_IBLOCK_ID' => $arItem['IBLOCK_ID'],
                                    'ITEM_ID' => $arItem['ID'],
                                    'ASK_FORM_ID' => $arParams['ASK_FORM_ID'],
                                ];?>
                                <div class="js-replace-btns js-config-btns <?= $arCurrentOffer ? 'hide-600' : '';?>" data-btn-config='<?=str_replace('\'', '"', CUtil::PhpToJSObject($arBtnConfig, false, true));?>'>
                                    <?=TSolution\Functions::showBasketButton(
                                        array_merge(
                                            $arBtnConfig,
                                            [
                                                'ITEM' => ($arCurrentOffer ? $arCurrentOffer : $arItem),
                                                'PARAMS' => $arParams,
                                            ]
                                        )
                                    );?>
                                </div>
                                <?if ($arCurrentOffer):?>
                                    <div class="visible-600">
                                        <?=TSolution\Functions::showBasketButton([
                                            'ORDER_BTN' => false,
                                            'ITEM' => $arCurrentOffer,
                                        ]);?>
                                    </div>
                                <?endif;?>
                                <?// hint?>
                                <?if ($arItem['INCLUDE_TEXT']):?>
                                    <div class="block-with-icon block-with-icon--mt-14">
                                        <?=TSolution::showIconSvg('icon block-with-icon__icon', SITE_TEMPLATE_PATH.'/images/svg/catalog/info_big.svg', '', '', true, false);?>
                                        <div class="block-with-icon__text color_666 font_13">
                                            <?=$arItem['INCLUDE_TEXT'];?>
                                        </div>
                                    </div>
                                <?endif;?>
                            </div>
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
                <div class="bottom_nav mobile_slider <?= $bHasNav ? '' : ' hidden-nav';?>" data-parent=".catalog-list" data-append=".grid-list" <?= $bAjax ? "style='display: none; '" : '';?>>
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
            <div class="bottom_nav <?= $bMobileScrolledItems ? 'hide-600' : '';?>" <?= $arParams['AJAX_REQUEST'] == 'Y' ? "style='display: none; '" : '';?> data-parent=".catalog-list" data-append=".grid-list">
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

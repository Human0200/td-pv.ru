<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}

/**
 * @var array $arResult
 * @var array $arParams
 * @var bool $bOffersMode
 * @var bool $bUseSchema
 **/
?>
<div class="properties-group properties-group--block js-offers-group-wrap">
    <div class="properties-group__group<?=$bOffersMode ? ' js-offers-group' : '';?>" data-group-code="<?=$this->__component::NO_GROUP_CODE;?>">
        <div class="properties-group__items js-offers-group__items-wrap font_15">
            <?foreach ($arResult['DISPLAY_PROPERTIES'] as $arProp):?>
                <?$bHint = $arProp['HINT'] && $arParams['SHOW_HINTS'] == 'Y';?>
                <div class="properties-group__item<?=$bOffersMode || $arProp['IS_OFFER'] ? ' js-offers-group__item' : '';?>" itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
                    <div class="properties-group__name-wrap<?=$bHint ? ' properties-group__name-wrap--whint' : '';?>">
                        <span itemprop="name" class="properties-group__name"><?=$arProp['NAME'];?></span>
                        <?if ($bHint):?>
                            <div class="hint hint--down">
                                <span class="hint__icon rounded bg-theme-hover border-theme-hover bordered"><i>?</i></span>
                                <div class="tooltip"><?=$arProp['HINT'];?></div>
                            </div>
                        <?endif;?>
                    </div>

                    <div class="properties-group__value-wrap">
                        <div class="properties-group__value color_dark" itemprop="value">
                            <?if (is_array($arProp['DISPLAY_VALUE']) && count($arProp['DISPLAY_VALUE'])):?>
                                <?=implode(', ', $arProp['DISPLAY_VALUE']);?>
                            <?else:?>
                                <?=$arProp['DISPLAY_VALUE'];?>
                            <?endif;?>
                        </div>
                    </div>
                </div>
            <?endforeach;?>

            <?if ($arResult['OFFER_DISPLAY_PROPERTIES']):?>
                <?foreach ($arResult['OFFER_DISPLAY_PROPERTIES'] as $arProp):?>
                    <?$bHint = $arProp['HINT'] && $arParams['SHOW_HINTS'] == 'Y';?>
                    <div class="properties-group__item js-offers-group__item" itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
                        <div class="properties-group__name-wrap<?=$bHint ? ' properties-group__name-wrap--whint' : '';?>">
                            <span itemprop="name" class="properties-group__name"><?=$arProp['NAME'];?></span>
                            <?if ($bHint):?>
                                <div class="hint hint--down">
                                    <span class="hint__icon rounded bg-theme-hover border-theme-hover bordered"><i>?</i></span>
                                    <div class="tooltip"><?=$arProp['HINT'];?></div>
                                </div>
                            <?endif;?>
                        </div>

                        <div class="properties-group__value-wrap">
                            <div class="properties-group__value color_dark" itemprop="value">
                                <?if (is_array($arProp['DISPLAY_VALUE']) && count($arProp['DISPLAY_VALUE'])):?>
                                    <?=implode(', ', $arProp['DISPLAY_VALUE']);?>
                                <?else:?>
                                    <?=$arProp['DISPLAY_VALUE'];?>
                                <?endif;?>
                            </div>
                        </div>
                    </div>
                <?endforeach;?>
            <?endif;?>
        </div>
    </div>
</div>

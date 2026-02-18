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

$bOneRowTable = count($arResult['GROUPS']) === 1 && reset($arResult['GROUPS'])['NAME'] === $this->__component::NO_GROUP_NAME;

$bFirst = true;
?>
<div class="properties-group properties-group--table<?=$bOneRowTable ? ' properties-group--table-one-column' : '';?> js-offers-group-wrap">
    <?foreach ($arResult['GROUPS'] as $arGroup):?>
        <?php
        $bNoGroup = $arGroup['CODE'] === $this->__component::NO_GROUP_CODE || $arGroup['NAME'] === $this->__component::NO_GROUP_NAME;
        $bOfferGroup = $bOffersMode || (isset($arGroup['OFFER_GROUP']) && $arGroup['OFFER_GROUP']);
        ?>
        <div class="properties-group__group<?=$bOfferGroup ? ' js-offers-group' : '';?>" data-group-code="<?=$arGroup['CODE'] ?? $this->__component::NO_GROUP_CODE;?>">
            <?if (!$bNoGroup && !empty(trim($arGroup['NAME']))):?>
                <div class="properties-group__group-name color_dark mb mb--12 font_16 switcher-title<?=$bFirst ? ' properties-group__group-name--first' : '';?>">
                    <?=$arGroup['NAME'];?>
                </div>
            <?endif;?>

            <div class="properties-group__items js-offers-group__items-wrap font_15">
                <?foreach ($arGroup['DISPLAY_PROPERTIES'] as $arProp):?>
                    <?$bHint = $arProp['HINT'] && $arParams['SHOW_HINTS'] == 'Y';?>
                    <div class="properties-group__item<?=$bOffersMode || $arProp['IS_OFFER'] ? ' js-offers-group__item' : '';?>" <?=$bUseSchema ? 'itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"' : '';?>>
                        <div class="properties-group__name-wrap<?=$bHint ? ' properties-group__name-wrap--whint' : '';?>">
                            <span <?=$bUseSchema ? 'itemprop="name"' : '';?> class="properties-group__name secondary-color"><?=$arProp['NAME'];?></span>
                            <?if ($bHint):?>
                                <div class="hint hint--down">
                                    <span class="hint__icon rounded bg-theme-hover border-theme-hover bordered"><i>?</i></span>
                                    <div class="tooltip"><?=$arProp['HINT'];?></div>
                                </div>
                            <?endif;?>
                        </div>

                        <div class="properties-group__value-wrap">
                            <div class="properties-group__value color_dark" <?=$bUseSchema ? 'itemprop="value"' : '';?>>
                                <?if (is_array($arProp['DISPLAY_VALUE']) && count($arProp['DISPLAY_VALUE'])):?>
                                    <?=implode(', ', $arProp['DISPLAY_VALUE']);?>
                                <?else:?>
                                    <?=$arProp['DISPLAY_VALUE'];?>
                                <?endif;?>
                            </div>
                        </div>
                    </div>
                <?endforeach;?>
            </div>
        </div>
        <?$bFirst = false;?>
    <?endforeach;?>
</div>

<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}
?>
<form name="subscribe-footer-form" action="<?=SITE_DIR.$arParams['PAGE'];?>" method="post" class="subscribe-form flexbox flexbox--align-start">
    <?=bitrix_sessid_post();?>

    <div class="relative width-100">
        <input type="text" class="form-control subscribe-input required"
            name="EMAIL"
            placeholder="<?=GetMessage('EMAIL_INPUT');?>"
            value="<?=$arResult['USER_EMAIL'] ?: ($arResult['SUBSCRIPTION']['EMAIL'] ?: $arResult['REQUEST']['EMAIL']);?>"
            size="30"
            maxlength="255"
            >

        <div class="subscribe-form__save stroke-theme-hover colored_theme_hover_bg-block">
            <input type="submit" name="Save" class="subscribe-btn" value="">
            <?=TSolution::showIconSvg(' subscribe-form__right-arrow', SITE_TEMPLATE_PATH.'/images/svg/Arrow_map.svg');?>
            <div class="subscribe-form__right-arrow-line colored_theme_hover_bg-el"></div>
        </div>
    </div>

    <?foreach ($arResult['RUBRICS'] as $itemID => $itemValue):?>
        <input type="hidden" name="RUB_ID[]" value="<?=$itemValue['ID'];?>">
    <?endforeach;?>

    <input type="hidden" name="FORMAT" value="html">

    <input type="hidden" name="PostAction" value="Add">
    <input type="hidden" name="ID" value="<?=$arResult['SUBSCRIPTION']['ID'];?>">
</form>

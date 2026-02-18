<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

// ***********************************
// setting section
// ***********************************
?>
<div class="top-form bordered_block">
    <h4><?=GetMessage('subscr_title_settings');?></h4>
    <form action="<?=$arResult['FORM_ACTION'];?>" method="post" class="form subscribe-settings-form" name="subscribe-settings-form">
        <?=bitrix_sessid_post();?>

        <?$email = ($arResult['SUBSCRIPTION']['EMAIL'] != '' ? $arResult['SUBSCRIPTION']['EMAIL'] : $arResult['REQUEST']['EMAIL']);?>
        <div class="form-group <?=$email ? 'input-filed' : '';?>">
            <label for="EMAIL" class="font_13 color_666"><?=GetMessage('subscr_email');?>&nbsp;<span class="required-star">*</span></label>
            <div class="wrap-half-block">
                <div class="input">
                    <input class="form-control" type="text" id="EMAIL" name="EMAIL" value="<?=$email;?>" required size="30" maxlength="255">
                </div>
                <div class="text_block"><?=GetMessage('subscr_settings_note1');?> <?=GetMessage('subscr_settings_note2');?></div>
            </div>
        </div>

        <div class="form-group option filter subscribes-block">
            <div class="subsection-title option-font-bold font_16"><?=GetMessage('subscr_rub');?>&nbsp;<span class="required-star">*</span></div>
            <?foreach ($arResult['RUBRICS'] as $itemID => $itemValue):?>
                <input class="form-checkbox__input"
                    type="checkbox"
                    name="RUB_ID[]"
                    id="rub_<?=$itemValue['ID'];?>"
                    value="<?=$itemValue['ID'];?>"
                    <?=$itemValue['CHECKED'] ? ' checked' : ''?>
                    >
                <label for="rub_<?=$itemValue['ID'];?>" class="form-checkbox__label">
                    <span class="bx_filter_input_checkbox">
                        <span><?=$itemValue['NAME'];?></span>
                    </span>
                    <span class="form-checkbox__box form-box"></span>
                </label>
            <?endforeach;?>
        </div>

        <div class="form-group option filter format-subscribe-group">
            <div class="subsection-title option-font-bold font_16"><?=GetMessage('subscr_fmt');?></div>
            <div class="form-radiobox">
                <input class="form-radiobox__input"
                    type="radio"
                    id="text"
                    name="FORMAT"
                    value="text"
                    <?=$arResult['SUBSCRIPTION']['FORMAT'] === 'text' ? ' checked' : '';?>
                    >
                <label for="text" class="form-radiobox__label">
                    <span class="bx_filter_input_checkbox">
                        <span><?=GetMessage('subscr_text');?></span>
                    </span>
                    <span class="form-radiobox__box"></span>
                </label>
            </div>
            &nbsp;&nbsp;
            <div class="form-radiobox">
                <input class="form-radiobox__input"
                    type="radio"
                    name="FORMAT"
                    id="html"
                    value="html"
                    <?=$arResult['SUBSCRIPTION']['FORMAT'] === 'text' ? ' checked' : '';?>
                    >
                <label for="html" class="form-radiobox__label">
                    <span class="bx_filter_input_checkbox">
                        <span>HTML</span>
                    </span>
                    <span class="form-radiobox__box"></span>
                </label>
            </div>
        </div>

        <?if (TSolution::GetFrontParametrValue('CAPTCHA_ON_SUBSCRIBE') === 'Y'):?>
            <?$arResult['CAPTCHACode'] = $APPLICATION->CaptchaGetCode();?>
            <div class="captcha-row clearfix fill-animate">
                <label class="font_13 color_999"><span><?=GetMessage('FORM_CAPRCHE_TITLE');?>&nbsp;<span class="required-star">*</span></span></label>
                <div class="captcha_image">
                    <img data-src="" src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult['CAPTCHACode']);?>" class="captcha_img">
                    <input type="hidden" name="captcha_sid" class="captcha_sid" value="<?=htmlspecialcharsbx($arResult['CAPTCHACode']);?>">
                    <div class="captcha_reload"></div>
                    <span class="refresh"><a href="javascript:;" rel="nofollow"><?=GetMessage('REFRESH');?></a></span>
                </div>
                <div class="captcha_input">
                    <input type="text" class="inputtext form-control captcha" name="captcha_word" size="30" maxlength="50" value="" required>
                </div>
            </div>
        <?endif;?>

        <?global $arTheme;?>
        <?if ($arTheme['SHOW_LICENCE']['VALUE'] == 'Y' && !$arResult['ID']):?>
            <div class="subscribe_licenses">
                <?TSolution\Functions::showBlockHtml([
                    'FILE' => 'consent/userconsent.php',
                    'PARAMS' => [
                        'OPTION_CODE' => 'AGREEMENT_SUBSCRIBE',
                        'SUBMIT_TEXT' => GetMessage("subscr_add"),
                        'REPLACE_FIELDS' => [],
                        'INPUT_NAME' => "licenses_subscribe",
                        'INPUT_ID' => 'licenses_subscribe',
                    ]
                ]);?>
            </div>
        <?endif;?>

        <div class=but-r>
            <input type="submit" class="btn btn-default btn-lg" name="Save" value="<?=$arResult['ID'] > 0 ? GetMessage('subscr_upd') : GetMessage('subscr_add');?>">
            <input type="reset" class="btn btn-default btn-transparent-bg white btn-lg" value="<?=GetMessage('subscr_reset');?>" name="reset">
        </div>

        <input type="hidden" name="PostAction" value="<?=$arResult['ID'] > 0 ? 'Update' : 'Add';?>">
        <input type="hidden" name="ID" value="<?=$arResult['SUBSCRIPTION']['ID'];?>">

        <?if ($_REQUEST['register'] == 'YES'):?>
            <input type="hidden" name="register" value="YES">
        <?endif;?>

        <?if ($_REQUEST['authorize'] == 'YES'):?>
            <input type="hidden" name="authorize" value="YES">
        <?endif;?>
    </form>
</div>

<script>
    BX.Aspro.Utils.readyDOM(() => {
        $('form[name="subscribe-settings-form"]').validate({
            ignore: ".ignore",
            highlight: function (element) {
                $(element).parent().addClass('error');
            },
            unhighlight: function (element) {
                $(element).parent().removeClass('error');
            },
            submitHandler: function (form) {
                if ($('form[name="subscribe-settings-form"]').valid()){
                    setTimeout(function() {
                        $(form).find('button[type="submit"]').attr("disabled", "disabled");
                    }, 300);

                    const eventdata = {type: 'form_submit', form: form, form_name: 'subscribe-settings-form'};
                    BX.onCustomEvent('onSubmitForm', [eventdata]);
                }
            },
            errorPlacement: function (error, element) {
                error.insertBefore(element);
            },
            messages: {
                licenses_subscribe: {
                    required: BX.message('JS_REQUIRED_LICENSES')
                }
            }
        });
    });
</script>

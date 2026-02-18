<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

use Bitrix\Main\Localization\Loc;
?>
<form name="form_popup_subscribe" action="<?=POST_FORM_ACTION_URI;?>" method="post" novalidate="novalidate">
    <?=bitrix_sessid_post();?>

    <input type="hidden" name="ID" value="<?=$arResult['SUBSCRIPTION']['ID'];?>"/>
    <input type="hidden" name="FORMAT" value="html"/>
    <input type="hidden" name="action" value="subscribe"/>

    <?foreach ($arResult['RUBRICS'] as $key => $rubric):?>
        <input type="hidden" name="RUB_ID[]" value="<?=$rubric['ID'];?>"/>
    <?endforeach;?>

    <div class="form-header">
        <div class="text">
            <div class="title font_24 color_333"><?=Loc::getMessage('SUBSCRIBE__POPUP__TITLE');?></div>
        </div>
    </div>

    <div class="form-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="font_13 color_999"><span><?=Loc::getMessage('SUBSCRIBE__POPUP__EMAIL');?>&nbsp;<span class="star">*</span></span></label>
                    <div class="input">
                        <input type="email" class="form-control inputtext input-filed" required name="EMAIL"
                               value="<?=$arResult['USER_EMAIL'] ? $arResult['USER_EMAIL'] : ($arResult['SUBSCRIPTION']['EMAIL'] != '' ? $arResult['SUBSCRIPTION']['EMAIL'] : $arResult['REQUEST']['EMAIL']);?>">
                    </div>
                </div>
            </div>
        </div>

        <?if (TSolution::GetFrontParametrValue('CAPTCHA_ON_SUBSCRIBE') === 'Y'):?>
            <?$arResult['CAPTCHACode'] = $APPLICATION->CaptchaGetCode();?>
            <div class="captcha-row clearfix fill-animate">
                <label class="font_13 color_999"><span><?=GetMessage('FORM_CAPRCHE_TITLE');?>&nbsp;<span class="required-star">*</span></span></label>
                <div class="captcha_image">
                    <img data-src="" src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult['CAPTCHACode']);?>" class="captcha_img" />
                    <input type="hidden" name="captcha_sid" class="captcha_sid" value="<?=htmlspecialcharsbx($arResult['CAPTCHACode']);?>" />
                    <div class="captcha_reload"></div>
                    <span class="refresh"><a href="javascript:;" rel="nofollow"><?=GetMessage('REFRESH');?></a></span>
                </div>
                <div class="captcha_input">
                    <input type="text" class="inputtext form-control captcha" name="captcha_word" size="30" maxlength="50" value="" required />
                </div>
            </div>
        <?endif;?>
    </div>

    <div class="form-footer clearfix">
        <?if (TSolution::GetFrontParametrValue('SHOW_LICENCE') == 'Y' && !$arResult['ID']):?>
            <div class="userconsent-wrap mb mb--32">
                <?TSolution\Functions::showBlockHtml([
                    'FILE' => 'consent/userconsent.php',
                    'PARAMS' => [
                        'OPTION_CODE' => 'AGREEMENT_SUBSCRIBE',
                        'SUBMIT_TEXT' => Loc::getMessage('SUBSCRIBE__POPUP__SUBMIT'),
                        'REPLACE_FIELDS' => [],
                        'INPUT_NAME' => "licenses_subscribe",
                        'INPUT_ID' => "licenses_popup_subscribe",
                    ]
                ]);?>
            </div>
        <?endif;?>
        <div>
            <button type="submit" class="btn btn-default btn-lg has-ripple"><?=Loc::getMessage('SUBSCRIBE__POPUP__SUBMIT');?></button>
        </div>
    </div>
</form>


<script>
    BX.Aspro.Utils.readyDOM(() => {
        $('#popup_subscribe_container form[name="form_popup_subscribe"]').validate({
            ignore: ".ignore",
            highlight: function (element) {
                $(element).parent().addClass('error');
            },
            unhighlight: function (element) {
                $(element).parent().removeClass('error');
            },
            submitHandler: function (form) {
                var $form = $(form);

                if ($form.valid()) {
                    $form.find('button[type="submit"]').attr('disabled', 'disabled');
                    $.ajax({
                        type: 'post',
                        url: $form.attr('action'),
                        data: $form.serialize(),
                        beforeSend: function (xhr, settings) {
                        },
                        success: function (html) {
                            $('#popup_subscribe_container').html(html);
                        },
                        complete: function (xhr, textStatus) {
                        }
                    });
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

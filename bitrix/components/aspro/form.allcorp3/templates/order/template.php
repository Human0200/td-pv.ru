<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

use Bitrix\Main\Localization\Loc;

$bFormErrors = $arResult['isFormErrors'] == 'Y';

$formClassList = '';
if ($arResult['isFormNote'] == 'Y') {
    $formClassList .= ' success';
}
if ($bFormErrors) {
    $formClassList .= ' error';
}
?>
<div class="form order<?=$formClassList;?>">
    <?=$arResult['FORM_HEADER'];?>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <?if ($arResult['isIblockDescription']):?>
                <div class="description">
                    <?if ($arResult['IBLOCK_DESCRIPTION_TYPE'] === 'text'):?>
                        <p><?=$arResult['IBLOCK_DESCRIPTION'];?></p>
                    <?else:?>
                        <?=$arResult['IBLOCK_DESCRIPTION'];?>
                    <?endif;?>
                </div>
            <?endif;?>
        </div>

        <div class="col-md-12 col-sm-12">
            <div class="form-body__fields row flexbox">
                <?if ($bFormErrors):?>
                    <div class="col-md-12">
                        <div class="form-error alert alert-danger">
                            <?=$arResult['FORM_ERRORS_TEXT'];?>
                        </div>
                    </div>
                <?endif;?>

                <?php
                $arQuestionsText = [];

                if (is_array($arResult['QUESTIONS'])) {
                    if ($arResult['QUESTIONS']['MESSAGE']) {
                        $arQuestionMessage = $arResult['QUESTIONS']['MESSAGE'];
                        unset($arResult['QUESTIONS']['MESSAGE']);
                        $arResult['QUESTIONS']['MESSAGE'] = $arQuestionMessage;
                    }

                    foreach ($arResult['QUESTIONS'] as $FIELD_SID => $arQuestion) {
                        if (!empty($arQuestion['NAME'])) {
                            $arQuestionsText[] = $arQuestion['NAME'];
                        }

                        $field = TSolution\Form\Field\Factory::create('iblock', [
                            'FIELD_SID' => $FIELD_SID,
                            'QUESTION' => $arQuestion,
                        ]);

                        $field->draw();

                        if ($field->isTypeDate()) {
                            $templateData['DATETIME'] = true;
                        }
                    }
                }
                ?>
                <?if ($arResult['isUseCaptcha'] === 'Y'):?>
                    <div class="form-control captcha-row captcha-row--margined">
                        <label class="font_14"><span><?=GetMessage('FORM_CAPRCHE_TITLE');?>&nbsp;<span class="required-star">*</span></span></label>
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

            <div class="row">
                <div class="col-md-12 col-sm-12" style="margin-top: 26px;">
                    <?php
                    $showLicence = $arParams['SHOW_LICENCE'] == 'Y';
                    $showOffer = $arParams['SHOW_OFFER'] == 'Y';
                    ?>
                    <?if ($showLicence || $showOffer):?>
                        <div class="userconsent-wrap mb mb--32">
                            <?if ($showLicence):?>
                                <?TSolution\Functions::showBlockHtml([
                                    'FILE' => 'consent/userconsent.php',
                                    'PARAMS' => [
                                        'OPTION_CODE' => $arParams['AGREEMENT_OPTION_CODE'],
                                        'SUBMIT_TEXT' => $arParams['SEND_BUTTON_NAME'],
                                        'REPLACE_FIELDS' => $arQuestionsText ?: [],
                                        'INPUT_NAME' => 'licenses_popup',
                                        'INPUT_ID' => 'licenses',
                                    ]
                                ]);?>
                            <?endif;?>

                            <?if ($showOffer):?>
                                <?TSolution\Functions::showBlockHtml([
                                    'FILE' => 'consent/public_offer.php',
                                    'PARAMS' => [
                                        'INPUT_NAME' => 'public_offer_order',
                                        'INPUT_ID' => 'public_offer_order',
                                    ]
                                ]);?>
                            <?endif;?>
                        </div>
                    <?endif;?>

                    <div class="">
                        <?=str_replace('class="', 'class="btn-lg ', $arResult['SUBMIT_BUTTON']);?>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

    <?=$arResult['FORM_FOOTER'];?>
</div>

<script>
    BX.message({
        FORM_FILE_DEFAULT: '<?=Loc::getMessage('FORM_FILE_DEFAULT');?>',
    });

    BX.Aspro.Utils.readyDOM(() => {
        if (arAsproOptions['THEME']['USE_SALE_GOALS'] !== 'N') {
            const eventdata = {
                goal: 'goal_order_begin'
            };
            BX.onCustomEvent('onCounterGoals', [eventdata]);
        }

        $('.order.form form[name="<?=$arResult['IBLOCK_CODE'];?>"]').validate({
            ignore: ".ignore",
            highlight: function(element) {
                $(element).parent().addClass('error');
            },
            unhighlight: function(element) {
                $(element).parent().removeClass('error');
            },
            submitHandler: function(form) {
                if ($('.order.form form[name="<?=$arResult['IBLOCK_CODE'];?>"]').valid()) {
                    $(form).find('button[type="submit"]').attr("disabled", "disabled");

                    const eventdata = {
                        type: 'form_submit',
                        form: form,
                        form_name: '<?=$arResult['IBLOCK_CODE'];?>'
                    };
                    BX.onCustomEvent('onSubmitForm', [eventdata]);
                }
            },
            errorPlacement: function(error, element) {
                error.insertBefore(element);
            },
            messages: {
                licenses_popup: {
                    required: BX.message('JS_REQUIRED_LICENSES')
                },
                public_offer_popup: {
                    required : BX.message('JS_REQUIRED_LICENSES')
                }
            }
        });

        if (arAsproOptions['THEME']['PHONE_MASK'].length) {
            var base_mask = arAsproOptions['THEME']['PHONE_MASK'].replace(/(\d)/g, '_');

            $('.order.form form[name="<?=$arResult['IBLOCK_CODE'];?>"] input.phone').inputmask("mask", {
                mask: arAsproOptions['THEME']['PHONE_MASK'],
                showMaskOnHover: false
            });

            $('.order.form form[name="<?=$arResult['IBLOCK_CODE'];?>"] input.phone').blur(function() {
                if ($(this).val() == base_mask || $(this).val() == '') {
                    if ($(this).hasClass('required')) {
                        $(this).parent().find('div.error').html(BX.message("JS_REQUIRED"));
                    }
                }
            });
        }

        var sessionID = '<?=bitrix_sessid();?>';
        $('input#SESSION_ID').val(sessionID);

        if (arAsproOptions['THEME']['DATE_MASK'].length) {
            $('.order.form form[name="<?=$arResult['IBLOCK_CODE'];?>"] input.date').inputmask('datetime', {
                inputFormat: arAsproOptions['THEME']['DATE_MASK'],
                placeholder: arAsproOptions['THEME']['DATE_PLACEHOLDER'],
                showMaskOnHover: false
            });
        }

        if (arAsproOptions['THEME']['DATETIME_MASK'].length) {
            $('.order.form form[name="<?=$arResult['IBLOCK_CODE'];?>"] input.datetime').inputmask('datetime', {
                inputFormat: arAsproOptions['THEME']['DATETIME_MASK'],
                placeholder: arAsproOptions['THEME']['DATETIME_PLACEHOLDER'],
                showMaskOnHover: false
            });
        }

        $('input[type=file]').uniform({
            fileButtonHtml: BX.message('JS_FILE_BUTTON_NAME'),
            fileDefaultHtml: BX.message('FORM_FILE_DEFAULT')
        });

        $(document).on('change', 'input[type=file]', function() {
            if ($(this).val()) {
                $(this).closest('.uploader').addClass('files_add');
            } else {
                $(this).closest('.uploader').removeClass('files_add');
            }
        });

        $('.form .add_file').on('click', function() {
            const container = $(this).closest('.input');
            const index = container.find('input[type=file]').length + 1;
            const name = container.find('input[type=file]:first').attr('name');

            $('<input type="file" id="POPUP_FILE" name="' + name.replace('n0', 'n' + index) + '" class="inputfile" value="" />').insertBefore($(this));
            $('input[type=file]').uniform({
                fileButtonHtml: BX.message('JS_FILE_BUTTON_NAME'),
                fileDefaultHtml: BX.message('FORM_FILE_DEFAULT')
            });
        });

        BX?.UserConsent?.loadFromForms?.();
    });
</script>

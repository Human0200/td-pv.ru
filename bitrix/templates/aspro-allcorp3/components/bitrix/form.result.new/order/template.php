<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

use Bitrix\Main\Localization\Loc;
?>
<div class="form order<?=$arResult['FORM_NOTE'] ? ' success' : '';?><?=$arResult['isFormErrors'] == 'Y' ? ' error' : '';?>">
    <!--noindex-->
    <?if ($arResult['isFormErrors'] == 'Y'):?>
        <div class="form-error alert alert-danger"><?=$arResult['FORM_ERRORS_TEXT'];?></div>
    <?endif;?>

    <?=$arResult['FORM_HEADER'];?>

    <?=bitrix_sessid_post();?>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <?if ($arResult['isFormDescription'] == 'Y'):?>
                <div class="description"><?=$arResult['FORM_DESCRIPTION'];?></div>
            <?endif;?>
        </div>

        <div class="col-md-12 col-sm-12">
            <div class="form-body__fields row flexbox">
                <?php
                $arQuestionsText = [];

                if (is_array($arResult['QUESTIONS'])) {
                    foreach ($arResult['QUESTIONS'] as $FIELD_SID => $arQuestion) {
                        if (!empty($arQuestion['CAPTION'])) {
                            $arQuestionsText[] = $arQuestion['CAPTION'];
                        }

                        $field = TSolution\Form\Field\Factory::create('webform', [
                            'FIELD_SID' => $FIELD_SID,
                            'QUESTION' => $arQuestion,
                            'PARAMS' => $arParams,
                            'TYPE' => 'POPUP',
                        ]);

                        $field->draw();

                        if ($field->isTypeDate()) {
                            $templateData['DATETIME'] = true;
                        }
                    }
                }
                ?>
            </div>

            <?if ($arResult['isUseCaptcha'] == 'Y'):?>
                <div class="captcha-row clearfix">
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
            <?elseif ($arParams['HIDDEN_CAPTCHA'] == 'Y'):?>
                <textarea name="nspm" style="display:none;"></textarea>
            <?endif;?>

            <div class="form-footer">
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
                                    'SUBMIT_TEXT' => $arResult['arForm']['BUTTON'],
                                    'REPLACE_FIELDS' => $arQuestionsText ?: [],
                                    'INPUT_NAME' => 'licenses_popup',
                                    'INPUT_ID' => 'licenses_inline_'.$arResult['arForm']['ID'],
                                ]
                            ]);?>
                        <?endif;?>

                        <?if ($showOffer):?>
                            <?TSolution\Functions::showBlockHtml([
                                'FILE' => 'consent/public_offer.php',
                                'PARAMS' => [
                                    'INPUT_NAME' => 'public_offer_popup',
                                    'INPUT_ID' => 'public_offer_inline_'.$arResult['arForm']['ID'],
                                ]
                            ]);?>
                        <?endif;?>
                    </div>
                <?endif;?>

                <div class="">
                    <button type="submit" class="btn btn-default btn-lg">
                        <span>
                            <?=$arResult['arForm']['BUTTON'];?>
                        </span>
                    </button>
                </div>
                <input type="hidden" value="<?=$arResult['arForm']['BUTTON'];?>" name="web_form_submit" />
            </div>
        </div>
    </div>

    <?=$arResult['FORM_FOOTER'];?>
    <!--/noindex-->
    <script type="text/javascript">
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

            var sessionID = '<?=bitrix_sessid();?>';
            $('input[data-sid=SESSION_ID]').val(sessionID);

            $('form[name="<?=$arResult['arForm']['VARNAME'];?>"]').validate({
                highlight: function(element) {
                    $(element).parent().addClass('error');
                },
                unhighlight: function(element) {
                    $(element).parent().removeClass('error');
                },
                submitHandler: function(form) {
                    if ($('form[name="<?=$arResult['arForm']['VARNAME'];?>"]').valid()) {
                        setTimeout(function() {
                            $(form).find('button[type="submit"]').attr("disabled", "disabled");
                        }, 300);

                        const eventdata = {
                            type: 'form_submit',
                            form: form,
                            form_name: '<?=$arResult['arForm']['VARNAME'];?>'
                        };
                        BX.onCustomEvent('onSubmitForm', [eventdata]);
                    }
                },
                errorPlacement: function(error, element) {
                    error.insertBefore(element);
                },
                messages:{
                    licenses_popup: {
                        required: BX.message('JS_REQUIRED_LICENSES')
                    },
                    public_offer_popup: {
                        required: BX.message('JS_REQUIRED_LICENSES')
                    }
                }
            });


            if (arAsproOptions['THEME']['PHONE_MASK'].length) {
                const base_mask = arAsproOptions['THEME']['PHONE_MASK'].replace(/(\d)/g, '_');

                $('form[name="<?=$arResult['arForm']['VARNAME'];?>"] input.phone').inputmask('mask', {
                    mask: arAsproOptions['THEME']['PHONE_MASK'],
                    showMaskOnHover: false
                });

                $('form[name="<?=$arResult['arForm']['VARNAME'];?>"] input.phone').blur(function() {
                    if ($(this).val() == base_mask || $(this).val() == '') {
                        if ($(this).hasClass('required')) {
                            $(this).parent().find('div.error').html(BX.message('JS_REQUIRED'));
                        }
                    }
                });
            }

            if (arAsproOptions['THEME']['DATE_MASK'].length) {
                $('form[name="<?=$arResult['arForm']['VARNAME'];?>"] input.date').inputmask('datetime', {
                    inputFormat: arAsproOptions['THEME']['DATE_MASK'],
                    placeholder: arAsproOptions['THEME']['DATE_PLACEHOLDER'],
                    showMaskOnHover: false
                });
            }

            if (arAsproOptions['THEME']['DATETIME_MASK'].length) {
                $('form[name="<?=$arResult['arForm']['VARNAME'];?>"] input.datetime').inputmask('datetime', {
                    inputFormat: arAsproOptions['THEME']['DATETIME_MASK'],
                    placeholder: arAsproOptions['THEME']['DATETIME_PLACEHOLDER'],
                    showMaskOnHover: false
                });
            }

            $('.jqmClose').on('click', function(e) {
                e.preventDefault();
                $(this).closest('.jqmWindow').jqmHide();
            });

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
                const index = $(this).closest('.input').find('input[type=file]').length + 1;

                $('<input type="file" id="POPUP_FILE" name="FILE_n'+index+'"   class="inputfile" value="">').insertBefore($(this));

                $('input[type=file]').uniform({
                    fileButtonHtml: BX.message('JS_FILE_BUTTON_NAME'),
                    fileDefaultHtml: BX.message('FORM_FILE_DEFAULT')
                });
            });

            BX?.UserConsent?.loadFromForms?.();
        });
    </script>
</div>

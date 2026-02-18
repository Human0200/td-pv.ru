<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

use Bitrix\Main\Localization\Loc;

if (!strlen($arResult['FORM_NOTE']) && $arParams['IGNORE_AJAX_HEAD'] !== 'Y') {
    $GLOBALS['APPLICATION']->ShowAjaxHead();
    ?>
    <span class="jqmClose top-close stroke-theme-hover" onclick="window.b24form = false;" title="<?=Loc::getMessage('CLOSE_BLOCK');?>">
        <?=TSolution::showIconSvg('', SITE_TEMPLATE_PATH.'/images/svg/Close.svg');?>
    </span>
    <?php
}
?>
<div class="flexbox">
    <div class="form popup<?=$arResult['FORM_NOTE'] ? ' success' : '';?><?=$arResult['isFormErrors'] == 'Y' ? ' error' : '';?>">
        <!--noindex-->
        <div class="form-header">
            <?if ($arResult['isFormTitle'] == 'Y'):?>
                <div class="text">
                    <div class="title switcher-title font_24 color_333"><?=$arResult['FORM_NOTE'] ? GetMessage('SUCCESS_TITLE') : $arResult['FORM_TITLE'];?></div>
                    <?if ($arResult['isFormDescription'] == 'Y' && !$arResult['FORM_NOTE']):?>
                        <div class="form_desc form_14 color_666"><?=$arResult['FORM_DESCRIPTION'];?></div>
                    <?endif;?>
                </div>
            <?endif;?>
        </div>

        <?if ($arResult['FORM_NOTE']):?>
            <div class="form-body">
                <div class="form-inner form-inner--popup flex-1">
                    <div class="form-send rounded-4 bordered">
                        <div class="flexbox flexbox--direction-row">
                            <div class="form-send__icon form-send--mr-30">
                                <?=TSolution::showIconSvg('send', SITE_TEMPLATE_PATH.'/images/svg/Form_success.svg');?>
                            </div>

                            <div class="form-send__info form-send--mt-n4">
                                <div class="form-send__info-title switcher-title font_18"><?=Loc::getMessage('PHANKS_TEXT');?></div>
                                <div class="form-send__info-text">
                                    <?if ($arResult['isFormErrors'] == 'Y'):?>
                                        <?=$arResult['FORM_ERRORS_TEXT'];?>
                                    <?else:?>
                                        <?$successNoteFile = SITE_DIR."include/form/success_{$arResult['arForm']['SID']}.php";?>
                                        <?if (Bitrix\Main\IO\File::isFileExists(Bitrix\Main\Application::getDocumentRoot().$successNoteFile)):?>
                                            <?$APPLICATION->IncludeFile($successNoteFile, [], ['MODE' => 'html', 'NAME' => 'Form success note']);?>
                                        <?elseif ($arParams['SUCCESS_MESSAGE']):?>
                                            <?=$arParams['SUCCESS_MESSAGE'];?>
                                        <?else:?>
                                            <?=Loc::getMessage('SUCCESS_SUBMIT_FORM');?>
                                        <?endif;?>
                                        <script>
                                            if (arAsproOptions['THEME']['USE_FORMS_GOALS'] !== 'NONE') {
                                                const id = '_<?=!empty($arResult['arForm']['ID']) ? $arResult['arForm']['ID'] : $arResult['ID'];?>';
                                                const eventdata = {
                                                    goal: 'goal_webform_success' + (arAsproOptions['THEME']['USE_FORMS_GOALS'] === 'COMMON' ? '' : id)
                                                };
                                                BX.onCustomEvent('onCounterGoals', [eventdata]);
                                            }
                                            $('.ocb_frame').addClass('success');
                                        </script>
                                    <?endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <?if ($arParams['DISPLAY_CLOSE_BUTTON'] != 'N'):?>
                    <div class="btn btn-transparent-border btn-lg jqmClose"><?=$arParams['CLOSE_BUTTON_NAME'] ? $arParams['CLOSE_BUTTON_NAME'] : Loc::getMessage('SEND_MORE');?></div>
                <?endif;?>
            </div>
        <?endif;?>

        <?if (!$arResult['FORM_NOTE']):?>
            <?if ($arResult['isFormErrors'] == 'Y'):?>
                <div class="form-error alert alert-danger"><?=$arResult['FORM_ERRORS_TEXT'];?></div>
            <?endif;?>

            <?=$arResult['FORM_HEADER'];?>

            <?=bitrix_sessid_post();?>

            <div class="form-body">
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
                <?else:?>
                    <textarea name="nspm" style="display:none;"></textarea>
                <?endif;?>
            </div>

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
                                    'INPUT_ID' => 'licenses_popup_'.$arResult['arForm']['ID'],
                                ]
                            ]);?>
                        <?endif;?>

                        <?if ($showOffer):?>
                            <?TSolution\Functions::showBlockHtml([
                                'FILE' => 'consent/public_offer.php',
                                'PARAMS' => [
                                    'INPUT_NAME' => 'public_offer_popup',
                                    'INPUT_ID' => 'public_offer_popup_'.$arResult['arForm']['ID'],
                                ]
                            ]);?>
                        <?endif;?>
                    </div>
                <?endif;?>

                <div class="">
                    <button type="submit" class="btn btn-default btn-lg"><span><?=$arResult['arForm']['BUTTON'];?></span></button>
                </div>
                <input type="hidden" value="<?=$arResult['arForm']['BUTTON'];?>" name="web_form_submit" />
            </div>

            <?=$arResult['FORM_FOOTER'];?>
        <?endif;?>
        <!--/noindex-->
        <script type="text/javascript">

        BX.message({
            FORM_FILE_DEFAULT: '<?=Loc::getMessage('FORM_FILE_DEFAULT');?>',
        });

        BX.Aspro.Utils.readyDOM(() => {
            $('.popup form[name="<?=$arResult['arForm']['VARNAME'];?>"]').validate({
                highlight: function(element) {
                    $(element).parent().addClass('error');
                },
                unhighlight: function(element) {
                    $(element).parent().removeClass('error');
                },
                submitHandler: function(form) {
                    if ($('.popup form[name="<?=$arResult['arForm']['VARNAME'];?>"]').valid()) {
                        setTimeout(function() {
                            $(form).find('button[type="submit"]').attr("disabled", "disabled");
                        }, 300);

                        const eventdata = {
                            form,
                            type: 'form_submit',
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
                        required : BX.message('JS_REQUIRED_LICENSES')
                    },
                    public_offer_popup: {
                        required : BX.message('JS_REQUIRED_LICENSES')
                    }
                }
            });

            if (arAsproOptions['THEME']['PHONE_MASK'].length) {
                const base_mask = arAsproOptions['THEME']['PHONE_MASK'].replace(/(\d)/g, '_');

                $('.popup form input.phone').inputmask('mask', {
                    mask: arAsproOptions['THEME']['PHONE_MASK'],
                    showMaskOnHover: false
                });

                $('.popup form input.phone').blur(function() {
                    if ($(this).val() == base_mask || $(this).val() == '') {
                        if ($(this).hasClass('required')) {
                            $(this).parent().find('div.error').html(BX.message('JS_REQUIRED'));
                        }
                    }
                });
            }

            if (arAsproOptions['THEME']['DATE_MASK'].length) {
                $('.popup form input.date').inputmask('datetime', {
                    inputFormat: arAsproOptions['THEME']['DATE_MASK'],
                    placeholder: arAsproOptions['THEME']['DATE_PLACEHOLDER'],
                    showMaskOnHover: false
                });
            }

            if (arAsproOptions['THEME']['DATETIME_MASK'].length) {
                $('.popup form input.datetime').inputmask('datetime', {
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

                $('<input type="file" id="POPUP_FILE" name="FILE_n'+index+'" class="inputfile" value="">').insertBefore($(this));

                $('input[type=file]').uniform({
                    fileButtonHtml: BX.message('JS_FILE_BUTTON_NAME'),
                    fileDefaultHtml: BX.message('FORM_FILE_DEFAULT')
                });
            });

            BX?.UserConsent?.loadFromForms?.();
        });
        </script>
    </div>
</div>

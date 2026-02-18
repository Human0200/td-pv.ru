<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}
use Bitrix\Main\Localization\Loc;

?>
<div class="form inline<?=$arResult['FORM_NOTE'] ? ' success' : '';?><?=$arResult['isFormErrors'] == 'Y' ? ' error' : '';?>  border_block <?=$templateName;?>">
    <div class="top-form bordered_block">
        <?if (strlen($arResult['FORM_NOTE'])):?>
            <!--noindex-->
            <?if ($arResult['isFormTitle'] == 'Y'):?>
                <div class="form-header-text">
                    <div class="text">
                        <h3><?=$arResult['FORM_NOTE'] ? GetMessage('SUCCESS_TITLE') : $arResult['FORM_TITLE'];?></h3>
                        <div class="text_msg">
                            <?$successNoteFile = SITE_DIR."include/form/success_{$arResult['arForm']['SID']}.php";?>
                            <?if (Bitrix\Main\IO\File::isFileExists(Bitrix\Main\Application::getDocumentRoot().$successNoteFile)):?>
                                <?$APPLICATION->IncludeFile($successNoteFile, [], ['MODE' => 'html', 'NAME' => 'Form success note']);?>
                            <?elseif ($arParams['SUCCESS_MESSAGE']):?>
                                <?=$arParams['SUCCESS_MESSAGE'];?>
                            <?else:?>
                                <?=GetMessage('FORM_SUCCESS');?>
                            <?endif;?>
                        </div>
                    </div>
                </div>
            <?endif;?>

            <div class="form_result <?=$arResult['isFormErrors'] == 'Y' ? 'error' : 'success';?>">
                <?if ($arResult['isFormErrors'] == 'Y'):?>
                    <?=$arResult['FORM_ERRORS_TEXT'];?>
                <?else:?>
                    <script>
                        if (arAsproOptions['THEME']['USE_FORMS_GOALS'] !== 'NONE') {
                            const id = '_'+'<?=(isset($arResult['arForm']['ID']) && $arResult['arForm']['ID']) ? $arResult['arForm']['ID'] : $arResult['ID'];?>';
                            const eventdata = {
                                goal: 'goal_webform_success' + (arAsproOptions['THEME']['USE_FORMS_GOALS'] === 'COMMON' ? '' : id)
                            };
                            BX.onCustomEvent('onCounterGoals', [eventdata]);
                        }
                    </script>
                    <?if ($arParams['DISPLAY_CLOSE_BUTTON']):?>
                        <div class="form-footer" style="text-align: left;">
                            <button class="btn-lg <?=$arParams['CLOSE_BUTTON_CLASS'];?>"><?=$arParams['CLOSE_BUTTON_NAME'] ?: GetMessage('RELOAD_PAGE');?></button>
                        </div>
                    <?endif;?>
                <?endif;?>
            </div>
        <?endif;?>

        <?if (!$arResult['FORM_NOTE']):?>
            <?=$arResult['FORM_HEADER'];?>

            <?=bitrix_sessid_post();?>

            <?if ($arResult['isFormDescription'] == 'Y'):?>
                <div class="form-header-text">
                    <div class="text">
                        <div class=""><?=$arResult['FORM_DESCRIPTION'];?></div>
                    </div>
                </div>
            <?endif;?>

            <?if ($arResult['isFormErrors'] == 'Y'):?>
                <div class="form-error alert alert-danger"><?=$arResult['FORM_ERRORS_TEXT'];?></div>
            <?endif;?>

            <div class="form-body questions-block">
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
                <?elseif ($arParams['HIDDEN_CAPTCHA'] == 'Y'):?>
                    <textarea name="nspm" style="display:none;"></textarea>
                <?endif;?>
            </div>

            <div class="form-footer" >
                <?if ($arParams['SHOW_LICENCE'] == 'Y'):?>
                    <div class="userconsent-wrap mb mb--32">
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
                    </div>
                <?endif;?>

                <div class="text-left">
                    <button type="submit" class="btn btn-default btn-lg">
                        <span>
                            <?=$arResult['arForm']['BUTTON'];?>
                        </span>
                    </button>
                </div>
                <input type="hidden" class="btn btn-default btn-lg" value="<?=$arResult['arForm']['BUTTON'];?>" name="web_form_submit">
            </div>

            <?=$arResult['FORM_FOOTER'];?>
        <?endif;?>

        <!--/noindex-->
        <script type="text/javascript">
            BX.message({
                FORM_FILE_DEFAULT: '<?=Loc::getMessage('FORM_FILE_DEFAULT');?>',
            });

            BX.Aspro.Utils.readyDOM(() => {
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
                            required: BX.message('JS_REQUIRED_LICENSES')
                        }
                    }
                });


                if (arAsproOptions['THEME']['PHONE_MASK'].length) {
                    var base_mask = arAsproOptions['THEME']['PHONE_MASK'].replace(/(\d)/g, '_');

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

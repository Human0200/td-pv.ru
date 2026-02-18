<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

$this->setFrameMode(false);
use Bitrix\Main\Localization\Loc;
?>

<?if ($arResult['isFormNote'] !== 'Y' && $arParams['IGNORE_AJAX_HEAD'] !== 'Y'):?>
    <?$GLOBALS['APPLICATION']->ShowAjaxHead();?>
    <span class="jqmClose top-close stroke-theme-hover" onclick="window.b24form = false;" title="<?=Loc::getMessage('CLOSE_BLOCK');?>">
        <?=TSolution::showIconSvg('', SITE_TEMPLATE_PATH.'/images/svg/Close.svg');?>
    </span>
<?endif;?>

<div class="flexbox">
    <div class="form popup<?= $arResult['isFormNote'] == 'Y' ? ' success' : '';?><?= $arResult['isFormErrors'] == 'Y' ? ' error' : '';?>">
        <?if ($arResult['isFormNote'] == 'Y'):?>
            <div class="form-header">
                <div class="text">
                    <div class="title switcher-title font_24 color_333"><?=$arResult['IBLOCK_TITLE'];?></div>
                </div>
            </div>

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
                                            <?=$arParams['~SUCCESS_MESSAGE'];?>
                                        <?else:?>
                                            <?=Loc::getMessage('SUCCESS_SUBMIT_FORM');?>
                                        <?endif;?>
                                        <script>
                                            if (arAsproOptions['THEME']['USE_FORMS_GOALS'] !== 'NONE') {
                                                const id = '_<?=$arParams['IBLOCK_ID'];?>';
                                                const eventdata = {
                                                    goal: 'goal_webform_success' + (arAsproOptions['THEME']['USE_FORMS_GOALS'] === 'COMMON' ? '' : id),
                                                    params: <?=CUtil::PhpToJSObject($arParams, false);?>
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
                    <div class="btn btn-transparent-border btn-lg jqmClose"><?= $arParams['CLOSE_BUTTON_NAME'] ? $arParams['CLOSE_BUTTON_NAME'] : Loc::getMessage('SEND_MORE');?></div>
                <?endif;?>
            </div>
        <?else:?>
            <?=$arResult['FORM_HEADER'];?>

            <div class="form-header">
                <div class="text">
                    <?if ($arResult['isIblockTitle']):?>
                        <div class="title switcher-title font_24 color_333"><?=$arResult['IBLOCK_TITLE'];?></div>
                    <?endif;?>
                    <?php
                    if ($arResult['isIblockDescription'] && $arResult['IBLOCK_DESCRIPTION']) {
                        if ($arResult['IBLOCK_DESCRIPTION_TYPE'] == 'text') {
                            ?>
                            <div class="form_desc form_14 color_666"><p><?=$arResult['IBLOCK_DESCRIPTION'];?></p></div>
                            <?
                        } else {
                            ?>
                            <div class="form_desc form_14 color_666"><?=$arResult['IBLOCK_DESCRIPTION'];?></div>
                            <?
                        }
                    }
                    ?>
                </div>
            </div>

            <?if ($arResult['isFormErrors'] == 'Y'):?>
                <div class="form-error alert alert-danger">
                    <?=$arResult['FORM_ERRORS_TEXT'];?>
                </div>
            <?endif;?>

            <div class="form-body">
                <div class="form-body__fields row flexbox">
                <?php
                $arQuestionsText = [];

                if (is_array($arResult['QUESTIONS'])) {
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
                </div>

                <?if ($arResult['isUseCaptcha'] === 'Y'):?>
                    <div class="form-control captcha-row">
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
                    <script type="text/javascript">BX.onCustomEvent("onRenderCaptcha");</script>
                <?endif;?>
            </div>

            <div class="form-footer clearfix">
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
                                    'INPUT_ID' => 'licenses_popup_'.$arParams['IBLOCK_ID'],
                                ]
                            ]);?>
                        <?endif;?>

                        <?if ($showOffer):?>
                            <?TSolution\Functions::showBlockHtml([
                                'FILE' => 'consent/public_offer.php',
                                'PARAMS' => [
                                    'INPUT_NAME' => 'public_offer_popup',
                                    'INPUT_ID' => 'public_offer_popup_'.$arParams['IBLOCK_ID'],
                                ]
                            ]);?>
                        <?endif;?>
                    </div>
                <?endif;?>
                <div class="">
                    <?=str_replace('class="', 'class="btn-lg ', $arResult['SUBMIT_BUTTON']);?>
                </div>
            </div>

            <?=$arResult['FORM_FOOTER'];?>
        <?endif;?>
    </div>
</div>

<script>
    BX.message({
        FORM_FILE_DEFAULT: '<?= Loc::getMessage('FORM_FILE_DEFAULT');?>',
    });

    BX.Aspro.Utils.readyDOM(() => {
        $('.popup form[name="<?=$arResult['IBLOCK_CODE'];?>"]').validate({
            ignore: ".ignore",
            highlight: function(element) {
                $(element).parent().addClass('error');
            },
            unhighlight: function(element) {
                $(element).parent().removeClass('error');
            },
            submitHandler: function(form) {
                if ($('.popup form[name="<?=$arResult['IBLOCK_CODE'];?>"]').valid()) {
                    $(form).find('button[type="submit"]').attr('disabled', 'disabled');

                    const eventdata = {
                        form,
                        type: 'form_submit',
                        form_name: '<?=$arResult['IBLOCK_CODE'];?>'
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
            var base_mask = arAsproOptions['THEME']['PHONE_MASK'].replace(/(\d)/g, '_');

            $('.popup form[name="<?=$arResult['IBLOCK_CODE'];?>"] input.phone').inputmask('mask', {
                mask: arAsproOptions['THEME']['PHONE_MASK'],
                showMaskOnHover: false
            });

            $('.popup form[name="<?=$arResult['IBLOCK_CODE'];?>"] input.phone').blur(function() {
                if ($(this).val() == base_mask || $(this).val() == '') {
                    if ($(this).hasClass('required')) {
                        $(this).parent().find('div.error').html(BX.message('JS_REQUIRED'));
                    }
                }
            });
        }

        if (arAsproOptions['THEME']['DATE_MASK'].length) {
            $('.popup form[name="<?=$arResult['IBLOCK_CODE'];?>"] input.date').inputmask('datetime', {
                inputFormat: arAsproOptions['THEME']['DATE_MASK'],
                placeholder: arAsproOptions['THEME']['DATE_PLACEHOLDER'],
                showMaskOnHover: false
            });
        }

        if (arAsproOptions['THEME']['DATETIME_MASK'].length) {
            $('.popup form[name="<?=$arResult['IBLOCK_CODE'];?>"] input.datetime').inputmask('datetime', {
                inputFormat: arAsproOptions['THEME']['DATETIME_MASK'],
                placeholder: arAsproOptions['THEME']['DATETIME_PLACEHOLDER'],
                showMaskOnHover: false
            });
        }

        $('.btn.jqmClose').closest('.jqmWindow').jqmAddClose('.jqmClose');

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

            $('<input type="file" id="POPUP_FILE" name="'+name.replace('n0', 'n'+index)+'" class="inputfile" value="" />').insertBefore($(this));
            $('input[type=file]').uniform({
                fileButtonHtml: BX.message('JS_FILE_BUTTON_NAME'),
                fileDefaultHtml: BX.message('FORM_FILE_DEFAULT')
            });
        });

        BX?.UserConsent?.loadFromForms?.();
    });
</script>

<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use Bitrix\Main\Localization\Loc;

?>
<form name="form_popup_subscribe" action="<?= POST_FORM_ACTION_URI ?>" method="post" novalidate="novalidate">
	<?= bitrix_sessid_post() ?>
	<input type="hidden" name="ID" value="<?= $arResult['SUBSCRIPTION']['ID'] ?>"/>
	<input type="hidden" name="FORMAT" value="html"/>
	<input type="hidden" name="action" value="subscribe"/>
	<? foreach ($arResult['RUBRICS'] as $key => $rubric): ?>
		<input type="hidden" name="RUB_ID[]" value="<?= $rubric["ID"] ?>"/>
	<? endforeach; ?>

	<div class="form-header">
		<div class="text">
			<div class="title font_24 color_333"><?= Loc::getMessage('SUBSCRIBE__POPUP__TITLE') ?></div>
		</div>
	</div>

	<div class="form-body">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label class="font_13 color_999"><span><?= Loc::getMessage('SUBSCRIBE__POPUP__EMAIL') ?>&nbsp;<span class="star">*</span></span></label>
					<div class="input">
						<input type="email" class="form-control inputtext input-filed" required name="EMAIL"
							   value="<?= $arResult['USER_EMAIL'] ? $arResult['USER_EMAIL'] : ($arResult['SUBSCRIPTION']['EMAIL'] != "" ? $arResult['SUBSCRIPTION']['EMAIL'] : $arResult['REQUEST']['EMAIL']) ?>">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="form-footer clearfix">
		<? if (CAllcorp3::GetFrontParametrValue('SHOW_LICENCE') == 'Y' && !$arResult['ID']) : ?>
			<div class="licence_block form-checkbox">
				<input type="checkbox" class="form-checkbox__input form-checkbox__input--visible"
					   id="licenses_popup_subscribe" <?= (COption::GetOptionString('aspro.allcorp3', 'LICENCE_CHECKED', 'N') == 'Y' ? 'checked' : ''); ?>
					   name="licenses_subscribe" required value="Y">
				<label for="licenses_popup_subscribe" class="form-checkbox__label">
					<span><? include(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'] . SITE_DIR . "include/licenses_text.php")) ?></span>
					<span class="form-checkbox__box"></span>
				</label>
			</div>
		<? endif ?>
		<div>
			<button type="submit" class="btn btn-default btn-lg has-ripple"><?= Loc::getMessage('SUBSCRIBE__POPUP__SUBMIT') ?></button>
		</div>
	</div>
</form>


<script>
    $(document).ready(function () {
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
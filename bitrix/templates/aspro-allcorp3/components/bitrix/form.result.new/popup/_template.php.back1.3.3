<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main\Localization\Loc;

if (!strlen($arResult["FORM_NOTE"]) && $arParams['IGNORE_AJAX_HEAD'] !== 'Y') {
	$GLOBALS['APPLICATION']->ShowAjaxHead();
	?>
	<span class="jqmClose top-close stroke-theme-hover" onclick="window.b24form = false;" title="<?=Loc::getMessage('CLOSE_BLOCK');?>">
		<?=TSolution::showIconSvg('', SITE_TEMPLATE_PATH.'/images/svg/Close.svg')?>
	</span>
	<?
}
?>
<div class="flexbox">
	<div class="form popup<?=($arResult['FORM_NOTE'] ? ' success' : '')?><?=($arResult['isFormErrors'] == 'Y' ? ' error' : '')?>">
		<!--noindex-->
		<div class="form-header">
			<?if($arResult["isFormTitle"] == "Y"):?>
				<div class="text">
					<div class="title switcher-title font_24 color_333"><?=($arResult['FORM_NOTE'] ? GetMessage("SUCCESS_TITLE") : $arResult["FORM_TITLE"]);?></div>
					<?if($arResult["isFormDescription"] == "Y" && !$arResult['FORM_NOTE']):?>
						<div class="form_desc form_14 color_666"><?=$arResult["FORM_DESCRIPTION"]?></div>
					<?endif;?>
				</div>
			<?endif;?>
		</div>
		<?if ($arResult["FORM_NOTE"]):?>
			<div class="form-body">
				<div class="form-inner form-inner--popup flex-1">
					<div class="form-send rounded-4 bordered">
						<div class="flexbox flexbox--direction-row">
							<div class="form-send__icon form-send--mr-30">
								<?=TSolution::showIconSvg('send', SITE_TEMPLATE_PATH.'/images/svg/Form_success.svg');?>
							</div>
							<div class="form-send__info form-send--mt-n4">
								<div class="form-send__info-title switcher-title font_18"><?=Loc::getMessage("PHANKS_TEXT") ?></div>
								<div class="form-send__info-text">
									<?if ($arResult["isFormErrors"] == "Y"):?>
										<?=$arResult["FORM_ERRORS_TEXT"]?>
									<?else:?>
										<?$successNoteFile = SITE_DIR."include/form/success_{$arResult["arForm"]["SID"]}.php";?>
										<?if (\Bitrix\Main\IO\File::isFileExists(\Bitrix\Main\Application::getDocumentRoot().$successNoteFile)):?>
											<?$APPLICATION->IncludeFile($successNoteFile, array(), array("MODE" => "html", "NAME" => "Form success note"));?>
										<?elseif($arParams["SUCCESS_MESSAGE"]):?>
											<?=$arParams["SUCCESS_MESSAGE"];?>
										<?else:?>
											<?=Loc::getMessage("SUCCESS_SUBMIT_FORM");?>
										<?endif;?>
										<script>
											if (arAllcorp3Options['THEME']['USE_FORMS_GOALS'] !== 'NONE') {
												var id = '_'+'<?=((isset($arResult["arForm"]["ID"]) && $arResult["arForm"]["ID"]) ? $arResult["arForm"]["ID"] : $arResult["ID"] )?>';
												var eventdata = {goal: 'goal_webform_success' + (arAllcorp3Options['THEME']['USE_FORMS_GOALS'] === 'COMMON' ? '' : id)};
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
				<?if ( $arParams["DISPLAY_CLOSE_BUTTON"] != "N" ):?>
					<div class="btn btn-transparent-border btn-lg jqmClose"><?=($arParams["CLOSE_BUTTON_NAME"] ? $arParams["CLOSE_BUTTON_NAME"] : Loc::getMessage("SEND_MORE"));?></div>
				<?endif;?>
			</div>
		<?endif;?>
		<?if(!$arResult["FORM_NOTE"]){?>
			<?if($arResult["isFormErrors"] == "Y"):?>
				<div class="form-error alert alert-danger"><?=$arResult["FORM_ERRORS_TEXT"]?></div>
			<?endif;?>
			<?=$arResult["FORM_HEADER"]?>
			<?=bitrix_sessid_post();?>
			<div class="form-body">
				<div class="form-body__fields row flexbox">
				<?
				if (is_array($arResult["QUESTIONS"])) {
					foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) {
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
				<?if($arResult["isUseCaptcha"] == "Y"):?>
					<div class="captcha-row clearfix fill-animate">
						<label class="font_13 color_999"><span><?=GetMessage("FORM_CAPRCHE_TITLE")?>&nbsp;<span class="required-star">*</span></span></label>
						<div class="captcha_image">
							<img data-src="" src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"])?>" class="captcha_img" />
							<input type="hidden" name="captcha_sid" class="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"])?>" />
							<div class="captcha_reload"></div>
							<span class="refresh"><a href="javascript:;" rel="nofollow"><?=GetMessage("REFRESH")?></a></span>
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
				<?if($arParams["SHOW_LICENCE"] == "Y"):?>
					<div class="licence_block form-checkbox">
						<input type="hidden" name="aspro_<?=VENDOR_SOLUTION_NAME?>_form_validate">
						<input type="checkbox" class="form-checkbox__input form-checkbox__input--visible" id="licenses_popup_<?=$arResult["arForm"]["ID"];?>" <?=(COption::GetOptionString(VENDOR_MODULE_ID, "LICENCE_CHECKED", "N") == "Y" ? "checked" : "");?> name="licenses_popup" required value="Y">
						<label for="licenses_popup_<?=$arResult["arForm"]["ID"];?>" class="form-checkbox__label">
							<span>
								<?include(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].SITE_DIR."include/licenses_text.php"));?>
							</span>
							<span class="form-checkbox__box"></span>
						</label>
					</div>
				<?endif;?>
				<div class="">
				<button type="submit" class="btn btn-default btn-lg"><span><?=$arResult["arForm"]["BUTTON"]?></span></button>
				</div>
				<input type="hidden" value="<?=$arResult["arForm"]["BUTTON"]?>" name="web_form_submit" />
			</div>
			<?=$arResult["FORM_FOOTER"]?>
		<?}?>
		<!--/noindex-->
		<script type="text/javascript">

		BX.message({
            FORM_FILE_DEFAULT: '<?= Loc::getMessage('FORM_FILE_DEFAULT') ?>',
		});
		$(document).ready(function(){
			$('.popup form[name="<?=$arResult["arForm"]["VARNAME"]?>"]').validate({
				highlight: function( element ){
					$(element).parent().addClass('error');
				},
				unhighlight: function( element ){
					$(element).parent().removeClass('error');
				},
				submitHandler: function( form ){
					if( $('.popup form[name="<?=$arResult["arForm"]["VARNAME"]?>"]').valid() ){
						setTimeout(function() {
							$(form).find('button[type="submit"]').attr("disabled", "disabled");
						}, 300);
						var eventdata = {type: 'form_submit', form: form, form_name: '<?=$arResult["arForm"]["VARNAME"]?>'};
						BX.onCustomEvent('onSubmitForm', [eventdata]);
					}
				},
				errorPlacement: function( error, element ){
					error.insertBefore(element);
				},
				messages:{
				licenses_popup: {
					required : BX.message('JS_REQUIRED_LICENSES')
				}
				}
			});

			
			if(arAllcorp3Options['THEME']['PHONE_MASK'].length){
				var base_mask = arAllcorp3Options['THEME']['PHONE_MASK'].replace( /(\d)/g, '_' );
				$('.popup form input.phone').inputmask('mask', {'mask': arAllcorp3Options['THEME']['PHONE_MASK'], 'showMaskOnHover': false });
				$('.popup form input.phone').blur(function(){
					if( $(this).val() == base_mask || $(this).val() == '' ){
						if( $(this).hasClass('required') ){
							$(this).parent().find('div.error').html(BX.message('JS_REQUIRED'));
						}
					}
				});
			}
			
			if(arAllcorp3Options['THEME']['DATE_MASK'].length)
			{
				$('.popup form input.date').inputmask('datetime', {
					'inputFormat':  arAllcorp3Options['THEME']['DATE_MASK'],
					'placeholder': arAllcorp3Options['THEME']['DATE_PLACEHOLDER'],
					'showMaskOnHover': false
				});
			}

			if(arAllcorp3Options['THEME']['DATETIME_MASK'].length)
			{
				$('.popup form input.datetime').inputmask('datetime', {
					'inputFormat':  arAllcorp3Options['THEME']['DATETIME_MASK'],
					'placeholder': arAllcorp3Options['THEME']['DATETIME_PLACEHOLDER'],
					'showMaskOnHover': false
				});
			}

			$('.jqmClose').on('click', function(e){
				e.preventDefault();
				$(this).closest('.jqmWindow').jqmHide();
			})

			$('input[type=file]').uniform({fileButtonHtml: BX.message('JS_FILE_BUTTON_NAME'), fileDefaultHtml: BX.message('FORM_FILE_DEFAULT')});
			$(document).on('change', 'input[type=file]', function(){
				if($(this).val())
				{
					$(this).closest('.uploader').addClass('files_add');
				}
				else
				{
					$(this).closest('.uploader').removeClass('files_add');
				}
			})
			$('.form .add_file').on('click', function(){
				var index = $(this).closest('.input').find('input[type=file]').length+1;
				$('<input type="file" id="POPUP_FILE" name="FILE_n'+index+'"   class="inputfile" value="" />').insertBefore($(this));
				$('input[type=file]').uniform({fileButtonHtml: BX.message('JS_FILE_BUTTON_NAME'), fileDefaultHtml: BX.message('FORM_FILE_DEFAULT')});
			})
		});
		</script>
	</div>
</div>
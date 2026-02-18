<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();?>
<?$this->setFrameMode(true);?>

<?use \Bitrix\Main\Localization\Loc;?>
<div class="form-list <?=$templateName?>-template">
	<?
	$bFonImg = $arParams['TYPE_BLOCK'] == 'BG_IMG';
	$bCompact = $arParams['TYPE_BLOCK'] == 'COMPACT';
	$bNarrow = isset($arParams['NARROW']) && $arParams['NARROW'];
	$bWideImg = !$bFonImg && !$bNarrow && !$bCompact;

	if ($bCompact && $arParams['NO_IMAGE'] == 'Y') {
		$arParams['IMG_PATH'] = '';
	}

	$bCenteredBlock = $arParams['CENTERED'] == 'Y' || (!$arParams['IMG_PATH'] && !$bFonImg);

	$formWrapperClass = '';
	if (!$bCenteredBlock) {
		$formWrapperClass .= ' flexbox flexbox--direction-row';

		if ($bCompact) {
			$formWrapperClass .= ' flexbox--column-t767';
		} else {
			$formWrapperClass .= ' flexbox--column-t991';
		}
		if ($arParams['POSITION_IMAGE'] == 'LEFT') {
			$formWrapperClass .= ' flexbox--direction-row-reverse';
		}
	}
	if ($arParams['IMG_PATH'] && !$bNarrow && !$bFonImg) {
		$formWrapperClass .= ' form--static';
	}

	$bSuccess = $arResult['isFormNote'] == 'Y';

	$formClass = 'form--inline form--'.$arParams['TYPE_BLOCK'];
	if ($arParams['IMG_PATH'] && $bFonImg) {
		$formClass .= ' form--static form--with-bg';
	}	
	if ($arParams['IMG_PATH'] && !$bNarrow) {
		$formClass .= ' form--static';
	}	
	if ($bCenteredBlock) {
		$formClass .= ' form--centered';
	}
	if ($bSuccess) {
		$formClass .= ' form--success';
	}
	if ($arResult['isFormErrors'] == 'Y') {
		$formClass .= ' form--error';
	}
	if ($arParams['LIGHT_TEXT'] == 'Y') {
		$formClass .= ' form--light';
	}
	if ($arParams['LIGHTEN_DARKEN'] == 'Y') {
		$formClass .= ' form--opacity';
	}
	?>
	<?if (!$bWideImg):?>
	<div class="maxwidth-theme">
	<?endif;?>

		<div class="form <?=$formClass?>">

			<?if ($arParams['IMG_PATH'] && $bFonImg):?>
				<div class="form-fon" style="background-image: url(<?=$arParams['IMG_PATH']?>)"></div>
			<?endif;?>

			<div class="form__wrapper <?=$formWrapperClass;?>">
				<!--noindex-->
					<?if (!$bFonImg && $arParams['IMG_PATH']):?>
						<div class="form__img flex-1 form__img--<?=$arParams['TYPE_BLOCK'];?><?=(!$bNarrow ? ' form--static' : '');?>">
							<div class="sticky-block<?=($bWideImg ? ' form__img--WIDE' : '')?>">
								<div class="form-fon" style="background-image: url(<?=$arParams['IMG_PATH']?>)"></div>
							</div>
						</div>
						<div class="form__info flex-1 form__info--<?=$arParams['POSITION_IMAGE'];?>">
							<?if ($bWideImg):?>
								<div class="maxwidth-theme--half">
							<?endif?>
					<?endif?>

					<?=TSolution\Functions::showTitleInLeftBlock([
						'WRAPPER_CLASS' => 'form-header flex-1',
						'PATH' => 'form-list',
						'PARAMS' => $arParams,
					]);?>

					<?if ($bCompact):?>
						<div class="form-btn ">
							<div class="animate-load <?=$arParams["SEND_BUTTON_CLASS"];?>" data-event="jqm" data-param-id="<?=$arParams['IBLOCK_ID']?>" data-name="callback"><?=$arParams["SEND_BUTTON_NAME"]?></div>
						</div>
					<?endif;?>
					<?if ($bSuccess && !$bCompact):?>
						<div class="form-inner form-inner--pt-35 flex-1">
							<div class="form-send rounded-4 bordered">
								<div class="flexbox flexbox--direction-<?=($bCenteredBlock ? 'column' : 'row');?>">
									<div class="form-send__icon form-send--<?=($bCenteredBlock ? 'margined' : 'mr-30');?>">
										<?=TSolution::showIconSvg('send', SITE_TEMPLATE_PATH.'/images/svg/Form_success.svg');?>
									</div>
									<div class="form-send__info<?=($bCenteredBlock ? '' : ' form-send--mt-n7');?>">
										<div class="form-send__info-title switcher-title font_24"><?=Loc::getMessage("PHANKS_TEXT") ?></div>
										<div class="form-send__info-text">
											<?if ($arResult["isFormErrors"] == "Y"):?>
												<?=$arResult["FORM_ERRORS_TEXT"]?>
											<?else:?>
												<?$successNoteFile = SITE_DIR."include/form/success_{$arResult["IBLOCK_CODE"]}.php";?>
												<?if (\Bitrix\Main\IO\File::isFileExists(\Bitrix\Main\Application::getDocumentRoot().$successNoteFile)):?>
													<?$APPLICATION->IncludeFile($successNoteFile, array(), array("MODE" => "html", "NAME" => "Form success note"));?>
												<?elseif($arParams["SUCCESS_MESSAGE"]):?>
													<?=$arParams["SUCCESS_MESSAGE"];?>
												<?else:?>
													<?=Loc::getMessage("SUCCESS_SUBMIT_FORM");?>
												<?endif;?>
												<script>
													if (arAllcorp3Options['THEME']['USE_FORMS_GOALS'] !== 'NONE') {
														var id = '_'+'<?=$arParams["IBLOCK_ID"]?>';
														var eventdata = {goal: 'goal_webform_success' + (arAllcorp3Options['THEME']['USE_FORMS_GOALS'] === 'COMMON' ? '' : id)};
														BX.onCustomEvent('onCounterGoals', [eventdata]);
													}
													$(window).scroll();
												</script>
											<?endif;?>
										</div>
										<?if ( $arParams["DISPLAY_CLOSE_BUTTON"] != "N" ):?>
											<div class="btn btn-transparent-border btn-lg reload-page"><?=($arParams["CLOSE_BUTTON_NAME"] ? $arParams["CLOSE_BUTTON_NAME"] : Loc::getMessage("SEND_MORE"));?></div>
											<div class="close-block stroke-theme-hover reload-page">
												<?=TSolution::showIconSvg('close', SITE_TEMPLATE_PATH.'/images/svg/Close_sm.svg');?>
											</div>
										<?endif;?>
									</div>
								</div>
							</div>
						</div>
					<?endif;?>

					<?if (!$bSuccess && !$bCompact){?>
						<div class="form-inner flex-1">
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
								<?if($arResult["isUseCaptcha"] === "Y"):?>
									<div class="form-control captcha-row fill-animate">
										<?=$arResult["CAPTCHA_CAPTION"];?>
										<div class="captcha_image">
											<img data-src="" src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"])?>" class="captcha_img"/>
											<input type="hidden" name="captcha_sid" class="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"])?>" />
											<div class="captcha_reload"></div>
											<span class="refresh"><a href="javascript:;" rel="nofollow"><?=GetMessage("REFRESH")?></a></span>
										</div>
										<div class="captcha_input">
											<input type="text" class="inputtext form-control captcha" name="captcha_word" size="30" maxlength="50" value="" required />
										</div>
									</div>
								<?endif;?>
							</div>

							<div class="form-footer">
								<?if($arParams["SHOW_LICENCE"] == "Y"):?>
									<div class="licence_block form-checkbox">
										<input type="checkbox" class="form-checkbox__input form-checkbox__input--visible" id="licenses_inline_<?=$arParams["IBLOCK_ID"];?>" <?=(COption::GetOptionString(VENDOR_MODULE_ID, "LICENCE_CHECKED", "N") == "Y" ? "checked" : "");?> name="licenses" required value="Y">
										<label for="licenses_inline_<?=$arParams["IBLOCK_ID"];?>" class="form-checkbox__label">
											<span>
												<?include(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].SITE_DIR."include/licenses_text.php"));?>
											</span>
											<span class="form-checkbox__box"></span>
										</label>
									</div>
								<?endif;?>
								<div class="form-footer__btn">
									<?=$arResult["SUBMIT_BUTTON"];?>
								</div>
							</div>
							<?=$arResult["FORM_FOOTER"]?>
						</div>
					<?}?>

					<?if (!$bFonImg && $arParams['IMG_PATH']):?>
						<?if ($bWideImg):?>
							</div>
						<?endif?>
						</div>
					<?endif?>
				<!--/noindex-->
			</div>
		</div>
	<?if (!$bWideImg):?>
	</div>
	<?endif;?>
</div>
<script>
	$(document).ready(function(){

		$('.form--inline form[name="<?=$arResult["IBLOCK_CODE"]?>"]').validate({
			ignore: ".ignore",
			highlight: function( element ){
				$(element).parent().addClass('error');
			},
			unhighlight: function( element ){
				$(element).parent().removeClass('error');
			},
			submitHandler: function( form ){
				if( $('.form--inline form[name="<?=$arResult["IBLOCK_CODE"]?>"]').valid() ){
					$(form).find('button[type="submit"]').attr('disabled', 'disabled');
					var eventdata = {type: 'form_submit', form: form, form_name: '<?=$arResult["IBLOCK_CODE"]?>'};
					BX.onCustomEvent('onSubmitForm', [eventdata]);
				}
			},
			errorPlacement: function( error, element ){
				error.insertBefore(element);
			},
			messages:{
				licenses: {
					required : BX.message('JS_REQUIRED_LICENSES')
				}
			}
		});

		if(arAllcorp3Options['THEME']['PHONE_MASK'].length){
			var base_mask = arAllcorp3Options['THEME']['PHONE_MASK'].replace( /(\d)/g, '_' );
			$('.form--inline form[name="<?=$arResult['IBLOCK_CODE']?>"] input.phone').inputmask('mask', {'mask': arAllcorp3Options['THEME']['PHONE_MASK'], 'showMaskOnHover': false });
			$('.form--inline form[name="<?=$arResult['IBLOCK_CODE']?>"] input.phone').blur(function(){
				if( $(this).val() == base_mask || $(this).val() == '' ){
					if( $(this).hasClass('required') ){
						$(this).parent().find('div.error').html(BX.message('JS_REQUIRED'));
					}
				}
			});
		}

		if(arAllcorp3Options['THEME']['DATE_MASK'].length)
		{
			$('.form--inline form[name="<?=$arResult["IBLOCK_CODE"]?>"] input.date').inputmask('datetime', {
				'inputFormat':  arAllcorp3Options['THEME']['DATE_MASK'],
				'placeholder': arAllcorp3Options['THEME']['DATE_PLACEHOLDER'],
				'showMaskOnHover': false
			});
		}

		if(arAllcorp3Options['THEME']['DATETIME_MASK'].length)
		{
			$('.form--inline form[name="<?=$arResult["IBLOCK_CODE"]?>"] input.datetime').inputmask('datetime', {
				'inputFormat':  arAllcorp3Options['THEME']['DATETIME_MASK'],
				'placeholder': arAllcorp3Options['THEME']['DATETIME_PLACEHOLDER'],
				'showMaskOnHover': false
			});
		}

		$('.jqmClose').closest('.jqmWindow').jqmAddClose('.jqmClose');

		$('input[type=file]').uniform({fileButtonHtml: BX.message('JS_FILE_BUTTON_NAME'), fileDefaultHtml: BX.message('JS_FILE_DEFAULT')});
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
			var container = $(this).closest('.input'),
				index = container.find('input[type=file]').length+1,
				name = container.find('input[type=file]:first').attr('name');
			$('<input type="file" id="POPUP_FILE" name="'+name.replace('n0', 'n'+index)+'"   class="inputfile" value="" />').insertBefore($(this));
			$('input[type=file]').uniform({fileButtonHtml: BX.message('JS_FILE_BUTTON_NAME'), fileDefaultHtml: BX.message('JS_FILE_DEFAULT')});
		})
	});
</script>
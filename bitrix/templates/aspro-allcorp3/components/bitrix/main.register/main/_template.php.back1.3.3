<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>
<div class="module-form-block-wr registraion-page">
	<?if($USER->IsAuthorized()){
		LocalRedirect($arParams['PERSONAL_PAGE']);
	}else{?>
		<?if (count($arResult["ERRORS"]) > 0){
			foreach ($arResult["ERRORS"] as $key => $error)
				if (intval($key) == 0 && $key !== 0)
					$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);

			ShowError(implode("<br />", $arResult["ERRORS"]));
		}elseif(empty($arResult["ERRORS"]) && !empty($_POST["register_submit_button"]) && $arResult["USE_EMAIL_CONFIRMATION"] === "Y"){?>
		    <p><?echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p>
		<?}elseif( empty($arResult["ERRORS"]) && !empty($_POST["register_submit_button"]) && $arResult["USE_EMAIL_CONFIRMATION"]=="N"){
			LocalRedirect($arParams['PERSONAL_PAGE']);
		}else{?>
			<div class="form border_block">
				<div class="wrap_md">
					<div class="main_info iblock max-form-block">
						<div class="top">
							<?$APPLICATION->IncludeFile(SITE_DIR."include/register_description.php", Array(), Array("MODE" => "html", "NAME" => GetMessage("REGISTER_INCLUDE_AREA"), ));?>
						</div>
						<script>
							$(document).ready(function(){
								$.validator.addClassRules({
									'phone_input':{
										regexp: arAllcorp3Options['THEME']['VALIDATE_PHONE_MASK']
									}
								})
								$("form#registraion-page-form").validate
								({
									rules:{ emails: "email"},
									messages: {
										"captcha_word": {
											remote: '<?=GetMessage("VALIDATOR_CAPTCHA")?>'
										},
										licenses_popup: {
									        required : BX.message('JS_REQUIRED_LICENSES')
									      }
									},
									submitHandler: function( form ){
										// $('input#input_LOGIN').val($('input#input_EMAIL').val());
										var eventdata = {type: 'form_submit', form: form, form_name: 'REGISTER'};
										BX.onCustomEvent('onSubmitForm', [eventdata]);
									},
									errorPlacement: function( error, element ){
										error.insertBefore(element);
									}
								});
								$("form[name=bx_auth_servicesform_inline]").validate();

								if(arAllcorp3Options['THEME']['PHONE_MASK'].length){
									var base_mask = arAllcorp3Options['THEME']['PHONE_MASK'].replace( /(\d)/g, '_' );
									$('form#registraion-page-form input.phone_input').inputmask('mask', {'mask': arAllcorp3Options['THEME']['PHONE_MASK'], 'showMaskOnHover': false });
									$('form#registraion-page-form input.phone_input').blur(function(){
										if( $(this).val() == base_mask || $(this).val() == '' ){
											if( $(this).hasClass('required') ){
												$(this).parent().find('label.error').html(BX.message('JS_REQUIRED'));
											}
										}
									});
								}
							})
						</script>

						<div class="auth__services">
							<?$APPLICATION->IncludeComponent(
								"bitrix:system.auth.form",
								"popup",
								array(
									"TITLE" => "",
									"PROFILE_URL" => SITE_DIR."cabinet/",
									"SHOW_ERRORS" => "Y",
									"POPUP_AUTH" => "Y",
								)
							);?>
						</div>

						<form id="registraion-page-form" method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data" >
							<?if($arResult["BACKURL"] <> ''):?>
								<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
							<?endif;?>
							<input type="hidden" name="register_submit_button" value="reg" />
							<?
							$arTmpField=$arFields=$arUFields=array();
							$arTmpField=array_combine($arResult['SHOW_FIELDS'], $arResult['SHOW_FIELDS']);
							unset($arTmpField["PASSWORD"]);
							unset($arTmpField["CONFIRM_PASSWORD"]);

							if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"){
								foreach($arParams["USER_PROPERTY"] as $name){
									$arUFields[$name]=$arResult["USER_PROPERTIES"]["DATA"][$name];
								}
							}

							if($arParams["SHOW_FIELDS"]){
								foreach($arParams["SHOW_FIELDS"] as $name){
									$arFields[$arTmpField[$name]]=$name;
								}
							}else{
								$arFields=$arTmpField;
							}
							$arFields["PASSWORD"]="PASSWORD";
							$arFields["CONFIRM_PASSWORD"]="CONFIRM_PASSWORD";
							$arFields["LOGIN"]="LOGIN";
							$class = "form-control bg-color";

							global $arTheme;
							if($arTheme['CABINET']['DEPENDENT_PARAMS']["PERSONAL_ONEFIO"]["VALUE"] != "N")
							{
								unset($arFields["LAST_NAME"]);
								unset($arFields["SECOND_NAME"]);
							}
							?>
							<?foreach ($arFields as $FIELD):?>
								<?if(($FIELD != "LOGIN" && $arTheme['CABINET']['DEPENDENT_PARAMS']["LOGIN_EQUAL_EMAIL"]["VALUE"] == "Y") || $arTheme['CABINET']['DEPENDENT_PARAMS']["LOGIN_EQUAL_EMAIL"]["VALUE"] != "Y"):?>
									<div class="form-group fill-animate <?=($arResult["VALUES"][$FIELD] ? 'input-filed' : '');?>">
										<div class="wrap_md">
											<div class="iblock label_block">
												<label class="font_13 color_666" for="input_<?=$FIELD;?>">
												<?=(($arTheme['CABINET']['DEPENDENT_PARAMS']["PERSONAL_ONEFIO"]["VALUE"] != "N" && $FIELD == "NAME") ? GetMessage("REGISTER_FIELD_ONENAME") : GetMessage("REGISTER_FIELD_".$FIELD));?> <?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="required-star">*</span><?endif;?>
												</label>
											<?if( array_key_exists( $FIELD, $arResult["ERRORS"] ) ):?>
												<?$class.=' error'?>
											<?endif;?>
											<div class="input">
								<?endif;?>
											<?switch ($FIELD){
												case "PASSWORD":?>
													<input size="30" type="password" id="input_<?=$FIELD;?>" name="REGISTER[<?=$FIELD?>]" required value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off" class="form-control bg-color password <?=(array_key_exists( $FIELD, $arResult["ERRORS"] ))? 'error': ''?>"  />

												<?break;
												case "CONFIRM_PASSWORD":?>
													<input size="30" type="password" id="input_<?=$FIELD;?>" name="REGISTER[<?=$FIELD?>]" required value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off" class="form-control bg-color confirm_password <?=(array_key_exists( $FIELD, $arResult["ERRORS"] ))? 'error': ''?>" />

												<?break;
												case "PERSONAL_GENDER":?>
													<select name="REGISTER[<?=$FIELD?>]" id="input_<?=$FIELD;?>">
														<option value=""><?=GetMessage("USER_DONT_KNOW")?></option>
														<option value="M"<?=$arResult["VALUES"][$FIELD] == "M" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_MALE")?></option>
														<option value="F"<?=$arResult["VALUES"][$FIELD] == "F" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_FEMALE")?></option>
													</select>
													<?break;
												case "PERSONAL_COUNTRY":
												case "WORK_COUNTRY":?>
													<select name="REGISTER[<?=$FIELD?>]" id="input_<?=$FIELD;?>">
														<?foreach ($arResult["COUNTRIES"]["reference_id"] as $key => $value){?>
															<option value="<?=$value?>"<?if ($value == $arResult["VALUES"][$FIELD]):?> selected="selected"<?endif?>><?=$arResult["COUNTRIES"]["reference"][$key]?></option>
														<?}?>
													</select>
													<?break;
												case "PERSONAL_PHOTO":
												case "WORK_LOGO":?>
													<input size="30" type="file" class="form-control bg-color" id="input_<?=$FIELD;?>" name="REGISTER_FILES_<?=$FIELD?>" />
													<?break;
												case "PERSONAL_NOTES":
												case "WORK_NOTES":?>
													<textarea cols="30" rows="5" class="form-control bg-color" id="input_<?=$FIELD;?>" name="REGISTER[<?=$FIELD?>]"><?=$arResult["VALUES"][$FIELD]?></textarea>

												<?case "PERSONAL_STREET":?>
													<textarea cols="30" rows="5" class="form-control bg-color" id="input_<?=$FIELD;?>" name="REGISTER[<?=$FIELD?>]"><?=$arResult["VALUES"][$FIELD]?></textarea>
													<?break;?>
												<?case "EMAIL":?>
													<?//print_r($arResult);?>
													<input size="30" type="email" id="input_<?=$FIELD;?>" name="REGISTER[<?=$FIELD?>]" <?=($arResult["EMAIL_REQUIRED"] || in_array($FIELD, $arResult["REQUIRED_FIELDS"]) ? "required" : "");?> value="<?=$arResult["VALUES"][$FIELD]?>" class="<?=$class?>" id="emails"/>
												<?break;?>
												<?case "NAME":?>
													<input size="30" type="text" id="input_<?=$FIELD;?>" name="REGISTER[<?=$FIELD?>]" <?=($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y" ? "required": "");?> value="<?=$arResult["VALUES"][$FIELD]?>" class="<?=$class?>"/>
												<?break;?>
												<?case "PERSONAL_PHONE":?>
													<input size="30" type="text" id="input_<?=$FIELD;?>" name="REGISTER[<?=$FIELD?>]" class="form-control bg-color phone_input <?=(array_key_exists( $FIELD, $arResult["ERRORS"] ))? 'error': ''?>" <?=($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y" ? "required": "");?> value="<?=$arResult["VALUES"][$FIELD]?>" />
												<?break;?>
												<?break;
												default:?>
													<?// hide login?>
													<input size="30" id="input_<?=$FIELD;?>" class="form-control bg-color" <?=(($FIELD == "LOGIN" && $arTheme['CABINET']['DEPENDENT_PARAMS']["LOGIN_EQUAL_EMAIL"]["VALUE"] == "Y") ? 'type="hidden" value="1"' : 'type="text"');?> name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" />
													<?if ($FIELD == "PERSONAL_BIRTHDAY"){?>
														<?$APPLICATION->IncludeComponent(
															'bitrix:main.calendar',
															'',
															array(
																'SHOW_INPUT' => 'N',
																'FORM_NAME' => 'regform',
																'INPUT_NAME' => 'REGISTER[PERSONAL_BIRTHDAY]',
																'SHOW_TIME' => 'N'
															),
															null,
															array("HIDE_ICONS"=>"Y")
														);?>
													<?}?>
													<?break;?>
											<?}?>
									<?if(($FIELD != "LOGIN" && $arTheme['CABINET']['DEPENDENT_PARAMS']["LOGIN_EQUAL_EMAIL"]["VALUE"] == "Y") || $arTheme['CABINET']['DEPENDENT_PARAMS']["LOGIN_EQUAL_EMAIL"]["VALUE"] != "Y"):?>
											</div>
											<?if(array_key_exists( $FIELD, $arResult["ERRORS"] ) ):?>
												<label class="error"><?=GetMessage("REGISTER_FILL_IT")?></label>
											<?endif;?>
											</div>
											<div class="iblock text_block">
												<?if($arTheme['CABINET']['DEPENDENT_PARAMS']["LOGIN_EQUAL_EMAIL"]["VALUE"] == "Y" && $FIELD == 'EMAIL'):?>
													<?=GetMessage("REGISTER_FIELD_TEXT_".$FIELD.'_EQUAL');?>
												<?else:?>
													<?=GetMessage("REGISTER_FIELD_TEXT_".$FIELD);?>
												<?endif;?>
											</div>
										</div>
									</div>
									<?endif;?>
							<?endforeach?>
							<?if($arUFields){?>
								<?foreach($arUFields as $arUField){?>
									<div class="r">
										<label><?=$arUField["EDIT_FORM_LABEL"];?>:<?if ($arUField["MANDATORY"] == "Y"):?><span class="star">*</span><?endif;?></label>
										<?$APPLICATION->IncludeComponent(
										"bitrix:system.field.edit",
										$arUField["USER_TYPE"]["USER_TYPE_ID"],
										array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));?>
									</div>
								<?}?>
							<?}?>
							<?if ($arResult["USE_CAPTCHA"] == "Y"){?>
								<div class="row captcha-row captcha-row--inline">
									<div class="col-md-12">
										<label for="captcha_word" class="font_13 color_666"><?=(TSolution\ReCaptcha::checkRecaptchaActive() ? GetMessage("FORM_GENERAL_RECAPTCHA") : GetMessage("REGISTER_CAPTCHA_PROMT"))?> <span class="required-star">*</span></label>
										<div class="captcha_image">
											<img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHA_CODE"])?>" class="captcha_img" border="0" />
											<input type="hidden" name="captcha_sid" class="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHA_CODE"])?>" />
											<div class="captcha_reload"></div>
											<span class="refresh"><a href="javascript:;" rel="nofollow"><?=GetMessage("REFRESH")?></a></span>
										</div>
										<div class="captcha_input">
											<input type="text" class="inputtext form-control captcha" name="captcha_word" size="30" maxlength="50" value="" required />
										</div>
									</div>
								</div>
							<?}?>
							<?if(COption::GetOptionString(VENDOR_MODULE_ID, "SHOW_LICENCE", "N") == "Y"):?>
								<div class="form-group bg-color">
									<div class="wrap_md">
										<div class="iblock label_block">
											<div class="licence_block form-checkbox">
												<input type="checkbox" id="licenses_reg" name="licenses_popup" <?=($arTheme["SHOW_LICENCE"]["DEPENDENT_PARAMS"]["LICENCE_CHECKED"]["VALUE"] == "Y" ? "checked" : "");?> required value="Y" class="form-checkbox__input form-checkbox__input--visible">
												<label for="licenses_reg" class="form-checkbox__label">
													<span>
														<?include(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].SITE_DIR."include/licenses_text.php"));?>
													</span>
													<span class="form-checkbox__box"></span>
												</label>
											</div>
										</div>
									</div>
								</div>
							<?endif;?>
							<div class="but-r">
								<button class="btn btn-default btn-lg bold register" type="submit" name="register_submit_button1" value="<?=GetMessage("AUTH_REGISTER")?>">
									<?=GetMessage("REGISTER_REGISTER")?>
								</button>
								<div class="clearboth"></div>
							</div>
						</form>
					</div>
					<?/*
					<div class="social_block iblock">
						<?$APPLICATION->IncludeComponent(
							"bitrix:system.auth.form",
							"main",
							array(
								"PROFILE_URL" => $arParams["PATH_TO_PERSONAL"],
								"SHOW_ERRORS" => "Y",
								"POPUP_AUTH" => "Y"
							)
						);?>
					</div>
					*/?>
				</div>
			</div>
		<?}?>
	<?}?>
</div>
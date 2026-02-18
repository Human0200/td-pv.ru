<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(
	$arResult['ERROR'] &&
	$arResult['ERROR_MESSAGE']['TYPE'] === 'ERROR' &&
	$arResult['ERROR_MESSAGE']['ERROR_TYPE'] === 'CHANGE_PASSWORD' &&
	$arParams['CHANGE_PASSWORD_URL']
):?>
	<?$_SESSION['arAuthResult'] = $APPLICATION->arAuthResult;?>
	<script>
	location.href = '<?=$arParams['CHANGE_PASSWORD_URL'].(strlen($arResult['BACKURL']) ? (strpos($arParams['CHANGE_PASSWORD_URL'], '?') ? '&' : '?').'backurl='.$arResult['BACKURL'] : '')?>';
	</script>
<?else:?>
	<?/*<link rel="stylesheet" type="text/css" href="/bitrix/js/socialservices/css/ss.css">*/?>
	<?if( $arResult["FORM_TYPE"] == "login" ){?>
		<div id="ajax_auth" class="auth-page pk-page">
			<div class="auth form-block">
				<div class="form">
					<div class="form-body">
						<?if( $arResult["ERROR"] ){?>
							<div class="alert alert-danger">
								<?if($arResult['ERROR_MESSAGE']['MESSAGE']):?>
									<p><?=$arResult['ERROR_MESSAGE']['MESSAGE']?></p>
								<?else:?>
									<p><?=GetMessage('AUTH_ERROR')?></p>
								<?endif;?>
							</div>
						<?}?>
						
						<?if($arResult["AUTH_SERVICES"]):?>
							<div class="auth__services">
								<?$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "icons",
									array(
										"AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
										"AUTH_URL" => SITE_DIR."cabinet/?login=yes",
										"POST" => $arResult["POST"],
										"SUFFIX" => "form",
									),
									$component, array("HIDE_ICONS"=>"Y")
								);
								?>
							</div>
						<?endif;?>

						<form id="avtorization-form" name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arParams["AUTH_URL"]?>?login=yes">
							<?if($arResult["BACKURL"] <> ''):?>
								<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
							<?endif?>
							<?/*foreach ($arResult["POST"] as $key => $value):?><input type="hidden" name="<?=$key?>" value="<?=$value?>" /><?endforeach*/?>
							<input type="hidden" name="AUTH_FORM" value="Y" />
							<input type="hidden" name="TYPE" value="AUTH" />

							<div class="row" data-sid="USER_LOGIN_POPUP">
								<div class="form-group fill-animate">
									<div class="col-md-12">
										<label class="font_13 color_999" for="USER_LOGIN_POPUP"><?=GetMessage("AUTH_LOGIN")?> <span class="required-star">*</span></label>
										<div class="input">
											<input type="text" name="USER_LOGIN" id="USER_LOGIN_POPUP" class="form-control required" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" autocomplete="on" tabindex="1"/>
										</div>
									</div>
								</div>
							</div>
							<div class="row" data-sid="USER_PASSWORD_POPUP">
								<div class="form-group fill-animate">
									<div class="col-md-12">
										<label class="font_13 color_999" for="USER_PASSWORD_POPUP"><?=GetMessage("AUTH_PASSWORD")?> <span class="required-star">*</span></label>
										<div class="input">
											<input type="password" name="USER_PASSWORD" id="USER_PASSWORD_POPUP" class="form-control required" maxlength="50" value="" autocomplete="on" tabindex="2"/>
										</div>
									</div>
								</div>
							</div>

							<?if ($arResult["CAPTCHA_CODE"]):?>
								<div class="captcha-row form-group fill-animate captcha-row--margined">
									<label class="font_13 color_999" for="captcha_word"><?=GetMessage("AUTH_CAPTCHA_PROMT")?> <span class="required-star">*</span></label>
									<div class="captcha_image">
										<img data-src="" src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHA_CODE"])?>" class="captcha_img" />
										<input type="hidden" name="captcha_sid" class="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHA_CODE"])?>" />
										<div class="captcha_reload"></div>
										<span class="refresh"><a href="javascript:;" rel="nofollow"><?=GetMessage("REFRESH")?></a></span>
									</div>
									<div class="captcha_input">
										<input type="text" class="inputtext form-control captcha" name="captcha_word" size="30" maxlength="50" value="" required />
									</div>
								</div>
							<?endif?>
							<div class="auth__bottom">
								<div class="auth__bottom-action">
									<div class="line-block line-block--20 flexbox--wrap flexbox--justify-beetwen">
										<div class="line-block__item">
											<div class="prompt remember pull-left form-checkbox">
												<input type="checkbox" class="form-checkbox__input" id="USER_REMEMBER_frm" name="USER_REMEMBER" value="Y" tabindex="5"/>
												<label for="USER_REMEMBER_frm" tabindex="5" class="form-checkbox__label form-checkbox__label--sm">
													<span><?echo GetMessage("AUTH_REMEMBER_SHORT")?></span>
													<span class="form-checkbox__box"></span>
												</label>
											</div>
										</div>
										<div class="line-block__item font_13">
											<a class="forgot" href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"];?>" tabindex="3"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
										</div>
									</div>
								</div>
								<div class="auth__bottom-btns">
									<div class="line-block line-block--32 flexbox--justify-beetwen">
										<div class="line-block__item flex-1">
											<button type="submit" class="btn btn-default btn-lg auth__bottom-btn" name="Login" value="" tabindex="4">
												<span><?=GetMessage("AUTH_LOGIN_BUTTON")?></span>
											</button>
										</div>
										<div class="line-block__item flex-1">
											<?if(\Bitrix\Main\Config\Option::get('main', 'new_user_registration', 'N', NULL) == 'Y'):?>
												<!--noindex-->
													<a href="<?=$arResult["AUTH_REGISTER_URL"];?>" rel="nofollow" class="btn btn-default btn-transparent-border btn-lg auth__bottom-btn" tabindex="6">
														<?=GetMessage("AUTH_REGISTER_NEW")?>
													</a>
												<!--/noindex-->
											<?endif;?>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>

				<script>
				$(document).ready(function(){
					$("form[name=bx_auth_servicesform]").validate();
					$('form#avtorization-form').validate({
						rules:{
							USER_LOGIN:{
								required:true
							}
						},
						submitHandler: function( form ){
							if( $( form ).valid() ){
								if(BX('wrap_ajax_auth')){
									jsAjaxUtil.CloseLocalWaitWindow( 'id', 'wrap_ajax_auth' );
									jsAjaxUtil.ShowLocalWaitWindow( 'id', 'wrap_ajax_auth', true );
								}

								var bCaptchaInvisible = false;
								if(window.renderRecaptchaById && window.asproRecaptcha && window.asproRecaptcha.key)
								{
									if(window.asproRecaptcha.params.recaptchaSize == 'invisible')
									{
										if(!$(form).find('.g-recaptcha-response').val())
										{
											grecaptcha.execute($(form).find('.g-recaptcha').data('widgetid'));
											bCaptchaInvisible = true;
										}
									}
								}
								if(!bCaptchaInvisible)
								{
									$.ajax({
										type: "POST",
										url: $(form).attr('action'),
										data: $(form).serialize()
									}).done(function( html ){
										if($(html).find('.alert').length){
											$('#ajax_auth').html( html );
											//show password eye
											$('#ajax_auth').find(".form-group:not(.eye-password-ignore) [type=password]").each(function (item) {
													$(this).closest(".form-group").addClass("eye-password");
												});
										}
										else{
											var match = html.match(/location\.href\s*=\s*['"]([^'"]*)['"]/);
											if (match) {
												location.href = match[1];
											}
											else{
												BX.reload(false);
											}
										}

										if(BX('wrap_ajax_auth')){
											jsAjaxUtil.CloseLocalWaitWindow( 'id', 'wrap_ajax_auth' );
										}
									});
								}

							}
						},
						errorPlacement: function( error, element ){
							$(error).attr( 'alt', $(error).text());
							$(error).attr( 'title', $(error).text());
							error.insertBefore( element );
						}
					});
				})
				</script>
			</div>
		</div>
	<?}else{?>
		<script>
		BX.reload(true);
		</script>
	<?}?>
	<?// need pageobject.js for BX.reload()?>
	<script>
	BX.loadScript(['<?=Bitrix\Main\Page\Asset::getInstance()->getFullAssetPath('/bitrix/js/main/pageobject/pageobject.js')?>']);
	</script>
<?endif;?>
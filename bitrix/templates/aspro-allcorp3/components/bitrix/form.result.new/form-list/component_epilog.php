<?global $USER;?>
<?Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("form-block".$arParams["WEB_FORM_ID"]);?>
<script type="text/javascript">
$(document).ready(function() {
	<?if($USER->IsAuthorized()):?>
		<?
		$dbRes = CUser::GetList(($by = "id"), ($order = "asc"), array("ID" => $USER->GetID()), array("FIELDS" => array("ID", "PERSONAL_PHONE")));
		$arUser = $dbRes->Fetch();

		$fio = $USER->GetFullName();
		$phone = $arUser['PERSONAL_PHONE'];
		$email = $USER->GetEmail();
		?>
		try{
			<?if ($fio):?>
				$('.form.form--inline input[data-sid=CLIENT_NAME], .form.form--inline input[data-sid=FIO], .form.form--inline input[data-sid=NAME]').val('<?=$fio?>').addClass('input-filed');
			<?endif;?>
			<?if ($phone):?>
				$('.form.form--inline input[data-sid=PHONE]').val('<?=$phone?>').addClass('input-filed');
			<?endif;?>
			<?if ($email):?>
				$('.form.form--inline input[data-sid=EMAIL]').val('<?=$email?>').addClass('input-filed');
			<?endif;?>
		}
		catch(e){
		}
	<?endif;?>
	BX.onCustomEvent('formCustomHandlers', []);
});
</script>
<?Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("form-block".$arParams["WEB_FORM_ID"], "");?>
<?
$arExtenstions = ['form_custom_handlers'];
if (isset($templateData['DATETIME'])) {
	$arExtenstions[] = 'datetimepicker_init';
}

TSolution\Extensions::initInPopup($arExtenstions);
?>
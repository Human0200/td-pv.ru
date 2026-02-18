<?global $USER;?>
<?Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("form-block".$arParams["IBLOCK_ID"]);?>
<script>
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
				$('.form.form--inline input[id=CLIENT_NAME], .form.form--inline input[id=FIO], .form.form--inline input[id=NAME]').val('<?=$USER->GetFullName()?>');
			<?endif;?>
			<?if ($phone):?>
				$('.form.form--inline input[id=PHONE]').val('<?=$arUser['PERSONAL_PHONE']?>');
			<?endif;?>
			<?if ($email):?>
				$('.form.form--inline input[id=EMAIL]').val('<?=$USER->GetEmail()?>');
			<?endif;?>
		}
		catch(e){}
	<?endif;?>
	// customizable form handlers
	BX.onCustomEvent('formCustomHandlers', []);
});
</script>
<?Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("form-block".$arParams["IBLOCK_ID"], "");?>
<?
$arExtenstions = ['form_custom_handlers'];
if (isset($templateData['DATETIME'])) {
	$arExtenstions[] = 'datetimepicker_init';
}

TSolution\Extensions::initInPopup($arExtenstions);
?>
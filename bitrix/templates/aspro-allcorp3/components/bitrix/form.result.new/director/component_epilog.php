<?global $USER;?>
<?Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("form-block".$arParams["WEB_FORM_ID"]);?>
<?if($USER->IsAuthorized()):?>
	<?
	$dbRes = CUser::GetList(($by = "id"), ($order = "asc"), array("ID" => $USER->GetID()), array("FIELDS" => array("ID", "PERSONAL_PHONE")));
	$arUser = $dbRes->Fetch();
	?>
	<script type="text/javascript">
	$(document).ready(function() {
		try{
			$('.form input[data-sid=CLIENT_NAME], .form input[data-sid=FIO], .form input[data-sid=NAME]').val('<?=$USER->GetFullName()?>');
			$('.form input[data-sid=PHONE]').val('<?=$arUser['PERSONAL_PHONE']?>');
			$('.form input[data-sid=EMAIL]').val('<?=$USER->GetEmail()?>');
		}
		catch(e){
		}
	});
	</script>
<?endif;?>
<?Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("form-block".$arParams["WEB_FORM_ID"], "");?>
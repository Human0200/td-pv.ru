<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//***********************************
//status and unsubscription/activation section
//***********************************
?>
<div class="status-block top-form">
	<h4><?echo GetMessage("subscr_title_status")?></h4>
	<form action="<?=$arResult["FORM_ACTION"]?>" method="get">
			<div class="wrap-half-block">
				<div>
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
						<tr valign="top">
							<td><span><?echo GetMessage("subscr_conf")?></span></td>
							<td class="td_right <?echo ($arResult["SUBSCRIPTION"]["CONFIRMED"] == "Y"? "notetext":"errortext")?>"><span><?echo ($arResult["SUBSCRIPTION"]["CONFIRMED"] == "Y"? GetMessage("subscr_yes"):GetMessage("subscr_no"));?></span></td>
						</tr>
						<tr>
							<td><span><?echo GetMessage("subscr_act")?></span></td>
							<td class="td_right <?echo ($arResult["SUBSCRIPTION"]["ACTIVE"] == "Y"? "notetext":"errortext")?>"><span><?echo ($arResult["SUBSCRIPTION"]["ACTIVE"] == "Y"? GetMessage("subscr_yes"):GetMessage("subscr_no"));?></span></td>
						</tr>
						<tr>
							<td><span><?echo GetMessage("adm_id")?></span></td>
							<td class="td_right"><span><?echo $arResult["SUBSCRIPTION"]["ID"];?>&nbsp;</span></td>
						</tr>
						<?if($arResult["SUBSCRIPTION"]["DATE_INSERT"]):?>
							<tr>
								<td><span><?echo GetMessage("subscr_date_add")?></span></td>
								<td class="td_right"><span><?echo FormatDateFromDB($arResult["SUBSCRIPTION"]["DATE_INSERT"], 'SHORT');?>&nbsp;</span></td>
							</tr>
						<?endif;?>
						<?if($arResult["SUBSCRIPTION"]["DATE_UPDATE"]):?>
							<tr>
								<td><span><?echo GetMessage("subscr_date_upd")?></td>
								<td class="td_right"><span><?echo FormatDateFromDB($arResult["SUBSCRIPTION"]["DATE_UPDATE"], 'SHORT');?>&nbsp;</span></td>
							</tr>
						<?endif;?>
					</table>
				</div>
				<div class="text_block">
				<?if($arResult["SUBSCRIPTION"]["CONFIRMED"] <> "Y"):?>
					<p><?echo GetMessage("subscr_title_status_note1")?></p>
				<?elseif($arResult["SUBSCRIPTION"]["ACTIVE"] == "Y"):?>
					<p class="mb-10"><?echo GetMessage("subscr_title_status_note2")?></p>
					<p><?echo GetMessage("subscr_status_note3")?></p>
				<?else:?>
					<p class="mb-10"><?echo GetMessage("subscr_status_note4")?></p>
					<p><?echo GetMessage("subscr_status_note5")?></p>
				<?endif;?>
				</div>
			</div>
			
	<?if($arResult["SUBSCRIPTION"]["CONFIRMED"] == "Y"):?>	
		<div class="button-block but-r">
			<?if($arResult["SUBSCRIPTION"]["ACTIVE"] == "Y"):?>
				<input type="submit" class="btn btn-default btn-lg" name="unsubscribe" value="<?echo GetMessage("subscr_unsubscr")?>" />
				<input type="hidden" name="action" value="unsubscribe" />
			<?else:?>
				<input type="submit" class="btn btn-default btn-lg" name="activate" value="<?echo GetMessage("subscr_activate")?>" />
				<input type="hidden" name="action" value="activate" />
			<?endif;?>
		</div>
	<?endif;?>
	<input type="hidden" name="ID" value="<?echo $arResult["SUBSCRIPTION"]["ID"];?>" />
	<?echo bitrix_sessid_post();?>
	</form>
</div>
<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Localization\Loc;
?>
<?if($arResult['ITEM']):?>
	<?
	$type = 'WEBFORM';
	$bPicture = ($arResult['ITEM']['PREVIEW_PICTURE']);
	$webFormId = $arResult['ITEM']['PROPERTY_LINK_WEB_FORM_ID'];
	?>
	<?if($webFormId > 0):?>
		<div class="form marketing-popup with_web_form popup-text-info<?=($bPicture ? " popup-text-info--has-img" : "");?> <?=$templateName?>" data-classes="<?=$type?> <?=$position?>">
			<?if($arResult['ITEM']['PREVIEW_PICTURE']):?>
				<div class="popup-text-info__picture"><div style="background-image: url(<?=CFile::GetPath($arResult['ITEM']["PREVIEW_PICTURE"]);?>)"></div></div>
			<?endif;?>

			<div class="popup-text-info__webform ">
				<?$APPLICATION->IncludeComponent(
					"aspro:form." . VENDOR_SOLUTION_NAME, "popup",
					Array(
						"IBLOCK_TYPE" => VENDOR_PARTNER_NAME . '_'. VENDOR_SOLUTION_NAME . '_form',
						"IBLOCK_ID" => $webFormId,
						"AJAX_MODE" => "Y",
						"AJAX_OPTION_JUMP" => "N",
						"AJAX_OPTION_STYLE" => "N",
						"AJAX_OPTION_HISTORY" => "N",
						"CACHE_TYPE" => "A",
						"CACHE_TIME" => "100000",
						"AJAX_OPTION_ADDITIONAL" => "",
						"SUCCESS_MESSAGE" => Loc::getMessage('MARKETING_POPUP_SUCCESS_MESSAGE'),
						"SEND_BUTTON_NAME" => Loc::getMessage('MARKETING_POPUP_SEND_BUTTON_NAME'),
						"SEND_BUTTON_CLASS" => "btn btn-default",
						"DISPLAY_CLOSE_BUTTON" => "Y",
						"POPUP" => "Y",
						"CLOSE_BUTTON_NAME" => Loc::getMessage('MARKETING_POPUP_CLOSE_BUTTON_NAME'),
						"CLOSE_BUTTON_CLASS" => "jqmClose btn btn-default bottom-close",
						"IGNORE_AJAX_HEAD" => "Y",
					)
				);?>
			</div>
		</div>
	<?endif;?>
<?endif;?>
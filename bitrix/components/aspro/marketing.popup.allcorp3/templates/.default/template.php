<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Localization\Loc;

$frame = $this->createFrame()->begin('');

if(
	is_array($arResult) &&
	$arResult['ITEMS']
){
	foreach($arResult['ITEMS'] as $key => $arItem){
		$type = $arItem['PROPERTY_MODAL_TYPE_XML_ID'];

		if(
			!$type ||
			(
				$type === 'WEBFORM' &&
				!$arItem['PROPERTY_LINK_WEB_FORM_ID']
			)
		){
			continue;
		}
		?>
			<div
				class="dyn_mp_jqm"
				data-name="dyn_mp_jqm"
				data-event="jqm"
				data-param-form_id="marketing"
				data-param-id="<?=$arItem['ID']?>"
				data-param-iblock_id="<?=$arItem['IBLOCK_ID']?>"
				data-param-popup_type="<?=$arItem['POPUP_TYPE']?>"
				data-param-delay="<?=$arItem['PROPERTY_DELAY_SHOW_VALUE']?>"
				data-no-mobile="Y"
				data-ls="mw_<?=$arItem['ID']?>"
				data-ls_timeout="<?=$arItem['PROPERTY_LS_TIMEOUT_VALUE']?>"
				data-no-overlay="<?=$type == 'TEXT' ? 'Y' : ''?>"
				data-param-template="<?=$type?>"
			></div>
		<?
	}
}

$frame->end();
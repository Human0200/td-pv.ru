<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Localization\Loc;
?>
<?if($arResult['ITEM']):?>
	<?
	$type = 'MAIN';
	$bPicture = ($arResult['ITEM']['PREVIEW_PICTURE']);
	$bBtn1 = ($arResult['ITEM']['PROPERTY_BTN1_TEXT_VALUE'] && $arResult['ITEM']['PROPERTY_BTN1_LINK_VALUE']);
	$bBtn2 = ($arResult['ITEM']['PROPERTY_BTN2_TEXT_VALUE'] && $arResult['ITEM']['PROPERTY_BTN2_LINK_VALUE']);
	?>
	<div class="form marketing-popup popup-text-info<?=($bPicture ? " popup-text-info--has-img" : "");?> <?=$templateName?>" data-classes="<?=$type?> <?=$position?>">
		<?if($arResult['ITEM']['PREVIEW_PICTURE']):?>
			<div class="popup-text-info__picture"><div style="background-image: url(<?=CFile::GetPath($arResult['ITEM']["PREVIEW_PICTURE"]);?>)"></div></div>
		<?endif;?>

		<div class="popup-text-info__title color_333 font_24 font_bold switcher-title"><?=$arResult['ITEM']["NAME"];?></div>

		<div class="popup-text-info__text color_666">
			<?$obParser = new CTextParser;?>
			<?=$obParser->html_cut($arResult['ITEM']["PREVIEW_TEXT"], 500);?>

			<?if($bBtn1 || $bBtn2):?>
				<div class="popup-text-info__btn">
					<?if($bBtn1):?>
						<a class="btn <?=($arResult['ITEM']['BTN1_CLASS_INFO']['XML_ID'] ? $arResult['ITEM']['BTN1_CLASS_INFO']['XML_ID'] : "btn-default");?> btn-lg" href="<?=SITE_DIR?><?=$arResult['ITEM']["PROPERTY_BTN1_LINK_VALUE"];?>"><?=$arResult['ITEM']['PROPERTY_BTN1_TEXT_VALUE'];?></a>
					<?endif;?>
					<?if($bBtn2):?>
						<a class="btn <?=($arResult['ITEM']['BTN2_CLASS_INFO']['XML_ID'] ? $arResult['ITEM']['BTN2_CLASS_INFO']['XML_ID'] : "btn-transparent-border");?> btn-lg" href="<?=SITE_DIR?><?=$arResult['ITEM']["PROPERTY_BTN2_LINK_VALUE"];?>"><?=$arResult['ITEM']['PROPERTY_BTN2_TEXT_VALUE'];?></a>
					<?endif;?>
				</div>
			<?endif;?>
		</div>
	</div>
<?endif;?>
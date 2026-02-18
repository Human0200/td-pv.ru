<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */

$this->setFrameMode(true);

use \Bitrix\Main\Localization\Loc;

global $arTheme;
if($arResult['REGIONS']):?>
	<div class="regions region_wrapper" title="<?= Loc::getMessage('REGION') ?>">
		<div class="js_city_change regions__chooser fill-theme-parent light-opacity-hover color-theme-hover js_city_change animate-load1" data-name="city_chooser" data-param-url="<?=urlencode($APPLICATION->GetCurUri());?>" data-param-form_id="city_chooser">
			<span class="icon-block__only-icon fill-theme-target banner-light-icon-fill menu-light-icon-fill"><?=TSolution::showIconSvg('region', SITE_TEMPLATE_PATH.'/images/svg/region_big.svg');?></span>
			<span class="icon-block__icon fill-theme-target banner-light-icon-fill menu-light-icon-fill"><?=TSolution::showIconSvg('region', SITE_TEMPLATE_PATH.'/images/svg/region.svg');?></span>
			<?if($arParams['ONLY_ICON'] != 'Y'):?>
				<span class="regions__name icon-block__name color-theme-hover font_13 banner-light-text menu-light-text"><?=$arResult['CURRENT_REGION']['NAME'];?></span>
				<span class="more-arrow fill-theme-target banner-light-icon-fill menu-light-icon-fill fill-dark-light-block"><?=TSolution::showIconSvg("", SITE_TEMPLATE_PATH."/images/svg/more_arrow.svg", "", "", false);?></span>
			<?endif;?>
		</div>
		<div class="dropdown">
			<div class="wrap">
				<?foreach($arResult['REGIONS'] as $id => $arItem):?>
					<div class="more_item <?=($id == $arResult['CURRENT_REGION']['ID'] ? 'current' : '');?> font_13">
						<span class="color-theme-hover color_333" data-region_id="<?=$arItem['ID']?>" data-href="<?=$arItem['URL'];?>"><?=$arItem['NAME'];?></span>
					</div>
				<?endforeach;?>
			</div>
		</div>
		<?if($arResult['SHOW_REGION_CONFIRM']):?>
			<div class="confirm_region">
				<?
				$href = 'data-href="'.$arResult['REGIONS'][$arResult['REAL_REGION']['ID']]['URL'].'"';
				if($arTheme['USE_REGIONALITY']['DEPENDENT_PARAMS']['REGIONALITY_TYPE']['VALUE'] == 'SUBDOMAIN' && ($arResult['HOST'].$_SERVER['HTTP_HOST'].$arResult['URI'] == $arResult['REGIONS'][$arResult['REAL_REGION']['ID']]['URL']))
				$href = '';?>
				<div class="title"><?=Loc::getMessage('CITY_TITLE');?><span class="city"><?=$arResult['REAL_REGION']['NAME'];?>?</span></div>
				<div class="buttons clearfix">
					<span><span class="btn btn-default btn-md aprove" data-id="<?=$arResult['REAL_REGION']['ID'];?>" <?=$href;?>><?=Loc::getMessage('CITY_YES');?></span></span>
					<span><span class="btn btn-md btn-transparent-border js_city_change"><?=Loc::getMessage('CITY_CHANGE');?></span></span>
				</div>
				<span class="jqmClose top-close stroke-theme-hover top-close--small region-close" title="<?=\Bitrix\Main\Localization\Loc::getMessage('CLOSE_BLOCK');?>"><?=TSolution::showIconSvg('', SITE_TEMPLATE_PATH.'/images/svg/Close.svg')?></span>
			</div>
		<?endif;?>
	</div>
<?endif;?>

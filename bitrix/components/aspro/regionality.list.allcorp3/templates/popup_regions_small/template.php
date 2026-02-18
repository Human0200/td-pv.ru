<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */

$this->setFrameMode(true);

use \Bitrix\Main\Localization\Loc;
?>
<?if(!$arResult['POPUP']):?>
	<?if($arResult['CURRENT_REGION']):?>
		<?global $arTheme;?>
		<div class="regions" title="<?= Loc::getMessage('REGION') ?>">
			<div class="regions__chooser fill-theme-parent light-opacity-hover color-theme-hover js_city_chooser animate-load" data-event="jqm" data-name="city_chooser_small" data-param-url="<?=urlencode($APPLICATION->GetCurUri());?>" data-param-form_id="city_chooser">
			<span class="icon-block__only-icon fill-theme-target banner-light-icon-fill menu-light-icon-fill"><?=TSolution::showIconSvg('region', SITE_TEMPLATE_PATH.'/images/svg/region_big.svg');?></span>
				<span class="icon-block__icon fill-theme-target banner-light-icon-fill menu-light-icon-fill"><?=TSolution::showIconSvg('region', SITE_TEMPLATE_PATH.'/images/svg/region.svg');?></span>
				<?if($arParams['ONLY_ICON'] != 'Y'):?>
					<span class="regions__name icon-block__name color-theme-hover font_13 banner-light-text menu-light-text"><?=$arResult['CURRENT_REGION']['NAME'];?></span>
					<span class="more-arrow fill-theme-target banner-light-icon-fill menu-light-icon-fill fill-dark-light-block"><?=TSolution::showIconSvg("", SITE_TEMPLATE_PATH."/images/svg/more_arrow.svg", "", "", false);?></span>
				<?endif;?>
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
<?else:?>
	<div class="popup_regions">
		<div class="search-page autocomplete-block h-search" id="title-search-city">
			<div class="wrapper searchinput searchinput--lg">
			<input id="search" class="autocomplete text" type="text" placeholder="<?=Loc::getMessage('CITY_PLACEHOLDER');?>">
			<button class="btn btn-search btn--no-rippple" type="submit" name="s" value=""><?=TSolution::showIconSvg("search", SITE_TEMPLATE_PATH."/images/svg/Search_black.svg");?></button>
				<div class="js-autocomplete-block"></div>
			</div>
			<?if($arResult['FAVORITS']):?>
				<div class="favorits">
					<div class="favorits_wrapper line-block line-block--16 line-block--flex-wrap">
						<?foreach($arResult['FAVORITS'] as $arItem):?>
							<div class="favorits__item line-block__item font_13">
									<a href="<?=$arItem['URL'];?>" data-id="<?=$arItem['ID'];?>" class="favorits__link dark_link color_666 js-change-region"><?=$arItem['NAME'];?></a>
							</div>
						<?endforeach;?>
					</div>
				</div>
			<?endif;?>
		</div>
		<?if(\Bitrix\Main\Config\Option::get(VENDOR_MODULE_ID, 'REGIONALITY_SEARCH_ROW', 'N') != 'Y'):?>
				<div class="items only_city cities line-block line-block--80 line-block--align-normal">
					<?if($arResult['REGIONS']):?>
						<div class="line-block__item cities__wrapper scrollbar scrollbar--overscroll-auto">
							<div class="block city cities--only-city">
								<div class="items_block">
									<?foreach($arResult['REGIONS'] as $key => $arItem):?>
										<?$bCurrent = ($arResult['CURRENT_REGION']['ID'] == $arItem['ID']);?>
										<div class="cities__item dark_link font_14 shown <?=($bCurrent ? 'current' : '');?>" data-id="<?=((isset($arItem['IBLOCK_SECTION_ID']) && $arItem['IBLOCK_SECTION_ID']) ? $arItem['IBLOCK_SECTION_ID'] : 0);?>">
											<?if($bCurrent):?>
												<span class="cities__item-link"><?=$arItem['NAME'];?></span>
											<?else:?>
												<a href="<?=$arItem['URL'];?>" data-id="<?=$arItem['ID'];?>" class="cities__item-link dark_link js-change-region"><?=$arItem['NAME'];?></a>
											<?endif;?>
										</div>
									<?endforeach;?>
								</div>
							</div>
						</div>
					<?endif;?>
				</div>
				<script>
					var arRegions = <?=CUtil::PhpToJsObject($arResult['JS_REGIONS']);?>
				</script>
			<?else:?>
				<script>
					var arRegions = [];
				</script>
			<?endif;?>
		</div>
	<?endif;?>


<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<?use \Bitrix\Main\Localization\Loc;?>
<?if($arResult['ITEMS']):?>

	<?if (!function_exists('showAsproLandingItems')):?>
		<?function showAsproLandingItems($arParams = [
			'ITEMS' => [],
			'COUNT' => 10,
			'PARAMS' => []
		]){
			ob_start();?>
				<?$i = 0;?>
				<?$bFilled = ($arParams['PARAMS']['BG_FILLED'] == 'Y');?>
				<?$bModile = ($arParams['PARAMS']['MOBILED'] == 'Y');?>
				<?$bSlider = ($arParams['PARAMS']['VIEW_TYPE'] == 'slider' && $bModile);?>
				<?if ($bModile):?>
					<!-- noindex -->
				<?endif;?>
				<div class="landings-list__info <?=$bModile ? 'landings-list__info--mobiled visible-xs' : 'hidden-xs'?> <?=$bSlider ? 'swipeignore' : ''?>">
					<?$compare_field = (isset($arParams['PARAMS']["COMPARE_FIELD"]) && $arParams['PARAMS']["COMPARE_FIELD"] ? $arParams['PARAMS']["COMPARE_FIELD"] : "DETAIL_PAGE_URL");
					$bProp = (isset($arParams['PARAMS']["COMPARE_PROP"]) && $arParams['PARAMS']["COMPARE_PROP"] == "Y");

					$textExpand = Loc::getMessage("SHOW_STEP_ALL");
					$textHide = Loc::getMessage("HIDE");
					$opened = "N";
					$classOpened = "";
					$arParams["COUNT"] = (int)$arParams["COUNT"];
					$count = count($arParams['ITEMS']);

					if ($bSlider) {
						$arParams["COUNT"] = 0;
					}

					$bWithHidden = $bCheckItemActive = $bHiddenOK = false;?>

					<?foreach ($arParams['ITEMS'] as $key => $arItem) {
						++$i;
						$bHidden = ($i > $arParams["COUNT"] && $arParams["COUNT"]);

						if ($bHidden) {
							$bWithHidden = true;
						}

						$url = $arItem[$compare_field];
						if ($bProp) {
							$url = $arItem["PROPERTIES"][$compare_field]["VALUE"];
						}

						if ($url) {
							$arFilterQuery = TSolution\Functions::checkActiveFilterPage($arParams['PARAMS']["SEF_CATALOG_URL"], $url);
							$bActiveFilter = ($arFilterQuery && !in_array('clear', $arFilterQuery));
							$curDir = $GLOBALS['APPLICATION']->GetCurDir();
							$curDirDec = urldecode(str_replace(' ', '+', $curDir));
							$urlDec= urldecode($url);
							$urlDecCP = iconv("utf-8","windows-1251", $urlDec);
							$bCurrentUrl = ($curDirDec == $urlDec) || ($curDir == $urlDec) || ($curDir == $urlDecCP);

							if ($bCurrentUrl) {
								if($bActiveFilter){
									/*if ($bHidden) {
										$bCheckItemActive = true;
										$textExpand = $textHide;
										$textHide = Loc::getMessage("SHOW_STEP_ALL");
										$opened = "Y";
										$classOpened = "opened";
									}*/

									$arParams['ITEMS'][$key]['ACTIVE'] = 'Y';
									$arParams['ITEMS'][$key]['ACTIVE_URL'] = $bCurrentUrl ? 'Y' : 'N';
								}
							}
						}
					}?>
					<?$i = 0;?>
					<div class="landings-list__info-wrapper <?=($bWithHidden ? 'last' : '');?> flexbox flexbox--direction-row <?=($bSlider ? 'with-slider' : 'flexbox--wrap');?> mobile-scrolled mobile-scrolled--items-auto mobile-offset">
						<?foreach($arParams['ITEMS'] as $arItem):?>
							<?
							++$i;
							$bHidden = ($i > $arParams["COUNT"] && $arParams["COUNT"]);

							$url = $arItem[$compare_field];
							if ($bProp) {
								$url = $arItem["PROPERTIES"][$compare_field]["VALUE"];
							}
							$class = '';
							if ($bHidden) {
								if ($arItem['ACTIVE_URL'] != 'Y') {
									$class .= 'hidden js-hidden';
								} else {
									if ($i > $arParams['COUNT'] && $count == $i) {
										$bHidden = false;
									}
								}
							}
							if ($arItem['ACTIVE_URL'] == 'Y') {
								$class = 'active';
							}
							$itemClass = 'landings-list__name rounded-4 bordered';
							?>
							<div class="landings-list__item font_14  <?=$class;?>" id="<?//=$this->GetEditAreaId($arItem['ID']);?>">
								<div>
									<?if(strlen($url)):?>
										<?if($arItem['ACTIVE_URL'] == 'Y'):?>
											<span class="<?=$itemClass;?> landings-list__item--active bg-more-theme <?=($bActiveFilter ? 'landings-list__item--reset colored_more_theme_bg2_hover' : '');?>"><span><?=$arItem['NAME']?></span>
												<?if($arItem['ACTIVE']):?>
													<span class="landings-list__clear-filter colored_theme_bg_hovered_hover" title="<?=Loc::getMessage('RESET_LANDING');?>">
														<?=TSolution::showIconSvg("delete_filter", SITE_TEMPLATE_PATH.'/images/svg/catalog/cancelfilter.svg', '', '', false, false);?>
													</span>
												<?endif;?>
											</span>
										<?else:?>
											<a class="<?=$itemClass;?> shadow-hovered shadow-hovered-f600 shadow-no-border-hovered" href="<?=$url?>"><span><?=$arItem['NAME']?></span></a>
										<?endif;?>
									<?else:?>
										<span class="<?=$itemClass;?>"><span><?=$arItem['NAME']?></span></span>
									<?endif?>
								</div>
							</div>
						<?endforeach?>
						<?if($bHidden):?>
							<div class="landings-list__item font_14">
								<button class="landings-list__item--js-more btn--no-btn-appearance dark_link <?=$classOpened;?>" data-opened="<?=$opened;?>" data-visible="<?=$arParams['COUNT'];?>">
									<span data-opened="<?=$opened;?>" data-text="<?=$textHide;?>"><?=$textExpand;?></span><?=TSolution::showIconSvg("wish ncolor", SITE_TEMPLATE_PATH."/images/svg/arrow_showmoretags.svg");?>
								</button>
							</div>
						<?endif?>
					</div>
				</div>
				<?if ($bModile):?>
					<!-- /noindex -->
				<?endif;?>

			<?$html = ob_get_clean();
			return $html;
		}?>
	<?endif;?>

	<div class="landings-list <?=$templateName;?> with-<?=$arParams['VIEW_TYPE']?>">
		<?$bInFilterShow = ($arParams['VIEW_TYPE'] == 'filter')?>
		<?if ($bInFilterShow):?>
			<div class="with-filter-wrapper">
				<div class="bx_filter_parameters_box">
					<div class="bx_filter_parameters_box_title title rounded3 box-shadow-sm colored_theme_hover_bg-block">
						<div>
							<div><?=Loc::getMessage('LANDING_TITLE_FILTER');?></div>
						</div>
						<?=TSolution::showIconSvg("down colored_theme_hover_bg-el", SITE_TEMPLATE_PATH.'/images/svg/trianglearrow_down.svg', '', '', true, false);?>
					</div>
					<div class="bx_filter_block">
		<?endif;?>
			<?=showAsproLandingItems([
				'ITEMS' => $arResult['ITEMS'],
				'COUNT' => $arParams['SHOW_COUNT_MOBILE'],
				'PARAMS' => $arParams + ['MOBILED' => 'Y']
			])?>
		<?if ($bInFilterShow):?>
					</div>
				</div>
			</div>
		<?endif;?>
		<?=showAsproLandingItems([
			'ITEMS' => $arResult['ITEMS'],
			'COUNT' => $arParams['SHOW_COUNT'],
			'PARAMS' => $arParams
		])?>
	</div>

<?endif?>

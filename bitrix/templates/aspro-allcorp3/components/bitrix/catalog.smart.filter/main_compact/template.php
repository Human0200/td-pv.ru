<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
use \Bitrix\Main\Localization\Loc;
if($arResult["ITEMS"]){?>
	<?global $filter_exists;?>
	<?$filter_exists = "filter_exists";?>
	<?$bActiveFilter = TSolution\Functions::checkActiveFilterPage($arParams["SEF_RULE_FILTER"]);
	?>
	<div class="filter-compact-block swipeignore">
		<div class="bx_filter bx_filter_vertical compact swipeignore <?=(isset($arResult['EMPTY_ITEMS']) ? 'empty-items': '');?>">
			<div class="bx_filter_section clearfix">
				<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter">
					<div class="bx_filter_parameters_box title color_333 font_12 text-upper font-bold">
						<div class="bx_filter_parameters_box_title filter_title <?=($bActiveFilter && $bActiveFilter[1] != 'clear' ? 'active-filter' : '')?>">
							<?=TSolution::showIconSvg("catalog fill-dark-light", SITE_TEMPLATE_PATH.'/images/svg/catalog/filter.svg', '', '', true, false);?>
							<span><?=Loc::getMessage("FILTER_TITLE_COMPACT");?></span>
							<?=TSolution::showIconSvg("icon svg-close close-icons stroke-theme-hover", SITE_TEMPLATE_PATH.'/images/svg/Close.svg', '', '', true, false);?>
						</div>
					</div>

					<div class="bx_filter_parameters">
						<input type="hidden" name="del_url" id="del_url" value="<?echo str_replace('/filter/clear/apply/','/',$arResult["SEF_DEL_FILTER_URL"]);?>" />
						<?foreach($arResult["HIDDEN"] as $arItem):?>
							<input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
						<?endforeach;
						$isFilter = $titlePrice = false;
						$numVisiblePropValues = 2;

						//ASPRO_FILTER_SORT
						foreach($arResult["ITEMS"] as $key => $arItem){
							if (isset($arItem["ASPRO_FILTER_SORT"]) && $arItem["VALUES"]) {
								$class = $arItem["DISPLAY_EXPANDED"] === "Y" ? "active" : '';
								$style = $arItem["DISPLAY_EXPANDED"] !== "Y" ? "style='display:none;'" : '';
								$isFilter = true;
								$checkedItemExist = false;
								?>
								<div class="bx_filter_parameters_box bx_sort_filter <?=$class;?>" data-expanded="<?=($arItem["DISPLAY_EXPANDED"] ? $arItem["DISPLAY_EXPANDED"] : "N");?>" data-prop_code="<?=strtolower($arItem["CODE"]);?>" data-check_prop_inline="<?= $arItem['IS_PROP_INLINE'] ? 'true' : 'false'; ?>" data-property_id="<?=$arItem["ID"]?>">
									<span data-f="<?=Loc::getMessage('CT_BCSF_SET_FILTER')?>" data-fi="<?=Loc::getMessage('CT_BCSF_SET_FILTER_TI')?>" data-fr="<?=Loc::getMessage('CT_BCSF_SET_FILTER_TR')?>" data-frm="<?=Loc::getMessage('CT_BCSF_SET_FILTER_TRM')?>" class="bx_filter_container_modef"></span>
									<div class="bx_filter_parameters_box_title"><div><?=$arItem["NAME"]?></div><?=TSolution::showIconSvg("down colored_theme_hover_bg-el", SITE_TEMPLATE_PATH.'/images/svg/trianglearrow_down.svg', '', '', true, false);?></div>
									<div class="bx_filter_block <?=($arItem["PROPERTY_TYPE"]!="N" && ($arItem["DISPLAY_TYPE"] != "P" && $arItem["DISPLAY_TYPE"] != "R") ? "limited_block" : "");?>" <?=$style;?>>
										<div class="bx_filter_parameters_box_container <?=($arItem["DISPLAY_TYPE"]=="G" ? "pict_block" : "");?>">
										<div class="bx_filter_select_container">
											<div class="bx_filter_select_block" onclick="smartFilter.showDropDownPopup(this, '<?=CUtil::JSEscape($key)?>')">
												<div class="bx_filter_select_text" data-role="currentOption">
													<?
													foreach ($arItem["VALUES"] as $val => $ar)
													{
														if ($ar["CHECKED"] && $ar["CHECKED"]=="Y")
														{
															echo $ar["VALUE"];
															$checkedItemExist = true;
														}
													}
													?>
												</div>
												<div class="bx_filter_select_arrow"></div>
												<div class="bx_filter_select_popup" data-role="dropdownContent" style="display: none;">
													<ul>
													<?foreach($arItem["VALUES"] as $val => $ar):?>
														<?$ar["CONTROL_ID"] .= $arParams['AJAX_FILTER_FLAG'];?>
														<li><?=$ar["CONTROL_HTML"]?></li>
													<?endforeach;?>
													</ul>
												</div>
											</div>
										</div>
											</div>
										<div class="clb"></div>
									</div>
								</div><?
								unset($arResult["ITEMS"][$key]);
							}
							if (isset($arItem["PRICE"])) {
								if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] > 0) {
									$titlePrice = true;
								}
							}
						}

						//prices?>
						<?if ($titlePrice):?>
							<div class="bx_filter_parameters_box prices<?=(isset($arResult['PRICE_SET']) && $arResult['PRICE_SET'] == 'Y' ? ' set' : '');?>">
								<span data-f="<?=Loc::getMessage('CT_BCSF_SET_FILTER')?>" data-fi="<?=Loc::getMessage('CT_BCSF_SET_FILTER_TI')?>" data-fr="<?=Loc::getMessage('CT_BCSF_SET_FILTER_TR')?>" data-frm="<?=Loc::getMessage('CT_BCSF_SET_FILTER_TRM')?>" class="bx_filter_container_modef"></span>
								<div class="bx_filter_parameters_box_title title rounded3 box-shadow-sm" >
									<div><?=Loc::getMessage("PRICE");?></div>
									<span class="delete_filter colored_theme_bg_hovered_hover">
										<?=TSolution::showIconSvg("delete_filter", SITE_TEMPLATE_PATH.'/images/svg/catalog/cancelfilter.svg', '', '', false, false);?>
									</span>
									<?=TSolution::showIconSvg("down colored_theme_hover_bg-el", SITE_TEMPLATE_PATH.'/images/svg/trianglearrow_down.svg', '', '', true, false);?>
								</div>
								<div class="bx_filter_block">
									<?foreach($arResult["ITEMS"] as $key=>$arItem)
									{
										$key = $arItem["ENCODED_ID"];
										if(isset($arItem["PRICE"])):
											if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
												continue;
											?>
												<div class="price_block swipeignore">
													<div class="bx_filter_parameters_box_title rounded3 prices"><?=(count($arParams['PRICE_CODE']) > 1 ? $arItem["NAME"] : Loc::getMessage("PRICE"));?></div>
													<div class="bx_filter_parameters_box_container numbers">
														<div class="wrapp_all_inputs wrap_md">
															<?
															$isConvert=false;
															if($arParams["CONVERT_CURRENCY"]=="Y"){
																$isConvert=true;
															}
															$price1 = $arItem["VALUES"]["MIN"]["VALUE"];
															$price2 = $arItem["VALUES"]["MIN"]["VALUE"] + round(($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"])/4);
															$price3 = $arItem["VALUES"]["MIN"]["VALUE"] + round(($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"])/2);
															$price4 = $arItem["VALUES"]["MIN"]["VALUE"] + round((($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"])*3)/4);
															$price5 = $arItem["VALUES"]["MAX"]["VALUE"];

															if($isConvert){
																$price1 =SaleFormatCurrency($price1, $arParams["CURRENCY_ID"], true);
																$price2 =SaleFormatCurrency($price2, $arParams["CURRENCY_ID"], true);
																$price3 =SaleFormatCurrency($price3, $arParams["CURRENCY_ID"], true);
																$price4 =SaleFormatCurrency($price4, $arParams["CURRENCY_ID"], true);
																$price5 =SaleFormatCurrency($price5, $arParams["CURRENCY_ID"], true);
															}
															?>
															<div class="wrapp_change_inputs iblock">
																<div class="bx_filter_parameters_box_container_block">
																	<div class="bx_filter_input_container form-control bg">
																		<input
																			class="min-price"
																			type="text"
																			name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
																			id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
																			value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
																			size="5"
																			placeholder="<?echo $price1;?>"
																			onkeyup="smartFilter.keyup(this)"
																			autocomplete="off"
																		/>
																	</div>
																</div>
																<div class="bx_filter_parameters_box_container_block">
																	<div class="bx_filter_input_container form-control bg">
																		<input
																			class="max-price"
																			type="text"
																			name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
																			id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
																			value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
																			size="5"
																			placeholder="<?echo $price5;?>"
																			onkeyup="smartFilter.keyup(this)"
																			autocomplete="off"
																		/>
																	</div>
																</div>
																<span class="divider"></span>
																<div style="clear: both;"></div>
															</div>
															<div class="wrapp_slider iblock">
																<div class="bx_ui_slider_track" id="drag_track_<?=$key?>">
																	<div class="bx_ui_slider_part first p1"><span><?=$price1?></span></div>
																	<div class="bx_ui_slider_part p2"><span><?=$price2?></span></div>
																	<div class="bx_ui_slider_part p3"><span><?=$price3?></span></div>
																	<div class="bx_ui_slider_part p4"><span><?=$price4?></span></div>
																	<div class="bx_ui_slider_part last p5"><span><?=$price5?></span></div>

																	<div class="bx_ui_slider_pricebar_VD" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></div>
																	<div class="bx_ui_slider_pricebar_VN" style="left: 0;right: 0;" id="colorAvailableInactive_<?=$key?>"></div>
																	<div class="bx_ui_slider_pricebar_V"  style="left: 0;right: 0;" id="colorAvailableActive_<?=$key?>"></div>
																	<div class="bx_ui_slider_range" id="drag_tracker_<?=$key?>"  style="left: 0%; right: 0%;">
																		<a class="bx_ui_slider_handle left"  style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a>
																		<a class="bx_ui_slider_handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a>
																	</div>
																</div>
																<div style="opacity: 0;height: 1px;"></div>
															</div>
														</div>
													</div>
												</div>
											<?
											$isFilter=true;
											$precision = 2;
											if (Bitrix\Main\Loader::includeModule("currency"))
											{
												$res = CCurrencyLang::GetFormatDescription($arItem["VALUES"]["MIN"]["CURRENCY"]);
												$precision = $res['DECIMALS'];
											}
											$arJsParams = array(
												"leftSlider" => 'left_slider_'.$key,
												"rightSlider" => 'right_slider_'.$key,
												"tracker" => "drag_tracker_".$key,
												"trackerWrap" => "drag_track_".$key,
												"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
												"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
												"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
												"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
												"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
												"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
												"fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
												"fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
												"precision" => $precision,
												"colorUnavailableActive" => 'colorUnavailableActive_'.$key,
												"colorAvailableActive" => 'colorAvailableActive_'.$key,
												"colorAvailableInactive" => 'colorAvailableInactive_'.$key,
											);
											?>
											<script type="text/javascript">
												BX.ready(function(){
													if(typeof window['trackBarOptions'] === 'undefined'){
														window['trackBarOptions'] = {}
													}
													window['trackBarOptions']['<?=$key?>'] = <?=CUtil::PhpToJSObject($arJsParams)?>;
													window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(window['trackBarOptions']['<?=$key?>']);
												});
											</script>
										<?endif;
									}?>
									<div class="bx_filter_button_box active clearfix">
										<span class="btn btn-default round-ignore btn-sm "><?=Loc::getMessage("CT_BCSF_SET_FILTER")?></span>
										<span data-f="<?=Loc::getMessage('CT_BCSF_SET_FILTER')?>" data-fi="<?=Loc::getMessage('CT_BCSF_SET_FILTER_TI')?>" data-fr="<?=Loc::getMessage('CT_BCSF_SET_FILTER_TR')?>" data-frm="<?=Loc::getMessage('CT_BCSF_SET_FILTER_TRM')?>" class="bx_filter_container_modef"></span>
									</div>
								</div>
							</div>
						<?endif;?>

						<?//not prices
						foreach($arResult["ITEMS"] as $key=>$arItem)
						{
							if(
								empty($arItem["VALUES"])
								|| isset($arItem["PRICE"])
							)
								continue;

							if (
								$arItem["DISPLAY_TYPE"] == "A"
								&& (
									$arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0
								)
							)
								continue;
							$class="";
							/*if($arItem["OPENED"]){
								if($arItem["OPENED"]=="Y"){
									$class="active";
								}
							}else*//*if($arItem["DISPLAY_EXPANDED"]=="Y"){
								$class="active";
							}*/
							$isFilter=true;
							?>
							<?if ($arItem["FILTER_HINT"]) {
								preg_match('/#.*?#/s', $arItem["FILTER_HINT"], $matches);
								if (count($matches)) {
									$arItem['DECIMALS'] = intval(str_replace('#', '', $matches[0])) ?: 0;
									$arItem["FILTER_HINT"] = str_replace($matches[0], '', $arItem["FILTER_HINT"]);
									if (!trim(strip_tags($arItem["FILTER_HINT"]))) {
										$arItem["FILTER_HINT"] = '';
									}
								}
							}?>
							<div class="bx_filter_parameters_box prop_type_<?=$arItem["PROPERTY_TYPE"];?><?=(isset($arItem['PROPERTY_SET']) && $arItem['PROPERTY_SET'] == 'Y' ? ' opened' : '');?>" data-prop_code="<?=strtolower($arItem["CODE"]);?>" data-check_prop_inline="<?= $arItem['IS_PROP_INLINE'] ? 'true' : 'false'; ?>" data-property_id="<?=$arItem["ID"]?>">
								<span data-f="<?=Loc::getMessage('CT_BCSF_SET_FILTER')?>" data-fi="<?=Loc::getMessage('CT_BCSF_SET_FILTER_TI')?>" data-fr="<?=Loc::getMessage('CT_BCSF_SET_FILTER_TR')?>" data-frm="<?=Loc::getMessage('CT_BCSF_SET_FILTER_TRM')?>" class="bx_filter_container_modef"></span>
								<? if( !$arItem['IS_PROP_INLINE'] ): ?>
									<div class="bx_filter_parameters_box_title title bordered rounded-4 shadow-hovered shadow-no-border-hovered font_14 menu-arrow-wrapper bg-opacity-theme-parent-hover link-with-flag fill-theme-parent-all" >
										<div class="text">
											<span><?=( $arItem["CODE"] == "MINIMUM_PRICE" ? Loc::getMessage("PRICE") : $arItem["NAME"] );?></span>
											<span class="count_selected"><?=(isset($arItem['COUNT_SELECTED']) && $arItem['COUNT_SELECTED'] ? ': '.$arItem['COUNT_SELECTED'] : '');?></span>
										</div>
										<span class="delete_filter colored_more_theme_bg2_hover" title="<?=Loc::getMessage("CLEAR_VALUE")?>">
											<?=TSolution::showIconSvg("delete_filter", SITE_TEMPLATE_PATH.'/images/svg/catalog/cancelfilter.svg', '', '', false, false);?>
										</span>
										<?=TSolution::showIconSvg("down menu-arrow  bg-opacity-theme-target fill-theme-target fill-dark-light", SITE_TEMPLATE_PATH.'/images/svg/Triangle_down.svg', '', '', true, false);?>
									</div>
								<? endif; ?>
								<?
									$style = "";
									if( $arItem['IS_PROP_INLINE'] ){
										$style = "style='display:block;'";
									}/*elseif($arItem["DISPLAY_EXPANDED"]!= "Y"){
										$style="style='display:none;'";
									}*/
								?>
								<div class="bx_filter_block<?= $arItem['IS_PROP_INLINE'] ? " limited_block" : '';?>" <?= $style; ?>>
									<div class="bx_filter_parameters_box_container <?=($arItem["DISPLAY_TYPE"]=="G" ? "pict_block" : "");?>">
									<?
									$arCur = current($arItem["VALUES"]);
									switch ($arItem["DISPLAY_TYPE"]){
										case "A"://NUMBERS_WITH_SLIDER
											?>
											<?$isConvert=false;
											if($arItem["CODE"] == "MINIMUM_PRICE" && $arParams["CONVERT_CURRENCY"]=="Y"){
												$isConvert=true;
											}
											$value1 = floatval($arItem["VALUES"]["MIN"]["VALUE"]);
											$value2 = $arItem["VALUES"]["MIN"]["VALUE"] + round(($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"])/4);
											$value3 = $arItem["VALUES"]["MIN"]["VALUE"] + round(($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"])/2);
											$value4 = $arItem["VALUES"]["MIN"]["VALUE"] + round((($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"])*3)/4);
											$value5 = floatval($arItem["VALUES"]["MAX"]["VALUE"]);
											if($isConvert){
												$value1 =SaleFormatCurrency($value1, $arParams["CURRENCY_ID"], true);
												$value2 =SaleFormatCurrency($value2, $arParams["CURRENCY_ID"], true);
												$value3 =SaleFormatCurrency($value3, $arParams["CURRENCY_ID"], true);
												$value4 =SaleFormatCurrency($value4, $arParams["CURRENCY_ID"], true);
												$value5 =SaleFormatCurrency($value5, $arParams["CURRENCY_ID"], true);
											}?>
											<div class="fullwidth-input">
												<div class="bx_filter_parameters_box_container_block">
													<div class="bx_filter_input_container bg">
														<input
															class="min-price"
															type="text"
															name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
															id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
															value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ? floatval($arItem["VALUES"]["MIN"]["HTML_VALUE"]) : $arItem["VALUES"]["MIN"]["HTML_VALUE"]; ?>"
															size="5"
															placeholder="<?echo $value1;?>"
															onkeyup="smartFilter.keyup(this)"
															autocomplete="off"
														/>
													</div>
												</div>
												<div class="bx_filter_parameters_box_container_block">
													<div class="bx_filter_input_container bg">
														<input
															class="max-price"
															type="text"
															name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
															id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
															value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ? floatval($arItem["VALUES"]["MAX"]["HTML_VALUE"]) : $arItem["VALUES"]["MAX"]["HTML_VALUE"]; ?>"
															size="5"
															placeholder="<?echo $value5;?>"
															onkeyup="smartFilter.keyup(this)"
															autocomplete="off"
														/>
													</div>
												</div>
												<span class="divider"></span>
												<div style="clear: both;"></div>
											</div>
											<div class="wrapp_slider iblock">
												<div class="bx_ui_slider_track" id="drag_track_<?=$key?>">

													<div class="bx_ui_slider_part first p1"><span><?=$value1?></span></div>
													<div class="bx_ui_slider_part p2"><span><?=$value2?></span></div>
													<div class="bx_ui_slider_part p3"><span><?=$value3?></span></div>
													<div class="bx_ui_slider_part p4"><span><?=$value4?></span></div>
													<div class="bx_ui_slider_part last p5"><span><?=$value5?></span></div>

													<div class="bx_ui_slider_pricebar_VD" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></div>
													<div class="bx_ui_slider_pricebar_VN" style="left: 0;right: 0;" id="colorAvailableInactive_<?=$key?>"></div>
													<div class="bx_ui_slider_pricebar_V"  style="left: 0;right: 0;" id="colorAvailableActive_<?=$key?>"></div>
													<div class="bx_ui_slider_range" 	id="drag_tracker_<?=$key?>"  style="left: 0;right: 0;">
														<a class="bx_ui_slider_handle left"  style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a>
														<a class="bx_ui_slider_handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a>
													</div>
												</div>
												<?
												$arJsParams = array(
													"leftSlider" => 'left_slider_'.$key,
													"rightSlider" => 'right_slider_'.$key,
													"tracker" => "drag_tracker_".$key,
													"trackerWrap" => "drag_track_".$key,
													"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
													"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
													"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
													"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
													"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
													"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
													"fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
													"fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
													"precision" => $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0,
													"colorUnavailableActive" => 'colorUnavailableActive_'.$key,
													"colorAvailableActive" => 'colorAvailableActive_'.$key,
													"colorAvailableInactive" => 'colorAvailableInactive_'.$key,
												);
												?>
												
												<script type="text/javascript">
													BX.ready(function(){
														if(typeof window['trackBarOptions'] === 'undefined'){
															window['trackBarOptions'] = {}
														}
														window['trackBarOptions']['<?=$key?>'] = <?=CUtil::PhpToJSObject($arJsParams)?>;
														window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(window['trackBarOptions']['<?=$key?>']);
													});
												</script>
											</div>
											<?
											break;
										case "B"://NUMBERS
											?>
											<div class="fullwidth-input">
												<div class="bx_filter_parameters_box_container_block">
													<div class="bx_filter_input_container bg">
														<input
															class="min-price"
															type="text"
															name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
															id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
															value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ? floatval($arItem["VALUES"]["MIN"]["HTML_VALUE"]) : $arItem["VALUES"]["MIN"]["HTML_VALUE"]; ?>"
															placeholder="<?echo floatval($arItem["VALUES"]["MIN"]["VALUE"]);?>"
															size="5"
															onkeyup="smartFilter.keyup(this)"
															autocomplete="off"
															/>
													</div>
												</div>
												<div class="bx_filter_parameters_box_container_block">
													<div class="bx_filter_input_container bg">
														<input
															class="max-price"
															type="text"
															name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
															id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
															value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ? floatval($arItem["VALUES"]["MAX"]["HTML_VALUE"]) : $arItem["VALUES"]["MAX"]["HTML_VALUE"]; ?>"
															placeholder="<?echo floatval($arItem["VALUES"]["MAX"]["VALUE"]);?>"
															size="5"
															onkeyup="smartFilter.keyup(this)"
															autocomplete="off"
															/>
													</div>
												</div>
											</div>
											<?
											break;
										case "G"://CHECKBOXES_WITH_PICTURES
											?>
											<?$j=1;
											$isHidden = false;?>
											<?foreach ($arItem["VALUES"] as $val => $ar):?>
												<?if($ar["VALUE"]){?>
													<?if($j > $numVisiblePropValues && !$isHidden):
														$isHidden = true;?>
														<div class="hidden_values filter label_block">
													<?endif;?>
													<div class="pict">
														<input
															style="display: none"
															type="checkbox"
															name="<?=$ar["CONTROL_NAME"]?>"
															id="<?=$ar["CONTROL_ID"]?>"
															value="<?=$ar["HTML_VALUE"]?>"
															<? echo $ar["DISABLED"] ? 'disabled class="disabled"': '' ?>
															<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
															autocomplete="off"
														/>
														<?
														$class = "";
														if ($ar["CHECKED"])
															$class.= " active";
														if ($ar["DISABLED"])
															$class.= " disabled";
														?>
														<label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx_filter_param_label nab dib<?=$class?>" onclick="smartFilter.keyup(BX('<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')); BX.toggleClass(this, 'active');">
															<?/*<span class="bx_filter_param_btn bx_color_sl" title="<?=$ar["VALUE"]?>">*/?>
																<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
																<span class="bx_filter_btn_color_icon" title="<?=$ar["VALUE"]?>" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
																<?endif?>
															<?/*</span>*/?>
														</label>
													</div>
													<?$j++;?>
												<?}?>
											<?endforeach?>
											<?if($isHidden):?>
												</div>
												<div class="inner_expand_text font_14 colored"><span class="expand_block dotted"><?=Loc::getMessage("FILTER_EXPAND_VALUES");?></span></div>
											<?endif;?>
											<?
											break;
										case "H"://CHECKBOXES_WITH_PICTURES_AND_LABELS
											?>
											<?$j=1;
											$isHidden = false;?>
											<?foreach ($arItem["VALUES"] as $val => $ar):?>
												<?if($ar["VALUE"]){?>
													<?if($j > $numVisiblePropValues && !$isHidden):
														$isHidden = true;?>
														<div class="hidden_values filter label_block">
													<?endif;?>
													<input
														style="display: none"
														type="checkbox"
														name="<?=$ar["CONTROL_NAME"]?>"
														id="<?=$ar["CONTROL_ID"]?>"
														value="<?=$ar["HTML_VALUE"]?>"
														<? echo $ar["DISABLED"] ? 'disabled class="disabled"': '' ?>
														<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
														autocomplete="off"
													/>
													<?
													$class = "";
													/*if ($ar["CHECKED"])
														$class.= " active";*/
													if ($ar["DISABLED"])
														$class.= " disabled";
													?>
													<label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx_filter_param_label<?=$class?> pal nab" onclick="smartFilter.keyup(BX('<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')); BX.toggleClass(this, 'active');">
														<?/*<span class="bx_filter_param_btn bx_color_sl" title="<?=$ar["VALUE"]?>">*/?>
															<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
																<span class="bx_filter_btn_color_icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
															<?endif?>
														<?/*</span>*/?>
														<span class="bx_filter_param_text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
														if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
															?> (<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
														endif;?></span>
													</label>
													<?$j++;?>
												<?}?>
											<?endforeach?>
											<?if($isHidden):?>
												</div>
												<div class="inner_expand_text"><span class="expand_block colored_theme_text_with_hover"><?=Loc::getMessage("FILTER_EXPAND_VALUES");?></span></div>
											<?endif;?>
											<?
											break;
										case "P"://DROPDOWN
											$checkedItemExist = false;
											?>
											<div class="bx_filter_select_container">
												<div class="bx_filter_select_block" onclick="smartFilter.showDropDownPopup(this, '<?=CUtil::JSEscape($key)?>')">
													<div class="bx_filter_select_text" data-role="currentOption">
														<?
														foreach ($arItem["VALUES"] as $val => $ar)
														{
															if ($ar["CHECKED"])
															{
																echo $ar["VALUE"];
																$checkedItemExist = true;
															}
														}
														if (!$checkedItemExist)
														{
															echo Loc::getMessage("CT_BCSF_FILTER_ALL");
														}
														?>
													</div>
													<div class="bx_filter_select_arrow">
														<?=TSolution::showIconSvg("down", SITE_TEMPLATE_PATH.'/images/svg/Triangle_down.svg', '', '', true, false);?>
													</div>
													<input
														style="display: none"
														type="radio"
														name="<?=$arCur["CONTROL_NAME_ALT"]?>"
														id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
														value=""
													/>
													<?foreach ($arItem["VALUES"] as $val => $ar):?>
														<input
															style="display: none"
															type="radio"
															name="<?=$ar["CONTROL_NAME_ALT"]?>"
															id="<?=$ar["CONTROL_ID"]?>"
															value="<? echo $ar["HTML_VALUE_ALT"] ?>"
															<? echo $ar["DISABLED"] ? 'disabled class="disabled"': '' ?>
															<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
														/>
													<?endforeach?>
													<div class="bx_filter_select_popup" data-role="dropdownContent" style="display: none;">
														<ul>
															<li>
																<label for="<?="all_".$arCur["CONTROL_ID"]?>" class="bx_filter_param_label" data-role="all_label_<?=$arCur["CONTROL_ID"]?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape("all_".$arCur["CONTROL_ID"])?>')">
																	<? echo Loc::getMessage("CT_BCSF_FILTER_ALL"); ?>
																</label>
															</li>
														<?
														foreach ($arItem["VALUES"] as $val => $ar):
															$class = "";
															if ($ar["CHECKED"])
																$class.= " selected";
															if ($ar["DISABLED"])
																$class.= " disabled";
														?>
															<li>
																<label for="<?=$ar["CONTROL_ID"]?>" class="bx_filter_param_label<?=$class?>" data-role="label_<?=$ar["CONTROL_ID"]?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')"><?=$ar["VALUE"]?></label>
															</li>
														<?endforeach?>
														</ul>
													</div>
												</div>
											</div>
											<?
											break;
										case "R"://DROPDOWN_WITH_PICTURES_AND_LABELS
											?>
											<div class="bx_filter_select_container">
												<div class="bx_filter_select_block" onclick="smartFilter.showDropDownPopup(this, '<?=CUtil::JSEscape($key)?>')">
													<div class="bx_filter_select_text" data-role="currentOption">
														<?
														$checkedItemExist = false;
														foreach ($arItem["VALUES"] as $val => $ar):
															if ($ar["CHECKED"])
															{
															?>
																<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
																	<span class="bx_filter_btn_color_icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
																<?endif?>
																<span class="bx_filter_param_text">
																	<?=$ar["VALUE"]?>
																</span>
															<?
																$checkedItemExist = true;
															}
														endforeach;
														if (!$checkedItemExist){?>
															<?echo Loc::getMessage("CT_BCSF_FILTER_ALL");
														}
														?>
													</div>
													<div class="bx_filter_select_arrow">
														<?=TSolution::showIconSvg("down", SITE_TEMPLATE_PATH.'/images/svg/Triangle_down.svg', '', '', true, false);?>
													</div>
													<input
														style="display: none"
														type="radio"
														name="<?=$arCur["CONTROL_NAME_ALT"]?>"
														id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
														value=""
													/>
													<?foreach ($arItem["VALUES"] as $val => $ar):?>
														<input
															style="display: none"
															type="radio"
															name="<?=$ar["CONTROL_NAME_ALT"]?>"
															id="<?=$ar["CONTROL_ID"]?>"
															value="<?=$ar["HTML_VALUE_ALT"]?>"
															<? echo $ar["DISABLED"] ? 'disabled class="disabled"': '' ?>
															<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
														/>
													<?endforeach?>
													<div class="bx_filter_select_popup" data-role="dropdownContent" style="display: none">
														<ul>
															<li style="border-bottom: 1px solid #e5e5e5;padding-bottom: 5px;margin-bottom: 5px;">
																<label for="<?="all_".$arCur["CONTROL_ID"]?>" class="bx_filter_param_label" data-role="label_<?=$arCur["CONTROL_ID"]?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape("all_".$arCur["CONTROL_ID"])?>')">
																	<? echo Loc::getMessage("CT_BCSF_FILTER_ALL"); ?>
																</label>
															</li>
														<?
														foreach ($arItem["VALUES"] as $val => $ar):
															$class = "";
															if ($ar["CHECKED"])
																$class.= " selected";
															if ($ar["DISABLED"])
																$class.= " disabled";
														?>
															<li>
																<label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx_filter_param_label<?=$class?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')">
																	<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
																		<span class="bx_filter_btn_color_icon" title="<?=$ar["VALUE"]?>" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
																	<?endif?>
																	<span class="bx_filter_param_text">
																		<?=$ar["VALUE"]?>
																	</span>
																</label>
															</li>
														<?endforeach?>
														</ul>
													</div>
												</div>
											</div>
											<?
											break;
										case "K"://RADIO_BUTTONS
											?>
											<div class="scrolled scroll-deferred srollbar-custom">
												<div class="form-radiobox">
													<input
														type="radio"
														value=""
														name="<? echo $arCur["CONTROL_NAME_ALT"] ?>"
														id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
														onclick="smartFilter.click(this)"
														class="form-radiobox__input"
													/>
													<label data-role="all_label_<?=$arCur["CONTROL_ID"]?>" class="bx_filter_param_label form-radiobox__label color-theme-hover " for="<? echo "all_".$arCur["CONTROL_ID"] ?>">
														<span class="bx_filter_input_checkbox"><span><? echo Loc::getMessage("CT_BCSF_FILTER_ALL"); ?></span></span>
														<span class="form-radiobox__box"></span>
													</label>
												</div>
												<?$j=1;
												$isHidden = false;?>
												<?foreach($arItem["VALUES"] as $val => $ar):?>
													<?if($j > $numVisiblePropValues && !$isHidden):
														$isHidden = true;?>
														<div class="hidden_values">
													<?endif;?>
													<div class="form-radiobox">
														<input
																	type="radio"
																	value="<? echo $ar["HTML_VALUE_ALT"] ?>"
																	name="<? echo $ar["CONTROL_NAME_ALT"] ?>"
																	id="<? echo $ar["CONTROL_ID"] ?>"
																	<? echo $ar["DISABLED"] ? 'disabled': '' ?>
																	<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
																	onclick="smartFilter.click(this)"
																	class="form-radiobox__input"
																/>
														<?$class = "";
														if ($ar["CHECKED"])
															$class.= " selected";
														if ($ar["DISABLED"])
															$class.= " disabled";?>
														<label data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx_filter_param_label form-radiobox__label color-theme-hover <?=$class;?>" for="<? echo $ar["CONTROL_ID"] ?>">
															<span class="bx_filter_input_checkbox">

																<span class="bx_filter_param_text1" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
																if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
																	?> (<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
																endif;?></span>
															</span>
															<span class="form-radiobox__box"></span>
														</label>
													</div>
													<?$j++;?>
												<?endforeach;?>
												<?if($isHidden):?>
													</div>
													<div class="inner_expand_text font_14 colored"><span class="expand_block dotted"><?=Loc::getMessage("FILTER_EXPAND_VALUES");?></span></div>
												<?endif;?>
											</div>
											<?
											break;
										case "U"://CALENDAR
											?>
											<div class="bx_filter_parameters_box_container_block">
												<div class="bx_filter_input_container bx_filter_calendar_container">
													<?$APPLICATION->IncludeComponent(
														'bitrix:main.calendar',
														'',
														array(
															'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
															'SHOW_INPUT' => 'Y',
															'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MIN"]["VALUE"]).'" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
															'INPUT_NAME' => $arItem["VALUES"]["MIN"]["CONTROL_NAME"],
															'INPUT_VALUE' => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
															'SHOW_TIME' => 'N',
															'HIDE_TIMEBAR' => 'Y',
														),
														null,
														array('HIDE_ICONS' => 'Y')
													);?>
												</div>
											</div>
											<div class="bx_filter_parameters_box_container_block">
												<div class="bx_filter_input_container bx_filter_calendar_container">
													<?$APPLICATION->IncludeComponent(
														'bitrix:main.calendar',
														'',
														array(
															'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
															'SHOW_INPUT' => 'Y',
															'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MAX"]["VALUE"]).'" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
															'INPUT_NAME' => $arItem["VALUES"]["MAX"]["CONTROL_NAME"],
															'INPUT_VALUE' => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
															'SHOW_TIME' => 'N',
															'HIDE_TIMEBAR' => 'Y',
														),
														null,
														array('HIDE_ICONS' => 'Y')
													);?>
												</div>
											</div>
											<?
											break;
										default://CHECKBOXES
											$count=count($arItem["VALUES"]);
											$i=1;
											if(!$arItem["FILTER_HINT"] && $arItem["CODE"] !== "FILTER_PRICE"){
												$prop = CIBlockProperty::GetByID($arItem["ID"], $arItem["IBLOCK_ID"])->GetNext();
												$arItem["FILTER_HINT"]=$prop["HINT"];
											}
											if($arItem["IBLOCK_ID"]!=$arParams["IBLOCK_ID"] && strpos($arItem["FILTER_HINT"],'line')!==false){
												$isSize=true;
											}else{
												$isSize=false;
											}?>
											<?$j=1;
											$isHidden = false;?>

											<? if($arItem['IS_PROP_INLINE']): ?>
												<div class="bx_filter_parameters_box_title title bordered rounded-4 shadow-hovered shadow-no-border-hovered font_14 prices">
											<? endif; ?>

											<?if ($count):?>
												<div class="form-checkbox form-checkbox--margined scrolled scroll-deferred <?= !$arItem['IS_PROP_INLINE'] ? 'srollbar-custom' : ''; ?>">
											<?endif;?>

											<?foreach($arItem["VALUES"] as $val => $ar):?>

												<?if($j > $numVisiblePropValues && !$isHidden):
													$isHidden = true;?>
													<div class="hidden_values">
												<?endif;?>
												<input
													type="checkbox"
													value="<? echo $ar["HTML_VALUE"] ?>"
													name="<? echo $ar["CONTROL_NAME"] ?>"
													id="<? echo $ar["CONTROL_ID"] ?>"
													<? echo $ar["DISABLED"] ? 'disabled': '' ?>
													<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
													onclick="smartFilter.click(this)"
													class="form-checkbox__input"
													autocomplete="off"
												/>
												<label data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx_filter_param_label form-checkbox__label color-theme-hover <?=($isSize ? "nab sku" : "");?> <?=($i==$count ? "last" : "");?> <? echo $ar["DISABLED"] ? 'disabled': '' ?>" for="<? echo $ar["CONTROL_ID"] ?>">
													<span class="bx_filter_input_checkbox">

														<span class="bx_filter_param_text" title="<?= $arItem['IS_PROP_INLINE'] ? $arItem['NAME'] : $ar["VALUE"]; ?>"><?= $arItem['IS_PROP_INLINE'] ? $arItem['NAME'] : $ar["VALUE"]; ?><?
														if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"]) && !$isSize):
															?> (<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
														endif;?></span>
													</span>
													<span class="form-checkbox__box form-box"></span>
												</label>
												<?$i++;?>
												<?$j++;?>
											<?endforeach;?>
											<?if ($count):?>
												<?if($isHidden):?>
													</div>
													<div class="inner_expand_text font_14 colored"><span class="expand_block dotted"><?=Loc::getMessage("FILTER_EXPAND_VALUES");?></span></div>
												<?endif;?>
												</div>
											<?endif;?>

											<? if( $arItem['IS_PROP_INLINE'] ): ?>
												<span class="delete_filter colored_theme_bg_hovered_hover" title="<?=Loc::getMessage("CLEAR_VALUE")?>">
													<?=TSolution::showIconSvg("delete_filter", SITE_TEMPLATE_PATH.'/images/svg/catalog/cancelfilter.svg', '', '', false, false);?>
												</span>
												</div>
											<? endif; ?>
									<?}?>
									</div>
									<?if(!$arItem["FILTER_HINT"] && $arItem["CODE"] !== "FILTER_PRICE"){
										$prop = CIBlockProperty::GetByID($arItem["ID"], $arParams["IBLOCK_ID"])->GetNext();
										$arItem["FILTER_HINT"]=$prop["HINT"];
									}?>
									<?if ($arItem["FILTER_HINT"] && $arParams['SHOW_HINTS'] == 'Y'):?>
										<div class="char_name">
											<div class="hint">
												<span class="hint__icon rounded bg-theme-hover border-theme-hover bordered">
													<i>?</i>
												</span>
												<span class="hint__text font_13 color_999">
													<?=Loc::getMessage('HINT');?>
												</span>
												<div class="tooltip tooltip--manual" style="display: none;"><?=$arItem["FILTER_HINT"]?></div>
											</div>
										</div>
									<?endif;?>
									<? if( !$arItem['IS_PROP_INLINE'] ): ?>
										<div class="bx_filter_button_box active clearfix">
											<?/*<span class="btn btn-default btn-sm round-ignore"><?=Loc::getMessage("CT_BCSF_SET_FILTER")?></span>*/?>
											<span data-f="<?=Loc::getMessage('CT_BCSF_SET_FILTER')?>" data-fi="<?=Loc::getMessage('CT_BCSF_SET_FILTER_TI')?>" data-fr="<?=Loc::getMessage('CT_BCSF_SET_FILTER_TR')?>" data-frm="<?=Loc::getMessage('CT_BCSF_SET_FILTER_TRM')?>" class="bx_filter_container_modef btn btn-default btn-sm "><?=Loc::getMessage("CT_BCSF_SET_FILTER")?>:<span></span></span>
										</div>
									<? endif; ?>
								</div>
							</div>
						<?}?>
						<?if($isFilter):?>
							<button class="bx_filter_search_reset btn-link-text font_14 colored<?=($bActiveFilter && $bActiveFilter[1] != 'clear' ? '' : ' hidden');?>" type="reset" id="del_filter" name="del_filter" data-href="">
								<span class="dotted"><?=Loc::getMessage("CT_BCSF_DEL_FILTER")?></span>
							</button>
						<?endif;?>
					</div>
					<?if ($isFilter):?>
						<div class="bx_filter_button_box active hidden">
							<div class="bx_filter_block">
								<div class="bx_filter_parameters_box_container flexbox flexbox--direction-row">
									<?if($arParams["FILTER_VIEW_MODE"] == "VERTICAL"):?>
										<div class="bx_filter_popup_result right" id="modef_mobile" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?>>
											<?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num_mobile">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
											<a href="<?echo $arResult["FILTER_URL"]?>" class="button white_bg"><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
										</div>
									<?endif?>
									<div class="bx_filter_popup_result right font_14" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?>>
										<?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
										<!-- noindex -->
										<a href="<?echo $arResult["FORM_ACTION"]?>" class="popup-result-link animate-arrow-hover" rel="nofollow" title="<?echo GetMessage("CT_BCSF_FILTER_SHOW")?>">
											<span class="arrow-all arrow-all--light-stroke">
												<?=TSolution::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH.'/images/svg/Arrow_map.svg');?>
												<span class="arrow-all__item-line arrow-all--light-bgcolor"></span>
											</span>
										</a>
										<!-- /noindex -->
									</div>
									<input class="bx_filter_search_button btn btn-default" type="submit" id="set_filter" name="set_filter"  value="<?=GetMessage("CT_BCSF_SET_FILTER")?>" />
									<?if ($bActiveFilter && $bActiveFilter[1] != 'clear'):?>
										<button class="bx_filter_search_reset btn btn-transparent-bg btn-default" type="reset" id="del_filter" name="del_filter">
											<?=GetMessage("CT_BCSF_DEL_FILTER")?>
										</button>
									<?endif;?>
								</div>
							</div>
						</div>
					<?endif;?>
				</form>
				<div style="clear: both;"></div>
			</div>
		</div>
		<script>
			var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=$arParams["VIEW_MODE"];?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);

			<?if(!$isFilter){?>
				$('.bx_filter_vertical').remove();
			<?}?>

			BX.message({
				SELECTED: '<? echo GetMessage("SELECTED"); ?>',
			});

			$(document).ready(function(){
				$('.bx_filter_search_reset').on('click', function(){
					<?if($arParams["SEF_MODE"]=="Y"){?>
						location.href=$('form.smartfilter').find('#del_url').val();
					<?}else{?>
						location.href=$('form.smartfilter').attr('action');
					<?}?>
				})
			})
		</script>
	</div>
<?}?>
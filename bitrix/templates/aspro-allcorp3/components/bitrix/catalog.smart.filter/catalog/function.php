<?
if(!function_exists("ShowFilterItemExt")){
	function ShowFilterItemExt($key, $arItem, $arParams){?>
		<?
		global $APPLICATION;
		if ($key!="TOP_BLOCK"){
			if (empty($arItem["VALUES"])|| isset($arItem["PRICE"])) {
				return;
			}
			if (
				$arItem["DISPLAY_TYPE"] == "A"
				&& (
					$arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0
				)
			) {
				return;
			}
		}
		$class="";
		if ($arItem["DISPLAY_EXPANDED"]=="Y") {
			$class = "active";
		}
		if (isset($arItem['PROPERTY_SET']) && $arItem['PROPERTY_SET'] == 'Y') {
			$class .= " opened";
		}
		$numVisiblePropValues = 5;
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
		<div class="bx_filter_parameters_box <?=$class;?>" data-expanded="<?=($arItem["DISPLAY_EXPANDED"] ? $arItem["DISPLAY_EXPANDED"] : "N");?>" data-prop_code=<?=strtolower($arItem["CODE"]);?> data-property_id="<?=$arItem["ID"]?>">
			<?if ( !$arItem['IS_PROP_INLINE'] ):?>	
				<div class="bx_filter_parameters_box_title bg-opacity-theme-parent-hover link-with-flag fill-theme-parent-all menu-arrow-wrapper" >
					<div class="bx_filter_parameter_label">
						<?=$arItem["NAME"]?>
						<?if (strlen($arItem['FILTER_HINT']) && $arParams['SHOW_HINTS'] == 'Y'):?>
							<div class="hint hint--absolute2">
								<span class="hint__icon rounded bg-theme-hover border-theme-hover">
									<i>?</i>
								</span>
								<div class="tooltip tooltip--manual" style="display: none;"><?=$arItem["FILTER_HINT"]?></div>
							</div>
					<?endif;?>
					</div>
					<?=TSolution::showIconSvg("down menu-arrow bg-opacity-theme-target fill-theme-target fill-dark-light", SITE_TEMPLATE_PATH.'/images/svg/Triangle_down.svg', '', '', true, false);?>
				</div>
			<?endif;?>

			<?
				$style = "";

				if ($arItem['IS_PROP_INLINE']) {
					$style="style='display:block;'";
				} elseif($arItem["DISPLAY_EXPANDED"] !== "Y") {
					$style="style='display:none;'";
				}				
			?>
			<div class="bx_filter_block" <?=$style;?>>					
				<span class="bx_filter_container_modef"></span>
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
									$value1 =number_format($value1, 0, ".", " ");
									$value2 =number_format($value2, 0, ".", " ");
									$value3 =number_format($value3, 0, ".", " ");
									$value4 =number_format($value4, 0, ".", " ");
									$value5 =number_format($value5, 0, ".", " ");
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
												placeholder="<?echo $value1;?>"
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
											window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
										});
									</script>
								</div>
								<?
								break;
							case "B"://NUMBERS
								?>
								<div class="fullwidth-input fullwidth-input--margined clearfix">
									<div class="bx_filter_parameters_box_container_block"><div class="bx_filter_input_container bg">
										<input
											class="min-price"
											type="text"
											name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
											id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
											value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
											size="5"
											placeholder="<?echo $arItem["VALUES"]["MIN"]["VALUE"];?>"
											onkeyup="smartFilter.keyup(this)"
											autocomplete="off"
											/>
									</div></div>
									<div class="bx_filter_parameters_box_container_block"><div class="bx_filter_input_container bg">
										<input
											class="max-price"
											type="text"
											name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
											id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
											value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
											placeholder="<?echo $arItem["VALUES"]["MAX"]["VALUE"];?>"
											size="5"
											onkeyup="smartFilter.keyup(this)"
											autocomplete="off"
											/>
									</div></div>
								</div>
								<?
								break;
							case "G"://CHECKBOXES_WITH_PICTURES
								?>
								<?foreach ($arItem["VALUES"] as $val => $ar):?>
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
											<span class="bx_filter_param_btn bx_color_sl" title="<?=$ar["VALUE"]?>">
												<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
												<span class="bx_filter_btn_color_icon" title="<?=$ar["VALUE"]?>" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
												<?endif?>
											</span>
										</label>
									</div>
								<?endforeach?>
								<?
								break;
							case "H"://CHECKBOXES_WITH_PICTURES_AND_LABELS
								?>
								<?foreach ($arItem["VALUES"] as $val => $ar):?>
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
									<label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx_filter_param_label<?=$class?> pal nab" onclick="smartFilter.keyup(BX('<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')); BX.toggleClass(this, 'active');">
										<span class="bx_filter_param_btn bx_color_sl" title="<?=$ar["VALUE"]?>">
											<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
												<span class="bx_filter_btn_color_icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
											<?endif?>
										</span>
										<span class="bx_filter_param_text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
										if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
											?> (<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
										endif;?></span>
									</label>
								<?endforeach?>
								<?
								break;
							case "P"://DROPDOWN
								$checkedItemExist = false;
								?>
								<div class="bx_filter_select_container">
									<div class="bx_filter_select_block s_<?=CUtil::JSEscape($key)?>" data-id="<?=CUtil::JSEscape($key)?>" onclick="smartFilter.showDropDownPopup(this, '<?=CUtil::JSEscape($key)?>')">
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
												echo GetMessage("CT_BCSF_FILTER_ALL");
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
													<label for="<?="all_".$arCur["CONTROL_ID"]?>" class="bx_filter_param_label" data-role="label_<?="all_".$arCur["CONTROL_ID"]?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape("all_".$arCur["CONTROL_ID"])?>')">
														<? echo GetMessage("CT_BCSF_FILTER_ALL"); ?>
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
									<div class="bx_filter_select_block s_<?=CUtil::JSEscape($key)?>" data-id="<?=CUtil::JSEscape($key)?>" onclick="smartFilter.showDropDownPopup(this, '<?=CUtil::JSEscape($key)?>')">
										<div class="bx_filter_select_text" data-role="currentOption">
											<?
											$checkedItemExist = false;
											foreach ($arItem["VALUES"] as $val => $ar):
												if ($ar["CHECKED"])
												{
												?>
													<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
														<span class="bx_filter_param_btn"><span class="bx_filter_btn_color_icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span></span>
													<?endif?>
													<span class="bx_filter_param_text">
														<?=$ar["VALUE"]?>
													</span>
												<?
													$checkedItemExist = true;
												}
											endforeach;
											if (!$checkedItemExist){?>
												<?echo GetMessage("CT_BCSF_FILTER_ALL");
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
													<label for="<?="all_".$arCur["CONTROL_ID"]?>" class="bx_filter_param_label" data-role="label_<?="all_".$arCur["CONTROL_ID"]?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape("all_".$arCur["CONTROL_ID"])?>')">
														<? echo GetMessage("CT_BCSF_FILTER_ALL"); ?>
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
													<label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx_filter_param_label<?=(isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"]) ? ' wselectpict' : '');?><?=$class?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')">
														<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
															<span class="bx_filter_param_btn"><span class="bx_filter_btn_color_icon" title="<?=$ar["VALUE"]?>" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span></span>
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
										<label class="bx_filter_param_label form-radiobox__label color-theme-hover" for="<? echo "all_".$arCur["CONTROL_ID"] ?>">
											<span><? echo GetMessage("CT_BCSF_FILTER_ALL"); ?></span>
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
											<label data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx_filter_param_label form-radiobox__label color-theme-hover <? echo $ar["DISABLED"] ? 'disabled': '' ?>" for="<? echo $ar["CONTROL_ID"] ?>">
												<span class="bx_filter_input_checkbox ">
													
													<span class="bx_filter_param_text1"><?=$ar["VALUE"];?><?
													if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
														?> (<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
													endif;?></span>
												</span>
												<span class="form-radiobox__box form-box"></span>
											</label>
										</div>
										<?$j++;?>
									<?endforeach;?>
									<?if($isHidden):?>
										</div>
										<div class="inner_expand_text font_14 colored"><span class="expand_block dotted"><?=GetMessage("FILTER_EXPAND_VALUES");?></span></div>
									<?endif;?>
								</div>
								<?
								break;
							case "U"://CALENDAR
								?>
								<div class="fullwidth-input fullwidth-input--margined clearfix">
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
								</div>
								<?
								break;
							default://CHECKBOXES
								$count=count($arItem["VALUES"]);
								$i=1;
								if (!$arItem["FILTER_HINT"]) {
									$prop = CIBlockProperty::GetByID($arItem["ID"], $arItem["IBLOCK_ID"])->GetNext();
									$arItem["FILTER_HINT"]=$prop["HINT"];
								}
								if ($arItem["IBLOCK_ID"]!=$arParams["IBLOCK_ID"] && strpos($arItem["FILTER_HINT"],'line')!==false) {
									$isSize=true;
								} else {
									$isSize=false;
								}?>
								<?$j=1;
								$isHidden = false;?>
								<?if ($count):?>
									<div class="form-checkbox form-checkbox--margined scrolled scroll-deferred srollbar-custom">
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
										<? echo $ar["DISABLED"] ? 'disabled ': '' ?>
										<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
										onclick="smartFilter.click(this)"
										class="form-checkbox__input"
										autocomplete="off"
									/>
									<label
										data-role="label_<?=$ar["CONTROL_ID"]?>" class="form-checkbox__label color-theme-hover <?=($isSize ? "nab sku" : "");?> <?=($i==$count ? "last" : "");?> <? echo $ar["DISABLED"] ? 'disabled': '' ?>"
										for="<? echo $ar["CONTROL_ID"] ?>"
									>
										<span class="bx_filter_input_checkbox">
											
											<span class="bx_filter_param_text"><?=$ar["VALUE"];?><?
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
										<div class="inner_expand_text font_14 colored"><span class="expand_block dotted"><?=GetMessage("FILTER_EXPAND_VALUES");?></span></div>
									<?endif;?>
									</div>
								<?endif;?>
						<?}?>
						</div>
						<div class="clearfix"></div>
					</div>
		</div>
	<?}
}?>
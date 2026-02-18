<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die(); ?>
<? Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("FrontPageForm"); ?>
<?
require_once($_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/vendor/php/solution.php');
if (!class_exists('TSolution') || !CModule::IncludeModule(TSolution::moduleID)) {
	ShowError(GetMessage('ASPRO_MODULE_NOT_INSTALLED'));
	return;
}


$arThemes = TSolution::GetFrontParametrsValues(SITE_ID);
$arParams["SHOW_LICENCE"] = $arThemes["SHOW_LICENCE"];
$arParams["LICENCE_TEXT"] = $arThemes["LICENCE_TEXT"];

if (!$arParams["SEND_BUTTON_CLASS"]) {
	$arParams["SEND_BUTTON_CLASS"] = 'btn btn-default btn-lg';
}

$imgType = ($arParams["TYPE_BLOCK"] == 'BG_IMG' ? '' : '_ACTIVE');
$formCode = $formName = $arParams['IMG_PATH'] = '';

$bCRMForm = false;

$FormHtml = '';
foreach(GetModuleEvents(TSolution::moduleID, 'OnAsproAdditionalForm', true) as $arEvent){
	$FormHtml = ExecuteModuleEventEx($arEvent, array($arParams));
}
echo $FormHtml;
if(!empty($FormHtml)){
	return;
}

if($arThemes['USE_BITRIX_FORM'] == 'Y' && \Bitrix\Main\Loader::includeModule('form')):?>
	<?
	if ($arParams['WEBFORM_ID']) {
		$code = $arParams['WEBFORM_ID'];
	} else {
		$code = $arParams['IBLOCK_ID'];
	}
	$bFormID = (int)$code;
	$arFilter = ['ACTIVE' => 'Y', 'SITE' => array(SITE_ID)];
	if ($bFormID) {
		$arFilter['ID'] = $code;
	} else {
		$arFilter += ['SID' => $code, 'SID_EXACT_MATCH' => 'N'];
	}
	$rsForm = CForm::GetList($by = 'id', $order = 'asc', $arFilter, $is_filtered);
	if ($item = $rsForm->Fetch()) {
		$arParams["IBLOCK_ID"] = $item['ID'];
		
		$arSid = explode('_', $item['SID']);
		$sideID = array_pop($arSid);
		$code = implode('_', $arSid);

		$arImgID = TSolution::unserialize(\Bitrix\Main\Config\Option::get(VENDOR_MODULE_ID, 'BGFILE'.strtoupper($code).'_FORM'.$imgType, serialize([]), SITE_ID));
		
		if ($arImgID) {
			$arParams['IMG_PATH'] = CFile::GetPath($arImgID[0]);
		}
		
		$bCRMForm = \Bitrix\Main\Config\Option::get(VENDOR_MODULE_ID, strtoupper($code).'_FORM', 'COMPLEX', SITE_ID) == 'CRM';
		$formCode = $code;
		$formName = $item['NAME'];
	}
	?>
	<?if (!$bCRMForm):?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:form",
			$this->getTemplateName(),
			Array(
				"AJAX_MODE" => $arParams["AJAX_MODE"],
				"SEF_MODE" => "N",
				"WEB_FORM_ID" => $arParams["IBLOCK_ID"],
				"START_PAGE" => "new",
				"SHOW_LIST_PAGE" => "N",
				"SHOW_EDIT_PAGE" => "N",
				"SHOW_VIEW_PAGE" => "N",
				"SUCCESS_URL" => "",
				"SHOW_ANSWER_VALUE" => "N",
				"SHOW_ADDITIONAL" => "N",
				"SHOW_STATUS" => "N",
				"EDIT_ADDITIONAL" => "N",
				"EDIT_STATUS" => "Y",
				"TOTAL_SUMM" => $arParams['TOTAL_SUMM'],
				"NOT_SHOW_FILTER" => "",
				"NOT_SHOW_TABLE" => "",
				"CHAIN_ITEM_TEXT" => "",
				"CHAIN_ITEM_LINK" => "",
				"IGNORE_CUSTOM_TEMPLATE" => "N",
				"IGNORE_AJAX_HEAD" => $arParams["IGNORE_AJAX_HEAD"] ?? "N",
				"USE_EXTENDED_ERRORS" => "Y",
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"AJAX_OPTION_JUMP" => $arParams["AJAX_OPTION_JUMP"],
				"AJAX_OPTION_STYLE" => $arParams["AJAX_OPTION_STYLE"],
				"AJAX_OPTION_HISTORY" => $arParams["AJAX_OPTION_HISTORY"],
				"SHOW_LICENCE" => $arParams["SHOW_LICENCE"],
				"LICENCE_TEXT" => $arParams["LICENCE_TEXT"],
				"DISPLAY_CLOSE_BUTTON" => $arParams["DISPLAY_CLOSE_BUTTON"],
				"SUCCESS_MESSAGE" => $arParams["SUCCESS_MESSAGE"],
				"SEND_BUTTON_CLASS" => $arParams["SEND_BUTTON_CLASS"],
				"SEND_BUTTON_NAME" => $arParams["SEND_BUTTON_NAME"],
				"NARROW" => $arParams["NARROW"],
				"POSITION_IMAGE" => $arParams["POSITION_IMAGE"],
				"SUBTITLE" => $arParams["SUBTITLE"],
				"TITLE" => $arParams["TITLE"],
				"TYPE_BLOCK" => $arParams["TYPE_BLOCK"],
				"CENTERED" => $arParams["CENTERED"],
				"LIGHT_TEXT" => $arParams["LIGHT_TEXT"],
				"LIGHTEN_DARKEN" => $arParams["LIGHTEN_DARKEN"],
				"NO_IMAGE" => $arParams["NO_IMAGE"],
				"IMG_PATH" => $arParams['IMG_PATH'],
				"SHOW_PREVIEW_TEXT" => $arParams["SHOW_PREVIEW_TEXT"],
				"PREVIEWTEXT_FORM" => $arParams["PREVIEWTEXT_FORM"],
				"CLOSE_BUTTON_NAME" => $arParams["CLOSE_BUTTON_NAME"],
				"CLOSE_BUTTON_CLASS" => $arParams["CLOSE_BUTTON_CLASS"],
				"VARIABLE_ALIASES" => Array(
					"action" => "action"
				)
			), false, array('HIDE_ICONS' => 'Y')
		);?>
	<?endif;?>
<?else:?>
	<?if( CModule::IncludeModule("iblock") ){
		$GLOBALS['strError'] = '';
		$antiSpamHiddenFieldCode = 'not_send_confirm_text';
		$processingApprovalFieldCode = 'processing_approval';

		$arImgID = TSolution::unserialize(\Bitrix\Main\Config\Option::get(VENDOR_MODULE_ID, 'BGFILE'.strtoupper($arParams["IBLOCK_ID"]).'_FORM'.$imgType, serialize([]), SITE_ID));

		if ($arImgID) {
			$arParams['IMG_PATH'] = CFile::GetPath($arImgID[0]);
		}

		$bFormID = (int)$arParams["IBLOCK_ID"];
		if (!$bFormID) {
			$code = $arParams["IBLOCK_ID"];	
			$formCode = $formName = $arParams["IBLOCK_ID"];
			$arParams["IBLOCK_ID"] = TSolution\Cache::$arIBlocks[SITE_ID][VENDOR_PARTNER_NAME . '_'. VENDOR_SOLUTION_NAME . '_form'][$arParams["IBLOCK_ID"]][0];

		} else {
			$arIBlock = CIBlock::GetList( false, array( "ID" => $arParams["IBLOCK_ID"] ) )->Fetch();
			$formCode = $arIBlock["CODE"];
			$formName = $arIBlock["NAME"];
			$code = $formCode;
		}
		$bCRMForm = \Bitrix\Main\Config\Option::get(VENDOR_MODULE_ID, strtoupper($code).'_FORM', 'COMPLEX', SITE_ID) == 'CRM';

		if (!$bCRMForm) {
			if( !is_set( $arParams["CACHE_TIME"] ) ){
				$arParams["CACHE_TIME"] = "3600";
			}


			$bCache = !( $_SERVER["REQUEST_METHOD"] == "POST" && !empty( $_REQUEST["form_submit"] ) || $_REQUEST['formresult'] == 'ADDOK' ) && !( $arParams["CACHE_TYPE"] == "N" || ( $arParams["CACHE_TYPE"] == "A" && COption::GetOptionString("main", "component_cache_on", "Y") == "N" ) || ( $arParams["CACHE_TYPE"] == "Y" && intval($arParams["CACHE_TIME"]) <= 0 ) );

			if( $bCache ){
				$arCacheParams = array();
				foreach( $arParams as $key => $value )
					if( substr($key, 0, 1) != "~" )
						$arCacheParams[$key] = $value;
				if($arParams["CACHE_GROUPS"] == "Y")
					$arCacheParams["USER_GROUPS"] = $GLOBALS["USER"]->GetGroups();
				$obFormCache = new CPHPCache;
				$CACHE_ID = SITE_ID."|".$componentName."|".md5(serialize($arCacheParams));
				if( ( $tzOffset = CTimeZone::GetOffset() ) <> 0 )
					$CACHE_ID .= "|".$tzOffset;
				$CACHE_PATH = "/".SITE_ID.CComponentEngine::MakeComponentPath( $componentName );
			}

			if( $bCache && $obFormCache->InitCache( $arParams["CACHE_TIME"], $CACHE_ID, $CACHE_PATH ) ){
				$arCacheVars = $obFormCache->GetVars();
				$bVarsFromCache = true;

				$arResult = $arCacheVars["arResult"];
				$arResult["FORM_NOTE"] = "";
				$arResult["isFormNote"] = "N";
			}else{
				$bVarsFromCache = false;

				if( $arParams["IBLOCK_ID"] > 0 ){
					$arResult["F_RIGHT"] = CIBlock::GetPermission( $arParams["IBLOCK_ID"] );

					if( $arResult["F_RIGHT"] == "D" ){
						$arResult["ERROR"] = "FORM_ACCESS_DENIED";
					}
				}else{
					$arResult["ERROR"] = "FORM_NOT_FOUND";
				}

				$arResult["EVENT_TYPE"] = "ASPRO_SEND_FORM";

				$arIBlock = CIBlock::GetList( false, array( "ID" => $arParams["IBLOCK_ID"] ) )->Fetch();
				$arResult["IBLOCK_CODE"] = $arIBlock["CODE"];
				$arResult["IBLOCK_TITLE"] = $arIBlock["NAME"];
				$arResult["IBLOCK_DESCRIPTION"] = $arIBlock["DESCRIPTION"];
				$arResult["IBLOCK_DESCRIPTION_TYPE"] = $arIBlock["DESCRIPTION_TYPE"];

				if($arIBlock['IBLOCK_TYPE_ID']){
					$arResult["IBLOCK_TYPE_STRING"] = CIBlockType::GetByID($arIBlock['IBLOCK_TYPE_ID'])->Fetch();
				}
				if($arIBlock["IBLOCK_TYPE_ID"] !== $arParams["IBLOCK_TYPE"]){
					$arResult["ERROR"] = "FORM_ACCESS_DENIED";
				}

				$rsProp = CIBlock::GetProperties( $arParams["IBLOCK_ID"], array( "SORT"=> "ASC" ) , array("ACTIVE" => "Y"));
				while( $arProp = $rsProp->Fetch() ){
					$arResult["arQuestions"][] = $arProp;
				}

				if(is_array($arResult["arQuestions"])){
					foreach( $arResult["arQuestions"] as $key => $arQuestion ){
						$tmp = array(
							"NAME" => $arQuestion["NAME"],
							"CODE" => $arQuestion["CODE"],
							"IS_REQUIRED" => $arQuestion["IS_REQUIRED"],
							"HINT" => $arQuestion["HINT"],
							"DEFAULT" => $arQuestion["DEFAULT_VALUE"],
							"ICON" => $arQuestion["XML_ID"]
						);
						if( $arQuestion["PROPERTY_TYPE"] == "S" && empty( $arQuestion["USER_TYPE"] ) ){
							$tmp["FIELD_TYPE"] = "text";
						}elseif( $arQuestion["PROPERTY_TYPE"] == "E" ){
							$propertyCode = $arQuestion['CODE'];
							$tmp["FIELD_TYPE"] = "elements";
							$tmp["LINK_IBLOCK_ID"] = $arQuestion["LINK_IBLOCK_ID"];
						}elseif( $arQuestion["PROPERTY_TYPE"] == "S" && !empty( $arQuestion["USER_TYPE"] ) && $arQuestion["USER_TYPE"] == "Date" ){
							$tmp["FIELD_TYPE"] = "date";
						}elseif( $arQuestion["PROPERTY_TYPE"] == "S" && !empty( $arQuestion["USER_TYPE"] ) && $arQuestion["USER_TYPE"] == "DateTime" ){
							$tmp["FIELD_TYPE"] = "datetime";
						}elseif( $arQuestion["PROPERTY_TYPE"] == "S" && !empty( $arQuestion["USER_TYPE"] ) && $arQuestion["USER_TYPE"] == "HTML" ){
							$tmp["FIELD_TYPE"] = "html";
						}elseif( $arQuestion["PROPERTY_TYPE"] == "N" ){
							$tmp["FIELD_TYPE"] = "integer";
						}elseif( $arQuestion["PROPERTY_TYPE"] == "L" && $arQuestion["LIST_TYPE"] == "L" ){
							$tmp["FIELD_TYPE"] = "list";
						}elseif( $arQuestion["PROPERTY_TYPE"] == "L" && $arQuestion["LIST_TYPE"] == "C" ){
							$tmp["FIELD_TYPE"] = "checkbox";
						}elseif( $arQuestion["PROPERTY_TYPE"] == "F" ){
							$tmp["FIELD_TYPE"] = "file";
						}else{
							continue;
						}

						$tmp["MULTIPLE"] = $arQuestion["MULTIPLE"];

						// if( $tmp["FIELD_TYPE"] != 'checkbox' ){
							$tmp["CAPTION"] = '<label for="'.$arQuestion["CODE"].'" class="font_13 color_999">'.$arQuestion["NAME"].': '.($arQuestion["IS_REQUIRED"] == "Y" ? '<span class="required-star">*</span>' : '').'</label>';
						// }

						$arResult["QUESTIONS"][$arQuestion["CODE"]] = $tmp;
					}
				}

				$arResult["SITE"] = CSite::GetByID(SITE_ID)->Fetch();
				$arModuleOptions = TSolution::GetFrontParametrsValues(SITE_ID);
				$arResult['MODULE_OPTIONS'] = $arModuleOptions;
				$arResult['CAPTCHA_TYPE'] = ($arModuleOptions['CAPTCHA_FORM_TYPE'] == "Y" ? "IMG" : "HIDE");

				if( $bCache ){
					$obFormCache->StartDataCache();
					$GLOBALS['CACHE_MANAGER']->StartTagCache($CACHE_PATH);
					$GLOBALS['CACHE_MANAGER']->RegisterTag("forms");
					$GLOBALS['CACHE_MANAGER']->RegisterTag("form_".$arParams["IBLOCK_ID"]);
					$GLOBALS['CACHE_MANAGER']->EndTagCache();
					$obFormCache->EndDataCache(
						array(
							"arResult" => $arResult,
						)
					);
				}
			}

			$eventDesc = $eventDescAdmin = $messBody = $messBodyAdmin = '';
			if(is_array($arResult["QUESTIONS"])){
				foreach($arResult["QUESTIONS"] as $FIELD_CODE => $arQuestion){
					$eventDesc .= $arQuestion["NAME"].": "."#".$FIELD_CODE."#\n";
					if($arQuestion["FIELD_TYPE"] == "html"){
						$messBody .= $arQuestion["NAME"].":\n"."#".$FIELD_CODE."#\n";
					}
					else{
						$messBody .= $arQuestion["NAME"].": "."#".$FIELD_CODE."#\n";
					}
				}
			}
			$eventDesc .= GetMessage("FORM_ET_DESCRIPTION");
			$eventDescAdmin = $eventDesc.GetMessage("FORM_ET_DESCRIPTION_ADMIN");
			$messBodyAdmin = $messBody;
			$messBodyAdmin .= GetMessage("FORM_EM_ADMIN_LINK");

			$event_name = $arResult["EVENT_TYPE"]."_".$arParams["IBLOCK_ID"];
			$arEvent = CEventType::GetByID( $event_name, $arResult["SITE"]["LANGUAGE_ID"] )->Fetch();
			if( !is_array( $arEvent ) ){
				$et = new CEventType;
				$arEventFields = array(
					"LID" => $arResult["SITE"]["LANGUAGE_ID"],
					"EVENT_NAME" => $event_name,
					"NAME" => GetMessage("FORM_ET_NAME")." \"".$arResult["IBLOCK_TITLE"]."\"",
					"DESCRIPTION" => $eventDesc,
				);
				$et->Add($arEventFields);
				$arEventFields["LID"] = ($arResult["SITE"]["LANGUAGE_ID"] == 'ru' ? 'en' : 'ru');
				$et->Add($arEventFields);
			}

			$arMess = CEventMessage::GetList( $arResult["SITE"]["ID"], $order="desc", array( "TYPE_ID" => $event_name ) )->Fetch();
			if( !is_array( $arMess ) ){
				$em = new CEventMessage;
				$arMess = array();
				$arMess["ID"] = $em->Add( array(
					"ACTIVE" => "Y",
					"EVENT_NAME" => $event_name,
					"LID" => array( $arResult["SITE"]["LID"] ),
					"EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
					"EMAIL_TO" => ($arResult["IBLOCK_CODE"] == 'CALLSTAFF' ? "#STAFF_EMAIL_HIDDEN#" : "#EMAIL#"),
					"BCC" => "",
					"SUBJECT" => GetMessage("FORM_EM_NAME"),
					"BODY_TYPE" => "text",
					"MESSAGE" => GetMessage("FORM_EM_START").$messBody.GetMessage("FORM_EM_END"),
				) );
				$arMess["EVENT_NAME"] = $event_name;
			}

			$event_name_admin = $arResult["EVENT_TYPE"]."_ADMIN_".$arParams["IBLOCK_ID"];
			$arEvent = CEventType::GetByID( $event_name_admin, $arResult["SITE"]["LANGUAGE_ID"] )->Fetch();
			if( !is_array( $arEvent ) ){
				$et = new CEventType;
				$arEventFields = array(
					"LID" => $arResult["SITE"]["LANGUAGE_ID"],
					"EVENT_NAME" => $event_name_admin,
					"NAME" => GetMessage("FORM_ET_NAME")." \"".$arResult["IBLOCK_TITLE"]."\"",
					"DESCRIPTION" => $eventDescAdmin,
				);
				$et->Add($arEventFields);
				$arEventFields["LID"] = ($arResult["SITE"]["LANGUAGE_ID"] == 'ru' ? 'en' : 'ru');
				$et->Add($arEventFields);
			}

			$arMessAdmin = CEventMessage::GetList( $arResult["SITE"]["ID"], $order="desc", array( "TYPE_ID" => $event_name_admin ) )->Fetch();
			if( !is_array( $arMessAdmin ) ){
				$em = new CEventMessage;
				$arMessAdmin = array();
				$arMessAdmin["ID"] = $em->Add( array(
					"ACTIVE" => "Y",
					"EVENT_NAME" => $event_name_admin,
					"LID" => array( $arResult["SITE"]["LID"] ),
					"EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
					"EMAIL_TO" => "#DEFAULT_EMAIL_FROM#",
					"BCC" => "",
					"SUBJECT" => GetMessage("FORM_EM_NAME"),
					"BODY_TYPE" => "text",
					"MESSAGE" => GetMessage("FORM_EM_START_ADMIN").$messBodyAdmin.GetMessage("FORM_EM_END"),
				) );
				$arMessAdmin["EVENT_NAME"] = $event_name_admin;
			}

			if(is_array($arResult["QUESTIONS"])){
				
				foreach( $arResult["QUESTIONS"] as $FIELD_CODE => $arQuestion ){
					$val = '';
					if(isset($_REQUEST[$FIELD_CODE])){
						$val = !empty( $_REQUEST[$FIELD_CODE] ) ? $_REQUEST[$FIELD_CODE] : $arQuestion["DEFAULT"];
						if(!is_array($val)){
							$val = htmlspecialchars($val, (ENT_COMPAT | ENT_HTML401), LANG_CHARSET);
						}
					}
					elseif($arQuestion["FIELD_TYPE"] === "file"){
						$val = $valFile = $arQuestion["DEFAULT"];
						if($arQuestion["MULTIPLE"] == "Y"){
							$valFile = array('n0' => $arQuestion["DEFAULT"], 'n1' => $arQuestion["DEFAULT"]);
						}
					}
					elseif($FIELD_CODE == 'TOTAL_SUMM')
					{
						if($arParams['TOTAL_SUMM'])
						{
							$val = $arParams['TOTAL_SUMM'];
						}
					}

					$required = $arQuestion["IS_REQUIRED"] == "Y" ? 'required' : '';
					$phone = strpos( $arQuestion["CODE"], "PHONE" ) !== false ? 'phone' : '';
					$placeholder = $arParams["IS_PLACEHOLDER"] == "Y" ? 'placeholder="'.$arQuestion["NAME"].'"' : '';
					// $icon = !empty( $arQuestion["ICON"] ) ? '<i class="fa '.$arQuestion["ICON"].'"></i>' : '';
					$html = '';


					switch( $arQuestion["FIELD_TYPE"] ){
						case "hidden":
							$html = '<input type="hidden" id="'.$arQuestion["CODE"].'" name="'.$arQuestion["CODE"].'" class="form-control ignore '.$required.' '.$phone.'" '.$placeholder.' value="'.$val.'" />'.$icon;
							break;
						case "text":
							$html = '<input type="'.( $arQuestion["CODE"] == "EMAIL" ? "email" : ($arQuestion["CODE"] == "PHONE" ? "tel" : "text") ).'" id="'.$arQuestion["CODE"].'" name="'.$arQuestion["CODE"].'" class="form-control '.$required.' '.$phone.'" '.$placeholder.' value="'.$val.'" />'.$icon;
							break;
						case "integer":
							$html = '<input type="number" id="'.$arQuestion["CODE"].'" name="'.$arQuestion["CODE"].'" class="form-control '.$required.'" '.$placeholder.' value="'.$val.'" />'.$icon;
							break;
						case "date":
							$html = '<input type="text" id="'.$arQuestion["CODE"].'" name="'.$arQuestion["CODE"].'" class="form-control date '.$required.'" '.$placeholder.' value="'.$val.'" />'.$icon;
							break;
						case "datetime":
							$html = '<input type="text" id="'.$arQuestion["CODE"].'" name="'.$arQuestion["CODE"].'" class="form-control datetime '.$required.'" '.$placeholder.' value="'.$val.'" />'.$icon;
							break;
						case "html":
							$cur_val = (isset($val['TEXT']) ? $val['TEXT'] : $val);
							$html = '<textarea id="'.$arQuestion["CODE"].'" rows="3" name="'.$arQuestion["CODE"].'" class="form-control '.$required.'" '.$placeholder.'>'.$cur_val.'</textarea>'.$icon;
							break;
						case "elements":
							$rsValue = CIBlockElement::GetList(array( "SORT" => "ASC", "ID" => "ASC" ), array("IBLOCK_ID" => $arQuestion["LINK_IBLOCK_ID"], "ACTIVE" => "Y"), false, false, array("ID", "NAME"));
							$multiple = $arQuestion["MULTIPLE"] == "Y" ? ' multiple ' : '';
							$html = '<select id="'.$arQuestion["CODE"].'" name="'.$arQuestion["CODE"].($arQuestion["MULTIPLE"] == "Y" ? '[]' : '').'" class="form-control '.$required.'" '.$multiple.$placeholder.'>';
							while( $arValue = $rsValue->Fetch() ){
								$selected = '';
								if( !empty( $val ) && (!is_array($val) ? ($arValue["ID"] == $val) : (in_array($arValue["ID"], $val))) ){
									$selected = 'selected="selected"';
								}
								if( empty( $val ) && $arValue["DEF"] == "Y" ){
									$selected = 'selected="selected"';
								}
								$html .= '<option value="'.$arValue["ID"].'" '.$selected.' >'.$arValue["NAME"].'</option>';
								$arResult["QUESTIONS"][$FIELD_CODE]["ENUMS"][$arValue["ID"]] = $arValue["NAME"];
							}
							$html .= '</select>';
							break;
							break;
						case "list":
							$rsValue = CIBlockProperty::GetPropertyEnum( $arQuestion["CODE"], array( "SORT" => "ASC", "ID" => "ASC" ), array("IBLOCK_ID" => $arParams["IBLOCK_ID"]));
							$multiple = $arQuestion["MULTIPLE"] == "Y" ? ' multiple ' : '';
							$html = '<select id="'.$arQuestion["CODE"].'" name="'.$arQuestion["CODE"].($arQuestion["MULTIPLE"] == "Y" ? '[]' : '').'" class="form-control '.$required.'" '.$multiple.$placeholder.'>';
							while( $arValue = $rsValue->Fetch() ){
								$selected = '';
								if( !empty( $val ) && (!is_array($val) ? ($arValue["ID"] == $val) : (in_array($arValue["ID"], $val))) ){
									$selected = 'selected="selected"';
								}
								if( empty( $val ) && $arValue["DEF"] == "Y" ){
									$selected = 'selected="selected"';
								}
								$html .= '<option value="'.$arValue["ID"].'" '.$selected.' >'.$arValue["VALUE"].'</option>';
								$arResult["QUESTIONS"][$FIELD_CODE]["ENUMS"][$arValue["ID"]] = $arValue["VALUE"];
							}
							$html .= '</select>';
							break;
						case "checkbox":
							$html = '';
							$rsValue = CIBlockProperty::GetPropertyEnum( $arQuestion["CODE"], array( "SORT" => "ASC", "ID" => "ASC" ), array("IBLOCK_ID" => $arParams["IBLOCK_ID"]));
							$count = 0;
							while ($arValue = $rsValue->Fetch()) {
								$count++;
							}
							$rsValue = CIBlockProperty::GetPropertyEnum( $arQuestion["CODE"], array( "SORT" => "ASC", "ID" => "ASC" ), array("IBLOCK_ID" => $arParams["IBLOCK_ID"]) );
							
							$multiple = $arQuestion['MULTIPLE'] === 'Y';
							$fieldType = $multiple ? 'checkbox' : 'radio';
							$fieldClass = $multiple ? 'checkbox' : 'radiobox';
							while ($arValue = $rsValue->Fetch()) {
								$artmpValue = $arValue;
								$checked = '';
								$isPopup = $arParams["POPUP"] === "Y" ? 'POPUP_' : '';

								if (!empty($val) && (!is_array($val) ? ($arValue["ID"] == $val) : (in_array($arValue["ID"], $val)))) {
									$checked = 'checked="checked"';
								}
								if (empty($val) && $arValue["DEF"] == "Y") {
									$checked = 'checked="checked"';
								}
								$html .= '<div class="filter '.$fieldClass.'">
											<input class="form-'.$fieldClass.'__input form-'.$fieldClass.'__input--visible" 
													id="'.$isPopup.'s'.$arValue["ID"].'" 
													name="'.$arQuestion["CODE"].($arQuestion["MULTIPLE"] == "Y" ? '[]' : '').'" 
													type="'.$fieldType.'" value="'.$arValue["ID"].'" 
													'.$checked.' 
											/>
											<label class="form-'.$fieldClass.'__label" for="'.$isPopup.'s'.$arValue["ID"].'">'.$arValue["VALUE"].'<span class="form-'.$fieldClass.'__box"></span></label>
										</div>';
								$arResult["QUESTIONS"][$FIELD_CODE]["ENUMS"][$arValue["ID"]] = $arValue["VALUE"];
							}
							break;
						case "file":
							if( $arQuestion["MULTIPLE"] == "Y" ){
								$html = '';
								for( $i = 0; $i < 1; ++$i ){
									$html .= '<input type="file" id="'.$arQuestion["CODE"].'" name="'.$arQuestion["CODE"].'_n'.$i.'" '.$required.' '.$placeholder.' class="inputfile" value="'.$valFile['n'.$i].'" />'.$icon;
								}
							}else{
								$html = '<input type="file" id="'.$arQuestion["CODE"].'" name="'.$arQuestion["CODE"].'" '.$required.' '.$placeholder.' class="inputfile" value="'.$valFile.'" />'.$icon;
							}
							break;
					}

					if ($FIELD_CODE == 'RATING') {?>
						<?ob_start()?>
						<div class="votes_block with-text">
							<div class="ratings">
								<?for($i=1;$i<=5;$i++):?>
									<div class="item-rating" data-message="<?=GetMessage('RATING_MESSAGE_'.$i)?>"><?=\TSolution::showIconSvg("star", SITE_TEMPLATE_PATH."/images/svg/star.svg");?></div>
								<?endfor;?>
							</div>
							<div class="rating_message muted" data-message="<?=GetMessage('RATING_MESSAGE_0')?>"><?=GetMessage('RATING_MESSAGE_0')?></div>
							<?=str_replace('type="text"', 'type="hidden"', $html)?>
						</div>
						<?$html = ob_get_clean()?>
					<?}

					$arResult["QUESTIONS"][$FIELD_CODE]["VALUE"] = $val;
					$arResult["QUESTIONS"][$FIELD_CODE]["HTML_CODE"] = $html;
					
					foreach(GetModuleEvents(TSolution::moduleID, 'OnAsproIBlockFormDrawFields', true) as $arEvent){
						ExecuteModuleEventEx($arEvent, array($FIELD_CODE, &$arResult['QUESTIONS'][$FIELD_CODE]));
					}
				}
			}

			if( strlen( $arResult["ERROR"] ) <= 0 ){
				if( strlen( $_REQUEST["form_submit"] ) > 0 ){
					if($arResult["CAPTCHA_TYPE"] != "NONE")
					{
						if($arResult["CAPTCHA_TYPE"] == "IMG" && ( empty( $_REQUEST["captcha_word"] ) || !$APPLICATION->CaptchaCheckCode( $_REQUEST["captcha_word"], $_REQUEST["captcha_sid"] ) ) )
						{
							$arResult["FORM_ERRORS"][] = GetMessage("FORM_CAPTCHA");
							$captcha_error = true;
						}
					}

					if(is_array($_REQUEST)){
						foreach($_REQUEST as $code => $value){
							if($arResult["QUESTIONS"][$code]["FIELD_TYPE"] == "html"){
								$_REQUEST[$code] = array( "VALUE" => array ("TEXT" => $value, "TYPE" => $arResult["QUESTIONS"][$code]["FIELD_TYPE"]) );
							}
							elseif($arResult["QUESTIONS"][$code]["FIELD_TYPE"] == "date"){
								if(strlen($value)){
									$objDate = new \Bitrix\Main\Type\Date(str_replace(array('-', '/', ' ', ':'), array('.', '.', '.', '.'), $value));
									$_REQUEST[$code] = array("VALUE" => $objDate->toString());
								}
								else{
									$_REQUEST[$code] = array("VALUE" => $value);
								}
							}
							elseif($arResult["QUESTIONS"][$code]["FIELD_TYPE"] == "datetime"){
								if(strlen($value)){
									$arDateTime = explode(' ', $value);
									$objDateTime = new \Bitrix\Main\Type\DateTime(str_replace(array('-', '/', ' ', ':'), array('.', '.', '.', '.'), $arDateTime[0]).' '.str_replace(array('-', '/', ' ', ':'), array(':', ':', ':', ':'), $arDateTime[1]));
									$_REQUEST[$code] = array("VALUE" => $objDateTime->toString());
								}
								else{
									$_REQUEST[$code] = array("VALUE" => $value);
								}
							}
						}
					}

					$arPropFields = $_REQUEST;

					if(is_array($_FILES)){
						foreach($arResult["QUESTIONS"] as $FIELD_CODE => $arQuestion){
							if($arQuestion["FIELD_TYPE"] === 'file'){
								$bMultiple = $arQuestion["MULTIPLE"] === "Y";
								$arFiles = array();
								if(isset($_FILES[$FIELD_CODE]) && !$bMultiple){
									$arFiles[$FIELD_CODE] = $_FILES[$FIELD_CODE];
								}
								elseif($bMultiple){
									foreach($_FILES as $key => $arFile){
										if(strpos($key, '_n') !== false){
											if(is_numeric(str_replace(array($FIELD_CODE, '_', 'n'), '', $key))){
												$code = explode('_', $key);
												if($code[0] == $FIELD_CODE)
													$arFiles[$key] = $_FILES[$key];
											}
										}
									}
								}
								if($arFiles){
									foreach($arFiles as $key => $arFile){
										if($arFile['name']){
											if($arFile['error']){
												$arResult["FORM_ERRORS"][] = GetMessage('FORM_FILE_UPLOAD_ERROR').$arFile['name'];
											}
											else{
												$code = explode('_', $key);
												$tmp = $code[$cntCode - 1];
												$arPropFields[$FIELD_CODE][($tmp ? $tmp : count((array)$arPropFields[$FIELD_CODE]))] = $arFile;
											}
										}
									}
								}
							}
						}
					}

					if(is_array($arResult["QUESTIONS"])){
						foreach( $arResult["QUESTIONS"] as $FIELD_CODE => $arQuestion ){
							if(empty($arPropFields[$FIELD_CODE]) && $arQuestion["IS_REQUIRED"] == "Y" ){
								$arResult["FORM_ERRORS"][] = GetMessage("FORM_REQUIRED_INPUT").$arQuestion["NAME"];
							}
						}
					}

					if (count((array)$arResult["FORM_ERRORS"]) <= 0) {
						$el = new CIBlockElement;

						$arFields = array(
							"IBLOCK_ID" => $arParams["IBLOCK_ID"],
							"ACTIVE" => "Y",
							"NAME" => GetMessage("DEFAULT_NAME") . ConvertTimeStamp(),
							"PROPERTY_VALUES" => $arPropFields,
						);

						try {
							foreach (GetModuleEvents(TSolution::moduleID, "OnBeforeFormSend", true) as $arEvent) {
								ExecuteModuleEventEx($arEvent, array(&$arFields));
							}

							if ($RESULT_ID = $el->Add($arFields)) {
								$arResult["FORM_RESULT"] = "ADDOK";

								foreach (GetModuleEvents(TSolution::moduleID, "OnAfterFormSend", true) as $arEvent) {
									ExecuteModuleEventEx($arEvent, array(&$arFields));
								}

								$arEventFields = array(
									"SITE_NAME" => $arResult["SITE"]["NAME"],
									"FORM_NAME" => $arResult["IBLOCK_TITLE"],
									"ADMIN_RESULT_URL" => (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['SERVER_NAME'] . '/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=' . $arParams['IBLOCK_ID'] . '&type=' . $arResult["IBLOCK_TYPE_STRING"]['ID'] . '&ID=' . $RESULT_ID . '&lang=' . $arResult["SITE"]["LANGUAGE_ID"] . '&find_section_section=0&WF=Y',
									"PAGE_LINK" => ((CSite::inDir(SITE_DIR . 'ajax/') || CSite::inDir(SITE_DIR . 'form/')) ? (isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] ? $_SERVER["HTTP_REFERER"] : $APPLICATION->GetCurPage()) : $APPLICATION->GetCurPage()),
								);

								if (is_array($arResult["QUESTIONS"])) {
									foreach ($arResult["QUESTIONS"] as $FIELD_CODE => $arQuestion) {
										if ($FIELD_CODE !== $antiSpamHiddenFieldCode) {
											if ($arQuestion["FIELD_TYPE"] == "list" || $arQuestion["FIELD_TYPE"] == "checkbox") {
												if ($arQuestion['MULTIPLE'] == 'Y' && is_array($arQuestion["VALUE"])) {
													foreach ($arQuestion["VALUE"] as $value) {
														$arEventFields[$FIELD_CODE][] = $arQuestion["ENUMS"][$value];
													}
													$arEventFields[$FIELD_CODE] = (count((array)$arEventFields[$FIELD_CODE]) > 1 ? "\n" : '') . implode("\n", $arEventFields[$FIELD_CODE]);
												} else {
													$arEventFields[$FIELD_CODE] = $arQuestion["ENUMS"][$arQuestion["VALUE"]];
												}
											} elseif ($arQuestion["FIELD_TYPE"] == "file") {
												$dbRes = CIBlockElement::GetList(array(), array('ID' => $RESULT_ID, 'IBLOCK_ID' => $arParams['IBLOCK_ID']), false, false, array('ID', 'PROPERTY_' . $FIELD_CODE));
												while ($arItem = $dbRes->Fetch()) {
													if ($arItem['PROPERTY_' . strtoupper($FIELD_CODE) . '_VALUE']) {
														$filePath = CFile::GetPath($arItem['PROPERTY_' . strtoupper($FIELD_CODE) . '_VALUE']);
														$fileSize = filesize($_SERVER['DOCUMENT_ROOT'] . $filePath);
														$fileLink = (CMain::IsHTTPS() ? 'https' : 'http') . '://' . $_SERVER['SERVER_NAME'] . $filePath;
														$format = 0;
														$formats = array(GetMessage('FORM_CT_NAME_b'), GetMessage('FORM_CT_NAME_KB'), GetMessage('FORM_CT_NAME_MB'), GetMessage('FORM_CT_NAME_GB'), GetMessage('FORM_CT_NAME_TB'));
														while ($fileSize > 1024 && count($formats) != ($format + 1)) {
															++$format;
															$fileSize = round($fileSize / 1024, 1);
														}
														$arEventFields[$FIELD_CODE][] = GetMessage('FORM_CT_NAME_SIZE') . $fileSize . $formats[$format] . '. ' . GetMessage('FORM_CT_NAME_LINK') . $fileLink;
													}
												}

												$arEventFields[$FIELD_CODE] = (count((array)$arEventFields[$FIELD_CODE]) > 1 ? "\n" : '') . implode("\n", (array)$arEventFields[$FIELD_CODE]);
											} elseif ($arQuestion["FIELD_TYPE"] == "elements") {
												$dbRes = CIBlockElement::GetList(array(), array('ID' => $arQuestion["VALUE"], 'IBLOCK_ID' => $arQuestion['LINK_IBLOCK_ID']), false, false, array('ID', 'NAME'));
												while ($arItem = $dbRes->Fetch()) {
													$arEventFields[$FIELD_CODE][] = $arItem["NAME"];
												}

												$arEventFields[$FIELD_CODE] = (count((array)$arEventFields[$FIELD_CODE]) > 1 ? "\n" : '') . implode("\n", (array)$arEventFields[$FIELD_CODE]);
											} else {
												$arEventFields[$FIELD_CODE] = $arQuestion["VALUE"];
											}
										}
									}
								}
								if (strlen($arEventFields["EMAIL"])) {
									if (isset($arEventFields['ORDER_LIST']) && strpos('aspro_' . VENDOR_SOLUTION_NAME . '_order_page', $arResult['IBLOCK_CODE']) !== false) {
										$arEventFields['ORDER_LIST'] = implode(($arMess['BODY_TYPE'] === 'text' ? "\n" : '<br />'), $arResult["QUESTIONS"]['ORDER_LIST']["VALUE"]);
										if (isset($arEventFields['SESSION_ID'])) {
											unset($arEventFields['SESSION_ID']);
										}
									}
									CEvent::SendImmediate($arMess["EVENT_NAME"], SITE_ID, $arEventFields, "Y", $arMess["ID"]);
								}

								if (isset($arEventFields['ORDER_LIST']) && strpos('aspro_' . VENDOR_SOLUTION_NAME . '_order_page', $arResult['IBLOCK_CODE']) !== false) {
									$arEventFields['ORDER_LIST'] = implode(($arMessAdmin['BODY_TYPE'] === 'text' ? "\n" : '<br />'), $arResult["QUESTIONS"]['ORDER_LIST']["VALUE"]);
								}
								CEvent::SendImmediate($arMessAdmin["EVENT_NAME"], SITE_ID, $arEventFields, "Y", $arMessAdmin["ID"]);

								if ($arParams["SEF_MODE"] == "Y") {
									LocalRedirect(
										$APPLICATION->GetCurPageParam(
											"formresult=" . urlencode($arResult["FORM_RESULT"]),
											array('formresult', 'strFormNote', 'SEF_APPLICATION_CUR_PAGE_URL')
										)
									);

									die();
								} else {
									LocalRedirect(
										$APPLICATION->GetCurPageParam(
											"IBLOCK_ID=" . $arParams["IBLOCK_ID"]
											. "&RESULT_ID=" . $RESULT_ID
												. "&formresult=" . urlencode($arResult["FORM_RESULT"]),
											array('formresult', 'strFormNote', 'IBLOCK_ID', 'RESULT_ID')
										)
									);

									die();
								}
							} else {
								$arResult["FORM_ERRORS"][] = $el->LAST_ERROR;
							}
						} catch (\Bitrix\Main\SystemException $e) {
							$arResult["FORM_ERRORS"][] = $e->getMessage();
						}
					}
				}

				if(!empty( $_REQUEST["formresult"] ) && strtoupper($_REQUEST["formresult"]) == "ADDOK"){
					$successNoteFile = SITE_DIR."include/form/success_{$arResult["IBLOCK_CODE"]}.php";
					if(\Bitrix\Main\IO\File::isFileExists(\Bitrix\Main\Application::getDocumentRoot().$successNoteFile)):
						$arResult['FORM_NOTE'] = \Bitrix\Main\IO\File::getFileContents(\Bitrix\Main\Application::getDocumentRoot().$successNoteFile);
					else:
						$arResult['FORM_NOTE'] = !empty( $arParams["SUCCESS_MESSAGE"] ) ? $arParams["~SUCCESS_MESSAGE"] : GetMessage('FORM_NOTE_ADDOK');
					endif;
				}

				$arResult["isFormErrors"] = (isset($arResult["FORM_ERRORS"]) && count($arResult["FORM_ERRORS"]) > 0 ? "Y" : "N");

				if($arResult["CAPTCHA_TYPE"] == "IMG")
					$arResult["CAPTCHACode"] = $APPLICATION->CaptchaGetCode();

				$arResult = array_merge(
					$arResult,
					array(
						"isFormNote" => strlen( $arResult["FORM_NOTE"] ) ? "Y" : "N",

						"FORM_HEADER" => sprintf(
							"<form name=\"%s\" action=\"%s\" method=\"%s\" enctype=\"multipart/form-data\"  class='".($arResult['MODULE_OPTIONS']['RECAPTCHA_LOGO'] == 'N' ? 'hidde_gr_block' : '')."'>",
							$arResult["IBLOCK_CODE"], POST_FORM_ACTION_URI, "POST"
						).$res .= bitrix_sessid_post(),
						"isIblockTitle" => strlen( $arResult["IBLOCK_TITLE"] ) > 0 ? "Y" : "N",
						"isIblockDescription" => strlen( $arResult["IBLOCK_DESCRIPTION"] ) > 0 ? "Y" : "N",
						"DATE_FORMAT" => CLang::GetDateFormat("SHORT"),
						"FORM_FOOTER" => "</form>",
						"SUBMIT_BUTTON" => "<button class=\"".$arParams["SEND_BUTTON_CLASS"]."\" type=\"submit\">".$arParams["SEND_BUTTON_NAME"]."</button><br/><input type=\"hidden\" name=\"form_submit\" value=\"".GetMessage("FORM_ADD")."\">",
						"CLOSE_BUTTON" => "<button class=\"".$arParams["CLOSE_BUTTON_CLASS"]."\" data-url=\"".$APPLICATION->GetCurPageParam('',	array('formresult', 'strFormNote', 'IBLOCK_ID', 'RESULT_ID', 'bxajaxid', 'AJAX_CALL', 'SEF_APPLICATION_CUR_PAGE_URL'))."\">".$arParams["CLOSE_BUTTON_NAME"]."</button>",

					)
				);

				if(($arResult["isUseCaptcha"] = ($arResult["CAPTCHA_TYPE"] === 'IMG') ? 'Y' : 'N') === 'Y')
				{
					$arResult["CAPTCHA_CAPTION"] = "<label for=\"captcha_word\" class=\"font_13 color_999\">".GetMessage("FORM_CAPTCHA_FIELD_TITLE")."&nbsp;<span class=\"required-star\">*</span></label>";
					$arResult["CAPTCHA_IMAGE"] = "<input type=\"hidden\" name=\"captcha_sid\" class=\"captcha_sid\" value=\"".htmlspecialcharsbx($arResult["CAPTCHACode"])."\" /><img src=\"/bitrix/tools/captcha.php?captcha_sid=".htmlspecialcharsbx($arResult["CAPTCHACode"])."\" class=\"captcha_img\" width=\"180\" height=\"40\" />";
					$captcha_val = !empty( $_REQUEST["captcha_word"] ) ? $_REQUEST["captcha_word"] : "";
					$captcha_val = htmlspecialchars($captcha_val, (ENT_COMPAT | ENT_HTML401), LANG_CHARSET);
					$arResult["CAPTCHA_FIELD"] = "<input id=\"captcha_word\" type=\"text\" name=\"captcha_word\" value=\"".$captcha_val."\" class=\"form-control captcha required\" autocomplete=\"off\" />".($captcha_error ? "<label for=\"captcha_word\" class=\"error\">".GetMessage("CAPTCHA_ERROR")."</label>" : "");


					$arResult["CAPTCHA_ERROR"] = $captcha_error ? "Y" : "N";
				}

				if($arResult["isFormErrors"] == "Y"){
					ob_start();
					ShowError( implode( '<br />', $arResult["FORM_ERRORS"] ) );
					$arResult["FORM_ERRORS_TEXT"] = ob_get_contents();
					ob_end_clean();
				}

				if($arResult["CAPTCHA_TYPE"] == "HIDE")
				{
					$val = "";
					if(isset($_REQUEST["nspm"])){
						$val = !empty( $_REQUEST["nspm"] ) ? $_REQUEST["nspm"]  : "";
						if(!is_array($val)){
							$val = htmlspecialchars($val, (ENT_COMPAT | ENT_HTML401), LANG_CHARSET);
						}
					}
					$arResult["QUESTIONS"]["CAPTCHA"] = array(
						"HTML_CODE" => "<textarea name='nspm' style='display:none;'>".$val."</textarea>",
						"CAPTION" => "",
						"FIELD_TYPE" => "hidden",
						"STRUCTURE" => array(
							array(
								"FIELD_TYPE" => "hidden"
							)
						)
					);
				}
				
				$this->initComponentTemplate();

				$this->IncludeComponentTemplate();
			}else{
				ShowError(GetMessage($arResult["ERROR"]));
			}
		}
	}else{
		ShowError(GetMessage("FORM_MODULE_NOT_INSTALLED"));
	}?>
<?endif;?>
<?//b24 form?>
<?if ($bCRMForm):?>
	<?$id = $arParams['POPUP'] ?>
	<?if ($arParams['POPUP'] == 'Y'):?>
		<script data-skip-moving="true">
			window.b24form = false;
		</script>
	<?endif;?>
	<?echo '<div id="bx24_form_inline_second'.$id.'"></div>';
	$bitrix24 = @file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/form/b24/'.$formCode.'_FORM.php');

	if( strpos($bitrix24, '/bitrix/header.php') !== false ){
		$templatePatterns = [
			'/\<\?\s*require\(\$_SERVER\[\"DOCUMENT_ROOT\"\]\.\"\/bitrix\/header.php\"\);\s*\$APPLICATION->SetTitle\(\"\"\);\?\>/s',
			'/\<\?\s*require\(\$_SERVER\[\"DOCUMENT_ROOT\"\]\.\"\/bitrix\/footer.php\"\);\?\>/s'
		];
		$bitrix24 = preg_replace($templatePatterns, '', $bitrix24);
	}

	$pattern = '/script\s*id\s*=\s*[\'\"](\s*\w*\s*)[\'\"]/s';
	$replacement = 'script id="$1_2"';
	$bitrix24 = preg_replace($pattern, $replacement, $bitrix24);

	$pattern = '/b24form\s*\({\s*\w*".*:\s*(".*\s*"(?!\,)\s*})\);/s';
	preg_match($pattern, $bitrix24, $matches);
	$need = str_replace('}', ', "node": document.getElementById("bx24_form_inline_second'.$id.'")}', $matches[0]);
	$bitrix24 = str_replace($matches[0], $need, $bitrix24);

	if(!$bitrix24):?>
		<div class="form popup">
			<div class="form-header">
				<h2><?=$formName?></h2>
			</div>
			<div class="form-body">
				<div class="alert alert-danger">
					File not found or file is empty
				</div>
			</div>
			<div class="form-footer"></div>
		</div>
	<?else:?>
		<?print_r($bitrix24);
	endif;?>
<?endif;?>

<? Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("FrontPageForm", ""); ?>
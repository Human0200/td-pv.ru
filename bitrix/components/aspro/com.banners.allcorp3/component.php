<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!class_exists('TSolution') || !CModule::IncludeModule(TSolution::moduleID)) {
	ShowError(GetMessage('ASPRO_MODULE_NOT_INSTALLED'));
	return;
}

global $USER, $APPLICATION;
global $arRegion, $arTheme;

CPageOption::SetOptionString("main", "nav_page_in_session", "N");

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
if(strlen($arParams["IBLOCK_TYPE"])<=0)
	$arParams["IBLOCK_TYPE"] = "news";
$arParams["IBLOCK_ID"] = trim($arParams["IBLOCK_ID"]);

$arParams["SORT_BY1"] = trim($arParams["SORT_BY1"]);
if(strlen($arParams["SORT_BY1"])<=0)
	$arParams["SORT_BY1"] = "ACTIVE_FROM";
if(!preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["SORT_ORDER1"]))
	$arParams["SORT_ORDER1"]="DESC";

if(strlen($arParams["SORT_BY2"])<=0)
	$arParams["SORT_BY2"] = "SORT";
if(!preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["SORT_ORDER2"]))
	$arParams["SORT_ORDER2"]="ASC";

if(strlen($arParams["FILTER_NAME"])<=0 || !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $arParams["FILTER_NAME"]))
{
	$arParams["FILTER_NAME"] = "arRegionLink";
	$arrFilter = array();
}
$arrFilter = $GLOBALS[$arParams["FILTER_NAME"]];
if(!is_array($arrFilter))
	$arrFilter = array();

$arParams["CHECK_DATES"] = $arParams["CHECK_DATES"]!="N";

if(!is_array($arParams["FIELD_CODE"]))
	$arParams["FIELD_CODE"] = array();
foreach($arParams["FIELD_CODE"] as $key=>$val)
	if(!$val)
		unset($arParams["FIELD_CODE"][$key]);

if(!is_array($arParams["PROPERTY_CODE"]))
	$arParams["PROPERTY_CODE"] = array();
foreach($arParams["PROPERTY_CODE"] as $key=>$val)
	if($val==="")
		unset($arParams["PROPERTY_CODE"][$key]);

$arParams["NEWS_COUNT"] = intval($arParams["NEWS_COUNT"]);
if($arParams["NEWS_COUNT"]<=0)
	$arParams["NEWS_COUNT"] = 20;

$arParams["USE_PERMISSIONS"] = $arParams["USE_PERMISSIONS"]=="Y";
if(!is_array($arParams["GROUP_PERMISSIONS"]))
	$arParams["GROUP_PERMISSIONS"] = array(1);

$bUSER_HAVE_ACCESS = !$arParams["USE_PERMISSIONS"];
if($arParams["USE_PERMISSIONS"] && isset($GLOBALS["USER"]) && is_object($GLOBALS["USER"]))
{
	$arUserGroupArray = $USER->GetUserGroupArray();
	foreach($arParams["GROUP_PERMISSIONS"] as $PERM)
	{
		if(in_array($PERM, $arUserGroupArray))
		{
			$bUSER_HAVE_ACCESS = true;
			break;
		}
	}
}

if($arRegion){
	$arrFilter["REGION_BANNER_ID"] = $arRegion["ID"];
}

$strCurrentTemplate = $arTheme["INDEX_TYPE"]["SUB_PARAMS"][$arTheme["INDEX_TYPE"]["VALUE"]]["BIG_BANNER_INDEX"]["TEMPLATE"]["VALUE"];
$currentBanner = $arTheme["INDEX_TYPE"]["SUB_PARAMS"][$arTheme["INDEX_TYPE"]["VALUE"]]["BIG_BANNER_INDEX"]["TEMPLATE"]["LIST"][$strCurrentTemplate];

if ($arParams['SET_FROM_PARAMS'] === 'Y') {
	$arParams["HEIGHT_BANNER"] = $arParams["HEIGHT_BANNER"] === 'FROM_THEME' 
		? $currentBanner["ADDITIONAL_OPTIONS"]["HEIGHT_BANNER"]["VALUE"]
		: $arParams["HEIGHT_BANNER"];
	
	$arParams["NARROW_BANNER"] = $arParams["NARROW_BANNER"] === 'FROM_THEME' 
		? $currentBanner["ADDITIONAL_OPTIONS"]["NARROW_BANNER"]["VALUE"] === 'Y'
		: $arParams["NARROW_BANNER"] === 'Y';
	
	$arParams["NO_OFFSET_BANNER"] = $arParams["NO_OFFSET_BANNER"] === 'FROM_THEME' 
		? $currentBanner["ADDITIONAL_OPTIONS"]["NO_OFFSET_BANNER"]["VALUE"] === 'Y' || $arParams['HEADER_OPACITY']
		: $arParams["NO_OFFSET_BANNER"] === 'Y' || $arParams['HEADER_OPACITY'];
	
	$arParams["WIDE_TEXT"] = $arParams["TITLE_LARGE"] = $arParams["WIDE_TEXT"] === 'FROM_THEME' 
		? $currentBanner["ADDITIONAL_OPTIONS"]["WIDE_TEXT"]["VALUE"] === 'Y'
		: $arParams["WIDE_TEXT"] === 'Y';

	if ($arParams["BANNER_TYPE"] === 'type_2') {
		$arParams["ALL_WIDTH_BUTTONS"] = true;
		$arParams["SLIDER_ITEMS"] = 3;
	}
	if ($arParams["BANNER_TYPE"] === 'type_3') {
		$arParams["TEXT_PADDING_LEFT_WIDE"] = true;
		$arParams["TEXT_PADDING_LEFT_NARROW"] = true;
		$arParams["INNER_PADDING_NARROW"] = true;
	}
	if ($arParams["BANNER_TYPE"] === 'type_4') {
		$arParams["INNER_PADDING_WIDE"] = false;
		$arParams["INNER_PADDING_NARROW"] = true;
	}
	if ($arParams["BANNER_TYPE"] === 'type_5') {
		$arParams["TEXT_PADDING_LEFT_WIDE"] = true;
		$arParams["TEXT_PADDING_RIGHT"] = true;
		$arParams["NO_MAXWITH_THEME_WIDE"] = true;
		$arParams["IMG_POSITION"] = "SQUARE";
		$arParams["WIDE_TEXT"] = false;
	}

	$arParams['HEADER_OPACITY'] = $arParams["BANNER_TYPE"] === 'type_1' ? true : false;
	$arParams['BANNER_TYPE_THEME_CHILD'] = $arParams["BANNER_TYPE"] !== 'type_3' ? '' : $arParams["BANNER_TYPE_THEME_CHILD"];
} else {
	$arParams["HEIGHT_BANNER"] = $currentBanner["ADDITIONAL_OPTIONS"]["HEIGHT_BANNER"]["VALUE"];
	$arParams["NARROW_BANNER"] = $currentBanner["ADDITIONAL_OPTIONS"]["NARROW_BANNER"]["VALUE"] == "Y";
	$arParams["NO_OFFSET_BANNER"] = $currentBanner["ADDITIONAL_OPTIONS"]["NO_OFFSET_BANNER"]["VALUE"] == "Y" || $arParams['HEADER_OPACITY'];
	$arParams["WIDE_TEXT"] = $arParams["TITLE_LARGE"] = $currentBanner["ADDITIONAL_OPTIONS"]["WIDE_TEXT"]["VALUE"] == "Y";
}

$arParams['CURRENT_BANNER_INDEX'] = TSolution::getCurrentPresetBannerIndex(SITE_ID);
$arParams['BIGBANNER_MOBILE'] = $arTheme['BIGBANNER_MOBILE']['VALUE'];
$arParams['BIGBANNER_HIDEONNARROW'] = $arTheme['BIGBANNER_HIDEONNARROW']['VALUE'];
$arParams['BIGBANNER_SLIDESSHOWSPEED'] = $arTheme['BIGBANNER_SLIDESSHOWSPEED']['VALUE'];
$arParams['BIGBANNER_ANIMATIONSPEED'] = $arTheme['BIGBANNER_ANIMATIONSPEED']['VALUE'];
$arParams['BIGBANNER_ANIMATIONTYPE'] = $arTheme['BIGBANNER_ANIMATIONTYPE']['VALUE'];
$arParams['SLIDER_VIEW_MOBILE'] = $arTheme["MOBILE_BIG_BANNER_INDEX"]["VALUE"];

if ($arParams['CODE_BLOCK']) {
	$indexPageOptions = $arTheme['INDEX_TYPE']['SUB_PARAMS'][ $arTheme['INDEX_TYPE']['VALUE'] ];
	$blockOptions = $indexPageOptions[$arParams['CODE_BLOCK']];
	$blockTemplateOptions = $blockOptions['TEMPLATE']['LIST'][ $blockOptions['TEMPLATE']['VALUE'] ];

	if ($arParams['WIDE'] === 'FROM_THEME') {
		$arParams['WIDE'] = $blockTemplateOptions["ADDITIONAL_OPTIONS"]["WIDE"]["VALUE"];
	}
	if ($arParams['ITEMS_OFFSET'] === 'FROM_THEME') {
		$arParams['ITEMS_OFFSET'] = $blockTemplateOptions["ADDITIONAL_OPTIONS"]["ITEMS_OFFSET"]["VALUE"];
	}
	if ($arParams['TEXT_CENTER'] === 'FROM_THEME') {
		$arParams['TEXT_CENTER'] = $blockTemplateOptions["ADDITIONAL_OPTIONS"]["TEXT_CENTER"]["VALUE"];
	}
	if ($arParams['SHORT_BLOCK'] === 'FROM_THEME') {
		$arParams['SHORT_BLOCK'] = $blockTemplateOptions["ADDITIONAL_OPTIONS"]["SHORT_BLOCK"]["VALUE"];
	}
	if ($arParams['LINES_COUNT'] === 'FROM_THEME') {
		$arParams['LINES_COUNT'] = $blockTemplateOptions["ADDITIONAL_OPTIONS"]["LINES_COUNT"]["VALUE"];
	}
	if ($arParams['ELEMENTS_ROW'] === 'FROM_THEME') {
		$arParams['ELEMENTS_ROW'] = $blockTemplateOptions["ADDITIONAL_OPTIONS"]["ELEMENTS_COUNT"]["VALUE"];
	}
	if ($arParams['TEXT_POSITION'] === 'FROM_THEME') {
		$arParams['TEXT_POSITION'] = $blockTemplateOptions["ADDITIONAL_OPTIONS"]["TEXT_POSITION"]["VALUE"];
	}
}

if($this->StartResultCache(false, array(($arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups()), $bUSER_HAVE_ACCESS, $arNavigation, $arrFilter)))
{
	if( !CModule::IncludeModule("iblock") )
	{
		$this->AbortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}
	if(is_numeric($arParams["IBLOCK_ID"]))
	{
		$rsIBlock = CIBlock::GetList(array(), array(
			"ACTIVE" => "Y",
			"ID" => $arParams["IBLOCK_ID"],
		));
	}
	else
	{
		$rsIBlock = CIBlock::GetList(array(), array(
			"ACTIVE" => "Y",
			"CODE" => $arParams["IBLOCK_ID"],
			"SITE_ID" => SITE_ID,
		));
	}
	if($arResult = $rsIBlock->GetNext())
	{
		$arResult["USER_HAVE_ACCESS"] = $bUSER_HAVE_ACCESS;
		//SELECT
		$arSelect = array_merge($arParams["FIELD_CODE"], array(
			"ID",
			"IBLOCK_ID",
			"IBLOCK_SECTION_ID",
			"NAME",
			"ACTIVE_FROM",			
			"DETAIL_PICTURE",
			"PREVIEW_PICTURE",
			"PREVIEW_TEXT",
			"SORT",
		));
		$bGetProperty = count($arParams["PROPERTY_CODE"])>0;
		if($bGetProperty)
			$arSelect[]="PROPERTY_*";
		//WHERE
		$bannerTypeID=0;
		$arBannersCode = $arCode = array();
		$bUseType = !($arParams['SET_BANNER_FROM_TYPE'] == 'N');

		if($arParams["BANNER_TYPE_THEME"])
		{
			$arCode[] = $arParams["BANNER_TYPE_THEME"];
			if($arParams["BANNER_TYPE_THEME_CHILD"])
				$arCode[] = $arParams["BANNER_TYPE_THEME_CHILD"];

				

			$rsItem = CIBlockElement::GetList(Array("SORT"=>"ASC", "ID" => "ASC"),  Array("IBLOCK_ID" => $arParams["TYPE_BANNERS_IBLOCK_ID"], "CODE" => $arCode), false, false, Array("IBLOCK_ID", "ID", "CODE"));
			while($arItem = $rsItem->Fetch())
				$arBannersCode[$arItem["CODE"]] = $arItem["ID"];
		}
		if (!$bUseType) {
			$arBannersCode['ALL'] = 'ALL';
		}
		if(!$arBannersCode)
		{
			$this->abortResultCache();
			return;
		}

		$arFilter = array (
			"IBLOCK_ID" => $arResult["ID"],
			"IBLOCK_LID" => SITE_ID,
			"ACTIVE" => "Y",
		);
		
		if($arParams["CHECK_DATES"])
			$arFilter["ACTIVE_DATE"] = "Y";


		//ORDER BY
		$arSort = array(
			$arParams["SORT_BY1"]=>$arParams["SORT_ORDER1"],
			$arParams["SORT_BY2"]=>$arParams["SORT_ORDER2"],
		);
		if(!array_key_exists("ID", $arSort))
			$arSort["ID"] = "DESC";

		$obParser = new CTextParser;
		$arResult["ITEMS"] = array();
		$arResult["ELEMENTS"] = array();
		$arResult['HAS_SLIDE_BANNERS'] = $arResult['HAS_CHILD_BANNERS'] = false;
		$j = 1;

		foreach($arBannersCode as $key => $arTypeBaner)
		{
			$arFilter2 = array();
			$count = ($j == 1 ? '' : $j);
			++$j;

			if($arParams["BANNER_TYPE_THEME_CHILD"] && $key == $arParams["BANNER_TYPE_THEME_CHILD"] && $arParams["SECTION_ID"])
				$arFilter2["SECTION_ID"] = $arParams["SECTION_ID"];

			if($arParams['SECTION_ITEM_CODE'])
				$arFilter2["SECTION_CODE"] = $arParams["SECTION_ITEM_CODE"];


			if( $arParams["NEWS_COUNT".$count] ) {
				if ($bUseType) {
					$arFilter2["PROPERTY_TYPE_BANNERS.CODE"] = $key;
				}
				$rsElement = CIBlockElement::GetList($arSort, array_merge($arFilter, $arrFilter, $arFilter2), false, array("nTopCount" => $arParams["NEWS_COUNT".$count]), $arSelect);
			}
			while($obElement = $rsElement->GetNextElement())
			{
				$arItem = $obElement->GetFields();
				$arItem["TYPE_BANNER"] = $key;
				$arButtons = CIBlock::GetPanelButtons(
					$arItem["IBLOCK_ID"],
					$arItem["ID"],
					0,
					array("SECTION_BUTTONS"=>false, "SESSID"=>false)
				);
				$arItem["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
				$arItem["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];
				
				$arItem["FORMAT_NAME"]=str_replace("&lt;br/&gt;", "", $arItem["NAME"]);

				if($arParams["PREVIEW_TRUNCATE_LEN"] > 0)
					$arItem["PREVIEW_TEXT"] = $obParser->html_cut($arItem["PREVIEW_TEXT"], $arParams["PREVIEW_TRUNCATE_LEN"]);

				if(strlen($arItem["ACTIVE_FROM"])>0)
					$arItem["DISPLAY_ACTIVE_FROM"] = CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], MakeTimeStamp($arItem["ACTIVE_FROM"], CSite::GetDateFormat()));
				else
					$arItem["DISPLAY_ACTIVE_FROM"] = "";

				if(strlen($arItem["DATE_CREATE"])>0)
					$arItem["DISPLAY_DATE_CREATE"] = CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], MakeTimeStamp($arItem["DATE_CREATE"], CSite::GetDateFormat()));
				else
					$arItem["DISPLAY_DATE_CREATE"] = "";

				if(array_key_exists("DETAIL_PICTURE", $arItem))
					$arItem["DETAIL_PICTURE"] = CFile::GetFileArray($arItem["DETAIL_PICTURE"]);
					
				if(array_key_exists("PREVIEW_PICTURE", $arItem))
					$arItem["PREVIEW_PICTURE"] = CFile::GetFileArray($arItem["PREVIEW_PICTURE"]);

				$arItem["FIELDS"] = array();
				foreach($arParams["FIELD_CODE"] as $code)
					if(array_key_exists($code, $arItem))
						$arItem["FIELDS"][$code] = $arItem[$code];

				if($bGetProperty)
					$arItem["PROPERTIES"] = $obElement->GetProperties();

				$arItem["DISPLAY_PROPERTIES"]=array();
				foreach($arParams["PROPERTY_CODE"] as $pid)
				{
					$prop = &$arItem["PROPERTIES"][$pid];
					if(
						(is_array($prop["VALUE"]) && count($prop["VALUE"])>0)
						|| (!is_array($prop["VALUE"]) && strlen($prop["VALUE"])>0)
					)
					{
						$arItem["DISPLAY_PROPERTIES"][$pid] = CIBlockFormatProperties::GetDisplayValue($arItem, $prop, "news_out");
					}
				}
				
				$arrTizersFilter = array('ID' => $arItem['PROPERTIES']['LINK_TIZERS']['VALUE'], 'IBLOCK_ID' => $arParams["TIZERS_IBLOCK_ID"], 'GLOBAL_ACTIVE' => 'Y', 'ACTIVE' => 'Y');
				$arrTizersSelect = array('ID', 'NAME', 'DETAIL_TEXT', 'PREVIEW_TEXT', 'PROPERTY_LINK', 'PROPERTY_TIZER_ICON');
				$arItem['TIZERS'] = TSolution\Cache::CIblockElement_GetList(array("SORT" => 'ASC', 'ID' => 'ASC', "CACHE" => array("TAG" => TSolution\Cache::GetIBlockCacheTag($arParams["TIZERS_IBLOCK_ID"]), 'GROUP' => array('ID'))), $arrTizersFilter, false, false, $arrTizersSelect);

				$arResult["ITEMS"][] = $arItem;
				$arResult["ELEMENTS"][] = $arItem["ID"];
			}
		}
		
		$this->SetResultCacheKeys(array(
			"ID",
			"IBLOCK_TYPE_ID",
			"LIST_PAGE_URL",			
			"NAME",
			"SECTION",
			"ELEMENTS",
		));		

		$this->IncludeComponentTemplate();
	}
	else
	{
		$this->AbortResultCache();
		ShowError(GetMessage("T_NEWS_NEWS_NA"));
		@define("ERROR_404", "Y");
		if($arParams["SET_STATUS_404"]==="Y")
			CHTTP::SetStatus("404 Not Found");
	}
}

if(isset($arResult["ID"]))
{
	$arTitleOptions = null;
	if($USER->IsAuthorized())
	{
		if(
			$APPLICATION->GetShowIncludeAreas()
			|| (is_object($GLOBALS["INTRANET_TOOLBAR"]) && $arParams["INTRANET_TOOLBAR"]!=="N")
			|| $arParams["SET_TITLE"]
		)
		{
			if(CModule::IncludeModule("iblock"))
			{
				$arButtons = CIBlock::GetPanelButtons(
					$arResult["ID"],
					0,
					$arParams["PARENT_SECTION"],
					array("SECTION_BUTTONS"=>false)
				);

				if($APPLICATION->GetShowIncludeAreas())
					$this->AddIncludeAreaIcons(CIBlock::GetComponentMenu($APPLICATION->GetPublicShowMode(), $arButtons));

				if(
					is_array($arButtons["intranet"])
					&& is_object($GLOBALS["INTRANET_TOOLBAR"])
					&& $arParams["INTRANET_TOOLBAR"]!=="N"
				)
				{
					$APPLICATION->AddHeadScript('/bitrix/js/main/utils.js');
					foreach($arButtons["intranet"] as $arButton)
						$GLOBALS["INTRANET_TOOLBAR"]->AddButton($arButton);
				}

				if($arParams["SET_TITLE"])
				{
					$arTitleOptions = array(
						'ADMIN_EDIT_LINK' => $arButtons["submenu"]["edit_iblock"]["ACTION"],
						'PUBLIC_EDIT_LINK' => "",
						'COMPONENT_NAME' => $this->GetName(),
					);
				}
			}
		}
	}

	$this->SetTemplateCachedData($arResult["NAV_CACHED_DATA"]);
	
	return $arResult["ELEMENTS"];
}?>
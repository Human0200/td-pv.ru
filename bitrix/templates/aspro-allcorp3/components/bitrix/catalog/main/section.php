<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<?

use Bitrix\Main\Loader,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\ModuleManager;

Loader::includeModule("iblock");

global $arTheme, $NextSectionID, $arRegion, $bHideLeftBlock;

$arPageParams = $arSection = $section = array();

if (!$arParams["SECTION_DISPLAY_PROPERTY"]) {
	$arParams["SECTION_DISPLAY_PROPERTY"] = "UF_VIEWTYPE";
}
$bOrderViewBasket = (trim($arTheme['ORDER_VIEW']['VALUE']) === 'Y');
$_SESSION['SMART_FILTER_VAR'] = $arParams['FILTER_NAME'];?>

<?$bShowLeftBlock = ($arTheme["LEFT_BLOCK_CATALOG_SECTIONS"]["VALUE"] == "Y" && !defined("ERROR_404") && !$bHideLeftBlock);?>

<?$APPLICATION->SetPageProperty("MENU", 'N');?>
<?$APPLICATION->AddViewContent('right_block_class', 'catalog_page ');?>

<div class="top-content-block">
	<?$APPLICATION->ShowViewContent('top_content');?>
	<?$APPLICATION->ShowViewContent('top_content2');?>
</div>

<?
$arParams['SHOW_ONE_CLINK_BUY'] = $arTheme["SHOW_ONE_CLICK_BUY"]["VALUE"];
$arParams['MAX_GALLERY_ITEMS'] = $arTheme["SHOW_CATALOG_GALLERY_IN_LIST"]["DEPENDENT_PARAMS"]["MAX_GALLERY_ITEMS"]["VALUE"];
$arParams['SHOW_GALLERY'] = $arTheme["SHOW_CATALOG_GALLERY_IN_LIST"]["VALUE"];
?>

<?
//set params for props from module
TSolution\Functions::replacePropsParams($arParams);
?>

<?// get current section ID
$arSectionFilter = [];
if ($arResult["VARIABLES"]["SECTION_ID"] > 0) {
	$arSectionFilter = array('GLOBAL_ACTIVE' => 'Y', "ID" => $arResult["VARIABLES"]["SECTION_ID"], "IBLOCK_ID" => $arParams["IBLOCK_ID"]);
} elseif (strlen(trim($arResult["VARIABLES"]["SECTION_CODE"])) > 0) {
	$arSectionFilter = array('GLOBAL_ACTIVE' => 'Y', "=CODE" => $arResult["VARIABLES"]["SECTION_CODE"], "IBLOCK_ID" => $arParams["IBLOCK_ID"]);
}
if ($arSectionFilter) {
	$section = TSolution\Cache::CIBlockSection_GetList(array('CACHE' => array("MULTI" =>"N", "TAG" => TSolution\Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), TSolution::makeSectionFilterInRegion($arSectionFilter), false, array("ID", "IBLOCK_ID", "NAME", "DESCRIPTION", "UF_TOP_SEO", 'UF_FILTER_VIEW', "UF_TABLE_PROPS", "UF_INCLUDE_SUBSECTION", "UF_PICTURE_RATIO", "UF_PRICE_COMPACT", $arParams["SECTION_DISPLAY_PROPERTY"], "IBLOCK_SECTION_ID", "DEPTH_LEVEL", "LEFT_MARGIN", "RIGHT_MARGIN"));
}

$typeSKU = '';
$bSetElementsLineRow = false;

if ($section) {
	$arSection["ID"] = $section["ID"];
    if ($arParams['ADD_SECTIONS_CHAIN'] !== 'N') {
        $NextSectionID = $arSection['ID'];
    }

	$arSection["NAME"] = $section["NAME"];
	$arSection["IBLOCK_SECTION_ID"] = $section["IBLOCK_SECTION_ID"];
	$arSection["DEPTH_LEVEL"] = $section["DEPTH_LEVEL"];
	if ($section[$arParams["SECTION_DISPLAY_PROPERTY"]]) {
		$arDisplayRes = CUserFieldEnum::GetList(array(), array("ID" => $section[$arParams["SECTION_DISPLAY_PROPERTY"]]));
		if ($arDisplay = $arDisplayRes->GetNext()) {
			$arSection["DISPLAY"] = $arDisplay["XML_ID"];
		}
	}

	if (strlen($section["DESCRIPTION"])) {
		$arSection["DESCRIPTION"] = $section["DESCRIPTION"];
	}
	if (strlen($section["UF_TOP_SEO"])) {
		$arSection["UF_TOP_SEO"] = $section["UF_TOP_SEO"];
	}
	$posSectionDescr = COption::GetOptionString(VENDOR_MODULE_ID, "SHOW_SECTION_DESCRIPTION", "BOTTOM", SITE_ID);

	global $arSubSectionFilter;
	$arSubSectionFilter = array(
		"SECTION_ID" => $arSection["ID"],
		"IBLOCK_ID" => $arParams['IBLOCK_ID'],
		"ACTIVE" => "Y",
		"GLOBAL_ACTIVE" => "Y",
	);
	$iSectionsCount = count(TSolution\Cache::CIblockSection_GetList(array("CACHE" => array("TAG" => TSolution\Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]), "MULTI" => "Y")), TSolution::makeSectionFilterInRegion($arSubSectionFilter)));

	if ($arParams['SHOW_MORE_SUBSECTIONS'] === 'N') {
		$iSectionsCount = 0;
	}

	// set smartfilter view
	$viewTmpFilter = 0;
	if ($section['UF_FILTER_VIEW']) {
		$viewTmpFilter = $section['UF_FILTER_VIEW'];
	}

	$viewTableProps = 0;
	if ($section['UF_TABLE_PROPS']) {
		$viewTableProps = $section['UF_TABLE_PROPS'];
	}

	$viewPictureRatio = 0;
	if ($section['UF_PICTURE_RATIO']) {
		$viewPictureRatio = $section['UF_PICTURE_RATIO'];
	}

	$includeSubsection = '';
	if ($section['UF_INCLUDE_SUBSECTION']) {
		$includeSubsection = $section['UF_INCLUDE_SUBSECTION'];
	}

	if (!$viewTmpFilter || !$arSection["DISPLAY"] || !$viewTableProps || !$includeSubsection) {
		if ($section['DEPTH_LEVEL'] > 1) {
			$sectionParent = TSolution\Cache::CIBlockSection_GetList(array('CACHE' => array("MULTI" =>"N", "TAG" => TSolution\Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), array('GLOBAL_ACTIVE' => 'Y', "ID" => $section["IBLOCK_SECTION_ID"], "IBLOCK_ID" => $arParams["IBLOCK_ID"]), false, array("ID", "IBLOCK_ID", "NAME", 'UF_FILTER_VIEW', "UF_TABLE_PROPS", "UF_PICTURE_RATIO", "UF_INCLUDE_SUBSECTION", "UF_PRICE_COMPACT", $arParams["SECTION_DISPLAY_PROPERTY"]));
			if ($sectionParent['UF_FILTER_VIEW'] && !$viewTmpFilter) {
				$viewTmpFilter = $sectionParent['UF_FILTER_VIEW'];
			}
			if ($sectionParent['UF_TABLE_PROPS'] && !$viewTableProps) {
				$viewTableProps = $sectionParent['UF_TABLE_PROPS'];
			}
			if ($sectionParent['UF_INCLUDE_SUBSECTION'] && !$includeSubsection) {
				$includeSubsection = $sectionParent['UF_INCLUDE_SUBSECTION'];
			}
			if ($sectionParent[$arParams["SECTION_DISPLAY_PROPERTY"]] && !$arSection["DISPLAY"]) {
				$arDisplayRes = CUserFieldEnum::GetList(array(), array("ID" => $sectionParent[$arParams["SECTION_DISPLAY_PROPERTY"]]));
				if ($arDisplay = $arDisplayRes->GetNext()) {
					$arSection["DISPLAY"] = $arDisplay["XML_ID"];
				}
			}

			if ($section['DEPTH_LEVEL'] > 2) {
				if (!$viewTmpFilter || !$arSection["DISPLAY"] || !$viewTableProps || !$includeSubsection) {
					$sectionRoot = TSolution\Cache::CIBlockSection_GetList(array('CACHE' => array("MULTI" =>"N", "TAG" => TSolution\Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), array('GLOBAL_ACTIVE' => 'Y', "<=LEFT_BORDER" => $section["LEFT_MARGIN"], ">=RIGHT_BORDER" => $section["RIGHT_MARGIN"], "DEPTH_LEVEL" => 1, "IBLOCK_ID" => $arParams["IBLOCK_ID"]), false, array("ID", "IBLOCK_ID", "NAME", 'UF_FILTER_VIEW', "UF_PICTURE_RATIO", "UF_TABLE_PROPS", "UF_INCLUDE_SUBSECTION", "UF_PRICE_COMPACT", $arParams["SECTION_DISPLAY_PROPERTY"]));
					if ($sectionRoot['UF_FILTER_VIEW'] && !$viewTmpFilter) {
						$viewTmpFilter = $sectionRoot['UF_FILTER_VIEW'];
					}
					if ($sectionRoot['UF_TABLE_PROPS'] && !$viewTableProps) {
						$viewTableProps = $sectionRoot['UF_TABLE_PROPS'];
					}
					if ($sectionRoot['UF_INCLUDE_SUBSECTION'] && !$includeSubsection) {
						$includeSubsection = $sectionRoot['UF_INCLUDE_SUBSECTION'];
					}
					if ($sectionRoot[$arParams["SECTION_DISPLAY_PROPERTY"]] && !$arSection["DISPLAY"]) {
						$arDisplayRes = CUserFieldEnum::GetList(array(), array("ID" => $sectionRoot[$arParams["SECTION_DISPLAY_PROPERTY"]]));
						if ($arDisplay = $arDisplayRes->GetNext()) {
							$arSection["DISPLAY"] = $arDisplay["XML_ID"];
						}
					}
				}
			}
		}
	}
	if ($viewTmpFilter) {
		$rsViews = CUserFieldEnum::GetList(array(), array('ID' => $viewTmpFilter));
		if ($arView = $rsViews->Fetch()) {
			$viewFilter = $arView['XML_ID'];
			$arTheme['FILTER_VIEW']['VALUE'] = strtoupper($viewFilter);
		}
	}
	if ($viewTableProps) {
		$rsViews = CUserFieldEnum::GetList(array(), array('ID' => $viewTableProps));
		if ($arView = $rsViews->Fetch()) {
			$typeTableProps = strtolower($arView['XML_ID']);
		}
	}
	if ($includeSubsection) {
		$rsViews = CUserFieldEnum::GetList(array(), array('ID' => $includeSubsection));
		if ($arView = $rsViews->Fetch()) {
			$arParams["INCLUDE_SUBSECTIONS"] = $arView['XML_ID'];
		}
	}

	if ($viewPictureRatio) {
		$rsViews = CUserFieldEnum::GetList(array(), array('ID' => $viewPictureRatio));
		if ($arView = $rsViews->Fetch()) {
			$arParams["PICTURE_RATIO"] = $arView['XML_ID'];
		}
	}

	$arParams['PICTURE_RATIO'] ?? strtolower(TSolution::GetFrontParametrValue('ELEMENTS_IMG_TYPE'));

	$arElementFilter = array("SECTION_ID" => $arSection["ID"], "ACTIVE" => "Y", "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"], "IBLOCK_ID" => $arParams["IBLOCK_ID"]);
	if ($arParams["INCLUDE_SUBSECTIONS"] == "A") {
		$arElementFilter["INCLUDE_SUBSECTIONS"] = "Y";
		$arElementFilter["SECTION_GLOBAL_ACTIVE"] = "Y";
		$arElementFilter["SECTION_ACTIVE "] = "Y";
	}

	if (
		$arRegion
		&& TSolution::getFrontParametrValue('REGIONALITY_FILTER_ITEM') == 'Y'
		&& TSolution::getFrontParametrValue('REGIONALITY_FILTER_CATALOG') == 'Y'
	) {
		$arElementFilter['PROPERTY_LINK_REGION'] = $arRegion['ID'];
	}


	$itemsCnt = TSolution\Cache::CIBlockElement_GetList(array("CACHE" => array("TAG" => TSolution\Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), TSolution::makeElementFilterInRegion($arElementFilter), array());
}

$linerow = $arParams["LINE_ELEMENT_COUNT"];

$bHideSideSectionBlock = ($arParams["SHOW_SIDE_BLOCK_LAST_LEVEL"] == "Y" && $iSectionsCount && $arParams["INCLUDE_SUBSECTIONS"] == "N");
if ($bHideSideSectionBlock) {
	$APPLICATION->SetPageProperty("MENU", "N");
}

$arParams['FILTER_VIEW'] = 'VERTICAL';
if($arTheme['SHOW_SMARTFILTER']['VALUE'] !== 'N' && $itemsCnt){
	if (
		$arTheme['SHOW_SMARTFILTER']['DEPENDENT_PARAMS']['FILTER_VIEW']['VALUE'] == 'COMPACT' || !$bShowLeftBlock
	) {
		$arParams['FILTER_VIEW'] = 'COMPACT';
	}
}

$bMobileSectionsCompact = $arTheme['MOBILE_LIST_SECTIONS_COMPACT_IN_SECTIONS']['VALUE'] === 'Y';

$mobileListElementsView = TSolution::GetFrontParametrValue('MOBILE_LIST_ELEMENTS_COMPACT_IN_SECTIONS');
$bMobileItemsCompact = $mobileListElementsView === 'Y';
$bMobileOneRow = $mobileListElementsView === 'ONE_ROW';
?>
<div class="main-wrapper flexbox flexbox--direction-row">
	<div class="section-content-wrapper <?=($bShowLeftBlock ? 'with-leftblock' : '');?> flex-1">
		<?if (!$section):?>
			<?\Bitrix\Iblock\Component\Tools::process404(
				""
				,($arParams["SET_STATUS_404"] === "Y")
				,($arParams["SET_STATUS_404"] === "Y")
				,($arParams["SHOW_404"] === "Y")
				,$arParams["FILE_404"]
			);?>
		<?endif;?>

		<?if ($section):?>
			<?
			//seo
			$catalogInfoIblockId = $arParams["LANDING_IBLOCK_ID"];
			if ($catalogInfoIblockId && !$bSimpleSectionTemplate) {
				$arSeoItems = TSolution\Cache::CIBLockElement_GetList(array('SORT' => 'ASC', 'CACHE' => array("MULTI" => "Y", "TAG" => TSolution\Cache::GetIBlockCacheTag($catalogInfoIblockId))), array("IBLOCK_ID" => $catalogInfoIblockId, "ACTIVE" => "Y"), false, false, array("ID", "IBLOCK_ID", "PROPERTY_FILTER_URL", "PROPERTY_LINK_REGION"));
				$arSeoItem = $arTmpRegionsLanding = array();
				if ($arSeoItems) {
					$iLandingItemID = 0;
					$current_url =  $APPLICATION->GetCurDir();
					$url = urldecode(str_replace(' ', '+', $current_url));
					foreach ($arSeoItems as $arItem) {
						if (!is_array($arItem['PROPERTY_LINK_REGION_VALUE'])) {
							$arItem['PROPERTY_LINK_REGION_VALUE'] = (array)$arItem['PROPERTY_LINK_REGION_VALUE'];
						}

						if (!$arSeoItem) {
							$urldecoded = urldecode($arItem["PROPERTY_FILTER_URL_VALUE"]);
							$urldecodedCP = iconv("utf-8", "windows-1251//IGNORE", $urldecoded);
							if ($urldecoded == $url || $urldecoded == $current_url || $urldecodedCP == $current_url) {
								if ($arItem['PROPERTY_LINK_REGION_VALUE']) {
									if ($arRegion && in_array($arRegion['ID'], $arItem['PROPERTY_LINK_REGION_VALUE'])) {
										$arSeoItem = $arItem;
									}
								} else {
									$arSeoItem = $arItem;
								}

								if ($arSeoItem) {
									$iLandingItemID = $arSeoItem['ID'];
									$arSeoItem = TSolution\Cache::CIBLockElement_GetList(array('SORT' => 'ASC', 'CACHE' => array("MULTI" => "N", "TAG" => TSolution\Cache::GetIBlockCacheTag($catalogInfoIblockId))), array("IBLOCK_ID" => $catalogInfoIblockId, "ID" => $iLandingItemID), false, false, array("ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT", "DETAIL_PICTURE", "PREVIEW_PICTURE", "PROPERTY_FILTER_URL", "PROPERTY_LINK_REGION", "PROPERTY_FORM_QUESTION", "PROPERTY_SECTION_SERVICES", "PROPERTY_TIZERS", "PROPERTY_SECTION", "DETAIL_TEXT", "PROPERTY_I_ELEMENT_PAGE_TITLE", "PROPERTY_I_ELEMENT_PREVIEW_PICTURE_FILE_ALT", "PROPERTY_I_ELEMENT_PREVIEW_PICTURE_FILE_TITLE", "PROPERTY_I_SKU_PAGE_TITLE", "PROPERTY_I_SKU_PREVIEW_PICTURE_FILE_ALT", "PROPERTY_I_SKU_PREVIEW_PICTURE_FILE_TITLE", "ElementValues"));

									$arIBInheritTemplates = array(
										"ELEMENT_PAGE_TITLE" => $arSeoItem["PROPERTY_I_ELEMENT_PAGE_TITLE_VALUE"],
										"ELEMENT_PREVIEW_PICTURE_FILE_ALT" => $arSeoItem["PROPERTY_I_ELEMENT_PREVIEW_PICTURE_FILE_ALT_VALUE"],
										"ELEMENT_PREVIEW_PICTURE_FILE_TITLE" => $arSeoItem["PROPERTY_I_ELEMENT_PREVIEW_PICTURE_FILE_TITLE_VALUE"],
										"SKU_PAGE_TITLE" => $arSeoItem["PROPERTY_I_SKU_PAGE_TITLE_VALUE"],
										"SKU_PREVIEW_PICTURE_FILE_ALT" => $arSeoItem["PROPERTY_I_SKU_PREVIEW_PICTURE_FILE_ALT_VALUE"],
										"SKU_PREVIEW_PICTURE_FILE_TITLE" => $arSeoItem["PROPERTY_I_SKU_PREVIEW_PICTURE_FILE_TITLE_VALUE"],
									);
                                    if (TSolution::isSmartSeoInstalled()) {
                                        Aspro\Smartseo\General\Smartseo::disallowNoindexRule(true);
                                    }
								}
							}
						}

						if ($arItem['PROPERTY_LINK_REGION_VALUE']) {
							if (!$arRegion || !in_array($arRegion['ID'], $arItem['PROPERTY_LINK_REGION_VALUE'])) {
								$arTmpRegionsLanding[] = $arItem['ID'];
							}
						}
					}
				}

				if ($arSeoItems && $bHideSideSectionBlock) {
					$arSeoItems = [];
				}
			}

			$arParams['FILTER_ELEMENTS_CNT'] = [];
			if ($arRegion) {
				$arParams["USE_REGION"] = "Y";

				$GLOBALS[$arParams['FILTER_NAME']]['IBLOCK_ID'] = $arParams['IBLOCK_ID'];
				if (
					TSolution::getFrontParametrValue('REGIONALITY_FILTER_ITEM') == 'Y'
					&& TSolution::getFrontParametrValue('REGIONALITY_FILTER_CATALOG') == 'Y'
				) {
					$GLOBALS[$arParams['FILTER_NAME']]['PROPERTY_LINK_REGION'] = $arRegion['ID'];
				}

				TSolution::makeElementFilterInRegion($GLOBALS[$arParams['FILTER_NAME']]);
			}


			/* hide compare link from module options */
			if (TSolution::GetFrontParametrValue('CATALOG_COMPARE') == 'N') {
				$arParams["USE_COMPARE"] = 'N';
			}

			$bContolAjax = (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest" && isset($_GET["control_ajax"]) && $_GET["control_ajax"] == "Y" );
			$sViewElementTemplate = ($arParams["SECTION_ELEMENTS_TYPE_VIEW"] == "FROM_MODULE" ? $arTheme["ELEMENTS_CATALOG_PAGE"]["VALUE"] : $arParams["SECTION_ELEMENTS_TYPE_VIEW"]);
			?>
			<?// section elements?>
			<div class="js_wrapper_items<?=($arTheme["LAZYLOAD_BLOCK_CATALOG"]["VALUE"] == "Y" ? ' with-load-block' : '')?>" >
				<div class="js-load-wrapper">
					<?if($bContolAjax):?>
						<?$APPLICATION->RestartBuffer();?>
					<?endif;?>

					<?@include_once('page_blocks/'.$sViewElementTemplate.'.php');?>
					<?TSolution\Extensions::init('images_detail');?>

					<?if($bContolAjax):?>
						<?die();?>
					<?endif;?>
				</div>
			</div>

			<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.history.js');?>
		<?else:?>
			<div class="alert alert-danger">
				<?=($arParams['MESSAGE_404'] ?:Loc::getMessage("NOT_FOUNDED_SECTION"));?>
			</div>
		<?endif;?>
	</div>
	<?if($bShowLeftBlock):?>
		<?TSolution::ShowPageType('left_block');?>
	<?endif;?>
</div>

<?
TSolution::setCatalogSectionDescription(
	array(
		'FILTER_NAME' => $arParams['FILTER_NAME'],
		'CACHE_TYPE' => $arParams['CACHE_TYPE'],
		'CACHE_TIME' => $arParams['CACHE_TIME'],
		'SECTION_ID' => $arSection['ID'],
		'SHOW_SECTION_DESC' => $arParams['SHOW_SECTION_DESC'],
		'SEO_ITEM' => $arSeoItem,
	)
);
?>

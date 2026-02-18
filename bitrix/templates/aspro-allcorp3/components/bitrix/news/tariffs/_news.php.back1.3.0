<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

global $arTheme, $APPLICATION;

$bShowLeftBlock = ($arTheme['LEFT_BLOCK_TARIFFS_ROOT']['VALUE'] === 'Y' && !defined('ERROR_404'));
$APPLICATION->SetPageProperty('MENU', 'N');

// get section items count and subsections
$arItemFilter = TSolution::GetCurrentSectionElementFilter($arResult["VARIABLES"], $arParams, false);
$arSubSectionFilter = TSolution::GetCurrentSectionSubSectionFilter($arResult["VARIABLES"], $arParams, false);
$itemsCnt = TSolution\Cache::CIBlockElement_GetList(array("CACHE" => array("TAG" => TSolution\Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), $arItemFilter, array());
$arSubSections = TSolution\Cache::CIBlockSection_GetList(array("CACHE" => array("TAG" => TSolution\Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]), "MULTI" => "Y")), $arSubSectionFilter, false, array("ID"));

// is ajax: need for ajax pagination
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'  && isset($_GET['ajax_get']) && $_GET['ajax_get'] === 'Y' || (isset($_GET['AJAX_REQUEST']) && $_GET['AJAX_REQUEST'] === 'Y');
?>
<?if(TSolution::GetFrontParametrValue('TARIFFS_USE_DETAIL') !== 'Y'):?>
	<?TSolution::goto404Page();?>
<?else:?>
	<?if(!$itemsCnt && !$arSubSections):?>
		<div class="alert alert-warning"><?=GetMessage("SECTION_EMPTY")?></div>
	<?else:?>
		<?TSolution::CheckComponentTemplatePageBlocksParams($arParams, __DIR__);?>

		<?// rss?>
		<?if($arParams['USE_RSS'] !== 'N'):?>
			<?$this->SetViewTarget('cowl_buttons');?>
			<?TSolution\Functions::ShowRSSIcon(
				array(
					'URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['rss']
				)
			);?>
			<?$this->EndViewTarget();?>
		<?endif;?>

		<div class="tariffs-wrapper">
			<?if($arSubSections):?>
				<?$sViewElementTemplate = ($arParams["SECTIONS_TYPE_VIEW"] == "FROM_MODULE" ? $arTheme["SECTIONS_TYPE_VIEW_TARIFFS"]["VALUE"] : $arParams["SECTIONS_TYPE_VIEW"]);?>
				<?@include_once('page_blocks/'.$sViewElementTemplate.'.php');?>
			<?endif;?>

			<?if(!$arSubSections && $arParams['INCLUDE_SUBSECTIONS'] !== 'N'):?>
				<?// section elements?>
				<?if(strlen($arParams["FILTER_NAME"])):?>
					<?$GLOBALS[$arParams["FILTER_NAME"]] = array_merge((array)$GLOBALS[$arParams["FILTER_NAME"]], $arItemFilter);?>
				<?else:?>
					<?$arParams["FILTER_NAME"] = "arrFilter";?>
					<?$GLOBALS[$arParams["FILTER_NAME"]] = $arItemFilter;?>
				<?endif;?>

				<?$sViewElementTemplate = ($arParams["SECTION_ELEMENTS_TYPE_VIEW"] == "FROM_MODULE" ? $arTheme["ELEMENTS_PAGE_TARIFFS"]["VALUE"] : $arParams["SECTION_ELEMENTS_TYPE_VIEW"]);?>
				<?@include_once('page_blocks/'.$sViewElementTemplate.'.php');?>
			<?endif;?>
		</div>
	<?endif;?>

	<?// intro text?>
	<?ob_start();?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "page",
			"AREA_FILE_SUFFIX" => "inc",
			"EDIT_TEMPLATE" => ""
		)
	);?>
	<?$html = trim(ob_get_contents());?>
	<?ob_end_clean();?>
	<?if($html || $bShowLeftBlock):?>
		<div class="main-wrapper flexbox flexbox--direction-row">
			<div class="section-content-wrapper <?=($bShowLeftBlock ? 'with-leftblock' : '');?> flex-1 detail-maxwidth">
				<?if($html):?>
					<div class="text_before_items">
						<?$APPLICATION->IncludeComponent(
							"bitrix:main.include",
							"",
							Array(
								"AREA_FILE_SHOW" => "page",
								"AREA_FILE_SUFFIX" => "inc",
								"EDIT_TEMPLATE" => ""
							)
						);?>
					</div>
				<?endif;?>
			</div>

			<?if($bShowLeftBlock):?>
				<?TSolution::ShowPageType('left_block');?>
			<?endif;?>
		</div>
	<?endif;?>
<?endif;?>
<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

global $arTheme, $APPLICATION, $NextSectionID;

$bShowLeftBlock = ($arTheme['LEFT_BLOCK_TARIFFS_SECTIONS']['VALUE'] === 'Y' && !defined('ERROR_404'));
$APPLICATION->SetPageProperty('MENU', 'N');

// get section items count and subsections
$arItemFilter = TSolution::GetCurrentSectionElementFilter($arResult["VARIABLES"], $arParams);
$arSectionFilter = TSolution::GetCurrentSectionFilter($arResult["VARIABLES"], $arParams);
$itemsCnt = TSolution\Cache::CIblockElement_GetList(array("CACHE" => array("TAG" => TSolution\Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), $arItemFilter, array());
$arSection = TSolution\Cache::CIblockSection_GetList(array("CACHE" => array("TAG" => TSolution\Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]), "MULTI" => "N")), $arSectionFilter, false, array('ID', 'NAME', 'DESCRIPTION', 'PICTURE', 'DETAIL_PICTURE', 'IBLOCK_ID', 'UF_TOP_SEO'));
$arSubSectionFilter = TSolution::GetCurrentSectionSubSectionFilter($arResult["VARIABLES"], $arParams, $arSection['ID']);
$arSubSections = TSolution\Cache::CIblockSection_GetList(array("CACHE" => array("TAG" => TSolution\Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]), "MULTI" => "Y")), $arSubSectionFilter, false, array("ID", "DEPTH_LEVEL"));
?>
<?if(TSolution::GetFrontParametrValue('TARIFFS_USE_DETAIL') !== 'Y'):?>
	<?TSolution::goto404Page();?>
<?else:?>
	<?if(!$arSection && $arParams['SET_STATUS_404'] !== 'Y'):?>
		<div class="alert alert-warning"><?=GetMessage("SECTION_NOTFOUND")?></div>
	<?elseif(!$arSection && $arParams['SET_STATUS_404'] === 'Y'):?>
		<?TSolution::goto404Page();?>
	<?else:?>
        <?
        if ($arParams['ADD_SECTIONS_CHAIN'] !== 'N') {
            $NextSectionID = $arSection['ID'];
        }
		TSolution::AddMeta(
			array(
				'og:description' => $arSection['DESCRIPTION'],
				'og:image' => (($arSection['PICTURE'] || $arSection['DETAIL_PICTURE']) ? CFile::GetPath(($arSection['PICTURE'] ? $arSection['PICTURE'] : $arSection['DETAIL_PICTURE'])) : false),
			)
		);

		TSolution::CheckComponentTemplatePageBlocksParams($arParams, __DIR__);
		?>

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

		<?if(!$arSubSections && !$itemsCnt):?>
			<div class="alert alert-warning"><?=GetMessage("SECTION_EMPTY")?></div>
		<?endif;?>

		<div class="tariffs-wrapper">
			<?if($arSubSections):?>
				<?// sections list?>
				<?$sViewElementTemplate = ($arParams["SECTION_TYPE_VIEW"] == "FROM_MODULE" ? $arTheme["SECTION_TYPE_VIEW_TARIFFS"]["VALUE"] : $arParams["SECTION_TYPE_VIEW"]);?>

				<div class="section-wrapper-list">
					<?@include_once('page_blocks/'.$sViewElementTemplate.'.php');?>
				</div>
			<?endif;?>

			<?if (TSolution::checkAjaxRequest()):?>
				<?$APPLICATION->RestartBuffer()?>
			<?endif;?>

			<?// section elements?>
			<?$sViewElementTemplate = ($arParams["SECTION_ELEMENTS_TYPE_VIEW"] == "FROM_MODULE" ? $arTheme["ELEMENTS_PAGE_TARIFFS"]["VALUE"] : $arParams["SECTION_ELEMENTS_TYPE_VIEW"]);?>
			<?@include_once('page_blocks/'.$sViewElementTemplate.'.php');?>

			<?if (TSolution::checkAjaxRequest()):?>
				<?die()?>
			<?endif;?>
		</div>

		<?ob_start();?>
		<?if (
			$arSection['DESCRIPTION'] &&
			strpos($_SERVER['REQUEST_URI'], 'PAGEN') === false &&
			$arParams['SHOW_SECTION_DESCRIPTION'] != 'N'
		):?>
			<div class="text_after_items">
				<?=$arSection['DESCRIPTION'];?>
			</div>
		<?endif;?>
		<?$html = trim(ob_get_contents());?>
		<?ob_end_clean();?>

		<?if($html || $bShowLeftBlock):?>
			<div class="main-wrapper flexbox flexbox--direction-row">
				<div class="section-content-wrapper <?=($bShowLeftBlock ? 'with-leftblock' : '');?> flex-1 detail-maxwidth">
					<?=$html?>
				</div>

				<?if($bShowLeftBlock):?>
					<?TSolution::ShowPageType('left_block');?>
				<?endif;?>
			</div>
		<?endif;?>
	<?endif;?>
<?endif;?>

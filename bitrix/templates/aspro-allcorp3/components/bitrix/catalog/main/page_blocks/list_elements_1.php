<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();?>
<?if($arSeoItem):?>
	<?ob_start();?>
		<?if($arSeoItem["DETAIL_PICTURE"] || $arSeoItem["PROPERTY_TIZERS_VALUE"]):?>
			<div class="seo_block">
				<?if($arSeoItem["DETAIL_PICTURE"]):?>
					<img data-src="<?=CFile::GetPath($arSeoItem["DETAIL_PICTURE"]);?>" src="<?=CFile::GetPath($arSeoItem["DETAIL_PICTURE"]);?>" alt="" title="" class="img-responsive top-big-img rounded-4 <?=($arSeoItem["PROPERTY_TIZERS_VALUE"] ? 'top-big-img--with-tizers' : '');?>"/>
				<?endif;?>
				<?if($arSeoItem["PROPERTY_TIZERS_VALUE"]):?>
					<?$GLOBALS["arLandingTizers"] = array("ID" => $arSeoItem["PROPERTY_TIZERS_VALUE"]);
					?>
					<div class="detail-block bordered rounded-4 tizers">
						<?$APPLICATION->IncludeComponent(
						"bitrix:news.list",
						"tizers-list",
						array(
							"IBLOCK_TYPE" => "aspro_allcorp3_content",
							"IBLOCK_ID" => $arParams["LANDING_TIZER_IBLOCK_ID"],
							"NEWS_COUNT" => "4",
							"SORT_BY1" => "SORT",
							"SORT_ORDER1" => "ASC",
							"SORT_BY2" => "ID",
							"SORT_ORDER2" => "DESC",
							// "SMALL_BLOCK" => "Y",
							"FILTER_NAME" => "arLandingTizers",
							"FIELD_CODE" => array(
								0 => "PREVIEW_PICTURE",
								1 => "PREVIEW_TEXT",
								2 => "DETAIL_PICTURE",
								3 => "DETAIL_TEXT",
							),
							"PROPERTY_CODE" => array(
								0 => "TIZER_ICON",
								1 => "URL",
							),
							"CHECK_DATES" => "Y",
							"DETAIL_URL" => "",
							"AJAX_MODE" => "N",
							"AJAX_OPTION_JUMP" => "N",
							"AJAX_OPTION_STYLE" => "Y",
							"AJAX_OPTION_HISTORY" => "N",
							"CACHE_TYPE" => $arParams['CACHE_TYPE'],
							"CACHE_TIME" => "36000000",
							"CACHE_FILTER" => "Y",
							"CACHE_GROUPS" => "N",
							"PREVIEW_TRUNCATE_LEN" => "250",
							"ACTIVE_DATE_FORMAT" => "d F Y",
							"SET_TITLE" => "N",
							"SHOW_DETAIL_LINK" => "N",
							"SET_STATUS_404" => "N",
							"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
							"ADD_SECTIONS_CHAIN" => "N",
							"HIDE_LINK_WHEN_NO_DETAIL" => "N",
							"PARENT_SECTION" => "",
							"PARENT_SECTION_CODE" => "",
							"DISPLAY_TOP_PAGER" => "N",
							"DISPLAY_BOTTOM_PAGER" => "Y",
							"PAGER_TITLE" => "",
							"PAGER_SHOW_ALWAYS" => "N",
							"PAGER_TEMPLATE" => "ajax",
							"PAGER_DESC_NUMBERING" => "N",
							"PAGER_DESC_NUMBERING_CACHE_TIME" => "3600",
							"PAGER_SHOW_ALL" => "N",
							"DISPLAY_DATE" => "Y",
							"DISPLAY_NAME" => "Y",
							"DISPLAY_PICTURE" => "N",
							"DISPLAY_PREVIEW_TEXT" => "N",
							"AJAX_OPTION_ADDITIONAL" => "",
							"COMPONENT_TEMPLATE" => "tizers-list",
							"SET_BROWSER_TITLE" => "N",
							"SET_META_KEYWORDS" => "N",
							"SET_META_DESCRIPTION" => "N",
							"SET_LAST_MODIFIED" => "N",
							"INCLUDE_SUBSECTIONS" => "Y",
							"STRICT_SECTION_CHECK" => "N",
							"TYPE_IMG" => "left",
							"CENTERED" => "Y",
							"SIZE_IN_ROW" => "4",
							"PAGER_BASE_LINK_ENABLE" => "N",
							"SHOW_404" => "N",
							'TEXT_CENTERED' => false,
							'FRONT_PAGE' => false,
							'NARROW' => true,
							'TOP_TEXT_SIZE' => '50',
							'ITEMS_OFFSET' => true,
							'IMAGES' => 'ICONS',
							// 'IMAGES' => 'PICTURES',
							'IMAGE_POSITION' =>'LEFT',
							'WRAPPER_OFFSET' => true,
							"MOBILE_SCROLLED" => false,
							'ITEMS_COUNT' => 4,
							"MESSAGE_404" => ""
						),
						false, array("HIDE_ICONS" => "Y")
					);?>
					</div>
				<?endif;?>
			</div>
		<?endif;?>
	<?
	$html = ob_get_clean();
	$APPLICATION->AddViewContent('top_content', $html);
	?>

	<?ob_start();?>
		<?if($arSeoItem["PREVIEW_PICTURE"]):?>
			<div class="seo-block-main line-block line-block--48 line-block--24-1100 line-block--align-normal flexbox--direction-row-reverse">
				<div class="line-block__item visible-lg">
					<div class="sticky-block">
						<div class="seo_block seo_block--img">
							<img data-src="<?=CFile::GetPath($arSeoItem["PREVIEW_PICTURE"]);?>" src="<?=CFile::GetPath($arSeoItem["PREVIEW_PICTURE"]);?>" alt="" title="" class="img-responsive top-big-img rounded-4 <?=($arSeoItem["PROPERTY_TIZERS_VALUE"] ? 'top-big-img--with-tizers' : '');?>"/>
						</div>
					</div>
				</div>
				<div class="line-block__item">
		<?endif;?>
		<?if($arSeoItem["PREVIEW_TEXT"]):?>
			<div class="seo_block seo_block--description color_666">
				<?=$arSeoItem["PREVIEW_TEXT"]?>
			</div>
		<?endif;?>
		<?if($arSeoItem["PROPERTY_FORM_QUESTION_VALUE"]):?>
			<div class="seo_block">
				<div class="rounded-4 bordered grey-bg">
					<div class="order-info-block">
						<div class="line-block line-block--align-normal line-block--40">
							<div class="line-block__item icon-svg-block">
									<?= CAllcorp3::showIconSvg('review stroke-theme', SITE_TEMPLATE_PATH . '/images/svg/order_large.svg'); ?>
							</div>
							<div class="line-block__item flex-1">
								<div class="text font_18 color_333 font_large">
									<?$APPLICATION->IncludeComponent(
										'bitrix:main.include',
										'',
										array(
											'AREA_FILE_SHOW' => 'page',
											'AREA_FILE_SUFFIX' => 'landing',
											'EDIT_TEMPLATE' => ''
										)
									);?>
								</div>
							</div>
							<div class="line-block__item order-info-btns">
								<div class="line-block line-block--align-normal line-block--12">
									<div class="line-block__item">
										<span 
										 class="btn btn-default btn-lg animate-load" 
										 data-event="jqm" 
										 data-param-id="<?=CAllcorp3::getFormID('aspro_allcorp3_question');?>" 
										 data-name="question"
										>
											<span>
												<?=(strlen($arParams['S_ASK_QUESTION']) ? $arParams['S_ASK_QUESTION'] : GetMessage('S_ASK_QUESTION'))?>
											</span>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?endif;?>
		<?if($arSeoItem["PREVIEW_PICTURE"]):?>
				</div>
			</div>
		<?endif;?>
	<?
	$html = ob_get_clean();
	$APPLICATION->AddViewContent('top_desc', $html);
	$APPLICATION->AddViewContent('top_content', $html);
	?>

	<?ob_start();?>
		
	<?
	$html = ob_get_clean();
	$APPLICATION->AddViewContent('top_content', $html);
	?>
<?endif;?>

<?if($iSectionsCount && $arParams['INCLUDE_SUBSECTIONS'] != 'N'):?>
	<?$this->SetViewTarget("top_content");?>
		<?global $arTheme;?>
		<div class="section-block">
			<?
			if (!$arParams["SECTION_TYPE_VIEW"]) {
				$arParams["SECTION_TYPE_VIEW"] = "FROM_MODULE";
			}
			$sViewElementTemplate = ($arParams["SECTION_TYPE_VIEW"] == "FROM_MODULE" ? $arTheme["SECTION_TYPE_VIEW_CATALOG"]["VALUE"] : $arParams["SECTION_TYPE_VIEW"]);
			?>
			<?@include_once($sViewElementTemplate.'.php');?>
		</div>
	<?$this->EndViewTarget();?>
<?endif;?>

<?$section_pos_top = \Bitrix\Main\Config\Option::get("aspro.allcorp3", "TOP_SECTION_DESCRIPTION_POSITION", "UF_TOP_SEO", SITE_ID );?>
<?$section_pos_bottom = \Bitrix\Main\Config\Option::get("aspro.allcorp3", "BOTTOM_SECTION_DESCRIPTION_POSITION", "DESCRIPTION", SITE_ID );?>

<?if(!$arSeoItem):?>
	<?if(
		$arParams["SHOW_SECTION_DESC"] != 'N' &&
		strpos($_SERVER['REQUEST_URI'], 'PAGEN') === false
	):?>
		<?ob_start();?>
		<?if($posSectionDescr !== "BOTTOM"):?>
			<?if ($arSection[$section_pos_top]):?>
				<div class="group_description_block top color_666">
					<div><?=$arSection[$section_pos_top]?></div>
				</div>
			<?endif;?>
		<?endif;?>
		<?
		$html = ob_get_clean();
		$APPLICATION->AddViewContent('top_desc', $html);
		$APPLICATION->AddViewContent('top_content', $html);
		?>
	<?endif;?>
<?endif;?>

<?$this->SetViewTarget("top_content2");?>
	<?@include_once('landing_1.php');?>
<?$this->EndViewTarget();?>

<?if($iSectionsCount && $arParams['INCLUDE_SUBSECTIONS'] == 'N'):?>
	<?global $arTheme;?>
	<div class="section-block">
		<?
		if (!$arParams["SECTION_TYPE_VIEW"]) {
			$arParams["SECTION_TYPE_VIEW"] = "FROM_MODULE";
		}
		$sViewElementTemplate = ($arParams["SECTION_TYPE_VIEW"] == "FROM_MODULE" ? $arTheme["SECTION_TYPE_VIEW_CATALOG"]["VALUE"] : $arParams["SECTION_TYPE_VIEW"]);
		?>
		<?@include_once($sViewElementTemplate.'.php');?>
	</div>
<?endif;?>

<?$isAjax="N";?>
<?if (
	isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && 
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest" && 
	isset($_GET["ajax_get"]) && $_GET["ajax_get"] == "Y" || 
	(isset($_GET["ajax_basket"]) && $_GET["ajax_basket"]=="Y")
	) {
	$isAjax="Y";
}?>
<?if (
	isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && 
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest" && 
	isset($_GET["ajax_get_filter"]) && $_GET["ajax_get_filter"] == "Y"
	) {
	$isAjaxFilter="Y";
}
if (isset($isAjaxFilter) && $isAjaxFilter == "Y") {
	$isAjax="N";
}
?>

<?if ($isAjax == "N"):?>
	<?
	$frame = new \Bitrix\Main\Page\FrameHelper('catalog-elements-block');
	$frame->begin();
	$frame->setAnimation(true);
	?>
<?endif;?>

<?include_once(__DIR__."/../include_sort.php");?>
<?include_once(__DIR__."/../include_filter.php");?>

<?if ($isAjax == "Y"):?>
	<?$APPLICATION->RestartBuffer();?>
<?endif;?>

<?$upperDisplay = $display ? strtoupper($display): 'TABLE';?>
<?if ($isAjax == "N"):?>
	<div class="ajax_load <?=$display;?>-view">
<?endif;?>

<?
if($arParams['FILTER_NAME']) {
	$SMART_FILTER_FILTER = $GLOBALS[$arParams['FILTER_NAME']];
}
if($arResult["VARIABLES"]['SECTION_ID']) {
	$SMART_FILTER_FILTER['SECTION_ID'] = $arResult["VARIABLES"]['SECTION_ID'];
}
else if($arResult["VARIABLES"]['SECTION_CODE']) {
	$SMART_FILTER_FILTER['SECTION_CODE'] = $arResult["VARIABLES"]['SECTION_CODE'];
}

$SMART_FILTER_SORT = array(
	$arAvailableSort[$sort]["SORT"] => strtoupper($order),
	$arParams['ELEMENT_SORT_FIELD2'] => $arParams['ELEMENT_SORT_ORDER2'],
);
?>

<?// section elements?>
<?$sViewElementsTemplate = ($arParams["ELEMENTS_".$upperDisplay."_TYPE_VIEW"] == "FROM_MODULE" ? $arTheme["ELEMENTS_".$upperDisplay."_TYPE_VIEW"]["VALUE"] : $arParams["ELEMENTS_".$upperDisplay."_TYPE_VIEW"]);?>
<?@include_once($sViewElementsTemplate.'.php');?>

<!--noindex-->
<?if($SMART_FILTER_FILTER):?>
	<script class="smart-filter-filter" data-skip-moving="true">
		var filter = <?=\Bitrix\Main\Web\Json::encode($SMART_FILTER_FILTER);?>
	</script>
<?endif;?>

<?if($SMART_FILTER_SORT):?>
	<script class="smart-filter-sort" data-skip-moving="true">
		var sort = <?=\Bitrix\Main\Web\Json::encode($SMART_FILTER_SORT)?>
	</script>
<?endif;?>
<!--/noindex-->

<?if ($isAjax == "N"):?>
	</div>
	<?$frame->end();?>

	<?if (!$arSeoItem):?>
		<?if(
			$arParams["SHOW_SECTION_DESC"] != 'N' &&
			strpos($_SERVER['REQUEST_URI'], 'PAGEN') === false
		):?>
			<?ob_start();?>
			<?if($posSectionDescr !== "TOP"):?>
				<?if($arSection[$section_pos_bottom]):?>
					<div class="group_description_block bottom color_666">
						<div><?=$arSection[$section_pos_bottom]?></div>
					</div>
				<?endif;?>
			<?endif;?>
			<?
			$html = ob_get_clean();
			$APPLICATION->AddViewContent('bottom_desc', $html);
			$APPLICATION->ShowViewContent('bottom_desc');
			$APPLICATION->ShowViewContent('smartseo_bottom_description');
			$APPLICATION->ShowViewContent('smartseo_additional_description');
			$APPLICATION->ShowViewContent('sotbit_seometa_bottom_desc');
			$APPLICATION->ShowViewContent('sotbit_seometa_add_desc');
			?>
		<?endif;?>
	<?else:?>
		<?ob_start();?>
		<?if($arSeoItem["DETAIL_TEXT"]):?>
			<div class="group_description_block bottom color_666">
				<?=$arSeoItem["DETAIL_TEXT"];?>
			</div>
		<?endif;?>
		<?
		$html = ob_get_clean();
		$APPLICATION->AddViewContent('bottom_desc', $html);
		$APPLICATION->ShowViewContent('bottom_desc');
		$APPLICATION->ShowViewContent('smartseo_bottom_description');
		$APPLICATION->ShowViewContent('sotbit_seometa_bottom_desc');
		?>
	<?endif;?>

	<?if($arSeoItem):?>
		<?if (!isset($arSeoItem["IPROPERTY_VALUES"])) {
			$ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues($arSeoItem["IBLOCK_ID"], $arSeoItem["ID"]);
			$arSeoItem["IPROPERTY_VALUES"] = $ipropValues->getValues();
		}
		$langing_seo_h1 = ($arSeoItem["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] != "" 
			? $arSeoItem["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] 
			: $arSeoItem["NAME"]);
		$langing_seo_title = ($arSeoItem["IPROPERTY_VALUES"]["ELEMENT_META_TITLE"] != "" 
			? $arSeoItem["IPROPERTY_VALUES"]["ELEMENT_META_TITLE"] 
			: $langing_seo_h1);

		$APPLICATION->SetTitle($langing_seo_h1);
		$APPLICATION->AddChainItem($langing_seo_h1);

		if ($langing_seo_title) {
			$APPLICATION->SetPageProperty("title", $langing_seo_title);
		}
		
		if ($arSeoItem["IPROPERTY_VALUES"]["ELEMENT_META_DESCRIPTION"]) {
			$APPLICATION->SetPageProperty("description", $arSeoItem["IPROPERTY_VALUES"]["ELEMENT_META_DESCRIPTION"]);
		}
		
		if ($arSeoItem["IPROPERTY_VALUES"]['ELEMENT_META_KEYWORDS']) {
			$APPLICATION->SetPageProperty("keywords", $arSeoItem["IPROPERTY_VALUES"]['ELEMENT_META_KEYWORDS']);
		}
		?>
	<?endif;?>
<?else:?>
	<?die();?>
<?endif;?>
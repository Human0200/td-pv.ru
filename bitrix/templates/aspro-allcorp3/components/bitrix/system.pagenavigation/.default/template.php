<?$this->setFrameMode(true);?>
<?if($arResult["NavPageCount"] > 1):?>
	<?
	if($arResult["NavQueryString"])
	{
		$arUrl = explode('&amp;', $arResult["NavQueryString"]);
		if($arUrl)
		{
			foreach($arUrl as $key => $url)
			{
				if(strpos($url, 'ajax_get') !== false || 
					strpos($url, 'AJAX_REQUEST') !== false ||
					strpos($url, 'ajax') !== false ||
					strpos($url, 'BLOCK') !== false)
					unset($arUrl[$key]);
			}
		}
		$arResult["NavQueryString"] = implode('&amp;', $arUrl);
	}
	$count_item_between_cur_page = 2; // count numbers left and right from cur page
	$count_item_dotted = 2; // count numbers to end or start pages
	
	$arResult["nStartPage"] = $arResult["NavPageNomer"] - $count_item_between_cur_page;
	$arResult["nStartPage"] = $arResult["nStartPage"] <= 0 ? 1 : $arResult["nStartPage"];
	$arResult["nEndPage"] = $arResult["NavPageNomer"] + $count_item_between_cur_page;
	$arResult["nEndPage"] = $arResult["nEndPage"] > $arResult["NavPageCount"] ? $arResult["NavPageCount"] : $arResult["nEndPage"];
	$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
	$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
	if($arResult["NavPageNomer"] == 1){
		$bPrevDisabled = true;
	}
	elseif($arResult["NavPageNomer"] < $arResult["NavPageCount"]){
		$bPrevDisabled = false;
	}
	if($arResult["NavPageNomer"] == $arResult["NavPageCount"]){
		$bNextDisabled = true;
	}
	else{
		$bNextDisabled = false;
	}
	?>
	<?global $APPLICATION;?>
	<?
	$bHasPage = (isset($_GET['PAGEN_'.$arResult["NavNum"]]) && $_GET['PAGEN_'.$arResult["NavNum"]]);
	if($bHasPage)
	{
		if($_GET['PAGEN_'.$arResult["NavNum"]] == 1 && !isset($_GET['q']))
		{
			LocalRedirect($arResult["sUrlPath"], false, "301 Moved permanently");
		}
		elseif($_GET['PAGEN_'.$arResult["NavNum"]] > $arResult["nEndPage"])
		{
			if (!defined("ERROR_404"))
			{
				define("ERROR_404", "Y");
				\CHTTP::setStatus("404 Not Found");
			}
		}

	}?>
	<div class="module-pagination bordered rounded-4">
		<div class="nums">
			<div class="arrows-pagination hide-600">
				<?if(!$bPrevDisabled):?>
					<?$page = ( $bHasPage ? ($arResult["NavPageNomer"]-1 == 1 ? '' : $arResult["NavPageNomer"]-1) : '' );
					$url = ($page ? '?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.$page : $strNavQueryStringFull);?>
					<a href="<?=$arResult["sUrlPath"]?><?=$url?>" class="arrows-pagination__prev arrows-pagination__item animate-arrow-hover stroke-theme-parent-all colored_theme_hover_bg-block" title="<?=GetMessage("nav_prev")?>">
						<span class="arrow-all arrow-all--reverce arrow-all--wide arrow-all--sm stroke-theme-target">
							<?=CAllcorp3::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH.'/images/svg/Arrow_map.svg');?>
							<span class="arrow-all__item-line colored_theme_hover_bg-el"></span>
						</span>
					</a>
					<link rel="prev" href="<?=$arResult["sUrlPath"].$url?>" />
					<link rel="canonical" href="<?=$arResult["sUrlPath"]?>" />
				<?endif;?>
				<?if(!$bNextDisabled):?>
					<?$APPLICATION->AddHeadString('<link rel="next" href="'.$arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]+1).'"  />', true);?>
					<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>" class="arrows-pagination__next arrows-pagination__item animate-arrow-hover stroke-theme-parent-all colored_theme_hover_bg-block" title="<?=GetMessage("nav_next")?>">
						<span class="arrow-all arrow-all--wide arrow-all--sm stroke-theme-target">
							<?=CAllcorp3::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH.'/images/svg/Arrow_map.svg');?>
							<span class="arrow-all__item-line colored_theme_hover_bg-el"></span>
						</span>
					</a>
				<?endif;?>
			</div>
			<?if($arResult["nStartPage"] > 1):?>
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1" class="dark_link module-pagination__item">1</a>
				<?if(($arResult["nStartPage"] - $count_item_dotted) > 1):?>
					<span class='point_sep module-pagination__item'>...</span>
				<?elseif(($firstPage = $arResult["nStartPage"]-1) > 1 && $arResult["nStartPage"] !=2):?>
					<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$firstPage?>" class="dark_link module-pagination__item"><?=$firstPage?></a>
				<?endif;?>
			<?endif;?>
			<?while($arResult["nStartPage"] <= $arResult["nEndPage"]):?>
				<?if($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
					<span class="cur module-pagination__item"><?=$arResult["nStartPage"]?></span>
				<?elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):?>
					<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="dark_link module-pagination__item"><?=$arResult["nStartPage"]?></a>
				<?else:?>
					<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>" class="dark_link  module-pagination__item"><?=$arResult["nStartPage"]?></a>
				<?endif;?>
				<?$arResult["nStartPage"]++;?>
			<?endwhile;?>
			<?if($arResult["nEndPage"] < $arResult["NavPageCount"]):?>
				<?if(($arResult["nEndPage"] + $count_item_dotted) < $arResult["NavPageCount"]):?>
					<span class='point_sep module-pagination__item'>...</span>
				<?elseif(($lastPage = $arResult["nEndPage"]+1) < $arResult["NavPageCount"]):?>
					<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$lastPage?>" class="dark_link  module-pagination__item"><?=$lastPage?></a>
				<?endif;?>
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>" class="dark_link module-pagination__item"><?=$arResult["NavPageCount"]?></a>
			<?endif;?>
			<?if ($arResult["bShowAll"]):?>			
				<div class="all_block_nav">
					<!--noindex-->
						<?if ($arResult["NavShowAll"]):?>
							<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=0" class="dark_link module-pagination__item dark_link module-pagination__item--all" rel="nofollow"><?=GetMessage("nav_paged")?></a>
						<?else:?>
							<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=1" class="dark_link module-pagination__item dark_link module-pagination__item--all" rel="nofollow"><?=GetMessage("nav_all")?></a>
						<?endif?>
					<!--/noindex-->
				</div>			
			<?endif?>
		</div>
	</div>
<?endif;?>
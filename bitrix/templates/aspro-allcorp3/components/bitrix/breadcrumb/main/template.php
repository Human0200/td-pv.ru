<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$strReturn = '';
if($arResult){
	\Bitrix\Main\Loader::includeModule("iblock");
	global $NextSectionID, $APPLICATION;
	$cnt = count($arResult);
	$lastindex = $cnt - 1;
	$visibleMobile = 0;
	if(\Bitrix\Main\Loader::includeModule('aspro.allcorp3'))
	{
		global $arTheme;
		$bShowCatalogSubsections = ($arTheme["SHOW_BREADCRUMBS_SUBSECTIONS"]["VALUE"] == "Y");
		$bMobileBreadcrumbs = ($arTheme["MOBILE_CATALOG_BREADCRUMBS"]["VALUE"] == "Y" && $NextSectionID);
	}
	if ($bMobileBreadcrumbs) {
		$visibleMobile = $lastindex - 1;
	}
	for($index = 0; $index < $cnt; ++$index){
		$arSubSections = array();
		$bShowMobileArrow = false;
		$arItem = $arResult[$index];
		$title = htmlspecialcharsex($arItem["TITLE"]);
		$bLast = $index == $lastindex;
		if ($NextSectionID) {
			if ($bMobileBreadcrumbs && $visibleMobile == $index) {
				$bShowMobileArrow = true;
			}
			if ($bShowCatalogSubsections) {
				$arSubSections = TSolution::getChainNeighbors($NextSectionID, $arItem['LINK']);
			}
		}
		if($index){
			$strReturn .= '<span class="breadcrumbs__separator">&mdash;</span>';
		}

		if($arItem["LINK"] <> "" && $arItem['LINK'] != GetPagePath() && $arItem['LINK']."index.php" != GetPagePath() || $arSubSections){
			$strReturn .= '<div class="breadcrumbs__item  category-separator-sibling category-separator-sibling--inline category-separator-sibling--padding-right'.($bMobileBreadcrumbs ? ' breadcrumbs__item--mobile' : '').($bShowMobileArrow ? ' breadcrumbs__item--visible-mobile' : '').($arSubSections ? ' breadcrumbs__item--with-dropdown colored_theme_hover_bg-block ' : '').($bLast ? ' cat_last' : '').'" id="bx_breadcrumb_'.$index.'" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';

			if($arSubSections){
				if($index == ($cnt-1)):
					$strReturn .= '<link href="'.GetPagePath().'" itemprop="item" /><span>';
				else:
					$strReturn .= '<a class="breadcrumbs__link colored_theme_hover_bg-el-svg fill-theme-hover" href="'.$arItem["LINK"].'" itemprop="item">';
				endif;
				if ($bShowMobileArrow) {
					$strReturn .= CAllCorp3::showIconSvg('colored_theme_hover_bg-el-svg', SITE_TEMPLATE_PATH.'/images/svg/catalog/arrow_breadcrumbs.svg');
				}
				$strReturn .='<span itemprop="name" class="breadcrumbs__item-name font_13">'.$title.'</span>'.CAllCorp3::showSpriteIconSvg(SITE_TEMPLATE_PATH."/images/svg/arrows.svg#down", "arrow fill-use-svg-999 breadcrumbs__arrow-down fill-theme-hover hide-768", ['WIDTH' => 5, 'HEIGHT' => 3]);
				$strReturn .= '<meta itemprop="position" content="'.($index + 1).'">';
				if($index == ($cnt-1)):
					$strReturn .= '</span>';
				else:
					$strReturn .= '</a>';
				endif;

                $strReturn .= '<div class="breadcrumbs__dropdown-wrapper dropdown-menu-wrapper hide-768"><div class="breadcrumbs__dropdown scrollbar dropdown-menu-inner rounded-4">';
                foreach($arSubSections as $arSubSection){
                    if ($arSubSection["LINK"] !== $arItem["LINK"]) {
                        $strReturn .= '<div class="breadcrumbs__dropdown-item"><a class="breadcrumbs__dropdown-link dark_link font_13" href="'.$arSubSection["LINK"].'">'.$arSubSection["NAME"].'</a></div>';
                    }
                }
                $strReturn .= '</div></div>';

			}
			else{
				$strReturn .= '<a class="breadcrumbs__link " href="'.$arItem["LINK"].'" title="'.$title.'" itemprop="item">';
				if ($bShowMobileArrow) {
					$strReturn .= CAllCorp3::showIconSvg('colored_theme_hover_bg-el-svg', SITE_TEMPLATE_PATH.'/images/svg/catalog/arrow_breadcrumbs.svg');
				}
				$strReturn .= '<span itemprop="name" class="breadcrumbs__item-name font_13">'.$title.'</span><meta itemprop="position" content="'.($index + 1).'"></a>';
			}
			$strReturn .= '</div>';
		}
		else{
			$strReturn .= '<span class="breadcrumbs__item'.($bMobileBreadcrumbs ? ' breadcrumbs__item--mobile' : '').'" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><link href="'.GetPagePath().'" itemprop="item" /><span><span itemprop="name" class="breadcrumbs__item-name font_13">'.$title.'</span><meta itemprop="position" content="'.($index + 1).'"></span></span>';
		}
	}

	return '<div class="breadcrumbs swipeignore" itemscope="" itemtype="http://schema.org/BreadcrumbList">'.$strReturn.'</div>';
	//return $strReturn;
}
else{
	return $strReturn;
}
?>

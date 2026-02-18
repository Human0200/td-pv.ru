<?
$contentType = $arTheme['WIDE_MENU_CONTENT']['VALUE'];
$childsType = $arTheme['WIDE_MENU_CONTENT']['DEPENDENT_PARAMS']['CHILDS_VIEW']['VALUE'];
$bClick2show4Depth = $arTheme['CLICK_TO_SHOW_4DEPTH']['VALUE'] === 'Y';
$bShowChilds = $bShowChilds && $contentType == 'CHILDS';

$liClass= '';
$liClass .= $sCountElementsMenu;
if($bShowChilds) {
    $liClass .= ' header-menu__dropdown-item--with-dropdown';
}
if($arSubItem["SELECTED"]) {
    $liClass .= ' active';
}
if($bHasPicture) {
    $liClass .= ' has_img';
}
if($contentType == 'NO_CONTENT') {
    $liClass .= ' header-menu__dropdown-item--centered';
}
$liClass .= ' header-menu__dropdown-item--img-'.$arTheme['IMAGES_WIDE_MENU_POSITION']['VALUE'];
?>
<li class="header-menu__dropdown-item <?=$liClass?>">
    <?if($bHasPicture):
        if($bIcon) {
            $arImg = CFile::ResizeImageGet($arSubItem['PARAMS']['ICON'], array('width' => 90, 'height' => 60), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
        }
        elseif($bTransparentPicture) {
            $arImg = CFile::ResizeImageGet($arSubItem['PARAMS']['TRANSPARENT_PICTURE'], array('width' => 90, 'height' => 60), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
        }
        elseif($bPicture) {
            $arImg = CFile::ResizeImageGet($arSubItem['PARAMS']['PICTURE'], array('width' => 90, 'height' => 60), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
        }
        $imgClass = '';
        $imgClass .= ' header-menu__dropdown-item-img--'.$arTheme['IMAGES_WIDE_MENU_POSITION']['VALUE'];
        if(is_array($arImg)):?>
            <div class="header-menu__dropdown-item-img <?=$imgClass?>">
				<div class="header-menu__dropdown-item-img-inner">
                    <a href="<?=$arSubItem["LINK"]?>">
                        <?if($bIcon):?>
                            <?$arOptions['PATH'] = $arImg['src']?>
                            <?$arItem["PICTURE"]["TITLE"] = $arSubItem['TEXT'];?>
							<?$arItem["PICTURE"]["ALT"] = $arSubItem['TEXT'];?>
							<?=CAllcorp3::showSectionSvg($arOptions, $bIcon, $arItem);?>
                        <?else:?>
                            <img src="<?=$arImg["src"]?>" alt="<?=$arSubItem["TEXT"]?>" title="<?=$arSubItem["TEXT"]?>" />
                        <?endif;?>
                    </a>
				</div>
            </div>
        <?endif;?>
    <?endif;?>

    <div class="header-menu__wide-item-wrapper">
        <a class="<?=$contentType == 'NO_CONTENT' ? 'font_14' : 'font_15'?> dark_link switcher-title" href="<?=$arSubItem["LINK"]?>">
            <span><?=$arSubItem["TEXT"]?></span>
            <?if($bShowChilds):?>
                <?=CAllcorp3::showIconSvg(' header-menu__wide-submenu-right-arrow only_more_items fill-dark-light-block', SITE_TEMPLATE_PATH.'/images/svg/Arrow_right_small.svg');?>
            <?endif;?>
        </a>
        <?if($bShowChilds):?>
            <?$iCountChilds = count($arSubItem["CHILD"]);?>
            <ul class="header-menu__wide-submenu <?=$childsType == 'BY_DELIMITER' ? ' header-menu__wide-submenu--delimiter' : ''?>">
                <?
                $counterWide = 1;
                foreach($arSubItem["CHILD"] as $key => $arSubSubItem):?>
                    <?$bShowChilds = $arSubSubItem["CHILD"] && $arParams["MAX_LEVEL"] > 3 && $childsType != 'BY_DELIMITER';?>
                    <li class="<?=($counterWide > $iVisibleItemsMenu ? 'collapsed' : '');?> header-menu__wide-submenu-item <?=$counterWide == count($arSubItem["CHILD"]) ? 'header-menu__wide-submenu-item--last' : ''?> <?=($bShowChilds ? "header-menu__wide-submenu-item--with-dropdown" : "")?> <?=($arSubSubItem["SELECTED"] ? "active" : "")?>" <?=($counterWide > $iVisibleItemsMenu ? 'style="display: none;"' : '');?>>
                        <span class="header-menu__wide-submenu-item-inner">
                            <a class="font_14 dark_link color_666 fill-theme-hover fill-dark-light-block" href="<?=$arSubSubItem["LINK"]?>">
                                <span class="header-menu__wide-submenu-item-name"><?=$arSubSubItem["TEXT"]?></span><?if ($bShowChilds && $bClick2show4Depth):?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?endif;/*!!!hack for correct move icon to new line!!!*/
                                ?><?if(
                                    $bShowChilds &&
                                    $bClick2show4Depth
                                ):?><?
                                    ?><span class="toggle_block"><?=CAllcorp3::showIconSvg("down header-menu__wide-submenu-right-arrow menu-arrow bg-opacity-theme-target fill-theme-target", SITE_TEMPLATE_PATH.'/images/svg/Triangle_down.svg', '', '', true, false);?></span>
                                <?endif;?>
                                <?if($bShowChilds):?>
                                    <?=CAllcorp3::showIconSvg(' header-menu__wide-submenu-right-arrow only_more_items fill-dark-light-block', SITE_TEMPLATE_PATH.'/images/svg/Arrow_right_small.svg');?>
                                <?endif;?>
                                <?if( $childsType == 'BY_DELIMITER' && $counterWide < (count($arSubItem["CHILD"]) ) ):?>
                                    <span class="header-menu__wide-submenu-item-separator <?=($counterWide == $iVisibleItemsMenu ? 'last-visible' : '');?>" <?=($counterWide == $iVisibleItemsMenu ? 'style="display:none"' : '');?>>&mdash;</span>
                                <?endif;?>
                            </a>
                            <?if($bShowChilds):?>
                                <div class="submenu-wrapper"<?=($bClick2show4Depth ? ' style="display:none"' : '')?>>
                                    <ul class="header-menu__wide-submenu">
                                        <?foreach($arSubSubItem["CHILD"] as $arSubSubSubItem):?>
                                            <li class="header-menu__wide-submenu-item <?=($arSubSubSubItem["SELECTED"] ? "active" : "")?>">
                                                <span class="header-menu__wide-submenu-item-inner">
                                                    <a class="font_13 dark_link color_666" href="<?=$arSubSubSubItem["LINK"]?>"><span class="header-menu__wide-submenu-item-name"><?=$arSubSubSubItem["TEXT"]?></span></a>
                                                </span>
                                            </li>
                                        <?endforeach;?>
                                    </ul>
                                </div>
                            <?endif;?>
                        </span>
                    </li>
                    <?$counterWide++;?>
                <?endforeach;?>
                <?if($iCountChilds > $iVisibleItemsMenu && $bWideMenu):?>
                    <li class="header-menu__wide-submenu-item--more_items">
                        <span class="dark_link fill-theme-hover1 with_dropdown font_13 fill-dark-light-block svg">
                            <?=\Bitrix\Main\Localization\Loc::getMessage("S_MORE_ITEMS");?>
                            <?=CAllcorp3::showIconSvg(" menu-arrow", SITE_TEMPLATE_PATH."/images/svg/Arrow_right_small.svg", "", "", true, false);?>
                        </span>
                        
                    </li>
                <?endif;?>
            </ul>
        <?elseif($contentType == 'DESCRIPTION' && $arSubItem['PARAMS']['UF_TOP_SEO']):?>
           <div class="header-menu__wide-item-description font_13"><?=$arSubItem['PARAMS']['UF_TOP_SEO'];?></div>
        <?endif;?>
    </div>
</li>
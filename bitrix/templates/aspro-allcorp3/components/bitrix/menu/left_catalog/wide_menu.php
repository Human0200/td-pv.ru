<?
$contentType = $arParams['WIDE_MENU_PARAMS']['CONTENT_TYPE'];
$childsType = $arParams['WIDE_MENU_PARAMS']['CHILDS_TYPE'];
$bClick2show4Depth = $arTheme['CLICK_TO_SHOW_4DEPTH']['VALUE'] === 'Y';

$liClass= '';
$liClass .= $sCountElementsMenu;
if($bShowChilds) {
    $liClass .= ' header-menu-side__dropdown-item--with-dropdown';
}
if($arSubItem["SELECTED"]) {
    $liClass .= ' active';
}
if($bHasPicture) {
    $liClass .= ' has_img';
}
if($contentType == 'NO_CONTENT') {
    $liClass .= ' header-menu-side__dropdown-item--centered';
}
$liClass .= ' header-menu-side__dropdown-item--img-'.$arParams['WIDE_MENU_PARAMS']['IMG_POSITION'];

$bFromIblock = $arItem["CHILD"] && $arItem["CHILD"][0]['PARAMS'] && isset($arItem["CHILD"][0]['PARAMS']['FROM_IBLOCK']);
?>
<ul class="left-menu-wrapper <?=$bFromIblock ? '' : 'left-menu-wrapper--simple'?>">
    <?foreach($arItem["CHILD"] as $arSubItem):?>
        <li class="header-menu-side__dropdown-item <?=$liClass?>">
            <?
            $bShowChilds = $arSubItem["CHILD"] && $arParams["MAX_LEVEL"] > 2;
            $bShowChilds = $bShowChilds && $contentType == 'CHILDS';
            $bIcon = isset($arSubItem['PARAMS']['ICON']) && $arSubItem['PARAMS']['ICON'] && $arParams['WIDE_MENU_PARAMS']['IMAGES'] == 'ICONS' ? $arSubItem['PARAMS']['ICON'] : false;
            $bTransparentPicture = isset($arSubItem['PARAMS']['TRANSPARENT_PICTURE']) && $arSubItem['PARAMS']['TRANSPARENT_PICTURE'] && $arParams['WIDE_MENU_PARAMS']['IMAGES'] == 'TRANSPARENT_PICTURES' ? $arSubItem['PARAMS']['TRANSPARENT_PICTURE'] || ($arParams['WIDE_MENU_PARAMS']['IMAGES'] == 'ICONS' && !$bIcon) : false;           
            $bPicture = isset($arSubItem['PARAMS']['PICTURE']) && $arSubItem['PARAMS']['PICTURE'] && ( $arParams['WIDE_MENU_PARAMS']['IMAGES'] == 'PICTURES' || ($arParams['WIDE_MENU_PARAMS']['IMAGES'] == 'TRANSPARENT_PICTURES' && !$bTransparentPicture) || ($arParams['WIDE_MENU_PARAMS']['IMAGES'] == 'ICONS' && !$bIcon && !$bTransparentPicture) ) ? $arSubItem['PARAMS']['PICTURE'] : false;
            $bHasPicture = $bIcon || $bTransparentPicture || $bPicture;
            ?>
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
                $imgClass .= ' header-menu-side__dropdown-item-img--'.$arParams['WIDE_MENU_PARAMS']['IMG_POSITION'];
                if(is_array($arImg)):?>
                    <div class="header-menu-side__dropdown-item-img <?=$imgClass?>">
                        <a href="<?=$arSubItem["LINK"]?>">
                            <?if($bIcon):?>
                                <?=CAllcorp3::showIconSvg(' fill-theme', $arImg['src']);?>
                            <?else:?>
                                <img src="<?=$arImg["src"]?>" alt="<?=$arSubItem["TEXT"]?>" title="<?=$arSubItem["TEXT"]?>" />
                            <?endif;?>
                        </a>
                    </div>
                <?endif;?>
            <?endif;?>

            <div class="header-menu-side__wide-item-wrapper">
                <a class="<?=$contentType == 'NO_CONTENT' ? 'font_14' : 'font_15'?> dark_link switcher-title" href="<?=$arSubItem["LINK"]?>" title="<?=$arSubItem["TEXT"]?>">
                    <?=$arSubItem["TEXT"]?>
                </a>
                <?if($bShowChilds):?>
                    <?$iCountChilds = count($arSubItem["CHILD"]);?>
                    <ul class="header-menu-side__wide-submenu <?=$childsType == 'BY_DELIMITER' ? ' header-menu-side__wide-submenu--delimiter' : ''?>">
                        <?
                        $counterWide = 1;
                        foreach($arSubItem["CHILD"] as $key => $arSubSubItem):?>
                            <?$bShowChilds = $arSubSubItem["CHILD"] && $arParams["MAX_LEVEL"] > 3 && $childsType != 'BY_DELIMITER';?>
                            <li class="<?=($counterWide > $iVisibleItemsMenu ? 'collapsed' : '');?> header-menu-side__wide-submenu-item <?=$counterWide == count($arSubItem["CHILD"]) ? 'header-menu-side__wide-submenu-item--last' : ''?> <?=($bShowChilds ? "header-menu-side__wide-submenu-item--with-dropdown" : "")?> <?=($arSubSubItem["SELECTED"] ? "active" : "")?>" <?=($counterWide > $iVisibleItemsMenu ? 'style="display: none;"' : '');?>>
                                <div class="header-menu-side__wide-submenu-item-inner">
                                    <a class="font_14 dark_link fill-theme-hover" href="<?=$arSubSubItem["LINK"]?>" title="<?=$arSubSubItem["TEXT"]?>">
                                        <span class="header-menu-side__wide-submenu-item-name">
                                            <?=$arSubSubItem["TEXT"]?>
                                        </span>
                                        <?if(
                                            $bShowChilds &&
                                            $bClick2show4Depth
                                        ):?>
                                            <span class="toggle_block"><?=CAllcorp3::showIconSvg("down header-menu-side__wide-submenu-right-arrow menu-arrow bg-opacity-theme-target fill-theme-target fill-dark-light", SITE_TEMPLATE_PATH.'/images/svg/Triangle_down.svg', '', '', true, false);?></span>
                                        <?endif;?>
                                        <?if( $childsType == 'BY_DELIMITER' && $counterWide < (count($arSubItem["CHILD"]) ) ):?>
                                            <span class="header-menu-side__wide-submenu-item-separator <?=($counterWide == $iVisibleItemsMenu ? 'last-visible' : '');?>" <?=($counterWide == $iVisibleItemsMenu ? 'style="display:none"' : '');?>>&mdash;</span>
                                        <?endif;?>
                                    </a>
                                    <?if($bShowChilds):?>
                                        <div class="submenu-wrapper"<?=($bClick2show4Depth ? ' style="display:none"' : '')?>>
                                            <ul class="header-menu-side__wide-submenu">
                                                <?foreach($arSubSubItem["CHILD"] as $arSubSubSubItem):?>
                                                    <li class="header-menu-side__wide-submenu-item <?=($arSubSubSubItem["SELECTED"] ? "active" : "")?>">
                                                        <span class="header-menu-side__wide-submenu-item-inner">
                                                            <a class="font_13 dark_link color_666" href="<?=$arSubSubSubItem["LINK"]?>"><span class="header-menu-side__wide-submenu-item-name"><?=$arSubSubSubItem["TEXT"]?></span></a>
                                                        </span>
                                                    </li>
                                                <?endforeach;?>
                                            </ul>
                                        </div>
                                    <?endif;?>
                                </div>
                            </li>
                            <?$counterWide++;?>
                        <?endforeach;?>
                        <?if($iCountChilds > $iVisibleItemsMenu && $bWideMenu):?>
                            <li class="header-menu-side__wide-submenu-item--more_items">
                                <span class="dark_link with_dropdown font_11 fill-dark-light-block">
                                    <?=\Bitrix\Main\Localization\Loc::getMessage("S_MORE_ITEMS");?>
									<?//=CAllcorp3::showIconSvg("", SITE_TEMPLATE_PATH."/images/svg/Arrow_right_small.svg", "", "", false);?>
                                    <?=CAllcorp3::showIconSvg(" menu-arrow", SITE_TEMPLATE_PATH."/images/svg/Arrow_right_small.svg", "", "", true, false);?>
                                </span>
                            </li>
                        <?endif;?>
                    </ul>
                <?elseif($contentType == 'DESCRIPTION' && $arSubItem['PARAMS']['UF_TOP_SEO']):?>
                <div class="header-menu-side__wide-item-description font_13">
                    <?=$arSubItem['PARAMS']['UF_TOP_SEO'];?>
                    </div>
                <?endif;?>
            </div>
        </li>
    <?endforeach;?>
</ul>
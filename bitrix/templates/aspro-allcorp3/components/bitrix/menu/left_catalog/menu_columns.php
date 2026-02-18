<?if(!function_exists('showSideMenuChilds')) {
    function showSideMenuChilds($arChilds, $level = 1) {
        if($level > 1):?>
            <div class="menu-side-column__dropdown menu-side-column__dropdown--level-<?=$level?>">
        <?endif;?>
            <ul class="left-menu-wrapper">
                <?foreach($arChilds as $arChildItem){?>
                    <li class="menu-side-column__dropdown-item fill-theme-parent <?=($arChildItem["CHILD"] ? "has-childs" : "");?> <?if($arChildItem["SELECTED"]){?> current <?}?>">
                        <?if($arChildItem["IMAGES"] && $arTheme['SHOW_CATALOG_SECTIONS_ICONS']['VALUE'] == 'Y' && $arTheme["MENU_TYPE_VIEW"]["VALUE"] !== 'BOTTOM'){?>
                            <span class="image colored_theme_svg">
                                <a href="<?=$arChildItem["LINK"];?>">
                                    <?if(strpos($arChildItem["IMAGES"]["src"], ".svg") !== false):?>
                                        <?=CAllcorp3::showIconSvg("picture", $arChildItem["IMAGES"]["src"]);?>
                                    <?else:?>
                                        <img class="lazy" src="<?=$arChildItem["IMAGES"]["src"];?>" alt="<?=$arChildItem["TEXT"];?>" />
                                    <?endif;?>	
                                </a>
                            </span>
                        <?}?>
                        <a class="menu-side-column__dropdown-item-link font_15 dark_link" href="<?=$arChildItem["LINK"];?>"><span><?=$arChildItem["TEXT"];?></span></a>
                        <?if($arChildItem["CHILD"]){?>
                            <?=CAllcorp3::showIconSvg(' fill-theme-target menu-side-column__wide-submenu-right-arrow fill-dark-light-block', SITE_TEMPLATE_PATH.'/images/svg/Arrow_right_small.svg');?>
                            <?showSideMenuChilds($arChildItem["CHILD"], $level + 1);?>
                        <?}?>
                    </li>
                <?}?>
            </ul>
        <?if($level > 1):?>
            </div>
        <?endif;?>
    <?
    $level++;    
    }
}?>

<?showSideMenuChilds($arItem["CHILD"]);?>
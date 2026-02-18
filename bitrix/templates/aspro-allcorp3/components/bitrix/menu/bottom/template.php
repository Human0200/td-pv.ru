<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

$this->setFrameMode(true);

if (empty($arResult)) {
    return;
}

$colmd = 12;
$colsm = 12;

$bMenuToRow = $arParams['ROW_ITEMS'] === true;

$isMobileFooterCompact = TSolution::getFrontParametrValue('COMPACT_FOOTER_MOBILE') === 'Y';
$indexSection = $arParams['ROOT_MENU_TYPE'];

if (!function_exists('ShowSubItems2')) {
    function ShowSubItems2($arItem, $indexSection) {
        if ($arItem['CHILD']) {
            $count = count($arItem['CHILD']);
            $lastIndex = count($arItem['CHILD']) - 1;

            foreach ($arItem['CHILD'] as $i => $arSubItem) {
                $bLink = strlen($arSubItem['LINK']);
                ?>
                <?if (!$i):?>
                    <div id="<?=$indexSection;?>" class="wrap wrap_compact_mobile accordion-grid-item">
                        <div class="wrap_inner accordion-grid-item__wrapper">
                            <div class="mt mt--20 mt--conditional">
                <?endif;?>

                <div class="item-link item-link <?=$i == 0 ? 'item-link--first' : '';?> <?=$i == $lastIndex ? 'item-link--last' : '';?>">
                    <div class="item<?=$arSubItem['SELECTED'] ? ' active' : '';?>">
                        <div class="title <?=$arParams['BOLD_ITEMS'] ? 'font_15' : 'font_13';?>">
                            <?if ($bLink):?>
                                <a href="<?=$arSubItem['LINK'];?>"><?=$arSubItem['TEXT'];?></a>
                            <?else:?>
                                <span><?=$arSubItem['TEXT'];?></span>
                            <?endif;?>
                        </div>
                    </div>
                </div>

                <?if ($i && $i === $lastIndex || $count == 1):?>
                            </div>
                        </div>
                    </div>
                <?endif;?>
                <?php
            }
        }
    }
}

$bottomMenuClassList = ['bottom-menu'];
if ($arParams['BOLD_ITEMS']) {
    $bottomMenuClassList[] = 'bottom-menu--bold';
} else {
    $bottomMenuClassList[] = 'bottom-menu--normal';

    if ($isMobileFooterCompact) {
        $bottomMenuClassList[] = 'accordion-grid accordion-grid--to-768';
    }
}

$bottomMenuClass = TSolution\Utils::implodeClasses($bottomMenuClassList);
?>
<div class="<?=$bottomMenuClass;?>">
    <div class="items">
        <?if ($bMenuToRow):?>
            <div class="line-block line-block--48 line-block--align-normal line-block--flex-wrap line-block--block">
        <?endif;?>

        <?$lastIndex = count($arResult) - 1;?>
        <?foreach ($arResult as $i => $arItem):?>
            <?if ($i === 1 && !$bMenuToRow):?>
                <div id="<?=$indexSection;?>" class="wrap<?=$arParams['BOLD_ITEMS'] ? '' : ' wrap_compact_mobile accordion-grid-item';?> ">
                    <div class="wrap_inner accordion-grid-item__wrapper">
                        <div class="mt mt--20 mt--conditional">
            <?endif;?>

            <?php
            $bLink = strlen($arItem['LINK']);
            $itemLinkClassList = ['item-link'];
            if (!$arParams['BOLD_ITEMS'] && $isMobileFooterCompact) {
                $itemLinkClassList[] = 'accordion-grid-button';
            }
            if ($bMenuToRow) {
                $itemLinkClassList[] = 'line-block__item';
            }

            $itemClass = TSolution\Utils::implodeClasses($itemLinkClassList);
            ?>
            <div class="<?=$itemClass;?>">
                <div class="item<?=$arItem['SELECTED'] ? ' active' : '';?> <?=$arParams['BOLD_ITEMS'] ? 'font_bold' : '';?>">
                    <div class="title font_15 font_bold">
                        <?if ($bLink):?>
                            <a class="dark_link" href="<?=$arItem['LINK'];?>"<?=$arItem['ATTRIBUTE'];?>><?=$arItem['TEXT'];?></a>
                        <?else:?>
                            <span><?=$arItem['TEXT'];?></span>
                        <?endif;?>
                    </div>
                </div>

                <?if ($isMobileFooterCompact && ($arItem['CHILD'] || $i < 1) && !$arParams['BOLD_ITEMS']):?>
                    <button type="button" class="btn--no-btn-appearance fa fa-angle-down">
                        <?=TSolution::showIconSvg('', SITE_TEMPLATE_PATH.'/images/svg/more_arrow.svg', '', '', false);?>
                    </button>
                <?endif;?>
            </div>

            <?if ($i && $i === $lastIndex && !$bMenuToRow):?>
                        </div>
                    </div>
                </div>
            <?endif;?>
            <?ShowSubItems2($arItem, $indexSection);?>
        <?endforeach;?>

        <?if ($bMenuToRow):?>
            </div>
        <?endif;?>
    </div>
</div>

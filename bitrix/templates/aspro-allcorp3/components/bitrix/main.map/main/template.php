<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!is_array($arResult["arMap"]) || count($arResult["arMap"]) < 1)
	return;

$arRootNode = Array();
foreach($arResult["arMap"] as $index => $arItem){
	if ($arItem["LEVEL"] == 0)
		$arRootNode[] = $index;
}

$allNum = count($arRootNode);
$colNum = ceil($allNum / $arParams["COL_NUM"]);

switch($arParams["COL_NUM"]){
	case 1:
		$colClacc = 'col-md-12 col-sm-4 col-xs-6 mobile-column';
		break;
	case 2:
		$colClacc = 'col-md-6 col-sm-4 col-xs-6 mobile-column';
		break;
	case 3:
		$colClacc = 'col-md-4 col-sm-4 col-xs-6 mobile-column';
		break;
	case 4:
		$colClacc = 'col-md-3 col-sm-4 col-xs-6 mobile-column';
		break;
	case 5:
		$colClacc = 'col-md-2 col-sm-4 col-xs-6 mobile-column';
		break;
}

if($arParams["COL_NUM"] > 5) {
	$colClacc = 'col-md-2 col-sm-4 col-xs-6 mobile-column';
}
?>
<table class="map-columns main">
    <tr class="row wrap-map">
        <td class="<?=$colClacc?>">
            <ul class="map-level-0">
                <?
                $previousLevel = -1;
                $counter = 0;
                $column = 1;
                ?>
                <?foreach($arResult["arMap"] as $index => $arItem):?>
                    <?
                    $arItem["FULL_PATH"] = htmlspecialcharsbx($arItem["FULL_PATH"], ENT_COMPAT, false);
                    $arItem["NAME"] = htmlspecialcharsbx($arItem["NAME"], ENT_COMPAT, false);
                    $arItem["DESCRIPTION"] = htmlspecialcharsbx($arItem["DESCRIPTION"], ENT_COMPAT, false);
                    ?>
                    <?if ($arItem["LEVEL"] < $previousLevel):?>
                        <?=str_repeat("</ul></li>", ($previousLevel - $arItem["LEVEL"]));?>
                    <?endif;?>

                    <?if ($counter >= $colNum && $arItem["LEVEL"] === 0):?>
                        <?
                        $allNum = $allNum - $counter;
                        $colNum = ceil(($allNum) / ($arParams["COL_NUM"] > 1 ? ($arParams["COL_NUM"] - $column) : 1));
                        $counter = 0;
                        $column++;
                        ?>
                        </ul></td><td class="<?=$colClacc?>"><ul class="map-level-0">
                    <?endif;?>

                    <?if (array_key_exists($index + 1, $arResult["arMap"]) && $arItem["LEVEL"] < $arResult["arMap"][$index + 1]["LEVEL"]):?>
                        <li class="item item-level-<?=$arItem["LEVEL"]?>">
                            <div class="map-columns__link-wrapper">
                                <a class="dark_link <?=($arItem["LEVEL"] == 0 ? "title-block font_18" : "")?>" href="<?=$arItem["FULL_PATH"]?>"><?=$arItem["NAME"]?></a>
                                <?if ($arItem["LEVEL"]):?>
                                    <?=CAllcorp3::showIconSvg(' map-columns__dropdown-right-arrow bg-theme-hover fill-dark-light-block', SITE_TEMPLATE_PATH.'/images/svg/Arrow_right_small.svg');?>
                                <?endif;?>
                            </div>
                            <?if ($arParams["SHOW_DESCRIPTION"] === "Y" && strlen($arItem["DESCRIPTION"])):?>
                                <div class="map-columns__description-wrapper"><?=$arItem["DESCRIPTION"]?></div>
                            <?endif;?>
                            <ul class="map-columns__dropdown map-level-<?=($arItem["LEVEL"] + 1)?> <?=($arItem["LEVEL"] ? " hidden-block" : "")?>">
                    <?else:?>
                        <li class="item item-level-<?=$arItem["LEVEL"]?>">
                            <div class="map-columns__link-wrapper">
                                <a class="dark_link <?=($arItem["LEVEL"] == 0 ? "title-block font_18" : "")?>" href="<?=$arItem["FULL_PATH"]?>"><?=$arItem["NAME"]?></a>
                            </div>
                            <?if ($arParams["SHOW_DESCRIPTION"] == "Y" && $arItem["DESCRIPTION"] <> ''):?>
                                <div class="map-columns__description-wrapper"><?=$arItem["DESCRIPTION"]?></div>
                            <?endif;?>
                        </li>
                    <?endif;?>
                    <?
                    $previousLevel = $arItem["LEVEL"];
                    if($arItem["LEVEL"] == 0)
                        $counter++;
                    ?>
                <?endforeach;?>

                <?if ($previousLevel > 1)://close last item tags?>
                    <?=str_repeat("</ul></li>", ($previousLevel-1));?>
                <?endif;?>
            </ul>
        </td>
    </tr>
</table>
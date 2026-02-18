<?
use \Bitrix\Main\Localization\Loc;

$bTab = isset($tabCode) && $tabCode === 'brand';
?>
<?//show brand block?>
<?if($bTab && !empty($arResult['BRAND_ITEM']) && !empty($arResult['BRAND_ITEM']['DETAIL_TEXT'])){?>

    <div class="detail-block ordered-block brand">
        <div class="ordered-block__title switcher-title font_22"><?=$arParams["T_BRAND"]?></div>
        <?=$arResult['BRAND_ITEM']['DETAIL_TEXT']?>
    </div>
<?}?>
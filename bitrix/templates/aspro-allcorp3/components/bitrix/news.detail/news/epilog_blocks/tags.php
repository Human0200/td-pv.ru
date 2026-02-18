<?
use \Bitrix\Main\Localization\Loc;
?>
<?//show tags block?>
<?if($arParams["DETAIL_USE_TAGS"] == "Y" && $templateData["TAGS"]):?>

    <div class="detail-block ordered-block comments">
        <?$arTags = explode(",", $templateData['TAGS']);?>
        <div class="search-tags-cloud">
            <div class="tags">
                <?foreach($arTags as $text):?>
                    <a href="<?=SITE_DIR;?>search/index.php?tags=<?=htmlspecialcharsex($text);?>" class="rounded-4 font_13 bordered" rel="nofollow"><?=$text;?></a>
                <?endforeach;?>
            </div>
        </div>
    </div>
<?endif;?>
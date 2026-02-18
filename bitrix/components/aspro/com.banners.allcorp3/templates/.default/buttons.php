<?
$bShowButton1 = strlen($arItem['PROPERTIES']['BUTTON1TEXT']['VALUE']) && (strlen($arItem['PROPERTIES']['BUTTON1LINK']['VALUE']) || strlen($arItem['PROPERTIES']['FORM_CODE1']['VALUE']));
$bShowButton2 = strlen($arItem['PROPERTIES']['BUTTON2TEXT']['VALUE']) && (strlen($arItem['PROPERTIES']['BUTTON2LINK']['VALUE']) || strlen($arItem['PROPERTIES']['FORM_CODE2']['VALUE']));

$bSubscribe = $arItem['PROPERTIES']['SUBSCRIBE']['VALUE'] == 'Y' && $sliderItems < 2;

if(!isset($templateData['IS_SUBSCRIBE']) && $bSubscribe){
    $templateData['IS_SUBSCRIBE'] = true;
}
$bShowButtons = !$bSubscribe && ($bShowButton1 || $bShowButton2);
$bShowButtonsWrapper = $bShowButtons || $bSubscribe || $bShowVideo;

$button1Class = $arItem['PROPERTIES']['BUTTON1CLASS']['VALUE_XML_ID'] ? $arItem['PROPERTIES']['BUTTON1CLASS']['VALUE_XML_ID'] : 'btn-default';
$button1Color = $arItem['PROPERTIES']['BUTTON1COLOR']['VALUE_XML_ID'] ? $arItem['PROPERTIES']['BUTTON1COLOR']['VALUE_XML_ID'] : '';
$button1Link = $arItem['PROPERTIES']['BUTTON1LINK']['VALUE'];
$button1Form = $arItem['PROPERTIES']['FORM_CODE1']['VALUE'] ? 'data-event="jqm" data-param-id="'.TSolution::getFormID($arItem['PROPERTIES']['FORM_CODE1']['VALUE']).'" data-name="order_from_banner"' : '';
$button1Text = $arItem['PROPERTIES']['BUTTON1TEXT']['VALUE'];
$button1Attr = $arItem['PROPERTIES']['BUTTON1ATTR']['VALUE'] ? $arItem['PROPERTIES']['BUTTON1ATTR']['VALUE'] : '';

$button2Class = $arItem['PROPERTIES']['BUTTON2CLASS']['VALUE_XML_ID'] ? $arItem['PROPERTIES']['BUTTON2CLASS']['VALUE_XML_ID'] : 'btn-default';
$button2Color = $arItem['PROPERTIES']['BUTTON2COLOR']['VALUE_XML_ID'] ? $arItem['PROPERTIES']['BUTTON2COLOR']['VALUE_XML_ID'] : '';
$button2Link = $arItem['PROPERTIES']['BUTTON2LINK']['VALUE'];
$button2Form = $arItem['PROPERTIES']['FORM_CODE2']['VALUE'] ? 'data-event="jqm" data-param-id="'.TSolution::getFormID($arItem['PROPERTIES']['FORM_CODE2']['VALUE']).'" data-name="order_from_banner"' : '';
$button2Text = $arItem['PROPERTIES']['BUTTON2TEXT']['VALUE'];
$button2Attr = $arItem['PROPERTIES']['BUTTON2ATTR']['VALUE'] ? $arItem['PROPERTIES']['BUTTON2ATTR']['VALUE'] : '';
?>

<?if($bShowButtonsWrapper):?>
    <div class="banners-big__buttons <?=$sliderItems > 1 ? 'banners-big__buttons--small' : ''?>">
        <?if($bSubscribe):?>
            <div class="banners-big__buttons-item">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:subscribe.edit", 
                    "banner", 
                    array(
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_SHADOW" => "Y",
                        "AJAX_OPTION_STYLE" => "Y",
                        "ALLOW_ANONYMOUS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "COMPOSITE_FRAME_MODE" => "A",
                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                        "PAGE" => "cabinet/subscribe/",
                        "SET_TITLE" => "N",
                        "SHOW_AUTH_LINKS" => "N",
                        "SHOW_HIDDEN" => "N",
                        "COMPONENT_TEMPLATE" => "footer"
                    ),
                    false,
                    array("HIDE_ICONS" => "Y")
                );?>
            </div>
        <?endif;?>

        <?if($bShowButtons):?>
            <?if($bShowButton1):?>
                <div class="banners-big__buttons-item">
                    <a href="<?=$button1Link?>"<?=$button1Attr?><?=$button1Form ? " ".$button1Form :""?> class="btn <?=$button1Class?> <?=$button1Color?>">
                        <?=$button1Text?>
                    </a>
                </div>
            <?endif;?>
            <?if($bShowButton2):?>
                <div class="banners-big__buttons-item">
                    <a href="<?=$button2Link?>"<?=$button2Attr?><?=$button2Form ? " ".$button2Form :""?> class="btn <?=$button2Class?> <?=$button2Color?>">
                        <?=$button2Text?>
                    </a>
                </div>
            <?endif;?>
        <?endif;?>

        <?if($bShowVideo):?>
            <div class="banners-big__buttons-item banners-big__buttons-item--video">
                <?if (!$bShowButtons && !$bSubscribe):?>
                    <span class="btn play btn-video<?=($bVideoAutoStart ? ' loading' : '');?> small <?=$buttonVideoClass;?> <?=$buttonVideoColor;?>" title="<?=$buttonVideoText?>">
                        <?=TSolution::showSpriteIconSvg(SITE_TEMPLATE_PATH.'/images/svg/video_buttons_sprite.svg#video-play-13-13', 'play play--no-buttons', [
                            'WIDTH' => 13, 
                            'HEIGHT' => 13
                        ]);?>
                    </span>
                <?else:?>
                    <span class="btn<?=($bVideoAutoStart ? ' loading' : '');?> btn-video<?=($buttonVideoText ? ' with-text' : '');?> <?=$buttonVideoClass;?> <?=$buttonVideoColor;?>" title="<?=$buttonVideoText?>">
                        <?=TSolution::showSpriteIconSvg(SITE_TEMPLATE_PATH.'/images/svg/video_buttons_sprite.svg#video-play-13-13', 'play', [
                            'WIDTH' => 13, 
                            'HEIGHT' => 13
                        ]);?>
                        <?=$buttonVideoText?>
                    </span>
                <?endif;?>
            </div>
        <?endif;?>
    </div>
<?endif;?>
<?if($arItem['PROPERTIES']['LINK_TIZERS']['VALUE'] && $arParams["TIZERS_IBLOCK_ID"]):?>
    <?if($arItem['TIZERS']):?>
        <div class="banners-big__tizers <?=$arItem['PROPERTIES']['TIZERS_ICONS']['VALUE_XML_ID'] == 'Y' ? 'banners-big__tizers--icons' : ''?>">
            <div class="banners-tizers">
                <div class="row flexbox">
                    <?foreach($arItem['PROPERTIES']['LINK_TIZERS']['VALUE'] as $arTizerID){
                        $arTizer = $arItem['TIZERS'][$arTizerID]?>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="banners-tizers__item">
                                <?if($arTizer["PROPERTY_LINK_VALUE"]):?>
                                    <a class="banners-tizers__name dark-color" href="<?=$arTizer["PROPERTY_LINK_VALUE"]?>">
                                <?endif;?>

                                    <?if($arItem['PROPERTIES']['TIZERS_ICONS']['VALUE_XML_ID'] == 'Y' && $arTizer['PROPERTY_TIZER_ICON_VALUE']):?>
                                        <div class="banners-tizers__top-icon">
                                            <?
                                            $fileInfo = CFile::GetFileArray($arTizer['PROPERTY_TIZER_ICON_VALUE']);
                                            $bSvg = strpos($fileInfo['FILE_NAME'], '.svg');
                                            if($bSvg) {
                                                echo( TSolution::showIconSvg(" banners-tizers__icon", $fileInfo['SRC']) );
                                            } else {?>
                                                <div class="banners-tizers__image" style="background: url(<?=$fileInfo['SRC']?>) no-repeat center;"></div>
                                            <?}?>
                                        </div>
                                    <?else:?>
                                        <div class="banners-tizers__top-text switcher-title"><?=$arTizer['PREVIEW_TEXT'];?></div>
                                    <?endif;?>
                                    
                                    <?if($arTizer["DETAIL_TEXT"]):?>
                                        <div class="banners-tizers__desc-text <?=!$arParams['LOW_BANNER'] && !$arParams['NARROW_BANNER'] ? 'banners-tizers__desc-text--large font_14' : 'font_13'?>"><?=$arTizer["DETAIL_TEXT"];?></div>
                                    <?endif;?>
                                <?if($arTizer["PROPERTY_LINK_VALUE"]):?>
                                    </a>
                                <?endif;?>
                            </div>
                        </div>
                    <?}?>
                </div>
            </div>
        </div>
    <?endif;?>
<?endif;?>
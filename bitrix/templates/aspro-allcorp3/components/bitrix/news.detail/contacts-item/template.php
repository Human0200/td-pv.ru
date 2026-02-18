<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

$bUseMap = $arParams['USE_MAP'] === 'Y' && $arResult['DISPLAY_PROPERTIES']['MAP']['VALUE'];
$typeMap = $arParams['TYPE_MAP'];
$bUseFeedback = $arParams['USE_FEEDBACK'] === 'Y';

$arResult['DISPLAY_PROPERTIES']['PHONE']['VALUE'] = (is_array($arResult['DISPLAY_PROPERTIES']['PHONE']['VALUE']) ? $arResult['DISPLAY_PROPERTIES']['PHONE']['VALUE'] : ($arResult['DISPLAY_PROPERTIES']['PHONE']['VALUE'] ? array($arResult['DISPLAY_PROPERTIES']['PHONE']['VALUE']) : array()));
$arResult['DISPLAY_PROPERTIES']['PHONE']['DESCRIPTION'] = (is_array($arResult['DISPLAY_PROPERTIES']['PHONE']['DESCRIPTION']) ? $arResult['DISPLAY_PROPERTIES']['PHONE']['DESCRIPTION'] : ($arResult['DISPLAY_PROPERTIES']['PHONE']['DESCRIPTION'] ? array($arResult['DISPLAY_PROPERTIES']['PHONE']['DESCRIPTION']) : array()));

$arResult['DISPLAY_PROPERTIES']['EMAIL']['VALUE'] = (is_array($arResult['DISPLAY_PROPERTIES']['EMAIL']['VALUE']) ? $arResult['DISPLAY_PROPERTIES']['EMAIL']['VALUE'] : ($arResult['DISPLAY_PROPERTIES']['EMAIL']['VALUE'] ? array($arResult['DISPLAY_PROPERTIES']['EMAIL']['VALUE']) : array()));

$arResult['DISPLAY_PROPERTIES']['METRO']['VALUE'] = (is_array($arResult['DISPLAY_PROPERTIES']['METRO']['VALUE']) ? $arResult['DISPLAY_PROPERTIES']['METRO']['VALUE'] : ($arResult['DISPLAY_PROPERTIES']['METRO']['VALUE'] ? array($arResult['DISPLAY_PROPERTIES']['METRO']['VALUE']) : array()));

$address = $arResult['NAME'].($arResult['PROPERTIES']['ADDRESS']['VALUE'] ? ', '.$arResult['PROPERTIES']['ADDRESS']['VALUE'] : '');

$arPhotos = array();
$imageID = ($arResult['FIELDS']['DETAIL_PICTURE']['ID'] ? $arResult['FIELDS']['DETAIL_PICTURE']['ID'] : false);

$templateData = array_filter([
    'STAFF' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_STAFF'), array('LINK_CONTACT'), $arParams),
]);

if($imageID){
    $arImage = CFile::ResizeImageGet($imageID, array('width' => 600, 'height' => 600), BX_RESIZE_IMAGE_PROPORTIONAL);
    $arPhotos[] = array(
        'ID' => $arResult['FIELDS']['DETAIL_PICTURE']['ID'],
        'ORIGINAL' => ($arResult['FIELDS']['DETAIL_PICTURE']['SRC'] ? $arResult['FIELDS']['DETAIL_PICTURE']['SRC'] : $arImage),
        'PREVIEW' => $arImage,
        'DESCRIPTION' => (strlen($arResult['FIELDS']['DETAIL_PICTURE']['DESCRIPTION']) ? $arResult['FIELDS']['DETAIL_PICTURE']['DESCRIPTION'] : $address),
    );
}
if(is_array($arResult['DISPLAY_PROPERTIES']['MORE_PHOTOS']['VALUE'])) {
    foreach($arResult['DISPLAY_PROPERTIES']['MORE_PHOTOS']['VALUE'] as $i => $photoID){
        $arPhotos[] = array(
            'ID' => $photoID,
            'ORIGINAL' => CFile::GetPath($photoID),
            'PREVIEW' => CFile::ResizeImageGet($photoID, array('width' => 600, 'height' => 600), BX_RESIZE_IMAGE_PROPORTIONAL),
            'DESCRIPTION' => $arResult['DISPLAY_PROPERTIES']['MORE_PHOTOS']['DESCRIPTION'][$i],
        );
    }
}
?>
<?if($bUseMap):?>
    <?
    $mapLAT = $mapLON = $iCountShops = 0;
    $arPlacemarks = array();

    if($arResult['DISPLAY_PROPERTIES']['MAP']['VALUE']){
        $arCoords = explode(',', $arResult['DISPLAY_PROPERTIES']['MAP']['VALUE']);
        $mapLAT = floatval($arCoords[0]);
        $mapLON = floatval($arCoords[1]);

        $phones = '';
        $arResult['DISPLAY_PROPERTIES']['PHONE']['VALUE'] = (is_array($arResult['DISPLAY_PROPERTIES']['PHONE']['VALUE']) ? $arResult['DISPLAY_PROPERTIES']['PHONE']['VALUE'] : ($arResult['DISPLAY_PROPERTIES']['PHONE']['VALUE'] ? array($arResult['DISPLAY_PROPERTIES']['PHONE']['VALUE']) : array()));
        foreach ($arResult['DISPLAY_PROPERTIES']['PHONE']['VALUE'] as $phone) {
            $phones .= '<div class="value"><a class="dark_link" rel= "nofollow" href="tel:'.str_replace(array(' ', ',', '-', '(', ')'), '', $phone).'">'.$phone.'</a></div>';
        }

        $emails = '';
        $arResult['DISPLAY_PROPERTIES']['EMAIL']['VALUE'] = (is_array($arResult['DISPLAY_PROPERTIES']['EMAIL']['VALUE']) ? $arResult['DISPLAY_PROPERTIES']['EMAIL']['VALUE'] : ($arResult['DISPLAY_PROPERTIES']['EMAIL']['VALUE'] ? array($arResult['DISPLAY_PROPERTIES']['EMAIL']['VALUE']) : array()));
        foreach ($arResult['DISPLAY_PROPERTIES']['EMAIL']['VALUE'] as $email) {
            $emails .= '<a class="dark_link" href="mailto:' .$email. '">' .$email . '</a><br>';
        }

        $metrolist = '';
        $arResult['DISPLAY_PROPERTIES']['METRO']['VALUE'] = (is_array($arResult['DISPLAY_PROPERTIES']['METRO']['VALUE']) ? $arResult['DISPLAY_PROPERTIES']['METRO']['VALUE'] : ($arResult['DISPLAY_PROPERTIES']['METRO']['VALUE'] ? array($arResult['DISPLAY_PROPERTIES']['METRO']['VALUE']) : array()));
        foreach ($arResult['DISPLAY_PROPERTIES']['METRO']['VALUE'] as $metro) {
            $metrolist .= '<div class="metro"><i></i>'. $metro . '</div>';
        }

        $popupOptions = [
            'ITEM' => [
                'NAME' => $address,
                'EMAIL' => $arResult['DISPLAY_PROPERTIES']['EMAIL']['VALUE'],
                'EMAIL_HTML' => $emails,
                'PHONE' => $arResult['DISPLAY_PROPERTIES']['PHONE']['VALUE'],
                'PHONE_HTML' => $phones,
                'METRO' => $arResult['DISPLAY_PROPERTIES']['METRO']['VALUE'],
                'METRO_HTML' => $metrolist,
                'SCHEDULE' => $arResult['DISPLAY_PROPERTIES']['SCHEDULE']['DISPLAY_VALUE'],
                'DISPLAY_PROPERTIES' => [
                    'METRO' => [
                        'NAME' => Loc::getMessage('MYMS_TPL_METRO'),
                    ],
                    'SCHEDULE' => [
                        'NAME' => Loc::getMessage('MYMS_TPL_SCHEDULE'),
                    ],
                    'PHONE' => [
                        'NAME' =>  Loc::getMessage('MYMS_TPL_PHONE'),
                    ],
                    'EMAIL' => [
                        'NAME' => Loc::getMessage('MYMS_TPL_EMAIL'),
                    ]
                ]
            ],
            'PARAMS' => [
                'TITLE' => '',
                'BTN_CLASS' => '',
            ],
            'SHOW_QUESTION_BTN' => 'Y',
            'SHOW_SOCIAL' => 'N',
            'SHOW_CLOSE' => 'N',
            'SHOW_TITLE' => 'N',
        ];

        $arPlacemarks[] = array(
            "LAT" => $arCoords[0],
            "LON" => $arCoords[1],
            "TEXT" => TSolution\Functions::getItemMapHtml($popupOptions),
            "TITLE" => $address,
        );
    }
    ?>
<?endif;?>
<?
$templateData['MAP']["PLACEMARKS"] = $arPlacemarks;
$templateData['MAP']["mapLAT"] = $mapLAT;
$templateData['MAP']["mapLON"] = $mapLON;
?>

<div class="contacts-detail shop-detail" itemscope itemtype="http://schema.org/Organization">
	<?//hidden text for validate microdata?>
	<div class="hidden">
		<span itemprop="name"><?=$address?></span>
	</div>

	<div class="contacts__row">
		<div class="contacts__col">
			<div class="contacts__content-wrapper">
                <?/*<div class="contacts-detail__property contacts-detail__property--top">
                    <div class="contact-property contact-property--address">
                        <div class="contact-property__label font_13 color_999"><?=Loc::getMessage('T_CONTACTS_ADDRESS')?></div>
                        <div itemprop="address" class="contact-property__value color_333 font_28"><?=$address?></div>
                    </div>
                </div>
                */?>

                <?//gallery?>
                <?if($arPhotos):?>
                    <?$templateData['PHOTO'] = true;?>
                    <!-- noindex-->
                        <div class="contacts-detail__image contacts-detail__image--gallery rounded-4 swipeignore">
                            <div class="text-center gallery-big">
                                <div class="owl-carousel owl-carousel--outer-dots owl-carousel--nav-hover-visible owl-bg-nav owl-carousel--light owl-carousel--button-wide owl-carousel--button-offset-half" data-slider="content-detail-gallery__slider" data-plugin-options='{"items": "1", "autoplay" : false, "autoplayTimeout" : "3000", "smartSpeed":1000, "dots": true, "dotsContainer": false, "nav": true, "loop": false, "index": true, "margin": 10}'>
                                <?foreach($arPhotos as $i => $arPhoto):?>
                                    <div class="item">
                                        <a href="<?=$arPhoto['ORIGINAL']?>" class="fancy" data-fancybox="item_slider" target="_blank" title="<?=$arPhoto['DESCRIPTION']?>">
                                            <div style="background-image:url('<?=$arPhoto['PREVIEW']['src']?>')"></div>
                                        </a>
                                    </div>
                                <?endforeach;?>
                                </div>
                            </div>
                        </div>
                    <!-- /noindex-->
                <?endif;?>

				<div class="contacts-detail__info">
					<div class="contacts-detail__properties">
                        <?if(
                            $arResult['DISPLAY_PROPERTIES']['METRO']['VALUE'] ||
                            $arResult['DISPLAY_PROPERTIES']['SCHEDULE']['VALUE'] ||
                            $address
                        ):?>
                            <div class="contacts__col">
                                <?if($address):?>
                                    <div class="contacts-detail__property">
                                        <div class="contact-property contact-property--address">
                                            <div class="contact-property__label font_13 color_999"><?=Loc::getMessage('T_CONTACTS_ADDRESS')?></div>
                                            <div  itemprop="address" class="contact-property__value color_333"><?=$address?></div>
                                        </div>
                                    </div>
                                <?endif;?>

                                <?if($arResult['DISPLAY_PROPERTIES']['METRO']['VALUE']):?>
                                    <div class="contacts-detail__property">
                                        <div class="contact-property contact-property--metro">
                                            <div class="contact-property__label font_13 color_999"><?=Loc::getMessage('T_CONTACTS_METRO')?></div>
                                            <?foreach($arResult['DISPLAY_PROPERTIES']['METRO']['VALUE'] as $i => $metro):?>
                                                <div class="contact-property__value color_333"><?=$metro?></div>
                                            <?endforeach;?>
                                        </div>
                                    </div>
                                <?endif;?>

                                <?if($arResult['DISPLAY_PROPERTIES']['SCHEDULE']['VALUE']):?>
                                    <div class="contacts-detail__property">
                                        <div class="contact-property contact-property--schedule">
                                            <div class="contact-property__label font_13 color_999"><?=Loc::getMessage('T_CONTACTS_SCHEDULE')?></div>
                                            <div class="contact-property__value color_333"><?=$arResult['DISPLAY_PROPERTIES']['SCHEDULE']['DISPLAY_VALUE']?></div>
                                        </div>
                                    </div>
                                <?endif;?>
                            </div>
                        <?endif;?>

                        <?if(
                            $arResult['DISPLAY_PROPERTIES']['PHONE']['VALUE'] ||
                            $arResult['DISPLAY_PROPERTIES']['EMAIL']['VALUE']
                        ):?>
                            <div class="contacts__col">
                                <?if($arResult['DISPLAY_PROPERTIES']['PHONE']['VALUE']):?>
                                    <div class="contacts-detail__property">
                                        <div class="contact-property contact-property--phones">
                                            <div class="contact-property__label font_13 color_999"><?=Loc::getMessage('T_CONTACTS_PHONE')?></div>
                                            <?foreach($arResult['DISPLAY_PROPERTIES']['PHONE']['VALUE'] as $i => $phone):?>
                                                <div class="contact-property__value dark_link">
                                                    <a title="<?=htmlspecialcharsbx($arResult['DISPLAY_PROPERTIES']['PHONE']['DESCRIPTION'][$i])?>" href="<?='tel:'.str_replace(array(' ', '-', '(', ')'), '', $phone)?>"><?=$phone?></a>
                                                </div>
                                            <?endforeach;?>
                                        </div>
                                    </div>
                                <?endif;?>

                                <?if($arResult['DISPLAY_PROPERTIES']['EMAIL']['VALUE']):?>
                                    <div class="contacts-detail__property">
                                        <div class="contact-property contact-property--email">
                                            <div class="contact-property__label font_13 color_999"><?=Loc::getMessage('T_CONTACTS_EMAIL')?></div>
                                            <?foreach($arResult['DISPLAY_PROPERTIES']['EMAIL']['VALUE'] as $i => $email):?>
                                                <div class="contact-property__value dark_link">
                                                    <a href="mailto:<?=$email?>"><?=$email?></a>
                                                </div>
                                            <?endforeach;?>
                                        </div>
                                    </div>
                                <?endif;?>
                            </div>
                        <?endif;?>
					</div>
				</div>
				<div class="contacts-detail__social">
					<?$APPLICATION->IncludeComponent(
						"aspro:social.info.".VENDOR_SOLUTION_NAME,
						".default",
						array(
							"CACHE_TYPE" => "A",
							"CACHE_TIME" => "3600000",
							"CACHE_GROUPS" => "N",
							"COMPONENT_TEMPLATE" => ".default",
							'SVG' => false,
							'IMAGES' => true,
							'ICONS' => true,
							'SIZE' => 'large',
							'HIDE_MORE' => false,
						),
						false
					);?>
				</div>
				<div class="contacts-detail__description" itemprop="description">
                    <?if($arResult['FIELDS']['DETAIL_TEXT']):?>
                        <div itemprop="description" class="contact-property contact-property--decription">
                            <div class="contact-property__text font_large color_666"><?=$arResult['FIELDS']['DETAIL_TEXT']?></div>
                        </div>
                    <?endif;?>

					<?if($bUseFeedback):?>
						<div class="contacts-detail__btn-wrapper">
						<span>
							<span class="btn btn-default btn-transparent-border bg-theme-target border-theme-target animate-load" data-event="jqm" data-param-id="aspro_<?=VENDOR_SOLUTION_NAME?>_question" data-name="question"><?=Loc::getMessage('T_CONTACTS_QUESTION1')?></span>
						</span>
						</div>
					<?endif;?>
				</div>
			</div>

<?
namespace Aspro\Allcorp3\Functions;
use \Bitrix\Main\Localization\Loc;
include_once $_SERVER['DOCUMENT_ROOT'] .'/bitrix/modules/aspro.allcorp3/lib/functions/CAsproAllcorp3.php';



    class CAsproAllcorp3Custom {

        public static function showPriceCAsproAllcorp3($arOptions = [])
        {
            $arDefaultOptions = [
                'TYPE' => 'catalog-block',
                'WRAPPER_CLASS' => '',
                'TO_LINE' => false,
                'WIDE_BLOCK' => false,
                'SHOW_SCHEMA' => true,
                'PRICE_BLOCK_CLASS' => 'color_333',
                'PRICE_FONT' => 17,
                'PRICEOLD_FONT' => 13,
                'RETURN' => false,
                'PRICES' => [],
                'ITEM' => [],
                'PARAMS' => []
            ];
            $arConfig = array_merge($arDefaultOptions, $arOptions);


            $arParams = $arConfig['PARAMS'];
            $arItem = $arConfig['ITEM'];
            $bLinePrices = $arConfig['TO_LINE'];
            $bShowSchema = $arConfig['SHOW_SCHEMA'];
            $bWideBlock = $arConfig['WIDE_BLOCK'];

            $price = isset($arItem['PRICE']) && $arItem['PRICE']['VALUE']
                ? $arItem['PRICE']
                : $arItem['DISPLAY_PROPERTIES']['PRICE'];
            $priceOld = isset($arItem['PRICEOLD']) && $arItem['PRICEOLD']['VALUE']
                ? $arItem['PRICEOLD']
                : $arItem['DISPLAY_PROPERTIES']['PRICEOLD'];
            $priceEconomy = isset($arItem['ECONOMY']) && $arItem['ECONOMY']['VALUE']
                ? $arItem['ECONOMY']
                : $arItem['DISPLAY_PROPERTIES']['ECONOMY'];
            $priceCurrency = isset($arItem['PRICE_CURRENCY']) && $arItem['PRICE_CURRENCY']
                ? $arItem['PRICE_CURRENCY']
                : $arItem['DISPLAY_PROPERTIES']['PRICE_CURRENCY'];
            $priceFilter = isset($arItem['FILTER_PRICE']) && $arItem['FILTER_PRICE']['VALUE']
                ? $arItem['FILTER_PRICE']
                : $arItem['DISPLAY_PROPERTIES']['FILTER_PRICE'];

            if (!$priceCurrency) {
                $priceCurrency = $arItem['PROPERTIES']['PRICE_CURRENCY'];
            }
            if (!$priceFilter) {
                $priceFilter = $arItem['PROPERTIES']['FILTER_PRICE'];
            }

            if ($arConfig['PRICES']) {
                $price['VALUE'] = $arConfig['PRICES']['PRICE'];
                $priceOld['VALUE'] = $arConfig['PRICES']['PRICE_OLD'];
                $priceCurrency['VALUE'] = $arConfig['PRICES']['PRICE_CURRENCY'];
            }

            $bUseCurrency = $priceCurrency['VALUE'];
            ?>
            <?ob_start();?>
            <?if(strlen($price['VALUE'])):?>
            <?if(strlen($arConfig['WRAPPER_CLASS'])):?>
                <div class="<?=$arConfig['WRAPPER_CLASS']?>">
            <?endif;?>

            <div class="price<?=($bLinePrices ? '  price--inline' : '')?> <?=$arConfig['PRICE_BLOCK_CLASS'];?>">
                <div class="price__new">
						<span class="price__new-val font_<?=$arConfig['PRICE_FONT'];?>">
							<?if ($bUseCurrency) {
                                $price['VALUE'] = self::replaceCurrencyInPrice($price['VALUE'], $priceCurrency["VALUE"]);
                            }?>
                            <?=\CAllcorp3::FormatPriceShema($price['VALUE'], ($arParams['SHOW_PRICE'] ? false : $bShowSchema), $arItem['PROPERTIES'] ?: $arItem['DISPLAY_PROPERTIES'] ?: $arItem)?>
						    <?if(empty((float)$priceEconomy['VALUE']) && $bShowSchema) {?>
                                <meta itemprop="price" content="0">
                            <?}?>
                        </span>
                </div>
                <?if($priceOld['VALUE']):?>
                    <div class="price__old">
                        <?if($bWideBlock):?>
                            <?=GetMessage('PRICE_DISCOUNT')?>
                        <?endif;?>
                        <?if ($bUseCurrency) {
                            $priceOld['VALUE'] = self::replaceCurrencyInPrice($priceOld['VALUE'], $priceCurrency["VALUE"]);
                        }?>
                        <span class="price__old-val font_<?=$arConfig['PRICEOLD_FONT'];?> color_999"><?=$priceOld['VALUE']?></span>
                    </div>
                <?endif;?>
                <?if($arItem['DISPLAY_PROPERTIES']['ECONOMY']['VALUE']):?>
                    <div class="price__economy rounded-3">
                        <?if($bWideBlock):?>
                            <?=GetMessage('PRICE_ECONOMY')?>
                        <?endif;?>
                        <?if ($bUseCurrency) {
                            $priceEconomy['VALUE'] = self::replaceCurrencyInPrice($priceEconomy['VALUE'], $priceCurrency["VALUE"]);
                        }?>
                        <span class="price__economy-val font_11"><?=$priceEconomy['VALUE']?></span>
                    </div>
                <?endif;?>
            </div>

            <?if(strlen($arConfig['WRAPPER_CLASS'])):?>
                </div>
            <?endif;?>
        <?endif;?>
            <?$html = ob_get_contents();
            ob_end_clean();


            if ($arConfig['RETURN']) {
                return $html;
            } else {
                echo $html;
            }
            ?>
        <?}

        public static function replaceCurrencyInPrice($price, $currency){
             $useShortcode = false;
             $useOt = false;

             if(strpos($price, '#CURRENCY#') !== false) {
                 $useShortcode = true;
             }

            if(strpos($price, 'от') !== false) {
                $useOt = true;
            }


            $number = preg_replace('/[^0-9,.]+/', '', $price);

             if ($number === "") {
                 return $price;
             }

             $price = number_format(
                 $number,
                 0,
                 '.',
                 ' '
             );

             if($useShortcode) {
                 $price .= ' '.'#CURRENCY#';
             }

             if($useOt) {
                 $price = 'от ' . $price;
             }

             return str_replace('#CURRENCY#', $currency, $price);


//            preg_match('/[\d.,]+/u', $price, $matches);
//            if (empty($matches)) {
//                return $price;
//            }
//
//            $number = str_replace(',', '.', $matches[0]);
//            $number = floatval($number);
//
//            $formattedNumber = number_format($number, 0, '.', ' ');
//
//            $currency = trim(str_replace($matches[0], '', $price));
//
//            return $formattedNumber . ' ' . $currency;
        }

    }



?>
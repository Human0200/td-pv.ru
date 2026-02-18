<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
use Bitrix\Main\Loader;

$arExtensions = [];
if ($arParams['SLIDER'] === 'Y' || $arParams['SLIDER'] === true) {
	$arExtensions[] = 'swiper';
}
if ($arParams['DISPLAY_COMPARE'] || $arParams['ORDER_VIEW']) {
	$arExtensions[] = 'item_action';
}

if (isset($templateData['TEMPLATE_LIBRARY']) && !empty($templateData['TEMPLATE_LIBRARY'])){
	$loadCurrency = false;
	if (!empty($templateData['CURRENCIES'])) {
		$loadCurrency = Loader::includeModule('currency');
	}
	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);
	if ($loadCurrency){?>
	<script type="text/javascript">
		BX.Currency.setCurrencies(<? echo $templateData['CURRENCIES']; ?>);
	</script>
	<?}
}

if (!$templateData['ITEMS']) {
	$GLOBALS['APPLICATION']->SetPageProperty('BLOCK_CATALOG_TAB', 'hidden');
}

TSolution\Extensions::init($arExtensions);
?>
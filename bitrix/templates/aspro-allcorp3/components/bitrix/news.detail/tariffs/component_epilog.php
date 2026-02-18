<?
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
global $arTheme, $APPLICATION;

CJSCore::Init('aspro_fancybox');

$arExtensions = [];

// top banner
\TSolution\Banner\Transparency::setHeaderClasses($templateData);

// can order?
$bOrderViewBasket = $templateData["ORDER"];

// use tabs?
if($arParams['USE_DETAIL_TABS'] === 'Y'){
	$bUseDetailTabs = true;
}
else{
	$bUseDetailTabs = false;
}

if ($arTheme['SHOW_PROJECTS_MAP_DETAIL']['VALUE'] == 'N') {
	unset($templateData['MAP']);
}

// blocks order
if(
	!$bUseDetailTabs &&
	array_key_exists('DETAIL_BLOCKS_ALL_ORDER', $arParams) &&
	$arParams["DETAIL_BLOCKS_ALL_ORDER"]
){
	$arBlockOrder = explode(",", $arParams["DETAIL_BLOCKS_ALL_ORDER"]);
}
else{
	$arBlockOrder = explode(",", $arParams["DETAIL_BLOCKS_ORDER"]);
	$arTabOrder = explode(",", $arParams["DETAIL_BLOCKS_TAB_ORDER"]);
}
?>
<div class="tariffs-detail__bottom-info">
	<?foreach($arBlockOrder as $blockCode):?>
		<?if(file_exists(__DIR__ . '/epilog_blocks/' . $blockCode . '.php')) :?>
			<?include 'epilog_blocks/'.$blockCode.'.php';?>
		<?endif;?>
	<?endforeach;?>

	<?if(file_exists(__DIR__ . '/epilog_blocks/tags.php')) :?>
		<?include 'epilog_blocks/tags.php';?>
	<?endif;?>
</div>

<?
if ($arExtensions) {
	TSolution\Extensions::init($arExtensions);
}
?>
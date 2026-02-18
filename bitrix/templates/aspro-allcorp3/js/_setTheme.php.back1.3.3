<?
use \Bitrix\Main\Loader,
	\Bitrix\Main\Localization\Loc,
	\Bitrix\Main\Config\Option,
	\CAllcorp3 as Solution;

define('NOT_CHECK_PERMISSIONS', true);
define('STATISTIC_SKIP_ACTIVITY_CHECK', 'true');
define('STOP_STATISTICS', true);
define('PUBLIC_AJAX_MODE', true);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

Loader::includeModule(Solution::moduleID);

if(isset($_REQUEST['site_id'])) {
	$SITE_ID = $_REQUEST['site_id'];
}
else{
	$SITE_ID = 's1';
}

if(isset($_REQUEST['site_dir'])) {
	$SITE_DIR = $_REQUEST['site_dir'];
}

$arSite = CSite::GetByID($SITE_ID)->Fetch();

$arFrontParametrs = Solution::GetFrontParametrsValues($SITE_ID, $SITE_DIR);

$tmp = $arFrontParametrs['DATE_FORMAT'];
$DATE_MASK = ($tmp == 'DOT' ? 'dd.mm.yyyy': ($tmp == 'HYPHEN' ? 'dd-mm-yyyy': ($tmp == 'SPACE' ? 'dd mm yyyy': ($tmp == 'SLASH' ? 'dd/mm/yyyy': 'dd:mm:yyyy'))));
$VALIDATE_DATE_MASK = ($tmp == 'DOT' ? '^[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{4}$': ($tmp == 'HYPHEN' ? '^[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4}$': ($tmp == 'SPACE' ? '^[0-9]{1,2} [0-9]{1,2} [0-9]{4}$': ($tmp == 'SLASH' ? '^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$': '^[0-9]{1,2}\:[0-9]{1,2}\:[0-9]{4}$'))));
$DATE_PLACEHOLDER = ($tmp == 'DOT' ? GetMessage('DATE_FORMAT_DOT') : ($tmp == 'HYPHEN' ? GetMessage('DATE_FORMAT_HYPHEN') : ($tmp == 'SPACE' ? GetMessage('DATE_FORMAT_SPACE') : ($tmp == 'SLASH' ? GetMessage('DATE_FORMAT_SLASH') : GetMessage('DATE_FORMAT_COLON')))));
$DATETIME_MASK = $DATE_MASK.' HH:MM'; /* !!! HH::MM for inputmask 4, h:s for other */
$DATETIME_PLACEHOLDER = ($tmp == 'DOT' ? GetMessage('DATE_FORMAT_DOT') : ($tmp == 'HYPHEN' ? GetMessage('DATE_FORMAT_HYPHEN') : ($tmp == 'SPACE' ? GetMessage('DATE_FORMAT_SPACE') : ($tmp == 'SLASH' ? GetMessage('DATE_FORMAT_SLASH') : GetMessage('DATE_FORMAT_COLON'))))).' '.GetMessage('TIME_FORMAT_COLON');
$VALIDATE_DATETIME_MASK = ($tmp == 'DOT' ? '^[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{4} [0-9]{1,2}\:[0-9]{1,2}$': ($tmp == 'HYPHEN' ? '^[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4} [0-9]{1,2}\:[0-9]{1,2}$': ($tmp == 'SPACE' ? '^[0-9]{1,2} [0-9]{1,2} [0-9]{4} [0-9]{1,2}\:[0-9]{1,2}$': ($tmp == 'SLASH' ? '^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4} [0-9]{1,2}\:[0-9]{1,2}$': '^[0-9]{1,2}\:[0-9]{1,2}\:[0-9]{4} [0-9]{1,2}\:[0-9]{1,2}$'))));

// get banner`s index of current preset 
$currentBannerIndex = Solution::getCurrentPresetBannerIndex($SITE_ID);
?>
<?header('Content-Type: application/javascript');?>
var arAsproOptions = window[solutionName] = ({
	SITE_DIR: '<?=$SITE_DIR?>',
	SITE_ID: '<?=$SITE_ID?>',
	SITE_ADDRESS: '<?=$arSite['SERVER_NAME'];?>',
	SITE_TEMPLATE_PATH: '<?=SITE_TEMPLATE_PATH?>',
	FORM: ({
		ASK_FORM_ID: 'ASK',
		SERVICES_FORM_ID: 'SERVICES',
		FEEDBACK_FORM_ID: 'FEEDBACK',
		CALLBACK_FORM_ID: 'CALLBACK',
		RESUME_FORM_ID: 'RESUME',
		TOORDER_FORM_ID: 'TOORDER'
	}),
	THEME: <?=CUtil::PhpToJSObject(
		array_merge(
			$arFrontParametrs, 
			array(
				'DATE_MASK' => $DATE_MASK,
				'DATE_PLACEHOLDER' => $DATE_PLACEHOLDER,
				'VALIDATE_DATE_MASK' => $VALIDATE_DATE_MASK,
				'DATETIME_MASK' => $DATETIME_MASK,
				'DATETIME_PLACEHOLDER' => $DATETIME_PLACEHOLDER,
				'VALIDATE_DATETIME_MASK' => $VALIDATE_DATETIME_MASK,
				'INSTAGRAMM_INDEX' => isset($arFrontParametrs[$arFrontParametrs['INDEX_TYPE'].'_INSTAGRAMM_INDEX']) ? $arFrontParametrs[$arFrontParametrs['INDEX_TYPE'].'_INSTAGRAMM_INDEX'] : 'Y',
				'IS_BASKET_PAGE' => Solution::IsBasketPage($arFrontParametrs['BASKET_PAGE_URL']),
				'IS_ORDER_PAGE' => Solution::IsBasketPage($arFrontParametrs['ORDER_PAGE_URL']),
				'PERSONAL_PAGE_URL' => $arFrontParametrs['PERSONAL_PAGE_URL'],
			)
		)
	)?>,
	PRESETS: <?=CUtil::PhpToJSObject(
		array(
			'VALUE' => Solution::getCurrentPreset($SITE_ID),
			'LIST' => Solution::$arPresetsList,
		)
	)?>,
	THEMATICS: <?=CUtil::PhpToJSObject(
		array(
			'VALUE' => Solution::getCurrentThematic($SITE_ID),
			'LIST' => Solution::$arThematicsList,
		)
	)?>,
	REGIONALITY: ({
		USE_REGIONALITY: '<?=$arFrontParametrs['USE_REGIONALITY']?>',
		REGIONALITY_VIEW: '<?=$arFrontParametrs['REGIONALITY_VIEW']?>',
	}),
	COUNTERS: ({
		YANDEX_COUNTER: 1,
		GOOGLE_COUNTER: 1,
		YANDEX_ECOMERCE: '<?=Option::get(Solution::moduleID, 'YANDEX_ECOMERCE', false, $SITE_ID)?>',
		GOOGLE_ECOMERCE: '<?=Option::get(Solution::moduleID, 'GOOGLE_ECOMERCE', false, $SITE_ID)?>',
		TYPE: {
			ONE_CLICK: '<?=GetMessage('ONE_CLICK_BUY');?>',
			QUICK_ORDER: '<?=GetMessage('QUICK_ORDER');?>',
		},
		GOOGLE_EVENTS: {
			ADD2BASKET: '<?=trim(Option::get(Solution::moduleID, 'BASKET_ADD_EVENT', 'addToCart', $SITE_ID))?>',
			REMOVE_BASKET: '<?=trim(Option::get(Solution::moduleID, 'BASKET_REMOVE_EVENT', 'removeFromCart', $SITE_ID))?>',
			CHECKOUT_ORDER: '<?=trim(Option::get(Solution::moduleID, 'CHECKOUT_ORDER_EVENT', 'checkout', $SITE_ID))?>',
			PURCHASE: '<?=trim(Option::get(Solution::moduleID, 'PURCHASE_ORDER_EVENT', 'gtm.dom', $SITE_ID))?>',
		}
	}),
	OID: '<?=$arFrontParametrs['CATALOG_OID'];?>',
	JS_ITEM_CLICK: ({
		'precision': 6,
		'precisionFactor': Math.pow(10, 6)
	}),
<? if ($currentBannerIndex > 1): ?>
	CURRENT_BANNER_INDEX: <?=$currentBannerIndex?>,
<? endif; ?>
});
<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
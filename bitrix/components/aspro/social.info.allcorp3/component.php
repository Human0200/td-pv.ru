<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if(!isset($arParams['CACHE_TIME']))
	$arParams['CACHE_TIME'] = 36000000;

if (!class_exists('TSolution') || !CModule::IncludeModule(TSolution::moduleID)) {
	ShowError(GetMessage('ASPRO_MODULE_NOT_INSTALLED'));
	return;
}

$arFrontParametrs = TSolution::GetFrontParametrsValues(SITE_ID);

if($this->StartResultCache(false, array(($arParams['CACHE_GROUPS'] === 'N'? false : $USER->GetGroups()), $arResult['ITEMS'], $bUSER_HAVE_ACCESS, $arNavigation))){
	$this->SetResultCacheKeys(array(
		'SOCIAL_VK',
		'SOCIAL_RUTUBE',
		'SOCIAL_FACEBOOK',
		'SOCIAL_TWITTER',
		'SOCIAL_INSTAGRAM',
		'SOCIAL_TELEGRAM',
		'SOCIAL_ODNOKLASSNIKI',
		'SOCIAL_YOUTUBE',
		'SOCIAL_MAIL',
		'SOCIAL_VIBER',
		'SOCIAL_WHATS',
		'SOCIAL_ZEN',
		'SOCIAL_TIKTOK',
		'SOCIAL_PINTEREST',
		'SOCIAL_SNAPCHAT',
		'SOCIAL_LINKEDIN',
	));

	$arResult['ITEMS'] = array(
		"SOCIAL_VK" => array(
			'VALUE' => $arFrontParametrs['SOCIAL_VK'],
			'ICON' => SITE_TEMPLATE_PATH."/images/svg/social/VK.svg",
			'ICON_CLASS' => 'vk',
		),
		"SOCIAL_RUTUBE" => array(
			'VALUE' => $arFrontParametrs['SOCIAL_RUTUBE'],
			'ICON' => SITE_TEMPLATE_PATH."/images/svg/social/RUTUBE.svg",
			'ICON_CLASS' => 'rutube',
		),
		"SOCIAL_FACEBOOK" => array(
			'VALUE' => $arFrontParametrs['SOCIAL_FACEBOOK'],
			'ICON' => SITE_TEMPLATE_PATH."/images/svg/social/FACEBOOK.svg",
			'ICON_CLASS' => 'fb',
		),
		"SOCIAL_TWITTER" => array(
			'VALUE' => $arFrontParametrs['SOCIAL_TWITTER'],
			'ICON' => SITE_TEMPLATE_PATH."/images/svg/social/TWITTER.svg",
			'ICON_CLASS' => 'tw',
		),
		"SOCIAL_INSTAGRAM" => array(
			'VALUE' => $arFrontParametrs['SOCIAL_INSTAGRAM'],
			'ICON' => SITE_TEMPLATE_PATH."/images/svg/social/INSTAGRAM.svg",
			'ICON_CLASS' => 'inst',
		),
		"SOCIAL_TELEGRAM" => array(
			'VALUE' => $arFrontParametrs['SOCIAL_TELEGRAM'],
			'ICON' => SITE_TEMPLATE_PATH."/images/svg/social/TELEGRAM.svg",
			'ICON_CLASS' => 'tel',
		),
		"SOCIAL_YOUTUBE" => array(
			'VALUE' => $arFrontParametrs['SOCIAL_YOUTUBE'],
			'ICON' => SITE_TEMPLATE_PATH."/images/svg/social/YOUTUBE.svg",
			'ICON_CLASS' => 'yt',
		),
		"SOCIAL_ODNOKLASSNIKI" => array(
			'VALUE' => $arFrontParametrs['SOCIAL_ODNOKLASSNIKI'],
			'ICON' => SITE_TEMPLATE_PATH."/images/svg/social/ODNOKLASSNIKI.svg",
			'ICON_CLASS' => 'ok',
		),
		"SOCIAL_MAIL" => array(
			'VALUE' => $arFrontParametrs['SOCIAL_MAIL'],
			'ICON' => SITE_TEMPLATE_PATH."/images/svg/social/MAIL.svg",
			'ICON_CLASS' => 'ml',
		),
		"SOCIAL_VIBER" => array(
			'VALUE' => $arFrontParametrs['SOCIAL_VIBER'],
			'ICON' => SITE_TEMPLATE_PATH."/images/svg/social/VIBER.svg",
			'ICON_CLASS' => 'vi',
			'CUSTOM_DESKTOP' => $arFrontParametrs['SOCIAL_VIBER_CUSTOM_DESKTOP'],
			'CUSTOM_MOBILE' => $arFrontParametrs['SOCIAL_VIBER_CUSTOM_MOBILE'],
		),
		"SOCIAL_WHATS" => array(
			'VALUE' => $arFrontParametrs['SOCIAL_WHATS'],
			'ICON' => SITE_TEMPLATE_PATH."/images/svg/social/WHATS.svg",
			'ICON_CLASS' => 'wh',
			'CUSTOM_DESKTOP' => $arFrontParametrs['SOCIAL_WHATS_CUSTOM'],
			'ADD_TEXT' => $arFrontParametrs['SOCIAL_WHATS_TEXT'],
		),
		"SOCIAL_ZEN" => array(
			'VALUE' => $arFrontParametrs['SOCIAL_ZEN'],
			'ICON' => SITE_TEMPLATE_PATH."/images/svg/social/ZEN.svg",
			'ICON_CLASS' => 'zen',
		),
		"SOCIAL_TIKTOK" => array(
			'VALUE' => $arFrontParametrs['SOCIAL_TIKTOK'],
			'ICON' => SITE_TEMPLATE_PATH."/images/svg/social/TIKTOK.svg",
			'ICON_CLASS' => 'tt',
		),
		"SOCIAL_PINTEREST" => array(
			'VALUE' => $arFrontParametrs['SOCIAL_PINTEREST'],
			'ICON' => SITE_TEMPLATE_PATH."/images/svg/social/PINTEREST.svg",
			'ICON_CLASS' => 'pt',
		),
		"SOCIAL_SNAPCHAT" => array(
			'VALUE' => $arFrontParametrs['SOCIAL_SNAPCHAT'],
			'ICON' => SITE_TEMPLATE_PATH."/images/svg/social/SNAPCHAT.svg",
			'ICON_CLASS' => 'sc',
		),
		"SOCIAL_LINKEDIN" => array(
			'VALUE' => $arFrontParametrs['SOCIAL_LINKEDIN'],
			'ICON' => SITE_TEMPLATE_PATH."/images/svg/social/Linkedin.svg",
			'ICON_CLASS' => 'li',
		),
	);

	$this->IncludeComponentTemplate();
}
?>

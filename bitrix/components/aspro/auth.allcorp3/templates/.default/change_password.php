<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();?>
<?$APPLICATION->AddChainItem("Смена пароля");?>
<?$APPLICATION->SetTitle("Смена пароля");?>
<?global $USER, $APPLICATION;
if( !$USER->IsAuthorized() ){?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:system.auth.changepasswd",
		"main",
		false
	);?>
<?}else{
	LocalRedirect( $arParams["PERSONAL"] );
}?>
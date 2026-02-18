<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = array(
	"NAME" => Loc::getMessage("T_ASPRO_INVOICEBOX_NAME"),
	"DESCRIPTION" => Loc::getMessage("T_ASPRO_INVOICEBOX_DESCRIPTION"),
	"ICON" => "/images/search_form.gif",
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "aspro",
		"NAME" => GetMessage("T_ASPRO"),
	),
	"COMPLEX" => "N"
);
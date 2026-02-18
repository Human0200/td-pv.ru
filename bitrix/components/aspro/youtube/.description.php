<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
 
$arComponentDescription = array(
	"NAME" => GetMessage("T_ASPRO_YOUTUBE_NAME"),
	"DESCRIPTION" => GetMessage("T_ASPRO_YOUTUBE_DESCRIPTION"),
	"ICON" => "/images/youtube.gif",
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "aspro",
		"NAME" => GetMessage("ASPRO")
	),
	"COMPLEX" => "N"
);
?>
<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
$arFromTheme = [];
if (isset($_REQUEST['src_path'])) {
	$_SESSION['src_path_component'] = $_REQUEST['src_path'];
}

if (strpos($_SESSION['src_path_component'], 'custom') === false) {
	$arFromTheme = ["FROM_THEME" => GetMessage("V_FROM_THEME")];
}

$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		"API_TOKEN_YOUTUBE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("TOKEN_YOUTUBE"),
			"TYPE" => "LIST",
			"VALUES" => $arFromTheme,
			"DEFAULT" => "AIzaSyDDLpzOYXoK73uvJub8SiUwQ2zyC1GNWi8",
			"ADDITIONAL_VALUES" => "Y",
		),
		"CHANNEL_ID_YOUTUBE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("CHANNEL_ID_YOUTUBE_TITLE"),
			"TYPE" => "LIST",
			"VALUES" =>$arFromTheme,
			"DEFAULT" => "UCvNfOlv6ELNl95oi_Q8xooA",
			"ADDITIONAL_VALUES" => "Y",
		),
		"TITLE" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("TITLE_YOUTUBE"),
			"TYPE" => "LIST",
			"VALUES" => $arFromTheme,
			"DEFAULT" => GetMessage("TITLE_YOUTUBE_VALUE"),
			"ADDITIONAL_VALUES" => "Y",
		),
		"RIGHT_TITLE" => array(
			'NAME' => GetMessage('T_RIGHT_TITLE'),
			'TYPE' => 'LIST',
			"VALUES" => $arFromTheme,
			'DEFAULT' =>  GetMessage('RIGHT_TITLE_VALUE'),
			"ADDITIONAL_VALUES" => "Y",
		),
		'SUBTITLE' => array(
			'NAME' => GetMessage('T_SUBTITLE'),
			'TYPE' => 'LIST',
			"VALUES" => $arFromTheme,
			'DEFAULT' => '',
			"ADDITIONAL_VALUES" => "Y",
		),
		'SORT_YOUTUBE' => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			'NAME' => GetMessage('SORT_YOUTUBE_TITLE'),
			'TYPE' => 'LIST',
			'VALUES' => array_merge(
				$arFromTheme,
				[
					'date' => GetMessage('SORT_YOUTUBE_DATE_TITLE'),
					'rating' => GetMessage('SORT_YOUTUBE_RATING_TITLE'),
					/*'viewCount' => GetMessage('SORT_YOUTUBE_VIEWCOUNT_TITLE'),*/
				]
			),
			'DEFAULT' => "date",
		),
		'PLAYLIST_ID_YOUTUBE' => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			'NAME' => GetMessage('PLAYLIST_ID_YOUTUBE_TITLE'),
			'TYPE' => 'LIST',
			"VALUES" => $arFromTheme,
			'DEFAULT' => '',
			"ADDITIONAL_VALUES" => "Y",
		),
		'COUNT_VIDEO_YOUTUBE' => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			'NAME' => GetMessage('COUNT_VIDEO_YOUTUBE'),
			'TYPE' => 'LIST',
			"VALUES" => $arFromTheme,
			'DEFAULT' => "5",
			"ADDITIONAL_VALUES" => "Y",
		),
		'COUNT_VIDEO_ON_LINE_YOUTUBE' => array(
			'NAME' => GetMessage('COUNT_VIDEO_ON_LINE_YOUTUBE'),
			'TYPE' => 'LIST',
			'VALUES' => $arFromTheme + [
					'2' => 2,
					'3' => 3,
					'4' => 4,
				],
			'DEFAULT' => "3",
		),
	),
);
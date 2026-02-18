<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

use \Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);

Loc::loadMessages(__FILE__);

$arItemFilter = CAllcorp3::GetIBlockAllElementsFilter($arParams);
$arElements = CAllcorp3Cache::CIblockElement_GetList(array("CACHE" => array("TAG" => CAllcorp3Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]), "MULTI" => "Y")), $arItemFilter, false, false, array('ID', 'NAME','PREVIEW_TEXT'));
?>

<? if (empty($arElements)): ?>
	<div class="alert alert-warning"><?= Loc::getMessage('FAQ__SECTION_EMPTY') ?></div>
<? else : ?>
	<?CAllcorp3::CheckComponentTemplatePageBlocksParams($arParams, __DIR__);?>
	<?// section elements?>
	<?@include_once('page_blocks/'.$arParams["SECTION_ELEMENTS_TYPE_VIEW"].'.php');?>
	<?$arFaqSchema = array(
		"@context" => "https://schema.org",
		"@type" => "FAQPage",
		"mainEntity" => []
	)?>
	<?foreach ($arElements as $element):
		$arFaqSchema['mainEntity'][] = array(
			"@type" => "Question",
			"name" => $element['NAME'],
			"acceptedAnswer" => array(
				"@type" => "Answer",
				"text" => $element['PREVIEW_TEXT']
			)
		);
	endforeach;?>
	<?if($arParams["SHOW_ASK_QUESTION_BLOCK"] == "Y"){
		include('include_bottom_block.php');
	}?>	
	<script type="application/ld+json"><?=str_replace("'", "\"", CUtil::PhpToJSObject($arFaqSchema, false, true));?></script>
<? endif ?>
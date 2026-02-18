<?php

use \Bitrix\Main\Localization\Loc;

CJSCore::Init('aspro_fancybox');

Loc::loadMessages(__FILE__);?>
<div class="partner-epilog">	
	<?
	$arBlockOrder = explode(",", $arParams['DETAIL_BLOCKS_ORDER']);
	foreach ($arBlockOrder as $code) {
		switch ($code) {
			default :
				include_once 'epilog_blocks/' . $code . '.php';
				break;
		}
	}
	?>
</div>
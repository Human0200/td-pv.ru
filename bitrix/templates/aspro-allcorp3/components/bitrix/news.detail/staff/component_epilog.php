<?php

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

CJSCore::Init('aspro_fancybox');
?>
<div class="staff-epilog">
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
<?php

use \Bitrix\Main\Localization\Loc;

?>
<div class="rounded-4 bordered grey-bg order-block__wrapper">
	<div class="order-info-block">
		<div class="line-block line-block--align-normal line-block--40">
			<div class="line-block__item icon-svg-block">
					<?= CAllcorp3::showIconSvg('review stroke-theme', SITE_TEMPLATE_PATH . '/images/svg/order_large.svg'); ?>
			</div>
			<div class="line-block__item flex-1">
				<div class="text font_18 color_333 font_large">
					<? 
					$APPLICATION->IncludeComponent('bitrix:main.include', '', ['AREA_FILE_SHOW' => 'file', 'PATH' => SITE_DIR . 'include/ask_question_faq.php', 'EDIT_TEMPLATE' => '']);
					?>
				</div>
			</div>
			<div class="line-block__item order-info-btns">
				<div class="line-block line-block--align-normal line-block--12">
					<div class="line-block__item">
						<span class="btn btn-default btn-lg" data-event="jqm"
							data-param-id="<?= CAllcorp3::getFormID("aspro_allcorp3_question"); ?>"
							data-name="question">
							<span><?= (strlen($arParams['S_ASK_QUESTION']) ? $arParams['S_ASK_QUESTION'] : Loc::getMessage('FAQ__BTN__ASK_QUESTION')) ?></span>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
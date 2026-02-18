<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arOptions = $arResult['OPTIONS'];
?>
<div id="eyed-panel" class="eyed-panel">
	<?if ($arResult['ENABLED']):?>
		<div class="eyed-panel__inner">
			<!--noindex -->
			<div class="maxwidth-theme">
				<div class="line-block flexbox--justify-beetwen flexbox--wrap line-block--24-vertical">
					<div class="line-block__item eyed-panel__item" data-option="FONT-SIZE">
						<div class="line-block line-block--8-vertical">
							<div class="line-block__item eyed-panel__item-title font_bold"><?=Loc::getMessage('EA_T_FONT_SIZE_TITLE')?></div>
							<div class="line-block__item eyed-panel__item-values">
								<div class="line-block line-block--8">
									<div class="line-block__item">
										<a href="" class="eyed-panel__item-value<?=($arOptions['FONT-SIZE'] == 16 ? ' active' : '')?>" data-option_value="16" rel="nofollow" title="<?=Loc::getMessage('EA_T_FONT_SIZE_SMALL')?>"><?=TSolution::showIconSvg('', $templateFolder.'/images/svg/font_size_16.svg')?></a>
									</div>
									<div class="line-block__item">
										<a href="" class="eyed-panel__item-value<?=($arOptions['FONT-SIZE'] == 20 ? ' active' : '')?>" data-option_value="20" 
										rel="nofollow" title="<?=Loc::getMessage('EA_T_FONT_SIZE_NORMAL')?>"><?=TSolution::showIconSvg('', $templateFolder.'/images/svg/font_size_20.svg')?></a>
									</div>
									<div class="line-block__item">
										<a href="" class="eyed-panel__item-value<?=($arOptions['FONT-SIZE'] == 24 ? ' active' : '')?>" data-option_value="24" rel="nofollow" title=" <?=Loc::getMessage('EA_T_FONT_SIZE_BIG')?>"><?=TSolution::showIconSvg('', $templateFolder.'/images/svg/font_size_24.svg')?></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="line-block__item eyed-panel__item" data-option="COLOR-SCHEME">
						<div class="line-block line-block--8-vertical">
							<div class="line-block__item eyed-panel__item-title font_bold"><?=Loc::getMessage('EA_T_COLOR_SCHEME_TITLE')?></div>
							<div class="line-block__item eyed-panel__item-values">
								<div class="line-block line-block--8">
									<div class="line-block__item">
										<a href="" class="eyed-panel__item-value<?=($arOptions['COLOR-SCHEME'] === 'black' ? ' active' : '')?>" data-option_value="black" rel="nofollow" title="<?=Loc::getMessage('EA_T_COLOR_SCHEME_BLACK')?>"><span><?=TSolution::showIconSvg('', $templateFolder.'/images/svg/color_scheme_black.svg')?></span></a>
									</div>
									<div class="line-block__item">
										<a href="" class="eyed-panel__item-value<?=($arOptions['COLOR-SCHEME'] === 'white' ? ' active' : '')?>" data-option_value="white" rel="nofollow" title="<?=Loc::getMessage('EA_T_COLOR_SCHEME_WHITE')?>"><span><?=TSolution::showIconSvg('', $templateFolder.'/images/svg/color_scheme_white.svg')?></span></a>
									</div>
									<div class="line-block__item">
										<a href="" class="eyed-panel__item-value<?=($arOptions['COLOR-SCHEME'] === 'blue' ? ' active' : '')?>" data-option_value="blue" rel="nofollow" title="<?=Loc::getMessage('EA_T_COLOR_SCHEME_BLUE')?>"><span><?=TSolution::showIconSvg('', $templateFolder.'/images/svg/color_scheme_blue.svg')?></span></a>
									</div>
									<div class="line-block__item">
										<a href="" class="eyed-panel__item-value<?=($arOptions['COLOR-SCHEME'] === 'black_on_yellow' ? ' active' : '')?>" data-option_value="black_on_yellow" rel="nofollow" title="<?=Loc::getMessage('EA_T_COLOR_SCHEME_BLACK_ON_YELLOW')?>"><span><?=TSolution::showIconSvg('', $templateFolder.'/images/svg/color_scheme_black_on_yellow.svg')?></span></a>
									</div>
									<div class="line-block__item">
										<a href="" class="eyed-panel__item-value<?=($arOptions['COLOR-SCHEME'] === 'green' ? ' active' : '')?>" data-option_value="green" rel="nofollow" title="<?=Loc::getMessage('EA_T_COLOR_SCHEME_GREEN')?>"><span><?=TSolution::showIconSvg('', $templateFolder.'/images/svg/color_scheme_green.svg')?></span></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="line-block__item eyed-panel__item" data-option="IMAGES">
						<div class="line-block line-block--8-vertical">
							<div class="line-block__item eyed-panel__item-title font_bold"><?=Loc::getMessage('EA_T_IMAGES_TITLE')?></div>
							<div class="line-block__item eyed-panel__item-values">
								<div class="line-block line-block--8">
									<div class="line-block__item">
										<a href="" class="eyed-panel__item-value<?=($arOptions['IMAGES'] ? ' active' : '')?>" data-option_value="1" rel="nofollow" title="<?=Loc::getMessage('EA_T_IMAGES_ON')?>"><?=TSolution::showIconSvg('', $templateFolder.'/images/svg/images_on.svg')?></a>
									</div>
									<div class="line-block__item">
										<a href="" class="eyed-panel__item-value<?=($arOptions['IMAGES'] ? '' : ' active')?>" data-option_value="0" rel="nofollow" title="<?=Loc::getMessage('EA_T_IMAGES_OFF')?>"><?=TSolution::showIconSvg('', $templateFolder.'/images/svg/images_off.svg')?></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="line-block__item eyed-panel__item" data-option="SPEAKER">
						<div class="line-block line-block--8-vertical">
							<div class="line-block__item eyed-panel__item-title font_bold"><?=Loc::getMessage('EA_T_SPEAKER_TITLE')?></div>
							<div class="line-block__item eyed-panel__item-values">
								<div class="line-block line-block--8">
									<div class="line-block__item">
										<a href="" class="eyed-panel__item-value<?=($arOptions['SPEAKER'] ? ' active' : '')?>" data-option_value="1" title="<?=Loc::getMessage('EA_T_SPEAKER_ON')?>" rel="nofollow"><?=TSolution::showIconSvg('', $templateFolder.'/images/svg/speaker_on.svg')?></a>
									</div>
									<div class="line-block__item">
										<a href="" class="eyed-panel__item-value<?=($arOptions['SPEAKER'] ? '' : ' active')?>" data-option_value="0" title="<?=Loc::getMessage('EA_T_SPEAKER_OFF')?>" rel="nofollow"><?=TSolution::showIconSvg('', $templateFolder.'/images/svg/speaker_off.svg')?></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="line-block__item">
						<div class="btn btn-default eyed-toggle eyed-toggle--off font_bold"><?=TSolution::showIconSvg('', $templateFolder.'/images/svg/eye.svg')?><?=Loc::getMessage('EA_T_NORMAL_VERSION')?></div>
					</div>
				</div>
			</div>
			<!-- noindex -->
		</div>
	<?endif;?>
	<?if(!$arResult['IS_AJAX']):?>
		<script>
		BX.ready(function(){
			new JEyed(<?=CUtil::PhpToJSObject($arResult, false, true)?>);
		});

		BX.message({
			EA_T_EYED_VERSION: '<?=Loc::getMessage('EA_T_EYED_VERSION')?>',
			EA_T_NORMAL_VERSION: '<?=Loc::getMessage('EA_T_NORMAL_VERSION')?>',
			EA_T_NORMAL_VERSION_SHORT: '<?=Loc::getMessage('EA_T_NORMAL_VERSION_SHORT')?>',
			__EA_T_TEXT_REGEX: '<?=Loc::getMessage('__EA_T_TEXT_REGEX')?>',
		});
		</script>
	<?endif;?>
</div>
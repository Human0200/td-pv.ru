<?
use Bitrix\Main\Localization\Loc;

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
Loc::loadMessages(__FILE__);

$this->setFrameMode(true);

$arResult['TEMPLATE'] = $this->{'__name'};
?>
<button id="theme-selector--<?=$arResult['RAND']?>" class="theme-selector btn--no-btn-appearance fill-theme-parent-all" title="<?=Loc::getMessage('TS_T_'.$arResult['COLOR'])?>">
	<span class="theme-selector__inner">
		<span class="theme-selector__items menu-light-icon-fill banner-light-icon-fill fill-use-888 fill-theme-use-svg-hover fill-theme-target light-opacity-hover">
			<span class="theme-selector__item theme-selector__item--light<?=($arResult['COLOR'] === 'light' ? ' current' : '')?>"
				<?=$arResult['COLOR'] !== 'light' ? 'style="display: none"' : '';?>
			>
				<span class="theme-selector__item-icon"><?=TSolution::showSpriteIconSvg($this->{'__folder'}.'/images/svg/icons.svg#light-16-16', 'light-16-16', ['WIDTH' => 18, 'HEIGHT' => 18]);?></span>
			</span>
			<span class="theme-selector__item theme-selector__item--dark<?=($arResult['COLOR'] === 'dark' ? ' current' : '')?>"
				<?=$arResult['COLOR'] !== 'dark' ? 'style="display: none"' : '';?>
			>
				<span class="theme-selector__item-icon"><?=TSolution::showSpriteIconSvg($this->{'__folder'}.'/images/svg/icons.svg#dark-14-14', 'dark-14-14', ['WIDTH' => 18, 'HEIGHT' => 18]);?></span>
			</span>
		</span>
	</span>
	<script>
	BX.message({
		TS_T_light: '<?=GetMessageJS('TS_T_light')?>',
		TS_T_dark: '<?=GetMessageJS('TS_T_dark')?>',
	});

	new JThemeSelector(
		'<?=$arResult['RAND']?>', 
		<?=CUtil::PhpToJSObject($arParams, false, true)?>, <?=CUtil::PhpToJSObject($arResult, false, true)?>
	);
	</script>
</button>
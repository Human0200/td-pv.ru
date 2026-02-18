<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?
$bEmpty = true;
foreach($arResult['ITEMS'] as $arItem) {
	if( !empty($arItem['VALUE']) ) {
		$bEmpty = false;
		break;
	}
}
$bSvg = $arParams['SVG'];
$bImage = $arParams['IMAGES'];
?>
<?if($arParams["SOCIAL_TITLE"] && !$bEmpty):?>
	<div class="small_title"><?=$arParams["SOCIAL_TITLE"];?></div>
<?endif;?>

<?if(!$bEmpty):?>
	<!-- noindex -->
	<?if($arParams['WRAPPER']):?>
		<div class="<?=$arParams['WRAPPER']?>">
	<?endif;?>
	<div class="social <?=$bSvg ? 'social--picture-svg' : ''?> <?=$bImage ? 'social--picture-image' : ''?>">
		<ul class="social__items <?=$arParams['SIZE'] ? 'social__items--size-'.$arParams['SIZE'] : ''?> <?=$arParams['ICONS'] ? 'social__items--type-icon' : ''?>">
			<?
			$counter = 1;
			$arMoreSocial = array();
			foreach($arResult['ITEMS'] as $itemKey => $arItem):?>
				<?if( !empty($arItem['VALUE']) ):?>
					<?if($counter < 5 || !$arParams['HIDE_MORE']):?>
						<?$itemTitle = GetMessage('TEMPL_'.$itemKey);
						$hrefMobile = $hrefDesktop = '';
						$bViber = $itemKey === 'SOCIAL_VIBER';
						$bWhats = $itemKey === 'SOCIAL_WHATS';
						if($bViber){
							$hrefDesktop = strlen(trim($arItem["CUSTOM_DESKTOP"])) ? $arItem["CUSTOM_DESKTOP"] : 'viber://chat?number=+'.$arItem['VALUE'];
							$hrefMobile = strlen(trim($arItem["CUSTOM_MOBILE"])) ? $arItem["CUSTOM_MOBILE"] : 'viber://add?number='.$arItem['VALUE'];
						}
						if($bWhats){
							if( strlen(trim($arItem["CUSTOM_DESKTOP"])) ){
								$hrefDesktop = $arItem["CUSTOM_DESKTOP"];
							} else {
								$bWhatsText = !empty($arItem['ADD_TEXT']);
								$text = '';
								if($bWhatsText){
									if(defined('LANG_CHARSET') && strtolower(LANG_CHARSET) == 'windows-1251'){
										$text = iconv("windows-1251","utf-8", $arItem['ADD_TEXT']);
									} else {
										$text = $arItem['ADD_TEXT'];
									}
								}
								$whatsText = $bWhatsText ? '?text='.rawurlencode($text) : '';
								$hrefDesktop = 'https://wa.me/'.$arItem['VALUE'].$whatsText;
							}
						}
						?>
						<?if($bViber):?>
							<li class="social__item <?=$bImage ? 'social__item--image '.$arItem['ICON_CLASS'] : ''?> hide_on_desktop">
								<a class="social__link fill-theme-hover banner-light-icon-fill menu-light-icon-fill" href="<?=$hrefMobile ? $hrefMobile : $arItem['VALUE']?>" target="_blank" rel="nofollow" title="<?=$itemTitle?>">
									<?if($bSvg):?>
										<?=TSolution::showIconSvg($arItem['ICON_CLASS'], $arItem['ICON']);?>
									<?endif;?>
								</a>
							</li>
						<?endif;?>
						<li class="social__item <?=$bImage ? 'social__item--image '.$arItem['ICON_CLASS'] : ''?> <?=$bViber ? 'hide_on_mobile' : ''?>">
							<a class="social__link fill-theme-hover banner-light-icon-fill menu-light-icon-fill" href="<?=$hrefDesktop ? $hrefDesktop : $arItem['VALUE']?>" target="_blank" rel="nofollow" title="<?=$itemTitle?>">
								<?if($bSvg):?>
									<?=TSolution::showIconSvg($arItem['ICON_CLASS'], $arItem['ICON']);?>
								<?endif;?>
							</a>
						</li>
					<?else:?>
						<?$arMoreSocial[$itemKey] = $arItem;?>
					<?endif;?>
					<?$counter++?>
				<?endif;?>
			<?endforeach;?>
		</ul>

		<?if($arMoreSocial):?>
			<div class="social__more-dots menu-light-text banner-light-text">...</div>
			<ul class="social__more">
				<?foreach($arMoreSocial as $itemKey => $arItem):?>
					<?$itemTitle = GetMessage('TEMPL_'.$itemKey);
					$hrefMobile = $hrefDesktop = '';
					$bViber = $itemKey === 'SOCIAL_VIBER';
					$bWhats = $itemKey === 'SOCIAL_WHATS';
					if($bViber){
						$hrefDesktop = strlen(trim($arItem["CUSTOM_DESKTOP"])) ? $arItem["CUSTOM_DESKTOP"] : 'viber://chat?number=+'.$arItem['VALUE'];
						$hrefMobile = strlen(trim($arItem["CUSTOM_MOBILE"])) ? $arItem["CUSTOM_MOBILE"] : 'viber://add?number='.$arItem['VALUE'];
					}
					if($bWhats){
						if( strlen(trim($arItem["CUSTOM_DESKTOP"])) ){
							$hrefDesktop = $arItem["CUSTOM_DESKTOP"];
						} else {
							$bWhatsText = !empty($arItem['ADD_TEXT']);
							$text = '';
							if($bWhatsText){
								if(defined('LANG_CHARSET') && strtolower(LANG_CHARSET) == 'windows-1251'){
									$text = iconv("windows-1251","utf-8", $arItem['ADD_TEXT']);
								} else {
									$text = $arItem['ADD_TEXT'];
								}
							}
							$whatsText = $bWhatsText ? '?text='.rawurlencode($text) : '';
							$hrefDesktop = 'https://wa.me/'.$arItem['VALUE'].$whatsText;
						}
					}
					?>
					<?if($bViber):?>
						<li class="social__item <?=$bImage ? 'social__item--image '.$arItem['ICON_CLASS'] : ''?> hide_on_desktop">
							<a class="social__link fill-theme-hover" href="<?=$hrefMobile ? $hrefMobile : $arItem['VALUE']?>" target="_blank" rel="nofollow" title="<?=$itemTitle?>">
								<?if($bSvg):?>
									<?=TSolution::showIconSvg($arItem['ICON_CLASS'], $arItem['ICON']);?>
								<?endif;?>
							</a>
						</li>
					<?endif;?>
					<li class="social__item <?=$bImage ? 'social__item--image '.$arItem['ICON_CLASS'] : ''?> <?=$bViber ? 'hide_on_mobile' : ''?>">
						<a class="social__link fill-theme-hover" href="<?=$hrefDesktop ? $hrefDesktop : $arItem['VALUE']?>" target="_blank" rel="nofollow" title="<?=$itemTitle?>">
							<?if($bSvg):?>
								<?=TSolution::showIconSvg($arItem['ICON_CLASS'], $arItem['ICON']);?>
							<?endif;?>
						</a>
					</li>
				<?endforeach;?>
			</ul>
		<?endif;?>
	</div>
	<?if($arParams['WRAPPER']):?>
		</div>
	<?endif;?>
	<!-- /noindex -->
<?endif;?>
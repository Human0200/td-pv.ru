<div class="banners-big__side-items banners-big__side-items--right">
	<?foreach($arResult['ITEMS'][$arParams['BANNER_TYPE_THEME_CHILD']]['ITEMS'] as $key => $arItem) {
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		$bannerColor = $arItem['PROPERTIES']['MAIN_COLOR']['VALUE'] ? $arItem['PROPERTIES']['MAIN_COLOR']['VALUE_XML_ID'] : 'dark';
		?>
		<div class="banners-big__side-item banners-big__side-item--height-50 banners-big__side-item--<?=$bannerColor?> <?=$arItem["PROPERTIES"]["BANNER_SIZE"]["VALUE_XML_ID"];?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<div class="banners-big__side-item-image" style="background-image:url(<?=($arItem["DETAIL_PICTURE"]["SRC"] ? $arItem["DETAIL_PICTURE"]["SRC"] : $arItem["PREVIEW_PICTURE"]["SRC"]);?>)"></div>
		
			<?$isUrl=(strlen($arItem["PROPERTIES"]["LINKIMG"]["VALUE"]) ? true : false);?>
			<?if($isUrl):?>
				<a href="<?=$arItem["PROPERTIES"]["LINKIMG"]["VALUE"]?>" class="banners-big__side-item-link" title="<?=$arItem["FORMAT_NAME"];?>" <?=($arItem["PROPERTIES"]["TARGETS"]["VALUE_XML_ID"] ? "target='".$arItem["PROPERTIES"]["TARGETS"]["VALUE_XML_ID"]."'" : "");?>>
			<?endif;?>

			<?if($arItem["PROPERTIES"]["TEXT_POSITION"]["VALUE_XML_ID"] != "image"):?>
				<?$arItem["FORMAT_NAME"]=strip_tags($arItem["~NAME"]);?>
				
				<?$class_position_block = $class_text_block = '';
				if(isset($arItem["PROPERTIES"]["TEXT_POSITION"]) && $arItem["PROPERTIES"]["TEXT_POSITION"]["VALUE_XML_ID"])
					$class_position_block = $arItem["PROPERTIES"]["TEXT_POSITION"]["VALUE_XML_ID"].'_blocks';
				if(isset($arItem["PROPERTIES"]["TEXTCOLOR"]) && $arItem["PROPERTIES"]["TEXTCOLOR"]["VALUE_XML_ID"])
					$class_text_block = $arItem["PROPERTIES"]["TEXTCOLOR"]["VALUE_XML_ID"].'_text';
				?>
				<div class="banners-big__side-item-text-wrapper <?=$class_position_block;?> <?=$class_text_block;?>">
					<?if(strlen($arItem['PROPERTIES']['TOP_TEXT']['VALUE'])):?>
						<div class="banners-big__side-item-top-text"><?=$arItem['PROPERTIES']['TOP_TEXT']['VALUE']?></div>
					<?endif?>
					<div class="banners-big__side-item-title switcher-title"><?=$arItem['NAME']?></div>
				</div>
			<?endif;?>
			
			<?if($isUrl):?>
				</a>
			<?endif;?>
		</div>
	<?}?>
</div>
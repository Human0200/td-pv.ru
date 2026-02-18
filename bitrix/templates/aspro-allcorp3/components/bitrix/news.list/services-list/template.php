<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();
$this->setFrameMode(true);
use \Bitrix\Main\Localization\Loc;

$bItemsTypeElements = $arParams['ITEMS_TYPE'] !== 'SECTIONS';
$arItems = $bItemsTypeElements ? $arResult['ITEMS'] : $arResult['SECTIONS'];
?>
<?if($arItems):?>
	<?
	$bShowTitle = $arParams['TITLE'] && $arParams['SHOW_TITLE'];
	$bShowTitleLink = $arParams['RIGHT_TITLE'] && $arParams['RIGHT_LINK'];
	$bShowLeftBlock = $arParams['HIDE_LEFT_TEXT_BLOCK'] === 'N';

	$bIcons = $arParams['IMAGES'] === 'ICONS';
	$bFonImg = $arParams['IMAGE_POSITION'] === 'BG';
	$bSRLImg = $arParams['IMAGE_POSITION'] === 'SIDE' || $arParams['IMAGE_POSITION'] === 'RIGHT' || $arParams['IMAGE_POSITION'] === 'LEFT';
	$bTRLImg = $arParams['IMAGE_POSITION'] === 'TOP_LEFT' || $arParams['IMAGE_POSITION'] === 'TOP_RIGHT';
	$bRSImg = $arParams['IMAGE_POSITION'] === 'RIGHT' || $arParams['IMAGE_POSITION'] === 'SIDE';
	$bImgSticky = $arParams['STICKY_IMAGES'] === 'Y';
	$bNarrow = $arParams['NARROW'] && ($bShowLeftBlock || !$bSRLImg);

	$bOrderViewBasket = $arParams['ORDER_VIEW'];

	$btnClass = '';

	$blockClasses = ($arParams['ITEMS_OFFSET'] ? 'services-list--items-offset' : 'services-list--items-close');
	if($bSRLImg){
		$blockClasses .= ' services-list--img-srl';
	}
	if($bTRLImg){
		$blockClasses .= ' services-list--img-trl';
	}
	if($arParams['IMAGE_POSITION'] === 'SIDE'){
		$blockClasses .= ' services-list--img-side';
	}

	$gridClass = ['grid-list'];
	if($arParams['MOBILE_SCROLLED']){
		$gridClass[] = 'mobile-scrolled mobile-scrolled--items-2';

		if ($bNarrow) {
			$gridClass[] = 'mobile-offset';

			if (!$arParams['ITEMS_OFFSET']) {
				$gridClass[] = 'mobile-offset--right';
			}
		} else if ($arParams['ITEMS_OFFSET']) {
			$gridClass[] = 'mobile-offset';
		}
	}
	if(!$arParams['ITEMS_OFFSET']){
		$gridClass[] = 'grid-list--no-gap';
	}
	if($bNarrow){
		$gridClass[] = 'grid-list--items-'.$arParams['ELEMENTS_ROW'];
	}
	else{
		$gridClass[] = 'grid-list--wide grid-list--items-'.$arParams['ELEMENTS_ROW'].'-wide';
	}
	if($bSRLImg){
		$gridClass[] = 'grid-list--no-gap-f601';
	}

	$itemWrapperClasses = ' grid-list__item stroke-theme-parent-all colored_theme_hover_bg-block animate-arrow-hover';
	if(!$arParams['ITEMS_OFFSET'] && $arParams['BORDER']){
		$itemWrapperClasses .= ' grid-list-border-outer';
	}
	if(!$bFonImg){
		$itemWrapperClasses .= ' color-theme-parent-all';
	}
	if($bSRLImg){
		if(!$bShowLeftBlock){
			if($arParams['NARROW']){
				$itemWrapperClasses .= ' services-list__wrapper--padding';
			}
			else{
				$itemWrapperClasses .= ' services-list__wrapper--border-bottom';
			}
		}
	}

	$itemClasses = 'height-100 flexbox';
	if($arParams['ROW_VIEW']){
		if(
			$arParams['IMAGE_POSITION'] !== 'LEFT' &&
			$arParams['IMAGE_POSITION'] !== 'TOP_LEFT'
		){
			$itemClasses .= ' flexbox--direction-row-reverse';
		}
		else{
			$itemClasses .= ' flexbox--direction-row';
		}
	}
	if($arParams['COLUMN_REVERSE']){
		$itemClasses .= ' flexbox--direction-column-reverse';
	}
	if($arParams['BORDER']){
		$itemClasses .= ' bordered';
	}
	if($arParams['ROUNDED'] && $arParams['ITEMS_OFFSET']){
		$itemClasses .= ' rounded-4';
	}
	if($arParams['ITEM_HOVER_SHADOW']){
		$itemClasses .= ' shadow-hovered shadow-no-border-hovered';
	}
	if($arParams['DARK_HOVER']){
		$itemClasses .= ' dark-block-hover';
	}
	if($bFonImg){
		$itemClasses .= ' services-list__item--has-additional-text services-list__item--has-bg';
	}
	if(!$bItemsTypeElements){
		$itemClasses .= ' services-list__item--section';
	}
	if(
		$arParams['IMAGE_POSITION'] === 'TOP' ||
		$bTRLImg
	){
		$itemClasses .= ' services-list__item--big-padding border-theme-parent-hover bg-theme-parent-hover';
		$btnClass .= ' border-theme-target bg-theme-target';
	}
	if($arParams['ELEMENTS_ROW'] == 1){
		$itemClasses .= ' services-list__item--wide';
		
		if($bShowLeftBlock){
			$itemClasses .= ' services-list__item--with-left-block';
		}
		else{
			if($bSRLImg){
				if($arParams['NARROW']){
					$itemClasses .= ' maxwidth-theme';
				}
			}
		}
	}

	if (!$arParams['MOBILE_SCROLLED']) {
		$itemClasses .= ' services-list__item--no-scrolled';
	}

	$imageWrapperClasses = 'services-list__item-image-wrapper--'.($arParams['IMAGES'] === 'TRANSPARENT_PICTURES' ? 'PICTURE' : $arParams['IMAGES']).' services-list__item-image-wrapper--'.$arParams['IMAGE_POSITION'];
	$imageClasses = $arParams['IMAGES'] === 'ROUND_PICTURES' ? 'rounded' : (($arParams['IMAGES'] === 'PICTURES' || $arParams['IMAGES'] === 'BIG_PICTURES') ? ($bSRLImg && !$arParams['NARROW'] ? '' : ($arParams['ITEMS_OFFSET'] ? 'rounded-4' : '' )) : '');
	if($arParams['IMAGE_POSITION'] === 'TOP'){
		$imageWrapperClasses .= ' no-shrinked';
	}
	if($bSRLImg){
		$imageWrapperClasses .= ' flex-1';
	}

	$gridClass = TSolution\Utils::implodeClasses($gridClass);
	?>
	<?if(!$arParams['IS_AJAX']):?>
		<div class="services-list <?=$blockClasses?> <?=$templateName?>-template">
			<?=TSolution\Functions::showTitleBlock([
				'PATH' => 'services-list',
				'PARAMS' => $arParams,
				'VISIBLE' => !$bShowLeftBlock
			]);?>

		<?if($arParams['MAXWIDTH_WRAP']):?>
			<?if($bSRLImg && !$bShowLeftBlock):?>
				<div class="maxwidth-theme maxwidth-theme--no-maxwidth-f601">
			<?elseif($bNarrow):?>
				<div class="maxwidth-theme">
			<?elseif($arParams['ITEMS_OFFSET']):?>
				<div class="maxwidth-theme maxwidth-theme--no-maxwidth">
			<?endif;?>
		<?endif;?>

		<?if($bShowLeftBlock):?>
			<?//need for showed left block?>
			<div class="flexbox flexbox--direction-row flexbox--column-t991">
				<?=TSolution\Functions::showTitleInLeftBlock([
					'PATH' => 'services-list',
					'PARAMS' => $arParams,
					'VISIBLE' => $bShowLeftBlock
				]);?>
				<div class="flex-grow-1">
		<?endif;?>

		<div class="<?=$gridClass?>">
	<?endif;?>
			<?
			$bShowImage = 
				$bFonImg ||
				$bIcons ||
				(
					$arParams['IMAGES'] !== 'TRANSPARENT_PICTURES' && 
					in_array('PREVIEW_PICTURE', $arParams['FIELD_CODE'])
				) ||
				(
					$arParams['IMAGES'] === 'TRANSPARENT_PICTURES' && 
					in_array('TRANSPARENT_PICTURE', $arParams['PROPERTY_CODE'])
				);

			$counter = 1;
			foreach($arItems as $i => $arItem):?>
				<?
				$bOrderButton = '';
				$bOrderButton = $arItem['PROPERTIES']['FORM_ORDER']['VALUE_XML_ID'] == 'YES';

				$dataItem = $bOrderViewBasket ? TSolution::getDataItem($arItem) : false;

				// edit/add/delete buttons for edit mode
				if($bItemsTypeElements){
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				}
				else{
					// edit/add/delete buttons for edit mode
					$arSectionButtons = CIBlock::GetPanelButtons($arItem['IBLOCK_ID'], 0, $arItem['ID'], array('SESSID' => false, 'CATALOG' => true));
					$this->AddEditAction($arItem['ID'], $arSectionButtons['edit']['edit_section']['ACTION_URL'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'SECTION_EDIT'));
					$this->AddDeleteAction($arItem['ID'], $arSectionButtons['edit']['delete_section']['ACTION_URL'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'SECTION_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				}

				// use detail link?
				$bDetailLink = $arParams['SHOW_DETAIL_LINK'] != 'N' && (!strlen($arItem['DETAIL_TEXT']) ? ($arParams['HIDE_LINK_WHEN_NO_DETAIL'] !== 'Y' && $arParams['HIDE_LINK_WHEN_NO_DETAIL'] != 1) : true);

				// detail url
				$detailUrl = $bItemsTypeElements ? $arItem['DETAIL_PAGE_URL'] : $arItem['SECTION_PAGE_URL'];

				// preview text
				$previewText = $bItemsTypeElements ? $arItem['FIELDS']['PREVIEW_TEXT'] : $arItem['~UF_TOP_SEO'];
				$htmlPreviewText = '';

				// preview image
				if($bShowImage){
					if($bItemsTypeElements){
						if($bIcons){
							$nImageID = $arItem['DISPLAY_PROPERTIES']['ICON']['VALUE'];
						}
						else{
							if($arParams['IMAGES'] === 'TRANSPARENT_PICTURES'){
								$nImageID = $arItem['DISPLAY_PROPERTIES']['TRANSPARENT_PICTURE']['VALUE'];
							}
							else{
								$nImageID = is_array($arItem['FIELDS']['PREVIEW_PICTURE']) ? $arItem['FIELDS']['PREVIEW_PICTURE']['ID'] : $arItem['FIELDS']['PREVIEW_PICTURE'];
							}
						}
					}
					else{
						if($bIcons){
							$nImageID = $arItem['~UF_ICON'];
						}
						else{
							if($arParams['IMAGES'] === 'TRANSPARENT_PICTURES'){
								$nImageID = $arItem['~UF_TRANSPARENT_PICTURE'];
							}
							else{
								$nImageID = is_array($arItem['PICTURE']) ? $arItem['PICTURE']['ID'] : $arItem['~PICTURE'];
							}
						}
					}

					$imageSrc = ($nImageID ? CFile::getPath($nImageID) : SITE_TEMPLATE_PATH.'/images/svg/noimage_product.svg');
					$nImageNoticeID = is_array($arItem['FIELDS']['PREVIEW_PICTURE']) ? $arItem['FIELDS']['PREVIEW_PICTURE']['ID'] : $arItem['FIELDS']['PREVIEW_PICTURE'];
					$imageNoticeSrc = ($nImageNoticeID ? CFile::getPath($nImageNoticeID) : SITE_TEMPLATE_PATH.'/images/svg/noimage_product.svg');
				}

				$bShowPrice = $bItemsTypeElements && in_array('PRICE', $arParams['PROPERTY_CODE']) && strlen($arItem['DISPLAY_PROPERTIES']['PRICE']['VALUE']);
				$bShowBottom = ($bItemsTypeElements && $bShowPrice) || ($bRSImg);
				?>
				<div class="services-list__wrapper <?=$itemWrapperClasses?>">
					<div class="services-list__item <?=$itemClasses?> <?=($bDetailLink ? '' : 'services-list__item--cursor-initial')?> js-popup-block" id="<?=$this->GetEditAreaId($arItem['ID'])?>" <?=($bOrderViewBasket ? ' data-item="'.$dataItem.'"' : '')?> data-id="<?=$arItem['ID']?>">
						<?if($bShowImage && $imageSrc):?>
							<div class="services-list__item-image-wrapper <?=$imageWrapperClasses?>">
								<?if($bDetailLink):?>
									<a class="services-list__item-link <?=($bImgSticky ? 'sticky-block' : '')?> detail-info__image"  href="<?=$detailUrl?>" data-src="<?=$imageNoticeSrc?>">
								<?else:?>
									<span class="services-list__item-link <?=($bImgSticky ? 'sticky-block' : '')?>">
								<?endif;?>
									<?if($bIcons && $nImageID):?>
										<?$arOptions['PATH'] = $imageSrc?>
										<?$arItem["PICTURE"]["TITLE"] = $arItem['NAME'];?>
										<?$arItem["PICTURE"]["ALT"] = $arItem['NAME'];?>
										<?=CAllcorp3::showSectionSvg($arOptions, $bIcons, $arItem);?>
									<?else:?>
										<span class="services-list__item-image rounded-4 <?=$imageClasses?>" style="background-image: url(<?=$imageSrc?>);"></span>
									<?endif;?>
								<?if($bDetailLink):?>
									</a>
								<?else:?>
									</span>
								<?endif;?>

								<?if(
									$arParams['IMAGE_POSITION'] === 'TOP' ||
									(
										$bTRLImg && $arParams['IMAGES'] !== 'BIG_PICTURES'
									)
								):?>
									<?if($bDetailLink):?>
										<a class="arrow-all stroke-theme-target" href="<?=$detailUrl?>">
											<?=TSolution::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH.'/images/svg/Arrow_map.svg');?>
											<div class="arrow-all__item-line colored_theme_hover_bg-el"></div>
										</a>
									<?endif;?>
								<?endif;?>
							</div>
						<?endif;?>

						<?if($bFonImg):?>
							<?if($bDetailLink):?>
								<a class="services-list__item-link services-list__item-link--absolute" href="<?=$detailUrl?>"></a>
							<?endif;?>

							<div class="services-list__item-additional-text-wrapper">
								<div class="services-list__item-additional-text-top-part">
									<?if($arItem['SECTIONS'] && $arParams['SHOW_SECTION'] != 'N'):?>
										<div class="services-list__item-section font_13 color_light--opacity"><?=implode(', ', $arItem['SECTIONS'])?></div>
									<?endif;?>

									<div class="services-list__item-title switcher-title font_<?=$arParams['NAME_SIZE']?> color_light">
										<span><?=$arItem['NAME']?></span>

										<?if(!$bItemsTypeElements):?>
											<?if($bDetailLink):?>
												<div class="arrow-all arrow-all--light-stroke">
													<?=TSolution::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH.'/images/svg/Arrow_map.svg');?>
													<div class="arrow-all__item-line arrow-all--light-bgcolor"></div>
												</div>
											<?endif;?>
										<?endif;?>
									</div>
								</div>
							</div>
						<?endif;?>

						<div class="services-list__item-text-wrapper flexbox <?=($bShowBottom ? 'services-list__item-text-wrapper--has-bottom-part'.(($arParams['IMAGE_POSITION'] === 'TOP' || $bTRLImg) ? ' flexbox--justify-beetwen' : '') : '')?>">
							<?if($bFonImg):?>
								<?if($bDetailLink):?>
									<a class="services-list__item-link services-list__item-link--absolute" href="<?=$detailUrl?>"></a>
								<?endif;?>
							<?endif;?>

							<?if($bSRLImg && !$arParams['NARROW']):?><div class="flexbox <?=($bShowImage && $imageSrc ? 'maxwidth-theme--half flex-1' : 'maxwidth-theme')?>"><?endif;?>

							<div class="services-list__item-text-top-part <?=($bFonImg ? 'srollbar-custom scroll-deferred' : '')?> <?=($bSRLImg && !$arParams['NARROW'] && !($bShowImage && $imageSrc)) ? 'flex-1' : ''?>">
								<?if($bItemsTypeElements && $arItem['SECTIONS'] && $arParams['SHOW_SECTION'] != 'N'):?>
									<div class="services-list__item-section font_13 <?=($bFonImg ? 'color_light--opacity' : 'color_999')?>"><?=implode(', ', $arItem['SECTIONS'])?></div>
								<?endif;?>

								<div class="services-list__item-title switcher-title font_<?=$arParams['NAME_SIZE']?>">
									<?if($bDetailLink):?>
										<a class="dark_link color-theme-target js-popup-title" href="<?=$detailUrl?>"><?=$arItem['NAME']?></a>
									<?else:?>
										<span class="color_333"><?=$arItem['NAME']?></span>
									<?endif;?>

									<?if($bFonImg):?>
										<?if(!$bItemsTypeElements):?>
											<?if($bDetailLink):?>
												<a class="arrow-all  arrow-all--light-stroke" href="<?=$detailUrl?>">
													<?=TSolution::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH.'/images/svg/Arrow_map.svg');?>
													<div class="arrow-all__item-line arrow-all--light-bgcolor"></div>
												</a>
											<?endif;?>
										<?endif;?>
									<?elseif($arParams['IMAGE_POSITION'] === 'TOP_LEFT'):?>
										<?if($bDetailLink):?>
											<?if($arParams['ELEMENTS_ROW'] == 1):?>
												<a class="arrow-all arrow-all--wide stroke-theme-target" href="<?=$detailUrl?>">
													<?=TSolution::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH.'/images/svg/Arrow_lg.svg');?>
													<div class="arrow-all__item-line colored_theme_hover_bg-el"></div>
												</a>
											<?else:?>
												<a class="arrow-all stroke-theme-target" href="<?=$detailUrl?>">
													<?=TSolution::showIconSvg(' arrow-all__item-arrow', SITE_TEMPLATE_PATH.'/images/svg/Arrow_map.svg');?>
													<div class="arrow-all__item-line colored_theme_hover_bg-el"></div>
												</a>
											<?endif;?>
										<?endif;?>
									<?endif;?>
								</div>

								<?if(
									in_array('PREVIEW_TEXT', $arParams['FIELD_CODE']) &&
									$arParams['SHOW_PREVIEW'] &&
									strlen($previewText)
								):?>
									<?ob_start()?>
										<div class="services-list__item-preview-wrapper">
											<div class="services-list__item-preview font_15 <?=($bFonImg ? 'color_light--opacity' : 'color_666')?>">
												<?=$previewText?>
											</div>
										</div>
									<?$htmlPreviewText = ob_get_clean()?>
									<?if($bItemsTypeElements):?>
										<?=$htmlPreviewText?>
									<?endif;?>
								<?endif;?>

								<?if(
									$bItemsTypeElements &&
									($arItem['MIDDLE_PROPS'] || $arItem['FORMAT_PROPS'])
								):?>
									<?if(array_key_exists('MIDDLE_PROPS', $arItem) && $arItem['MIDDLE_PROPS']):?>
										<?ob_start()?>
										<?foreach($arItem['MIDDLE_PROPS'] as $PCODE => $arProperty):?>
											<div class="services-list__item-properties-item-wraper">
												<div class="services-list__item-properties-item <?=($bFonImg ? 'color_light--opacity' : 'color_333')?>" data-code="<?=strtolower($PCODE)?>">
													<div class="services-list__item-properties-item-name"><?=$arProperty['NAME']?>:&nbsp;</div>
													<div class="services-list__item-properties-item-value">
														<?if($PCODE === 'SITE'):?>
															<!--noindex-->
															<a href="<?=(strpos($arProperty['VALUE'], 'http') === false ? 'http://' : '').$arProperty['VALUE'];?>" rel="nofollow" target="_blank" class="dark-link">
																<?=strpos($arProperty['VALUE'], '?') === false ? $arProperty['VALUE'] : explode('?', $arProperty['VALUE'])[0]?>
															</a>
															<!--/noindex-->
														<?elseif($PCODE === 'EMAIL'):?>
															<a href="mailto:<?=$arProperty['VALUE']?>"><?=$arProperty['VALUE']?></a>
														<?elseif($PCODE === 'PHONE'):?>
															<a href="tel:<?=str_replace(array('+', ' ', ',', '-', '(', ')'), '', $arProperty['VALUE'])?>" class="dark-color"><?=$arProperty['VALUE']?></a>
														<?else:?>
															<?=$arProperty['VALUE']?>
														<?endif;?>
													</div>
												</div>
											</div>
										<?endforeach;?>
										<?$htmlMiddleProperties = ob_get_clean()?>

										<?if(trim($htmlMiddleProperties)):?>
											<div class="services-list__item-properties services-list__item-properties--middle font_14"><?=$htmlMiddleProperties?></div>
										<?endif;?>
									<?endif?>

									<?if(array_key_exists('FORMAT_PROPS', $arItem) && $arItem['FORMAT_PROPS']):?>
										<?ob_start()?>
											<?foreach($arItem['FORMAT_PROPS'] as $PCODE => $arProperty):?>
												<div class="services-list__item-properties-item-wraper">
													<div class="services-list__item-properties-item <?=($bFonImg ? 'color_light--opacity' : 'color_333')?>" data-code="<?=strtolower($PCODE)?>">
														<span class="services-list__item-properties-item-name"><?=$arProperty['NAME']?>:&nbsp;</span>
														<?if(is_array($arProperty['DISPLAY_VALUE'])):?>
															<?$val = implode('&nbsp;/&nbsp;', $arProperty['DISPLAY_VALUE']);?>
														<?else:?>
															<?$val = $arProperty['DISPLAY_VALUE'];?>
														<?endif;?>
														<span class="services-list__item-properties-item-value"><?=$val?></span>
													</div>
												</div>
											<?endforeach;?>
										<?$htmlProperties = ob_get_clean()?>

										<?if(trim($htmlProperties)):?>
											<div class="services-list__item-properties font_14"><?=$htmlProperties?></div>
										<?endif;?>
									<?endif?>
								<?endif;?>

								<?if(
									!$bItemsTypeElements &&
									$arItem['CHILD']
								):?>
									<div class="services-list__item-childs font_15">
										<ul class="list-unstyled">
											<?$i = 0;?>
											<?foreach($arItem['CHILD'] as $arChild):?>
												<li class="services-list__item-childs-item-wraper">
													<?
														if(is_array($arChild['DETAIL_PAGE_URL'])){
															if(isset($arChild['CANONICAL_PAGE_URL']) && !empty($arChild['CANONICAL_PAGE_URL'])){
																$arChild['DETAIL_PAGE_URL'] = $arChild['CANONICAL_PAGE_URL'];
															}
															else{
																$arChild['DETAIL_PAGE_URL'] = $arChild['DETAIL_PAGE_URL'][key($arChild['DETAIL_PAGE_URL'])];
															}
														}
													?>
													<?$bShowChildDetail = $arChild['SECTION_PAGE_URL'] || ($arParams['SHOW_ELEMENTS_DETAIL_LINK'] != 'N' && (!strlen($arChild['DETAIL_TEXT']) ? ($arParams['HIDE_ELEMENTS_LINK_WHEN_NO_DETAIL'] !== 'Y' && $arParams['HIDE_ELEMENTS_LINK_WHEN_NO_DETAIL'] != 1) : true));?>
													<?if($bShowChildDetail):?>
														<a class="services-list__item-childs-item <?=($bFonImg ? 'dark_link color_light--opacity' : '')?>" href="<?=($arChild['DETAIL_PAGE_URL'] ? $arChild['DETAIL_PAGE_URL'] : $arChild['SECTION_PAGE_URL'])?>">
													<?else:?>
														<span class="services-list__item-childs-item <?=($bFonImg ? 'dark_link color_light--opacity' : '')?>">
													<?endif;?>

														<span class="services-list__item-childs-item-name"><?=$arChild['NAME']?></span>
														<?if(++$i < (count($arItem['CHILD']))):?>
															<span class="services-list__item-childs-item-separator">&mdash;</span>
														<?endif;?>

													<?if($bShowChildDetail):?>
														</a>
													<?else:?>
														</span>
													<?endif;?>
												</li>
											<?endforeach;?>
										</ul>
									</div>
								<?endif;?>

								<?if(!$bItemsTypeElements):?>
									<?=$htmlPreviewText?>
								<?endif;?>
							</div>

							<?if($bShowBottom):?>
								<div class="services-list__item-text-bottom-part <?=($bShowPrice ? 'services-list__item-text-bottom-part--has-price' : '')?>">
									<div class='<?=$arParams['IMAGE_POSITION'] == 'BG' ? 'flexbox--justify-beetwen line-block line-block--flex-wrap line-block--gap line-block--gap-12' : ''?>'>	
										<?if($bShowPrice):?>
											<div class="services-list__item-price-wrapper line-block__item">
												<div class="services-list__item-price font_17 <?=($bFonImg ? 'color_light' : 'color_333')?>">
													<?=TSolution\Functions::showPrice([
														'ITEM' => $arItem,
														'PARAMS' => $arParams,
														'SHOW_SCHEMA' => false,
														'PRICE_BLOCK_CLASS' => ($bFonImg ? 'color_light' : 'color_333')
													]);?>
												</div>
											</div>
										<?endif;?>

										<div class="services-list__item-order-btns <?=$arParams['IMAGE_POSITION'] !== 'BG' ? 'services-list__item-order-btns--margin-top': '' ?> <?=$bRSImg ? 'line-block line-block--gap line-block--gap-16' : ''?>">
											<div class="buy_block">
												<?if ($bOrderButton):?>
													<?if($arParams['IMAGE_POSITION'] === 'TOP') {
														$btnClass .= ' btn-transparent-border btn-wide';
													}
													if($arParams['IMAGE_POSITION'] == 'BG') {
														$btnClass .= ' btn-sm';
													} elseif($bRSImg) {
														$btnClass .= ' btn-lg';
													}
													?>
													<?=TSolution\Functions::showBasketButton([
														'ITEM' => $arItem,
														'PARAMS' => $arParams,
														'BASKET' => (isset($arParams['ORDER_BASKET']) ? $arParams['ORDER_BASKET'] : $bOrderViewBasket),
														'ORDER_BTN' => $bOrderButton,
														'BTN_CLASS' => $btnClass,
														'BTN_IN_CART_CLASS' => $btnClass,
														'TO_ORDER_TEXT' => ($arParams['S_ORDER_SERVISE'] ? $arParams['S_ORDER_SERVISE'] : Loc::getMessage('S_ORDER_SERVISE')),
														'ORDER_FORM_ID' => $arParams["FORM_ID_ORDER_SERVISE"],
														'SHOW_COUNTER' => false,
													]);?>
												<?endif;?>
											</div>
											<?if($bRSImg):?>
												<?if($bDetailLink):?>
													<a class="btn btn-lg btn-transparent-border more" href="<?=$detailUrl?>"><?=Loc::getMessage('SHOW_MORE')?></a>
												<?endif;?>
											<?endif;?>
										</div>
									</div>
								</div>
							<?endif;?>

							<?if($bSRLImg && !$arParams['NARROW']):?></div><?endif;?>
						</div>
					</div>
				</div>
			<?
			$counter++;
			endforeach;?>

			<?if($arParams['IS_AJAX']):?>
				<div class="wrap_nav bottom_nav_wrapper">
					<script>InitScrollBar();</script>
			<?endif;?>
				<?$bHasNav = (strpos($arResult["NAV_STRING"], 'more_text_ajax') !== false);?>
				<div class="bottom_nav mobile_slider <?=($bHasNav ? '' : ' hidden-nav');?>" data-parent=".services-list" data-append=".grid-list" <?=($arParams["IS_AJAX"] ? "style='display: none; '" : "");?>>
					<?if($bHasNav):?>
						<?=$arResult["NAV_STRING"]?>
					<?endif;?>
				</div>

			<?if($arParams['IS_AJAX']):?>
				</div>
			<?endif;?>

	<?if(!$arParams['IS_AJAX']):?>
		</div>
	<?endif;?>

		<?// bottom pagination?>
		<?if($arParams['IS_AJAX']):?>
			<div class="wrap_nav bottom_nav_wrapper">
		<?endif;?>

		<div class="bottom_nav_wrapper nav-compact">
			<div class="bottom_nav hide-600" <?=($arParams['IS_AJAX'] ? "style='display: none; '" : "");?> data-parent=".services-list" data-append=".grid-list">
				<?if($arParams['DISPLAY_BOTTOM_PAGER']):?>
					<?=$arResult['NAV_STRING']?>
				<?endif;?>
			</div>
		</div>

		<?if($arParams['IS_AJAX']):?>
			</div>
		<?endif;?>

	<?if(!$arParams['IS_AJAX']):?>
		<?if($bShowLeftBlock):?>
				</div> <?// .flex-grow-1?>
			</div> <?// .flexbox?>
		<?endif;?>

		<?if($arParams['MAXWIDTH_WRAP']):?>
			<?if($bSRLImg):?>
				</div>
			<?elseif($bNarrow):?>
				</div>
			<?elseif($arParams['ITEMS_OFFSET']):?>
				</div>
			<?endif;?>
		<?endif;?>

		</div> <?// .services-list?>
	<?endif;?>
<?endif;?>
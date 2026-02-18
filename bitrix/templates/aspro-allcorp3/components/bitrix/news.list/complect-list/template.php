<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

use \Bitrix\Main\Localization\Loc;

$arItems = $arResult['ITEMS'];

$bSlider = $arParams['SLIDER'] === true || $arParams['SLIDER'] === 'Y';
$bNarrow = $arParams['NARROW'];

$cntVisibleChars = intval($arParams['VISIBLE_PROP_COUNT']);
$cntVisibleChars = $cntVisibleChars >= 0 ? $cntVisibleChars : 4;

$bOrderViewBasket = $arParams['ORDER_VIEW'];
$basketURL = (strlen(trim($arTheme['ORDER_VIEW']['DEPENDENT_PARAMS']['URL_BASKET_SECTION']['VALUE'])) ? trim($arTheme['ORDER_VIEW']['DEPENDENT_PARAMS']['URL_BASKET_SECTION']['VALUE']) : '');

$bShowImage = in_array('PREVIEW_PICTURE', $arParams['FIELD_CODE']);

$bMobileScrolledItems = (!isset($arParams['MOBILE_SCROLLED']) ||
	($arParams['MOBILE_SCROLLED'] === true || $arParams['MOBILE_SCROLLED'] === 'Y'));

if ($bSlider) {
	$bDots1200 = $arParams['DOTS_1200'] === 'Y' ? 1 : 0;
	if ($arParams['ITEM_1200']) {
		$items1200 = intval($arParams['ITEM_1200']);
	} else {
		$items1200 = $arParams['ELEMENTS_ROW'] ? $arParams['ELEMENTS_ROW'] : 1;
	}

	$bDots768 = 1;
	if ($arParams['ITEM_768']) {
		$items768 = intval($arParams['ITEM_768']);
	} else {
		$items768 =
			$arParams['ELEMENTS_ROW'] > 1 ? 2 : 1;
	}

	$bDots380 = 1;
	if ($arParams['ITEM_380']) {
		$items380 = intval($arParams['ITEM_380']);
	} else {
		$items380 = 1;
	}

	$bDots0 = $arParams['DOTS_0'] === 'Y' ? 1 : 0;
	if ($arParams['ITEM_0']) {
		$items0 = intval($arParams['ITEM_0']);
	} else {
		$items0 = 1;
	}

	$owlClasses = ' owl-carousel--light owl-carousel--items-width-360-adaptive owl-carousel--wide-adaptive owl-carousel--outer-dots owl-carousel--buttons-bordered owl-carousel--button-wide owl-carousel--items-' . $arParams['ELEMENTS_ROW'];
	if ($arParams['NARROW']) {
		$owlClasses .= ' owl-carousel--button-offset-half';
	} else {
		$owlClasses .= ' owl-carousel--button-offset-none';
	}

	if (!$arParams['NARROW']) {
		$owlClasses .= ' owl-carousel--wide-view owl-carousel--buttons-size-48';
	}
	if ($arParams['BORDER']) {
		$owlClasses .= ' owl-carousel--after-offset-1';
	}
	if (!$arParams['ITEMS_OFFSET']) {
		$owlClasses .= ' owl-carousel--no-gap';
	}
	if ($arParams['ITEM_HOVER_SHADOW'] !== false) {
		$owlClasses .= ' owl-carousel--with-shadow';
	}
	if (!$arParams['IS_AJAX']) {
		$owlClasses .= ' appear-block';
	}
} else {
	$gridClass = ['grid-list'];
	if ($arParams['MOBILE_SCROLLED']) {
		$gridClass[] = 'mobile-scrolled mobile-scrolled--items-2';

		if ($arParams['NARROW']) {
			$gridClass[] = 'mobile-offset';

			if (!$arParams['ITEMS_OFFSET']) {
				$gridClass[] = 'mobile-offset--right';
			}
		} else if ($arParams['ITEMS_OFFSET']) {
			$gridClass[] = 'mobile-offset';
		}
	}
	if (!$arParams['ITEMS_OFFSET']) {
		$gridClass[] = 'grid-list--no-gap';
	} elseif ($arParams['GRID_GAP']) {
		$gridClass[] = 'grid-list--gap-' . $arParams['GRID_GAP'];
	}
	if ($arParams['NARROW']) {
		$gridClass[] = 'grid-list--items-' . $arParams['ELEMENTS_ROW'];
	} else {
		$gridClass[] = 'grid-list--wide grid-list--items-' . $arParams['ELEMENTS_ROW'] . '-wide';
	}

	$gridClass = TSolution\Utils::implodeClasses($gridClass);
}

$itemWrapperClasses = ' grid-list__item';
if (!$arParams['ITEMS_OFFSET'] && $arParams['BORDER']) {
	$itemWrapperClasses .= ' grid-list-border-outer';
}

$itemWrapperClasses .= ' color-theme-parent-all';

$itemClasses = 'height-100 flexbox bg-theme-parent-hover border-theme-parent-hover';
if ($arParams['ROW_VIEW']) {
	$itemClasses .= ' flexbox--direction-row';
}
if ($arParams['COLUMN_REVERSE']) {
	$itemClasses .= ' flexbox--direction-column-reverse';
}
if ($arParams['BORDER']) {
	$itemClasses .= ' bordered';
}
if ($arParams['ROUNDED']) {
	if (
		$arParams['ITEMS_OFFSET'] ||
		$arParams['ROW_VIEW']
	) {
		$itemClasses .= ' rounded-4';
	}
}
if ($arParams['ITEM_HOVER_SHADOW']) {
	$itemClasses .= ' shadow-hovered shadow-no-border-hovered';
}
if ($arParams['ELEMENTS_ROW'] == 1) {
	$itemClasses .= ' complects-list__item--wide';
}

$valY = TSolution::showIconSvg('tariff-yes fill-theme-target', SITE_TEMPLATE_PATH . '/images/svg/tariff_yes.svg');
$valN = TSolution::showIconSvg('tariff-no fill-theme-target', SITE_TEMPLATE_PATH . '/images/svg/tariff_no.svg');
$navPageNomer = $arResult['NAV_RESULT']->{'NavPageNomer'};
?>

<? if (!$arParams['IS_AJAX']) : ?>
	<div class="complects-list <?= $blockClasses ?> <?= $templateName ?>-template">

		<? if ($arParams['MAXWIDTH_WRAP']) : ?>
			<? if ($arParams['NARROW']) : ?>
				<div class="maxwidth-theme">
				<? elseif ($arParams['ITEMS_OFFSET'] && !$bSlider) : ?>
					<div class="maxwidth-theme maxwidth-theme--no-maxwidth">
					<? endif; ?>
				<? endif; ?>
			<? endif; ?>

			<? if ($navPageNomer < 2) : ?>
				<? if ($bSlider) : ?>
					<div class="owl-carousel <?= $owlClasses ?>" data-plugin-options='{"nav": true, "rewind": true, "dots": true, "dotsContainer": false, "loop": false, "autoplay": false, "marginMove": true, "margin": <?= ($arParams['ITEMS_OFFSET'] ? ($arParams['GRID_GAP'] ? $arParams['GRID_GAP'] : "32") : ($arParams['BORDER'] ? "-1" : "0")) ?>, "responsive": {"0": {"autoWidth": true, "lightDrag": true, "dots": <?= $bDots0 ?>, "items": <?= $items0 ?> <?= ($arParams['ITEMS_OFFSET'] ? ', "margin": 24' : '') ?>}, "380": {"autoWidth": true, "lightDrag": true, "dots": <?= $bDots380 ?>, "items": <?= $items380 ?> <?= ($arParams['ITEMS_OFFSET'] ? ', "margin": 24' : '') ?>}, "768": {"autoWidth": false, "lightDrag": false, "dots": <?= $bDots768 ?>, "items": <?= $items768 ?>}, "1200": {"autoWidth": false, "lightDrag": false, "dots": <?= $bDots1200 ?>, "items": <?= $items1200 ?>} }}'>
					<? else : ?>
						<div class="<?= $gridClass ?>">
						<? endif; ?>
					<? endif; ?>

					<? foreach ($arItems as $i => $arItem) : ?>
						<?
						// edit/add/delete buttons for edit mode
						$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
						$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

						// use order button?
						$dataItem = ($bOrderViewBasket ? TSolution::getDataItem($arItem) : false);
						$bOrderButton = ($arItem['PROPERTIES']['FORM_ORDER']['VALUE_XML_ID'] === 'YES');

						$bShowPrice = $arItem['PRICES'];
						$bShowBottom = $bShowPrice || $bOrderButton;

						?>
						<div class="complects-list__wrapper <?= $itemWrapperClasses ?>">
							<div class="complects-list__item js-popup-block <?= $itemClasses ?>" data-type="SERVICES" id="<?= $this->GetEditAreaId($arItem['ID']) ?>">
								<? if ($arItem['IMAGES']) : ?>
									<div class="complects-list__item-image-wrapper">
										<div class="line-block line-block--20 line-block--20-vertical">
											<? foreach ($arItem['IMAGES'] as $key => $arImage) : ?>
												<div class="line-block__item">
													<img src="<?= $arImage['RESIZED_SRC'] ?>" alt="<?= ($arImage['DESCRIPTION'] ?? $arItem['NAME']); ?>" />
												</div>
											<? endforeach; ?>
										</div>
									</div>
								<? endif; ?>
								<div class="complects-list__item-title switcher-title font_20">
									<span class="color_333"><?= strip_tags($arItem["~NAME"], "<br><br/>"); ?></span>
								</div>

								<div class="complects-list__item-text-wrapper flexbox" data-id="<?= $arItem['ID'] ?>" <?= ($bOrderViewBasket ? ' data-item="' . $dataItem . '"' : '') ?>>
									<?if ($arItem['LINK_COMPLECT'] || $arItem['LINK_SERVICES']):?>
										<?$currency = $arItem['DISPLAY_PROPERTIES']['PRICE_CURRENCY']['VALUE'];?>
										<div class="complects-list__item-text-top-part text-complect" data-currency="<?=$currency;?>">
											<? if ($arItem['LINK_COMPLECT']):?>
												<div class="complects-list__item-properties-wraper">
													<div class="complects-list__item-properties-title color_333 font_14 bold text-complect__title"><?= $arItem['DISPLAY_PROPERTIES']['LINK_COMPLECT']['NAME'] ?></div>
													<? foreach ($arItem['LINK_COMPLECT'] as $arProperty) : ?>																											
														<div class="complects-list__item-properties color_333 complect-props">
															<div class="line-block line-block--align-normal line-block--20 line-block--20-vertical">
																<div class="line-block__item complect-props__name">
																	<span class="complect-props__inner font_13 complect-props__inner--icons"><?= $arProperty['UF_NAME'] ?></span>
																</div>
																<div class="line-block__item complect-props__value">
																	<span class="complect-props__inner font_13 text-right">
																		<?= TSolution\Functions::showPrice(['ITEM' => $arProperty, 'PARAMS' => $arParams, 'PRICE_FONT' => 13, 'SHOW_SCHEMA' => false]) ?>
																	</span>
																</div>
															</div>
														</div>
													<? endforeach; ?>
												</div>												
											<?endif;?>
											<?if ($arItem['LINK_SERVICES']):?>
												<div class="services-complect">
													<div class="services-complect__title color_333 font_14 bold text-complect__title">
														<?= $arItem['DISPLAY_PROPERTIES']['LINK_SERVICES']['NAME'] ?>
														<?if ($arItem['DISPLAY_PROPERTIES']['LINK_SERVICES']['HINT']):?>
															<span class="hint">
																<span class="hint__icon rounded bg-theme-hover border-theme-hover bordered muted"><i>?</i></span>
																<div class="tooltip" style=""><?= $arItem['DISPLAY_PROPERTIES']['LINK_SERVICES']['HINT'] ?></div>
															</span>
														<?endif;?>
													</div>
													<? foreach ($arItem['LINK_SERVICES'] as $arService) : ?>
														<div class="complects-list__item-properties color_333 complect-props">
															<div class="line-block line-block--align-normal line-block--20 line-block--10-vertical">
																<?
																$arService['ID'] .= '_'.$arItem['ID'];
																$arService['PARENT_ID'] = $arItem['ID'];
																$price = ($arService['PROPERTY_FILTER_PRICE_VALUE'] ?? TSolution\Functions::clearPriceFromString($arService['PROPERTY_PRICE_VALUE']));
																$priceOld = (TSolution\Functions::clearPriceFromString ($arService['PROPERTY_PRICEOLD_VALUE']??$arService['PROPERTY_PRICE_VALUE']));
																?>
																<div class="line-block__item complect-props__name"  <?= ($bOrderViewBasket ? ' data-item="' . TSolution::getDataItem($arService) . '"' : '') ?> data-id="<?=$arService['ID'];?>">
																	<span class="toggle-checkbox" data-price="<?=$price?>" data-oldprice="<?=$priceOld?>">
																		<input type="checkbox" name="buy_services_<?=$arService['ID'];?>" id="buy_services_<?=$arService['ID'];?>" class="toggle-checkbox__input">
																		<label for="buy_services_<?=$arService['ID'];?>" class="toggle-checkbox__label"></label>
																	</span>
																	<a href="<?=$arService['DETAIL_PAGE_URL'];?>" class="complect-props__inner font_13 complect-props__toggle"><?= $arService['NAME'] ?></a>
																</div>
																<div class="line-block__item complect-props__value">
																	<span class="font_13 text-right">
																		<?= TSolution\Functions::showPrice(['ITEM' => $arService, 'PARAMS' => $arParams, 'PRICE_FONT' => 13, 'SHOW_SCHEMA' => false]) ?>
																	</span>
																</div>
															</div>
														</div>
													<? endforeach; ?>
												</div>
											<?endif;?>
										</div>
									<?endif;?>
									<? if ($bShowBottom) : ?>
										<div class="complects-list__item-text-bottom-part">
											<?TSolution\Functions::showPrice(['ITEM' => $arItem, 'PARAMS' => $arParams, 'SHOW_SCHEMA' => false, 'PRICE_FONT' => '22']); ?>
											<? if ($bOrderButton) : ?>
												<div class="complects-list__item_buttons">
													<?= TSolution\Functions::showBasketButton([
														'ITEM' => $arItem,
														'PARAMS' => $arParams,
														'BASKET_URL' => $basketURL,
														'BASKET' => $bOrderViewBasket,
														'ORDER_BTN' => $bOrderButton,
														'BTN_CLASS' => 'bg-theme-target border-theme-target btn-sm btn-wide opt_action',
														'BTN_IN_CART_CLASS' => ' btn-sm btn-wide',
														'SHOW_COUNTER' => false,
														'TO_CART_TEXT' => Loc::getMessage('BUY_COMPLECT'),
													]); ?>
												</div>
											<? endif; ?>
										</div>
									<? endif; ?>
								</div>
							</div>
						</div>
					<? endforeach; ?>

					<? if (!$bSlider) : ?>
						<? if ($bMobileScrolledItems) : ?>
							<? if ($arParams['IS_AJAX'] && $navPageNomer > 1) : ?>
								<div class="wrap_nav bottom_nav_wrapper">
								<? endif; ?>
								<? $bHasNav = (strpos($arResult["NAV_STRING"], 'more_text_ajax') !== false); ?>
								<div class="bottom_nav mobile_slider <?= ($bHasNav ? '' : ' hidden-nav'); ?>" data-parent=".complects-list" data-append=".grid-list" <?= (($arParams['IS_AJAX'] && $navPageNomer > 1) ? "style='display: none; '" : ""); ?>>
									<? if ($bHasNav) : ?>
										<?= $arResult["NAV_STRING"] ?>
									<? endif; ?>
								</div>

								<? if ($arParams['IS_AJAX'] && $navPageNomer > 1) : ?>
								</div>
							<? endif; ?>
						<? endif; ?>
					<? endif; ?>

					<? if ($navPageNomer < 2) : ?>
						</div>
					<? endif; ?>

					<? // bottom pagination
					?>
					<? if ($arParams['IS_AJAX'] && $navPageNomer > 1) : ?>
						<div class="wrap_nav bottom_nav_wrapper">
						<? endif; ?>

						<div class="bottom_nav_wrapper nav-compact <?= ($bSlider ? 'hidden' : '') ?>">
							<div class="bottom_nav <?= ($bMobileScrolledItems ? 'hide-600' : ''); ?>" <?= (($arParams['IS_AJAX'] && $navPageNomer > 1) ? "style='display: none; '" : ""); ?> data-parent="<?= ($bTopTabs ? '.tab-content-block' : '.complects-list') ?>" data-append=".grid-list">
								<? if ($arParams['DISPLAY_BOTTOM_PAGER']) : ?>
									<?= $arResult['NAV_STRING'] ?>
								<? endif; ?>
							</div>
						</div>

						<? if ($arParams['IS_AJAX']) : ?>
							<script>
								$(document).ready(function() {
									setBasketItemsClasses();
									<? if ($bSlider) : ?>InitOwlSlider();
								<? endif; ?>
								});
							</script>
						<? endif; ?>

						<? if ($arParams['IS_AJAX'] && $navPageNomer > 1) : ?>
						</div>
					<? endif; ?>

					<? if (!$arParams['IS_AJAX']) : ?>
						<? if ($arParams['MAXWIDTH_WRAP']) : ?>
							<? if ($arParams['NARROW']) : ?>
					</div>
				<? elseif ($arParams['ITEMS_OFFSET'] && !$bSlider) : ?>
					</div>
				<? endif; ?>
			<? endif; ?>

				</div> <? // .complects-list
						?>
			<? endif; ?>
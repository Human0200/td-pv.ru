<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
$this->setFrameMode(true);
$colmd = 12;
$colsm = 12;

$bMenuToRow = $arParams['ROW_ITEMS'] === true;
?>
<?if($arResult):?>
	<?
	global $arTheme;
	$compactFooterMobile = $arTheme['COMPACT_FOOTER_MOBILE']['VALUE'];
	if(!function_exists("ShowSubItems2")){
		function ShowSubItems2($arItem, $indexSection){
			?>
			<?if($arItem["CHILD"]):?>
				<?$noMoreSubMenuOnThisDepth = false;
				$count = count($arItem["CHILD"]);?>
				<?$lastIndex = count($arItem["CHILD"]) - 1;?>
				<?foreach($arItem["CHILD"] as $i => $arSubItem):?>
					<?if(!$i):?>
						<div id="<?=$indexSection?>" class="wrap <?=$arParams['BOLD_ITEMS'] ? '' : 'panel-collapse'?> wrap_compact_mobile">
					<?endif;?>
						<?$bLink = strlen($arSubItem['LINK']);?>
						<div class="item-link item-link <?=$i == 0 ? 'item-link--first' : ''?> <?=$i == $lastIndex ? 'item-link--last' : ''?>">
							<div class="item<?=($arSubItem["SELECTED"] ? " active" : "")?>">
								<div class="title <?=$arParams['BOLD_ITEMS'] ? 'font_15' : 'font_13'?>">
									<?if($bLink):?>
										<a href="<?=$arSubItem['LINK']?>"><?=$arSubItem['TEXT']?></a>
									<?else:?>
										<span><?=$arSubItem['TEXT']?></span>
									<?endif;?>
								</div>
							</div>
						</div>

						<?$noMoreSubMenuOnThisDepth |= CAllcorp3::isChildsSelected($arSubItem["CHILD"]);?>
					<?if($i && $i === $lastIndex || $count == 1):?>
						</div>
					<?endif;?>
				<?endforeach;?>

			<?endif;?>
			<?
		}
	}
	?>
	<?$indexSection = $arParams['ROOT_MENU_TYPE'];?>
	<div class="bottom-menu <?=$arParams['BOLD_ITEMS'] ? 'bottom-menu--bold' : 'bottom-menu--normal'?>">
		<div class="items">

			<?if($bMenuToRow):?>
				<div class="line-block line-block--48 line-block--align-normal line-block--flex-wrap line-block--block">
			<?endif;?>

			<?$lastIndex = count($arResult) - 1;?>
			<?foreach($arResult as $i => $arItem):?>

				<?if($i === 1 && !$bMenuToRow):?>
					<div id="<?=$indexSection?>" class="wrap <?=$arParams['BOLD_ITEMS'] ? '' : 'panel-collapse wrap_compact_mobile'?> ">
				<?endif;?>
					<?$bLink = strlen($arItem['LINK']);?>
					<div class="item-link <?=$arParams['BOLD_ITEMS'] ? '' : 'accordion-close'?> <?=$bMenuToRow ? 'line-block__item' : ''?> item-link" data-parent="#<?=$indexSection?>" data-target="#<?=$indexSection?>">
						<div class="item<?=($arItem["SELECTED"] ? " active" : "")?> <?=$arParams['BOLD_ITEMS'] ? 'font_bold' : ''?>">
							<div class="title font_15 font_bold">
								<?if($bLink):?>
									<a class="dark_link" href="<?=$arItem['LINK']?>"<?=$arItem['ATTRIBUTE']?>><?=$arItem['TEXT']?></a>
								<?else:?>
									<span><?=$arItem['TEXT']?></span>
								<?endif;?>
							</div>
						</div>

						<?if( $compactFooterMobile == "Y" && ($arItem["CHILD"] || $i < 1) && !$arParams['BOLD_ITEMS'] ):?>
							<span class="fa fa-angle-down">
								<?=CAllcorp3::showIconSvg("", SITE_TEMPLATE_PATH."/images/svg/more_arrow.svg", "", "", false);?>
							</span>
						<?endif;?>
					</div>
				<?if($i && $i === $lastIndex && !$bMenuToRow):?>
					</div>
				<?endif;?>
				<?ShowSubItems2($arItem, $indexSection);?>
			<?endforeach;?>

			<?if($bMenuToRow):?>
				</div>
			<?endif;?>
		</div>
	</div>
<?endif;?>
<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();?>
<?$this->setFrameMode(true);?>
<?
$INPUT_ID = trim($arParams["~INPUT_ID"]);
if(strlen($INPUT_ID) <= 0)
	$INPUT_ID = "title-search-input";
$INPUT_ID = CUtil::JSEscape($INPUT_ID);
$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
if(strlen($CONTAINER_ID) <= 0)
	$CONTAINER_ID = "title-search";
$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);

$bFixed = $arParams['TYPE'] == 'fixed';
$type = $arParams['TYPE'] == 'fixed' ? 'big' : 'cover';
$bCoverSearch = $type === 'cover';

$inputText = GetMessage("CT_BST_SEARCH_INPUT");
$svg = 'search_lg';
?>
<?if($arParams["SHOW_INPUT"] !== "N"):?>
	<div class="inline-search-block fixed with-close inline-search-block--<?=$type;?>">
		<div class="maxwidth-theme">
			<div class="search-wrapper">
				<?if ($bCoverSearch):?>
					<div class="switcher-title search-title font_42 color_333">
						<?=GetMessage("CT_BST_SEARCH_INPUT")?>
						<?
						$inputText = GetMessage("CT_BST_SEARCH_INPUT_".$type);
						$svg = 'Search_black';
						?>
					</div>
				<?endif;?>
				<div id="<?=$CONTAINER_ID?>">
					<form action="<?=$arResult["FORM_ACTION"]?>" class="search">
						<?if($bFixed):?>
							<span class="search-icon-before">
								<?=CAllcorp3::showIconSvg('', SITE_TEMPLATE_PATH.'/images/svg/Search_black.svg')?>
							</span>
						<?endif;?>
						<div class="search-input-div">
							<input class="search-input" id="<?=$INPUT_ID?>" type="text" name="q" value="" placeholder="<?=$inputText?>" size="40" maxlength="50" autocomplete="off" />
						</div>
						<div class="search-button-div">
							<?if($bFixed):?>
								<?/*<button class="btn btn-search-full btn-default btn--no-rippple " type="submit" name="s" value="<?=GetMessage("CT_BST_SEARCH_BUTTON")?>"><?=GetMessage("CT_BST_SEARCH_BUTTON")?></button>*/?>
								<span class="jqmClose top-close stroke-theme-hover inline-search-hide" title="<?=\Bitrix\Main\Localization\Loc::getMessage('CLOSE_BLOCK');?>"><?=CAllcorp3::showIconSvg('', SITE_TEMPLATE_PATH.'/images/svg/Close.svg')?></span>
							<?else:?>
								<button class="btn btn-search btn--no-rippple" type="submit" name="s" title="<?=GetMessage("CT_BST_SEARCH_BUTTON")?>" value="<?=GetMessage("CT_BST_SEARCH_BUTTON")?>">
									<?=CAllcorp3::showIconSvg('', SITE_TEMPLATE_PATH.'/images/svg/'.$svg.'.svg')?>
								</button>
							<?endif;?>
						</div>
					</form>
					<?if(!$bFixed):?>
						<span class="jqmClose top-close stroke-theme-hover inline-search-hide" title="<?=\Bitrix\Main\Localization\Loc::getMessage('CLOSE_BLOCK');?>"><?=CAllcorp3::showIconSvg('', SITE_TEMPLATE_PATH.'/images/svg/Close.svg')?></span>
					<?endif;?>
				</div>
			</div>
		</div>
	</div>
<?endif;?>
<script type="text/javascript">
	var jsControl2 = new JCTitleSearch2({
		//'WAIT_IMAGE': '/bitrix/themes/.default/images/wait.gif',
		'AJAX_PAGE' : '<?=CUtil::JSEscape(POST_FORM_ACTION_URI)?>',
		'CONTAINER_ID': '<?=$CONTAINER_ID?>',
		'INPUT_ID': '<?=$INPUT_ID?>',
		'INPUT_ID_TMP': '<?=$INPUT_ID?>',
		'TYPE': '<?=$type?>',
		'MIN_QUERY_LEN': 2
	});
</script>
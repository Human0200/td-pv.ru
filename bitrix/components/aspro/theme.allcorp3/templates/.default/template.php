<?

use \Bitrix\Main\Config\Option;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(false);

$bUseDemoLink = Option::get(TSolution::moduleID, 'USE_DEMO_LINK', 'N', SITE_ID) === 'Y';
?>
<div class="style-switcher">
	<div class="close_block">
		<div>
			<a href="javascript:void(0)" title="<?=GetMessage('SWITCH_CLOSE_TITLE');?>">
				<?=TSolution::showIconSvg("close", $templateFolder."/images/svg/close.svg");?>
			</a>
		</div>
		
		<div class="closes"><?=TSolution::showIconSvg("close_small", $templateFolder."/images/svg/close_small.svg");?></div>
	</div>

	<div class="top_block_switch">
		<div class="switch presets_action<?=($_COOKIE['styleSwitcherType'] === 'presets' ? ' active' : '');?>">
			<?=TSolution::showIconSvg("preset", $templateFolder."/images/svg/prepared.svg");?>

			<div class="tooltip">
				<div class="wrap">
					<div class="title"><?=GetMessage('SWITCH_PRESETS_TOOLTIP_TITLE');?></div>

					<div class="text"><?=GetMessage('SWITCH_PRESETS_TOOLTIP_DESCRIPTION');?></div>
				</div>
			</div>
		</div>

		<div class="switch<?=($_COOKIE['styleSwitcherType'] === 'parametrs' ? ' active' : '');?>">
			<?=TSolution::showIconSvg("config", $templateFolder."/images/svg/finetune.svg");?>

			<div class="tooltip">
				<div class="wrap">
					<div class="title"><?=GetMessage('SWITCH_PARAMETRS_TOOLTIP_TITLE');?></div>

					<div class="text"><?=GetMessage('SWITCH_PARAMETRS_TOOLTIP_DESCRIPTION');?></div>
				</div>
			</div>
		</div>
	</div>

	<div class="style-switcher-body loading_block">
		<?TSolution::checkRestartBuffer(true, 'widget');?>

		<?if (TSolution::checkAjaxRequest()):?>
			<?// widget.css?>
			<link href="<?=(file_exists($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/css/widget.min.css') ? $templateFolder.'/css/widget.min.css' : $templateFolder.'/css/widget.css').'?'.filemtime($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/css/widget.css');?>" rel="stylesheet">

			<?// spectrum.css?>
			<link href="<?=(file_exists($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/css/spectrum.min.css') ? SITE_TEMPLATE_PATH.'/css/spectrum.min.css' : SITE_TEMPLATE_PATH.'/css/spectrum.css');?>" rel="stylesheet">
			
			<div>
				<?$strBanner = GetMessage("THEME_BANNER", array("#MODULE#" => VENDOR_SOLUTION_NAME, "#MODULE_CODE#" => VENDOR_MODULE_CODE));?>
				<?if ($strBanner):?>
					<div class="banner-block"><?=$strBanner;?></div>
				<?endif;?>

				<div class="left-block <?=($strBanner ? 'with-banner' : '');?> scrollbar">
					<div class="section-block presets_tab <?=($_COOKIE['styleSwitcherType'] === 'presets' ? ' active' : '');?>" data-type="presets">
						<?=TSolution::showIconSvg("smpresents", $templateFolder."/images/svg/prepared_small.svg");?><?=GetMessage("TITLE_TAB_PRESETS");?>
					</div>
					
					<div class="section-block parametrs_tab <?=($_COOKIE['styleSwitcherType'] === 'parametrs' ? ' active' : '');?>" data-type="parametrs">
						<div>
							<?=TSolution::showIconSvg("smparameters", $templateFolder."/images/svg/finetune_small.svg");?>
							<?=GetMessage("TITLE_TAB_PARAMETRS");?>
						</div>
						
						<div class="subitems">
							<?
							$arParametrs = TSolution::$arParametrsList;
							$i = 0;

							foreach ($arParametrs as $blockCode => $arBlock) {
								if (isset($arBlock['THEME']) && $arBlock['THEME'] == 'Y') {
									$active = '';
									if ($_COOKIE['styleSwitcherSubType']) {
										if ($i == $_COOKIE['styleSwitcherSubType']) {
											$active = 'active toggle_initied';
										}
									} elseif (!$i) {
										$active = 'active toggle_initied';
									}

									$i++;
									?>
									<div class="subsection-block <?=$active;?>" data-code="<?=$blockCode?>">
										<?=$arBlock['TITLE'];?>
									</div>
									<?
								} else {
									unset($arParametrs[$blockCode]);
								}
							}
							?>
						</div>
					</div>
					
					<div class="section-block share_tab loading_state" data-type="share">
						<?=TSolution::showIconSvg("share", $templateFolder."/images/svg/share.svg");?>
						<?=GetMessage("TITLE_TAB_SHARE");?>
					</div>
					
					<div class="section-block updates_tab hidden" data-type="updates">
						<?=TSolution::showIconSvg("updates", $templateFolder."/images/svg/updates.svg");?>
						<?=GetMessage("TITLE_TAB_UPDATES");?>
					</div>
					
					<div class="section-block demos_tab hidden" data-type="demos">
						<?=TSolution::showIconSvg("demo_small", $templateFolder."/images/svg/demo_small.svg");?>
						<?=GetMessage("TITLE_TAB_DEMOS");?>
					</div>
				</div>

				<div class="right-block">
					<div class="inner-content<?=$arResult['SHOW_RESET'] ? ' with-action-block' : '';?>">
						<?
						$arThematics = TSolution::$arThematicsList;
						$curThematic = TSolution::getCurrentThematic(SITE_ID);
						$hasMoreThematic = count($arThematics) > 1;

						$arPresets = TSolution::$arPresetsList;
						$curPreset = TSolution::getCurrentPreset(SITE_ID);

						if (strlen($curPreset)) {
							$title = $arPresets[$curPreset]['TITLE'];
							$arPresets[$curPreset]['CURRENT'] = 'Y';
						} else {
							$title = '';
						}
						?>
						<div class="contents presets<?=($_COOKIE['styleSwitcherType'] === 'presets' ? ' active' : '');?> <?=(!$hasMoreThematic ? 'one-thematics' : '');?>">
							<?if ($hasMoreThematic):?>
								<div class="presets_subtabs">
									<div class="presets_subtab<?=(!$_COOKIE['STYLE_SWITCHER_CONFIG_BLOCK'] ? ' active' : '');?>">
										<div class="item">
											<div class="title"><?=TSolution::showIconSvg("theme", $templateFolder."/images/svg/theme.svg");?><?=GetMessage("PRESET_TOP_TEMATIK");?></div>
											
											<div class="desc"><?=(strlen($curThematic) ? $arThematics[$curThematic]['TITLE'] : "&mdash;");?></div>
										</div>
									</div>

									<div class="presets_subtab <?=($_COOKIE['STYLE_SWITCHER_CONFIG_BLOCK'] == 1 ? ' active' : '');?>">
										<div class="item">
											<div class="title"><?=TSolution::showIconSvg("configuration", $templateFolder."/images/svg/configuration.svg");?><?=GetMessage("PRESET_TOP_CONFIG");?></div>
											
											<div class="desc"><?=($title ? $title : "&mdash;");?></div>
										</div>
									</div>
								</div>
							<?endif;?>

							<div class="presets_block">
								<?/*thematics*/?>
								<?if ($hasMoreThematic):?>
									<div class="options thematik <?=(!$_COOKIE['STYLE_SWITCHER_CONFIG_BLOCK'] ? "active" : "");?> scrollbar">
										<div class="rows items">
											<?foreach ($arThematics as $arThematic):?>
												<?if (!$bUseDemoLink && $curThematic !== $arThematic['CODE']) continue;?>

												<div class="item col-md-4 col-sm-6 col-xs-12<?=($curThematic === $arThematic['CODE'] ? ' active' : '');?>" data-code="<?=$arThematic['CODE'];?>">
													<div class="inner">
														<div class="img">
															<div class="img_inner">
																<img src="<?=$arThematic['PREVIEW_PICTURE'].'?'.filemtime($_SERVER['DOCUMENT_ROOT'].$arThematic['PREVIEW_PICTURE']);?>" alt="<?=$arThematic['TITLE'];?>" title="<?=$arThematic['TITLE'];?>" class="img-responsive">
															</div>
														</div>

														<div class="title"><?=$arThematic['TITLE'];?></div>
													</div>
												</div>
											<?endforeach;?>
										</div>
									</div>
								<?endif;?>

								<?/*configuration*/?>
								<div class="options conf <?=(!$hasMoreThematic ? 'active' : ($_COOKIE['STYLE_SWITCHER_CONFIG_BLOCK'] == 1 ? "active" : ""));?> scrollbar">
									<div class="rows items">
										<?foreach ($arPresets as $arPreset):?>
											<?$bHidden = !strlen($curThematic) || !$arThematics[$curThematic] || !in_array($arPreset['ID'], $arThematics[$curThematic]['PRESETS']['LIST']);?>
											
											<div class="item col-md-6 col-sm-6 col-xs-12<?=($bHidden ? ' hidden' : '');?>">
												<div class="preset-block<?=($arPreset['CURRENT'] ? ' current' : '');?><?=($arPreset['PREVIEW_PICTURE'] ? '' : ' no_img');?>" data-id="<?=$arPreset['ID'];?>">
													<?if ($arPreset['PREVIEW_PICTURE']):?>
														<div class="image">
															<div class="status_btn">
																<div class="action_btn">
																	<div class="apply_conf_block">
																		<div class="btn btn-default">
																			<?=TSolution::showIconSvg("choose", $templateFolder."/images/svg/choose.svg");?>
																			<?=GetMessage("THEME_CONFIG_APPLY");?>
																		</div>
																	</div>

																	<div class="preview_conf_block">
																		<div class="btn btn-default white">
																			<?=TSolution::showIconSvg("fastview", $templateFolder."/images/svg/fastview.svg");?>
																			<?=GetMessage("THEME_CONFIG_FAST_VIEW");?>
																		</div>
																	</div>
																</div>

																<div class="checked_wrapper">
																	<div class="checked">
																		<?=TSolution::showIconSvg("check_configuration", $templateFolder."/images/svg/check_configuration.svg");?>
																	</div>
																</div>
															</div>

															<img class="img-responsive" 
																src="<?=($arPreset['PREVIEW_PICTURE'] ? $arPreset['PREVIEW_PICTURE'].'?'.filemtime($_SERVER['DOCUMENT_ROOT'].$arPreset['PREVIEW_PICTURE']) : '');?>" 
																title="<?=$arPreset['TITLE'];?>" 
															>
														</div>
													<?endif;?>

													<div class="info">
														<div class="title">
															<?=$arPreset['TITLE'];?>
														</div>

														<div class="description" data-img="<?=($arPreset['DETAIL_PICTURE'] ? $arPreset['DETAIL_PICTURE'].'?'.filemtime($_SERVER['DOCUMENT_ROOT'].$arPreset['DETAIL_PICTURE']) : '');?>">
															<?=$arPreset['DESCRIPTION'];?>
														</div>
													</div>

													<div class="clearfix"></div>
												</div>
											</div>
										<?endforeach;?>
									</div>
								</div>
							</div>
						</div>

						<div class="contents parametrs<?=($_COOKIE['styleSwitcherType'] === 'parametrs' ? ' active' : '');?>">
							<div class="style-switcher-parametrs__action-block action_block<?=$arResult['CAN_SAVE'] ? ' can_save' : '';?>">
								<div class="action_block_inner">
									<div class="style-switcher-line-block style-switcher-line-block--12">
										<div class="style-switcher-line-block__item">
											<a href="" rel="nofollow" class="dark_link fill-theme-hover sharepreset-trigger-open" title="<?=GetMessage('TITLE_TAB_SHARE');?>">
												<?=TSolution::showIconSvg("share", $templateFolder."/images/svg/share.svg");?><span><?=GetMessage("TITLE_TAB_SHARE");?></span>
											</a>
										</div>
									</div>

									<div class="style-switcher-line-block style-switcher-line-block--12">
										<div class="style-switcher-line-block__item">
											<div class="btn btn-default btn-md btn-transparent-border header-inner reset" title="<?=GetMessage('THEME_RESET_TITLE');?>">
												<?=TSolution::showIconSvg("default", $templateFolder."/images/svg/default.svg");?><?=GetMessage('THEME_RESET');?>
											</div>
										</div>

										<?if ($GLOBALS['USER']->IsAdmin()):?>
											<div class="style-switcher-line-block__item style-switcher--save-btn">
												<div class="btn btn-default btn-md header-inner save_btn" title="<?=GetMessage("SAVE_CONFIG_TITLE");?>">
													<?=TSolution::showIconSvg("save", $templateFolder."/images/svg/save.svg");?><?=GetMessage("SAVE_CONFIG");?>
												</div>
											</div>
										<?endif;?>
									</div>
								</div>
							</div>

							<div class="right-block scrollbar">
								<div class="content-body">
									<form method="POST" name="style-switcher">
										<?
										if ($arParametrs) {
											$switcherController = new TSolution\Switcher($arResult);
											$i = 0;
											foreach ($arParametrs as $blockCode => $arBlock) {
												$active = '';
												if ($_COOKIE['styleSwitcherSubType']) {
													if ($i == $_COOKIE['styleSwitcherSubType']) {
														$active = 'active';
													}
												} elseif (!$i) {
													$active = 'active';
												}
												?>
												<div class="block-item <?=$active;?> <?=$blockCode;?>">
													<?
													$switcherController->showAllOptions($blockCode);
													$i++;
													?>
												</div>
												<?
											}
										}
										?>
									</form>
								</div>
							</div>
						</div>
						
						<div class="contents share" data-script="<?=$this->{'__folder'}.'/share.php';?>"></div>
						
						<div class="contents updates">
							<div class="right-block">
								<div class="content-body">
									<div class="title_block">
										<div class="title">
											<?=GetMessage("SWITCH_UPDATES_TOOLTIP_TITLE");?>
										</div>

										<div class="link">
											<!-- noindex -->
											<a href="https://aspro.ru/company/news/obnovleniya/" class="dark_link" target="_blank" rel="nofollow">
												<?=GetMessage("SWITCH_UPDATES_TOOLTIP_TITLE_ALL");?>
											</a>
											<!-- /noindex -->
										</div>
									</div>

									<div class="body_block scrollbar">
										<div class="news"></div>
									</div>
								</div>
							</div>
						</div>

						<div class="contents demos">
							<div class="right-block scrollbar">
								<div class="content-body body">Form</div>
							</div>
						</div>

						<div class="contents wizard scrollbar" data-script="<?=$this->{'__folder'}.'/wizard.php';?>"></div>
					</div>
				</div>
			</div>

			<?// spectrum.js?>
			<script src="<?=(file_exists($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/js/spectrum.min.js') ? SITE_TEMPLATE_PATH.'/js/spectrum.min.js' : SITE_TEMPLATE_PATH.'/js/spectrum.js');?>" type="text/javascript"></script>

			<?// Sortable.js?>
			<script src="<?=(file_exists($_SERVER['DOCUMENT_ROOT'].'/bitrix/js/'.TSolution::moduleID.'/sort/Sortable.min.js') ? '/bitrix/js/'.TSolution::moduleID.'/sort/Sortable.min.js' : '/bitrix/js/'.TSolution::moduleID.'/sort/Sortable.js');?>" type="text/javascript"></script>

			<?// widget.js?>
			<script src="<?=(file_exists($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/js/widget.min.js') ? $templateFolder.'/js/widget.min.js' : $templateFolder.'/js/widget.js').'?'.filemtime($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/js/widget.js');?>" type="text/javascript"></script>
		<?endif;?>
		<?TSolution::checkRestartBuffer(true, 'widget');?>
	</div>

	<div class="clearfix"></div>
</div>

<script>
	if (typeof arAsproOptions === "object" && arAsproOptions) {
		arAsproOptions.USE_DEMO_LINK = '<?=($bUseDemoLink ? 'Y' : 'N');?>';
	}
</script>
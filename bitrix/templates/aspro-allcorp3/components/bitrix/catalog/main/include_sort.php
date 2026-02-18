<?if($itemsCnt):?>
	<?
	if($_SESSION[$arParams["SECTION_DISPLAY_PROPERTY"].'_'.$arParams['IBLOCK_ID']] === NULL){
		$arUserFieldViewType = CUserTypeEntity::GetList(array(), array('ENTITY_ID' => 'IBLOCK_'.$arParams['IBLOCK_ID'].'_SECTION', 'FIELD_NAME' => $arParams["SECTION_DISPLAY_PROPERTY"]))->Fetch();
		$resUserFieldViewTypeEnum = CUserFieldEnum::GetList(array(), array('USER_FIELD_ID' => $arUserFieldViewType['ID']));
		while($arUserFieldViewTypeEnum = $resUserFieldViewTypeEnum->GetNext()){
			$_SESSION[$arParams["SECTION_DISPLAY_PROPERTY"].'_'.$arParams['IBLOCK_ID']][$arUserFieldViewTypeEnum['ID']] = $arUserFieldViewTypeEnum['XML_ID'];
		}
	}
	
	$sort_default = $arParams['SORT_PROP_DEFAULT'] ? $arParams['SORT_PROP_DEFAULT'] : 'name';
	$order_default = $arParams['SORT_DIRECTION'] ? $arParams['SORT_DIRECTION'] : 'asc';
	$arPropertySortDefault = array('name', 'sort');
	
	$arAvailableSort = array(
		'name' => array(
			'SORT' => 'NAME',
			'ORDER_VALUES' => array(
				'asc' => GetMessage('sort_title').GetMessage('sort_name_asc'),
				'desc' => GetMessage('sort_title').GetMessage('sort_name_desc'),
			),
		),
		'sort' => array(
			'SORT' => 'SORT',
			'ORDER_VALUES' => array(
				'asc' => GetMessage('sort_title').GetMessage('sort_sort', array('#ORDER#' => GetMessage('sort_prop_asc'))),
				'desc' => GetMessage('sort_title').GetMessage('sort_sort', array('#ORDER#' => GetMessage('sort_prop_desc'))),
			)
		),
	);
	
	
	foreach($arAvailableSort as $prop => $arProp){
		if(!in_array($prop, $arParams['SORT_PROP']) && $sort_default !== $prop){
			unset($arAvailableSort[$prop]);
		}
	}

	if($arParams['SORT_PROP']){
		if(!isset($_SESSION[$arParams['IBLOCK_ID'].md5(serialize((array)$arParams['SORT_PROP']))])){
			foreach($arParams['SORT_PROP'] as $prop){
				if($prop == 'PRICE' && !$bFilterPrice)
					$prop = 'FILTER_PRICE';
				if(!isset($arAvailableSort[$prop])){
					$dbRes = CIBlockProperty::GetList(array(), array('ACTIVE' => 'Y', 'IBLOCK_ID' => $arParams['IBLOCK_ID'], 'CODE' => $prop));
					while($arPropperty = $dbRes->Fetch()){
						$arAvailableSort[$prop] = array(
							'SORT' => 'PROPERTY_'.$prop,
							'ORDER_VALUES' => array(),
						);

						if($prop == 'PRICE' || $prop == 'FILTER_PRICE'){
							$arAvailableSort[$prop]['ORDER_VALUES']['asc'] = GetMessage('sort_title').GetMessage('sort_PRICE_asc');
							$arAvailableSort[$prop]['ORDER_VALUES']['desc'] = GetMessage('sort_title').GetMessage('sort_PRICE_desc');
						}
						else{
							$arAvailableSort[$prop]['ORDER_VALUES']['asc'] = GetMessage('sort_title_property', array('#CODE#' => $arPropperty['NAME'], '#ORDER#' => GetMessage('sort_prop_asc')));
							$arAvailableSort[$prop]['ORDER_VALUES']['desc'] = GetMessage('sort_title_property', array('#CODE#' => $arPropperty['NAME'], '#ORDER#' => GetMessage('sort_prop_desc')));
						}
					}
				}
			}
			$_SESSION[$arParams['IBLOCK_ID'].md5(serialize((array)$arParams['SORT_PROP']))] = $arAvailableSort;
		}
		else{
			$arAvailableSort = $_SESSION[$arParams['IBLOCK_ID'].md5(serialize((array)$arParams['SORT_PROP']))];
		}
	}
	$arDisplays = array("table", "list", "price");
	if (
		array_key_exists('display', $_REQUEST) && 
		!empty($_REQUEST['display']) && 
		(in_array(trim($_REQUEST["display"]), $arDisplays))
	) {
		setcookie('catalogViewMode', $_REQUEST['display'], 0, SITE_DIR);
		$_COOKIE['catalogViewMode'] = $_REQUEST['display'];
	}
	if (array_key_exists('sort', $_REQUEST) && !empty($_REQUEST['sort'])) {
		setcookie('catalogSort', $_REQUEST['sort'], 0, SITE_DIR);
		$_COOKIE['catalogSort'] = $_REQUEST['sort'];
	}
	if (array_key_exists('order', $_REQUEST) && !empty($_REQUEST['order'])) {
		setcookie('catalogOrder', $_REQUEST['order'], 0, SITE_DIR);
		$_COOKIE['catalogOrder'] = $_REQUEST['order'];
	}
	if (array_key_exists('show', $_REQUEST) && !empty($_REQUEST['show'])) {
		setcookie('catalogPageElementCount', $_REQUEST['show'], 0, SITE_DIR);
		$_COOKIE['catalogPageElementCount'] = $_REQUEST['show'];
	}

	

	if (isset($_COOKIE['catalogViewMode']) && $_COOKIE['catalogViewMode']) {
		$display = $_COOKIE['catalogViewMode'];
	} else {
		if (
			$arSection[$arParams["SECTION_DISPLAY_PROPERTY"]] && 
			isset($_SESSION[$arParams["SECTION_DISPLAY_PROPERTY"].'_'.$arParams['IBLOCK_ID']][$arSection[$arParams["SECTION_DISPLAY_PROPERTY"]]])
		) {
			$display = $_SESSION[$arParams["SECTION_DISPLAY_PROPERTY"].'_'.$arParams['IBLOCK_ID']][$arSection[$arParams["SECTION_DISPLAY_PROPERTY"]]];
		} else {
			$display = $arParams['VIEW_TYPE'];
		}
	}

	$bForceDisplay = false;	
	
	if ($arSection["DISPLAY"] && in_array($arSection["DISPLAY"], $arDisplays)) {
		if ($arParams['SHOW_LIST_TYPE_SECTION'] == 'Y') {
			if (!isset($_COOKIE['catalogViewMode'])) {
				$display = $arSection["DISPLAY"];
			}
		} else {
			$display = $arSection["DISPLAY"];
			$bForceDisplay = true;
		}
	}
	
	if ($display) {
		if (!in_array(trim($display), $arDisplays)) {
			$display = "table";
		}
	} else {
		$display = "table";
	}
	
	$show = !empty($_COOKIE['catalogPageElementCount']) ? $_COOKIE['catalogPageElementCount'] : $arParams['PAGE_ELEMENT_COUNT'];
	$sort = !empty($_COOKIE['catalogSort']) ? $_COOKIE['catalogSort'] : $sort_default;
	$order = !empty($_COOKIE['catalogOrder']) ? $_COOKIE['catalogOrder'] : $order_default;
	
	$arDelUrlParams = array('sort', 'order', 'control_ajax', 'ajax_get_filter', 'linerow', 'display');
	?>
	<!-- noindex -->
	<div class="filter-panel filter-panel--filter-<?=$arParams['FILTER_VIEW']?> sort_header view_<?=$display?> flexbox flexbox--direction-row flexbox--justify-beetwen bordered rounded-4">
		<div class="filter-panel__part-left">
			<div class="line-block line-block--align-normal line-block--0 filter-panel__main-info">
				<?if($arTheme['SHOW_SMARTFILTER']['VALUE'] !== 'N' && $itemsCnt):?>
					<?$bActiveFilter = TSolution\Functions::checkActiveFilterPage($arParams["SEF_URL_TEMPLATES"]['smart_filter']);?>
					<div class="line-block__item filter-panel__filter <?=($bHideLeftBlock && !$bShowCompactHideLeft ? 'filter-panel__filter--visible' : '');?>">
						<div class="fill-theme-hover dark_link">
							<div class="bx-filter-title filter_title <?=($bActiveFilter && $bActiveFilter[1] != 'clear' ? 'active-filter' : '')?>">
								<?=TSolution::showIconSvg("icon fill-dark-light", SITE_TEMPLATE_PATH.'/images/svg/catalog/filter.svg', '', '', true, false);?>
								<span class="font_upper_md dotted font_bold"><?=\Bitrix\Main\Localization\Loc::getMessage("CATALOG_SMART_FILTER_TITLE");?></span>
							</div>
							<div class="controls-hr"></div>
						</div>
					</div>
				<?endif;?>

				<?if ($arAvailableSort):?>
					<div class="line-block__item">
						<div class="filter-panel__sort">
							<div class="dropdown-select">
								<div class="dropdown-select__title font_14 fill-dark-light-block">
									<span>
										<?if($order && $sort):?>
											<?=$arAvailableSort[$sort]['ORDER_VALUES'][$order]?>
										<?else:?>
											<?=\Bitrix\Main\Localization\Loc::getMessage('NOTHING_SELECTED');?>
										<?endif;?>
									</span>
									<?=TSolution::showIconSvg("down", SITE_TEMPLATE_PATH.'/images/svg/Triangle_down.svg', '', '', true, false);?>
								</div>
								<div class="dropdown-select__list dropdown-menu-wrapper" role="menu">
									<div class="dropdown-menu-inner rounded-4">
										<?foreach($arAvailableSort as $newSort => $arSort):?>
											<?if(is_array($arSort['ORDER_VALUES'])):?>
												<?foreach($arSort['ORDER_VALUES'] as $newOrder => $sortTitle):?>
													<div class="dropdown-select__list-item font_14">
														<?
														$current_url = $APPLICATION->GetCurPageParam('sort='.$newSort.'&order='.$newOrder, $arDelUrlParams);
														$url = str_replace('+', '%2B', $current_url);?>
		
														<?if($bCurrentLink = ($sort == $newSort && $order == $newOrder)):?>
															<span class="dropdown-select__list-link color_333 dropdown-select__list-link--current">
															
														<?else:?>
															<a href="<?=$url;?>" class="dropdown-select__list-link <?=$value?> <?=$key?> dark_link <?=($arParams['AJAX_CONTROLS'] == 'Y' ? ' js-load-link' : '');?>" data-url="<?=$url;?>" rel="nofollow">
														<?endif;?>
															<span>
																<?=$sortTitle?>
															</span>
														<?if($bCurrentLink):?>
															</span>
														<?else:?>
															</a>
														<?endif;?>
													</div>
												<?endforeach?>
											<?endif;?>
										<?endforeach;?>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?endif;?>
			</div>			
		</div>
		<?if (!$bForceDisplay):?>
			<div class="filter-panel__part-right">
				<div class="line-block line-block--align-normal line-block--0">
					<?if($display == 'table'):?>					
						<div class="line-block__item">
							<div class="filter-panel__view controls-linecount controls-view">
								<?$arLineCount = [4,3];?>
								<?if (
									array_key_exists("linerow", $_REQUEST) || 
									array_key_exists("linerow", $_SESSION) || 
									$arParams["SECTION_LIST_DISPLAY_TYPE"]
								) {
									if (
										$_REQUEST["linerow"] &&
										(in_array(trim($_REQUEST["linerow"]), $arLineCount))
									) {
										$linerow = htmlspecialcharsbx(trim($_REQUEST["linerow"]));
										$_SESSION["linerow"]=htmlspecialcharsbx(trim($_REQUEST["linerow"]));
									} elseif (
										$_SESSION["linerow"] && 
										(in_array(trim($_SESSION["linerow"]), $arLineCount))
									) {
										$linerow = $_SESSION["linerow"];
									} elseif(
										$arParams["SECTION_LIST_DISPLAY_TYPE"] && 
										(in_array(trim($arParams["SECTION_LIST_DISPLAY_TYPE"]), $arLineCount))
									) {
										$linerow = $arParams["SECTION_LIST_DISPLAY_TYPE"];
									} else {
										$linerow = 3;
									}

								} else {
									$linerow = 3;
								}?>
								<?foreach ($arLineCount as $value):?>
									<?
									$current_url = '';
									$current_url = $APPLICATION->GetCurPageParam('linerow='.$value, $arDelUrlParams);
									$url = str_replace('+', '%2B', $current_url);
									?>
									<?if($linerow == $value):?>
										<span title="<?=\Bitrix\Main\Localization\Loc::getMessage("SECT_DISPLAY_".$value)?>" class="controls-view__link controls-view__link--current"><?=TSolution::showIconSvg("type", SITE_TEMPLATE_PATH.'/images/svg/catalog/'.$value.'inarow.svg', '', '', true, false);?></span>
									<?else:?>
										<a rel="nofollow" href="<?=$url;?>" data-url="<?=$url?>" title="<?=\Bitrix\Main\Localization\Loc::getMessage("SECT_DISPLAY_".$value)?>" class="controls-view__link muted fill-theme-hover <?=($arParams['AJAX_CONTROLS'] == 'Y' ? ' js-load-link' : '');?>"><?=TSolution::showIconSvg("type", SITE_TEMPLATE_PATH.'/images/svg/catalog/'.$value.'inarow.svg', '', '', true, false);?></a>
									<?endif;?>
								<?endforeach;?>
								<div class="controls-hr"></div>
							</div>
						</div>
					<?endif;?>

					<div class="line-block__item">
						<div class="filter-panel__view controls-view">
							<?foreach($arDisplays as $displayType):?>
								<?
								$current_url = '';
								$current_url = $APPLICATION->GetCurPageParam('display='.$displayType, $arDelUrlParams);
								$url = str_replace('+', '%2B', $current_url);
								?>
								<?if($display == $displayType):?>
									<span title="<?=\Bitrix\Main\Localization\Loc::getMessage("SECT_DISPLAY_".strtoupper($displayType))?>" class="controls-view__link controls-view__link--<?=$displayType?> controls-view__link--current"><?=TSolution::showIconSvg("type", SITE_TEMPLATE_PATH.'/images/svg/catalog/'.$displayType.'type.svg', '', '', true, false);?></span>
								<?else:?>
									<a rel="nofollow" href="<?=$url;?>" data-url="<?=$url?>" title="<?=\Bitrix\Main\Localization\Loc::getMessage("SECT_DISPLAY_".strtoupper($displayType))?>" class="controls-view__link controls-view__link--<?=$displayType?> muted fill-theme-hover <?=($arParams['AJAX_CONTROLS'] == 'Y' ? ' js-load-link' : '');?>"><?=TSolution::showIconSvg("type", SITE_TEMPLATE_PATH.'/images/svg/catalog/'.$displayType.'type.svg', '', '', true, false);?></a>
								<?endif;?>
							<?endforeach;?>
						</div>
					</div>
				</div>
			</div>
		<?endif;?>
	</div>
	<!-- /noindex -->
<?endif;?>

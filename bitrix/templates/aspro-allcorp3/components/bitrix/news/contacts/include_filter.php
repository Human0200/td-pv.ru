<?
use \Bitrix\Main\Localization\Loc;

if($arSection){
    $arAllItemsFilter = $arItemFilter;
    unset(
        $arAllItemsFilter['SECTION_ID'], 
        $arAllItemsFilter['SECTION_CODE'], 
        $arAllItemsFilter['SECTION_GLOBAL_ACTIVE']
    );

    $arAllItems = CAllcorp3Cache::CIblockElement_GetList(
        array(
            'CACHE' => array(
                'TAG' => CAllcorp3Cache::GetIBlockCacheTag($arParams['IBLOCK_ID'])
            )
        ),
        $arAllItemsFilter,
        false,
        false,
        array('ID', 'IBLOCK_SECTION_ID')
    );
}
else{
    $arAllItems = $arItems;
}

$arAllSections = $arAllItems ? CAllcorp3::GetSections($arAllItems, array_merge($arParams, array('SEF_URL_TEMPLATES' => array()))) : array();

$bHasSections = (isset($arAllSections['ALL_SECTIONS']) && $arAllSections['ALL_SECTIONS']);
$bHasChildSections = (isset($arAllSections['CHILD_SECTIONS']) && $arAllSections['CHILD_SECTIONS']);
if($bHasSections){    
    $arAllSections['CURRENT_SECTIONS'] = array(
        'PARENT' => array('ID' => false),
        'CHILD' => array('ID' => false),
    );

    if($arSection){
        foreach($arAllSections['ALL_SECTIONS'] as $_arSection){
            $bChecked = $_arSection['SECTION']['ID'] == $arSection['ID'];
            if($bChecked){
                $arAllSections['CURRENT_SECTIONS']['PARENT'] = $_arSection['SECTION'];
                break;
            }
            elseif($bHasChildSections){
                if(in_array($arSection['ID'], $_arSection['CHILD_IDS'])){
                    $arAllSections['CURRENT_SECTIONS']['PARENT'] = $_arSection['SECTION'];
                    $arAllSections['CURRENT_SECTIONS']['CHILD'] = $arAllSections['CHILD_SECTIONS'][$arSection['ID']];
                    break;
                }
            }
        }
    }

    $selectRegionText = ($arParams['CHOOSE_REGION_TEXT'] ? $arParams['CHOOSE_REGION_TEXT'] : Loc::getMessage('CHOISE_ITEM', array('#ITEM#' => ($bHasChildSections ? Loc::getMessage('CHOISE_REGION') : Loc::getMessage('CHOISE_CITY')))));

    $selectCityText = Loc::getMessage('CHOISE_ITEM', array('#ITEM#' => Loc::getMessage('CHOISE_CITY')));
    ?>
    <div class="contacts__filter line-block line-block--16">
        <div class="line-block__item">
            <div class="contacts__filter-select">
                <div class="dropdown-select <?=($bHasChildSections ? 'region' : 'city')?> bordered rounded-4" data-id="<?=$arAllSections['CURRENT_SECTIONS']['PARENT']['ID']?>">
                    <div class="dropdown-select__title">
                        <span><?=($arAllSections['CURRENT_SECTIONS']['PARENT']['ID'] ? $arAllSections['CURRENT_SECTIONS']['PARENT']['NAME'] : $selectRegionText)?></span>
                        <?=CAllcorp3::showIconSvg("down fill-dark-light", SITE_TEMPLATE_PATH.'/images/svg/Triangle_down.svg', '', '', true, false);?>
                    </div>
                    <div class="dropdown-select__list dropdown-menu-wrapper" role="menu">
                        <div class="dropdown-menu-inner rounded-4 scrollbar">
                            <div class="dropdown-select__list-item">
                                <?$bChecked = !$arAllSections['CURRENT_SECTIONS']['PARENT']['ID'];?>
                                <a href="<?=$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"]?>" class="dropdown-select__list-link empty dark_link <?=($bChecked ? 'dropdown-select__list-link--current' : '')?>" data-id="0" rel="nofollow">
                                    <span><?=$selectRegionText?></span>
                                </a>
                            </div>
                            <?foreach($arAllSections['ALL_SECTIONS'] as $_arSection):?>
                                <?$bChecked = $_arSection['SECTION']['ID'] == $arAllSections['CURRENT_SECTIONS']['PARENT']['ID'];?>
                                <div class="dropdown-select__list-item">
                                    <a href="<?=$_arSection['SECTION']['SECTION_PAGE_URL']?>" class="dropdown-select__list-link dark_link <?=($bChecked ? 'dropdown-select__list-link--current' : '')?>" data-id="<?=$_arSection['SECTION']['ID']?>" rel="nofollow">
                                        <span><?=$_arSection['SECTION']['NAME']?></span>
                                    </a>
                                </div>
                            <?endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?if($bHasChildSections):?>
            <div class="line-block__item">
                <div class="contacts__filter-select">
                    <div class="dropdown-select city bordered rounded-4" data-id="<?=($arAllSections['CURRENT_SECTIONS']['CHILD']['ID'] ?: $arAllSections['CURRENT_SECTIONS']['PARENT']['ID'])?>">
                        <div class="dropdown-select__title">
                            <span><?=($arAllSections['CURRENT_SECTIONS']['CHILD']['ID'] ? $arAllSections['CURRENT_SECTIONS']['CHILD']['NAME'] : $selectCityText)?></span>
                            <?=CAllcorp3::showIconSvg("down fill-dark-light", SITE_TEMPLATE_PATH.'/images/svg/Triangle_down.svg', '', '', true, false);?>
                        </div>
                        <div class="dropdown-select__list dropdown-menu-wrapper" role="menu">
                            <div class="dropdown-menu-inner rounded-4 scrollbar">
                                <div class="dropdown-select__list-item">
                                    <?$bChecked = !$arAllSections['CURRENT_SECTIONS']['CHILD']['ID'];?>
                                    <a href="javascript:;" class="dropdown-select__list-link empty dark_link <?=($bChecked ? 'dropdown-select__list-link--current' : '')?>" data-id="0" rel="nofollow">
                                        <span><?=$selectCityText?></span>
                                    </a>
                                </div>
                                <?foreach($arAllSections['CHILD_SECTIONS'] as $_arSubSection):?>
                                    <?
                                    $bChecked = $_arSubSection['ID'] == $arAllSections['CURRENT_SECTIONS']['CHILD']['ID'];
                                    $bVisible = $_arSubSection['IBLOCK_SECTION_ID'] == $arAllSections['CURRENT_SECTIONS']['PARENT']['ID'];
                                    ?>
                                    <div class="dropdown-select__list-item">
                                        <a href="<?=$_arSubSection['SECTION_PAGE_URL']?>" class="dropdown-select__list-link dark_link <?=($bChecked ? 'dropdown-select__list-link--current' : '')?>" data-id="<?=$_arSubSection['ID']?>" data-parent_id="<?=$_arSubSection['IBLOCK_SECTION_ID']?>" rel="nofollow" <?=($bVisible ? '' : 'style="display:none"')?>>
                                            <span><?=$_arSubSection['NAME']?></span>
                                        </a>
                                    </div>
                                <?endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?endif;?>
    </div>
    <?
}
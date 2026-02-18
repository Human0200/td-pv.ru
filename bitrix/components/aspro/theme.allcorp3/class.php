<?

use Bitrix\Main\Loader,
    Bitrix\Main\Localization\Loc,
    Bitrix\Main\SystemException;

require($_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/vendor/php/solution.php');

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
Loc::loadMessages(__FILE__);

class Theme extends \CBitrixComponent {
    public function onPrepareComponentParams($arParams){
        return $arParams;
    }

    protected function includeModules(){
        if(!class_exists('TSolution') || !Loader::includeModule(TSolution::moduleID)){
            throw new SystemException(Loc::getMessage('WS_C_ERROR_MODULE_NOT_INSTALLED'));
        }
    }

    public function executeComponent(){
        try{
            $this->includeModules();

            $bAjaxWidget = isset($_REQUEST['BLOCK']) && $_REQUEST['BLOCK'] === 'widget';
            $bShowTemplate = $bAjaxWidget || $this->arParams['SHOW_TEMPLATE'] === 'Y';

            $arFrontParametrs = TSolution::GetFrontParametrsValues(SITE_ID, SITE_DIR, $bShowTemplate);
            if($bShowTemplate){
                global $arMergeOptions;
                //$arFrontParametrs = array_merge((array)$arFrontParametrs, (array)$arMergeOptions);
                if(isset($_SESSION['arMergeOptions']) && !empty($_SESSION['arMergeOptions'])){
                    $arFrontParametrs = array_merge((array)$arFrontParametrs, (array)$_SESSION['arMergeOptions']);
                }
                $_SESSION['arMergeOptions'] = (array)$arMergeOptions;
            }

            $this->arResult = TSolution\Functions::getSolutionOptions($arFrontParametrs);

            if($bShowTemplate){
                $bPageSpeedTest = TSolution::isPageSpeedTest(); // it`s page speed test now

                $active = ($this->arResult['THEME_SWITCHER']['VALUE'] == 'Y' && !$bPageSpeedTest);
                $this->arResult['SHOW_RESET'] = ((isset($_SESSION['THEME']) && $_SESSION['THEME']) && (isset($_SESSION['THEME'][SITE_ID]) && $_SESSION['THEME'][SITE_ID]));
                $this->arResult['CAN_SAVE'] = ($GLOBALS['USER']->IsAdmin() && $this->arResult['SHOW_RESET']);

                $themeDir = strToLower($this->arResult['BASE_COLOR']['VALUE'].($this->arResult['BASE_COLOR']['VALUE'] !== 'CUSTOM' ? '' : '_'.SITE_ID));
                $GLOBALS['APPLICATION']->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/themes/'.$themeDir.'/colors.css', true);
                $GLOBALS['APPLICATION']->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/width-'.$this->arResult['PAGE_WIDTH']['VALUE'].'.css', true);
                $GLOBALS['APPLICATION']->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/fonts/font-'.$this->arResult['FONT_STYLE']['VALUE'].'.css', true);

                if(
                    $active &&
                    (
                        (
                            (
                                !isset($_REQUEST['ajax']) ||
                                strtolower($_REQUEST['ajax']) !== 'y'
                            ) &&
                            (
                                !isset($_SERVER['HTTP_X_REQUESTED_WITH']) ||
                                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest'
                            )
                        ) ||
			            $bAjaxWidget
                    )
                ){
                    \Bitrix\Main\Data\StaticHtmlCache::getInstance()->markNonCacheable();

                    if(!$bPageSpeedTest){
                        //$GLOBALS['APPLICATION']->AddHeadScript(SITE_TEMPLATE_PATH.'/js/spectrum.js');
                        //$GLOBALS['APPLICATION']->AddHeadScript('/bitrix/js/aspro.allcorp3/sort/Sortable.js');
                        // $GLOBALS['APPLICATION']->AddHeadScript(SITE_TEMPLATE_PATH.'/js/on-off-switch.js');
                        // $GLOBALS['APPLICATION']->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/spectrum.css');
                        $this->includeComponentTemplate();
                    }
                }

                $GLOBALS['APPLICATION']->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/custom.css', true);

                $file = \Bitrix\Main\Application::getDocumentRoot().'/bitrix/components/aspro/theme.'.VENDOR_SOLUTION_NAME.'/css/user_font_'.SITE_ID.'.css';
                if($this->arResult['CUSTOM_FONT']['VALUE'] && \Bitrix\Main\IO\File::isFileExists($file)){
                    $GLOBALS['APPLICATION']->SetAdditionalCSS($this->__path.'/css/user_font_'.SITE_ID.'.css', true);
                }
            }
        }
        catch(SystemException $e){
            ?>
            <div class="alert alert-danger"><?=$e->getMessage()?></div>
            <?
        }

        return $this->arResult;
    }
}

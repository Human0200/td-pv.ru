<?
use Bitrix\Main\Loader,
    Bitrix\Main\Localization\Loc,
    Bitrix\Main\Config\Option,
    Bitrix\Main\SystemException;

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
Loc::loadMessages(__FILE__);

class ExpressButton extends \CBitrixComponent {
	const CUSTOM_CLASS = 'custom';
    const FORM_ACTION = 'FORM';

    public function onPrepareComponentParams($arParams){
    	if(isset($arParams['CUSTOM_SITE_ID'])){
			$this->setSiteId($arParams['CUSTOM_SITE_ID']);
		}

		if(isset($arParams['CUSTOM_LANGUAGE_ID'])){
			$this->setLanguageId($arParams['CUSTOM_LANGUAGE_ID']);
		}

        return $arParams;
    }

    public function executeComponent(){
    	try{
    		$this->includeModules();

    		$arBackParametrs = TSolution::GetBackParametrsValues($this->getSiteId());
            $class = trim($arBackParametrs['EXPRESS_BUTTON_CLASS']);
            $customClass = trim($arBackParametrs['EXPRESS_BUTTON_CUSTOM_CLASS']);

            $this->arResult = array(
                'action' => $arBackParametrs['EXPRESS_BUTTON_ACTION'],
                'title' => trim($arBackParametrs['EXPRESS_BUTTON_TITLE']),
                'class' => strlen($class) ? $class : 'btn-default' ,
                'custom_class' => strlen($customClass) ? $customClass : '' ,
                'link' => trim($arBackParametrs['EXPRESS_BUTTON_LINK']),
                'form' => $arBackParametrs['EXPRESS_BUTTON_FORM'],
            );

	        $this->includeComponentTemplate();
        }
        catch(SystemException $e){
            // echo $e->getMessage();
        }

        return $this->arResult;
    }

    protected function includeModules(){
        if(!class_exists('TSolution') || !Loader::includeModule(TSolution::moduleID)){
            throw new SystemException(Loc::getMessage('WS_C_ERROR_MODULE_NOT_INSTALLED'));
        }
    }

    public static function getSite($siteId){
        static $arSites;

        if(strlen($siteId)){
            if(!isset($arSites[$siteId])){
                $arSites[$siteId] = \CSite::GetByID($siteId)->Fetch();
            }

            return $arSites[$siteId];
        }

        return array();
    }

    public function isLinkAction() {
        return $this->arResult['action'] !== self::FORM_ACTION || !strlen($this->arResult['form']);
    }

    public function isLinkTargetBlank() {
        return strpos($this->arResult['link'], 'https://') !== false || strpos($this->arResult['link'], 'http://') !== false;
    }
    public function getAtributes() {
        $arBackParametrs = TSolution::GetBackParametrsValues($this->getSiteId());
        $arAtributes = [];
        for($i = 0; $i < $arBackParametrs['EXPRESS_BUTTON_ATR']; ++$i) {
            $parametersName = TSolution::normalizeValue($arBackParametrs['EXPRESS_BUTTON_ATR_array_ATR_NAME_'.$i]);
            $parametersValue = TSolution::normalizeValue($arBackParametrs['EXPRESS_BUTTON_ATR_array_ATR_VALUE_'.$i]);
            
            if ($parametersName && $parametersValue) {
                $arAtributes[] = $parametersName."='{$parametersValue}'";
            } elseif ($parametersName) {
                $arAtributes[] = $parametersName;
            } elseif ($parametersValue) {
                $arAtributes[] = $parametersValue;
            }
        }
        if (count($arAtributes)) {
            array_unshift($arAtributes, '');
        }

        return implode(' ', $arAtributes);
    }
    

    public function getFormId() {
        return TSolution::getFormID($this->arResult['form'], $this->getSiteId());
    }

    public function isCustomClass() {
        return $this->arResult['class'] === self::CUSTOM_CLASS;
    }

    public function getClass() {
        $class = $this->isCustomClass() ? $this->arResult['custom_class'] : $this->arResult['class'];
        $class = trim($class);

        return 'btn '.($this->isLinkAction() ? '' : 'animate-load ').$class;
    }
}
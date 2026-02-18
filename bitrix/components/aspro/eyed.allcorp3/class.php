<?
use Bitrix\Main\Loader,
    Bitrix\Main\Localization\Loc,
    Bitrix\Main\Config\Option,
    Bitrix\Main\SystemException;

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
Loc::loadMessages(__FILE__);

class Eyed extends \CBitrixComponent {
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
        $isAjax = $this->request->isPost() && $this->request['mode'] === 'ajax' && $this->request['action'] === 'getEyed';

        $this->addBodyClasses();

        if($isAjax){
			$GLOBALS['APPLICATION']->RestartBuffer();
		}

    	try{
    		$this->includeModules();

            $signer = new \Bitrix\Main\Security\Sign\Signer;
            $signedParams = $signer->sign(base64_encode(serialize($this->arParams)), str_replace(':', '.', $this->getName()));

            $this->arResult = array(
                'ENABLED' => TSolution\Eyed::isEnabled(),
                'ACTIVE' => TSolution\Eyed::isActive(),
                'IS_AJAX' => $isAjax,
                'SIGNED_PARAMS' => $signedParams,
                'COOKIE'=> array(
                    'ACTIVE' => TSolution\Eyed::cookieActive,
                    'OPTIONS' => TSolution\Eyed::cookieOptions,
                ),
                'OPTIONS' => TSolution\Eyed::getOptions(),
            );

            if($isAjax){
                $GLOBALS['APPLICATION']->RestartBuffer();
            }

	        $this->includeComponentTemplate();
        }
        catch(SystemException $e){
            // echo $e->getMessage();
        }

        return $this->arResult;
    }

    public function addBodyClasses(){
        $GLOBALS['bodyDopClass'] = '';

        if(TSolution\Eyed::isActive()){
            \Bitrix\Main\Data\StaticHtmlCache::getInstance()->markNonCacheable();

            $GLOBALS['bodyDopClass'] = ' eyed';
            $arOptions = TSolution\Eyed::getOptions();

            // font size
            switch($arOptions['FONT-SIZE']){
                case 16:
                    $GLOBALS['bodyDopClass'] .= ' eyed--font-size--16';
                    break;
                case 20:
                    $GLOBALS['bodyDopClass'] .= ' eyed--font-size--20';
                    break;
                case 24:
                    $GLOBALS['bodyDopClass'] .= ' eyed--font-size--24';
                    break;
                default:
                    $GLOBALS['bodyDopClass'] .= ' eyed--font-size--16';
            }

            // color scheme
            switch($arOptions['COLOR-SCHEME']){
                case 'black':
                    $GLOBALS['bodyDopClass'] .= ' eyed--color-scheme--black';
                    break;
                case 'white':
                    $GLOBALS['bodyDopClass'] .= ' eyed--color-scheme--white';
                    break;
                case 'blue':
                    $GLOBALS['bodyDopClass'] .= ' eyed--color-scheme--blue';
                    break;
                case 'black_on_yellow':
                     $GLOBALS['bodyDopClass'] .= ' eyed--color-scheme--black_on_yellow';
                     break;
                 case 'green':
                     $GLOBALS['bodyDopClass'] .= ' eyed--color-scheme--green';
                default:
                    $GLOBALS['bodyDopClass'] .= ' eyed--color-scheme--black';
            }

            // images
            switch($arOptions['IMAGES']){
                case 0:
                    $GLOBALS['bodyDopClass'] .= ' eyed--images--off';
                    break;
                case 1:
                    $GLOBALS['bodyDopClass'] .= ' eyed--images--on';
                    break;
                default:
                    $GLOBALS['bodyDopClass'] .= ' eyed--images--on';
            }

            // speaker
            switch($arOptions['SPEAKER']){
                case 0:
                    $GLOBALS['bodyDopClass'] .= ' eyed--speaker--off';
                    break;
                case 1:
                    $GLOBALS['bodyDopClass'] .= ' eyed--speaker--on';
                    break;
                default:
                    $GLOBALS['bodyDopClass'] .= ' eyed--speaker--off';
            }
        }

        return $GLOBALS['bodyDopClass'];
    }

    protected function includeModules(){
        if(!class_exists('TSolution') || !Loader::includeModule(TSolution::moduleID)){
            throw new SystemException(Loc::getMessage('WS_C_ERROR_MODULE_NOT_INSTALLED'));
        }
    }
}
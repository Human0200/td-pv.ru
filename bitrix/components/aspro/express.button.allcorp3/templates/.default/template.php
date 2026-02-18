<?
use Bitrix\Main\Localization\Loc;

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
Loc::loadMessages(__FILE__);

$this->setFrameMode(true);

$title = $arResult['title'];
$component = $this->__component;
?>
<?$strAtributesList = $component->getAtributes();
if($component->isLinkAction()):?>
	<?
    $link = $arResult['link'];
    $bBlank = $component->isLinkTargetBlank();

    if(!$bBlank){
        if(strlen($link)){
            if(strpos($link, '#SITE_DIR#') !== false){
                $link = str_replace('#SITE_DIR#', $component::getSite($component->getSiteId())['DIR'], $link);
            }
            $link = '/'.ltrim($link, '/');
        }
    }
    ?>
    <?if(strlen($link)):?>
        <a class="<?=htmlspecialcharsbx($component->getClass())?>" href="<?=$link?>"<?=($bBlank ? ' target="_blank"' : '')?><?= $strAtributesList?>><?=$title?></a>
    <?else:?>
        <span class="<?=htmlspecialcharsbx($component->getClass())?>"<?=$strAtributesList?>><?=$title?></span>
    <?endif;?>
<?else:?>
    <button type="button" class="<?=htmlspecialcharsbx($component->getClass())?>" <?=$strAtributesList?> data-event="jqm" data-param-id="<?=$component->getFormId()?>"><?=$title?></button>
<?endif;?>
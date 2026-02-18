<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

if (strlen($arResult['MESSAGE']))
    ShowError($arResult['MESSAGE']);
?>
<p><?=Loc::getMessage("PAYMENT_DESCRIPTION");?><b><?=$arResult['ORDER_AMOUNT_FORMATTED']?></b></p>

<form action="<?=$arResult['PAYMENT_URL']; ?>" method="post" id="invoicebox-form" target="_blank">
    <input type="hidden" name="itransfer_encoding" value="utf-8"/>
    <?php foreach($arResult['FORM_FILEDS'] as $name => $value): ?>
        <input type="hidden" name="<?=$name;?>" value="<?=$value;?>">
    <?php endforeach; ?>
    <p>
        <button type="submit" class="btn btn-default pl-4 pr-4"><?=Loc::getMessage("PAYMENT_BUTTON")?></button>
    </p>
</form>
<p><?=Loc::getMessage("PAYMENT_REFUND"); ?></p>

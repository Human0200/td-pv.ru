<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

$GLOBALS['APPLICATION']->ShowAjaxHead();
?>
<div class="flexbox">
    <div id="popup_subscribe_container" class="form popup">
        <?php
        if ($arResult['EVENT']['SUCCESS_UPDATE']) {
            include __DIR__.'/success.php';
        } else {
            if (!empty($arResult['ERROR_MESS'])) {
                ?>
                <div class="top-form messages">
                    <div class="alert alert-danger mb mb--0">
                        <?=ShowMessage(['MESSAGE' => $arResult['ERROR_MESS'], 'TYPE' => 'ERROR']);?>
                    </div>
                </div>
                <?php
            }

            include __DIR__.'/subscribe.php';
        }
        ?>
    </div>
</div>

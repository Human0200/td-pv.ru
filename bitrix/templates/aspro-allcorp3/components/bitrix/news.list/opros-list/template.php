<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<?if($arResult['ITEMS']){?>
    <div class="designer-docs-list">
        <?php foreach ($arResult['ITEMS'] as $item){?>
            <?php
                $file = \CFIle::GetPath($item['PROPERTIES']['FILE']['VALUE']);
                if(empty($file)) continue;
                $type = explode(".", $file)[1];
            ?>
            <?php $img = \CFile::ResizeImageGet($item['PREVIEW_PICTURE']["ID"], array( "width" => 70, "height" => 70 ), BX_RESIZE_IMAGE_PROPORTIONAL,true );?>
            <div class="designer-docs-item">
                <div class="designer-docs-item-img">
                    <img src="<?=$img['src']?>" alt="<?=$item['NAME']?>">
                </div>
                <div class="designer-docs-item-text"><?=$item['~PREVIEW_TEXT']?></div>
                <div class="designer-docs-item-link">
                    <span class="designer-docs-item-icon"><?=$type?></span>
                    <a href="<?=$file?>" target="_blank" class="designer-docs-item-title"><?=$item['NAME']?></a>
                </div>
            </div>
        <?php }?>
    </div>
<?php }?>
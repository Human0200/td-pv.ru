<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? $this->setFrameMode( true ); ?>
<?if( !empty( $arResult ) ){?>
	<ul class="menu-topest">
		<?
		$counter = 1;
		foreach( $arResult as $key => $arItem ){?>
			<li class="menu-topest__item <?=$arItem["SELECTED"] ? 'current' : ''?> <?=$counter == 1 ? 'menu-topest__item--first' : ''?> <?=$counter == count($arResult) ? 'menu-topest__item--last' : ''?>">
				<a class="dark_link banner-light-text light-opacity-hover menu-light-text menu-topest__link" href="<?=$arItem["LINK"]?>"<?=$arItem['ATTRIBUTE']?>><span><?=$arItem["TEXT"]?></span></a>
			</li>
		<?
		$counter++;
		}?>
		<li class="menu-topest__more hidden">
			<span class="banner-light-text menu-light-text light-opacity-hover">...</span>
			<ul class="dropdown"></ul>
		</li>
	</ul>
<?}?>
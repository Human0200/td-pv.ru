<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Localization\Loc;

$bGallery = boolval($GLOBALS['arRegion']);
?>
<div class="contacts-v1 contacts-detail" itemscope itemtype="http://schema.org/Organization">
	<?//hidden text for validate microdata?>
	<div class="hidden">
		<?global $arSite;?>
		<span itemprop="name"><?=$arSite["NAME"]?></span>
	</div>

	<div class="contacts__row">
		<div class="contacts__col">
			<div class="contacts__content-wrapper">
				<div class="contacts-detail__image rounded-4<?=($bGallery ? ' contacts-detail__image--gallery' : '')?>">
					<?CAllcorp3::showContactImg($bGallery);?>
				</div>
				<div class="contacts-detail__info">
					<div class="contacts-detail__properties">
						<div class="contacts__col">
							<div class="contacts-detail__property">
								<?CAllcorp3::showContactAddr(Loc::getMessage('T_CONTACTS_ADDRESS'), false);?>
							</div>
							<div class="contacts-detail__property">
								<?CAllcorp3::showContactSchedule(Loc::getMessage('T_CONTACTS_SCHEDULE'), false);?>
							</div>
						</div>
						<div class="contacts__col">
							<div class="contacts-detail__property">
								<?CAllcorp3::showContactPhones(Loc::getMessage('T_CONTACTS_PHONE'), false);?>
							</div>
							<div class="contacts-detail__property">
								<?CAllcorp3::showContactEmail(Loc::getMessage('T_CONTACTS_EMAIL'), false);?>
							</div>
						</div>
					</div>
				</div>
				<div class="contacts-detail__social">
					<?$APPLICATION->IncludeComponent(
						"aspro:social.info.allcorp3",
						".default",
						array(
							"CACHE_TYPE" => "A",
							"CACHE_TIME" => "3600000",
							"CACHE_GROUPS" => "N",
							"COMPONENT_TEMPLATE" => ".default",
							'SVG' => false,
							'IMAGES' => true,
							'ICONS' => true,
							'SIZE' => 'large',
							'HIDE_MORE' => false,
						),
						false
					);?>
				</div>
				<div class="contacts-detail__description">
					<?=CAllcorp3::showContactDesc();?>
					<?if($bUseFeedback):?>
						<div class="contacts-detail__btn-wrapper">
							<span>
								<span class="btn btn-default btn-transparent-border bg-theme-target border-theme-target animate-load" data-event="jqm" data-param-id="aspro_allcorp3_question" data-name="question"><?=Loc::getMessage('T_CONTACTS_QUESTION1')?></span>
							</span>
						</div>
					<?endif;?>
				</div>
			</div>
		</div>
		<?if($bUseMap):?>
		<div class="contacts__map-wrapper">
			<div class="sticky-block contacts_map-sticky rounded-4 bordered">
				<?$APPLICATION->IncludeFile(SITE_DIR . "include/contacts-site-map-".(CAllcorp3::GetFrontParametrValue('CONTACTS_TYPE_MAP') == 'GOOGLE' ? 'google' : 'yandex').".php", array(), array("MODE" => "html", "TEMPLATE" => "include_area.php", "NAME" => "Map"));?>
			</div>
		</div>
	<?endif;?>
	</div>

	<?/*if($bUseMap):?>
		<div class="contacts__map-wrapper">
			<?$APPLICATION->IncludeFile(SITE_DIR . "include/contacts-site-map-".(CAllcorp3::GetFrontParametrValue('CONTACTS_TYPE_MAP') == 'GOOGLE' ? 'google' : 'yandex').".php", array(), array("MODE" => "html", "TEMPLATE" => "include_area.php", "NAME" => "Map"));?>
		</div>
	<?endif;*/?>
</div>
<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?
if($arResult['ITEMS'] && ((isset($arParams['PAGE']) && $arParams['PAGE']) && (isset($arParams['USE_FILTER_ELEMENTS']) && $arParams['USE_FILTER_ELEMENTS'] == 'Y')))
{
	foreach($arResult['ITEMS'] as $key => $arItem)
	{
		if(isset($arItem['PROPERTIES']['URL']['VALUE']))
		{
			$unset = true;
			if(!is_array($arItem['PROPERTIES']['URL']['VALUE']))
				$arItem['PROPERTIES']['URL']['VALUE'] = array($arItem['PROPERTIES']['URL']['VALUE']);
			if($arItem['PROPERTIES']['URL']['VALUE'])
			{
				foreach($arItem['PROPERTIES']['URL']['VALUE'] as $url)
				{
					$url=str_replace('SITE_DIR', SITE_DIR, $url);
					if($arItem['PROPERTIES']['URL_NOT_SHOW']['VALUE'])
					{
						if(!is_array($arItem['PROPERTIES']['URL_NOT_SHOW']['VALUE']))
							$arItem['PROPERTIES']['URL_NOT_SHOW']['VALUE'] = array($arItem['PROPERTIES']['URL_NOT_SHOW']['VALUE']);
						foreach($arItem['PROPERTIES']['URL_NOT_SHOW']['VALUE'] as $url_not_show)
						{
							$url_not_show=str_replace('SITE_DIR', SITE_DIR, $url_not_show);
							if(CSite::InDir($url_not_show))
								unset($arResult['ITEMS'][$key]);
							else
							{
								if(CSite::InDir($url))
									$unset = false;
							}
						}
					}
					else
					{
						if(CSite::InDir($url))
							$unset = false;
					}
				}
			}
			if($unset && isset($arResult['ITEMS'][$key]))
				unset($arResult['ITEMS'][$key]);
		}
	}
}?>
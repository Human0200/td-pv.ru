<?
use Bitrix\Main\SystemException,
	Bitrix\Main\Web\HttpClient;

class CAsproYoutube extends CBitrixComponent
{
	const URL_YOUTUBE_API = 'https://www.googleapis.com/youtube/v3/';

	public $access_token = 0;
	public $channel_id = 0;
	public $playlist_id = 0;
	public $count_post = 5;
	public $error = "";
	public $sort = "";
	public $App;

	public function checkApiToken(){
		if(!strlen($this->access_token)){
			$this->error="No API token youtube";
		}
	}

	private function getFormatResult(array $arOptions =[]){
		$arDefaultOptions = [
			'method' => '',
			'part' => '',
			'playlist' => '',
			'channel' => '',
			'addUrlParams' => ''
		];
		$arConfig = array_merge($arDefaultOptions, $arOptions);
		
		if($arConfig['playlist']) {
			$urlEnd = '&playlistId='.$arConfig['playlist'];
		} else {
			$urlEnd = '&order='.$this->sort.'&type=video';
		}

		$url = self::URL_YOUTUBE_API.$arConfig['method'].'?key='.$this->access_token.'&channelId='.$this->channel_id.'&part='.$arConfig['part'].'&maxResults='.$this->count_post.$urlEnd;

		if($arConfig['channel']){
			$url = self::URL_YOUTUBE_API.$arConfig['method'].'?key='.$this->access_token.'&id='.$this->channel_id.'&part='.$arConfig['part'];
		}

		if($arConfig['addUrlParams']){
			$url.= '&'.$arConfig['addUrlParams'];
		}		
		
		try{
			$http = new HttpClient();
			$http->setTimeout(30);
			$http->setStreamTimeout(30);
			$data = $http->get($url);
		}
		catch(SystemException $e){
			$data = '';
		}
		
		$data = json_decode($data, true);
		$data = $this->App->ConvertCharsetArray($data, 'UTF-8', LANG_CHARSET);

		return $data;
	}

	public function getYoutubeVideos(){
		$data=$this->getFormatResult(['method' => 'search', 'part' => 'id']);

		return $data;
	}

	public function getYoutubeVideosByPlaylist(){
		$data=$this->getFormatResult(['method' => 'playlistItems', 'part' => 'snippet', 'playlist' => $this->playlist_id]);

		return $data;
	}

	public function getYoutubeVideosWithDetails($arItems){
		$data = [];
		if(isset($arItems[0]['id']['videoId'])){
			$arVideoIds = array_column(array_column($arItems, 'id'), 'videoId');
			$strVideoIds = implode(',', $arVideoIds);
			$addUrlParams = 'id=' . $strVideoIds;
			$data = $this->getFormatResult(['method' => 'videos', 'part' => 'snippet', 'addUrlParams' => $addUrlParams]);
		}

		return $data;
	}

	public function getYoutubeVideosBySearch(){
		$arYoutubeVideos = $this->getYoutubeVideos();
		if(!$arYoutubeVideos['error'] && !empty($arYoutubeVideos["items"])){
			$arYoutubeVideos = $this->getYoutubeVideosWithDetails($arYoutubeVideos["items"]);
		}
		
		return $arYoutubeVideos;
	}

	public function getYoutubeChannelInfo(){
		$data=$this->getFormatResult(['method' => 'channels', 'part' => 'snippet,statistics,brandingSettings', 'channel' => true]);

		return $data;
	}

	public function arResultSet(){			
			global $APPLICATION;
			$this->access_token = $this->arParams["API_TOKEN_YOUTUBE"];
			$this->channel_id = $this->arParams["CHANNEL_ID_YOUTUBE"];
			$this->sort = $this->arParams["SORT_YOUTUBE"];
			$this->playlist_id = $this->arParams["PLAYLIST_ID_YOUTUBE"];
			$this->count_post = $this->arParams["COUNT_VIDEO_YOUTUBE"];
			$this->App = $APPLICATION;

			if($this->playlist_id) {
				$arYoutubeVideos = $this->getYoutubeVideosByPlaylist();
			} else {
				$arYoutubeVideos = $this->getYoutubeVideosBySearch();
			}

			if(!empty($arYoutubeVideos)){
				if($arYoutubeVideos['error']){
					$this->AbortResultCache();
					$arResult['ERRORS']['MESSAGE'] = $arYoutubeVideos['error']['errors'][0]['message'];
					$arResult['ERRORS']['REASON'] = $arYoutubeVideos['error']['errors'][0]['reason'];
				} else {
					foreach($arYoutubeVideos['items'] as $key => $video):						
						if(!empty($video['snippet']['thumbnails']['standard'])){
							$arResult['ITEMS'][$key]['IMAGE'] = $video['snippet']['thumbnails']['standard']['url'];
						} else {
							$arResult['ITEMS'][$key]['IMAGE'] = $video['snippet']['thumbnails']['high']['url'];
						}
						$arResult['ITEMS'][$key]['DATE_FROM'] = $video['snippet']['publishedAt'];
						$arResult['ITEMS'][$key]['TITLE'] = $video['snippet']['title'];
						$arResult['ITEMS'][$key]['ID'] = $video['snippet']['resourceId']['videoId'] ?? $video['id'];
					endforeach;
				}
			}

			//comment this because we don't use it in our template now
			if(!$this->channel_id){
				$arChannelInfo = $this->getYoutubeChannelInfo();

				if($arChannelInfo['error']){
					$this->AbortResultCache();
					$arResult['ERRORS']['MESSAGE'] = $arChannelInfo['error']['errors'][0]['message'];
					$arResult['ERRORS']['REASON'] = $arChannelInfo['error']['errors'][0]['reason'];
				} else {
					$arResult['CHANNEL_INFO']['BANNER'] = $arChannelInfo['items'][0]['brandingSettings']['image'];
					$arResult['CHANNEL_INFO']['TITLE'] = $arChannelInfo['items'][0]['snippet']['title'];
					$arResult['CHANNEL_INFO']['DESCRIPTION'] = $arChannelInfo['items'][0]['snippet']['description'];
					$arResult['CHANNEL_INFO']['ICON'] = $arChannelInfo['items'][0]['snippet']['thumbnails'];
					$arResult['CHANNEL_INFO']['SUBSCRIBERS'] = static::numberPrepare($arChannelInfo['items'][0]['statistics']['subscriberCount']);
					$arResult['CHANNEL_INFO']['VIDEO_COUNT'] = static::numberPrepare($arChannelInfo['items'][0]['statistics']['videoCount']);
					$arResult['CHANNEL_INFO']['VIEW_COUNT'] = static::numberPrepare($arChannelInfo['items'][0]['statistics']['viewCount']);

					$arResult['SUBSCRIBE_BUTTON'] = '<script src="https://apis.google.com/js/platform.js"></script><div class="g-ytsubscribe" data-channelid="'.$this->channel_id.'" data-layout="default" data-count="default"></div>';
				}
			}
			$arResult['RIGHT_LINK'] = "https://www.youtube.com/channel/";

		return $arResult;
	}

    public function executeComponent()
    {
        if($this->startResultCache())
        {
            $this->arResult = $this->arResultSet();
            $this->includeComponentTemplate();
        }
        return $this->arResult;
    }

	public static function numberPrepare($number) {
		if((int)$number >= 1000000) {
			return (int)($number/1000000).'M';
		} else if((int)$number >= 1000) {
			return (int)($number/1000).'K';
		} else if((int)$number < 1000) {
			return (int)($number);
		}
	}
};
?>
<?php
	error_reporting(0);
	include_once('queryelements.php');
	class GetAppInfoAPI {
	
	
		private $base_googleplay_url = 'https://play.google.com';
		private $base_appstore_url = 'https://itunes.apple.com/de/';
		private $base_windowsstore_url = 'http://apps.microsoft.com/';
		private $base_windowsphonestore_url = 'http://www.windowsphone.com/de-de/store/';
		
		
		function is_cached($id) {
			$cachefile = $this->get_cache_filename($id);
			$contcachetime = WPAPPBOX_CONT_CACHINGTIME*60*60;
			if (is_readable($cachefile) && (time() - $contcachetime < filemtime($cachefile))) return true;
			else return false;
		}
		
		
		function get_cache_filename($id) {
			return WPAPPBOX_CONTENT_DIR.$id.".desc";
		}
		
		
		function get_cached_file($id){
			return(unserialize(file_get_contents($this->get_cache_filename($id))));
		}
		
		
		function save_cached_file($id, $appinfo) {
			foreach($appinfo['General'] as $appdata) {
				if(trim($appdata->app_title) != '') file_put_contents($this->get_cache_filename($id), serialize($appinfo), LOCK_EX );
			}
		}
		
		
		function get_fcontent($url, $javascript_loop = 0, $timeout = 5) {
			$url = str_replace("&amp;", "&", urldecode(trim($url)));
			$cookie = tempnam ("/tmp", "CURLCOOKIE");
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
			curl_setopt($ch, CURLOPT_ENCODING, "");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_AUTOREFERER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
			$content = curl_exec($ch);
			$response = curl_getinfo($ch);
			curl_close ($ch);
			if ($response['http_code'] == 301 || $response['http_code'] == 302) {
				ini_set("user_agent", "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
				if ($headers = get_headers($response['url'])) {
					foreach($headers as $value) {
						if (substr( strtolower($value), 0, 9) == "location:") return $this->get_fcontent(trim(substr($value, 9, strlen($value))));
					}
				}
			}
			if (( preg_match("/>[[:space:]]+window\.location\.replace\('(.*)'\)/i", $content, $value) || preg_match("/>[[:space:]]+window\.location\=\"(.*)\"/i", $content, $value) ) && $javascript_loop < 5) return $this->get_fcontent( $value[1], $javascript_loop+1 );
			else return array( $content, $response );
		}
		
		
		function getGooglePlay($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_file($item_id));
			$thestoreurl = 'https://play.google.com/store/apps/details?id=';
			$page_url = $thestoreurl.$item_id;
			$this_content = $this->get_fcontent($page_url);
			$pos = strpos($this_content[1]['url'], 'http://www.google.com/sorry/?continue');
			if(strpos($this_content[1]['url'], 'http://www.google.com/sorry/?continue') !== false) {
				$app_info['General'][] = (object) array(
					'app_store_url' => $page_url,
					'banner_image' => $banner_image, 
					'banner_icon' => $banner_icon, 
					'app_title' => 'Download im Play Store', 
					'app_author' => '', 
					'author_store_url' => '',
					'app_price' => '',
					'storename' => 'Google Play',
					'storename_css' => 'googleplay',
					'fallback' => '1'
				);
				//$this->save_cached_file($item_id, $app_info);
				return $app_info;
			}
			elseif((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found != '') return 0;
				$banner_image = pq('.doc-banner-image-container > img')->attr('src');
				$banner_icon = pq('.doc-banner-icon > img')->attr('src');
				$app_title = pq('.doc-banner-title')->html();
				$app_author = pq('.doc-header-link')->html();
				$author_store_url = $this->base_googleplay_url.''.pq('.doc-header-link')->attr('href');
				$app_price = pq('.buy-button-price')->html();
				if(strpos($app_price, 'Install') !== false) $app_price = 'Kostenlos';
				$app_price = str_replace('Übersetzen', '', $app_price);
				$app_price = str_replace('kaufen', '', $app_price);
				$app_price = str_replace('Für ', '', $app_price);
				foreach(pq('.screenshot-image-wrapper > img') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('src');
					$app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				$app_store_url = $page_url;
				$app_info['General'][] = (object) array(
					'app_store_url' => $app_store_url,
					'banner_image' => $banner_image, 
					'banner_icon' => $banner_icon, 
					'app_title' => $app_title, 
					'app_author' => $app_author, 
					'author_store_url' => $author_store_url,
					'app_price' => $app_price,
					'storename' => 'Google Play',
					'storename_css' => 'googleplay',
					'fallback' => '0'
				);
				$this->save_cached_file($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		function getAndroidPit($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_file($item_id));
			$thestoreurl = 'http://www.androidpit.de/de/android/market/apps/app/';
			$page_url = $thestoreurl.$item_id;
			$this_content = $this->get_fcontent($page_url);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq(".httpErrorFooter")->text();
				if($error_found != '') return 0;
				$banner_image = pq('div.detailHead div.visual img')->attr('src');
				$banner_icon = pq('div.detailHead div.appIcon > img')->attr('src');
				$app_title = pq('div.titleAndOwner > h1')->html();
				$app_author = pq('div.titleAndOwner span.brand')->html();
				$author_store_url = pq('div.titleAndOwner a')->attr('href');
				$app_price = pq('div.subData > div.data > span.price')->html();
				if(strpos($app_price, 'EUR') !== false) $app_price = str_replace('EUR ', '', $app_price).' €';
				if(trim($app_price) == '') $app_price = 'Kostenlos';
				foreach(pq('div.screenshot a[rel="screenshots"]') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('href');
					$app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				$app_store_url = $page_url;
				$app_info['General'][] = (object) array(
					'app_store_url' => $app_store_url,
					'banner_image' => $banner_image, 
					'banner_icon' => $banner_icon, 
					'app_title' => $app_title, 
					'app_author' => $app_author, 
					'author_store_url' => $author_store_url,
					'app_price' => $app_price,
					'storename' => 'AndroidPit',
					'storename_css' => 'androidpit',
					'fallback' => '0'
				);
				$this->save_cached_file($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		function getAppWorld($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_file($item_id));
			$thestoreurl = 'http://appworld.blackberry.com/webstore/content/screenshots/';
			$page_url = $thestoreurl.$item_id.'/?lang=de';
			$this_content = $this->get_fcontent($page_url);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("ul.awErrorLi")->text();
				if($error_found != '') return 0;
				$banner_icon = 'http://appworld.blackberry.com'.pq('div#appIcon > img')->attr('src');
				$app_title = pq('pre.apptitle')->html();
				$app_author = pq('pre.awAppInfoVendor > a > span.sitelink')->html();
				$author_store_url = pq('pre.awAppInfoVendor > a.vendorlink')->attr('href');
				$app_price = ucfirst(strtolower(pq('div#priceArea > div')->html()));
				if(strpos('Us$', $app_price)) $app_price = str_replace('Us$', '', $app_price).' $';
				foreach(pq('div#screenshot_slider div.imageScreenshot > a > img') as $appshots) {
					$app_screen_shots = 'http://appworld.blackberry.com'.str_replace('?t=1', '?t=2', pq($appshots)->attr('src'));
					$app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				$app_store_url = str_replace('screenshots/', '', $page_url);
				$app_info['General'][] = (object) array(
					'app_store_url' => $app_store_url,
					'banner_image' => $banner_image, 
					'banner_icon' => $banner_icon, 
					'app_title' => $app_title, 
					'app_author' => $app_author, 
					'author_store_url' => $author_store_url,
					'app_price' => $app_price,
					'storename' => 'AppWorld',
					'storename_css' => 'bbappworld',
					'fallback' => '0'
				);
				$this->save_cached_file($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		function getAppStore($item_id) {
			if(substr($item_id, 0, 2) == 'id') $item_id = substr($item_id, 2);
			if($this->is_cached($item_id)) return($this->get_cached_file($item_id));
			$thestoreurl = 'https://itunes.apple.com/de/app/id';
			$page_url = $thestoreurl.$item_id;
			$this_content = $this->get_fcontent($page_url);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#desktopContentBlockId")->text();
				if($error_found == '') return 0;
				if(pq('meta[property="og:site_name"]')->attr('content') == 'Mac App Store') $ismas = true;
				else $ismas = false;
				$banner_icon = pq('div#left-stack > div.product > a > div.artwork > img')->attr('src');
				$app_title = pq('div#title > div.left > h1')->html();
				$app_author = str_replace('von ', '', pq('div#title > div.left > h2')->html());
				$author_store_url = pq('div#title > div.right > a.view-more')->attr('href');
				$app_price = pq('div.price')->html();
				foreach(pq('div.screenshots > div.content > div > div > img') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('src');
					$app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				foreach(pq('div.screenshots > div.toggle > div.content > div > div > img') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('src');
					$app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				$app_store_url = pq('link[rel="canonical"]')->attr('href');
				$app_info['General'][] = (object) array(
					'app_store_url' => $app_store_url,
					'banner_icon' => $banner_icon, 
					'app_title' => $app_title, 
					'app_author' => $app_author, 
					'author_store_url' => $author_store_url,
					'app_price' => $app_price,
					'fallback' => '0'
				);
				if(!$ismas) {
					$app_info['General'][] = (object) array(
						'storename' => 'App Store',
						'storename_css' => 'appstore'
					);
				}
				else {
					$app_info['General'][] = (object) array(
						'storename' => 'Mac App Store',
						'storename_css' => 'macappstore'
					);
				}
				$this->save_cached_file($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		function getWindowsPhone($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_file($item_id));
			$thestoreurl = 'http://www.windowsphone.com/de-DE/store/app/app/';
			$page_url = $thestoreurl.$item_id;
			$this_content = $this->get_fcontent($page_url);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq(".content-container")->text();
				if($error_found != '') return 0;
				$banner_icon = pq('img.appImage')->attr('src');
				$app_title = pq('h1[itemprop="name"]')->html();
				$app_author = pq('a[itemprop="publisher"]')->html();
				$author_store_url = pq('a[itemprop="publisher"]')->attr('href');
				$app_price = trim(pq('span[itemprop="price"]')->html());
				if($app_price == 'Free') $app_price = 'Kostenlos';
				foreach(pq('#screenshots > ul > li > a') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('href');
					$app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				$app_store_url = $page_url;
				$app_info['General'][] = (object) array(
					'app_store_url' => $app_store_url,
					'banner_icon' => $banner_icon, 
					'app_title' => $app_title, 
					'app_author' => $app_author, 
					'author_store_url' => $author_store_url,
					'app_price' => $app_price,
					'storename' => 'WP8 Store',
					'storename_css' => 'windowsphonestore',
					'fallback' => '0'
				);
				$this->save_cached_file($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		function getWindowsStore($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_file($item_id));
			$thestoreurl = 'http://apps.microsoft.com/webpdp/de-DE/app/';
			$page_url = $thestoreurl.$item_id;
			$this_content = $this->get_fcontent($page_url);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq(".content-container")->text();
				if($error_found != '') return 0;
				$banner_icon = pq('#AppLogo > img')->attr('src');
				$app_title = pq('#ProductTitleText')->html();
				$app_author = pq('#AppDeveloperText')->html();
				$author_store_url = '';
				$app_price = trim(pq('#Price')->html());
				if($app_price == 'Free') $app_price = 'Kostenlos';
				foreach(pq('#ScreenshotImageButtons > a') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('imgurl');
					$app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				$app_store_url = $page_url;
				$app_info['General'][] = (object) array(
					'app_store_url' => $app_store_url,
					'banner_icon' => $banner_icon, 
					'app_title' => $app_title, 
					'app_author' => $app_author, 
					'author_store_url' => $app_store_url,
					'app_price' => $app_price,
					'storename' => 'Windows Store',
					'storename_css' => 'windowsstore',
					'fallback' => '0'
				);
				$this->save_cached_file($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
	}
?>
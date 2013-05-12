<?php
	
	error_reporting(0);
	include_once('queryelements.php');
	class GetAppInfoAPI {
		
		function get_cache_name($id) {
			return(WPAPPBOX_CACHE_PREFIX.md5($id));
		}
		
		
		function is_cached($id) {
			if(cache_deactive()) return false;
			if(get_transient($this->get_cache_name($id)) != false) return true;
			else return false;
		}
		
		
		function get_cached_data($id){
			return(get_transient($this->get_cache_name($id)));
		}
		
		
		function save_data_to_cache($id, $appinfo) {
			if(cache_deactive()) return(false);
			foreach($appinfo['General'] as $appdata) {
				if(trim($appdata->app_title) != '') set_transient($this->get_cache_name($id), $appinfo, WPAPPBOX_DATA_CACHINGTIME*60);
			}
		}
		
		
		function get_fcontent($url, $javascript_loop = 0, $timeout = 5) {
			$url = str_replace("&amp;", "&", trim($url));
			$cookie = tempnam ("/tmp", "CURLCOOKIE");
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
			curl_setopt($ch, CURLOPT_ENCODING, "");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_AUTOREFERER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
			if(ini_get('open_basedir') == '' && !ini_get('safe_mode')) curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
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
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$thestoreurl = 'https://play.google.com/store/apps/details?id=';
			$page_url = $thestoreurl.$item_id;
			$this_content = $this->get_fcontent(urldecode($page_url));
			if(WPAPPBOX_ERRROR_PARSEOUTPUT == '1') print_r($this_content);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found != '') return 0;
				$banner_image = pq('.doc-banner-image-container > img')->attr('src');
				$banner_icon = pq('.doc-banner-icon > img')->attr('src');
				$app_title = pq('.doc-banner-title')->html();
				$app_author = pq('.doc-header-link')->html();
				$author_store_url = 'https://play.google.com'.pq('.doc-header-link')->attr('href');
				$app_price = pq('span[itemprop="price"]')->attr('content');
				if($app_price == '0') $app_price = __('Kostenlos', 'wp-appbox');
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
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			if(($this_content[1]['http_code'] == '503') || ($this_content[1]['http_code'] == '302')) {
				$app_info['General'][] = (object) array(
					'app_store_url' => $page_url,
					'banner_image' => $banner_image, 
					'banner_icon' => $banner_icon, 
					'app_title' => __('Download', 'wp-appbox').' @ Play Store', 
					'app_author' => '', 
					'author_store_url' => '',
					'app_price' => '',
					'storename' => 'Google Play',
					'storename_css' => 'googleplay',
					'fallback' => '1'
				);
				//$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			return 0;
		}
		
		
		function getFirefoxMarketplace($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$thestoreurl = 'https://marketplace.firefox.com/app/';
			$page_url = $thestoreurl.$item_id.'/?src=mkt-home';
			$this_content = $this->get_fcontent(urldecode($page_url));
			if(WPAPPBOX_ERRROR_PARSEOUTPUT == '1') print_r($this_content);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq(".httpErrorFooter")->text();
				if($error_found != '') return 0;
				$banner_icon = pq('section.main > div > img.icon')->attr('src');
				$app_title = pq('section.main > div > div.info > h3')->html();
				$app_author = pq('section.main > div > div.info > div.author')->html();
				$author_store_url = $page_url;
				$app_price = __('Kostenlos', 'wp-appbox');
				foreach(pq('link[rel="prefetch"]') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('href');
					if(Trim($app_screen_shots) != '') $app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				$app_store_url = $page_url;
				$app_info['General'][] = (object) array(
					'app_store_url' => $app_store_url,
					'banner_icon' => $banner_icon, 
					'app_title' => $app_title, 
					'app_author' => $app_author, 
					'author_store_url' => $author_store_url,
					'app_price' => $app_price,
					'storename' => 'FF Marketplace',
					'storename_css' => 'firefoxmarketplace',
					'fallback' => '0'
				);
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		function getAndroidPit($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$thestoreurl = 'http://www.androidpit.de/de/android/market/apps/app/';
			$page_url = $thestoreurl.$item_id;
			$this_content = $this->get_fcontent(urldecode($page_url));
			if(WPAPPBOX_ERRROR_PARSEOUTPUT == '1') print_r($this_content);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq(".httpErrorFooter")->text();
				if($error_found != '') return 0;
				$app_store_url = pq('span[itemprop="url"]')->attr('content');
				$banner_image = pq('div.detailHead div.visual img')->attr('src');
				$banner_icon = pq('div.detailHead div.appIcon > img')->attr('src');
				$app_title = pq('div.titleAndOwner > h1')->html();
				$app_author = pq('div.titleAndOwner span.brand')->html();
				$author_store_url = pq('div.titleAndOwner a')->attr('href');
				$app_price = pq('div.subData > div.data > span.price')->html();
				if(strpos($app_price, 'EUR') !== false) $app_price = str_replace('EUR ', '', $app_price).' €';
				if(trim($app_price) == '') $app_price = __('Kostenlos', 'wp-appbox');
				foreach(pq('div.screenImage a') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('href');
					if(Trim($app_screen_shots) != '') $app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
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
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		function getBlackBerryWorld($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$thestoreurl = 'http://appworld.blackberry.com/webstore/content/';
			$page_url = $thestoreurl.$item_id.'/?lang=de';
			$this_content = $this->get_fcontent(urldecode($page_url));
			if(WPAPPBOX_ERRROR_PARSEOUTPUT == '1') print_r($this_content);
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
					'storename' => 'BB World',
					'storename_css' => 'blackberryworld',
					'fallback' => '0'
				);
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		function getAppStore($item_id) {
			$options = get_option('wpAppbox');
			if(substr($item_id, 0, 2) == 'id') $item_id = substr($item_id, 2);
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$thestoreurl = 'https://itunes.apple.com/de/lookup?id=';
			$page_url = $thestoreurl.$item_id;
			$this_content = $this->get_fcontent(urldecode($page_url));
			$this_content = json_decode($this_content[0]);
			if(WPAPPBOX_ERRROR_PARSEOUTPUT == '1') print_r($this_content);
			if($this_content->resultCount == '1') {
				$this_content = $this_content->results[0];
				if($this_content->kind == 'mac-software') $ismas = true;
				else $ismas = false;
				$banner_icon = $this_content->artworkUrl100;
				$app_title = $this_content->trackName;
				$app_author = $this_content->artistName;
				$author_store_url = $this_content->artistViewUrl;
				$app_price = $this_content->formattedPrice;
				foreach($this_content->screenshotUrls as $appshots) {
					$app_info['ScreenShots'][] = (object) array('screen_shot' => $appshots);
				}
				foreach($this_content->ipadScreenshotUrls as $appshots) {
					$app_info['ScreenShots'][] = (object) array('screen_shot' => $appshots);
				}
				$app_store_url = $this_content->trackViewUrl;
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
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		function getWindowsPhone($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$thestoreurl = 'http://www.windowsphone.com/de-de/store/app/app/';
			$page_url = $thestoreurl.$item_id;
			$this_content = $this->get_fcontent(urldecode($page_url));
			if(WPAPPBOX_ERRROR_PARSEOUTPUT == '1') print_r($this_content);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq(".content-container")->text();
				if($error_found != '') return 0;
				$banner_icon = pq('img.appImage')->attr('src');
				$app_title = pq('h1[itemprop="name"]')->html();
				$app_author = pq('a[itemprop="publisher"]:first')->html();
				$author_store_url = pq('a[itemprop="publisher"]:first')->attr('href');
				$app_price = trim(pq('span[itemprop="price"]')->html());
				if($app_price == 'Free') $app_price = __('Kostenlos', 'wp-appbox');
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
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		function getSamsungApps($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$thestoreurl = 'http://apps.samsung.com/earth/topApps/topAppsDetail.as?productId=';
			$page_url = $thestoreurl.$item_id;
			$this_content = $this->get_fcontent(urldecode($page_url));
			if(WPAPPBOX_ERRROR_PARSEOUTPUT == '1') print_r($this_content);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				if(pq('meta[property="og:title"]')->attr('content') == '') $error_found = true;
				if($error_found) return 0;
				$app_title = trim(pq('meta[property="og:title"]')->attr('content'));
				$banner_icon = pq('meta[property="og:image"]')->attr('content');
				$app_author = trim(pq('a[class="seller-name"]')->html());
				$author_store_url = $page_url;
				if(pq('p[id="layerPrice"]')->attr('class') == 'free') $app_price = __('Kostenlos', 'wp-appbox');
				else $app_price = trim(pq('p[id="layerPrice"]')->html());
				
				foreach(pq('article#sereen ul.screen-list > li > img') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('src');
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
					'storename' => 'Samsung Apps',
					'storename_css' => 'samsungapps',
					'fallback' => '0'
				);
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		function getWindowsStore($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$thestoreurl = 'http://apps.microsoft.com/windows/de-DE/app/';
			$page_url = $thestoreurl.$item_id;
			$this_content = $this->get_fcontent(urldecode($page_url));
			if(WPAPPBOX_ERRROR_PARSEOUTPUT == '1') print_r($this_content);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq(".content-container")->text();
				if($error_found != '') return 0;
				$banner_icon = pq('#AppLogo > img')->attr('src');
				$app_title = pq('#ProductTitleText')->html();
				$app_author = pq('#AppDeveloperText')->html();
				$author_store_url = '';
				$app_price = trim(pq('#Price')->html());
				if($app_price == 'Free') $app_price = __('Kostenlos', 'wp-appbox');
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
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		function getFirefoxAddon($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$thestoreurl = 'https://addons.mozilla.org/de/firefox/addon/';
			$page_url = $thestoreurl.$item_id.'/';
			$this_content = $this->get_fcontent(urldecode($page_url));
			if(WPAPPBOX_ERRROR_PARSEOUTPUT == '1') print_r($this_content);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("title")->html();
				if($error_found == 'Nicht gefunden') return 0;
				$banner_icon = pq('img[itemprop="image"]')->attr('src');
				$app_title = pq('span[itemprop="name"]:first')->html();
				$app_author = pq('h4[class="author"] > a')->html();
				$author_store_url = pq('h4[class="author"] > a')->attr('href');
				$app_price = __('Kostenlos', 'wp-appbox');
				foreach(pq('section.previews > div.carousel > ul > li > a') as $appshots) {
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
					'storename' => 'Firefox Add-ons',
					'storename_css' => 'firefoxaddon',
					'fallback' => '0'
				);
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		//EXPERIMENTELL
		function getChromeWebStore($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$thestoreurl = 'https://chrome.google.com/webstore/detail/';
			$page_url = $thestoreurl.$item_id.'?hl=de';
			$this_content = $this->get_fcontent(urldecode($page_url));
			if($this_content[1]['http_code'] == '0') $this_content = $this->get_fcontent(urldecode('https://chrome.google.com'.$this_content[1]['url']));
			if(WPAPPBOX_ERRROR_PARSEOUTPUT == '1') print_r($this_content);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found != '') return 0;
				print_r(pq('div[slideIndex="0"]')->html());
				$banner_icon = pq('meta[property="og:image"]')->attr('content');
				$app_store_url = pq('meta[property="og:url"]')->attr('content');
				$app_title = pq('meta[property="og:title"]')->attr('content');
				if(pq('a[class="webstore-tb-ub-e"]')->html() != ''):
					$app_author = pq('a[class="webstore-tb-ub-e"]')->html();
					$author_store_url = pq('a[class="webstore-tb-ub-e"]')->attr('href');
				elseif(pq('div.webstore-tb-ub-ic')->html() != ''):
					$app_author = pq('div.webstore-tb-ub-ic')->html();
					$author_store_url = pq('div.webstore-tb-ub-ic')->html();
					$author_store_url = str_replace('von ', 'http://', $author_store_url);
				else:
					$app_author = __('Unbekannt', 'wp-appbox');
					$author_store_url = $app_store_url;
				endif;
				$app_author = str_replace('von ', '', $app_author);
				$app_author = str_replace('http://', '', $app_author);
				$app_author = str_replace('https://', '', $app_author);
				$app_price = __('Kostenlos', 'wp-appbox');
				foreach(pq('img.slideshow-slide-image-new-size') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('src');
					$app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				$app_info['General'][] = (object) array(
					'app_store_url' => $app_store_url,
					'banner_icon' => $banner_icon, 
					'app_title' => $app_title, 
					'app_author' => $app_author, 
					'author_store_url' => $author_store_url,
					'app_price' => $app_price,
					'storename' => 'Chrome Web Store',
					'storename_css' => 'chromewebstore',
					'fallback' => '0'
				);
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			if(($this_content[1]['http_code'] == '503') || ($this_content[1]['http_code'] == '302')) {
				$app_info['General'][] = (object) array(
					'app_store_url' => $page_url,
					'banner_icon' => $banner_icon, 
					'app_title' => __('Download', 'wp-appbox').' @ Chrome Web Store', 
					'app_author' => '', 
					'author_store_url' => '',
					'app_price' => '',
					'storename' => 'Chrome Web Store',
					'storename_css' => 'chromewebstore',
					'fallback' => '1'
				);
				//$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			return 0;
		}
		
		
	}
?>
<?php
	error_reporting(0);
	
	include_once('queryelements.php');
	
	class GetAppInfoAPI {
	
		function echo_parse_output() {
			$options = get_option('wpAppbox');
			if($options['wpAppbox_error_parseoutput'] && has_user_admin_permissions()) return true;
			else false;
		}
		
		
		function StringEndsWith($check, $endStr) {
			if(!is_string($check) || !is_string($endStr) || strlen($check)<strlen($endStr)) return false;
		    	return(substr($check, strlen($check)-strlen($endStr), strlen($endStr)) === $endStr);
		}
		
		
		function get_store_url($store, $id) {
			global $store_urls;
			$options = get_option('wpAppbox');
			$func = 'wpappbox_get_'.$store.'_url';
			if(function_exists($func)) $url = $func;
			else {
				if(($options['wpAppbox_storeurl_'.$store] == '1') || ($options['wpAppbox_storeurl_'.$store] == '')) $url = $store_urls[$store][1];
				elseif(($options['wpAppbox_storeurl_'.$store] == '0') && ($options['wpAppbox_storeurl_'.$store.'_url'] != '')) $url = $options['wpAppbox_storeurl_'.$store.'_url'];
				elseif(($options['wpAppbox_storeurl_'.$store] == '0') && ($options['wpAppbox_storeurl_'.$store.'_url'] == '')) $url = $store_urls[$store][1];
				else $url = $store_urls[$store][$options['wpAppbox_storeurl_'.$store]];
			}
			$url = str_replace('{APPID}', $id, $url);
			$url = str_replace('{ID}', $id, $url);
			return($url);
		}
		
		
		function get_cache_name($id) {
			return(WPAPPBOX_CACHE_PREFIX.md5($id));
		}
		
		function is_cached($id) {
			if(is_admin() || cache_deactive() || create_new_cache($id)) return false;
			if(get_transient($this->get_cache_name($id)) != false) return true;
			else return false;
		}
		
		
		function get_cached_data($id){
			return(get_transient($this->get_cache_name($id)));
		}
		
		
		function save_data_to_cache($id, $appinfo) {
			if(cache_deactive()) return(false);
			array_push($appinfo['General'], array("wp-appbox-version" => WPAPPBOX_PLUGIN_VERSION));
			foreach($appinfo['General'] as $appdata) {
				if(trim($appdata->app_title) != '') set_transient($this->get_cache_name($id), $appinfo, WPAPPBOX_DATA_CACHINGTIME*60);
			}
		}
		
		
		function get_fcontent($url, $javascript_loop = 0, $timeout = 3) {
			$options = get_option('wpAppbox');
			if(array_key_exists('wpAppbox_curl_timeout', $options)) $timeout = $options['wpAppbox_curl_timeout'];
			$url = str_replace("&amp;", "&", trim($url));
			$cookie = tempnam("/tmp", "CURLCOOKIE");
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
			curl_close($ch);
			unlink($cookie);
			if($response['http_code'] == 301 || $response['http_code'] == 302) {
				ini_set("user_agent", "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
				if($headers = get_headers($response['url'])) {
					foreach($headers as $value) {
						if(substr(strtolower($value), 0, 9) == "location:") return $this->get_fcontent(trim(substr($value, 9, strlen($value))));
					}
				}
			}
			if (( preg_match("/>[[:space:]]+window\.location\.replace\('(.*)'\)/i", $content, $value) || preg_match("/>[[:space:]]+window\.location\=\"(.*)\"/i", $content, $value)) && $javascript_loop < 5) return $this->get_fcontent($value[1], $javascript_loop+1);
			else return array($content, $response);
		}
		
		
		function getGooglePlay($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$page_url = $this->get_store_url('googleplay', $item_id);
			$page_url = str_replace('{TYPE}', 'apps', $page_url);
			$this_content = $this->get_fcontent(urldecode($page_url));
			if($this->echo_parse_output()) print_r($this_content);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found != '') return 0;
				$app_icon = pq('img.cover-image[itemprop="image"]')->attr('src');
				$app_icon = str_replace('=w300', '=w128', $app_icon);
				$app_video = str_replace('autoplay=1', 'autoplay=0', pq('span.play-action-container')->attr('data-video-url'));
				$app_title = pq('div[itemprop="name"]>div')->html();
				if(trim($app_title) == '') $app_title = pq('h1[itemprop="name"]>div')->html();
				$app_author = pq('div[itemprop="author"]>a>span[itemprop="name"]')->html();
				$author_store_url = 'https://play.google.com'.pq('div[itemprop="author"]>meta[itemprop="url"]')->attr('content');
				$app_price = pq('meta[itemprop="price"]')->attr('content');
				if((trim(pq('div.inapp-msg')->html())) != '') $app_has_iap = true;
				$app_rating = pq('meta[itemprop="ratingValue"]')->attr('content');
				if((strpos($app_price, ",") == false) && (strpos($app_price, ".") == false)) $app_price = __('Free', 'wp-appbox');
				foreach(pq('img[itemprop="screenshot"]') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('src');
					if(substr($app_screen_shots, -8, 8) == '=h310-rw') $app_screen_shots = str_replace('=h500', '', $app_screen_shots);
					$app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				$app_store_url = $page_url;
				$app_info['General'][] = (object) array(
					'app_id' => $item_id,
					'app_store_url' => $app_store_url,
					'app_icon' => $app_icon, 
					'app_video' => $app_video, 
					'app_title' => trim($app_title), 
					'app_author' => $app_author, 
					'author_store_url' => $author_store_url,
					'app_price' => $app_price,
					'app_has_iap' => $app_has_iap,
					'app_rating' => $app_rating,
					'storename' => 'Google Play',
					'storename_css' => 'googleplay',
					'fallback' => '0'
				);
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			if(($this_content[1]['http_code'] == '503') || ($this_content[1]['http_code'] == '302')) {
				$app_info['General'][] = (object) array(
					'app_id' => '0',
					'app_store_url' => $page_url,
					'app_icon' => plugins_url('wp-appbox/img/fallback/googleplay.png'), 
					'app_title' => __('Download', 'wp-appbox'), 
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
			$page_url = $this->get_store_url('firefoxmarketplace', $item_id);
			$this_content = $this->get_fcontent(urldecode($page_url));
			$this_content = json_decode($this_content[0]);
			if($this->echo_parse_output()) print_r($this_content);
			if(isset($this_content)) {
				$app_id = $this_content->id;
				$app_store_url = 'https://marketplace.firefox.com/app/'.$item_id;
				$app_title = $this_content->name;
				$app_price = $this_content->premium_type;
				if($app_price = 'free') $app_price = __('Free', 'wp-appbox');
				$app_icon = $this_content->icons->{64};
				$app_author = $this_content->author;
				$author_store_url = $this_content->support_url;
				$app_rating = $this_content->ratings->average;
				foreach($this_content->previews as $appshots) {
					$app_info['ScreenShots'][] = (object) array('screen_shot' => $appshots->image_url);
				}
				
				$app_info['General'][] = (object) array(
					'app_id' => $item_id,
					'app_store_url' => $app_store_url,
					'app_icon' => $app_icon, 
					'app_title' => trim($app_title), 
					'app_author' => $app_author,
					'author_store_url' => $author_store_url,
					'app_price' => $app_price,
					'app_rating' => $app_rating,
					'storename' => 'FF Marketplace',
					'storename_css' => 'firefoxmarketplace',
					'fallback' => '0',
					'data_type' => '0'
				);
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		function getAmazonApps($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$page_url = $this->get_store_url('amazonapps', $item_id);
			$this_content = $this->get_fcontent(urldecode($page_url));
			if($this->echo_parse_output()) print_r($this_content);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("title")->html();
				if(strpos($error_found, "404") !== false) return 0;
				$app_rating = substr(pq('span.crAvgStars span.swSprite')->attr('title'), 0, 3);
				$app_title = strip_tags(pq('div.buying>h1>span#btAsinTitle')->html());
				$app_price = pq('#actualPriceValue>b')->html();
				if(strpos($app_price, 'EUR') !== false) $app_price = str_replace('EUR ', '', $app_price).' €';
				if((strpos($app_price, "0,00") !== false) || (strpos($app_price, "0.00") !== false)) $app_price = __('Free', 'wp-appbox');
				$app_store_url = $page_url;
				$app_icon = pq('img#main-image')->attr('src');
				$app_author = pq('div.buying>span>a')->html();
				$sourceUrl = parse_url($page_url);
				$sourceUrl = $sourceUrl['scheme'].'://'.$sourceUrl['host'];
				$author_store_url = $sourceUrl.pq('div.buying>span>a')->attr('href');
				foreach(pq('img[class*=thumb][class!=border thumb0 selected]') as $appshots) {
					$app_screen_shots = str_replace('30', '300', pq($appshots)->attr('src'));
					if(Trim($app_screen_shots) != '') $app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				$app_store_url = $page_url;
				$app_info['General'][] = (object) array(
					'app_id' => $item_id,
					'app_store_url' => $app_store_url,
					'app_icon' => $app_icon, 
					'app_title' => trim($app_title), 
					'app_author' => $app_author, 
					'author_store_url' => $author_store_url,
					'app_price' => $app_price,
					'app_rating' => $app_rating,
					'storename' => 'Amazon Apps',
					'storename_css' => 'amazonapps',
					'fallback' => '0',
					'data_type' => '0'
				);
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		function getGoodOldGames($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$page_url = $this->get_store_url('goodoldgames', $item_id);
			$this_content = $this->get_fcontent(urldecode($page_url));
			if($this->echo_parse_output()) print_r($this_content);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("title")->html();
				if(strpos($error_found, "404") !== false) return 0;
				$app_title = pq('meta[name="og:title"]')->attr('content');
				$app_store_url = pq('meta[name="og:url"]')->attr('content');
				$app_icon = pq('meta[name="og:image"]')->attr('content');
				$app_price = strip_tags(pq('span.buy-price:not(.buy-price--label):first')->html());
				if(strpos($app_price, '%') !== false) $app_price = strip_tags(pq('.buy-price__new:first')->html());
				if(strpos($app_price, '€')) {
					$app_price = str_replace('€', '', $app_price);
					$app_price = str_replace('.', ',', $app_price);
					$app_price .= '€';
				}
				$app_author = pq('a[href*="/games##devpub="]:first')->html();
				$author_store_url = 'http://www.gog.com'.pq('a[href*="/games##devpub="]:first')->attr('href');
				$app_rating = 0;
				foreach(pq('span.header__rating>i') as $stars) {
					$stars = pq($stars)->attr('class');
					if($stars == 'ic icon-star-full') $app_rating = $app_rating + 1;
					else if($stars == 'ic icon-star-half') $app_rating = $app_rating + 0.5;
				}
				$app_video = pq('iframe#ytplayer:first')->attr('src');
				foreach(pq('div.screen-ov-img img') as $appshots) {
					$app_screen_shots = str_replace('_small_30', '', pq($appshots)->attr('src'));
					if(Trim($app_screen_shots) != '') $app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				$app_store_url = $page_url;
				$app_info['General'][] = (object) array(
					'app_id' => $item_id,
					'app_store_url' => $app_store_url,
					'app_icon' => $app_icon, 
					'app_title' => trim($app_title), 
					'app_author' => $app_author, 
					'author_store_url' => $author_store_url,
					'app_price' => $app_price,
					'app_rating' => $app_rating,
					'app_video' => $app_video,
					'storename' => 'GOG.com',
					'storename_css' => 'goodoldgames',
					'fallback' => '0',
					'data_type' => '0'
				);
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		function getSteam($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$page_url = $this->get_store_url('steam', $item_id);
			$this_content = $this->get_fcontent($page_url);
			$this_content = $this->get_fcontent(urldecode($page_url));
			$this_content = json_decode($this_content[0]);
			if($this->echo_parse_output()) print_r($this_content);
			if($this_content->$item_id->success == '1') {
				$this_content = $this_content->$item_id->data;
				$app_title = $this_content->name;
				$app_store_url = 'http://store.steampowered.com/app/'.$item_id.'/';
				$app_icon = $this_content->header_image;
				print_r($app_icon2);
				foreach($this_content->developers as $devs) {
					$app_author .= ', <a href="http://store.steampowered.com/search/?developer='.$devs.'">'.$devs.'</a>';
				}
				$app_author = substr($app_author, 2);
				$currency = $this_content->price_overview->currency;
				$app_price = ($this_content->price_overview->final)/100;
				if($currency == 'EUR') $app_price = str_replace('.', ',', $app_price).' €';
				elseif($currency == 'USD') $app_price = '$ '.$app_price;
				else $app_price = $app_price.' '.$currency;
				foreach($this_content->screenshots as $appshots) {
					$app_info['ScreenShots'][] = (object) array('screen_shot' => $appshots->path_thumbnail);
				}
				$app_info['General'][] = (object) array(
					'app_id' => $item_id,
					'app_store_url' => $app_store_url,
					'app_icon' => $app_icon, 
					'app_title' => trim($app_title), 
					'app_author' => $app_author, 
					'author_store_url' => '',
					'app_price' => $app_price,
					'app_rating' => '',
					'storename' => 'Steam',
					'storename_css' => 'steam',
					'fallback' => '0',
					'data_type' => '0'
				);
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		function getAppStore($item_id) {
			$options = get_option('wpAppbox');
			$item_id = str_replace(array('-iphone', '-ipad', '-universal', '-watch'), '', $item_id);
			if(substr($item_id, 0, 2) == 'id') $item_id = substr($item_id, 2);
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$page_url = $this->get_store_url('appstore', $item_id);
			if(strpos($item_id, "bundle") !== false) $page_url = str_replace('app/id', '', $page_url);
			$this_content = $this->get_fcontent(urldecode($page_url));
			if($this->echo_parse_output()) print_r($this_content);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#desktopContentBlockId")->text();
				if($error_found == '') return 0;
				$app_title = pq('h1[itemprop="name"]')->html();
				$app_store_url = pq('link[rel="canonical"]:first')->attr('href');
				$app_icon = pq('meta[property="og:image"]')->attr('content');
				$app_author = pq('div#title>div.left>h2')->html();
				$app_author = preg_replace("/^\w+\W ?(.*)$/s", "$1", $app_author);
				$author_store_url = pq('div#title>div.right>a.view-more')->attr('href');
				$app_price = trim(pq('div[itemprop="price"]')->attr('content'));
				if($app_price == '0') $app_price = __('Free', 'wp-appbox');
				if(pq('div.in-app-purchases')->html() != '') $app_has_iap = true;
				$app_watch = pq('div.works-on-apple-watch>img')->attr('src');
				$app_rating_html = pq('div.customer-ratings>div.rating:last')->html();
				$app_rating = 5-substr_count($app_rating_html, 'ghost');
				if(strpos($app_rating_html, 'half') !== false) $app_rating = $app_rating-0.5;
				foreach(pq('div.iphone-screen-shots img') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('src');
					$app_info['ScreenShots']['iphone'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				foreach(pq('div.ipad-screen-shots img') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('src');
					$app_info['ScreenShots']['ipad'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				foreach(pq('div#watch-screenshots-swoosh div.lockup img') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('src');
					$app_info['ScreenShots']['watch'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				foreach(pq('div.mac-application div.lockup img') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('src');
					$app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				if(pq('div#mac-app-store-required')->html() == '') {
					$storename = 'App Store';
					$storename_css = 'appstore';
				}
				else {
					$storename = 'Mac App Store';
					$storename_css = 'macappstore';
				}
				$app_info['General'][] = (object) array(
					'app_id' => $item_id,
					'app_store_url' => $app_store_url,
					'app_icon' => $app_icon, 
					'app_title' => trim($app_title), 
					'app_author' => $app_author, 
					'author_store_url' => $author_store_url,
					'app_price' => $app_price,
					'app_has_iap' => $app_has_iap,
					'app_rating' => $app_rating,
					'app_watch' => $app_watch,
					'storename' => $storename, 
					'storename_css' => $storename_css, 
					'fallback' => '0',
					'data_type' => '0'
				);
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		function getAppStore_old($item_id) {
			$options = get_option('wpAppbox');
			if(strpos($item_id, "bundle") !== false) { $this->getAppStoreBundle($item_id); }
			if(substr($item_id, 0, 2) == 'id') $item_id = substr($item_id, 2);
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$itunes_id = str_replace(array('-iphone', '-ipad', '-universal'), '', $item_id);
			$page_url = $this->get_store_url('appstore', 'lookup?id='.$itunes_id);
			$this_content = $this->get_fcontent(urldecode($page_url));
			$this_content = json_decode($this_content[0]);
			if($this->echo_parse_output()) print_r($this_content);
			if($this_content->resultCount == '1') {
				$this_content = $this_content->results[0];
				if($this_content->kind == 'mac-software') $ismas = true;
				else $ismas = false;
				if(preg_match('~http://.*\.(tif)~i', $this_content->artworkUrl100)) $app_icon = $this_content->artworkUrl60;
				else {
					$app_icon = $this_content->artworkUrl100;
					if((!$options['wpAppbox_itunes_secureimage']) && ($this_content->kind != 'podcast')) {
						if(preg_match('~http://.*\.(([0-9]{2,4})x[0-9]{2,4}-[0-9]{2,3}).(png|jpg|jpeg)~i', $app_icon, $replacement)) {
							$app_icon = str_replace($replacement[1], '128x128-75', $app_icon);
						}
						elseif(preg_match('~http://.*\.(png|jpg|jpeg)(.*)(.png|.jpg|.jpeg)~i', $app_icon, $replacement)) {
							$app_icon = str_replace($replacement[2], $replacement[2].'.128x128-75', $app_icon);
						}
						//elseif(preg_match('~http://.*\.(png|jpg|jpeg)~i', $app_icon, $replacement)) {
							//$app_icon = str_replace('.'.$replacement[1], '.128x128-75.'.$replacement[1], $app_icon);
						//}
					}
				}
				$app_rating = $this_content->averageUserRating;
				$app_title = $this_content->trackName;
				$app_author = $this_content->artistName;
				$author_store_url = $this_content->artistViewUrl;
				$app_price = $this_content->price;
				if($app_price == '0.00') $app_price = __('Free', 'wp-appbox');
				else $app_price = $this_content->formattedPrice;
				if(in_array('iosUniversal', $this_content->features)) {
					if($this->StringEndsWith($item_id, '-iphone')) $apptype = 'iphone';
					elseif($this->StringEndsWith($item_id, '-ipad')) $apptype = 'ipad';
					else $apptype = 'universal';
				}
				else $apptype = 'universal';
				if($apptype == 'iphone' || $apptype == 'universal') {
					foreach($this_content->screenshotUrls as $appshots) {
						$app_info['ScreenShots'][] = (object) array('screen_shot' => $appshots);
					}
				}
				if($apptype == 'ipad' || $apptype == 'universal') {
					foreach($this_content->ipadScreenshotUrls as $appshots) {
						$app_info['ScreenShots'][] = (object) array('screen_shot' => $appshots);
					}
				}
				$app_store_url = $this_content->trackViewUrl;
				if(!$ismas) {
					$storename = 'App Store';
					$storename_css = 'appstore';
				}
				else {
					$storename = 'Mac App Store';
					$storename_css = 'macappstore';
				}
				$app_store_url = str_replace('?mt=8&uo=4', '', $app_store_url);
				$app_info['General'][] = (object) array(
					'app_id' => $itunes_id,
					'app_store_url' => $app_store_url,
					'app_icon' => $app_icon, 
					'app_title' => trim($app_title), 
					'app_author' => $app_author, 
					'author_store_url' => $author_store_url,
					'app_price' => $app_price,
					'app_rating' => $app_rating,
					'storename' => $storename, 
					'storename_css' => $storename_css, 
					'fallback' => '0',
					'data_type' => '0'
				);
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		function getWordPress($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$page_url = $this->get_store_url('wordpress', $item_id);
			$this_content = $this->get_fcontent(urldecode($page_url.'screenshots/'));
			if($this->echo_parse_output()) print_r($this_content);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("Whoops!")->text();
				if($error_found != '') return 0;
				$app_rating = pq('meta[itemprop="ratingValue"]')->attr('content');
				$app_icon = plugins_url('wp-appbox/img/wordpress-logo.png');
				$app_title = pq('h2[itemprop="name"]')->text();
				$app_author = pq('div.plugin-contributor-info:first>div>a')->text();
				if(substr_count($this_content[0], '<div class=\'plugin-contributor-info\'>') > 1) {
					$app_author = __('various', 'wp-appbox');
					$author_store_url = $page_url;
				}
				else {
					$app_author = pq('div.plugin-contributor-info:first>div>a')->text();
					$author_store_url = pq('div.plugin-contributor-info:first>div>a')->attr('href');
				}
				$app_price = __('Free', 'wp-appbox');
				foreach(pq('img.screenshot') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('src');
					$app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				$app_store_url = $page_url;
				$app_info['General'][] = (object) array(
					'app_id' => $item_id,
					'app_store_url' => $app_store_url,
					'app_icon' => $app_icon, 
					'app_title' => trim($app_title), 
					'app_author' => $app_author, 
					'author_store_url' => $author_store_url,
					'app_price' => $app_price,
					'app_rating' => $app_rating,
					'storename' => 'WordPress',
					'storename_css' => 'wordpress',
					'fallback' => '0',
					'data_type' => '0'
				);
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		function getWindowsStore($item_id) {
			$item_id = str_replace(array('-mobile', '-desktop', '-all'), '', $item_id);
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$page_url = $this->get_store_url('windowsstore', $item_id);
			if(strlen($item_id) > 20) {
				$page_url = 'https://www.windowsphone.com/s?appId='.$item_id;
				$old_phone_app = true;
			}
			$this_content = $this->get_fcontent(urldecode($page_url));
			if($this->echo_parse_output()) print_r($this_content);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq('meta[name="ms.pagename"]')->attr('content');
				if($error_found != 'App Details') return 0;
				$app_store_url = pq('link[rel="canonical"]')->attr('href');
				if($old_phone_app) {
					$new_item_id = preg_replace("/https:\/\/www.microsoft.com\/.*-.*\/store\/apps\/.*\/(.*)/i", "$1", $app_store_url);
					return($this->getWindowsStore($new_item_id));
				}
				$app_store_url = preg_replace("/(https:\/\/www.microsoft.com\/)(.*)(store\/apps\/.*\/.*)/i", "$1$3", $app_store_url);
				$app_title = pq('#page-title[itemprop="name"]')->html();
				$app_price = trim(pq('div.price:first span')->html());
				$app_author = pq('dd.metadata-list-content:first>div')->html();
				$author_store_url = '';
				$app_icon = pq('img.cli_image:first')->attr('src');
				$icon_bg = pq('img.cli_image:first')->attr('style');
				$icon_bg = preg_replace("/.*(#.*);[ ].*/i", "$1", $icon_bg);
				$app_rating = trim(pq('ul.rating-stars-value')->attr('style'));
				if($app_rating != '') {
					$app_rating = preg_replace("/width: (.*)%/i", "$1", $app_rating);
					$app_rating = intval($app_rating);
					if($app_rating != 0) {
						switch($app_rating) {
							case ($app_rating >= 0 && $app_rating < 10):
								$app_rating = 0;
								break;
							case ($app_rating >= 10 && $app_rating < 20):
								$app_rating = 0.5;
								break;
							case ($app_rating >= 20 && $app_rating < 30):
								$app_rating = 1;
								break;
							case ($app_rating >= 30 && $app_rating < 40):
								$app_rating = 1.5;
								break;
							case ($app_rating >= 40 && $app_rating < 50):
								$app_rating = 2;
								break;
							case ($app_rating >= 50 && $app_rating < 60):
								$app_rating = 2.5;
								break;
							case ($app_rating >= 60 && $app_rating < 70):
								$app_rating = 3;
								break;
							case ($app_rating >= 70 && $app_rating < 80):
								$app_rating = 3.5;
								break;
							case ($app_rating >= 80 && $app_rating < 90):
								$app_rating = 4;
								break;
							case ($app_rating >= 90 && $app_rating < 100):
								$app_rating = 4.5;
								break;
							case ($app_rating == 100):
								$app_rating = 5;
								break;
						}
					}
				}
				foreach(pq('div.media.slide > div > img') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('src');
					$app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				foreach(pq('div.media.slide.srv_mobile > div > img') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('src');
					$app_info['ScreenShots']['mobile'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				foreach(pq('div.media.slide.srv_desktop > div > img') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('src');
					$app_info['ScreenShots']['desktop'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				$app_info['General'][] = (object) array(
					'app_id' => $item_id,
					'app_store_url' => $app_store_url,
					'app_icon' => $app_icon, 
					'app_title' => trim($app_title), 
					'app_author' => $app_author, 
					'icon_bg' => $icon_bg,
					'app_price' => $app_price,
					'app_rating' => $app_rating,
					'storename' => 'Windows Store',
					'storename_css' => 'windowsstore',
					'fallback' => '0',
					'data_type' => '0'
				);
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		function getOperaAddons($item_id) {
			if($this->is_cached($item_id.'operaaddons')) return($this->get_cached_data($item_id.'operaaddons'));
			$page_url = $this->get_store_url('operaaddons', $item_id);
			$this_content = $this->get_fcontent(urldecode($page_url));
			if($this->echo_parse_output()) print_r($this_content);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("div.contained>header>h2")->text();
				if($error_found == '404') return 0;
				$app_rating = pq('p.rating>span[class="meter"]>span')->attr('title');
				$app_title = pq('meta[property="og:title"]')->attr('content');
				$app_icon = pq('meta[property="og:image"]')->attr('content');
				$app_store_url = pq('meta[property="og:url"]')->attr('content');
				$app_author = pq('article.pkg-details h3.h-byline>a')->html();
				$author_store_url = 'https://addons.opera.com'.pq('article.pkg-details h3.h-byline>a')->attr('href');
				$app_price = $app_price = __('Free', 'wp-appbox');
				foreach(pq('meta[property="og:image"]:not(first)') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('content');
					if($app_screen_shots != $app_icon) $app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				$app_info['General'][] = (object) array(
					'app_id' => $item_id,
					'app_store_url' => $app_store_url,
					'app_icon' => $app_icon, 
					'app_title' => trim($app_title), 
					'app_author' => $app_author, 
					'author_store_url' => $author_store_url,
					'app_price' => $app_price,
					'app_rating' => $app_rating,
					'storename' => 'Opera Add-ons',
					'storename_css' => 'operaaddons',
					'fallback' => '0',
					'data_type' => '0'
				);
				$this->save_data_to_cache($item_id.'operaaddons', $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		function getFirefoxAddon($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$page_url = $this->get_store_url('firefoxaddon', $item_id);
			$this_content = $this->get_fcontent(urldecode($page_url));
			if($this->echo_parse_output()) print_r($this_content);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("title")->html();
				if($error_found == 'Nicht gefunden') return 0;
				$app_rating = pq('meta[itemprop="ratingValue"]')->attr('content');
				$app_icon = pq('img[itemprop="image"]')->attr('src');
				$app_title = pq('span[itemprop="name"]:first')->html();
				$app_author = pq('h4[class="author"] > a')->html();
				$author_store_url = 'https://addons.mozilla.org'.pq('h4[class="author"] > a')->attr('href');
				$app_price = __('Free', 'wp-appbox');
				foreach(pq('section.previews > div.carousel > ul > li > a') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('href');
					$app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				$app_store_url = $page_url;
				$app_info['General'][] = (object) array(
					'app_id' => $item_id,
					'app_store_url' => $app_store_url,
					'app_icon' => $app_icon, 
					'app_title' => trim($app_title), 
					'app_author' => $app_author, 
					'author_store_url' => $author_store_url,
					'app_price' => $app_price,
					'app_rating' => $app_rating,
					'storename' => 'Firefox Add-ons',
					'storename_css' => 'firefoxaddon',
					'fallback' => '0',
					'data_type' => '0'
				);
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
	
		function getChromeWebStore($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$page_url = $this->get_store_url('chromewebstore', $item_id);
			$this_content = $this->get_fcontent(urldecode($page_url));
			if($this_content[1]['http_code'] == '301') $this_content = $this->get_fcontent($this_content[1]['redirect_url']);
			else if($this_content[1]['http_code'] == '0') $this_content = $this->get_fcontent(urldecode('https://chrome.google.com'.$this_content[1]['url']));
			if($this->echo_parse_output()) print_r($this_content);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found != '') return 0;
				print_r(pq('div[slideIndex="0"]')->html());
				$app_rating = pq('meta[itemprop="ratingValue"]')->attr('content');
				$app_icon = pq('meta[property="og:image"]')->attr('content');
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
					$app_author = __('Unknown', 'wp-appbox');
					$author_store_url = $app_store_url;
				endif;
				$app_author = str_replace('von ', '', $app_author);
				$app_author = str_replace('http://', '', $app_author);
				$app_author = str_replace('https://', '', $app_author);
				$app_price = __('Free', 'wp-appbox');
				foreach(pq('img.slideshow-slide-image-new-size') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('src');
					$app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				$app_info['General'][] = (object) array(
					'app_id' => $item_id,	
					'app_store_url' => $app_store_url,
					'app_icon' => $app_icon, 
					'app_title' => trim($app_title), 
					'app_author' => $app_author, 
					'author_store_url' => $author_store_url,
					'app_price' => $app_price,
					'app_rating' => $app_rating,
					'storename' => 'Chrome Web Store',
					'storename_css' => 'chromewebstore',
					'fallback' => '0',
					'data_type' => '0'
				);
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			if(($this_content[1]['http_code'] == '503') || ($this_content[1]['http_code'] == '302')) {
				$app_info['General'][] = (object) array(
					'app_id' => '0',
					'app_store_url' => $page_url,
					'app_icon' => $app_icon, 
					'app_title' => __('Download', 'wp-appbox').' @ Chrome Web Store', 
					'app_author' => '', 
					'author_store_url' => '',
					'app_price' => '',
					'storename' => 'Chrome Web Store',
					'storename_css' => 'chromewebstore',
					'fallback' => '1',
					'data_type' => '0'
				);
				//$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			return 0;
		}
		
		
	}
?>
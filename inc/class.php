<?php

	error_reporting(0);
	
	include_once('queryelements.php');
	class GetAppInfoAPI {
	
	
		function echo_parse_output() {
			$options = get_option('wpAppbox');
			if($options['wpAppbox_error_parseoutput'] && has_user_admin_permissions()) return true;
			else false;
		}
		
		
		function get_store_url($store, $id) {
			switch($store) {
				case 'googleplay':
					if(function_exists('wpappbox_get_googleplay_url')) $url = wpappbox_get_googleplay_url();
					else $url = 'https://play.google.com/store/apps/details?id={APPID}';
					break;
				case 'firefoxmarketplace':
					if(function_exists('wpappbox_get_firefoxmarketplace_url')) $url = wpappbox_get_firefoxmarketplace_url();
					else $url = 'https://marketplace.firefox.com/api/v1/apps/app/{APPID}/?region=de&lang=de';
					break;
				case 'androidpit':
					if(function_exists('wpappbox_get_androidpit_url')) $url = wpappbox_get_androidpit_url();
					else $url = 'http://www.androidpit.de/de/android/market/apps/app/{APPID}';
					break;
				case 'amazonapps':
					if(function_exists('wpappbox_get_amazonapps_url')) $url = wpappbox_get_amazonapps_url();
					else $url = 'http://www.amazon.de/gp/product/{APPID}/?ie=UTF8';
					break;
				case 'appstore':
					if(function_exists('wpappbox_get_appstore_url')) $url = wpappbox_get_appstore_url();
					else $url = 'https://itunes.apple.com/de/lookup?id={APPID}';
					break;
				case 'steam':
					if(function_exists('wpappbox_get_steam_url')) $url = wpappbox_get_steam_url();
					else $url = 'http://store.steampowered.com/app/{APPID}/?l=german';
					break;	
				case 'windowsphone':
					if(function_exists('wpappbox_get_windowsphone_url')) $url = wpappbox_get_windowsphone_url();
					else $url = 'http://www.windowsphone.com/de-de/store/app/app/{APPID}';
					break;
				case 'samsungapps':
					if(function_exists('wpappbox_get_samsungapps_url')) $url = wpappbox_get_samsungapps_url();
					else $url = 'http://apps.samsung.com/topApps/topAppsDetail.as?COUNTRY_CODE=DEU&productId={APPID}';
					break;
				case 'wordpress':
					if(function_exists('wpappbox_get_wordpress_url')) $url = wpappbox_get_wordpress_url();
					else $url = 'http://wordpress.org/plugins/{APPID}/';
					break;
				case 'windowsstore':
					if(function_exists('wpappbox_get_windowsstore_url')) $url = wpappbox_get_windowsstore_url();
					else $url = 'http://apps.microsoft.com/windows/de-DE/app/{APPID}';
					break;
				case 'operaaddons':
					if(function_exists('wpappbox_get_operaaddons_url')) $url = wpappbox_get_operaaddons_url();
					else $url = 'https://addons.opera.com/de/extensions/details/{APPID}/?display=de';
					break;
				case 'firefoxaddon':
					if(function_exists('wpappbox_get_firefoxaddon_url')) $url = wpappbox_get_firefoxaddon_url();
					else $url = 'https://addons.mozilla.org/de/firefox/addon/{APPID}/';
					break;	
				case 'chromewebstore':
					if(function_exists('wpappbox_get_chromewebstore_url')) $url = wpappbox_get_chromewebstore_url();
					else $url = 'https://chrome.google.com/webstore/detail/{APPID}?hl=de';
					break;						
			}
			$url = str_replace('{APPID}', $id, $url);
			return($url);
		}
		
		
		function get_cache_name($id) {
			return(WPAPPBOX_CACHE_PREFIX.md5($id));
		}
		
		
		function is_cached($id) {
			if(cache_deactive() || create_new_cache()) return false;
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
			if(!array_key_exists('wpAppbox_curl_timeout', $options)) $timeout = $options['wpAppbox_curl_timeout'];
			if((strpos($url, 'apps.samsung.com') !== false) && ($timeout < 10)) $timeout = 10;
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
			print_r($respaonse);
			unlink($cookie);
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
			$page_url = $this->get_store_url('googleplay', $item_id);
			$this_content = $this->get_fcontent(urldecode($page_url));
			if($this->echo_parse_output()) print_r($this_content);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found != '') return 0;
				$banner_icon = pq('img.cover-image[itemprop="image"]')->attr('src');
				$banner_icon = str_replace('=w300', '=w128', $banner_icon);
				$app_title = pq('div[itemprop="name"]>div')->html();
				$app_author = pq('div[itemprop="author"]>a[itemprop="name"]')->html();
				$author_store_url = 'https://play.google.com'.pq('div[itemprop="author"]>meta[itemprop="url"]')->attr('content');
				$app_price = pq('meta[itemprop="price"]')->attr('content');
				if((strpos($app_price, ",") == false) && (strpos($app_price, ".") == false)) $app_price = __('Kostenlos', 'wp-appbox');
				foreach(pq('img[itemprop="screenshot"]') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('src');
					if(substr($app_screen_shots, -8, 8) == '=h310-rw') $app_screen_shots = str_replace('=h500', '', $app_screen_shots);
					$app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				$app_store_url = $page_url;
				$app_info['General'][] = (object) array(
					'app_id' => $item_id,
					'app_store_url' => $app_store_url,
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
					'app_id' => '0',
					'app_store_url' => $page_url,
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
			$page_url = $this->get_store_url('firefoxmarketplace', $item_id);
			$this_content = $this->get_fcontent(urldecode($page_url));
			$this_content = json_decode($this_content[0]);
			if($this->echo_parse_output()) print_r($this_content);
			if(isset($this_content)) {
				$app_id = $this_content->id;
				$app_store_url = 'https://marketplace.firefox.com/app/'.$item_id;
				$app_title = $this_content->name;
				$app_price = $this_content->premium_type;
				if($app_price = 'free') $app_price = __('Kostenlos', 'wp-appbox');
				$banner_icon = $this_content->icons->{64};
				$app_author = $this_content->listed_authors[0]->name;
				$author_store_url = $this_content->support_url;
				foreach($this_content->previews as $appshots) {
					$app_info['ScreenShots'][] = (object) array('screen_shot' => $appshots->image_url);
				}
				
				$app_info['General'][] = (object) array(
					'app_id' => $item_id,
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
			$page_url = $this->get_store_url('androidpit', $item_id);
			$this_content = $this->get_fcontent(urldecode($page_url));
			if($this->echo_parse_output()) print_r($this_content);
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
					'app_id' => $item_id,
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
		
		
		function getAmazonApps($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$page_url = $this->get_store_url('amazonapps', $item_id);
			$this_content = $this->get_fcontent(urldecode($page_url));
			if($this->echo_parse_output()) print_r($this_content);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("title")->html();
				if(strpos($error_found, "404") !== false) return 0;
				$app_title = pq('span#btAsinTitle')->html();
				$app_price = pq('span#actualPriceValue>b')->html();
				$banner_image = str_replace('._SL75_AA30_', '', pq('td[id=alt_image_1]>table>tr>td.tiny>img')->attr('src'));
				if(strpos($app_price, 'EUR') !== false) $app_price = str_replace('EUR ', '', $app_price).' €';
				if(strpos($app_price, "0,00") !== false) $app_price = __('Kostenlos', 'wp-appbox');
				$app_store_url = $page_url;
				$banner_icon = pq('img#prodImage')->attr('src');
				$app_author = pq('div.buying:has(h1.parseasinTitle)>a')->html();
				$author_store_url = 'http://www.amazon.de'.pq('div.buying:has(h1.parseasinTitle)>a')->attr('href');
				foreach(pq('td[id*=alt_image_][id!=alt_image_1]>table>tr>td.tiny>img') as $appshots) {
					$app_screen_shots = str_replace('._SL75_AA30_', '', pq($appshots)->attr('src'));
					if(Trim($app_screen_shots) != '') $app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				$app_store_url = $page_url;
				$app_info['General'][] = (object) array(
					'app_id' => $item_id,
					'app_store_url' => $app_store_url,
					'banner_image' => $banner_image, 
					'banner_icon' => $banner_icon, 
					'app_title' => $app_title, 
					'app_author' => $app_author, 
					'author_store_url' => $author_store_url,
					'app_price' => $app_price,
					'storename' => 'Amazon Apps',
					'storename_css' => 'amazonapps',
					'fallback' => '0'
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
			if($this->echo_parse_output()) print_r($this_content);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200') && (strpos($this_content[1]['url'], '/agecheck/app/') !== false)) {
				$page_url = $this_content[1]['url'];
				$this_content = $this->get_fcontent($this_content[1]['url'].'?l=german');
				phpQuery::newDocumentHTML($this_content[0]);
				$app_title = str_replace(' bei Steam', '', pq('title')->html());
				$banner_icon = pq('img.agegate_img_app')->attr('src');
				$app_info['General'][] = (object) array(
					'app_id' => $item_id,
					'app_store_url' => $page_url,
					'banner_icon' => $banner_icon, 
					'app_title' => $app_title, 
					'storename' => 'Steam',
					'storename_css' => 'steam',
					'fallback' => '1'
				);
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			elseif((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("div.apphub_AppName")->html();
				if($error_found == '') return 0;
				$app_title = pq('div.apphub_AppName')->html();
				$banner_icon = pq('div.apphub_AppIcon > img')->attr('src');
				$app_price_first = pq('div.game_purchase_price:first')->html();
				$app_price_last = pq('div.game_purchase_price:last')->html();
				if($app_price_first == $app_price_last) $app_price = $app_price_first;
				else $app_price = $app_price_first.' - '.$app_price_last;
				if($app_price == '') {
					$app_price_first = pq('div.game_purchase_discount:first div.discount_final_price')->html();
					$app_price_last = pq('div.game_purchase_discount:last div.discount_final_price')->html();
					if($app_price_first == $app_price_last) $app_price = $app_price_first;
					else $app_price = $app_price_first.' - '.$app_price_last;
				}
				$app_author = pq('div.details_block>a[href*="http://store.steampowered.com/search/?developer="]')->html();
				$author_store_url = pq('div.details_block>a[href*="http://store.steampowered.com/search/?developer="]')->attr('href');
				foreach(pq('div.highlight_screenshot > div > a') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('href');
					if((Trim($app_screen_shots) != '') && (count($app_info['ScreenShots']) < 12)) $app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				$app_store_url = str_replace('screenshots/', '', $page_url);
				$app_info['General'][] = (object) array(
					'app_id' => $item_id,
					'app_store_url' => $app_store_url,
					'banner_image' => $banner_image, 
					'banner_icon' => $banner_icon, 
					'app_title' => $app_title, 
					'app_author' => $app_author, 
					'author_store_url' => $author_store_url,
					'app_price' => $app_price,
					'storename' => 'Steam',
					'storename_css' => 'steam',
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
			if($this->echo_parse_output()) print_r($this_content);
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
					'app_id' => $item_id,
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
			$itunes_id = str_replace(array('-iphone', '-ipad', '-universal'), '', $item_id);
			$page_url = $this->get_store_url('appstore', $itunes_id);
			$this_content = $this->get_fcontent(urldecode($page_url));
			$this_content = json_decode($this_content[0]);
			if($this->echo_parse_output()) print_r($this_content);
			if($this_content->resultCount == '1') {
				$this_content = $this_content->results[0];
				if($this_content->kind == 'mac-software') $ismas = true;
				else $ismas = false;
				if(preg_match('~http://.*\.(tif)~i', $this_content->artworkUrl100)) $banner_icon = $this_content->artworkUrl60;
				else {
					$banner_icon = $this_content->artworkUrl100;
					if(!$options['wpAppbox_itunes_secureimage']) {
						if(preg_match('~http://.*\.(([0-9]{2,4})x[0-9]{2,4}-[0-9]{2,3}).(png|jpg|jpeg)~i', $banner_icon, $replacement)) {
							$banner_icon = str_replace($replacement[1], '128x128-75', $banner_icon);
						}
						elseif(preg_match('~http://.*\.(png|jpg|jpeg)(.*)(png|jpg|jpeg)~i', $banner_icon, $replacement)) {
							$banner_icon = str_replace($replacement[2], $replacement[2].'128x128-75.', $banner_icon);
						}
						elseif(preg_match('~http://.*\.(png|jpg|jpeg)~i', $banner_icon, $replacement)) {
							$banner_icon = str_replace($replacement[1], '128x128-75.'.$replacement[1], $banner_icon);
						}
					}
				}
				$app_title = $this_content->trackName;
				$app_author = $this_content->artistName;
				$author_store_url = $this_content->artistViewUrl;
				$app_price = $this_content->formattedPrice;
				if((strpos($app_price, ",") == false) && (strpos($app_price, ".") == false)) $app_price = __('Kostenlos', 'wp-appbox');
				if(in_array('iosUniversal', $this_content->features)) {
					if(StringEndsWith($item_id, '-iphone')) $apptype = 'iphone';
					elseif(StringEndsWith($item_id, '-ipad')) $apptype = 'ipad';
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
				$app_info['General'][] = (object) array(
					'app_id' => $itunes_id,
					'app_store_url' => $app_store_url,
					'banner_icon' => $banner_icon, 
					'app_title' => $app_title, 
					'app_author' => $app_author, 
					'author_store_url' => $author_store_url,
					'app_price' => $app_price,
					'storename' => $storename, 
					'storename_css' => $storename_css, 
					'fallback' => '0'
				);
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		function getWindowsPhone($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$page_url = $this->get_store_url('windowsphone', $item_id);
			$this_content = $this->get_fcontent(urldecode($page_url));
			if($this->echo_parse_output()) print_r($this_content);
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
					'app_id' => $item_id,
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
			$page_url = $this->get_store_url('samsungapps', $item_id);
			$this_content = $this->get_fcontent(urldecode($page_url));
			if($this->echo_parse_output()) print_r($this_content);
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
					'app_id' => $item_id,
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
		
		
		function getWordPress($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$page_url = $this->get_store_url('wordpress', $item_id);
			$this_content = $this->get_fcontent(urldecode($page_url.'screenshots/'));
			if($this->echo_parse_output()) print_r($this_content);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("Whoops!")->text();
				if($error_found != '') return 0;
				$banner_icon = plugins_url('wp-appbox/img/wordpress-logo.png');
				$app_title = pq('h2[itemprop="name"]')->text();
				$app_author = pq('div.plugin-contributor-info:first>div>a')->text();
				if(substr_count($this_content[0], '<div class=\'plugin-contributor-info\'>') > 1) {
					$app_author = __('verschiedene', 'wp-appbox');
					$author_store_url = $page_url;
				}
				else {
					$app_author = pq('div.plugin-contributor-info:first>div>a')->text();
					$author_store_url = pq('div.plugin-contributor-info:first>div>a')->attr('href');
				}
				$app_price = __('Kostenlos', 'wp-appbox');
				if(pq('div.with-banner')->text() != '') $banner_image = 'http://s-plugins.wordpress.org/'.$item_id.'/assets/banner-772x250.png';
				else $banner_image = '';
				foreach(pq('img.screenshot') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('src');
					$app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				$app_store_url = $page_url;
				$app_info['General'][] = (object) array(
					'app_id' => $item_id,
					'app_store_url' => $app_store_url,
					'banner_image' => $banner_image, 
					'banner_icon' => $banner_icon, 
					'app_title' => $app_title, 
					'app_author' => $app_author, 
					'author_store_url' => $author_store_url,
					'app_price' => $app_price,
					'storename' => 'WordPress',
					'storename_css' => 'wordpress',
					'fallback' => '0'
				);
				$this->save_data_to_cache($item_id, $app_info);
				return $app_info;
			}
			else return 0;
		}
		
		
		function getWindowsStore($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$page_url = $this->get_store_url('windowsstore', $item_id);
			$this_content = $this->get_fcontent(urldecode($page_url));
			if($this->echo_parse_output()) print_r($this_content);
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
					'app_id' => $item_id,
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
		
		
		function getOperaAddons($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$page_url = $this->get_store_url('operaaddons', $item_id);
			$this_content = $this->get_fcontent(urldecode($page_url));
			if($this->echo_parse_output()) print_r($this_content);
			if((isset($this_content[0])) && ($this_content[1]['http_code'] == '200')) {
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("div.contained>header>h2")->text();
				if($error_found == '404') return 0;
				$app_title = pq('meta[property="og:title"]')->attr('content');
				$banner_icon = pq('meta[property="og:image"]')->attr('content');
				$app_store_url = pq('meta[property="og:url"]')->attr('content');
				$app_author = pq('article.pkg-details h3.h-byline>a')->html();
				$author_store_url = 'https://addons.opera.com'.pq('article.pkg-details h3.h-byline>a')->attr('href');
				$app_price = $app_price = __('Kostenlos', 'wp-appbox');
				foreach(pq('meta[property="og:image"]:not(first)') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('content');
					if($app_screen_shots != $banner_icon) $app_info['ScreenShots'][] = (object) array('screen_shot' => $app_screen_shots);
				}
				$app_info['General'][] = (object) array(
					'app_id' => $item_id,
					'app_store_url' => $app_store_url,
					'banner_icon' => $banner_icon, 
					'app_title' => $app_title, 
					'app_author' => $app_author, 
					'author_store_url' => $author_store_url,
					'app_price' => $app_price,
					'storename' => 'Opera Add-ons',
					'storename_css' => 'operaaddons',
					'fallback' => '0'
				);
				$this->save_data_to_cache($item_id, $app_info);
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
					'app_id' => $item_id,
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
		
	
		function getChromeWebStore($item_id) {
			if($this->is_cached($item_id)) return($this->get_cached_data($item_id));
			$page_url = $this->get_store_url('chromewebstore', $item_id);
			$this_content = $this->get_fcontent(urldecode($page_url));
			if($this_content[1]['http_code'] == '0') $this_content = $this->get_fcontent(urldecode('https://chrome.google.com'.$this_content[1]['url']));
			if($this->echo_parse_output()) print_r($this_content);
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
					'app_id' => $item_id,	
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
						'app_id' => '0',
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
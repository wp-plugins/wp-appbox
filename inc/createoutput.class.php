<?php
	error_reporting(0);
	
	class CreateOutput {
			
		function cleanURL($url, $store) {
			global $http_allowed_stores;
			if(in_array($store, $http_allowed_stores)) {
				$url = str_replace('http://', '//', $url);
				$url = str_replace('https://', '//', $url);
			}
			return($url);
		}
			
		function checkAttributs($attr) {
			if($attr['store'] == '') return('nostore');
			elseif($attr['appid'] == '') return('noappid');
			else return(true);
		}
		
		function has_user_permissions() {
			$userdata = get_userdata(get_current_user_id());
			if(intval($userdata->user_level) >= 2) return true;
			else false;
		}
		
		function loadTemplate($style) {
			ob_start();
			include('tpl/'.$style.'.php');
			$tpl = ob_get_contents();
			print_r($tpl);
			ob_end_clean();
			return($tpl);
		}
		
		function getTheAppData($store, $appid) {
			$app_info = new GetAppInfoAPI;
			if($store == 'androidpit') $store = 'googleplay';
			if($store == 'windowsphone') $store = 'windowsstore';
			$thegetfunction = 'get'.$store;
			return($app_info->$thegetfunction($appid));
		}
		
		function theQRCode($app_data, $size ='200', $EC_level='L', $margin='0') {
			global $ItemInfo;
			$url = urlencode($this->theAppLink($app_data));
			//$url = '//chart.apis.google.com/chart?cht=qr&chl='.$url.'&chs='.$size.'x'.$size.'&chld='.$EC_level.'|'.$margin;
			$url = 'https://chart.googleapis.com/chart?cht=qr&chl='.$url.'&chs='.$size.'x'.$size.'&chld='.$EC_level.'|'.$margin;
			return('<div class="qrcode"><img src="'.$url.'" alt="'.$this->theAppTitle($app_data).'" /></div>');
		}
		
		function theAppTitle($app_data) {
			//$title = shorten_title_author($app_data->app_title, 'title');
			$title = $app_data->app_title;
			return($title);
		}
		
		function theDeveloper($app_data, $link = true) {
			//$developer = shorten_title_author($app_data->app_author, 'author');
			$developer = $app_data->app_author;
			$developer_url = $app_data->author_store_url;
			if(($developer_url == '') || (!$link)) return($developer);
			else return('<a href="'.$developer_url.'">'.$developer.'</a>');
		}
		
		function theAppID($app_data) {
			return($app_data->app_id);
		}
		
		function theAppIcon($app_data, $app_store) {
			if($app_data->app_icon != '') $app_icon = $app_data->app_icon;
			else $app_icon = $app_data->banner_icon;
			if(($app_data->icon_bg != '') && ($app_data->storename_css == 'windowsstore')) return($this->cleanURL($app_icon, $app_store).'" style="'.$app_data->icon_bg);
			return($this->cleanURL($app_icon, $app_store));
		}
		
		function theDownloadText() {
			$options = get_option('wpAppbox');
			if($options['wpAppbox_downloadtext'] == '') return(__('Download', 'wp-appbox'));
			return($options['wpAppbox_downloadtext']);
		}
		
		function theAppLink_AppStore($link) {
			$dev_id = '11ltUj';
			$options = get_option('wpAppbox');
			if($options['wpAppbox_user_affiliateids']) {
				$author_id = get_the_author_meta('id');
				if($options['wpAppbox_user'.$author_id.'_apple_global']) {
					$affid = ($options['wpAppbox_user'.$author_id.'_apple_sponsored'] == true) ? $dev_id : $options['wpAppbox_user'.$author_id.'_apple'];
				}
			}
			if($affid == '') $affid = ($options['wpAppbox_affid_sponsored']) ? $dev_id : $options['wpAppbox_affid'];
			if($affid != '') {
				if(strpos($link, '?') !== false) $link = $link.'&amp;at='.$affid;
				else $link = $link.'?at='.$affid;
			}
			return($link);
		}
		
		function theAppLink_AmazonApps($link, $appid) {
			$dev_id = 'derscom08-21';
			$options = get_option('wpAppbox');
			if($options['wpAppbox_user_affiliateids']) {
				$author_id = get_the_author_meta('id');
				if($options['wpAppbox_user'.$author_id.'_amazonpartnernet_global']) {
					$affid = ($options['wpAppbox_user'.$author_id.'_amazonpartnernet_sponsored'] == true) ? $dev_id : $options['wpAppbox_user'.$author_id.'_amazonpartnernet'];
				}
			}
			if($affid == '') $affid = ($options['wpAppbox_affid_amazonpartnernet_sponsored']) ? $dev_id : $options['wpAppbox_affid_amazonpartnernet'];
			if($affid != '') $link = $link.'ref=as_li_tf_tl?ie=UTF8&camp=1638&creative=6742&creativeASIN='.$appid.'&linkCode=am2&tag='.$affid;
			return($link);
		}
		
		function theAppLink($app_data) {
			$options = get_option('wpAppbox');
			$link = $app_data->app_store_url;
			if(strpos($link, 'apple.com')) $link = $this->theAppLink_AppStore($link);
			if(strpos($link, 'amazon.')) $link = $this->theAppLink_AmazonApps($link, $this->theAppID());
			return($link);
		}
		
		function theStoreName($app_data) {
			return($app_data->storename);
		}
		
		function theRating($app_data) {
			$options = get_option('wpAppbox');
			if($options['wpAppbox_showrating']) {
				$rating = $app_data->app_rating;
				if($rating == '') return('');
				$rating = str_replace(',', '.', $rating);
				$rating = number_format($rating, 2);
				$rating = round($rating, 1);
				if($rating <= 0.3) $rating_stars = '00';
				if($rating >= 0.4 && $rating <= 0.7) $rating_stars = '05';
				if($rating >= 0.8 && $rating <= 1.3) $rating_stars = '10';
				if($rating >= 1.4 && $rating <= 1.7) $rating_stars = '15';
				if($rating >= 1.8 && $rating <= 2.3) $rating_stars = '20';
				if($rating >= 2.4 && $rating <= 2.7) $rating_stars = '25';
				if($rating >= 2.8 && $rating <= 3.3) $rating_stars = '30';
				if($rating >= 3.4 && $rating <= 3.7) $rating_stars = '35';
				if($rating >= 3.8 && $rating <= 4.3) $rating_stars = '40';
				if($rating >= 4.4 && $rating <= 4.8) $rating_stars = '45';
				if($rating >= 4.9) $rating_stars = '50';
				return('<div title="'.$rating.' '.__('of 5 stars', 'wp-appbox').'" class="rating-stars stars'.$rating_stars.'"></div>');
			}
		}
		
		function theStoreCSS($app_data) {
			return($app_data->storename_css);
		}
		
		function theScreenshots($app_screenshots, $app_id, $app_store) {
			$options = get_option('wpAppbox');
			$screenshots_out = '';
			foreach($app_screenshots as $appshots) {
				$screenshot_url = $appshots->screen_shot;
				$screenshot_url = $this->cleanURL($screenshot_url, $app_store);
				$screenshots_out .= '<li><img src="'.$screenshot_url.'" alt="" /></li>';
			}
			return($screenshots_out);
		}
		
		function theScreenshotsAppStore($app_screenshots, $app_id, $app_type, $app_store = 'appstore') {
			$options = get_option('wpAppbox');
			$screenshots_out = '';
			$app_screenshots['iphone'][] = '';
			$app_screenshots['ipad'][] = '';
			$app_screenshots['watch'][] = '';
			if($app_type == 'iphone') $app_screenshots = $app_screenshots['iphone'];
			else if($app_type == 'ipad') $app_screenshots = $app_screenshots['ipad'];
			else if($app_type == 'watch') $app_screenshots = $app_screenshots['watch'];
			else $app_screenshots = array_merge($app_screenshots['iphone'], $app_screenshots['ipad'], $app_screenshots['watch']);
			foreach($app_screenshots as $appshots) {
				$screenshot_url = $appshots->screen_shot;
				if($screenshot_url != '') {
					$screenshot_url = $this->cleanURL($screenshot_url, $app_store);
					$screenshots_out .= '<li><img src="'.$screenshot_url.'" alt="" /></li>';
				}
			}
			return($screenshots_out);
		}
		
		function theAppWatch($app_data) {
			$app_watch = $app_data->app_watch;
			if($app_watch != '') return('<img src="'.$app_watch.'" class="watch-icon" alt="" title="" />');
		}
		
		function thePrice($app_data, $price) {
			if($app_data->app_has_iap) $app_has_iap = '<sup><small>*</small></sup>';
			if(($app_data->app_price == $price) || ($price == '')) return($app_data->app_price.$app_has_iap);
			else return('<span class="oldprice">'.$price.'</span> '.$app_data->app_price.$app_has_iap);
		}
		
		function theReloadLink($app_data) {
			$options = get_option('wpAppbox');
			if($options['wpAppbox_show_reload_link'] && has_user_permissions()) return('<a href="'.get_permalink().(is_preview() ? '&amp;' : '?').'wpappbox_reload_cache&amp;wpappbox_appid='.$app_data->app_id.'" title="'.__('Renew cached data of this app', 'wp-appbox').'" class="reload-link">&#8635;</a> ');
		}
		
		function errorOutput($error_type, $store = '', $app_id = '', $style = 'simple') {
			$options = get_option('wpAppbox');
			switch($error_type) {
				case 'nostore':
					$output = __('The App Store is not recognized.', 'wp-appbox');
					break;
				case 'noappid':
					$output = __('The App ID is not recognized.', 'wp-appbox');
					break;
				case 'notfound':
					$output = __('The app was not found in the store.', 'wp-appbox');
					break;
				case 'fallback':
					if($style != 'compact') $output = loadTemplate('simple');
					else $output = loadTemplate('compact');
					preg_match('~(<div class="developer">.*</div>)~i', $output, $replacement);
					$output = str_replace($replacement[1], '', $output);
					preg_match('~(<div class="price">.*</div>)~i', $output, $replacement);
					$output = str_replace($replacement[1], '', $output);
					switch($store) {
						case 'googleplay':
							if($style == 'compact') $fallback_descr = __('Temporary recognition as a bot', 'wp-appbox');
							else $fallback_descr = __('Due to a temporary recognition as a bot can currently unfortunately no app details are displayed.', 'wp-appbox');
							break;
						case 'steam':
							if($style == 'compact') $fallback_descr = __('Age verification required', 'wp-appbox');
							else $fallback_descr = __('The $item_idme requires an age verification on the Steam website. Therefore, unfortunately, no further information can be displayed.', 'wp-appbox');
							break;
					}
					if($style != 'compact') $fallback_descr = '<div class="fallback">'.$fallback_descr.'</div>';
					preg_match('~(<a .* class="apptitle">.*</a>)~i', $output, $replacement);
					$output = str_replace($replacement[1], $replacement[1].$fallback_descr, $output);
					return($output);
					break;
				default:
					$output = __('An unknown error has occurred.', 'wp-appbox');
					break;
			}
			if($error_type != 'fallback') $output = '<!-- WP-Appbox (Store: '.$store.' // ID: '.$app_id.') --><div class="wpappbox error"><span>'.$output.' :-( #wpappbox</span></div><!-- /WP-Appbox -->';
			if(($options['wpAppbox_error_onlyforauthor'] == false) || has_user_permissions() || isset($_GET['wpappbox_show_errormessages'])) return($output);
		}
	
		function theOutput($attr) {
			$options = get_option('wpAppbox');
			if($this->checkAttributs($attr) === true) {
				if($attr['store'] == 'appstore') {
					if($attr['bundle'] == true) $attr['appid'] = 'app-bundle/id'.$attr['appid'];
					if(preg_match('/-iphone/', $attr['appid'])) $app_type = 'iphone';
					else if(preg_match('/-ipad/', $attr['appid'])) $app_type = 'ipad';
					else if(preg_match('/-watch/', $attr['appid'])) $app_type = 'watch';
					else $app_type = 'universal';
					$attr['appid'] = str_replace(array('-iphone', '-ipad', '-universal', '-watch'), '', $attr['appid']);
					if(substr($attr['appid'], 0, 2) == 'id') $attr['appid'] = substr($attr['appid'], 2);
				}
				$app_info = $this->getTheAppData($attr['store'], $attr['appid']);
				if($app_info === 0) return($this->errorOutput('notfound', $attr['store'], $attr['appid']));
				else {
					$app_data = $app_info['General']['0'];
					if($app_data->fallback == '1') $template = $this->errorOutput('fallback', $app_data->storename_css, $attr['appid'], $attr['style']);
					else $template = loadTemplate($attr['style']);
					$app_store = $this->theStoreCSS($app_data);
					if(($attr['style'] == 'screenshots') || ($attr['style'] == 'screenshots-only')) {
						$app_screenshots = $app_info['ScreenShots'];
						if($app_store == 'appstore') $app_screenshots = $this->theScreenshotsAppStore($app_screenshots, $this->theAppID($app_data), $app_type);
						else $app_screenshots = $this->theScreenshots($app_screenshots, $this->theAppID($app_data), $app_store);
						if((($attr['style'] === 'screenshots') || ($attr['style'] === 'screenshots-only')) && ($app_screenshots == '')) {
							$attr['style'] = CreateAttributs::getStandardStyle($attr['store']);
							if(($attr['style'] === 'screenshots') || ($attr['style'] === 'screenshots-only')) $attr['style'] = 'simple';
							$template = loadTemplate($attr['style']);
						}
						else $template = str_replace('{SCREENSHOTS}', $app_screenshots, $template);
					}
					if(is_feed()) $template = '<p><strong>WP-Appbox:</strong> <a href="{APPLINK}" title="{TITLE}">{TITLE} ({STORE}) →</a></p>';
					//if($options['wpAppbox_simple_badge_style'] == '2') $template = str_replace('simple {STORECSS}', 'simple lbmc '.'{STORECSS}', $template);
					$template = str_replace('{WPAPPBOXVERSION}', WPAPPBOX_PLUGIN_VERSION, $template);
					$template = str_replace('{DOWNLOADTEXT}', $this->theDownloadText(), $template);
					$template = str_replace('{APPID}', $this->theAppID($app_data), $template);
					$template = str_replace('{APPIDHASH}', md5($this->theAppID($app_data)), $template);
					$template = str_replace('{WATCHICON}', $this->theAppWatch($app_data), $template);
					$template = str_replace('{ICON}', $this->theAppIcon($app_data, $app_store), $template);
					$template = str_replace('{TITLE}', $this->theAppTitle($app_data), $template);
					$template = str_replace('{STORE}', $this->theStoreName($app_data), $template);
					$template = str_replace('{RATING}', $this->theRating($app_data), $template);
					if($options['wpAppbox_colorful']) $template = str_replace('{STORECSS}', $this->theStoreCSS($app_data).' colorful', $template);
					else $template = str_replace('{STORECSS}', $this->theStoreCSS($app_data), $template);
					$template = str_replace('{APPLINK}', $this->theAppLink($app_data), $template);
					$template = str_replace('{DEVELOPERLINK}', $this->theDeveloper($app_data), $template);
					$template = str_replace('{PRICE}', $this->thePrice($app_data, $attr['oldprice']), $template);
					$template = str_replace('{QRCODE}', $this->theQRCode($app_data), $template);
					if($attr['nofollow']) $template = str_replace('<a ', '<a rel="nofollow" ', $template);
					if($attr['targetblank']) $template = str_replace('<a ', '<a target="_blank" ', $template);
					$template = str_replace('{RELOADLINK}', $this->theReloadLink($app_data), $template);
					if(!is_feed()) $template = '<!-- WP-Appbox (Store: '.$this->theStoreCSS($app_data).' // ID: '.$this->theAppID($app_data).') -->'.$template.'<!-- /WP-Appbox -->';
					return($template);
				}
			}
			else return($this->errorOutput($this->checkAttributs($attr)));
		}
			
	}

?>
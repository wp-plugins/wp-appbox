<?php

$options = get_option('wpAppbox');
if($options['wpAppbox_datacachetime'] == '') $options['wpAppbox_datacachetime'] = '300';

define("WPAPPBOX_PLUGIN_NAME", 'WP-Appbox'); 
define("WPAPPBOX_PLUGIN_VERSION", '3.1.3');

define("WPAPPBOX_DATA_CACHINGTIME", $options['wpAppbox_datacachetime']);  

define("WPAPPBOX_PLUGIN_BASE_DIR", basename(dirname(dirname(__FILE__))));

define("WPAPPBOX_CACHE_PREFIX", 'wpAppbox_');
						
$store_names = array(	'amazonapps' => 'Amazon Apps',
						'appstore' => '(Mac) App Store',
						'chromewebstore' => 'Chrome Web Store',
						'firefoxaddon' => 'Firefox Erweiterungen',
						'firefoxmarketplace' => 'Firefox Marketplace',
						'goodoldgames' => 'Good Old Games (GOG.com)',
						'googleplay' => 'Google Play Apps',
						'operaaddons' => 'Opera Add-ons',
						'steam' => 'Steam',
						'windowsstore' => 'Windows Store',
						'wordpress' => 'WordPress Plugins',
						);
												
$mobile_stores = array('amazonapps', 'appstore', 'firefoxmarketplace', 'googleplay', 'pebble');
								
$http_allowed_stores = array('chromewebstore', 'firefoxaddons', 'firefoxmarketplace', 'googleplay', 'operaaddons');	
												
$style_names_global = array('0' => 'standard',
							'1' => 'simple',
							'2' => 'compact',
							'3' => 'screenshots',
							'4' => 'screenshots-only');
							
$style_names_appstores = array(	'amazonapps' => array(1, 2, 3, 4),
								'appstore' => array(1, 2, 3, 4),
								'chromewebstore' => array(1, 2),
								'firefoxaddon' => array(1, 2, 3, 4),
								'firefoxmarketplace' => array(1, 2, 3, 4),
								'goodoldgames' => array(1, 2, 3, 4),
								'googleplay' => array(1, 2, 3, 4),
								'operaaddons' => array(1, 2, 3, 4),
								'steam' => array(1, 2, 3, 4),
								'windowsstore' => array(1, 2, 3, 4),
								'wordpress' => array(1, 2, 3, 4),
								);
						
?>
<?php

$options = get_option('wpAppbox');
if($options['wpAppbox_datacachetime'] == '') $options['wpAppbox_datacachetime'] = '300';

define("WPAPPBOX_PLUGIN_NAME", 'WP-Appbox'); 
define("WPAPPBOX_PLUGIN_VERSION", '2.0.0');

define("WPAPPBOX_DATA_CACHINGTIME", $options['wpAppbox_datacachetime']);  

define("WPAPPBOX_PLUGIN_BASE_DIR", basename(dirname(dirname(__FILE__))));

define("WPAPPBOX_CACHE_PREFIX", 'wpAppbox_');
						
$store_names = array(	'amazonapps' => 'Amazon Apps',
						'androidpit' => 'AndroidPit',
						'appstore' => '(Mac) App Store',
						'chromewebstore' => 'Chrome Web Store',
						'firefoxaddon' => 'Firefox Erweiterungen',
						'firefoxmarketplace' => 'Firefox Marketplace',
						'googleplay' => 'Google Play',
						'intelappup' => 'Intel AppUp',
						'operaaddons' => 'Opera Add-ons',
						'samsungapps' => 'Samsung Apps',
						'steam' => 'Steam',
						'windowsstore' => 'Windows Store',
						'windowsphone' => 'Windows Phone Store',
						'wordpress' => 'WordPress Plugins',
						);
												
$mobile_stores = array('amazonapps', 'androidpit', 'appstore', 'firefoxmarketplace', 'googleplay', 'samsungapps', 'windowsphone');
												
$style_names_global = array('-1' => 'standard',
							'0' => 'simple',
							'3' => 'compact',
							'2' => 'screenshots',
							'1' => 'banner',
							'4' => 'video');	
							
$style_names_appstores = array(	'amazonapps' => array(0, 1, 2, 3),
								'androidpit' => array(0, 1, 2, 3),
								'appstore' => array(0, 2, 3),
								'chromewebstore' => array(0, 3),
								'firefoxaddon' => array(0, 2, 3),
								'firefoxmarketplace' => array(0, 2, 3),
								'googleplay' => array(0, 2, 3, 4),
								'intelappup' => array(0, 2, 3),
								'operaaddons' => array(0, 2, 3),
								'samsungapps' => array(0, 2, 3),
								'steam' => array(0, 2, 3),
								'windowsstore' => array(0, 2, 3),
								'windowsphone' => array(0, 2, 3),
								'wordpress' => array(0, 1, 2, 3),
								);
						
?>
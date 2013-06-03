<?php 
$options = get_option('wpAppbox');
if($options['wpAppbox_datacachetime'] == '') $options['wpAppbox_datacachetime'] = '300';

define("WPAPPBOX_PLUGIN_NAME", 'WP-Appbox'); 
define("WPAPPBOX_PLUGIN_VERSION", '1.7.7');

define("WPAPPBOX_DATA_CACHINGTIME", $options['wpAppbox_datacachetime']);  

define("WPAPPBOX_ERRROR_PARSEOUTPUT", $options['wpAppbox_error_parseoutput']); 

define("PLUGIN_BASE_DIR", basename(dirname(dirname(__FILE__))));

define("WPAPPBOX_CACHE_PREFIX", 'wpAppbox_');

$store_names = array(	'amazonapps' => 'Amazon Apps',
						'androidpit' => 'AndroidPit',
						'appstore' => '(Mac) App Store',
						//'blackberryworld' => 'BlackBerry World',
						'chromewebstore' => 'Chrome Web Store',
						'firefoxaddon' => 'Firefox Erweiterungen',
						'firefoxmarketplace' => 'Firefox Marketplace',
						'googleplay' => 'Google Play',
						'operaaddons' => 'Opera Add-ons',
						'samsungapps' => 'Samsung Apps',
						'windowsstore' => 'Windows Store',
						'windowsphone' => 'Windows Phone Store',
						'wordpress' => 'WordPress Plugin Verzeichnis');
												
$mobile_stores = array ('amazonapps', 'androidpit', 'appstore', 'firefoxmarketplace', 'googleplay', 'samsungapps', 'windowsphone');
												
$style_names = array(	'0' => 'simple',
						'1' => 'banner',
						'2' => 'screenshots');		
						
?>
<?php 
$options = get_option('wpAppbox');
if($options['wpAppbox_datacachetime'] == '') $options['wpAppbox_datacachetime'] = '300';

define("WPAPPBOX_PLUGIN_NAME", 'WP-Appbox'); 
define("WPAPPBOX_PLUGIN_VERSION", '1.4.0');

define("WPAPPBOX_DATA_CACHINGTIME", $options['wpAppbox_datacachetime']);  

define("WPAPPBOX_ERRROR_PARSEOUTPUT", $options['wpAppbox_error_parseoutput']); 

define("PLUGIN_BASE_DIR", basename(dirname(dirname(__FILE__))));

define("WPAPPBOX_CACHE_PREFIX", 'wpAppbox_');

$store_names = array(	'appstore' => '(Mac) App Store',
						'googleplay' => 'Google Play',
						'windowsstore' => 'Windows Store',
						'windowsphone' => 'Windows Phone Store',
						//'blackberryworld' => 'BlackBerry World',
						'androidpit' => 'AndroidPit',
						'chromewebstore' => 'Chrome Web Store',
						'firefoxmarketplace' => 'Firefox Marketplace',
						'firefoxaddon' => 'Firefox Add-ons');
												
$style_names = array(	'0' => 'simple',
						'1' => 'banner',
						'2' => 'screenshots');		
						
?>
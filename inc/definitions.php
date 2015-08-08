<?php

define("WPAPPBOX_PLUGIN_NAME", 'WP-Appbox'); 
define("WPAPPBOX_PLUGIN_VERSION", '3.1.7');

define("WPAPPBOX_CACHINGTIME", (get_option('wpAppbox_cacheTime') != '' ? get_option('wpAppbox_cacheTime') : $wpAppbox_optionsDefault['cacheTime'])); 

define("WPAPPBOX_PLUGIN_BASE_DIR", basename(dirname(dirname(__FILE__))));

define("WPAPPBOX_PREFIX", 'wpAppbox_');
						
$wpAppbox_storeNames = array(	
	'amazonapps' => 'Amazon Apps',
	'appstore' => '(Mac) App Store',
	'chromewebstore' => 'Chrome Web Store',
	'firefoxaddon' => 'Firefox Erweiterungen',
	'firefoxmarketplace' => 'Firefox Marketplace',
	'goodoldgames' => 'Good Old Games (GOG.com)',
	'googleplay' => 'Google Play Apps',
	'operaaddons' => 'Opera Add-ons',
	'steam' => 'Steam',
	'windowsstore' => 'Windows Store',
	'wordpress' => 'WordPress Plugins'
);
								
$wpAppbox_secureStores = array('chromewebstore', 'firefoxaddons', 'firefoxmarketplace', 'googleplay', 'operaaddons');	
												
$wpAppbox_styleNames = array(
	'0' => 'standard',
	'1' => 'simple',
	'2' => 'compact',
	'3' => 'screenshots',
	'4' => 'screenshots-only'
);
							
$wpAppbox_storeStyles = array(	
	'amazonapps' => array(1, 2, 3, 4),
	'appstore' => array(1, 2, 3, 4),
	'chromewebstore' => array(1, 2),
	'firefoxaddon' => array(1, 2, 3, 4),
	'firefoxmarketplace' => array(1, 2, 3, 4),
	'goodoldgames' => array(1, 2, 3, 4),
	'googleplay' => array(1, 2, 3, 4),
	'operaaddons' => array(1, 2, 3, 4),
	'steam' => array(1, 2, 3, 4),
	'windowsstore' => array(1, 2, 3, 4),
	'wordpress' => array(1, 2, 3, 4)
);

$wpAppbox_optionsDefault = array(
	'pluginVersion' => WPAPPBOX_PLUGIN_VERSION,
	'cacheTime' => intval('600'),
	'imageCache' => false,
	'nofollow' => true,
	'targetBlank' => true,
	'showRating' => true,
	'colorfulIcons' => false,
	'showReload' => true,
	'downloadCaption' => __('Download', 'wp-appbox'),
	'disableCSS' => false,
	'disableFonts' => false,
	'eOnlyAuthors' => false,
	'eOutput' => false,
	'eImageApple' => false,
	'curlTimeout' => intval('5'),
	'userAffiliate' => false,
	'affiliateApple' => '',
	'affiliateAppleDev' => false,
	'affiliateAmazon' => '',
	'affiliateAmazonDev' => false,
	'defaultStyle' => intval('1'),
	'defaultButton' => intval('0')
);


?>
<?php 

	$store_urls_languages = array(
		'0' => __('Use own URL', 'wp-appbox'),
		'1' => __('Germany', 'wp-appbox'),
		'2' => __('United States', 'wp-appbox'),
		'3' => __('United Kingdom', 'wp-appbox'),
		'4' => __('France', 'wp-appbox'),
		'5' => __('Spain', 'wp-appbox'),
		'6' => __('Russia', 'wp-appbox'),
		'7' => __('Turkey', 'wp-appbox'),
		'8' => __('Italy', 'wp-appbox'),
		'9' => __('Austria', 'wp-appbox'),
		'10' => __('Switzerland', 'wp-appbox')
	);
	
	$store_no_languages = array('chromewebstore', 'steam', 'wordpress', 'goodoldgames');
	
	$store_urls = array(	
		'amazonapps' => array(
			'1' => 'http://www.amazon.de/gp/product/{APPID}/?ie=UTF8',
			'2' => 'http://www.amazon.com/gp/product/{APPID}/?ie=UTF8',
			'3' => 'http://www.amazon.co.uk/gp/product/{APPID}/?ie=UTF8',
			'4' => 'http://www.amazon.fr/gp/product/{APPID}/?ie=UTF8',
			'5' => 'http://www.amazon.es/gp/product/{APPID}/?ie=UTF8',
			'8' => 'http://www.amazon.it/gp/product/{APPID}/?ie=UTF8'
		),
		'appstore' => array(
			'1' => 'https://itunes.apple.com/de/{APPID}',
			'2' => 'https://itunes.apple.com/us/{APPID}',
			'3' => 'https://itunes.apple.com/gb/{APPID}',
			'4' => 'https://itunes.apple.com/fr/{APPID}',
			'5' => 'https://itunes.apple.com/es/{APPID}',
			'6' => 'https://itunes.apple.com/ru/{APPID}',
			'7' => 'https://itunes.apple.com/tr/{APPID}',
			'8' => 'https://itunes.apple.com/it/{APPID}',
			'9' => 'https://itunes.apple.com/at/{APPID}',
			'10' => 'https://itunes.apple.com/ch/{APPID}'
		),
		'chromewebstore' => array(
			'1' => 'https://chrome.google.com/webstore/detail/{APPID}?hl=de'
		),
		'firefoxaddon' => array(
			'1' => 'https://addons.mozilla.org/de/firefox/addon/{APPID}/',
			'2' => 'https://addons.mozilla.org/en-US/firefox/addon/{APPID}/',
			'4' => 'https://addons.mozilla.org/fr/firefox/addon/{APPID}/',
			'5' => 'https://addons.mozilla.org/es/firefox/addon/{APPID}/',
			'6' => 'https://addons.mozilla.org/ru/firefox/addon/{APPID}/',
			'8' => 'https://addons.mozilla.org/it/firefox/addon/{APPID}/'
		),
		'firefoxmarketplace' => array(
			'1' => 'https://marketplace.firefox.com/api/v1/apps/app/{APPID}/?region=de&lang=de',
			'2' => 'https://marketplace.firefox.com/api/v1/apps/app/{APPID}/?region=us&lang=en',
			'3' => 'https://marketplace.firefox.com/api/v1/apps/app/{APPID}/?region=en&lang=uk',
			'4' => 'https://marketplace.firefox.com/api/v1/apps/app/{APPID}/?region=fr&lang=fr',
			'5' => 'https://marketplace.firefox.com/api/v1/apps/app/{APPID}/?region=es&lang=es',
			'6' => 'https://marketplace.firefox.com/api/v1/apps/app/{APPID}/?region=ru&lang=ru',
			'7' => 'https://marketplace.firefox.com/api/v1/apps/app/{APPID}/?region=tr&lang=tr',
			'8' => 'https://marketplace.firefox.com/api/v1/apps/app/{APPID}/?region=it&lang=it',
		),
		'goodoldgames' => array(
			'1' => 'http://www.gog.com/game/{APPID}'
		),
		'googleplay' => array(
			'1' => 'https://play.google.com/store/apps/details?id={APPID}&hl=de',
			'2' => 'https://play.google.com/store/apps/details?id={APPID}&hl=en',
			'3' => 'https://play.google.com/store/apps/details?id={APPID}&hl=en',
			'4' => 'https://play.google.com/store/apps/details?id={APPID}&hl=fr',
			'5' => 'https://play.google.com/store/apps/details?id={APPID}&hl=es',
			'6' => 'https://play.google.com/store/apps/details?id={APPID}&hl=ru',
			'7' => 'https://play.google.com/store/apps/details?id={APPID}&hl=tr',
			'8' => 'https://play.google.com/store/apps/details?id={APPID}&hl=it',
			'9' => 'https://play.google.com/store/apps/details?id={APPID}&hl=au',
			'10' => 'https://play.google.com/store/apps/details?id={APPID}&hl=ch'
		),
		'operaaddons' => array(
			'1' => 'https://addons.opera.com/de/extensions/details/{APPID}/',
			'2' => 'https://addons.opera.com/en/extensions/details/{APPID}/',
			'3' => 'https://addons.opera.com/en-gb/extensions/details/{APPID}/',
			'4' => 'https://addons.opera.com/fr/extensions/details/{APPID}/',
			'5' => 'https://addons.opera.com/es/extensions/details/{APPID}/',
			'6' => 'https://addons.opera.com/ru/extensions/details/{APPID}/',
			'7' => 'https://addons.opera.com/tr/extensions/details/{APPID}/',
			'8' => 'https://addons.opera.com/it/extensions/details/{APPID}/'
		),
		'pebble' => array(
			'1' => 'https://apps.getpebble.com/applications/{APPID}'
		),
		'steam' => array(
			'1' => 'http://store.steampowered.com/api/appdetails/?appids={APPID}&cc=de&l=de',
			'2' => 'http://store.steampowered.com/api/appdetails/?appids={APPID}&cc=us&l=en',
			'3' => 'http://store.steampowered.com/api/appdetails/?appids={APPID}&&cc=uk&en=uk',
			'4' => 'http://store.steampowered.com/api/appdetails/?appids={APPID}&&cc=fr&en=fr',
			'5' => 'http://store.steampowered.com/api/appdetails/?appids={APPID}&&cc=es&en=es',
			'6' => 'http://store.steampowered.com/api/appdetails/?appids={APPID}&&cc=ru&en=ru',
			'7' => 'http://store.steampowered.com/api/appdetails/?appids={APPID}&&cc=tr&en=tr',
			'8' => 'http://store.steampowered.com/api/appdetails/?appids={APPID}&&cc=it&en=it',
			'9' => 'http://store.steampowered.com/api/appdetails/?appids={APPID}&&cc=at&en=de'
		),
		'windowsstore' => array(
			'1' => 'http://apps.microsoft.com/windows/de-de/app/{APPID}',
			'2' => 'http://apps.microsoft.com/windows/en-us/app/{APPID}',
			'3' => 'http://apps.microsoft.com/windows/en-gb/app/{APPID}',
			'4' => 'http://apps.microsoft.com/windows/fr-fr/app/{APPID}',
			'5' => 'http://apps.microsoft.com/windows/es-es/app/{APPID}',
			'6' => 'http://apps.microsoft.com/windows/ru-ru/app/{APPID}',
			'7' => 'http://apps.microsoft.com/windows/tr-tr/app/{APPID}',
			'8' => 'http://apps.microsoft.com/windows/it-it/app/{APPID}',
			'9' => 'http://apps.microsoft.com/windows/de-at/app/{APPID}',
			'10' => 'http://apps.microsoft.com/windows/de-ch/app/{APPID}'
		),
		'windowsphone' => array(
			'1' => 'http://www.windowsphone.com/de-de/store/app/app/{APPID}',
			'2' => 'http://www.windowsphone.com/en-us/store/app/app/{APPID}',
			'3' => 'http://www.windowsphone.com/en-gb/store/app/app/{APPID}',
			'4' => 'http://www.windowsphone.com/fr-fr/store/app/app/{APPID}',
			'5' => 'http://www.windowsphone.com/es-es/store/app/app/{APPID}',
			'6' => 'http://www.windowsphone.com/ru-ru/store/app/app/{APPID}',
			'7' => 'http://www.windowsphone.com/tr-tr/store/app/app/{APPID}',
			'8' => 'http://www.windowsphone.com/it-it/store/app/app/{APPID}',
			'9' => 'http://www.windowsphone.com/de-at/store/app/app/{APPID}',
			'10' => 'http://www.windowsphone.com/de-ch/store/app/app/{APPID}'
		),
		'wordpress' => array(
			'1' => 'https://wordpress.org/plugins/{APPID}/'
		),
		);
		
	function getStoreURL_AppStore() {
		
	}

?>
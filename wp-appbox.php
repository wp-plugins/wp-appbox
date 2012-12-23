<?php
/*
Plugin Name: WP-Appbox
Plugin URI: http://www.blogtogo.de/
Description: "WP-Appbox" ermöglicht es, via Shortcode schnell und einfach App-Details von Apps aus dem Apple App Store, Windows Store, Windows Phone Store und aus Google Play in Artikeln oder auf Seiten anzuzeigen.
Author: Marcel Schmilgeit
Version: 1.0.0 Beta 5
Author URI: http://www.blogtogo.de
*/

include("inc/definitions.php");
include("inc/admin.php");
include_once('inc/class.php');

$store_names = array(	'appstore' => '(Mac) App Store',
						'googleplay' => 'Google Play',
						'windowsstore' => 'Windows Store',
						'windowsphone' => 'Windows Phone Store',
						'appworld' => 'BlackBerry AppWorld',
						'androidpit' => 'AndroidPit');
						
$style_names = array(	'0' => 'simple',
						'1' => 'banner',
						'2' => 'screenshots');			

function convert_atts($atts) {
	return(array_map('strtolower', $atts));
}


function is_value_style($value) {
	if($value == 'simple' || $value == 'banner' || $value == 'screenshots') return(true);
	else return(false);
}


function is_value_store($value) {
	global $store_names;
	if(array_key_exists($value, $store_names)) return(true);
	else return(false);
}


function get_app_store_url() {
	global $ItemInfo;
	$options = get_option('wpAppbox');
	foreach($ItemInfo['General'] as $appdata) {
		$app_store_url = $appdata->app_store_url;
		if(trim($app_store_url) != '') {
			if(strpos($app_store_url, 'apple.com')) {
				if($options['wpAppbox_affid_sponsored'] == true) $app_store_url = 'http://clkde.Tradedoubler.com/click?p=23761&a=1906666&url='.urlencode($app_store_url).'&partnerId=2003';
				elseif (Trim($options['wpAppbox_affid']) != '') $app_store_url = 'http://clkde.Tradedoubler.com/click?p=23761&a='.Trim($options['wpAppbox_affid']).'&url='.urlencode($app_store_url).'&partnerId=2003';
			}
			return($app_store_url);
		}
	}
}


function qrcode_url($size ='400', $EC_level='H', $margin='1') {
	global $ItemInfo;
	$url = urlencode(get_app_store_url());
	echo('http://chart.apis.google.com/chart?cht=qr&chl='.$url.'&chs='.$size.'x'.$size.'&chld=L|0');
}


function app_store_url() {
	echo(get_app_store_url());
}
	
	
function app_store_url_enc() {
	echo(urlencode(get_app_store_url()));
}
	
	
function banner_image() {
	global $ItemInfo;
	foreach($ItemInfo['General'] as $appdata) echo($appdata->banner_image);
}
	
	
function banner_icon() {
	global $ItemInfo;
	foreach($ItemInfo['General'] as $appdata) echo($appdata->banner_icon);
}

	
function app_author() {
	echo(get_app_author());
}

	
function get_app_author() {
	global $ItemInfo;
	foreach($ItemInfo['General'] as $appdata) {
		$app_author = $appdata->app_author;
		if(trim($app_author) != '') {
			if(strlen($app_author) > 31) $app_author = substr($app_author, 0, 29).'…';
		}
		return($app_author);
	}
}
	
	
function author_store_url() {
	global $ItemInfo;
	foreach($ItemInfo['General'] as $appdata) echo($appdata->author_store_url);
}
	
	
function app_price() {
	global $ItemInfo;
	foreach($ItemInfo['General'] as $appdata) echo($appdata->app_price);
}

	
function app_title() {
	global $ItemInfo;
	foreach($ItemInfo['General'] as $appdata) echo($appdata->app_title);
}


function app_screenshots() {
	global $ItemInfo;
	foreach($ItemInfo['ScreenShots'] as $appshots) echo('<li><img src="'.$appshots->screen_shot.'" alt="" /></li>');
}


function storename() {
	global $ItemInfo;
	foreach($ItemInfo['General'] as $appdata) echo($appdata->storename);
}


function storename_css() {
	global $ItemInfo;
	foreach($ItemInfo['General'] as $appdata) echo($appdata->storename_css);
}


function get_storename_css() {
	global $ItemInfo;
	foreach($ItemInfo['General'] as $appdata) if(trim($appdata->storename_css) != '') return($appdata->storename_css);
}


function do_nofollow($tpl) {
	$tpl = str_replace('<a ', '<a rel="nofollow" ', $tpl);
	return($tpl);
}


function do_targetblank($tpl) {
	$tpl = str_replace('<a ', '<a target="_blank" ', $tpl);
	return($tpl);
}


function output_tpl($tpl) {
	$options = get_option('wpAppbox');
	if($options['wpAppbox_nofollow'] == true) $tpl = do_nofollow($tpl);
	if($options['wpAppbox_blank'] == true) $tpl = do_targetblank($tpl);
	return($tpl);
}


function wpAppbox_appbox($atts, $content) {
	global $ItemInfo, $store_names, $style_names;
	$class_init = new GetAppInfoAPI;
	
	foreach ($atts as $value) {
		if(is_value_style($value)) $style = $value;
		elseif(is_value_store($value)) $store = $value;
		else $id = $value;
	}
	
	if($store == '') $error .= ('<li>Der Store konnte <strong>nicht</strong> erkannt werden. :(</li>');
	if($id == '') $error .= ('<li>Es konnte <strong>keine</strong> App-ID erkannt werden. :-(</li>');
	if($error != '') return('<div class="appcontainer"><ul class="error">'.$error.'</ul></div>');
	
	if($style == '') {
	 	$options = get_option('wpAppbox');
	 	$style = $style_names[$options['wpAppbox_view_'.$store]];
	}
	if(($style == 'banner') && ($store != 'googleplay') && ($store != 'androidpit')) $style = 'simple';
	if(is_feed()) $style = 'feed';
	
	$getdatafunc = 'get'.$store;
	$ItemInfo = $class_init->$getdatafunc($id);
	if($ItemInfo !== 0) {
		ob_start();
		include 'tpl/'.$style.'.php';
		$tpl = ob_get_contents();
		ob_end_clean();
		if($ItemInfo !== 0) return(output_tpl($tpl));
	}
	else return('<div class="appcontainer"><ul class="error"><li>Die App konnte bei "'.$store_names[$store].'" <b>nicht</b> gefunden werden. :-(</li></ul></div>');
}


function br_trigger_error($message) {
    if(isset($_GET['action']) && $_GET['action'] == 'error_scrape') {
        echo '<strong>' . $message . '</strong>';
        exit;
    } 
    else trigger_error($message, E_USER_ERROR);
}


function wpAppbox_add_buttons($buttons) {
	$options = get_option('wpAppbox');
	if($options['wpAppbox_enabled_appbox']) array_push($buttons, "separator", "wpAppbox_AppboxButton");
	else {
		if($options['wpAppbox_enabled_appstore']) array_push($buttons, "separator", "wpAppbox_AppStoreButton");
		if($options['wpAppbox_enabled_googleplay']) array_push($buttons, "separator", "wpAppbox_GooglePlayButton");
		if($options['wpAppbox_enabled_windowsstore']) array_push($buttons, "separator", "wpAppbox_WindowsStoreButton");
		if($options['wpAppbox_enabled_windowsphone']) array_push($buttons, "separator", "wpAppbox_WindowsPhoneStoreButton");
		if($options['wpAppbox_enabled_androidpit']) array_push($buttons, "separator", "wpAppbox_AndroidPitButton");
		if($options['wpAppbox_enabled_bbappworld']) array_push($buttons, "separator", "wpAppbox_BBAppWorldButton");
	}
	return $buttons;
}


function wpAppbox_register($plugin_array) {
	$options = get_option('wpAppbox');
	if($options['wpAppbox_enabled_appbox']) $plugin_array["buttons"] = plugins_url('buttons/combined.btn.js.php', __FILE__);
	else $plugin_array["buttons"] = plugins_url('buttons/single.btn.js.php', __FILE__);
	return $plugin_array;
}


function wpAppbox_activate()
{
	// check cache Directory
	if (!file_exists(WPAPPBOX_CONTENT_DIR) || !is_writable(WPAPPBOX_CONTENT_DIR)) {
	    if(!file_exists(WPAPPBOX_CONTENT_DIR)) mkdir(WPAPPBOX_CONTENT_DIR) or br_trigger_error('Das Cache Verzeichnis konnte nicht angelegt werden.');     
	    if(!is_writable(WPAPPBOX_CONTENT_DIR)) chmod(WPAPPBOX_CONTENT_DIR, 0777) or br_trigger_error('Das Cache Verzeichnis ist nicht schreibbar. Bitte die Flags des Ordners auf 777 setzen.');   
	}  
	if(allow_url_fopen=='off') {
		br_trigger_error('"allow_url_fopen" ist auf diesem Server deaktiviert, wird aber ben&ouml;tigt. Bitte aktivieren sie diese Funktion (setzten sie sich ggf. mit ihrem Hoster in Verbindung.'); 
	} 
	if(!function_exists('curl_init')){
		br_trigger_error('"curl" ist auf diesem Server deaktiviert, wird aber ben&ouml;tigt. Bitte aktivieren sie diese Funktion (setzten sie sich ggf. mit ihrem Hoster in Verbindung.'); 
	}  
	$my_new_options = array(
		'wpAppbox_piccache' => true,
		'wpAppbox_datacache' => true,
		'wpAppbox_piccchetime' => '60',
		'wpAppbox_datacachetime' => '60',
		'wpAppbox_affid' => '',
		'wpAppbox_affid_sponsored' => '0',
		'wpAppbox_view_appstore' => '0',
		'wpAppbox_view_googleplay' => '0',
		'wpAppbox_view_androidpit' => '0',
		'wpAppbox_view_bbappworld' => '0',
		'wpAppbox_view_windowsstore' => '0',
		'wpAppbox_view_windowsphone' => '0',
		'wpAppbox_nofollow' => '0',
		'wpAppbox_blank' => '1',
		'wpAppbox_enabled_appstore' => '1',
		'wpAppbox_enabled_googleplay' => '1',
		'wpAppbox_enabled_windowsstore' => '1',
		'wpAppbox_enabled_windowsphone' => '1',
		'wpAppbox_enabled_androidpit' => '1',
		'wpAppbox_enabled_bbappworld' => '1',
		'wpAppbox_enabled_appbox' => '1'
	);	
	add_option('wpAppbox', $my_new_options);
}


function wpAppbox_deactivate() {
	delete_option('wpAppbox');
}


wp_register_style('wpappbox', plugins_url('css/styles.min.css', __FILE__), array(), '1.0.0beta6', 'screen');
wp_enqueue_style('wpappbox');
 
add_shortcode('appbox', 'wpAppbox_appbox');
 
add_filter('mce_external_plugins', "wpAppbox_register");
add_filter('mce_buttons', 'wpAppbox_add_buttons', 0);

add_action('admin_menu', 'wpAppbox_create_menu');
add_action('admin_init', 'wpAppbox_register_settings');

register_activation_hook(__FILE__, 'wpAppbox_activate');
register_deactivation_hook(__FILE__, 'wpAppbox_deactivate');

?>
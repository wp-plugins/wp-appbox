<?php
/*
Plugin Name: WP-Appbox
Plugin URI: http://www.blogtogo.de/wp-appbox-app-badge-fuer-google-play-mac-app-store-windows-store-windows-phone-store-co/
Description: "WP-Appbox" ermöglicht es, via Shortcode schnell und einfach App-Details von Apps aus einer Reihe an App Stores in Artikeln oder Seiten anzuzeigen.
Author: Marcel Schmilgeit
Version: 1.3.1
Author URI: http://www.blogtogo.de
*/

include("inc/definitions.php");
include("inc/admin.php");
include_once('inc/class.php');
		

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
		$app_store_url = str_replace('?mt=8&uo=4', '', $appdata->app_store_url);
		if(trim($app_store_url) != '') {
			if(strpos($app_store_url, 'apple.com')) {
				if($options['wpAppbox_affid_sponsored'] == true) $affid = '1906666';
				elseif (Trim($options['wpAppbox_affid']) != '') $affid = Trim($options['wpAppbox_affid']);
				if($affid != '') $app_store_url = 'http://clk.Tradedoubler.com/click?p=23761&a='.$affid.'&url='.urlencode($app_store_url.'&partnerId=2003');
			}
			if(strpos($app_store_url, 'androidpit.de')) {
				if($options['wpAppbox_affid_affilinet_sponsored'] == true) $affid = '622817';
				elseif (Trim($options['wpAppbox_affid_affilinet']) != '') $affid = Trim($options['wpAppbox_affid_affilinet']);
				if($affid != '') $app_store_url = 'http://partners.webmasterplan.com/click.asp?ref='.$affid.'&site=8170&type=text&tnb=36&diurl='.$app_store_url;
			}
			return($app_store_url);
		}
	}
}


function qrcode_url($size ='400', $EC_level='L', $margin='0') {
	global $ItemInfo;
	$url = get_app_store_url();
	echo('http://chart.apis.google.com/chart?cht=qr&chl='.$url.'&chs='.$size.'x'.$size.'&chld='.$EC_level.'|'.$margin);
	//echo('http://chart.apis.google.com/chart?cht=qr&chl='.$url.'&chs='.$size.'x'.$size.'&chld=L|0');
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


function needs_fallback() {
	global $ItemInfo;
	foreach($ItemInfo['General'] as $appdata) {
		$fallback = $appdata->fallback;
		if(trim($fallback) == '1') return true;
		else return false;
	}
}


function output_fallback($tpl) {
	$tpl = preg_replace("%<span class=\"price\">(.*?)</span>%s", "", $tpl);
	$tpl = preg_replace("%<span class=\"developer\">(.*?)</span>%s", "<span class=\"fallback\">Aufgrund einer temporären Erkennung als Bot können momentan leider keine App-Details angezeigt werden.</span>", $tpl);
	$tpl = preg_replace("%<img class=\"appicon\" src=\"(.*?)\"%s", "<img class=\"appicon\" src=\"".plugins_url( 'img/fallback/'.get_storename_css().'.png' , __FILE__ )."\"", $tpl);
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
	
	if($store == 'appworld') $store = 'blackberryworld';
	
	if($store == '') $error .= ('<li>Der Store konnte <strong>nicht</strong> erkannt werden. :(</li>');
	if($id == '') $error .= ('<li>Es konnte <strong>keine</strong> App-ID erkannt werden. :-(</li>');
	if($error != '') return('<div class="appcontainer"><ul class="error">'.$error.'</ul></div>');
	
	if($style == '') {
		$style = 'simple';
	 	$options = get_option('wpAppbox');
	 	$style = $style_names[$options['wpAppbox_view_'.$store]];
	}
	if(($style == 'banner') && ($store != 'googleplay') && ($store != 'androidpit')) $style = 'simple';
	if(is_feed()) $style = 'feed';
	
	$getdatafunc = 'get'.$store;
	$ItemInfo = $class_init->$getdatafunc($id);
	if(needs_fallback()) $style = 'simple';
	if($ItemInfo !== 0) {
		if(count($ItemInfo['ScreenShots']) == 0) $style = 'simple';
		ob_start();
		include 'tpl/'.$style.'.php';
		$tpl = ob_get_contents();
		ob_end_clean();
		if($ItemInfo !== 0) $tpl = output_tpl($tpl);
		if(needs_fallback()) $tpl = output_fallback($tpl);
		return($tpl);
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
		if($options['wpAppbox_enabled_blackberryworld']) array_push($buttons, "separator", "wpAppbox_BlackBerryWorldButton");
		if($options['wpAppbox_enabled_chromewebstore']) array_push($buttons, "separator", "wpAppbox_ChromeWebStoreButton");
		if($options['wpAppbox_enabled_firefoxmarketplace']) array_push($buttons, "separator", "wpAppbox_FirefoxMarketplaceButton");
	}
	return $buttons;
}


function wpAppbox_register($plugin_array) {
	$options = get_option('wpAppbox');
	if($options['wpAppbox_enabled_appbox']) $plugin_array["wpAppbox"] = plugins_url('buttons/combined.btn.js.php', __FILE__);
	else $plugin_array["wpAppbox"] = plugins_url('buttons/single.btn.js.php', __FILE__);
	return $plugin_array;
}


function wpAppbox_activate()
{
	if(allow_url_fopen=='off') {
		br_trigger_error(__('"allow_url_fopen" is disabled on this server, but is required. Please enable this feature (or contact your hoster).', 'wp-appbox')); 
	} 
	if(!function_exists('curl_init')){
		br_trigger_error(__('"cURL" is disabled on this server, but is required. Please enable this feature (or contact your hoster).', 'wp-appbox')); 
	}  
}


function wpAppbox_deactivate() {
	delete_option('wpAppbox');
}


wp_register_style('wpappbox', plugins_url('css/styles.min.css', __FILE__), array(), WPAPPBOX_PLUGIN_VERSION, 'screen');
wp_enqueue_style('wpappbox');
 
add_shortcode('appbox', 'wpAppbox_appbox');
 
add_filter('mce_external_plugins', "wpAppbox_register");
add_filter('mce_buttons', 'wpAppbox_add_buttons', 0);

add_action('admin_menu', 'wpAppbox_pageInit');
add_action('admin_init', 'wpAppbox_adminInit');

register_activation_hook(__FILE__, 'wpAppbox_activate');
register_deactivation_hook(__FILE__, 'wpAppbox_deactivate');

?>
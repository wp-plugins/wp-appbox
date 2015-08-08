<?php
/*
Plugin Name: WP-Appbox
Plugin URI: http://www.blogtogo.de/wp-appbox-app-badge-fuer-google-play-mac-app-store-windows-store-windows-phone-store-co/
Description: "WP-Appbox" ermöglicht es, via Shortcode schnell und einfach App-Details von Apps aus einer Reihe an App Stores in Artikeln oder Seiten anzuzeigen.
Author: Marcel Schmilgeit
Version: 3.1.7
Author URI: http://www.blogtogo.de
*/

load_plugin_textdomain('wp-appbox', false, dirname(plugin_basename( __FILE__ )) . '/lang');

include_once("inc/definitions.php");
include_once('inc/getstoreurls.class.php');
include_once('inc/getappinfo.class.php');
include_once('inc/createattributs.class.php');
include_once('inc/createoutput.class.php');
include_once("admin/admin.php");
include_once("admin/user-profiles.php");
require_once(ABSPATH . 'wp-includes/pluggable.php');


function has_user_permissions() {
	$userdata = get_userdata(get_current_user_id());
	if(intval($userdata->user_level) >= 2) return true;
	else false;
}


function has_user_admin_permissions() {
	$userdata = get_userdata(get_current_user_id());
	if(intval($userdata->user_level) >= 9) return true;
	else false;
}


function cache_deactive() {
	if(has_user_permissions()) {
		if(isset($_GET['wpappbox_nocache'])) return true;
		else false;
	}
}


function create_new_cache($app_id) {
	if(has_user_permissions()) {
		if((isset($_GET['wpappbox_reload_cache'])) || (isset($_GET['action']) && $_GET['action'] === 'wpappbox_reload_cache')) {
			if(!isset($_GET['wpappbox_appid'])) return true;
			elseif($_GET['wpappbox_appid'] === $app_id) return true;
		}
	}
	return false;
}


function get_storename_css() {
	global $ItemInfo;
	foreach($ItemInfo['General'] as $appdata) if(trim($appdata->storename_css) != '') return($appdata->storename_css);
}


function wpAppbox_loadTemplate($styleName) {
	ob_start();
	include('tpl/'.$styleName.'.php');
	$tpl = ob_get_contents();
	print_r($tpl);
	ob_end_clean();
	return($tpl);
}


function wpAppbox_checkOlderVersion() {
	$this_ver = str_replace('.', '', WPAPPBOX_PLUGIN_VERSION);
	$comp_ver = str_replace('.', '', get_option('wpAppbox_pluginVersion'));
	if($comp_ver < $this_ver) return(true);
}


function wpAppbox_appbox($appbox_attributs, $content) {
	$attr = new CreateAttributs;
	$attr = $attr->devideAttributs($appbox_attributs);
	$output = new CreateOutput;
	$output = $output->theOutput($attr); 
	return($output);
}


function wpAppbox_UpdateAction() {
	if(get_option('wpAppbox') !== false) wpAppbox_updateOptions();
}


function wpAppbox_setOptions() {
	global $wpAppbox_optionsDefault, $wpAppbox_storeNames;
	foreach($wpAppbox_optionsDefault as $key => $value) {
		$key = 'wpAppbox_'.$key;
		if(get_option($key) === false) update_option($key, $value);
	}
	foreach($wpAppbox_storeNames as $storeID => $storeName) {
		$key_defaultStyle = 'wpAppbox_defaultStyle_'.$storeID;
		$key_buttonAppbox = 'wpAppbox_buttonAppbox_'.$storeID;
		$key_buttonWYSIWYG = 'wpAppbox_buttonWYSIWYG_'.$storeID;
		$key_buttonHTML = 'wpAppbox_buttonHTML_'.$storeID;
		$key_buttonHidden = 'wpAppbox_buttonHidden_'.$storeID;
		$key_storeURL = 'wpAppbox_storeURL_'.$storeID;
		$key_storeURL_URL = 'wpAppbox_storeURL_URL_'.$storeID;
		if(get_option($key_defaultStyle) === false) update_option($key_defaultStyle, intval('0'));
		if(get_option($key_buttonWYSIWYG) === false) update_option($key_buttonWYSIWYG, true);
		if(get_option($key_buttonHTML) === false) update_option($key_buttonHTML, true);
		if(get_option($key_storeURL) === false) update_option($key_storeURL, intval('1'));
		if(get_option($key_storeURL_URL) === false) update_option($key_storeURL_URL, '');
	}
	update_option('wpAppbox_pluginVersion', WPAPPBOX_PLUGIN_VERSION);
}


function wpAppbox_deleteOptions() {
	global $wpdb;
	$wpdb->query("DELETE FROM wp_options WHERE option_name LIKE 'wpAppbox_%';");
	delete_option('wpAppbox'); //Für ältere Versionen
}

//Für ältere Versionen
function wpAppbox_updateOptions() {
	$oldSettings = get_option('wpAppbox');
	if(!empty($oldSettings)) {
		global $wpAppbox_optionsDefault, $wpAppbox_storeNames;
		if($oldSettings['wpAppbox_datacachetime'] != '') update_option('wpAppbox_cacheTime', $oldSettings['wpAppbox_datacachetime']);
		if($oldSettings['wpAppbox_nofollow'] != ('' || false)) update_option('wpAppbox_nofollow', $oldSettings['wpAppbox_nofollow']);
		if($oldSettings['wpAppbox_blank'] != ('' || false)) update_option('wpAppbox_targetBlank', $oldSettings['wpAppbox_blank']);
		if($oldSettings['wpAppbox_showrating'] != ('' || false)) update_option('wpAppbox_showRating', $oldSettings['wpAppbox_showrating']);
		if($oldSettings['wpAppbox_colorful'] != ('' || false)) update_option('wpAppbox_colorfulIcons', $oldSettings['wpAppbox_colorful']);
		if($oldSettings['wpAppbox_show_reload_link'] != ('' || false)) update_option('wpAppbox_showReload', $oldSettings['wpAppbox_show_reload_link']);
		if($oldSettings['wpAppbox_downloadtext'] != '') update_option('wpAppbox_downloadCaption', $oldSettings['wpAppbox_downloadtext']);
		if($oldSettings['wpAppbox_useownsheet'] != ('' || false)) update_option('wpAppbox_disableCSS', $oldSettings['wpAppbox_useownsheet']);
		if($oldSettings['wpAppbox_avoid_loadfonts'] != ('' || false)) update_option('wpAppbox_disableFonts', $oldSettings['wpAppbox_avoid_loadfonts']);
		if($oldSettings['wpAppbox_error_onlyforauthor'] != ('' || false)) update_option('wpAppbox_eOnlyAuthors', $oldSettings['wpAppbox_error_onlyforauthor']);
		if($oldSettings['wpAppbox_error_erroroutput'] != ('' || false)) update_option('wpAppbox_eOutput', $oldSettings['wpAppbox_error_erroroutput']);
		if($oldSettings['wpAppbox_itunes_secureimage'] != ('' || false)) update_option('wpAppbox_eImageApple', $oldSettings['wpAppbox_itunes_secureimage']);
		if($oldSettings['wpAppbox_curl_timeout'] != '') update_option('wpAppbox_curlTimeout', $oldSettings['wpAppbox_curl_timeout']);
		if($oldSettings['wpAppbox_user_affiliateids'] != ('' || false)) update_option('wpAppbox_userAffiliate', $oldSettings['wpAppbox_user_affiliateids']);
		if($oldSettings['wpAppbox_affid'] != '') update_option('wpAppbox_affiliateApple', $oldSettings['wpAppbox_affid']);
		if($oldSettings['wpAppbox_affid_sponsored'] != ('' || false)) update_option('wpAppbox_affiliateAppleDev', $oldSettings['wpAppbox_affid_sponsored']);
		if($oldSettings['wpAppbox_affid_amazonpartnernet'] != '') update_option('wpAppbox_affiliateAmazon', $oldSettings['wpAppbox_affid_amazonpartnernet']);
		if($oldSettings['wpAppbox_affid_amazonpartnernet_sponsored'] != ('' || false)) update_option('wpAppbox_affiliateAmazonDev', $oldSettings['wpAppbox_affid_amazonpartnernet_sponsored']);
		if($oldSettings['wpAppbox_view_default'] != '') update_option('wpAppbox_defaultStyle', $oldSettings['wpAppbox_view_default']);
		if($oldSettings['wpAppbox_button_default'] != '') update_option('wpAppbox_defaultButton', $oldSettings['wpAppbox_button_default']);
		foreach($wpAppbox_storeNames as $storeID => $storeName) {
			$key_defaultStyle = 'wpAppbox_defaultStyle_'.$storeID;
			$key_buttonAppbox = 'wpAppbox_buttonAppbox_'.$storeID;
			$key_buttonWYSIWYG = 'wpAppbox_buttonWYSIWYG_'.$storeID;
			$key_buttonHTML = 'wpAppbox_buttonHTML_'.$storeID;
			$key_buttonHidden = 'wpAppbox_buttonHidden_'.$storeID;
			$key_storeURL = 'wpAppbox_storeURL_'.$storeID;
			$key_storeURL_URL = 'wpAppbox_storeURL_URL_'.$storeID;
			if($oldSettings['wpAppbox_view_'.$storeID] != '') update_option($key_defaultStyle, intval($oldSettings['wpAppbox_view_'.$storeID]));
			if($oldSettings['wpAppbox_button_appbox_'.$storeID] != ('' || false)) update_option($key_buttonAppbox, $oldSettings['wpAppbox_button_appbox_'.$storeID]);
			if($oldSettings['wpAppbox_button_alone_'.$storeID] != ('' || false)) update_option($key_buttonWYSIWYG, $oldSettings['wpAppbox_button_alone_'.$storeID]);
			if($oldSettings['wpAppbox_button_html_'.$storeID] != ('' || false)) update_option($key_buttonHTML, $oldSettings['wpAppbox_button_html_'.$storeID]);
			if($oldSettings['wpAppbox_button_hidden_'.$storeID] != ('' || false)) update_option($key_buttonHidden, $oldSettings['wpAppbox_button_hidden_'.$storeID]);
			if($oldSettings['wpAppbox_storeurl_'.$storeID] != ('' || false)) update_option($key_storeURL, intval($oldSettings['wpAppbox_storeurl_'.$storeID]));
			if($oldSettings['wpAppbox_storeurl_url'.$storeID] != ('' || false)) update_option($key_storeURL_URL, $oldSettings['wpAppbox_storeurl_url'.$storeID]);
		}
		update_option('wpAppbox_pluginVersion', WPAPPBOX_PLUGIN_VERSION);
		delete_option('wpAppbox'); //Für ältere Versionen
	}
}


function wpAppbox_addButtonsWYSIWYG($buttons) {
	$option = get_option('wpAppbox_defaultButton');
	if(($option == '0' || '3')) {
		if(get_option('wpAppbox_buttonWYSIWYG_amazonapps') || ($option == '0')) array_push($buttons, "separator", "wpAppbox_AmazonAppsButton");
		if(get_option('wpAppbox_buttonWYSIWYG_appstore') || ($option == '0')) array_push($buttons, "separator", "wpAppbox_AppStoreButton");
		if(get_option('wpAppbox_buttonWYSIWYG_chromewebstore') || ($option == '0')) array_push($buttons, "separator", "wpAppbox_ChromeWebStoreButton");
		if(get_option('wpAppbox_buttonWYSIWYG_firefoxaddon') || ($option == '0')) array_push($buttons, "separator", "wpAppbox_FirefoxAddonButton");
		if(get_option('wpAppbox_buttonWYSIWYG_firefoxmarketplace') || ($option == '0')) array_push($buttons, "separator", "wpAppbox_FirefoxMarketplaceButton");
		if(get_option('wpAppbox_buttonWYSIWYG_googleplay') || ($option == '0')) array_push($buttons, "separator", "wpAppbox_GooglePlayButton");
		if(get_option('wpAppbox_buttonWYSIWYG_operaaddons') || ($option == '0')) array_push($buttons, "separator", "wpAppbox_OperaAddonsButton");
		if(get_option('wpAppbox_buttonWYSIWYG_steam') || ($option == '0')) array_push($buttons, "separator", "wpAppbox_SteamButton");
		if(get_option('wpAppbox_buttonWYSIWYG_windowsstore') || ($option == '0')) array_push($buttons, "separator", "wpAppbox_WindowsStoreButton");
		if(get_option('wpAppbox_buttonWYSIWYG_wordpress') || ($option == '0')) array_push($buttons, "separator", "wpAppbox_WordPressButton");
	}
	if(($option == '1' || '3')) array_push($buttons, "separator", "wpAppbox_AppboxButton");
	return $buttons;
}


function wpAppbox_addButtonsHTML() {
	global $wpAppbox_storeNames;
	$option = get_option('wpAppbox_defaultButton');
	if($option != '2') {
		if(wp_script_is('quicktags')) {
			echo "<script type=\"text/javascript\">";
			foreach($wpAppbox_storeNames as $storeID => $storeName) {
				if(get_option('wpAppbox_buttonHTML_'.$storeID) || ($option == '0')) echo "QTags.addButton('htmlx_".$storeID."', 'Appbox: ".$storeID."', '[appbox ".$storeID." appid]', '', '', '".$storeName."');";
			}
			echo "</script>";
		}
	}
}


function wpAppbox_register($plugin_array) {
	global $wpAppbox_storeNames;
	$option = get_option('wpAppbox_defaultButton');
	foreach($wpAppbox_storeNames as $storeID => $storeName) {
		if(get_option('wpAppbox_buttonAppbox_'.$storeID)) $iscombined = true;
	}
	if(($option == '1') || ($option == '3')) {
		if(($iscombined) || ($option == '1')) {
			if(version_compare(get_bloginfo('version'), '3.9', '>=')) $plugin_array['wpAppbox_CombinedButton'] = plugins_url('buttons/combined.btn.js.php', __FILE__);
			else $plugin_array['wpAppboxCombined'] = plugins_url('buttons/combined.btn.old.js.php', __FILE__);
		}
	}
	if(($option == '0') || ($option == '3')) $plugin_array["wpAppboxSingle"] = plugins_url('buttons/single.btn.js.php', __FILE__);
	return $plugin_array;
}


function wpAppbox_addSettings($links, $file) {
	static $this_plugin;
	if(!$this_plugin) $this_plugin = plugin_basename(__FILE__);
	if($file == $this_plugin) {
		$settings_link = '<a href="options-general.php?page=wp-appbox">' . __('Settings') . '</a>';
		$links = array_merge(array($settings_link), $links);
	}
	return $links;
}


function wpAppbox_addLinks($links, $file) {
	static $this_plugin;
	if(!$this_plugin) $this_plugin = plugin_basename(__FILE__);
	if($file == $this_plugin) {
		$links = array();
		$links[] = 'Version '.WPAPPBOX_PLUGIN_VERSION;
		$links[] = '<a target="_blank" href="https://twitter.com/Marcelismus">' . __('Follow me on Twitter') . '</a>';
		$links[] = '<a target="_blank" href="http://www.blogtogo.de/wp-appbox-app-badge-fuer-google-play-mac-app-store-windows-store-windows-phone-store-co/">' . __('Plugin page') . '</a>';
		$links[] = '<a target="_blank" href="http://wordpress.org/support/view/plugin-reviews/wp-appbox">' . __('Rate the plugin') . '</a>';
		$links[] = '<a target="_blank" href="http://www.amazon.de/gp/registry/wishlist/1FC2DA2J8SZW7">' . __('Amazon Wishlist') . '</a>';
		$links[] = '<a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SH9AAS276RAS6">' . __('PayPal-Donation') . '</a>';
	}
	return $links;
}


function br_trigger_error($message) {
    if(isset($_GET['action']) && $_GET['action'] == 'error_scrape') {
        echo '<strong>'.$message.'</strong>';
        exit;
    } 
    else trigger_error($message, E_USER_ERROR);
}


function wpAppbox_activate() {
	if(version_compare(phpversion(), '5.0') == -1) br_trigger_error(__('To use this plugin requires at least PHP version 5.0 is required.', 'wp-appbox'));
	if(!function_exists('curl_init')) br_trigger_error(__('"cURL" is disabled on this server, but is required. Please enable this feature (or contact your hoster).', 'wp-appbox')); 
	if(!function_exists('curl_exec')) br_trigger_error(__('"curl_exec" is disabled on this server, but is required. Please enable this feature (or contact your hoster).', 'wp-appbox')); 
	wpAppbox_setOptions();
}


function wpAppbox_uninstall() {
	wpAppbox_deleteOptions();
}


function wpAppbox_RegisterStyle() {
	if(get_option('wpAppbox_disableCSS') == false) {
		wp_register_style('wpappbox', plugins_url('css/styles.min.css', __FILE__), array(), WPAPPBOX_PLUGIN_VERSION, 'screen');
		wp_enqueue_style('wpappbox');
	}
}


function wpAppbox_loadFonts() {
	if(get_option('wpAppbox_disableFonts') == false) {
		wp_register_style('open-sans', '//fonts.googleapis.com/css?family=Open+Sans:400,600');
		wp_enqueue_style('open-sans');
	}
}
add_action('wp_print_styles', 'wpAppbox_loadFonts');
 
add_shortcode('appbox', 'wpAppbox_appbox');
 
add_filter('mce_external_plugins', "wpAppbox_register");
add_filter('mce_buttons', 'wpAppbox_addButtonsWYSIWYG', 0);
add_filter('plugin_action_links', 'wpAppbox_addSettings', 10, 2);
add_filter('plugin_row_meta', 'wpAppbox_addLinks', 10, 2 );

add_action('admin_menu', 'wpAppbox_pageInit');
add_action('admin_init', 'wpAppbox_adminInit');
add_action('admin_print_footer_scripts', 'wpAppbox_addButtonsHTML');
add_action('wp_enqueue_scripts', 'wpAppbox_RegisterStyle');
if(version_compare(get_bloginfo('version'), '3.9', '>=')) add_action('admin_enqueue_scripts', 'wpAppbox_RegisterStyle');

register_activation_hook(__FILE__, 'wpAppbox_activate');
register_uninstall_hook(__FILE__, 'wpAppbox_uninstall');

//wpAppbox_deleteOptions();
if(wpAppbox_checkOlderVersion()) wpAppbox_UpdateAction();

?>
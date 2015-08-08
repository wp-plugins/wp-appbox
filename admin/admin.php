<?php

function is_there_any_url_function() {
	if(function_exists('wpappbox_get_googleplay_url')) return('wpappbox_get_googleplay_url');
	if(function_exists('wpappbox_get_goodoldgames_url')) return('wpappbox_get_goodoldgames_url');
	if(function_exists('wpappbox_get_firefoxmarketplace_url')) return('wpappbox_get_firefoxmarketplace_url');
	if(function_exists('wpappbox_get_amazonapps_url')) return('wpappbox_get_amazonapps_url');
	if(function_exists('wpappbox_get_appstore_url')) return('wpappbox_get_appstore_url');
	if(function_exists('wpappbox_get_steam_url')) return('wpappbox_get_steam_url');
	if(function_exists('wpappbox_get_samsungapps_url')) return('wpappbox_get_samsungapps_url');
	if(function_exists('wpappbox_get_wordpress_url')) return('wpappbox_get_wordpress_url');
	if(function_exists('wpappbox_get_windowsstore_url')) return('wpappbox_get_windowsstore_url');
	if(function_exists('wpappbox_get_operaaddons_url')) return('wpappbox_get_operaaddons_url');
	if(function_exists('wpappbox_get_firefoxaddon_url')) return('wpappbox_get_firefoxaddon_url');
	if(function_exists('wpappbox_get_chromewebstore_url')) return('wpappbox_get_chromewebstore_url');
	return false;
}

function wpAppbox_pageInit() {
	$settings_page = add_options_page(WPAPPBOX_PLUGIN_NAME.' Einstellungen', WPAPPBOX_PLUGIN_NAME, 'manage_options', 'wp-appbox', 'wpAppbox_options_page');
	add_action( "load-{$settings_page}", 'wpAppbox_loadSettingsPage' );
}

function wpAppbox_clear_cache() {
	global $wpdb;
	if(isset($_GET['clearcache'])) {
		if($wpdb->query("DELETE FROM `$wpdb->options` WHERE `option_name` LIKE ('%".WPAPPBOX_CACHE_PREFIX."%')")) echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>'.__('The cache was successfully cleared.', 'wp-appbox').'</strong></p></div>';
		else echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>'.__('The cache can not be emptied or there are no apps in the cache.', 'wp-appbox').'</strong></p></div>';
	}
}

function wpAppbox_adminInit() {
}

function wpAppbox_createTabs($current = '') {
	if(isset($_GET['tab'])) $current = $_GET['tab'];
    $tabs = array(	'cache' => __('Cache', 'wp-appbox'),
    				'general' => __('Settings', 'wp-appbox'),  
    				'banner' => __('App-Badge', 'wp-appbox'), 
    				'buttons' => __('Buttons', 'wp-appbox'),  
    				'affiliate' => __('Affiliate IDs', 'wp-appbox'),  
    				'storeurls' => __('Store-URLs', 'wp-appbox'),  
    				'help' => __('Help', 'wp-appbox'));
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=wp-appbox&tab=$tab'>$name</a>";

    }
    echo '</h2>';
}

function wpAppbox_loadSettingsPage() {
	if($_GET['tab'] === 'cache') {
		$args = array(
		       'label' => __('Apps', 'wp-appbox'),
		       'default' => 50,
		       'option' => 'apps_per_page'
		       );
		add_screen_option( 'per_page', $args );
	}
	if($_POST["wp-appbox-settings-submit"] == 'Y') {
		check_admin_referer("wp-appbox-setting-page");
		wpAppbox_saveSettings();
		$url_parameters = isset($_GET['tab'])?'updated=true&tab='.$_GET['tab']:'updated=true';
		wp_redirect(admin_url('options-general.php?page=wp-appbox&'.$url_parameters));
		exit;
	}
}


function wpAppbox_setScreenOptions($status, $option, $value) {
  if ('apps_per_page' == $option) return $value;
}
add_filter('set-screen-option', 'wpAppbox_setScreenOptions', 10, 3);


function wpAppbox_saveSettings() {
	global $wpAppbox_storeNames, $wpAppbox_optionsDefault;
	if(isset($_GET['tab'])) $tab = $_GET['tab'];
	switch($tab) {
    	case 'general':
	    	update_option('wpAppbox_curlTimeout', (trim($_POST['wpAppbox_curlTimeout']) != '' ? intval($_POST['wpAppbox_curlTimeout']) : $wpAppbox_optionsDefault['curlTimeout']));
	    	update_option('wpAppbox_downloadCaption', (trim($_POST['wpAppbox_downloadCaption']) != '' ? $_POST['wpAppbox_downloadCaption'] : $wpAppbox_optionsDefault['downloadCaption']));
    		update_option('wpAppbox_cacheTime', (trim($_POST['wpAppbox_cacheTime']) != '' ? intval($_POST['wpAppbox_cacheTime']) : $wpAppbox_optionsDefault['cacheTime']));
    		//update_option('wpAppbox_imageCache', $_POST['wpAppbox_imageCache']);
    		update_option('wpAppbox_nofollow', $_POST['wpAppbox_nofollow']);
    		update_option('wpAppbox_targetBlank', $_POST['wpAppbox_targetBlank']);
    		update_option('wpAppbox_showRating', $_POST['wpAppbox_showRating']);
    		update_option('wpAppbox_colorfulIcons', $_POST['wpAppbox_colorfulIcons']);
    		update_option('wpAppbox_showReload', $_POST['wpAppbox_showReload']);
    		update_option('wpAppbox_disableCSS', $_POST['wpAppbox_disableCSS']);
    		update_option('wpAppbox_disableFonts', $_POST['wpAppbox_disableFonts']);
    		update_option('wpAppbox_eOnlyAuthors', $_POST['wpAppbox_eOnlyAuthors']);
    		update_option('wpAppbox_eOutput', $_POST['wpAppbox_eOutput']);
    		update_option('wpAppbox_eImageApple', $_POST['wpAppbox_eImageApple']);
	   	break;
	   	case 'buttons':
	   		update_option('wpAppbox_defaultButton', intval($_POST['wpAppbox_defaultButton']));
	   		foreach($wpAppbox_storeNames as $storeID => $storeName) {
			   	$key_buttonAppbox = 'wpAppbox_buttonAppbox_'.$storeID;
				update_option($key_buttonAppbox, $_POST[$key_buttonAppbox]);
			   	$key_buttonWYSIWYG = 'wpAppbox_buttonWYSIWYG_'.$storeID;
				update_option($key_buttonWYSIWYG, $_POST[$key_buttonWYSIWYG]);
			   	$key_buttonHTML = 'wpAppbox_buttonHTML_'.$storeID;
				update_option($key_buttonHTML, $_POST[$key_buttonHTML]);
			   	$key_buttonHidden = 'wpAppbox_buttonHidden_'.$storeID;
				update_option($key_buttonHidden, $_POST[$key_buttonHidden]);
	   		}
	   	break;
	   	case 'storeurls':
	   		foreach($wpAppbox_storeNames as $storeID => $storeName) {
	   	   	$key_storeURL = 'wpAppbox_storeURL_'.$storeID;
	   	   	update_option($key_storeURL, intval($_POST[$key_storeURL]));
	   	   	if($_POST[$key_storeURL] == '0') {
	   	   		$key_storeURL_URL = 'wpAppbox_storeURL_URL_'.$storeID;
	   	   		update_option($key_storeURL_URL, trim($_POST[$key_storeURL_URL]));
	   	   	}
	   	}
	   	break;
		case 'banner':
			update_option('wpAppbox_defaultStyle', intval($_POST['wpAppbox_defaultStyle']));
			foreach($wpAppbox_storeNames as $storeID => $storeName) {
				$key_defaultStyle = 'wpAppbox_defaultStyle_'.$storeID;
				update_option($key_defaultStyle, intval($_POST[$key_defaultStyle]));
			}
		break;
		case 'affiliate':
			update_option('wpAppbox_userAffiliate', $_POST['wpAppbox_userAffiliate']);
			update_option('wpAppbox_affiliateApple', Trim($_POST['wpAppbox_affiliateApple']));
			update_option('wpAppbox_affiliateAppleDev', $_POST['wpAppbox_affiliateAppleDev']);
			update_option('wpAppbox_affiliateAmazon', Trim($_POST['wpAppbox_affiliateAmazon']));
			update_option('wpAppbox_affiliateAmazonDev', $_POST['wpAppbox_affiliateAmazonDev']);
		break;
	}
	update_option('wpAppbox_pluginVersion', WPAPPBOX_PLUGIN_VERSION);
}

function wpAppbox_options_page() {
	global $wpAppbox_storeNames, $wpAppbox_styleNames, $wpAppbox_storeStyles, $wpAppbox_storeURL_languages, $wpAppbox_storeURL, $wpAppbox_storeURL_noLanguages;
	if(isset($_GET['clearcache'])) { $tab = 'cache'; }
	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32">
			<br>
		</div>
		<h2><?php echo WPAPPBOX_PLUGIN_NAME; ?> (Version <?php echo WPAPPBOX_PLUGIN_VERSION; ?>)</h2>
		<?php wpAppbox_clear_cache(); ?>
		<?php 
			if(is_there_any_url_function() != false) { 
				$output = str_replace('{FUNCTIONNAME}', is_there_any_url_function(), __('Please remove the function "{FUNCTIONNAME}" and others from you functions.php.', 'wp-appbox'));
				$output = '<div id="setting-error-settings_updated" class="updated settings-error"><p>'.$output.'</p></div>';
				echo $output;
			}
		?>
		<div class="widget" style="margin:15px 0;"><p style="margin:10px;">
			<a href="https://twitter.com/Marcelismus" target="_blank"><?php _e('Follow me on Twitter', 'wp-appbox'); ?></a> | <a href="http://www.blogtogo.de/wp-appbox-app-badge-fuer-google-play-mac-app-store-windows-store-windows-phone-store-co/" target="_blank"><?php _e('Visit the Plugin plage', 'wp-appbox'); ?></a> | <a href="http://wordpress.org/extend/plugins/wp-appbox/" target="_blank"><?php _e('Plugin at WordPress Directory', 'wp-appbox'); ?></a> | <a href="http://wordpress.org/plugins/wp-appbox/changelog/" target="_blank"><?php _e('Changelog', 'wp-appbox'); ?></a>
			<a href="/wp-admin/options-general.php?page=wp-appbox&tab=cache&clearcache" onClick="return confirm('<?php _e('Are you sure that the cache should be cleared? All data must be reloaded from the server of the operator.', 'wp-appbox'); ?>')" style="float:right;"><?php _e('Clear cache', 'wp-appbox'); ?></a>
		</p></div>
		<?php if(isset($_GET['tab'])) { ?>
		<div style="float: right;">
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="SH9AAS276RAS6">
				<input type="image" src="https://www.paypalobjects.com/de_DE/DE/i/btn/btn_donate_SM.gif" border="0" name="submit">
				<img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
			</form>
		</div>
		<?php } ?>
		<?php wpAppbox_createTabs(); ?>
		<?php settings_fields('wpAppbox'); ?>
		<form method="post" action="<?php admin_url('options-general.php?page=wp-appbox'); ?>">
		<?php wp_nonce_field("wp-appbox-setting-page"); ?>
		<?php
			if(isset($_GET['tab'])) $tab = $_GET['tab'];
			if(isset($tab)) include_once('admin-'.$tab.'.php');
			else {
			?>
			<style>
				.donation-link>a:link,
				.donation-link>a:visited {
					position: absolute;
					bottom: 12px;
					width: 76px;
					height: 48px;
					display: block;
					padding-top: 28px;
					-webkit-border-radius: 42px;
					-moz-border-radius: 42px;
					border-radius: 42px;
					background-color: #D4B06A;
					color: #FFF;
					text-decoration: none;
					font-size: 14px;
				}
				.donation-link>a:hover,
				.donation-link>a:active {
					background-color: #996632;
				}
				.donation-link.amazon>a:link {
					right: 12px;
				}
				.donation-link.paypal>a:link {
					right: 100px;
				}
			</style>
			<div style="position: relative;width:100%; height: auto; text-align: center; background-color:#f5d6a9;">
				<div style="position: absolute; bottom: 4px; left: 8px;"><small>Logo by <a href="https://twitter.com/craive" target="_blank">@craive</a></small></div>
				<div class="donation-link amazon"><a href="http://www.amazon.de/gp/registry/wishlist/1FC2DA2J8SZW7?tag=blogtogo-21" target="_blank">Amazon</a></div>
				<div class="donation-link paypal"><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SH9AAS276RAS6" target="_blank">PayPal</a></div>
				<img style="width:100%; max-width: 1000px; max-height: 500px;" src="<?php echo plugins_url('img/wpappbox-logo.png', dirname(__FILE__)); ?>" alt="<?php echo WPAPPBOX_PLUGIN_NAME; ?> (Version <?php echo WPAPPBOX_PLUGIN_VERSION; ?>)" title="<?php echo WPAPPBOX_PLUGIN_NAME; ?> (Version <?php echo WPAPPBOX_PLUGIN_VERSION; ?>)" />
			</div>
			<?php
			}
		?>
		<?php 
		if($tab != 'help') {
		?>
		<p class="submit" style="clear: both;">
		  <?php if((isset($_GET['tab'])) && ($tab != 'cache') && ($tab != 'help')) { ?><input type="submit" name="Submit" class="button-primary" value="<?php _e('Save changes', 'wp-appbox'); ?>" /><?php } ?>
	      <input type="hidden" name="wp-appbox-settings-submit" value="Y" />
	   </p>
		<?php 
		}
	?>
	</form>
	</div>
<?php } ?>
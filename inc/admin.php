<?php

function wpAppbox_pageInit() {
	$settings_page = add_options_page(WPAPPBOX_PLUGIN_NAME, WPAPPBOX_PLUGIN_NAME, 'manage_options', 'wp-appbox', 'wpAppbox_options_page');
	add_action( "load-{$settings_page}", 'wpAppbox_loadSettingsPage' );
}

function wpAppbox_clear_cache() {
	global $wpdb;
	if(isset($_GET['clearcache'])) {
		if($wpdb->query("DELETE FROM `$wpdb->options` WHERE `option_name` LIKE ('%".WPAPPBOX_CACHE_PREFIX."%')")) echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>'.__('Der WP-Appbox-Cache wurde geleert.', 'wp-appbox').'</strong></p></div>';
		else echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>'.__('Der WP-Appbox-Cache konnte nicht geleert werden.', 'wp-appbox').'</strong></p></div>';
	}
}

function wpAppbox_adminInit() {
	$settings = get_option("wpAppbox");
	if(empty($settings)) {
		$settings = array();	
		add_option("wpAppbox", $settings, '', 'yes');
	}	
	$settings = get_option("wpAppbox");
	if(!array_key_exists('wpAppbox_piccache', $settings)) $settings['wpAppbox_piccache'] = true;
	if(!array_key_exists('wpAppbox_datacache', $settings)) $settings['wpAppbox_datacache'] = false;
	if(!array_key_exists('wpAppbox_piccchetime', $settings)) $settings['wpAppbox_piccchetime'] = '300';
	if(!array_key_exists('wpAppbox_datacachetime', $settings)) $settings['wpAppbox_datacachetime'] = '300';
	if(!array_key_exists('wpAppbox_qrcode', $settings)) $settings['wpAppbox_qrcode'] = '1';
	if(!array_key_exists('wpAppbox_affid', $settings)) $settings['wpAppbox_affid'] = '';
	if(!array_key_exists('wpAppbox_affid_sponsored', $settings)) $settings['wpAppbox_affid_sponsored'] = '0';
	if(!array_key_exists('wpAppbox_affid_affilinet', $settings)) $settings['wpAppbox_affid_affilinet'] = '';
	if(!array_key_exists('wpAppbox_affid_affilinet_sponsored', $settings)) $settings['wpAppbox_affid_affilinet_sponsored'] = '0';
	if(!array_key_exists('wpAppbox_affid_amazonpartnernet', $settings)) $settings['wpAppbox_affid_amazonpartnernet'] = '';
	if(!array_key_exists('wpAppbox_affid_amazonpartnernet_sponsored', $settings)) $settings['wpAppbox_affid_amazonpartnernet_sponsored'] = '0';
	if(!array_key_exists('wpAppbox_view_appstore', $settings)) $settings['wpAppbox_view_appstore'] = '0';
	if(!array_key_exists('wpAppbox_view_googleplay', $settings)) $settings['wpAppbox_view_googleplay'] = '0';
	if(!array_key_exists('wpAppbox_view_androidpit', $settings)) $settings['wpAppbox_view_androidpit'] = '0';
	if(!array_key_exists('wpAppbox_view_blackberryworld', $settings)) $settings['wpAppbox_view_blackberryworld'] = '0';
	if(!array_key_exists('wpAppbox_view_windowsstore', $settings)) $settings['wpAppbox_view_windowsstore'] = '0';
	if(!array_key_exists('wpAppbox_view_windowsphone', $settings)) $settings['wpAppbox_view_windowsphone'] = '0';
	if(!array_key_exists('wpAppbox_view_chromewebstore', $settings)) $settings['wpAppbox_view_chromewebstore'] = '0';
	if(!array_key_exists('wpAppbox_view_amazonapps', $settings)) $settings['wpAppbox_view_amazonapps'] = '0';
	if(!array_key_exists('wpAppbox_view_firefoxaddon', $settings)) $settings['wpAppbox_view_firefoxaddon'] = '0';
	if(!array_key_exists('wpAppbox_view_firefoxmarketplace', $settings)) $settings['wpAppbox_view_firefoxmarketplace'] = '0';
	if(!array_key_exists('wpAppbox_view_operaaddons', $settings)) $settings['wpAppbox_view_operaaddons'] = '0';
	if(!array_key_exists('wpAppbox_view_samsungapps', $settings)) $settings['wpAppbox_view_samsungapps'] = '0';
	if(!array_key_exists('wpAppbox_view_steam', $settings)) $settings['wpAppbox_view_steam'] = '0';
	if(!array_key_exists('wpAppbox_view_wordpress', $settings)) $settings['wpAppbox_view_wordpress'] = '0';
	if(!array_key_exists('wpAppbox_nofollow', $settings)) $settings['wpAppbox_nofollow'] = '0';
	if(!array_key_exists('wpAppbox_blank', $settings)) $settings['wpAppbox_blank'] = '1';
	if(!array_key_exists('wpAppbox_enabled_appbox', $settings)) $settings['wpAppbox_enabled_appbox'] = '0';
	if(!array_key_exists('wpAppbox_enabled_appstore', $settings)) $settings['wpAppbox_enabled_appstore'] = '1';
	if(!array_key_exists('wpAppbox_enabled_googleplay', $settings)) $settings['wpAppbox_enabled_googleplay'] = '1';
	if(!array_key_exists('wpAppbox_enabled_windowsstore', $settings)) $settings['wpAppbox_enabled_windowsstore'] = '1';
	if(!array_key_exists('wpAppbox_enabled_windowsphone', $settings)) $settings['wpAppbox_enabled_windowsphone'] = '1';
	if(!array_key_exists('wpAppbox_enabled_androidpit', $settings)) $settings['wpAppbox_enabled_androidpit'] = '1';
	if(!array_key_exists('wpAppbox_enabled_blackberryworld', $settings)) $settings['wpAppbox_enabled_blackberryworld'] = '1';
	if(!array_key_exists('wpAppbox_enabled_chromewebstore', $settings)) $settings['wpAppbox_enabled_chromewebstore'] = '1';
	if(!array_key_exists('wpAppbox_enabled_amazonapps', $settings)) $settings['wpAppbox_enabled_amazonapps'] = '1';
	if(!array_key_exists('wpAppbox_enabled_firefoxaddon', $settings)) $settings['wpAppbox_enabled_firefoxaddon'] = '1';
	if(!array_key_exists('wpAppbox_enabled_firefoxmarketplace', $settings)) $settings['wpAppbox_enabled_firefoxmarketplace'] = '1';
	if(!array_key_exists('wpAppbox_enabled_operaaddons', $settings)) $settings['wpAppbox_enabled_operaaddons'] = '1';
	if(!array_key_exists('wpAppbox_enabled_samsungapps', $settings)) $settings['wpAppbox_enabled_samsungapps'] = '1';
	if(!array_key_exists('wpAppbox_enabled_steam', $settings)) $settings['wpAppbox_enabled_steam'] = '1';
	if(!array_key_exists('wpAppbox_enabled_wordpress', $settings)) $settings['wpAppbox_enabled_wordpress'] = '1';
	if(!array_key_exists('wpAppbox_error_parseoutput', $settings)) $settings['wpAppbox_error_parseoutput'] = '0';
	if(!array_key_exists('wpAppbox_error_erroroutput', $settings)) $settings['wpAppbox_error_erroroutput'] = '0';
	if(!array_key_exists('wpAppbox_curl_timeout', $settings)) $settings['wpAppbox_curl_timeout'] = '3';
	if(!array_key_exists('wpAppbox_add_referrer', $settings)) $settings['wpAppbox_add_referrer'] = '0';
	if(!array_key_exists('wpAppbox_no_shorten_title', $settings)) $settings['wpAppbox_no_shorten_title'] = '0';
	if(!array_key_exists('wpAppbox_itunes_secureimage', $settings)) $settings['wpAppbox_itunes_secureimage'] = '0';
	if(!array_key_exists('wpAppbox_notification', $settings)) $settings['wpAppbox_notification'] = '0';
	if(!array_key_exists('wpAppbox_version', $settings)) $settings['wpAppbox_version'] = WPAPPBOX_PLUGIN_VERSION;
	$updated = update_option("wpAppbox", $settings);
}

function wpAppbox_createTabs($current = 'general') {
	if(isset($_GET['tab'])) $current = $_GET['tab'];
    $tabs = array(	'general' => __('Allgemeines', 'wp-appbox'),  
    				'editor' => __('Editor & Ausgabe', 'wp-appbox'),  
    				'affiliate' => __('Affiliate', 'wp-appbox'),  
    				//'cache' => __('Cache', 'wp-appbox'),  
    				'help' => __('Hilfe', 'wp-appbox'));
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=wp-appbox&tab=$tab'>$name</a>";

    }
    echo '</h2>';
}

function wpAppbox_loadSettingsPage() {
	if($_POST["wp-appbox-settings-submit"] == 'Y') {
		check_admin_referer("wp-appbox-setting-page");
		wpAppbox_saveSettings();
		$url_parameters = isset($_GET['tab'])?'updated=true&tab='.$_GET['tab']:'updated=true';
		wp_redirect(admin_url('options-general.php?page=wp-appbox&'.$url_parameters));
		exit;
	}
}

function wpAppbox_saveSettings() {
	$settings = get_option("wpAppbox");
	if(isset($_GET['tab'])) $tab = $_GET['tab'];
	else $tab = 'general';
	switch($tab) {
    	case 'general':
    		$settings['wpAppbox_datacachetime'] = $_POST['wpAppbox_datacachetime'];
    		$settings['wpAppbox_nofollow'] = $_POST['wpAppbox_nofollow'];
    		$settings['wpAppbox_blank'] = $_POST['wpAppbox_blank'];
    		$settings['wpAppbox_qrcode'] = $_POST['wpAppbox_qrcode'];
    		$settings['wpAppbox_no_shorten_title'] = $_POST['wpAppbox_no_shorten_title'];
    		$settings['wpAppbox_add_referrer'] = $_POST['wpAppbox_add_referrer'];
    		$settings['wpAppbox_error_parseoutput'] = $_POST['wpAppbox_error_parseoutput'];
    		$settings['wpAppbox_error_erroroutput'] = $_POST['wpAppbox_error_erroroutput'];
    		$settings['wpAppbox_curl_timeout'] = $_POST['wpAppbox_curl_timeout'];
    		$settings['wpAppbox_itunes_secureimage'] = $_POST['wpAppbox_itunes_secureimage'];
	   	break;
		case 'editor':
			$settings['wpAppbox_enabled_appstore'] = $_POST['wpAppbox_enabled_appstore'];
			$settings['wpAppbox_enabled_googleplay'] = $_POST['wpAppbox_enabled_googleplay'];
			$settings['wpAppbox_enabled_androidpit'] = $_POST['wpAppbox_enabled_androidpit'];
			$settings['wpAppbox_enabled_windowsstore'] = $_POST['wpAppbox_enabled_windowsstore'];
			$settings['wpAppbox_enabled_windowsphone'] = $_POST['wpAppbox_enabled_windowsphone'];
			$settings['wpAppbox_enabled_blackberryworld'] = $_POST['wpAppbox_enabled_blackberryworld'];
			$settings['wpAppbox_enabled_amazonapps'] = $_POST['wpAppbox_enabled_amazonapps'];
			$settings['wpAppbox_enabled_appbox'] = $_POST['wpAppbox_enabled_appbox'];
			$settings['wpAppbox_enabled_chromewebstore'] = $_POST['wpAppbox_enabled_chromewebstore'];
			$settings['wpAppbox_enabled_firefoxaddon'] = $_POST['wpAppbox_enabled_firefoxaddon'];
			$settings['wpAppbox_enabled_firefoxmarketplace'] = $_POST['wpAppbox_enabled_firefoxmarketplace'];
			$settings['wpAppbox_enabled_samsungapps'] = $_POST['wpAppbox_enabled_samsungapps'];
			$settings['wpAppbox_enabled_wordpress'] = $_POST['wpAppbox_enabled_wordpress'];
			$settings['wpAppbox_enabled_operaaddons'] = $_POST['wpAppbox_enabled_operaaddons'];
			$settings['wpAppbox_view_appstore'] = $_POST['wpAppbox_view_appstore'];
			$settings['wpAppbox_view_googleplay'] = $_POST['wpAppbox_view_googleplay'];
			$settings['wpAppbox_view_androidpit'] = $_POST['wpAppbox_view_androidpit'];
			$settings['wpAppbox_view_windowsstore'] = $_POST['wpAppbox_view_windowsstore'];
			$settings['wpAppbox_view_windowsphone'] = $_POST['wpAppbox_view_windowsphone'];
			$settings['wpAppbox_view_blackberryworld'] = $_POST['wpAppbox_view_blackberryworld'];
			$settings['wpAppbox_view_chromewebstore'] = $_POST['wpAppbox_view_chromewebstore'];
			$settings['wpAppbox_view_firefoxmarketplace'] = $_POST['wpAppbox_view_firefoxmarketplace'];
			$settings['wpAppbox_view_amazonapps'] = $_POST['wpAppbox_view_amazonapps'];
			$settings['wpAppbox_view_firefoxaddon'] = $_POST['wpAppbox_view_firefoxaddon'];
			$settings['wpAppbox_view_samsungapps'] = $_POST['wpAppbox_view_samsungapps'];
			$settings['wpAppbox_view_steam'] = $_POST['wpAppbox_view_steam'];
			$settings['wpAppbox_view_wordpress'] = $_POST['wpAppbox_view_wordpress'];
			$settings['wpAppbox_view_operaaddons'] = $_POST['wpAppbox_view_operaaddons'];
		break;
		case 'affiliate':
			$settings['wpAppbox_affid'] = Trim($_POST['wpAppbox_affid']);
			$settings['wpAppbox_affid_sponsored'] = $_POST['wpAppbox_affid_sponsored'];
			$settings['wpAppbox_affid_affilinet'] = Trim($_POST['wpAppbox_affid_affilinet']);
			$settings['wpAppbox_affid_affilinet_sponsored'] = $_POST['wpAppbox_affid_affilinet_sponsored'];
			$settings['wpAppbox_affid_amazonpartnernet'] = Trim($_POST['wpAppbox_affid_amazonpartnernet']);
			$settings['wpAppbox_affid_amazonpartnernet_sponsored'] = $_POST['wpAppbox_affid_amazonpartnernet_sponsored'];
		break;
		case 'cache':
		break;
	}
	$settings['wpAppbox_version'] = WPAPPBOX_PLUGIN_VERSION;
	$updated = update_option("wpAppbox", $settings);
}

function wpAppbox_options_page() {
	global $store_names, $mobile_stores;
	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32">
			<br>
		</div>
		<h2><?php echo WPAPPBOX_PLUGIN_NAME; ?> (Version <?php echo WPAPPBOX_PLUGIN_VERSION; ?>)</h2>
		<?php $options = get_option('wpAppbox'); ?>
		<?php 
			if($options['wpAppbox_notification'] == '1') {
				echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>'.__('WP-Appbox wurde erfolgreich aktualisiert. Falls Dir das Plugin gefällt, <a href="http://wordpress.org/support/view/plugin-reviews/wp-appbox" target="_blank">bewerte es doch im Plugin-Verzeichnis</a>. :-)', 'wp-appbox').'</strong></p></div>'; 
				$options['wpAppbox_notification'] = '0';
				$updated = update_option("wpAppbox", $options);
			}
		?>
		<?php wpAppbox_clear_cache(); ?> 
		<div class="widget" style="margin:15px 0;"><p style="margin:10px;">
			<a href="https://twitter.com/Marcelismus" target="_blank"><?php _e('Folge mir via Twitter', 'wp-appbox'); ?></a> | <a href="http://www.blogtogo.de/wp-appbox-app-badge-fuer-google-play-mac-app-store-windows-store-windows-phone-store-co/" target="_blank"><?php _e('Besuch die Plugin-Seite', 'wp-appbox'); ?></a> | <a href="http://wordpress.org/extend/plugins/wp-appbox/" target="_blank"><?php _e('Plugin im WordPress Directory', 'wp-appbox'); ?></a>
			<a href="/wp-admin/options-general.php?page=wp-appbox&clearcache" onClick="return confirm('<?php _e('Soll der Cache wirklich geleert werden? Sämtliche App-Daten müssen dann neu von den Servern der Betreiber geladen werden.', 'wp-appbox'); ?>')" style="float:right;"><?php _e('Cache leeren', 'wp-appbox'); ?></a>
		</p></div>
		<div style="float: right;">
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="SH9AAS276RAS6">
				<input type="image" src="https://www.paypalobjects.com/de_DE/DE/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">
				<img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
			</form>
		</div>
		<?php wpAppbox_createTabs(); ?>
		<?php settings_fields('wpAppbox'); ?>
		<form method="post" action="<?php admin_url('options-general.php?page=wp-appbox'); ?>">
		<?php wp_nonce_field("wp-appbox-setting-page"); ?>
		<table class="form-table">
	<?php
	if(isset($_GET['tab'])) $tab = $_GET['tab'];
	else $tab = 'general';
	switch($tab){
		case 'general':
			?>
			<tr valign="top">
				<th scope="row" colspan="2"><strong><?php _e('Cache-Einstellungen', 'wp-appbox'); ?></strong><br /><i><?php _e('Die Cachingzeiten geben an, wie oft die Daten aktualisiert vom Server geladen werden - dies erhöht die Performance und sollte eigentlich nicht geändert werden.', 'wp-appbox'); ?></i></th>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Caching-Zeit (in Minuten)', 'wp-appbox'); ?>:</th>
				<td>
					<input type="number" pattern="[0-9]*" name="wpAppbox_datacachetime" value="<?php echo $options['wpAppbox_datacachetime']; ?>" />
					<span class="description"><?php _e('Die empfohlene Zeitspanne beträgt <strong>300</strong> Minuten', 'wp-appbox'); ?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" colspan="2"><strong><?php _e('Sonstige Einstellungen', 'wp-appbox'); ?></strong><br /><i><?php _e('Sonstiges Gedöns, was keine eigene Kategorie benötigt :D', 'wp-appbox'); ?></i></th>
			</tr>
			<tr valign="top">
				<?php 
					$mobile_stores_count = count($mobile_stores);
					$i = 0;
					foreach($mobile_stores as $name) { 
						$i++;
						$mobile_stores_output .= $name;
						if($mobile_stores_count > $i) $mobile_stores_output .= ', ';
					} 
				?>
				<th scope="row"><?php _e('QR-Codes', 'wp-appbox'); ?>:</th>
				<td>	
				    <p><input type="radio" name="wpAppbox_qrcode" value="1" <?php  if($options['wpAppbox_qrcode'] == '1') echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Zeigt alle QR-Codes in sämtlichen App-Badges an.', 'wp-appbox'); ?></span></p>
				    <p><input type="radio" name="wpAppbox_qrcode" value="2" <?php  if($options['wpAppbox_qrcode'] == '2') echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Zeigt QR-Codes nur für mobile App Stores an:', 'wp-appbox'); ?> <?php echo $mobile_stores_output; ?></span></p>
				    <p><input type="radio" name="wpAppbox_qrcode" value="0" <?php  if($options['wpAppbox_qrcode'] == '0') echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Blendet sämtliche QR-Codes in den App-Badges aus. Temporär funktioniert dies auch über das Attribut "noqrcode" im Shortcode.', 'wp-appbox'); ?></span></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Titel nicht kürzen', 'wp-appbox'); ?>:</th>
				<td>
					<input type="checkbox" name="wpAppbox_no_shorten_title" value="1" <?php  if($options['wpAppbox_no_shorten_title']) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Zeigt immer den vollen App-Titel, auch wenn dieser zu viele Zeichen enthält.', 'wp-appbox'); ?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Nofollow', 'wp-appbox'); ?>:</th>
				<td>
					<input type="checkbox" name="wpAppbox_nofollow" value="1" <?php  if($options['wpAppbox_nofollow']) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Fügt allen Links das Attribut "<a href="http://de.wikipedia.org/wiki/Nofollow" target="_blank">nofollow</a>" hinzu', 'wp-appbox'); ?></span>
				</td>
			</tr>
			<th scope="row"><?php _e('Öffne Links in einem neuen Fenster', 'wp-appbox'); ?>:</th>
				<td>
					<input type="checkbox" name="wpAppbox_blank" value="1" <?php  if($options['wpAppbox_blank']) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Öffnet alle App-Links in einem neuen Fenster (target="blank")', 'wp-appbox'); ?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" colspan="2"><strong><?php _e('Fehlerausgabe & Fehlerbehebung', 'wp-appbox'); ?></strong><br /><i><?php _e('Die Fehlerausgabe sollte nur in Problemfällen eingeschaltet werden. Kann das Design auseinandernehmen.', 'wp-appbox'); ?></i></th>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Server Timeout', 'wp-appbox'); ?>:</th>
				<td>
					<input type="number" pattern="[0-9]*" name="wpAppbox_curl_timeout" value="<?php echo $options['wpAppbox_curl_timeout']; ?>" />
					<span class="description"><?php _e('Der empfohlene Timeout-Wert beträgt <strong>5</strong> Sekunden. Nur ändern, sofern Apps nicht gefunden werden.', 'wp-appbox'); ?></span>
				</td>
			</tr>
			<!--<tr valign="top">
				<th scope="row"><?php _e('Fehlerausgabe', 'wp-appbox'); ?>:</th>
				<td>
					<input type="checkbox" name="wpAppbox_error_erroroutput" value="1" <?php  if($options['wpAppbox_error_erroroutput']) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Fehlerausgabe aktivieren. Nur sichtbar für Administratoren.', 'wp-appbox'); ?></span>
				</td>
			</tr>-->
			<tr valign="top">
				<th scope="row"><?php _e('Parse Output', 'wp-appbox'); ?>:</th>
				<td>
					<input type="checkbox" name="wpAppbox_error_parseoutput" value="1" <?php  if($options['wpAppbox_error_parseoutput']) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Parse Output aktivieren. Nur sichtbar für Administratoren.', 'wp-appbox'); ?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Cache deaktivieren', 'wp-appbox'); ?>:</th>
				<td>
					<span class="description"><?php _e('Der Cache nur kann temporär deaktiviert werden, indem an die URL eines Artikel "?wpappbox_nocache" angehangen wird. Nur von Usern möglich, die mindestens Autor sind.', 'wp-appbox'); ?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Neue Daten erzwingen', 'wp-appbox'); ?>:</th>
				<td>
					<span class="description"><?php _e('Sofern das erneute Laden von App-Daten (trotz Cache) erzwungen werden soll, dann funktioniert dies, indem an die URL eines Artikels "?wpappbox_reload_cache" angehangen wird. Nur von Usern möglich, die mindestens Autor sind.', 'wp-appbox'); ?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Apple App Store Icons', 'wp-appbox'); ?>:</th>
				<td>
					<input type="checkbox" name="wpAppbox_itunes_secureimage" value="1" <?php  if($options['wpAppbox_itunes_secureimage']) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Kompatibilitätsmodus für App-Icons aus dem (Mac) App Store.', 'wp-appbox'); ?></span>
				</td>
			</tr>
			<?php
		break;
		case 'editor':
			?>
			<tr valign="top">
				<th scope="row" colspan="2"><strong><?php _e('App Stores &amp; Formateinstellungen', 'wp-appbox'); ?></strong><br /><i><?php _e('Welche Buttons sollten im Editor angezeigt werden und welche App-Banner sollen bei Verwendung ohne Formatstag genutzt werden?', 'wp-appbox'); ?></i></th>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Appbox', 'wp-appbox'); ?>:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_appbox" value="1" <?php  if($options['wpAppbox_enabled_appbox']) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Nutze nur einen Button für alle App Stores (alle anderen Buttons werden ausgeblendet)', 'wp-appbox'); ?></span></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Amazon Apps', 'wp-appbox'); ?>:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_amazonapps" value="1" <?php  if($options['wpAppbox_enabled_amazonapps']) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Button im Editor anzeigen', 'wp-appbox'); ?></span></p>
					<select name="wpAppbox_view_amazonapps" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_amazonapps'] == '0') echo 'selected="selected"'; ?>><?php _e('Simple Badge', 'wp-appbox'); ?></option> 
					   <option value="2" <?php if($options['wpAppbox_view_amazonapps'] == '2') echo 'selected="selected"'; ?>><?php _e('Screenshots', 'wp-appbox'); ?></option>
					   <option value="1" <?php if($options['wpAppbox_view_amazonapps'] == '1') echo 'selected="selected"'; ?>><?php _e('Banner Badge', 'wp-appbox'); ?></option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('AndroidPit', 'wp-appbox'); ?> (Android):</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_androidpit" value="1" <?php  if($options['wpAppbox_enabled_androidpit'] == true) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Button im Editor anzeigen', 'wp-appbox'); ?></span></p>
					<select name="wpAppbox_view_androidpit" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_androidpit'] == '0') echo 'selected="selected"'; ?>><?php _e('Simple Badge', 'wp-appbox'); ?></option> 
					   <option value="2" <?php if($options['wpAppbox_view_androidpit'] == '2') echo 'selected="selected"'; ?>><?php _e('Screenshots', 'wp-appbox'); ?></option>
					   <option value="1" <?php if($options['wpAppbox_view_androidpit'] == '1') echo 'selected="selected"'; ?>><?php _e('Banner Badge', 'wp-appbox'); ?></option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('App Store &amp; Mac App Store', 'wp-appbox'); ?>:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_appstore" value="1" <?php  if($options['wpAppbox_enabled_appstore'] == true) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Button im Editor anzeigen', 'wp-appbox'); ?></span></p>
					<select name="wpAppbox_view_appstore" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_appstore'] == '0') echo 'selected="selected"'; ?>><?php _e('Simple Badge', 'wp-appbox'); ?></option> 
					   <option value="2" <?php if($options['wpAppbox_view_appstore'] == '2') echo 'selected="selected"'; ?>><?php _e('Screenshots', 'wp-appbox'); ?></option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Chrome Web Store', 'wp-appbox'); ?> (experimental):</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_chromewebstore" value="1" <?php  if($options['wpAppbox_enabled_chromewebstore'] == true) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Button im Editor anzeigen', 'wp-appbox'); ?></span></p>
					<select name="wpAppbox_view_chromewebstore" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_chromewebstore'] == '0') echo 'selected="selected"'; ?>><?php _e('Simple Badge', 'wp-appbox'); ?></option> 
					   <option value="2" <?php if($options['wpAppbox_view_chromewebstore'] == '2') echo 'selected="selected"'; ?>><?php _e('Screenshots', 'wp-appbox'); ?></option>
					</select> 
				</td>
			</tr>
			<!--<tr valign="top">
				<th scope="row"><?php _e('BlackBerry World', 'wp-appbox'); ?>:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_blackberryworld" value="1" <?php  if($options['wpAppbox_enabled_blackberryworld'] == true) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Button im Editor anzeigen', 'wp-appbox'); ?></span></p>
					<select name="wpAppbox_view_blackberryworld" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_blackberryworld'] == '0') echo 'selected="selected"'; ?>><?php _e('Simple Badge', 'wp-appbox'); ?></option> 
					   <option value="2" <?php if($options['wpAppbox_view_blackberryworld'] == '2') echo 'selected="selected"'; ?>><?php _e('Screenshots', 'wp-appbox'); ?></option>
					</select> 
				</td>
			</tr>-->
			<tr valign="top">
				<th scope="row"><?php _e('Firefox Erweiterungen', 'wp-appbox'); ?>:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_firefoxaddon" value="1" <?php  if($options['wpAppbox_enabled_firefoxaddon'] == true) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Button im Editor anzeigen', 'wp-appbox'); ?></span></p>
					<select name="wpAppbox_view_firefoxaddon" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_firefoxaddon'] == '0') echo 'selected="selected"'; ?>><?php _e('Simple Badge', 'wp-appbox'); ?></option> 
					   <option value="2" <?php if($options['wpAppbox_view_firefoxaddon'] == '2') echo 'selected="selected"'; ?>><?php _e('Screenshots', 'wp-appbox'); ?></option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Firefox Marketplace', 'wp-appbox'); ?>:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_firefoxmarketplace" value="1" <?php  if($options['wpAppbox_enabled_firefoxmarketplace'] == true) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Button im Editor anzeigen', 'wp-appbox'); ?></span></p>
					<select name="wpAppbox_view_firefoxmarketplace" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_firefoxmarketplace'] == '0') echo 'selected="selected"'; ?>><?php _e('Simple Badge', 'wp-appbox'); ?></option> 
					   <option value="2" <?php if($options['wpAppbox_view_firefoxmarketplace'] == '2') echo 'selected="selected"'; ?>><?php _e('Screenshots', 'wp-appbox'); ?></option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Google Play', 'wp-appbox'); ?>:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_googleplay" value="1" <?php  if($options['wpAppbox_enabled_googleplay'] == true) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Button im Editor anzeigen', 'wp-appbox'); ?></span></p>
					<select name="wpAppbox_view_googleplay" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_googleplay'] == '0') echo 'selected="selected"'; ?>><?php _e('Simple Badge', 'wp-appbox'); ?></option> 
					   <option value="2" <?php if($options['wpAppbox_view_googleplay'] == '2') echo 'selected="selected"'; ?>><?php _e('Screenshots', 'wp-appbox'); ?></option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Opera Add-ons', 'wp-appbox'); ?>:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_operaaddons" value="1" <?php  if($options['wpAppbox_enabled_operaaddons'] == true) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Button im Editor anzeigen', 'wp-appbox'); ?></span></p>
					<select name="wpAppbox_view_operaaddons" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_operaaddons'] == '0') echo 'selected="selected"'; ?>><?php _e('Simple Badge', 'wp-appbox'); ?></option> 
					   <option value="2" <?php if($options['wpAppbox_view_operaaddons'] == '2') echo 'selected="selected"'; ?>><?php _e('Screenshots', 'wp-appbox'); ?></option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Samsung Apps', 'wp-appbox'); ?> (Android):</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_samsungapps" value="1" <?php  if($options['wpAppbox_enabled_samsungapps'] == true) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Button im Editor anzeigen', 'wp-appbox'); ?></span></p>
					<select name="wpAppbox_view_samsungapps" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_samsungapps'] == '0') echo 'selected="selected"'; ?>><?php _e('Simple Badge', 'wp-appbox'); ?></option> 
					   <option value="2" <?php if($options['wpAppbox_view_samsungapps'] == '2') echo 'selected="selected"'; ?>><?php _e('Screenshots', 'wp-appbox'); ?></option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Steam', 'wp-appbox'); ?>:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_steam" value="1" <?php  if($options['wpAppbox_enabled_steam'] == true) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Button im Editor anzeigen', 'wp-appbox'); ?></span></p>
					<select name="wpAppbox_view_steam" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_steam'] == '0') echo 'selected="selected"'; ?>><?php _e('Simple Badge', 'wp-appbox'); ?></option> 
					   <option value="2" <?php if($options['wpAppbox_view_steam'] == '2') echo 'selected="selected"'; ?>><?php _e('Screenshots', 'wp-appbox'); ?></option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Windows Store', 'wp-appbox'); ?>:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_windowsstore" value="1" <?php  if($options['wpAppbox_enabled_windowsstore'] == true) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Button im Editor anzeigen', 'wp-appbox'); ?></span></p>
					<select name="wpAppbox_view_windowsstore" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_windowsstore'] == '0') echo 'selected="selected"'; ?>><?php _e('Simple Badge', 'wp-appbox'); ?></option> 
					   <option value="2" <?php if($options['wpAppbox_view_windowsstore'] == '2') echo 'selected="selected"'; ?>><?php _e('Screenshots', 'wp-appbox'); ?></option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Windows Phone Store', 'wp-appbox'); ?>:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_windowsphone" value="1" <?php  if($options['wpAppbox_enabled_windowsphone'] == true) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Button im Editor anzeigen', 'wp-appbox'); ?></span></p>
					<select name="wpAppbox_view_windowsphone" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_windowsphone'] == '0') echo 'selected="selected"'; ?>><?php _e('Simple Badge', 'wp-appbox'); ?></option> 
					   <option value="2" <?php if($options['wpAppbox_view_windowsphone'] == '2') echo 'selected="selected"'; ?>><?php _e('Screenshots', 'wp-appbox'); ?></option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('WordPress Plugin Verzeichnis', 'wp-appbox'); ?>:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_wordpress" value="1" <?php  if($options['wpAppbox_enabled_wordpress'] == true) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Button im Editor anzeigen', 'wp-appbox'); ?></span></p>
					<select name="wpAppbox_view_wordpress" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_wordpress'] == '0') echo 'selected="selected"'; ?>><?php _e('Simple Badge', 'wp-appbox'); ?></option> 
					   <option value="2" <?php if($options['wpAppbox_view_wordpress'] == '1') echo 'selected="selected"'; ?>><?php _e('Banner Badge', 'wp-appbox'); ?></option>
					</select> 
				</td>
			</tr>
			<?php
		break;
		case 'affiliate':
			?>
			<tr valign="top">
				<th scope="row" colspan="2"><strong><?php _e('(Mac) App Store &amp; App Store: TradeDoubler', 'wp-appbox'); ?></strong><br /><i><?php _e('Du hast eine Affiliate-ID bei TradeDoubler? Dann gebe sie hier an und die App-Store-Links werden mit deiner Affiliate-ID versehen. Du hast keinen TradeDoubler-Account?', 'wp-appbox'); ?> <a href="http://clkde.tradedoubler.com/click?p=82&a=1906666&g=19144578" target="_blank"><?php _e('Hier bekommst du einen.', 'wp-appbox'); ?></a>
				<script type="text/javascript">
					var uri = 'http://impde.tradedoubler.com/imp?type(inv)g(19144578)a(1906666)' + new String (Math.random()).substring (2, 11);
					document.write('<img src="'+uri +'">');
				</script></i></th>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('TradeDoubler-ID', 'wp-appbox'); ?>:</th>
				<td>
					<input type="text" name="wpAppbox_affid" value="<?php echo $options['wpAppbox_affid']; ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Nutze die ID des Entwicklers', 'wp-appbox'); ?>:</th>
				<td>
					<input type="checkbox" name="wpAppbox_affid_sponsored" value="1" <?php  if($options['wpAppbox_affid_sponsored'] == true) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Ich habe keine ID bei TradeDoubler und möchte die ID des Entwicklers nutzen. (In diesem Falle: <strong>Danke</strong>!)', 'wp-appbox'); ?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" colspan="2"><strong><?php _e('AndroidPit: Affili.net', 'wp-appbox'); ?></strong><br /><i><?php _e('Du hast eine Affiliate-ID bei Affili.net? Dann gebe sie hier an und die AndroidPit-Links werden mit deiner Affiliate-ID versehen. Du hast keinen Affili.net-Account?', 'wp-appbox'); ?> <a href="http://www.affili.net/" target="_blank"><?php _e('Hier bekommst du einen.', 'wp-appbox'); ?></a></i></th>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Affili.net-ID', 'wp-appbox'); ?>:</th>
				<td>
					<input type="text" name="wpAppbox_affid_affilinet" value="<?php echo $options['wpAppbox_affid_affilinet']; ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Nutze die ID des Entwicklers', 'wp-appbox'); ?>:</th>
				<td>
					<input type="checkbox" name="wpAppbox_affid_affilinet_sponsored" value="1" <?php  if($options['wpAppbox_affid_affilinet_sponsored'] == true) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Ich habe keine ID bei Affili.net und möchte die ID des Entwicklers nutzen. (In diesem Falle: <strong>Danke</strong>!)', 'wp-appbox'); ?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" colspan="2"><strong><?php _e('Amazon Apps: Amazon PartnerNet', 'wp-appbox'); ?></strong><br /><i><?php _e('Du hast eine Affiliate-ID beim Amazon PartnerNet? Dann gebe sie hier an und die Amazon-App-Shop-Links werden mit deiner Affiliate-ID versehen. Du hast keinen Amazon-PartnerNet-Account?', 'wp-appbox'); ?> <a href="https://partnernet.amazon.de/" target="_blank"><?php _e('Hier bekommst du einen.', 'wp-appbox'); ?></a></i></th>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Amazon PartnerNet ID', 'wp-appbox'); ?>:</th>
				<td>
					<input type="text" name="wpAppbox_affid_amazonpartnernet" value="<?php echo $options['wpAppbox_affid_amazonpartnernet']; ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Nutze die ID des Entwicklers', 'wp-appbox'); ?>:</th>
				<td>
					<input type="checkbox" name="wpAppbox_affid_amazonpartnernet_sponsored" value="1" <?php  if($options['wpAppbox_affid_amazonpartnernet_sponsored'] == true) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Ich habe keine ID beim Amazon PartnerNet und möchte die ID des Entwicklers nutzen. (In diesem Falle: <strong>Danke</strong>!)', 'wp-appbox'); ?></span>
				</td>
			</tr>
			<?php
		break;
		case 'cache':
		break;
		case 'help': 
			?>
			<tr valign="top"><th scope="row" colspan="2"><?php _e('Eine kleine Übersicht darüber, wie ihr an die ID einer App gelangt.', 'wp-appbox'); ?></th></tr>
				<?php foreach($store_names as $id => &$name) { ?>
				<tr valign="top">
					<th scope="row"><?php echo $name; ?>:</th>
					<td><img src="<?php echo plugins_url('img/appid/'.$id.'.jpg', dirname(__FILE__)); ?>" alt="<?php echo $name; ?> ID" /></td>
				</tr>
				<?php } ?>
			<?php
		break;
	} //Switch $tab
	?>
	</table> <!-- .form-table -->   
	<p class="submit" style="clear: both;">
	      <input type="submit" name="Submit" class="button-primary" value="<?php _e('Änderungen speichern', 'wp-appbox'); ?>" />
	      <input type="hidden" name="wp-appbox-settings-submit" value="Y" />
	   </p>
	</form>
	</div>
	<?php
?>
<?php } ?>
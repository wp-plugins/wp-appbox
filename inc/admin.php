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
	$settings = array(
		'wpAppbox_piccache' => true,
		'wpAppbox_datacache' => true,
		'wpAppbox_piccchetime' => '300',
		'wpAppbox_datacachetime' => '300',
		'wpAppbox_noqrcode' => false,
		'wpAppbox_affid' => '',
		'wpAppbox_affid_sponsored' => '1',
		'wpAppbox_affid_affilinet' => '',
		'wpAppbox_affid_affilinet_sponsored' => '1',
		'wpAppbox_affid_amazonpartnernet' => '',
		'wpAppbox_affid_amazonpartnernet_sponsored' => '1',
		'wpAppbox_view_appstore' => '0',
		'wpAppbox_view_googleplay' => '0',
		'wpAppbox_view_androidpit' => '0',
		'wpAppbox_view_blackberryworld' => '0',
		'wpAppbox_view_windowsstore' => '0',
		'wpAppbox_view_windowsphone' => '0',
		'wpAppbox_view_chromewebstore' => '0',
		'wpAppbox_view_amazonapps' => '0',
		'wpAppbox_view_firefoxaddon' => '0',
		'wpAppbox_view_samsungapps' => '0',
		'wpAppbox_view_wordpress' => '0',
		'wpAppbox_nofollow' => '0',
		'wpAppbox_blank' => '1',
		'wpAppbox_enabled_appstore' => '1',
		'wpAppbox_enabled_googleplay' => '1',
		'wpAppbox_enabled_windowsstore' => '1',
		'wpAppbox_enabled_windowsphone' => '1',
		'wpAppbox_enabled_androidpit' => '1',
		'wpAppbox_enabled_blackberryworld' => '1',
		'wpAppbox_enabled_appbox' => '0',
		'wpAppbox_enabled_chromewebstore' => '1',
		'wpAppbox_enabled_amazonapps' => '1',
		'wpAppbox_enabled_firefoxaddon' => '1',
		'wpAppbox_enabled_samsungapps' => '1',
		'wpAppbox_enabled_wordpress' => '1',
		'wpAppbox_error_parseoutput' => '0',
		'wpAppbox_add_referrer' => '0',
		'wpAppbox_no_shorten_title' => '0'
	);	
	add_option("wpAppbox", $settings, '', 'yes');
	}	
}

function wpAppbox_createTabs($current = 'general') {
	if(isset($_GET['tab'])) $current = $_GET['tab'];
    $tabs = array(	'general' => __('Allgemeines', 'wp-appbox'),  
    				'editor' => __('Editor & Banner', 'wp-appbox'),  
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
    		$settings['wpAppbox_noqrcode'] = $_POST['wpAppbox_noqrcode'];
    		$settings['wpAppbox_no_shorten_title'] = $_POST['wpAppbox_no_shorten_title'];
    		$settings['wpAppbox_add_referrer'] = $_POST['wpAppbox_add_referrer'];
    		$settings['wpAppbox_error_parseoutput'] = $_POST['wpAppbox_error_parseoutput'];
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
			$settings['wpAppbox_view_wordpress'] = $_POST['wpAppbox_view_wordpress'];
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
	$updated = update_option("wpAppbox", $settings);
}

function wpAppbox_options_page() {
	global $store_names;
	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32">
			<br>
		</div>
		<h2><?php echo WPAPPBOX_PLUGIN_NAME; ?> (Version <?php echo WPAPPBOX_PLUGIN_VERSION; ?>)</h2>
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
		<?php $options = get_option('wpAppbox'); ?>
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
				<th scope="row"><?php _e('QR-Codes ausblenden', 'wp-appbox'); ?>:</th>
				<td>
					<input type="checkbox" name="wpAppbox_noqrcode" value="1" <?php  if($options['wpAppbox_noqrcode']) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Blendet sämtliche QR-Codes in den App-Badges aus. Temporär funktioniert dies auch über das Attribut "noqrcode" im Shortcode.', 'wp-appbox'); ?></span>
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
				<th scope="row"><?php _e('Parse Output', 'wp-appbox'); ?>:</th>
				<td>
					<input type="checkbox" name="wpAppbox_error_parseoutput" value="1" <?php  if($options['wpAppbox_error_parseoutput']) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Parse Output aktivieren', 'wp-appbox'); ?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Cache deaktivieren', 'wp-appbox'); ?>:</th>
				<td>
					<span class="description"><?php _e('Der Cache nur kann temporär deaktiviert werden, indem an die URL eines Artikel "?wpappbox_nocache" angehangen wird.', 'wp-appbox'); ?></span>
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
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_appbox" value="1" <?php  if($options['wpAppbox_enabled_appbox'] == true) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Nutze nur einen Button für alle App Stores (alle anderen Buttons werden ausgeblendet)', 'wp-appbox'); ?></span></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Amazon Apps', 'wp-appbox'); ?>:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_amazonapps" value="1" <?php  if($options['wpAppbox_enabled_amazonapps'] == true) echo 'checked="checked"'; ?> /> <span class="description"><?php _e('Button im Editor anzeigen', 'wp-appbox'); ?></span></p>
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
					   <option value="1" <?php if($options['wpAppbox_view_googleplay'] == '1') echo 'selected="selected"'; ?>><?php _e('Banner Badge', 'wp-appbox'); ?></option>
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
<?php

function wpAppbox_pageInit() {
	$settings_page = add_options_page(WPAPPBOX_PLUGIN_NAME, WPAPPBOX_PLUGIN_NAME, 'manage_options', 'wp-appbox', 'wpAppbox_options_page');
	add_action( "load-{$settings_page}", 'wpAppbox_loadSettingsPage' );
}

function wpAppbox_clear_cache() {
	global $wpdb;
	if(isset($_GET['clearcache'])) {
		if($wpdb->query("DELETE FROM `$wpdb->options` WHERE `option_name` LIKE ('%".WPAPPBOX_CACHE_PREFIX."%')")) echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>Der WP-Appbox-Cache wurde geleert.</strong></p></div>';
		else echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>Der WP-Appbox-Cache konnte nicht geleert werden.</strong></p></div>';
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
		'wpAppbox_affid' => '',
		'wpAppbox_affid_sponsored' => '1',
		'wpAppbox_affid_affilinet' => '',
		'wpAppbox_affid_affilinet_sponsored' => '1',
		'wpAppbox_view_appstore' => '0',
		'wpAppbox_view_googleplay' => '0',
		'wpAppbox_view_androidpit' => '0',
		'wpAppbox_view_blackberryworld' => '0',
		'wpAppbox_view_windowsstore' => '0',
		'wpAppbox_view_windowsphone' => '0',
		'wpAppbox_view_chromewebstore' => '0',
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
		'wpAppbox_error_parseoutput' => '0'
	);	
	add_option("wpAppbox", $settings, '', 'yes');
	}	
}

function wpAppbox_createTabs($current = 'general') {
	if(isset($_GET['tab'])) $current = $_GET['tab'];
    $tabs = array(	'general' => 'Allgemeines',  
    				'editor' => 'Editor & Banner', 
    				'affiliate' => 'Affiliate', 
    				'help' => 'Hilfe');
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
    		$settings['wpAppbox_error_parseoutput'] = $_POST['wpAppbox_error_parseoutput'];
	   	break;
		case 'editor':
			$settings['wpAppbox_enabled_appstore'] = $_POST['wpAppbox_enabled_appstore'];
			$settings['wpAppbox_enabled_googleplay'] = $_POST['wpAppbox_enabled_googleplay'];
			$settings['wpAppbox_enabled_androidpit'] = $_POST['wpAppbox_enabled_androidpit'];
			$settings['wpAppbox_enabled_windowsstore'] = $_POST['wpAppbox_enabled_windowsstore'];
			$settings['wpAppbox_enabled_windowsphone'] = $_POST['wpAppbox_enabled_windowsphone'];
			$settings['wpAppbox_enabled_blackberryworld'] = $_POST['wpAppbox_enabled_blackberryworld'];
			$settings['wpAppbox_enabled_appbox'] = $_POST['wpAppbox_enabled_appbox'];
			$settings['wpAppbox_enabled_chromewebstore'] = $_POST['wpAppbox_enabled_chromewebstore'];
			$settings['wpAppbox_enabled_firefoxmarketplace'] = $_POST['wpAppbox_enabled_firefoxmarketplace'];
			$settings['wpAppbox_view_appstore'] = $_POST['wpAppbox_view_appstore'];
			$settings['wpAppbox_view_googleplay'] = $_POST['wpAppbox_view_googleplay'];
			$settings['wpAppbox_view_androidpit'] = $_POST['wpAppbox_view_androidpit'];
			$settings['wpAppbox_view_windowsstore'] = $_POST['wpAppbox_view_windowsstore'];
			$settings['wpAppbox_view_windowsphone'] = $_POST['wpAppbox_view_windowsphone'];
			$settings['wpAppbox_view_blackberryworld'] = $_POST['wpAppbox_view_blackberryworld'];
			$settings['wpAppbox_view_chromewebstore'] = $_POST['wpAppbox_view_chromewebstore'];
			$settings['wpAppbox_view_firefoxmarketplace'] = $_POST['wpAppbox_view_firefoxmarketplace'];
		break;
		case 'affiliate':
			$settings['wpAppbox_affid'] = Trim($_POST['wpAppbox_affid']);
			$settings['wpAppbox_affid_sponsored'] = $_POST['wpAppbox_affid_sponsored'];
			$settings['wpAppbox_affid_affilinet'] = Trim($_POST['wpAppbox_affid_affilinet']);
			$settings['wpAppbox_affid_affilinet_sponsored'] = $_POST['wpAppbox_affid_affilinet_sponsored'];
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
			<a href="http://www.blogtogo.de/wp-appbox-app-badge-fuer-google-play-mac-app-store-windows-store-windows-phone-store-co/" target="_blank">Besuch die Plugin-Seite</a> | <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SH9AAS276RAS6" target="_blank">Donation</a> | <a href="http://wordpress.org/extend/plugins/wp-appbox/" target="_blank">Plugin im WordPress Directory</a> | <a href="https://twitter.com/Marcelismus" target="_blank">Folge mir via Twitter</a>
			<a href="/wp-admin/options-general.php?page=wp-appbox&clearcache" onClick="return confirm('Soll der Cache wirklich geleert werden? Sämtliche App-Daten müssen dann neu von den Servern der Betreiber geladen werden.')" style="float:right;">Cache leeren</a>
		</p></div>
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
				<th scope="row" colspan="2"><strong>Cache-Einstellungen</strong><br /><i>Die Cachingzeiten geben an, wie oft die Daten aktualisiert vom Server geladen werden - dies erhöht die Performance und sollte eigentlich nicht geändert werden.</i></th>
			</tr>
			<tr valign="top">
				<th scope="row">Caching-Zeit (in Minuten):</th>
				<td>
					<input type="number" pattern="[0-9]*" name="wpAppbox_datacachetime" value="<?php echo $options['wpAppbox_datacachetime']; ?>" />
					<span class="description">Die empfohlene Zeitspanne beträgt <strong>300</strong> Minuten</span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" colspan="2"><strong>Sonstige Einstellungen</strong><br /><i>Sonstiges Gedöns, was keine eigene Kategorie benötigt :D</i></th>
			</tr>
			<tr valign="top">
				<th scope="row">Nofollow:</th>
				<td>
					<input type="checkbox" name="wpAppbox_nofollow" value="1" <?php  if($options['wpAppbox_nofollow'] == true) echo 'checked="checked"'; ?> /> <span class="description">Fügt allen Links das Attribut "<a href="http://de.wikipedia.org/wiki/Nofollow" target="_blank">nofollow</a>" hinzu</span>
				</td>
			</tr>
			<th scope="row">Öffne Links in einem neuen Fenster:</th>
				<td>
					<input type="checkbox" name="wpAppbox_blank" value="1" <?php  if($options['wpAppbox_blank'] == true) echo 'checked="checked"'; ?> /> <span class="description">Öffnet alle App-Links in einem neuen Fenster (target="blank")</span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" colspan="2"><strong>Fehlerausgabe</strong><br /><i>Die Fehlerausgabe sollte nur in Problemfällen eingeschaltet werden. Kann das Design auseinandernehmen.</i></th>
			</tr>
			<tr valign="top">
				<th scope="row">Parse Output:</th>
				<td>
					<input type="checkbox" name="wpAppbox_error_parseoutput" value="1" <?php  if($options['wpAppbox_error_parseoutput'] == true) echo 'checked="checked"'; ?> /> <span class="description">Parse Output aktivieren</span>
				</td>
			</tr>
			<?php
		break;
		case 'editor':
			?>
			<tr valign="top">
				<th scope="row" colspan="2"><strong>App Stores &amp; Formateinstellungen</strong><br /><i>Welche Buttons sollten im Editor angezeigt werden und welche App-Banner sollen bei Verwendung ohne Formatstag genutzt werden?</i></th>
			</tr>
			<tr valign="top">
				<th scope="row">Appbox:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_appbox" value="1" <?php  if($options['wpAppbox_enabled_appbox'] == true) echo 'checked="checked"'; ?> /> <span class="description">Nutze nur einen Button für alle App Stores (alle anderen Buttons werden ausgeblendet)</span></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">App Store &amp; Mac App Store:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_appstore" value="1" <?php  if($options['wpAppbox_enabled_appstore'] == true) echo 'checked="checked"'; ?> /> <span class="description">Button im Editor anzeigen</span></p>
					<select name="wpAppbox_view_appstore" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_appstore'] == '0') echo 'selected="selected"'; ?>>Simple Badge</option> 
					   <option value="2" <?php if($options['wpAppbox_view_appstore'] == '2') echo 'selected="selected"'; ?>>Screenshots</option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Google Play:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_googleplay" value="1" <?php  if($options['wpAppbox_enabled_googleplay'] == true) echo 'checked="checked"'; ?> /> <span class="description">Button im Editor anzeigen</span></p>
					<select name="wpAppbox_view_googleplay" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_googleplay'] == '0') echo 'selected="selected"'; ?>>Simple Badge</option> 
					   <option value="2" <?php if($options['wpAppbox_view_googleplay'] == '2') echo 'selected="selected"'; ?>>Screenshots</option>
					   <option value="1" <?php if($options['wpAppbox_view_googleplay'] == '1') echo 'selected="selected"'; ?>>Banner Badge</option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">AndroidPit:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_androidpit" value="1" <?php  if($options['wpAppbox_enabled_androidpit'] == true) echo 'checked="checked"'; ?> /> <span class="description">Button im Editor anzeigen</span></p>
					<select name="wpAppbox_view_androidpit" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_androidpit'] == '0') echo 'selected="selected"'; ?>>Simple Badge</option> 
					   <option value="2" <?php if($options['wpAppbox_view_androidpit'] == '2') echo 'selected="selected"'; ?>>Screenshots</option>
					   <option value="1" <?php if($options['wpAppbox_view_androidpit'] == '1') echo 'selected="selected"'; ?>>Banner Badge</option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Windows Store:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_windowsstore" value="1" <?php  if($options['wpAppbox_enabled_windowsstore'] == true) echo 'checked="checked"'; ?> /> <span class="description">Button im Editor anzeigen</span></p>
					<select name="wpAppbox_view_windowsstore" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_windowsstore'] == '0') echo 'selected="selected"'; ?>>Simple Badge</option> 
					   <option value="2" <?php if($options['wpAppbox_view_windowsstore'] == '2') echo 'selected="selected"'; ?>>Screenshots</option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Windows Phone Store:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_windowsphone" value="1" <?php  if($options['wpAppbox_enabled_windowsphone'] == true) echo 'checked="checked"'; ?> /> <span class="description">Button im Editor anzeigen</span></p>
					<select name="wpAppbox_view_windowsphone" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_windowsphone'] == '0') echo 'selected="selected"'; ?>>Simple Badge</option> 
					   <option value="2" <?php if($options['wpAppbox_view_windowsphone'] == '2') echo 'selected="selected"'; ?>>Screenshots</option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">BlackBerry World:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_blackberryworld" value="1" <?php  if($options['wpAppbox_enabled_blackberryworld'] == true) echo 'checked="checked"'; ?> /> <span class="description">Button im Editor anzeigen</span></p>
					<select name="wpAppbox_view_blackberryworld" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_blackberryworld'] == '0') echo 'selected="selected"'; ?>>Simple Badge</option> 
					   <option value="2" <?php if($options['wpAppbox_view_blackberryworld'] == '2') echo 'selected="selected"'; ?>>Screenshots</option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Firefox Marketplace:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_firefoxmarketplace" value="1" <?php  if($options['wpAppbox_enabled_firefoxmarketplace'] == true) echo 'checked="checked"'; ?> /> <span class="description">Button im Editor anzeigen</span></p>
					<select name="wpAppbox_view_firefoxmarketplace" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_firefoxmarketplace'] == '0') echo 'selected="selected"'; ?>>Simple Badge</option> 
					   <option value="2" <?php if($options['wpAppbox_view_firefoxmarketplace'] == '2') echo 'selected="selected"'; ?>>Screenshots</option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Chrome Web Store:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox_enabled_chromewebstore" value="1" <?php  if($options['wpAppbox_enabled_chromewebstore'] == true) echo 'checked="checked"'; ?> /> <span class="description">Button im Editor anzeigen</span></p>
					<select name="wpAppbox_view_chromewebstore" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_chromewebstore'] == '0') echo 'selected="selected"'; ?>>Simple Badge</option> 
					   <option value="2" <?php if($options['wpAppbox_view_chromewebstore'] == '2') echo 'selected="selected"'; ?>>Screenshots</option>
					</select> 
				</td>
			</tr>
			<?php
		break;
		case 'affiliate':
			?>
			<tr valign="top">
				<th scope="row" colspan="2"><strong>Mac App Store &amp; App Store: TradeDoubler</strong><br /><i>Du hast eine Affiliate-ID bei TradeDoubler? Dann gebe sie hier an und die App-Store-Links werden mit deiner Affiliate-ID versehen. Du hast keinen TradeDoubler-Account? <a href="http://clkde.tradedoubler.com/click?p=82&a=1906666&g=19144578" target="_blank">Hier bekommst du einen.</a>
				<script type="text/javascript">
					var uri = 'http://impde.tradedoubler.com/imp?type(inv)g(19144578)a(1906666)' + new String (Math.random()).substring (2, 11);
					document.write('<img src="'+uri +'">');
				</script></i></th>
			</tr>
			<tr valign="top">
				<th scope="row">TradeDoubler-ID:</th>
				<td>
					<input type="text" name="wpAppbox_affid" value="<?php echo $options['wpAppbox_affid']; ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Nutze die ID des Entwicklers:</th>
				<td>
					<input type="checkbox" name="wpAppbox_affid_sponsored" value="1" <?php  if($options['wpAppbox_affid_sponsored'] == true) echo 'checked="checked"'; ?> /> <span class="description">Ich habe keine ID bei TradeDoubler und möchte die ID des Entwicklers nutzen. (In diesem Falle: <strong>Danke</strong>!)</span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" colspan="2"><strong>AndroidPit: Affili.net</strong><br /><i>Du hast eine Affiliate-ID bei Affili.net? Dann gebe sie hier an und die AndroidPit-Links werden mit deiner Affiliate-ID versehen. Du hast keinen Affili.net-Account? <a href="http://www.affili.net/" target="_blank">Hier bekommst du einen.</a></i></th>
			</tr>
			<tr valign="top">
				<th scope="row">Affili.net-ID:</th>
				<td>
					<input type="text" name="wpAppbox_affid_affilinet" value="<?php echo $options['wpAppbox_affid_affilinet']; ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Nutze die ID des Entwicklers:</th>
				<td>
					<input type="checkbox" name="wpAppbox_affid_affilinet_sponsored" value="1" <?php  if($options['wpAppbox_affid_affilinet_sponsored'] == true) echo 'checked="checked"'; ?> /> <span class="description">Ich habe keine ID bei Affili.net und möchte die ID des Entwicklers nutzen. (In diesem Falle: <strong>Danke</strong>!)</span>
				</td>
			</tr>
			<?php
		break;
		case 'help': 
			?>
			<tr valign="top"><th scope="row" colspan="2">Eine kleine Übersicht darüber, wie ihr an die ID einer App gelangt.</th></tr>
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
	      <input type="submit" name="Submit" class="button-primary" value="Änderungen speichern" />
	      <input type="hidden" name="wp-appbox-settings-submit" value="Y" />
	   </p>
	</form>
	</div>
	<?php
?>
<?php } ?>
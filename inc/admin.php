<?php

function wpAppbox_create_menu() {
	add_options_page(WPAPPBOX_PLUGIN_NAME, WPAPPBOX_PLUGIN_NAME, 'manage_options', PLUGIN_BASE_DIR, 'wpAppbox_options_page');
}

function wpAppbox_options_validate($input) {
	return $input;
}

function wpAppbox_register_settings() {
	register_setting('wpAppbox_options', 'wpAppbox', 'wpAppbox_options_validate');
}

function wpAppbox_options_page() {
	global $store_names;
?>

<script type="text/javascript">
function setCheckboxen() {
	window.document.options.elements["wpAppbox[wpAppbox_enabled_appstore]"].disabled = window.document.options.elements["wpAppbox[wpAppbox_enabled_appbox]"].checked;
	window.document.options.elements["wpAppbox[wpAppbox_enabled_googleplay]"].disabled = window.document.options.elements["wpAppbox[wpAppbox_enabled_appbox]"].checked;
	window.document.options.elements["wpAppbox[wpAppbox_enabled_androidpit]"].disabled = window.document.options.elements["wpAppbox[wpAppbox_enabled_appbox]"].checked;
	window.document.options.elements["wpAppbox[wpAppbox_enabled_windowsstore]"].disabled = window.document.options.elements["wpAppbox[wpAppbox_enabled_appbox]"].checked;
	window.document.options.elements["wpAppbox[wpAppbox_enabled_windowsphone]"].disabled = window.document.options.elements["wpAppbox[wpAppbox_enabled_appbox]"].checked;
	window.document.options.elements["wpAppbox[wpAppbox_enabled_bbappworld]"].disabled = window.document.options.elements["wpAppbox[wpAppbox_enabled_appbox]"].checked;
}
</script>
<div class="wrap">
	<div id="icon-options-general" class="icon32">
		<br>
	</div>
	<h2><?php echo WPAPPBOX_PLUGIN_NAME; ?> (Version <?php echo WPAPPBOX_PLUGIN_VERSION; ?>)</h2>
	<div class="widget" style="margin:15px 0;"><p style="margin:10px;">
		<a href="http://www.blogtogo.de" target="_blank">Besuch die Plugin-Seite</a> | <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SH9AAS276RAS6" target="_blank">Donation</a> | <a href="#" target="_blank">Plugin im WordPress Directory</a> | <a href="https://twitter.com/Marcelismus" target="_blank">Folge mir via Twitter</a>
	</p></div>
	<form name="options" method="post" action="options.php">
	<?php settings_fields('wpAppbox_options'); ?>
	<?php $options = get_option('wpAppbox'); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row" colspan="2"><strong>Cache-Einstellungen</strong><br /><i>Die Cachingzeiten geben an, wie oft die Daten aktualisiert vom Server geladen werden - dies erhöht die Performance und sollte eigentlich nicht geändert werden.</i></th>
			</tr>
			<tr valign="top">
				<th scope="row">Daten-Caching (in Minuten):</th>
				<td>
					<input type="number" pattern="[0-9]" name="wpAppbox[wpAppbox_datacachetime]" value="<?php echo $options['wpAppbox_datacachetime']; ?>" />
					<span class="description">Die empfohlene Zeitspanne liegt bei <strong>60</strong> Minuten</span>
				</td>
			</tr>
			<!--
			<tr valign="top">
				<th scope="row">Bilder-Caching (in Minuten):</th>
				<td>
					<input type="number" pattern="[0-9]" name="wpAppbox[wpAppbox_piccachetime]" value="<?php echo $options['wpAppbox_piccachetime']; ?>" />
				</td>
			</tr>
			-->
			<tr valign="top">
				<th scope="row" colspan="2"><strong>App Stores &amp; Format-Einstellungen</strong><br /><i>Welche App Stores sollen aktiviert werden und welche Ansichten sollen standardmäßig bei Verwendung ohne Formatstag angezeigt werden?</i></th>
			</tr>
			<tr valign="top">
				<th scope="row">Appbox:</th>
				<td>
					<p style="margin-bottom: 4px;"><input onClick="setCheckboxen()" type="checkbox" name="wpAppbox[wpAppbox_enabled_appbox]" value="1" <?php  if($options['wpAppbox_enabled_appbox'] == true) echo 'checked="checked"'; ?> /> <span class="description">Nutze nur einen einzigen Button mit allen App Stores im Editor (alle anderen werden ausgeblendet)</span></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">App Store &amp; Mac App Store:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox[wpAppbox_enabled_appstore]" value="1" <?php  if($options['wpAppbox_enabled_appstore'] == true) echo 'checked="checked"'; ?> <?php  if($options['wpAppbox_enabled_appbox'] == true) echo 'disabled="disabled"'; ?> /> <span class="description">Button anzeigen</span></p>
					<select name="wpAppbox[wpAppbox_view_appstore]" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_appstore'] == '0') echo 'selected="selected"'; ?>>Simple Badge</option> 
					   <option value="2" <?php if($options['wpAppbox_view_appstore'] == '2') echo 'selected="selected"'; ?>>Screenshots</option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Google Play:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox[wpAppbox_enabled_googleplay]" value="1" <?php  if($options['wpAppbox_enabled_googleplay'] == true) echo 'checked="checked"'; ?> <?php  if($options['wpAppbox_enabled_appbox'] == true) echo 'disabled="disabled"'; ?> /> <span class="description">Button anzeigen</span></p>
					<select name="wpAppbox[wpAppbox_view_googleplay]" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_googleplay'] == '0') echo 'selected="selected"'; ?>>Simple Badge</option> 
					   <option value="2" <?php if($options['wpAppbox_view_googleplay'] == '2') echo 'selected="selected"'; ?>>Screenshots</option>
					   <option value="1" <?php if($options['wpAppbox_view_googleplay'] == '1') echo 'selected="selected"'; ?>>Banner Badge</option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">AndroidPit:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox[wpAppbox_enabled_androidpit]" value="1" <?php  if($options['wpAppbox_enabled_androidpit'] == true) echo 'checked="checked"'; ?> <?php  if($options['wpAppbox_enabled_appbox'] == true) echo 'disabled="disabled"'; ?> /> <span class="description">Button anzeigen</span></p>
					<select name="wpAppbox[wpAppbox_view_androidpit]" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_androidpit'] == '0') echo 'selected="selected"'; ?>>Simple Badge</option> 
					   <option value="2" <?php if($options['wpAppbox_view_androidpit'] == '2') echo 'selected="selected"'; ?>>Screenshots</option>
					   <option value="1" <?php if($options['wpAppbox_view_androidpit'] == '1') echo 'selected="selected"'; ?>>Banner Badge</option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Windows Store:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox[wpAppbox_enabled_windowsstore]" value="1" <?php  if($options['wpAppbox_enabled_windowsstore'] == true) echo 'checked="checked"'; ?> <?php  if($options['wpAppbox_enabled_appbox'] == true) echo 'disabled="disabled"'; ?> /> <span class="description">Button anzeigen</span></p>
					<select name="wpAppbox[wpAppbox_view_windowsstore]" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_windowsstore'] == '0') echo 'selected="selected"'; ?>>Simple Badge</option> 
					   <option value="2" <?php if($options['wpAppbox_view_windowsstore'] == '2') echo 'selected="selected"'; ?>>Screenshots</option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Windows Phone Store:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox[wpAppbox_enabled_windowsphone]" value="1" <?php  if($options['wpAppbox_enabled_windowsphone'] == true) echo 'checked="checked"'; ?> <?php  if($options['wpAppbox_enabled_appbox'] == true) echo 'disabled="disabled"'; ?> /> <span class="description">Button anzeigen</span></p>
					<select name="wpAppbox[wpAppbox_view_windowsphone]" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_windowsphone'] == '0') echo 'selected="selected"'; ?>>Simple Badge</option> 
					   <option value="2" <?php if($options['wpAppbox_view_windowsphone'] == '2') echo 'selected="selected"'; ?>>Screenshots</option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">BlackBerry AppWorld:</th>
				<td>
					<p style="margin-bottom: 4px;"><input type="checkbox" name="wpAppbox[wpAppbox_enabled_bbappworld]" value="1" <?php  if($options['wpAppbox_enabled_bbappworld'] == true) echo 'checked="checked"'; ?> <?php  if($options['wpAppbox_enabled_appbox'] == true) echo 'disabled="disabled"'; ?> /> <span class="description">Button anzeigen</span></p>
					<select name="wpAppbox[wpAppbox_view_bbappworld]" style="width:200px"> 
					   <option value="0" <?php if($options['wpAppbox_view_bbappworld'] == '0') echo 'selected="selected"'; ?>>Simple Badge</option> 
					   <option value="2" <?php if($options['wpAppbox_view_bbappworld'] == '2') echo 'selected="selected"'; ?>>Screenshots</option>
					</select> 
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" colspan="2"><strong>Affiliate-ID</strong><br /><i>Du hast eine Affiliate-ID bei TradeDoubler? Dann gebe sie hier an und deine App-Store-Links werden mit Deinem Partnerlink versehen.</i></th>
			</tr>
			<tr valign="top">
				<th scope="row">TradeDoubler-ID:</th>
				<td>
					<input type="text" name="wpAppbox[wpAppbox_affid]" value="<?php echo $options['wpAppbox_affid']; ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">ID des Entwicklers nutzen:</th>
				<td>
					<input type="checkbox" name="wpAppbox[wpAppbox_affid_sponsored]" value="1" <?php  if($options['wpAppbox_affid_sponsored'] == true) echo 'checked="checked"'; ?> /> <span class="description">Ich habe keine eigene Affiliate-ID bei TradeDoubler und möchte die ID des Entwicklers nutzen. (In diesem Falle: <strong>Danke!</strong>)</span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" colspan="2"><strong>Sonstige Einstellungen</strong><br /><i>Sonstiges Gedöns, was keine eigene Kategorie braucht. :-D</i></th>
			</tr>
			<tr valign="top">
				<th scope="row">Nofollow:</th>
				<td>
					<input type="checkbox" name="wpAppbox[wpAppbox_nofollow]" value="1" <?php  if($options['wpAppbox_nofollow'] == true) echo 'checked="checked"'; ?> /> <span class="description">Fügt den Links das Attribut "<a href="http://de.wikipedia.org/wiki/Nofollow" target="_blank">nofollow</a>" hinzu</span>
				</td>
			</tr>
			<th scope="row">Links in neuem Fenster öffnen:</th>
				<td>
					<input type="checkbox" name="wpAppbox[wpAppbox_blank]" value="1" <?php  if($options['wpAppbox_blank'] == true) echo 'checked="checked"'; ?> /> <span class="description">Öffnet die Links der Apps in einem neuen Fenster (target="_blank")</span>
				</td>
			</tr>
		</table>
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
	<br />
	<div id="icon-options-general" class="icon32">
		<br>
	</div>
	<h2>Hilfe</h2>
	<p>Kleine Übersicht darüber, wie ihr an die App-IDs der entsprechenen Stores kommt:</p>
	<table class="form-table">
		<?php foreach($store_names as $id => &$name) { ?>
		<tr valign="top">
			<th scope="row"><?php echo $name; ?>:</th>
			<td><img src="<?php echo plugins_url('img/appid/'.$id.'.png', dirname(__FILE__)); ?>" alt="<?php echo $name; ?> ID" /></td>
		</tr>
		<?php } ?>
	</table>
</div>
<?php } ?>
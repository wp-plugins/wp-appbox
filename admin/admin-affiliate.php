<script>
	function show_hide_apple_affiliate() {
		var status = document.getElementById("wpAppbox_affiliate_apple_service").selectedIndex;
		var sponsored_td = document.getElementById("wpAppbox_affid_sponsored_tr");
		var desc_n = document.getElementById("wpAppbox_affiliate_apple_desc_n");
		if(status == "0") { 
			sponsored_td.style.display = "";
			desc_n.innerHTML = "<?php _e('TradeDoubler-ID', 'wp-appbox'); ?>";
		}
		else { 
			sponsored_td.style.display = "none";
			desc_n.innerHTML = "<?php _e('PHG-ID', 'wp-appbox'); ?>";
		}
	}
</script>


<h3><?php _e('(Mac) App Store &amp; App Store: TradeDoubler und PHG', 'wp-appbox'); ?></h3>
<p><?php _e('Du hast eine Affiliate-ID bei TradeDoubler oder PHG? Dann gebe sie hier an und die App-Store-Links werden mit deiner Affiliate-ID versehen. Du hast keinen TradeDoubler-Account?', 'wp-appbox'); ?> <a href="http://clkde.tradedoubler.com/click?p=82&a=1906666&g=19144578" target="_blank"><?php _e('Hier bekommst du einen.', 'wp-appbox'); ?></a>
<script type="text/javascript">
	var uri = 'http://impde.tradedoubler.com/imp?type(inv)g(19144578)a(1906666)' + new String (Math.random()).substring (2, 11);
	document.write('<img src="'+uri +'">');
</script></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affiliate_apple_service"><?php _e('Apple Affiliate', 'wp-appbox'); ?>:</label></th>
		<td>	
			<select name="wpAppbox_affiliate_apple_service" id="wpAppbox_affiliate_apple_service" class="postform" style="min-width:250px;" onchange="javascript:show_hide_apple_affiliate()">
			   <option class="level-0" value="tradedoubler" <?php if($options['wpAppbox_affiliate_apple_service'] == 'tradedoubler') echo 'selected="selected"'; ?>><?php _e('TradeDoubler (TD) - Nur für Europa und Südamerika.', 'wp-appbox'); ?></option> 
			   <option class="level-0" value="phg" <?php if($options['wpAppbox_affiliate_apple_service'] == 'phg') echo 'selected="selected"'; ?>><?php _e('Performance Horizon Group (PHG) - Nicht für Europa und Südamerika.', 'wp-appbox'); ?></option>
			</select>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affid"><span id="wpAppbox_affiliate_apple_desc_n"><?php echo ($options['wpAppbox_affiliate_apple_service'] == 'tradedoubler') ? 'TradeDoubler-ID' : 'PHG-ID'; ?></span>:</label></th>
		<td>	
			<input type="text" name="wpAppbox_affid" id="wpAppbox_affid" value="<?php echo $options['wpAppbox_affid']; ?>" />
		</td>
	</tr>
	<tr valign="top" id="wpAppbox_affid_sponsored_tr" <?php echo ($options['wpAppbox_affiliate_apple_service'] == 'tradedoubler') ? '' : 'style="display:none;"'; ?>>
		<th scope="row"><label for="wpAppbox_affid_sponsored"><?php _e('Nutze die ID des Entwicklers', 'wp-appbox'); ?>:</label></th>
		<td>	
			<input type="checkbox" name="wpAppbox_affid_sponsored" id="wpAppbox_affid_sponsored" value="1" <?php if($options['wpAppbox_affid_sponsored'] == true) echo 'checked="checked"'; ?> /> <?php _e('Ich habe keine ID bei TradeDoubler und möchte die ID des Entwicklers nutzen. (In diesem Falle: <strong>Danke</strong>!)', 'wp-appbox'); ?>
		</td>
	</tr>
</table>

<h3><?php _e('AndroidPit: Affili.net', 'wp-appbox'); ?></h3>
<p><?php _e('Du hast eine Affiliate-ID bei Affili.net? Dann gebe sie hier an und die AndroidPit-Links werden mit deiner Affiliate-ID versehen. Du hast keinen Affili.net-Account?', 'wp-appbox'); ?> <a href="http://www.affili.net/" target="_blank"><?php _e('Hier bekommst du einen.', 'wp-appbox'); ?></a></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affid_affilinet"><?php _e('Affili.net-ID', 'wp-appbox'); ?>:</label></th>
		<td>
			<input type="text" name="wpAppbox_affid_affilinet" id="wpAppbox_affid_affilinet" value="<?php echo $options['wpAppbox_affid_affilinet']; ?>" />
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affid_affilinet_sponsored"><?php _e('Nutze die ID des Entwicklers', 'wp-appbox'); ?>:</label></th>
		<td>	
			<input type="checkbox" name="wpAppbox_affid_affilinet_sponsored" id="wpAppbox_affid_affilinet_sponsored" value="1" <?php if($options['wpAppbox_affid_affilinet_sponsored'] == true) echo 'checked="checked"'; ?> /> <?php _e('Ich habe keine ID bei Affili.net und möchte die ID des Entwicklers nutzen. (In diesem Falle: <strong>Danke</strong>!)', 'wp-appbox'); ?>
		</td>
	</tr>
</table>

<h3><?php _e('Amazon Apps: Amazon PartnerNet', 'wp-appbox'); ?></h3>
<p><?php _e('Du hast eine Affiliate-ID beim Amazon PartnerNet? Dann gebe sie hier an und die Amazon-App-Shop-Links werden mit deiner Affiliate-ID versehen. Du hast keinen Amazon-PartnerNet-Account?', 'wp-appbox'); ?> <a href="https://partnernet.amazon.de/" target="_blank"><?php _e('Hier bekommst du einen.', 'wp-appbox'); ?></a></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affid_amazonpartnernet"><?php _e('Amazon PartnerNet ID', 'wp-appbox'); ?>:</label></th>
		<td>	
			<input type="text" name="wpAppbox_affid_amazonpartnernet" id="wpAppbox_affid_amazonpartnernet" value="<?php echo $options['wpAppbox_affid_amazonpartnernet']; ?>" />
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affid_amazonpartnernet_sponsored"><?php _e('Nutze die ID des Entwicklers', 'wp-appbox'); ?>:</label></th>
		<td>	
			<input type="checkbox" name="wpAppbox_affid_amazonpartnernet_sponsored" id="wpAppbox_affid_amazonpartnernet_sponsored" value="1" <?php  if($options['wpAppbox_affid_amazonpartnernet_sponsored'] == true) echo 'checked="checked"'; ?> /> <?php _e('Ich habe keine ID beim Amazon PartnerNet und möchte die ID des Entwicklers nutzen. (In diesem Falle: <strong>Danke</strong>!)', 'wp-appbox'); ?>
		</td>
	</tr>
</table>

<h3><?php _e('Benutzerdefinitierte Affiliate-IDs', 'wp-appbox'); ?></h3>
<p><?php _e('Jeder Benutzer und Autor kann seine eigenen Affiliate-IDs nutzen, sofern unter seinem Namen ein Artikel veröffentlicht wird. Wird keine ID im Benutzerprofil angegeben, so werden die globalen IDs verwendet.', 'wp-appbox'); ?></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_user_affiliateids"><?php _e('Benutzer-IDs aktivieren', 'wp-appbox'); ?>:</label></th>
		<td>	
			<input type="checkbox" name="wpAppbox_user_affiliateids" id="wpAppbox_user_affiliateids" value="1" <?php if($options['wpAppbox_user_affiliateids']) echo 'checked="checked"'; ?> /> <?php _e('Aktiviert die Möglichkeit, benutzerspezifische IDs zu nutzen.', 'wp-appbox'); ?>
		</td>
	</tr>
</table>
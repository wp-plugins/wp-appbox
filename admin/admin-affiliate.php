<h3><?php _e('(Mac) App Store &amp; App Store: TradeDoubler', 'wp-appbox'); ?></h3>
<p><?php _e('Du hast eine Affiliate-ID bei TradeDoubler? Dann gebe sie hier an und die App-Store-Links werden mit deiner Affiliate-ID versehen. Du hast keinen TradeDoubler-Account?', 'wp-appbox'); ?> <a href="http://clkde.tradedoubler.com/click?p=82&a=1906666&g=19144578" target="_blank"><?php _e('Hier bekommst du einen.', 'wp-appbox'); ?></a>
<script type="text/javascript">
	var uri = 'http://impde.tradedoubler.com/imp?type(inv)g(19144578)a(1906666)' + new String (Math.random()).substring (2, 11);
	document.write('<img src="'+uri +'">');
</script></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affid"><?php _e('TradeDoubler-ID', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_affid">
				<input type="text" name="wpAppbox_affid" value="<?php echo $options['wpAppbox_affid']; ?>" />
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affid_sponsored"><?php _e('Nutze die ID des Entwicklers', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_affid_sponsored">
				<input type="checkbox" name="wpAppbox_affid_sponsored" value="1" <?php  if($options['wpAppbox_affid_sponsored'] == true) echo 'checked="checked"'; ?> />
				<?php _e('Ich habe keine ID bei TradeDoubler und möchte die ID des Entwicklers nutzen. (In diesem Falle: <strong>Danke</strong>!)', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
</table>

<h3><?php _e('AndroidPit: Affili.net', 'wp-appbox'); ?></h3>
<p><?php _e('Du hast eine Affiliate-ID bei Affili.net? Dann gebe sie hier an und die AndroidPit-Links werden mit deiner Affiliate-ID versehen. Du hast keinen Affili.net-Account?', 'wp-appbox'); ?> <a href="http://www.affili.net/" target="_blank"><?php _e('Hier bekommst du einen.', 'wp-appbox'); ?></a></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affid_affilinet"><?php _e('Affili.net-ID', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_affid_affilinet">
				<input type="text" name="wpAppbox_affid_affilinet" value="<?php echo $options['wpAppbox_affid_affilinet']; ?>" />
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affid_affilinet_sponsored"><?php _e('Nutze die ID des Entwicklers', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_affid_affilinet_sponsored">
				<input type="checkbox" name="wpAppbox_affid_affilinet_sponsored" value="1" <?php  if($options['wpAppbox_affid_affilinet_sponsored'] == true) echo 'checked="checked"'; ?> />
				<?php _e('Ich habe keine ID bei Affili.net und möchte die ID des Entwicklers nutzen. (In diesem Falle: <strong>Danke</strong>!)', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
</table>

<h3><?php _e('Amazon Apps: Amazon PartnerNet', 'wp-appbox'); ?></h3>
<p><?php _e('Du hast eine Affiliate-ID beim Amazon PartnerNet? Dann gebe sie hier an und die Amazon-App-Shop-Links werden mit deiner Affiliate-ID versehen. Du hast keinen Amazon-PartnerNet-Account?', 'wp-appbox'); ?> <a href="https://partnernet.amazon.de/" target="_blank"><?php _e('Hier bekommst du einen.', 'wp-appbox'); ?></a></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affid_amazonpartnernet"><?php _e('Amazon PartnerNet ID', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_affid_amazonpartnernet">
				<input type="text" name="wpAppbox_affid_amazonpartnernet" value="<?php echo $options['wpAppbox_affid_amazonpartnernet']; ?>" />
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affid_amazonpartnernet_sponsored"><?php _e('Nutze die ID des Entwicklers', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_affid_amazonpartnernet_sponsored">
				<input type="checkbox" name="wpAppbox_affid_amazonpartnernet_sponsored" value="1" <?php  if($options['wpAppbox_affid_amazonpartnernet_sponsored'] == true) echo 'checked="checked"'; ?> />
				<?php _e('Ich habe keine ID beim Amazon PartnerNet und möchte die ID des Entwicklers nutzen. (In diesem Falle: <strong>Danke</strong>!)', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
</table>
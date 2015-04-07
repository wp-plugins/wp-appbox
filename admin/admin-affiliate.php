<h3><?php _e('(Mac) App Store &amp; App Store: PHG', 'wp-appbox'); ?></h3>
<p><?php _e('Have an affiliate ID at PHG? If so, enter it here and your app store links will be provided with your affiliate ID attached. No PHG account?', 'wp-appbox'); ?> <a href="http://affiliate.itunes.apple.com/de/apply" target="_blank"><?php _e('Here you can get one.', 'wp-appbox'); ?></a></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affid"><?php _e('Affiliate Token', 'wp-appbox'); ?>:</label></th>
		<td>
			<input type="text" name="wpAppbox_affid" id="wpAppbox_affid" value="<?php echo $options['wpAppbox_affid']; ?>" />
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affid_sponsored"><?php _e('Use the ID of the developer', 'wp-appbox'); ?>:</label></th>
		<td>	
			<input type="checkbox" name="wpAppbox_affid_sponsored" id="wpAppbox_affid_sponsored" value="1" <?php if($options['wpAppbox_affid_sponsored'] == true) echo 'checked="checked"'; ?> /> <?php _e('I have no ID at Apple/PHG and would like to use the developer-ID. (In this case: <strong>Thanks!</strong>)', 'wp-appbox'); ?>
		</td>
	</tr>
</table>

<h3><?php _e('Amazon Apps: Amazon PartnerNet', 'wp-appbox'); ?></h3>
<p><?php _e('Have an affiliate ID at Amazon PartnerNet? If so, enter it here and your app store links will be provided with your affiliate ID attached. No Amazon PartnerNet account?', 'wp-appbox'); ?> <a href="https://partnernet.amazon.de/" target="_blank"><?php _e('Here you can get one.', 'wp-appbox'); ?></a></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affid_amazonpartnernet"><?php _e('Amazon PartnerNet ID', 'wp-appbox'); ?>:</label></th>
		<td>	
			<input type="text" name="wpAppbox_affid_amazonpartnernet" id="wpAppbox_affid_amazonpartnernet" value="<?php echo $options['wpAppbox_affid_amazonpartnernet']; ?>" />
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affid_amazonpartnernet_sponsored"><?php _e('Use the ID of the developer', 'wp-appbox'); ?>:</label></th>
		<td>	
			<input type="checkbox" name="wpAppbox_affid_amazonpartnernet_sponsored" id="wpAppbox_affid_amazonpartnernet_sponsored" value="1" <?php  if($options['wpAppbox_affid_amazonpartnernet_sponsored'] == true) echo 'checked="checked"'; ?> /> <?php _e('I have no affiliate ID at Amazon PartnerNet and want to use the ID of the developer. (In this case: <strong>Thank you</strong>!)', 'wp-appbox'); ?>
		</td>
	</tr>
</table>

<h3><?php _e('Custon affiliate IDs', 'wp-appbox'); ?></h3>
<p><?php _e('Each user and author can use his own affiliate IDs provided under his name an article is published. If no ID is specified in the user profile, the global IDs are used.', 'wp-appbox'); ?></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_user_affiliateids"><?php _e('Activate custom ID', 'wp-appbox'); ?>:</label></th>
		<td>	
			<input type="checkbox" name="wpAppbox_user_affiliateids" id="wpAppbox_user_affiliateids" value="1" <?php if($options['wpAppbox_user_affiliateids']) echo 'checked="checked"'; ?> /> <?php _e('Activates the possibility to use custom affiliate IDs for each user', 'wp-appbox'); ?>
		</td>
	</tr>
</table>
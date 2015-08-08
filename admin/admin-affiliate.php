<h3><?php _e('(Mac) App Store &amp; App Store: PHG', 'wp-appbox'); ?></h3>
<p><?php _e('Have an affiliate ID at PHG? If so, enter it here and your app store links will be provided with your affiliate ID attached. No PHG account?', 'wp-appbox'); ?> <a href="http://affiliate.itunes.apple.com/de/apply" target="_blank"><?php _e('Here you can get one.', 'wp-appbox'); ?></a></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affiliateApple"><?php _e('Affiliate Token', 'wp-appbox'); ?>:</label></th>
		<td>
			<input type="text" name="wpAppbox_affiliateApple" id="wpAppbox_affiliateApple" value="<?php echo(get_option('wpAppbox_affiliateApple')); ?>" />
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affiliateAppleDev"><?php _e('Use the ID of the developer', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_affiliateAppleDev"><input type="checkbox" name="wpAppbox_affiliateAppleDev" id="wpAppbox_affiliateAppleDev" value="1" <?php checked(get_option('wpAppbox_affiliateAppleDev')); ?>/> <?php _e('I have no ID at Apple/PHG and would like to use the developer-ID. (In this case: <strong>Thanks!</strong>)', 'wp-appbox'); ?></label>
		</td>
	</tr>
</table>

<h3><?php _e('Amazon Apps: Amazon PartnerNet', 'wp-appbox'); ?></h3>
<p><?php _e('Have an affiliate ID at Amazon PartnerNet? If so, enter it here and your app store links will be provided with your affiliate ID attached. No Amazon PartnerNet account?', 'wp-appbox'); ?> <a href="https://partnernet.amazon.de/" target="_blank"><?php _e('Here you can get one.', 'wp-appbox'); ?></a></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affiliateAmazon"><?php _e('Amazon PartnerNet ID', 'wp-appbox'); ?>:</label></th>
		<td>	
			<input type="text" name="wpAppbox_affiliateAmazon" id="wpAppbox_affiliateAmazon" value="<?php echo(get_option('wpAppbox_affiliateAmazon')); ?>" />
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affiliateAmazonDev"><?php _e('Use the ID of the developer', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_affiliateAmazonDev"><input type="checkbox" name="wpAppbox_affiliateAmazonDev" id="wpAppbox_affiliateAmazonDev" value="1" <?php checked(get_option('wpAppbox_affiliateAmazonDev')); ?>/> <?php _e('I have no affiliate ID at Amazon PartnerNet and want to use the ID of the developer. (In this case: <strong>Thank you</strong>!)', 'wp-appbox'); ?></label>
		</td>
	</tr>
</table>

<h3><?php _e('Custon affiliate IDs', 'wp-appbox'); ?></h3>
<p><?php _e('Each user and author can use his own affiliate IDs provided under his name an article is published. If no ID is specified in the user profile, the global IDs are used.', 'wp-appbox'); ?></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_userAffiliate"><?php _e('Activate custom ID', 'wp-appbox'); ?>:</label></th>
		<td>	
			<input type="checkbox" name="wpAppbox_userAffiliate" id="wpAppbox_userAffiliate" value="1" <?php checked(get_option('wpAppbox_userAffiliate')); ?><?php _e('Activates the possibility to use custom affiliate IDs for each user', 'wp-appbox'); ?>
		</td>
	</tr>
</table>
<?php function wpAppbox_add_custom_affiliate_id($user) { ?>
		<?php  
			if(get_option('wpAppbox_userAffiliate')) {
				$userID = $user->ID;
				if(!current_user_can('edit_user', $userID)) return(false);
				?>
		<h3><?php _e('WP-Appbox: Affiliate-IDs', 'wpappbox'); ?></h3>
		<script>
			function show_hide_options(affid) {
				var status = document.getElementById("wpAppbox_user_<?php echo($userID); ?>_ownAffiliate"+affid).checked;
				var table = document.getElementById("wpAppbox_user_<?php echo($userID); ?>_affiliate"+affid);
				if(status == true) { table.style.display = ""; }
				else { table.style.display = "none"; }
			}
		</script>
		<table class="form-table">
			<tr>
				<th>
					<label for="wpAppbox_user_<?php echo($userID); ?>_Apple"><?php _e('Apple/PHG Token', 'wpappbox'); ?>:</label>
				</th>
				<td>
					<p><label for="wpAppbox_user_<?php echo($userID); ?>_ownAffiliateApple"><input onClick="javascript:show_hide_options('Apple')" type="checkbox" name="wpAppbox_user_<?php echo($userID); ?>_ownAffiliateApple" id="wpAppbox_user_<?php echo($userID); ?>_ownAffiliateApple" value="1" <?php checked(get_option('wpAppbox_user_'.$userID.'_ownAffiliateApple')); ?>/> <?php _e('Use a different affiliate ID as in the global settings.', 'wp-appbox'); ?></label></p>
					<div id="wpAppbox_user_<?php echo($userID); ?>_affiliateApple" <?php if(get_option('wpAppbox_user_'.$userID.'_ownAffiliateApple') != true) echo 'style="display:none;"'; ?>>
						<p style="margin-left: 24px;"><input type="text" name="wpAppbox_user_<?php echo($userID); ?>_affiliateApple" id="wpAppbox_user_<?php echo($userID); ?>_affiliateApple" value="<?php echo(get_option('wpAppbox_user_'.$userID.'_affiliateApple')); ?>" class="regular-text" style="width: 200px;" /> <span class="description"><?php _e('Your affiliate ID at PHG. If no ID is specified, the default ID is used.', 'wpappbox'); ?></span></p>
						<p style="margin-left: 24px;"><label for="wpAppbox_user_<?php echo($userID); ?>_affiliateAppleDev"><input type="checkbox" name="wpAppbox_user_<?php echo($userID); ?>_affiliateAppleDev" id="wpAppbox_user_<?php echo($userID); ?>_affiliateAppleDev" value="1" <?php checked(get_option('wpAppbox_user_'.$userID.'_affiliateAppleDev')); ?> /> <?php _e('I have no ID at Apple/PHG and would like to use the developer-ID. (In this case: <strong>Thanks!</strong>)', 'wp-appbox'); ?></label></p>
					</div>
				</td>
			</tr>
			<tr>
				<th>
					<label for="wpAppbox_user_<?php echo($userID); ?>_Amazon"><?php _e('Amazon PartnerNet ID', 'wpappbox'); ?>:</label>
				</th>
				<td>
					<p><label for="wpAppbox_user_<?php echo($userID); ?>_ownAffiliateAmazon"><input onClick="javascript:show_hide_options('Amazon')" type="checkbox" name="wpAppbox_user_<?php echo($userID); ?>_ownAffiliateAmazon" id="wpAppbox_user_<?php echo($userID); ?>_ownAffiliateAmazon" value="1" <?php checked(get_option('wpAppbox_user_'.$userID.'_ownAffiliateAmazon')); ?> /> <?php _e('Use a different affiliate ID as in the global settings.', 'wp-appbox'); ?></label></p>
					<div id="wpAppbox_user_<?php echo($userID); ?>_affiliateAmazon" <?php if(get_option('wpAppbox_user_'.$userID.'_ownAffiliateAmazon') != true) echo 'style="display:none;"'; ?>>
						<p style="margin-left: 24px;"><input type="text" name="wpAppbox_user_<?php echo($userID); ?>_affiliateAmazon" id="wpAppbox_user_<?php echo($userID); ?>_affiliateAmazon" value="<?php echo(get_option('wpAppbox_user_'.$userID.'_affiliateAmazon')); ?>" class="regular-text" style="width: 200px;" /> <span class="description"><?php _e('Your affiliate ID at Amazon PartnerNet. If no ID is specified, the default ID is used.', 'wpappbox'); ?></span></p>
						<p style="margin-left: 24px;"><label for="wpAppbox_user_<?php echo($userID); ?>_affiliateAmazonDev"><input type="checkbox" name="wpAppbox_user_<?php echo($userID); ?>_affiliateAmazonDev" id="wpAppbox_user_<?php echo($userID); ?>_affiliateAmazonDev" value="1" <?php checked(get_option('wpAppbox_user_'.$userID.'_affiliateAmazonDev')); ?> /> <?php _e('I have no affiliate ID at Amazon PartnerNet and want to use the ID of the developer. (In this case: <strong>Thank you</strong>!)', 'wp-appbox'); ?></label></p>
					</div>
				</td>
			</tr>
		</table>
<?php }
}

function wpAppbox_save_custom_affiliate_id($userID) {
	if(!current_user_can('edit_user', $userID)) return(false);
	update_option('wpAppbox_user_'.$userID.'_ownAffiliateApple', $_POST['wpAppbox_user_'.$userID.'_ownAffiliateApple']);
	update_option('wpAppbox_user_'.$userID.'_affiliateApple', Trim($_POST['wpAppbox_user_'.$userID.'_affiliateApple']));
	update_option('wpAppbox_user_'.$userID.'_affiliateAppleDev', $_POST['wpAppbox_user_'.$userID.'_affiliateAppleDev']);
	update_option('wpAppbox_user_'.$userID.'_ownAffiliateAmazon', $_POST['wpAppbox_user_'.$userID.'_ownAffiliateAmazon']);
	update_option('wpAppbox_user_'.$userID.'_affiliateAmazon', Trim($_POST['wpAppbox_user_'.$userID.'_affiliateAmazon']));
	update_option('wpAppbox_user_'.$userID.'_affiliateAmazonDev', $_POST['wpAppbox_user_'.$userID.'_affiliateAmazonDev']);
}

add_action('show_user_profile', 'wpAppbox_add_custom_affiliate_id');
add_action('edit_user_profile', 'wpAppbox_add_custom_affiliate_id');

add_action('personal_options_update', 'wpAppbox_save_custom_affiliate_id');
add_action('edit_user_profile_update', 'wpAppbox_save_custom_affiliate_id');

?>
<?php function wpAppbox_add_custom_affiliate_id($user) { ?>
		<?php  
			$options = get_option("wpAppbox");
			if($options['wpAppbox_user_affiliateids']) {
				$userid = $user->ID;
				if(!current_user_can('edit_user', $userid)) return FALSE;
				?>
		<h3><?php _e('WP-Appbox: Affiliate-IDs', 'wpappbox'); ?></h3>
		<script>
			function show_hide_options(affid) {
				var status = document.getElementById("wpAppbox_user<?php echo($userid); ?>_"+affid+"_global").checked;
				var table = document.getElementById("wpAppbox_user<?php echo($userid); ?>_"+affid+"_div");
				if(status == true) { table.style.display = ""; }
				else { table.style.display = "none"; }
			}
			function show_hide_apple_affiliate() {
				var status = document.getElementById("wpAppbox_user<?php echo($userid); ?>_affiliate_apple_service").selectedIndex;
				var desc = document.getElementById("wpAppbox_user<?php echo($userid); ?>_apple_desc");
				var sponsored = document.getElementById("wpAppbox_user<?php echo($userid); ?>_tradedoubler_sponsored_p");
				if(status == "0") { 
					sponsored.style.display = "";
					desc.innerHTML = "<?php _e('Deine Affiliate-ID bei TradeDoubler. Wird keine ID angegeben, wird die Standard-ID genutzt.', 'wpappbox'); ?>";
				}
				else { 
					sponsored.style.display = "none";
					desc.innerHTML = "<?php _e('Deine Affiliate-ID bei PHG. Wird keine ID angegeben, wird die Standard-ID genutzt.', 'wpappbox'); ?>";
				}
			}
		</script>
		<table class="form-table">
			<tr>
				<th>
					<label for="wpAppbox_user<?php echo($userid); ?>_tradedoubler"><?php _e('TradeDoubler- & PHG-ID', 'wpappbox'); ?>:</label>
				</th>
				<td>
					<p><label for="wpAppbox_user<?php echo($userid); ?>_tradedoubler_global"><input onClick="javascript:show_hide_options('tradedoubler')" type="checkbox" name="wpAppbox_user<?php echo($userid); ?>_tradedoubler_global" id="wpAppbox_user<?php echo($userid); ?>_tradedoubler_global" value="1" <?php if($options['wpAppbox_user'.$userid.'_tradedoubler_global'] == true) echo 'checked="checked"'; ?> /> <?php _e('Nutze andere IDs als die globalen IDs aus den Einstellungen der WP-Appbox.', 'wp-appbox'); ?></label></p>
					<div id="wpAppbox_user<?php echo($userid); ?>_tradedoubler_div" <?php if(!$options['wpAppbox_user'.$userid.'_tradedoubler_global']) echo 'style="display:none;"'; ?>>
						<p style="margin-left: 24px;">
							<select name="wpAppbox_user<?php echo($userid); ?>_affiliate_apple_service" id="wpAppbox_user<?php echo($userid); ?>_affiliate_apple_service" class="postform" style="min-width:250px;" onchange="javascript:show_hide_apple_affiliate()">
							   <option class="level-0" value="tradedoubler" <?php if($options['wpAppbox_user'.$userid.'_affiliate_apple_service'] == 'tradedoubler') echo 'selected="selected"'; ?>><?php _e('TradeDoubler (TD) - Nur für Europa und Südamerika.', 'wp-appbox'); ?></option> 
							   <option class="level-0" value="phg" <?php if($options['wpAppbox_user'.$userid.'_affiliate_apple_service'] == 'phg') echo 'selected="selected"'; ?>><?php _e('Performance Horizon Group (PHG) - Nicht für Europa und Südamerika.', 'wp-appbox'); ?></option>
							</select> 
						</p>
						<p style="margin-left: 24px;">
							<input type="text" name="wpAppbox_user<?php echo($userid); ?>_tradedoubler" id="wpAppbox_user<?php echo($userid); ?>_tradedoubler" value="<?php echo $options['wpAppbox_user'.$userid.'_tradedoubler']; ?>" class="regular-text" style="width: 200px;" /> <span class="description" id="wpAppbox_user<?php echo($userid); ?>_apple_desc"><?php echo ($options['wpAppbox_user'.$userid.'_affiliate_apple_service'] == 'tradedoubler') ? __('Deine Affiliate-ID bei TradeDoubler. Wird keine ID angegeben, wird die Standard-ID genutzt.', 'wpappbox') : __('Deine Affiliate-ID bei PHG. Wird keine ID angegeben, wird die Standard-ID genutzt.', 'wpappbox'); ?></span>
						</p>
						<p style="margin-left: 24px;  <?php if($options['wpAppbox_user'.$userid.'_affiliate_apple_service'] == 'phg') echo 'display:none;'; ?>" id="wpAppbox_user<?php echo($userid); ?>_tradedoubler_sponsored_p"><label for="wpAppbox_user<?php echo($userid); ?>_tradedoubler_sponsored"><input type="checkbox" name="wpAppbox_user<?php echo($userid); ?>_tradedoubler_sponsored" value="1" <?php if($options['wpAppbox_user'.$userid.'_tradedoubler_sponsored']) echo 'checked="checked"'; ?> /> <?php _e('Ich habe keine ID bei TradeDoubler und möchte die ID des Entwicklers nutzen. (In diesem Falle: <strong>Danke</strong>!)', 'wp-appbox'); ?></label></p>
					</div>
				</td>
			</tr>
			<tr>
				<th>
					<label for="wpAppbox_user<?php echo($userid); ?>_affilinet"><?php _e('Affili.net-ID', 'wpappbox'); ?>:</label>
				</th>
				<td>
					<p><label for="wpAppbox_user<?php echo($userid); ?>_affilinet_global"><input onClick="javascript:show_hide_options('affilinet')" type="checkbox" name="wpAppbox_user<?php echo($userid); ?>_affilinet_global" id="wpAppbox_user<?php echo($userid); ?>_affilinet_global" value="1" <?php if($options['wpAppbox_user'.$userid.'_affilinet_global'] == true) echo 'checked="checked"'; ?> /> <?php _e('Nutze andere IDs als die globalen IDs aus den Einstellungen der WP-Appbox.', 'wp-appbox'); ?></label></p>
					<div id="wpAppbox_user<?php echo($userid); ?>_affilinet_div" <?php if(!$options['wpAppbox_user'.$userid.'_affilinet_global']) echo 'style="display:none;"'; ?>>
						<p style="margin-left: 24px;"><input type="text" name="wpAppbox_user<?php echo($userid); ?>_affilinet" id="wpAppbox_user<?php echo($userid); ?>_affilinet" value="<?php echo $options['wpAppbox_user'.$userid.'_affilinet']; ?>" class="regular-text" style="width: 200px;" /> <span class="description"><?php _e('Deine Affiliate-ID bei Affili.net. Wird keine ID angegeben, wird die Standard-ID genutzt.', 'wpappbox'); ?></span></p>
						<p style="margin-left: 24px;"><label for="wpAppbox_user<?php echo($userid); ?>_affilinet_sponsored"><input type="checkbox" name="wpAppbox_user<?php echo($userid); ?>_affilinet_sponsored" value="1" <?php  if($options['wpAppbox_user'.$userid.'_affilinet_sponsored'] == true) echo 'checked="checked"'; ?> /> <?php _e('Ich habe keine ID bei Affili.net und möchte die ID des Entwicklers nutzen. (In diesem Falle: <strong>Danke</strong>!)', 'wp-appbox'); ?></label></p>
					</div>
				</td>
			</tr>
			<tr>
				<th>
					<label for="wpAppbox_user<?php echo($userid); ?>_amazonpartnernet"><?php _e('Amazon PartnerNet ID', 'wpappbox'); ?>:</label>
				</th>
				<td>
					<p><label for="wpAppbox_user<?php echo($userid); ?>_amazonpartnernet_global"><input onClick="javascript:show_hide_options('amazonpartnernet')" type="checkbox" name="wpAppbox_user<?php echo($userid); ?>_amazonpartnernet_global" id="wpAppbox_user<?php echo($userid); ?>_amazonpartnernet_global" value="1" <?php  if($options['wpAppbox_user'.$userid.'_amazonpartnernet_global'] == true) echo 'checked="checked"'; ?> /> <?php _e('Nutze andere IDs als die globalen IDs aus den Einstellungen der WP-Appbox.', 'wp-appbox'); ?></label></p>
					<div id="wpAppbox_user<?php echo($userid); ?>_amazonpartnernet_div" <?php if(!$options['wpAppbox_user'.$userid.'_amazonpartnernet_global']) echo 'style="display:none;"'; ?>>
						<p style="margin-left: 24px;"><input type="text" name="wpAppbox_user<?php echo($userid); ?>_amazonpartnernet" id="wpAppbox_user<?php echo($userid); ?>_amazonpartnernet" value="<?php echo $options['wpAppbox_user'.$userid.'_amazonpartnernet']; ?>" class="regular-text" style="width: 200px;" /> <span class="description"><?php _e('Deine Affiliate-ID beim Amazon PartnerNet. Wird keine ID angegeben, wird die Standard-ID genutzt.', 'wpappbox'); ?></span></p>
						<p style="margin-left: 24px;"><label for="wpAppbox_user<?php echo($userid); ?>_amazonpartnernet_sponsored"><input type="checkbox" name="wpAppbox_user<?php echo($userid); ?>_amazonpartnernet_sponsored" value="1" <?php  if($options['wpAppbox_user'.$userid.'_amazonpartnernet_sponsored'] == true) echo 'checked="checked"'; ?> /> <?php _e('Ich habe keine ID beim Amazon PartnerNet und möchte die ID des Entwicklers nutzen. (In diesem Falle: <strong>Danke</strong>!)', 'wp-appbox'); ?></label></p>
					</div>
				</td>
			</tr>
		</table>
<?php }
}

function wpAppbox_save_custom_affiliate_id($user_id) {
	if(!current_user_can('edit_user', $user_id)) return FALSE;
	$settings = get_option("wpAppbox");
	if($settings['wpAppbox_user_affiliateids']) {
		$settings['wpAppbox_user'.$user_id.'_affiliate_apple_service'] = $_POST['wpAppbox_user'.$user_id.'_affiliate_apple_service'];
		$settings['wpAppbox_user'.$user_id.'_tradedoubler'] = $_POST['wpAppbox_user'.$user_id.'_tradedoubler'];
		$settings['wpAppbox_user'.$user_id.'_tradedoubler_global'] = $_POST['wpAppbox_user'.$user_id.'_tradedoubler_global'];
		$settings['wpAppbox_user'.$user_id.'_tradedoubler_sponsored'] = $_POST['wpAppbox_user'.$user_id.'_tradedoubler_sponsored'];
		$settings['wpAppbox_user'.$user_id.'_affilinet'] = $_POST['wpAppbox_user'.$user_id.'_affilinet'];
		$settings['wpAppbox_user'.$user_id.'_affilinet_global'] = $_POST['wpAppbox_user'.$user_id.'_affilinet_global'];
		$settings['wpAppbox_user'.$user_id.'_affilinet_sponsored'] = $_POST['wpAppbox_user'.$user_id.'_affilinet_sponsored'];
		$settings['wpAppbox_user'.$user_id.'_amazonpartnernet'] = $_POST['wpAppbox_user'.$user_id.'_amazonpartnernet'];
		$settings['wpAppbox_user'.$user_id.'_amazonpartnernet_global'] = $_POST['wpAppbox_user'.$user_id.'_amazonpartnernet_global'];
		$settings['wpAppbox_user'.$user_id.'_amazonpartnernet_sponsored'] = $_POST['wpAppbox_user'.$user_id.'_amazonpartnernet_sponsored'];
		update_option("wpAppbox", $settings);
	}
}

add_action('show_user_profile', 'wpAppbox_add_custom_affiliate_id');
add_action('edit_user_profile', 'wpAppbox_add_custom_affiliate_id');

add_action('personal_options_update', 'wpAppbox_save_custom_affiliate_id');
add_action('edit_user_profile_update', 'wpAppbox_save_custom_affiliate_id');

?>
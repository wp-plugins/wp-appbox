<p><?php _e('What buttons are to be used in the editor, and what app banners to be used in operation without format specification?', 'wp-appbox'); ?></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="default_appbanner"><?php _e('Standard App-Badge', 'wp-appbox'); ?></label></th>
		<td colspan="7">
			<select name="wpAppbox_view_default" id="wpAppbox_view_default" class="postform" style="min-width:250px;" onChange="javascript:show_hide_box()">
			   <option class="level-0" value="1" <?php selected($options['wpAppbox_view_default'], '1'); ?>><?php _e('Simple Badge', 'wp-appbox'); ?></option> 
			   <option class="level-0" value="3" <?php selected($options['wpAppbox_view_default'], '3'); ?>><?php _e('Screenshots', 'wp-appbox'); ?></option>
			   <option class="level-0" value="6" <?php selected($options['wpAppbox_view_default'], '6'); ?>><?php _e('Screenshots Only', 'wp-appbox'); ?></option>
			   <option class="level-0" value="2" <?php selected($options['wpAppbox_view_default'], '2'); ?>><?php _e('Compact Badge', 'wp-appbox'); ?></option> 
			</select>
		</td>
	</tr>
	<?php 
		$th_last = count($store_names);
		$th_half = ceil($th_last/2);
		$th_count = -1;
		foreach($style_names_appstores as $store => $styles) { ?>
		<?php $th_count++; ?>
		<?php if(($th_count == 0) || ($th_half == $th_count)) { ?>
			<tr valign="top">
				<th scope="row"></th>
				<td style="width: 80px; text-align:center;"><?php _e('Standard', 'wp-appbox'); ?></td>
				<td style="width: 80px; text-align:center;"><?php _e('Simple', 'wp-appbox'); ?></td>
				<td style="width: 80px; text-align:center;"><?php _e('Compact', 'wp-appbox'); ?></td>
				<td style="width: 80px; text-align:center;"><?php _e('Screenshots', 'wp-appbox'); ?></td>
				<td style="width: 80px; text-align:center;"><?php _e('Screenshots&nbsp;Only', 'wp-appbox'); ?></td>
				<td></td>
			</tr>
		<?php } ?>
		<tr valign="top">
			<th scope="row"><label for="default_<?php echo $store; ?>"><?php echo($store_names[$store]); ?></label></th>
			<?php foreach($style_names_global as $style_id => $style_name) { ?>
				<?php if((in_array($style_id, $styles)) || ($style_id == '0')) { ?>
					<td style="text-align:center;"><input name="wpAppbox_view_<?php echo $store; ?>" <?php checked($options['wpAppbox_view_'.$store], $style_id); ?> type="radio" id="wpAppbox_view_<?php echo $store; ?>" value="<?php echo $style_id; ?>" /></td>
				<?php } else { ?>
					<td></td>
				<?php } ?>
			<?php } ?>		
			<td></td>
		</tr>
	<?php } ?>
	<tr valign="top">
		<th scope="row"></th>
		<td style="width: 80px; text-align:center;"><?php _e('Standard', 'wp-appbox'); ?></td>
		<td style="width: 80px; text-align:center;"><?php _e('Simple', 'wp-appbox'); ?></td>
		<td style="width: 80px; text-align:center;"><?php _e('Compact', 'wp-appbox'); ?></td>
		<td style="width: 80px; text-align:center;"><?php _e('Screenshots', 'wp-appbox'); ?></td>
		<td style="width: 80px; text-align:center;"><?php _e('Screenshots&nbsp;Only', 'wp-appbox'); ?></td>
		<td></td>
	</tr>
</table>
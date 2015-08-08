<script>
	function select_row(id, status) {
		<?php foreach($wpAppbox_storeNames as $storeID => $storeName) { ?>
			var checkbox_<?php echo($storeID); ?> = document.getElementById("wpAppbox_defaultStyle_<?php echo($storeID); ?>"+id);
			if(checkbox_<?php echo($storeID); ?>) checkbox_<?php echo($storeID); ?>.checked = status;
		<?php } ?>
	}
</script>

<p><?php _e('What buttons are to be used in the editor, and what app banners to be used in operation without format specification?', 'wp-appbox'); ?></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_defaultStyle"><?php _e('Standard App-Badge', 'wp-appbox'); ?></label></th>
		<td colspan="7">
			<select name="wpAppbox_defaultStyle" id="wpAppbox_defaultStyle" class="postform" style="min-width:250px;" onChange="javascript:show_hide_box()">
			   <option class="level-0" value="1" <?php selected(get_option('wpAppbox_defaultStyle'), '1'); ?>><?php _e('Simple Badge', 'wp-appbox'); ?></option> 
			   <option class="level-0" value="3" <?php selected(get_option('wpAppbox_defaultStyle'), '3'); ?>><?php _e('Screenshots', 'wp-appbox'); ?></option>
			   <option class="level-0" value="6" <?php selected(get_option('wpAppbox_defaultStyle'), '6'); ?>><?php _e('Screenshots Only', 'wp-appbox'); ?></option>
			   <option class="level-0" value="2" <?php selected(get_option('wpAppbox_defaultStyle'), '2'); ?>><?php _e('Compact Badge', 'wp-appbox'); ?></option> 
			</select>
		</td>
	</tr>
	<?php 
		$th_last = count($wpAppbox_storeNames);
		$th_half = ceil($th_last/2);
		$th_count = -1;
		foreach($wpAppbox_storeStyles as $storeName => $storeStyles) { ?>
		<?php $th_count++; ?>
		<?php if(($th_count == 0) || ($th_half == $th_count)) { ?>
			<tr valign="top">
				<th scope="row"></th>
				<td style="width: 80px; text-align:center;"><?php _e('Standard', 'wp-appbox'); ?><?php if($th_count == 0) { ?><br /><small><a href="#" onClick="select_row(0, true);return false;"><?php _e('All', 'wp-appbox'); ?></a></small><?php } ?></td>
				<td style="width: 80px; text-align:center;"><?php _e('Simple', 'wp-appbox'); ?><?php if($th_count == 0) { ?><br /><small><a href="#" onClick="select_row(1, true);return false;"><?php _e('All', 'wp-appbox'); ?></a></small><?php } ?></td>
				<td style="width: 80px; text-align:center;"><?php _e('Compact', 'wp-appbox'); ?><?php if($th_count == 0) { ?><br /><small><a href="#" onClick="select_row(2, true);return false;"><?php _e('All', 'wp-appbox'); ?></a></small><?php } ?></td>
				<td style="width: 80px; text-align:center;"><?php _e('Screenshots', 'wp-appbox'); ?><?php if($th_count == 0) { ?><br /><small><a href="#" onClick="select_row(3, true);return false;"><?php _e('All', 'wp-appbox'); ?></a></small><?php } ?></td>
				<td style="width: 80px; text-align:center;"><?php _e('Screenshots&nbsp;Only', 'wp-appbox'); ?><?php if($th_count == 0) { ?><br /><small><a href="#" onClick="select_row(4, true);return false;"><?php _e('All', 'wp-appbox'); ?></a></small><?php } ?></td>
				<td></td>
			</tr>
		<?php } ?>
		<tr valign="top">
			<th scope="row"><label for="default_<?php echo($storeName); ?>"><?php echo($wpAppbox_storeNames[$storeName]); ?></label></th>
			<?php foreach($wpAppbox_styleNames as $styleID => $styleName) { ?>
				<?php if((in_array($styleID, $storeStyles)) || ($styleID == '0')) { ?>
					<td style="text-align:center;"><input name="wpAppbox_defaultStyle_<?php echo($storeName); ?>" <?php checked(get_option('wpAppbox_defaultStyle_'.$storeName), $styleID); ?> type="radio" id="wpAppbox_defaultStyle_<?php echo($storeName.$styleID); ?>" value="<?php echo($styleID); ?>" /></td>
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
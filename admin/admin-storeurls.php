<script>
	function show_hide_box(store) {
		var box = document.getElementById("wpAppbox_storeurl_"+store);
		var attr = document.getElementById("wpAppbox_storeurl_"+store).options[box.selectedIndex].getAttribute("data");
		var txt = document.getElementById("wpAppbox_storeurl_"+store+"_url");
		txt.value = attr;
		if(box.selectedIndex == 0) txt.disabled = false;
		else txt.disabled = true;
	}
</script>

<h3><?php _e('Store-URLs', 'wp-appbox'); ?></h3>
<p><?php _e('Here you can change the query URL of the stores. Just copy the desired URL and set instead of the app ID wildcard {APPID}. If the URL is empty, the default URL (German) is used.', 'wp-appbox'); ?></p>

<table class="form-table">
	<?php foreach($store_names as $store => $name) { ?>
		<tr valign="top">
			<th scope="row"><?php echo($store_names[$store]); ?>:</th>
			<td>	
				<?php 
					if(in_array($store, $store_no_languages)) { _e('No language selection supported.', 'wp-appbox'); } 
					else { 
				?>
					<select style="width: 185px;" onChange="javascript:show_hide_box('<?php echo $store; ?>')" name="wpAppbox_storeurl_<?php echo $store; ?>" id="wpAppbox_storeurl_<?php echo $store; ?>" class="postform">
						<option <?php if($options['wpAppbox_storeurl_'.$store] == '0') echo 'selected="selected"'; ?> value="0" data="<?php echo $options['wpAppbox_storeurl_'.$store.'_url']; ?>"><?php echo $store_urls_languages[0]; ?></option>
						<?php 
							asort($store_urls_languages);
							foreach($store_urls_languages as $id => $language) { ?>
							<?php if(($id != '0') && ($store_urls[$store][$id] != '')) { ?>
								<option <?php if($options['wpAppbox_storeurl_'.$store] == $id) echo 'selected="selected"'; ?> value="<?php echo $id; ?>" data="<?php echo $store_urls[$store][$id]; ?>"><?php echo $language; ?></option>
							<?php } ?>
						<?php } ?>
					</select>
					 
					<input <?php if($options['wpAppbox_storeurl_'.$store] != 0) echo 'disabled="disabled"'; ?> type="text" value="<?php echo ($options['wpAppbox_storeurl_'.$store] == '0') ? $options['wpAppbox_storeurl_'.$store.'_url'] : $store_urls[$store][$options['wpAppbox_storeurl_'.$store]]; ?>" name="wpAppbox_storeurl_<?php echo $store; ?>_url" id="wpAppbox_storeurl_<?php echo $store; ?>_url" style="width:500px;" />
				<?php } ?>
			</td>
		</tr>
	<?php } ?>
</table>
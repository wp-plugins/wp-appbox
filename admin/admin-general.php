<h3><?php _e('Basic settings', 'wp-appbox'); ?></h3>
<p><?php _e('Some basic settings for the WP-Appbox and the badges. ;)', 'wp-appbox'); ?></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_showrating"><?php _e('App-Ratings', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_showrating">
				<input type="checkbox" name="wpAppbox_showrating" id="wpAppbox_showrating" value="1" <?php  if($options['wpAppbox_showrating']) echo 'checked="checked"'; ?> />
				<?php _e('Show app-ratings from the stores in the banner (Variable {RATING} in the template-files)', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_colorful"><?php _e('Colored store icons', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_colorful">
				<input type="checkbox" name="wpAppbox_colorful" id="wpAppbox_colorful" value="1" <?php  if($options['wpAppbox_colorful']) echo 'checked="checked"'; ?> />
				<?php _e('Show colored icons of the stores instead of the grey ones', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_nofollow"><?php _e('Nofollow', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_nofollow">
				<input type="checkbox" name="wpAppbox_nofollow" id="wpAppbox_nofollow" value="1" <?php  if($options['wpAppbox_nofollow']) echo 'checked="checked"'; ?> />
				<?php _e('Adds the <a href="http://en.wikipedia.org/wiki/Nofollow" target="_blank">nofollow</a> attribute to the links', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_blank"><?php _e('Open links in a new window', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_blank">
				<input type="checkbox" name="wpAppbox_blank" id="wpAppbox_blank" value="1" <?php  if($options['wpAppbox_blank']) echo 'checked="checked"'; ?> />
				<?php _e('Opens the links of apps in a new window (target="_blank")', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_show_reload_link"><?php _e('Show Reload-link', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_show_reload_link">
				<input type="checkbox" name="wpAppbox_show_reload_link" id="wpAppbox_show_reload_link" value="1" <?php  if($options['wpAppbox_show_reload_link']) echo 'checked="checked"'; ?> />
				<?php _e('Shows in the Appbox a link to reload the app data (only for authors and higher)', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_downloadtext"><?php _e('Downloadbutton caption', 'wp-appbox'); ?></label></th>
		<td>
			<input type="text" name="wpAppbox_downloadtext" id="wpAppbox_downloadtext" value="<?php echo $options['wpAppbox_downloadtext']; ?>" /> <label for="wpAppbox_downloadtext"><?php _e('Caption of the "Download"-button in the app-badge', 'wp-appbox'); ?></label>
		</td>
	</tr>
</table>

<h3><?php _e('Caching options', 'wp-appbox'); ?></h3>
<p><?php _e('The caching interval indicate how often the data is updated from the server - this increases the performance, and should not really be changed.', 'wp-appbox'); ?></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_datacachetime"><?php _e('Data caching (minutes)', 'wp-appbox'); ?></label></th>
		<td>
			<input type="number" pattern="[0-9]*" name="wpAppbox_datacachetime" id="wpAppbox_datacachetime" value="<?php echo $options['wpAppbox_datacachetime']; ?>" /> <label for="wpAppbox_datacachetime"><?php _e('The recommended interval is <strong>300</strong> minutes', 'wp-appbox'); ?></label>
		</td>
	</tr>
</table>

<h3><?php _e('Error output & troubleshooting', 'wp-appbox'); ?></h3>
<p><?php _e('The error output should only be turned on in case of problems. The design can be separated.', 'wp-appbox'); ?></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_curl_timeout"><?php _e('Server timeout', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_curl_timeout">
				<input type="number" pattern="[0-9]*" name="wpAppbox_curl_timeout" id="wpAppbox_curl_timeout" value="<?php echo $options['wpAppbox_curl_timeout']; ?>" />
				<?php _e('The recommended timeout is <strong>5</strong> seconds. Only change if apps are not found.', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_error_onlyforauthor"><?php _e('Error messages', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_error_onlyforauthor">
				<input type="checkbox" name="wpAppbox_error_onlyforauthor" id="wpAppbox_error_onlyforauthor" value="1" <?php  if($options['wpAppbox_error_onlyforauthor']) echo 'checked="checked"'; ?> />
				<?php _e('Show error messages only for authors.', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_error_parseoutput"><?php _e('Parse output', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_error_parseoutput">
				<input type="checkbox" name="wpAppbox_error_parseoutput" id="wpAppbox_error_parseoutput" value="1" <?php  if($options['wpAppbox_error_parseoutput']) echo 'checked="checked"'; ?> />
				<?php _e('Activate parse output. Only visible to administrators.', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php _e('Disable cache', 'wp-appbox'); ?>:</th>
		<td>	
			<?php _e('The cache can only be temporarily disabled by adding "?wpappbox_nocache" is appended to the URL of an article. Only for "authors".', 'wp-appbox'); ?>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php _e('Force reloading', 'wp-appbox'); ?>:</th>
		<td>	
			<?php _e('If reloading of app-data (despite cache) is to be forced, then does this by "?wpappbox_reload_cache" is appended to the URL of an article. Only users, who are at least author.', 'wp-appbox'); ?>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_useownsheet"><?php _e('Disable the plugins sheet', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_useownsheet">
				<input type="checkbox" name="wpAppbox_useownsheet" id="wpAppbox_useownsheet" value="1" <?php  if($options['wpAppbox_useownsheet']) echo 'checked="checked"'; ?> />
				<?php _e('Disables the plugins stylesheets and allow the use of their own adaptations.', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_avoid_loadfonts"><?php _e('Avoid Google Fonts', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_avoid_loadfonts">
				<input type="checkbox" name="wpAppbox_avoid_loadfonts" id="wpAppbox_avoid_loadfonts" value="1" <?php  if($options['wpAppbox_avoid_loadfonts']) echo 'checked="checked"'; ?> />
				<?php _e('Avoid loading of Google Fonts (OpenSans) through WP-Appbox.', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_itunes_secureimage"><?php _e('Apple App Store Icons', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_itunes_secureimage">
				<input type="checkbox" name="wpAppbox_itunes_secureimage" id="wpAppbox_itunes_secureimage" value="1" <?php  if($options['wpAppbox_itunes_secureimage']) echo 'checked="checked"'; ?> />
				<?php _e('Compatibility mode for app icons from the (Mac) App Store.', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
</table>
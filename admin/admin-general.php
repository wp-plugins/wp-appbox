<h3><?php _e('Basic settings', 'wp-appbox'); ?></h3>
<p><?php _e('Some basic settings for the WP-Appbox and the badges. ;)', 'wp-appbox'); ?></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_showRating"><?php _e('App-Ratings', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_showRating">
				<input type="checkbox" name="wpAppbox_showRating" id="wpAppbox_showRating" value="1" <?php checked(get_option('wpAppbox_showRating')); ?>/>
				<?php _e('Show app-ratings from the stores in the banner (Variable {RATING} in the template-files)', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_colorfulIcons"><?php _e('Colored store icons', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_colorfulIcons">
				<input type="checkbox" name="wpAppbox_colorfulIcons" id="wpAppbox_colorfulIcons" value="1" <?php checked(get_option('wpAppbox_colorfulIcons')); ?>/>
				<?php _e('Show colored icons of the stores instead of the grey ones', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_nofollow"><?php _e('Nofollow', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_nofollow">
				<input type="checkbox" name="wpAppbox_nofollow" id="wpAppbox_nofollow" value="1" <?php checked(get_option('wpAppbox_nofollow')); ?>/>
				<?php _e('Adds the <a href="http://en.wikipedia.org/wiki/Nofollow" target="_blank">nofollow</a> attribute to the links', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_targetBlank"><?php _e('Open links in a new window', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_targetBlank">
				<input type="checkbox" name="wpAppbox_targetBlank" id="wpAppbox_targetBlank" value="1" <?php checked(get_option('wpAppbox_targetBlank')); ?>/>
				<?php _e('Opens the links of apps in a new window (target="_blank")', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_reloadLink"><?php _e('Show Reload-link', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_showReload">
				<input type="checkbox" name="wpAppbox_showReload" id="wpAppbox_showReload" value="1" <?php checked(get_option('wpAppbox_showReload')); ?>/>
				<?php _e('Shows in the Appbox a link to reload the app data (only for authors and higher)', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_downloadCaption"><?php _e('Downloadbutton caption', 'wp-appbox'); ?></label></th>
		<td>
			<input type="text" name="wpAppbox_downloadCaption" id="wpAppbox_downloadCaption" value="<?php echo get_option('wpAppbox_downloadCaption'); ?>" /> <label for="wpAppbox_downloadtext"><?php _e('Caption of the "Download"-button in the app-badge', 'wp-appbox'); ?></label>
		</td>
	</tr>
</table>

<h3><?php _e('Caching options', 'wp-appbox'); ?></h3>
<p><?php _e('The caching interval indicate how often the data is updated from the server - this increases the performance, and should not really be changed.', 'wp-appbox'); ?></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_cacheTime"><?php _e('Data caching (minutes)', 'wp-appbox'); ?></label></th>
		<td>
			<input type="number" pattern="[0-9]*" name="wpAppbox_cacheTime" id="wpAppbox_cacheTime" value="<?php echo get_option('wpAppbox_cacheTime'); ?>" /> <label for="wpAppbox_cacheTime"><?php _e('The recommended interval is <strong>600</strong> minutes', 'wp-appbox'); ?></label>
		</td>
	</tr>
</table>

<h3><?php _e('Error output & troubleshooting', 'wp-appbox'); ?></h3>
<p><?php _e('The error output should only be turned on in case of problems. The design can be separated.', 'wp-appbox'); ?></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_curlTimeout"><?php _e('Server timeout', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_curlTimeout">
				<input type="number" pattern="[0-9]*" name="wpAppbox_curlTimeout" id="wpAppbox_curlTimeout" value="<?php echo get_option('wpAppbox_curlTimeout'); ?>" />
				<?php _e('The recommended timeout is <strong>5</strong> seconds. Only change if apps are not found.', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_eOnlyAuthors"><?php _e('Error messages', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_eOnlyAuthors">
				<input type="checkbox" name="wpAppbox_eOnlyAuthors" id="wpAppbox_eOnlyAuthors" value="1" <?php checked(get_option('wpAppbox_eOnlyAuthors')); ?>/>
				<?php _e('Show error messages only for authors.', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_eOutput"><?php _e('Parse output', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_eOutput">
				<input type="checkbox" name="wpAppbox_eOutput" id="wpAppbox_eOutput" value="1" <?php checked(get_option('wpAppbox_eOutput')); ?>/>
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
		<th scope="row"><label for="wpAppbox_disableCSS"><?php _e('Disable the plugins sheet', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_disableCSS">
				<input type="checkbox" name="wpAppbox_disableCSS" id="wpAppbox_disableCSS" value="1" <?php checked(get_option('wpAppbox_disableCSS')); ?>/>
				<?php _e('Disables the plugins stylesheets and allow the use of their own adaptations.', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_disableFonts"><?php _e('Disable Google Fonts', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_disableFonts">
				<input type="checkbox" name="wpAppbox_disableFonts" id="wpAppbox_disableFonts" value="1" <?php checked(get_option('wpAppbox_disableFonts')); ?>/>
				<?php _e('Avoid loading of Google Fonts (OpenSans) through WP-Appbox.', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_eImageApple"><?php _e('Apple App Store Icons', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_eImageApple">
				<input type="checkbox" name="wpAppbox_eImageApple" id="wpAppbox_eImageApple" value="1" <?php checked(get_option('wpAppbox_eImageApple')); ?>/>
				<?php _e('Compatibility mode for app icons from the (Mac) App Store.', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
</table>
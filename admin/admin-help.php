<h3><?php _e('Get the ID of an app', 'wp-appbox'); ?></h3>
<p><?php _e('A small overview of how you get the ID of an app.', 'wp-appbox'); ?></p>

<table class="form-table">
	<?php foreach($wpAppbox_storeNames as $id => &$name) { ?>
	<tr valign="top">
		<th scope="row"><?php echo $name; ?>:</th>
		<td><img src="<?php echo plugins_url('img/appid/'.$id.'.jpg', dirname(__FILE__)); ?>" alt="<?php echo $name; ?> ID" /></td>
	</tr>
	<?php } ?>
</table>

<h3><?php _e('The shortcode', 'wp-appbox'); ?></h3>
<p><?php _e('A short overview of tags and parameters.', 'wp-appbox'); ?></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><?php _e('App Store screenshots', 'wp-appbox'); ?>:</th>
		<td><?php _e('Link to a universal app for iOS and Watch-App for Apple Watch, so you can just leave on request show the iPhone or iPad screenshots. For this, <code>-iphone</code>, <code>-ipad</code> or <code>-watch</code> can be added to the App ID. Example: <code>[appbox appstore appid-iphone screenshots]</code>', 'wp-appbox'); ?></td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php _e('Windows Store screenshots', 'wp-appbox'); ?>:</th>
		<td><?php _e('Link to a universal app for Windows 10 (Mobile), so you can just leave on request show the mobile or desktop screenshots. For this, <code>-mobile</code> or <code>-desktop</code> can be added to the App ID. Example: <code>[appbox windowsstore appid-mobile screenshots]</code>', 'wp-appbox'); ?></td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php _e('Show old price', 'wp-appbox'); ?>:</th>
		<td><?php _e('If you want besides a special price also specify an old price, then the day <code>oldprice="xy"</code> are used in the shortcode. This is only displayed if it differs from the current price. Example: <code>[appbox appstore appid oldprice="1,99€"]</code>', 'wp-appbox'); ?></td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php _e('Temporarily disable cache', 'wp-appbox'); ?>:</th>
		<td><?php _e('The cache can be temporarily disabled by adding <code>?wpappbox_reload_cache</code> is appended to the URL of an article. Only for authors.', 'wp-appbox'); ?></td>
	</tr>
</table>
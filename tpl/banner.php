<div class="appcontainer banner <?php storename_css(); ?>">
	<div style="width:auto; height:auto; position: relative !important;">
		<a href="<?php app_store_url(); ?>" title="<?php app_title(); ?>"><img src="<?php banner_image(); ?>" alt="<?php app_title(); ?>" class="appbanner" /></a>
		<?php qrcode(); ?>
	</div>
	<table class="appdetails">
		<tr>
			<td>
				<a href="<?php app_store_url(); ?>" title="<?php app_title(); ?>" class="apptitle"><?php app_title(); ?></a><br />
				<span class="developer"><?php _e('Entwickler', 'wp-appbox'); ?>: <a href="<?php author_store_url(); ?>" title="<?php app_author(); ?>" class="appauthor"><?php app_author(); ?></a></span><br />
				<span class="price"><?php _e('Preis', 'wp-appbox'); ?>: <?php app_price(); ?></td>
			</td>
			<td class="appbutton <?php storename_css(); ?>">
				<a href="<?php app_store_url(); ?>"  title="<?php app_title(); ?>"><?php _e('Download', 'wp-appbox'); ?> @<br /><?php storename(); ?></a>
			</td>
		</tr>
	</table>
</div>
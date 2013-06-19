<div class="appcontainer screenshots <?php storename_css(); ?>">
		<a href="<?php app_store_url(); ?>" title="<?php app_title(); ?>"><img src="<?php banner_icon(); ?>" alt="<?php app_title(); ?>" class="appicon" /></a>
		<?php qrcode(); ?>
		<a href="<?php app_store_url(); ?>"  title="<?php app_title(); ?>" class="appbutton <?php storename_css(); ?>"><?php _e('Download', 'wp-appbox'); ?> @<br /><?php storename(); ?></a>
		<div class="appdetails">
			<a href="<?php app_store_url(); ?>" title="<?php app_title(); ?>" class="apptitle"><?php app_title(); ?></a><br />
			<span class="developer"><?php _e('Entwickler', 'wp-appbox'); ?>: <a href="<?php author_store_url(); ?>" title="<?php app_author(); ?>" class="appauthor"><?php app_author(); ?></a></span><br />
			<span class="price"><?php _e('Preis', 'wp-appbox'); ?>: <?php app_price(); ?></span>
		</div>
		<div class="appscreenshots">
			<div class="slider">
				<ul>
					<?php app_screenshots(); ?>
				</ul>
			</div>
		</div>
		<div style="clear:both;"></div>
</div>
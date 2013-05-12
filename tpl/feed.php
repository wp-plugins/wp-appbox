<div class="appcontainer feed <?php storename_css(); ?>">
	<table width="100%;">
		<tr>
			<td style="width: 88px;"><a href="<?php app_store_url(); ?>" title="<?php app_title(); ?>"><img style="border-radius: 6px !important; border: 0 !important; padding: 0 !important; width: 80px !important; height: 80px !important;" src="<?php banner_icon(); ?>" alt="<?php app_title(); ?>" /></a></td>
			<td>
				<a href="<?php app_store_url(); ?>" title="<?php app_title(); ?>"><?php app_title(); ?><img src="<?php echo plugins_url('img/'.get_storename_css().'-small.png', dirname(__FILE__)); ?>" style="margin-left:6px !important;" /></a><br />
				<?php _e('Preis', 'wp-appbox'); ?>: <?php app_price(); ?>
			</td>
		</tr>
	</table>
</div>
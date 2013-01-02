<div class="appcontainer banner <?php storename_css(); ?>">
	<div style="width:auto; height:auto; position: relative !important;">
		<a href="<?php app_store_url(); ?>" title="<?php app_title(); ?>"><img src="<?php banner_image(); ?>" alt="<?php app_title(); ?>" class="appbanner" /></a>
		<div class="qrcode qrcode-banner"><img src="<?php qrcode_url(); ?>" alt="<?php app_title(); ?>" /></div>
	</div>
	<table class="appdetails">
		<tr>
			<td>
				<a href="<?php app_store_url(); ?>" title="<?php app_title(); ?>" class="apptitle"><?php app_title(); ?></a><br />
				<span class="developer">Entwickler: <a href="<?php author_store_url(); ?>" title="<?php app_author(); ?>" class="appauthor"><?php app_author(); ?></a></span><br />
				<span class="price">Preis: <?php app_price(); ?></td>
			</td>
			<td class="appbutton <?php storename_css(); ?>">
				<a href="<?php app_store_url(); ?>"  title="<?php app_title(); ?>">Download @<br /><?php storename(); ?></a>
			</td>
		</tr>
	</table>
</div>
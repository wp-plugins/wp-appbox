<div class="appcontainer simple <?php storename_css(); ?>">
	<a href="<?php app_store_url(); ?>" title="<?php app_title(); ?>"><img src="<?php banner_icon(); ?>" alt="<?php app_title(); ?>" class="appicon" /></a>
	<div class="qrcode qrcode-boxed"><img src="<?php qrcode_url(); ?>" alt="<?php app_title(); ?>" /></div>
	<a href="<?php app_store_url(); ?>"  title="<?php app_title(); ?>" class="appbutton <?php storename_css(); ?>">Download @<br /><?php storename(); ?></a>
	<div class="appdetails">
		<a href="<?php app_store_url(); ?>" title="<?php app_title(); ?>" class="apptitle"><?php app_title(); ?></a><br />
		<span class="developer">Entwickler: <a href="<?php author_store_url(); ?>" title="<?php app_author(); ?>" class="appauthor"><?php app_author(); ?></a></span><br />
		<span class="price">Preis: <?php app_price(); ?></span>
	</div>
</div>
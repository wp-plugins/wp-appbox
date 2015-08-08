<div class="wpappbox wpappbox-{APPIDHASH} simple {STORECSS}">
	{QRCODE}
	<div class="appicon">
		<a href="{APPLINK}" title="{TITLE}"><img src="{ICON}" />{WATCHICON}</a>
	</div>
	<div class="applinks">
		<div class="appbuttons">
			<a href="{APPLINK}" title="{TITLE}">{DOWNLOADCAPTION}</a>
			<span onMouseOver="jQuery('.wpappbox-{APPIDHASH} .qrcode').show();" onMouseOut="jQuery('.wpappbox-{APPIDHASH} .qrcode').hide();">QR-Code</span>
		</div>
	</div>
	<div class="appdetails">
		<div class="apptitle">{RELOADLINK}<a href="{APPLINK}" title="{TITLE}" class="apptitle">{TITLE}</a></div>
		<div class="developer"><?php _e('Developer', 'wp-appbox'); ?>: {DEVELOPERLINK}</div>
		<div class="price"><?php _e('Price', 'wp-appbox'); ?>: {PRICE} {RATING}</div>
	</div>
</div>
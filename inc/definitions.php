<?php 
$options = get_option('wpAppbox');

define("WPAPPBOX_PLUGIN_NAME", 'WP-Appbox'); 
define("WPAPPBOX_PLUGIN_VERSION", '1.0.1');

define("WPAPPBOX_PIC_CACHINGTIME", get_option("wpAppbox_piccache", $options['wpAppbox_piccachetime'])); 
define("WPAPPBOX_CONT_CACHINGTIME", get_option("wpAppbox_datacache", $options['wpAppbox_datacachetime']));  

define("PLUGIN_BASE_DIR", basename(dirname(dirname(__FILE__))));

define("WPAPPBOX_CONTENT_URL", WP_PLUGIN_URL."/".PLUGIN_BASE_DIR."/cache/"); // URL to Cache Folder (www.site.com/...)
define("WPAPPBOX_CONTENT_DIR", WP_PLUGIN_DIR."/".PLUGIN_BASE_DIR."/cache/"); // lokal Path to cache Folder (var/www/htdocs/...)
?>
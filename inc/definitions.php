<?php 
$options = get_option('wpAppbox');

define("WPAPPBOX_PLUGIN_NAME", 'WP-Appbox'); 
define("WPAPPBOX_PLUGIN_VERSION", '1.0.4');

define("WPAPPBOX_PIC_CACHINGTIME", $options['wpAppbox_piccachetime']); 
define("WPAPPBOX_DATA_CACHINGTIME", $options['wpAppbox_datacachetime']);  

define("WPAPPBOX_ERRROR_PARSEOUTPUT", $options['wpAppbox_error_parseoutput']); 

define("PLUGIN_BASE_DIR", basename(dirname(dirname(__FILE__))));

define("WPAPPBOX_CONTENT_URL", WP_PLUGIN_URL."/".PLUGIN_BASE_DIR."/cache/"); // URL to Cache Folder (www.site.com/...)
define("WPAPPBOX_CONTENT_DIR", WP_PLUGIN_DIR."/".PLUGIN_BASE_DIR."/cache/"); // lokal Path to cache Folder (var/www/htdocs/...)
?>
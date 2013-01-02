<?php 
$options = get_option('wpAppbox');
if($options['wpAppbox_datacachetime'] == '') $options['wpAppbox_datacachetime'] = '180';

define("WPAPPBOX_PLUGIN_NAME", 'WP-Appbox'); 
define("WPAPPBOX_PLUGIN_VERSION", '1.2.1');

define("WPAPPBOX_DATA_CACHINGTIME", $options['wpAppbox_datacachetime']);  

define("WPAPPBOX_ERRROR_PARSEOUTPUT", $options['wpAppbox_error_parseoutput']); 

define("PLUGIN_BASE_DIR", basename(dirname(dirname(__FILE__))));

define("WPAPPBOX_CACHE_PREFIX", 'wpAppbox_');
?>
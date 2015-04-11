<?php
	global $wpdb;
	
	if(!class_exists('WP_List_Table')) require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

	class Cached_Apps extends WP_List_Table {
		
		function cleanCache() {
			global $wpdb;
			$apps_timeouts = $wpdb->get_results("	SELECT 
														option_name 
													FROM 
														`$wpdb->options` 
													WHERE 
														(option_name LIKE '%_transient_timeout_wpAppbox_%')
														AND
														(option_value < ".time().")
													ORDER BY option_value");
			foreach($apps_timeouts as $key => $app) {
				$transient_id = str_replace('_transient_timeout_wpAppbox_', '', $app->option_name);
				$wpdb->query("DELETE FROM `$wpdb->options` WHERE option_name = '_transient_wpAppbox_".$transient_id."'");
				$wpdb->query("DELETE FROM `$wpdb->options` WHERE option_name = '_transient_timeout_wpAppbox_".$transient_id."'");
			}
		}
		
		function outputRating($rating) {
			if($rating == '') $rating = 0;
			$rating = str_replace(',', '.', $rating);
			$rating = number_format($rating, 2);
			$rating = round($rating, 1);
			if($rating <= 0.3) $rating_stars = 0;
			if($rating >= 0.4 && $rating <= 0.7) $rating_stars = 1;
			if($rating >= 0.8 && $rating <= 1.3) $rating_stars = 2;
			if($rating >= 1.4 && $rating <= 1.7) $rating_stars = 3;
			if($rating >= 1.8 && $rating <= 2.3) $rating_stars = 4;
			if($rating >= 2.4 && $rating <= 2.7) $rating_stars = 5;
			if($rating >= 2.8 && $rating <= 3.3) $rating_stars = 6;
			if($rating >= 3.4 && $rating <= 3.7) $rating_stars = 7;
			if($rating >= 3.8 && $rating <= 4.3) $rating_stars = 8;
			if($rating >= 4.4 && $rating <= 4.8) $rating_stars = 9;
			if($rating >= 4.9) $rating_stars = 10;
			return('<div style="width:65px; height:13px; background: url('.plugins_url('img/stars-sprites.png', dirname(__FILE__)).') no-repeat center center; background-position:0 -'.($rating_stars * 13).'px"></div>');
		}
		
		function fill_data($search) {
			global $wpdb;
			if($search != NULL){
				$search = trim($search);
				$apps_infos = $wpdb->get_results("SELECT option_id, option_name, option_value FROM `$wpdb->options` WHERE option_name LIKE '%_transient_wpAppbox_%' AND option_value LIKE '%_".$search."_%' ORDER BY option_name");
				$apps_timeouts = $wpdb->get_results("SELECT option_id, option_name, option_value FROM `$wpdb->options` WHERE option_name LIKE '%_transient_timeout_wpAppbox_%' ORDER BY option_name");
			}
			else {
				$apps_infos = $wpdb->get_results("SELECT option_id, option_name, option_value FROM `$wpdb->options` WHERE option_name LIKE '%_transient_wpAppbox_%' ORDER BY option_name");
				$apps_timeouts = $wpdb->get_results("SELECT option_id, option_name, option_value FROM `$wpdb->options` WHERE option_name LIKE '%_transient_timeout_wpAppbox_%' ORDER BY option_name");
			}
			$apps = array();
			foreach($apps_infos as $key => $app) {
				$option_name = str_replace('_transient_wpAppbox_', '', $app->option_name);
				$app = unserialize($app->option_value);
				$apps[$option_name] = array('app_title' => $app['General'][0]->app_title,
											'app_store' => $app['General'][0]->storename_css,
											'app_store_url' => $app['General'][0]->app_store_url,
											'app_price' => $app['General'][0]->app_price,
											'app_rating' => $app['General'][0]->app_rating,
											'app_icon_bg' => $app['General'][0]->icon_bg,
											'app_icon' => $app['General'][0]->app_icon,
											'app_transient_id' => $option_name,
											'app_timeout' => $apps_timeouts[$key]->option_value);
			}
			foreach($apps as $key => $row) {
				$app_title_lwrcs[$key] = strtolower($row['app_title']);
				$app_title[$key] = $row['app_title'];
				$app_rating[$key] = $row['app_rating'];
				$app_store[$key] = $row['app_store'];
				$app_price[$key] = $row['app_price'];
				$app_icon[$key] = $row['app_icon'];
				$app_icon_bg[$key] = $row['app_icon_bg'];
				$app_timeout[$key] = $row['app_timeout'];
			}
			$this->apps = $apps;
		}
		
		function __construct() {
			global $status, $page;
			parent::__construct(array(
				'singular' 	=> 'app',
			    'plural' 	=> 'apps',
			    'ajax' 		=> true        
			));
			$this->admin_header();
		}
		
		function admin_header() {
		  	$page = (isset($_GET['page'])) ? esc_attr($_GET['page']) : false;
		  	if('wp-appbox' != $page) return;
			echo '<style type="text/css">';
			echo '.wp-list-table .column-app_transient_id { width: 5%; }';
			echo '.wp-list-table .column-app_title { width: 60%; }';
			echo '.wp-list-table .column-app_icon { width: 52px; }';
			echo '.wp-list-table .column-app_store { width: 20%; }';
			echo '.wp-list-table .column-app_price { width: 15%; }';
			echo '.wp-list-table .column-app_rating { width: 111px; }';
			echo '.wp-list-table .column-app_timeout { width: 20%; }';
			echo '</style>';
		}
			
		function column_default($item, $column_name) {
			global $store_names;
			switch($column_name) { 
				case 'app_transient_id':
				case 'app_title':
				case 'app_price':
					return $item[$column_name];
				case 'app_rating':
					return $this->outputRating($item[$column_name]);
				case 'app_icon':
					if($item['app_store'] == 'windowsstore') return '<img src="'.$item[$column_name].'" style="'.$item['app_icon_bg'].' width:48px; height:48px;" />';
					return '<img src="'.$item[$column_name].'" style="width:48px; height:48px;" />';
				case 'app_store':
					if($item['app_store'] == 'googleplay apps') return '<img src="'.plugins_url('img/googleplay-small.png', dirname(__FILE__)).'" style="margin-right:8px; height:14px;" /> Google Play';
					return '<img src="'.plugins_url('img/'.(($item[$column_name] == 'macappstore') ? 'macappstore' : $item[$column_name]).'-small.png', dirname(__FILE__)).'" style="margin-right:8px; height:14px;" />'.(($item[$column_name] == 'macappstore') ? '(Mac) App Store' : $store_names[$item[$column_name]]);
				case 'app_timeout':
			    	return date_i18n('d.m. Y, H:i:s', $item[$column_name]);
			   	default:
			   		return print_r($item, true);
			}
		}
			
		function get_columns(){
			$columns = array(
				'cb'        	=> '<input type="checkbox" />',
				'app_icon'   	=> '',
				'app_title' 	=> __('Title', 'wpappbox'),
				'app_rating'   	=> __('Rating', 'wpappbox'),
				'app_price'   	=> __('Price', 'wpappbox'),
			    'app_store'  	=> __('Store', 'wpappbox'),
			    'app_timeout' 	=> __('Expiry', 'wpappbox')
			);
			return $columns;
		}
		
		function prepare_items() {
			global $apps;
			$actions = $this->get_bulk_actions();
			$this->process_bulk_action();
			if(isset($_POST['s'])) {
				$this->fill_data($_POST['s']);
			}
			else $this->fill_data(); 
			$columns = $this->get_columns();
			$hidden = array();
			$sortable = $this->get_sortable_columns();
			$this->_column_headers = array($columns, $hidden, $sortable);
			usort( $this->apps, array(&$this, 'usort_reorder'));
			$this->items = $this->apps;
			$per_page = 50;
			
			$user = get_current_user_id();
			$screen = get_current_screen();
			$screen_option = $screen->get_option('per_page', 'option');
			$per_page = get_user_meta($user, $screen_option, true);
			
			$current_page = $this->get_pagenum();
			$total_items = count($this->apps);
			$this->found_data = array_slice($this->apps, (($current_page-1)*$per_page), $per_page);
			$this->set_pagination_args(array(
				'total_items' => $total_items,
			    'per_page'    => $per_page
			));
			$this->items = $this->found_data;
		}
			
		function get_sortable_columns() {
			$sortable_columns = array(
				'app_transient_id'	=> array('app_transient_id', false),
				'app_title'			=> array('app_title', false),
				'app_store'   		=> array('app_store', false),
			    'app_timeout'   	=> array('app_timeout', false)
			);
			return $sortable_columns;
		}
			
		function usort_reorder($a, $b) {
			$orderby = (!empty( $_GET['orderby'])) ? $_GET['orderby'] : 'app_title';
			$order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc';
			$result = strcmp($a[$orderby], $b[$orderby]);
			return ($order === 'asc') ? $result : -$result;
		}
		
		function column_cb($item) {
			return sprintf('<input type="checkbox" name="app_transient_id[]" value="%s" />', $item['app_transient_id']);    
		  }
		
		function column_app_title($item) {
			if(isset($_GET['paged'])) $getparam .= '&paged='.$_GET['paged'];
			if(isset($_GET['orderby'])) $getparam .= '&orderby='.$_GET['orderby'];
			if(isset($_GET['order'])) $getparam .= '&order='.$_GET['order'];
		  	$actions = array(	'goto' => sprintf('<a href="'.$item['app_store_url'].'" target="_blank">'.__('Go to Store', 'wp-appbox').'</a>', $_REQUEST['page'], 'goto', $item['app_store_url']),
		  						'reload' => sprintf('<a href="?page=%s&action=%s&tab=cache'.$getparam.'&app_transient_id=%s">'.__('Renew cache', 'wp-appbox').'</a>', $_REQUEST['page'], 'reload', $item['app_transient_id']),
		  						'delete' => sprintf('<a href="?page=%s&action=%s&tab=cache'.$getparam.'&app_transient_id=%s">'.__('Delete', 'wp-appbox').'</a>', $_REQUEST['page'], 'delete', $item['app_transient_id'])
		  					);
		  	return sprintf('%1$s %2$s', $item['app_title'], $this->row_actions($actions));
		}
		
		function get_bulk_actions() {
		  	$actions = array('reload' => __('Renew cache', 'wp-appbox'), 'delete' => __('Delete', 'wp-appbox'));
		  	return $actions;
		}
		
		function process_bulk_action() {
			global $wpdb;
			$app_transient_ids = isset($_REQUEST['app_transient_id']) ? $_REQUEST['app_transient_id'] : array();
			if(is_array($app_transient_ids)) $app_transient_ids = implode(',', $app_transient_ids);
			$app_transient_ids = explode(',', $app_transient_ids);
			if(!empty($app_transient_ids)) {
				if('delete' === $this->current_action()) {
					foreach($app_transient_ids as $id) {
						$wpdb->query("DELETE FROM `$wpdb->options` WHERE option_name = '_transient_wpAppbox_".$id."'");
						$wpdb->query("DELETE FROM `$wpdb->options` WHERE option_name = '_transient_timeout_wpAppbox_".$id."'");
					}
				}
				if('reload' === $this->current_action()) {
					foreach($app_transient_ids as $id) {
						$app_data = get_transient(WPAPPBOX_CACHE_PREFIX.$id);
						$app_id = $app_data['General'][0]->app_id;
						$app_store = ($app_data['General'][0]->storename_css == 'macappstore') ? 'appstore' : $app_data['General'][0]->storename_css;
						$app_data = CreateOutput::getTheData($app_store, $app_id);
					}
				}
			}
		}
		
		function extra_tablenav($which) {
			if($which == "top") {
			?>
			   	<div class="alignleft actions bulkactions">
				   	<label class="screen-reader-text" for="search_id-search-input"><?php _e('Search', 'wp-appbox') ?>:</label> 
				   	<input id="search_id-search-input" type="text" name="s" value="<?php echo $_POST['s']; ?>" /> 
				   	<input id="search-submit" class="button" type="submit" name="" value="<?php _e('Search', 'wp-appbox') ?>" />
				   	<?php if(isset($_POST['s'])) { ?>
				   		<a href="/wp-admin/options-general.php?page=wp-appbox&tab=cache" class="button"><?php _e('Clear search', 'wp-appbox') ?></a>
				   	<?php } ?>
			   	</div>
		   	<?php
		   	}
		   	if($which == "bottom") {
		   	}
		}
		
		function no_items() {
		if(isset($_POST['s'])) $theecho = __('No apps in WordPress-cache were found with this term.', 'wp-appbox').'<a href="/wp-admin/options-general.php?page=wp-appbox&tab=cache">'.__('Clear search', 'wp-appbox').'</a>';
		else $theecho = __('There are no apps in the WordPress-Cache.', 'wp-appbox');
		echo $theecho;
		}
			
	} //class
			
	function wpAppbox_RenderCachedAppsList() {
		$myListTable = new Cached_Apps();
		$myListTable->cleanCache(); 
		$myListTable->prepare_items(); 
		?>
  		<form method="post">
   	 	<input type="hidden" name="page" value="wp-appbox" />
    	<?php
		$myListTable->display(); 
		add_action('wp-appbox', 'custom_bulk_actions');
  		echo '</form><small>'.__('Your time', 'wp-appbox').': '.date_i18n('d.m. Y, H:i:s').'</small><br /><small>'.__('Servertime', 'wp-appbox').': '.Date('d.m. Y, H:i:s').'</small>';
	}
	
	wpAppbox_RenderCachedAppsList();
			
?>
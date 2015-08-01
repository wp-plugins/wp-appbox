<?php
	error_reporting(0);
	
	class CreateAttributs {
	
		function isValueStyle($value) {
			global $style_names_global;
			if(array_search($value, $style_names_global) != '') return(true);
			else return(false);
		}
		
		function isValueStore($value) {
			global $store_names;
			if($value == 'androidpit') $value = 'googleplay';
			if($value == 'windowsphone') $value = 'windowsstore';
			if(array_key_exists($value, $store_names)) return(true);
			else return(false);
		}
		
		function isValueNoQRCode($value) {
			if($value == 'noqrcode') return(true);
			else return(false);
		}
		
		function isValueAppBundle($value) {
			if($value == 'bundle') return(true);
			else return(false);
		}
		
		function getStandardStyle($store) {
			global $style_names_global;
			$options = get_option('wpAppbox');
			if($options['wpAppbox_view_'.$store] == '0') return($style_names_global[$options['wpAppbox_view_default']]);
			else return($style_names_global[$options['wpAppbox_view_'.$store]]);
		}
		
		function checkStyle($store, $style) {
			global $style_names_global, $style_names_appstores;
			if(is_feed()) return('feed');
			$style_id = $key = array_search($style, $style_names_global);
			if(in_array($style_id, $style_names_appstores[$store])) return($style);
			else return($this->getStandardStyle($store));
		}

		function devideAttributs($attribute) {
			$options = get_option('wpAppbox');
			$attr =	array(	'store' => '',
							'style' => '',
							'appid' => '',
							'bundle' => false,
							'showqrcode' => true,
							'oldprice' => '',
							'nofollow' => $options['wpAppbox_nofollow'],
							'targetblank' => $options['wpAppbox_blank']
							);
			extract(shortcode_atts(array('alterpreis' => '',  'oldprice' => ''), $attribute));
			if(($alterpreis) || ($oldprice)) $attr['oldprice'] = $alterpreis.$oldprice;
			if(is_array($attribute)) {
				foreach ($attribute as $value) {
					if($this->isValueAppBundle($value)) $attr['bundle'] = true;
					elseif($this->isValueStyle($value)) $attr['style'] = $value;
					elseif($this->isValueStore($value)) $attr['store'] = $value;
					elseif($attr['oldprice'] != $value) $attr['appid'] = $value;
				}
			}
			if(($attr['store'] != '') && ($attr['style'] == '')) $attr['style'] = $this->checkStyle($attr['store'], $this->getStandardStyle($attr['store']));
			$attr['appid'] = str_replace('/>', '', $attr['appid']);
			return($attr);
		}
	
	}

?>
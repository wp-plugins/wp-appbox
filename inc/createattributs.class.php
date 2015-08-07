<?php
	error_reporting(0);
	
	class CreateAttributs {
	
		function isValueStyle($value) {
			global $wpAppbox_styleNames;
			if(array_search($value, $wpAppbox_styleNames) != '') return(true);
			else return(false);
		}
		
		function isValueStore($value) {
			global $wpAppbox_storeNames;
			if($value == 'androidpit') $value = 'googleplay';
			if($value == 'windowsphone') $value = 'windowsstore';
			if(array_key_exists($value, $wpAppbox_storeNames)) return(true);
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
		
		function getStandardStyle($storeID) {
			global $wpAppbox_styleNames;
			if(get_option('wpAppbox_defaultStyle_'.$storeID) == '0') return($wpAppbox_styleNames[get_option('wpAppbox_defaultStyle')]);
			else return($wpAppbox_styleNames[get_option('wpAppbox_defaultStyle_'.$store)]);
		}
		
		function checkStyle($store, $style) {
			global $wpAppbox_styleNames, $wpAppbox_storeStyles;
			if(is_feed()) return('feed');
			$style_id = $key = array_search($style, $wpAppbox_styleNames);
			if(in_array($style_id, $wpAppbox_storeStyles[$store])) return($style);
			else return($this->getStandardStyle($store));
		}

		function devideAttributs($attribute) {
			$attr =	array(	'store' => '',
							'style' => '',
							'appid' => '',
							'bundle' => false,
							'showqrcode' => true,
							'oldprice' => '',
							'nofollow' => get_option('wpAppbox_nofollow'),
							'targetblank' => get_option('wpAppbox_targetBlank')
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
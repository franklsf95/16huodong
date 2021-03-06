<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class BaseModel extends CI_Model {
    var $tableName = '';
	var $enable_staging = false;
	var $model_fields;
	
    function __construct() {
		parent::__construct();
		
		$this->enable_staging = $this->config->item('enable_staging') == 'Y';

		if ($this->tableName != '') {
			$this->model_fields = $this->db->list_fields($this->tableName);
		}
    }    					

	function _processParams(&$information) {
		$information['params'] = array();
		if (array_key_exists('attribs', $information)) {
			
			if (strlen($information['attribs']) > 2 && substr($information['attribs'], 0, 2) == "a:") {
				$information['params'] = unserialize($information['attribs']);
			} else {
				$attribs = $information['attribs'];
				$params = explode("\n", $attribs);
				foreach ($params as $param) {
					$pos = strpos($param, "=");
					if ($pos === false) {
					} else {
						$param_key = substr($param, 0, $pos);
						$param_value = substr($param, $pos + 1);
						$information['params'][$param_key] = $param_value;
					}
				}
			}
		}
	}

	function filterLanguage(&$result){
		$dbprefix = $this->config->item('dbprefix');
		$prefixs = array();
		foreach ($this->avaliable_backend_languages as $lang) {
			$prefixs[$lang] = array();
		}
		
		if ($result) {
			$table_fields = array_keys($result);
			
			foreach ($table_fields as $field) {
				foreach ($this->avaliable_backend_languages as $lang) {
					if (preg_match("/_${lang}$/", $field)) {
						$prefixs[$lang][] = preg_replace("/_${lang}$/", '', $field);
					}
				}
			}
	
			if (array_key_exists($this->current_language, $prefixs)) {
				foreach($prefixs[$this->current_language] as $prefix){
					$result[$prefix.'_curlang'] = $result[$prefix.'_' . $this->current_language];
				}
			}
		}
		return $result;
	}

	function filterLanguageList(&$results){
		$dbprefix = $this->config->item('dbprefix');
		$prefixs = array();
		foreach ($this->avaliable_backend_languages as $lang) {
			$prefixs[$lang] = array();
		}
		
		if(count($results) > 0 && is_array($results[0])){
			$table_fields = array_keys($results[0]);
			
			foreach ($table_fields as $field) {
				foreach ($this->avaliable_backend_languages as $lang) {
					if (preg_match("/_${lang}$/", $field)) {
						$prefixs[$lang][] = preg_replace("/_${lang}$/", '', $field);
					}
				}
			}
	
			foreach ($results as $key=>$item) {
				if (array_key_exists($this->current_language, $prefixs)) {
					foreach($prefixs[$this->current_language] as $prefix){
						$results[$key][$prefix.'_curlang'] = $item[$prefix.'_' . $this->current_language];
					}
				}
			}
		}
		return $results;
	}
	
	function getFieldByArray($array = array(), $field){
		$fields = array();
		if (is_array($array)){
			foreach ($array as $vo) {
				$fields[] = $vo[$field]; 
			}
		}
		return $fields;
	}


}
?>
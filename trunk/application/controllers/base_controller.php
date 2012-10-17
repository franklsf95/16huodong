<?php

class BaseController extends CI_Controller {

	var $enable_session = true;
	var $viewFolder = '';
	var $layoutFolder = '';
	var $applicationFolder = '';
	var $layout = 'default';
	var $all_avaliable_language = array();
	var $current_language = 'chs';
	var $current_time = '';
	var $current_date = '';
	var $site_name;
	var $site_keyword;
	var $site_description;
	
	
	function __construct() {
		parent::__construct();
		
		$this->getSiteInformation();
		
		if ($this->enable_session) {		//启用session
			@session_start();
		}
		
		$this->current_time = date('Y-m-d H:i:s');
		$this->current_date = date('Y-m-d');
		
		//设定语言相关变量
		$this->all_avaliable_language = $this->config->item('all_avaliable_language');
		$this->current_language = $this->config->item('language');
		

		$this->ci_smarty->assign('current_language',$this->current_language);
		$this->ci_smarty->assign('all_avaliable_language',$this->all_avaliable_language);
		
		
		//修改smarty函数
		$this->ci_smarty->registerPlugin('modifier','site_url', 'site_url');			//启用链接功能
		$this->ci_smarty->registerPlugin('modifier','base_url', 'base_url');			//启用链接功能
		$this->ci_smarty->registerPlugin('modifier','strtotime', 'strtotime');			//启用链接功能
		
		$this->lang->load('global');			//读取语言文件
		$this->lang->load('alert');			//读取语言文件
		$this->ci_smarty->registerPlugin('modifier','lang_line', array($this->lang, 'line'));	//启用语言模版
		
		
		//修改输出模版路径
		
		$this->viewFolder = $this->config->item('template');
		$this->layoutFolder = $this->config->item('template').'/layout/';
		
		if ($this->applicationFolder) {
			$this->viewFolder = $this->viewFolder.'/'.$this->applicationFolder;
		}
		
		$this->ci_smarty->assign('template',$this->config->item('template'));
		
	}
	
	function getSiteInformation(){
		$all_running_value_information = $this->db->get('running_value')->result_array();
		
		foreach($all_running_value_information as $vo) {
			$site_information[$vo['code']] = $vo['value'];
		}
		
		$this->site_name = $site_information['site_name'];
		$this->site_keyword = $site_information['site_keyword'];
		$this->site_description = $site_information['site_description'];
		$this->ci_smarty->assign('site_name',$site_information['site_name']);
		$this->ci_smarty->assign('site_keyword',$site_information['site_keyword']);
		$this->ci_smarty->assign('site_description',$site_information['site_description']);
	}
	
	function getParameter($parameterName, $defaultValue = '', $useDefaultValueIfEmpty = true, $xss_clean = FALSE) {			//获取post或get变量
		$value = $this->input->get_post($parameterName);
		if ($value === FALSE) {
			return $defaultValue;
		} else {
			if ($value == '' && $useDefaultValueIfEmpty) {
				return $defaultValue;
			} else {
				return $value;
			}
		}
	}
	
	function getParameterInt($parameterName, $defaultValue = 0, $useDefaultValueIfEmpty = true) {				//获取Int变量
		$value = $this->input->get_post($parameterName);
		if ($value === FALSE) {
			return $defaultValue;
		} else {
			if ($value == '' && $useDefaultValueIfEmpty) {
				return $defaultValue;
			} else {
				if (is_numeric($value)) {
					return $value;
				} else {
					return $defaultValue;
				}
			}
		}
	}
	
	function getParameterWithOutTag($parameterName, $defaultValue = '', $useDefaultValueIfEmpty = true, $xss_clean = FALSE) {			//获取post或get变量
		$value = htmlspecialchars($this->input->get_post($parameterName),ENT_QUOTES);
		if ($value === FALSE) {
			return $defaultValue;
		} else {
			if ($value == '' && $useDefaultValueIfEmpty) {
				return $defaultValue;
			} else {
				return $value;
			}
		}
	}
	
	
	function getSessionValue($parameterName, $defaultValue = '', $useDefaultValueIfEmpty = true) {						//获取session值
		if (isset($_SESSION)) {
			if (array_key_exists($parameterName, $_SESSION)) {
				if ($_SESSION[$parameterName] == '' && $useDefaultValueIfEmpty) {
					return $defaultValue;
				}
				return $_SESSION[$parameterName];
			} else {
				return $defaultValue;
			}
		} else {
			return $defaultValue;
		}
	}
	
	function setSessionValue($parameterName, $value = '') {				//设置session值
		$_SESSION[$parameterName] = $value;
	}
	
	function unsetSessionValue($parameterName) {					//注销session值
		unset($_SESSION[$parameterName]);
	}
	
	function displayWithLayout($templateName, $layout = '') {			//打开模版（包括公共界面layout）
	
		if (!$layout) {
			$layout = $this->layout;
		}
		if ($this->viewFolder != '') {
			$this->ci_smarty->assign('sidebar', $this->viewFolder . '/sidebar');
			$this->ci_smarty->assign('template_content', $this->viewFolder . '/' . $templateName);
		} else {
			$this->ci_smarty->assign('template_content', $templateName);
		}
		if ($this->layoutFolder) {
			$this->ci_smarty->view($this->layoutFolder . $layout);
			
		} else {
			$this->ci_smarty->view('layout/' . $layout);
		}
	}
	
	function displayWithoutLayout($templateName) {					//打开模版
		if ($this->viewFolder != '') {
			$this->ci_smarty->view($this->viewFolder . '/' . $templateName);
		} else {
			$this->ci_smarty->view($templateName);
		}
	}
	
	
	function filterLanguage(&$result){					//多语言单层筛选
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

	function filterLanguageList(&$results){					//多语言多层数组筛选
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
	
	function simpleCreatePageInformation($count, $limit){
		$page_information = array();
		
		$page_information['limit'] = $limit;
		$page_information['first_page'] = 1;
		$page_information['last_page'] = (int)ceil($count / $limit);
		$page_information['page_count'] = $count / $limit;
		

		for ($i = 0; $i < $page_information['page_count']; $i++) {
			$page_information['all_pages'][] = $i + 1;
		}
		
		return $page_information;
	}
	
	
	
	function &createPageInformation($count, $page, $limit, $excluding_query_parts = null) {						//分页函数
		$page_information = array();
		
		$internal_page = $page - 1;
		$page_offset = $internal_page * $limit;
		if ($page_offset < 0) {
			$internal_page = 0;
			$page_offset = 0;
		}
		if ($page_offset > $count) {
			$internal_page = (int)($count / $limit);
			$page_offset = $count - $count % $limit;
		}
		
		$page_information['count'] = $count;
		$page_information['page'] = $page;
		$page_information['limit'] = $limit;
		$page_information['rearrange'] = $limit;
		$page_information['internal_page'] = $internal_page;
		$page_information['page_offset'] = $page_offset;
		
		$page_information['current_page'] = $internal_page + 1;
		$page_information['first_page'] = 1;
		$page_information['previous_page'] = $internal_page - 1 + 1;
		$page_information['next_page'] = $internal_page + 1 + 1;
		$page_information['last_page'] = (int)ceil($count / $limit);
		$page_information['page_count'] = $count / $limit;
		
		$page_information['all_pages'] = array();
		if ($page_information['page_count'] <= 10) {
			for ($i = 0; $i < $page_information['page_count']; $i++) {
				$page_information['all_pages'][] = $i + 1;
			}
		} else {
			$page_length_1 = $internal_page;
			$page_length_2 = $page_information['page_count'] - $internal_page;
		
			$page_count_1 = 0;
			$page_count_2 = 0;
		
			if ($page_length_1 < 5) {
				$page_count_1 = $internal_page;
				$page_count_2 = 10 - $page_count_1 - 1; 
			} else if ($page_length_2 < 4) {
				$page_count_2 = $page_length_2; 
				$page_count_1 = 10 - $page_count_2 - 1; 
			} else {
				$page_count_1 = 5;
				$page_count_2 = 4;
			}
		
			for ($i = $internal_page; $i >= $internal_page - $page_count_1; $i--) {
				$page_information['all_pages'][] = $i + 1;
			}
			for ($i = $internal_page + 1; $i <= $internal_page + $page_count_2; $i++) {
				$page_information['all_pages'][] = $i + 1;
			}
			sort($page_information['all_pages']);
			reset($page_information['all_pages']);
		}


		$p_page = $this->getParameterInt('page', 1);
		$p_sort = $this->getParameter('sort', '');
        $p_order = $this->getParameter('order', '');

		// For searching and paging
        $original_gets = $_GET;
		$query_parts = array();
        foreach ($original_gets as $key => $value) {
			$keep = true;
            if ($key == "sort" || $key == "order" || $key == "page") {
				$keep = false;
			} else if (isset($excluding_query_parts) && is_array($excluding_query_parts)) {
		        foreach ($excluding_query_parts as $excluding_query_part) {
		            if ($excluding_query_part == $key) {
						$keep = false;
						break;
					}
				}
			}
			if ($keep) {
				if (is_array($value)) {
					foreach ($value as $array_key => $array_value) {
						if (is_array($array_value)) {
						} else {
							$query_parts[] = urlencode($key . '[' . $array_key . ']') . "=" . urlencode($array_value);
						}
					}
				} else {
					$query_parts[] = urlencode($key) . "=" . urlencode($value);
				}
			}
        }

        $page_information['query_string_filter'] = join("&", $query_parts);
        $page_information['query_string_paging'] = join("&", array(
            $page_information['query_string_filter'],
            "sort=" . urlencode($p_sort),
            "order=" . urlencode($p_order)
        ));
        $page_information['query_string_sort'] = join("&", array(
            $page_information['query_string_filter'],
            "page=" . urlencode($p_page),
        ));

		
		return $page_information;
	}
	
	function _setAdditionalQueryString(&$param) {
	}
	
	function getAdditionalQueryString($param = NULL) {
		if ($param == NULL) {
			$param = array();
		}
		$this->_setAdditionalQueryString($param);
		$query_string = '';
		if (count($param) > 0) {
			$query_string_parts = array();
			foreach ($param as $key => $value) {
				if ($value) {
					if (is_array($value)) {
						foreach ($value as $sub_key => $sub_value) {
							$query_string_parts[] = $key . "[$sub_key]=" . $sub_value;
						}
					} else {
						$query_string_parts[] = $key . '=' . $value;
					}
				}
			}
			$query_string = '?' . join('&', $query_string_parts);
		}
		return $query_string;
	}
	
	function forward($templateName, $param = NULL) {
		if ($this->applicationFolder != '') {
			redirect($this->applicationFolder . '/' . $templateName . $this->getAdditionalQueryString($param));
		} else {
			$controller_name = strtolower(get_class($this));
			redirect($controller_name . '/' . $templateName . $this->getAdditionalQueryString($param));
		}
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
	
	
	function _saveItem($isNew, &$id, &$param) {
	
	}

	function save_form() {
		$isNew = true;
		$p_id = $this->getParameter('cid', 0);
		if ($p_id != 0) {
			$isNew = false;
		}
		$param = null;
		$error_message = $this->_saveItem($isNew, $p_id, $param);
		if ($error_message) {
			$this->displayError($error_message);
		} else {
			$this->forward('index', $param);
		}
	}
	
	function getImageUrl($url){
		if (preg_match("/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/ ",$url)){
			$return_url['relative_path'] = $this->get_file($url);
			$return_url['absolute_path'] = "http://" . $_SERVER['HTTP_HOST'].$return_url['relative_path'];
			return $return_url;
		}elseif (preg_match("/^(\/upload\/){1}([a-z0-9_-])*(\/image\/){1}([0-9]){8}(\/)([0-9_]){20}(\.)([a-zA-Z])*$/",$url)) {
			$return_url['relative_path'] = $url;
			$return_url['absolute_path'] = "http://" . $_SERVER['HTTP_HOST'].$url;
			return $return_url;
		}elseif (preg_match("/^(\/application\/views\/){1}([a-z0-9_-])*(\/images\/blog\/default_album.jpg){1}$/",$url)){
			$return_url['relative_path'] = $url;
			$return_url['absolute_path'] = "http://" . $_SERVER['HTTP_HOST'].$url;
			return $return_url;
		}else {
			return false;
		}
	}
	
	function get_file($url){
		set_time_limit (24 * 60 * 60);
		$php_path = dirname(__FILE__) . '/';
		$php_url = dirname($_SERVER['PHP_SELF']) . '/';
		$member_account = $_SESSION['current_member_information']['account'];
		//文件保存目录路径
		$save_path = $php_path . '../../upload/'.$member_account.'/';
		//文件保存目录URL
		$save_url = $php_url . '../../upload/'.$member_account.'/image/'.date("Ymd").'/';
		if (!is_dir($save_path)){
			mkdir($save_path);
		}
		$save_path .= 'image/';
		if (!is_dir($save_path)){
			mkdir($save_path);
		}
		$save_path .= date("Ymd").'/';
		if (!is_dir($save_path)){
			mkdir($save_path);
		}
		
		$file = fopen ($url, "rb");
		if ($file){
			//获得文件扩展名
			$temp_arr = explode(".", $url);
			$file_ext = array_pop($temp_arr);
			$file_ext = trim($file_ext);
			$file_ext = strtolower($file_ext);
			//检查扩展名
			if (!in_array($file_ext, array('jpg','gif','png'))){
				show_error('文件不合法');
			}else{
				
				//新文件名
				$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
				$newf = fopen ($save_path.$new_file_name, "wb");
				if ($newf) {
					while(!feof($file)) {
						fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
					}
				}
			}
			
			if ($file) {
				fclose($file);
			}
			
			if ($newf) {
				fclose($newf);
			}
			return preg_replace('/(\/index\.php\/[a-zA-Z0-9_]+\/\.\.\/\.\.)/','',$save_url.$new_file_name);
		}
	}
	
	
	

}


?>
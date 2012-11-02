<?php

class BaseController extends CI_Controller {

	var $enable_session = true;
	var $viewFolder = '';
	var $layoutFolder = '';
	var $commonFolder = '';
	var $applicationFolder = '';
	var $layout = 'default';
	var $all_avaliable_language = array();
	var $current_language = 'chs';
	var $current_time = '';
	var $current_date = '';
	var $site_name;
	var $site_keyword;
	var $site_description;
	var $LIMIT = 2;
	var $CLIMIT = 10;	//单页评论加载数量
	var $MLIMIT = 50; 	//单页留言加载数量
	
	
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
		
		
		//注册smarty模板可调用的函数
		$this->ci_smarty->registerPlugin('modifier','site_url', 'site_url');
		$this->ci_smarty->registerPlugin('modifier','base_url', 'base_url');
		$this->ci_smarty->registerPlugin('modifier','strtotime', 'strtotime');
		
		$this->lang->load('global');			//读取语言文件
		$this->lang->load('alert');			//读取语言文件
		$this->ci_smarty->registerPlugin('modifier','lang_line', array($this->lang, 'line'));	//启用语言模版
		
		//Smarty模板路径
		$this->layoutFolder = 'layout/';
		$this->commonFolder = 'common/';
		
		if ($this->applicationFolder) {
			$this->viewFolder = $this->applicationFolder;
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
	
	/**
	* 给会员显示页面，包含layout侧栏
	*
	* @deprecated
	*/
	function displayWithLayout($templateName, $layout = '') {
	
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
	
	/**
	* 显示页面
	*
	* @author franklsf95
	*
	* @param	string	$templateName	要打开的模板
	* @param	string	$templateTitle	显示的页面标题
	* @param	string	$moreCss		附加在头部的css段（若有）
	* @param	string	$moreJs			附加在body的script段（若有）
	* @param	string	$baseTemplate	公用模板版本（游客guest，会员member）
	*/
	function display( $templateName, $templateTitle, $moreCss='', $moreJs='', $baseTemplate = 'guest' ) {
		$this->ci_smarty->assign('template_content', $templateName);
		$this->ci_smarty->assign('template_title', $templateTitle);
		$this->ci_smarty->assign('more_css', $moreCss);
		$this->ci_smarty->assign('more_js', $moreJs);
		$this->ci_smarty->assign('base_tpl', $this->commonFolder . $baseTemplate);
		//check if $this has custom viewFolder ( defined as applicationFolder in BaseController::__construct() )
		$this->ci_smarty->assign('view_folder', $this->viewFolder);

		$this->ci_smarty->view($this->commonFolder . 'base_template');
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
	
	/**
	* 创建分页信息并赋给smarty
	*
	* @param 	int 	$count 	条目总数
	* @param 	int 	$page 	当前页面
	* @param 	int 	$limit 	每页条目数
	* @param 	string 	$url 	主URL 	ajax控制则可留空
	*
	* @author 	franklsf95
	*
	* @return 	smarty 	array 	$page_information
	*/
	function &setPageInformation( $count, $page, $limit, $url='' ) {
		$page_information = array();

		$page_count = ceil( $count / $this->LIMIT );
		$page_offset = ($page-1) * $this->LIMIT;
		if( $page_offset < 0 ) 	$page_offset = 0;
		elseif( $page_offset > $count )	$page_offset = $page_count;

		$page_information['count'] = $count;
		$page_information['page'] = $page;
		$page_information['page_offset'] = $page_offset;
		$page_information['url'] = site_url($url);
		$page_information['first_page'] = 1;
		$page_information['previous_page'] = $page - 1;
		$page_information['next_page'] = $page + 1;
		$page_information['last_page'] = $page_count;
		$page_information['page_count'] = $page_count;

		$start = ($page>5) ? $page-5 : 1;
		$end = ($page+5 < $page_count) ? $page+5 : $page_count;

		$page_information['all_pages'] = range( $start, $end );

		//处理已经提交的get数据，继续放入get请求
		$get_data = $this->input->get();
		$get_string = '';
		if( !empty($get_data) ) {
			foreach( $get_data as $key => $value ) {
				if( $key != 'page' )
					$get_string .= ('&'.$key.'='.$value);
			}
		}
		$page_information['get_string'] = $get_string;

        //print_r($page_information);exit();
        $this->ci_smarty->assign('page_information',$page_information);
        return $page_information;
	}
	
	/**
	* @deprecated
	*/
	function getAdditionalQueryString($param = NULL) {
		return $param;
	}
	
	/**
	* @deprecated
	*/
	function forward($templateName, $param = NULL) {
		redirect($this->applicationFolder . '/' . $templateName);
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
		}elseif (preg_match("/^\/asset\/img\/default\/book_cover\.jpg$/",$url)){
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
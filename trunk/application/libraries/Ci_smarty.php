<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once BASEPATH . "../inc/Smarty/Smarty.class.php";

/**
* @file system/application/libraries/CI_Smarty.php
*/
class CI_Smarty extends Smarty
{
	function CI_Smarty()
	{
		parent::__construct();

		$config =& get_config();
		
		// absolute path prevents "template not found" errors
		$this->template_dir = (!empty($config['smarty_template_dir']) ? $config['smarty_template_dir'] 
																	  : APPPATH . 'views/');
																	
		$this->compile_dir  = (!empty($config['smarty_compile_dir']) ? $config['compile_dir'] 
																	 : BASEPATH . 'cache/'); //use CI's cache folder        

		if (!empty($config['smarty_left_delimiter'])) {
			$this->left_delimiter = $config['smarty_left_delimiter'];
		}
		if (!empty($config['smarty_right_delimiter'])) {
			$this->right_delimiter = $config['smarty_right_delimiter'];
		}

		$this->assign("BASEPATH", BASEPATH);
		$this->assign("APPPATH", APPPATH);
		$this->assign("config", $config);
		$this->assign("server_information", $_SERVER);

		if (function_exists('site_url')) {
    		// URL helper required
			$this->assign("site_url", site_url()); // so we can get the full path to CI easily
		}
		
	}
	
	function view($resource_name, $cache_id = null)   {
		if (strpos($resource_name, '.tpl') === false) {
			$resource_name .= '.tpl';
		}
		return parent::display($resource_name, $cache_id);
	}
	
	
	
} // END class smarty_library
?>
<?php
include_once "base_action_controller.php";
/**
* 纯测试用
*/
Class Test Extends BaseActionController {

	var $applicationFolder = "test"; 
	
	function __construct() {
		parent::__construct();
		
	}

	function index(){
		$activity_id['code']=1;
		print_r(  site_url("activity/view?id=$activity_id[\'code\']")  );exit();
		$this->ci_smarty->view( $this->config->item('template').'/library/view_js' );
	}
	
	
}



?>
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
		$this->ci_smarty->view( $this->config->item('template').'/library/view_js' );
	}
	
	
}



?>
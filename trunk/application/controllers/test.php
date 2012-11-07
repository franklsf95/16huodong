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
		echo idx( $this->extend_control->getBookBasicById(3), 'book_name');
	}
	
	
}



?>
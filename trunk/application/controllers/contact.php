<?php
include_once "base_controller.php";
/**
* 给未登录用户显示contact
*/
Class Contact Extends BaseController {

	var $applicationFolder = "contact"; 
	
	function __construct() {
		parent::__construct();
		
	}
	
	function index(){
		$this->display('index','关于我们');
	}
}



?>
<?php
include_once "base_controller.php";
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
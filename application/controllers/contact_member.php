<?php
include_once "base_action_controller.php";
Class Contact_member Extends BaseActionController {

	var $applicationFolder = "contact"; 
	
	function __construct() {
		parent::__construct();
		
	}
	
	function index(){
		$this->display('index','关于我们');
	}
}



?>
<?php
include_once "base_action_controller.php";
Class Test Extends BaseActionController {

	var $applicationFolder = "test"; 
	
	function __construct() {
		parent::__construct();
		
	}
	//此模块用于测试
	function index(){
		
		$new_system_message = $this->extend_control->getNewSystemMessage($this->current_member_id);			//新的系统消息数
		
		
	}
	
	
}



?>
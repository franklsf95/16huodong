<?php
include_once "base_action_controller.php";
/**
* 处理各种搜索请求，返回搜索结果
*/
Class Search Extends BaseActionController {

	var $applicationFolder = "search"; 
	
	function __construct() {
		parent::__construct();
		
	}
	
	function index(){
		redirect("activity");
	}
}



?>
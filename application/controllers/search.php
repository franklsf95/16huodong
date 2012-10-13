<?php
include_once "base_action_controller.php";
Class Search Extends BaseactionController {

	var $applicationFolder = "search"; 
	
	function __construct() {
		parent::__construct();
		
	}
	
	function index(){
		$member_id = $this->getParameter('member_id',$this->current_member_information['member_id']);
		
		$all_hot_activity_tag_information = $this->extend_control->getHotActivityTag(0,10);
		
		//print_r($all_hot_activity_tag_information);
		
		$this->ci_smarty->assign('all_hot_activity_tag_information',$all_hot_activity_tag_information);
		$this->displayWithLayout('index');
	}
	
	function school(){
		$school_id = $this->getParameter('school_id',$this->current_member_information['current_school']);
		$all_hot_activity_tag_information = $this->extend_control->getHotActivityTag(0,10);
		
		
		$this->ci_smarty->assign('all_hot_activity_tag_information',$all_hot_activity_tag_information);
		$this->ci_smarty->assign('school_id',$school_id);
		$this->displayWithLayout('school');
	}
	

	
	
	
	
	
}



?>
<?php
include_once "base_action_controller.php";
Class System_message Extends BaseActionController {

	var $applicationFolder = "system_message"; 
	
	function __construct() {
		parent::__construct();
		
	}
	
	function index(){
		$member_id = $this->current_member_id;
		
		//get_activity_system_message
		
		
		$p_page = $this->getParameter('page',1);
		$p_limit = $this->getParameter('limit',10);
		$acitvity_system_message_count = $this->extend_control->countMemberActivitySystemMessage($member_id);
		$page_information = $this->createPageInformation($acitvity_system_message_count, $p_page, $p_limit);
		
		$all_activity_system_information = $this->extend_control->getMemberActivitySystemMessageInformation($member_id,null,$page_information['page_offset'],$p_limit);
		
		$all_member_system_information = $this->extend_control->getMemberSystemMessageInformation($member_id,null);
		
		//print_r($all_member_system_information);
		
		/*
		$type = $this->getParameter('type',NULL);
		$this->db->select('sm.member_id, re_m.name as member_name, sm.target_id, sm.type, sm.code, sm.created_time');
		$this->db->from('system_message as sm');
		$this->db->join('member as m','m.member_id = sm.target_id');
		$this->db->join('member as re_m','re_m.member_id = sm.member_id');
		if ($type != ''){
			$this->db->where('type',$type);
		}
		$this->db->where('sm.target_id',$member_id);
		$all_system_message = $this->db->get()->result_array();
		*/
		
		
		
		$this->ci_smarty->assign('page_information',$page_information);
		$this->ci_smarty->assign('all_activity_system_information',$all_activity_system_information);
		$this->ci_smarty->assign('all_member_system_information',$all_member_system_information);
		
		$this->displayWithLayout('index');
		
	}
	
	
}



?>
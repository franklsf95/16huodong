<?php
include_once "base_action_controller.php";
Class Friend Extends BaseActionController {

	var $applicationFolder = "friend"; 
	
	function __construct() {
		parent::__construct();
		
	}
	
	function index(){
		
		$member_id = $this->getParameter('id',$this->current_member_information['member_id']);
		
		$all_friend_information = $this->extend_control->getAllFrinedInformationByMemberId($member_id);
		
		$this->ci_smarty->assign('all_friend_information',$all_friend_information);
		
		$this->displayWithLayout('index');
	}
	
	/*function search_member(){
		$member_id = $this->current_member_id;
		$search = $this->getParameter('search',NULL);
		
		$about_member_list = $this->extend_control->getAboutMemberList($member_id,'array');
		
		$this->db->select('m.member_id, m.name as member_name, m.image as member_image');
		$this->db->from('member as m');
		
		if ($search['member_name'] != '') {
			$this->db->like('m.name',$search['member_name']);
		}
		
		if ($search['school_name'] != '') {
			$this->db->join('public_school as ps','m.current_school = ps.school_id');
			$this->db->like('ps.name',$search['school_name']);
		}
		
		$this->db->where_not_in('member_id',$about_member_list);
		
		$all_select_member_information = $this->db->get()->result_array();
		
		$this->ci_smarty->assign('all_select_member_information',$all_select_member_information);
		
		$this->displayWithLayout('search_member');
	}*/
	
	
}



?>
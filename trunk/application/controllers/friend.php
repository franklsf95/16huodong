<?php
include_once "base_action_controller.php";
/**
* 控制好友列表显示
*/
Class Friend Extends BaseActionController {

	var $applicationFolder = "friend"; 
	
	function __construct() {
		parent::__construct();
		
	}
	
	/**
     * 显示会员好友列表
     *
     * @param 	id 	会员ID，默认自己
     *
     */
	function index(){
		$member_id = $this->getParameter('id',$this->current_member_id);
		$member_name = $this->extend_control->getMemberNameByMemberId($member_id);
		$all_friend_information = $this->extend_control->getAllFriendInformation($member_id);
		$this->ci_smarty->assign('information',$all_friend_information);
		$this->ci_smarty->assign('member_id',$member_id);
		$this->ci_smarty->assign('member_name',$member_name);
		$this->ci_smarty->assign('is_me', $member_id == $this->current_member_id );
		
		$this->display('index',$member_name.'的好友','index_css','index_js');
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
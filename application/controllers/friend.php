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
		$all_friend_information = $this->extend_control->getAllFriendsBrief($member_id);
		
		$this->ci_smarty->assign('information',$all_friend_information);
		$this->ci_smarty->assign('member_id',$member_id);
		$this->ci_smarty->assign('member_name',$member_name);
		$this->ci_smarty->assign('is_me', $member_id == $this->current_member_id );
		
		$this->display('index',$member_name.'的好友','index_css','index_js');
	}

	/**
     * 处理AJAX好友请求（加好友、批准、拒绝）
     *
     * @param 	target_id 	要加谁/要删谁
     * @param 	deny 		1表示拒绝申请，0表示批准
     *
     * @return 	0失败 	1成功成为好友 	-1成功删除好友 	2成功申请好友	-2成功拒绝申请
     */
	function ajaxToggleFriend(){
		$target_id = $this->getParameter('target_id',NULL);
		$member_id = $this->current_member_id;
		$deny = $this->getParameter('deny',NULL);
		
		$is_friend = $this->extend_control->getFriendStatus($member_id,$target_id);
		
		$return = 0;
		if ($is_friend==1) {	//是好友，删除好友
			$this->db->where('member_id',$member_id);
			$this->db->where('target_id',$target_id);
			$this->db->delete('member_friend');
			
			$this->db->where('member_id',$target_id);
			$this->db->where('target_id',$member_id);
			$this->db->delete('member_friend');
			
			$return = -1;
			
		} else if ( $is_friend==-2 ) {		//对方已申请我为好友
			if( !$deny ) {			//批准好友请求
				$data['member_id'] = $member_id;
				$data['target_id'] = $target_id;
				$data['created_time'] = $this->current_time;
				$data['approved'] = 1;
				$this->db->insert('member_friend',$data);
				$member_friend_id = $this->db->insert_id();

				$data2['approved'] = 1;
				$this->db->where('target_id',$member_id);
				$this->db->where('member_id',$target_id);
				$this->db->update('member_friend',$data2);
				
				$system_data['target_id'] = $target_id;
				$system_data['category'] = 'friend';
				$system_data['type'] = 'add_friend';
				$system_data['code'] = $member_friend_id;
				$this->system_message($system_data);
				$return = 1;
			} else {				//拒绝好友请求
				$this->db->where('target_id',$member_id);
				$this->db->where('member_id',$target_id);
				$this->db->delete('member_friend');
				$return = -2;
			}
		} else if ($is_friend==0) {		//互为陌生人，发送好友申请
			$data['member_id'] = $member_id;
			$data['target_id'] = $target_id;
			$data['created_time'] = $this->current_time;
			$data['approved'] = 0;
			$this->db->insert('member_friend',$data);
			$member_friend_id = $this->db->insert_id();
				
			//发送好友申请提示
			$system_data['category'] = 'friend';
			$system_data['type'] = 'apply_friend';
			$system_data['code'] = $member_friend_id;
			$system_data['target_id'] = $target_id;
			$this->system_message($system_data);
				
			$return = 2;
		}
		echo $return;
	}
	
}



?>
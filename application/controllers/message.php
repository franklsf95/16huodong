<?php
include_once "base_action_controller.php";
Class Message Extends BaseactionController {

	var $applicationFolder = "message"; 
	
	function __construct() {
		parent::__construct();
		$member_id = $this->current_member_id;
		$member_base_information = $this->extend_control->getMemberBaseInformation($member_id);
		$this->ci_smarty->assign('member_base_information',$member_base_information);
	}
	
	
	function index(){
		$member_id = $this->current_member_id;
		$p_page = $this->getParameter('page',1);
		$p_limit = $this->getParameter('limit',999);
		
		$count = $this->extend_control->countMemberMessageByGroup($member_id);
		$page_information = $this->createPageInformation($count, $p_page, $p_limit);
		
		$all_member_message_information = $this->extend_control->getAllMemberMessageInformationByGroup($member_id,$page_information['page_offset'],$p_limit);
		
		
		$all_system_message_information = $this->extend_control->getAllSystemMessageInformation($member_id);
		
		//print_r($all_system_message_information);
		
		$this->ci_smarty->assign('all_member_message_information',$all_member_message_information);
		$this->ci_smarty->assign('all_system_message_information',$all_system_message_information);
		
		$this->displayWithLayout('index');
	}
	
	function view(){
		$member_id = $this->getParameter('member_id',NULL);
		$p_page = $this->getParameter('page',1);
		$p_limit = $this->getParameter('limit',999);
		
		$count = $this->extend_control->countMemberMessageByMemberId($member_id);
		$page_information = $this->createPageInformation($count, $p_page, $p_limit);
		
		$all_member_message_information = $this->extend_control->getAllMemberMessageInformationByMemberId($member_id,$page_information['page_offset'],$p_limit);
		
		$member_base_information = $this->extend_control->getMemberBaseInformation($member_id);
		
		
		//浏览过就把通知删除掉
		
		$this->db->where('member_id',$member_id);
		$this->db->where('target_id',$this->current_member_id);
		$this->db->where('category','message');
		$this->db->where('type','member_message');
		$this->db->delete('system_message');
		
		
		$this->ci_smarty->assign('all_member_message_information',$all_member_message_information);
		$this->ci_smarty->assign('member_base_information',$member_base_information);
		$this->ci_smarty->assign('page_information',$page_information);
		
		$this->displayWithLayout('view');
		
		
		
	
	}
	
	
	
	function outbox(){
		$member_id = $this->current_member_id;
		$p_page = $this->getParameter('page',1);
		$p_limit = $this->getParameter('limit',10);
		
		$count = $this->extend_control->countMemberOutMessage($member_id);
		$page_information = $this->createPageInformation($count, $p_page, $p_limit);
		
		$all_member_out_message_information = $this->extend_control->getMemberOutMessageInformation($member_id,$page_information['page_offset'],$p_limit);
		
		$this->ci_smarty->assign('all_member_out_message_information',$all_member_out_message_information);
		$this->ci_smarty->assign('page_information',$page_information);
		
		$this->displayWithLayout('outbox');
	}
	
	
	function edit(){
		$this->displayWithLayout('edit');
	}
	
	
	function _saveItem($isNew, &$id, &$param) {
		$member_id = $this->current_member_id;
		$target_id = $this->getParameter('member_id',NULL);
		$content = $this->getParameterWithOutTag('message_content',NULL);
		
		if ($member_id == $target_id) {
			show_error('请不要尝试给自己发站内信^-^');
		}
		
		if ($member_id < $target_id) {
			$group = $member_id.','.$target_id;
		}else {
			$group = $target_id.','.$member_id;
		}
		
		if ($member_id != '' && $target_id != '' && $content != '') {
			
			$data['member_id'] = $member_id;
			$data['target_id'] = $target_id;
			$data['content'] = $content;
			$data['group'] = $group;

			if ($isNew){
				$data['created_time'] = $this->current_time;
				
				$this->db->insert('member_message',$data);
				$member_message_id = $this->db->insert_id();
				
				$system_message_data = array();
				$system_message_data['category'] = "message";
				$system_message_data['type'] = "member_message";
				$system_message_data['target_id'] = $target_id;
				$system_message_data['member_id'] = $member_id;
				$system_message_data['code'] = $member_message_id;
				
				$this->system_message($system_message_data);
				
				redirect('message');
				
			}else {
				$data['modified_time'] = $this->current_time;
				
				$this->db->where('member_message_id',$id);
				$this->db->update('member_message',$data);
			}
		
		}
		
	}
	
	function save_form_array(){
		$member_id = $this->current_member_id;
		$member_list = $this->getParameter('member_list',array());
		$content = $this->getParameterWithOutTag('content',NULL);
		
		if ($member_id != '' && count($member_list) > 0 && $content != '') {
			foreach ($member_list as $target_id) {
				if ($member_id != $target_id) {
					$data = array();
					if ($member_id < $target_id) {
						$group = $member_id.','.$target_id;
					}else {
						$group = $target_id.','.$member_id;
					}
					
					$data['member_id'] = $member_id;
					$data['target_id'] = $target_id;
					$data['content'] = $content;
					$data['group'] = $group;
					$data['created_time'] = $this->current_time;
					
					$this->db->insert('member_message',$data);
					
					$member_message_id = $this->db->insert_id();
					
					$system_message_data = array();
					$system_message_data['category'] = "message";
					$system_message_data['type'] = "member_message";
					$system_message_data['target_id'] = $target_id;
					$system_message_data['member_id'] = $member_id;
					$system_message_data['code'] = $member_message_id;
					
					$this->system_message($system_message_data);
				}
			}
			
		}
		redirect('message');
	}
	
	
}
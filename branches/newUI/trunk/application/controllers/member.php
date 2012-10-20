<?php
include_once "base_action_controller.php";
Class Member Extends BaseActionController {

	var $applicationFolder = "member"; 
	
	function __construct() {
		parent::__construct();
		
	}
	
	function index(){
		
		$member_id = $this->getParameter('id',$this->current_member_id);
		//if ($member_id == $this->current_member_id) {
		//	redirect('my_page');
		//}
		
		$this->save_member_visit($member_id);
		$member_information = $this->extend_control->getMemberInformation($member_id);
		$member_information['is_friend'] = $this->extend_control->isFriend($this->current_member_id,$member_id);
		$member_information['my_page'] = $member_id == $this->current_member_id ? true : false;
		
		$this->ci_smarty->assign('member_information',$member_information);
		$this->ci_smarty->assign('member_id',$member_id);
		
		$template_view = $member_information['member_type'];
		$this->displayWithLayout($template_view);
	}
	
	
	function save_member_leave_word(){
		$member_id = $this->current_member_id;
		$target_id = $this->getParameter('member_id',NULL);
		$content = $this->getParameter('content',NULL);
		
		if ($member_id != '' && $target_id != '' && $content != '') {
		
			$data['member_id'] = $member_id;
			$data['target_id'] = $target_id;
			$data['content'] = $content;
			$data['created_time'] = $this->current_time;
			
			$this->db->insert('member_leave_word',$data);
			
			redirect("member?id=$target_id");
		
		} else {
			print_r($_POST);
		}
	}
	
	
	function save_member_visit($member_id){
		$visitor_id = $this->current_member_id;
		
		if ($member_id != $visitor_id) {
			$this->db->where('member_id',$member_id);
			$this->db->where('visitor_id',$visitor_id);
			$member_visit_information = $this->db->get_first('member_visit');
			$data['visit_time'] = $this->current_time;
			
			if (count($member_visit_information) == 0) {
				$data['member_id'] = $member_id;
				$data['visitor_id'] = $visitor_id;
				$this->db->insert('member_visit',$data);
			}else {
				$this->db->where('member_id',$member_id);
				$this->db->where('visitor_id',$visitor_id);
				$this->db->update('member_visit',$data);
			}
		}
	}
	
	
}



?>
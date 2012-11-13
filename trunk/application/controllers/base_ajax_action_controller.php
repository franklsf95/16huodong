<?php
include_once dirname(__FILE__)."/base_action_controller.php";
Class Base_ajax_action_controller extends BaseActionController {

	function __construct() {
		parent::__construct();
		$this->ci_smarty->assign('lang','chs');
		$this->load->model('db_public_area');
		$this->load->model('db_public_school');
	}
	
	function getBlogClass(){
		$member_id = $this->current_member_information['member_id'];
		$this->db->where('member_id',$member_id);
		$all_blog_class_information = $this->db->get('book_class')->result_array();
		
		echo json_encode($all_blog_class_information);
	}
	
	function addBlogClass(){
		$name = $this->getParameter('name',NULL);
		$member_id = $this->current_member_information['member_id'];
		if ($name != '') {
			$data['name'] = $name;
			$data['member_id'] = $member_id;
			$data['created_time'] = $this->current_time;
			$this->db->insert('book_class',$data);
		}
	}
	
	function deleteFollowMember(){
		$member_id = $this->current_member_id;
		$friend_id = $this->getParameter('friend_id',NULL);
		
		$this->db->where('member_id',$member_id);
		$this->db->where('friend_id',$friend_id);
		$this->db->delete('member_friend');
	}
	
	function deleteFansMember(){
		$friend_id = $this->current_member_id;
		$member_id = $this->getParameter('member_id',NULL);
		
		$this->db->where('member_id',$member_id);
		$this->db->where('friend_id',$friend_id);
		$this->db->delete('member_friend');
	}
	
	function getBlogInformationById(){
		$book_id = $this->getParameter('book_id',NULL);
		$this->db->where('book_id',$book_id);
		$book_information = $this->db->get_first('book');
		
		echo json_encode($book_information);
	}
	
	
	function getHotBlogInformation(){
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',6);
		$all_hot_blog_information = $this->extend_control->getHotBlogInformation($page_offset,$limit);
		
		echo json_encode($all_hot_blog_information);
	}
	
	function getMemberBlogInformation(){
		$member_id = $this->getParameter('member_id',$this->current_member_id);
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',6);
		$all_book_information = $this->extend_control->getMemberBlogInformation($member_id,$page_offset,$limit);
		
		echo json_encode($all_book_information);
	}
	
	function getPreferBlogInformation(){
		$member_id = $this->getParameter('member_id',$this->current_member_id);
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',6);
		$all_prefer_blog_information = $this->extend_control->getPreferBlogInformation($member_id,$page_offset,$limit);
		
		echo json_encode($all_prefer_blog_information);
	}
	
	//暂不启用ajax提交评论
	function addActivityComment(){
		$activity_id = $this->getParameter('activity_id',Null);
		$content = $this->getParameterWithOutTag('content',Null);
		
		$data['member_id'] = $this->current_member_id;
		$data['activity_id'] = $activity_id;
		$data['content'] = $content;
		$data['created_time'] = $this->current_time;
		
		$result = $this->db->insert('activity_comment',$data);
		
		if($result) {
			$activity_comment_id = $this->db->insert_id();
			
			//system_message
			$this->db->select('publisher_id');
			$this->db->where('activity_id',$activity_id);
			
			$system_data['target_id'] = idx($this->db->get_first(),'publisher_id');
			$system_data['category'] = 'activity';
			$system_data['type'] = 'new_comment';
			$system_data['code'] = $activity_id;
			
			$this->system_message($system_data);
			
			$this->db->select('m.member_id, m.name as member_name, m.image as member_image, ac.*');
			$this->db->from('activity_comment as ac');
			$this->db->join('member as m','m.member_id = ac.member_id');
			$this->db->where('ac.activity_comment_id',$activity_comment_id);
			$activity_comment_information = $this->db->get_first();
			
			echo json_encode($activity_comment_information);
		}
	}
	
	//暂不启用ajax提交回复评论
	function addActivityCommentReply(){
		$activity_comment_id = $this->getParameter('activity_comment_id',Null);
		$reply = $this->getParameterWithOutTag('reply',Null);
		
		$data['reply'] = $reply;
		$this->db->where('activity_comment_id',$activity_comment_id);
		$result = $this->db->update('activity_comment',$data);
		
		if($result) {
			
			
			$this->db->select('m.member_id, m.name as member_name, m.image as member_image, ac.*');
			$this->db->from('activity_comment as ac');
			$this->db->join('member as m','m.member_id = ac.member_id');
			$this->db->where('ac.activity_comment_id',$activity_comment_id);
			$activity_comment_information = $this->db->get_first();
			
			//system_message
			$system_data['category'] = 'activity';
			$system_data['type'] = 'new_reply';
			$system_data['target_id'] = $activity_comment_information['member_id'];
			$system_data['code'] = $activity_comment_information['activity_id'];
			
			$this->system_message($system_data);
			
			
			echo json_encode($activity_comment_information);
		}
	}
	
	function getMemberInformationBySearch(){
		$member_name = $this->getParameter('member_name',NULL);
		$member_type = $this->getParameter('member_type',NULL);
		$rand = $this->getParameter('rand',false);
		$all_member_information = $this->extend_control->getMemberInformationBySearch($member_name,$member_type,$rand);
		
		echo json_encode($all_member_information);
		
	}
	
	function getMemberInformationBySchoolId(){
		$school_id = $this->getParameter('school_id',NULL);
		$member_type = $this->getParameter('member_type',NULL);
		$all_member_information = $this->extend_control->getMemberInformationBySchoolId($school_id,$member_type);
		
		echo json_encode($all_member_information);
		
	}
	
	function getActivityInformationByName(){
		$activity_name = $this->getParameter('activity_name',NULL);
		$activity_type = $this->getParameter('activity_type',NULL);
		$rand = $this->getParameter('rand',false);
		$all_activity_information = $this->extend_control->getActivityInformationByName($activity_name,$activity_type,$rand);
		
		echo json_encode($all_activity_information);
	}
	
}
?>
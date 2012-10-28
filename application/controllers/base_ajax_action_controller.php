<?php
include_once dirname(__FILE__)."/base_action_controller.php";
Class Base_ajax_action_controller extends BaseActionController {

	function __construct() {
		parent::__construct();
		$this->ci_smarty->assign('lang','chs');
		$this->load->model('db_public_area');
		$this->load->model('db_public_school');
	}
	
		
	//资料传送
	
	function saveMemberSay(){
		$member_id = $this->current_member_information['member_id'];
		$content = $this->getParameter('content',NULL);
		
		if ($member_id != '' && $content != '') {
			$data['member_id'] = $member_id;
			$data['content'] = $content;
			$data['created_time'] = $this->current_time;
			
			$result = $this->db->insert('member_say',$data);
		}
		
		if ($result) {
			$data['result'] = 'Y';
			echo json_encode($data);
		}
	
	}
	
	function getBlogClass(){
		$member_id = $this->current_member_information['member_id'];
		$this->db->where('member_id',$member_id);
		$all_blog_class_information = $this->db->get('member_blog_class')->result_array();
		
		echo json_encode($all_blog_class_information);
	}
	
	
	function addBlogComment(){
		$member_blog_id = $this->getParameter('member_blog_id',Null);
		$content = $this->getParameterWithOutTag('content',Null);
		
		$data['member_id'] = $this->current_member_id;
		$data['member_blog_id'] = $member_blog_id;
		$data['content'] = $content;
		$data['created_time'] = $this->current_time;
		
		$result = $this->db->insert('member_blog_comment',$data);
		
		if($result) {
			$member_blog_comment_id = $this->db->insert_id();
			
			$this->db->select('member_id');
			$this->db->where('member_blog_id',$member_blog_id);
			$target_id = idx($this->db->get_first('member_blog'),'member_id');
			
			//system_message
			$system_data['category'] = 'blog';
			$system_data['type'] = 'new_comment';
			$system_data['target_id'] = $target_id;
			$system_data['code'] = $member_blog_id;
			$this->system_message($system_data);
			
			$this->db->select('m.member_id, m.name as member_name, m.image as member_image, mbc.member_blog_comment_id, mbc.member_blog_id, mbc.content, mbc.created_time');
			$this->db->from('member_blog_comment as mbc');
			$this->db->join('member as m','m.member_id = mbc.member_id');
			$this->db->where('mbc.member_blog_comment_id',$member_blog_comment_id);
			$blog_comment_information = $this->db->get_first();
			
			echo json_encode($blog_comment_information);
		}
	}
	
	
	function getBlogCommentInformation(){
		$member_blog_id = $this->getParameter('member_blog_id',Null);
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',5);
		$all_blog_comment_information = $this->extend_control->getBlogCommentInformation($member_blog_id,$page_offset,$limit);
		
		echo json_encode($all_blog_comment_information);
	}
	
	function getMemberAlbum(){
		$member_id = $this->current_member_id;
		$this->db->where('member_id',$member_id);
		$all_member_album_information = $this->db->get('member_album')->result_array();
		
		echo json_encode($all_member_album_information);
	}
	
	function addMemberAlbum(){
		$name = $this->getParameter('name',NULL);
		$image = $this->getParameter('image',NULL);
		$description = $this->getParameter('description',NULL);
		$member_id = $this->current_member_information['member_id'];
		if ($name != '') {
			$data['name'] = $name;
			$data['member_id'] = $member_id;
			$data['image'] = $image;
			$data['description'] = $description;
			$data['created_time'] = $this->current_time;
			$this->db->insert('member_album',$data);
		}
	}
	
	function addBlogClass(){
		$name = $this->getParameter('name',NULL);
		$member_id = $this->current_member_information['member_id'];
		if ($name != '') {
			$data['name'] = $name;
			$data['member_id'] = $member_id;
			$data['created_time'] = $this->current_time;
			$this->db->insert('member_blog_class',$data);
		}
	}
	
	function addLeaveWordReply(){
		$member_id = $this->current_member_id;
		$leave_word_id = $this->getParameter('leave_word_id',NULL);
		$leave_word_reply = $this->getParameter('leave_word_reply',NULL);
		$this->db->where('member_leave_word_id',$leave_word_id);
		$member_leave_word_information = $this->db->get_first('member_leave_word');
		if ($member_leave_word_information['reply'] == '' && $leave_word_reply != '') {
			$data['reply'] = $leave_word_reply;
			$this->db->where('member_leave_word_id',$leave_word_id);
			$this->db->update('member_leave_word',$data);
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
	
	function updateSystemMessage(){
		$system_message_id = $this->getParameter('system_message_id');
		$target_id = $this->current_member_id;
		$data['is_new'] = 'N';
		$this->db->where('system_message_id',$system_message_id);
		$this->db->where('target_id',$target_id);
		$this->db->update('system_message',$data);
		
	}
	
	
	function getBlogInformationById(){
		$member_blog_id = $this->getParameter('member_blog_id',NULL);
		$this->db->where('member_blog_id',$member_blog_id);
		$member_blog_information = $this->db->get_first('member_blog');
		
		echo json_encode($member_blog_information);
	}
	
	function getAllMemberBlogInformation(){
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',6);
		$all_member_blog_information = $this->extend_control->getAllMemberBlogInformation($page_offset,$limit);
		
		echo json_encode($all_member_blog_information);
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
		$all_member_blog_information = $this->extend_control->getMemberBlogInformation($member_id,$page_offset,$limit);
		
		echo json_encode($all_member_blog_information);
	}
	
	function getPreferBlogInformation(){
		$member_id = $this->getParameter('member_id',$this->current_member_id);
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',6);
		$all_prefer_blog_information = $this->extend_control->getPreferBlogInformation($member_id,$page_offset,$limit);
		
		echo json_encode($all_prefer_blog_information);
	}
	
	/*
	function getMemberAlbumInformation(){
		$member_album_id = $this->getParameter('member_album_id',NULL);
		$this->db->where('member_album_id',$member_album_id);
		$member_album_information = $this->db->get_first('member_album');
		
		echo json_encode($member_album_information);
	}
	*/
	
	function getNewActivityInformation(){
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',5);
		$all_new_activity_information = $this->extend_control->getNewActivityInformation($page_offset,$limit);
		
		echo json_encode($all_new_activity_information);
	}
	
	function getActivityCommentInformation(){
		$activity_id = $this->getParameter('activity_id',Null);
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',5);
		$all_activity_comment_information = $this->extend_control->getActivityCommentInformation($activity_id,$page_offset,$limit);
		
		echo json_encode($all_activity_comment_information);
	}
	
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
			
			$this->db->select('member_id');
			$this->db->where('activity_id',$activity_id);
			$target_id = idx($this->db->get_first('activity_publish_member'),'member_id');
			
			//system_message
			$system_data['category'] = 'activity';
			$system_data['type'] = 'new_comment';
			$system_data['target_id'] = $target_id;
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
	
	function getHotActivityInformation(){
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',5);
		$all_hot_activity_information = $this->extend_control->getHotActivityInformation($page_offset,$limit);
		echo json_encode($all_hot_activity_information);
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
	
	function getAllMemberInformationByName(){
		$member_name = $this->getParameter('member_name','');
		
		$all_member_information = $this->extend_control->getAllMemberInformationByName($member_name);
		
		echo json_encode($all_member_information);
		
		
	}
}
?>
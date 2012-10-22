<?php
include_once "base_action_controller.php";
Class Activity Extends BaseactionController {

	var $applicationFolder = "activity"; 
	
	function __construct() {
		parent::__construct();
		
	}
	
	function index(){
		$member_id = $this->getParameter('member_id',$this->current_member_information['member_id']);
		$this->displayWithLayout('index');
	}
	
	function rate1(){
		$activity_id = $this->getParameter('id');
		$member_id = $this->current_member_id;
		if ($activity_id != '') {
			$this->db->select('a.activity_id');
			$this->db->from('activity as a');
			$this->db->where('activity_id',$activity_id);
			$activity_information = $this->db->get_first();
			if ($activity_information) {
				$this->db->select('a.activity_id, a.member_id, a.rate');
				$this->db->from('activity_rate as a');
				$this->db->where('activity_id',$activity_id);
				$this->db->where('member_id',$member_id);
				$rate = $this->db->get_first();
				if ($rate) {
					if ($rate['rate']==-1) {
						$rate['rate']=1;
					} else {
						$rate['rate']=1-$rate['rate'];
					}
					$this->db->where('activity_id',$activity_id);
					$this->db->where('member_id',$member_id);
					$this->db->update('activity_rate',$rate);
				} else {
					$rate['activity_id']=$activity_id;
					$rate['member_id']=$member_id;
					$rate['rate']=1;
					$this->db->insert('activity_rate',$rate);
				}
				redirect('activity/view?id='.$activity_id);
			} else {
				$this->index();
			}
		} else {
			$this->index();
		}
	}
	
	function rate2(){
		$activity_id = $this->getParameter('id');
		$member_id = $this->current_member_id;
		if ($activity_id != '') {
			$this->db->select('a.activity_id');
			$this->db->from('activity as a');
			$this->db->where('activity_id',$activity_id);
			$activity_information = $this->db->get_first();
			if ($activity_information) {
				$this->db->select('a.activity_id, a.member_id, a.rate');
				$this->db->from('activity_rate as a');
				$this->db->where('activity_id',$activity_id);
				$this->db->where('member_id',$member_id);
				$rate = $this->db->get_first();
				if ($rate) {
					if ($rate['rate']==1) {
						$rate['rate']=-1;
					} else {
						$rate['rate']=-1-$rate['rate'];
					}
					$this->db->where('activity_id',$activity_id);
					$this->db->where('member_id',$member_id);
					$this->db->update('activity_rate',$rate);
				} else {
					$rate['activity_id']=$activity_id;
					$rate['member_id']=$member_id;
					$rate['rate']=-1;
					$this->db->insert('activity_rate',$rate);
				}
				redirect('activity/view?id='.$activity_id);
			} else {
				$this->index();
			}
		} else {
			$this->index();
		}
	}
	
	function new_activity(){
		$p_page = $this->getParameter('page',1);
		$p_limit = $this->getParameter('limit', 10);
		
		$count = $this->extend_control->countNewActivity();
		$page_information = $this->createPageInformation($count, $p_page, $p_limit);
		$all_new_activity_information = $this->extend_control->getNewActivityInformation($page_information['page_offset'],$p_limit);
		
		$this->ci_smarty->assign('page_information',$page_information);
		$this->ci_smarty->assign('all_new_activity_information',$all_new_activity_information);
		
		$this->displayWithLayout('new_activity');
	}
	
	
	function all_attention_activity(){
		$member_id = $this->getParameter('member_id',$this->current_member_id);
		$p_page = $this->getParameter('page',1);
		$p_limit = $this->getParameter('limit', 10);
		
		$count = $this->extend_control->countAllMemberAttentionActivity($member_id);
		$page_information = $this->createPageInformation($count, $p_page, $p_limit);
		$all_member_attention_activity_information = $this->extend_control->getAllMemberAttentionActivityInformation($member_id,$page_information['page_offset'],$p_limit);
		
		$this->ci_smarty->assign('page_information',$page_information);
		$this->ci_smarty->assign('all_member_attention_activity_information',$all_member_attention_activity_information);
		
		$this->displayWithLayout('all_attention_activity');
	}
	
	
	function all_attend_activity(){
		$member_id = $this->getParameter('member_id',$this->current_member_id);
		$p_page = $this->getParameter('page',1);
		$p_limit = $this->getParameter('limit', 10);
		
		$count = $this->extend_control->countAllMemberAttendActivity($member_id);
		$page_information = $this->createPageInformation($count, $p_page, $p_limit);
		$all_member_attend_activity_information = $this->extend_control->getAllMemberAttendActivityInformation($member_id,$page_information['page_offset'],$p_limit);
		
		$this->ci_smarty->assign('page_information',$page_information);
		$this->ci_smarty->assign('all_member_attend_activity_information',$all_member_attend_activity_information);
		
		$this->displayWithLayout('all_attend_activity');
	}
	
	
	function all_publish_activity(){
		$member_id = $this->getParameter('member_id',$this->current_member_id);
		$p_page = $this->getParameter('page',1);
		$p_limit = $this->getParameter('limit', 10);
		
		$count = $this->extend_control->countAllMemberPublishActivity($member_id);
		$page_information = $this->createPageInformation($count, $p_page, $p_limit);
		$all_member_publish_activity_information = $this->extend_control->getAllMemberPublishActivityInformation($member_id,$page_information['page_offset'],$p_limit);
		
		$this->ci_smarty->assign('page_information',$page_information);
		$this->ci_smarty->assign('all_member_publish_activity_information',$all_member_publish_activity_information);
		
		$this->displayWithLayout('all_publish_activity');
	}
	
	
	function view(){
		$activity_id = $this->getParameter('id');
		$member_id = $this->current_member_id;
		$p_page = $this->getParameter('page',1);
		$p_limit = $this->getParameter('limit', 10);
		
		$this->addActivityMemberVisit($activity_id);
		
		$activity_information = $this->extend_control->getAcitivityInformationById($activity_id);
		$activity_information['all_activity_attend_member_information'] = $this->extend_control->getAllActivityAttendMemberInformation($activity_id);
		$activity_information['all_activity_attention_member_information'] = $this->extend_control->getAllActivityAttentionMemberInformation($activity_id);
		
		$count = $this->extend_control->countAllActivityComment($activity_id);
		$page_information = $this->createPageInformation($count, $p_page, $p_limit);
		$all_activity_comment_information = $this->extend_control->getActivityCommentInformation($activity_id,$page_information['page_offset'],$p_limit);
		$activity_information['all_activity_comment_information'] = $all_activity_comment_information;
		$activity_information['is_attend'] = $this->extend_control->isMemberAttendActivity($member_id,$activity_id);
		$activity_information['is_attention'] = $this->extend_control->isMemberAttentionActivity($member_id,$activity_id);
		
		$activity_information['is_publisher'] = $this->extend_control->isMemberPublishActivity($member_id,$activity_id);
		
		$rate1=$rate2=$rate3=$rate4=0;
		$this->db->select('a.activity_id, a.member_id, a.rate');
		$this->db->from('activity_rate as a');
		$this->db->where('activity_id',$activity_id);
		$results=$this->db->get()->result_array();
		
		foreach ($results as $item) {
			if ($item['rate']==1) {
				$rate1++;
				if ($item['member_id'] == $member_id) {
					$rate3++;
				}
			} else if ($item['rate']==-1) {
				$rate2++;
				if ($item['member_id'] == $member_id) {
					$rate4++;
				}
			}
		}
		
		$this->ci_smarty->assign('rate1',$rate1);
		$this->ci_smarty->assign('rate2',$rate2);
		$this->ci_smarty->assign('rate3',$rate3);
		$this->ci_smarty->assign('rate4',$rate4);
		
		$this->ci_smarty->assign('page_information',$page_information);
		$this->ci_smarty->assign('activity_information',$activity_information);
		
		if ($activity_information['is_publisher'] == 'Y') {
			$this->displayWithLayout('publisher_view');
		}else {
			$this->displayWithLayout('view');
		}
		
		
	}
	
	function search_activity(){
		$search = $this->getParameter('search',NULL);
		
		$this->db->select('a.activity_id, a.name as activity_name, a.apply_start_time, a.apply_end_time, a.start_time, a.end_time, a.description, m.member_id, m.name as member_name, m.image as member_image');
		$this->db->from('activity as a');
		$this->db->join('activity_publish_member as apm','apm.activity_id = a.activity_id');
		$this->db->join('member as m','m.member_id = apm.member_id');
		
		if ($search['activity_name'] != '') {
			$this->db->like('a.name',$search['activity_name']);
		}
		
		if ($search['member_name'] != '') {
			$this->db->like('m.name',$search['member_name']);
		}
		
		$this->db->order_by('a.created_time','DESC');
		$all_search_activity_information = $this->db->get()->result_array();
		
		$this->ci_smarty->assign('all_search_activity_information',$all_search_activity_information);
		
		$this->displayWithLayout('search_activity');
	}
	
	
	function attend_activity(){
		$activity_id = $this->getParameter('id');
		$member_id = $this->current_member_information['member_id'];
		$return_data = array();
		if ($activity_id){
			//检查该会员是否已经参加活动
			$is_attend = $this->extend_control->isMemberAttendActivity($member_id,$activity_id);
			if($is_attend == 'N'){
				$data['member_id'] = $member_id;
				$data['activity_id'] = $activity_id;
				$data['created_time'] = $this->current_time;
				$this->db->insert('activity_attend_member',$data);
				
				$return_data['status'] = 'Y';
				$return_data['str'] = '已报名活动';
				
				
				//system_message
				$this->db->select('member_id');
				$this->db->where('activity_id',$activity_id);
				$member_id = idx($this->db->get_first('activity_publish_member'),'member_id');
				$system_data['target_id'] = $member_id;
				$system_data['category'] = 'activity';
				$system_data['type'] = 'attend_activity';
				$system_data['code'] = $activity_id;
				$this->system_message($system_data);
				
				
			} else {
				
				$this->db->where('member_id',$member_id);
				$this->db->where('activity_id',$activity_id);
				$this->db->delete('activity_attend_member');
				
				$return_data['status'] = 'N';
				$return_data['str'] = '已取消报名';
			}
		}
		echo json_encode($return_data);
	}
	
	function handle_activity_attend(){
		$activity_attend_id = $this->getParameter('activity_attend_id',Null);
		$action = $this->getParameter('action',Null);
		$return_data = array();
		
		if($activity_attend_id != '' && $action != '') {
			$this->db->where('activity_attend_id',$activity_attend_id);
			$activity_attend_information = $this->db->get_first('activity_attend_member');
			
			if($activity_attend_id != '') {
				if($action == 'Y') {
					
					
					//system_message
					$system_data['target_id'] = $activity_attend_information['member_id'];
					$system_data['category'] = 'activity';
					$system_data['type'] = 'activity_apply_pass';
					$system_data['code'] = $activity_attend_information['activity_id'];
					$this->system_message($system_data);
					
					
					$data['status'] = 'Y';
					$this->db->where('activity_attend_id',$activity_attend_id);
					$this->db->update('activity_attend_member',$data);
					$return_data['status'] = 'Y';
					$return_data['str'] = '已通过报名';
					$return_data['member_id'] = $activity_attend_information['member_id'];
				}else if ($action == 'N') {
					$this->db->where('activity_attend_id',$activity_attend_id);
					$this->db->delete('activity_attend_member');
					$return_data['status'] = 'N';
					$return_data['str'] = '已拒绝报名';
					$return_data['member_id'] = $activity_attend_information['member_id'];
				}
			}
			
		}
		echo json_encode($return_data);
	}
	
	
	function attention_activity(){
		$activity_id = $this->getParameter('id');
		$member_id = $this->current_member_information['member_id'];
		if ($activity_id){
			//检查该会员是否已经参加活动
			$is_attention = $this->extend_control->isMemberAttentionActivity($member_id,$activity_id);
			if($is_attention == 'N'){
				$data['member_id'] = $member_id;
				$data['activity_id'] = $activity_id;
				$data['created_time'] = $this->current_time;
				
				$this->db->insert('activity_attention_member',$data);
				
				$return_data['status'] = 'Y';
				$return_data['str'] = '已关注活动';
				
			} else {
				
				$this->db->where('member_id',$member_id);
				$this->db->where('activity_id',$activity_id);
				$this->db->delete('activity_attention_member');
				
				$return_data['status'] = 'N';
				$return_data['str'] = '已取消关注';
				
			}
			
			echo json_encode($return_data);
		}
	}
	
	function attend_activity_list(){
		
		$member_id = $this->current_member_information['member_id'];
		
		$this->db->select('a.*');
		$this->db->from('activity as a');
		$this->db->join('activity_attend_member as aam','aam.activity_id = a.activity_id');
		$this->db->where('aam.member_id',$member_id);
		$all_attend_activity_information = $this->db->get()->result_array();
		
		$this->ci_smarty->assign('all_attend_activity_information',$all_attend_activity_information);
		
		$this->displayWithLayout('attend_activity_list');
		
	}
	
	function edit(){				//新建、编辑活动
		$id = $this->getParameter('id',NULL);
		$member_id = $this->current_member_information['member_id'];
		$title = '发起新活动';
		
		if ($id != '') {
			$title = '编辑活动 #'.$id;
			$this->db->from('activity as a');
			$this->db->join('activity_publish_member as apm','a.activity_id = apm.activity_id');
			$this->db->where('a.activity_id',$id);
			$this->db->where('apm.member_id',$member_id);
			$this->db->where('apm.publisher','Y');
			$activity_information = $this->db->get_first('');
			
			//获取活动标签
			$this->db->select('tag');
			$this->db->from('activity_tag');
			$this->db->where('activity_id',$id);
			$all_tag = $this->db->get()->result_array();
			
			if(is_array($all_tag)){
				foreach ($all_tag as $tag) {
					$activity_information['tag'][] = $tag['tag'];
				}
			}
			
			$this->ci_smarty->assign('activity_information',$activity_information);
			$this->ci_smarty->assign('cid',$activity_information['activity_id']);
		}
		$this->ci_smarty->assign('all_member_friend_information',$this->current_member_information['all_member_friend_information']);
		
		//$this->displayWithLayout('edit_old');
		$this->display( 'edit', $title, 'edit_css', 'edit_js' );
	}
	
	function _saveItem($isNew, &$id, &$param) {
		
		$name = $this->getParameterWithOutTag('name',NULL);
		$apply_start_time = $this->getParameter('apply_start_time',NULL);
		$apply_end_time = $this->getParameter('apply_end_time',NULL);
		$start_time = $this->getParameter('start_time',NULL);					//1为正常
		$end_time = $this->getParameter('end_time',NULL);
		$price = $this->getParameterWithOutTag('price',NULL);
		$address = $this->getParameterWithOutTag('address',NULL);
		$image = $this->getParameter('image',NULL);
		$description = $this->getParameterWithOutTag('description',NULL);
		$tag_array = $this->getParameter('tag',NULL);
		$content = $this->getParameter('content',NULL);
		$invite_member = $this->getParameter('invite_member',NULL);
		//$tag = trim(trim(str_replace('/',',',str_replace('.',',',str_replace(';',',',str_replace('，',',',str_replace(' ',',',$tag)))))),',');
		
		$data['name'] = $name;
		$data['apply_start_time'] = $apply_start_time;
		$data['apply_end_time'] = $apply_end_time;
		$data['start_time'] = $start_time;
		$data['end_time'] = $end_time;
		$data['price'] = $price;
		$data['address'] = $address;
		$data['description'] = $description;
		$data['content'] = $content;
		
		//处理图片高宽问题
		$image_url = $this->getImageUrl($image);
		if ($image_url === false) {
			show_error('活动封面上传错误');
		}
		$image_parameter = @getimagesize($image_url['absolute_path']);
		$data['image_width'] = $image_parameter['0'];
		$data['image_height'] = $image_parameter['1'];
		$data['image'] = $image_url['relative_path'];

		if ($isNew){
			//写入activity
			$data['created_time'] = $this->current_time;
			$this->db->insert('activity',$data);
			
			$activity_id = $this->db->insert_id();
			
			//写入activity_publisher
			$activity_publisher_data['activity_id'] = $activity_id;
			$activity_publisher_data['member_id'] = $this->current_member_information['member_id'];
			$activity_publisher_data['publisher'] = 'Y';
			
			$this->db->insert('activity_publish_member',$activity_publisher_data);
			
			//写入activity_tag
			foreach($tag_array as $tag_value){
				$activity_tag_data = array();
				$activity_tag_data['activity_id'] = $activity_id;
				$activity_tag_data['tag'] = $tag_value;
				$activity_tag_data['created_time'] = date('Y-m-d H:i:s');
				$this->db->insert('activity_tag',$activity_tag_data);
			}
			
			if (count($invite_member) >0 ){
				$this->invite_member_attend_activity($activity_id,$invite_member);
			}
			redirect('activity/view?id='.$activity_id);
			
		}else {
			$data['modified_time'] = $this->current_time;
			$this->db->where('activity_id',$id);
			$this->db->update('activity',$data);
			
			//删除activity_tag
			$this->db->where('activity_id',$id);
			$this->db->delete('activity_tag');
			
			//写入activity_tag
			foreach($tag_array as $tag_value){
				$activity_tag_data = array();
				$activity_tag_data['activity_id'] = $id;
				$activity_tag_data['tag'] = $tag_value;
				$activity_tag_data['created_time'] = date('Y-m-d H:i:s');
				$this->db->insert('activity_tag',$activity_tag_data);
			}
			
			$system_data['category'] = "activity";
			$system_data['type'] = "edit_activity";
			$system_data['code'] = $id;
			$this->system_message($system_data);
			
			if (count($invite_member) >0 ){
				$this->invite_member_attend_activity($id,$invite_member);
			}
			
			
			
			redirect('activity/view?id='.$id);
		}
		
	}
	
	function save_comment(){
		$activity_id = $this->getParameter('activity_id',NULL);
		$activity_comment = $this->getParameter('activity_comment',NULL);
		if ($activity_id != '' && $activity_comment != ''){
			
			$data['activity_id'] = $activity_id;
			$data['content'] = trim($activity_comment);
			$data['member_id'] = $this->current_member_id;
			$data['created_time'] = $this->current_time;
			
			$this->db->insert('activity_comment',$data);
			
			
		}
		redirect(site_url("activity/view?id=$activity_id"));
	}
	
	function addActivityCommentReply(){
		$activity_comment_id = $this->getParameter('activity_comment_id',NULL);
		$reply = $this->getParameter('reply',NULL);
		$this->db->where('activity_comment_id',$activity_comment_id);
		$activity_comment_information = $this->db->get_first('activity_comment');
		if ($activity_comment_information['reply'] == '' && $reply != '') {
			$data['reply'] = $reply;
			$this->db->where('activity_comment_id',$activity_comment_id);
			$this->db->update('activity_comment',$data);
		}
		
		redirect(site_url("activity/view?id=$activity_comment_information[activity_id]"));
	}
	
	function invite_member_attend_activity($activity_id,$member_list){
		$member_id = $this->current_member_id;
		
		foreach ($member_list as $target_id) {
			$system_data['member_id'] = $this->current_member_id;
			$system_data['target_id'] = $target_id;
			$system_data['category'] = "activity";
			$system_data['type'] = "invite_attend_activity";
			$system_data['code'] = $activity_id;
			
				
			$this->system_message($system_data);
		}
	}
	
	
	
}



?>
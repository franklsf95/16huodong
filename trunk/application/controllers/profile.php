<?php
include_once "base_action_controller.php";
/**
* 控制会员主页显示、资料编辑、留言？访问量统计
*/
Class Profile Extends BaseActionController {

	var $applicationFolder = "profile"; 
	
	function __construct() {
		parent::__construct();
		
	}
	
	/**
     * 显示会员个人主页
     *
     * @param 	id 	会员ID，默认自己
     *
     */
	function index(){
		$member_id = $this->getParameter('id',$this->current_member_id);
		
		$this->save_member_visit($member_id);
		$member_information = $this->extend_control->getMemberInformation($member_id);
		
		$this->ci_smarty->assign('member_information',$member_information);
		$this->ci_smarty->assign('member_id',$member_id);
		$this->ci_smarty->assign('is_me', $member_id == $this->current_member_id );
		$this->ci_smarty->assign('is_friend',$this->extend_control->getFriendStatus($this->current_member_id,$member_id) );
		
		$template_view = $member_information['member_type'];
		//print_r($member_information);exit();
		$this->display('view/index', $member_information['member_name'].'的主页','view_css','view_js');
	}

	/**
     * 显示用户的活动历史
     *
     * @param	member_id	要显示的用户的ID
     * @param 	type 		类型：a参加；f关注；p发起
     * @param	page		当前进行到的页面
     */
	function history(){
		$member_id = $this->getParameter('member_id',$this->current_member_id);
		$member_name = $this->extend_control->getMemberNameByMemberId($member_id);
		$type = $this->getParameter('type');
		$page = $this->getParameter('page',1);
		$limit = $this->LIMIT;
		$offset = ($page-1) * $limit;
		$title = $member_name;

		if( $type == 'a' ) {
			$count = $this->extend_control->countAllMemberFollowActivities($member_id);
			$information = $this->extend_control->getAllMemberFollowActivities($member_id,$offset,$limit);
			$title .= '参加的活动';
		} elseif( $type == 'f' ) {
			$count = $this->extend_control->countAllMemberAttendActivities($member_id);
			$information = $this->extend_control->getAllMemberAttendActivities($member_id,$offset,$limit);
			$title .= '关注的活动';
		} elseif( $type == 'p' ) {
			$count = $this->extend_control->countAllMemberPublishActivities($member_id);
			$information = $this->extend_control->getAllMemberPublishActivities($member_id,$offset,$limit);
			$title .= '发起的活动';
		} else {
			show_error('没有指定活动类型！');
		}
		$this->setPageInformation( $count, $page, $limit, 'profile/history' );

		$this->ci_smarty->assign('history',$information);
		$this->ci_smarty->assign('type',$type);
		$this->ci_smarty->assign('title',$title);
		$this->ci_smarty->assign('member_id',$member_id);
		$this->ci_smarty->assign('member_name',$member_name);
		
		$this->display('history',$title);
	}
	
	/**
     * 显示会员资料编辑页面，为不同的会员显示不同的页面
     */
	function edit(){
		$member_type = $this->current_member_information['member_type'];
		if( $member_type=='stu' ) {
			$template_title = '编辑个人资料';
		} else if ( $member_type=='com' ) {
			$template_title = '编辑公司资料';
		} else {
			$template_title = '编辑组织资料';
		}
		//print_r($this->current_member_information);exit();
		$this->display('edit/index', $template_title, 'edit_css', 'edit_js');
	}

	/**
     * 处理编辑个人资料提交
     *
     * @param 	一堆
     */
	function save_form() {
		$member_id = $this->current_member_id;
		$image = $this->getParameter('image',Null);
		$name = $this->getParameterWithOutTag('name',Null);
		$gender = $this->getParameter('gender',Null);
		$birthday = $this->getParameter('birthday',Null);
		$qq = $this->getParameterInt('qq',Null);								//QQ
		$organisation = $this->getParameterWithOutTag('organisation',Null);		//所属组织
		$email = $this->getParameterWithOutTag('email',Null);
		$title = $this->getParameterWithOutTag('title',Null);		//职务
		$principal = $this->getParameterWithOutTag('principal',Null);		//负责人
		$phone = $this->getParameterWithOutTag('phone',Null);		//电话
		$address = $this->getParameterWithOutTag('address',Null);		//地址
		$tag_array = $this->getParameter('tag',Null);		//标签
		$description = $this->getParameterWithOutTag('description',Null);		//关于我
		$content = $this->getParameter('content',Null);	//组织介绍页

		$member_data['name'] = $name;
		$member_data['image'] = $image;
		$member_data['gender'] = $gender;
		$member_data['birthday'] = $birthday;
		$member_data['qq'] = $qq;
		$member_data['organisation'] = $organisation;
		$member_data['email'] = $email;
		$member_data['title'] = $title;
		$member_data['principal'] = $principal;
		$member_data['phone'] = $phone;
		$member_data['address'] = $address;
		$member_data['description'] = $description;
		$member_data['content'] = $content;
		$member_data['qq'] = $qq;

		$this->db->where('member_id',$member_id);
		$this->db->update('member',$member_data);
		
		//处理会员标签
		$this->db->where('member_id',$member_id);
		$this->db->delete('member_tag');

		foreach ($tag_array as $tag_value) {
			$member_tag_data = array();
			$member_tag_data['member_id'] = $member_id;
			$member_tag_data['tag'] = $tag_value;
			$member_tag_data['created_time'] = date('Y-m-d H:i:s');
			
			$this->db->insert('member_tag',$member_tag_data);
		}
		
		//更新session、处理更改密码
		
		$old_password = $this->getParameter('old_password',Null);
		$new_password = $this->getParameter('new_password',Null);
		$repeat_password = $this->getParameter('repeat_password',Null);
		
		if ($old_password != '' && $new_password != '' && $repeat_password != '' && $new_password == $repeat_password) {
			$this->db->where('member_id',$member_id);
			$this->db->where('password',md5($old_password));
			
			$member_information = $this->db->get_first('member');
			
			if ($member_information) {
				$member_password_data['password'] = md5($new_password);
				$this->db->where('member_id',$member_id);
				$this->db->update('member',$member_password_data);
			}
		}
		$this->extend_control->setCurrentMemberInformation();
		
		redirect('profile');
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
//--------AJAX工具组

	function ajaxGetCurrentAttendActivity(){
		$member_id = $this->getParameter('member_id',$this->current_member_id);
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',5);
		$all_current_attend_activity_information = $this->extend_control->getCurrentAttendActivityInformation($member_id,$page_offset,$limit);
		
		echo json_encode($all_current_attend_activity_information);
	}
	
	function ajaxGetCurrentFollowActivity(){
		$member_id = $this->getParameter('member_id',$this->current_member_id);
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',5);
		$all_current_attention_activity_information = $this->extend_control->getCurrentFollowActivityInformation($member_id,$page_offset,$limit);
		
		echo json_encode($all_current_attention_activity_information);
	}
	
	function ajaxGetCurrentPublishActivity(){
		$member_id = $this->getParameter('member_id',$this->current_member_id);
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',5);
		$all_current_publish_activity_information = $this->extend_control->getCurrentPublishActivityInformation($member_id,$page_offset,$limit);
		
		echo json_encode($all_current_publish_activity_information);
	}
	
}



?>
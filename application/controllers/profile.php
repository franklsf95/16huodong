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

	function index() {
		redirect('profile/view/'.$this->current_member_id);
	}

	/**
     * 显示会员个人主页
     *
     * @param 	member_id 	会员ID，默认自己
     */
	function view( $member_id = 0 ){
		if( $member_id == 0 )
			$member_id = $this->current_member_id;
		else
			$this->saveMemberVisit( $member_id );

		$member_information = $this->extend_control->getMemberInformation($member_id);
		if( !$member_information )
			show_error('你要找的用户不存在哟~');

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
     * @param	page		当前进行到的页面
     * @param 	string 		$type 		类型：a参加；f关注；p发起
     */
	function history( $type ){
		$member_id = $this->getParameter('member_id',$this->current_member_id);
		$member_name = $this->extend_control->getMemberNameByMemberId($member_id);
		$page = $this->getParameter('page',1);
		$limit = $this->LIMIT;
		$offset = ($page-1) * $limit;
		$title = $member_name;

		if( $type == 'follow' ) {
			$count = $this->extend_control->countAllMemberFollowActivities($member_id);
			$information = $this->extend_control->getAllMemberFollowActivities($member_id,$offset,$limit);
			$title .= '关注的活动';
		} elseif( $type == 'attend' ) {
			$count = $this->extend_control->countAllMemberAttendActivities($member_id);
			$information = $this->extend_control->getAllMemberAttendActivities($member_id,$offset,$limit);
			$title .= '参加的活动';
		} elseif( $type == 'publish' ) {
			$count = $this->extend_control->countAllMemberPublishActivities($member_id);
			$information = $this->extend_control->getAllMemberPublishActivities($member_id,$offset,$limit);
			$title .= '发起的活动';
		} else {
			show_error('没有指定活动类型！');
		}
		$this->setPageInformation( $count, $page, $limit, 'profile/history/'.$type );

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
		$realname = $this->getParameterWithOutTag('realname',Null);
		$gender = $this->getParameter('gender',Null);
		$birthday = $this->getParameter('birthday',Null);
		$school_changed = $this->getParameter('school_changed',Null);
		$school_id = $this->getParameter('school_id',Null);
		$school_name = $this->getParameter('inputSchool',Null);
		$area = $this->getParameter('area',Null);
		$city = $this->getParameter('city',Null);
		$qq = $this->getParameter('qq',Null);								//QQ
		$organisation = $this->getParameterWithOutTag('organisation',Null);		//所属组织
		$email = $this->getParameterWithOutTag('email',Null);
		$title = $this->getParameterWithOutTag('title',Null);		//职务
		$principal = $this->getParameterWithOutTag('principal',Null);		//负责人
		$phone = $this->getParameterWithOutTag('phone',Null);		//电话
		$address = $this->getParameterWithOutTag('address',Null);		//地址
		$tag_array = $this->getParameter('tag',Null);		//标签
		$description = $this->getParameterWithOutTag('description',Null);		//关于我
		$content = $this->getParameter('content',Null);	//组织介绍页
		$accept_notification = $this->getParameter('accept_notification',1);

		$member_data['name'] = $name;
		$member_data['realname'] = $realname;
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
		$member_data['accept_notification'] = $accept_notification;
		$member_data['modified_time'] = $this->current_time;
		if ($school_changed) {
			$member_data['area-1'] = $area;
			$member_data['area-3'] = $city;
			$member_data['school_id'] = $school_id;
			$member_data['school_name']=$school_name;
		}

		$this->db->where('member_id',$member_id);
		$this->db->update('member',$member_data);

		//处理会员标签
		$this->db->where('member_id',$member_id);
		$this->db->delete('member_tag');

		if ($tag_array != null) {
			foreach ($tag_array as $tag_value) {
				$member_tag_data = array();
				$member_tag_data['member_id'] = $member_id;
				$member_tag_data['tag'] = $tag_value;
				$member_tag_data['created_time'] = $this->current_time;

				$this->db->insert('member_tag',$member_tag_data);
			}
		}

		//处理更改密码

		$old_password = $this->getParameter('old_password');
		$new_password = $this->getParameter('new_password');
		$repeat_password = $this->getParameter('repeat_password');

		if ( $old_password && $new_password && $repeat_password && $new_password == $repeat_password) {
			$this->db->where('member_id',$member_id);
			$this->db->where('password',md5($old_password));

			$member_exist = $this->db->count_all_results('member');

			if ($member_exist) {
				$member_password_data['password'] = md5($new_password);
				$this->db->where('member_id',$member_id);
				$this->db->update('member',$member_password_data);
			} else {
				show_error('修改密码失败：原密码错误');
			}
		}

		redirect('profile');
	}

	function saveMemberVisit( $member_id ){
		$visitor_id = $this->current_member_id;

		$this->db->where('member_id',$member_id);
		$this->db->where('visitor_id',$visitor_id);
		$member_visit_information = $this->db->get_first('member_visit');

		$data['visit_time'] = $this->current_time;
		if (count($member_visit_information) == 0) {
			$data['member_id'] = $member_id;
			$data['visitor_id'] = $visitor_id;
			$this->db->insert('member_visit',$data);
		} else {
			$this->db->where('member_id',$member_id);
			$this->db->where('visitor_id',$visitor_id);
			$this->db->update('member_visit',$data);
		}
	}
//--------AJAX工具组

	function ajaxGetAttendActivity(){
		$member_id = $this->getParameter('member_id',$this->current_member_id);
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',5);
		$all_current_attend_activity_information = $this->extend_control->getCurrentAttendActivityInformation($member_id,$page_offset,$limit);

		echo json_encode($all_current_attend_activity_information);
	}

	function ajaxGetFollowActivity(){
		$member_id = $this->getParameter('member_id',$this->current_member_id);
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',5);
		$all_current_attention_activity_information = $this->extend_control->getCurrentFollowActivityInformation($member_id,$page_offset,$limit);

		echo json_encode($all_current_attention_activity_information);
	}

	function ajaxGetPublishActivity(){
		$member_id = $this->getParameter('member_id',$this->current_member_id);
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',5);
		$all_current_publish_activity_information = $this->extend_control->getCurrentPublishActivityInformation($member_id,$page_offset,$limit);

		echo json_encode($all_current_publish_activity_information);
	}

	function ajaxGetPublishBook() {
		$member_id = $this->getParameter('member_id',$this->current_member_id);
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',6);
		$all_book_information = $this->extend_control->getPublishBookInformation($member_id,$page_offset,$limit);

		echo json_encode($all_book_information);
	}

	function ajaxGetLikeBook(){
		$member_id = $this->getParameter('member_id',$this->current_member_id);
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',6);
		$all_like_book_information = $this->extend_control->getLikeBookInformation($member_id,$page_offset,$limit);

		echo json_encode($all_like_book_information);
	}

}



?>
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
		$member_information['is_friend'] = $this->extend_control->isFriend($this->current_member_id,$member_id);
		$member_information['my_page'] = $member_id == $this->current_member_id ? true : false;
		
		$this->ci_smarty->assign('member_information',$member_information);
		$this->ci_smarty->assign('member_id',$member_id);
		
		$template_view = $member_information['member_type'];
		//print_r($member_information);exit();
		$this->display($template_view, $member_information['member_name'].'的主页','view_css','view_js');
	}
	
	/**
     * 显示会员资料编辑页面，为不同的会员显示不同的页面
     */
	function edit(){
		$member_id = $this->current_member_id;
		$this->db->select('m.member_id, m.account as member_account, m.name as member_name, m.image as member_image, m.gender as member_gender, m.birthday as member_birthday, m.current_school as member_current_school, m.member_type, m.member_type_2, m.principal, m.qq as member_qq, m.email as member_email, m.phone as member_phone, m.organisation as member_organisation, m.title as member_title, m.address as member_address, m.tag as member_tag, m.description as member_description, m.content, m.school_name');
		$this->db->from('member as m');
		$this->db->where('m.member_id',$member_id);
		$member_information = $this->db->get_first();
		$this->ci_smarty->assign('member_information',$member_information);

		$template_name = 'edit_'.$member_information['member_type'];
		if( $member_information['member_type']=='student' ) {
			$template_title = '编辑个人资料';
		} else if ( $member_information['member_type']=='company' ) {
			$template_title = '编辑公司资料';
		} else {
			$template_title = '编辑组织资料';
		}
		//print_r($member_information);exit();
		$this->display($template_name,$template_title,'edit_css','edit_js');
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
		$tag = $this->getParameterWithOutTag('tag',Null);		//标签
		$description = $this->getParameterWithOutTag('description',Null);		//关于我
		$content = $this->getParameter('content',Null);	//组织介绍页

		$tag = trim(trim(str_replace('/',',',str_replace('.',',',str_replace(';',',',str_replace('，',',',str_replace(' ',',',$tag)))))),',');
		
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
		$member_data['tag'] = $tag;
		$member_data['description'] = $description;
		$member_data['content'] = $content;
		$member_data['qq'] = $qq;
		//print_r($member_data);exit();

		$this->db->where('member_id',$member_id);
		$this->db->update('member',$member_data);
		
		//处理会员标签
		
		$this->db->where('member_id',$member_id);
		$this->db->delete('member_tag');
		
		$tag_array = explode(',',$tag);
		
		//print_r($tag_array);
		
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
		
		$this->db->select('m.member_id, m.account, m.member_type, m.member_type_2, m.status as member_status, m.image as member_image, m.name as member_name, m.principal, m.gender, m.birthday, m.hobby, m.qq, m.mobilephone, m.phone, m.email, m.address, m.tag, m.description, m.content, m.created_time, m.modified_time, m.current_school, m.school_name as current_school_name');
		$this->db->from('member as m');
		//$this->db->join('public_school as ps','ps.school_id = m.current_school','LEFT');
		$this->db->where('member_id',$member_id);
		$member_information = $this->db->get_first();
					
		if ($member_information) {
			$this->setSessionValue('current_member_information',$member_information);
		}
		
		redirect('profile');
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
<?php
include_once "base_controller.php";
Class Register Extends BaseController {

	var $applicationFolder = "register"; 
	
	function __construct() {
		parent::__construct();
		
	}
	
	function index(){
		
		$this->displayWithoutLayout('index');
		
		
	}
	
	function saveForm(){
		$account = $this->getParameter('account',NULL);
		$password = $this->getParameter('password',NULL);
		$email = $this->getParameter('email',NULL);
		$member_type = $this->getParameter('member_type',NULL);
		$status = $this->getParameter('status','1');					//1为正常
		$image = $this->getParameter('image',$this->config->item('application_prefix').'upload/portrait.jpg');
		$name = $this->getParameterWithOutTag('name',NULL);
		$current_school = $this->getParameter('current_school_id',NULL);
		
		
		if ($account != '' && $password != '' && $member_type != '' && $email != '') {
			$this->db->where('account',$account);
			$member_information = $this->db->get_first('member');
			if ($member_information) {
				show_error('已存在的帐号，请重新选择一个帐号名');
			} else {
				$this->db->where('email',$email);
				$member_information = $this->db->get_first('member');
				
				if ($member_information) {
					show_error('已存在的邮箱，你是否忘记了密码');
				}else {
					$data['account'] = $account;
					$data['password'] = md5($password);
					$data['member_type'] = $member_type;
					$data['status'] = $status;
					$data['image'] = $image;
					$data['name'] = $name;
					$data['current_school'] = $current_school;
					$data['email'] = $email;
					$this->db->insert('member',$data);
					$member_id = $this->db->insert_id();
					
					$this->db->select('m.member_id, m.account, m.member_type, m.member_type_2, m.status as member_status, m.image as member_image, m.name as member_name, m.principal, m.gender, m.birthday, m.hobby, m.qq, m.mobilephone, m.phone, m.email, m.address, m.tag, m.description, m.content, m.created_time, m.modified_time, m.current_school, ps.name as current_school_name');
					$this->db->from('member as m');
					$this->db->join('public_school as ps','ps.school_id = m.current_school','LEFT');
					$this->db->where('member_id',$member_id);
					$this->db->where('password',md5($password));
					$member_information = $this->db->get_first();
					
					if ($member_information) {
						$this->setSessionValue('current_member_information',$member_information);
						redirect('register/detail_information');
					}
				}
			}
		} else {
			show_error('帐号、密码和邮箱不能为空，请重新输入');
		}
	}
	
	function detail_information(){
		$current_member_informaton = $this->getSessionValue('current_member_information');
		
		
		$this->ci_smarty->assign('member_information',$current_member_informaton);
		
		if ($current_member_informaton['member_type'] == 'student') {
			$this->displayWithOutLayout('student');
		} else if ($current_member_informaton['member_type'] == 'student_organization') {
			$this->displayWithOutLayout('student_organization');
		} else if ($current_member_informaton['member_type'] == 'commonweal_organization') {
			$this->displayWithOutLayout('commonweal_organization');
		} else if ($current_member_informaton['member_type'] == 'company') {
			$this->displayWithOutLayout('company');
		}
		
	}
	
	function save_detail_information(){
		
		$current_member_informaton = $this->getSessionValue('current_member_information');
		
		$principal = $this->getParameterWithOutTag('principal',Null);		//组织
		$organisation = $this->getParameterWithOutTag('organisation',Null);		//组织
		$title = $this->getParameterWithOutTag('title',Null);					//头衔
		$qq = $this->getParameterInt('qq',Null);								//QQ
		$phone = $this->getParameterWithOutTag('phone',Null);					//电话
		$address = $this->getParameterWithOutTag('address',Null);					//电话
		$image = $this->getParameter('image',Null);								//头像
		$gender = $this->getParameterWithOutTag('gender',Null);					//性别
		$birthday = $this->getParameterWithOutTag('birthday',Null);				//生日
		$tag = $this->getParameterWithOutTag('tag',Null);
		$description = $this->getParameterWithOutTag('description',Null);
		
		
		$tag = trim(trim(str_replace('/',',',str_replace('.',',',str_replace(';',',',str_replace('，',',',str_replace(' ',',',$tag)))))),',');
		
		//存入会员资料
		$member_data['image'] = $image;
		$member_data['organisation'] = $organisation;
		$member_data['principal'] = $principal;
		$member_data['title'] = $title;
		$member_data['gender'] = $gender;
		$member_data['qq'] = $qq;
		$member_data['phone'] = $phone;
		$member_data['address'] = $address;
		$member_data['birthday'] = $birthday;
		$member_data['tag'] = $tag;
		$member_data['description'] = $description;
		
		$this->db->where('member_id',$current_member_informaton['member_id']);
		$this->db->update('member',$member_data);
		
		//处理会员标签
		
		
		$tag_array = explode(',',$tag);
		
		//print_r($tag_array);
		
		foreach ($tag_array as $tag_value) {
			$member_tag_data = array();
			$member_tag_data['member_id'] = $current_member_informaton['member_id'];
			$member_tag_data['tag'] = $tag_value;
			$member_tag_data['created_time'] = date('Y-m-d H:i:s');
			
			$this->db->insert('member_tag',$member_tag_data);
		}
		
		
		$this->db->select('m.member_id, m.account, m.member_type, m.member_type_2, m.status as member_status, m.image as member_image, m.name as member_name,m.organisation, m.title, m.principal, m.gender, m.birthday, m.hobby, m.qq, m.mobilephone, m.phone, m.email, m.address, m.tag, m.description, m.content, m.created_time, m.modified_time, m.current_school, ps.name as current_school_name');
		$this->db->from('member as m');
		$this->db->join('public_school as ps','ps.school_id = m.current_school','LEFT');
		$this->db->where('member_id',$current_member_informaton['member_id']);
		$member_information = $this->db->get_first();
					
		if ($member_information) {
			$this->setSessionValue('current_member_information',$member_information);
		}
		
		
		redirect('index');
		
		
	}
	
	
}



?>
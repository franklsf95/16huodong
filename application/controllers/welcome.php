<?php
include_once "base_controller.php";
/**
* 控制注册
* 显示欢迎页面
*/
class Welcome extends BaseController {
	var $applicationFolder = "welcome"; 
	
	/**
	* 显示欢迎界面 或 重定向到主页
	*/
	function index()
	{
		if ($this->getSessionValue('current_member_information')) {
			redirect('index');
		}
		$this->display('index','欢迎');
	}

	/**
	* 显示随便看看页面 或 重定向到主页
	*/
	function demo()
	{
		if ($this->getSessionValue('current_member_information')) {
			redirect('index');
		}
		$this->display('demo','随便看看');
	}

	/**
	* 处理注册表单
	*
	* @param	一堆
	*/
	function saveForm(){
		$account = $this->getParameter('username',NULL);
		$password = $this->getParameter('password',NULL);
		$email = $this->getParameter('email',NULL);
		$member_type = $this->getParameter('member_type',NULL);
		$status = $this->getParameter('status','1');					//1为正常
		$image = $this->getParameter('image',$this->config->item('application_prefix').'upload/portrait.jpg');
		$name = $this->getParameter($member_type.'-name',NULL);
		$current_school = $this->getParameter('current_school_id',NULL);
		if ($account != '' && $password != '' && $member_type != '' && $email != '') {
			$this->db->where('account',$account);
			$member_information = $this->db->get_first('member');
			if ($member_information) {
				show_error('你注册的用户名已经存在');
			} else {
				$this->db->where('email',$email);
				$member_information = $this->db->get_first('member');
				
				if ($member_information) {
					show_error('每个邮箱只能注册一个用户');
				}else {
					$data['account'] = $account;
					$data['password'] = md5($password);
					$data['member_type'] = $member_type;
					$data['status'] = $status;
					$data['image'] = $image;
					$data['name'] = $name;
					$data['current_school'] = $current_school;
					$data['email'] = $email;
					$this->db->select('ps.name');
					$this->db->from('public_school as ps');
					$this->db->where('school_id',$current_school);
					$school = $this->db->get_first();
					$data['school_name']=$school['name'];
					$this->db->insert('member',$data);
					$member_id = $this->db->insert_id();
					$this->db->select('m.member_id, m.account, m.member_type, m.member_type_2, m.status as member_status, m.image as member_image, m.name as member_name, m.principal, m.gender, m.birthday, m.hobby, m.qq, m.mobilephone, m.phone, m.email, m.address, m.tag, m.description, m.content, m.created_time, m.modified_time, m.current_school, m.school_name as school_name');
					$this->db->from('member as m');
					//$this->db->join('public_school as ps','ps.school_id = m.current_school','LEFT');
					$this->db->where('member_id',$member_id);
					$this->db->where('password',md5($password));
					$member_information = $this->db->get_first();
					
					if ($member_information) {
						$this->setSessionValue('current_member_information',$member_information);
						redirect('index');
					}
				}
			}
		} else {
			show_error('首页是怎么检查你的！用户名、密码和邮箱有一项为空');
		}
	}
}


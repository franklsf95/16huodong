<?php
include_once "base_controller.php";
/**
* 控制注册
* 显示欢迎页面
*/
class Welcome extends BaseController {
	var $applicationFolder = "welcome"; 

	function __construct() {
		parent::__construct();

		if ($this->getSessionValue('current_member_id')) {
			redirect('index');
		}

		$this->load->model('db_public_area');
		$this->load->model('db_public_school');
	}
	
	/**
	* 显示欢迎界面 或 重定向到主页
	*/
	function index()
	{
		$this->display('index','欢迎');
	}

	/**
	* 显示随便看看页面 或 重定向到主页
	*/
	function demo()
	{
		$this->display('demo','随便看看','demo_css','demo_js');
	}

	/**
	* 处理注册表单
	*
	* @param	一堆
	*/
	function register(){
		$account = $this->getParameter('username',NULL);
		$password = $this->getParameter('password',NULL);
		$email = $this->getParameter('email',NULL);
		$member_type = $this->getParameter('member_type',NULL);
		$status = $this->getParameter('status','1');					//1为正常
		$image = $this->config->item('asset').'/img/default/portrait.jpg';
		$name = $this->getParameter($member_type.'-name',NULL);
		$school_id = $this->getParameter('current_school_id',NULL);
		$school_name = $this->getParameter($member_type.'-school',NULL);

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
					$data['school_id'] = $school_id;
					$data['school_name']=$school_name;
					$data['email'] = $email;
					$this->db->insert('member',$data);
					$newID = $this->db->insert_id();

					$this->setSessionValue('current_member_id',$newID);
					redirect('index');
				}
			}
		} else {
			show_error('首页是怎么检查你的！用户名、密码和邮箱有一项为空');
		}
	}
/*-----------------AJAX段---------------------*/

	/**
	* 处理ajax请求：获取所有【区】信息
	*
	* @param	city_id 	城市ID
	*/
	function ajaxGetAllAreaInformation(){
		$parent_id = $this->getParameter('city_id',NULL);
		$all_area_information = $this->db_public_area->getAllAreaInformation($parent_id);
		echo json_encode($all_area_information);
	}

	/**
	* 处理ajax请求：获取所有【学校】信息
	*
	* @param	area_id 	区ID
	*/
	function ajaxGetAllSchoolInformation(){
		$area_id = $this->getParameter('area_id',NULL);
		$all_school_information = $this->db_public_school->getAllSchoolInformation($area_id);
		echo json_encode($all_school_information);
	}

	/**
	* 处理ajax请求：获取demo活动信息（前10个）
	*/
	function ajaxGetDemoActivityInformation() {
		$all_new_activity_information = $this->extend_control->getLatestActivities(0,10);
		echo json_encode($all_new_activity_information);
	}
}


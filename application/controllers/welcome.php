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

		$this->load->model('db_public_area');
		$this->load->model('db_public_school');
	}

	/**
	* 显示欢迎界面
	*/
	function index()
	{
		if( $this->session->userdata('current_member_id') ) {
			redirect('index');
		}

		$ref = $this->getParameter('ref');
		$this->ci_smarty->assign('ref',$ref);
		$this->display('index','欢迎');
	}

	/**
	* 显示随便看看页面
	*/
	function demo() {
		$this->display('demo','随便看看','demo_css','demo_js');
	}

	/**
	* 给未登录用户显示活动详情
	*/
	function demo_activity_view( $activity_id ) {
		if(!$activity_id) redirect('welcome/demo');

		$activity_information = $this->extend_control->getActivityInformationById($activity_id);
		$activity_information['rate'] = $this->extend_control->getActivityRateInformation($activity_id);

		$count = $this->extend_control->countAllActivityComment($activity_id);
		$this->ci_smarty->assign('activity_information',$activity_information);

		$this->display('demo_activity_view',$activity_information['activity_name'].' | 随便看看','demo_activity_view_css','demo_activity_view_js');
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
		$area = $this->getParameter($member_type=='stu'?'area1':'area2',NULL);
		$city = $this->getParameter($member_type=='stu'?'city1':'city2',NULL);
		$school_id = $this->getParameter('school_id',NULL);
		$school_name = $this->getParameter($member_type.'-school',NULL);
		/*
		if( !$school_id && ( $member_type=='stu'||$member_type=='org' ) )
			show_error('请输入一个数据库中存在的学校~ 从下拉列表中选择即可。');
		*/
		if( $name==NULL )
			show_error('姓名/机构全名不可为空！');

		$this->db->where('account',$account);
		if( $this->db->get_first('member') )
			show_error('这个用户名已经被人注册过啦~');

		$this->db->where('email',$email);
		if( $this->db->get_first('member') )
			show_error('你已经用这个 E-mail 地址注册过啦~');

		$data['account'] = $account;
		$data['password'] = md5($password);
		$data['member_type'] = $member_type;
		$data['status'] = $status;
		$data['image'] = $image;
		$data['name'] = $name;
		$data['area-1'] = $area;
		$data['area-3'] = $city;
		$data['school_id'] = $school_id;
		$data['school_name']=$school_name;
		$data['email'] = $email;
		$data['created_time'] = $this->current_time;
		$this->db->insert('member',$data);

		//Set session
		$this->session->set_userdata( 'current_member_id', $this->db->insert_id() );

		redirect('profile/edit');
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
	function ajaxGetDemoActivities() {
		$all_new_activity_information = $this->extend_control->getHotActivities(10);
		echo json_encode($all_new_activity_information);
	}
}


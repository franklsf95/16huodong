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
	* 显示欢迎界面
	*/
	function index()
	{
		$ref = $this->input->get('ref',TRUE);
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
	function demo_activity_view() {
		$activity_id = $this->getParameter('id');
		
		if(!$activity_id) redirect('welcome/demo');
		
		$activity_information = $this->extend_control->getAcitivityInformationById($activity_id);
		$activity_information['is_attend'] = $this->extend_control->isMemberAttendActivity($member_id,$activity_id);
		$activity_information['is_attention'] = $this->extend_control->isMemberFollowActivity($member_id,$activity_id);
		$activity_information['is_publisher'] = $this->extend_control->isMemberPublishActivity($member_id,$activity_id);
		$activity_information['rate'] = $this->extend_control->getActivityRateInformation($activity_id);

		$count = $this->extend_control->countAllActivityComment($activity_id);
		$this->ci_smarty->assign('activity_information',$activity_information);

		$this->display('demo_activity_view',$activity_information['activity_name'].' | 随便看看','demo_activity_view_css');
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
		$school_id = $this->getParameter('school_id',NULL);
		$school_name = $this->getParameter($member_type.'-school',NULL);

		if( !$school_id && ( $member_type=='stu'||$member_type=='org' ) )
			show_error('请输入一个数据库中存在的学校~ 从下拉列表中选择即可。');

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
		$data['school_id'] = $school_id;
		$data['school_name']=$school_name;
		$data['email'] = $email;
		$this->db->insert('member',$data);

		$this->setSessionValue('current_member_id', $this->db->insert_id() );
		redirect('index');
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


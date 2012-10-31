<?php
include_once dirname(__FILE__)."/../base_controller.php";
Class Login Extends BaseController {
	var $applicationFolder = "login";
	var $viewFolder = 'admin';
	var $layoutFolder = 'admin/layout/';
	
	function __construct() {
		parent::__construct();
		
		//重新定义后台模板地址
		if ($this->applicationFolder) {
		
			$this->viewFolder = 'admin';	
			$this->layoutFolder = 'admin/layout/';
			
			$this->viewFolder = $this->viewFolder.'/'.$this->applicationFolder;
		}
	
	}
	
	function index(){
		$this->ci_smarty->view($this->viewFolder . '/index');
	}
	
	function loginSubmit(){
		$p_username = $this->getParameter('username',Null);
		$p_password = $this->getParameter('password',Null);
		if ($p_username && $p_password) {
			$this->db->select('au.*,ag.application_group_id,ag.name as application_group_name');
			$this->db->from('application_user as au');
			$this->db->join('application_group as ag','ag.application_group_id = au.application_group_id');
			$this->db->where('au.username',$p_username);
			$this->db->where('au.password',md5($p_password));
			$this->db->where('au.status','Y');
			$application_user_information = $this->db->get_first();
			
			
			if ($application_user_information) {
				$this->setSessionValue('application_user_id',$application_user_information['application_user_id']);
				$this->setSessionValue('application_group_id',$application_user_information['application_group_id']);
				$this->setSessionValue('application_user_name',$application_user_information['name']);
				$this->setSessionValue('application_user_username',$application_user_information['username']);
				$this->setSessionValue('application_group_name',$application_user_information['application_group_name']);
				
				$this->forward('../admin/index/index');
			} else $this->forward('../admin/login/index');
		}else $this->forward('../admin/login/index');
	
	}
	
	function logoutSubmit(){
		$_SESSION = array();
		$this->forward('../admin/login/index');
	}
	
}



?>
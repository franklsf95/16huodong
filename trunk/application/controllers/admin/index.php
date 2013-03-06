<?php
include_once "admin_controller.php";
Class Index Extends AdminController {
	var $applicationFolder = "index";
	function __construct() {
		parent::__construct();
		
	}
	
	function index(){
                $username=$this->getSessionValue('application_user_username');
                $this->ci_smarty->assign('username',$username);
		$this->displayWithLayout('index');
	
	}
	
	function loginSubmit(){
		$p_username = $this->getParameter('username',Null);
		$p_password = $this->getParameter('password',Null);
		
		if ($p_username && $p_password) {
			$this->db->select('au.*,ag.application_group_id,ag.name_chs as application_group_name');
			$this->db->from('application_user as au');
			$this->db->join('application_group as ag','ag.application_group_id = au.application_group_id');
			$this->db->where('au.username',$p_username);
			$this->db->where('au.password',md5($p_password));
			$this->db->where('au.state','Y');
			$application_user_information = $this->db->get_first();
			
			
			if ($application_user_information) {
				$this->setSessionValue('application_user_id',$application_user_information['application_user_id']);
				$this->setSessionValue('application_group_id',$application_user_information['application_group_id']);
				$this->setSessionValue('application_user_name',$application_user_information['name_chs']);
				$this->setSessionValue('application_group_name',$application_user_information['application_group_name']);
				
			
			} else echo "false";
		
		
		}
	
	}
	
}



?>
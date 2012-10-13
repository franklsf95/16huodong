<?php
include_once "admin_controller.php";
Class Application_user Extends AdminController {

	var $applicationFolder = "application_user";
	var $tableName="application_user";
	var $idFieldName = 'application_user_id';
	
	function __construct() {
		parent::__construct();
		$this->load->model('db_application_user');
		$this->load->model('db_application_group');
		
		$all_application_group_information = $this->db_application_group->getAllApplicationGroup();
		$this->ci_smarty->assign('all_application_group_information',$all_application_group_information);
		
	}
	
	function index(){
		$p_page = $this->getParameter('page',1);
		$p_limit = $this->getParameter('limit',10);
		
		$count = $this->db->count_all('application_user');
		$page_information = $this->createPageInformation($count,$p_page,$p_limit);
		
		$all_application_user_information = $this->db_application_user->getApplicationUserByPageInformation($p_limit,$page_information['page_offset']);
		
		
		$this->ci_smarty->assign('page_information', $page_information);
		$this->ci_smarty->assign('count', $count);
		$this->ci_smarty->assign('all_application_user_information',$all_application_user_information);
		$this->displayWithLayout('index');
	}
	
	function edit(){
	
		$application_user_id = $this->getParameter('cid',NULL);
		if ($application_user_id) {
			$application_user_information = $this->db_application_user->getApplicationUserInformation($application_user_id);
			$this->ci_smarty->assign('application_user_information',$application_user_information);
			$this->ci_smarty->assign('cid',$application_user_id);
		}
		
		
		$this->displayWithLayout('edit');
	}
	
	function _saveItem($isNew,$id,&$param) {
		$current_time = date('Y-m-d H:i:s');
		$application_group_id = $this->getParameter('application_group_id',Null);
		$status = $this->getParameter('status','Y');
		$username = $this->getParameter('username',Null);
		$name = $this->getParameter('name',$username);
		$old_password = $this->getParameter('old_password',Null);
		$password = $this->getParameter('password',Null);
		$repeat_password = $this->getParameter('repeat_password',Null);
		$email = $this->getParameter('email',Null);
		

		$data = array();
		$data['application_group_id'] = $application_group_id;
		$data['username'] = $username;
		$data['name'] = $name;
		$data['status'] = $status;
		$data['email'] = $email;
		$data['modified_time'] = $current_time;
		$data['modified_by'] = '-1';
		
		
		if ($isNew && $password == $repeat_password) {
		
			$data['password'] = md5($password);
			$data['created_time'] = $current_time;
			$data['created_by'] = '-1';
			$this->db->insert('application_user',$data);
		}else {
			$this->db->where('application_user_id',$id);
			$this->db->where('password',md5($old_password));
			
			if ($this->db->count_all_results('application_user') == 1) {
				
				if ($password != '' && $password == $repeat_password) {
					$data['password'] = md5($password);
				}
				
				$this->db->where('application_user_id',$id);
				$this->db->update('application_user',$data);
			}
		}
		
	}
	
	function get_application_user_information() {
		$application_user_id = $this->getParameter('application_user_id',Null);
		if ($application_user_id) {
			$application_user_information = $this->db_application_user->getApplicationUserInformation($application_user_id);
			$application_user_information['result'] = "success";
			echo json_encode($application_user_information);
		}
	}
	
}



?>
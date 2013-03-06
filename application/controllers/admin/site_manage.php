<?php
include_once "admin_controller.php";
Class Site_manage Extends AdminController {

	var $applicationFolder = "site_manage"; 
	
	function __construct() {
		parent::__construct();
		
	}
	
	function index(){
		$all_running_value = $this->db->get('running_value')->result_array();
		
		foreach($all_running_value as $running_value) {
			if($running_value['code'] == 'limit_query' || $running_value['code'] == 'limit_comment' || $running_value['code'] == 'limit_message' || $running_value['code'] == 'svn_version') {
				$key = $running_value['code'];
				$site_manage_information[$key] = $running_value['value'];
			}
		}
		
		$this->ci_smarty->assign('site_manage_information',$site_manage_information);
		
		
		$this->displayWithLayout('index');
	}
	
	function saveItem() {
	
		$limit_query = $this->getParameter('limit_query','10');
		$limit_comment = $this->getParameter('limit_comment','20');
		$limit_message = $this->getParameter('limit_message','20');
		$svn_version = $this->getParameter('svn_version','1');
		
		$data['limit_query'] = $limit_query;
		$data['limit_comment'] = $limit_comment;
		$data['limit_message'] = $limit_message;
		$data['svn_version'] = $svn_version;
		
		
		foreach($data as $key => $value) {
			
			$this->db->where('code',$key);
			$this->db->from('running_value');
			$code_exist = $this->db->count_all_results();
			if ($code_exist) {
				$this->db->where('code',$key);
				$data1['value'] = $value;
				$this->db->update('running_value',$data1);
			}else {
				$data1['code'] = $key;
				$data1['value'] = $value;
				$this->db->insert('running_value',$data1);
			
			}
		}
		$this->forward('../admin');
	}
}



?>
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
			if($running_value['code'] == 'site_status' || $running_value['code'] == 'site_name' || $running_value['code'] == 'site_keyword' || $running_value['code'] == 'site_description' || $running_value['code'] == 'site_copyright') {
				$key = $running_value['code'];
				$site_manage_information[$key] = $running_value['value'];
			}
		}
		
		$this->ci_smarty->assign('site_manage_information',$site_manage_information);
		
		
		$this->displayWithLayout('index');
	}
	
	function saveItem() {
	
		$site_status = $this->getParameter('site_status','Y');
		$site_name = $this->getParameter('site_name',Null);
		$site_keyword = $this->getParameter('site_keyword',Null);
		$site_description = $this->getParameter('site_description',Null);
		$site_copyright = $this->getParameter('site_copyright',Null);
		
		$data['site_status'] = $site_status;
		$data['site_name'] = $site_name;
		$data['site_keyword'] = $site_keyword;
		$data['site_description'] = $site_description;
		$data['site_copyright'] = $site_copyright;
		
		
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
		$this->forward('../admin/site_manage');
	}
}



?>
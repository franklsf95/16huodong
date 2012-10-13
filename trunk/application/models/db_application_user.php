<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once APPPATH."models/db_base_model.php";

class Db_application_user extends BaseModel {
    var $tableName = 'application_user';
    
    function __construct() {
		parent::__construct();
		
	}
	
	function getApplicationUserByPageInformation($limit,$page_offset){
		$this->db->select("au.application_user_id, au.username, au.name as application_user_name, au.email,au.status, ag.application_group_id, ag.code as application_group_code, ag.name as application_group_name");
		$this->db->from("application_user as au");
		$this->db->join('application_group as ag','au.application_group_id = ag.application_group_id','LEFT');
		$this->db->order_by('au.application_user_id','ASC');
		$all_application_user_information = $this->db->get("",$limit,$page_offset)->result_array();
		
		return $all_application_user_information;
	}
	
	function getApplicationUserInformation($application_user_id) {
		$this->db->from('application_user');
		$this->db->where('application_user_id',$application_user_id);
		$application_user_information = $this->db->get_first();
		return $application_user_information;
	}
	
}
?>

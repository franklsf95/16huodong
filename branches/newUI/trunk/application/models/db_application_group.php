<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once APPPATH."models/db_base_model.php";

class Db_application_group extends BaseModel {
    var $tableName = 'application_group';
    
    function __construct() {
		parent::__construct();
		
	}
	
	function getAllApplicationGroup() {
	
		$all_application_group_information = $this->db->get($this->tableName)->result_array();
		return $all_application_group_information;
	
	}
	
}
?>

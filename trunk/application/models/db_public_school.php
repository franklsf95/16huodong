<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once APPPATH."models/db_base_model.php";

class Db_public_school extends BaseModel {
    var $tableName = 'public_school';
	var $idFieldName = "school_id";
    
    function __construct() {
		parent::__construct();
		
	}
	
	function getPublicSchoolInformation($school_id){
		$this->db->where('school_id',$school_id);
		$public_school_information = $this->db->get_first('public_school');
		return $public_school_information;
	}
	
	function getAllSchoolInformation($area_id = NULL) {
		if ($area_id) {
			$this->db->where('area',$area_id);
		}
		$all_school_information = $this->db->get('public_school')->result_array();
		return $all_school_information;
	}
	
	
}
?>

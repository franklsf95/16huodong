<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once APPPATH."models/db_base_model.php";

class Db_activity extends BaseModel {
    var $tableName = 'activity';
	var $idFieldName = "activity_id";
    
    function __construct() {
		parent::__construct();
		
	}
	
	function getAllActivityByMemberId($member_id){
	
	}
	
	function _____suantou_legacy() {
		$this->db->where('type','province');
		$all_province_information = $this->db->get('public_area')->result_array();
		return $all_province_information;
	}
	
	function getAllCityInformation($area_id) {
		$this->db->where('type','city');
		$this->db->where('parent_id',$area_id);
		$all_city_information = $this->db->get('public_area')->result_array();
		return $all_city_information;
	}
	
	function getAllAreaInformation($area_id) {
		$this->db->where('type','area');
		$this->db->where('parent_id',$area_id);
		$all_area_information = $this->db->get('public_area')->result_array();
		return $all_area_information;
	}
	
}
?>

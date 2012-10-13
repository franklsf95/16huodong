<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once APPPATH."models/db_base_model.php";

class Db_running_value extends BaseModel {
    var $tableName = 'running_value';
    
    function __construct() {
		parent::__construct();
		
	}
	
	
	function get_running_value($code){
		$this->db->from('running_value');
		$this->db->where('code',$code);
		$running_value_information = $this->db->get_first();
		return $running_value_information;
	}
	
}
?>

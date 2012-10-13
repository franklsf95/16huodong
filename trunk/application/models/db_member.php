<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once APPPATH."models/db_base_model.php";

class Db_member extends BaseModel {
    var $tableName = 'member';
	var $idFieldName = "member_id";
    
    function __construct() {
		parent::__construct();
		
	}
	
	
}
?>

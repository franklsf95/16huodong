<?php
include_once "admin_controller.php";
Class Sendmail Extends AdminController {

	var $applicationFolder = "sendmail"; 
	var $tableName="member";
	var $idFieldName = 'member_id';
	
	function __construct() {
		parent::__construct();
	}
	
	function index(){

		$this->displayWithLayout('index');
	}
	
	function send()
	{
	$userid=$this->getSessionValue('application_user_id');
	$category=$this->getParameter('category',NULL);
	$type=$this->getParameter('type',NULL);
	$code=$this->getParameter('code',NULL);
	
	//$this->db->select('m.*');
	//$this->db->from('member as m');
	$member=$this->db->query('select * from 16_member;')->result_array();
	foreach($member as $m)
		{
		$data=array();
		$data['member_id']=$userid;
		$data['target_id']=$m['member_id'];
		$data['category']=$category;
		$data['type']=$type;
		$data['code']=$code;
		$data['created_time']=date('Y-m-d H:i:s');
		$this->db->insert('system_message',$data);
		}
	$this->forward('../admin/sendmail/index');
	}
	


	
	
	
}



?>
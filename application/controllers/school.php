<?php
include_once "base_action_controller.php";
/**
* “我的学校”板块
*/
Class School Extends BaseActionController {

	var $applicationFolder = "school"; 
	
	function __construct() {
		parent::__construct();
		
	}
	
	/**
	* 显示学校主页，默认为本校
	*
	* @param 	int 	$id 	学校ID
	*/
	function index( $id = 0 ) {
		if( $id==0 )
			$id = $this->current_member_information['school_id'];

		$this->ci_smarty->assign('school_id',$id);
		$this->ci_smarty->assign('school_name','test_name');

		$this->display('index', $school_name,'','');
	}

}

?>
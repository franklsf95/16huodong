<?php
include_once "base_action_controller.php";
/**
* 给已登录用户显示首页
*/
Class Index Extends BaseActionController {

	var $applicationFolder = "index"; 
	
	function __construct() {
		parent::__construct();
	}
	
	/**
	* 显示全站动态
	*/
	function index() {
		$hot_activities = $this->extend_control->getHotActivities();

		$this->ci_smarty->assign('hot_activities',$hot_activities);

		//print_r($hot_activities);exit();
		$this->display( 'index', '首页', 'index_css', 'index_js' );
	}
}
?>
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
	function index(){
		$all_member_visit_information = $this->extend_control->getMemberVisitInformation($this->current_member_id,5);
		$all_news_information = $this->extend_control->getAboutMemberNewsInformation($this->current_member_id);
		$all_new_activity_information = $this->extend_control->getNewActivityInformation();
		$all_active_attend_activity_information = $this->extend_control->getActiveAttendActivityInformation($this->current_member_id);
		
		//$all_activity_information = $this->extend_control->getAllActivitiyInformation($page_offset,$limit);
		
		$this->ci_smarty->assign('all_member_visit_information',$all_member_visit_information);
		$this->ci_smarty->assign('all_news_information',$all_news_information);
		$this->ci_smarty->assign('all_new_activity_information',$all_new_activity_information);
		$this->ci_smarty->assign('all_active_attend_activity_information',$all_active_attend_activity_information);
		
		$this->display( 'index', '首页', 'index_css', 'index_js' );
	}
}
?>
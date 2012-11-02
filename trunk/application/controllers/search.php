<?php
include_once "base_action_controller.php";
/**
* 处理各种搜索请求，返回搜索结果
*/
Class Search Extends BaseActionController {

	var $applicationFolder = "search"; 
	
	function __construct() {
		parent::__construct();
		
	}
	
	/**
	* 显示：重定向到首页
	*/
	function index(){
		redirect('index');
	}

	/**
	* 处理搜人请求
	*
	* @param 	post 	member_name 	搜索的人或组织名字
	*/
	function queryMember() {
		$member_name = $this->getParameter('member_name');
		$p_page = $this->getParameter('page',1);
		$limit = $this->LIMIT;
		$offset = ($p_page-1) * $limit;

		$count = $this->extend_control->searchMemberCountByName($member_name);
		$all_members = $this->extend_control->searchMemberByName($member_name,$offset, $limit);
		$this->setPageInformation($count, $p_page, $limit, 'search/queryMember');

		$this->ci_smarty->assign('search_query',$member_name);
		$this->ci_smarty->assign('all_members',$all_members);
		//print_r($page_information);exit();
		$this->display('result_members','搜索'.$member_name.'的结果');
	}

	/**
	* 处理搜活动请求
	*
	* @param 	string 	$query 	搜索人名或组织
	*/
	function queryActivity() {
		$activity_name = $this->getParameter('activity_name');
		$member_type = $this->getParameter('member_type');
		$is_current_school = $this->getParameter('is_current_school');
		$is_open = $this->getParameter('is_open');
		$is_active = $this->getParameter('is_active');

		if( $is_current_school ) {
			$school_id = $this->current_member_information['school_id'];
		}

		$all_activities = $this->extend_control->searchActivity($activity_name,$school_id,null,$member_type,null,$is_open,$is_active);
		$this->ci_smarty->assign('all_activities',$all_activities);
		//print_r($all_activities);exit();
		$this->display('result_activities','搜索'.$query.'的结果');
	}
}



?>
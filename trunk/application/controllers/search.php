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
	* 分拣搜索请求
	*
	* @param 	post 	member_name 	搜索的人或组织名字
	*/
	function query() {
		$query_member_name = $this->getParameter('member_name');

		if( $query_member_name ) {
			$this->queryMember( $query_member_name );
		}
	}

	/**
	* 处理搜人请求
	*
	* @param 	string 	$query 	搜索人名或组织
	*/
	function queryMember( $query ) {
		$all_members = $this->extend_control->searchMemberByName($query,0);
		$this->ci_smarty->assign('all_members',$all_members);
		//print_r($all_members);exit();
		$this->display('result_members','搜索'.$query.'的结果');
	}
}



?>
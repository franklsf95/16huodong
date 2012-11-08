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
	* 显示首页
	*/
	function index() {
		$hot_activities = $this->extend_control->getHotActivities();
		$this->ci_smarty->assign('hot_activities',$hot_activities);

		//print_r($hot_activities);exit();
		$this->display( 'index', '首页', 'index_css', 'index_js' );
	}
	
	/**
	* 加载首页全站动态
	*
	* @param 	page_offset,limit
	*/
	function ajaxGetAllNewsFeed(){
		$page_offset = $this->getParameter('page_offset','');
		$limit = $this->getParameter('limit','');

		$all_news_feed = $this->extend_control->getAllNewsFeed($page_offset, $limit);
		$news_array = Array();
		//print_r($all_news_feed);exit();

		foreach ($all_news_feed as $news) {
			$data['created_time'] = $news['created_time'];
			$data['image'] = $news['member_image'];
			$data['msg'] = $this->decodeMessage($data);
			$news_array[] = $data;
		} //end foreach
		echo json_encode($news_array);
	}

}
?>
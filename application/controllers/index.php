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
		$hot_activities = $this->extend_control->getHotActivities(9);

		foreach( $hot_activities as $i )
			$hot_activities[] = $i;

		foreach( $hot_activities as $key=>$i ) {
			$temp[] = $i;
			if( $key%3==2 ) {
				$hot_activity_groups[] = $temp;
				$temp = Array();
			}
		}

		$this->ci_smarty->assign('hot_activity_groups',$hot_activity_groups);
		//print_r($hot_activity_groups);exit();
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
			$data['member_id'] = $news['member_id'];
			$data['msg'] = $this->decodeMessage($news);
			$news_array[] = $data;
		} //end foreach
		echo json_encode($news_array);
	}

	/**
	* 处理联系我们表单
	*/
	function saveFeedback(){
		$member_id = $this->current_member_id;
		$email = $this->getParameter('feedback_email',NULL);
		$feedback = $this->getParameter('feedback',NULL);
		$data['member_id']=$member_id;
		$data['email']=$email;
		$data['message']=$feedback;
		$this->db->insert('feedback',$data);
		redirect('index');
	}

}
?>
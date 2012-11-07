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
	
	function ajaxGetAllNewsFeed(){
		$page_offset = $this->getParameter('page_offset','');
		$limit = $this->getParameter('limit','');
		$json='Array(';
		$all_news_feed = $this->extend_control->getAllNewsFeed($page_offset, $limit);
		foreach ($all_news_feed as $news_feed) {
			if ($news_feed['category']=='activity') {
				$this->db->select('name');
				$this->db->from('activity');
				$this->db->where('activity_id',$news_feed['code']);
				$activity=$this->db->get_first();
				if ($activity) {
					if ($news_feed['type']=='publish_activity') {
						$json.='Array(\'created_time\':'.$news_feed['created_time'].', \'message\':<a href="http://'.$_SERVER ['HTTP_HOST'].'/index.php/profile?id='. $news_feed['member_id']. '">'.$news_feed['member_name'].'</a>发布了活动'. ' <a href="http://'.$_SERVER ['HTTP_HOST'].'/index.php/activity/view?id='. $news_feed['code']. '">'.$activity['name'].'</a>)';
					} else if ($news_feed['type']=='publish_activity') {
						$json.='Array(\'created_time\':'.$news_feed['created_time'].', \'message\':<a href="http://'.$_SERVER ['HTTP_HOST'].'/index.php/profile?id='. $news_feed['member_id']. '">'.$news_feed['member_name'].'</a>修改了活动'. ' <a href="http://'.$_SERVER ['HTTP_HOST'].'/index.php/activity/view?id='. $news_feed['code']. '">'.$activity['name'].'</a>)';
					} else if ($news_feed['type']=='new_comment') {
						$json.='Array(\'created_time\':'.$news_feed['created_time'].', \'message\':<a href="http://'.$_SERVER ['HTTP_HOST'].'/index.php/profile?id='. $news_feed['member_id']. '">'.$news_feed['member_name'].'</a>评论了<a href="http://'.$_SERVER ['HTTP_HOST'].'/index.php/profile?id='. $news_feed['target_id']. '">'.$news_feed['target_name']. '的活动<a href="http://'.$_SERVER ['HTTP_HOST'].'/index.php/activity/view?id='. $news_feed['code']. '">'.$activity['name'].'</a>)';
					} else if ($news_feed['type']=='new_reply') {
						$json.='Array(\'created_time\':'.$news_feed['created_time'].', \'message\':活动发布者<a href="http://'.$_SERVER ['HTTP_HOST'].'/index.php/profile?id='. $news_feed['member_id']. '">'.$news_feed['member_name'].'</a>回复了<a href="http://'.$_SERVER ['HTTP_HOST'].'/index.php/profile?id='. $news_feed['target_id']. '">'.$news_feed['target_name']. '对活动<a href="http://'.$_SERVER ['HTTP_HOST'].'/index.php/activity/view?id='. $news_feed['code']. '">'.$activity['name'].'</a>的评论)';
					} else if ($news_feed['type']=='attend_activity') {
						$json.='Array(\'created_time\':'.$news_feed['created_time'].', \'message\':<a href="http://'.$_SERVER ['HTTP_HOST'].'/index.php/profile?id='. $news_feed['member_id']. '">'.$news_feed['member_name'].'</a>报名参加<a href="http://'.$_SERVER ['HTTP_HOST'].'/index.php/profile?id='. $news_feed['target_id']. '">'.$news_feed['target_name']. '的活动<a href="http://'.$_SERVER ['HTTP_HOST'].'/index.php/activity/view?id='. $news_feed['code']. '">'.$activity['name'].'</a>)';
					} else if ($news_feed['type']=='activity_apply_pass') {
						$json.='Array(\'created_time\':'.$news_feed['created_time'].', \'message\':活动发布者<a href="http://'.$_SERVER ['HTTP_HOST'].'/index.php/profile?id='. $news_feed['member_id']. '">'.$news_feed['member_name'].'</a>通过了<a href="http://'.$_SERVER ['HTTP_HOST'].'/index.php/profile?id='. $news_feed['target_id']. '">'.$news_feed['target_name']. '在活动<a href="http://'.$_SERVER ['HTTP_HOST'].'/index.php/activity/view?id='. $news_feed['code']. '">'.$activity['name'].'的报名</a>)';
					}
				}
			} else if ($news_feed['type']=='add_friend') {
				$json.='Array(\'created_time\':'.$news_feed['created_time'].', \'message\':<a href="http://'.$_SERVER ['HTTP_HOST'].'/index.php/profile?id='. $news_feed['member_id']. '">'.$news_feed['member_name'].'</a>与<a href="http://'.$_SERVER ['HTTP_HOST'].'/index.php/profile?id='. $news_feed['target_id']. '">'.$news_feed['target_name']. '成为了好友)';
			}
		$json.=')';
		echo json_encode($json);
	}
?>
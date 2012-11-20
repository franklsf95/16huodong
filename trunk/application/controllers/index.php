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

		foreach( $hot_activities as $key=>$i ) {
			$temp[] = $i;
			if( $key%3==2 ) {
				$hot_activity_groups[] = $temp;
				$temp = Array();
			}
		}
		if( count($temp)>0 )
			$hot_activity_groups[] = $temp;

		$this->ci_smarty->assign('hot_activity_groups',$hot_activity_groups);
		//print_r($hot_activity_groups);exit();
		$this->display( 'index', '首页', 'index_css', 'index_js' );
	}
	
	/**
	* 加载首页全站动态
	*
	* @param 	page_offset,limit
	*/
	function ajaxGetNewsFeed(){
		$page_offset = $this->getParameter('page_offset','');
		$limit = $this->getParameter('limit','');

		$all_news_feed = $this->extend_control->getDistinctNewsFeed($page_offset, $limit);
		//print_r($all_news_feed);

		foreach ($all_news_feed as &$news) {
			$news['message'] = $this->decodeMessage($news);
		} //end foreach
		echo json_encode($all_news_feed);
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

	/**
	* 工具函数：将系统信息解释为可显示文本
	*
	* @param 	Array 	data 	系统信息
	*
	* @return 	string 	message 	HTML消息文本
	*/
	function decodeMessage($data) {
		if ( $data['activity_id']>0 ) {
			$activity_id = $data['activity_id'];
			$activity_name = idx( $this->extend_control->getActivityBasicById($activity_id), 'activity_name' );
			switch( $data['type'] ) {
				case 'new_activity':
					$message = "<a href='".site_url("profile?id=".$data['member_id'])."'>".$data['member_name']."</a> 发起了活动 <a href='".site_url("activity/view/$activity_id")."'>$activity_name</a>";
					break;
				case 'edit_activity':
					$message = "<a href='".site_url("profile?id=".$data['member_id'])."'>".$data['member_name']."</a> 修改了活动 <a href='".site_url("activity/view/$activity_id")."'>$activity_name</a> 的内容";
					break;
				case 'attend_activity':
					$message = "<a href='".site_url("profile?id=".$data['member_id'])."'>".$data['member_name']."</a> 报名参加了活动 <a href='".site_url("activity/view/$activity_id")."'>$activity_name</a>";
					break;
				case 'follow_activity':
					$message = "<a href='".site_url("profile?id=".$data['member_id'])."'>".$data['member_name']."</a> 关注了活动 <a href='".site_url("activity/view/$activity_id")."'>$activity_name</a>";
					break;
				case 'rate_up':
					$message = "<a href='".site_url("profile?id=".$data['member_id'])."'>".$data['member_name']."</a> 对活动 <a href='".site_url("activity/view/$activity_id")."'>$activity_name</a> 竖了大拇指";
					break;
				case 'rate_down':
					$message = "<a href='".site_url("profile?id=".$data['member_id'])."'>".$data['member_name']."</a> 对活动 <a href='".site_url("activity/view/$activity_id")."'>$activity_name</a> 竖了小拇指";
					break;
			}
		} elseif ( $data['book_id']>0 ) {
			$book_id = $data['book_id'];
			$book_name = idx( $this->extend_control->getBookBasicById($book_id), 'book_name');

			switch( $data['type'] ) {
				case 'new_book':
					$message = "<a href='".site_url("profile?id=".$data['member_id'])."'>".$data['member_name']."</a> 出版了微型书 <a href='".site_url("library/view?id=$book_id")."'>$book_name</a>";
					break;
				case 'edit_book':
					$message = "<a href='".site_url("profile?id=".$data['member_id'])."'>".$data['member_name']."</a> 润色了微型书 <a href='".site_url("library/view?id=$book_id")."'>$book_name</a>的内容";
					break;
				case 'like_book':
					$message = "<a href='".site_url("profile?id=".$data['member_id'])."'>".$data['member_name']."</a> 喜欢了微型书 <a href='".site_url("library/view?id=$book_id")."'>$book_name</a>";
					break;
			}
		}
		return $message;
	}

}
?>
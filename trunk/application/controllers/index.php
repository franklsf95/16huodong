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

		foreach ($all_news_feed as $news) {
			$data['created_time'] = $news['created_time'];
			$data['image'] = $news['member_image'];

			if ( $news['category']=='activity' ) {
				$activity_id = $news['code'];
				$activity_name = $this->extend_control->getActivityNameById($activity_id);
				switch( $news['type'] ) {
					case 'publish_activity':
						$data['msg'] = "<a href='".site_url("profile?id=".$news['member_id'])."'>".$news['member_name']."</a> 发起了活动 <a href='".site_url("activity/view?id=$activity_id")."'>$activity_name</a>";
						break;
					case 'edit_activity':
						$data['msg'] = "<a href='".site_url("profile?id=".$news['member_id'])."'>".$news['member_name']."</a> 修改了活动 <a href='".site_url("activity/view?id=$activity_id")."'>$activity_name</a> 的内容";
						break;
					case 'new_comment':
						$data['msg'] = "<a href='".site_url("profile?id=".$news['member_id'])."'>".$news['member_name']."</a> 评论了活动 <a href='".site_url("activity/view?id=$activity_id")."'>$activity_name</a> 的内容";
						break;
					case 'new_reply':
						$data['msg'] = "<a href='".site_url("profile?id=".$news['member_id'])."'>".$news['member_name']."</a> 回复了 <a href='".site_url("profile?id=".$news['target_id'])."'>". $news['target_name']."</a> 对活动 <a href=".site_url("activity/view?id=$activity_id")."'>$activity_name</a> 的评论";
						break;
					case 'attend_activity':
						$data['msg'] = "<a href='".site_url("profile?id=".$news['member_id'])."'>".$news['member_name']."</a> 报名参加了活动 <a href='".site_url("activity/view?id=$activity_id")."'>$activity_name</a>";
						break;
					case 'activity_apply_pass':
						$data['msg'] = "<a href='".site_url("profile?id=".$news['member_id'])."'>".$news['member_name']."</a> 通过了 <a href='".site_url("profile?id=".$news['target_id'])."'>". $news['target_name']."</a> 对活动 <a href=".site_url("activity/view?id=$activity_id")."'>$activity_name</a> 的报名";
						break;
				}
			} elseif ( $news['category']=='blog' ) {
				$blog_id = $news['code'];
				$blog_name = $this->extend_control->getMemberBlogInformationByBlogId($blog_id)['book_name'];
				switch( $news['type'] ) {
					case 'new_comment':
						$data['msg'] = "<a href='".site_url("profile?id=".$news['member_id'])."'>".$news['member_name']."</a> 评论了微型书 <a href='".site_url("library/view?id=$blog_id")."'>$blog_name</a> 的内容";
						break;
				}
			} elseif ( $news['category']=='friend' ) {
				switch( $news['type'] ) {
					case 'apply_friend':
					$data['msg'] = "<a href='".site_url("profile?id=".$news['member_id'])."'>".$news['member_name']."</a> 申请成为 <a href='".site_url("profile?id=".$news['target_id'])."'>".$news['target_name']."</a> 的好友";
						break;
					case 'approve_friend':
						$data['msg'] = "<a href='".site_url("profile?id=".$news['member_id'])."'>".$news['member_name']."</a> 与 <a href='".site_url("profile?id=".$news['target_id'])."'>".$news['target_name']."</a> 成为好友";
						break;
				}
			}
			$news_array[] = $data;
		} //end foreach
		echo json_encode($news_array);
	}

}
?>
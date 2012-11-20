<?php
include_once "base_action_controller.php";
/**
* 控制活动显示、编辑、报名、关注、评论、历史查询
*/
Class Activity Extends BaseActionController {

	var $applicationFolder = "activity"; 
	
	function __construct() {
		parent::__construct();
	}
	
	/**
     * 显示挖活动主页
     */
	function index(){
		$all_hot_activity_tag_information = $this->extend_control->getHotActivityTag(0,10);
		$this->ci_smarty->assign('all_hot_activity_tag_information',$all_hot_activity_tag_information);

		$this->display( 'index', '挖活动', 'index_css', 'index_js' );
	}
	
	/**
     * 显示活动详情、活动访问量+1
     *
     * @param	activity_id		活动ID
     */
	function view( $activity_id ){
		$member_id = $this->current_member_id;
		$page = 1;
		$limit = $this->CLIMIT;
		
		if(!$activity_id) redirect('activity');
		
		$this->extend_control->AddActivityVisit($activity_id);
		
		$activity_information = $this->extend_control->getActivityInformationById($activity_id);
		$activity_information['is_said'] = $this->extend_control->isMemberSaidActivity($member_id,$activity_id);
		$activity_information['is_attend'] = $this->extend_control->isMemberAttendActivity($member_id,$activity_id);
		$activity_information['is_follow'] = $this->extend_control->isMemberFollowActivity($member_id,$activity_id);
		$activity_information['is_publisher'] = $this->extend_control->isPublisherOfActivity($member_id,$activity_id);
		$activity_information['rate'] = $this->extend_control->getActivityRateInformation($activity_id);

		$this->ci_smarty->assign('activity_information',$activity_information);

		$count = $this->extend_control->countAllActivityComment($activity_id);
		$comment_information = $this->extend_control->getActivityComment( $activity_id,($page-1)*$limit,$limit );
		$this->setPageInformation( $count, $page, $limit );
		$this->ci_smarty->assign('comment_information',$comment_information);

		$this->display('view',$activity_information['activity_name'].' - 活动详情','view_css','view_js');
	}

	/**
     * 显示活动管理页面
     *
     * @param	activity_id		活动ID
     *
     * @author franklsf95
     */
	function admin( $activity_id ) {
		$member_id = $this->current_member_id;

		$activity_information = $this->extend_control->getActivityInformationById($activity_id);
		$activity_information['all_attends'] = $this->extend_control->getActivityAttendMemberInformation($activity_id);
		$activity_information['all_follows'] = $this->extend_control->getActivityFollowMemberInformation($activity_id);
		
		if( $activity_information['publisher_id'] != $this->current_member_id )
			show_error('你没有权限管理此活动');

		$this->ci_smarty->assign('activity_information',$activity_information);
		$this->display('admin',$activity_information['activity_name'].' - 管理活动','view_css','admin_js');
	}
		
	/**
     * 显示活动创建和编辑页面
     *
     * @param	id		活动ID，如为空则创建新活动
     */
	function edit( $id = 0 ) {
		$title = '发起新活动';
		
		if ( $id != 0 ) {
			$title = '编辑活动 #'.$id;
			$activity_information = $this->extend_control->getActivityInformationById( $id );

			if( $activity_information['publisher_id'] != $this->current_member_id )
				show_error('你不能编辑别人发起的活动！');
			
			$this->ci_smarty->assign('activity_information',$activity_information);
		}

		//print_r($activity_information);exit();
		$this->display( 'edit', $title, 'edit_css', 'edit_js' );
	}
	
//--------工具函数组
	/**
     * 工具函数：处理edit()提交
     *
     * @param	很多
     */
	function save_form() {
		$activity_id = $this->getParameter('activity_id');
		$image = $this->getParameter('image');
		$tag_array = $this->getParameter('tag');

		$data['name'] = $this->getParameterWithOutTag('name');
		$data['publisher_id'] = $this->current_member_id;
		$data['publisher_name'] = $this->current_member_information['member_name'];
		$data['apply_start_time'] = $this->getParameter('apply_start_time');
		$data['apply_end_time'] = $this->getParameter('apply_end_time');
		$data['start_time'] = $this->getParameter('start_time');
		$data['end_time'] = $this->getParameter('end_time');
		$data['price'] = $this->getParameterWithOutTag('price');
		$data['address'] = $this->getParameterWithOutTag('address');
		$data['url'] = $this->getParameter('url');
		$data['description'] = $this->getParameterWithOutTag('description');
		$data['content'] = $this->getParameter('content');
		
		//处理图片高宽问题
		$image_url = $this->getImageUrl($image);
		if ($image_url === false) {
			show_error('活动封面上传错误');
		}
		$data['image'] = $image_url['relative_path'];

		if ( !$activity_id ) {	//new
			//写入activity
			$data['created_time'] = $this->current_time;
			$this->db->insert('activity',$data);
			$activity_id = $this->db->insert_id();

			$this->newSystemMessage('activity','new_activity',$activity_id);

		} else {
			$data['modified_time'] = $this->current_time;
			$this->db->where('activity_id',$activity_id);
			$this->db->update('activity',$data);
			
			//删除activity_tag
			$this->db->where('activity_id',$activity_id);
			$this->db->delete('activity_tag');
			
			$this->newSystemMessage('activity','edit_activity',$activity_id);
		}
		//写入activity_tag
		foreach($tag_array as $tag_value){
			$activity_tag_data = array();
			$activity_tag_data['activity_id'] = $activity_id;
			$activity_tag_data['tag'] = $tag_value;
			$activity_tag_data['created_time'] = date('Y-m-d H:i:s');
			$this->db->insert('activity_tag',$activity_tag_data);
		}

		redirect('activity/view/'.$activity_id);
	}

	function say(){
		$activity_id = $this->getParameter('id');
		$say = $this->getParameter('say');
		$member_id = $this->current_member_id;
		
		if( !$activity_id ) redirect('activity');

		$this->db->select('a.activity_id, a.end_time');
		$this->db->from('activity as a');
		$this->db->where('activity_id',$activity_id);
		$activity_information = $this->db->get_first();
		if(date("Y-m-d",strtotime($activity_information['end_time']))>=date("Y-m-d")) {
			redirect('activity/view/'.$activity_id);
		}
		$this->db->select('a.activity_id, a.member_id');
		$this->db->from('activity_attend as a');
		$this->db->where('activity_id',$activity_id);
		$this->db->where('member_id',$member_id);
		$attend = $this->db->get_first();
		if ($attend) {
			$attend['say']=$say;
			$this->db->where('activity_id',$activity_id);
			$this->db->where('member_id',$member_id);
			$this->db->update('activity_attend',$attend);
		} else {
			redirect('activity/view/'.$activity_id);
		}

		redirect('activity/view/'.$activity_id);
	}
	
	/**
     * 工具函数：处理打分请求
     *
     * @param 	id 		活动ID
     * @param 	plus 	1=+1; 0=-1
     *
     * @author wangpeng
     */
	function rate(){
		$activity_id = $this->getParameter('id');
		$plus = $this->getParameter('plus');
		$member_id = $this->current_member_id;

		if( !$activity_id ) redirect('activity');

		$this->db->select('a.activity_id, a.end_time');
		$this->db->from('activity as a');
		$this->db->where('activity_id',$activity_id);
		$activity_information = $this->db->get_first();
		if(date("Y-m-d",strtotime($activity_information['end_time']))>=date("Y-m-d")) {
			redirect('activity/view/'.$activity_id);
		}
		$this->db->select('a.activity_id, a.member_id, a.rate');
		$this->db->from('activity_attend as a');
		$this->db->where('activity_id',$activity_id);
		$this->db->where('member_id',$member_id);
		$rate = $this->db->get_first();
		$send_news_feed=true;
		if ($rate) {
			if ( $plus ) { //to +1
				if ($rate['rate']==-1) {
					$rate['rate']=1;
				} else {
					if ($rate['rate']==1) $send_news_feed=false;
					$rate['rate']=1-$rate['rate'];
				}
			} else { //to -1
				if ($rate['rate']==1) {
					$rate['rate']=-1;
				} else {
					if ($rate['rate']==-1) $send_news_feed=false;
					$rate['rate']=-1-$rate['rate'];
				}
			}
			$this->db->where('activity_id',$activity_id);
			$this->db->where('member_id',$member_id);
			$this->db->update('activity_attend',$rate);
		} else {
			redirect('activity/view/'.$activity_id);
		}
		$news_feed_type = $plus ? 'rate_up' : 'rate_down';
		if($send_news_feed==true) $this->newNewsFeed('activity',$news_feed_type,$activity_id);

		redirect('activity/view/'.$activity_id);
	}

	/**
	* 处理post删除活动请求
	*
	* @param 	activity_id 	要删除的活动ID
	*/
	function deleteActivity( $activity_id ) {
		if ( $this->extend_control->isPublisherOfActivity( $this->current_member_id, $activity_id ) )
			$this->extend_control->deleteActivity( $activity_id );
		else
			show_error('你不可以删除别人的活动！');
		redirect('activity');
	}

	/**
	* 处理post提交参加活动请求
	* 若已报名则取消报名，否则报名
	*
	* @param 	id 		要参加的活动ID
	* 
	*/
	function attendActivity(){
		$activity_id = $this->getParameter('id');
		$member_id = $this->current_member_id;
		$provide_contact = $this->getParameter('provide_contact');
		$introduction = $this->getParameter('introduction');
		//Update member information
		$enableChange = $this->getParameter('enableChange');
		$newEmail = $this->getParameter('newEmail');
		$newPhone = $this->getParameter('newPhone');
		if( $enableChange=='Y' ) {
			$member_data['email'] = $newEmail;
			$member_data['phone'] = $newPhone;
			$this->db->where('member_id',$member_id);
			$this->db->update('member',$member_data);
		}

		if ($activity_id) {
			$is_attend = $this->extend_control->isMemberAttendActivity($member_id,$activity_id);
			$attend_count = idx( $this->extend_control->getActivityCountsById($activity_id), 'attend_count' );

			if( !$is_attend ){
				//添加参加列表
				$data['member_id'] = $member_id;
				$data['activity_id'] = $activity_id;
				$data['show_info'] = $provide_contact;
				$data['introduction'] = $introduction;
				$data['created_time'] = $this->current_time;
				$this->db->insert('activity_attend',$data);

				//更新参加人数
				$data2['attend_count'] = $attend_count+1;
				$this->db->where('activity_id',$activity_id);
				$this->db->update('activity',$data2);
				
				$publisher_id = idx( $this->extend_control->getActivityBasicById($activity_id), 'publisher_id' );
				$this->newSystemMessage('activity','attend_activity',$activity_id, $publisher_id);
				
			} else {
				//从参加列表删除
				$this->db->where('member_id',$member_id);
				$this->db->where('activity_id',$activity_id);
				$this->db->delete('activity_attend');

				$data2['attend_count'] = $attend_count-1;
				$this->db->where('activity_id',$activity_id);
				$this->db->update('activity',$data2);
				
			}
		}
		redirect('activity/view/'.$activity_id);
	}

	/**
	* 处理ajax提交关注活动
	* 若已关注则取消关注，否则关注
	*
	* @param 	id 		要参加的活动ID
	* 
	* @return 	1=关注成功	2=取消成功
	*/
	function followActivity(){
		$activity_id = $this->getParameter('id');
		$member_id = $this->current_member_id;
		if ($activity_id){
			//检查该会员是否已经报名活动
			$is_follow = $this->extend_control->isMemberFollowActivity($member_id,$activity_id);
			$follow_count = idx( $this->extend_control->getActivityCountsById($activity_id), 'follow_count' );

			if( !$is_follow ){
				$data['member_id'] = $member_id;
				$data['activity_id'] = $activity_id;
				$data['created_time'] = $this->current_time;
				$this->db->insert('activity_follow',$data);

				$data2['follow_count'] = $follow_count+1;
				$this->db->where('activity_id',$activity_id);
				$this->db->update('activity',$data2);

				$publisher_id = idx( $this->extend_control->getActivityBasicById($activity_id), 'publisher_id' );
				$this->newNewsFeed('activity','follow_activity',$activity_id, $publisher_id);
				
				$return = 1;
				
			} else {
				$this->db->where('member_id',$member_id);
				$this->db->where('activity_id',$activity_id);
				$this->db->delete('activity_follow');

				$data2['follow_count'] = $attend_count-1;
				$this->db->where('activity_id',$activity_id);
				$this->db->update('activity',$data2);
				
				$return = 2;
			}
			echo json_encode($return);
		}
	}

	/**
     * 处理ajax批准或拒绝报名
     *
     * @param	activity_attend_id	活动ID
     * @param	action				进行的操作，1批准，0拒绝
     *
     * @return	status 		状态，1成功，0失败
     *
     * @author	suantou franklsf95
     */
	function handle_activity_attend(){
		$activity_attend_id = $this->getParameter('activity_attend_id');
		$action = $this->getParameter('action',-1);
		$return_data = array();
		
		if( $activity_attend_id && $action >= 0 ) {
			$this->db->where('activity_attend_id',$activity_attend_id);
			$attendee = $this->db->get_first('activity_attend');
			
			if($activity_attend_id != '') {
				if( $action==1 ) { //permit
					$data['approved'] = 1;
					$this->db->where('activity_attend_id',$activity_attend_id);
					$this->db->update('activity_attend',$data);

					$this->newSystemMessage('activity','attend_approve',$attendee['activity_id'],$attendee['member_id']);

					$return_data['status'] = 1;
				} elseif( $action==0 ) { //deny
					$this->db->where('activity_attend_id',$activity_attend_id);
					$this->db->delete('activity_attend');
					$return_data['status'] = 1;
				}
			}
			
		}
		echo json_encode($return_data);
	}

	/**
     * 处理ajax获取新评论请求
     *
     * @param	activity_id	活动ID
     */
	function ajaxGetComment(){
		$activity_id = $this->getParameter('activity_id');
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',$this->CLIMIT);
		$comment_information = $this->extend_control->getActivityComment( $activity_id,$page_offset,$limit );
		
		echo json_encode($comment_information);
	}

	/**
	* 处理ajax提交评论
	*
	* @param 	activity_id 	微型书ID
	* @param 	content 	评论内容
	*
	* @return 	刚刚添加的评论
	*/
	function ajaxAddComment(){
		$activity_id = $this->getParameter('activity_id');
		$content = $this->getParameterWithOutTag('content');
		
		$data['member_id'] = $this->current_member_id;
		$data['activity_id'] = $activity_id;
		$data['content'] = $content;
		$data['created_time'] = $this->current_time;
		$this->db->insert('activity_comment',$data);

		$publisher_id = idx( $this->extend_control->getActivityBasicById($activity_id), 'publisher_id' );
		$this->newSystemMessage('activity','new_comment',$activity_id,$publisher_id);

		$data['comment_id'] = $this->db->insert_id();
		$data['member_name'] = $this->current_member_information['member_name'];
		$data['member_image'] = $this->current_member_information['member_image'];
			
		echo json_encode($data);
	}

	function ajaxAddReply() {
		$activity_comment_id = $this->getParameter('activity_comment_id');
		$reply = $this->getParameter('reply');

		$data['reply'] = $reply;
		$this->db->where('activity_comment_id',$activity_comment_id);
		$this->db->update('activity_comment',$data);

		$this->db->where('activity_comment_id',$activity_comment_id);
		$comment_information = $this->db->get_first('activity_comment');

		$target_id = $comment_information['memebr_id'];
		$this->newSystemMessage('activity','new_comment',$activity_id,$target_id);

		echo 1;
	}

	/**
     * 处理挖活动首页ajax按标签加载活动请求
     *
     * @param	activity_attend_id	活动ID
     * @param	action				进行的操作，1批准，0拒绝
     *
     * @return	status 		状态，1成功，0失败
     *
     * @author	suantou franklsf95
     */
	function ajaxGetActivitiesByTag(){
		$page_offset = $this->getParameter('page_offset');
		$limit = $this->getParameter('limit');
		$tag = $this->getParameterDecode('tag');
		$all_activity_information = $this->extend_control->searchActivity($page_offset,$limit,null,null,null,null,$tag);
		
		echo json_encode($all_activity_information);
	}

	function ajaxGetLatestActivities(){
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',10);
		$all_new_activity_information = $this->extend_control->getLatestActivities($page_offset,$limit);
		/*
		foreach( $all_new_activity_information as $i )
			$all_new_activity_information[] = $i;
		*/
		echo json_encode($all_new_activity_information);
	}

}

?>
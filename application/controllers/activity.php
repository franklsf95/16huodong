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
     * @param	id		活动ID
     * @param	page	评论页数
     */
	function view(){
		$activity_id = $this->getParameter('id');
		$member_id = $this->current_member_id;
		$page = $this->getParameter('page',1);
		$limit = $this->CLIMIT;
		
		if(!$activity_id) redirect('activity');
		$this->extend_control->AddActivityVisit($activity_id);
		
		$activity_information = $this->extend_control->getAcitivityInformationById($activity_id);
		$activity_information['attend_count'] = count( $this->extend_control->getAllActivityAttendMemberInformation($activity_id) );
		$activity_information['follow_count'] = count( $this->extend_control->getAllActivityAttentionMemberInformation($activity_id) );
		$activity_information['is_attend'] = $this->extend_control->isMemberAttendActivity($member_id,$activity_id);
		$activity_information['is_attention'] = $this->extend_control->isMemberFollowActivity($member_id,$activity_id);
		$activity_information['is_publisher'] = $this->extend_control->isMemberPublishActivity($member_id,$activity_id);
		
		$count = $this->extend_control->countAllActivityComment($activity_id);
		$all_activity_comment_information = $this->extend_control->getActivityCommentInformation($activity_id,($page-1)*$limit,$limit);
		
		$this->setPageInformation( $count, $page, $limit );

		$rate1=$rate2=$rate1ed=$rate2ed=0;
		$this->db->select('a.activity_id, a.member_id, a.rate');
		$this->db->from('activity_rate as a');
		$this->db->where('activity_id',$activity_id);
		$results=$this->db->get()->result_array();
		
		foreach ($results as $item) {
			if ($item['rate']==1) {
				$rate1++;
				if ($item['member_id'] == $member_id) {
					$rate1ed = 1;
				}
			} else if ($item['rate']==-1) {
				$rate2++;
				if ($item['member_id'] == $member_id) {
					$rate2ed = 1;
				}
			}
		}
		$this->ci_smarty->assign('rate1',$rate1);
		$this->ci_smarty->assign('rate2',$rate2);
		$this->ci_smarty->assign('rate1ed',$rate1ed);
		$this->ci_smarty->assign('rate2ed',$rate2ed);
		
		$this->ci_smarty->assign('activity_information',$activity_information);
		$this->ci_smarty->assign('all_activity_comment_information',$all_activity_comment_information);

		$this->display('view',$activity_information['activity_name'].' - 活动详情','view_css','view_js');
	}

	/**
     * 显示活动管理页面
     *
     * @param	id		活动ID
     *
     * @author franklsf95
     */
	function admin() {
		$activity_id = $this->getParameter('id');
		$member_id = $this->current_member_id;

		$activity_information = $this->extend_control->getAcitivityInformationById($activity_id);
		$activity_information['all_attends'] = $this->extend_control->getAllActivityAttendMemberInformation($activity_id);
		$activity_information['all_follows'] = $this->extend_control->getAllActivityAttentionMemberInformation($activity_id);
		
		$this->ci_smarty->assign('activity_information',$activity_information);
		$this->display('admin',$activity_information['activity_name'].' - 管理活动','view_css','admin_js');
	}
		
	/**
     * 显示活动创建和编辑页面
     *
     * @param	id		活动ID，如为空则创建新活动
     *
     * @author suantou
     */
	function edit() {
		$id = $this->getParameter('id',NULL);
		$member_id = $this->current_member_id;
		$title = '发起新活动';
		
		if ( $id ) {
			$title = '编辑活动 #'.$id;
			$this->db->from('activity as a');
			$this->db->where('a.activity_id',$id);
			$this->db->where('a.publisher',$member_id);
			$activity_information = $this->db->get_first();
			$activity_information['member_name'] = $this->current_member_information['member_name'];
			
			//获取活动标签
			$this->db->select('tag');
			$this->db->from('activity_tag');
			$this->db->where('activity_id',$id);
			$all_tag = $this->db->get()->result_array();
			
			if(is_array($all_tag)){
				foreach ($all_tag as $tag) {
					$activity_information['tag'][] = $tag['tag'];
				}
			}
			
			$this->ci_smarty->assign('activity_information',$activity_information);
		}
		$this->ci_smarty->assign('all_member_friend_information',$this->current_member_information['all_member_friend_information']);
		
		//print_r($activity_information);exit();
		$this->display( 'edit', $title, 'edit_css', 'edit_js' );
	}
	
//--------工具函数组
	/**
     * 工具函数：处理edit()提交
     *
     * @param	很多
     *
     * @author suantou
     */
	function _saveItem($isNew, &$id, &$param) {
		
		$name = $this->getParameterWithOutTag('name',NULL);
		$apply_start_time = $this->getParameter('apply_start_time',NULL);
		$apply_end_time = $this->getParameter('apply_end_time',NULL);
		$start_time = $this->getParameter('start_time',NULL);
		$end_time = $this->getParameter('end_time',NULL);
		$price = $this->getParameterWithOutTag('price',NULL);
		$address = $this->getParameterWithOutTag('address',NULL);
		$image = $this->getParameter('image',NULL);
		$description = $this->getParameterWithOutTag('description',NULL);
		$tag_array = $this->getParameter('tag',NULL);
		$content = $this->getParameter('content',NULL);
		$invite_member = $this->getParameter('invite_member',NULL);
		//$tag = trim(trim(str_replace('/',',',str_replace('.',',',str_replace(';',',',str_replace('，',',',str_replace(' ',',',$tag)))))),',');
		
		$data['name'] = $name;
		$data['publisher_id'] = $this->current_member_id;
		$data['publisher_name'] = $this->current_member_information['member_name'];
		$data['apply_start_time'] = $apply_start_time;
		$data['apply_end_time'] = $apply_end_time;
		$data['start_time'] = $start_time;
		$data['end_time'] = $end_time;
		$data['price'] = $price;
		$data['address'] = $address;
		$data['description'] = $description;
		$data['content'] = $content;
		
		//处理图片高宽问题
		$image_url = $this->getImageUrl($image);
		if ($image_url === false) {
			show_error('活动封面上传错误');
		}
		$image_parameter = @getimagesize($image_url['absolute_path']);
		$data['image_width'] = $image_parameter['0'];
		$data['image_height'] = $image_parameter['1'];
		$data['image'] = $image_url['relative_path'];

		if ($isNew){
			//写入activity
			$data['created_time'] = $this->current_time;
			$this->db->insert('activity',$data);
			$activity_id = $this->db->insert_id();
			
			//写入activity_tag
			foreach($tag_array as $tag_value){
				$activity_tag_data = array();
				$activity_tag_data['activity_id'] = $activity_id;
				$activity_tag_data['tag'] = $tag_value;
				$activity_tag_data['created_time'] = date('Y-m-d H:i:s');
				$this->db->insert('activity_tag',$activity_tag_data);
			}
			
			if (count($invite_member) >0 ){
				$this->invite_member_attend_activity($activity_id,$invite_member);
			}
			redirect('activity/view?id='.$activity_id);
			
		}else {
			$data['modified_time'] = $this->current_time;
			$this->db->where('activity_id',$id);
			$this->db->update('activity',$data);
			
			//删除activity_tag
			$this->db->where('activity_id',$id);
			$this->db->delete('activity_tag');
			
			//写入activity_tag
			foreach($tag_array as $tag_value){
				$activity_tag_data = array();
				$activity_tag_data['activity_id'] = $id;
				$activity_tag_data['tag'] = $tag_value;
				$activity_tag_data['created_time'] = date('Y-m-d H:i:s');
				$this->db->insert('activity_tag',$activity_tag_data);
			}
			
			$system_data['category'] = "activity";
			$system_data['type'] = "edit_activity";
			$system_data['code'] = $id;
			$this->system_message($system_data);
			
			if (count($invite_member) >0 ){
				$this->invite_member_attend_activity($id,$invite_member);
			}
			
			
			redirect('activity/view?id='.$id);
		}
		
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

		$this->db->select('a.activity_id');
		$this->db->from('activity as a');
		$this->db->where('activity_id',$activity_id);
		$activity_information = $this->db->get_first();

		$this->db->select('a.activity_id, a.member_id, a.rate');
		$this->db->from('activity_rate as a');
		$this->db->where('activity_id',$activity_id);
		$this->db->where('member_id',$member_id);
		$rate = $this->db->get_first();
		if ($rate) {
			if ( $plus ) { //to +1
				if ($rate['rate']==-1) {
					$rate['rate']=1;
				} else {
					$rate['rate']=1-$rate['rate'];
				}
			} else { //to -1
				if ($rate['rate']==1) {
					$rate['rate']=-1;
				} else {
					$rate['rate']=-1-$rate['rate'];
				}
			}
			$this->db->where('activity_id',$activity_id);
			$this->db->where('member_id',$member_id);
			$this->db->update('activity_rate',$rate);
		} else {
			$rate['activity_id']=$activity_id;
			$rate['member_id']=$member_id;
			$rate['rate']= $plus ? 1 : -1;
			$this->db->insert('activity_rate',$rate);
		}
		redirect('activity/view?id='.$activity_id);
	}


	//to-be-deprecated: 提交评论
	function save_comment(){
		$activity_id = $this->getParameter('activity_id',NULL);
		$activity_comment = $this->getParameter('activity_comment',NULL);
		if ($activity_id != '' && $activity_comment != ''){
			
			$data['activity_id'] = $activity_id;
			$data['content'] = trim($activity_comment);
			$data['member_id'] = $this->current_member_id;
			$data['created_time'] = $this->current_time;
			
			$this->db->insert('activity_comment',$data);
			
			
		}
		redirect(site_url("activity/view?id=$activity_id"));
	}
	
	function addActivityCommentReply(){
		$activity_comment_id = $this->getParameter('activity_comment_id',NULL);
		$reply = $this->getParameter('reply',NULL);
		$this->db->where('activity_comment_id',$activity_comment_id);
		$activity_comment_information = $this->db->get_first('activity_comment');
		if ($activity_comment_information['reply'] == '' && $reply != '') {
			$data['reply'] = $reply;
			$this->db->where('activity_comment_id',$activity_comment_id);
			$this->db->update('activity_comment',$data);
		}
		
		redirect(site_url("activity/view?id=$activity_comment_information[activity_id]"));
	}
	
	function invite_member_attend_activity($activity_id,$member_list){
		$member_id = $this->current_member_id;
		
		foreach ($member_list as $target_id) {
			$system_data['member_id'] = $this->current_member_id;
			$system_data['target_id'] = $target_id;
			$system_data['category'] = "activity";
			$system_data['type'] = "invite_attend_activity";
			$system_data['code'] = $activity_id;
			
				
			$this->system_message($system_data);
		}
	}

//--------AJAX工具组

/**
	* 处理ajax提交参加活动请求
	* 若已报名则取消报名，否则报名
	*
	* @param 	id 		要参加的活动ID
	* 
	* @return 	1=报名成功	2=取消成功
	*/
	function attendActivity(){
		$activity_id = $this->getParameter('id');
		$member_id = $this->current_member_information['member_id'];

		if ($activity_id) {
			$is_attend = $this->extend_control->isMemberAttendActivity($member_id,$activity_id);
			$this->CI->db->select('attend_count');
			$this->CI->db->from('activity');
			$this->CI->db->where('activity_id',$activity_id);
			$attend_count = idx( $this->CI->db->get_first(), 'attend_count' );

			if( !$is_attend ){
				//添加参加列表
				$data['member_id'] = $member_id;
				$data['activity_id'] = $activity_id;
				$data['created_time'] = $this->current_time;
				$this->db->insert('activity_attend',$data);

				//更新参加人数
				$data2['attend_count'] = $attend_count+1;
				$this->CI->db->where('activity_id',$activity_id);
				$this->CI->db->update('activity',$data2);

				$return = 1;
				
				//system_message
				$this->db->select('publisher_id');
				$this->db->where('activity_id',$activity_id);
				$this->db->from('activity');
				$system_data['target_id'] = idx($this->db->get_first(),'publisher_id');
				$system_data['category'] = 'activity';
				$system_data['type'] = 'attend_activity';
				$system_data['code'] = $activity_id;
				$this->system_message($system_data);
				
			} else {
				//从参加列表删除
				$this->db->where('member_id',$member_id);
				$this->db->where('activity_id',$activity_id);
				$this->db->delete('activity_attend');

				$data2['attend_count'] = $attend_count-1;
				$this->CI->db->where('activity_id',$activity_id);
				$this->CI->db->update('activity',$data2);
				
				$return = 2;
			}
		}
		echo $return;
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
		$member_id = $this->current_member_information['member_id'];
		if ($activity_id){
			//检查该会员是否已经报名活动
			$is_attention = $this->extend_control->isMemberFollowActivity($member_id,$activity_id);
			//get follow count
			$this->CI->db->select('follow_count');
			$this->CI->db->from('activity');
			$this->CI->db->where('activity_id',$activity_id);
			$follow_count = idx( $this->CI->db->get_first(), 'follow_count' );

			if( !$is_attention ){
				$data['member_id'] = $member_id;
				$data['activity_id'] = $activity_id;
				$data['created_time'] = $this->current_time;
				$this->db->insert('activity_follow',$data);

				$data2['follow_count'] = $follow_count+1;
				$this->CI->db->where('activity_id',$activity_id);
				$this->CI->db->update('activity',$data2);
				
				$return = 1;
				
			} else {
				$this->db->where('member_id',$member_id);
				$this->db->where('activity_id',$activity_id);
				$this->db->delete('activity_follow');

				$data2['follow_count'] = $attend_count-1;
				$this->CI->db->where('activity_id',$activity_id);
				$this->CI->db->update('activity',$data2);
				
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
		$activity_attend_id = $this->getParameter('activity_attend_id',Null);
		$action = $this->getParameter('action',-1);
		$return_data = array();
		
		if( $activity_attend_id && $action >= 0 ) {
			$this->db->where('activity_attend_id',$activity_attend_id);
			$activity_attend_information = $this->db->get_first('activity_attend');
			
			if($activity_attend_id != '') {
				if( $action ) { //permit
					//system_message
					$system_data['target_id'] = $activity_attend_information['member_id'];
					$system_data['category'] = 'activity';
					$system_data['type'] = 'activity_apply_pass';
					$system_data['code'] = $activity_attend_information['activity_id'];
					$this->system_message($system_data);
					
					$data['status'] = 'Y';
					$this->db->where('activity_attend_id',$activity_attend_id);
					$this->db->update('activity_attend',$data);
					$return_data['status'] = 1;
				} else { //deny
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
	function ajaxGetActivityCommentInformation(){
		$activity_id = $this->getParameter('activity_id',Null);
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',5);
		$all_activity_comment_information = $this->extend_control->getActivityCommentInformation($activity_id,$page_offset,$limit);
		
		echo json_encode($all_activity_comment_information);
	}
	
	function getCurrentAttendActivity(){
		$member_id = $this->getParameter('member_id',$this->current_member_id);
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',5);
		$all_current_attend_activity_information = $this->extend_control->getCurrentAttendActivityInformation($member_id,$page_offset,$limit);
		
		echo json_encode($all_current_attend_activity_information);
	}
	
	function getCurrentAttentionActivity(){
		$member_id = $this->getParameter('member_id',$this->current_member_id);
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',5);
		$all_current_attention_activity_information = $this->extend_control->getCurrentAttentionActivityInformation($member_id,$page_offset,$limit);
		
		echo json_encode($all_current_attention_activity_information);
	}
	
	function getCurrentPublishActivity(){
		$member_id = $this->getParameter('member_id',$this->current_member_id);
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',5);
		$all_current_publish_activity_information = $this->extend_control->getCurrentPublishActivityInformation($member_id,$page_offset,$limit);
		
		echo json_encode($all_current_publish_activity_information);
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
	function ajaxGetActivityInformationByTag(){
		$tag = $this->getParameter('tag',NULL);
		$all_activity_information = $this->extend_control->searchActivity(null,null,null,null,$tag);
		
		echo json_encode($all_activity_information);
	}

	function ajaxGetLatestActivities(){
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',5);
		$all_new_activity_information = $this->extend_control->getLatestActivities($page_offset,$limit);
		
		echo json_encode($all_new_activity_information);
	}

}

?>
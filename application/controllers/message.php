<?php
include_once "base_action_controller.php";
/**
* 控制站内信和系统消息的显示、站内信发送
*/
Class Message Extends BaseActionController {

	var $applicationFolder = "message"; 
	
	function __construct() {
		parent::__construct();
	}
	
	/**
	* 显示站内信主页、发送消息、收件箱
	*/
	function index(){
		$member_id = $this->current_member_id;
		
		$all_member_message_information = $this->extend_control->getAllMemberMessageInformationGroups($member_id);
		$new_system_messages = $this->extend_control->getNewSystemMessages($member_id);
		
		foreach( $new_system_messages as &$i ) {
			if( $i['category']=='activity' ) {
				$i['detail'] = $this->extend_control->getActivityBasicById( $i['code'] );
			} elseif( $i['category']=='book' ) {
				$i['detail'] = $this->extend_control->getBookBasicById( $i['code'] );
			}
		}

		$this->ci_smarty->assign('all_member_message_information',$all_member_message_information);
		$this->ci_smarty->assign('new_system_messages',$new_system_messages);

		//for compose section
		$target_id = $this->getParameter('target_id',NULL);
		$all_friends = $this->extend_control->getAllFriendsBasic($member_id);
		$this->ci_smarty->assign('all_friends',$all_friends);

		if( $target_id && $this->extend_control->isFriend($member_id,$target_id) ) {
			$this->ci_smarty->assign('target_id', $target_id);
			$target_name = $this->extend_control->getMemberNameByMemberId($target_id);
			$this->ci_smarty->assign('target_name', $target_name);
		}
		
		//print_r($new_system_messages);exit();
		$this->display('index','站内信','index_css','index_js');
	}

	/**
	* 显示群发页面
	*
	* @param 	msg 	预定义的消息
	*/
	function compose() {
		$msg = $this->getParameterWithOutTag('msg',NULL);
		$all_friends = $this->extend_control->getFriendBasicByName('');
		$this->ci_smarty->assign('all_friends',$all_friends);
		$this->ci_smarty->assign('msg',$msg);

		$this->display('compose','群发站内信','index_css','compose_js');
	}
	
	/**
	* 重定向页，标记消息已读
	*
	* @param 	a/d/b/pid 	活动/管理活动/书/好友ID
	* @param 	mid 		消息ID
	*/
	function redirectMsg(){
		$aid = $this->getParameter('aid',0);
		$bid = $this->getParameter('bid',0);
		$did = $this->getParameter('did',0);
		$pid = $this->getParameter('pid',0);
		$message_id = $this->getParameter('mid',0);
		if ( !$aid && !$did && !$bid && !$pid )
			redirect('message');
		
		$data['is_new'] = 'N';
		$this->db->where('system_message_id',$message_id);
		$this->db->update('system_message',$data);

		if( $aid )	redirect('activity/view/'.$aid);
		if( $did )	redirect('activity/admin/'.$did);
		if( $bid )	redirect('library/view/'.$bid);
		if( $pid )	redirect('profile/view/'.$pid);
	}
	
	/**
	* 显示我与target_id的留言记录
	*
	* @param 	page 	当前页数
	* @param 	limit 	每页消息数
	*/
	function view(){
		$target_id = $this->getParameter('target_id',NULL);
		$page = $this->getParameter('page',1);
		$limit = $this->MLIMIT;
		
		$count = $this->extend_control->countMemberMessageByMemberId($target_id);
		$this->setPageInformation( $count, $page, $limit, 'message/view' );
		
		$all_member_message_information = $this->extend_control->getAllMemberMessageInformationByMemberId($target_id,($page-1)*$limit,$limit);
		$target_info = $this->extend_control->getMemberBasicById($target_id);
		
		//浏览过就把通知删除掉
		$this->db->where('member_id',$target_id);
		$this->db->where('target_id',$this->current_member_id);
		$this->db->where('category','member_message');
		$this->db->where('type','new_message');
		$this->db->delete('system_message');
		
		$this->ci_smarty->assign('all_member_message_information',$all_member_message_information);
		$this->ci_smarty->assign('target_info',$target_info);
		
		//print_r($all_member_message_information);exit();
		$this->display('view','消息记录 - '.$member_base_information['member_name'],'','view_js');
	}

	/**
	* 发站内信
	*
	* @param 	int 	member_id 	对方ID
	* @param 	string 	content 	内容
	*/
	function sendUtil( $target_id, $content ) {
		$member_id = $this->current_member_id;

		if ($member_id == $target_id) {
			show_error('请不要尝试给自己发站内信 ^_^');
		}
		
		if ($member_id < $target_id) {
			$group = $member_id.','.$target_id;
		}else {
			$group = $target_id.','.$member_id;
		}
		
		if ( $target_id != '' && $content != '') {
			$data['member_id'] = $member_id;
			$data['target_id'] = $target_id;
			$data['content'] = $content;
			$data['group'] = $group;

			$data['created_time'] = $this->current_time;
				
			$this->db->insert('member_message',$data);
			$member_message_id = $this->db->insert_id();

			$this->newSystemMessage('member_message','new_message',$member_message_id,$target_id);
		}
	}
	
	/**
	* 处理发站内信表单
	*
	* @param 	target_id	 	收件人ID
	* @param 	message_content 		内容
	*/
	function send() {
		$target_id = $this->getParameter('member_id',NULL);
		$content = $this->getParameterWithOutTag('message_content',NULL);

		$this->sendUtil( $target_id, $content );
		redirect('message/view?target_id='.$target_id);
	}

	/**
	* 处理【群发】站内信表单
	*
	* @param 	member_list 	收件ID数组
	* @param 	message_content 		内容
	*/
	function sendToAll(){
		$member_id = $this->current_member_id;
		$member_list = $this->getParameter('member_list',array());
		$content = $this->getParameterWithOutTag('message_content',NULL);
		
		if ( count($member_list) == 0 || !$content ) redirect('message');
		foreach ($member_list as $target_id)
			$this->sendUtil( $target_id, $content);

		redirect('message/index');
	}		

//-------- AJAX工具组
	function ajaxGetFriendBasicByName(){
		$member_name = $this->getParameter('query','');
		
		$all_member_information = $this->extend_control->getFriendBasicByName($member_name);
		
		echo json_encode($all_member_information);
	}

	function ajaxMarkAsRead(){
		$system_message_id = $this->getParameter('system_message_id');
		$target_id = $this->current_member_id;
		$data['is_new'] = 'N';
		$this->db->where('system_message_id',$system_message_id);
		$this->db->where('target_id',$target_id);
		$this->db->update('system_message',$data);
	}



}
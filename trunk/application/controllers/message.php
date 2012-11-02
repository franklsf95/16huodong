<?php
include_once "base_action_controller.php";
/**
* 控制站内信和系统消息的显示、站内信发送
*/
Class Message Extends BaseActionController {

	var $applicationFolder = "message"; 
	
	function __construct() {
		parent::__construct();
		$member_id = $this->current_member_id;
		$member_base_information = $this->extend_control->getMemberBaseInformation($member_id);
		$this->ci_smarty->assign('member_base_information',$member_base_information);
	}
	
	/**
	* 显示站内信主页、发送消息、收件箱
	*
	* @param 	page 	当前页数
	*/
	function index(){
		$member_id = $this->current_member_id;
		$page = $this->getParameter('page',1);
		$limit = $this->MLIMIT;
		$offset = ($page-1) * $limit;
		
		$count = $this->extend_control->countMemberMessageGroups($member_id);
		$this->setPageInformation( $count, $page, $limit, 'message' );
		
		$all_member_message_information = $this->extend_control->getAllMemberMessageInformationGroups($member_id,$offset, $limit);
		$all_system_message_information = $this->extend_control->getAllSystemMessageInformation($member_id);
		
		$this->ci_smarty->assign('all_member_message_information',$all_member_message_information);
		$this->ci_smarty->assign('all_system_message_information',$all_system_message_information);
		
		//print_r($all_system_message_information);exit();

		$this->display('index','站内信','index_css','index_js');
	}
	
	/**
	* 重定向页：重定向到活动页面
	*
	* @param 	id 		活动ID
	* @param 	mid 	消息ID
	*/
	function gotoactmsg(){
		$member_id = $this->current_member_id;
		$activity_id =  $this->getParameter('id',0);
		$message_id =  $this->getParameter('mid',0);
		if ($activity_id == 0){
			redirect('message');
		} else {
			$system_message_id = $message_id;
			$target_id = $member_id;
			$data['is_new'] = 'N';
			$this->db->where('system_message_id',$system_message_id);
			$this->db->where('target_id',$target_id);
			$this->db->update('system_message',$data);
			redirect('activity/view?id='.$activity_id);
		}
	}
	
	/**
	* 重定向页：重定向到微型书页面
	*
	* @param 	id 		微型书ID
	* @param 	mid 	消息ID
	*/
	function gotoblogmsg(){
		$member_id = $this->current_member_id;
		$blog_id =  $this->getParameter('id',0);
		$message_id =  $this->getParameter('mid',0);
		if ($blog_id == 0){
			redirect('message');
		} else {
			$system_message_id = $message_id;
			$target_id = $member_id;
			$data['is_new'] = 'N';
			$this->db->where('system_message_id',$system_message_id);
			$this->db->where('target_id',$target_id);
			$this->db->update('system_message',$data);
			redirect('library/view?id='.$blog_id);
		}
	}
	
	/**
	* 重定向页：重定向到好友主页
	*
	* @param 	id 		好友ID
	* @param 	mid 	消息ID
	*/
	function gotomembermsg(){
		$member_id = $this->current_member_id;
		$targetmember_id =  $this->getParameter('id',0);
		$message_id =  $this->getParameter('mid',0);
		if ($targetmember_id == 0){
			redirect('message');
		} else {
			$system_message_id = $message_id;
			$target_id = $member_id;
			$data['is_new'] = 'N';
			$this->db->where('system_message_id',$system_message_id);
			$this->db->where('target_id',$target_id);
			$this->db->update('system_message',$data);
			redirect('profile?id='.$targetmember_id);
		}
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
		$target_info = $this->extend_control->getMemberBaseInformation($target_id);
		$my_info = $this->extend_control->getMemberBaseInformation($this->current_member_id);
		
		//浏览过就把通知删除掉
		$this->db->where('member_id',$target_id);
		$this->db->where('target_id',$this->current_member_id);
		$this->db->where('category','member_message');
		$this->db->where('type','new_message');
		$this->db->delete('system_message');
		
		$this->ci_smarty->assign('all_member_message_information',$all_member_message_information);

		$this->ci_smarty->assign('target_info',$target_info);
		$this->ci_smarty->assign('my_info',$my_info);
		$this->ci_smarty->assign('page_information',$page_information);
		
		//print_r($all_member_message_information);exit();
		$this->display('view','消息记录 - '.$member_base_information['member_name'],'','view_js');
	}
	
	
	/**
	* 处理发站内信表单
	*
	* @param 	member_id 	对方ID
	* @param 	content 	内容
	*/
	function _saveItem($isNew, &$id, &$param) {
		$member_id = $this->current_member_id;
		$target_id = $this->getParameter('member_id',NULL);
		$content = $this->getParameterWithOutTag('message_content',NULL);

		if ($member_id == $target_id) {
			show_error('请不要尝试给自己发站内信^-^');
		}
		
		if ($member_id < $target_id) {
			$group = $member_id.','.$target_id;
		}else {
			$group = $target_id.','.$member_id;
		}
		
		if ($member_id != '' && $target_id != '' && $content != '') {
			$data['member_id'] = $member_id;
			$data['target_id'] = $target_id;
			$data['content'] = $content;
			$data['group'] = $group;

			if ($isNew){
				$data['created_time'] = $this->current_time;
				
				$this->db->insert('member_message',$data);
				$member_message_id = $this->db->insert_id();
				
				$system_message_data = array();
				$system_message_data['category'] = "member_message";
				$system_message_data['type'] = "new_message";
				$system_message_data['target_id'] = $target_id;
				$system_message_data['member_id'] = $member_id;
				$system_message_data['code'] = $member_message_id;
				
				$this->system_message($system_message_data);
				
				redirect('message');
				
			}else {
				$data['modified_time'] = $this->current_time;
				
				$this->db->where('member_message_id',$id);
				$this->db->update('member_message',$data);
			}
		
		}
		
	}
	
	/**
	* 处理【群发】站内信表单
	*
	* @param 	member_list 	收件ID数组
	* @param 	content 		内容
	*/
	function save_form_array(){
		$member_id = $this->current_member_id;
		$member_list = $this->getParameter('member_list',array());
		$content = $this->getParameterWithOutTag('content',NULL);
		
		if ($member_id != '' && count($member_list) > 0 && $content != '') {
			foreach ($member_list as $target_id) {
				if ($member_id != $target_id) {
					$data = array();
					if ($member_id < $target_id) {
						$group = $member_id.','.$target_id;
					}else {
						$group = $target_id.','.$member_id;
					}
					
					$data['member_id'] = $member_id;
					$data['target_id'] = $target_id;
					$data['content'] = $content;
					$data['group'] = $group;
					$data['created_time'] = $this->current_time;
					
					$this->db->insert('member_message',$data);
					
					$member_message_id = $this->db->insert_id();
					
					$system_message_data = array();
					$system_message_data['category'] = "member_message";
					$system_message_data['type'] = "new_message";
					$system_message_data['target_id'] = $target_id;
					$system_message_data['member_id'] = $member_id;
					$system_message_data['code'] = $member_message_id;
					
					$this->system_message($system_message_data);
				}
			}
			
		}
		redirect('message');
	}
}
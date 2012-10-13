<?php
include_once "admin_controller.php";
Class Activity Extends AdminController {

	var $applicationFolder = "activity"; 
	var $tableName="activity";
	var $idFieldName = 'activity_id';
	
	function __construct() {
		parent::__construct();
	}
	
	function index(){
		$p_expiry = $this->getParameter('expiry',NULL);
		$p_page = $this->getParameter('page',1);
		$p_limit = $this->getParameter('limit',10);
		
		if ($p_expiry == 'Y') {
			$this->db->where('end_time <',date('Y-m-d'));
		}elseif ($p_expiry == 'N') {
			$this->db->where('end_time >=',date('Y-m-d'));
		}
		
		$count = $this->db->count_all_results('activity');
		$page_information = $this->createPageInformation($count,$p_page,$p_limit);
		
		$this->db->select('a.*,m.member_id, m.name as member_name');
		$this->db->from('activity as a');
		$this->db->join('activity_publish_member as apm','a.activity_id = apm.activity_id');
		$this->db->join('member as m','m.member_id = apm.member_id');
		if ($p_expiry == 'Y') {
			$this->db->where('end_time <',date('Y-m-d'));
		}elseif ($p_expiry == 'N') {
			$this->db->where('end_time >=',date('Y-m-d'));
		}
		
		$all_activity_information = $this->db->get('',$limit,$page_information['page_offset'])->result_array();
		
		$this->ci_smarty->assign('expiry', $p_expiry);
		$this->ci_smarty->assign('page_information', $page_information);
		$this->ci_smarty->assign('count', $count);
		$this->ci_smarty->assign('all_activity_information',$all_activity_information);
		$this->displayWithLayout('index');
	}
	
	function edit(){
		$activity_id = $this->getParameter('cid',NULL);
		
		if ($activity_id) {
			
			$this->db->where('activity_id',$activity_id);
			$activity_information = $this->db->get_first('activity');;
			$this->ci_smarty->assign('activity_information',$activity_information);
			$this->ci_smarty->assign('activity_id',$activity_id);
		}
		
		$this->displayWithLayout('edit');
	
	
	}
	
	function _saveItem($isNew, &$id, &$param) {
		$name = $this->getParameter('name',Null);
		$start_time = $this->getParameter('start_time',Null);
		$end_time = $this->getParameter('end_time',Null);
		$content = $this->getParameter('content',Null);
		
		$data = array();
		
		$data['name'] = $name;
		$data['start_time'] = $start_time;
		$data['end_time'] = $end_time;
		$data['content'] = $content;
		
		
		if ($isNew) {
			$data['created_time'] = $date_time;
			$data['modified_time'] = $date_time;
			$this->db->insert('activity',$data);
		} else {
			$data['modified_time'] = $date_time;
			$this->db->where('activity_id',$id);
			$this->db->update('activity',$data);
		}
		$this->forward('index');
	}
	
	function remove(){
		$activity_id = $this->getParameter('cid',Null);
		if ($activity_id != '') {
			//删除所有系统消息
			$this->db->where('category','activity');
			$this->db->where('code',$activity_id);
			$this->db->delete('system_message');
			
			
			//删除所有参加的活动
			$this->db->where('activity_id',$activity_id);
			$this->db->delete('activity_attend_member');
			
			//删除所有关注的活动
			$this->db->where('activity_id',$activity_id);
			$this->db->delete('activity_attention_member');
			
			//删除所有活动留言
			$this->db->where('activity_id',$activity_id);
			$this->db->delete('activity_comment');
			
			
			//删除所有会员标签
			$this->db->where('activity_id',$activity_id);
			$this->db->delete('activity_tag');
			
			//删除所有发布者
			$this->db->where('activity_id',$activity_id);
			$this->db->delete('activity_publish_member');
			
			//删除活动
			$this->db->where('activity_id',$activity_id);
			$this->db->delete('activity');
			
			$this->forward('index');
			
		}
	}
	
	
}



?>
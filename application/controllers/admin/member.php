<?php
include_once "admin_controller.php";
Class Member Extends AdminController {

	var $applicationFolder = "member"; 
	var $tableName="member";
	var $idFieldName = 'member_id';
	
	function __construct() {
		parent::__construct();
	}
	
	function index(){
		$p_member_type = $this->getParameter('member_type',NULL);
		$p_page = $this->getParameter('page',1);
		$p_limit = $this->getParameter('limit',10);
		
		if ($p_member_type != '') {
			$this->db->where('member_type',$p_member_type);
		}
		$count = $this->db->count_all_results('member');
		$page_information = $this->setPageInformation($count,$p_page,$p_limit);
		
		if ($p_member_type != '') {
			$this->db->where('member_type',$p_member_type);
		}
		$all_member_information = $this->db->get('member',$p_limit,$page_information['page_offset'])->result_array();
		
		$this->ci_smarty->assign('member_type', $p_member_type);
		$this->ci_smarty->assign('page_information', $page_information);
		$this->ci_smarty->assign('count', $count);
		$this->ci_smarty->assign('all_member_information',$all_member_information);
		$this->displayWithLayout('index');
	}
	
	function edit(){
		$member_id = $this->getParameter('cid',NULL);
		
		if ($member_id) {
			
			$this->db->where('member_id',$member_id);
			$member_information = $this->db->get_first('member');;
			$this->ci_smarty->assign('member_information',$member_information);
			$this->ci_smarty->assign('member_id',$member_id);
		}
		
		$this->displayWithLayout('edit');
	
	
	}
	function info($member_id)
	{

		if ($member_id) {
			
			$this->db->where('member_id',$member_id);
			$member_information = $this->db->get_first('member');;
			$this->ci_smarty->assign('member_information',$member_information);
			$this->ci_smarty->assign('member_id',$member_id);
		}
			$this->displayWithLayout('info');
		}
	function saveItem() {
		$name = $this->getParameter('name',Null);
		$password = $this->getParameter('password',Null);
		$id = $this->getParameter('cid',Null);
		$data = array();
		
		$data['name'] = $name;
		$data['realname']=$this->getParameter('realname',Null);
		if($password != '') {
			$data['password'] = md5($password);
		}
		
		
		echo $id;
			
			$this->db->where('member_id',$id);
			$this->db->update('member',$data);
		
		$this->forward('../admin/member/index');
	}
	
	function remove(){
		$member_id = $this->getParameter('cid',Null);
		if ($member_id != '') {
			//删除所有系统消息
			$this->db->where('target_id',$member_id);
			$this->db->or_where('member_id',$member_id);
			$this->db->delete('system_message');
			
			//删除所有个人消息
			$this->db->where('target_id',$member_id);
			$this->db->or_where('member_id',$member_id);
			$this->db->delete('member_message');
			
			//删除所有参加的活动
			$this->db->where('member_id',$member_id);
			$this->db->delete('activity_attend');
			
			//删除所有关注的活动
			$this->db->where('member_id',$member_id);
			$this->db->delete('activity_follow');
			
			//删除所有活动留言
			$this->db->where('member_id',$member_id);
			$this->db->delete('activity_comment');
			
			
			//删除所有会员标签
			$this->db->where('member_id',$member_id);
			$this->db->delete('member_tag');
			
			//删除所有会员访问
			$this->db->where('member_id',$member_id);
			$this->db->or_where('visitor_id',$member_id);
			$this->db->delete('member_visit');
			
			//删除会员所有喜欢日志
			$this->db->where('member_id',$member_id);
			$this->db->delete('member_like_book');
			
			//日志操作
			
			$this->db->select('GROUP_CONCAT(book_id) as all_blog_id');
			$this->db->where('author_id',$member_id);
			$all_blog_id = idx($this->db->get_first('book'),'all_blog_id');
			
			if($all_blog_id != '') {
			
				$sql = "delete from ".$this->db->dbprefix('member_like_book')." where book_id in (".$all_blog_id.")";
				$this->db->query($sql);
				
				$this->db->where('member_id',$member_id);
				$this->db->delete('book');
			}
			
			//活动操作
			$this->db->select('GROUP_CONCAT(activity_id) as all_activity_id');
			$this->db->where('publisher_id',$member_id);
			$all_activity_id = idx($this->db->get_first('activity'),'all_activity_id');
			
			if($all_activity_id != '') {
			
				$sql = "delete from ".$this->db->dbprefix('activity_attend')." where activity_id in (".$all_activity_id.")";
				$this->db->query($sql);
				
				$sql = "delete from ".$this->db->dbprefix('activity_follow')." where activity_id in (".$all_activity_id.")";
				$this->db->query($sql);
				
				$sql = "delete from ".$this->db->dbprefix('activity_comment')." where activity_id in (".$all_activity_id.")";
				$this->db->query($sql);
				
				$sql = "delete from ".$this->db->dbprefix('activity_tag')." where activity_id in (".$all_activity_id.")";
				$this->db->query($sql);
				
				$sql = "delete from ".$this->db->dbprefix('activity')." where activity_id in (".$all_activity_id.")";
				$this->db->query($sql);
			}
			
			$this->db->where('member_id',$member_id);
			$this->db->delete('member');
			
			$this->forward('../admin/member/index');
			
			
			
		}
	}
	
	
}



?>
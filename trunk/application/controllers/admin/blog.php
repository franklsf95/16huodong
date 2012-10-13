<?php
include_once "admin_controller.php";
Class Blog Extends AdminController {

	var $applicationFolder = "blog"; 
	var $tableName="member_blog";
	var $idFieldName = 'member_blog_id';
	
	function __construct() {
		parent::__construct();
	}
	
	function index(){
		$p_page = $this->getParameter('page',1);
		$p_limit = $this->getParameter('limit',10);
		
		
		$count = $this->db->count_all_results('member_blog');
		$page_information = $this->createPageInformation($count,$p_page,$p_limit);
		
		$this->db->select('mb.*, m.name as member_name');
		$this->db->from('member_blog as mb');
		$this->db->join('member as m','m.member_id = mb.member_id');
		
		$all_blog_information = $this->db->get('',$limit,$page_information['page_offset'])->result_array();
		
		$this->ci_smarty->assign('page_information', $page_information);
		$this->ci_smarty->assign('count', $count);
		$this->ci_smarty->assign('all_blog_information',$all_blog_information);
		$this->displayWithLayout('index');
	}
	
	function edit(){
		$member_blog_id = $this->getParameter('cid',NULL);
		
		if ($member_blog_id) {
			
			$this->db->where('member_blog_id',$member_blog_id);
			$blog_information = $this->db->get_first('member_blog');;
			$this->ci_smarty->assign('blog_information',$blog_information);
			$this->ci_smarty->assign('member_blog_id',$member_blog_id);
		}
		
		$this->displayWithLayout('edit');
	
	
	}
	
	function _saveItem($isNew, &$id, &$param) {
		$name = $this->getParameter('name',Null);
		$content = $this->getParameter('content',Null);
		
		$data = array();
		
		$data['name'] = $name;
		$data['content'] = $content;
		
		
		if ($isNew) {
			$data['created_time'] = $date_time;
			$data['modified_time'] = $date_time;
			$this->db->insert('member_blog',$data);
		} else {
			$data['modified_time'] = $date_time;
			$this->db->where('member_blog_id',$id);
			$this->db->update('member_blog',$data);
		}
		$this->forward('index');
	}
	
	function remove(){
		$member_blog_id = $this->getParameter('cid',Null);
		if ($member_blog_id != '') {
			//删除所有点击
			$this->db->where('member_blog_id',$member_blog_id);
			$this->db->delete('member_blog_hits');
			
			
			//删除所有评论
			$this->db->where('member_blog_id',$member_blog_id);
			$this->db->delete('member_blog_comment');
			
			//删除所有喜欢
			$this->db->where('member_blog_id',$member_blog_id);
			$this->db->delete('member_prefer_blog');
			
			
			//删除活动
			$this->db->where('member_blog_id',$member_blog_id);
			$this->db->delete('member_blog');
			
			$this->forward('index');
			
		}
	}
	
	
}



?>
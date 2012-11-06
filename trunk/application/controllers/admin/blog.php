<?php
include_once "admin_controller.php";
Class Blog Extends AdminController {

	var $applicationFolder = "blog"; 
	var $tableName="book";
	var $idFieldName = 'book_id';
	
	function __construct() {
		parent::__construct();
	}
	
	function index(){
		$p_page = $this->getParameter('page',1);
		$p_limit = $this->getParameter('limit',10);
		
		
		$count = $this->db->count_all_results('book');
		$page_information = $this->createPageInformation($count,$p_page,$p_limit);
		
		$this->db->select('mb.*, m.name as member_name');
		$this->db->from('book as mb');
		$this->db->join('member as m','m.member_id = mb.member_id');
		
		$all_blog_information = $this->db->get('',$limit,$page_information['page_offset'])->result_array();
		
		$this->ci_smarty->assign('page_information', $page_information);
		$this->ci_smarty->assign('count', $count);
		$this->ci_smarty->assign('all_blog_information',$all_blog_information);
		$this->displayWithLayout('index');
	}
	
	function edit(){
		$book_id = $this->getParameter('cid',NULL);
		
		if ($book_id) {
			
			$this->db->where('book_id',$book_id);
			$blog_information = $this->db->get_first('book');;
			$this->ci_smarty->assign('blog_information',$blog_information);
			$this->ci_smarty->assign('book_id',$book_id);
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
			$this->db->insert('book',$data);
		} else {
			$data['modified_time'] = $date_time;
			$this->db->where('book_id',$id);
			$this->db->update('book',$data);
		}
		$this->forward('index');
	}
	
	function remove(){
		$book_id = $this->getParameter('cid',Null);
		if ($book_id != '') {
			//删除所有点击
			$this->db->where('book_id',$book_id);
			$this->db->delete('book_hits');
			
			
			//删除所有评论
			$this->db->where('book_id',$book_id);
			$this->db->delete('book_comment');
			
			//删除所有喜欢
			$this->db->where('book_id',$book_id);
			$this->db->delete('member_like_book');
			
			//删除活动
			$this->db->where('book_id',$book_id);
			$this->db->delete('book');
			
			$this->forward('index');
			
		}
	}
	
	
}



?>
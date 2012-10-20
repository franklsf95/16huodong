<?php
include_once dirname(__FILE__)."/admin_controller.php";
Class Ajax_controller extends AdminController {
	var $viewFolder = 'admin';	
	var $layoutFolder = 'admin/layout/';
	var $applicationFolder = "login";
	function __construct() {
		parent::__construct();
		if ($this->enable_session) {
			//启用session			
			@session_start();
		}
		
		
		$this->load->model('db_article_class');
		$this->ci_smarty->assign('lang','chs');
		$this->check_login();
	}
	
	function check_login(){
		if(!$this->getSessionValue(application_user_id)) {
			$this->forward('../login/index');
			}
	}
	
	
	function changeNavigateOrder(){						//更改导航排序，将当前导航条目与前一个导航条目的order相交换
		$navigate_id = $this->getParameter('navigate_id',NULL);
		
		if($navigate_id) {
			$this->db->select('navigate_id,order');
			$this->db->where('navigate_id',$navigate_id);
			$navigate_information = $this->db->get_first('navigate');
			
			$this->db->select('navigate_id,order');
			$this->db->where('order < ',$navigate_information['order']);
			$this->db->order_by('order','DESC');
			$previous_navigate_information = $this->db->get_first('navigate');
			
			$data1['order'] = $previous_navigate_information['order'];
			$this->db->where('navigate_id',$navigate_information['navigate_id']);
			$this->db->update('navigate',$data1);
			
			$data2['order'] = $navigate_information['order'];
			$this->db->where('navigate_id',$previous_navigate_information['navigate_id']);
			$this->db->update('navigate',$data2);
		
		}
		
		$data['result'] = 'Y';
		
		echo json_encode($data);
		
	}
	
	function getArticleClass() {
		$all_article_class_information = $this->getClassList("article",0,0,"array");
		echo json_encode($all_article_class_information);
	}
	
	function getProductClass() {
		$all_product_class_information = $this->getClassList("product",0,0,"array");
		echo json_encode($all_product_class_information);
	}
	
	
	function getSpecialTopicClass(){
		$this->db->where('status','Y');
		$all_special_topic_class_information = $this->db->get('special_topic_class')->result_array();
		echo json_encode($all_special_topic_class_information);
	}
	
	
	function getSpecialTopic(){
		$this->db->where('status','	Y');
		$all_special_topic_information = $this->db->get('special_topic')->result_array();
		echo json_encode($all_special_topic_information);
	}
	
	
	function checkPassword(){
		
		$application_user_id = $this->getParameter('application_user_id',Null);
		$password = $this->getParameter('password',Null);
		$data['result'] = 'N';
		
		if ($application_user_id && $password) {
		
			$this->db->where('application_user_id',$application_user_id);
			$this->db->where('password',md5($password));
			
			if ($this->db->count_all_results('application_user') == 1) {
				$data['result'] = 'Y';
			}
		}
		
		echo json_encode($data);
	}
	
	function checkUsername(){
		$username = $this->getParameter('username',Null);
		$data['result'] = 'Y';
		if ($username) {
			$this->db->where('username',$username);
			if ($this->db->count_all_results('application_user') == 1) {
				$data['result'] = 'N';
			}
		}
		
		echo json_encode($data);
	}
	
	
	function checkArticleClassParent(){
		$class_id = $this->getParameter('class_id',Null);
		$parent_id = $this->getParameter('parent_id',Null);
		$data['result'] = "Y";
		//获取当前分类的子类
		
		$ban_class_array = $this->getClassList('article',$class_id);
		
		if (!empty($ban_class_array[$parent_id])){
			$data['result'] = "N";
		}
		echo json_encode($data);
	}
	
	function checkProductClassParent(){
		$class_id = $this->getParameter('class_id',Null);
		$parent_id = $this->getParameter('parent_id',Null);
		$data['result'] = "Y";
		//获取当前分类的子类
		
		$ban_class_array = $this->getClassList('product',$class_id);
		
		if (!empty($ban_class_array[$parent_id])){
			$data['result'] = "N";
		}
		echo json_encode($data);
	}
	
	
	
}
?>
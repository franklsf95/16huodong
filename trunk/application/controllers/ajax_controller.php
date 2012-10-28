<?php
include_once dirname(__FILE__)."/../base_controller.php";
/**
* @deprecated
* for Admin panel use
*/
Class Ajax_controller extends BaseController {
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
		$this->db->where('status','Y');
		$all_article_class_information = $this->db->get('article_class')->result_array();
		echo json_encode($all_article_class_information);
	}
	
	function getProductClass() {
		$this->db->where('status','Y');
		$all_product_class_information = $this->db->get('product_class')->result_array();
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
		
		$application_user_id = $this->getParameter('application_user_id',NULL);
		$password = $this->getParameter('password',NULL);
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
	
	
	
}
?>
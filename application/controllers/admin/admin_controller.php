<?php
include_once dirname(__FILE__)."/../base_controller.php";
Class AdminController extends BaseController {
	var $viewFolder = 'admin';	
	var $layoutFolder = 'admin/layout/';
	var $applicationFolder = "login";
	var $tableName = '';
	var $article_options = array();
	var $product_options = array();
	
	function __construct() {
		parent::__construct();
		if ($this->enable_session) {
			//启用session			
			@session_start();
		}
		
		//重新定义后台模板地址
		if ($this->applicationFolder) {
		
			$this->viewFolder = 'admin';	
			$this->layoutFolder = 'admin/layout/';
			
			$this->viewFolder = $this->viewFolder.'/'.$this->applicationFolder;
		}
		
		$current_time = date('Y-m-d H:i:s');
		$this->ci_smarty->assign('current_time',$current_time);
		
		$this->ci_smarty->assign('lang','chs');
		$this->check_login();
	}
	
	function check_login(){
		if(!$this->getSessionValue(application_user_id)) {
			$this->forward('../admin/login');
		}else {
			$this->ci_smarty->assign('current_application_user_information',$_SESSION);
		}
	}
	
	

	function _saveItem($isNew, &$id, &$param) {
	
	}

	function save_form() {
		$isNew = true;
		$p_id = $this->getParameter('cid', 0);
		if ($p_id != 0) {
			$isNew = false;
		}
		$param = null;
		$error_message = $this->_saveItem($isNew, $p_id, $param);
		if ($error_message) {
			echo $error_message;
		} else {
			$this->forward('../admin/'.$this->applicationFolder.'/index');
		}
	}
	
	
	function remove() {
		$cid = $this->getParameter('cid', array());
		$can_remove = true;
		foreach ($cid as $p_id) {
			if (!is_numeric($p_id)) {
				continue;
			}
			$can_remove = $this->_RemoveCheck($p_id);			//此函数可在具体页面自行定义，可做一些删除前的操作（例如删除相关导航）
			if (!$can_remove) {
				break;
			}
		}
		if ($can_remove) {
			foreach ($cid as $p_id) {
				$this->db->where($this->idFieldName, $p_id);
				$this->db->delete($this->tableName);
			}
		}
		$data['result'] = 'Y';
		echo json_encode($data);
	}
	
	function _removeCheck(){
		return true;
	}
}
?>
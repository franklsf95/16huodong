<?php
include_once dirname(__FILE__)."/base_controller.php";
Class Base_ajax_controller extends BaseController {

	function __construct() {
		parent::__construct();
		$this->ci_smarty->assign('lang','chs');
		$this->load->model('db_public_area');
		$this->load->model('db_public_school');
	}
	
	//资料获取
	
	function getPublicAreaInformation(){
		$area_id = $this->getParameter('area_id',NULL);
		$public_area_information = $this->db_public_area->getPublicAreaInformation($area_id);
		echo json_encode($public_area_information);
	}
	
	function getAllProvinceInformation(){
		$all_province_information = $this->db_public_area->getAllProvinceInformation();
		echo json_encode($all_province_information);
	}
	
	
	function getAllCityInformation(){
		$area_id = $this->getParameter('area_id',NULL);
		$all_city_information = $this->db_public_area->getAllCityInformation($area_id);
		echo json_encode($all_city_information);
	}
	
	function getAllAreaInformation(){
		$area_id = $this->getParameter('area_id',NULL);
		$all_area_information = $this->db_public_area->getAllAreaInformation($area_id);
		echo json_encode($all_area_information);
	}
	
	function getAllSchoolInformation(){
		$area_id = $this->getParameter('area_id',NULL);
		$all_school_information = $this->db_public_school->getAllSchoolInformation($area_id);
		echo json_encode($all_school_information);
	}
	
	function getSchoolInformation(){
		$school_id = $this->getParameter('school_id',NULL);
		$school_information = $this->db_public_school->getPublicSchoolInformation($school_id);
		echo json_encode($school_information);
	}
	
	

	
	
}
?>
<?php
include_once "base_action_controller.php";
/**
* @deprecated
*/
Class Album Extends BaseactionController {

	var $applicationFolder = "album"; 
	
	function __construct() {
		parent::__construct();
		
		$member_id = $this->getParameter('member_id',$this->current_member_id);
		$member_base_information = $this->extend_control->getMemberBaseInformation($member_id);
		$this->ci_smarty->assign('member_base_information',$member_base_information);
		
	}
	
	function index(){
		
		$all_new_album_information = $this->extend_control->getNewAlbumInformation();
		
		$all_member_album_information = $this->extend_control->getMemberAlbumInformation($this->current_member_id);
		
		$this->ci_smarty->assign('all_new_album_information',$all_new_album_information);
		$this->ci_smarty->assign('all_member_album_information',$all_member_album_information);
		
		$this->displayWithLayout('index');
	}
	
	function view_album(){
		$member_id = $this->getParameter('member_id',$this->current_member_id);
		$album_id = $this->getParameter('id',NULL);
		$p_page = $this->getParameter('page',1);
		$p_limit = $this->getParameter('limit',8);
		
		$count = $this->extend_control->countAlbumPhoto($album_id);
		
		$page_information = $this->createPageInformation($count, $p_page, $p_limit);
		
		$album_base_information = $this->extend_control->getAlbumBaseInformation($album_id);
		$all_album_photo_information = $this->extend_control->getAlbumPhotoInformation($member_id,$album_id,$page_information['page_offset'],$p_limit);
		
		$this->ci_smarty->assign('page_information',$page_information);
		$this->ci_smarty->assign('album_base_information',$album_base_information);
		$this->ci_smarty->assign('all_album_photo_information',$all_album_photo_information);
		
		$this->displayWithLayout('view_album');
		
	}
	
	function view_photo(){
		$photo_id = $this->getParameter('id',NULL);
		
		$photo_information = $this->extend_control->getPhotoInformation($photo_id);
		
		$this->ci_smarty->assign('photo_information',$photo_information);
		
		$this->displayWithLayout('view_photo');
	}
	
	function edit_photo(){
		$member_photo_id = $this->getParameter('id',NULL);
		
		if ($member_photo_id){
			$this->db->where('member_photo_id',$member_photo_id);
			$member_photo_information = $this->db->get_first('member_photo');
			$this->ci_smarty->assign('member_photo_information',$member_photo_information);
			$this->ci_smarty->assign('cid',$member_photo_id);
		}
	
		$this->displayWithLayout('edit_photo');
	}
	
	function edit(){

	}
	
	
	function _saveItem($isNew, &$id, &$param) {
		$member_id = $this->current_member_information['member_id'];
		$name = $this->getParameter('name',NULL);
		$member_album_id = $this->getParameter('member_album_id',NULL);
		$image = $this->getParameter('image',NULL);
		$description = $this->getParameter('description',NULL);

		$data['name'] = $name;
		$data['member_id'] = $member_id;
		$data['member_album_id'] = $member_album_id;
		$data['image'] = $image;
		$data['description'] = $description;

		if ($isNew){
			$data['created_time'] = $this->current_time;
			
			$this->db->insert('member_photo',$data);
			
			redirect('album');
			
		}else {
			$data['modified_time'] = $this->current_time;
			$this->db->where('member_photo_id',$id);
			$this->db->update('member_photo',$data);
		}
		
	}
	
	
	
	
	
}



?>
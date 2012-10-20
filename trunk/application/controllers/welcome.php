<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once "base_controller.php";
class Welcome extends BaseController {
	var $applicationFolder = "welcome"; 
	
	function index()
	{
		if ($this->getSessionValue('current_member_information')) {
			redirect('index');
		}
		$this->display('index','欢迎');
	}
}


<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once "base_controller.php";
class Welcome extends BaseController {
	var $applicationFolder = "welcome"; 
	
	function index()
	{
		$this->displayWithoutLayout('index');
	}
}


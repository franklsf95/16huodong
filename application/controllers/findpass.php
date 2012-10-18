<?php
include_once "base_controller.php";
Class FindPass Extends BaseController {

	var $applicationFolder = "findpass"; 
	
	function __construct() {
		parent::__construct();
	}
	
	function resetPass(){
		$vcode=$this->input->get('vcode', TRUE);
		if ($vcode==FALSE) {
			show_error('链接不正确');
		}else{
			$this->db->select('m.member_id, m.vcode, m.valid');
			$this->db->from('member_findpass as m');
			$this->db->where('vcode',$vcode);
			$vcode_information = $this->db->get_first();
			
			if ($vcode_information && $vcode_information['valid']!=0) {
				$this->ci_smarty->assign('vcode',$vcode);
				$this->displayWithoutLayout('resetPass');
			}else{
				show_error('链接不正确');
			}
		}
	}
	
	function resetPassSubmit(){
		$vcode=$this->input->get('vcode', TRUE);
		if ($vcode==FALSE) {
			show_error('链接不正确');
		}else{
			$this->db->select('m.member_id, m.vcode, m.valid');
			$this->db->from('member_findpass as m');
			$this->db->where('vcode',$vcode);
			$vcode_information = $this->db->get_first();
			
			if ($vcode_information && $vcode_information['valid']!=0) {
				$vcode_information['valid']=0;
				$new_password = $this->getParameter('password',Null);
				
				$this->db->select('m.member_id, m.account, m.member_type, m.password');
				$this->db->from('member as m');
				$this->db->where('member_id',$vcode_information['member_id']);
			
				$member_information = $this->db->get_first();
				if ($member_information) {
					$member_information['password'] = md5($new_password);
					$this->db->where('member_id',$vcode_information['member_id']);
					$this->db->update('member',$member_information);
				}
				
				$this->db->where('vcode',$vcode);
				$this->db->update('member_findpass',$vcode_information);
				$this->displayWithoutLayout('done');
			}else{
				show_error('链接不正确');
			}
		}
	}
	
	function index(){
		if ($this->getSessionValue('current_member_information')) {
			redirect('index');
		}else {
			$this->displayWithoutLayout('index');
		}
	}
	
	function findPassSubmit(){
		$account = $this->getParameter('account',NULL);
		
		if ($account != ''){
			$this->db->select('m.member_id, m.account, m.email');
			$this->db->from('member as m');
			$this->db->where('account',$account);
			$member_information = $this->db->get_first();
			
			if ($member_information) {
				$this->load->library('email');
				$to = $member_information['email'];
				$subject = "16活动网-找回密码";
				$vcode = $this->randstr();
				$message = "<html><body>请点击以下链接来找回密码<br>";
				$message.= '<a href="'.$_SERVER['DOCUMENT_ROOT'].'/index.php/findpass/resetPass?vcode='. $vcode. '">'.$_SERVER['DOCUMENT_ROOT'].'/index.php/findpass/resetPass?vcode='. $vcode. '</a></body></html>';
				
				$config["protocol"]     = "smtp";
				$config["smtp_host"]    = "smtp.ym.163.com";
				$config["smtp_user"]    = "guanliyuan@16huodong.com";
				$config["smtp_pass"]    = "poiuytrewq";
				$config["mailtype"]     = "html";
				$config["validate"]     = true;
				$config["priority"]     = 3;
				$config["crlf"]         = "/r/n";
				$config["smtp_port"]    = 25;
				$config["charset"]      = "utf-8";
				$config["wordwrap"]     = TRUE;
				$this->email->initialize($config);
				$this->email->from('guanliyuan@16huodong.com', 'admin');
				$this->email->to($to);     
				$this->email->subject($subject);
				$this->email->message($message); 
				$this->email->send();
				$data['member_id'] = $member_information['member_id'];
				$data['vcode'] = $vcode;
				$data['valid'] = 1;
				$this->db->insert('member_findpass',$data);
				$this->displayWithoutLayout('sent');
			}else {
				show_error('帐号错误，请检查输入');
			}
		}else {
			show_error('请输入帐号！');
		}
	
	}
	
	function logout(){
		$this->unsetSessionValue('current_member_information');
		setcookie('member_cookie[remember]','',time()-3600,'/');
		setcookie('member_cookie[account]','',time()-3600,'/');
		setcookie('member_cookie[key]','',time()-3600,'/');
		redirect('login');
	}
	
	function cookie(){
		print_r($_COOKIE['member_cookie']);
		exit();
	}
	function randstr($len=6) { 
		$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~'; 
		// characters to build the password from 
		$password=''; 
		while(strlen($password)<$len) 
		$password.=substr($chars,(mt_rand()%strlen($chars)),1); 
		return $password; 
	}
	
	
}



?>
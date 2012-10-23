<?php
include_once "base_controller.php";
/**
* 控制找回密码
* 显示找回密码步骤页面
*
* @author wangpeng
*/
Class FindPass Extends BaseController {

	var $applicationFolder = "findpass"; 
	
	function __construct() {
		parent::__construct();
	}

	/**
	* 显示：扔给welcome去处理
	*/
	function index(){
		redirect('welcome');
	}
	
	/**
	* 处理重设密码请求
	* 显示修改密码界面
	* 
	* @param	vcode	找回密码验证码
	*/
	function resetPass(){
		$vcode=$this->input->get('vcode', TRUE);
		if ($vcode==FALSE) {
			show_error('链接不正确');
		}else{
			$this->db->select('m.member_id, m.vcode, m.valid');
			$this->db->from('member_findpass as m');
			$this->db->where('vcode',$vcode);
			$vcode_information = $this->db->get_first();
			
			if ($vcode_information && $vcode_information['valid'] ) {
				$this->ci_smarty->assign('vcode',$vcode);
				$this->display('resetPass','重设密码');
			}else{
				show_error('链接不正确');
			}
		}
	}
	
	/**
	* 处理修改密码
	* 显示修改密码成功页面
	* 
	* @param	vcode	找回密码验证码
	*/
	function resetPassSubmit() {
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
				$this->display('done','修改密码成功');
			}else{
				show_error('链接不正确');
			}
		}
	}
	
	/**
	* 处理来自welcome的修改密码请求
	* 显示请查收邮件页面
	*
	* @param	account			要找回的账户名
	* @param	verifyEmail		确认Email
	*/
	function findPassSubmit(){
		$account = $this->getParameter('findUsername',NULL);
		$verifyEmail = $this->getParameter('findEmail',NULL);
		
		if ($account != ''){
			$this->db->select('m.member_id, m.account, m.email');
			$this->db->from('member as m');
			$this->db->where('account',$account);
			$member_information = $this->db->get_first();

			if( strcmp( $member_information['email'], $verifyEmail )!=0 ) {
				show_error('用户名和邮箱不匹配');
			}
			
			if ($member_information) {
				$this->load->library('email');
				$to = $member_information['email'];
				$subject = "16活动网-找回密码";
				$vcode = $this->randstr();
				$message = "<html><body>请点击以下链接来找回密码<br>";
				$message.= '<a href="http://'.$_SERVER ['HTTP_HOST'].'/index.php/findpass/resetPass?vcode='. $vcode. '">http://'.$_SERVER ['HTTP_HOST'].'/index.php/findpass/resetPass?vcode='. $vcode. '</a></body></html>';
				
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

				$this->display('sent','找回密码');
			}else {
				show_error('帐号错误，请检查输入');
			}
		}else {
			show_error('请输入帐号！');
		}
	
	}

	/**
	* 工具函数：生成随机vcode
	*
	* @param	$len	要生成的vcode位数
	*
	* @return	$len位的vcode
	*/
	function randstr($len=8) { 
		$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~'; 
		// characters to build the password from 
		$vcode=''; 
		while(strlen($vcode)<$len) 
			$vcode.=substr($chars,(mt_rand()%strlen($chars)),1); 
		return $vcode; 
	}
}

?>
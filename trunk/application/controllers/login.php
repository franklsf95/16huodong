<?php
include_once "base_controller.php";
/**
* 处理登录和登出
* 不显示任何页面，$applicationFolder = '';
*/
Class Login Extends BaseController {
	
	function __construct() {
		parent::__construct();
	}
	
	function index(){
		redirect('index');
	}
	
	/**
     * 处理登录
     *
     * @param account	用户名
     * @param password	密码
     * @param member_cookie	是否保留cookie
     */
	function loginSubmit(){
		$account = $this->getParameter('account',NULL);
		$password = $this->getParameter('password',NULL);
		$member_cookie = $this->getParameter('member_cookie',False);
		
		
		if ($account != '' && $password != ''){
			$this->db->select('m.member_id, m.account, m.member_type, m.member_type_2, m.status as member_status, m.image as member_image, m.name as member_name, m.principal, m.gender, m.birthday, m.hobby, m.qq, m.mobilephone, m.phone, m.email, m.address, m.tag, m.description, m.content, m.created_time, m.modified_time, m.current_school, ps.name as current_school_name');
			$this->db->from('member as m');
			$this->db->join('public_school as ps','ps.school_id = m.current_school','LEFT');
			$this->db->where('account',$account);
			$this->db->where('password',md5($password));
			$member_information = $this->db->get_first();
			
			if ($member_information) {
				if ($member_cookie == 'Y') {
					$member_cookie = array('remember' => 'Y','account' => $member_information['account'],'key'=>md5(md5($password).md5($password)));
					setcookie('member_cookie[remember]',$member_cookie['remember'],time()+3600*24*30,'/');
					setcookie('member_cookie[account]',$member_cookie['account'],time()+3600*24*30,'/');
					setcookie('member_cookie[key]',$member_cookie['key'],time()+3600*24*30,'/');
					
					//print_r($_COOKIE['member_cookie']);
					//exit();
				}
				$this->setSessionValue('current_member_information',$member_information);
				redirect('index');
			}else {
				show_error('帐号或密码错误，请检查输入');
			}
		}else {
			show_error('请输入帐号密码！');
		}
	
	}
	
	/**
     * 处理登出
     */
	function logout(){
		$this->unsetSessionValue('current_member_information');
		setcookie('member_cookie[remember]','',time()-3600,'/');
		setcookie('member_cookie[account]','',time()-3600,'/');
		setcookie('member_cookie[key]','',time()-3600,'/');
		redirect('index');
	}
	
	/**
	* @deprecated
	*/
	function cookie(){
		print_r($_COOKIE['member_cookie']);
		exit();
	}
	
}
?>
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
		$ref = $this->getParameter('ref',NULL);
		if ( $account == '' || $password == '' ) 	show_error('用户名或密码为空!');

		$this->db->select('member_id');
		$this->db->from('member');
		$this->db->where('account',$account);
		$this->db->where('password',md5($password));
		$current_member_id = idx( $this->db->get_first(), 'member_id' );

		if ( !$current_member_id ) 	show_error('该用户不存在!');

		if ($member_cookie == 'Y') {
			$member_cookie = array('remember' => 'Y','account' => $member_information['account'],'key'=>md5(md5($password).md5($password)));
			setcookie('member_cookie[remember]',$member_cookie['remember'],time()+3600*24*30,'/');
			setcookie('member_cookie[account]',$member_cookie['account'],time()+3600*24*30,'/');
			setcookie('member_cookie[key]',$member_cookie['key'],time()+3600*24*30,'/');
		}
		$this->setSessionValue('current_member_id',$current_member_id);
		if($ref){
			redirect(rawurldecode($ref));
		}else{
			redirect('index');
		}
	}
	
	/**
     * 处理登出
     */
	function logout(){
		$this->unsetSessionValue('current_member_id');
		setcookie('member_cookie[remember]','',time()-3600,'/');
		setcookie('member_cookie[account]','',time()-3600,'/');
		setcookie('member_cookie[key]','',time()-3600,'/');
		redirect('welcome');
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
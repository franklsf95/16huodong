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
		$account = $this->getParameter('account');
		$password = $this->getParameter('password');
		$member_cookie = $this->getParameter('member_cookie');
		$ref = $this->getParameter('ref');

		if ( $account == '' || $password == '' ) 	show_error('用户名或密码为空!');

		//Login validation
		$this->db->select('member_id, account');
		$this->db->from('member');
		if(substr_count($account,'@')==0){
			$this->db->where('account',$account);
		}else{
			$this->db->where('email',$account);
		}
		$this->db->where('password',md5($password));
		$current_member=$this->db->get_first();

		if ( !$current_member ) 	show_error('用户名或密码错误!');
		$account=$current_member['account'];

		//Set session
		$this->session->set_userdata( 'current_member_id', $current_member['member_id'] );

		//Set cookie
		if ($member_cookie == 'Y') {
			$this->input->set_cookie( 'account', $current_member['account'], 3600*24*30 );
			$this->input->set_cookie( 'passmd5', md5( md5($password).md5($password) ), 2600*24*30 );
		}

		if( $ref ) redirect(rawurldecode($ref));
		redirect('index');
	}
	
	/**
     * 处理登出
     */
	function logout(){
		//unset session
		$this->session->unset_userdata( 'current_member_id' );
		//unset cookie
		delete_cookie( 'account' );
		delete_cookie( 'passmd5' );

		redirect('welcome');
	}
}
?>
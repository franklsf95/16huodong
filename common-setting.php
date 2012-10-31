<?php
	$config['application_prefix'] = '/';			//配置程序目录
	$config['backend_prefix'] = '/';
	$config['template'] = "default";			//配置模板目录

	//if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
	error_reporting(E_ALL & ~E_NOTICE);
	$config['application_inc'] = '/inc/';
	$config['template_prefix'] = $config['application_prefix'].'application/views/'.$config['template'].'/';			//模板所在路径

	$ci_application_folder = $_SERVER['DOCUMENT_ROOT'] . $config['backend_prefix'] . "application";
	$config['application_path'] = $_SERVER['DOCUMENT_ROOT'] . $config['application_prefix'];
	$config['backend_path'] = $_SERVER['DOCUMENT_ROOT'] . $config['backend_prefix'];
	$config['base_url']	= "http://" . $_SERVER['HTTP_HOST'] . $config['backend_prefix'];

	$config['dbprefix'] = '16_';
	
	global $dsn;
	$dsn = array(
		'phptype'  => 'mysql',
		'dbdriver'  => 'mysql',
		'username' => 'root',
		'password' => '',
		'hostspec' => 'localhost',
		'database' => '16huodong',
		'dbprefix' => $config['dbprefix']
	);
	
	$config['all_avaliable_language'] = array('eng','cht','chs');
	
?>
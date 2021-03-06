<?php
include_once "base_action_controller.php";
/**
 * KindEditor PHP
 * 
 * CODE BY 蒜头
 * 文章中的图片上传，进行适当缩放，但不剪裁
 */
Class ImageUpload Extends BaseActionController {
	var $applicationFolder = "upload"; 
	function __construct() {
		parent::__construct();
		
	}
	function index() {
		$member_id = $this->current_member_id;
		$php_path = dirname(__FILE__) . '/';
		$php_url = dirname($_SERVER['PHP_SELF']) . '/';
		if ( !$member_id ) {
			show_error('用户不存在');
		}

		//文件保存目录路径
		$save_path = $php_path . '../../upload/'.$member_id.'/';
		//文件保存目录URL
		$save_url = $php_url . '../../upload/'.$member_id.'/';

		if (!is_dir($save_path)){
			mkdir($save_path);
		}

		//定义允许上传的文件扩展名
		$ext_arr = array(
			'image' => array('gif', 'jpg', 'jpeg', 'png'),
			'flash' => array('swf', 'flv'),
			'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
			'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
		);
		//最大文件大小
		$max_size = 3074304;

		$save_path = realpath($save_path) . '/';

		//有上传文件时
		if (empty($_FILES) === false) {
			//原文件名
			$file_name = $_FILES['imgFile']['name'];
			//服务器上临时文件名
			$tmp_name = $_FILES['imgFile']['tmp_name'];
			//文件大小
			$file_size = $_FILES['imgFile']['size'];
			//检查文件名
			if (!$file_name) {
				alert("请选择文件。");
			}
			//检查目录
			if (@is_dir($save_path) === false) {
				alert("上传目录不存在。");
			}
			//检查目录写权限
			if (@is_writable($save_path) === false) {
				alert("上传目录没有写权限。");
			}
			//检查是否已上传
			if (@is_uploaded_file($tmp_name) === false) {
				alert("临时文件可能不是上传文件。");
			}
			//检查文件大小
			if ($file_size > $max_size) {
				alert("上传文件大小不能超过500KB。");
			}
			//检查目录名
			$dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
			if (empty($ext_arr[$dir_name])) {
				alert("目录名不正确。");
			}
			//获得文件扩展名
			$temp_arr = explode(".", $file_name);
			$file_ext = array_pop($temp_arr);
			$file_ext = trim($file_ext);
			$file_ext = strtolower($file_ext);
			//检查扩展名
			if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
				alert("上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr[$dir_name]) . "格式。");
			}
			
			//创建文件夹
			if ($dir_name !== '') {
				$save_path .= $dir_name . "/";
				$save_url .= $dir_name . "/";
				if (!file_exists($save_path)) {
					mkdir($save_path);
				}
			}

			//新文件名
			$new_file_name_without_ext = date("YmdHis") . '_' . rand(10000, 99999) ;
			
			$new_file_name = $new_file_name_without_ext . '.' . $file_ext;

			
			//移动文件
			$file_path = $save_path . $new_file_name;
			if (move_uploaded_file($tmp_name, $file_path) === false) {
				alert("上传文件失败。");
			}
			@chmod($file_path, 0644);
			$file_url = $save_url . $new_file_name_without_ext . '.jpg';
			list($src_w,$src_h)=getimagesize($file_path);
			if($src_w>800)$this->resizeimage($file_path,800,800/$src_w*$src_h,$save_path.$new_file_name_without_ext.'.jpg');
			else $this->resizeimage($file_path,$src_w,$src_h,$save_path.$new_file_name_without_ext.'.jpg');
			if($file_ext!='jpg')unlink($file_path);
			header('Content-type: text/html; charset=UTF-8');
			echo json_encode(array('error' => 0, 'url' => str_replace('\\','',$file_url)));
			exit;
		}
	}

	function alert($msg) {
		header('Content-type: text/html; charset=UTF-8');
		$json = new Services_JSON();
		echo json_encode(array('error' => 1, 'message' => $msg));
		exit;
	}

	/**
	 * 生成保持原图纵横比的缩略图，支持.png .jpg .gif
	 * 缩略图类型统一为.jpg格式
	 * $srcFile     原图像文件名称
	 * $toW         缩略图宽
	 * $toH         缩略图高
	 * $toFile      缩略图文件名称，为空覆盖原图像文件
	 * @return bool    
	*/
	function resizeimage($srcFile, $toW, $toH, $toFile="") 
	{
		if ($toFile == "")
		{ 
			$toFile = $srcFile; 
		}
		$info = "";
		//返回含有4个单元的数组，0-宽，1-高，2-图像类型，3-宽高的文本描述。
		//失败返回false并产生警告。
		$data = getimagesize($srcFile, $info);
		if (!$data)
			return false;
		
		//将文件载入到资源变量im中
		switch ($data[2]) //1-GIF，2-JPG，3-PNG
		{
		case 1:
			if(!function_exists("imagecreatefromgif"))
			{
				echo "the GD can't support .gif, please use .jpeg or .png! <a href='javascript:history.back();'>back</a>";
				exit();
			}
			$im = imagecreatefromgif($srcFile);
			break;
			
		case 2:
			if(!function_exists("imagecreatefromjpeg"))
			{
				echo "the GD can't support .jpeg, please use other picture! <a href='javascript:history.back();'>back</a>";
				exit();
			}
			$im = imagecreatefromjpeg($srcFile);
			break;
			  
		case 3:
			$im = imagecreatefrompng($srcFile);    
			break;
		}
		
		//计算缩略图的宽高
		$srcW = imagesx($im);
		$srcH = imagesy($im);
		$toWH = $toW / $toH;
		$srcWH = $srcW / $srcH;
		if ($toWH <= $srcWH) 
		{
			$ftoW = $toW;
			$ftoH = (int)($ftoW * ($srcH / $srcW));
		}
		else 
		{
			$ftoH = $toH;
			$ftoW = (int)($ftoH * ($srcW / $srcH));
		}
		
		if (function_exists("imagecreatetruecolor")) 
		{
			$ni = imagecreatetruecolor($ftoW, $ftoH); //新建一个真彩色图像
			if ($ni) 
			{
				//重采样拷贝部分图像并调整大小 可保持较好的清晰度
				imagecopyresampled($ni, $im, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH);
			} 
			else 
			{
				//拷贝部分图像并调整大小
				$ni = imagecreate($ftoW, $ftoH);
				imagecopyresized($ni, $im, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH);
			}
		}
		else 
		{
			$ni = imagecreate($ftoW, $ftoH);
			imagecopyresized($ni, $im, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH);
		}

		//保存到文件 统一为.jpeg格式
		imagejpeg($ni, $toFile, 80);
		ImageDestroy($ni);
		ImageDestroy($im);
		return true;
	}
}
?>
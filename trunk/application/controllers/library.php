<?php
include_once "base_action_controller.php";
/**
* 显示人生图书馆、写书功能
*/
Class Library Extends BaseActionController {

	var $applicationFolder = "library"; 
	
	function __construct() {
		parent::__construct();
	}
	
	/**
     * 显示人生图书馆首页
     */
	function index(){
		$this->display('index','人生图书馆','index_css','index_js');
	}
	
	/**
     * 显示TA喜欢的和写的书
     *
     * @param	id		会员ID，默认为自己
     */
	function profile(){
		$member_id = $this->getParameter('id',$this->current_member_id);
		$member_name = $this->extend_control->getMemberNameByMemberId($member_id);
		$p_page = $this->getParameter('page',1);
		$limit = $this->CLIMIT;
		$offset = ($p_page-1) * $limit;
		
		$count = $this->extend_control->countMemberBlog($member_id);		
		$all_book_information = $this->extend_control->getMemberBlogInformation($member_id,$offset,$limit);
		$this->setPageInformation($count, $p_page, $limit);

		$this->ci_smarty->assign('information',$all_book_information);
		$this->ci_smarty->assign('member_id',$member_id);
		$this->ci_smarty->assign('member_name',$member_name);
		$this->ci_smarty->assign('my_page', $member_id == $this->current_member_id ? 1 : 0);

		//print_r($all_book_information);exit();
		$this->display('profile',$member_name.'的微型图书馆','profile_css','profile_js');
	}
	
	/**
	* 显示微型书内容，+1次访问量，控制评论显示
	*
	* @param 	id 		书的ID
	*/
	function view(){
		$book_id = $this->getParameter('id',NULL);
		$p_page = $this->getParameter('page',1);
		$limit = $this->CLIMIT;
		$offset = ($p_page-1) * $limit;
		
		if ( !$book_id ) redirect('library');
		$this->addMemberBlogVisit($book_id);
		
		$book_information = $this->extend_control->getMemberBlogInformationByBlogId($book_id);
			
		$count = $this->extend_control->countAllBlogComment($book_id);
		$all_blog_comment_information = $this->extend_control->getBlogCommentInformation($book_id,$offset,$limit);
		
		$this->setPageInformation($count, $p_page, $limit);

		$this->ci_smarty->assign('book_information',$book_information);
		$this->ci_smarty->assign('all_book_comment_information',$all_blog_comment_information);
		//print_r($book_information);exit();
		$this->display('view',$book_information['book_name'],'view_css','view_js');
	}
	
	/**
     * 显示微型书创建和编辑页面
     *
     * @param	id		书ID，如为空则写新书
     *
     */
	function edit(){
		$member_id = $this->current_member_information['member_id'];
		$book_id = $this->getParameter('id',Null);
		$title = '写新书';

		if ( $book_id ) {
			$title = '编辑微型书 #'.$id;
			$this->db->where('book_id',$book_id);
			$this->db->where('member_id',$member_id);
			$book_information = $this->db->get_first('book');
			$book_information['member_name'] = $this->current_member_information['member_name'];
			$this->ci_smarty->assign('book_information',$book_information);
			$this->ci_smarty->assign('cid',$book_information['book_id']);
		}
		//print_r($book_information);exit();
		$this->display('edit',$title,'edit_css','edit_js');
	}
	
	/**
     * 工具函数：处理edit()提交
     *
     * @param	很多
     */
	function save_form() {
		$member_id = $this->current_member_id;
		$book_id = $this->getParameter('book_id',NULL);
		$name = $this->getParameterWithOutTag('name',NULL);
		$image = $this->getParameter('image',$this->config->item('asset').'/img/default/book_cover.jpg');
		$content = $this->getParameter('content',NULL);
		
		$data['name'] = $name;
		$data['member_id'] = $member_id;
		$data['content'] = $content;
		
		//处理图片高宽问题
		$image_url = $this->getImageUrl($image);
		if ( !$image_url ) {
			show_error('微型书封面不合法');
		}
		$image_parameter = @getimagesize($image_url['absolute_path']);
		$data['image_width'] = $image_parameter['0'];
		$data['image_height'] = $image_parameter['1'];
		$data['image'] = $image_url['relative_path'];
		
		if ( !$book_id ){
			$data['created_time'] = $this->current_time;
			$this->db->insert('book',$data);
			$book_id = $this->db->insert_id();
		} else {
			$data['modified_time'] = $this->current_time;
			$this->db->where('book_id',$book_id);
			$this->db->update('book',$data);
		}
		redirect('library/view?id='.$book_id);
		
	}
	
	/**
     * 工具函数：处理评论提交
     *
     * @param	book_id 	书的ID
     * @param 	blog_comment 	评论内容
     *
     * @author suantou
     */
	function save_comment(){
		$book_id = $this->getParameter('book_id',NULL);
		$blog_comment = $this->getParameterWithOutTag('blog_comment',NULL);
		if ($book_id != '' && $blog_comment != ''){
			
			$data['book_id'] = $book_id;
			$data['content'] = trim($blog_comment);
			$data['member_id'] = $this->current_member_id;
			$data['created_time'] = $this->current_time;
			
			$this->db->insert('book_comment',$data);
		}
		redirect(site_url("library/view?id=$book_id"));
	}

	/**
     * 工具函数：处理blog访问量++
     *
     * @param	book_id 	书的ID
     */
	function addMemberBlogVisit($book_id) {
		$member_id = $this->current_member_id;
		$this->db->where('book_id',$book_id);
		$this->db->where('member_id',$member_id);
		
		$data['visited_time'] = $this->current_time;
		if ($this->db->count_all_results('book_visit') > 0) {
			$this->db->where('book_id',$book_id);
			$this->db->where('member_id',$member_id);
			$this->db->update('book_visit',$data);
		} else {
			$data['book_id'] = $book_id;
			$data['member_id'] = $member_id;
			$this->db->insert('book_visit',$data);
			$this->db->where('book_id',$book_id);
			$this->db->select('book_visit');
			$this->db->where('book_id',$book_id);

			$blog_information = $this->db->get_first('book');
			$blog_information['book_visit']++;
			$this->db->where('book_id',$book_id);
			$this->db->update('book',$blog_information);
		}
	}

//-------- ajax工具组
	/**
	* 处理ajax like微型书请求
	*
	* @param 	book_id 		书的ID
	*
	* @return 	0失败，-1已添加过，-2不能添加自己，1成功
	*/
	function ajaxLikeBook(){
		$book_id = $this->getParameter('id',NULL);
		$member_id = $this->current_member_id;
		
		$return_data = 0;
		if ($book_id != '' && $member_id != '') {
			$this->db->select('member_id, like_count');
			$this->db->where('book_id',$book_id);
			$blog_information = $this->db->get_first('book');
			$author_id = $blog_information['member_id'];

			if ($author_id != $member_id) {
				$this->db->where('member_id',$member_id);
				$this->db->where('book_id',$book_id);
				if (!$this->db->count_all_results('like_count')) {
					$like_count_data['member_id'] = $member_id;
					$like_count_data['book_id'] = $book_id;
					$like_count_data['created_time'] = $this->current_time;
					$this->db->insert('like_count',$like_count_data);

					$blog_information['like_count']++;
					$this->db->where('book_id',$book_id);
					$this->db->update('book',$blog_information);

					$return_data = 1;
				} else {
					//已存在记录
					$return_data = -1;
				}
			} else {
				//是自己的日志
				$return_data = -2;
			}
			
		}
		echo $return_data;
	}

	/**
	* 处理ajax删除自己的书请求
	*
	* @param 	book_id 		书的ID
	* @param 	author_id			作者ID，防止别人删除
	*
	* @return 	0失败，1成功
	*/
	function ajaxDeleteBook(){
		$book_id = $this->getParameter('book_id',Null);
		$author_id = $this->getParameter('author_id',Null);
		
		$return_data = 0;
		
		if ( $book_id && $this->current_member_id == $author_id ) {
			//先删除所有博客评论
			$this->db->where('book_id',$book_id);
			$this->db->delete('book_comment');
			
			//再删除喜欢的博客
			$this->db->where('book_id',$book_id);
			$this->db->delete('like_count');
			
			//删除博客
			$this->db->where('book_id',$book_id);
			$this->db->delete('book');
			
			$return_data = 1;
		}
		echo $return_data;
	}

	/**
	* 处理ajax提交评论
	*
	* @param 	book_id 	微型书ID
	* @param 	content 	评论内容
	*
	* @return 	刚刚添加的评论
	*/
	function ajaxAddComment(){
		$book_id = $this->getParameter('book_id',Null);
		$content = $this->getParameterWithOutTag('content',Null);
		
		$data['member_id'] = $this->current_member_id;
		$data['book_id'] = $book_id;
		$data['content'] = $content;
		$data['created_time'] = $this->current_time;
		
		$result = $this->db->insert('book_comment',$data);
		
		if($result) {
			$book_comment_id = $this->db->insert_id();
			
			$this->db->select('member_id');
			$this->db->where('book_id',$book_id);
			$target_id = idx($this->db->get_first('book'),'member_id');
			
			//system_message
			$system_data['category'] = 'blog';
			$system_data['type'] = 'new_comment';
			$system_data['target_id'] = $target_id;
			$system_data['code'] = $book_id;
			$this->system_message($system_data);
			
			$this->db->select('m.member_id, m.name as member_name, m.image as member_image, mbc.book_comment_id, mbc.book_id, mbc.content, mbc.created_time');
			$this->db->from('book_comment as mbc');
			$this->db->join('member as m','m.member_id = mbc.member_id');
			$this->db->where('mbc.book_comment_id',$book_comment_id);
			$blog_comment_information = $this->db->get_first();
			
			echo json_encode($blog_comment_information);
		}
	}
	
	/**
     * 处理ajax获取新评论请求
     *
     * @param	book_id		微型书ID
     */
	function ajaxGetBookComment(){
		$book_id = $this->getParameter('book_id',Null);
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',10);
		$all_blog_comment_information = $this->extend_control->getBlogCommentInformation($book_id,$page_offset,$limit);
		
		echo json_encode($all_blog_comment_information);
	}
}
?>
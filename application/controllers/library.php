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
		$p_limit = $this->getParameter('limit',5);
		
		$count = $this->extend_control->countMemberBlog($member_id);
		$page_information = $this->createPageInformation($count, $p_page, $p_limit);
		
		$all_member_blog_information = $this->extend_control->getMemberBlogInformation($member_id,$page_information['page_offset'],$p_limit);

		$this->ci_smarty->assign('information',$all_member_blog_information);
		$this->ci_smarty->assign('page_information',$page_information);
		$this->ci_smarty->assign('member_id',$member_id);
		$this->ci_smarty->assign('member_name',$member_name);
		$this->ci_smarty->assign('my_page', $member_id == $this->current_member_id ? 1 : 0);

		//print_r($all_member_blog_information);exit();
		$this->display('profile',$member_name.'的微型图书馆','profile_css','profile_js');
	}
	
	/**
	* 显示微型书内容，+1次访问量，控制评论显示
	*
	* @param 	id 		书的ID
	*/
	function view(){
		$member_blog_id = $this->getParameter('id',NULL);
		$p_page = $this->getParameter('page',1);
		$p_limit = $this->getParameter('limit', 10);
		
		if ( !$member_blog_id ) redirect('library');
		$this->addMemberBlogVisit($member_blog_id);
		
		$member_blog_information = $this->extend_control->getMemberBlogInformationByBlogId($member_blog_id);
			
		$count = $this->extend_control->countAllBlogComment($member_blog_id);
		$page_information = $this->createPageInformation($count, $p_page, $p_limit);
		$all_blog_comment_information = $this->extend_control->getBlogCommentInformation($member_blog_id,$page_information['page_offset'],$p_limit);
			
		$this->ci_smarty->assign('book_information',$member_blog_information);
		$this->ci_smarty->assign('page_information',$page_information);
		$this->ci_smarty->assign('all_book_comment_information',$all_blog_comment_information);
		//print_r($member_blog_information);exit();
		$this->display('view',$member_blog_information['member_blog_name'],'view_css','view_js');
	}
	
	/**
     * 显示微型书创建和编辑页面
     *
     * @param	id		书ID，如为空则写新书
     *
     */
	function edit(){
		$member_id = $this->current_member_information['member_id'];
		$member_blog_id = $this->getParameter('id',Null);
		$title = '写新书';

		if ( $member_blog_id ) {
			$title = '编辑微型书 #'.$id;
			$this->db->where('member_blog_id',$member_blog_id);
			$this->db->where('member_id',$member_id);
			$member_blog_information = $this->db->get_first('member_blog');
			$member_blog_information['member_name'] = $this->current_member_information['member_name'];
			$this->ci_smarty->assign('member_blog_information',$member_blog_information);
			$this->ci_smarty->assign('cid',$member_blog_information['member_blog_id']);
		}
		//print_r($member_blog_information);exit();
		$this->display('edit',$title,'edit_css','edit_js');
	}
	
	/**
     * 工具函数：处理edit()提交
     *
     * @param	很多
     *
     * @author suantou
     */
	function _saveItem($isNew, &$id, &$param) {
		$member_id = $this->current_member_information['member_id'];
		
		$name = $this->getParameterWithOutTag('name',NULL);
		$image = $this->getParameter('image',NULL);
		$content = $this->getParameter('content',NULL);
		
		$data['name'] = $name;
		$data['member_id'] = $member_id;
		$data['content'] = $content;
		
		//处理图片高宽问题
		$image_url = $this->getImageUrl($image);
		if ($image_url === false) {
			show_error('活动封面有问题');
		}
		$image_parameter = @getimagesize($image_url['absolute_path']);
		$data['image_width'] = $image_parameter['0'];
		$data['image_height'] = $image_parameter['1'];
		
		$data['image'] = $image_url['relative_path'];
		
		if ($isNew){
			$data['created_time'] = $this->current_time;
			
			$this->db->insert('member_blog',$data);
			$member_blog_id = $this->db->insert_id();
		} else {
			$data['modified_time'] = $this->current_time;
			
			$this->db->where('member_blog_id',$id);
			$this->db->update('member_blog',$data);
		}
		redirect('library/view?id='.$id);
		
	}
	
	/**
     * 工具函数：处理评论提交
     *
     * @param	member_blog_id 	书的ID
     * @param 	blog_comment 	评论内容
     *
     * @author suantou
     */
	function save_comment(){
		$member_blog_id = $this->getParameter('member_blog_id',NULL);
		$blog_comment = $this->getParameterWithOutTag('blog_comment',NULL);
		if ($member_blog_id != '' && $blog_comment != ''){
			
			$data['member_blog_id'] = $member_blog_id;
			$data['content'] = trim($blog_comment);
			$data['member_id'] = $this->current_member_id;
			$data['created_time'] = $this->current_time;
			
			$this->db->insert('member_blog_comment',$data);
		}
		redirect(site_url("library/view?id=$member_blog_id"));
	}

	/**
     * 工具函数：处理blog访问量++
     *
     * @param	member_blog_id 	书的ID
     */
	function addMemberBlogVisit($member_blog_id) {
		$member_id = $this->current_member_id;
		$this->db->where('member_blog_id',$member_blog_id);
		$this->db->where('member_id',$member_id);
		
		$data['visited_time'] = $this->current_time;
		if ($this->db->count_all_results('member_blog_visit') > 0) {
			$this->db->where('member_blog_id',$member_blog_id);
			$this->db->where('member_id',$member_id);
			$this->db->update('member_blog_visit',$data);
		} else {
			$data['member_blog_id'] = $member_blog_id;
			$data['member_id'] = $member_id;
			$this->db->insert('member_blog_visit',$data);
			$this->db->where('member_blog_id',$member_blog_id);
			$this->db->select('member_blog_visit');
			$this->db->where('member_blog_id',$member_blog_id);

			$blog_information = $this->db->get_first('member_blog');
			$blog_information['member_blog_visit']++;
			$this->db->where('member_blog_id',$member_blog_id);
			$this->db->update('member_blog',$blog_information);
		}
	}

//-------- ajax工具组
	/**
	* 处理ajax like微型书请求
	*
	* @param 	member_blog_id 		书的ID
	*
	* @return 	0失败，-1已添加过，-2不能添加自己，1成功
	*/
	function ajaxLikeBook(){
		$member_blog_id = $this->getParameter('id',NULL);
		$member_id = $this->current_member_id;
		
		$return_data = 0;
		if ($member_blog_id != '' && $member_id != '') {
			$this->db->select('member_id, member_prefer_blog');
			$this->db->where('member_blog_id',$member_blog_id);
			$blog_information = $this->db->get_first('member_blog');
			$author_id = $blog_information['member_id'];

			if ($author_id != $member_id) {
				$this->db->where('member_id',$member_id);
				$this->db->where('member_blog_id',$member_blog_id);
				if (!$this->db->count_all_results('member_prefer_blog')) {
					$member_prefer_blog_data['member_id'] = $member_id;
					$member_prefer_blog_data['member_blog_id'] = $member_blog_id;
					$member_prefer_blog_data['created_time'] = $this->current_time;
					$this->db->insert('member_prefer_blog',$member_prefer_blog_data);

					$blog_information['member_prefer_blog']++;
					$this->db->where('member_blog_id',$member_blog_id);
					$this->db->update('member_blog',$blog_information);

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
	* @param 	member_blog_id 		书的ID
	* @param 	author_id			作者ID，防止别人删除
	*
	* @return 	0失败，1成功
	*/
	function ajaxDeleteBook(){
		$member_blog_id = $this->getParameter('member_blog_id',Null);
		$author_id = $this->getParameter('author_id',Null);
		
		$return_data = 0;
		
		if ( $member_blog_id && $this->current_member_id == $author_id ) {
			//先删除所有博客评论
			$this->db->where('member_blog_id',$member_blog_id);
			$this->db->delete('member_blog_comment');
			
			//再删除喜欢的博客
			$this->db->where('member_blog_id',$member_blog_id);
			$this->db->delete('member_prefer_blog');
			
			//删除博客
			$this->db->where('member_blog_id',$member_blog_id);
			$this->db->delete('member_blog');
			
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
		$member_blog_id = $this->getParameter('book_id',Null);
		$content = $this->getParameterWithOutTag('content',Null);
		
		$data['member_id'] = $this->current_member_id;
		$data['member_blog_id'] = $member_blog_id;
		$data['content'] = $content;
		$data['created_time'] = $this->current_time;
		
		$result = $this->db->insert('member_blog_comment',$data);
		
		if($result) {
			$member_blog_comment_id = $this->db->insert_id();
			
			$this->db->select('member_id');
			$this->db->where('member_blog_id',$member_blog_id);
			$target_id = idx($this->db->get_first('member_blog'),'member_id');
			
			//system_message
			$system_data['category'] = 'blog';
			$system_data['type'] = 'new_comment';
			$system_data['target_id'] = $target_id;
			$system_data['code'] = $member_blog_id;
			$this->system_message($system_data);
			
			$this->db->select('m.member_id, m.name as member_name, m.image as member_image, mbc.member_blog_comment_id, mbc.member_blog_id, mbc.content, mbc.created_time');
			$this->db->from('member_blog_comment as mbc');
			$this->db->join('member as m','m.member_id = mbc.member_id');
			$this->db->where('mbc.member_blog_comment_id',$member_blog_comment_id);
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
		$member_blog_id = $this->getParameter('book_id',Null);
		$page_offset = $this->getParameter('page_offset',0);
		$limit = $this->getParameter('limit',10);
		$all_blog_comment_information = $this->extend_control->getBlogCommentInformation($member_blog_id,$page_offset,$limit);
		
		echo json_encode($all_blog_comment_information);
	}
}
?>
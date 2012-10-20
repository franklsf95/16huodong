<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*----------------------
#CI_Publish_Control 公共控制器
#
#
#
------------------------*/

class Extend_control {
	var $CI;
	
	function __construct() {
		$this->CI =& get_instance();
	}
	
	
	
	function getNewSystemMessage($member_id){				//系统信息统计
		$target_id = $member_id;
		
		$this->CI->db->from('system_message');
		$this->CI->db->where('target_id',$target_id);
		$this->CI->db->where('status','Y');
		$this->CI->db->where('is_new','Y');
		
		$activity_count = 0;
		$friend_count = 0;
		$blog_count = 0;
		$activity_edit_count = 0;
		$activity_comment_count = 0;
		$activity_reply_count = 0;
		$friend_apply_count = 0;
		$friend_add_count = 0;
		$blog_comment_count = 0;
		$member_message_count = 0;
		
		$all_new_system_message_information = $this->CI->db->get()->result_array();
		
		foreach($all_new_system_message_information as $system_message_information) {
			
			if ($system_message_information['category'] == 'activity'){
				$activity_count++;
				if($system_message_information['type'] == 'edit_activity'){
					$activity_edit_count++;
				}elseif ($system_message_information['type'] == 'new_comment'){
					$activity_comment_count++;
				}elseif ($system_message_information['type'] == 'new_reply'){
					$activity_reply_count++;
				}
				
			}elseif ($system_message_information['category'] == 'friend') {
				$friend_count++;
				if($system_message_information['type'] == 'apply_friend'){
					$friend_apply_count++;
				}elseif ($system_message_information['type'] == 'add_friend'){
					$friend_add_count++;
				}
				
			}elseif ($system_message_information['category'] == 'blog') {
				$blog_count++;
				if($system_message_information['type'] == 'new_comment'){
					$blog_comment_count++;
				}
				
			}elseif ($system_message_information['category'] == 'member_message') {
				$member_message_count++;
				if($system_message_information['type'] == 'new_message'){
					$member_message_count++;
				}
			}
			
		}
		
		if ($activity_count > 0) $all_system_message[] = array('type' => 'activity','count' => $activity_count);
		if ($friend_count > 0) $all_system_message[] = array('type' => 'friend','count' => $friend_count);
		if ($blog_count > 0) $all_system_message[] = array('type' => 'blog','count' => $blog_count);
		if ($member_message_count > 0) $all_system_message[] = array('type' => 'member_message','count' => $member_message_count);
		
		
		
		if ($activity_comment_count > 0) $all_system_message[] = array('type' => 'activity_comment','count' => $activity_comment_count);
		if ($activity_reply_count > 0) $all_system_message[] = array('type' => 'activity_reply','count' => $activity_reply_count);
		if ($friend_apply_count > 0) $all_system_message[] = array('type' => 'friend_apply','count' => $friend_apply_count);
		if ($friend_add_count > 0) $all_system_message[] = array('type' => 'friend_add','count' => $friend_add_count);
		if ($blog_comment_count > 0) $all_system_message[] = array('type' => 'blog_comment','count' => $blog_comment_count);
		
		
		return $all_system_message;
	}
	
	function countMemberActivitySystemMessage($target_id,$type = null){
		$this->CI->db->select('count(sm.system_message_id) as count');
		$this->CI->db->from('system_message as sm');
		$this->CI->db->where('sm.target_id',$target_id);
		$this->CI->db->where('sm.status','Y');
		if ($type) {
			$this->CI->db->where('sm.type',$type);
		}
		
		$count = idx($this->CI->db->get_first(),'count');
		return $count;
	}
	
	function getMemberActivitySystemMessageInformation($target_id,$type = null,$page_offset=0,$limit=25){
		
		$this->CI->db->select('a.activity_id, a.name as activity_name, m.member_id, m.name as member_name, m.image as member_image, sm.system_message_id, sm.category, sm.type, sm.status, sm.is_new');
		$this->CI->db->from('system_message as sm');
		$this->CI->db->join('activity as a','sm.code = a.activity_id');
		$this->CI->db->join('member as m','sm.member_id = m.member_id');
		$this->CI->db->where('sm.target_id',$target_id);
		$this->CI->db->where('sm.status','Y');
		$this->CI->db->where('sm.category','activity');
		
		if ($type) {
			$this->CI->db->where('sm.type',$type);
		}
		$this->CI->db->order_by('sm.system_message_id','DESC');
		
		$all_activity_system_information = $this->CI->db->get('',$limit,$page_offset)->result_array();;
		return $all_activity_system_information;
	}
	
	function getMemberSystemMessageInformation($target_id,$type = null){
		$this->CI->db->select('m.member_id, m.name as member_name, m.image as member_image,  sm.system_message_id, sm.category, sm.type, sm.status, sm.is_new, mf.member_friend_id');
		$this->CI->db->from('system_message as sm');
		$this->CI->db->join('member as m','m.member_id = sm.member_id');
		$this->CI->db->join('member_friend as mf','mf.member_friend_id = sm.code');
		$this->CI->db->where('sm.target_id',$target_id);
		$this->CI->db->where('sm.status','Y');
		
		if ($type) {
			$this->CI->db->where('sm.type',$type);
		}
		$this->CI->db->order_by('sm.system_message_id','DESC');
		
		$all_member_system_information = $this->CI->db->get('')->result_array();;
		return $all_member_system_information;
		
	}
	
	
	function getAttendActivityMemberInformation($activity_id) {
		
		$this->CI->db->select('activity_id,member_id,created_time');
		$this->CI->db->where('activity_id',$activity_id);
		$all_member_information = $this->CI->db->get('activity_attend_member')->result_array();
		return $all_member_information;
	}
	
	
	function getAboutMemberList($member_id,$type = 'array'){			//拿取自己关注会员及自己的会员id加入数组返回
	
		$this->CI->db->select('target_id');
		$this->CI->db->where('member_id',$this->CI->current_member_id);
		$this->CI->db->where('status','Y');
		$all_fllow_information = $this->CI->db->get('member_friend')->result_array();
		
		if ($type == 'array') {
		
			$about_member_list[] = $member_id;
			
			foreach ($all_fllow_information as $vo) {
				
				$about_member_list[] = $vo['target_id'];
			}
		} elseif ($type == 'str'){
			$about_member_list = "('".$member_id."'";
			
			foreach ($all_fllow_information as $vo) {
				
				$about_member_list .= ",'".$vo['target_id']."'";
			}
			
			$about_member_list .= ")";
		}
		return $about_member_list;
	}
	
	
	function getFollowMemberList($member_id,$type = 'array'){			//拿取自己关注会员及自己的会员id加入数组返回
	
		$this->CI->db->select('friend_id');
		$this->CI->db->where('member_id',$member_id);
		$all_fllow_information = $this->CI->db->get('member_friend')->result_array();
		
		if ($type == 'array') {
			
			foreach ($all_fllow_information as $vo) {
				
				$follow_member_list[] = $vo['friend_id'];
			}
		} elseif ($type == 'str'){
			$follow_member_list = "('".$member_id."'";
			
			foreach ($all_fllow_information as $vo) {
				
				$follow_member_list .= ",'".$vo['friend_id']."'";
			}
			
			$follow_member_list .= ")";
		}
		return $follow_member_list;
	}
	
	function countAboutMemberNewsInformation($member_id){
		$about_member_list = $this->getAboutMemberList($member_id,'str');
		
		$sql = "SELECT m.member_id,m.name AS member_name,m.image AS member_image, news.code, news.content, news.created_time, news.type FROM";
		
		//查找说说
		$sql .= " ((SELECT say.* FROM (SELECT `member_id`, `member_say_id` AS `code`, `content` AS content, `created_time`, LTRIM('say') AS `type` FROM `".$this->CI->db->dbprefix('member_say')."` WHERE `member_id` IN ".$about_member_list.") AS `say`)";
		
		//查找日志
		$sql .= " UNION ALL";
		$sql .= " (SELECT `blog`.* FROM (SELECT `member_id`, `member_blog_id` AS `code`, `name` AS content, `created_time`, LTRIM('blog') AS `type` FROM `".$this->CI->db->dbprefix('member_blog')."` WHERE `member_id` IN ".$about_member_list.") AS `blog`)";
		$sql .= " ORDER BY created_time DESC) AS news";
		$sql .= " JOIN `".$this->CI->db->dbprefix('member')."` AS m ON m.member_id = news.member_id";
		$sql .= " ORDER BY created_time DESC";
		
		$result = $this->CI->db->query($sql)->num_rows();
		
		return $result;
	}
	
	function getAboutMemberNewsInformation($member_id, $page_offset=0 , $limit = 25) {
		$about_member_list = $this->getAboutMemberList($member_id,'str');
		
		$sql = "SELECT m.member_id,m.name AS member_name,m.image AS member_image, news.code, news.content, news.created_time, news.type FROM";
		
		//查找说说
		$sql .= " ((SELECT say.* FROM (SELECT `member_id`, `member_say_id` AS `code`, `content` AS content, `created_time`, LTRIM('say') AS `type` FROM `".$this->CI->db->dbprefix('member_say')."` WHERE `member_id` IN ".$about_member_list.") AS `say`)";
		
		//查找日志
		$sql .= " UNION ALL";
		$sql .= " (SELECT `blog`.* FROM (SELECT `member_id`, `member_blog_id` AS `code`, `name` AS content, `created_time`, LTRIM('blog') AS `type` FROM `".$this->CI->db->dbprefix('member_blog')."` WHERE `member_id` IN ".$about_member_list.") AS `blog`)";
		$sql .= " ORDER BY created_time DESC";
		$sql .= " LIMIT ".$page_offset.','.$limit.") AS news";
		$sql .= " JOIN `".$this->CI->db->dbprefix('member')."` AS m ON m.member_id = news.member_id";
		$sql .= " ORDER BY created_time DESC";
		
		$all_news_information = $this->CI->db->query($sql)->result_array();
		
		
		foreach ($all_news_information as &$news_information) {
			if ($news_information['type'] == 'say') {
				$news_information['show'] = $news_information['content'];
				
			}elseif ($news_information['type'] == 'blog'){
				$url = site_url("blog/view?id=".$news_information['code']);
				$news_information['show'] = "发表了新的日志<a href='$url'>《".$news_information['content']."》</a>";
			
			}elseif ($news_information['type'] == 'photo'){
				//$news_information['show'] = "发表了上传了新的照片《".$news_information['content']."》";
			
			}
		
		}
		return $all_news_information;
	
	}
	
	function getMemberVisitInformation($member_id,$limit = 5){
		$this->CI->db->select('m.member_id, m.name as member_name, m.image as member_image,mv.visit_time');
		$this->CI->db->from('member_visit as mv');
		$this->CI->db->join('member as m','mv.visitor_id = m.member_id');
		$this->CI->db->where('mv.member_id',$member_id);
		$this->CI->db->limit($limit);
		$this->CI->db->order_by('mv.visit_time','DESC');
		
		$all_member_visit_information = $this->CI->db->get()->result_array();
		
		return $all_member_visit_information;
	}
	
	
	function getMemberNewsInformation($member_id, $page_offset=0 , $limit = 15) {
		
		$sql = "SELECT m.member_id,m.name AS member_name,m.image AS member_image, news.code, news.content, news.created_time, news.type FROM";
		
		//查找说说
		$sql .= " ((SELECT say.* FROM (SELECT `member_id`, `member_say_id` AS `code`, `content` AS content, `created_time`, LTRIM('say') AS `type` FROM `".$this->CI->db->dbprefix('member_say')."` WHERE `member_id` = ".$member_id.") AS `say`)";
		
		//查找日志
		$sql .= " UNION ALL";
		$sql .= " (SELECT `blog`.* FROM (SELECT `member_id`, `member_blog_id` AS `code`, `name` AS content, `created_time`, LTRIM('blog') AS `type` FROM `".$this->CI->db->dbprefix('member_blog')."` WHERE `member_id` = ".$member_id.") AS `blog`)";
		
		$sql .= " LIMIT ".$page_offset.','.$limit.") AS news";
		$sql .= " JOIN `".$this->CI->db->dbprefix('member')."` AS m ON m.member_id = news.member_id";
		$sql .= " ORDER BY created_time DESC";
		
		$all_news_information = $this->CI->db->query($sql)->result_array();
		
		
		foreach ($all_news_information as &$news_information) {
			if ($news_information['type'] == 'say') {
				$news_information['show'] = $news_information['content'];
				
			}elseif ($news_information['type'] == 'blog'){
				$url = site_url("blog/view?id=".$news_information['code']);
				$news_information['show'] = "发表了新的日志<a href='$url'>《".$news_information['content']."》</a>";
			
			}elseif ($news_information['type'] == 'photo'){
				//$news_information['show'] = "发表了上传了新的照片《".$news_information['content']."》";
			
			}
		
		}
		return $all_news_information;
	
	}
	
	function countNewActivity(){
		$this->CI->db->select('count(a.activity_id) as count');
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_publish_member as apm','apm.activity_id = a.activity_id');
		$this->CI->db->join('member as m','apm.member_id = m.member_id');
		$this->CI->db->where('apm.publisher','Y');
		$this->CI->db->where('date(a.end_time) >=',$this->CI->current_date);
		$result = idx($this->CI->db->get_first(),'count');
		
		return $result;
	}
	
	
	function getNewActivityInformation($page_offset = 0,$limit = 5) {
		$this->CI->db->select('a.activity_id, a.name as activity_name, a.apply_start_time, a.apply_end_time, a.start_time, a.end_time, a.image as activity_image, a.image_width as activity_image_width, a.image_height as activity_image_height, a.description, a.created_time, m.member_id, m.name as member_name, m.image as member_image, count(distinct aam.member_id) as attend_number, count(distinct aam2.member_id) as attention_number');
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_publish_member as apm','apm.activity_id = a.activity_id');
		$this->CI->db->join('member as m','apm.member_id = m.member_id');
		$this->CI->db->join('activity_attend_member as aam','aam.activity_id = a.activity_id','left');
		$this->CI->db->join('activity_attention_member as aam2','aam2.activity_id = a.activity_id','left');
		$this->CI->db->where('apm.publisher','Y');
		$this->CI->db->where('date(a.end_time) >=',$this->CI->current_date);
		$this->CI->db->group_by('a.activity_id');
		$this->CI->db->order_by('a.created_time','DESC');
		$all_new_activity_information = $this->CI->db->get('',$limit,$page_offset )->result_array();
		
		return $all_new_activity_information;
	}
	
	function getHotActivityInformation($page_offset = 0,$limit = 5) {
		$this->CI->db->select('a.activity_id, a.name as activity_name, a.apply_start_time, a.apply_end_time, a.start_time, a.end_time, a.image as activity_image, a.image_width as activity_image_width, a.image_height as activity_image_height, a.description, a.created_time, m.member_id, m.name as member_name, m.image as member_image, count(distinct aam.member_id) as attend_number, count(distinct aam2.member_id) as attention_number, count(av.activity_visit_id) as visit_number');
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_publish_member as apm','apm.activity_id = a.activity_id');
		$this->CI->db->join('activity_visit as av','a.activity_id = av.activity_id');
		$this->CI->db->join('member as m','apm.member_id = m.member_id');
		$this->CI->db->join('activity_attend_member as aam','aam.activity_id = a.activity_id','left');
		$this->CI->db->join('activity_attention_member as aam2','aam2.activity_id = a.activity_id','left');
		$this->CI->db->where('apm.publisher','Y');
		$this->CI->db->where('date(a.end_time) >=',$this->CI->current_date);
		$this->CI->db->group_by('a.activity_id');
		$this->CI->db->order_by('count(av.activity_visit_id)','DESC');
		$all_new_activity_information = $this->CI->db->get('',$limit,$page_offset )->result_array();
		
		return $all_new_activity_information;
	}
	
	
	function countActiveAttendActivity($member_id) {
		$this->CI->db->select('count(a.activity_id) as count');
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_attend_member as aam','a.activity_id = aam.activity_id');
		$this->CI->db->where('a.end_time >=',$this->CI->current_date);
		$this->CI->db->where('aam.member_id',$member_id);
		$result = idx($this->CI->db->get_first(),'count');
		
		return $result;
	}
	
	function getActiveAttendActivityInformation($member_id,$page_offset = Null,$limit = Null){
		$this->CI->db->select('a.activity_id, a.name as activity_name, a.apply_start_time, a.apply_end_time, a.start_time, a.end_time, a.description, m.member_id, m.name as member_name, m.image as member_image');
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_publish_member as apm','apm.activity_id = a.activity_id');
		$this->CI->db->join('member as m','apm.member_id = m.member_id');
		$this->CI->db->join('activity_attend_member as aam','a.activity_id = aam.activity_id');
		$this->CI->db->where('apm.publisher','Y');
		$this->CI->db->where('aam.member_id',$member_id);
		$this->CI->db->where('date(a.end_time) >=',$this->CI->current_date);
		$this->CI->db->order_by('a.created_time','DESC');
		$all_active_attend_activity_information = $this->CI->db->get('',$limit,$page_offset)->result_array();
		
		return $all_active_attend_activity_information;
	}
	
	function countAllMemberAttentionActivity($member_id) {
		$this->CI->db->select('count(a.activity_id) as count');
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_attention_member as aam','a.activity_id = aam.activity_id');
		$this->CI->db->where('aam.member_id',$member_id);
		$result = idx($this->CI->db->get_first(),'count');
		
		return $result;
	}
	
	function getAllMemberAttentionActivityInformation($member_id,$page_offset = 0,$limit = 5){
		$this->CI->db->select('a.activity_id, a.name as activity_name, a.image as activity_image, a.apply_start_time, a.apply_end_time, a.start_time, a.end_time, a.description, m.member_id, m.name as member_name, m.image as member_image,count(aam.member_id) as attention_count, count(aam2.member_id) as attend_count, count(ac.activity_comment_id) as comment_count');
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_publish_member as apm','apm.activity_id = a.activity_id');
		$this->CI->db->join('member as m','apm.member_id = m.member_id');
		$this->CI->db->join('activity_attention_member as aam','a.activity_id = aam.activity_id');
		$this->CI->db->join('activity_attend_member as aam2','a.activity_id = aam2.activity_id','LEFT');
		$this->CI->db->join('activity_comment as ac','a.activity_id = ac.activity_id','LEFT');
		$this->CI->db->where('apm.publisher','Y');
		$this->CI->db->where('aam.member_id',$member_id);
		$this->CI->db->group_by('a.activity_id');
		$this->CI->db->order_by('a.created_time','DESC');
		$all_member_attend_activity_information = $this->CI->db->get('',$limit,$page_offset)->result_array();
		
		return $all_member_attend_activity_information;
	}
	
	
	function countAllMemberAttendActivity($member_id) {
		$this->CI->db->select('count(a.activity_id) as count');
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_attend_member as aam','a.activity_id = aam.activity_id');
		$this->CI->db->where('aam.member_id',$member_id);
		$result = idx($this->CI->db->get_first(),'count');
		
		return $result;
	}
	
	function getAllMemberAttendActivityInformation($member_id,$page_offset = 0,$limit = 5){
		$this->CI->db->select('a.activity_id, a.name as activity_name, a.image as activity_image, a.apply_start_time, a.apply_end_time, a.start_time, a.end_time, a.description, m.member_id, m.name as member_name, m.image as member_image,count(aam.member_id) as attention_count, count(aam2.member_id) as attend_count, count(ac.activity_comment_id) as comment_count');
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_publish_member as apm','apm.activity_id = a.activity_id');
		$this->CI->db->join('member as m','apm.member_id = m.member_id');
		$this->CI->db->join('activity_attention_member as aam','a.activity_id = aam.activity_id');
		$this->CI->db->join('activity_attend_member as aam2','a.activity_id = aam2.activity_id','LEFT');
		$this->CI->db->join('activity_comment as ac','a.activity_id = ac.activity_id','LEFT');
		$this->CI->db->where('apm.publisher','Y');
		$this->CI->db->where('aam2.member_id',$member_id);
		$this->CI->db->group_by('a.activity_id');
		$this->CI->db->order_by('a.created_time','DESC');
		$all_member_attend_activity_information = $this->CI->db->get('',$limit,$page_offset)->result_array();
		
		return $all_member_attend_activity_information;
	}
	
	
	function countAllMemberPublishActivity($member_id) {
		$this->CI->db->select('count(a.activity_id) as count');
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_publish_member as apm','a.activity_id = apm.activity_id');
		$this->CI->db->where('apm.member_id',$member_id);
		$result = idx($this->CI->db->get_first(),'count');
		
		return $result;
	}
	
	function getAllMemberPublishActivityInformation($member_id,$page_offset = 0,$limit = 5){
		$this->CI->db->select('a.activity_id, a.name as activity_name, a.image as activity_image, a.apply_start_time, a.apply_end_time, a.start_time, a.end_time, a.description, m.member_id, m.name as member_name, m.image as member_image,count(aam.member_id) as attention_count, count(aam2.member_id) as attend_count, count(ac.activity_comment_id) as comment_count');
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_publish_member as apm','apm.activity_id = a.activity_id');
		$this->CI->db->join('member as m','apm.member_id = m.member_id');
		$this->CI->db->join('activity_attention_member as aam','a.activity_id = aam.activity_id','LEFT');
		$this->CI->db->join('activity_attend_member as aam2','a.activity_id = aam2.activity_id','LEFT');
		$this->CI->db->join('activity_comment as ac','a.activity_id = ac.activity_id','LEFT');
		$this->CI->db->where('apm.publisher','Y');
		$this->CI->db->where('apm.member_id',$member_id);
		$this->CI->db->group_by('a.activity_id');
		$this->CI->db->order_by('a.created_time','DESC');
		$all_member_publish_activity_information = $this->CI->db->get('',$limit,$page_offset)->result_array();
		
		return $all_member_publish_activity_information;
	}
	
	function getCurrentAttentionActivityInformation($member_id){
		$this->CI->db->select('a.activity_id, a.name as activity_name, a.apply_start_time, a.apply_end_time, a.start_time, a.end_time, a.image as activity_image, a.image_width as activity_image_width, a.image_height as activity_image_height, a.description, a.created_time, m.member_id, m.name as member_name, m.image as member_image, count(distinct aam.member_id) as attend_number, count(distinct aam2.member_id) as attention_number');
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_publish_member as apm','apm.activity_id = a.activity_id');
		$this->CI->db->join('member as m','apm.member_id = m.member_id');
		$this->CI->db->join('activity_attend_member as aam','aam.activity_id = a.activity_id','left');
		$this->CI->db->join('activity_attention_member as aam2','aam2.activity_id = a.activity_id','left');
		$this->CI->db->join('activity_attention_member as aam3','aam3.activity_id = a.activity_id');
		$this->CI->db->where('apm.publisher','Y');
		$this->CI->db->where('aam3.member_id',$member_id);
		$this->CI->db->where('date(a.end_time) >=',$this->CI->current_date);
		$this->CI->db->group_by('a.activity_id');
		$this->CI->db->order_by('a.created_time','DESC');
		$all_attention_activity_information = $this->CI->db->get('',$limit,$page_offset )->result_array();
		
		
		return $all_attention_activity_information;
	}
	
	function getCurrentAttendActivityInformation($member_id,$page_offset,$limit){
		$this->CI->db->select('a.activity_id, a.name as activity_name, a.apply_start_time, a.apply_end_time, a.start_time, a.end_time, a.image as activity_image, a.image_width as activity_image_width, a.image_height as activity_image_height, a.description, a.created_time, m.member_id, m.name as member_name, m.image as member_image, count(distinct aam.member_id) as attend_number, count(distinct aam2.member_id) as attention_number');
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_publish_member as apm','apm.activity_id = a.activity_id');
		$this->CI->db->join('member as m','apm.member_id = m.member_id');
		$this->CI->db->join('activity_attend_member as aam','aam.activity_id = a.activity_id','left');
		$this->CI->db->join('activity_attention_member as aam2','aam2.activity_id = a.activity_id','left');
		$this->CI->db->join('activity_attend_member as aam3','aam3.activity_id = a.activity_id');
		$this->CI->db->where('apm.publisher','Y');
		$this->CI->db->where('aam3.member_id',$member_id);
		$this->CI->db->where('date(a.end_time) >=',$this->CI->current_date);
		$this->CI->db->group_by('a.activity_id');
		$this->CI->db->order_by('a.created_time','DESC');
		$all_attend_activity_information = $this->CI->db->get('',$limit,$page_offset )->result_array();
		
		return $all_attend_activity_information;
	}
	
	
	function getCurrentPublishActivityInformation($member_id,$page_offset,$limit){
		$this->CI->db->select('a.activity_id, a.name as activity_name, a.apply_start_time, a.apply_end_time, a.start_time, a.end_time, a.image as activity_image, a.image_width as activity_image_width, a.image_height as activity_image_height, a.description, a.created_time, m.member_id, m.name as member_name, m.image as member_image, count(distinct aam.member_id) as attend_number, count(distinct aam2.member_id) as attention_number');
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_publish_member as apm','apm.activity_id = a.activity_id');
		$this->CI->db->join('member as m','apm.member_id = m.member_id');
		$this->CI->db->join('activity_attend_member as aam','aam.activity_id = a.activity_id','left');
		$this->CI->db->join('activity_attention_member as aam2','aam2.activity_id = a.activity_id','left');
		$this->CI->db->where('apm.publisher','Y');
		$this->CI->db->where('apm.member_id',$member_id);
		$this->CI->db->where('date(a.end_time) >=',$this->CI->current_date);
		$this->CI->db->group_by('a.activity_id');
		$this->CI->db->order_by('a.created_time','DESC');
		$all_publish_activity_information = $this->CI->db->get('',$limit,$page_offset )->result_array();
		
		return $all_publish_activity_information;
	}
	
	function countAllActivityComment($activity_id){
		$this->CI->db->select('count(ac.activity_comment_id) as count');
		$this->CI->db->from('activity_comment as ac');
		$this->CI->db->join('member as m','ac.member_id = m.member_id');
		$this->CI->db->where('ac.activity_id',$activity_id);
		
		$count = idx($this->CI->db->get_first(),'count');
		
		return $count;
	
	}
	
	function getActivityCommentInformation($activity_id,$page_offset = 0,$limit = 5){
		$this->CI->db->select('ac.activity_comment_id, ac.activity_id, ac.member_id, ac.content, ac.reply, ac.created_time, m.name as member_name, m.image as member_image');
		$this->CI->db->from('activity_comment as ac');
		$this->CI->db->join('member as m','ac.member_id = m.member_id');
		$this->CI->db->where('ac.activity_id',$activity_id);
		$this->CI->db->order_by('ac.created_time','DESC');
		$all_activity_comment_information = $this->CI->db->get('', $limit, $page_offset)->result_array();
		return $all_activity_comment_information;
	}
	
	function getAllActivityAttendMemberInformation($activity_id){
		$this->CI->db->select('m.member_id, m.name, m.image, m.mobilephone, m.phone, m.email, m.qq, aam.activity_attend_id, aam.status');
		$this->CI->db->from('activity_attend_member as aam');
		$this->CI->db->join('member as m','m.member_id = aam.member_id');
		$this->CI->db->where('aam.activity_id',$activity_id);
		$all_activity_attend_member_information = $this->CI->db->get('')->result_array();
		return $all_activity_attend_member_information;
	}
	
	function getAllActivityAttentionMemberInformation($activity_id){
		$this->CI->db->select('m.member_id, m.name, m.image, m.mobilephone, m.phone, m.email, m.qq');
		$this->CI->db->from('activity_attention_member as aam');
		$this->CI->db->join('member as m','m.member_id = aam.member_id');
		$this->CI->db->where('aam.activity_id',$activity_id);
		$all_activity_attention_member_information = $this->CI->db->get('')->result_array();
		return $all_activity_attention_member_information;
	}
	
	
	function countAllBlogComment($member_blog_id){
		$this->CI->db->select('count(mbc.member_blog_comment_id) as count');
		$this->CI->db->from('member_blog_comment as mbc');
		$this->CI->db->join('member as m','mbc.member_id = m.member_id');
		$this->CI->db->where('mbc.member_blog_id',$member_blog_id);
		
		$count = idx($this->CI->db->get_first(),'count');
		
		return $count;
	
	}
	
	function getBlogCommentInformation($member_blog_id,$page_offset = 0,$limit = 5){
		$this->CI->db->select('mbc.member_blog_comment_id, mbc.member_blog_id, mbc.member_id, mbc.content, mbc.created_time, m.name as member_name, m.image as member_image');
		$this->CI->db->from('member_blog_comment as mbc');
		$this->CI->db->join('member as m','mbc.member_id = m.member_id');
		$this->CI->db->where('mbc.member_blog_id',$member_blog_id);
		$this->CI->db->order_by('mbc.created_time','DESC');
		$all_blog_comment_information = $this->CI->db->get('', $limit, $page_offset)->result_array();
		return $all_blog_comment_information;
	}
	
	
	
	function getNewBlogInformation(){
		$follow_member_list = $this->getFollowMemberList($this->CI->current_member_id,'array');
	
		$this->CI->db->select('mb.member_blog_id, mb.name as member_blog_name, left(mb.content,150) as member_blog_description, mb.created_time, mb.modified_time, mbc.name as member_blog_class_name, m.member_id, m.name as member_name, m.image as member_image',false);
		$this->CI->db->from('member_blog as mb');
		$this->CI->db->join('member_blog_class as mbc','mb.member_blog_class_id = mbc.member_blog_class_id','LEFT');
		$this->CI->db->join('member as m','mb.member_id = m.member_id');
		$this->CI->db->where_in('mb.member_id',$follow_member_list);
		$this->CI->db->order_by('mb.created_time','DESC',false);
		$all_member_blog_information = $this->CI->db->get()->result_array();
		
		return $all_member_blog_information;
	}
	
	function countMemberBlog($member_id){
		$this->CI->db->select('count(mb.member_blog_id) as count');
		$this->CI->db->from('member_blog as mb');
		$this->CI->db->join('member as m','mb.member_id = m.member_id');
		$this->CI->db->where('mb.member_id',$member_id);
		
		$result = idx($this->CI->db->get_first(),'count');
		
		return $result;
	}
	
	
	function getAllMemberBlogInformation($page_offset = 0,$limit = 15, $str_length = 100){
		$this->CI->db->select('mb.member_blog_id, mb.name as member_blog_name, mb.image as member_blog_image, mb.image_width as member_blog_image_width, mb.image_height as member_blog_image_height, mb.content, mb.created_time, mb.modified_time, m.member_id, m.name as member_name, m.image as member_image, count(DISTINCT mpb.member_prefer_blog_id) as prefer_number, count(DISTINCT mbv.member_blog_visit_id) as visit_number');
		$this->CI->db->from('member_blog as mb');
		$this->CI->db->join('member as m','mb.member_id = m.member_id');
		$this->CI->db->join('member_blog_visit as mbv','mb.member_blog_id = mbv.member_blog_id','LEFT');
		$this->CI->db->join('member_prefer_blog as mpb','mb.member_blog_id = mpb.member_blog_id','LEFT');
		$this->CI->db->group_by('mb.member_blog_id');
		$this->CI->db->order_by('mb.created_time','DESC');
		$all_member_blog_information = $this->CI->db->get('',$limit,$page_offset)->result_array();
		
		foreach ($all_member_blog_information as &$member_blog_information) {
			$member_blog_information['content'] = trim($member_blog_information['content']);
			$member_blog_information['content'] = strip_tags($member_blog_information['content']);
			if (strlen($member_blog_information['content']) > 150) {
				$member_blog_information['content'] = mb_substr($member_blog_information['content'], 0, $str_length,'utf-8').'...';
			}
			//$member_blog_information['content'] = trim($member_blog_information['content']);
		}
		
		
		return $all_member_blog_information;
	}
	
	function getHotBlogInformation($page_offset = 0,$limit = 10){
		$this->CI->db->select('mb.member_blog_id, mb.name as member_blog_name, mb.image as member_blog_image, mb.image_width as member_blog_image_width, mb.image_height as member_blog_image_height, mb.created_time, mb.modified_time, m.member_id, m.name as member_name, m.image as member_image, count(DISTINCT mpb.member_prefer_blog_id) as prefer_number, count(DISTINCT mbv.member_blog_visit_id) as visit_number');
		$this->CI->db->from('member_blog as mb');
		$this->CI->db->join('member as m','mb.member_id = m.member_id');
		$this->CI->db->join('member_blog_visit as mbv','mb.member_blog_id = mbv.member_blog_id','LEFT');
		$this->CI->db->join('member_prefer_blog as mpb','mb.member_blog_id = mpb.member_blog_id','LEFT');
		$this->CI->db->group_by('mb.member_blog_id');
		$this->CI->db->order_by('count(mbv.member_blog_visit_id)','DESC');
		$this->CI->db->order_by('mb.created_time','DESC');
		$all_hot_blog_information = $this->CI->db->get('',$limit,$page_offset)->result_array();
		
		return $all_hot_blog_information;
	
	}
	
	function getMemberBlogInformation($member_id,$page_offset = 0,$limit = 15 ,$str_length = 150){
		$this->CI->db->select('mb.member_blog_id, mb.name as member_blog_name, mb.image as member_blog_image, mb.image_width as member_blog_image_width, mb.image_height as member_blog_image_height, mb.content, mb.created_time, mb.modified_time, m.member_id, m.name as member_name, m.image as member_image');
		$this->CI->db->from('member_blog as mb');
		$this->CI->db->join('member as m','mb.member_id = m.member_id');
		$this->CI->db->where('mb.member_id',$member_id);
		$this->CI->db->order_by('mb.created_time','DESC');
		$all_member_blog_information = $this->CI->db->get('',$limit,$page_offset)->result_array();
		
		foreach ($all_member_blog_information as &$member_blog_information) {
			$member_blog_information['content'] = trim($member_blog_information['content']);
			$member_blog_information['content'] = strip_tags($member_blog_information['content']);
			if (strlen($member_blog_information['content']) > 150) {
				$member_blog_information['content'] = mb_substr($member_blog_information['content'], 0, $str_length,'utf-8').'...';
			}
		
		}
		
		return $all_member_blog_information;
	}
	
	
	function getPreferBlogInformation($member_id,$page_offset = 0,$limit = 15){
		$this->CI->db->select('mb.member_blog_id, mb.name as member_blog_name, mb.image as member_blog_image, mb.image_width as member_blog_image_width, mb.image_height as member_blog_image_height, mb.created_time, mb.modified_time, m.member_id, m.name as member_name, m.image as member_image, count(DISTINCT mpb.member_prefer_blog_id) as prefer_number, count(DISTINCT mbv.member_blog_visit_id) as visit_number');
		$this->CI->db->from('member_blog as mb');
		$this->CI->db->join('member as m','mb.member_id = m.member_id');
		$this->CI->db->join('member_prefer_blog as mpb','mpb.member_blog_id = mb.member_blog_id');
		$this->CI->db->join('member_blog_visit as mbv','mb.member_blog_id = mbv.member_blog_id','LEFT');
		$this->CI->db->where('mpb.member_id',$member_id);
		$this->CI->db->group_by('mb.member_blog_id');
		$this->CI->db->order_by('mb.created_time','DESC');
		$all_prefer_blog_information = $this->CI->db->get('',$limit,$page_offset)->result_array();
		
		return $all_prefer_blog_information;
	}
	
	function getMemberBlogInformationByBlogId($member_blog_id){
		$this->CI->db->select('mb.member_blog_id, mb.name as member_blog_name, mb.image as member_blog_image, mb.content as member_blog_content, mb.created_time, mb.modified_time, m.member_id, m.name as member_name, m.image as member_image, count(DISTINCT mpb.member_prefer_blog_id) as prefer_number, count(DISTINCT mbv.member_blog_visit_id)as visit_number');
		$this->CI->db->from('member_blog as mb');
		$this->CI->db->join('member as m','mb.member_id = m.member_id');
		$this->CI->db->join('member_prefer_blog as mpb','mpb.member_blog_id = mb.member_blog_id','LEFT');
		$this->CI->db->join('member_blog_visit as mbv','mbv.member_blog_id = mb.member_blog_id');
		$this->CI->db->where('mb.member_blog_id',$member_blog_id);
		$this->CI->db->group_by('mb.member_blog_id');
		$member_blog_information = $this->CI->db->get_first();
		
		return $member_blog_information;
	}
	
	
	function getMemberLeaveWordInformation($member_id){
		$this->CI->db->select('mlw.member_leave_word_id, mlw.content, mlw.reply, mlw.created_time, mlw.modified_time, m.member_id, m.name as member_name, m.image as member_image, t.member_id as target_id, t.name as target_name, t.image as target_image');
		$this->CI->db->from('member_leave_word as mlw');
		$this->CI->db->join('member as m','m.member_id = mlw.member_id');
		$this->CI->db->join('member as t','t.member_id = mlw.target_id');
		$this->CI->db->where('mlw.target_id',$member_id);
		$this->CI->db->order_by('mlw.created_time','DESC',false);
		
		$all_member_leave_word_information = $this->CI->db->get()->result_array();
		
		return $all_member_leave_word_information;
	}
	
	
	function getNewAlbumInformation(){
		$friend_list = $this->getAboutMemberList($this->CI->current_member_id,'array');
		
		$this->CI->db->select('ma.member_album_id, ma.name as album_name, ma.image as album_image, ma.created_time, ma.modified_time, m.member_id, m.name as member_name');
		$this->CI->db->from('member_album as ma');
		$this->CI->db->join('member as m','m.member_id = ma.member_id');
		$this->CI->db->where_in('ma.member_id',$friend_list);
		$this->CI->db->order_by('ma.created_time','DESC');
		
		$all_new_album_information = $this->CI->db->get()->result_array();
		
		return $all_new_album_information;
	}
	
	function getMemberAlbumInformation($member_id){
		$this->CI->db->select('ma.member_album_id, ma.name as album_name, ma.image as album_image, ma.created_time, ma.modified_time, m.member_id, m.name as member_name');
		$this->CI->db->from('member_album as ma');
		$this->CI->db->join('member as m','m.member_id = ma.member_id');
		$this->CI->db->where('ma.member_id',$member_id);
		$this->CI->db->order_by('ma.created_time','DESC');
		
		$all_member_album_information = $this->CI->db->get()->result_array();
		
		return $all_member_album_information;
	}
	
	
	function getAlbumBaseInformation($album_id) {
		$this->CI->db->select('member_album_id,name as album_name');
		$this->CI->db->from('member_album');
		$this->CI->db->where('member_album_id',$album_id);
		
		$album_base_information = $this->CI->db->get_first();
		
		return $album_base_information;
	
	}
	
	function countAlbumPhoto($album_id){
		$this->CI->db->select('count(member_photo_id) as count');
		$this->CI->db->from('member_photo');
		$this->CI->db->where('member_album_id',$album_id);
		$result = idx($this->CI->db->get_first(),'count');
		
		return $result;
	
	}
	
	function getAlbumPhotoInformation($member_id,$album_id,$page_offset = 0,$limit = NULL){
		$this->CI->db->select('mp.member_photo_id, mp.name as photo_name, mp.image as photo_image, mp.description as photo_description, mp.created_time, mp.modified_time, ma.member_album_id, ma.name as album_name, m.member_id, m.name as member_name');
		$this->CI->db->from('member_photo as mp');
		$this->CI->db->join('member_album as ma','ma.member_album_id = mp.member_album_id');
		$this->CI->db->join('member as m','ma.member_id = m.member_id');
		$this->CI->db->where('mp.member_album_id',$album_id);
		$this->CI->db->where('mp.member_id',$member_id);
		$this->CI->db->order_by('mp.created_time','DESC');
		
		$all_album_photo_information = $this->CI->db->get('',$limit,$page_offset)->result_array();
		
		return $all_album_photo_information;
	}
	
	function getPhotoInformation($photo_id){
		$this->CI->db->select('mp.member_photo_id, mp.name as photo_name, mp.image as photo_image, mp.description as photo_description, mp.created_time, mp.modified_time, ma.member_album_id, ma.name as album_name, m.member_id, m.name as member_name');
		$this->CI->db->from('member_photo as mp');
		$this->CI->db->join('member_album as ma','ma.member_album_id = mp.member_album_id');
		$this->CI->db->join('member as m','ma.member_id = m.member_id');
		$this->CI->db->where('mp.member_photo_id',$photo_id);
		$this->CI->db->order_by('mp.created_time','DESC');
		
		$photo_information = $this->CI->db->get_first();
		
		return $photo_information;
		
	}
	
	function getFollowMemberInformation($member_id){
		$this->CI->db->select('m.member_id, m.name as member_name, m.image as member_image');
		$this->CI->db->from('member_friend as mf');
		$this->CI->db->join('member as m','mf.friend_id = m.member_id');
		$this->CI->db->where('mf.member_id',$member_id);
		$all_follow_member_information = $this->CI->db->get()->result_array();
		return $all_follow_member_information;
	}
	
	function getFansMemberInformation($member_id){
		$this->CI->db->select('m.member_id, m.name as member_name, m.image as member_image');
		$this->CI->db->from('member_friend as mf');
		$this->CI->db->join('member as m','mf.member_id = m.member_id');
		$this->CI->db->where('mf.friend_id',$member_id);
		$all_fans_member_information = $this->CI->db->get()->result_array();
		return $all_fans_member_information;
	}
	
	function getAllFrinedInformationByMemberId($member_id) {
		$this->CI->db->select('m.member_id, m.name as member_name, m.image as member_image, m.member_type, ps.name as current_school_name');
		$this->CI->db->from('member_friend as mf');
		$this->CI->db->join('member as m','mf.target_id = m.member_id');
		$this->CI->db->join('public_school as ps','ps.school_id = m.current_school','LEFT');
		$this->CI->db->where('mf.member_id',$member_id);
		$this->CI->db->where('mf.status','Y');
		$all_friend_information = $this->CI->db->get()->result_array();
		
		return $all_friend_information;
	}
	
	function isFriend($member_id,$target_id){
		$this->CI->db->where('member_id',$member_id);
		$this->CI->db->where('target_id',$target_id);
		$count1 = $this->CI->db->count_all_results('member_friend');
		
		$this->CI->db->where('target_id',$member_id);
		$this->CI->db->where('member_id',$target_id);
		$count2 = $this->CI->db->count_all_results('member_friend');
		
		if ($count1 > 0 && $count2 > 0) {
			$result = 'Y';
		}else {
			$result = 'N';
		}
		
		return $result;
		
	}
	
	function getMemberIdByMemberName($member_name){
		$this->CI->db->select('member_id');
		$this->CI->db->from('member');
		$this->CI->db->where('name',$member_name);
		$member_id = idx($this->CI->db->get_first(),'member_id');
		
		return $member_id;
	
	}
	
	function getMemberInformation($member_id) {
		$this->CI->db->select('m.member_id, m.account, m.name as member_name, m.member_type, m.member_type_2, m.status as member_status, m.image as member_image,m.organisation as member_organisation, m.title as member_title, m.principal as member_principal, m.gender as member_gender, m.birthday as member_birthday, m.hobby as member_hobby, m.qq as member_qq, m.mobilephone as member_mobilephone, m.phone as member_phone, m.email as member_email, m.address as member_address, m.tag as member_tag, m.description as member_description, m.content as member_content, m.created_time, m.modified_time, ps.name as member_school_name');
		$this->CI->db->from('member as m');
		$this->CI->db->join('public_school as ps','m.current_school = ps.school_id','LEFT');
		$this->CI->db->where('m.member_id',$member_id);
		$member_information = $this->CI->db->get_first();
		
		return $member_information;
	}
	
	function getMemberBaseInformation($member_id) {
		$this->CI->db->select('member_id, name as member_name, image as member_image');
		$this->CI->db->from('member');
		$this->CI->db->where('member_id',$member_id);
		$member_information = $this->CI->db->get_first();
		
		return $member_information;
	}
	
	function countMemberMessageByGroup($target_id){
		$this->CI->db->select('count(DISTINCT(`group`)) as count');
		$this->CI->db->from('member_message');
		$this->CI->db->where('member_id',$target_id);
		$this->CI->db->or_where('target_id',$target_id);
		$result = idx($this->CI->db->get_first(),'count');
		
		return $result;
	}
	
	
	function getAllMemberMessageInformationByGroup($member_id,$page_offset = 0, $limit = 999){
		
		$sql = "SELECT mm2.member_message_id, mm2.content, mm2.created_time, mm2.member_id, m.name as member_name, m.image as member_image, mm2.target_id, t.name as target_name, t.image as target_image, count FROM";
		$sql .= " (SELECT *, count(*) as count FROM";
		$sql .= " (SELECT * FROM `".$this->CI->db->dbprefix('member_message')."` WHERE member_id = '".$member_id."' OR target_id = '".$member_id."' ORDER BY created_time DESC) as mm1";
		$sql .=" GROUP BY `mm1`.`group`) as mm2";
		$sql .=" JOIN `".$this->CI->db->dbprefix('member')."` as m ON mm2.member_id = m.member_id";
		$sql .=" JOIN `".$this->CI->db->dbprefix('member')."` as t ON mm2.target_id = t.member_id";
		$sql .=" ORDER BY mm2.created_time DESC";
		$sql .=" LIMIT ".$page_offset.",".$limit;
		
		$all_member_message_information = $this->CI->db->query($sql)->result_array();
		
		return $all_member_message_information;
	}
	
	function getAllSystemMessageInformation($member_id){
	
		//category == 'friend'
		$this->CI->db->select('sm.system_message_id, sm.category, sm.type, sm.code, sm.created_time, sm.status, sm.is_new, m.member_id, m.name as member_name, m.image as member_image, t.member_id as target_id, t.name as target_name, t.image as target_image');
		$this->CI->db->from('system_message as sm');
		$this->CI->db->join('member as m','m.member_id = sm.member_id');
		$this->CI->db->join('member as t','t.member_id = sm.target_id');
		$this->CI->db->where('sm.target_id',$member_id);
		$this->CI->db->where('sm.category','friend');
		$this->CI->db->where('sm.status','Y');
		$all_member_message_information = $this->CI->db->get()->result_array();
		
		//category == 'activity'
		$this->CI->db->select('sm.system_message_id, sm.category, sm.type, sm.code, sm.created_time, sm.status, sm.is_new, m.member_id, m.name as member_name, m.image as member_image, t.member_id as target_id, t.name as target_name, t.image as target_image, a.activity_id, a.name as activity_name, a.image as activity_image');
		$this->CI->db->from('system_message as sm');
		$this->CI->db->join('member as m','m.member_id = sm.member_id');
		$this->CI->db->join('member as t','t.member_id = sm.target_id');
		$this->CI->db->join('activity as a','a.activity_id = sm.code');
		$this->CI->db->where('sm.target_id',$member_id);
		$this->CI->db->where('sm.category','activity');
		$this->CI->db->where('sm.status','Y');
		$all_activity_message_information = $this->CI->db->get()->result_array();
		
		//category == 'blog'
		
		$this->CI->db->select('sm.system_message_id, sm.category, sm.type, sm.created_time, sm.status, sm.is_new, ,m.member_id, m.name as member_name, m.image as member_image, mb.member_blog_id, mb.name as member_blog_name');
		$this->CI->db->from('system_message as sm');
		$this->CI->db->join('member as m','m.member_id = sm.member_id');
		$this->CI->db->join('member_blog as mb','mb.member_blog_id = sm.code');
		$this->CI->db->where('sm.target_id',$member_id);
		$this->CI->db->where('sm.category','blog');
		$this->CI->db->where('sm.status','Y');
		$all_blog_message_information = $this->CI->db->get()->result_array();
		
		
		$all_system_message_information['all_member_message_information'] = $all_member_message_information;
		$all_system_message_information['all_activity_message_information'] = $all_activity_message_information;
		$all_system_message_information['all_blog_message_information'] = $all_blog_message_information;

		return $all_system_message_information;
		
	}
	
	
	function countMemberMessageByMemberId($member_id){
		$current_member_id = $this->CI->current_member_id;
		if ($current_member_id < $member_id) {
			$group = $current_member_id.','.$member_id;
		} else {
			$group = $member_id.','.$current_member_id;
		}
		
		$this->CI->db->select('count(member_message_id) as count');
		$this->CI->db->from('member_message');
		$this->CI->db->where('group',$group);
		$count = idx($this->CI->db->get_first(),'count');
		
		return $count;
	}
	
	function getAllMemberMessageInformationByMemberId($member_id,$page_offset = 0, $limit = NULL){
		
		$current_member_id = $this->CI->current_member_id;
		if ($current_member_id < $member_id) {
			$group = $current_member_id.','.$member_id;
		} else {
			$group = $member_id.','.$current_member_id;
		}
		
		$this->CI->db->select('mm.member_message_id, mm.content, mm.created_time, mm.member_id, m.name as member_name, m.image as member_image, mm.target_id, t.name as target_name, t.image as target_image');
		$this->CI->db->from('member_message as mm');
		$this->CI->db->join('member as m','mm.member_id = m.member_id');
		$this->CI->db->join('member as t','mm.target_id = t.member_id');
		$this->CI->db->where('mm.group',$group);
		$this->CI->db->order_by('mm.created_time','DESC');
		$all_member_message_information = $this->CI->db->get('',$limit,$page_offset)->result_array();
		
		return $all_member_message_information;
	}
	
	function getMemberInMessageInformation($target_id,$page_offset = 0, $limit = NULL){
		$this->CI->db->select('m.name as member_name, mm.member_message_id, mm.content, mm.created_time');
		$this->CI->db->from('member_message as mm');
		$this->CI->db->join('member as m','mm.member_id = m.member_id');
		$this->CI->db->where('mm.target_id',$target_id);
		$all_member_message_information = $this->CI->db->get('',$limit,$page_offset)->result_array();
		
		return $all_member_message_information;
	}
	
	function countMemberOutMessage($member_id){
		$this->CI->db->select('count(DISTINCT(`group`)) as count');
		$this->CI->db->from('member_message');
		$this->CI->db->where('member_id',$member_id);
		$this->CI->db->or_where('target_id',$member_id);
		$result = idx($this->CI->db->get_first(),'count');
		
		return $result;
	}
	
	function getMemberOutMessageInformation($member_id,$page_offset = 0, $limit = NULL){
		$this->CI->db->select('m.name as member_name, mm.member_message_id, mm.name as message_name, mm.created_time');
		$this->CI->db->from('member_message as mm');
		$this->CI->db->join('member as m','mm.target_id = m.member_id');
		$this->CI->db->where('mm.member_id',$member_id);
		$all_member_message_information = $this->CI->db->get('',$limit,$page_offset)->result_array();
		
		return $all_member_message_information;
	}
	
	function getMemeberMessageInformation($member_message_id){
		$this->CI->db->select('mf.name as f_member_name, mt.name as t_member_name, mm.member_message_id, mm.name as message_name, mm.content, mm.created_time');
		$this->CI->db->from('member_message as mm');
		$this->CI->db->join('member as mf','mm.member_id = mf.member_id');
		$this->CI->db->join('member as mt','mm.target_id = mt.member_id');
		$this->CI->db->where('mm.member_message_id',$member_message_id);
		$member_message_information = $this->CI->db->get_first();
		
		return $member_message_information;
	
	}
	
	function getMemberInformationBySearch($member_name,$member_type,$rand=false){
		$this->CI->db->select('member_id, name as member_name, member_type, image as member_image');
		$this->CI->db->from('member');
		
		if ($rand == 'false') {
			$this->CI->db->like('name',$member_name);
			$this->CI->db->where('member_type',$member_type);
			$this->CI->db->order_by('member_id','DESC');
		} else {
			$this->CI->db->where('member_type',$member_type);
			//$this->CI->db->or_where('member_type','company');
			$this->CI->db->order_by('member_id',random);
		}
		$all_member_information = $this->CI->db->get()->result_array();
		
		return $all_member_information;
		
	}
	
	function getMemberInformationBySchoolId($school_id,$member_type){
		$this->CI->db->select('member_id, name as member_name, member_type, image as member_image');
		$this->CI->db->from('member');
		$this->CI->db->where('current_school',$school_id);
		$this->CI->db->where('member_type',$member_type);
		$all_member_information = $this->CI->db->get()->result_array();
		
		return $all_member_information;
		
	}
	
	function getAcitivityInformationById($activity_id){
		$this->CI->db->select('a.activity_id, a.name as activity_name, a.apply_start_time, a.apply_end_time, a.start_time, a.end_time, a.image as activity_image, a.image_width as activity_image_width, a.image_height as activity_image_height, a.price as activity_price, a.address as activity_address, a.description as activity_description, a.content as activity_content, a.created_time, m.member_id, m.name as member_name, m.image as member_image');
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_publish_member as apm','apm.activity_id = a.activity_id');
		$this->CI->db->join('member as m','apm.member_id = m.member_id');
		$this->CI->db->where('a.activity_id',$activity_id);
		$activity_information = $this->CI->db->get_first();
		
		return $activity_information;
	}
	
	function getActivityInformationByName($activity_name,$activity_type,$rand = false){
		$this->CI->db->select('a.activity_id, a.name as activity_name, a.apply_start_time, a.apply_end_time, a.start_time, a.end_time, a.image as activity_image, a.description, a.created_time, m.member_id, m.name as member_name, m.image as member_image, count(DISTINCT aam.member_id) as attend_number, count(DISTINCT aam2.member_id) as attention_number');
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_publish_member as apm','apm.activity_id = a.activity_id');
		$this->CI->db->join('member as m','apm.member_id = m.member_id');
		$this->CI->db->join('activity_attend_member as aam','aam.activity_id = a.activity_id','left');
		$this->CI->db->join('activity_attention_member as aam2','aam2.activity_id = a.activity_id','left');
		$this->CI->db->where('apm.publisher','Y');
		if ($rand == 'false'){
			$this->CI->db->like('a.name',$activity_name);
		}else {
			$this->CI->db->order_by('a.activity_id','random');
			$this->CI->db->limit('5');
		}
		
		if ($activity_type == 'new') {
			
		}elseif ($activity_type == 'attention') {
			$this->CI->db->where('aam2.member_id',$this->CI->current_member_id);
		}
		
		$this->CI->db->group_by('a.activity_id');
		$this->CI->db->order_by('a.created_time','DESC');
		$all_new_activity_information = $this->CI->db->get()->result_array();
		
		return $all_new_activity_information;
	}
	
	function getActivityInformationBySearchFields($activity_name = null, $school_id = null, $member_id = null, $tag= null, $apply_start_time = null, $apply_end_time = null, $start_time = null, $end_time = null, $activity_type = null, $status = null){
		$this->CI->db->select('a.activity_id, a.name as activity_name, a.apply_start_time, a.apply_end_time, a.start_time, a.end_time, a.image as activity_image, a.description, a.created_time, m.member_id, m.name as member_name, m.image as member_image, count(DISTINCT aam.member_id) as attend_number, count(DISTINCT aam2.member_id) as attention_number');
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_publish_member as apm','apm.activity_id = a.activity_id');
		$this->CI->db->join('member as m','apm.member_id = m.member_id');
		$this->CI->db->join('activity_attend_member as aam','aam.activity_id = a.activity_id','left');
		$this->CI->db->join('activity_attention_member as aam2','aam2.activity_id = a.activity_id','left');
		
		if ($activity_name != '') {
			$this->db->like('a.name',$activity_name);
		}
		
		if ($school_id != '') {
			$this->CI->db->where('m.current_school',$school_id);
		}
		
		if ($member_id != '') {
			$this->CI->db->where('m.member_id',$member_id);
		}
		
		if ($tag != ''){
			$this->CI->db->join('activity_tag as at','a.activity_id = at.activity_id');
			$this->CI->db->where('at.tag',$tag);
		}
		
		if ($apply_start_time != ''){
			$this->CI->db->where('a.apply_start_time >=',$apply_start_time);
		}
		
		if ($apply_end_time != ''){
			$this->CI->db->where('a.apply_end_time <=',$apply_end_time);
		}
		
		if ($start_time != ''){
			$this->CI->db->where('a.start_time >=',$start_time);
		}
		
		if ($end_time != ''){
			$this->CI->db->where('a.end_time <=',$end_time);
		}
		
		if ($activity_type == 'new') {
			
		}elseif ($activity_type == 'attention') {
			$this->CI->db->where('aam2.member_id',$this->CI->current_member_id);
		}elseif ($activity_type == 'attend') {
			$this->CI->db->where('aam.member_id',$this->CI->current_member_id);
		}
		
		if ($status == 'active') {
			$this->CI->db->where('a.end_time >=',date('Y-m-d'));
		}
		
		$this->CI->db->group_by('a.activity_id');
		$this->CI->db->order_by('a.created_time','DESC');
		$all_new_activity_information = $this->CI->db->get()->result_array();
		
		return $all_new_activity_information;
	}
	
	
	function getHotActivityTag($page_offset = 0, $limit = NULL){
		$this->CI->db->select('tag, count(activity_tag_id) as tag_count');
		$this->CI->db->from('activity_tag');
		$this->CI->db->group_by('tag');
		$this->CI->db->order_by('tag_count','DESC');
		$all_hot_activity_tag = $this->CI->db->get('',$limit,$page_offset)->result_array();
		
		return $all_hot_activity_tag;
		
	}
	
	
	/*--------------------------Activity-----------------------------*/
	
	function isMemberAttendActivity($member_id,$activity_id){
		
		$this->CI->db->where('member_id',$member_id);
		$this->CI->db->where('activity_id',$activity_id);
		$count = $this->CI->db->count_all_results('activity_attend_member');
		
		$result = '';
		
		if ($count == 1) {
			$result = 'Y';
		}else {
			$result = 'N';
		}
		
		return $result;
		
	}
	
	function isMemberAttentionActivity($member_id,$activity_id){
		
		$this->CI->db->where('member_id',$member_id);
		$this->CI->db->where('activity_id',$activity_id);
		$count = $this->CI->db->count_all_results('activity_attention_member');
		
		$result = '';
		
		if ($count == 1) {
			$result = 'Y';
		}else {
			$result = 'N';
		}
		
		return $result;
		
	}
	
	function isMemberPublishActivity($member_id,$activity_id){
		$this->CI->db->where('member_id',$member_id);
		$this->CI->db->where('activity_id',$activity_id);
		$count = $this->CI->db->count_all_results('activity_publish_member');
		if ($count > 0){
			$result = 'Y';
		}else {
			$result = 'N';
		}
		return $result;
	}
	
	function getAllMemberInformationByName($member_name){
		$this->CI->db->select('member_id, name as member_name, image as member_image');
		$this->CI->db->from('member');
		$this->CI->db->like('name',$member_name);
		$all_member_information = $this->CI->db->get('')->result_array();
		return $all_member_information;
	}
	
	
}

?>
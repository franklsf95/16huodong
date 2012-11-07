<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 公共控制器，用来数据库存取
*/

define( 'MEMBER_BASIC', 	'm.member_id, m.name as member_name, m.image as member_image');
define( 'MEMBER_BRIEF',		'm.member_id, m.name as member_name, m.image as member_image, m.member_type, m.school_id, m.school_name, m.gender, m.organisation, m.title, m.principal');
define( 'MEMBER_CONTACT', 	'm.member_id, m.name as member_name, m.image as member_image, m.school_id, m.school_name, m.phone, m.email, m.qq');
define( 'MEMBER_DETAIL', 	'm.member_id, m.account, m.name as member_name, m.member_type, m.school_id, m.school_name, m.image as member_image, m.organisation as member_organisation, m.title as member_title, m.principal as member_principal, m.gender as member_gender, m.birthday as member_birthday, m.qq as member_qq, m.phone as member_phone, m.email as member_email, m.address as member_address, m.description as member_description, m.content as member_content, m.created_time, m.modified_time');
define( 'ACTIVITY_BASIC', 	'a.activity_id, a.name as activity_name, a.publisher_id, a.publisher_name');
define( 'ACTIVITY_BRIEF', 	'a.activity_id, a.name as activity_name, a.publisher_id, a.publisher_name, a.apply_start_time, a.apply_end_time, a.start_time, a.end_time, a.image as activity_image, a.description, a.follow_count, a.attend_count, a.view_count');
define( 'ACTIVITY_DETAIL', 	'a.activity_id, a.name as activity_name, a.publisher_id, a.publisher_name, a.apply_start_time, a.apply_end_time, a.start_time, a.end_time, a.image as activity_image, a.price, a.address, a.description, a.content, a.created_time, a.modified_time, a.view_count, a.attend_count, a.follow_count, a.book_id');
define( 'COMMENT',			'ac.activity_comment_id, ac.activity_id, ac.member_id, ac.content, ac.reply, ac.created_time, m.name as member_name, m.image as member_image');
DEFINE( 'BOOK_BASIC', 		'mb.book_id, mb.name as book_name, mb.author_id, mb.author_name');
DEFINE( 'BOOK_FULL',		'mb.book_id, mb.name as book_name, mb.author_id, mb.author_name, mb.image as book_image, mb.content as book_content, mb.created_time, mb.modified_time, mb.like_count, mb.view_count');

class Extend_control {
	var $CI;

	function __construct() {
		$this->CI =& get_instance();
	}

/*
 *---------------------------------------------------------------
 * 会员信息处理
 *---------------------------------------------------------------
 */

	/**
	* 初始化会员信息
	*
	* @return 	PHP全局变量 	current_member_information
	* @return 	PHP sessionValue 	current_member_information
	* @return 	Smarty全局变量 	current_member_id, current_member_information
	*/
	function setCurrentMemberInformation() {
		$cmid = $this->CI->current_member_id;

		$this->CI->db->select(MEMBER_DETAIL);
		$this->CI->db->from('member as m');
		$this->CI->db->where('member_id',$cmid);
		$cmi = $this->CI->db->get_first();

		$this->CI->db->select('tag');
		$this->CI->db->from('member_tag');
		$this->CI->db->where('member_id',$cmid);
		$tag_array = $this->CI->db->get()->result_array();
		$tags = array();
		foreach( $tag_array as $t ) {
			$tags[] = $t['tag'];
		}
		$cmi['tags'] = $tags;

		$this->CI->setSessionValue('current_member_information',$cmi);
		$this->CI->current_member_information = $cmi;

		$this->CI->ci_smarty->assign('current_member_information',$cmi);
		$this->CI->ci_smarty->assign('current_member_id',$cmid);
	}

	function getMemberIdByMemberName($member_name){
		$this->CI->db->select('member_id');
		$this->CI->db->from('member');
		$this->CI->db->where('name',$member_name);
		$member_id = idx($this->CI->db->get_first(),'member_id');
		
		return $member_id;
	}

	function getMemberNameByMemberId($member_id){
		$this->CI->db->select('name');
		$this->CI->db->from('member');
		$this->CI->db->where('member_id',$member_id);
		$name = idx($this->CI->db->get_first(),'name');
		
		return $name;
	}

	function getMemberInformation($member_id) {
		$this->CI->db->select(MEMBER_DETAIL);
		$this->CI->db->from('member as m');
		$this->CI->db->where('m.member_id',$member_id);
		$member_information = $this->CI->db->get_first();

		$this->CI->db->select('tag');
		$this->CI->db->from('member_tag');
		$this->CI->db->where('member_id',$member_id);
		$tag_array = $this->CI->db->get()->result_array();
		$tags = array();
		foreach( $tag_array as $t ) {
			$tags[] = $t['tag'];
		}
		$member_information['tags'] = $tags;

		return $member_information;
	}
	
	function getMemberBasicById($member_id) {
		$this->CI->db->select(MEMBER_BASIC);
		$this->CI->db->from('member as m');
		$this->CI->db->where('member_id',$member_id);
		
		return $this->CI->db->get_first();
	}

	/**
	* 检查好友状态
	*
	* @param 	$member_id 		A的ID
	* @param 	$target_id 		B的ID
	*
	* @return 	0不是好友	1是好友	-1 A加过B	-2 B加过A
	*/
	function getFriendStatus($member_id,$target_id){
		$this->CI->db->where('member_id',$member_id);
		$this->CI->db->where('target_id',$target_id);
		$count1 = $this->CI->db->count_all_results('member_friend');
		
		$this->CI->db->where('target_id',$member_id);
		$this->CI->db->where('member_id',$target_id);
		$count2 = $this->CI->db->count_all_results('member_friend');
		
		if ($count1 && $count2 ) {
			return 1;
		} else if (!$count1 && $count2) {
			return -2;
		} else if ($count1 && !$count2) {
			return -1;
		} else {
			return 0;
		}
	}

	/**
	* 检查是否为好友
	*
	* @param 	$member_id 		A的ID
	* @param 	$target_id 		B的ID
	*
	* @return 	0不是好友	1是好友
	*/
	function isFriend($member_id,$target_id) {
		$this->CI->db->select('approved');
		$this->CI->db->where('member_id',$member_id);
		$this->CI->db->where('target_id',$target_id);

		return idx( $this->CI->db->get_first('member_friend'), 'approved' );
	}

	function getAllFriendsBasic($member_id) {
		$this->CI->db->select(MEMBER_BASIC);
		$this->CI->db->from('member_friend as mf');
		$this->CI->db->join('member as m','mf.target_id = m.member_id');
		$this->CI->db->where('mf.member_id',$member_id);
		$this->CI->db->where('mf.approved',1);
		
		return $this->CI->db->get()->result_array();
	}

/*
 *---------------------------------------------------------------
 * 全站活动加载
 *---------------------------------------------------------------
 */
	function getAllNewsFeed($page_offset = 0, $limit = 20){
		$this->CI->db->select('nf.news_feed_id, nf.type, nf.code, nf.created_time, nf.category, t.member_id as target_id, t.name as target_name, '.MEMBER_BASIC);
		$this->CI->db->from('news_feed as nf');
		$this->CI->db->join('member as m','m.member_id = nf.member_id');
		$this->CI->db->join('member as t','t.member_id = nf.target_id');
		$this->CI->db->order_by('nf.created_time','DESC');
		$all_news_feed = $this->CI->db->get('',$limit,$page_offset)->result_array();

		return $all_news_feed;
	}

	function getHotActivities($limit = 3) {
		$this->CI->db->select(ACTIVITY_BRIEF);
		$this->CI->db->from('activity as a');
		$this->CI->db->where('date(a.end_time) >=',$this->CI->current_date);
		$this->CI->db->group_by('a.activity_id');
		$this->CI->db->order_by('view_count','DESC');
		
		return $this->CI->db->get('',$limit )->result_array();
	}

	function getLatestActivities($page_offset = 0,$limit = 5) {
		$this->CI->db->select(ACTIVITY_BRIEF);
		$this->CI->db->from('activity as a');
		$this->CI->db->where('date(a.end_time) >=',$this->CI->current_date);
		$this->CI->db->group_by('a.activity_id');
		$this->CI->db->order_by('a.created_time','DESC');
		
		return $this->CI->db->get('',$limit,$page_offset )->result_array();
	}

	/**
	* 随机获取活动信息
	*/
	function randomActivityInformation($activity_type,$rand = false){
		$this->CI->db->select(ACTIVITY_BRIEF);
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_attend as af','a.activity_id = af.activity_id','LEFT');

		if( $rand ) {
			$this->CI->db->order_by('a.activity_id','random');
			$this->CI->db->limit('5');
		}
		
		if ($activity_type == 'new') {
			
		}elseif ($activity_type == 'follow') {
			$this->CI->db->where('af.member_id',$this->CI->current_member_id);
		}
		
		$this->CI->db->group_by('a.activity_id');
		$this->CI->db->order_by('a.created_time','DESC');
		$all_new_activity_information = $this->CI->db->get()->result_array();
		
		return $all_new_activity_information;
	}

/*
 *---------------------------------------------------------------
 * 单个活动信息处理
 *---------------------------------------------------------------
 */
	function getActivityBasicById($activity_id) {
		$this->CI->db->select(ACTIVITY_BASIC);
		$this->CI->db->from('activity as a');
		$this->CI->db->where('a.activity_id',$activity_id);
		
		return $this->CI->db->get_first();
	}
	/**
	* 获取活动全部信息
	*
	* @param 	$activity_id 	活动ID
	*/
	function getActivityInformationById($activity_id){
		$this->CI->db->select(ACTIVITY_DETAIL);
		$this->CI->db->from('activity as a');
		$this->CI->db->where('a.activity_id',$activity_id);
		$activity_information = $this->CI->db->get_first();

		//get tags
		$this->CI->db->select('tag');
		$this->CI->db->from('activity_tag');
		$this->CI->db->where('activity_id',$id);
		$all_tag = $this->CI->db->get()->result_array();
			
		if( is_array($all_tag) )
			foreach ($all_tag as $tag)
				$activity_information['tags'][] = $tag['tag'];
		
		return $activity_information;
	}

	function getActivityCountsById( $activity_id ) {
		$this->CI->db->select('a.view_count, a.attend_count, a.follow_count');
		$this->CI->db->from('activity as a');
		$this->CI->db->where('a.activity_id',$activity_id);
		
		return $this->CI->db->get_first();
	}

	function getActivityCommentInformation($activity_id,$page_offset = 0,$limit = 5){
		$this->CI->db->select(COMMENT);
		$this->CI->db->from('activity_comment as ac');
		$this->CI->db->join('member as m','ac.member_id = m.member_id');
		$this->CI->db->where('ac.activity_id',$activity_id);
		$this->CI->db->order_by('ac.created_time','DESC');
		$all_activity_comment_information = $this->CI->db->get('', $limit, $page_offset)->result_array();
		return $all_activity_comment_information;
	}
	
	function getActivityAttendMemberInformation($activity_id){
		$this->CI->db->select(MEMBER_CONTACT.', am.activity_attend_id, am.approved');
		$this->CI->db->from('activity_attend as am');
		$this->CI->db->join('member as m','m.member_id = am.member_id');
		$this->CI->db->where('am.activity_id',$activity_id);

		return $this->CI->db->get()->result_array();
	}
	
	function getActivityAttendMemberId($activity_id) {
		$this->CI->db->select('member_id');
		$this->CI->db->where('activity_id',$activity_id);
		
		return $this->CI->db->get('activity_attend')->result_array();
	}
	
	function getActivityFollowMemberInformation($activity_id){
		$this->CI->db->select(MEMBER_CONTACT);
		$this->CI->db->from('activity_follow as am');
		$this->CI->db->join('member as m','m.member_id = am.member_id');
		$this->CI->db->where('am.activity_id',$activity_id);

		return $this->CI->db->get()->result_array();
	}

	/**
	* 获取单个活动的rate信息
	*
	* @return 	Array 	rate1, rate2, rate1ed, rate2ed
	*/
	function getActivityRateInformation($activity_id) {
		$member_id = $this->CI->current_member_id;

		$rate_array['rate1'] = 0;
		$rate_array['rate2'] = 0;
		$rate_array['rate1ed'] = false;
		$rate_array['rate2ed'] = false;

		$this->CI->db->select('a.activity_id, a.member_id, a.rate');
		$this->CI->db->from('activity_rate as a');
		$this->CI->db->where('activity_id',$activity_id);
		$results=$this->CI->db->get()->result_array();
		
		foreach ($results as $item) {
			if ($item['rate']==1) {
				$rate_array['rate1']++;
				if ($member_id && $item['member_id'] == $member_id) {
					$rate_array['rate1ed'] = true;
				}
			} else if ($item['rate']==-1) {
				$rate_array['rate2']++;
				if ($member_id && $item['member_id'] == $member_id) {
					$rate_array['rate2ed'] = true;
				}
			}
		}
		return $rate_array;
	}

	function isMemberAttendActivity($member_id,$activity_id){
		$this->CI->db->where('member_id',$member_id);
		$this->CI->db->where('activity_id',$activity_id);
		
		return $this->CI->db->count_all_results('activity_attend');
	}
	
	function isMemberFollowActivity($member_id,$activity_id){
		$this->CI->db->where('member_id',$member_id);
		$this->CI->db->where('activity_id',$activity_id);
				
		return $this->CI->db->count_all_results('activity_follow');
	}
	
	function isMemberPublishActivity($member_id,$activity_id){
		$this->CI->db->where('publisher_id',$member_id);
		$this->CI->db->where('activity_id',$activity_id);

		return $this->CI->db->count_all_results('activity');
	}

	/**
	* 更新活动访问量
	*/
	function AddActivityVisit($activity_id) {
		$this->CI->db->select('view_count');
		$this->CI->db->from('activity');
		$this->CI->db->where('activity_id',$activity_id);
		$currentCount = idx( $this->CI->db->get_first(), 'view_count' );

		$data['view_count'] = $currentCount+1;
		$this->CI->db->where('activity_id',$activity_id);
		$this->CI->db->update('activity',$data);
	}


/*
 *---------------------------------------------------------------
 * 单个会员所有活动读取
 *---------------------------------------------------------------
 */

	function getCurrentFollowActivityInformation($member_id){
		$this->CI->db->select(ACTIVITY_BRIEF);
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_follow as af','af.activity_id = a.activity_id');
		$this->CI->db->where('af.member_id',$member_id);
		$this->CI->db->where('date(a.end_time) >=',$this->CI->current_date);
		$this->CI->db->group_by('a.activity_id');
		$this->CI->db->order_by('a.created_time','DESC');
		
		return $this->CI->db->get('',$limit,$page_offset )->result_array();
	}
	
	function getCurrentAttendActivityInformation($member_id,$page_offset,$limit){
		$this->CI->db->select(ACTIVITY_BRIEF);
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_attend as am','am.activity_id = a.activity_id');
		$this->CI->db->where('am.member_id',$member_id);
		$this->CI->db->where('date(a.end_time) >=',$this->CI->current_date);
		$this->CI->db->group_by('a.activity_id');
		$this->CI->db->order_by('a.created_time','DESC');
		
		return $this->CI->db->get('',$limit,$page_offset )->result_array();
	}
	
	function getCurrentPublishActivityInformation($member_id,$page_offset,$limit){
		$this->CI->db->select(ACTIVITY_BRIEF);
		$this->CI->db->from('activity as a');
		$this->CI->db->where('a.publisher_id',$member_id);
		$this->CI->db->where('date(a.end_time) >=',$this->CI->current_date);
		$this->CI->db->group_by('a.activity_id');
		$this->CI->db->order_by('a.created_time','DESC');
		
		return $this->CI->db->get('',$limit,$page_offset )->result_array();
	}

	function countAllMemberFollowActivities($member_id) {
		$this->CI->db->select('count(a.activity_id) as count');
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_follow as am','a.activity_id = am.activity_id');
		$this->CI->db->where('am.member_id',$member_id);
		$result = idx($this->CI->db->get_first(),'count');
		
		return $result;
	}
	
	function getAllMemberFollowActivities($member_id,$offset=0,$limit){
		$this->CI->db->select(ACTIVITY_BRIEF);
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_follow as am','a.activity_id = am.activity_id');
		$this->CI->db->where('am.member_id',$member_id);
		$this->CI->db->group_by('a.activity_id');
		$this->CI->db->order_by('a.created_time','DESC');
		$all_member_attend_activity_information = $this->CI->db->get('',$limit,$offset)->result_array();
		
		return $all_member_attend_activity_information;
	}
	
	function countAllMemberAttendActivities($member_id) {
		$this->CI->db->select('count(a.activity_id) as count');
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_attend as am','a.activity_id = am.activity_id');
		$this->CI->db->where('am.member_id',$member_id);
		$result = idx($this->CI->db->get_first(),'count');
		
		return $result;
	}
	
	function getAllMemberAttendActivities($member_id,$offset=0,$limit){
		$this->CI->db->select(ACTIVITY_BRIEF);
		$this->CI->db->from('activity as a');
		$this->CI->db->join('activity_attend as aa','a.activity_id = aa.activity_id','LEFT');
		$this->CI->db->where('aa.member_id',$member_id);
		$this->CI->db->group_by('a.activity_id');
		$this->CI->db->order_by('a.created_time','DESC');
		$all_member_attend_activity_information = $this->CI->db->get('',$limit,$offset)->result_array();
		
		return $all_member_attend_activity_information;
	}
	
	function countAllMemberPublishActivities($member_id) {
		$this->CI->db->select('count(a.activity_id) as count');
		$this->CI->db->from('activity as a');
		$this->CI->db->where('a.publisher_id',$member_id);
		$result = idx($this->CI->db->get_first(),'count');
		
		return $result;
	}
	
	function getAllMemberPublishActivities($member_id,$offset=0,$limit){
		$this->CI->db->select(ACTIVITY_BRIEF);
		$this->CI->db->from('activity as a');
		$this->CI->db->where('a.publisher_id',$member_id);
		$this->CI->db->group_by('a.activity_id');
		$this->CI->db->order_by('a.created_time','DESC');
		$all_member_publish_activity_information = $this->CI->db->get('',$limit,$offset)->result_array();
		
		return $all_member_publish_activity_information;
	}

/*
 *---------------------------------------------------------------
 * 人生图书馆
 *---------------------------------------------------------------
 */

////-------- 全站读取

	function getAllMemberBlogInformation($page_offset = 0,$limit = 15, $str_length = 100){
		$this->CI->db->select(BOOK_FULL);
		$this->CI->db->from('book as mb');
		$this->CI->db->join('member as m','mb.author_id = m.member_id');
		$this->CI->db->group_by('mb.book_id');
		$this->CI->db->order_by('mb.created_time','DESC');
		$all_book_information = $this->CI->db->get('',$limit,$page_offset)->result_array();
		
		foreach ($all_book_information as &$book_information) {
			$book_information['content'] = trim($book_information['content']);
			$book_information['content'] = strip_tags($book_information['content']);
			if (strlen($book_information['content']) > 150) {
				$book_information['content'] = mb_substr($book_information['content'], 0, $str_length,'utf-8').'...';
			}
			//$book_information['content'] = trim($book_information['content']);
		}
		
		
		return $all_book_information;
	}
	
	function getHotBlogInformation($page_offset = 0,$limit = 10){
		$this->CI->db->select(BOOK_FULL);
		$this->CI->db->from('book as mb');
		$this->CI->db->join('member as m','mb.author_id = m.member_id');
		$this->CI->db->group_by('mb.book_id');
		$this->CI->db->order_by('count(mbv.book_visit_id)','DESC');
		$this->CI->db->order_by('mb.created_time','DESC');
		$all_hot_blog_information = $this->CI->db->get('',$limit,$page_offset)->result_array();
		
		return $all_hot_blog_information;
	
	}
	
	function getMemberBlogInformation($member_id,$page_offset = 0,$limit = 15 ,$str_length = 150){
		$this->CI->db->select('mb.book_id, mb.name as book_name, mb.image as book_image, mb.image_width as book_image_width, mb.image_height as book_image_height, mb.content, mb.created_time, mb.modified_time');
		$this->CI->db->from('book as mb');
		$this->CI->db->where('mb.author_id',$member_id);
		$this->CI->db->order_by('mb.created_time','DESC');
		$all_book_information = $this->CI->db->get('',$limit,$page_offset)->result_array();
		
		foreach ($all_book_information as &$i) {
			$i['content'] = trim($i['content']);
			$i['content'] = strip_tags($i['content']);
			if (strlen($i['content']) > 150) {
				$i['content'] = mb_substr($i['content'], 0, $str_length,'utf-8').'...';
			}
		}
		
		return $all_book_information;
	}
	
	function getPreferBlogInformation($member_id,$page_offset = 0,$limit = 15){
		$this->CI->db->select(BOOK_FULL);
		$this->CI->db->from('book as mb');
		$this->CI->db->join('member as m','mb.author_id = m.member_id');
		$this->CI->db->join('member_like_book as mpb','mpb.book_id = mb.book_id');
		$this->CI->db->where('mpb.member_id',$member_id);
		$this->CI->db->group_by('mb.book_id');
		$this->CI->db->order_by('mb.created_time','DESC');
		$all_prefer_blog_information = $this->CI->db->get('',$limit,$page_offset)->result_array();
		
		return $all_prefer_blog_information;
	}


////-------- 单个微型书读取

	function getBookBasicById($book_id){
		$this->CI->db->select(BOOK_BASIC);
		$this->CI->db->from('book as mb');
		$this->CI->db->where('mb.book_id',$book_id);
		
		return $this->CI->db->get_first();
	}
	
	function getBookInformationById($book_id){
		$this->CI->db->select(BOOK_FULL);
		$this->CI->db->from('book as mb');
		$this->CI->db->where('mb.book_id',$book_id);
		
		return $this->CI->db->get_first();
	}

////-------- 微型书评论

	function countAllBlogComment($book_id){
		$this->CI->db->select('count(mbc.book_comment_id) as count');
		$this->CI->db->from('book_comment as mbc');
		$this->CI->db->join('member as m','mbc.member_id = m.member_id');
		$this->CI->db->where('mbc.book_id',$book_id);
		$count = idx($this->CI->db->get_first(),'count');
		return $count;
	
	}
	
	function getBookComment($book_id,$page_offset = 0,$limit = 10){
		$this->CI->db->select('mbc.book_comment_id, mbc.book_id, mbc.member_id, mbc.content, mbc.created_time, m.name as member_name, m.image as member_image');
		$this->CI->db->from('book_comment as mbc');
		$this->CI->db->join('member as m','mbc.member_id = m.member_id');
		$this->CI->db->where('mbc.book_id',$book_id);
		$this->CI->db->order_by('mbc.created_time','DESC');
		$all_blog_comment_information = $this->CI->db->get('', $limit, $page_offset)->result_array();
		return $all_blog_comment_information;
	}

/*
 *---------------------------------------------------------------
 * 系统消息读取
 *---------------------------------------------------------------
 */
	
	/**
	* 获取所有新消息提醒
	* 用于member/sidebar
	* BaseActionController@__constructor()
	*/
	function getNewSystemMessageCategories($member_id){		
		$this->CI->db->from('system_message');
		$this->CI->db->where('target_id',$member_id);
		$this->CI->db->where('status','Y');
		$this->CI->db->where('is_new','Y');
		$all_new_system_message_information = $this->CI->db->get()->result_array();
		
		$activity_count = 0;
		$friend_count = 0;
		$book_count = 0;
		$member_message = 0;
		
		foreach( $all_new_system_message_information as $i )
		{
			if ($i['category'] == 'activity') 		$activity_count++;				
			elseif ($i['category'] == 'friend')		$friend_count++;
			elseif ($i['category'] == 'book')		$book_count++;
			elseif ($i['category'] == 'member_message') 	$member_message_count++;
		}

		$all_system_message = array();
		if ($activity_count > 0) $all_system_message[] = array('type' => 'activity','count' => $activity_count);
		if ($friend_count > 0) $all_system_message[] = array('type' => 'friend','count' => $friend_count);
		if ($book_count > 0) $all_system_message[] = array('type' => 'book','count' => $book_count);
		if ($member_message_count > 0) $all_system_message[] = array('type' => 'member_message','count' => $member_message_count);
		
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

/*
 *---------------------------------------------------------------
 * 搜索
 *---------------------------------------------------------------
 */
	/**
	* 按人名搜索返回会员信息
	*
	* @param 	string 	$member_name 	查询的会员名
	* @param 	int 	$offset 		db query offset
	* @param 	int 	$limit 			返回数量上限
	*/
	function searchMemberByName($member_name, $offset=0, $limit=0){
		$this->CI->db->select(MEMBER_BRIEF);
		$this->CI->db->from('member as m');
		$this->CI->db->like('name',$member_name);
		$this->CI->db->order_by('member_id','DESC');

		return $this->CI->db->get('',$limit,$offset)->result_array();
	}

	/**
	* 按人名搜索好友，返回基本信息
	*
	* @param 	int 	$member_name 	查询的好友名
	*/
	function getFriendBasicByName($member_name){
		$this->CI->db->select(MEMBER_BASIC);
		$this->CI->db->from('member as m');
		if($member_name) $this->CI->db->like('m.name',$member_name);

		$this->CI->db->join('member_friend as mf','mf.target_id = m.member_id');
		$this->CI->db->where('mf.member_id',$this->CI->current_member_id);
		$this->CI->db->where('mf.approved',1);

		return $this->CI->db->get('')->result_array();
	}

	/**
	* 按人名搜索返回符合条件总数
	*
	* @param 	string 	$member_name 	查询的会员名
	*/
	function searchMemberCountByName($member_name){
		$this->CI->db->select('count(member_id) as count');
		$this->CI->db->from('member');
		$this->CI->db->like('name',$member_name);
		return idx($this->CI->db->get_first(),'count');
	}

	/**
	* 搜索活动
	*
	* @param 	int 	$offset 		db query offset
	* @param 	int 	$limit 			返回数量上限
	*/
	function searchActivity( 
		$offset = 0,
		$limit = 0,
		$activity_name = null, 
		$school_id = null, 
		$publisher_id = null, 
		$member_type = null,
		$tag = null, 
		$is_open = null,
		$is_active = null,
		$is_following = null,
		$is_attending = null,
		$apply_start_time = null, 
		$apply_end_time = null, 
		$start_time = null, 
		$end_time = null ) {

		$this->CI->db->select(ACTIVITY_BRIEF);
		$this->CI->db->from('activity as a');
		$this->CI->db->join('member as m','a.publisher_id = m.member_id','left');
		$this->CI->db->join('activity_attend as am','am.activity_id = a.activity_id','left');
		$this->CI->db->join('activity_follow as af','af.activity_id = a.activity_id','left');
		
		if ($activity_name!='') $this->CI->db->like('a.name',$activity_name);
		if ($publisher_id)	$this->CI->db->where('a.publisher_id',$publisher_id);	

		if ($tag) {
			$this->CI->db->join('activity_tag as at','a.activity_id = at.activity_id');
			$this->CI->db->where('at.tag',$tag);
		}
		if ($school_id)	$this->CI->db->where('m.school_id',$school_id);
		if ($member_type)	$this->CI->db->where('m.member_type',$member_type);	

		if ($is_open) 	$this->CI->db->where('a.apply_end_time >=',date('Y-m-d'));
		if ($is_active)	$this->CI->db->where('a.end_time >=',date('Y-m-d'));
		if ($is_following) 	$this->CI->db->where('af.member_id',$this->CI->current_member_id);
		if ($is_attending) 	$this->CI->db->where('am.member_id',$this->CI->current_member_id);
		
		if ($apply_start_time)	$this->CI->db->where('a.apply_start_time >=',$apply_start_time);
		if ($apply_end_time)	$this->CI->db->where('a.apply_end_time <=',$apply_end_time);
		if ($start_time) 		$this->CI->db->where('a.start_time >=',$start_time);
		if ($end_time) 			$this->CI->db->where('a.end_time <=',$end_time);
		
		$this->CI->db->group_by('a.activity_id');
		$this->CI->db->order_by('a.activity_id','DESC');
		return $this->CI->db->get('',$limit,$offset)->result_array();
	}

	/**
	* 返回搜索结果总数
	*/
	function searchActivityCount( 
		$activity_name = null, 
		$school_id = null, 
		$publisher_id = null, 
		$member_type = null,
		$tag = null, 
		$is_open = null,
		$is_active = null,
		$is_following = null,
		$is_attending = null,
		$apply_start_time = null, 
		$apply_end_time = null, 
		$start_time = null, 
		$end_time = null ) {
		$this->CI->db->select('count(a.activity_id) as count');
		$this->CI->db->from('activity as a');
		$this->CI->db->join('member as m','a.publisher_id = m.member_id','left');
		$this->CI->db->join('activity_attend as am','am.activity_id = a.activity_id','left');
		$this->CI->db->join('activity_follow as af','af.activity_id = a.activity_id','left');
		
		if ($activity_name!='') $this->CI->db->like('a.name',$activity_name);
		if ($publisher_id)	$this->CI->db->where('a.publisher_id',$publisher_id);	

		if ($tag) {
			$this->CI->db->join('activity_tag as at','a.activity_id = at.activity_id');
			$this->CI->db->where('at.tag',$tag);
		}
		if ($school_id)	$this->CI->db->where('m.school_id',$school_id);
		if ($member_type)	$this->CI->db->where('m.member_type',$member_type);	

		if ($is_open) 	$this->CI->db->where('a.apply_end_time >=',date('Y-m-d'));
		if ($is_active)	$this->CI->db->where('a.end_time >=',date('Y-m-d'));
		if ($is_following) 	$this->CI->db->where('af.member_id',$this->CI->current_member_id);
		if ($is_attending) 	$this->CI->db->where('am.member_id',$this->CI->current_member_id);
		
		if ($apply_start_time)	$this->CI->db->where('a.apply_start_time >=',$apply_start_time);
		if ($apply_end_time)	$this->CI->db->where('a.apply_end_time <=',$apply_end_time);
		if ($start_time) 		$this->CI->db->where('a.start_time >=',$start_time);
		if ($end_time) 			$this->CI->db->where('a.end_time <=',$end_time);
		
		return idx($this->CI->db->get_first(),'count');
	}

/*
 *---------------------------------------------------------------
 * uncat
 *---------------------------------------------------------------
 */
	
	function getMemberVisitInformation($member_id,$limit = 5){
		$this->CI->db->select(MEMBER_BRIEF.', mv.visit_time');
		$this->CI->db->from('member_visit as mv');
		$this->CI->db->join('member as m','mv.visitor_id = m.member_id');
		$this->CI->db->where('mv.member_id',$member_id);
		$this->CI->db->limit($limit);
		$this->CI->db->order_by('mv.visit_time','DESC');
		
		return $this->CI->db->get()->result_array();
	}
	
	
	function countNewActivity(){
		$this->CI->db->select('count(a.activity_id) as count');
		$this->CI->db->from('activity as a');
		$this->CI->db->where('date(a.end_time) >=',$this->CI->current_date);
		
		return idx($this->CI->db->get_first(),'count');
	}
	
	function countAllActivityComment($activity_id){
		$this->CI->db->select('count(ac.activity_comment_id) as count');
		$this->CI->db->from('activity_comment as ac');
		$this->CI->db->join('member as m','ac.member_id = m.member_id');
		$this->CI->db->where('ac.activity_id',$activity_id);
		
		$count = idx($this->CI->db->get_first(),'count');
		
		return $count;
	
	}
	
		
	function getNewBlogInformation(){
		$follow_member_list = $this->getFollowMemberList($this->CI->current_member_id,'array');
	
		$this->CI->db->select('mb.book_id, mb.name as book_name, left(mb.content,150) as book_description, mb.created_time, mb.modified_time, mbc.name as book_class_name, m.member_id, m.name as member_name, m.image as member_image',false);
		$this->CI->db->from('book as mb');
		$this->CI->db->join('book_class as mbc','mb.book_class_id = mbc.book_class_id','LEFT');
		$this->CI->db->join('member as m','mb.author_id = m.member_id');
		$this->CI->db->where_in('mb.author_id',$follow_member_list);
		$this->CI->db->order_by('mb.created_time','DESC',false);
		$all_book_information = $this->CI->db->get()->result_array();
		
		return $all_book_information;
	}
	
	function countMemberBlog($member_id){
		$this->CI->db->select('count(mb.book_id) as count');
		$this->CI->db->from('book as mb');
		$this->CI->db->join('member as m','mb.author_id = m.member_id');
		$this->CI->db->where('mb.author_id',$member_id);
		
		$result = idx($this->CI->db->get_first(),'count');
		
		return $result;
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
		
	function countMemberMessageGroups($target_id){
		$this->CI->db->select('count(DISTINCT(`group`)) as count');
		$this->CI->db->from('member_message');
		$this->CI->db->where('member_id',$target_id);
		$this->CI->db->or_where('target_id',$target_id);
		$result = idx($this->CI->db->get_first(),'count');
		
		return $result;
	}
	
	//rewrite needed
	function getAllMemberMessageInformationGroups($member_id,$page_offset = 0, $limit = 999){
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
		$friend = $this->CI->db->get()->result_array();
		
		//category == 'activity'
		$this->CI->db->select('sm.system_message_id, sm.category, sm.type, sm.code, sm.created_time, sm.status, sm.is_new, m.member_id, m.name as member_name, m.image as member_image, t.member_id as target_id, t.name as target_name, t.image as target_image, a.activity_id, a.name as activity_name, a.image as activity_image');
		$this->CI->db->from('system_message as sm');
		$this->CI->db->join('member as m','m.member_id = sm.member_id');
		$this->CI->db->join('member as t','t.member_id = sm.target_id');
		$this->CI->db->join('activity as a','a.activity_id = sm.code');
		$this->CI->db->where('sm.target_id',$member_id);
		$this->CI->db->where('sm.category','activity');
		$this->CI->db->where('sm.status','Y');
		$activity = $this->CI->db->get()->result_array();
		
		//category == 'blog'
		$this->CI->db->select('sm.system_message_id, sm.category, sm.type, sm.created_time, sm.status, sm.is_new, ,m.member_id, m.name as member_name, m.image as member_image, mb.book_id, mb.name as book_name');
		$this->CI->db->from('system_message as sm');
		$this->CI->db->join('member as m','m.member_id = sm.member_id');
		$this->CI->db->join('book as mb','mb.book_id = sm.code');
		$this->CI->db->where('sm.target_id',$member_id);
		$this->CI->db->where('sm.category','blog');
		$this->CI->db->where('sm.status','Y');
		$book = $this->CI->db->get()->result_array();
		
		$all_system_message_information['friend'] = $friend;
		$all_system_message_information['activity'] = $activity;
		$all_system_message_information['book'] = $book;

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
		
		$this->CI->db->select('mm.member_message_id, mm.content, mm.created_time, mm.member_id, mm.target_id');
		$this->CI->db->from('member_message as mm');
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
	
	

	/**
	* 按类别随机展示会员
	*
	* @param 	string 	$member_type 	查询的会员类型
	* @param 	int 	$limit 			返回数量
	*/
	function randomMemberByType($member_type,$limit=10) {
		$this->CI->db->where('member_type',$member_type);
		$this->CI->db->order_by('member_id',random);
		$this->CI->db->limit($limit);

		return $this->CI->db->get()->result_array();
	}
	
	function getMemberInformationBySchoolId($school_id,$member_type){
		$this->CI->db->select('member_id, name as member_name, member_type, image as member_image');
		$this->CI->db->from('member');
		$this->CI->db->where('school_id',$school_id);
		$this->CI->db->where('member_type',$member_type);
		$all_member_information = $this->CI->db->get()->result_array();
		
		return $all_member_information;
		
	}
	
	
	function getHotActivityTag($page_offset = 0, $limit = NULL){
		$this->CI->db->select('tag, count(activity_tag_id) as tag_count');
		$this->CI->db->from('activity_tag');
		$this->CI->db->group_by('tag');
		$this->CI->db->order_by('tag_count','DESC');
		$all_hot_activity_tag = $this->CI->db->get('',$limit,$page_offset)->result_array();
		
		return $all_hot_activity_tag;
		
	}
	
	
	
}

?>
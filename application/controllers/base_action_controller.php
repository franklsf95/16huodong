<?phpinclude_once "base_controller.php";Class BaseActionController extends BaseController {		var $applicationFolder;	var $article_options = array();	var $product_options = array();	var $current_member_information = array();	var $current_member_id;		function __construct() {		parent::__construct();				if ($this->enable_session) {		//启用session			@session_start();		}		$this->load->model('db_running_value');		$this->ci_smarty->assign('lang','chs');				$this->initialize_running_value();		$this->initialize_check_login();				if ($this->current_member_information) {			$this->initialize_get_member_information();		}			}		function initialize_running_value(){				//拿取站点参数				//站点状态		$site_status = $this->db_running_value->get_running_value('site_status');		$site_name = $this->db_running_value->get_running_value('site_name');		$site_keyword = $this->db_running_value->get_running_value('site_keyword');		$site_description = $this->db_running_value->get_running_value('site_description');		$site_copyright = $this->db_running_value->get_running_value('site_copyright');				if ($site_status['value'] == 'N'){			show_error("站点状态不可用，请联系管理员");		}				$this->ci_smarty->assign('site_name',$site_name['value']);		$this->ci_smarty->assign('site_keyword',$site_keyword['value']);		$this->ci_smarty->assign('site_description',$site_description['value']);		$this->ci_smarty->assign('site_copyright',$site_copyright['value']);	}			function initialize_check_login(){		//print_r($_COOKIE);		//exit();		if($current_member_information = $this->getSessionValue(current_member_information)) {			$this->current_member_information = $current_member_information;			$this->current_member_id = $current_member_information['member_id'];			$this->ci_smarty->assign('current_member_information',$current_member_information);			$this->ci_smarty->assign('current_member_id',$current_member_information['member_id']);		} elseif($_COOKIE['member_cookie']){			//print_r($_COOKIE['member_cookie']);		//exit();			$this->db->select('member_id,account,password');			$this->db->from('member');			$this->db->where('account',$_COOKIE['member_cookie']['account']);			$cookie_member_information = $this->db->get_first();						if ($cookie_member_information) {				if($_COOKIE['member_cookie']['key'] == md5($cookie_member_information['password'].$cookie_member_information['password'])) {					$this->db->select('m.member_id, m.account, m.member_type, m.member_type_2, m.status as member_status, m.image as member_image, m.name as member_name, m.principal, m.gender, m.birthday, m.hobby, m.qq, m.mobilephone, m.phone, m.email, m.address, m.tag, m.description, m.content, m.created_time, m.modified_time, m.current_school, ps.name as current_school_name');					$this->db->from('member as m');					$this->db->join('public_school as ps','ps.school_id = m.current_school','LEFT');					$this->db->where('member_id',$cookie_member_information['member_id']);					$member_information = $this->db->get_first();					$this->setSessionValue('current_member_information',$member_information);					redirect('index');				} else {					$this->forward('../welcome/index');				}			}else {				$this->forward('../welcome/index');			}		} else {			$this->forward('../welcome/index');		}	}		/*--------------------------------------------------	#获取全站初始信息	#会员粉丝列表、会员关注列表、	---------------------------------------------------*/	function initialize_get_member_information(){		$all_member_friend_information = $this->get_all_member_friend_information($this->current_member_id);		$all_system_message_count = $this->extend_control->getNewSystemMessage($this->current_member_id);				//print_r($all_system_message_count);				$this->current_member_information['all_member_friend_information'] = $all_member_friend_information;		//$this->current_member_information['member_fans_information'] = $member_fans_information;		//$this->current_member_information['member_follow_information'] = $member_follow_information;		$this->ci_smarty->assign('all_system_message_count',$all_system_message_count);	}			function get_all_member_friend_information($member_id){		$this->db->select('m.member_id, m.name as member_name, m.image as member_image');		$this->db->from('member_friend as mf');		$this->db->join('member as m','mf.target_id = m.member_id');		$this->db->where('mf.member_id',$member_id);		$this->db->where('mf.status','Y');		$all_member_friend_information = $this->db->get()->result_array();		return $all_member_friend_information;		}			/*--------------------------------------------------	#系统通知推送	#	---------------------------------------------------*/	function system_message($data){			$data['created_time'] = $this->current_time;		$data['member_id'] = $this->current_member_id;				$check_data = array('member_id'		=>	$data['member_id'],							'category'		=>	$data['category'],							'type'			=>	$data['type'],							'code'			=>	$data['code']							);				if ($data['type'] == 'publish_activity' && 1 == 0) {	//发布了一个活动就通知所有的好友			foreach ($this->current_member_information['all_member_friend_information'] as $member_information) {				$data['member_id'] = $this->current_member_id;				$data['target_id'] = $member_information['member_id'];								$check_data['target_id'] = $member_information['member_id'];								if ($this->check_system_message($check_data)) {					$this->db->insert('system_message',$data);				}			}		} elseif ($data['type'] == 'edit_activity') {	//修改了活动就通知所有参加的人			$activity_id = $data['code'];			$all_member_information = $this->extend_control->getAttendActivityMemberInformation($data['code']);						foreach ($all_member_information as $member_information) {							$data['target_id'] = $member_information['member_id'];								$check_data['target_id'] = $member_information['member_id'];								if ($this->check_system_message($check_data)) {					$this->db->insert('system_message',$data);				}			}		} elseif($data['category'] == 'activity' && $data['type'] == 'new_comment') {				//活动有新的评论						//重置member_id与target_id			$member_id = $data['target_id'];			$target_id = $data['member_id'];						$data['member_id'] = $target_id;			$data['target_id'] = $member_id;						$check_data['member_id'] = $data['member_id'];			$check_data['target_id'] = $data['target_id'];						if ($this->check_system_message($check_data)) {					$this->db->insert('system_message',$data);			}								}elseif($data['category'] == 'activity' && $data['type'] == 'new_reply'){				//活动评论有新的回复						$check_data['target_id'] = $data['target_id'];						if ($this->check_system_message($check_data)) {					$this->db->insert('system_message',$data);			}					}elseif($data['category'] == 'activity' && $data['type'] == 'attend_activity'){				//新的活动申请						$check_data['target_id'] = $data['target_id'];						if ($this->check_system_message($check_data)) {					$this->db->insert('system_message',$data);			}					}elseif($data['category'] == 'activity' && $data['type'] == 'activity_apply_pass'){				//通过活动申请						$check_data['target_id'] = $data['target_id'];						if ($this->check_system_message($check_data)) {					$this->db->insert('system_message',$data);			}					}elseif ($data['type'] == 'invite_attend_activity'){									//邀请活动					$check_data['target_id'] = $data['target_id'];							if ($this->check_system_message($check_data)) {				$this->db->insert('system_message',$data);			}							} elseif ($data['category'] == 'friend' && $data['type'] == 'apply_friend') {											//好友申请			$check_data['target_id'] = $data['target_id'];			if ($this->check_system_message($check_data)) {				$this->db->insert('system_message',$data);			}		} elseif ($data['type'] == 'add_friend'){												//添加好友			$check_data['target_id'] = $data['target_id'];			if ($this->check_system_message($check_data)) {				$this->db->insert('system_message',$data);			}		}elseif ($data['category'] == 'member_message' && $data['type'] == 'new_message') {											//新的会员短消息						$check_data['target_id'] = $data['target_id'];			if ($this->check_system_message($check_data)) {				$this->db->insert('system_message',$data);			}					}elseif ($data['category'] == 'blog' && $data['type'] == 'new_comment') {											//						$check_data['target_id'] = $data['target_id'];			if ($this->check_system_message($check_data)) {				$this->db->insert('system_message',$data);			}					}		}		function check_system_message($check_data){			//检查是否有相同的系统消息存在				if($check_data['member_id'] != $check_data['target_id']) {			$this->db->where($check_data);			$count = $this->db->count_all_results('system_message');			if ($count > 0) {				return false;			}else {				return true;			}		}else {			return false;		}	}			function addActivityMemberVisit($activity_id){		$member_id = $this->current_member_id;		$this->db->where('activity_id',$activity_id);		$this->db->where('member_id',$member_id);				$data['visited_time'] = $this->current_time;		if ($this->db->count_all_results('activity_visit') > 0) {			$this->db->where('activity_id',$activity_id);			$this->db->where('member_id',$member_id);			$this->db->update('activity_visit',$data);		}else {			$data['activity_id'] = $activity_id;			$data['member_id'] = $member_id;			$this->db->insert('activity_visit',$data);					}	}		function addMemberBlogVisit($member_blog_id){		$member_id = $this->current_member_id;		$this->db->where('member_blog_id',$member_blog_id);		$this->db->where('member_id',$member_id);				$data['visited_time'] = $this->current_time;		if ($this->db->count_all_results('member_blog_visit') > 0) {			$this->db->where('member_blog_id',$member_blog_id);			$this->db->where('member_id',$member_id);			$this->db->update('member_blog_visit',$data);		}else {			$data['member_blog_id'] = $member_blog_id;			$data['member_id'] = $member_id;			$this->db->insert('member_blog_visit',$data);		}	}		function display( $templateName, $templateTitle ) {		parent::display( $templateName, $templateTitle, 'member' );	}}?>
<?phpinclude_once "base_controller.php";Class BaseActionController extends BaseController {		var $applicationFolder;	var $article_options = array();	var $product_options = array();	var $current_member_information = array();	var $current_member_id;		function __construct() {		parent::__construct();				if ($this->enable_session) {		//启用session			@session_start();		}		$this->load->model('db_running_value');		$this->ci_smarty->assign('lang','chs'); //设置smarty语言				$this->initialize_running_value();		$this->initialize_member_login();		$this->initialize_member_information();	}		/**	* 获取全站运行参数	*/	function initialize_running_value(){		$site_status = $this->db_running_value->get_running_value('site_status');		$site_name = $this->db_running_value->get_running_value('site_name');		$site_keyword = $this->db_running_value->get_running_value('site_keyword');		$site_description = $this->db_running_value->get_running_value('site_description');		$site_copyright = $this->db_running_value->get_running_value('site_copyright');				if ($site_status['value'] == 'N'){			show_error("Site is down.");		}				$this->ci_smarty->assign('site_name',$site_name['value']);		$this->ci_smarty->assign('site_keyword',$site_keyword['value']);		$this->ci_smarty->assign('site_description',$site_description['value']);		$this->ci_smarty->assign('site_copyright',$site_copyright['value']);	}		/**	* 检查用户登录	*/	function initialize_member_login(){		//print_r($_COOKIE);exit();		$cmid = $this->getSessionValue('current_member_id');				if( $cmid ) {			$this->current_member_id = $cmid;			$this->extend_control->setCurrentMemberInformation();		} elseif($_COOKIE['member_cookie']) {			//print_r($_COOKIE['member_cookie']);exit();			$this->db->select('member_id,password');			$this->db->from('member');			$this->db->where('account',$_COOKIE['member_cookie']['account']);			$login_information = $this->db->get_first();						if ( !$login_information ) redirect('welcome');			if ($_COOKIE['member_cookie']['key'] != md5($login_information['password'].$login_information['password']) )				redirect('welcome');			$this->extend_control->setCurrentMemberInformation();			redirect('index');		} else {			if(substr_count(current_url(),'welcome')==0){				redirect('welcome?ref='.rawurlencode(current_url()));			}else{				redirect('welcome');			}		}	}		/**	* 初始化好友信息、系统消息	*	* @return smarty 	$all_system_message_count	*/	function initialize_member_information(){		//get all member friends		$this->db->select('m.member_id, m.name as member_name, m.image as member_image');		$this->db->from('member_friend as mf');		$this->db->join('member as m','mf.target_id = m.member_id');		$this->db->where('mf.member_id',$this->current_member_id);		$this->db->where('approved',true);		$all_member_friend_information = $this->db->get()->result_array();		$all_system_message_notice = $this->extend_control->getNewSystemMessageCategories($this->current_member_id);		//print_r($all_system_message_notice);exit();		$this->current_member_information['all_member_friend_information'] = $all_member_friend_information;		$this->ci_smarty->assign('all_system_message_notice',$all_system_message_notice);	}		/**	* 工具函数：发送系统消息	*/	function system_message($data){			$data['created_time'] = $this->current_time;		$data['member_id'] = $this->current_member_id;				$check_data = array('member_id'		=>	$data['member_id'],							'category'		=>	$data['category'],							'type'			=>	$data['type'],							'code'			=>	$data['code']							);				if ($data['type'] == 'publish_activity' && 1 == 0) {	//发布了一个活动就通知所有的好友			foreach ($this->current_member_information['all_member_friend_information'] as $member_information) {				$data['member_id'] = $this->current_member_id;				$data['target_id'] = $member_information['member_id'];								$check_data['target_id'] = $member_information['member_id'];								if ($this->checkSystemMessageByData($check_data)) {					$this->db->insert('system_message',$data);				}			}		} elseif ($data['type'] == 'edit_activity') {	//修改了活动就通知所有参加的人			$activity_id = $data['code'];			$all_member_information = $this->extend_control->getAttendActivityMemberInformation($data['code']);						foreach ($all_member_information as $member_information) {							$data['target_id'] = $member_information['member_id'];								$check_data['target_id'] = $member_information['member_id'];								if ($this->checkSystemMessageByData($check_data)) {					$this->db->insert('system_message',$data);				}			}		} elseif($data['category'] == 'activity' && $data['type'] == 'new_comment') {			//活动有新的评论						//重置member_id与target_id			$member_id = $data['target_id'];			$target_id = $data['member_id'];						$data['member_id'] = $target_id;			$data['target_id'] = $member_id;						$check_data['member_id'] = $data['member_id'];			$check_data['target_id'] = $data['target_id'];						if ($this->checkSystemMessageByData($check_data)) {					$this->db->insert('system_message',$data);			}								}elseif($data['category'] == 'activity' && $data['type'] == 'new_reply'){				//活动评论有新的回复						$check_data['target_id'] = $data['target_id'];						if ($this->checkSystemMessageByData($check_data)) {					$this->db->insert('system_message',$data);			}					}elseif($data['category'] == 'activity' && $data['type'] == 'attend_activity'){				//新的活动申请						$check_data['target_id'] = $data['target_id'];						if ($this->checkSystemMessageByData($check_data)) {					$this->db->insert('system_message',$data);			}					}elseif($data['category'] == 'activity' && $data['type'] == 'activity_apply_pass'){				//通过活动申请						$check_data['target_id'] = $data['target_id'];						if ($this->checkSystemMessageByData($check_data)) {					$this->db->insert('system_message',$data);			}					}elseif ($data['type'] == 'invite_attend_activity'){									//邀请活动					$check_data['target_id'] = $data['target_id'];							if ($this->checkSystemMessageByData($check_data)) {				$this->db->insert('system_message',$data);			}							} elseif ($data['category'] == 'friend' && $data['type'] == 'apply_friend') {											//好友申请			$check_data['target_id'] = $data['target_id'];			if ($this->checkSystemMessageByData($check_data)) {				$this->db->insert('system_message',$data);			}		} elseif ($data['type'] == 'add_friend'){												//添加好友			$check_data['target_id'] = $data['target_id'];			if ($this->checkSystemMessageByData($check_data)) {				$this->db->insert('system_message',$data);			}		}elseif ($data['category'] == 'member_message' && $data['type'] == 'new_message') {											//新的会员短消息			$check_data['target_id'] = $data['target_id'];			if ($this->checkSystemMessageByType($check_data)) {				$this->db->insert('system_message',$data);			} else {				$data['is_new']='Y';				$this->db->where('member_id',$data['member_id']);				$this->db->where('target_id',$data['target_id']);				$this->db->where('category',$data['category']);				$this->db->where('type',$data['type']);				$this->db->update('system_message',$data);			}		}elseif ($data['category'] == 'blog' && $data['type'] == 'new_comment') {											//						$check_data['target_id'] = $data['target_id'];			if ($this->checkSystemMessageByData($check_data)) {				$this->db->insert('system_message',$data);			}					}		}		/**	* 工具函数：检查是否存在完全相同的系统消息	*	* @return 	false=有重复 	true=无重复	*/	function checkSystemMessageByData($check_data) {		if( $check_data['member_id'] == $check_data['target_id'] ) return false; //invalid		$this->db->where($check_data);		$count = $this->db->count_all_results('system_message');		return $count>0 ? false : true;	}		/**	* 工具函数：检查是否存在相同类型的系统消息	*	* @return 	false=有重复 	true=无重复	*/	function checkSystemMessageByType($check_data){		if($check_data['member_id'] == $check_data['target_id']) return false;		$this->db->where('member_id',$check_data['member_id']);		$this->db->where('target_id',$check_data['target_id']);		$this->db->where('category',$check_data['category']);		$this->db->where('type',$check_data['type']);		$count = $this->db->count_all_results('system_message');		return $count>0 ? false : true;	}		/**	* 显示页面	*	* @author franklsf95	*	* @see BaseController::display()	*/	function display( $templateName, $templateTitle, $moreCss='', $moreJs='' ) {		$templateTitle .= ' | '.$this->current_member_information['member_name'];		parent::display( $templateName, $templateTitle, $moreCss, $moreJs, 'member' );	}}?>
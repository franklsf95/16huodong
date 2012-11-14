<?phpinclude_once "base_controller.php";Class BaseActionController extends BaseController {		var $applicationFolder;	var $article_options = array();	var $product_options = array();	var $current_member_information = array();	var $current_member_id;		function __construct() {		parent::__construct();				$this->ci_smarty->assign('lang','chs'); //设置smarty语言				$this->initialize_member_login();				//initialize system message notices		$all_system_message_notice = $this->extend_control->getNewSystemMessageCategories($this->current_member_id);		//print_r($all_system_message_notice);exit();		$this->ci_smarty->assign('all_system_message_notice',$all_system_message_notice);	}		/**	* 检查用户登录	*/	function initialize_member_login(){		//print_r($_COOKIE);exit();		$cmid = $this->getSessionValue('current_member_id');				if( $cmid ) {			$this->current_member_id = $cmid;			$this->extend_control->setCurrentMemberInformation();		} elseif($_COOKIE['member_cookie']) {			//print_r($_COOKIE['member_cookie']);exit();			$this->db->select('member_id,password');			$this->db->from('member');			$this->db->where('account',$_COOKIE['member_cookie']['account']);			$login_information = $this->db->get_first();						if ( !$login_information ) redirect('welcome');			if ($_COOKIE['member_cookie']['key'] != md5($login_information['password'].$login_information['password']) )				redirect('welcome');			$this->extend_control->setCurrentMemberInformation();			redirect('index');		} else {			if(substr_count(current_url(),'welcome')==0&&strrchr(current_url(),"index.php")!="index.php"&&strrchr(current_url(),"index.php/")!="index.php/"){				redirect('welcome?ref='.rawurlencode(current_url()));			}else{				redirect('welcome');			}		}	}		/**	* 发送系统消息、更新首页动态	*	* @param 	$category 		大类：activity/blog/friend/message	* @param 	$type			消息类别（细类）	* @param 	$code			必要参数	* @param 	$target 		对方ID（可选）	*	*/	function newSystemMessage($category, $type, $code, $target=null, $from=null) {		$data['created_time'] = $this->current_time;		if ($from==null)			$data['member_id'] = $this->current_member_id;		else			$data['member_id'] = $from;		$data['target_id'] = $target;		$data['category']  = $category;		$data['type']      = $type;		$data['code']      = $code;		switch( $type ) {			//发布活动或写新书后通知全部好友			case 'new_activity':			case 'new_book':				$friend_list = $this->extend_control->getAllFriendsBasic( $this->current_member_id );								foreach ($friend_list as $i) {					$data['target_id'] = $i['member_id'];					$this->sendSystemMessage($data);				}				$this->sendToNewsFeed($data);				break;			//修改活动内容后通知所有attend member			case 'edit_activity':				$attend_list = $this->extend_control->getActivityAttendMemberId($data['code']);				foreach ($attend_list as $i) {					$data['target_id'] = $i['member_id'];					$this->sendSystemMessage($data);				}				$this->sendToNewsFeed($data);				break;			//活动、微型书新评论：通知发起人/作者			case 'new_comment':			//publisher回复评论：通知原作者			case 'new_reply':			//活动报名通过：通知用户			case 'attend_approve':			//好友申请			case 'apply_friend':			//活动评价提醒			case 'rate_request':			//好友申请通过			case 'approve_friend':				$this->sendSystemMessage($data);				break;			//活动报名：通知publisher			case 'attend_activity':				$this->sendSystemMessage($data);				$this->sendToNewsFeed($data);				break;			//邀请好友参加活动			case 'invite_attend_activity':				break;			//好友新留言			case 'new_message':				if( $this->checkMemberMessage($data) )					$this->db->insert('system_message',$data);				else {					$data['is_new']='Y';					$this->db->where('member_id',$data['member_id']);					$this->db->where('target_id',$data['target_id']);					$this->db->where('category',$data['category']);					$this->db->where('type',$data['type']);					$this->db->update('system_message',$data);				}				break;		} //end switch	}	function newNewsFeed($category, $type, $code) {		$data['created_time'] = $this->current_time;		$data['member_id'] = $this->current_member_id;		$data['type']      = $type;		if( $category=='activity' )			$data['activity_id'] = $code;		elseif( $category=='book' )			$data['book_id'] = $code;		$this->sendToNewsFeed($data);	}		/**	* 发送系统消息最后检查	*/	function sendSystemMessage($data) {		if( $data['member_id'] == $data['target_id'] ) return false;		$this->db->insert('system_message',$data);	}	/**	* 同时抄送给首页	*/	function sendToNewsFeed($data) {		if( $data['category']=='activity' )			$data['activity_id'] = $data['code'];		elseif( $data['category']=='book' )			$data['book_id'] = $data['code'];		unset( $data['category'] );		unset( $data['code'] );		unset( $data['target_id'] );		$this->db->insert('news_feed',$data);	}	/**	* 工具函数：检查是否存在相同的好友消息提醒	*	* @return 	false=有重复 	true=无重复	*/	function checkMemberMessage($check_data){		if($check_data['member_id'] == $check_data['target_id']) return false;		$this->db->where('member_id',$check_data['member_id']);		$this->db->where('target_id',$check_data['target_id']);		$this->db->where('category',$check_data['category']);		$this->db->where('type',$check_data['type']);		$count = $this->db->count_all_results('system_message');		return $count>0 ? false : true;	}		/**	* 显示页面	*	* @author franklsf95	*	* @see BaseController::display()	*/	function display( $templateName, $templateTitle, $moreCss='', $moreJs='' ) {		$templateTitle .= ' | '.$this->current_member_information['member_name'];		parent::display( $templateName, $templateTitle, $moreCss, $moreJs, 'member' );	}}?>
<?php
include_once "base_action_controller.php";
Class SendMail Extends BaseActionController {

	var $current_language = 'chs';
	var $applicationFolder = "sendmail"; 
	function __construct() {
		parent::__construct();
	}
	
	function index(){
		$this->load->library('email');
		$this->db->select('member_id, email');
		$this->db->from('member');
		$this->db->where('accept_notification',1);
		$all_member_information = $this->db->get('')->result_array();
		foreach ($all_member_information as $member_information){
			$mail='';
			$this->db->select('activity_id');
			$this->db->from('activity_attend');
			$this->db->where('member_id',$member_information['member_id']);
			$this->db->where('notified',0);
			$this->db->where('approved',1);
			$all_attend_information = $this->db->get('')->result_array();
			foreach ($all_attend_information as $attendance){
				$this->db->select('a.activity_id, a.name as activity_name, a.start_time, a.end_time');
				$this->db->from('activity as a');
				$this->db->where('activity_id',$attendance['activity_id']);
				$this->db->where('date(a.start_time) >=',date('y-m-d',time()));
				$this->db->where('date(a.start_time) <=',date('y-m-d',time()+(24*60*60*1)));
				$activity_information = $this->db->get_first();
				if ($activity_information) {
					$mail.='您报名的活动<a href="http://'.$_SERVER ['HTTP_HOST'].'/index.php/activity/view?id='. $activity_information['activity_id']
					.'">'.$activity_information['activity_name'].'</a>将于'.$activity_information['start_time'].'开始<br/>';
					$attendance['notified']=1;
					$this->db->where('member_id',$member_information['member_id']);
					$this->db->where('activity_id',$attendance['activity_id']);
					$this->db->update('activity_attend',$attendance);
				}
			}
			if ($mail != '') {
				$mail='<html><body>'.$mail.'</body></html>';
				$to = $member_information['email'];
				$subject = "【活动提醒】16活动网";
				$config =& get_config();
				$this->email->initialize($config);
				$this->email->from('webmaster@16huodong.com', '石榴');
				$this->email->to($to);     
				$this->email->subject($subject);
				$this->email->message($mail); 
				$this->email->send();
				echo('message sent to #'.$member_information['member_id']);
			}
		}
		
		
		$this->db->select('member_id, email, accept_notification');
		$this->db->from('member');
		$all_member_information = $this->db->get('')->result_array();
		foreach ($all_member_information as $member_information){
			$mail='';
			$this->db->select('activity_id');
			$this->db->from('activity_attend');
			$this->db->where('member_id',$member_information['member_id']);
			$this->db->where('notified !=',2);
			$this->db->where('approved',1);
			$all_attend_information = $this->db->get('')->result_array();
			foreach ($all_attend_information as $attendance){
				$this->db->select('a.activity_id, a.name as activity_name, a.end_time');
				$this->db->from('activity as a');
				$this->db->where('activity_id',$attendance['activity_id']);
				$this->db->where('date(a.end_time) <=',date('y-m-d',time()));
				$activity_information = $this->db->get_first();
				if ($activity_information) {
					$mail.='您参加的活动<a href="http://'.$_SERVER ['HTTP_HOST'].'/index.php/activity/view?id='. $activity_information['activity_id']
					.'">'.$activity_information['activity_name'].'</a>请您去打分哦<br/>';
					$attendance['notified']=2;
					$this->db->where('member_id',$member_information['member_id']);
					$this->db->where('activity_id',$attendance['activity_id']);
					$this->db->update('activity_attend',$attendance);
				}
			}
			if ($mail != ''&&$member_information['accept_notification']==1) {
				$mail='<html><body>'.$mail.'</body></html>';
				$to = $member_information['email'];
				$subject = "【活动评价】16活动网";
				$config =& get_config();
				$this->email->initialize($config);
				$this->email->from('webmaster@16huodong.com', '石榴');
				$this->email->to($to);     
				$this->email->subject($subject);
				$this->email->message($mail); 
				$this->email->send();
				echo('message sent to #'.$member_information['member_id']);
			}
		}
	}
	
	
}



?>
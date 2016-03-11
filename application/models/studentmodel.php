<?php
class Studentmodel extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->database();
		$ci = get_instance();
		$ci->load->helper('string');
    }
	
	
	//upload profile pic : Done
	function updateProfilePic($appl_code, $img_name) {
		$c_tbl = 'bed_application';
		$modified_on = gmdate('Y-m-d H:i:s');
		$modified_by = (isset($this->session->userdata['student']) ? 'student' : $this->session->userdata['user']['user_name']);
		
		$data = array(
				      'appl_profile_pic'	=>	$img_name
				    );
		$this->db->where('appl_code', $appl_code);					
		$status = $this->db->update($c_tbl, $data);
		$this->session->userdata['student']['student_pic'] = $img_name;
		
		//update the transaction history
		$event = "Profile picture uploaded";
		$this->createTransHistory($appl_code, $event, $modified_by, $modified_on);
		
		return $status;
	}
	
	//get details for reset password : Done
	function getApplBasicDetails() {
		$ar_tbl = 'bed_application';
		$m_tbl  = 'cnf_method';
		
		$this->db->select(array('appl_sl_no', 'appl_code', 'appl_name', 'appl_method_type', 'method_name', 'appl_gurd_name', 'appl_phone', 'appl_profile_pic', 'appl_status', 'appl_pmt_code', 'appl_pmt_type', 'appl_verified_on' , 'appl_verified_by'));
		$this->db->from($ar_tbl);
		$this->db->join($m_tbl, 'method_code = appl_method_type');
		
		if($this->input->post('appl_code') != null && $this->input->post('appl_code') != ''){
			$this->db->like('LOWER(appl_code)', trim(strtolower($this->input->post('appl_code'))));			
		}
		
		if($this->input->post('appl_phone') != null && $this->input->post('appl_phone') != ''){
			$this->db->like('appl_phone', trim($this->input->post('appl_phone')));			
		}
		
		if($this->input->post('appl_name') != null && $this->input->post('appl_name') != ''){
			$this->db->like('LOWER(appl_name)', trim(strtolower($this->input->post('appl_name'))), 'both');			
		}
		if($this->input->post('user_action') == 'payment' && $this->session->userdata['user']['user_role'] == "Verifier"){
			$this->db->like('appl_verified_by', $this->session->userdata['user']['user_name']);	
		}
		
		$query = $this->db->get();
		$r = $query->result();
		
		$info = array();
		if(count($r) > 0) {
			for($i=0; $i<count($r); $i++){
					
				$full_name = '';
				if($full_name != 'System'){
					$full_name = $this->getFullNameByUseName($r[$i]->appl_verified_by);
				}
				
				$profile_pic_path = $this->config->base_url() . "upload/students/profile_pic/";
				$info[$i] = array(
								'appl_sl_no'		=>	$r[$i]->appl_sl_no,
								'appl_code'			=>	$r[$i]->appl_code,
								'appl_name'			=>	$r[$i]->appl_name,
								'appl_method_type'	=>	$r[$i]->appl_method_type,
								'method_name'		=>	$r[$i]->method_name,
								'appl_gurd_name'	=>	$r[$i]->appl_gurd_name,
								'appl_phone'		=>	$r[$i]->appl_phone,
								'appl_status'		=>	$r[$i]->appl_status,
								'appl_pmt_code'		=>	$r[$i]->appl_pmt_code,
								'appl_pmt_type'		=>	$r[$i]->appl_pmt_type,
								'appl_verified_by'	=>	$full_name,
								'appl_verified_on'	=>	getDateFormat($r[$i]->appl_verified_on),
								'appl_profile_pic'	=>	$profile_pic_path . (($r[$i]->appl_profile_pic != '') ? 't_' . $r[$i]->appl_profile_pic : 'no-profile-pic_90.png')
							);
			}			
		}
		//print_r($info); exit();				
		return $info;			
	}

	//update password : Done
	function updatePassword($appl_code, $new_passwd, $modified_by) {
		$c_tbl = 'bed_application';
		$modified_on = gmdate('Y-m-d H:i:s');

		$data = array(
				      'appl_passwd'	=>	strtoupper($new_passwd),
				      'appl_modifed_on'	=>	$modified_on,
				      'appl_modifed_by'	=>	$modified_by
				    );
		$this->db->where('appl_code', $appl_code);	
		if($modified_by == 'student') {
			$appl_code = $this->session->userdata['appl_code'];
		}		
		
		if(strlen($appl_code) == 9 && $appl_code != '0' && $appl_code != ""){
			$this->db->update($c_tbl, $data);
			//update the transaction history
			
			$event = "Password changed";
			$this->createTransHistory($appl_code, $event, $modified_by, $modified_on);
			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;		
		}else{
			return FALSE;
		}		
	}
		
	//get application status by application code: Done
	function getApplicationStatusByApplicationCode($appl_code){
		$sql = "SELECT appl_status FROM bed_application WHERE appl_code = '".$appl_code."'";
		$query = $this->db->query($sql);
		$results = $query->result();
		$pg_appl_status = "";
		if(count($results) > 0){
			$appl_status = $results[0]->appl_status;
		}
		return $appl_status;
	}
	
	//get user full name by user_name
	function getFullNameByUseName($user_name){
		$sql = "SELECT user_firstname, user_lastname FROM users WHERE user_name = '".$user_name."'";
		$query = $this->db->query($sql);
		$results = $query->result();
		$full_name = "";
		if(count($results) > 0){
			$full_name = getFullname($results[0]->user_firstname, '', $results[0]->user_lastname);
		}
		return $full_name;
	}
	
	
	//get students for notification by study center, subject count :X
	function getStudentsForNotificationCount($sql) {
		$results = $this->db->query($sql)->result();
		return count($results);
	}

	//get students for notification by study center, subject: X
	function getStudentsForNotification($cntr_code, $subj_code, $current_page = 1, $per_page = 50) {
		$ar_tbl = 'appl_register_tmp';
		$subj_tbl 	= 'cnf_subj';
		$cntr_tbl = 'cnf_cntr';
		$pmnt_tbl = 'appl_payments';
		
		$sql = "SELECT DISTINCT cntr_code, cntr_name, appl_subj_code, subj_name, 
					appl_form_num, appl_enrl_num, appl_fname, appl_mname, appl_lname, appl_father_name, appl_mobile_num, appl_status,
					pmnt_journal_num, pmnt_challan_date, pmnt_challan_amount
				FROM " . $ar_tbl . "
				JOIN " . $cntr_tbl . " ON cntr_code = appl_cntr_code
				JOIN " . $subj_tbl . " ON subj_code = appl_subj_code 
				LEFT OUTER JOIN " . $pmnt_tbl . " ON pmnt_challan_num = appl_form_num
				WHERE appl_id > 0 AND appl_status = 3";
		if($cntr_code != '00') {
			$sql .= " AND cntr_code = '" . $cntr_code . "'";
		}

		if($subj_code != '00') {
			$sql .= " AND subj_code = '" . $subj_code . "'";
		}

		//get data for pagination
		$total_results = $this->getStudentsForNotificationCount($sql);
		$total_pages = ceil($total_results / $per_page);
		$offset = ($current_page - 1) * $per_page;
		$paginate = array('total_records'	=>	$total_results,
						  'total_pages'		=>	$total_pages,
						  'per_page'		=>	$per_page,
						  'current_page'	=>	$current_page
						 );

		$sql .= " ORDER BY appl_form_num, appl_enrl_num, appl_fname, appl_lname";
		$sql .= " LIMIT " . $offset . ", " . $per_page;
	
		//echo $sql;
				
		$r = $this->db->query($sql)->result();
		$results = array();	
		
		for($i=0; $i<count($r); $i++) {
			$results[$i] = array(
									'cntr_code'				=>	$r[$i]->cntr_code,
									'cntr_name'				=>	$r[$i]->cntr_name,
									'appl_subj_code'		=>	$r[$i]->appl_subj_code,
									'subj_name'				=>	$r[$i]->subj_name,
									'appl_form_num'			=>	$r[$i]->appl_form_num,
									'appl_enrl_num'			=>	$r[$i]->appl_enrl_num,
									'appl_name'				=>	getFullname($r[$i]->appl_fname, $r[$i]->appl_mname, $r[$i]->appl_lname),
									'appl_father_name'		=>	$r[$i]->appl_father_name,
									'appl_mobile_num'		=>	$r[$i]->appl_mobile_num,
									'appl_status'			=>	getApplicationStatusText($r[$i]->appl_status),
									'pmnt_journal_num'		=>	($r[$i]->pmnt_journal_num == NULL) ? '' : $r[$i]->pmnt_journal_num,
									'pmnt_challan_date'		=>	getDateFormat($r[$i]->pmnt_challan_date),
									'pmnt_challan_amount'	=>	$r[$i]->pmnt_challan_amount
								);
		}	
		$students = array('students'	=>	$results, 'paginate'	=>	$paginate);
		return $students;	
	}		

	//check whether application exists for application code/ mobile number combination
	function isApplicationExistsForApplicationCodeMobileNumber($pg_appl_code, $pg_apl_mobile){
		$sql = "SELECT * FROM bed_application WHERE appl_code = '".$pg_appl_code."' AND appl_phone=".$pg_apl_mobile;
		$query = $this->db->query($sql);
		$results = $query->result();
		if(count($results) > 0){
			return true;
		}else{
			return false;			
		}
	}

	//send approval SMS notification : X
	function sendApprovalSMSNotification($appl_id) {
		$ar_tbl = 'appl_register_tmp';
		$this->db->select(array('appl_enrl_num', 'appl_mobile_num'), FALSE);
		$this->db->from($ar_tbl);
		$this->db->where('appl_id', $appl_id);
		$query = $this->db->get();
		$r = $query->row();
		
		$ph_num = $r->appl_mobile_num;
		$sms_msg = "Your application is verified and approved. Please note your permanent Enrolment Number: " . $r->appl_enrl_num;
		
		$this->sendSMSNotification($ph_num, $sms_msg);
	}
	
	//send SMS notification : X
	function sendSMSNotification($ph_nos, $sms_msg) {
		$sms_msg	=	str_replace(" ", "+", $sms_msg);
		
		$url		=	'http://sms99.co.in/pushsms.php';
		$curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $url . "?username=trbudedu&password=43185&sender=BUDEDU&message=" . $sms_msg . "&numbers=" . $ph_nos);
	    $output = curl_exec($curl);
	    curl_close ($curl);
		return TRUE;
	}

	//insert into transaction history:
	function createTransHistory($form_num, $event, $user, $date) {
		$ath_tbl = 'appl_trans_history';
		$data = array(
							'ath_form_num'		=>	$form_num,
				      		'ath_event'			=>	$event,
				      		'ath_event_by'		=>	$user,
				      		'ath_event_date'	=>	$date
					  );
		$status = $this->db->insert($ath_tbl, $data);	
	}
}	
?>	
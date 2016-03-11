<?php
class Admissionmodel extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->database();
		$this->load->model('usermodel');
    }
	
	//get date format for the dropdown
	function getDateFormatOption() {
		$arr = array("d-m-y"=>date("d-m-y"), "d-m-Y"=>date("d-m-Y"), "d-M-Y"=>date("d-M-Y"), 
					 "d-F-Y"=>date("d-F-Y"), "l, j F Y"=>date("l, j F Y"),
					 "m-d-Y"=>date("m-d-Y"), "F d, Y"=>date("F d, Y"),
					 "M d, Y h:i A"=>date("M d, Y h:i A"));
		return $arr;
	}	
	
	//get records per page for the dropdown
	function getRecordsPerPageOption() {
		$arr = array("5"=>"5", "10"=>"10", "25"=>"25", "50"=>"50", "100"=>"100");
		return $arr;
	}
	
	
	//get all Notice
	function getAllNotices($status=null) {
		$c_tbl = 'cnf_notice';
		$this->db->select(array('notice_id', 'notice_ctgry', 'notice_title', 'notice_desc', 'notice_file', 'notice_is_active'));
		$this->db->from($c_tbl);
		if($status){
			$this->db->where('notice_is_active', 1);
		}
		$this->db->order_by('notice_id', 'asc'); 
		$query = $this->db->get();
		$results = $query->result();
		
		$records = array();
		for($i=0; $i<count($results); $i++){
			$description = $results[$i]->notice_desc;
			
			$description = str_replace('"', '&quote;', $description);
			$description = str_replace('"', '&apos;', $description);
			
			$records[$i] = array(
							 'notice_id'     	=> $results[$i]->notice_id,
							 'notice_ctgry'     => $results[$i]->notice_ctgry,
							 'notice_title'	    => $results[$i]->notice_title,
							 'notice_desc'		=> $description,
							 'notice_file'	    => $results[$i]->notice_file,
							 'notice_is_active'	=> $results[$i]->notice_is_active,
						 );
		}
		
		//print_r($records); exit();
		
		return $records;
	}
	
	//get notice by category
	function getNoticeByCategory($notice_ctgry) {
		$c_tbl = 'cnf_notice';
		$this->db->select(array('notice_id', 'notice_ctgry', 'notice_title', 'notice_file', 'notice_desc', 'notice_is_active'));
		$this->db->from($c_tbl);
		$this->db->where('notice_is_active', 1);
		$this->db->where('notice_ctgry', $notice_ctgry);
		$this->db->order_by('notice_id', 'asc'); 
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}
	
	//create Notice
	function createNotice() {
		$c_tbl = 'cnf_notice';
		$created_on = gmdate('Y-m-d');
		$created_by = $this->session->userdata['user']['user_name']; //user id from session

		$uploadfilename = "";
		if (isset($_FILES['userfile'])){
			$uploadfilename = $_FILES['userfile']['name'];
		}
		
		$data = array(
					  'notice_ctgry'		=>	$this->input->post('notice_ctgry'),
					  'notice_title'		=>	$this->input->post('notice_title'),
					  'notice_file'			=>	$uploadfilename,
				      'notice_desc'			=>	$this->input->post('notice_desc'),
				      'notice_is_active'	=>	($this->input->post('notice_is_active') == 'on') ? 1 : 0,
				      'created_on'			=>	$created_on,
				      'created_by'			=>	$created_by,
				      'modified_on'			=>	$created_on,
				      'modified_by'			=>	$created_by
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	//update Notice
	function updateNotice() {
		$c_tbl = 'cnf_notice';
		$modified_on = gmdate('Y-m-d');
		$modified_by = $this->session->userdata['user']['user_name']; //user id from session

		if (isset($_FILES['userfile'])){
			$data = array(
				      'notice_ctgry'		=>	$this->input->post('notice_ctgry'),
				      'notice_title'		=>	$this->input->post('notice_title'),
				      'notice_file'			=>	$_FILES['userfile']['name'],
				      'notice_desc'			=>	$this->input->post('notice_desc'),
				      'notice_is_active'	=>	($this->input->post('notice_is_active') == 'on') ? 1 : 0,
				      'modified_on'			=>	$modified_on,
				      'modified_by'			=>	$modified_by
				    );
		}else{
			$data = array(
				      'notice_ctgry'		=>	$this->input->post('notice_ctgry'),
				      'notice_title'		=>	$this->input->post('notice_title'),
				      'notice_desc'			=>	$this->input->post('notice_desc'),
				      'notice_is_active'	=>	($this->input->post('notice_is_active') == 'on') ? 1 : 0,
				      'modified_on'			=>	$modified_on,
				      'modified_by'			=>	$modified_by
				    );
		}
		
		$this->db->where('notice_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	//delete Notice
	function deleteNotice($id) {
		$c_tbl = 'cnf_notice';
		$this->db->delete($c_tbl, array('notice_id' => $id)); 
		return "DELETED";
	}		


	//application related functions : Start
	
	//create application data
	function saveApplicationData(){
		$c_tbl = 'bed_application';
		
		$created_on = gmdate('Y-m-d');
		$timestamp = getDateFormat($created_on, 'ymdhis');
			
		$StepOneApplData = $this->session->userdata('StepOneAppl');
		$StepTwoApplData = $this->session->userdata('StepTwoAppl');
	
		

		$appl_dep_apnt_date  = $StepOneApplData['appl_dep_apnt_date'];
		$appl_dep_apprv_date = $StepOneApplData['appl_dep_apprv_date'];
		
		if($appl_dep_apnt_date!= '' && $appl_dep_apnt_date != null){
			$appl_dep_apnt_date = convertToMySqlDate($appl_dep_apnt_date); 
		}
		if($appl_dep_apprv_date!= '' && $appl_dep_apprv_date != null){
			$appl_dep_apprv_date = convertToMySqlDate($appl_dep_apprv_date); 
		}
		
		$cand_univ_ctgry = 'BU';
		if($StepOneApplData['appl_ctgr'] == 'F'){
			if($StepTwoApplData['appl_pg_board'] > 1){
				if($StepTwoApplData['appl_pg_board'] != 525){
					$cand_univ_ctgry = 'OU';	
				}				
			}else if($StepTwoApplData['appl_ug_board'] > 1){
				if($StepTwoApplData['appl_ug_board'] != 525){
					$cand_univ_ctgry = 'OU';
				}
			}			
		}
				
		$data = array(
					  'appl_name'				=>	$StepOneApplData['appl_name'],
					  'appl_ctgr'				=>	$StepOneApplData['appl_ctgr'],
					  'appl_reservation'		=>	$StepOneApplData['appl_reservation'],
					  'appl_is_pwd'				=>	$StepOneApplData['appl_is_pwd'],
					  'appl_univ_ctgry'			=>	$cand_univ_ctgry,
					  'appl_last_exam'			=>	$StepOneApplData['appl_last_exam'],
					  'appl_method_type'		=>	$StepOneApplData['appl_method_type'],
					  'appl_method_paper1'		=>	$StepOneApplData['appl_method_paper1'],
					  'appl_method_paper2'		=>	$StepOneApplData['appl_method_paper2'],
					  'appl_mp_pct'				=>	$StepOneApplData['appl_mp_pct'],
					  'appl_hs_pct'				=>	$StepOneApplData['appl_hs_pct'],
					  'appl_ug_pct'				=>	$StepOneApplData['appl_ug_pct'],
					  'appl_ug_ctgry'			=>	$StepOneApplData['appl_ug_ctgry'],
					  'appl_pg_pct'				=>	$StepOneApplData['appl_pg_pct'],
					  'appl_dep_org_name'		=>	$StepOneApplData['appl_dep_org_name'],
					  'appl_dep_org_addr'		=>	$StepOneApplData['appl_dep_org_addr'],
					  'appl_dep_apnt_date'		=>	$appl_dep_apnt_date,
					  'appl_dep_apprv_date'		=>	$appl_dep_apprv_date,					  
					  'appl_dep_exp_month'		=>	getMonthToJune($StepOneApplData['appl_dep_apprv_date']),

				      'appl_relegion'	 =>	$StepTwoApplData['appl_relegion'],
				      'appl_nationality' =>	$StepTwoApplData['appl_nationality'],
				      'appl_gurd_name'	 =>	$StepTwoApplData['appl_gurd_name'],
				      'appl_gurd_rel'	 =>	$StepTwoApplData['appl_gurd_rel'],
				      'appl_gender'		 =>	$StepTwoApplData['appl_gender'],
				      'appl_dob'		 =>	convertToMySqlDate($StepTwoApplData['appl_dob']),
				      'appl_dob_month'	 =>	getMonthToJune($StepTwoApplData['appl_dob']),
				      
				      'appl_comm_addr1'	=>	$StepTwoApplData['appl_comm_addr1'],
				      'appl_comm_addr2'	=>	$StepTwoApplData['appl_comm_addr2'],
				      'appl_comm_city'	=>	$StepTwoApplData['appl_comm_city'],
				      'appl_comm_dist'	=>	$StepTwoApplData['appl_comm_dist'],
				      'appl_comm_state'	=>	$StepTwoApplData['appl_comm_state'],
				      'appl_comm_pin'	=>	$StepTwoApplData['appl_comm_pin'],
				      'appl_phone'		=>	$StepTwoApplData['appl_phone'],
				      'appl_email'		=>	$StepTwoApplData['appl_email'],
				      
					  'appl_univ_regno'	=>	$StepTwoApplData['appl_univ_regno'],
				      'appl_univ_name'	=>	$StepTwoApplData['appl_univ_name'],
					  
				      'appl_mp_subj'	=>	$StepTwoApplData['appl_mp_subj'],
				      'appl_hs_subj'	=>	$StepTwoApplData['appl_hs_subj'],
				      'appl_ug_subj'	=>	$StepTwoApplData['appl_ug_subj'],
				      'appl_pg_subj'	=>	$StepTwoApplData['appl_pg_subj'],
				      'appl_mp_pyear'	=>	$StepTwoApplData['appl_mp_pyear'],
				      'appl_hs_pyear'	=>	$StepTwoApplData['appl_hs_pyear'],
				      'appl_ug_pyear'	=>	$StepTwoApplData['appl_ug_pyear'],
				      'appl_pg_pyear'	=>	$StepTwoApplData['appl_pg_pyear'],
				      'appl_mp_board'	=>	$StepTwoApplData['appl_mp_board'],
				      'appl_hs_board'	=>	$StepTwoApplData['appl_hs_board'],
				      'appl_ug_board'	=>	$StepTwoApplData['appl_ug_board'],
				      'appl_pg_board'	=>	$StepTwoApplData['appl_pg_board'],
				      'appl_is_mphil'	=>	$StepTwoApplData['appl_is_mphil'],
				      'appl_is_phd'		=>	$StepTwoApplData['appl_is_phd'],
					  'appl_score'	 	=>	getScorePoint($StepOneApplData, $StepTwoApplData),
				      'appl_passwd'	=>	$this->input->post('appl_passwd'),
				      'appl_profile_pic'=>'',
				      'appl_status'		=>	'1',
				      'appl_created_on'	=>	$created_on
				    );
		
		$status = TRUE;
		$this->db->trans_begin();
		
		$this->db->insert($c_tbl, $data);
		if ($this->db->trans_status() === FALSE) {
			$status = FALSE;
		}
		
		$appl_code = null;		
	
	
		if($status) {
			$appl_sl_no	=	$this->db->insert_id();
			if($appl_sl_no<10){
				$appl_sl_no = "0000".$appl_sl_no;
			}else
			if($appl_sl_no<100){
				$appl_sl_no = "000".$appl_sl_no;
			}else
			if($appl_sl_no<1000){
				$appl_sl_no = "00".$appl_sl_no;
			}else
			if($appl_sl_no<10000){
				$appl_sl_no = "0".$appl_sl_no;
			}	
			
			$appl_code =  "B15".$StepOneApplData['appl_ctgr'] . $appl_sl_no;
			//update form number
			$fn_data = array('appl_code' => $appl_code );
			
			$this->db->where('appl_sl_no', $appl_sl_no);					
			$status = $this->db->update($c_tbl, $fn_data);
		
			//$this->db->insert($c_tbl, $fn_data);	

			if ($this->db->trans_status() === FALSE) {
				$status = FALSE;
			}
		}
		
		$result  =array('appl_code'		=>$appl_code,
						'appl_mobile1'	=>$this->input->post('appl_phone'),
						'appl_email'	=>$this->input->post('appl_email'),
						'appl_passwd'	=>$this->input->post('appl_passwd'),
					  );
		
		if ($status === FALSE) {
		    $this->db->trans_rollback();
			$result['status'] = 0;
		} else {
		    $this->db->trans_commit();
			$result['status'] = 1;
		}		
					
		return $result;
		
	}
	
	//update application data : X
	function updateApplicationData(){
		$c_tbl = 'bed_application';
		
		$modified_by = 'student';
		$modified_on = gmdate('Y-m-d');
		$timestamp = getDateFormat($modified_on, 'ymdhis');
		
		if(isset($this->session->userdata['user'])) {
			$modified_by = $this->session->userdata['user_name'];
		}
		
		$data = array(
					'appl_name' => $_REQUEST['appl_name'],
					'appl_relegion' => $_REQUEST['appl_relegion'],
					'appl_nationality' => $_REQUEST['appl_nationality'],
					'appl_gurd_name' => $_REQUEST['appl_gurd_name'],
					'appl_gurd_rel' => $_REQUEST['appl_gurd_rel'],
					'appl_gender' => $_REQUEST['appl_gender'],
					'appl_dob' => convertToMySqlDate($_REQUEST['appl_dob']),
					'appl_comm_addr1' => $_REQUEST['appl_comm_addr1'],
					'appl_comm_addr2' => $_REQUEST['appl_comm_addr2'],
					'appl_comm_city' => $_REQUEST['appl_comm_city'],
					'appl_comm_state' => $_REQUEST['appl_comm_state'],
					'appl_comm_dist' => $_REQUEST['appl_comm_dist'],
					'appl_comm_pin' => $_REQUEST['appl_comm_pin'],
					'appl_phone' => $_REQUEST['appl_phone'],
					'appl_email' => $_REQUEST['appl_email'],
					'appl_modifed_on'	=>	$modified_on,
					'appl_modifed_on'	=>	$modified_by
	   );
			
		$status = FALSE;
		$this->db->trans_begin();
		$this->db->where('appl_sl_no', trim($_REQUEST['appl_sl_no']));
		
		$this->db->update($c_tbl, $data);
		if ($this->db->trans_status() === FALSE) {
			 $this->db->trans_rollback();
			 $status = FALSE;
		}else{
			 $this->db->trans_commit();
			 $status = TRUE;
		}
		$this->db->trans_complete();
		
		//echo $status;  print_r($data); exit();
							
		return $status;
	}
	
	//get application data : Done
	function getApplicationData($appl_code=null){
		$cnd_tbl = 'bed_application';
		$met_tbl = 'cnf_method';
		$mp1_tbl = 'cnf_method_paper';
		$mp2_tbl = 'cnf_method_paper';
		$sub_tbl = 'cnf_subjects';
		$res_tbl = 'cnf_reservation';
		$st_tbl  = 'cnf_states';
		$org_tbl = 'cnf_organizations';
		
		$profile_pic_path = $this->config->base_url() . "upload/students/profile_pic/";
		
		$this->db->select(array('DISTINCT ' . $cnd_tbl . '.appl_sl_no', 'appl_code', 'appl_ctgr', $cnd_tbl . '.appl_ctgr', 'appl_method_type', 'appl_method_paper1', 'appl_method_paper2', 
								'appl_name', 'appl_gurd_name', 'appl_gurd_rel', 'appl_gender', 'appl_dob', 'appl_dob_month',
								'appl_comm_addr1', 'appl_comm_addr2', 'appl_comm_dist', 'appl_comm_state', 'appl_comm_city', 'appl_comm_pin', 'appl_phone', 'appl_email',
								'appl_relegion', 'appl_reservation', 'appl_is_pwd', 'appl_nationality', 'appl_last_exam', 'appl_univ_regno', 'appl_univ_name',
								'appl_mp_subj', 'appl_mp_board', 'appl_mp_pyear', 'appl_mp_pct',
								'appl_hs_subj', 'appl_hs_board', 'appl_hs_pyear', 'appl_hs_pct',
								'appl_ug_subj', 'appl_ug_board', 'appl_ug_pyear', 'appl_ug_pct', 'appl_ug_ctgry',
								'appl_pg_subj', 'appl_pg_board', 'appl_pg_pyear', 'appl_pg_pct',
								'appl_is_mphil', 'appl_is_phd',
								'appl_dep_org_name', 'appl_dep_org_addr', 'appl_dep_apnt_date', 'appl_dep_apprv_date', 'appl_dep_exp_month', 'appl_score', 
								'appl_status', 'appl_profile_pic', 
								'appl_pmt_code', 'appl_pmt_type', 'appl_verified_by', 'appl_verified_on', 'appl_created_on',
								'appl_merit_type', 'appl_gen_merit', 'appl_sc_merit', 'appl_st_merit', 'appl_obca_merit', 'appl_obcb_merit',
								
								'method_name', 'UG.subj_name as appl_ug_subj_name', 'PG.subj_name as appl_pg_subj_name', 
								'METH1.subj_name as appl_method_paper1_name', 'METH2.subj_name as appl_method_paper2_name',
								'state_name', 'resv_name', 
								'A.organization_name appl_mp_board_name', 'B.organization_name appl_hs_board_name', 'C.organization_name appl_ug_board_name', 'D.organization_name appl_pg_board_name', 
								), false);
		$this->db->from($cnd_tbl);
		$this->db->join($met_tbl, $met_tbl.'.method_code = '.$cnd_tbl.'.appl_method_type', 'LEFT OUTER');
		$this->db->join($sub_tbl. " METH1", 'METH1.subj_code 	 = '.$cnd_tbl.'.appl_method_paper1', 'LEFT OUTER');
		$this->db->join($sub_tbl. " METH2", 'METH2.subj_code 	 = '.$cnd_tbl.'.appl_method_paper2', 'LEFT OUTER');
		$this->db->join($sub_tbl. " UG", 'UG.subj_code 	 = '.$cnd_tbl.'.appl_ug_subj', 'LEFT OUTER');
		$this->db->join($sub_tbl. " PG", 'PG.subj_code 	 = '.$cnd_tbl.'.appl_pg_subj', 'LEFT OUTER');
		$this->db->join($st_tbl, $st_tbl.'.state_code 	= '.$cnd_tbl.'.appl_comm_state', 'LEFT OUTER');
		$this->db->join($res_tbl, $res_tbl.'.resv_code 	= '.$cnd_tbl.'.appl_reservation', 'LEFT OUTER');
		$this->db->join($org_tbl. " A", 'A.organization_id= '.$cnd_tbl.'.appl_mp_board', 'LEFT OUTER');
		$this->db->join($org_tbl. " B", 'B.organization_id= '.$cnd_tbl.'.appl_hs_board', 'LEFT OUTER');
		$this->db->join($org_tbl. " C", 'C.organization_id= '.$cnd_tbl.'.appl_ug_board', 'LEFT OUTER');
		$this->db->join($org_tbl. " D", 'D.organization_id= '.$cnd_tbl.'.appl_pg_board', 'LEFT OUTER');
		
		//echo $appl_code; exit();
		
		
		
		$this->db->where($cnd_tbl . '.appl_code', $appl_code);
		$query = $this->db->get();
		
		$results = $query->result_array();
		
		if(count($results) == 1){
			$results = $results[0];
			
			$str = $results['appl_last_exam'];
			$split_str = explode('-', $str);
			
			$lastExamType = $split_str[0];
			$lastExamCtgr = $split_str[1];
			
			$results['univ_logo'] = $this->config->base_url() . 'assets/img/bu_logo90.jpg';
			$results['lastExamType'] = $lastExamType;
			$results['lastExamCtgr'] = $lastExamCtgr;
			$results['appl_profile_pic'] =	$profile_pic_path . (($results['appl_profile_pic'] != '') ? 't_' . $results['appl_profile_pic']: 'no-profile-pic_90.png');
		}
		return $results;
	}
	
	
	//get student rank info by application code: Done
	function getRankCardInfo($appl_code){
		$c_tbl = 'bed_application';
		
		$this->db->select('*');
		$this->db->from($c_tbl);
		$this->db->where('LOWER(appl_code)', trim(strtolower($appl_code)));
		$query = $this->db->get();	
		
		$rankinfo = NULL;
		
			if ($query->num_rows() > 0) {
				$row = $query->row(); 
				$profile_pic_path = $this->config->base_url() . "upload/students/profile_pic/";
				$rankinfo = array(
								'univ_logo'     => $this->config->base_url() . 'assets/img/bu_logo90.jpg',
								'appl_name'    => $row->appl_name, 
								'appl_email'   => $row->appl_email,
								'appl_phone'   => $row->appl_phone,
								'appl_profile_pic'	=>	$profile_pic_path . (($row->appl_profile_pic != '') ? 't_' . $row->appl_profile_pic : 'no-profile-pic_90.png'),
								'appl_method'     => $this->usermodel->getMethodTypeNameByCode($row->appl_method_type),
								'appl_code'       => $row->appl_code,
								'GEN'   => $row->appl_gen_merit,
								'SC'	=> $row->appl_sc_merit,
								'ST'	=> $row->appl_st_merit,
								'OBCA'	=> $row->appl_obca_merit,
								'OBCB'	=> $row->appl_obcb_merit,
								'PWD'	=> $row->appl_pwd_merit,
								'GEN_TYPE'  => $this->configmodel->getMeritInfo($row->appl_gen_merit_ctgr),
								'SC_TYPE'	=> $this->configmodel->getMeritInfo($row->appl_sc_merit_ctgr),
								'ST_TYPE'	=> $this->configmodel->getMeritInfo($row->appl_st_merit_ctgr),
								'PWD_TYPE'	=> $this->configmodel->getMeritInfo($row->appl_pwd_merit_ctgr),
								'TYPE'	=> $row->appl_merit_type,
								'CTGR'	=> $row->appl_ctgr,
								
							 );
			}	
			return $rankinfo;
	}
	
	//submit application journal number: X
	function submitJournalInformation(){
		$c_tbl = 'pg_appl_candidates';
		$f_tbl = 'pg_appl_fees';
		
		$created_on = gmdate('Y-m-d');
		$timestamp = getDateFormat($created_on, 'ymdhis');
			
		$data = array(
					  'appl_fees_amount'	=>	applicationFeesAmount(),
					  'appl_fees_type'		=>	'Application Fees',
					  'appl_inst_type'		=>	'Challan',
				      'appl_inst_num'		=>	$this->input->post('appl_inst_num'),
				      'appl_inst_branch'	=>	$this->input->post('appl_inst_branch'),
				      'appl_inst_branch_code'=>	$this->input->post('appl_inst_branch_code'),
				      'appl_inst_date'		=>	convertToMySqlDate($this->input->post('appl_inst_date')),
				    );
		
		$status = TRUE;
		$this->db->trans_begin();
		
		$this->db->where('pg_appl_code', $this->input->post('pg_appl_code'));	
		$this->db->update($f_tbl, $data);
		if ($this->db->trans_status() === FALSE) {
			$status = FALSE;
		}
		
		if($status) {
			$fn_data = array('pg_appl_status' => '2' );
			$this->db->where('pg_appl_code', $this->input->post('pg_appl_code'));					
			$status = $this->db->update(pg_appl_candidates, $fn_data);
		
			if ($this->db->trans_status() === FALSE) {
				$status = FALSE;
			}
		}
		$result = false;
		
		if ($status === FALSE) {
		    $this->db->trans_rollback();
			$result = false;
		} else {
		    $this->db->trans_commit();
			$result = true;
		}		
					
		return $result;
	}	
	

	//get all payment files: Done
	function getALlUnprocessPaymentFilesOption(){
		$sql_u = "SELECT upload_file_id,  upload_file_name FROM pmt_upload_files WHERE is_upload_file_processed = 0 ORDER BY upload_file_date";
		$query_u = $this->db->query($sql_u);
		$dropdowns = $query_u->result();
		$unprocessList = array();
		$unprocessList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$unprocessList[$dropdown->upload_file_id] = $dropdown->upload_file_name;
        }
		$finalDropDown = $unprocessList;
        return $finalDropDown;
	} 
	
	//get all File: Done
	function getAllFiles($status=null) {
		$c_tbl = 'pmt_upload_files';
		$this->db->select(array('upload_file_id', 'upload_file_name', 'upload_file_date', 'processed_on', 'is_upload_file_processed'));
		$this->db->from($c_tbl);
		if($status != null){
			$this->db->where('is_upload_file_processed', 1);
		}
		$this->db->order_by('upload_file_date', 'asc'); 
		$query = $this->db->get();
		$results = $query->result();
		
		$records = array();
		for($i=0; $i<count($results); $i++){
			$records[$i] = array(
							 'upload_file_name'     	=> $results[$i]->upload_file_name,
							 'upload_file_id'     		=> $results[$i]->upload_file_id,
							 'upload_file_date'	    	=> getDateFormat($results[$i]->upload_file_date, 'd-m-Y'),
							 'is_upload_file_processed'	=> $results[$i]->is_upload_file_processed,
							 'processed_on'	    		=> getDateFormat($results[$i]->processed_on, 'd-m-Y'),
						 );
		}
		
		return $records;
	}
	
	//create File: Done
	function createFile() {
		$c_tbl = 'pmt_upload_files';
		$created_on = gmdate('Y-m-d');
		$created_by = $this->session->userdata['user']['user_name']; //user id from session

		$uploadfilename = "";
		if (isset($_FILES['userfile'])){
			$uploadfilename = $_FILES['userfile']['name'];
		}
		
		$data = array(
					  'upload_file_name'	=>	$_FILES['userfile']['name'],
				      'upload_file_date'	=>	convertToMySqlDate($this->input->post('upload_file_date')),
				      'created_on'			=>	$created_on,
				      'created_by'			=>	$created_by,
				      'modified_on'			=>	$created_on,
				      'modified_by'			=>	$created_by
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	//update files: Done
	function updateFile() {
		$c_tbl = 'pmt_upload_files';
		$modified_on = gmdate('Y-m-d');
		$modified_by = $this->session->userdata['user']['user_name']; //user id from session

		if (isset($_FILES['userfile'])){
			$data = array(
				      'upload_file_name'	=>	$_FILES['userfile']['name'],
				      'upload_file_date'	=>	convertToMySqlDate($this->input->post('upload_file_date')),
				      'modified_on'			=>	$modified_on,
				      'modified_by'			=>	$modified_by
				    );
		}else{
			$data = array(
				      'upload_file_date'	=>	convertToMySqlDate($this->input->post('upload_file_date')),
				      'modified_on'			=>	$modified_on,
				      'modified_by'			=>	$modified_by
				    );
		}
		
		$this->db->where('upload_file_id ', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	//delete file: Done
	function deleteFile($id) {
		$c_tbl = 'pmt_upload_files';
		$this->db->delete($c_tbl, array('upload_file_id' => $id)); 
		return "DELETED";
	}		

	//process payment file: Done
	function systemPaymentVerification(){
		$process_file_path = $this->config->base_url()."upload/payments/";
		$processed_on = gmdate('Y-m-d');
		$processed_by = $this->session->userdata['user']['user_name']; //user id from session
		
		//Fetch the filename from database
		$c_tbl = 'pmt_upload_files';
		$this->db->select(array('upload_file_id', 'upload_file_name', 'upload_file_date', 'processed_on', 'is_upload_file_processed'));
		$this->db->from($c_tbl);
		$this->db->where('upload_file_id', $_POST['upload_file_id']);
		
		$query = $this->db->get();
		$results = $query->result_array();
		
		$status = TRUE;
		
		if(count($results) >0){
			$csv_file_id		= $results[0]['upload_file_id'];
			$csv_file 			= $results[0]['upload_file_name'];
			$file_upload_date 	= $results[0]['upload_file_date'];
			$pmt_prcs_on		= $processed_on;
			$pmt_prcs_by		= $processed_by;
			
			$process_data = getRecordFromCSV($process_file_path.$csv_file);
			
			$this->db->trans_begin();
			
			$row_num = 0;
			foreach ($process_data as $line) {
				//verifyy the document header for better restriction....
				if($row_num > 0){
					//$header = array('Application Code', 'Application Name', 'Payment Date', 'Payment Number', 'Payment Item');
					$appl_code 	= $line[0];
					$appl_name 	= $line[1];
					//$pmt_amt 	= $line[2];
					$pmt_date 	= $line[3];
					$pmt_code 	= $line[4];
					$pmt_item 	= $line[5];
					$pmt_prcs_status = 0;
					
					
					
					$update_sql = "UPDATE bed_application SET appl_status = 3, appl_verified_by = 'SYSTEM', appl_verified_on = '".$processed_on."'
								    WHERE appl_code like '" . trim(strtoupper($appl_code)) . "'";
					$this->db->query($update_sql);
					
					//$update_data = array('appl_status' => 3, 'appl_verified_by'=> 'System', 'appl_verified_on' => $processed_on);
					//$this->db->where('appl_code', trim(strtoupper($appl_code))); // more validation will be updated
					//$this->db->update('bed_application', $update_data);
					 
					
					//echo $status; 
					//echo $this->db->last_query();
					//exit();
					
					
					if ($this->db->trans_status() === FALSE) {
						$status = FALSE;
					}
					
					if($this->db->affected_rows() > 0 ){
						$pmt_prcs_status = 1;
					}
					
					$insert_data = array(
											'pmt_file'=>  $csv_file,
											'pmt_file_id'=>  $csv_file_id,
											'appl_code'=> $appl_code,
											'appl_name'=> $appl_name,
											'pmt_code'=>  $pmt_code,
											'pmt_type'=>  $pmt_item,
											'pmt_date'=> $pmt_date,
											'pmt_prcs_status'=> $pmt_prcs_status,
											'pmt_prcs_on'=> $pmt_prcs_on,
											'pmt_prcs_by'=> $pmt_prcs_by,
										);	
					$this->db->insert('pmt_prcs_info', $insert_data);
					if ($this->db->trans_status() === FALSE) {
						$status = FALSE;
					}
				}
				$row_num++;
			}
			
			$update_data_2 = array('is_upload_file_processed'=> 1, 'processed_on'=>$pmt_prcs_on);
			$this->db->where('upload_file_id', $_POST['upload_file_id']);
			$this->db->update('pmt_upload_files', $update_data_2);
			
			//echo $status; 
			//echo $this->db->last_query();
			//exit();
			
			if ($status === FALSE) {
			    $this->db->trans_rollback();
			} else {
			    $this->db->trans_commit();
			}
			
			$this->db->trans_complete();
			
		}
		return $status;
	}

	function updateRevokePayment($appl_code){
		$processed_on = gmdate('Y-m-d');
		$processed_by = $this->session->userdata['user']['user_name']; //user id from session
		
		$update_data = array(
							'appl_status' => '1', 
							'appl_verified_by'=> $processed_by, 
							'appl_verified_on' => $processed_on,
							'appl_pmt_code' => '',
							'appl_pmt_type' => '',
							);
		$this->db->where('appl_code', $appl_code);
		
		$status = $this->db->update('bed_application', $update_data);
		
		if($status){
			//update the transaction history
			$event = "Payment Revoked";
			$this->createTransHistory($appl_code, $event, $processed_by, $processed_on);
		}
		
		
		return $status;
	}	
	
	function updateConfirmPayment(){
		$processed_on = gmdate('Y-m-d');
		$processed_by = $this->session->userdata['user']['user_name']; //user id from session
		
		$appl_code = $_REQUEST['appl_code'];
		
		$update_data = array(
							'appl_status' => '2', 
							'appl_verified_by'=> $processed_by, 
							'appl_verified_on' => $processed_on,
							'appl_pmt_code' => $_REQUEST['pmt_code'],
							'appl_pmt_type' => $_REQUEST['pmt_type'],
							);
		$this->db->where('appl_code', $appl_code);
		
		$status = $this->db->update('bed_application', $update_data);
		
		if($status){
			//update the transaction history
			$event = "Payment Updated";
			$this->createTransHistory($appl_code, $event, $processed_by, $processed_on);
		}
		return $status;
	}	

	function getNonVerifiedRecordById($id = null){
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		
		$delimeter = ",";
		$newline = "\r\n";
		$enclosure = "";
		
		$sql = 'select upload_file_name from pmt_upload_files where upload_file_id = '. $id;
		$query = $this->db->query($sql);
		$results = $query->result();
		$file_name = "";
		if(count($results) > 0){
			$file_name = $results[0]->upload_file_name;
		}
		$file_name = "PROCESS-".$file_name;
		
		
		$select_sql = 'select appl_code AS "Application Code", appl_name AS "Application Name", pmt_date AS "Payment Date", pmt_code AS "Instrument Number", pmt_type AS "Instrument Item" from pmt_prcs_info where pmt_file_id = '.$id .' and pmt_prcs_status != 1';
		$select_query = $this->db->query($select_sql);
		
		$data = $this->dbutil->csv_from_result($select_query, $delimeter, $newline, $enclosure);
		force_download($file_name, $data);
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
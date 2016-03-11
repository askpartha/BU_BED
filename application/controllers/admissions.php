<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admissions extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper( array('url', 'form', 'text') );
		$this->load->library('authenticate', 'session');
		$this->load->model('usermodel');
		$this->load->model('configmodel');
		$this->load->model('admissionmodel');
		$this->load->model('studentmodel');
	}

	//------------------------Start:  Admin Configuration --------------------	
	//list all notice
	function notices() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['notices'] = $this->admissionmodel->getAllNotices();
				$data['notice_ctgry_options'] = $this->configmodel->getAllNoticesCategoryOption();
				$data['page_title'] = "Configure Notices";
				$this->load->view('header', $data);
				$this->load->view('admissions/notices', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	// load list of notices in AJAX 
	function loadnotices() {
		echo json_encode($this->admissionmodel->getAllNotices());
	}	
	
	//add notice item
	function createnotice() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->admissionmodel->createNotice();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
						
						if (isset($_FILES['userfile'])){
							$config['upload_path'] = '././upload/notices/';
							$config['allowed_types'] = '*';
							
							$this->load->library('upload', $config);
							if ( ! $this->upload->do_upload()){
								$this->session->set_flashdata('success', 'News created but file not uploaded because '.$this->upload->display_errors());	
							}
						}

					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('admissions/notices');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->admissionmodel->updateNotice();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
						
						if (isset($_FILES['userfile'])){
							$config['upload_path'] = '././upload/notices/';
							$config['allowed_types'] = '*';
							
							$this->load->library('upload', $config);
							if ( ! $this->upload->do_upload()){
								$this->session->set_flashdata('success', 'News created but file not uploaded because '.$this->upload->display_errors());	
							}							
						}

					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('admissions/notices');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	//delete notice item
	function delnotice() {
		echo $this->admissionmodel->deleteNotice($_POST['id']);
	}	

	//general instruction for students
	function instructions(){
		//$this->output->enable_profiler(TRUE);
		$data['general_notices'] = $this->admissionmodel->getNoticeByCategory('General');
		$data['page_title'] = "General Instructions to the user";
		$this->load->view('web_header', $data);
		$this->load->view('admissions/instructions', $data);
	}
	
	//list all payment files
	function paymentfile() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				$data['payment_files'] = $this->admissionmodel->getAllFiles();
				$data['page_title'] = "Configure Payment Files";
				$this->load->view('header', $data);
				$this->load->view('admissions/paymentfile', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	// load list of payment file in AJAX 
	function loadpaymentfiles() {
		echo json_encode($this->admissionmodel->getAllNotices());
	}	
	
	//add payment file item
	function createpaymentfile() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				if($this->input->post('form_action') == 'add') {
					  if (isset($_FILES['userfile'])){
							$config['upload_path'] = '././upload/payments/';
							$config['allowed_types'] = 'csv';
							
							$this->load->library('upload', $config);
							if ( ! $this->upload->do_upload()){
								$this->session->set_flashdata('failure', 'Record created but file not uploaded because '.$this->upload->display_errors());	
							}else{
								$status = $this->admissionmodel->createFile();
								if($status){
									$this->session->set_flashdata('success', 'Record created succesfully');	
								}else{
									$this->session->set_flashdata('failure', 'Record not  created succesfully');
								}
							}
						}
					redirect('admissions/paymentfile');	
				} elseif($this->input->post('form_action') == 'edit') {
					if (isset($_FILES['userfile'])){
						$config['upload_path'] = '././upload/payments/';
						$config['allowed_types'] = 'csv';
						
						$this->load->library('upload', $config);
						if ( ! $this->upload->do_upload()){
							$this->session->set_flashdata('failure', 'Record created but file not uploaded because '.$this->upload->display_errors());	
						}else{
							$status = $this->admissionmodel->updateFile();
							if($status){
								$this->session->set_flashdata('success', 'Record created succesfully');	
							}else{
								$this->session->set_flashdata('failure', 'Record not  created succesfully');
							}
						}
					}else{
						$status = $this->admissionmodel->updateFile();
						if($status){
							$this->session->set_flashdata('success', 'Record created succesfully');	
						}else{
							$this->session->set_flashdata('failure', 'Record not  created succesfully');
						}
					}
					redirect('admissions/paymentfile');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	//delete payment file item
	function deletepaymentfile() {
		echo $this->admissionmodel->deleteFile($_POST['id']);
	}	

	//list all process payment files
	function processpaymentfile() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				$data['unprocess_payment_files'] 	= 	$this->admissionmodel->getALlUnprocessPaymentFilesOption();
				$data['payment_files'] 		= 	$this->admissionmodel->getAllFiles('1');
				
				$data['page_title'] = "Process Payment Files";
				$this->load->view('header', $data);
				$this->load->view('admissions/processpaymentfile', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}

	//download non verified records.
	function downloadnonverifiedrecord($id=null){
		$this->admissionmodel->getNonVerifiedRecordById($id);	
	}
	
	//verify payment files
	function verifypaymentfile() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				
				$status = $this->admissionmodel->systemPaymentVerification();
				if($status){
					$this->session->set_flashdata('success', 'System verified succesfully');	
				}else{
					$this->session->set_flashdata('failure', 'System not verified succesfully');
				}
				
				$data['unprocess_payment_files'] 	= 	$this->admissionmodel->getALlUnprocessPaymentFilesOption();
				$data['payment_files'] 		= 	$this->admissionmodel->getAllFiles('1');
				
				$data['page_title'] = "Process Payment Files";
				$this->load->view('header', $data);
				$this->load->view('admissions/processpaymentfile', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	
	//------------------------End:  Admin Configuration --------------------

	function applDateValidate($errorMessage){
		$status = true;
		//check whether todays date is less than equal to application last date 
		$applStartDate = $this->configmodel->getScheduleDateByName('ASD');
		$applEndDate   = $this->configmodel->getScheduleDateByName('AED'); 
		
		$todaysDateObj    = new DateTime();
		$applStartDateObj = new DateTime($applStartDate);
		$applEndDateObj   = new DateTime($applEndDate);
		
		if($applStartDate != "" && ($todaysDateObj < $applStartDateObj)){
			$status = false;
			$errorMessage .= "<li>B.Ed application yet to be started.</li>";
		}
		
		if($applStartDate != "" && ($applEndDateObj < $todaysDateObj)){
			$status = false;
			$errorMessage .= "<li>B.Ed applications being closed.</li>";
		}	
		$result['status'] = $status;
		$result['msg'] = $errorMessage;
		return $result;
	}
	
	function initFormOne($data){
		$data['general_notices'] 	 = $this->admissionmodel->getNoticeByCategory('General');
		$data['application_notices'] = $this->admissionmodel->getNoticeByCategory('Application');		
		$data['admission_notices'] 	 = $this->admissionmodel->getNoticeByCategory('Admission');
		$data['result_notices'] 	 = $this->admissionmodel->getNoticeByCategory('Result');
		
		$data['session_options'] 		= $this->configmodel->getSessionOption();
		$data['reservation_options'] 	= $this->configmodel->getReservationOption();
		$data['category_options'] 		= $this->configmodel->getCourseCtgryOption();
		$data['student_category_options'] = $this->configmodel->getCategoryOption();
		$data['method_options'] 		= $this->configmodel->getAllMethodsOption();
		$data['yesno_options'] 			= $this->configmodel->getYesNoOption();
		$data['ug_ctgy_options'] 		= $this->configmodel->getUGCategoryOption();	
		return $data;
	}
	
	function initFormTwo($data){
		$data['gender_options'] 	= $this->configmodel->getGenderOption();
		$data['yesno_options'] 		= $this->configmodel->getYesNoOption();	
		$data['gurd_options'] 		= $this->configmodel->GurdianOption();		
		
		$data['university_options'] = $this->configmodel->getAllOrganizationsOptionByCriteria('3'); 
		$data['council_options'] 	= $this->configmodel->getAllOrganizationsOptionByCriteria('2'); 
		$data['board_options'] 		= $this->configmodel->getAllOrganizationsOptionByCriteria('1');
		$data['state_options'] 		= $this->configmodel->getStateOptionWithCode();
		$data['subject_options'] 	= $this->configmodel->getAllSubjectsOption();
		$data['relligion_options'] 	= $this->configmodel->getReligionOption();
		$data['nationality_options'] 	= $this->configmodel->NationalityOption();
		
		return $data;
	}

	function resetFormOne($data){
		$data['appl_name'] 				= "";
		$data['appl_ctgr'] 				= "EMPTY";
		$data['appl_method_type'] 		= "EMPTY";
		$data['appl_method_paper1'] 	= "EMPTY";
		$data['appl_method_paper2']		= "EMPTY";
		$data['appl_reservation'] 		= "EMPTY";
		$data['appl_is_pwd'] 			= "N";
		$data['appl_last_exam'] 		= "EMPTY";
		$data['appl_mp_pct'] 			= "";
		$data['appl_hs_pct'] 			= "";
		$data['appl_ug_pct'] 			= "";
		$data['appl_ug_ctgry'] 			= "EMPTY";
		$data['appl_pg_pct'] 			= "";
		
		$data['appl_dep_org_name'] 		= "";		
		$data['appl_dep_org_addr'] 		= "";
		$data['appl_dep_apnt_date'] 	= "";
		$data['appl_dep_apprv_date'] 	= "";
		
		return $data;
	}
	
	function setFormOneFromSession($data){
		$tempData = $this->session->userdata('StepOneAppl');
		
		$data['appl_name'] 				= $tempData['appl_name'];
		$data['appl_ctgr'] 				= $tempData['appl_ctgr'];
		$data['appl_method_type'] 		= $tempData['appl_method_type'];
		$data['appl_method_paper1'] 	= $tempData['appl_method_paper1'];
		$data['appl_method_paper2']		= $tempData['appl_method_paper2'];
		$data['appl_reservation'] 		= $tempData['appl_reservation'];
		$data['appl_is_pwd'] 			= $tempData['appl_is_pwd'];
		$data['appl_last_exam'] 		= $tempData['appl_last_exam'];
		$data['appl_mp_pct'] 			= $tempData['appl_mp_pct'];
		$data['appl_hs_pct'] 			= $tempData['appl_hs_pct'];
		$data['appl_ug_pct'] 			= $tempData['appl_ug_pct'];
		$data['appl_ug_ctgry'] 			= $tempData['appl_ug_ctgry'];
		$data['appl_pg_pct'] 			= $tempData['appl_pg_pct'];
		
		$data['appl_dep_org_name'] 		= $tempData['appl_dep_org_name'];		
		$data['appl_dep_org_addr'] 		= $tempData['appl_dep_org_addr'];
		$data['appl_dep_apnt_date'] 	= $tempData['appl_dep_apnt_date'];
		$data['appl_dep_apprv_date'] 	= $tempData['appl_dep_apprv_date'];
		
		return $data;
	}

	function setFormOneFromRequest($data){
		$data['appl_name'] 				= $this->input->post('appl_name');
		$data['appl_ctgr'] 				= $this->input->post('appl_ctgr');
		$data['appl_method_type'] 		= $this->input->post('appl_method_type');
		$data['appl_method_paper1'] 	= $this->input->post('appl_method_paper1');
		$data['appl_method_paper2']		= $this->input->post('appl_method_paper2');
		$data['appl_reservation'] 		= $this->input->post('appl_reservation');
		$data['appl_is_pwd'] 			= $this->input->post('appl_is_pwd');
		$data['appl_last_exam'] 		= $this->input->post('appl_last_exam');
		$data['appl_mp_pct'] 			= $this->input->post('appl_mp_pct');
		$data['appl_hs_pct'] 			= $this->input->post('appl_hs_pct');
		$data['appl_ug_pct'] 			= $this->input->post('appl_ug_pct');
		$data['appl_ug_ctgry'] 			= $this->input->post('appl_ug_ctgry');
		$data['appl_pg_pct'] 			= $this->input->post('appl_pg_pct');
		
		$data['appl_dep_org_name'] 		= $this->input->post('appl_dep_org_name');		
		$data['appl_dep_org_addr'] 		= $this->input->post('appl_dep_org_addr');
		$data['appl_dep_apnt_date'] 	= $this->input->post('appl_dep_apnt_date');
		$data['appl_dep_apprv_date'] 	= $this->input->post('appl_dep_apprv_date');
		
		return $data;
	}

	function resetFormTwo($data){
		
		$data['appl_gurd_name'] = "";
		$data['appl_gurd_rel'] 	= "EMPTY";
		$data['appl_gender'] 	= "EMPTY";
		$data['appl_dob'] 		= "";
		$data['appl_comm_addr1']	= "";
		$data['appl_comm_addr2'] 	= "";
		$data['appl_comm_city'] 	= "";
		$data['appl_comm_dist'] 	= "";
		$data['appl_comm_state'] 	= "EMPTY";
		$data['appl_comm_pin'] 		= "";
		$data['appl_phone'] 		= "";
		$data['appl_email'] 		= "";		
		$data['appl_relegion'] 		= "EMPTY";
		$data['appl_nationality'] 	= "EMPTY";
		
		$data['appl_univ_regno'] 		= "";		
		$data['appl_univ_name'] 		= "";
		
		$data['appl_mp_pyear'] 	= "";
		$data['appl_mp_board'] 	= "EMPTY";
		$data['appl_mp_subj'] 	= "";
		$data['appl_hs_pyear'] 	= "";
		$data['appl_hs_board'] 	= "EMPTY";
		$data['appl_hs_subj'] 	= "";
		$data['appl_ug_pyear'] 	= "";
		$data['appl_ug_board'] 	= "EMPTY";
		$data['appl_ug_subj'] 	= "EMPTY";
		$data['appl_pg_pyear'] 	= "";
		$data['appl_pg_board'] 	= "EMPTY";
		$data['appl_pg_subj'] 	= "EMPTY";
		$data['appl_is_mphil'] 	= "0";
		$data['appl_is_phd'] 	= "0";
		
		return $data;
	}
	
	function setFormTwoFromSession($data){
		$tempData = $this->session->userdata('StepOneAppl');
		
		$data['appl_gurd_name'] = $tempData['appl_gurd_name'];
		$data['appl_gurd_rel'] 	= $tempData['appl_gurd_rel'];
		$data['appl_gender'] 	= $tempData['appl_gender'];
		$data['appl_dob'] 		= $tempData['appl_dob'];
		$data['appl_comm_addr1']	= $tempData['appl_comm_addr1'];
		$data['appl_comm_addr2'] 	= $tempData['appl_comm_addr2'];
		$data['appl_comm_city'] 	= $tempData['appl_comm_city'];
		$data['appl_comm_dist'] 	= $tempData['appl_comm_dist'];
		$data['appl_comm_state'] 	= $tempData['appl_comm_state'];
		$data['appl_comm_pin'] 		= $tempData['appl_comm_pin'];
		$data['appl_phone'] 		= $tempData['appl_phone'];
		$data['appl_email'] 		= $tempData['appl_email'];		
		$data['appl_relegion'] 		= $tempData['appl_relegion'];
		$data['appl_nationality'] 	= $tempData['appl_nationality'];
		$data['appl_univ_regno'] 	= $tempData['appl_univ_regno'];		
		$data['appl_univ_name'] 	= $tempData['appl_univ_name'];
		$data['appl_mp_pyear'] 	= $tempData['appl_mp_pyear'];
		$data['appl_mp_board'] 	= $tempData['appl_mp_board'];
		$data['appl_mp_subj'] 	= $tempData['appl_mp_subj'];
		$data['appl_hs_pyear'] 	= $tempData['appl_hs_pyear'];
		$data['appl_hs_board'] 	= $tempData['appl_hs_board'];
		$data['appl_hs_subj'] 	= $tempData['appl_hs_subj'];
		$data['appl_ug_pyear'] 	= $tempData['appl_ug_pyear'];
		$data['appl_ug_board'] 	= $tempData['appl_ug_board'];
		$data['appl_ug_subj'] 	= $tempData['appl_ug_subj'];
		$data['appl_pg_pyear'] 	= $tempData['appl_pg_pyear'];
		$data['appl_pg_board'] 	= $tempData['appl_pg_board'];
		$data['appl_pg_subj'] 	= $tempData['appl_pg_subj'];
		$data['appl_is_mphil'] 	= $tempData['appl_is_mphil'];
		$data['appl_is_phd'] 	= $tempData['appl_is_phd'];
		
		return $data;
	}

	function setFormTwoFromRequest($data){
		$data['appl_gurd_name'] = $this->input->post('appl_gurd_name');
		$data['appl_gurd_rel'] 	= $this->input->post('appl_gurd_rel');
		$data['appl_gender'] 	= $this->input->post('appl_gender');
		$data['appl_dob'] 		= $this->input->post('appl_dob');
		$data['appl_comm_addr1']	= $this->input->post('appl_comm_addr1');
		$data['appl_comm_addr2'] 	= $this->input->post('appl_comm_addr2');
		$data['appl_comm_city'] 	= $this->input->post('appl_comm_city');
		$data['appl_comm_dist'] 	= $this->input->post('appl_comm_dist');
		$data['appl_comm_state'] 	= $this->input->post('appl_comm_state');
		$data['appl_comm_pin'] 		= $this->input->post('appl_comm_pin');
		$data['appl_phone'] 		= $this->input->post('appl_phone');
		$data['appl_email'] 		= $this->input->post('appl_email');		
		$data['appl_relegion'] 		= $this->input->post('appl_relegion');
		$data['appl_nationality'] 	= $this->input->post('appl_nationality');
		$data['appl_univ_regno'] 	= $this->input->post('appl_univ_regno');		
		$data['appl_univ_name'] 	= $this->input->post('appl_univ_name');
		$data['appl_mp_pyear'] 	= $this->input->post('appl_mp_pyear');
		$data['appl_mp_board'] 	= $this->input->post('appl_mp_board');
		$data['appl_mp_subj'] 	= $this->input->post('appl_mp_subj');
		$data['appl_hs_pyear'] 	= $this->input->post('appl_hs_pyear');
		$data['appl_hs_board'] 	= $this->input->post('appl_hs_board');
		$data['appl_hs_subj'] 	= $this->input->post('appl_hs_subj');
		$data['appl_ug_pyear'] 	= $this->input->post('appl_ug_pyear');
		$data['appl_ug_board'] 	= $this->input->post('appl_ug_board');
		$data['appl_ug_subj'] 	= $this->input->post('appl_ug_subj');
		$data['appl_pg_pyear'] 	= $this->input->post('appl_pg_pyear');
		$data['appl_pg_board'] 	= $this->input->post('appl_pg_board');
		$data['appl_pg_subj'] 	= $this->input->post('appl_pg_subj');
		$data['appl_is_mphil'] 	= $this->input->post('appl_is_mphil');
		$data['appl_is_phd'] 	= $this->input->post('appl_is_phd');
		
		return $data;
	}
	
	function admstepone($redirection=null) {
		$data = array();
		
		$data = $this->initFormOne($data);
		
		if($redirection == 'failed'){
			$data = $this->setFormOneFromSession($data);
		}else{
			$data = $this->resetFormOne($data);
		}		
		
		$data['page_title'] = "Admission Form for B.Ed Courses";
		$this->load->view('web_header', $data);
		$this->load->view('admissions/admstepone', $data);
	}
	
	function isPropertyEmpty($property = ""){
		if($property == '' || $property == 'EMPTY' || $property == 'undefined'){
			return false;
		}
	}
	
	function submitstepone(){
		//$this->output->enable_profiler(TRUE);
		$errorMessage = "";
		$isValidationFailed = false;
		
		$appl_data = array();
		$appl_data = $this->setFormOneFromRequest($appl_data);
		$this->session->set_userdata('StepOneAppl', $appl_data);
		
		$retResult = $this->applDateValidate($errorMessage); 
		if(!$retResult['status']){
			$isValidationFailed = true;
		}
		$errorMessage.=$retResult['msg'];
		
		if($this->isPropertyEmpty('appl_name') || $this->isPropertyEmpty('appl_ctgr') || $this->isPropertyEmpty('appl_method_type') || 
		   $this->isPropertyEmpty('appl_method_paper1') || $this->isPropertyEmpty('appl_method_paper2') || $this->isPropertyEmpty('appl_reservation') || 
		   $this->isPropertyEmpty('appl_is_pwd') || $this->isPropertyEmpty('appl_last_exam')){
			$isValidationFailed = true;
			$errorMessage .= "<li>Some wrong in your application. Please use different browser.</li>";
		}
		
		
		//------------------- MARKS CALCULATIONS --------------- : START		
		$marks_flag = true;
		if(!is_numeric($this->input->post('appl_mp_pct')) || !is_numeric($this->input->post('appl_hs_pct')) || !is_numeric($this->input->post('appl_ug_pct'))){
			$isValidationFailed = true;
			$marks_flag = false;
			$errorMessage .= "<li>Some wrong in your application. marks should be in neumeric format only.</li>";
		}
		
		if($this->input->post('appl_ug_ctgry') =='EMPTY' || $this->input->post('appl_ug_ctgry') =='undefined'){
			$isValidationFailed = true;
			$errorMessage .= "<li>Undergraduate category should not blank.</li>";
		}
		
		
		
		//---------------- CRITERIA START -------------------
		$criteriaMarks = $this->configmodel->getCriteriaMarks();
		
		//---------------- CRITERIA END -------------------
		
		
		$str = $this->input->post('appl_last_exam');
		$split_str = explode('-', $str);
		
		$mp_marks = $this->input->post('appl_mp_pct');
		$hs_marks = $this->input->post('appl_hs_pct');
		$ug_marks = $this->input->post('appl_ug_pct');
		$pg_marks = $this->input->post('appl_pg_pct');
		
		if($marks_flag && ($mp_marks > 100 || $hs_marks > 100 || $ug_marks > 100)){
			$isValidationFailed = true;
			$marks_flag = false;
			$errorMessage .= "<li>Some wrong in your application. Percentage of marks should be iless than 100.</li>";
		}
		
				
		if($split_str[1] == 'M'){
				
			//echo "PASTAERS"; exit();
			
			if(!is_numeric($this->input->post('appl_pg_pct'))){
				$isValidationFailed = true;
				$marks_flag = false;
				$errorMessage .= "<li>Some wrong in your application. marks should be in neumeric format only.</li>";
			}
			if($marks_flag && $pg_marks > 100){
				$isValidationFailed = true;
				$marks_flag = false;
				$errorMessage .= "<li>Some wrong in your application. Percentage of marks should be iless than 100.</li>";
			}
			
			
			
			if($marks_flag){
				if($pg_marks< $criteriaMarks   &&  $ug_marks < $criteriaMarks){
					$isValidationFailed = true;
					$errorMessage .= "<li>Your are not elligible for application.</li>";
				}
			} 			
		}else{
			//echo $_POST['appl_last_exam']. "ABCJELORS"; exit();
			$pg_marks = 0;
			if($marks_flag && $ug_marks >= $criteriaMarks){
			}else{
				$isValidationFailed = true;
				$errorMessage .= "<li>Your are not elligible for application.</li>";
			}
		}

		
		//------------------- MARKS CALCULATIONS --------------- : END
		if($isValidationFailed){
			//$data = $this->initFormOne($data);
			$this->session->set_flashdata('failure', $errorMessage);	
			redirect('admissions/admstepone/failed');
		}else{
			redirect('admissions/admsteptwo');
		}
	}
	
	function admsteptwo($redirection=null){
		$tempData = $this->session->userdata('StepOneAppl');
		$data = array();
		$data = $this->initFormTwo($data);
		
		if($redirection == 'failed'){
			$data = $this->setFormTwoFromSession($data);
		}else{
			$data = $this->resetFormTwo($data);
		}	
		
		$data['appl_name'] 			= $tempData['appl_name'];
		$data['appl_ctgr'] 			= $tempData['appl_ctgr'];
		$data['appl_reservation'] 	= $tempData['appl_reservation'];
		$data['appl_is_pwd'] 		= $tempData['appl_is_pwd'];
		$data['appl_last_exam'] 	= $tempData['appl_last_exam'];
		$data['appl_method_type'] 	= $tempData['appl_method_type'];
		$data['appl_method_paper1'] = $tempData['appl_method_paper1'];
		$data['appl_method_paper2']	= $tempData['appl_method_paper2'];
		$data['appl_dep_org_name'] 	= $tempData['appl_dep_org_name'];
		$data['appl_dep_org_addr'] 	= $tempData['appl_dep_org_addr'];
		$data['appl_dep_apnt_date'] = $tempData['appl_dep_apnt_date'];
		$data['appl_dep_apprv_date']= $tempData['appl_dep_apprv_date'];
		$data['appl_mp_pct'] 	= $tempData['appl_mp_pct'];
		$data['appl_hs_pct'] 	= $tempData['appl_hs_pct'];
		$data['appl_ug_pct'] 	= $tempData['appl_ug_pct'];
		$data['appl_ug_ctgry'] 	= $tempData['appl_ug_ctgry'];
		$data['appl_pg_pct']	= $tempData['appl_pg_pct'];
		
		$pgPresent = false;
		$arr = explode('-', $tempData['appl_last_exam']);
		if($arr[1]=='M'){
			$pgPresent = true;
		}
		$data['pg_present'] = $pgPresent;
		
		$data['page_title'] = "Admission Form for B.Ed Courses";
		$this->load->view('web_header', $data);
		$this->load->view('admissions/admsteptwo', $data);
	}
	
	function submitsteptwo(){
		//$this->output->enable_profiler(TRUE);
		$sessOneData = $this->session->userdata('StepOneAppl');
		
		$appl_data = array();
		$appl_data = $this->setFormTwoFromRequest($appl_data);
		$this->session->set_userdata('StepTwoAppl', $appl_data);
		
		//print_r($this->session->userdata('StepOneAppl')); print_r($this->session->userdata('StepTwoAppl')); exit();
		
		$isValidationFailed = false;
		$errorMessage = "";
		
		if($sessOneData == null ){
			$isValidationFailed = true;
			$errorMessage .= "<li>There are some problem in your application.</li>";
		}
		
		//application date validation
		$retResult = $this->applDateValidate($errorMessage); 
		if(!$retResult['status']){
			$isValidationFailed = true;
		}
		$errorMessage.=$retResult['msg'];
		
		if($isValidationFailed){
			$this->session->set_flashdata('failure', $errorMessage);	
			redirect('admissions/admsteptwo/failed');
		}else{
			$results = $this->admissionmodel->saveApplicationData();
			
			//print_r($results); exit();
			
			if($results['status'] == 1){
				$this->session->set_userdata('StepOneAppl', null);
				$this->session->set_userdata('StepTwoAppl', null);
				$this->session->set_flashdata('success', 'Record saved succesfully');
				
				//TRIGGERED SMS AND MAIL
				$this->session->set_userdata('student', $results);				
				redirect('students/studentlogin/' . $results['appl_code']);
			}else{
				$this->session->set_flashdata('failure', 'Record not saved succesfully');	
				redirect('admissions/pgadmsteptwo/failed');
			}
		}
		
	}
	
	function getMethodOnePaperOptionByMethodType(){
		$result = $this->configmodel->getMethodOnePaperOptionByMethodType($_REQUEST['appl_method_type']);
		echo json_encode($result);
	}
	
	function getMethodTwoPaperOptionByMethodOnePaper(){
		$result = $this->configmodel->getMethodTwoPaperOptionByMethodOnePaper($_REQUEST['appl_method_paper1']);
		echo json_encode($result);
	}


	function pgadmedit($appl_code = null) {
		//application date validation
		$errorMessage = "";
		$isValidationFailed = false;
		$retResult = $this->applDateValidate($errorMessage); 
		if(!$retResult['status']){
			$isValidationFailed = true;
		}
		$errorMessage.=$retResult['msg'];
		
		$data = $this->admissionmodel->getApplicationData($this->session->userdata('appl_code'));
		$data = $this->initFormOne($data);
		$data = $this->initFormTwo($data);
		
		
		$data['page_title'] = "Student Application Modification";
		$data['appl_last_date'] = $this->configmodel->getScheduleDateByName('AED');
		
		$data['dateFlag'] = 'TRUE';
		if($isValidationFailed){
			$this->session->set_flashdata('failure', $errorMessage);	
			$data['dateFlag'] = 'FALSE';
		}
		
		//echo $appl_code; print_r($data); exit();
		
		$this->load->view('web_header', $data);
		$this->load->view('admissions/editpgadm_student', $data);
	}	
	

	function pgadmupdate(){
		$status = FALSE;

		$isValidationFailed = false;
		$retResult = $this->applDateValidate($errorMessage); 
		if(!$retResult['status']){
			$isValidationFailed = true;
		}
		
		if($isValidationFailed){
			$this->session->set_flashdata('failure', $errorMessage);	
			$dateFlag = 'FALSE';
		}else{
			$status = $this->admissionmodel->updateApplicationData();	
		}
		
		if($status == TRUE){
			$this->session->set_flashdata('success', 'Record uodated succesfully');
		}else{
			$this->session->set_flashdata('failure', 'Record not updated succesfully');	
		}
		redirect('admissions/pgadmedit/'.$_REQUEST['appl_code']);
	}
	
	//----------------------------------------------------------------------------
	//payment revoke
	function revokepayment(){
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"
			  || $this->session->userdata['user']['user_role'] == "Verifier"){
				$data['info'] = null;
				$data['page_title'] = "Student Payment Information";
				$this->load->view('header', $data);
				$this->load->view('admissions/revokepayment', $data);
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	
	//update revoke payment
	function updaterevokepayment() {
		$status = $this->admissionmodel->updateRevokePayment($_REQUEST['appl_code']);
		if($status) {
			echo 'TRUE';
		}
	}
	
	//payment revoke
	function confirmpayment(){
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"
			  ||$this->session->userdata['user']['user_role'] == "Staff" || $this->session->userdata['user']['user_role'] == "Verifier"){
				$data['info'] = null;
				$data['page_title'] = "Student Information";
				$this->load->view('header', $data);
				$this->load->view('admissions/confirmpayment', $data);
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	
	//update confirm payment
	function updateconfirmpayment() {
		//$this->output->enable_profiler(TRUE);
		$status = $this->admissionmodel->updateConfirmPayment();
		if($status) {
			echo 'TRUE';
		}
	}
	
	//download application form
	function downloadapplform($appl_code=null) {
			
		//print_r($this->session->getuserdata()); exit();
		
		if($appl_code != null) {
		}else{
			$appl_code = $this->session->userdata('appl_code');			
		}
		$form = $this->admissionmodel->getApplicationData($appl_code);
		
		$this->load->library('pdf');
		if($form != NULL) {
			//print_r($form);
			$this->pdf->convert_html_applform_to_pdf($form, "Application-".$appl_code);	
		}
	}
	
	//download rank card
	function downloadrankcard($appl_code=null) {
		if($appl_code==null){
			$appl_code = $this->session->userdata('appl_code');
		}
		//echo $appl_code; exit();
		
		$ranks = $this->admissionmodel->getRankCardInfo($appl_code);
		$this->load->library('pdf');
		if($ranks != NULL) {
			//print_r($ranks);
			$this->pdf->convert_html_rank_to_pdf($ranks, "Rankcard-".$appl_code);	
		}
	}

	
	//----------------------------------------------------------------------------
//================================== BELOW METHODS NOT USED AS OFF NOW ===================


}

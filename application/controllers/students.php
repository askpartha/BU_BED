<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Students extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper( array('url', 'form', 'text') );
		$this->load->library('authenticate', 'session');
		$this->load->library('foto');
		$this->load->model('configmodel');
		$this->load->model('usermodel');
		$this->load->model('admissionmodel');
		$this->load->model('studentmodel');
		$this->load->model('resultmodel');
	}

	//student login
	function studentlogin($redirect=null) {
		//echo $this->session->userdata['student']['appl_passwd'];
		//echo $this->session->userdata['student']['appl_passwd'];
		//echo $redirect; exit();
		
		if($redirect!=null){
			if($this->authenticate->authenticate_student($redirect, $this->session->userdata['student']['appl_passwd']) && $this->authenticate->is_logged_in()) {	
				redirect('students/dashboard');
			} else {
				$this->session->set_flashdata('failure', 'Authentication failed');
				redirect('students/studentlogin');
			}	
		}else{
			if($this->input->post('appl_num')) {
				if ($this->authenticate->authenticate_student($this->input->post('appl_num'), $this->input->post('appl_passwd')) && $this->authenticate->is_logged_in()) {
					redirect('students/dashboard');
				} else {
					$this->session->set_flashdata('failure', 'Authentication failed');
					redirect('students/studentlogin');
				}	
			} 
		}
		$data['page_title'] = "Student Login";
		$this->load->view('students/login', $data);
	}
	
	//student dashboard :Done
	function dashboard() {
		if ( !$this->authenticate->is_logged_in()) {
			redirect('students/studentlogin');
		} else {
			$data['page_title'] = "Student Dashboard";
			$data['apl_last_date'] = $this->configmodel->getScheduleDateByName('AED');
			$data['apl_result_date'] = $this->configmodel->getScheduleDateByName('RPD');
			$this->load->view('web_header', $data);
			$this->load->view('students/dashboard', $data);
		}
	}

	//student upload photo : Done
	function uploadphoto() {
		if ( !$this->authenticate->is_logged_in()) {
			redirect('students/studentlogin');
		} else {
			if($this->input->post('pg_appl_code')){
				$status = true;
				$filename = $_FILES['upload']['name'];
				if($filename != "") {
					$file_arr = explode(".", $filename);
				
					$path = realpath(APPPATH . '../upload/students/profile_pic');
				
					$new_img_name = $this->input->post('pg_appl_code') . "." . $file_arr[1];
					$new_img_name = strtolower($new_img_name);
					$new_img_path = $path . "/" . $new_img_name;
					
					//$smImgPath = $path . "/s_" . $new_img_name;
					$thumbImgPath = $path . "/t_" . $new_img_name;

					//upload the photo
					move_uploaded_file($_FILES['upload']['tmp_name'], $path . "/" . $new_img_name);
					
					//resize photos
					//$this->foto->resizePhoto($new_img_path, $smImgPath, 240, 240, 1);
					$status = $this->foto->resizePhoto($new_img_path, $thumbImgPath, 90, 90, 1);
					@unlink($new_img_path);
					$this->studentmodel->updateProfilePic($this->input->post('pg_appl_code'), $new_img_name); //update DB
				}	
				if($status){
					$this->session->set_flashdata('success', 'Photo Uploaded successfully');	
				}else{
					$this->session->set_flashdata('failure', $status);
				}

				redirect('students/uploadphoto');
			} else {
				$data['page_title'] = "Upload Photo";
				$this->load->view('web_header', $data);
				$this->load->view('students/uploadphoto', $data);
				
			}
		}
	}

	//reset password
	function resetpasswd() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				$data['info'] = null;
				$data['page_title'] = "Reset Student Password";
				$this->load->view('header', $data);
				$this->load->view('students/resetpasswd', $data);
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	
	//application download
	function application(){
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"
			  ||$this->session->userdata['user']['user_role'] == "Staff" || $this->session->userdata['user']['user_role'] == "Verifier"){
				$data['info'] = null;
				$data['page_title'] = "Student Application Information";
				$this->load->view('header', $data);
				$this->load->view('students/application', $data);
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	
	//search applicatin basics	
	function searchappl(){
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"
			  ||$this->session->userdata['user']['user_role'] == "Staff" || $this->session->userdata['user']['user_role'] == "Verifier"){
					
				$data['info'] = $this->studentmodel->getApplBasicDetails();
				
				if($this->input->post('user_action') == 'resetpassword' && ($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center")){
					$data['page_title'] = "Reset Student Password";
					$this->load->view('header', $data);
					$this->load->view('students/resetpasswd', $data);
				}
				if($this->input->post('user_action') == 'application'){
					$data['page_title'] = "Student Application Information";
					$this->load->view('header', $data);
					$this->load->view('students/application', $data);
				}
				if($this->input->post('user_action') == 'prepayment' && ($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center" || $this->session->userdata['user']['user_role'] == "Verifier")){
					$data['page_title'] = "Student Information";
					$this->load->view('header', $data);
					$this->load->view('admissions/confirmpayment', $data);
				}
				if($this->input->post('user_action') == 'payment' && ($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center" || $this->session->userdata['user']['user_role'] == "Verifier")){
					$data['page_title'] = "Student Payment Information";
					$this->load->view('header', $data);
					$this->load->view('admissions/revokepayment', $data);
				}
				
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	
	//generate random password
	function generatepasswd() {
		$new_passwd = $this->configmodel->randomString(8);
		$modified_by = $this->session->userdata['user']['user_name']; //user from session
		$status = $this->studentmodel->updatePassword($_REQUEST['appl_code'], $new_passwd, $modified_by);
		if($status) {
			echo $new_passwd;
		}
	}
	
	//change password : Done
	function changepass() {
		if ( !$this->authenticate->is_logged_in()) {
			redirect('students/studentlogin');
		} else {
			if($this->input->post('pg_appl_password')){
				$modified_by = 'student';
				$status = $this->studentmodel->updatePassword($this->session->userdata('appl_code') , $this->input->post('pg_appl_password'), $modified_by);
				if($status){
					$this->session->set_flashdata('success', 'Password changed successfully');
				}else{
					$this->session->set_flashdata('failure', 'Password change unsuccessful');
				}	
				redirect('students/changepass');
			} else {
				$data['page_title'] = "Change Password";
				$this->load->view('web_header', $data);
				$this->load->view('students/changepass', $data);
			
			}	
		}
	}	

	function results(){
		//$this->output->enable_profiler(TRUE);
		$data['result_notices'] = $this->admissionmodel->getNoticeByCategory('Result');
		$data['page_title'] = "Result for Applied Students";
		
		
		$resPubDate = $this->configmodel->getScheduleDateByName('RPD');
		$todaysDateObj = new DateTime();
		$resPubDateObj = new DateTime($resPubDate);
		
		$result_publication_flag = false;
		
		if(($todaysDateObj >= $resPubDateObj)){
			$result_publication_flag = true;
		}
		//echo $result_publication_flag; exit();
		
		$data['result_publication_flag'] = $result_publication_flag;
		$data['apl_result_date'] = $resPubDate;
		
		$data['cand_category_option'] = $this->configmodel->getCategoryOption();
		$data['cand_ctgry'] = $this->input->post('cand_ctgry');
		if($this->input->post('cand_ctgry') == 'D'){
			$data['cand_ctgry_name'] = 'Deputed';
		}elseif($this->input->post('cand_ctgry') == 'F'){
			$data['cand_ctgry_name'] = 'Freshers';
		}else{
			$data['cand_ctgry_name'] = '';
		}
		if(isset($_POST['cand_ctgry'])){
			$data['result']	= $this->resultmodel->getMeritLists($_POST['cand_ctgry']);
		}else{
			$data['result'] = array();
		}
		
		$this->load->view('web_header', $data);
		$this->load->view('students/results', $data);
	}
	
	
	function forgotpass(){
		$pg_appl_code = $_REQUEST['pg_appl_code'];
		$mobile_number = $_REQUEST['pg_apl_mobile'];
		
		$flag = $this->studentmodel->isApplicationExistsForApplicationCodeMobileNumber($pg_appl_code, $mobile_number);
		
		if($flag){
			$new_passwd = $this->configmodel->randomString(8);
			//$modified_by = $this->session->userdata['user']['user_name']; //user from session
			$modified_by = $pg_appl_code;
			$status = $this->studentmodel->updatePassword($pg_appl_code, $new_passwd, $modified_by);
			if($status) {
				$arr = array(
							"user_name"		=>'', 
							"user_phone"	=>$mobile_number,
							"user_password" =>$new_passwd, 
							"user_email"	=>"",
							);
				echo 'YOUR NEW PASSWORD IS : '.$new_passwd;
				//sendUserPassword($arr);
				//echo "<br/><font color='RED'>New password has send in your registered mobile number.</font>";
			}
		}else{
			echo 'Applicaion Number, Mobile Number combination not available.';
		}
	}
	//============================================== BELOW ARE NOT USED =============================
	//call for SMS notification
	function callfornotify() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" ||  
				$this->session->userdata['user']['user_role'] == "Center") {
					
				$current_page = 1;
				$per_page = (intval($this->input->post('records_per_page')) > 0) ? intval($this->input->post('records_per_page')) : $this->configmodel->getConfigByKey('records_per_page');
					
				$data['studycenter_options'] = $this->configmodel->getStudyCenterOption();
				
				$data['results'] = array('students'=>array());
				$data['records_per_page'] = $per_page;//$this->configmodel->getConfigByKey('records_per_page');
				
				if($this->session->userdata['user']['user_cntr_code'] == '00') {
					$data['cntr_code'] = 'EMPTY';
					$data['subj_code'] = 'EMPTY';
					$data['subject_options'] = array();
				} else {
					$data['cntr_code'] = $this->session->userdata['user']['user_cntr_code'];
					$data['subj_code'] = 'EMPTY';
					$data['subject_options'] = $this->configmodel->getSubjectNameByCenterCodeOption($this->session->userdata['user']['user_cntr_code']);
				}
				if($this->input->post('cntr_code')) {
					
					$data['results'] = $this->studentmodel->getStudentsForNotification($this->input->post('cntr_code'), $this->input->post('subj_code'), $current_page, $per_page);
					$data['cntr_code'] = $this->input->post('cntr_code');
					$data['subj_code'] = $this->input->post('subj_code');
				} 
				
				$data['page_title'] = "Call for Notification";
				$this->load->view('header', $data);
				$this->load->view('students/callfornotify', $data);
					
			} else {
				redirect('users/unauthorised');
			}
		}
	}

	//load for SMS notification by AJAX
	function loadfornotify() {
		if($_REQUEST['cntr_code']) {
			$cntr_code = $_REQUEST['cntr_code'];
		} else {
			$cntr_code = $this->session->userdata['user']['user_cntr_code'];
		}
		$subj_code = $_REQUEST['subj_code'];
		
		$per_page = (intval($_REQUEST['records_per_page']) > 0) ? intval($_REQUEST['records_per_page']) : $this->configmodel->getConfigByKey('records_per_page');
					
		echo json_encode($this->studentmodel->getStudentsForNotification($cntr_code, $subj_code, $_REQUEST['page'], $per_page));
	}				
	
	//send SMS notification
	function sendnotification() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" ||  
				$this->session->userdata['user']['user_role'] == "Center") {
				$this->session->set_userdata('student_sms', $this->input->post('notify_msg'));
				$msg = $this->studentmodel->sendSMSNotification($this->input->post('h_notify'), $this->input->post('notify_msg'));
				if ($msg) {
					$this->session->set_flashdata('success', 'SMS sent succesfully');
					redirect('students/callfornotify');
				}
	
			} else {
				redirect('users/unauthorised');
			}
		}
	}	
}
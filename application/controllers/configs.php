<?php
class Configs extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper( array('url', 'form', 'text') );
		$this->load->library('authenticate', 'session');
		$this->load->model('usermodel');
		$this->load->model('configmodel');		
	}

	//list all sessions
	function sessions() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['sessions'] = $this->configmodel->getAllSessions();
				$data['page_title'] = "Configure Sessions";
				$this->load->view('header', $data);
				$this->load->view('configs/sessions', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	// load list of sessions in AJAX 
	function loadsessions() {
		echo json_encode($this->configmodel->getAllSessions());
	}	
	
	//add session item
	function createsession() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createSession();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/sessions');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->configmodel->updateSession();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('configs/sessions');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	//delete session item
	function delsession() {
		echo $this->configmodel->deleteSession($_POST['id']);
	}	
	
	
	//list all religions
	function religions() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['religions'] = $this->configmodel->getAllreligions();
				$data['page_title'] = "Configure religions";
				$this->load->view('header', $data);
				$this->load->view('configs/religions', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	// load list of religions in AJAX 
	function loadreligions() {
		echo json_encode($this->configmodel->getAllreligions());
	}	
	
	//add religion item
	function createreligion() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createreligion();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/religions');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->configmodel->updatereligion();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('configs/religions');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	//delete religion item
	function delreligion() {
		echo $this->configmodel->deletereligion($_POST['id']);
	}
	
	
	//list all reservation
	function reservations() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['reservations'] = $this->configmodel->getAllReservation();
				$data['page_title'] = "Configure Reservations";
				$this->load->view('header', $data);
				$this->load->view('configs/reservations', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	// load list of reservation in AJAX 
	function loadreservations() {
		echo json_encode($this->configmodel->getAllReservation());
	}	
	
	//add reservation item
	function createreservation() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createReservation();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/reservations');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->configmodel->updateReservation();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('configs/reservations');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	//delete reservation item
	function delreservation() {
		echo $this->configmodel->deleteReservation($_POST['id']);
	}	
	
	
	//list all courses
	function courses() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['cors_ctgry_options'] = $this->configmodel->getCourseTypeOption();
				$data['courses'] = $this->configmodel->getAllCourses();
				$data['page_title'] = "Configure Courses";
				$this->load->view('header', $data);
				$this->load->view('configs/courses', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	// load list of courses in AJAX 
	function loadcourses() {
		echo json_encode($this->configmodel->getAllCourses());
	}	
	
	//add course item
	function createcourse() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createCourse();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/courses');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->configmodel->updateCourse();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('configs/courses');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	//delete course item
	function delcourse() {
		echo $this->configmodel->deleteCourse($_POST['id']);
	}	

	
	//list all organization
	function organizations() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['organization_category_options'] 	= $this->configmodel->getOrganizationCategoryOption();
				$data['state_options'] 	= $this->configmodel->getStateOptionWithCode();
				$data['organizations'] 	= array();//$this->configmodel->getAllOrganizations();
				
				$data['page_title'] = "Configure Organizations";
				$this->load->view('header', $data);
				$this->load->view('configs/organizations', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	// load list of organization in AJAX 
	function loadorganizations() {
		echo json_encode($this->configmodel->getAllOrganizationsByCriteria($_POST['organization_ctgry'], $_POST['organization_state'], $_POST['organization_name']));
	}	
	
	//add organization item
	function createorganization() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createOrganization();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/organizations');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->configmodel->updateOrganization();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('configs/organizations');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	//delete organization item
	function delorganization() {
		echo $this->configmodel->deleteOrganization($_POST['id']);
	}	

	
	
	//list all subjects
	function subjects() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['subjects'] = $this->configmodel->getAllSubjects();
				$data['page_title'] = "Configure Subjects";
				$this->load->view('header', $data);
				$this->load->view('configs/subjects', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	// load list of ug subjects in AJAX 
	function loadsubjects() {
		echo json_encode($this->configmodel->getAllSubjects());
	}	
	
	//add ug subject item
	function createsubject() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createSubject();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/subjects');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->configmodel->updateSubject();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('configs/subjects');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	//delete ug subject item
	function delsubject() {
		echo $this->configmodel->deleteSubject($_POST['id']);
	}		

	
	
	//list all methods
	function methods() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['methods'] = $this->configmodel->getAllMethods();
				$data['page_title'] = "Configure Methods";
				$this->load->view('header', $data);
				$this->load->view('configs/methods', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	// load list of methods in AJAX 
	function loadmethods() {
		echo json_encode($this->configmodel->getAllMethods());
	}	
	
	//add methods item
	function createmethod() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createMethod();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/methods');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->configmodel->updateMethod();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('configs/methods');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	//delete methods item
	function deleteMethod() {
		echo $this->configmodel->deleteMethod($_POST['id']);
	}		

	
	
	//list all method subjects
	function methodsubjects() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['methodsubject'] = $this->configmodel->getAllMethodTypeMethodSubjectAssoc();
				
				$data['methods_option'] = $this->configmodel->getAllMethodsOption();
				$data['subjects_option'] = $this->configmodel->getAllSubjectsOption();
				$data['page_title'] = "Configure Method Subject Association";
				$this->load->view('header', $data);
				$this->load->view('configs/methodsubjects', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	// load list of methods in AJAX 
	function loadmethodsubjects() {
		echo json_encode($this->configmodel->getAllMethodTypeMethodSubjectAssoc());
	}	
	
	//add methods subject item
	function createmethodsubject() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createMethodTypeMethodSubjectAssoc();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/methodsubjects');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->configmodel->updateMethodTypeMethodSubjectAssoc();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('configs/methodsubjects');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	//delete methods subject item
	function deletemethodsubject() {
		echo $this->configmodel->deleteMethodTypeMethodSubjectAssoc($_POST['id']);
	}		

	

	//list all schedule
	function schedules() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				$data['schedule_options'] = $this->configmodel->getApplicationDateCategoryOption();
				$data['schedule_type_options'] = $this->configmodel->getScheduleTypeOption();
				$data['schedules'] = $this->configmodel->getAllSchedules();
				$data['page_title'] = "Configure Schedules";
				$this->load->view('header', $data);
				$this->load->view('configs/schedules', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	// load list of pg subjects in AJAX 
	function loadschedules() {
		echo json_encode($this->configmodel->getAllSchedules());
	}	
	
	//add schedule item
	function createschedule() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createSchedule();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/schedules');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->configmodel->updateSchedule();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('configs/schedules');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	//delete schedules item
	function delschedule() {
		echo $this->configmodel->deleteSchedule($_POST['id']);
	}		

	
	
	//list all seats
	function seats() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				//$data['method_type_options'] 	= $this->configmodel->getAllMethodsOption();
				//$data['cand_category_option'] 		= $this->configmodel->getCategoryOption();
				//$data['reservation_options'] 	= $this->configmodel->getReservationOption();
				//$data['yesno_options'] 	= $this->configmodel->getYesNoOption();
				
				$data['seats'] = $this->configmodel->getAllSeats();
				$data['page_title'] = "Configure Seat Matrix";
				$this->load->view('header', $data);
				$this->load->view('configs/seats', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	// load list of seats in AJAX 
	function loadseats() {
		echo json_encode($this->configmodel->getAllSeats());
	}	
	
	//add seat item
	function createseat() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createSeat();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/seats');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->configmodel->updateSeat();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('configs/seats');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	//delete seat item
	function delseat() {
		echo $this->configmodel->deleteSeat($_POST['id']);
	}		

	//undergraduate and postgraduate subject relation
	function pgbbsubjects() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['pgsubject_options'] = $this->configmodel->getPostGraduateUnderGraduateSubjectOption();
				$data['ugsubject_options'] = array();//$this->configmodel->getPostGraduateSubjectOptionByCollege();
				$data['page_title'] = "Association between Post Graduate Subjects and Under Graduate Subjects";
				$this->load->view('header', $data);
				$this->load->view('configs/pgsubjects', $data);
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	
	// load list of ug subjects for pg subjects in AJAX 
	function loadpsdgsubjects() {
		echo json_encode($this->configmodel->getUnderGraduateSubjectOptionByPostGraduateSubject($_POST['pg_subj_code']));
	}
	
	//save pg ug subject relation
	function pgugsubjectassoc() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createPostGraduateUnderGraduateSubjectAssoc();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/pgsubjects');	
				} 
			} else {
				redirect('users/unauthorised');
			}
		}
	}

	
}

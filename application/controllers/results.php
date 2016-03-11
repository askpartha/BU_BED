<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Results extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper( array('url', 'form', 'text') );
		$this->load->library('authenticate', 'session');
		$this->load->model('configmodel');
		$this->load->model('resultmodel');
	}
	
	//generatemerits
	function generatemerits() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center") {
				$data['page_title'] = "Generate Merit List";
				$data['cand_category_option'] = $this->resultmodel->getNonGenaratedMeritCatgeory();
				$this->load->view('header', $data);
				$this->load->view('results/generatemerits', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	//revokemerits
	function revokemerits() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center") {
				$data['page_title'] = "Generate Merit List";
				$data['cand_category_option'] = $this->resultmodel->getGenaratedMeritCatgeory();
				$this->load->view('header', $data);
				$this->load->view('results/revokemerits', $data);
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	
	//method name option based on category
	function getmethodoption(){
		if($_REQUEST['type'] == 'true'){//fetch the method where the merit list did not generated
			echo json_encode($this->resultmodel->getNonGenMethodList($_REQUEST['cand_ctgry']));
		}else{
			echo json_encode($this->resultmodel->getGenMethodList($_REQUEST['cand_ctgry']));
		}
	}
	
	//method name option based on category
	function getmeritlistoption(){
		echo json_encode($this->resultmodel->getMeritListOption($_REQUEST['cand_ctgry']));
	}

	//generate merit list
	function generatemeritlist(){
		$status = $this->resultmodel->GenerateMeritList($_REQUEST['cand_ctgry']);
		echo $status;
	}
	
	//revoke merit list
	function revokemeritlist(){
		$status = $this->resultmodel->RevokeMeritList($_REQUEST['cand_ctgry']);
		echo $status;
	}

	
	//load payments by AJAX
	function loadmerits() {
		$per_page = $this->configmodel->getConfigByKey('records_per_page');
		echo json_encode($this->reportmodel->getAllPaymentsByDay($_REQUEST['date'], $_REQUEST['page'], $per_page));
	}

}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper( array('url', 'form', 'text') );
		$this->load->library('authenticate', 'session');
		$this->load->model('reportmodel');
		$this->load->model('resultmodel');
		$this->load->model('admissionmodel');
		$this->load->model('configmodel');
	}
	
	//payments
	function payments() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Staff" ||
			$this->session->userdata['user']['user_role'] == "Center" || $this->session->userdata['user']['user_role'] == "Verifier" ) {
				$data['page_title'] = "Payment Report";
				$this->load->view('header', $data);
				$this->load->view('reports/payments', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	//load payments by AJAX
	function loadpayments() {
		$per_page = $this->configmodel->getConfigByKey('records_per_page');
		echo json_encode($this->reportmodel->getAllPaymentsByDay($_REQUEST['date'], $_REQUEST['page'], $per_page));
	}

	//download payments in excel
	function downloadpayments() {
		$this->load->library("excel");
		$this->excel->setActiveSheetIndex(0);
		$filename = "payments" . date('Ymdhis'). ".xls";
		$data = $this->reportmodel->getAllChallansForDownload();
		$this->excel->create_excel($filename, $data);
	}
	
	//download meritlist in pdf
	function meritlists() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			$data['result']	= array();
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center") {
				$data['page_title'] = "Download Merit Lists";
				$this->load->view('header', $data);
				
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
				}
				
				$this->load->view('reports/meritlists', $data);
			} else {
				redirect('users/unauthorised');
			}
		}
	}

	function downloadmerits($resv_code, $merit_type_no, $page_no){
		//$this->output->enable_profiler(TRUE);
		//if ( !$this->authenticate->is_logged_in()) {
		//	redirect('users/login');
		//} else {
			//if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center") {
				//echo $resv ." ". $method_type . "  " . $cand_ctgry . "   ". $page_no . "\n"; exit();
				$this->load->library('pdf');
				
				$form = $this->resultmodel->getMeritListData($resv_code, $merit_type_no, $page_no);
				
				if($form != NULL) {
					$form['header'] = admissionName() . "PROVISIONAL RANKLIST OF <br/> SESSION -" . getCurrentSession();
					$form['univ_logo'] = $this->config->base_url() . 'assets/img/bu_logo90.jpg';
					$this->pdf->convert_html_meritlist_to_pdf($form, 'MERIT-LIST-'.$form['info']['cand_ctgry_name']."-".$form['info']['resv_name']);	
				}
				
			//} else {
			//	redirect('users/unauthorised');
			//}
		//}
	}

	function notifications($init=null){
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center") {
				$data['page_title'] = "Notification";
				$this->load->view('header', $data);
				$data['cand_category_option'] = $this->configmodel->getCategoryOption();
				if($init != 'AGFTYUIJJDPJJDKLLDJJHGGGGD'){
					$this->reportmodel->downloadORsendNotification();
					exit();
				}
				$this->load->view('reports/notifications', $data);
			} else {
				redirect('users/unauthorised');
			}
		}
		
	}	
}
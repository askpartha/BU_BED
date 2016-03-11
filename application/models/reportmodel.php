<?php
class Reportmodel extends CI_Model {
    function __construct() {
        parent::__construct();
		$this->load->database();
		$ci = get_instance();
		$ci->load->helper('string');
    }
    
	//get dashboard stats
	function getDashboardStats() {
		
		$sql = "SELECT COUNT(appl_code) AS total_form, 
						(SELECT COUNT(appl_code) FROM bed_application WHERE appl_status > 0 ) AS total_application,
						(SELECT COUNT(appl_code) FROM bed_application WHERE appl_status > 1 ) AS total_payment,
						(SELECT COUNT(appl_code) FROM bed_application WHERE appl_status > 2 ) AS total_confirm,
						(SELECT COUNT(appl_code) FROM bed_application WHERE appl_status = 9 ) AS total_appl_rejected
				FROM bed_application 
				WHERE appl_sl_no > 0 ";
				
		$r = $this->db->query($sql)->result();
		return array('stats'	=>	$r);		
	}
	

	//get all challans by day count
	function getAllPaymentsByDayCount($sql) {
		$results = $this->db->query($sql)->result();
		return count($results);
	}
	
	//get all challans by day
	function getAllPaymentsByDay($date, $current_page = 1, $per_page = 1) {
		$p_tbl 	= 'bed_application';
		$u_tbl 	= 'users';
		
		$clause = '';
		if($this->session->userdata['user']['user_role'] == "Verifier"){
			$clause = " AND appl_verified_by = '" . $this->session->userdata['user']['user_name'] ."'";
		}
		
		$sql = "SELECT DISTINCT appl_code, appl_ctgr, appl_name, appl_status, appl_pmt_code, appl_pmt_type, 
				appl_verified_by, appl_verified_on, user_firstname, user_lastname
				FROM bed_application
				LEFT OUTER JOIN users ON user_name = appl_verified_by
				WHERE appl_verified_on = '" . convertToMySqlDate($date) . "' AND appl_status = 2 " . $clause;
				
		//get data for pagination
		$total_results = $this->getAllPaymentsByDayCount($sql);
		$total_pages = ceil($total_results / $per_page);
		$offset = ($current_page - 1) * $per_page;
		$paginate = array('total_records'	=>	$total_results,
						  'total_pages'		=>	$total_pages,
						  'current_page'	=>	$current_page
						 );
		$sql .= " ORDER BY appl_verified_on, appl_ctgr, appl_name ";				 
		$sql .= " LIMIT " . $offset . ", " . $per_page;

		//echo $sql; exit();

 		$r = $this->db->query($sql)->result();
		$results = array();	
		
		for($i=0; $i<count($r); $i++) {
			$results[$i] = array(
									'appl_code'			=>	$r[$i]->appl_code,
									'appl_ctgr'			=>	$r[$i]->appl_ctgr,
									'appl_name'			=>	$r[$i]->appl_name,
									'appl_status'		=>	getApplicationStatus($r[$i]->appl_status),
									'appl_pmt_code'		=>	$r[$i]->appl_pmt_code,
									'appl_pmt_type'		=>	$r[$i]->appl_pmt_type,
									'appl_verified_by'	=>	getFullname($r[$i]->user_firstname, '', $r[$i]->user_lastname),
									'appl_verified_on'	=>	getDateFormat($r[$i]->appl_verified_on),
								);
		}
		$payments = array('payments'	=>	$results, 'search_date' =>  $date, 'paginate'	=>	$paginate);
		
		return $payments;		
	}


	function downloadORsendNotification(){
		$this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
       
	    $info_details_array = $this->resultmodel->getSeatInfoDetailsById($_REQUEST['merit_type']);
		
	    $col_merit_ctgr = "appl_". $info_details_array['reservation'] ."_merit_ctgr";
		$col_merit 		= "appl_". $info_details_array['reservation'] ."_merit";
		$resv_code 		= $info_details_array['reservation'];
		if($info_details_array['pwd'] == 1){
			$col_merit_ctgr = 'appl_pwd_merit_ctgr';
			$col_merit 		= 'appl_pwd_merit';
			$resv_code		= 'pwd';
		}
		
        $query = $this->db->query("SELECT appl_ctgr as 'CATEGORY', appl_code as 'APPLICATION CODE', appl_name as 'APPLICATION NAME', appl_phone as 'MOBILE NO',
        								  method_name as 'METHOD NAME', subj_name AS 'SUBJECT NAME', ".$col_merit." AS 'RANK' 
        						   FROM bed_application
        						   LEFT OUTER JOIN cnf_method ON method_code = appl_method_type
        						   LEFT OUTER JOIN cnf_subjects ON subj_code = appl_method_paper1 
        						   WHERE 
        						   		appl_status = 3 AND 
								 	   " . $col_merit_ctgr . " like '". $info_details_array['sl_no'] ."' AND
								 	   " . $col_merit . " >= " . $_REQUEST['start_rank'] . " &&  " . $col_merit . " <= " . $_REQUEST['end_rank'] . "
								 ORDER BY " . $col_merit . " ASC");
       
	    $delimiter = ",";
        $newline = "\r\n";
        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
        force_download('CSV_Notification_Report.csv', $data);	
	}
	
}
?>
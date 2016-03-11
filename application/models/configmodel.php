<?php
class Configmodel extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->database();
		$ci = get_instance();
		$ci->load->helper('string');
    }
	
	//random code genaration
	function randomString($length) {
		$key = '';
		$keys = array_merge(range(0, 9), range('A', 'Z'));

		for ($i = 0; $i < $length; $i++) {
			$key .= $keys[array_rand($keys)];
		}

		return $key;
	}
	
	function getConfigByKey($key) {
		switch ($key) {
		case "records_per_page":
			$msg = 500;
			break;
		case "1":
			$msg = "<span class='label label-info'>Application Submitted</span>";
			break;
		case "2":
			$msg = "<span class='label label-primary'>Payment Confirmed</span>";
			break;
		case "3":
			$msg = "<span class='label label-success'>Application Confirmed</span>";
			break;	
		case "4":
			$msg = "<span class='label label-success'>Admission Confirmed</span>";
			break;	
		case "9":
			$msg = "<span class='label label-danger'>Application Cancelled</span>";
			break;			
		}
		return $msg;
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
	
	
	//get category dropdown
	function getCategoryOption() {
		$arr = array("EMPTY"=>"", "F"=>"Freshers", "D"=>"Deputed");
		return $arr;
	}
	
	//get yes/no dropdown
	function getYesNoOption() {
		$arr = array("0"=>"No", "1"=>"Yes" );
		return $arr;
	}
	
	//get applicate date category
	function getApplicationDateCategoryOption() {
		$arr = array("EMPTY"=>"", "ASD"=>"Application Start Date", "AED"=>"Application End Date", "PED"=>"Payment Submission Last Date", "RPD"=>"Result Publication Date");
		return $arr;
	}
	
	//get applicationnotices dropdown
	function getAllNoticesCategoryOption() {
		$arr = array("EMPTY"=>"", "Application"=>"Application", "Admission"=>"Admission", "Result"=>"Result", "Admit"=>"Admit", "Rankcard"=>"Rank Card", "General"=>"General");
		return $arr;
	}
	
	//get gender category options
	function getGenderOption() {
		$arr = array("EMPTY"=>"", "M"=>"Male", "F"=>"Female");
		return $arr;
	}
	
	//get under graduate category options
	function getUGCategoryOption() {
		$arr = array("EMPTY"=>"", "G"=>"GENERAL", "H"=>"HONOURS");
		return $arr;
	}
	
	function getCourseTypeOption() {
		$arr = array("EMPTY"=>"", "B"=>"Bachelor", "M"=>"Masters");
		return $arr;
	}
	
	//get gurdian realtion options
	function GurdianOption(){
		$arr = array("EMPTY"=>"", "F"=>"Father", "M"=>"Mother", "H"=>"Husband" , "S"=>"Sister", "B"=>"Brother", "O"=>"Other");
		return $arr;
	}
	
	function NationalityOption(){
		$arr = array("EMPTY"=>"", "I"=>"Indian", "O"=>"Other");
		return $arr;
	}
	
	//get schedule type options
	function getScheduleTypeOption() {
		$arr = array("EMPTY"=>"", "S"=>"Start", "E"=>"End");
		return $arr;
	}
	
	//get organization category options
	function getOrganizationCategoryOption() {
		$arr = array("EMPTY"=>"", "1"=>"Secondary Board", "2"=>"Higher Secondary Board", "3"=>"University");
		return $arr;
	}
	
	//get user role for the dropdown
	function getRoleOption() {
		$arr = array("EMPTY"=>"","Admin"=>"Admin", "Center"=>"Center", "Staff" => "Staff", "Verifier" => "Verifier");
		return $arr;
	}	
	
	function getStateOptionWithoutCode() {
		$sql = "SELECT state_name FROM cnf_states ORDER BY state_name";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->state_name] = $dropdown->state_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	
	function getStateOptionWithCode() {
		$sql = "SELECT state_name, state_code FROM cnf_states ORDER BY state_name";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->state_code] = $dropdown->state_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	
	function getCourseOption() {
		$sql = "SELECT cors_code, cors_name, cors_ctgry FROM cnf_course WHERE cors_is_active = 1 ORDER BY cors_name";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->cors_code] = $dropdown->cors_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	
	function getCourseCtgryOption() {
		$sql = "SELECT cors_code, cors_name, cors_ctgry FROM cnf_course WHERE cors_is_active = 1 ORDER BY cors_name";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->cors_code.'-'.$dropdown->cors_ctgry] = $dropdown->cors_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	
	function getReservationOption() {
		$sql = "SELECT resv_code, resv_name FROM cnf_reservation WHERE resv_is_active = 1 ORDER BY resv_id";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList = array();
		//$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->resv_code] = $dropdown->resv_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	
	function getSessionOption() {
		$sql = "SELECT sess_val, sess_val FROM cnf_sess WHERE sess_is_active = 1 ORDER BY sess_val DESC";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		//$dropDownList['EMPTY'] = "";
		$dropDownList = array();
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->sess_val] = $dropdown->sess_val;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}	
	
	function getReligionOption() {
		$sql = "SELECT relg_val FROM cnf_relg WHERE relg_is_active = 1 ORDER BY relg_val";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList = array();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->relg_val] = $dropdown->relg_val;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}	
	
	function getMethodOnePaperOptionByMethodType($method_type=null) {
		$mp_tbl = 'cnf_method_paper';
		$s_tbl 	= 'cnf_subjects';	
		
		$sql = "SELECT DISTINCT method_subject1 as subj_code, subj_name
				FROM " . $mp_tbl . " 
				LEFT OUTER JOIN " . $s_tbl . " cs on subj_code=method_subject1
				WHERE cs.subj_is_active = 1 
				AND method_code like '". $method_type ."'  
				ORDER BY subj_name";
		
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList = array();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->subj_code] = $dropdown->subj_name;
        }
    	$finalDropDown = $dropDownList;
       return $query->result_array();
	}
	
	function getMethodTwoPaperOptionByMethodOnePaper($method_one_paper=null) {
		$mp_tbl = 'cnf_method_paper';
		$s_tbl 	= 'cnf_subjects';	
		
		$sql = "SELECT DISTINCT method_subject2 as subj_code, subj_name
				FROM " . $mp_tbl . " 
				LEFT OUTER JOIN " . $s_tbl . " cs on subj_code=method_subject2
				WHERE cs.subj_is_active = 1 
				AND method_subject1 like '". $method_one_paper ."'  
				ORDER BY subj_name";
		
		//echo $sql; exit();
				
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList = array();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->subj_code] = $dropdown->subj_name;
        }
    	$finalDropDown = $dropDownList;
        return $query->result_array();
	}
	
	
	function getAllReservation() {
		$c_tbl = 'cnf_reservation';
		$this->db->select(array('resv_id', 'resv_code', 'resv_name', 'resv_is_active'));
		$this->db->from($c_tbl);
		$this->db->order_by('resv_id', 'asc'); 
		$query = $this->db->get();
		$results = $query->result();
		return $results;
	}
	
	function createReservation() {
		$c_tbl = 'cnf_reservation';
		$created_on = gmdate('Y-m-d H:i:s');
		$created_by = $this->session->userdata['user']['user_id']; //user id from session

		$data = array(
					  'resv_code'		=>	$this->input->post('resv_code'),
				      'resv_name'		=>	$this->input->post('resv_name'),
				      'resv_is_active'	=>	($this->input->post('resv_is_active') == 'on') ? 1 : 0
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	function updateReservation() {
		$c_tbl = 'cnf_reservation';
		$modified_on = gmdate('Y-m-d H:i:s');
		$modified_by = $this->session->userdata['user']['user_id']; //user id from session

		$data = array(
				      'resv_code'		=>	$this->input->post('resv_code'),
				      'resv_name'		=>	$this->input->post('resv_name'),
				      'resv_is_active'	=>	($this->input->post('resv_is_active') == 'on') ? 1 : 0
				    );
		$this->db->where('resv_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	function deleteReservation($id) {
		$c_tbl = 'cnf_reservation';
		$this->db->delete($c_tbl, array('resv_id' => $id)); 
		return "DELETED";
	}		

	
	
	function getAllNotices() {
		$c_tbl = 'cnf_notice';
		$this->db->select(array('notice_id', 'notice_title', 'notice_desc', 'notice_file', 'notice_is_active'));
		$this->db->from($c_tbl);
		$this->db->order_by('notice_id', 'asc'); 
		$query = $this->db->get();
		$results = $query->result();
		return $results;
	}
	
	function createNotice() {
		$c_tbl = 'cnf_notice';
		$created_on = gmdate('Y-m-d H:i:s');
		$created_by = $this->session->userdata['user']['user_id']; //user id from session

		$data = array(
					  'notice_title'		=>	$this->input->post('notice_title'),
				      'notice_desc'			=>	$this->input->post('notice_desc'),
				      'notice_file'			=>	'',
				      'notice_is_active'	=>	($this->input->post('notice_is_active') == 'on') ? 1 : 0,
				      'created_on'			=>	$created_on,
				      'created_by'			=>	$created_by,
				      'modified_on'			=>	$created_on,
				      'modified_by'			=>	$created_by
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	function updateNotice() {
		$c_tbl = 'cnf_notice';
		$modified_on = gmdate('Y-m-d H:i:s');
		$modified_by = $this->session->userdata['user']['user_id']; //user id from session

		$data = array(
				      'notice_title'		=>	$this->input->post('notice_title'),
				      'notice_desc'			=>	$this->input->post('notice_desc'),
				      'notice_file'			=>	'',
				      'notice_is_active'	=>	($this->input->post('notice_is_active') == 'on') ? 1 : 0,
				      'modified_on'			=>	$modified_on,
				      'modified_by'			=>	$modified_by
				    );
		$this->db->where('cors_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	function deleteNotice($id) {
		$c_tbl = 'cnf_notice';
		$this->db->delete($c_tbl, array('resv_id' => $id)); 
		return "DELETED";
	}		

	
	
	function getAllCourses() {
		$c_tbl = 'cnf_course';
		$this->db->select(array('cors_id', 'cors_code', 'cors_name', 'cors_ctgry', 'cors_is_active'));
		$this->db->from($c_tbl);
		$this->db->order_by('cors_name', 'asc'); 
		$query = $this->db->get();
		$results = $query->result();
		return $results;
	}
	
	function createCourse() {
		$c_tbl = 'cnf_course';
		$created_on = gmdate('Y-m-d H:i:s');
		$created_by = $this->session->userdata['user']['user_id']; //user id from session

		$data = array(
					  'cors_code'		=>	$this->input->post('cors_code'),
				      'cors_name'		=>	$this->input->post('cors_name'),
				      'cors_ctgry'		=>	$this->input->post('cors_ctgry'),
				      'cors_is_active'	=>	($this->input->post('cors_is_active') == 'on') ? 1 : 0
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	function updateCourse() {
		$c_tbl = 'cnf_course';
		$modified_on = gmdate('Y-m-d H:i:s');
		$modified_by = $this->session->userdata['user']['user_id']; //user id from session

		$data = array(
				      'cors_code'		=>	$this->input->post('cors_code'),
				      'cors_name'		=>	$this->input->post('cors_name'),
				      'cors_ctgry'		=>	$this->input->post('cors_ctgry'),
				      'cors_is_active'	=>	($this->input->post('cors_is_active') == 'on') ? 1 : 0
				    );
		$this->db->where('cors_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	function deleteCourse($id) {
		$c_tbl = 'cnf_course';
		$this->db->delete($c_tbl, array('cors_id' => $id)); 
		return "DELETED";
	}		

	
	
	function getAllSessions() {
		$c_tbl = 'cnf_sess';
		$this->db->select(array('sess_id', 'sess_val', 'sess_is_active'));
		$this->db->from($c_tbl);
		$this->db->order_by('sess_val', 'desc'); 
		//$this->db->limit($per_page, $offset);
		$query = $this->db->get();
		$results = $query->result();
		return $results;
	}
	
	function createSession() {
		$c_tbl = 'cnf_sess';
		$created_on = gmdate('Y-m-d H:i:s');
		$created_by = $this->session->userdata['user']['user_id']; //user id from session

		$data = array(
				      'sess_val'		=>	$this->input->post('sess_val'),
				      'sess_is_active'	=>	($this->input->post('sess_is_active') == 'on') ? 1 : 0
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	function updateSession() {
		$c_tbl = 'cnf_sess';
		$modified_on = gmdate('Y-m-d H:i:s');
		$modified_by = $this->session->userdata['user']['user_id']; //user id from session

		$data = array(
				      'sess_val'		=>	$this->input->post('sess_val'),
				      'sess_is_active'	=>	($this->input->post('sess_is_active') == 'on') ? 1 : 0
				    );
		$this->db->where('sess_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	function deleteSession($id) {
		$c_tbl = 'cnf_sess';
		$this->db->delete($c_tbl, array('sess_id' => $id)); 
		return "DELETED";
	}
	
	

	function getAllreligions() {
		$c_tbl = 'cnf_relg';
		$this->db->select(array('relg_id', 'relg_val', 'relg_is_active'));
		$this->db->from($c_tbl);
		$this->db->order_by('relg_val', 'desc'); 
		//$this->db->limit($per_page, $offset);
		$query = $this->db->get();
		$results = $query->result();
		return $results;
	}
	
	function createreligion() {
		$c_tbl = 'cnf_relg';
		$created_on = gmdate('Y-m-d H:i:s');
		$created_by = $this->religion->userdata['user']['user_id']; //user id from religion

		$data = array(
				      'relg_val'		=>	$this->input->post('relg_val'),
				      'relg_is_active'	=>	($this->input->post('relg_is_active') == 'on') ? 1 : 0
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	function updatereligion() {
		$c_tbl = 'cnf_relg';
		$modified_on = gmdate('Y-m-d H:i:s');
		$modified_by = $this->religion->userdata['user']['user_id']; //user id from religion

		$data = array(
				      'relg_val'	=>	$this->input->post('relg_val'),
				      'relg_is_active'	=>	($this->input->post('relg_is_active') == 'on') ? 1 : 0
				    );
		$this->db->where('relg_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	function deletereligion($id) {
		$c_tbl = 'cnf_relg';
		$this->db->delete($c_tbl, array('relg_id' => $id)); 
		return "DELETED";
	}	
	
	
	function getAllOrganizations() {
		$c_tbl = 'cnf_organizations';
		$this->db->select(array('organization_id', 'organization_name', 'organization_state', 'organization_ctgry',  'organization_is_active'));
		$this->db->from($c_tbl);
		$this->db->order_by('organization_ctgry', 'asc');
		$this->db->order_by('organization_state', 'asc');
		$this->db->order_by('organization_name', 'asc'); 
		//$this->db->limit($per_page, $offset);
		$query = $this->db->get();
		$results = $query->result();
		return $results;
	}

	function getAllOrganizationsByCriteria($ctgry=null, $state=null, $name=null) {
		$c_tbl = 'cnf_organizations';
		$this->db->select(array('organization_id', 'organization_name', 'organization_state', 'organization_ctgry',  'organization_is_active'));
		$this->db->from($c_tbl);
		if($ctgry != null && $ctgry != ''){
			$this->db->where('organization_ctgry', $ctgry);
		}
		if($state != null && $state != ''){
			$this->db->where('organization_state', $state);
		}
		if($name != null && $name != ''){
			$this->db->like('UPPER(organization_name)', strtoupper('%'.$name.'%'));
		}
		
		//$this->db->where('organization_is_active', 1);
		
		$this->db->order_by('organization_name', 'asc'); 
		$query = $this->db->get();
		$results = $query->result();
		
		return $results;
	}
	
	function getAllOrganizationsOptionByCriteria($ctgry) {
		$sql = "SELECT organization_id, organization_name, organization_state FROM cnf_organizations WHERE organization_is_active = 1 AND organization_ctgry = '".$ctgry."'ORDER BY organization_state, organization_name ";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->organization_id] = $dropdown->organization_state . "-->" . $dropdown->organization_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
		
	}

	function createOrganization() {
		$c_tbl = 'cnf_organizations';
		$created_on = gmdate('Y-m-d H:i:s');
		$created_by = $this->session->userdata['user']['user_id']; //user id from session

		$data = array(
				      'organization_name'		=>	$this->input->post('organization_name'),
				      'organization_state'		=>	$this->input->post('organization_state'),
				      'organization_ctgry'		=>	$this->input->post('organization_ctgry'),
				      'organization_is_active'	=>	($this->input->post('organization_is_active') == 'on') ? 1 : 0
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	function updateOrganization() {
		
		$c_tbl = 'cnf_organizations';
		$modified_on = gmdate('Y-m-d H:i:s');
		$modified_by = $this->session->userdata['user']['user_id']; //user id from session

		$data = array(
				      'organization_name'		=>	$this->input->post('organization_name'),
				      'organization_state'		=>	$this->input->post('organization_state'),
				      'organization_ctgry'		=>	$this->input->post('organization_ctgry'),
				      'organization_is_active'	=>	($this->input->post('organization_is_active') == 'on') ? 1 : 0
				    );
		$this->db->where('organization_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	function deleteOrganization($id) {
		$c_tbl = 'cnf_organizations';
		$this->db->delete($c_tbl, array('organization' => $id)); 
		return "DELETED";
	}	
		
	
	
	function getAllSubjectsOption() {
		$sql = "SELECT subj_code, subj_name FROM cnf_subjects WHERE subj_is_active = 1 ORDER BY subj_name";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->subj_code] = $dropdown->subj_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	
	function getAllSubjects() {
		$c_tbl = 'cnf_subjects';
		
		$this->db->select(array('subj_id', 'subj_code', 'subj_name', 'subj_is_active'));
		$this->db->from($c_tbl);
		$this->db->order_by('subj_name', 'asc'); 
		$query = $this->db->get();
		$results = $query->result();
		return $results;
	}
	
	function createSubject() {
		$c_tbl = 'cnf_subjects';
		$created_on = gmdate('Y-m-d H:i:s');
		$created_by = $this->session->userdata['user']['user_id']; //user id from session

		$data = array(
					  'subj_code'		=>	$this->input->post('subj_code'),
				      'subj_name'		=>	$this->input->post('subj_name'),
				      'subj_is_active'	=>	($this->input->post('subj_is_active') == 'on') ? 1 : 0,
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	function updateSubject() {
		$c_tbl = 'cnf_subjects';
		$modified_on = gmdate('Y-m-d H:i:s');
		$modified_by = $this->session->userdata['user']['user_id']; //user id from session

		$data = array(
				      'subj_code'		=>	$this->input->post('subj_code'),
				      'subj_name'		=>	$this->input->post('subj_name'),
				      'subj_is_active'	=>	($this->input->post('subj_is_active') == 'on') ? 1 : 0,
				    );
		$this->db->where('subj_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	function deleteSubject($id) {
		$c_tbl = 'cnf_subjects';
		$this->db->delete($c_tbl, array('subj_id' => $id)); 
		//also association need to be deleted
		return "DELETED";
	}
	
	
	
	function getAllMethodsOption() {
		$sql = "SELECT method_code, method_name FROM cnf_method WHERE method_is_active = 1 ORDER BY method_name";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->method_code] = $dropdown->method_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	
	function getAllMethods() {
		$m_tbl = 'cnf_method';
		
		$this->db->select(array('method_id', 'method_code', 'method_name', 'method_is_active'));
		$this->db->from($m_tbl);
		$this->db->order_by('method_name', 'asc'); 
		$query = $this->db->get();
		$results = $query->result();
		return $results;
	}
	
	function getMethodNameByCode($method_code) {
		$sql = "SELECT method_name FROM cnf_method WHERE method_code = '".$method_code."'";
		$query = $this->db->query($sql);
		$results = $query->result();
		$method_name = "";
		if(count($results) > 0){
			$method_name = $results[0]->method_name;
		}
		return $method_name;
	}
	
	function getReservationNameByCode($resv_code) {
		if($resv_code == 'pwd'){
			return 'D.A.';
		}
		$sql = "SELECT resv_name FROM cnf_reservation WHERE resv_code = '".$resv_code."'";
		$query = $this->db->query($sql);
		$results = $query->result();
		$resv_name = "";
		if(count($results) > 0){
			$resv_name = $results[0]->resv_name;
		}
		return $resv_name;
	}
	
	function createMethod() {
		$m_tbl = 'cnf_method';

		$data = array(
					  'method_code'		=>	$this->input->post('method_code'),
				      'method_name'		=>	$this->input->post('method_name'),
				      'method_is_active'	=>	($this->input->post('method_is_active') == 'on') ? 1 : 0,
				    );
		$status = $this->db->insert($m_tbl, $data);
		return $status;		
	}
	
	function updateMethod() {
		$m_tbl = 'cnf_method';

		$data = array(
					  'method_code'		=>	$this->input->post('method_code'),
				      'method_name'		=>	$this->input->post('method_name'),
				      'method_is_active'	=>	($this->input->post('method_is_active') == 'on') ? 1 : 0,
				    );
					
		$this->db->where('method_id', $this->input->post('record_id'));					
		$status = $this->db->update($m_tbl, $data);
		return $status;		
	}	
	
	function deleteMethod($id) {
		$m_tbl = 'cnf_method';
		$this->db->delete($m_tbl, array('method_id' => $id)); 
		//also association need to be deleted
		return "DELETED";
	}
	
	
	function getAllSchedules() {
		$c_tbl = 'cnf_schedules';
		
		$this->db->select(array('schedule_id', 'schedule_name', 'schedule_type', 'schedule_date', 'schedule_is_active'));
		$this->db->from($c_tbl);
		$this->db->order_by('schedule_date', 'asc'); 
		$query = $this->db->get();
		$r = $query->result();
		
		$results = array();	
		
		for($i=0; $i<count($r); $i++) {
			//echo $r[$i]->schedule_date . "<br/>";
			$results[$i] = array(
									'schedule_id' 			=>	$r[$i]->schedule_id,
									'schedule_name' 		=> 	$r[$i]->schedule_name,
									'schedule_type' 		=> 	$r[$i]->schedule_type,
									'schedule_date' 		=> 	getDateFormat($r[$i]->schedule_date, 'd-m-Y'),
									'schedule_is_active' 	=> 	$r[$i]->schedule_is_active
								);
		}
		//exit();
		return $results;
	}
	
	function getScheduleDateByName($schedule_name) {
		$c_tbl = 'cnf_schedules';
		
		$this->db->select(array('schedule_id', 'schedule_date', 'schedule_is_active'));
		$this->db->from($c_tbl);
		$this->db->where('schedule_name', $schedule_name); 
		$this->db->where('schedule_is_active', 1); 
		$query = $this->db->get();
		$results = $query->result();
		$scheduledate = "";
		if(count($results) > 0){
			$scheduledate = getDateFormat($results[0]->schedule_date, 'd-m-Y');
		}
		return $scheduledate;
	}
	
	function isSchedulePresent($schedule_name){
		$c_tbl = 'cnf_schedules';
		$this->db->select(array('schedule_id'));
		$this->db->from($c_tbl);
		$this->db->where('schedule_name', $schedule_name);
		$query = $this->db->get();
		$r = $query->result();
		if(count($r) > 0){
			//return true;
			return false;//cooking
		}else{
			return false;
		}
	}
	
	function createSchedule() {
		$c_tbl = 'cnf_schedules';

		$schedule_date_str = $this->input->post('schedule_date');
		if($this->input->post('schedule_type') == 'E'){
			$schedule_date_str .= ' 23:59:00';
		}else if($this->input->post('schedule_type') == 'S'){
			$schedule_date_str .= ' 00:00:00';
		}
		
		//echo convertToMySqlDate($schedule_date_str, 'd-m-Y H:i:s', 'Y-m-d H:i:s'); exit();
		
		$status = false;
		if($this->isSchedulePresent($this->input->post('schedule_name'))==false){
			$data = array(
					  'schedule_name'		=>	$this->input->post('schedule_name'),
					  'schedule_type'		=>	$this->input->post('schedule_type'),
				      'schedule_date'		=>	convertToMySqlDate($schedule_date_str, 'd-m-Y H:i:s', 'Y-m-d H:i:s'),
				      'schedule_is_active'	=>	($this->input->post('schedule_is_active') == 'on') ? 1 : 0,
				    );
					
			$status = $this->db->insert($c_tbl, $data);
		}
		return $status;		
	}
	
	function updateSchedule() {
		$c_tbl = 'cnf_schedules';

		$schedule_date_str = $this->input->post('schedule_date');
		if($this->input->post('schedule_type') == 'E'){
			$schedule_date_str .= '  23:59:00';
		}else if($this->input->post('schedule_type') == 'S'){
			$schedule_date_str .= '  00:00:00';
		}

		$status = false;
		if($this->isSchedulePresent($this->input->post('schedule_name'))==false){
			$data = array(
					  'schedule_name'		=>	$this->input->post('schedule_name'),
					  'schedule_type'		=>	$this->input->post('schedule_type'),
				      'schedule_date'		=>	convertToMySqlDate($schedule_date_str, 'd-m-Y H:i:s', 'Y-m-d H:i:s'),
				      'schedule_is_active'	=>	($this->input->post('schedule_is_active') == 'on') ? 1 : 0,
				    );
					
			$this->db->where('schedule_id', $this->input->post('record_id'));	
			$status = $this->db->update($c_tbl, $data);
		}
		return $status;		
	}	
	
	function deleteSchedule($id) {
		$c_tbl = 'cnf_schedules';
		$this->db->delete($c_tbl, array('schedule_id' => $id)); 
		//also association need to be deleted
		return "DELETED";
	}
	
	
	function getAllSeats($current_page =1) {
		$per_page = 25;
		
		$sm_tbl = 'cnf_seat_info';
		$mt_tbl = 'cnf_method';
		$re_tbl = 'cnf_reservation';
				
		/*
		$this->db->select(array('sm_id', 'method_type', 'method_name', 'reservation_code', 'resv_name as reservation_name', 'is_reservation_pwd', 'cand_ctgry', 'num_seat'));
				$this->db->from($sm_tbl);
				$this->db->join($mt_tbl, 'method_code = method_type');
				$this->db->join($re_tbl, 'resv_code = reservation_code');
				
				$this->db->order_by('cand_ctgry', 'asc'); 
				$this->db->order_by('method_type', 'asc'); 
				$this->db->order_by('reservation_code', 'asc'); 
				
				$query = $this->db->get();
				$results = $query->result();*/
		
		$sql = "SELECT sl_no, cand_univ, cand_ctgry, method_type, method_name, subjects, reservation, pwd, seat_num, description, order_by, count, status
				FROM cnf_seat_info
				LEFT OUTER JOIN cnf_method ON method_code = method_type
				WHERE 1=1";
								
		//get data for pagination
		$total_results = $this->getRecordCount($sql);
		$total_pages = ceil($total_results / $per_page);
		$offset = ($current_page - 1) * $per_page;
		$paginate = array('total_records'	=>	$total_results,
						  'total_pages'		=>	$total_pages,
						  'current_page'	=>	$current_page
						 );
		$sql .= " ORDER BY cand_ctgry, cand_univ, sl_no";				 
		$sql .= " LIMIT " . $offset . ", " . $per_page;

		//echo $sql; exit();

 		$r = $this->db->query($sql)->result();
		$results = array();	
		
		for($i=0; $i<count($r); $i++) {
			$results[$i] = array(
									'sl_no'			=>	$r[$i]->sl_no,
									'cand_univ'		=>	$r[$i]->cand_univ,
									'cand_univ_name'=>	getUniversityCategoryName($r[$i]->cand_univ),
									'cand_ctgry'		=>	$r[$i]->cand_ctgry,
									'cand_ctgry_name'	=>	getApplicationCategory($r[$i]->cand_ctgry),
									'method_type'	=>	$r[$i]->method_type,
									'method_name'	=>	$r[$i]->method_name==null?"ALL" : $r[$i]->method_name,
									'subjects'		=>	$r[$i]->subjects,
									'reservation'	=>$r[$i]->reservation,
									'reservation_name'=>$this->getReservationNameByCode($r[$i]->reservation),
									'pwd'			=>	$r[$i]->pwd,
									'seat_num'		=>	$r[$i]->seat_num,
									'description'	=>	str_replace("'", "&quot;", $r[$i]->description),
									'order_by'		=>	$r[$i]->order_by,
									'count'			=>	$r[$i]->count,
									'status'		=>	$r[$i]->status,
								);
		}
		
		//print_r($results); exit();
		
		return $results;
	}
	
	function createSeat() {
		$c_tbl = 'cnf_seat_matrix';

		$data = array(
					  'method_type'			=>	$this->input->post('method_type'),
				      'reservation_code'	=>	$this->input->post('reservation_code'),
				      'is_reservation_pwd'	=>	$this->input->post('is_reservation_pwd'),
				      'cand_ctgry'			=>	$this->input->post('cand_ctgry'),
				      'num_seat'			=>	$this->input->post('num_seat'),
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	function updateSeat() {
		$c_tbl = 'cnf_seat_matrix';

		$data = array(
					  'method_type'			=>	$this->input->post('method_type'),
				      'reservation_code'	=>	$this->input->post('reservation_code'),
				      'is_reservation_pwd'	=>	$this->input->post('is_reservation_pwd'),
				      'cand_ctgry'			=>	$this->input->post('cand_ctgry'),
				      'num_seat'			=>	$this->input->post('num_seat'),
				    );
		$this->db->where('sm_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	function deleteSeat($id) {
		$c_tbl = 'cnf_seat_matrix';
		$this->db->delete($c_tbl, array('sm_id' => $id)); 
		//also association need to be deleted
		return "DELETED";
	}
	
	
	function getAllMethodTypeMethodSubjectAssoc() {
		$mp_tbl  = 'cnf_method_paper';
		$mt_tbl   = 'cnf_method';
		$sbj1_tbl = 'cnf_subjects';
		$sbj2_tbl = 'cnf_subjects';
				
		$this->db->select(array('method_subject_id', 'cnf_method_paper.method_code as method_code', 'method_name', 'method_subject1', 'method_subject2', 'sb1.subj_name as subj_name_1', 'sb2.subj_name as subj_name_2'));
		$this->db->from($mp_tbl);
		$this->db->join($mt_tbl, $mt_tbl.'.method_code = cnf_method_paper.method_code');
		$this->db->join($sbj1_tbl .' sb1', 'sb1.subj_code = method_subject1');
		$this->db->join($sbj2_tbl .' sb2', 'sb2.subj_code = method_subject2');
		
		$this->db->order_by('method_code', 'asc'); 
		$this->db->order_by('method_subject1', 'asc'); 
		$this->db->order_by('method_subject2', 'asc'); 
		
		$query = $this->db->get();
		$results = $query->result();
		return $results;
				
	}
	
	function createMethodTypeMethodSubjectAssoc() {
		$subj_tbl = 'cnf_method_paper';

		$data = array(
					  'method_code'		=>	$this->input->post('method_code'),
				      'method_subject1'	=>	$this->input->post('method_subject1'),
				      'method_subject2'	=>	$this->input->post('method_subject2'),
				    );
		$status = $this->db->insert($subj_tbl, $data);
		return $status;		
	}
	
	function updateMethodTypeMethodSubjectAssoc() {
		$subj_tbl = 'cnf_method_paper';

		$data = array(
					  'method_code'		=>	$this->input->post('method_code'),
				      'method_subject1'	=>	$this->input->post('method_subject1'),
				      'method_subject2'	=>	$this->input->post('method_subject2'),
				    );
		
		$this->db->where('method_subject_id', $this->input->post('record_id'));					
		$status = $this->db->update($subj_tbl, $data);
		return $status;		
	}
	
	function deleteMethodTypeMethodSubjectAssoc($id) {
		$subj_tbl = 'cnf_method_paper';
		$this->db->delete($subj_tbl, array('method_subject_id' => $id)); 
		//also association need to be deleted
		return "DELETED";	
	}
	
	
	function getAllElligibility() {
		$c_tbl = 'cnf_elligibility';
		$re_tbl = 'cnf_reservation';
		
		$this->db->select(array('elgb_id', 'elgb_resv_code', 'resv_name', 'elgb_is_pwd', 'elgb_cutoff'));
		$this->db->from($c_tbl);
		$this->db->join($re_tbl, 'resv_code = elgb_resv_code');
		
		$this->db->order_by('elgb_resv_code', 'asc'); 
		$this->db->order_by('elgb_is_pwd', 'asc'); 
		$query = $this->db->get();
		$results = $query->result();
		return $results;
	}
	
	function createElligibility() {
		$c_tbl = 'cnf_elligibility';

		$data = array(
					  'elgb_resv_code'	=>	$this->input->post('elgb_resv_code'),
				      'elgb_is_pwd'		=>	$this->input->post('elgb_is_pwd'),
				      'elgb_cutoff'		=>	$this->input->post('elgb_cutoff'),
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	function updateElligibility() {
		$c_tbl = 'cnf_elligibility';

		$data = array(
					  'elgb_resv_code'	=>	$this->input->post('elgb_resv_code'),
				      'elgb_is_pwd'		=>	$this->input->post('elgb_is_pwd'),
				      'elgb_cutoff'		=>	$this->input->post('elgb_cutoff'),
				    );
		$status = $this->db->insert($c_tbl, $data);
		
		$this->db->where('elgb_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	function deleteElligibility($id) {
		$c_tbl = 'cnf_elligibility';
		$this->db->delete($c_tbl, array('elgb_id' => $id)); 
		return "DELETED";
	}	
	
	function getReservationCodes() {
		$sql = "select distinct resv_code from cnf_reservation where resv_is_active  = 1";
		$query = $this->db->query($sql);
		$results = $query->result_array();
		$arrays = array();
		for($i=0; $i<count($results); $i++){
			$arrays[$i] = $results[$i]['resv_code'];
		}
		return $arrays;
	}
	
	function getPaperCodesByMethod($method_type) {
		$sql = "select distinct method_subject1 from cnf_method_paper where method_code  = like '".$method_type."'";
		$query = $this->db->query($sql);
		$results = $query->result_array();
		$arrays = array();
		for($i=0; $i<count($results); $i++){
			$arrays[$i] = $results[$i]['method_subject1'];
		}
		return $arrays;
	}	

	function getCriteriaMarks(){
		$criteriaMarks = 50;
		if($_POST['appl_last_exam'] == 'BTECH-B' || $_POST['appl_last_exam'] == 'BE-B'){
			 $criteriaMarks = 55;
		}else{
			if($_POST['appl_reservation'] == 'sc' || $_POST['appl_reservation'] == 'st' || $_POST['appl_is_pwd'] == '1'){
				$criteriaMarks = 45;
			}
		}
		return $criteriaMarks;
	}
	
	function getMeritInfo($merit_ctgr_index){
		$sql = "SELECT description FROM cnf_seat_info WHERE sl_no = ".$merit_ctgr_index;
		$query = $this->db->query($sql);
		$results = $query->result();
		$description = "";
		if(count($results) > 0){
			$description = $results[0]->description;
		}
		return $description;
	}
	
	function getRecordCount($sql) {
		$results = $this->db->query($sql)->result();
		return count($results);
	}
}
?>
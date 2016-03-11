<?php
class Usermodel extends CI_Model {
    function __construct() {
        parent::__construct();
		$this->load->database();
		$ci = get_instance();
		$ci->load->helper('string');
		$this->load->model('configmodel');	
    }
    
    function authenticate_user($username, $password) {
		$user_table = 'users';
		$this->db->select('*');
		$this->db->from($user_table);
		$this->db->where('LOWER(user_name)', strtolower($username));
		$this->db->where('user_password', $password);
		$this->db->where('is_active', 1);
		$query = $this->db->get();	
		
		if ($query->num_rows() == 1) {
			$row = $query->row(); 
			$user = array(
							'session_id'		=>	md5(date('Ymdhis')),
							'user_id'			=>	$row->user_id,
							'user_role' 		=> $row->role,
							'firstname' 		=> $row->user_firstname,
							'lastname' 			=> $row->user_lastname,
							'user_name' 		=> $row->user_name,
							'user_email' 		=> $row->user_email,
						);	
							
			return $user;
		}
		return NULL;
    }
	
    function authenticate_student($username, $password) {
		$c_tbl = 'bed_application';
		
		$this->db->select('*');
		$this->db->from($c_tbl);
		$this->db->where('LOWER(appl_code)', trim(strtolower($username)));
		$this->db->where('LOWER(appl_passwd)', trim(strtolower($password)));
		$query = $this->db->get();	
		
		if ($query->num_rows() == 1) {
			$row = $query->row(); 
			
			$rank = array();
			
			$resPubDate = $this->configmodel->getScheduleDateByName('RPD');
			$todaysDateObj = new DateTime();
			$resPubDateObj = new DateTime($resPubDate);
			
			$result_publication_flag = false;
			
			if(($todaysDateObj >= $resPubDateObj)){
				$result_publication_flag = true;
				$rank = array(
							'GEN'   => $row->appl_gen_merit,
							'SC'	=> $row->appl_sc_merit,
							'ST'	=> $row->appl_st_merit,
							'PWD'	=> $row->appl_pwd_merit,
							'GEN_TYPE'  => $this->configmodel->getMeritInfo($row->appl_gen_merit_ctgr),
							'SC_TYPE'	=> $this->configmodel->getMeritInfo($row->appl_sc_merit_ctgr),
							'ST_TYPE'	=> $this->configmodel->getMeritInfo($row->appl_st_merit_ctgr),
							'PWD_TYPE'	=> $this->configmodel->getMeritInfo($row->appl_pwd_merit_ctgr),
							'CTGR'		=> $row->appl_ctgr,
						 );
			 }else{
				  $rank = array(
							 'GEN'   => '',
							 'SC'	=> '',
							 'ST'	=> '',
							 'GEN_TYPE'  => '',
							 'SC_TYPE'	=> '',
							 'ST_TYPE'	=> '',
							 'PWD_TYPE'	=> '',
							 'CTGR'		=> ''
						  );
			 }
			 
			
						 
			$student = array(
							'session_id'	  => md5(date('Ymdhis')),
							'student_name'    => $row->appl_name, 
							'student_ctgr'    => $row->appl_ctgr, 
							'student_email'   => $row->appl_email,
							'student_mobile1' => $row->appl_phone,
							'student_pic'     => $row->appl_profile_pic,
							'rank'     		  => $rank,
							'result_pub_flag' => $result_publication_flag
						);	
			
			$this->session->set_userdata('appl_method',   $this->getMethodTypeNameByCode($row->appl_method_type));
			$this->session->set_userdata('appl_code',   $row->appl_code);	
			$this->session->set_userdata('appl_status', $row->appl_status);
			$this->session->set_userdata('user_role', 'student');
			
			return $student;
		} else {
		
		}
		return NULL;
    }	
	
	//search user: Done
	function getUsers(){
		$where = '';
		if($_POST['user_name'] !=null && $_POST['user_name'] !=''){
			$where .= ' AND UPPER(user_name) like "'.strtoupper($_POST['user_name'].'"');
		}
		if($_POST['user_firstname'] !=null && $_POST['user_firstname'] !=''){
			$where .= ' AND UPPER(user_firstname) like "%'.strtoupper($_POST['user_firstname']).'%"';
		}
		if($_POST['user_lastname'] !=null && $_POST['user_lastname'] !=''){
			$where .= ' AND UPPER(user_lastname) like "%'.strtoupper($_POST['user_lastname']).'%"';
		}
		if($_POST['user_phone'] !=null && $_POST['user_phone'] !=''){
			$where .= ' AND UPPER(user_phone) like "'.strtoupper($_POST['user_phone'].'"');
		}
		if($_POST['role'] !=null && $_POST['role'] !='' && $_POST['role'] !='EMPTY'){
			$where .= ' AND UPPER(role) like "'.strtoupper($_POST['role'].'"');
		}
		
		$sql = "SELECT user_id, role, user_firstname, user_lastname, user_name, user_phone, is_active as user_is_active 
				FROM users 
				WHERE 1=1 ".$where." ORDER BY user_name";
		
		$query = $this->db->query($sql);
		$results = $query->result();
		return $results;
	}
	
	//create user : Done
	function insertUser() {
		$user_table = "users";
		$created_on = gmdate('Y-m-d h:i:s');
		$modified_on = $created_on;
		$created_by = $this->session->userdata['user']['user_name'];
		$modified_by = $created_by;
		
		$is_user_flag = $this->isUserExists($this->input->post('user_name'));
		
		$results = array();
		if($is_user_flag){
			$results['status'] = false;
			$results['cause'] = 'Username already in used';
		}else{
			$userpassword = $this->generatePassword();
			$data = array(
		              'role'			=>	$this->input->post('role'),
		              'user_firstname'	=>	$this->input->post('user_firstname'),
		              'user_lastname'	=>	$this->input->post('user_lastname'),
		              'user_name'		=>	$this->input->post('user_name'),
		              'user_password'	=>	$userpassword,
		              'user_phone'		=>	$this->input->post('user_phone'),
		              'is_active'		=>	($this->input->post('user_is_active') == 'on') ? 1 : 0,
		              'created_on'		=>	$created_on,
		              'modified_on'		=>	$modified_on,
					  'created_by'		=>	$created_by,
					  'modified_by'		=>	$modified_by
		            );
		    $status = $this->db->insert($user_table, $data);
			if($status){
				$results['status'] = true;
				$results['password'] = $userpassword;
			}else{
				$results['status'] = false;
				$results['cause'] = '';
			}
		}
		return $results;
	}
	
	//update user : Done
	function updateUser() {
		$user_table = "users";
		$modified_on = date('Y-m-d h:i:s');
		$modified_by = $this->session->userdata['user']['user_name'];
		
		$data = array(
	              'role'			=>	$this->input->post('role'),
	              'user_firstname'	=>	$this->input->post('user_firstname'),
	              'user_lastname'	=>	$this->input->post('user_lastname'),
	              'user_phone'		=>	$this->input->post('user_phone'),
	              'is_active'		=>	($this->input->post('user_is_active') == 'on') ? '1': '0',
	              'modified_on'		=>	$modified_on,
				  'modified_by'		=>	$modified_by
	            );
		
		//echo $this->input->post('record_id');  print_r($data); exit();
		
		$this->db->where('user_id', $this->input->post('record_id'));					
		$status = $this->db->update($user_table, $data);
		
		return $status;
	}	
	
	//delete user : Done
	function deleteUser($id) {
		$user_table = "users";
		$this->db->delete($user_table, array('user_id' => $id)); 
		return "DELETED";
	}	
	
	//check whether user is exists or not
	function isUserExists($userName){
		$sql = "SELECT * FROM users WHERE user_name = '". $userName . "'";
		$query = $this->db->query($sql);
		$results = $query->result();
		if(count($results) > 0){
			return true;
		}else{
			return false;
		}
	}
	
	//generate password : Done
	function generatePassword(){
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$pass = substr(str_shuffle($chars),0,8);
		return $pass;
	}
	
	//send password
	function getUserPasswordByEmail($email){
		$user_table = "users";
		$this->db->select('*');
		$this->db->from($user_table);
		$this->db->where('user_email', $email);
		$this->db->where('is_active', 1);
		$query = $this->db->get();	
		
		if ($query->num_rows() == 1) {
			$row = $query->row(); 
			
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$pass = substr(str_shuffle($chars),0,8);
			
			$user = array(
							'emp_firstname' => $row->user_firstname,
							'emp_lastname' => $row->user_lastname,
							'user_name' => $row->user_name,
							'user_email' => $row->user_email,
							'user_password' => $pass
						);	
			$this->setPassword($email, $pass);				
			return $user;
		}
		return NULL;
	}
	

	function getDetailsForResetPassword() {
		$u_tbl = 'users';
		$this->db->select(array('user_id', 'role', 'user_firstname', 'user_lastname', 'user_name', 'user_phone', 'is_active'));
		$this->db->from($u_tbl);
		
		if($this->input->post('user_firstname') != null && $this->input->post('user_firstname') != ''){
			$this->db->like('lower(user_firstname)',  strtolower($this->input->post('user_firstname')), 'both');			
		}
		if($this->input->post('user_lastname') != null && $this->input->post('user_lastname') != ''){
			$this->db->where('lower(user_lastname)',  strtolower($this->input->post('user_lastname')));			
		}
		if($this->input->post('user_phone') != null && $this->input->post('user_phone') != ''){
			$this->db->where('lower(user_phone)',  strtolower($this->input->post('user_phone')));			
		}
		if($this->input->post('user_name') != null && $this->input->post('user_name') != ''){
			$this->db->like('lower(user_name)',  strtolower($this->input->post('user_name')), 'both');			
		}

		$query = $this->db->get();
		$r = $query->result();
		
		//echo $this->db->last_query();exit();
		
		$info = array();
		if(count($r) > 0) {
			for($cnt=0; $cnt<count($r); $cnt++){
				$info[$cnt] = array(
							'user_id'		=>	$r[$cnt]->user_id,
							'role'			=>	$r[$cnt]->role,
							'user_firstname'=>	$r[$cnt]->user_firstname,
							'user_lastname'	=>	$r[$cnt]->user_lastname,
							'user_name'	=>	$r[$cnt]->user_name,
							'user_phone'	=>	$r[$cnt]->user_phone,
						);
			}
		}				
		return $info;			
	}
	
	
	//send password
	function getUserPasswordByUserId($user_id){
		$user_table = "users";
		$this->db->select('*');
		$this->db->from($user_table);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();	
		
		if ($query->num_rows() == 1) {
			$row = $query->row(); 
			
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$pass = substr(str_shuffle($chars),0,8);
			
			$user = array(
							'user_id' => $row->user_id,
							'user_firstname' => $row->user_firstname,
							'user_lastname' => $row->user_lastname,
							'user_name' => $row->user_name,
							'user_password' => $pass
						);	
			$this->setPassword($user_id, $pass);				
			return $user;
		}
		return NULL;
	}
	
	
	function setPassword($userId, $pass) {
	
		$user_table = "users";
		$modified_on = date('Y-m-d h:i:s');
		$modified_by = $this->session->userdata['user']['user_name'];
		
		$data = array(
	              'user_password'	=>	$pass,
	              'modified_on'		=>	$modified_on,
				  'modified_by'		=>	$modified_by
	            );
		$this->db->where('user_id', $userId);					
		$status = $this->db->update($user_table, $data);
		
		return $status;
	}
	
	//change password by the user himself
	function changePassword() {
		$user_table = "users";
		$modified_on = gmdate('Y-m-d h:i:s');
		$modified_by = $this->session->userdata['user']['user_name'];
		
		$data = array(
	              'user_password'	=>	$this->input->post('user_password'),
	              'modified_on'		=>	$modified_on,
				  'modified_by'		=>	$modified_by
	            );
				
				
		$this->db->where('user_id', $this->session->userdata['user']['user_id']);					
		$status = $this->db->update($user_table, $data);
		return $status;
	}	
	
	/*/last user activities
	function getActivities($username, $num = 10) {
		$a_tbl = 'appl_trans_history';
		$this->db->select(array('ath_form_num', 'ath_event', 'ath_event_date'));
		$this->db->from($a_tbl);
		$this->db->where('ath_event_by', $username);
		$this->db->order_by('ath_event_date', 'DESC');
		$this->db->limit($num);	
		$query = $this->db->get();
		$r = $query->result();
		
		return $r;
	}	
	*/

	function getMethodTypeNameByCode($method_type) {
		$sql = "SELECT method_name FROM cnf_method WHERE method_code = '".$method_type."'";
		$query = $this->db->query($sql);
		$results = $query->result();
		$method_name = "";
		if(count($results) > 0){
			$method_name = $results[0]->method_name;
		}
		return $method_name;
	}
}
?>
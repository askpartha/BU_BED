<?php
class Resultmodel extends CI_Model {
    function __construct() {
        parent::__construct();
		$this->load->database();
		$ci = get_instance();
		$ci->load->helper('string');
		$this->load->model('configmodel');
    }

	function getNonGenaratedMeritCatgeory(){
		$sql = "SELECT DISTINCT cand_ctgry from  cnf_seat_info where cand_ctgry not in (SELECT DISTINCT appl_ctgr FROM cnf_merit_generation WHERE status='1')";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList = array();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->cand_ctgry] = getApplicationCategory($dropdown->cand_ctgry);
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	
	//---------------------- QUERY FORMATION-------------- : START
	function getGenaratedMeritCatgeory(){
		$sql = "SELECT DISTINCT appl_ctgr FROM cnf_merit_generation WHERE status='1'";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList = array();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->appl_ctgr] = getApplicationCategory($dropdown->appl_ctgr);
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	
	function getSeatInfoDetails($appl_ctgr){
		$sql = "SELECT * FROM cnf_seat_info WHERE cand_ctgry like '".$appl_ctgr."'";
		//echo $sql; 	
		$query = $this->db->query($sql);
		$results = $query->result_array();
		//print_r($results); exit();
		return $results;
	}
	
	function getSeatInfoDetailsById($merit_type_no){
		$sql = "SELECT * FROM cnf_seat_info WHERE sl_no='".$merit_type_no."'";
		$query = $this->db->query($sql);
		$results = $query->result_array();
		if(count($results) == 1){
			$results = $results[0];	
		}
		return $results;
	}
	
	
	function getUniversityClause($arrays){
		$str = '';
		if($arrays['cand_ctgry'] == 'F'){
			$str = " AND appl_univ_ctgry like '". $arrays['cand_univ'] ."'";
		}
		return $str;
	}
	
	function getMethodClause($arrays){
		$str = '';
		if($arrays['method_type'] != 'ALL'){
			$str = " AND appl_method_type like '". $arrays['method_type'] ."'";
		}
		return $str;
	}
	
	function getSubjectClause($arrays){
		$str = '';
		if($arrays['subjects'] != 'ALL'){
			$arr = explode(",", $arrays['subjects']);
			$int_str = "";
			for($j=0; $j<count($arr); $j++){
				$int_str .= "'".$arr[$j]."'";
				if(($j+1) != count($arr)){
					$int_str .= ", ";
				}
			}
			
			$str = " AND appl_method_paper1 in (". $int_str .")";
		}
		return $str;
	}
	
	function getReservationClause($arrays){
		$str = '';
		if($arrays['reservation'] != 'gen'){
			$str = " AND appl_reservation like '". $arrays['reservation'] ."'";
		}
		return $str;
	}
	
	function getDAClause($arrays){
		$str = '';
		if($arrays['pwd'] == 1){
			$str = " AND appl_is_pwd = 1";
		}
		return $str;
	}
	//---------------------- QUERY FORMATION-------------- : END
	
	function RevokeMeritList($appl_ctgr){
		$info_details_array = $this->getSeatInfoDetails($appl_ctgr);
		
		//print_r($info_details_array); exit();
		
		//TRANSACTION START
		$status = TRUE;
		$this->db->trans_begin();
		
		for($i=0; $i<count($info_details_array); $i++){
				
			$sql = "SELECT * FROM bed_application WHERE appl_status >= 3 AND appl_ctgr like '". $info_details_array[$i]['cand_ctgry'] ."' ";
			$sql .= $this->getUniversityClause($info_details_array[$i]);
			$sql .= $this->getMethodClause($info_details_array[$i]);
			$sql .= $this->getSubjectClause($info_details_array[$i]);
			$sql .= $this->getReservationClause($info_details_array[$i]);
			$sql .= $this->getDAClause($info_details_array[$i]);
			$sql .= " ORDER BY ".$info_details_array[$i]['order_by'] . ', appl_dob';
			
			$query = $this->db->query($sql);
			$result = $query->result_array();
	
			$resv_col = 'appl_'.$info_details_array[$i]['reservation'].'_merit';
			if($info_details_array[$i]['pwd'] == 1){
				$resv_col = 'appl_pwd_merit';
			}
			
			$total_record = count($result);
			//$total_record = 0;
			for($index=0; $index < $total_record; $index++){
				$appl_sl_no = $result[$index]['appl_sl_no'];
				
				$updateSQL = "UPDATE bed_application SET appl_status = 2, " . $resv_col  . " = 0 , ".$resv_col."_ctgr = 0 WHERE appl_sl_no = " . $appl_sl_no; 
				
				$this->db->query($updateSQL);
				
				//echo $updateSQL."<br/>";
				
				if ($this->db->trans_status() === FALSE) {
					$status = FALSE;
				}
			}// end of updation
			
			//update the count and status in cnf_info_seat table
			if($status === TRUE){
				$csi_tbl = 'cnf_seat_info';
				$data = array('count'=>	0,   'status'=>	'0' );
				$this->db->where('sl_no', $info_details_array[$i]['sl_no'] );	
				$this->db->update($csi_tbl, $data);
				if ($this->db->trans_status() === FALSE) {
					$status = FALSE;
				}
			}// end of update seat info table
		
		}// Emd of all type of seat info record operation
		
		//update merit generation table for further update : START
		if($status === TRUE){
			$modified_on = gmdate('Y-m-d H:i:s');
			$modified_by = $this->session->userdata['user']['user_name'];
			$cmg_tbl = 'cnf_merit_generation';
			
			
			$data = array( 'status'		=>	'0',
					      'generated_on'=>	$modified_on,
					      'generated_by'=>	$modified_by
						  );
			$this->db->where('appl_ctgr', $appl_ctgr );			  
			$this->db->update($cmg_tbl, $data);
			if ($this->db->trans_status() === FALSE) {
				$status = FALSE;
			}
		}
		//update merit generation table for further update : END
		
		//TRANSACTION END
		if ($status === FALSE) {
		    $this->db->trans_rollback();
		} else {
		    $this->db->trans_commit();
		}
		 $this->db->trans_complete();
		 
		return $status;
		
	} // End of function

	function GenerateMeritList($appl_ctgr){
			
		$info_details_array = $this->getSeatInfoDetails($appl_ctgr);
		
		//print_r($info_details_array); exit();
		
		//TRANSACTION START
		$status = TRUE;
		$this->db->trans_begin();
		
		for($i=0; $i<count($info_details_array); $i++){
				
			$sql = "SELECT * FROM bed_application WHERE  appl_ctgr like '". $info_details_array[$i]['cand_ctgry'] ."' AND appl_status >= 2 ";
			$sql .= $this->getUniversityClause($info_details_array[$i]);
			$sql .= $this->getMethodClause($info_details_array[$i]);
			$sql .= $this->getSubjectClause($info_details_array[$i]);
			$sql .= $this->getReservationClause($info_details_array[$i]);
			$sql .= $this->getDAClause($info_details_array[$i]);
			$sql .= " ORDER BY ".$info_details_array[$i]['order_by'] . ', appl_dob desc';
			
			//echo $sql . "<br/>"; continue; exit();
			
			$query = $this->db->query($sql);
			$result = $query->result_array();
	
			//print_r($result) . "<br/>"; exit();
	
			$resv_col = 'appl_'.$info_details_array[$i]['reservation'].'_merit';
			if($info_details_array[$i]['pwd'] == 1){
				$resv_col = 'appl_pwd_merit';
			}
			
			$total_record = count($result);
			for($index=0; $index < $total_record; $index++){
				$appl_sl_no = $result[$index]['appl_sl_no'];
				
				$updateSQL = "UPDATE bed_application SET appl_status=3, " . $resv_col  . "=" . ($index+1) . ", ".$resv_col."_ctgr=".$info_details_array[$i]['sl_no']." WHERE appl_sl_no=" . $appl_sl_no; 
				
				//echo $updateSQL . "<br/>"; exit();
				
				$flag = $this->db->query($updateSQL);
				//echo $flag;
				
				if ($this->db->trans_status() === FALSE) {
					$status = FALSE;
				}
			}// end of updation
			
			//update the count and status in cnf_info_seat table
			if($status === TRUE){
				$csi_tbl = 'cnf_seat_info';
				$data = array('count'=>	$total_record,   'status'=>	'1' );
				$this->db->where('sl_no', $info_details_array[$i]['sl_no'] );	
				$this->db->update($csi_tbl, $data);
				if ($this->db->trans_status() === FALSE) {
					$status = FALSE;
				}
			}// end of update seat info table
		
		}// Emd of all type of seat info record operation
		
		//update merit generation table for further update : START
		if($status === TRUE){
			$modified_on = gmdate('Y-m-d H:i:s');
			$modified_by = $this->session->userdata['user']['user_name'];
			$cmg_tbl = 'cnf_merit_generation';
			
			$data = array('appl_ctgr'		=>	$appl_ctgr,
						  'status'		=>	'1',
					      'generated_on'=>	$modified_on,
					      'generated_by'=>	$modified_by
						  );
						  
			$this->db->insert($cmg_tbl, $data);
			if ($this->db->trans_status() === FALSE) {
				$status = FALSE;
			}
		}
		//update merit generation table for further update : END
		
		//TRANSACTION END
		if ($status === FALSE) {
		    $this->db->trans_rollback();
		} else {
		    $this->db->trans_commit();
		}
		
		return $status;
		
	} // End of function

  	function getMeritLists($cand_category, $per_page = 40){
  		$info_details_array = $this->getSeatInfoDetails($cand_category);
		
		$return_result = array();
		
		for($i=0; $i<count($info_details_array); $i++){
				
			$col_merit_ctgr = "appl_". $info_details_array[$i]['reservation'] ."_merit_ctgr";
			$col_merit 		= "appl_". $info_details_array[$i]['reservation'] ."_merit";
			$resv_code 		= $info_details_array[$i]['reservation'];
			if($info_details_array[$i]['pwd'] == 1){
				$col_merit_ctgr = 'appl_pwd_merit_ctgr';
				$col_merit 		= 'appl_pwd_merit';
				$resv_code		= 'pwd';
			}

			$sql = "SELECT * FROM bed_application 
							 WHERE appl_status = 3 AND 
							 	   " . $col_merit_ctgr . " like '". $info_details_array[$i]['sl_no'] ."' 
							 ORDER BY " . $col_merit . " DESC";
			
			$total_results = $this->getTotalResultPageCount($sql);
			$total_pages = ceil($total_results / $per_page);
			
			$return_result[$i]['description'] = $info_details_array[$i]['description'];
			$return_result[$i]['sl_no'] 	  = $info_details_array[$i]['sl_no'];
			$return_result[$i]['total_record']= $total_results;
			$return_result[$i]['total_pages']= $total_pages;
			$return_result[$i]['reservation'] = $resv_code;
			$return_result[$i]['no_of_seats'] = $info_details_array[$i]['seat_num'];
		}
		
		//print_r($return_result); exit();
		
		return $return_result;
  	}

	function getMeritListData($resv, $merit_type_no, $page=1, $per_page=40){
		$col_merit 		= strtolower("appl_".$resv."_merit");
		$col_merit_ctgr = strtolower("appl_".$resv."_merit_ctgr");
		
		$sql = "SELECT appl_code, appl_ctgr, resv_name, appl_method_type, method_name, appl_name, appl_score, appl_dep_exp_month, " .  $col_merit  . " as resv_merit FROM bed_application
				JOIN cnf_method on method_code = appl_method_type
				LEFT OUTER JOIN cnf_reservation on resv_code=appl_reservation";
		$sql .= " WHERE " . $col_merit_ctgr . " = " . $merit_type_no . "  AND appl_status=3 ORDER BY " . $col_merit . " ASC";
				
		$total_results = $this->getTotalResultPageCount($sql);
		$total_pages = ceil($total_results / $per_page);

		$sql .= " LIMIT " . ($page-1)*$per_page . ", " . $per_page;

		$r = $this->db->query($sql)->result();
		$data = array();
		
		for($i=0; $i<count($r); $i++) {
				$data[$i]=array('appl_name' 		=>	$r[$i]->appl_name,
								'appl_code'			=>	$r[$i]->appl_code,
								'appl_method_type'	=>	$r[$i]->appl_method_type,
								'resv_name'			=>	$r[$i]->resv_name,
								'method_name'		=>	$r[$i]->method_name,
								'appl_score'		=>	$r[$i]->appl_score,
								'appl_dep_exp_month'=>	$r[$i]->appl_dep_exp_month,
								'appl_merit'		=>	$r[$i]->resv_merit,
								'PAGENO'			=>	$page,
								'TOTALPAGES'		=>	$total_pages
							);
		}
		
		$info_details_array = $this->getSeatInfoDetailsById($merit_type_no);
		
		$resv_name 			= $this->configmodel->getReservationNameByCode($resv);
		$method_type	 	= $info_details_array['method_type'];
		$method_type_name 	= $this->configmodel->getMethodNameByCode($method_type);
		$cand_ctgry			= $info_details_array['cand_ctgry'];
		$cand_ctgry_name	= getApplicationCategory($cand_ctgry);
		
		$info['resv_code'] 		= $resv;
		$info['resv_name'] 		= $resv_name;
		$info['cand_ctgry'] 	= $cand_ctgry;
		$info['cand_ctgry_name']= $cand_ctgry_name;
		$info['method_type'] 	= $method_type;
		$info['method_type_name'] = $method_type_name;
		$info['description'] 	= $info_details_array['description'];
		
		//$data['info'] = $info;
		
		//print_r($info); exit();
		
		return array("data"	=>	$data, 'info' => $info); 			
	}
	
	function getMeritListOption($appl_ctgr = null){
		$sql = "SELECT sl_no, description, seat_num FROM cnf_seat_info WHERE cand_ctgry = '".$appl_ctgr."' AND count > 0 ORDER BY cand_univ, method_type, reservation";
		$query = $this->db->query($sql);
		$results = $query->result_array();
		
        return $results;
	}
	
	function getTotalResultPageCount($sql) {
		$results = $this->db->query($sql)->result();
		return count($results);
	}
}
?>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Pdf {
 
	var $_dompdf = NULL;

	function __construct() {
		require_once APPPATH."third_party/dompdf/dompdf_config.inc.php";
		if(is_null($this->_dompdf)) {
			$this->_dompdf = new DOMPDF();
		}
	}
	
	function convertToPDF($str, $filename, $stream = true, $paper = 'A4', $orientation = 'landscape') {
		$this->_dompdf->load_html($str);
		$this->_dompdf->set_paper($paper, $orientation);
		$this->_dompdf->render();
		if ($stream) {
			$this->_dompdf->stream($filename);
		} else {
			return $this->_dompdf->output();
		}
	}
	
	function convert_html_challan_to_pdf($data, $filename ='', $stream = TRUE, $paper = 'A4', $orientation = 'landscape') {
		$s = "<style type='text/css'>
				body{
					font:8pt Helvetica, serif;
					margin-top: -2.2em;
            		margin-left: 0.2em;
				}
				p {margin:0.2em 0 0 0;padding:0;}
				
				</style>";
		
		$s .= "<table border=0 cellpadding=0 cellspacing=0 style='border-collapse:collapse;table-layout:fixed;width:800pt'>";
		$s .= "<tr style=''>";
		$s .= "<td colspan=4 align=center style='width:260pt'><img src='" . $data['univ_logo'] . "'></td>";
		$s .= "<td colspan=4 align=center style='width:260pt'><img src='" . $data['univ_logo'] . "'></td>";
		$s .= "<td colspan=4 align=center style='width:260pt'><img src='" . $data['univ_logo'] . "'></td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
		
		$s .= "<tr style='height:12.0pt;font-weight:700;font-size:10pt;'>";
		$s .= "<td colspan=4 align=center style='height:12.0pt;width:260pt'>THE UNIVERSITY OF BURDWAN</td>";
		$s .= "<td colspan=4 align=center style='width:260pt'>THE UNIVERSITY OF BURDWAN</td>";
		$s .= "<td colspan=4 align=center style='width:260pt'>THE UNIVERSITY OF BURDWAN</td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
			
		$s .= "<tr style='height:12.0pt;font-weight:700;font-size:10pt;'>";
		$s .= "<td colspan=4 align=center  style='height:12.0pt'>CHALLAN FOR APPLICATION FEES</td>";
		$s .= "<td colspan=4 align=center >CHALLAN FOR APPLICATION FEES</td>";
		$s .= "<td colspan=4 align=center >CHALLAN FOR APPLICATION FEES</td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
			
		$s .= "<tr style='height:12.0pt;font-weight:700;font-size:10pt;'>";
		$s .= "<td colspan=4 align=center  style='height:12.0pt'>STATE BANK OF INDIA</td>";
		$s .= "<td colspan=4 align=center >STATE BANK OF INDIA</td>";
		$s .= "<td colspan=4 align=center >STATE BANK OF INDIA</td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
			
		$s .= "<tr style='height:12.0pt;font-weight:700;font-size:10pt;'>";
		$s .= "<td colspan=4 align=center  style='height:12.0pt'>POWER JYOTI A/C No. ".$data['bank_account_no']."</td>";
		$s .= "<td colspan=4 align=center >POWER JYOTI A/C No. ".$data['bank_account_no']."</td>";
		$s .= "<td colspan=4 align=center >POWER JYOTI A/C No. ".$data['bank_account_no']."</td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
			
		$s .= "<tr style='height:12.0pt;font-weight:700;font-size:10pt;'>";
		$s .= "<td colspan=4 align=center style='height:12.0pt;border-bottom:thin solid;'>(BANK COPY)</td>";
		$s .= "<td colspan=4 align=center style='border-bottom:thin solid;'>(UNIVERSITY COPY)</td>";
		$s .= "<td colspan=4 align=center style='border-bottom:thin solid;'>(STUDENT COPY)</td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
			
		$s .= "<tr style='height:16.0pt'>";
		$s .= "<td style='height:12.0pt'>CHALLAN NO.</td>";
		$s .= "<td colspan=3>" . $data['appl_code'] . "</td>";
		$s .= "<td>CHALLAN NO.</td>";
		$s .= "<td colspan=3>" . $data['appl_code'] . "</td>";
		$s .= "<td>CHALLAN NO.</td>";
		$s .= "<td colspan=3>" . $data['appl_code'] . "</td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
		
		
		$s .= "<tr style='height:16.0pt'>";
		$s .= "<td style='height:12.0pt'></td>";
		$s .= "<td colspan=3></td>";
		$s .= "<td></td>";
		$s .= "<td colspan=3></td>";
		$s .= "<td></td>";
		$s .= "<td colspan=3></td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
		
		$s .= "<tr style='height:12.0pt'>";
		$s .= "<td style='height:12.0pt'>NAME:</td>";
		$s .= "<td colspan=3>" . $data['appl_name'] . "</td>";
		$s .= "<td>NAME:</td>";
		$s .= "<td colspan=3>" . $data['appl_name'] . "</td>";
		$s .= "<td>NAME:</td>";
		$s .= "<td colspan=3>" . $data['appl_name'] . "</td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
			
		$s .= "<tr style='height:12.0pt'>";
		$s .= "<td style='height:12.0pt'>SUBJECT:</td>";
		$s .= "<td colspan=3>" . $data['subj_name'] . "</td>";
		$s .= "<td>SUBJECT:</td>";
		$s .= "<td colspan=3>" . $data['subj_name'] . "</td>";
		$s .= "<td>SUBJECT:</td>";
		$s .= "<td colspan=3>" . $data['subj_name'] . "</td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
		
		$s .= "<tr style='height:12.0pt'>";
		$s .= "<td style='height:12.0pt'>ADDRESS:</td>";
		$s .= "<td colspan=3><p style='width:160pt;'>" . $data['appl_address'] . "</p></td>";
		$s .= "<td>ADDRESS:</td>";
		$s .= "<td colspan=3><p style='width:160pt;'>" . $data['appl_address'] . "</p></td>";
		$s .= "<td>ADDRESS:</td>";
		$s .= "<td colspan=3><p style='width:160pt;'>" . $data['appl_address'] . "</p></td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
			
		$s .= "<tr style='height:12.0pt'>";
		$s .= "<td colspan=4 style='height:12.0pt'></td>";
		$s .= "<td colspan=4></td>";
		$s .= "<td colspan=4></td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
			
		$s .= "<tr style='height:12.0pt;font-weight:bold;'>";
		$s .= "<td colspan=3 style='height:12.0pt;border-top:thin solid;border-bottom:thin solid;'>FEES TYPE</td>";
		$s .= "<td style='border-top:thin solid;border-bottom:thin solid;'>&nbsp;&nbsp;&nbsp;AMOUNT</td>";
		$s .= "<td colspan=3 style='border-top:thin solid;border-bottom:thin solid;'>FEES TYPE</td>";
		$s .= "<td style='border-top:thin solid;border-bottom:thin solid;'>&nbsp;&nbsp;&nbsp;AMOUNT</td>";
		$s .= "<td colspan=3 style='border-top:thin solid;border-bottom:thin solid;'>FEES TYPE</td>";
		$s .= "<td style='border-top:thin solid;border-bottom:thin solid;'>&nbsp;&nbsp;&nbsp;AMOUNT</td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";

		for($i=0;$i<2;$i++){
			$s .= "<tr style='height:16.0pt'>";
			$s .= "<td style='height:12.0pt'></td>";
			$s .= "<td colspan=3></td>";
			$s .= "<td></td>";
			$s .= "<td colspan=3></td>";
			$s .= "<td></td>";
			$s .= "<td colspan=3></td>";
			$s .= "<td style='width:20pt'></td>";
			$s .= "</tr>";
		}
		
		$s .= "<tr style='height:16.0pt'>";
		$s .= "<td colspan=3 style='height:16.0pt'> APPLICATION FEES</td>";
		$s .= "<td>&nbsp;&nbsp;&nbsp;" . $data['total_amt'] . "</td>";
		$s .= "<td colspan=3 style='height:16.0pt'> APPLICATION FEES</td>";
		$s .= "<td>&nbsp;&nbsp;&nbsp;" . $data['total_amt'] . "</td>";
		$s .= "<td colspan=3 style='height:16.0pt'> APPLICATION FEES</td>";
		$s .= "<td>&nbsp;&nbsp;&nbsp;" . $data['total_amt'] . "</td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
		
		for($i=0;$i<3;$i++){
			$s .= "<tr style='height:16.0pt'>";
			$s .= "<td style='height:12.0pt'></td>";
			$s .= "<td colspan=3></td>";
			$s .= "<td></td>";
			$s .= "<td colspan=3></td>";
			$s .= "<td></td>";
			$s .= "<td colspan=3></td>";
			$s .= "<td style='width:20pt'></td>";
			$s .= "</tr>";
		}
		
		/*
		$arr = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N');
				$n = 0;
				for($i=0;$i<count($data['fees']);$i++) {	
					$s .= "<tr style='height:16.0pt'>";
					$s .= "<td colspan=3 style='height:16.0pt'>" . $arr[$i] . '. ' . $data['fees'][$i]['fees_name'] . "</td>";
					$s .= "<td>&nbsp;&nbsp;&nbsp;" . $data['fees'][$i]['fees_amt'] . "</td>";
					$s .= "<td colspan=3>" . $arr[$i] . '. ' . $data['fees'][$i]['fees_name'] . "</td>";
					$s .= "<td>&nbsp;&nbsp;&nbsp;" . $data['fees'][$i]['fees_amt'] . "</td>";
					$s .= "<td colspan=3>" . $arr[$i] . '. ' . $data['fees'][$i]['fees_name'] . "</td>";
					$s .= "<td>&nbsp;&nbsp;&nbsp;" . $data['fees'][$i]['fees_amt'] . "</td>";
					$s .= "<td style='width:20pt'></td>";
					$s .= "</tr>";
					$n++;
				}	*/
		

			
		$s .= "<tr style='height:12.0pt;font-weight:700'>";
		$s .= "<td colspan=3 style='height:12.0pt;border-top:thin solid;'>TOTAL</td>";
		$s .= "<td style='border-top:thin solid;'>&nbsp;&nbsp;&nbsp;" . $data['total_amt'] . "</td>";
		$s .= "<td colspan=3 style='border-top:thin solid;'>TOTAL</td>";
		$s .= "<td style='border-top:thin solid;'>&nbsp;&nbsp;&nbsp;" . $data['total_amt'] . "</td>";
		$s .= "<td colspan=3 style='border-top:thin solid;'>TOTAL</td>";
		$s .= "<td style='border-top:thin solid;'>&nbsp;&nbsp;&nbsp;" . $data['total_amt'] . "</td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
			
		$s .= "<tr style='height:12.0pt'>";
		$s .= "<td colspan=4 style='height:12.0pt'>(Rupees in words: " . $data['total_amt_word'] . " only)</td>";
		$s .= "<td colspan=4>(Rupees in words: " . $data['total_amt_word'] . " only)</td>";
		$s .= "<td colspan=4>(Rupees in words: " . $data['total_amt_word'] . " only)</td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
		
		$s .= "<tr style='height:16.0pt'>";
		$s .= "<td style='height:12.0pt'></td>";
		$s .= "<td colspan=3></td>";
		$s .= "<td></td>";
		$s .= "<td colspan=3></td>";
		$s .= "<td></td>";
		$s .= "<td colspan=3></td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
			
		$s .= "<tr style='height:29.25pt'>";
		$s .= "<td colspan=4 height=39 style='height:29.25pt;'>BANK CHARGE CR TO COMMISSION OTHERS<br>
			    	98353______________ 50/- SEPARATELY.</td>";
		$s .= "<td colspan=4>BANK CHARGE CR TO COMMISSION OTHERS<br>
			    	98353______________ 50/- SEPARATELY.</td>";
		$s .= "<td colspan=4>BANK CHARGE CR TO COMMISSION OTHERS<br>
					98353______________ 50/- SEPARATELY.</td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
			
		$s .= "<tr style='height:14.0pt'>";
		$s .= "<td colspan=2 style='height:14.0pt'>TOTAL</td>";
		$s .= "<td colspan=2><p style='width:120pt;height:14pt;border-bottom:thin solid;'>&nbsp;</p></td>";
		$s .= "<td colspan=2>TOTAL</td>";
		$s .= "<td colspan=2><p style='width:120pt;height:14pt;border-bottom:thin solid;'>&nbsp;</p></td>";
		$s .= "<td colspan=2>TOTAL</td>";
		$s .= "<td colspan=2><p style='width:120pt;height:14pt;border-bottom:thin solid;'>&nbsp;</p></td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
			
		$s .= "<tr style='height:16.0pt'>";
		$s .= "<td style='height:12.0pt'></td>";
		$s .= "<td colspan=3></td>";
		$s .= "<td></td>";
		$s .= "<td colspan=3></td>";
		$s .= "<td></td>";
		$s .= "<td colspan=3></td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
		
		$s .= "<tr style='height:14.0pt'>";
		$s .= "<td colspan=2 style='height:14.0pt'>DATE</td>";
		$s .= "<td colspan=2><p style='width:120pt;height:14pt;border-bottom:thin solid;'>&nbsp;</p></td>";
		$s .= "<td colspan=2>DATE</td>";
		$s .= "<td colspan=2><p style='width:120pt;height:14pt;border-bottom:thin solid;'>&nbsp;</p></td>";
		$s .= "<td colspan=2>DATE</td>";
		$s .= "<td colspan=2><p style='width:120pt;height:14pt;border-bottom:thin solid;'>&nbsp;</p></td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
			
		$s .= "<tr style='height:14.0pt'>";
		$s .= "<td colspan=2 style='height:14.0pt'>BRANCH NAME</td>";
		$s .= "<td colspan=2><p style='width:120pt;height:14pt;border-bottom:thin solid;'>&nbsp;</p></td>";
		$s .= "<td colspan=2>BRANCH NAME</td>";
		$s .= "<td colspan=2><p style='width:120pt;height:14pt;border-bottom:thin solid;'>&nbsp;</p></td>";
		$s .= "<td colspan=2>BRANCH NAME</td>";
		$s .= "<td colspan=2><p style='width:120pt;height:14pt;border-bottom:thin solid;'>&nbsp;</p></td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
		
		$s .= "<tr style='height:16.0pt'>";
		$s .= "<td style='height:12.0pt'></td>";
		$s .= "<td colspan=3></td>";
		$s .= "<td></td>";
		$s .= "<td colspan=3></td>";
		$s .= "<td></td>";
		$s .= "<td colspan=3></td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
			
		$s .= "<tr style='height:14.0pt'>";
		$s .= "<td colspan=2 style='height:14.0pt'>BRANCH CODE</td>";
		$s .= "<td colspan=2><p style='width:120pt;height:14pt;border-bottom:thin solid;'>&nbsp;</p></td>";
		$s .= "<td colspan=2>BRANCH CODE</td>";
		$s .= "<td colspan=2><p style='width:120pt;height:14pt;border-bottom:thin solid;'>&nbsp;</p></td>";
		$s .= "<td colspan=2>BRANCH CODE</td>";
		$s .= "<td colspan=2><p style='width:120pt;height:14pt;border-bottom:thin solid;'>&nbsp;</p></td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
		
		$s .= "<tr style='height:16.0pt'>";
		$s .= "<td style='height:12.0pt'></td>";
		$s .= "<td colspan=3></td>";
		$s .= "<td></td>";
		$s .= "<td colspan=3></td>";
		$s .= "<td></td>";
		$s .= "<td colspan=3></td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
		
		$s .= "<tr style='height:18.0pt;font-weight:700'>";
		$s .= "<td colspan=2 style='height:16.0pt'>JOURNAL NO</td>";
		$s .= "<td colspan=2><p style='width:100pt;height:16pt;border:thin solid;'>&nbsp;</p></td>";
		$s .= "<td colspan=2>JOURNAL NO</td>";
		$s .= "<td colspan=2><p style='width:100pt;height:16pt;border:thin solid;'>&nbsp;</p></td>";
		$s .= "<td colspan=2>JOURNAL NO</td>";
		$s .= "<td colspan=2><p style='width:100pt;height:16pt;border:thin solid;'>&nbsp;</p></td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
			
		$s .= "<tr style='height:16.0pt'>";
		$s .= "<td colspan=2 style='height:16.0pt'>Signature of student</td>";
		$s .= "<td colspan=2><p style='width:120pt;height:16pt;border-bottom:thin solid;'>&nbsp;</p></td>";
		$s .= "<td colspan=2>Signature of student</td>";
		$s .= "<td colspan=2><p style='width:120pt;height:16pt;border-bottom:thin solid;'>&nbsp;</p></td>";
		$s .= "<td colspan=2>Signature of student</td>";
		$s .= "<td colspan=2><p style='width:120pt;height:16pt;border-bottom:thin solid;'>&nbsp;</p></td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
		
		
		$s .= "<tr style='height:16.0pt'>";
		$s .= "<td style='height:12.0pt'></td>";
		$s .= "<td colspan=3></td>";
		$s .= "<td></td>";
		$s .= "<td colspan=3></td>";
		$s .= "<td></td>";
		$s .= "<td colspan=3></td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
		
		
		$s .= "<tr style='height:18.0pt'>";
		$s .= "<td colspan=2 style='height:16.0pt'>Bank's authorized signature with seal</td>";
		$s .= "<td colspan=2><p style='width:120pt;height:16pt;border-bottom:thin solid;'>&nbsp;</p></td>";
		$s .= "<td colspan=2>Bank's authorized signature with seal</td>";
		$s .= "<td colspan=2><p style='width:120pt;height:16pt;border-bottom:thin solid;'>&nbsp;</p></td>";
		$s .= "<td colspan=2>Bank's authorized signature with seal</td>";
		$s .= "<td colspan=2><p style='width:120pt;height:16pt;border-bottom:thin solid;'>&nbsp;</p></td>";
		$s .= "<td style='width:20pt'></td>";
		$s .= "</tr>";
		
		$s .= "<tr style='height:10.0pt'>";
		$s .= "<td colspan=13 style='height:10.0pt'></td>";
		$s .= "</tr>";
			
		/*
		$s .= "<tr style='height:30pt;font-weight:700;'>";
				$s .= "<td colspan=4 style='height:27.75pt;'>Instruction for SWO:-<br>
							Please input fees in particular BOX (" . $arr[0] . "-" . $arr[$n-1] . ") &amp; CHALLAN NO. IN REF FIELD (MUST)</td>";
				$s .= "<td colspan=4>Instruction for SWO:-<br>
							Please input fees in particular BOX (" . $arr[0] . "-" . $arr[$n-1] . ") &amp; CHALLAN NO. IN REF FIELD (MUST)</td>";
				$s .= "<td colspan=4>Instruction for SWO:-<br>
							Please input fees in particular BOX (" . $arr[0] . "-" . $arr[$n-1] . ") &amp; CHALLAN NO. IN REF FIELD (MUST)</td>";
				$s .= "<td style='width:20pt'></td>";	    	
				$s .= "</tr>";*/
		
		
		$s .= "</table>";
		
		$this->convertToPDF($s, $filename, true, 'A4', 'landscape');
	}
		
	//rank card
	function convert_html_rank_to_pdf($data, $filename ='', $stream = TRUE, $paper = 'A6', $orientation = 'landscape') {
		$s = "<style type='text/css'>
				body{
					font:8pt Helvetica, serif;
					margin-top: 0.2em;
            		margin-left: 0.2em;
				}
				p {margin:0.2em 0 0 0;padding:0;}
				
				td.header {font-weight:700;font-size:14pt;}
				
				</style>";
		
		$s .= "<table border=0 cellpadding=0 cellspacing=0 style='border-collapse:collapse;table-layout:fixed;width:420pt;margin-bottom:20pt;'>";
		$s .= "<tr style='height:120.0pt'>";
		$s .= "<td style='width:86pt'><img src='" . $data['univ_logo'] . "'></td>";
		$s .= "<td align=center style='width:340pt' class='header'>";
		$s .= "The University of Burdwan<br/>Rajbati, Burdwan, 713104<br/>RANK CARD - B.Ed. Admission";
		$s .= "</td>";
		$s .= "<td align=center style='width:94pt'><img src='" . $data['appl_profile_pic'] . "' style='padding:2pt;border:thin solid;border-color:#666;'></td>";
		$s .= "</tr>";
		$s .= "<tr style='height:20.0pt'>";
		$s .= "<td colspan=2 style='width:426pt'>&nbsp;</td>";
		$s .= "<td style='width:94pt; height:20.0pt; border-bottom:thin solid;'></td>";
		$s .= "</tr>";
		$s .= "<tr style='height:12.0pt'>";
		$s .= "<td colspan=2 style='width:426pt'>&nbsp;</td>";
		$s .= "<td align=center style='width:94pt; height:12.0pt; font-size:7pt;'>Signature of the Candidate</td>";
		$s .= "</tr>";
		$s .= "</table>";
		
		$s .= "<table border=1 cellpadding=10 cellspacing=10 style='border-collapse:collapse;table-layout:fixed;width:520pt'><tr><td>";
		$s .= "<table border=0 cellpadding=0 cellspacing=0 style='border-collapse:collapse;table-layout:fixed;width:500pt'>";
		$s .= "<tr style='height:15.0pt'>";
		$s .= "<td style='height:15.0pt;width:110pt'>Method Name:</td>";
		$s .= "<td>" . $data['appl_method'] . "</td>";
		$s .= "<td style='width:110pt'>Application Code:</td>";
		$s .= "<td style='width:150pt'>" . $data['appl_code'] . "</td>";
		$s .= "</tr>";
		
		$s .= "<tr style='height:15.0pt'>";
		$s .= "<td style='height:15.0pt;'>Name of the Candidate:</td>";
		$s .= "<td>" . $data['appl_name'] . "</td>";
		$s .= "<td style='width:110pt'>Session:</td>";
		$s .= "<td style='width:150pt'>2015-2017</td>";
		$s .= "</tr>";
		
		$s .= "<tr style='height:15.0pt'>";
		$s .= "<td style='height:15.0pt;'>Candidate Category:</td>";
		$s .= "<td>" . getApplicationCategory($data['CTGR']). "</td>";
		$s .= "<td style='width:110pt'></td>";
		$s .= "<td style='width:150pt'></td>";
		$s .= "</tr>";
		$s .= "<tr style='height:15.0pt'><td colspan='4'><hr/></td></tr>";
		
		$genaral_rank = '';
		$obca_rank = '';
		$obcb_rank = '';
		$sc_rank = '';
		$st_rank = '';
		$pwd_rank = '';
		
		if($data['GEN'] != '' && $data['GEN'] != 0) $genaral_rank = $data['GEN']; else $genaral_rank = '---';
		if($data['SC'] != '' && $data['SC'] != 0) $sc_rank = $data['SC']; else $sc_rank = '---';
		if($data['ST'] != '' && $data['ST'] != 0) $st_rank = $data['ST']; else $st_rank = '---';
		if($data['PWD'] != '' && $data['PWD'] != 0) $pwd_rank = $data['PWD']; else $pwd_rank = '---';  
		
		$s .= "<tr style='height:15.0pt'><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
		$s .= "<tr style='height:25.0pt'><td colspan=3><b>Rank category</b></td><td><b>Provisional Rank</B></td></tr>";
		$s .= "<tr style='height:15.0pt'><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
		
		if($genaral_rank > 0){
		$s .= "<tr style='height:25.0pt'><td colspan=3>". $data['GEN_TYPE'] ."</td><td>". $genaral_rank ."</td></tr>";	
		}
		if($sc_rank > 0){
		$s .= "<tr style='height:25.0pt'><td colspan=3>". $data['SC_TYPE'] ."</td><td>". $sc_rank ."</td></tr>";	
		}
		if($st_rank > 0){
		$s .= "<tr style='height:25.0pt'><td colspan=3>". $data['ST_TYPE'] ."</td><td>". $st_rank ."</td></tr>";	
		}
		if($pwd_rank > 0){
		$s .= "<tr style='height:25.0pt'><td colspan=3>". $data['PWD_TYPE'] ."</td><td>". $pwd_rank ."</td></tr>";	
		}
		
		
		$s .= "<tr style='height:15.0pt'><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
		
		$s .= "<tr style='height:15.0pt'><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
		$s .= "<tr style='height:15.0pt'><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
		$s .= "<tr style='height:15.0pt'><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
		
		$s .= "<tr style='height:10.0pt;font-weight:700;font-size:10pt;'>";
		$s .= "<td colspan=2 valign=bottom style='height:10.0pt;'>&nbsp;</td>";
		$s .= "<td colspan=2 valign=bottom align=right>Faculty Council of Arts etc.</td>";
		$s .= "</tr>";	
		
		$s .= "<tr style='height:36pt;'>";
		$s .= "<td colspan=4 style='height:36pt;'>";
		$s .= "<p width=320 style='border:thin solid;padding:6pt;font-size:8pt;'>Carefully preserve this card. Show this card when you visit the counselling or admission.</p>";
		$s .= "</td></tr>";
						
		$s .= "</table>";
		$s .= "</td></tr>";
						
		$s .= "</table>";	
		$this->convertToPDF($s, $filename, true, 'A4', 'portrait');
	}			

	//application form
	function convert_html_applform_to_pdf($data, $filename ='', $stream = TRUE, $paper = 'A4', $orientation = 'landscape') {
		$s = "<style type='text/css'>
				body{
					font:9pt Helvetica, serif;
					margin-top: 0.2em;
            		margin-left: 0.2em;
				}
				p {margin:0.2em 0 0 0;padding:0;}
				
				td.header {font-weight:700;font-size:14pt;}
				
				</style>";
		
		$s .= "<table border=0 cellpadding=0 cellspacing=0 style='border-collapse:collapse;table-layout:fixed;width:530pt;margin-bottom:20pt;'>";
		$s .= "<tr style='height:120.0pt'>";
		$s .= "<td style='width:86pt'><img src='" . $data['univ_logo'] . "'></td>";
		$s .= "<td align=center style='width:350pt' class='header'>";
		$s .= "The University of Burdwan<br/>Rajbati, Burdwan, 713104<br/>APPLICATION FORM - B.ED";
		$s .= "</td>";
		$s .= "<td align=center style='width:94pt'><img src='" . $data['appl_profile_pic'] . "' style='padding:2pt;border:thin solid;border-color:#666;'></td>";
		$s .= "</tr>";
		$s .= "<tr style='height:20.0pt'>";
		$s .= "<td colspan=2 style='width:436pt'>&nbsp;</td>";
		$s .= "<td style='width:94pt; height:20.0pt; border-bottom:thin solid;'></td>";
		$s .= "</tr>";
		$s .= "<tr style='height:12.0pt'>";
		$s .= "<td colspan=2 style='width:436pt'>&nbsp;</td>";
		$s .= "<td align=center style='width:94pt; height:12.0pt; font-size:7pt;'>Signature of the Candidate</td>";
		$s .= "</tr>";
		$s .= "</table>";
			
		$s .= "<table border=0 cellpadding=0 cellspacing=0 style='border-collapse:collapse;table-layout:fixed;width:520pt'>";
		
		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Application Number:</td>";
  		$s .= "<td>" . $data['appl_code'] . "</td>";
  		$s .= "<td>Payment No:</td>";
  		$s .= "<td>" . $data['appl_pmt_code'] . "&nbsp;&nbsp; By " . $data['appl_pmt_type'] . "</td>";
 		$s .= "</tr>";
		
		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Session:</td>";
  		$s .= "<td>" . getCurrentSession() . "</td>";
  		$s .= "<td>Category:</td>";
  		$s .= "<td>" . getApplicationCategory($data['appl_ctgr']) . "</td>";
 		$s .= "</tr>";
 		
 		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Method Name:</td>";
  		$s .= "<td>" . $data['method_name'] . "</td>";
  		$s .= "<td style='height:20.0pt'>Gender:</td>";
  		$s .= "<td>" . getGenderName($data['appl_gender']) . "</td>";
 		$s .= "</tr>"; 	

		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Method Paper -I :</td>";
  		$s .= "<td>" . $data['appl_method_paper1_name'] . "</td>";
  		$s .= "<td style='height:20.0pt'>Method Paper -II :</td>";
  		$s .= "<td>" . $data['appl_method_paper2_name'] . "</td>";
 		$s .= "</tr>"; 
		
 		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Name of Applicant:</td>";
  		$s .= "<td>" . $data['appl_name'] . "</td>";
  		$s .= "<td>Date of Birth:</td>";
  		$s .= "<td>" . getDateFormat($data['appl_dob']) . "</td>";
 		$s .= "</tr>";
 
  		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td>Caste:</td>";
  		$s .= "<td>" . $data['resv_name'] . "</td>";
		$s .= "<td style='height:20.0pt'>PWD:</td>";
  		$s .= "<td>" . getYesNo($data['appl_is_pwd']). "</td>";
 		$s .= "</tr>";
 		
 	 	$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Gurdian Name:</td>";
  		$s .= "<td>" . $data['appl_gurd_name'] . "</td>";
  		$s .= "<td style='height:20.0pt'>Gurdian Relation:</td>";
  		$s .= "<td>" . getGurdianOName($data['appl_gurd_rel']) . "</td>";
 		$s .= "</tr>";
 
  		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Communication Address:</td>";
  		$s .= "<td>" . $data['appl_comm_addr1'] . "</td>";
  		$s .= "<td>Address 2:</td>";
  		$s .= "<td>" . $data['appl_comm_addr2'] . "</td>";
 		$s .= "</tr>";

 		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>City / Town / Village:</td>";
  		$s .= "<td>" . $data['appl_comm_city'] . "</td>";
  		$s .= "<td>District:</td>";
  		$s .= "<td>" . $data['appl_comm_dist'] . "</td>";
 		$s .= "</tr>";
 
   		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>State / Union Territory:</td>";
  		$s .= "<td>" . $data['state_name'] . "</td>";
  		$s .= "<td>PIN Code:</td>";
  		$s .= "<td>" . $data['appl_comm_pin'] . "</td>";
 		$s .= "</tr>";
 
  		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Mobile No:</td>";
  		$s .= "<td>" . $data['appl_phone'] . "</td>";
  		$s .= "<td>Email Id:</td>";
  		$s .= "<td>" . $data['appl_email'] . "</td>";
 		$s .= "</tr>";
 
		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Name of the University:</td>";
  		$s .= "<td>" . $data['appl_univ_name'] . "</td>";
  		$s .= "<td style='height:20.0pt'>Registration No:</td>";
  		$s .= "<td>" . $data['appl_univ_regno'] . "</td>";
 		$s .= "</tr>";
		
		$s .= "<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>";
		
 		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Exam Passed:</td>";
  		$s .= "<td>10th or Equivalent</td>";
  		$s .= "<td>Board:</td>";
  		$s .= "<td>" . $data['appl_mp_board_name'] . "</td>";
 		$s .= "</tr>";		
 		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Year of Passing:</td>";
  		$s .= "<td>" . $data['appl_mp_pyear'] . "</td>";
  		$s .= "<td>Subject(s) Studied:</td>";
  		$s .= "<td>" . $data['appl_mp_subj'] . "</td>";
 		$s .= "</tr>";		
  		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>% of Marks:</td>";
  		$s .= "<td>" . $data['appl_mp_pct'] . "</td>";
  		$s .= "<td></td>";
  		$s .= "<td></td>";
 		$s .= "</tr>";
		
		$s .= "<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>";
		
		
		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Exam Passed:</td>";
  		$s .= "<td>12th/ Equivalent</td>";
  		$s .= "<td>Council:</td>";
  		$s .= "<td>" . $data['appl_hs_board_name'] . "</td>";
 		$s .= "</tr>";		
 		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Year of Passing:</td>";
  		$s .= "<td>" . $data['appl_hs_pyear'] . "</td>";
  		$s .= "<td>Subject(s) Studied:</td>";
  		$s .= "<td>" . $data['appl_hs_subj'] . "</td>";
 		$s .= "</tr>";		
  		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>% of Marks:</td>";
  		$s .= "<td>" . $data['appl_hs_pct'] . "</td>";
  		$s .= "<td></td>";
  		$s .= "<td></td>";
 		$s .= "</tr>";
 		
 		$s .= "<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>";
		
		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Exam Passed:</td>";
  		$s .= "<td>Graduation</td>";
  		$s .= "<td>University:</td>";
  		$s .= "<td>" . $data['appl_ug_board_name'] . "</td>";
 		$s .= "</tr>";		
 		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Year of Passing:</td>";
  		$s .= "<td>" . $data['appl_ug_pyear'] . "</td>";
  		$s .= "<td>Subject(s) Studied:</td>";
  		$s .= "<td>" . $data['appl_ug_subj_name'] . " (". getUGCategoryName($data['appl_ug_ctgry']). ")".  "</td>";
 		$s .= "</tr>";		
  		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>% of Marks:</td>";
  		$s .= "<td>" . $data['appl_ug_pct'] .  "</td>";
  		$s .= "<td></td>";
  		$s .= "<td></td>";
 		$s .= "</tr>";
 		
		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>M.Phil :</td>";
  		$s .= "<td>" . getYesNo($data['appl_is_mphil']) . "</td>";
  		$s .= "<td style='height:20.0pt'>P.hd :</td>";
  		$s .= "<td>" . getYesNo($data['appl_is_phd']) . "</td>";
 		$s .= "</tr>";
 		
		
		if($data['lastExamCtgr'] == 'M'){
			$s .= "<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>";
		
			$s .= "<tr style='height:20.0pt'>";
	  		$s .= "<td style='height:20.0pt'>Exam Passed:</td>";
	  		$s .= "<td>Post Graduation</td>";
	  		$s .= "<td>University:</td>";
	  		$s .= "<td>" . $data['appl_pg_board_name'] . "</td>";
	 		$s .= "</tr>";		
	 		$s .= "<tr style='height:20.0pt'>";
	  		$s .= "<td style='height:20.0pt'>Year of Passing:</td>";
	  		$s .= "<td>" . $data['appl_pg_pyear'] . "</td>";
	  		$s .= "<td>Subject(s) Studied:</td>";
	  		$s .= "<td>" . $data['appl_pg_subj_name'] . "</td>";
	 		$s .= "</tr>";		
	  		$s .= "<tr style='height:20.0pt'>";
	  		$s .= "<td style='height:20.0pt'>% of Marks:</td>";
	  		$s .= "<td>" . $data['appl_pg_pct'] . "</td>";
	  		$s .= "<td></td>";
	  		$s .= "<td></td>";
	 		$s .= "</tr>";
		}
		
		if($data['appl_ctgr'] == 'D'){
			$s .= "<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>";
		
			$s .= "<tr style='height:20.0pt'>";
	  		$s .= "<td style='height:20.0pt'>Deputed Organization Name:</td>";
	  		$s .= "<td>" . $data['appl_dep_org_name'] . "</td>";
	  		$s .= "<td>Deputed Organization Address:</td>";
	  		$s .= "<td>" . $data['appl_dep_org_addr'] . "</td>";
	 		$s .= "</tr>";		
	 		$s .= "<tr style='height:20.0pt'>";
	  		$s .= "<td style='height:20.0pt'>Appointment Date:</td>";
	  		$s .= "<td>" . getDateFormat($data['appl_dep_apnt_date']) . "</td>";
	  		$s .= "<td>Approve Date:</td>";
	  		$s .= "<td>" . getDateFormat($data['appl_dep_apprv_date']) . "</td>";
	 		$s .= "</tr>";	
		}
 		
		$s .= "</table>";
			
		$s .= "<div style='position:absolute;bottom:20pt;'>Form submitted on: " .  getDateFormat($data['appl_created_on']) . "</div>";
			
		//echo $s;
			
		$this->convertToPDF($s, $filename, true, 'A4', 'portrait');
	}	
	
	function convert_html_meritlist_to_pdf($data, $filename ='', $stream = TRUE, $paper = 'A4', $orientation = 'landscape') {
		$s = "<style type='text/css'>
				body{
					font:8.5pt Helvetica, serif;
					margin-top: -3.0em;
            		margin-left: 0.2em;
				}
				p {margin:0.2em 0 0 0;padding:0;}
				
				.header {font-weight:700;font-size:10pt;border: 0pt;}
				
				table.collapse {
				  border-collapse: collapse;
				  border: 0.6pt solid black;  
				}
				
				table.collapse td {
				  border: 0.4pt solid black;
				  cellpadding: 0pt;
				  cellspacing: 0pt;
				}
				
				</style>";
		$s .= "<br/><br/>"; 
		
		$s .= "<table style='table-layout:fixed;width:530pt;margin-bottom:0pt; margin-top:-1pt;'>";
		$s .= "<tr>";
		$s .= "<td style='width:100pt;' align='left'> <img src='" . $data['univ_logo'] . "'></td>";
		$s .= "<td align='center'>";
		$s .= "<table style='table-layout:fixed; align=center'>";
		$s .= "<tr><td class='header' align='center' style='font-size:12pt;'>The University of Burdwan</td></tr>";
		$s .= "<tr><td class='header' align='center' style='font-size:9pt;'>" . $data['header']. "</td></tr>";
		$s .= "<tr><td class='header' align='center' style='font-size:10pt;'>" . $data['info']['description']. "</td></tr>";
		$s .= "</table>";
		$s .= "</td>";
		$s .= "<td style='width:170pt;'>";
		$s .= "<table style='table-layout:fixed;width:170pt; border: 0.8pt solid black'>";
		$s .= "<tr style='height:14.0pt'><td class='' align='left' style='font-size:9pt;'>CATEGORY: </td><td style='font-size:9pt;'>" . $data['info']['cand_ctgry_name'] . "</td></tr>";
		$s .= "<tr style='height:14.0pt'><td class='' align='left' style='font-size:9pt;'>METHOD TYPE: </td><td style='font-size:9pt;'>" . $data['info']['method_type_name'] . "</td></tr>";
		$s .= "<tr style='height:14.0pt'><td class='' align='left' style='font-size:9pt;'>RESERVATION: </td><td style='font-size:9pt;'>" . $data['info']['resv_name'] . "</td></tr>";
		$s .= "</table>";
		$s .= "</td>";
		$s .= "</tr>";
		$s .= "</table>";
		
		
		$s .= "<table class='collapse' style='table-layout:fixed;width:530pt; margin-top:-5pt;'>";
		$s .= "<tr class='header'>";
		$s .= "<td align=center style='width:50pt; '>Application Code.</td>";
		$s .= "<td align=center style='width:100pt; '>Applicant's Name.</td>";
		$s .= "<td align=center style='width:50pt; '>Reservation.</td>";
		$s .= "<td align=center style='width:40pt; '>Rank.</td>";
		if($data['info']['cand_ctgry'] == 'D'){
			$s .= "<td align=center style='width:60pt; '>Experience.</td>";	
		}else{
			$s .= "<td align=center style='width:60pt; '>Score.</td>";			
		}
		$s .= "</tr>";
		
		for($i=0; $i<sizeof($data['data']); $i++) {
			$s .= "<tr>";
			$s .= "<td align=center style='width:80pt; font-size:9pt;'>". $data['data'][$i]['appl_code'] ."</td>";
			$s .= "<td align=left style='width:100pt; font-size:9pt;'> &nbsp;". $data['data'][$i]['appl_name'] ."</td>";
			$s .= "<td align=left style='width:100pt; font-size:9pt;'> &nbsp;". $data['data'][$i]['resv_name'] ."</td>";
			$s .= "<td align=center style='width:60pt; font-size:10pt;'>". $data['data'][$i]['appl_merit'] ."</td>";
			if($data['info']['cand_ctgry'] == 'D'){
				$s .= "<td align=center style='width:60pt; font-size:10pt;'>". $data['data'][$i]['appl_dep_exp_month'] ."</td>";	
			}else{
				$s .= "<td align=center style='width:60pt; font-size:10pt;'>". $data['data'][$i]['appl_score'] ."</td>";			
			}
			$s .= "</tr>";
		}
		$s .= "</table>";
		
		$s .= "Page: " . $data['data'][0]['PAGENO'] ;
		
		//echo $s; print_r($data); exit();
		
		
		$this->convertToPDF($s, $filename, true, 'A4', 'portrait');
	}
}
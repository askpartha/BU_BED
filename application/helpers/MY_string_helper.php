<?php
function getFullname($firstname, $midname, $lastname)
{
	$fullname = $firstname . ' ' . ($midname == '' ? '' : $midname . ' ') . $lastname;
	return $fullname;	
}

function getDateFormat($date, $format = 'd-M-Y')
{
	$userTimezone = new DateTimeZone('Asia/Kolkata');
	//$gmtTimezone = new DateTimeZone('GMT');
	$myDateTime = new DateTime($date, $userTimezone);
	//$offset = $userTimezone->getOffset($myDateTime);	
	$my_date_format = date($format, $myDateTime->format('U') );	
	return $my_date_format;	
}

function convertToMySqlDate($date, $fromFormat='d-m-Y', $toFormat='Y-m-d') {
	$dt   = new DateTime();
	$datetime = $dt->createFromFormat($fromFormat, $date)->format($toFormat);
	return $datetime; 
}

function getYearMonth($date) {
	$date = explode('-', $date);
	$now = explode('-', date("Y-m-d"));
	$old = $now[0]*12+$now[1]-$date[0]*12-$date[1]-($date[2]>$now[2] ? 1 : 0);
	return floor($old / 12) .  " yrs " . ($old % 12) . " mths";
}

function getRelativeTime($timestamp){
	// Get time difference and setup arrays
	$difference = time() - $timestamp;
	$periods = array("second", "minute", "hour", "day", "week", "month", "years");
	$lengths = array("60","60","24","7","4.35","12");
 
	// Past or present
	if ($difference >= 0) {
		$ending = "ago";
	}
	else {
		$difference = -$difference;
		$ending = "to go";
	}
 
	// Figure out difference by looping while less than array length
	// and difference is larger than lengths.
	$arr_len = count($lengths);
	for($j = 0; $j < $arr_len && $difference >= $lengths[$j]; $j++) {
		$difference /= $lengths[$j];
	}
 
	// Round up		
	$difference = round($difference);
 
	// Make plural if needed
	if($difference != 1) {
		$periods[$j].= "s";
	}
 
	// Default format
	$text = "$difference $periods[$j] $ending";
 
	// over 24 hours
	if($j > 2) {
		// future date over a day formate with year
		if($ending == "to go") {
			if($j == 3 && $difference == 1) {
				$text = "Tomorrow at ". date("g:i a", $timestamp);
			}
			else {
				$text = date("F j, Y \a\\t g:i a", $timestamp);
			}
			return $text;
		}
 
		if($j == 3 && $difference == 1) { // Yesterday 
			$text = "Yesterday at ". date("g:i a", $timestamp);
		}
		else if($j == 3) { // Less than a week display -- Monday at 5:28pm
			$text = date("l \a\\t g:i a", $timestamp);
		}
		else if($j < 6 && !($j == 5 && $difference == 12)) { // Less than a year display -- June 25 at 5:23am
			$text = date("F j \a\\t g:i a", $timestamp);
		}
		else { // if over a year or the same month one year ago -- June 30, 2010 at 5:34pm
			$text = date("F j, Y \a\\t g:i a", $timestamp);
		}
	}
 
	return $text;
} 

function dateDiff($dateStart, $dateEnd) {
    $start = strtotime($dateStart);
    $end = strtotime($dateEnd);
    $days = ($end - $start) + 1;
    $days = ceil($days/86400);
    return $days;
}

function firstNwords($text, $length = 200, $dots = true) {
    $text = trim(preg_replace('#[\s\n\r\t]{2,}#', ' ', $text));
    $text_temp = $text;
    while (substr($text, $length, 1) != " ") { $length++; if ($length > strlen($text)) { break; } }
    $text = substr($text, 0, $length);
    return $text . ( ( $dots == true && $text != '' && strlen($text_temp) > $length ) ? '...' : ''); 
}

function getFormatedAmount($val) {
	return number_format($val, 2, '.', ',');
}

function getAmtInWords($no) {
    $words = array('0'=> '' ,'1'=> 'One' ,'2'=> 'Two' ,'3' => 'Three','4' => 'Four','5' => 'Five','6' => 'Six',
    				'7' => 'Seven','8' => 'Eight','9' => 'Nine','10' => 'Ten','11' => 'Eleven',
    				'12' => 'Twelve','13' => 'Thirteen','14' => 'Fouteen','15' => 'Fifteen','16' => 'Sixteen',
    				'17' => 'Seventeen','18' => 'Eighteen','19' => 'Nineteen','20' => 'Twenty',
    				'30' => 'Thirty','40' => 'Fourty','50' => 'Fifty','60' => 'Sixty','70' => 'Seventy',
    				'80' => 'Eighty','90' => 'Ninty','100' => 'Hundred','1000' => 'Thousand','100000' => 'Lakh','10000000' => 'Crore');
    if($no == 0)
    	return ' ';
    else {
	    $novalue='';
	    $highno=$no;
	    $remainno=0;
	    $value=100;
	    $value1=1000;
	    while($no>=100) {
    		if(($value <= $no) &&($no < $value1)) {
			    $novalue=$words["$value"];
			    $highno = (int)($no/$value);
			    $remainno = $no % $value;
			    break;
    		}
		    $value= $value1;
		    $value1 = $value * 100;
    	}
	    if(array_key_exists("$highno",$words))
	    	return $words["$highno"]." ".$novalue." ".getAmtInWords($remainno);
	    else {
		    $unit=$highno%10;
		    $ten =(int)($highno/10)*10;
	    	return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".getAmtInWords($remainno);
	    }
	}
}	

function getApplicationStatus($key) {
		$msg = '';
		switch ($key) {
		case "records_per_page":
			$msg = 40;
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

function getApplicationStatusText($val) {
	switch ($val) {
		case "1":
			$msg = "Form Submitted";
			break;
		case "2":
			$msg = "Payment Verified";
			break;
		case "3":
			$msg = "Application Confirmed";
			break;	
		case "4":
			$msg = "Admission Confirmed";
			break;			
	}
	return $msg;
}

function getJournalStatus($val) {
	switch ($val) {
		case "0":
			$msg = "Not Verified";
			break;
		case "1":
			$msg = "Verified";
			break;
		case "2":
			$msg = "Cancelled";
			break;			
	}
	return $msg;
}


function getMonthToJune($date) {
	if($date != null && $date != ''){
		$ts1 = strtotime($date);
		$ts2 = strtotime('30-06-2015');
		
		$year1 = date('Y', $ts1);
		$year2 = date('Y', $ts2);
	
		$month1 = date('m', $ts1);
		$month2 = date('m', $ts2);
	
		//echo (($year2 - $year1) * 12) + ($month2 - $month1); exit();
		
		return (($year2 - $year1) * 12) + ($month2 - $month1);
	}else{
		return 0;
	}
}

function getApplicationCategory($val) {
	$msg = '';
	switch ($val) {
		case "F":
			$msg = "Freshers";
			break;
		case "D":
			$msg = "Deputed";
			break;
	}
	return $msg;
}


function getGenderName($val) {
	$msg = '';
	switch ($val) {
		case "M":
			$msg = "Male";
			break;
		case "F":
			$msg = "Female";
			break;
	}
	return $msg;
}

function getGurdianOName($val) {
	$msg = '';
	switch ($val) {
		case "F":
			$msg = "FATHER";
			break;
		case "M":
			$msg = "MOTHER";
			break;
		case "H":
			$msg = "HUSBAND";
			break;
		case "S":
			$msg = "SISTER";
			break;
		case "B":
			$msg = "BROTHER";
			break;
		case "O":
			$msg = "OTHER";
			break;
	}
	return $msg;
}

function getNationalityName($val) {
	$msg = '';
	switch ($val) {
		case "I":
			$msg = "INDIAN";
			break;
		case "O":
			$msg = "OTHER";
			break;
	}
	return $msg;
}

function getUGCategoryName($val) {
	$msg = '';
	switch ($val) {
		case "H":
			$msg = "HONOURS";
			break;
		case "G":
			$msg = "GENERAL";
			break;
	}
	return $msg;
}

function getUniversityCategoryName($val) {
	$msg = '';
	switch ($val) {
		case "OU":
			$msg = "OTHER UNIVERSITY";
			break;
		case "BU":
			$msg = "BURDWAN UNIVERSITY";
			break;
	}
	return $msg;
}

function getYesNo($val) {
	$msg = '';
	switch ($val) {
		case "1":
			$msg = "YES";
			break;
		case "0":
			$msg = "NO";
			break;
	}
	return $msg;
}

function getScorePoint($StepOneApplData, $StepTwoApplData){
	$appl_mp_pct 	= $StepOneApplData['appl_mp_pct'];
	$appl_hs_pct 	= $StepOneApplData['appl_hs_pct'];
	$appl_ug_pct 	= $StepOneApplData['appl_ug_pct'];
	$appl_ug_ctgry 	= $StepOneApplData['appl_ug_ctgry'];
	$appl_pg_pct 	= $StepOneApplData['appl_pg_pct'];
	$appl_is_mphil 	= $StepTwoApplData['appl_is_mphil'];
	$appl_is_phd 	= $StepTwoApplData['appl_is_phd'];
	
	$score = 0;
	
	$score += ($appl_mp_pct * 0.1);
	$score += ($appl_hs_pct * 0.1);
	
	if($appl_ug_ctgry == 'H'){
		$score += ($appl_ug_pct * 0.2);	
	}else{
		$score += ($appl_ug_pct * 0.15);
	}
	if($appl_pg_pct == '' || $appl_pg_pct == null){
		$appl_pg_pct = 0;
	}
	$score += ($appl_pg_pct * 0.2);
	
	if($appl_is_phd == 1){
		$score+= 8;
	}elseif($appl_is_mphil == 1){
		$score+= 5;
	}
	
	//echo $score; exit();
	
	return $score;
}

//=========================================================================================:START
function applicationFeesAmount(){
	$application_fees = 500;
	return $application_fees;
}

function admissionFeesAmountDeputed(){
	$application_fees = '18,530';
	return $application_fees;
}

function admissionFeesAmountFreshers(){
	$application_fees = '6,530';
	return $application_fees;
}

function admissionName(){
	$adm_name = '2-Yr. B.Ed. Admission ';
	return $adm_name;
}

function PowerJyotiAccountNo(){
	$act_no = '32868998865';
	return $act_no;
}

function DraftFavourOf(){
	$name = '<b><u>FINANCE OFFICER, THE UNIVERSITY OF BURDWAN, PAYBLE AT SBI, BU BRANCH</u></b>';
	return $name;
}

function paymentSubmissionAddress(){
	$name = '<b>Office of the Secretory, F.C. (Arts etc), Rajbati, University of Burdwn</b>';
	return $name;
}

function getCurrentSession() {
	return '2015-2017';
}

function sendUserPassword($data){
	$user_name 		= $data['user_name'];
	$ph_nos 		= $data['user_phone'];
	$password 		= $data['user_password'];
	
	//SEND TO MOBILE
	$sms_msg    = 'YOUR NEW PASSWORD : '.$password;
	$sms_msg	=	str_replace(" ", "+", $sms_msg);
		
	/**/
	$url		=	'http://sms99.co.in/pushsms.php';
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url . "?username=demo7788&password=demo7788&sender=CAMERA&message=" . $sms_msg . "&numbers=" . $ph_nos);
	$output = curl_exec($curl);
	curl_close ($curl);
	
	return TRUE;
}

//=========================================================================================: END

function getRecordFromCSV($csv_file){
	$csvFile = file($csv_file);
	$data = array();
	foreach ($csvFile as $line) {
		$data[] = str_getcsv($line);
	}
	return $data;
}

function getPaymentCSVHeader(){
	$header = array('Application Code', 'Application Name', 'Payment Date', 'Payment Number', 'Payment Item');
	return $header;
}
?>
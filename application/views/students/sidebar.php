<ul class='student-dashboard-links'>

	<?php 
		if($this->session->userdata('appl_status') > 2  && $this->session->userdata('appl_status') != 9 && $this->session->userdata['student']['student_pic'] != '' && $this->session->userdata['student']['result_pub_flag']) {
			echo '<li>' . anchor('admissions/downloadrankcard/' . $this->session->userdata('appl_num'), '<i class="fa fa-download"></i> Download Rank Card') . '</li>';
		} else{
			echo '<li><i class="fa fa-download"></i> Download Rank Card</li>';			
		} 
	?>
	
	<?php  echo '<li>' . anchor('admissions/downloadapplform/' . $this->session->userdata('appl_num'), '<i class="fa fa-download"></i> Download Application Form') . '</li>'; ?>
	
	<?php 
		if($this->session->userdata('appl_status') < 2) {
			echo '<li>' . anchor('admissions/pgadmedit', '<i class="fa fa-edit"></i> Modify your application') . '</li>';
		} else {
			echo '<li><i class="fa fa-upload"></i> Modify your application</li>';
		}
	?>
	<?php echo '<li>' . anchor('students/uploadphoto', '<i class="fa fa-upload"></i> Upload your photo') . '</li>'; ?>
	<li><?php echo anchor('students/changepass/', '<i class="fa fa-key"></i> Change Password');?></li>
</ul>
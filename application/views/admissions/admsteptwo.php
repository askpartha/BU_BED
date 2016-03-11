<div class="page-title">
	
</div>	
<div class="container-fluid">
	<div class="row" style="height: 480px;margin: 10px; ">
		<?php
			$form = array(
							'class'	=>	'form-horizontal lft-pad-nm',
							'role'	=>	'form',
							'id' => 'addeditform'
						);	
			echo form_open('admissions/submitsteptwo', $form);
		?>
		
		<!-- start 1st row -->
		<div class="container-fluid">
			<div class="row">
				<?php
					if($this->session->flashdata('success')) {
						echo "<div class='alert alert-success action-message'>" . $this->session->flashdata('success') . "</div>";
					} else if($this->session->flashdata('failure')) {
						echo "<div class='alert alert-danger action-message'>" . $this->session->flashdata('failure') . "</div>";
					}
				?>
				<div class="col-lg-6 col-sm-6">
					<div class="form-group">
						<label>Name : <span id="appl_name"><?php echo $appl_name?></span></label>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Religion</label>
						<?php
							$appl_relegion_data = 'id="appl_relegion" tabindex="1" class="col-xs-10"';				
							echo form_dropdown('appl_relegion', $relligion_options, null, $appl_relegion_data);
						?>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Nationality</label>
						<?php
							$appl_nationality_data = 'id="appl_nationality" tabindex="2" class="col-xs-10"';				
							echo form_dropdown('appl_nationality', $nationality_options, null, $appl_nationality_data);
						?>
					</div>
				</div>
			</div>
			<!-- end 1st row -->
		</div>
		
		<!-- start 2nd row -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Gurdian's Name</label>
						<?php
							$appl_gurd_name_data = array(
													'name'	=> 'appl_gurd_name', 	
													'id'	=> 'appl_gurd_name',
													'value' =>  '',	
													'maxlength'=>'50',	
													'tabindex'=>"3",						
													'class'	=>	'col-xs-11 col-sm-11'
					            				);
							echo form_input($appl_gurd_name_data);
						?>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Relation with Gurdian</label>
						<?php
							$appl_gurd_rel_data = 'id="appl_gurd_rel" tabindex="4" class="col-xs-10"';				
							echo form_dropdown('appl_gurd_rel', $gurd_options, null, $appl_gurd_rel_data);
						?>
						
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Gender</label>
						<?php
							$appl_gender_data = 'id="appl_gender" tabindex="5" class="col-xs-10"';				
							echo form_dropdown('appl_gender', $gender_options, null, $appl_gender_data);
						?>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Date of Birth</label>
						<?php
							$appl_dob_data = array(
													'name'	=> 'appl_dob', 	
													'id'	=> 'appl_dob',
													'value' =>  '',	
													'maxlength'=>'10',	
													'tabindex'=>"6",						
													'class'	=>	'col-xs-9 col-sm-9 datepicker'
					            				);
							echo form_input($appl_dob_data);
						?>
					</div>
				</div>
			</div>
		</div>	<!-- end 2nd row -->	
		
		<h4>Communication Address:</h4>
		<!-- start 3rd row -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Address-I</label>
						<?php
							$appl_comm_addr1_data = array(
													'name'	=> 'appl_comm_addr1', 	
													'id'	=> 'appl_comm_addr1',
													'value' =>  '',	
													'maxlength'=>'100',	
													'tabindex'=>"7",						
													'class'	=>	'col-xs-11 col-sm-11'
					            				);
							echo form_input($appl_comm_addr1_data);
						?>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Address-II</label>
						<?php
							$appl_comm_addr2_data = array(
													'name'	=> 'appl_comm_addr2', 	
													'id'	=> 'appl_comm_addr2',
													'value' =>  '',	
													'maxlength'=>'100',	
													'tabindex'=>"8",						
													'class'	=>	'col-xs-11 col-sm-11'
					            				);
							echo form_input($appl_comm_addr2_data);
						?>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>City</label>
						<?php
							$appl_comm_city_data = array(
													'name'	=> 'appl_comm_city', 	
													'id'	=> 'appl_comm_city',
													'value' =>  '',	
													'maxlength'=>'30',	
													'tabindex'=>"9",						
													'class'	=>	'col-xs-11 col-sm-11'
					            				);
							echo form_input($appl_comm_city_data);
						?>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>District</label>
						<?php
							$appl_comm_dist_data = array(
													'name'	=> 'appl_comm_dist', 	
													'id'	=> 'appl_comm_dist',
													'value' =>  '',	
													'maxlength'=>'30',	
													'tabindex'=>"10",						
													'class'	=>	'col-xs-11 col-sm-11'
					            				);
							echo form_input($appl_comm_dist_data);
						?>
						
					</div>
				</div>
			</div>
		</div>	
		<!-- end 3rd row -->
		
		<!-- start 4th row -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>State</label>
						<?php
							$appl_comm_state_data = 'id="appl_comm_state" tabindex="10" class="col-xs-10"';				
							echo form_dropdown('appl_comm_state', $state_options, null, $appl_comm_state_data);
						?>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Pin</label>
						<?php
							$appl_comm_pin_data = array(
													'name'	=> 'appl_comm_pin', 	
													'id'	=> 'appl_comm_pin',
													'value' =>  '',	
													'maxlength'=>'6',	
													'tabindex'=>"11",						
													'class'	=>	'col-xs-11 col-sm-11'
					            				);
							echo form_input($appl_comm_pin_data);
						?>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Mobile Number</label>
						<?php
							$appl_phone_data = array(
													'name'	=> 'appl_phone', 	
													'id'	=> 'appl_phone',
													'value' =>  '',	
													'maxlength'=>'10',	
													'tabindex'=>"12",						
													'class'	=>	'col-xs-11 col-sm-11 number'
					            				);
							echo form_input($appl_phone_data);
						?>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Email Address</label>
						<?php
							$appl_email_data = array(
													'name'	=> 'appl_email', 	
													'id'	=> 'appl_email',
													'value' =>  '',	
													'maxlength'=>'100',	
													'tabindex'=>"13",						
													'class'	=>	'col-xs-11 col-sm-11'
					            				);
							echo form_input($appl_email_data);
						?>
					</div>
				</div>
			</div>
		</div>	
		<!-- end 4th row -->
		
		<!-- start 5th row -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>University Name</label>
						<?php
							$appl_univ_name_data = array(
													'name'	=> 'appl_univ_name', 	
													'id'	=> 'appl_univ_name',
													'value' =>  '',	
													'maxlength'=>'100',	
													'tabindex'=>"14",						
													'class'	=>	'col-xs-11 col-sm-11'
					            				);
							echo form_input($appl_univ_name_data);
						?>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>University Registration Number</label>
						<?php
							$appl_univ_regno_data = array(
													'name'	=> 'appl_univ_regno', 	
													'id'	=> 'appl_univ_regno',
													'value' =>  '',	
													'maxlength'=>'30',	
													'tabindex'=>"15",						
													'class'	=>	'col-xs-11 col-sm-11'
					            				);
							echo form_input($appl_univ_regno_data);
						?>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Phd Done</label>
						<?php
							$appl_is_phd_data = 'id="appl_is_phd" tabindex="16" class="col-xs-6"';				
							echo form_dropdown('appl_is_phd', $yesno_options, null, $appl_is_phd_data);
						?>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>M.Phil Done</label>
						<?php
							$appl_is_mphil_data = 'id="appl_is_mphil" tabindex="17" class="col-xs-6"';				
							echo form_dropdown('appl_is_mphil', $yesno_options, null, $appl_is_mphil_data);
						?>
					</div>
				</div>
			</div>
		</div>	
		<!-- end 5th row -->
		
		<h4>Marks History</h4> 
		<!-- start 6th row -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-5 col-sm-5">
					<div class="form-group">
						<label>10th Standard Board</label>
						<?php
							$appl_mp_board_data = 'id="appl_mp_board" tabindex="18" class="col-xs-10"';				
							echo form_dropdown('appl_mp_board', $board_options, null, $appl_mp_board_data);
						?>
					</div>
				</div>
				<div class="col-lg-2 col-sm-2">
					<div class="form-group">
						<label>Passing Year</label>
						<?php
							$appl_mp_pyear_data = array(
													'name'	=> 'appl_mp_pyear', 	
													'id'	=> 'appl_mp_pyear',
													'value' =>  '',	
													'maxlength'=>'4',	
													'tabindex'=>"19",						
													'class'	=>	'col-xs-6 col-sm-6'
					            				);
							echo form_input($appl_mp_pyear_data);
						?>
					</div>
				</div>
				<div class="col-lg-2 col-sm-2">
					<div class="form-group">
						<label>Obtained Marks in %</label>
						<?php echo $appl_mp_pct; ?>						
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Subjects</label>
						<?php
							$appl_mp_subj_data = array(
													'name'	=> 'appl_mp_subj', 	
													'id'	=> 'appl_mp_subj',
													'value' =>  '',	
													'maxlength'=>'50',	
													'tabindex'=>"20",						
													'class'	=>	'col-xs-11 col-sm-11'
					            				);
							echo form_input($appl_mp_subj_data);
						?>
					</div>
				</div>
			</div>
		</div>	
		<!-- end 6th row -->
		
		<!-- start 7th row -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-5 col-sm-5">
					<div class="form-group">
						<label>12th Standard Board</label>
						<?php
							$appl_hs_board_data = 'id="appl_hs_board" tabindex="21" class="col-xs-10"';				
							echo form_dropdown('appl_hs_board', $council_options, null, $appl_hs_board_data);
						?>
					</div>
				</div>
				<div class="col-lg-2 col-sm-2">
					<div class="form-group">
						<label>Passing Year</label>
						<?php
							$appl_hs_pyear_data = array(
													'name'	=> 'appl_hs_pyear', 	
													'id'	=> 'appl_hs_pyear',
													'value' =>  '',	
													'maxlength'=>'4',	
													'tabindex'=>"22",						
													'class'	=>	'col-xs-6 col-sm-6'
					            				);
							echo form_input($appl_hs_pyear_data);
						?>
					</div>
				</div>
				<div class="col-lg-2 col-sm-2">
					<div class="form-group">
						<label>Obtained Marks in %</label>
						<?php echo $appl_hs_pct; ?>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Subjects</label>
						<?php
							$appl_hs_subj_data = array(
													'name'	=> 'appl_hs_subj', 	
													'id'	=> 'appl_hs_subj',
													'value' =>  '',	
													'maxlength'=>'50',	
													'tabindex'=>"23",						
													'class'	=>	'col-xs-11 col-sm-11'
					            				);
							echo form_input($appl_hs_subj_data);
						?>
					</div>
				</div>
			</div>
		</div>	
		<!-- end 7th row -->
		
		<!-- start 8th row -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-5 col-sm-5">
					<div class="form-group">
						<label>Graduation University</label>
						<?php
							$appl_ug_board_data = 'id="appl_ug_board" tabindex="24" class="col-xs-10"';				
							echo form_dropdown('appl_ug_board', $university_options, null, $appl_ug_board_data);
						?>
					</div>
				</div>
				<div class="col-lg-2 col-sm-2">
					<div class="form-group">
						<label>Passing Year</label>
						<?php
							$appl_ug_pyear_data = array(
													'name'	=> 'appl_ug_pyear', 	
													'id'	=> 'appl_ug_pyear',
													'value' =>  '',	
													'maxlength'=>'4',	
													'tabindex'=>"25",						
													'class'	=>	'col-xs-6 col-sm-6'
					            				);
							echo form_input($appl_ug_pyear_data);
						?>
					</div>
				</div>
				<div class="col-lg-2 col-sm-2">
					<div class="form-group">
						<label>Obtained Marks in %</label>
						<?php echo $appl_ug_pct; ?>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Subjects ( <?php echo getUGCategoryName($appl_ug_ctgry); ?> )</label>
						<?php
							$appl_ug_subj_data = 'id="appl_ug_subj" tabindex="26" class="col-xs-11"';				
							echo form_dropdown('appl_ug_subj', $subject_options, null, $appl_ug_subj_data);
						?>
					</div>
				</div>
			</div>
		</div>	
		<!-- end 8th row -->
		
		<?php
		if(isset($pg_present) && $pg_present == 'M'){
		?>
		<!-- start 9th row -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-5 col-sm-5">
					<div class="form-group">
						<label>Post Graduation University</label>
						<?php
							$appl_board_data = 'id="appl_pg_board" tabindex="27" class="col-xs-10"';				
							echo form_dropdown('appl_pg_board', $university_options, null, $appl_board_data);
						?>
					</div>
				</div>
				<div class="col-lg-2 col-sm-2">
					<div class="form-group">
						<label>Passing Year</label>
						<?php
							$appl_pyear_data = array(
													'name'	=> 'appl_pg_pyear', 	
													'id'	=> 'appl_pg_pyear',
													'value' =>  '',	
													'maxlength'=>'4',	
													'tabindex'=>"28",						
													'class'	=>	'col-xs-6 col-sm-6'
					            				);
							echo form_input($appl_pyear_data);
						?>
					</div>
				</div>
				<div class="col-lg-2 col-sm-2">
					<div class="form-group">
						<label>Obtained Marks in %</label>
						<?php echo $appl_pg_pct; ?>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Subjects</label>
						<?php
							$appl_subj_data = 'id="appl_pg_subj" tabindex="29" class="col-xs-11"';				
							echo form_dropdown('appl_pg_subj', $subject_options, null, $appl_subj_data);
						?>
					</div>
				</div>
			</div>
		</div>	
		<!-- end 9th row -->
		<?php
		}?>
		
		<!-- start 10th row -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Password</label>
						<?php
							$appl_passwd_data = array(
													'name'	=> 'appl_passwd', 	
													'id'	=> 'appl_passwd',
													'value' =>  '',	
													'maxlength'=>'15',	
													'tabindex'=>"30",						
													'class'	=>	'col-xs-10 col-sm-10'
					            				);
							echo form_password($appl_passwd_data);
						?>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Confirm Password</label>
						<?php
							$appl_passwd2_data = array(
													'name'	=> 'appl_passwd2', 	
													'id'	=> 'appl_passwd2',
													'value' =>  '',	
													'maxlength'=>'15',	
													'tabindex'=>"31",						
													'class'	=>	'col-xs-10 col-sm-10'
					            				);
							echo form_password($appl_passwd2_data);
						?>
					</div>
				</div>
			</div>
		</div>	
		<!-- end 10th row -->
		
		
		<!-- start 8th row -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 col-sm-12" style="padding-left: 0;">
					<h4>Declaration</h4>
					<div>
						<input type="checkbox" id="declaration" checked="true"/>
						I do hereby declare that I will not be engaged in any other course of studies/job/fulltime research work, if admitted.<br/>
					</div>
					<div>
						<input type="checkbox" id="declaration2" checked="true"/>
						I declare that the particulars above are true to the best of my knowledge and belief. I give undertaking that my admission
						will stand cancelled if it is discovered that I do not have the minimum qualification or the information supplied by me is false. 
						I agree to abide by the rules and regulations of the course. I further declare that I shall submit to the disciplinary jurisdiction
						of the authorities of the University, who may be vested with the authority to exercise discipline under the Act, Statuses, Ordinances,
						Regulations and Rules of the University.
					</div>
					
				</div>
			</div>
		</div>	<!-- end 8th row -->
			
		<!-- start 9th row -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 col-sm-12 top-mrg-md" style="padding-left: 0;">
					<button type="button" class="btn btn-success save-btn">Submit Application</button>&nbsp;
					<button type="button" class="btn btn-default cancel-btn">Cancel</button>
					<input type="hidden" name="form_action" id="form_action" value="add">
					<br/>
					<small>This application must be submitted electronically, using the Submit Application button above. Printed copies of this online application form will not be accepted. </small>
				</div>
			</div>
		</div>	<!-- end 9th row -->			
		
		<?php	
			echo form_close();
		?>
		
	</div>
</div>

<?php
	$this->load->view('footer');
?>		

<script type="text/javascript">

	$('.input-number').keypress(function (key){
		if(key.charCode==0) return true;
		if(key.charCode<48 || key.charCode>57 )return false;
	});
	$('.input-number').keydown(function (key){
		if(key.charCode==0) return true;
		if(key.charCode<48 || key.charCode>57 )return false;
	});

	//make all the input text box value as upper case
	$(document).on('keyup','input',function() {
		this.value = this.value.toLocaleUpperCase();
	});
	$(document).on('keydown','input',function() {
		this.value = this.value.toLocaleUpperCase();
	});
	$('input').bind('keypress',function(event) {
		if(event.charCode == 39 || event.charCode == 34 || event.charCode == 96 || event.charCode == 126 || event.charCode==42 || event.charCode==37){
			jAlert('This special character not allowd.');
			return false;
		}
	});


	//onclick on submit button form information will be stored into database.
	$(document).on('click','.save-btn',function() {
		if(validate_form()){
			jConfirm(confirm_message_template(), $('#appl_name').html()+' PLEASE CONFIRM', function(e) {
				if (e) {
					$('.save-btn').attr('disabled', true);
					$('#addeditform').submit();	
				}
			})
		}
	});	

	//this template message shown into the confirm message at the time of form submission.
	function confirm_message_template(){
		var message = 'Are you sure want to submit the form.\n';
			message += ' Once application submited can\'t be revoked.\n';
			message += 'All the communication will be done on your mobile number.\n';
		 return message;
	}

	//below functions are used for validations : Start
	function validate_form(){
		$('.error-msg').remove();
		$('input').removeClass('form-error');
		$('select').removeClass('form-error');
		$('input:checkbox').removeClass('form-error');
		
		if(check_declaration()){
			var message = '';
			message += basic_info_validation();
			message += address_validation();
			message += marks_validation();
			message += password_validation();
			
			if(message == ''){
				return true;
			}else{
				//$('#addeditform').before("<div class='error-msg'></div>");
				$('.error-msg').html(message);
				jAlert('<b><u>Your form contains some error. Please check.</u></b><div class="error-msg">'+message+"</div>");
				return false;
			}
		}
	}
	
	
	function check_declaration(){
		var flag = true;
		if(!$("#declaration").is(':checked')){
			flag = false;
			$('#declaration').addClass('form-error');
			jAlert('Before proceeding you need to accept the declaration. <br/> Plese tick into first check box in declaration section');
		}
		if(!$("#declaration2").is(':checked')){
			flag = false;
			$('#declaration2').addClass('form-error');
			jAlert('Before proceeding you need to accept the declaration. <br/> Plese tick into second check box in declaration section');
		}
		return flag;
	}
	
	function basic_info_validation(){
		var msg = '';
		if($("#appl_relegion").val() == '' || $("#appl_relegion").val() ==  'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Religion can't be blank.</span>"; 
			$('#appl_relegion').addClass('form-error');
		}
		if($("#appl_nationality").val() == '' || $("#appl_nationality").val() ==  'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Nationality can't be blank.</span>"; 
			$('#appl_nationality').addClass('form-error');
		}
		if($("#appl_gurd_name").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Gurdian name can't be blank.</span>"; 
			$('#appl_gurd_name').addClass('form-error');
		}
		if($("#appl_gurd_rel").val() == '' || $("#appl_gurd_rel").val() ==  'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Gurdian relation can't be blank.</span>"; 
			$('#appl_gurd_rel').addClass('form-error');
		}
		if($("#appl_gender").val() == '' || $("#appl_gender").val() ==  'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Gender can't be blank.</span>"; 
			$('#appl_gender').addClass('form-error');
		}
		if($("#appl_dob").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>date of birth can't be blank.</span>"; 
			$('#appl_dob').addClass('form-error');
		}
		return msg;
	}
	
	function address_validation(){
		var msg = '';
		if($("#appl_comm_addr1").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Address line 1 can't be blank.</span>"; 
			$('#appl_comm_addr1').addClass('form-error');
		}
		if($("#appl_comm_city").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Address city/town/village can't be blank.</span>"; 
			$('#appl_comm_city').addClass('form-error');
		}
		if($("#appl_comm_dist").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Address district can't be blank.</span>"; 
			$('#appl_comm_dist').addClass('form-error');
		}
		if($("#appl_comm_state").val() == '' || $("#appl_comm_state").val() ==  'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Address state can't be blank.</span>"; 
			$('#appl_comm_state').addClass('form-error');
		}
		if($("#appl_comm_pin").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Address pin number can't be blank.</span>"; 
			$('#appl_comm_pin').addClass('form-error');
		}
		if($("#appl_phone").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Mobile number is mandatory.</span>"; 
			$('#appl_phone').addClass('form-error');
		}else if($("#appl_phone").val().length <10){
			msg += "<span><i class='fa fa-arrow-right'></i>Mobile number should be 10 digit.</span>"; 
			$('#appl_phone').addClass('form-error');
		}		
		if($("#appl_email").val() != ''){
		    var email = $("#appl_email").val();
		    var reg = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[_a-zA-Z0-9-]+()*(\.[_a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,4})$/
			if(reg.test(email)){
			}else{
				msg += "<span><i class='fa fa-arrow-right'></i>Email id is not in correct format.</span>"; 
				$('#appl_email').addClass('form-error');
			}
		}
		return msg;
	}

	function marks_validation(){
		var msg = '';
		if($("#appl_mp_pyear").val() == '' ){
			msg += "<span><i class='fa fa-arrow-right'></i>10th standard passing year can't be blank.</span>"; 
			$('#appl_mp_pyear').addClass('form-error');
		}
		if($("#appl_mp_board").val() == '' || $("#appl_mp_board").val() ==  'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Please select board for 10th standard examination.</span>"; 
			$('#appl_mp_board').addClass('form-error');
		}		
		if($("#appl_mp_subj").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Subject of 10th standard can't be blank.</span>"; 
			$('#appl_mp_subj').addClass('form-error');
		}
		if($("#appl_hs_pyear").val() == '' ){
			msg += "<span><i class='fa fa-arrow-right'></i>12th standard passing year can't be blank.</span>"; 
			$('#appl_hs_pyear').addClass('form-error');
		}
		if($("#appl_hs_board").val() == '' || $("#appl_hs_board").val() ==  'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Please select council for 12th standard examination.</span>"; 
			$('#appl_hs_board').addClass('form-error');
		}		
		if($("#appl_hs_subj").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Subject of 12th standard can't be blank.</span>"; 
			$('#appl_hs_subj').addClass('form-error');
		}
		if($("#appl_ug_pyear").val() == '' ){
			msg += "<span><i class='fa fa-arrow-right'></i>Graduation passing year can't be blank.</span>"; 
			$('#appl_ug_pyear').addClass('form-error');
		}
		if($("#appl_ug_board").val() == '' || $("#appl_hs_board").val() ==  'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Please select university for graduation examination.</span>"; 
			$('#appl_ug_board').addClass('form-error');
		}		
		if($("#appl_ug_subj").val() == '' || $("#appl_ug_subj").val() == 'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Subject of graduation can't be blank.</span>"; 
			$('#appl_ug_subj').addClass('form-error');
		}
		if($("#appl_pyear").val() == '' ){
			msg += "<span><i class='fa fa-arrow-right'></i>Post graduation passing year can't be blank.</span>"; 
			$('#appl_pyear').addClass('form-error');
		}
		if($("#appl_board").val() == '' || $("#appl_hs_board").val() ==  'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Please select university for graduation examination.</span>"; 
			$('#appl_board').addClass('form-error');
		}		
		if($("#appl_subj").val() == '' || $("#appl_subj").val() == 'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Subject of post graduation can't be blank.</span>"; 
			$('#appl_subj').addClass('form-error');
		}
		return msg;	
	}
	
	function password_validation(){
		var msg = '';
		var flag = true;
		if($("#appl_passwd").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Profile Password can't be left blank.</span>"; 
			$('#appl_passwd').addClass('form-error');
			flag = false;
		}
		if($("#appl_passwd2").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Confirm Password Can't be blank</span>"; 
			$('#appl_passwd').addClass('form-error');
			flag = false;
		}
		if(flag == true && $("#appl_passwd2").val() != $("#appl_passwd").val() ){
			msg += "<span><i class='fa fa-arrow-right'></i>Password should be mathced with confirm password.</span>"; 
			$('#appl_passwd2').addClass('form-error');
			$('#appl_passwd').addClass('form-error');
		}
		if(flag == true && $("#appl_passwd").val().length < 6 ){
			msg += "<span><i class='fa fa-arrow-right'></i>Password should be minimum of 6 alpha neumeric character.</span>"; 
			$('#appl_passwd').addClass('form-error');
		}
		return msg;
	}
	
	function onload_form(){
		fill_form_with_updated_value();
	}
	
	function fill_form_with_updated_value(){
		$("#appl_ctgr").val ("<?php echo $appl_ctgr; ?>");
		$("#appl_relegion").val ("<?php echo $appl_relegion; ?>");
		$("#appl_nationality").val ("<?php echo $appl_nationality; ?>");
		$("#appl_gurd_name").val("<?php echo $appl_gurd_name; ?>");		
		$("#appl_gurd_rel").val ("<?php echo $appl_gurd_rel; ?>");
		$("#appl_gender").val ("<?php echo $appl_gender; ?>");
		$("#appl_dob").val("<?php echo $appl_dob; ?>");		
		$("#appl_comm_addr1").val ("<?php echo $appl_comm_addr1; ?>");
		$("#appl_comm_addr2").val ("<?php echo $appl_comm_addr2; ?>");
		$("#appl_comm_city").val("<?php echo $appl_comm_city; ?>");
		$("#appl_comm_dist").val("<?php echo $appl_comm_dist; ?>");
		$("#appl_comm_state").val("<?php echo $appl_comm_state; ?>");
		$("#appl_comm_pin").val("<?php echo $appl_comm_pin; ?>");
		$("#appl_phone").val("<?php echo $appl_phone; ?>");
		$("#appl_email").val("<?php echo $appl_email; ?>");
		$("#appl_mp_subj").val("<?php echo $appl_mp_subj; ?>");
		$("#appl_hs_subj").val("<?php echo $appl_hs_subj; ?>");
		$("#appl_mp_pyear").val("<?php echo $appl_mp_pyear; ?>");
		$("#appl_hs_pyear").val("<?php echo $appl_hs_pyear; ?>");
		$("#appl_mp_board").val("<?php echo $appl_mp_board; ?>");
		$("#appl_hs_board").val("<?php echo $appl_hs_board; ?>");
		$("#appl_ug_pyear").val("<?php echo $appl_ug_pyear; ?>");
		$("#appl_ug_board").val("<?php echo $appl_ug_board; ?>");
		$("#appl_ug_subj").val("<?php echo $appl_ug_subj; ?>");
		$("#appl_pg_pyear").val("<?php echo $appl_pg_pyear; ?>");
		$("#appl_pg_board").val("<?php echo $appl_pg_board; ?>");
		$("#appl_pg_subj").val("<?php echo $appl_pg_subj; ?>");
		$("#appl_is_mphil").val("<?php echo $appl_is_mphil; ?>");
		$("#appl_is_phd").val("<?php echo $appl_is_phd; ?>");
	}
	
	onload_form();
</script>


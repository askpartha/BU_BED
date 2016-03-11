<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-title">
				<div class="col-lg-8 col-sm-8">
					<h2>Welcome, <?php echo $this->session->userdata['student']['student_name'];?></h2>
				</div>
				<div class="col-lg-4 col-sm-4">
					<h3>Application Number: <?php echo $this->session->userdata('appl_code');?></h3>
				</div>
			</div>	<!-- /heading -->
		</div>
	</div>	<!-- /row -->
	
	<div class="row">
		<div class="col-lg-2 col-sm-2">
			<?php
				$this->load->view('students/sidebar');
			?>
		</div>
		<div class="col-lg-10 col-md-10" >
			<div class="row btm-mrg-sm">
				<div class="col-lg-2"></div>
				<div class="col-lg-5">
					<h4>Applied Method Type: <u><?php echo $this->session->userdata('appl_method');?></u></h4>
				</div>
				<div class="col-lg-5"><h4>Status: 
					<?php
						echo getApplicationStatus($this->session->userdata('appl_status'));
					?></h4>
				</div>	
			</div>
			
			<?php
				if($this->session->flashdata('success')) {
					echo "<div class='alert alert-success action-message'>" . $this->session->flashdata('success') . "</div>";
				} else if($this->session->flashdata('failure')) {
					echo "<div class='alert alert-danger action-message'>" . $this->session->flashdata('failure') . "</div>";
				}
			?>
			
			<div class="row btm-mrg-sm" style="border-style: solid; border-width: 1px; "><div class="col-lg-2"></div></div>
			<?php if($dateFlag == 'TRUE') {?>
			
			<?php
				$form = array(
								'class'	=>	'form-horizontal lft-pad-nm',
								'role'	=>	'form',
								'id' => 'addeditform'
							);	
				echo form_open('admissions/pgadmupdate', $form);
			?>
			<input type="hidden" id="appl_sl_no" name="appl_sl_no" value=" <?php echo $appl_sl_no?>" />
			<input type="hidden" id="appl_code" name="appl_code" value=" <?php echo $appl_code?>" />
			
			<div class="row btm-mrg-md" style="border-style: solid; border-width: 0px; ">
				<div class="row btm-mrg-md">
					<div class="col-lg-3">
						<div class="form-group">
							<label>Applicant's Full Name</label>
							<?php
								$appl_name_data = array(
														'name'	=> 'appl_name', 	
														'id'	=> 'appl_name',
														'value' =>  $appl_name,	
														'maxlength'=>'50',	
														'tabindex'=>"3",						
														'class'	=>	'col-xs-11 col-sm-11'
						            				);
								echo form_input($appl_name_data);
							?>
						</div>
					</div>
					<div class="col-lg-3 col-sm-3">
						<div class="form-group">
							<label>Religion</label>
							<?php
								$appl_relegion_data = 'id="appl_relegion" tabindex="1" class="col-xs-10"';				
								echo form_dropdown('appl_relegion', $relligion_options, $appl_relegion, $appl_relegion_data);
							?>
						</div>
					</div>
					<div class="col-lg-3 col-sm-3">
						<div class="form-group">
							<label>Nationality</label>
							<?php
								$appl_nationality_data = 'id="appl_nationality" tabindex="2" class="col-xs-10"';				
								echo form_dropdown('appl_nationality', $nationality_options, $appl_nationality, $appl_nationality_data);
							?>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="form-group">
							<label>Date of Birth</label>
							<?php
								$appl_dob_data = array(
														'name'	=> 'appl_dob', 	
														'id'	=> 'appl_dob',
														'value' =>  getDateFormat($appl_dob, 'd-m-Y'),	
														'maxlength'=>'10',	
														'tabindex'=>"6",						
														'class'	=>	'col-xs-9 col-sm-9 datepicker'
						            				);
								echo form_input($appl_dob_data);
							?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-3 col-sm-3">
						<div class="form-group">
							<label>Gurdian's Name</label>
							<?php
								$appl_gurd_name_data = array(
														'name'	=> 'appl_gurd_name', 	
														'id'	=> 'appl_gurd_name',
														'value' =>  $appl_gurd_name,	
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
								echo form_dropdown('appl_gurd_rel', $gurd_options, $appl_gurd_rel, $appl_gurd_rel_data);
							?>
							
						</div>
					</div>
					<div class="col-lg-3 col-sm-3">
						<div class="form-group">
							<label>Gender</label>
							<?php
								$appl_gender_data = 'id="appl_gender" tabindex="5" class="col-xs-10"';				
								echo form_dropdown('appl_gender', $gender_options, $appl_gender, $appl_gender_data);
							?>
						</div>
					</div>
				</div>
				
				<h4>Communication Address:</h4>
				<!-- start 3rd row -->
				<div class="row">
					<div class="col-lg-3 col-sm-3">
						<div class="form-group">
							<label>Address-I</label>
							<?php
								$appl_comm_addr1_data = array(
														'name'	=> 'appl_comm_addr1', 	
														'id'	=> 'appl_comm_addr1',
														'value' =>  $appl_comm_addr1,	
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
														'value' =>  $appl_comm_addr2,	
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
														'value' =>  $appl_comm_city,	
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
														'value' =>  $appl_comm_dist,	
														'maxlength'=>'30',	
														'tabindex'=>"10",						
														'class'	=>	'col-xs-11 col-sm-11'
						            				);
								echo form_input($appl_comm_dist_data);
							?>
							
						</div>
					</div>
				</div>
				<!-- end 3rd row -->
				
				<!-- start 4th row -->
				<div class="row">
					<div class="col-lg-3 col-sm-3">
						<div class="form-group">
							<label>State</label>
							<?php
								$appl_comm_state_data = 'id="appl_comm_state" tabindex="10" class="col-xs-10"';				
								echo form_dropdown('appl_comm_state', $state_options, $appl_comm_state, $appl_comm_state_data);
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
														'value' =>  $appl_comm_pin,	
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
														'value' =>  $appl_phone,	
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
														'value' =>  $appl_email,	
														'maxlength'=>'100',	
														'tabindex'=>"13",						
														'class'	=>	'col-xs-11 col-sm-11'
						            				);
								echo form_input($appl_email_data);
							?>
						</div>
					</div>
				</div>
				
				
				<div class="row">
					<div class="col-lg-12 col-sm-12 top-mrg-md" style="padding-left: 0;">
						<button type="button" class="btn btn-success save-btn">Update Application</button>&nbsp;
						<input type="hidden" name="form_action" id="form_action" value="add">
						<br/>
						<small>This application must be submitted electronically, using the Submit Application button above. Printed copies of this online application form will not be accepted. </small>
					</div>
				</div>
				<!-- end 4th row -->
				
				<?php	
					echo form_close();
				?>
			</div>
			
			
			
			<?php 
				}else{
					echo "<a><b>Application last date is already over. The last date of the application was " . getDateFormat($appl_last_date) . "</b></a>";
				}
			?>			
				
		</div>	
	</div>	<!-- /row -->		
	
</div>
<?php
	$this->load->view('web_footer');
?>

<script>
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
		
		var message = '';
		message += basic_info_validation();
		message += address_validation();
		
		if(message == ''){
			return true;
		}else{
			//$('#addeditform').before("<div class='error-msg'></div>");
			$('.error-msg').html(message);
			jAlert('<b><u>Your form contains some error. Please check.</u></b><div class="error-msg">'+message+"</div>");
			return false;
		}
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
</script>
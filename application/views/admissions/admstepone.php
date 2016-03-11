<div class="container-fluid">
	<div class="row" >
		<div class="col-sm-7 data-content" style="border-right-style: solid; height: 520px; 	overflow: scroll;">
			<h4 style="text-align: center">Instructions for <?php echo admissionName();?>(<?php echo getCurrentSession();?>) in the Department of Education, B.U.</h4>
			<hr/>
			<div class="row" style="">
				<div class="col-sm-12">
					<!--<h4><?php echo $application_notices[$i]['notice_title'] ;?></h4>-->
					<ol >
					<?php
					//print_r($application_notices);
					for($i=0; $i<count($application_notices); $i++){
					?>
					<li>
						<div style="margin-bottom: 10px;">
							<p>
								<?php echo $application_notices[$i]['notice_desc'] ;?>
							</p>
							<?php
							if($application_notices[$i]['notice_file'] != ''){
							?>
							<a href="<?php echo $this->config->base_url(); ?>upload/notices/<?php echo $application_notices[$i]['notice_file'] ;?>" target="_blank">
								Download for details.
							</a>
							<?php	
							}
							?>
							
						</div>
						
					</li>
					<?php	
					}
					?>
					</ol>
				</div>
			</div>
		</div>
		<div class="col-sm-5">
			<?php
				if($this->session->flashdata('success')) {
					echo "<div class='alert alert-success action-message'>" . $this->session->flashdata('success') . "</div>";
				} else if($this->session->flashdata('failure')) {
					echo "<div class='alert alert-danger action-message'>" . $this->session->flashdata('failure') . "</div>";
				}
			?>	
			<!-- Form Data Entered Here-->
			<?php
				$form = array(
								'class'	=>	'form-horizontal lft-pad-nm',
								'role'	=>	'form',
								'id' => 'addeditform'
							);	
				echo form_open('admissions/submitstepone', $form);
			?>
			
			<!-- 1st line-->
			<div class="row">
				<div class="col-lg-6 col-sm-6">
					<div class="form-group">
						<label>Student Category</label>
						<?php
							$appl_ctgr_data = 'id="appl_ctgr" tabindex="1" class="col-xs-11"';				
							echo form_dropdown('appl_ctgr', $student_category_options, null, $appl_ctgr_data);
						?>
					</div>
				</div>	
				<div class="col-lg-6 col-sm-6">
					<div class="form-group">
						<label>Last Examination Passed</label>
						<?php
							$appl_last_exam_data = 'id="appl_last_exam" tabindex="2" class="col-xs-11"';				
							echo form_dropdown('appl_last_exam', $category_options, null, $appl_last_exam_data);
						?>
					</div>
				</div>
			</div>
			<div class="row" style="text-align: right;">
				<div class="col-lg-12 col-sm-12">
					<small>(B.Tech, B.E. Student please select UG Type as Honours)</small>
				</div>
			</div>
			<!-- 2nd line-->
			<div class="row">
				<div class="col-lg-12 col-sm-12">
					<div class="form-group">
						<label>Applicant's Full Name</label>
						<?php
							$appl_name_data = array(
													'name'	=> 'appl_name', 	
													'id'	=> 'appl_name',
													'value' =>  '',	
													'maxlength'=>'50',	
													'tabindex'=>"3",						
													'class'	=>	'col-xs-11 col-sm-11'
					            				);
							echo form_input($appl_name_data);
						?>
					</div>
				</div>	
			</div>
			
			<!-- 3rd line-->
			<div class="row">
				<div class="col-lg-6 col-sm-6">
					<div class="form-group">
						<label>Reservation</label>
						<?php
							$appl_reservation_data = 'id="appl_reservation" tabindex="4" class="col-xs-11"';				
							echo form_dropdown('appl_reservation', $reservation_options, null, $appl_reservation_data);
						?>
					</div>
				</div>	
				<div class="col-lg-6 col-sm-6">
					<div class="form-group">
						<label>D.A.</label>
						<?php
							$appl_is_pwd_data = 'id="appl_is_pwd" tabindex="5" class="col-xs-11"';				
							echo form_dropdown('appl_is_pwd', $yesno_options, null, $appl_is_pwd_data);
						?>
					</div>
				</div>
			</div>
			
			<!-- Row 4-->			
			<div class="row">
				<div class="col-lg-4 col-sm-4">
					<div class="form-group">
						<label>Method Type</label>
						<?php
							$appl_method_type_data = 'id="appl_method_type" tabindex="6" class="col-xs-11"';				
							echo form_dropdown('appl_method_type', $method_options, null, $appl_method_type_data);
						?>
					</div>
				</div>
				
				<div class="col-lg-4 col-sm-4">
					<div class="form-group">
						<label>Method Paper-1</label>
						<select id="appl_method_paper1" name="appl_method_paper1" tabindex="7" class="col-xs-11"></select>
					</div>
				</div>
				
				<div class="col-lg-4 col-sm-4">
					<div class="form-group">
						<label>Method Paper-2</label>
						<select id="appl_method_paper2" name="appl_method_paper2" tabindex="8" class="col-xs-11"></select>
					</div>
				</div>				
			</div>
			
			<!-- Row 5-->			
			<div class="row">
				<div class="col-lg-2 col-sm-2">
					<div class="form-group">
						<label>10th %</label>
						<?php
							$appl_mp_pct_data = array(
													'name'	=> 'appl_mp_pct', 	
													'id'	=> 'appl_mp_pct',
													'value' =>  '',	
													'maxlength'=>'5',	
													'tabindex'=>"9",						
													'class'	=>	'col-xs-11 col-sm-11 input-number-decimal'
					            				);
							echo form_input($appl_mp_pct_data);
						?>
					</div>
				</div>
				<div class="col-lg-2 col-sm-2">
					<div class="form-group">
						<label>12th %</label>
						<?php
							$appl_hs_pct_data = array(
													'name'	=> 'appl_hs_pct', 	
													'id'	=> 'appl_hs_pct',
													'value' =>  '',	
													'maxlength'=>'5',	
													'tabindex'=>"10",						
													'class'	=>	'col-xs11 col-sm-11 input-number-decimal'
					            				);
							echo form_input($appl_hs_pct_data);
						?>
					</div>
				</div>
				<div class="col-lg-2 col-sm-2">
					<div class="form-group">
						<label>UG %</label>
						<?php
							$appl_ug_pct_data = array(
													'name'	=> 'appl_ug_pct', 	
													'id'	=> 'appl_ug_pct',
													'value' =>  '',	
													'maxlength'=>'5',	
													'tabindex'=>"11",						
													'class'	=>	'col-xs-11 col-sm-11 input-number-decimal'
					            				);
							echo form_input($appl_ug_pct_data);
						?>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>UG Type</label>
						<?php
							$appl_ug_type_data = 'id="appl_ug_ctgry" tabindex="12" class="col-xs-11"';				
							echo form_dropdown('appl_ug_ctgry', $ug_ctgy_options, null, $appl_ug_type_data);
						?>
					</div>
				</div>
				<div class="col-lg-2 col-sm-2">
					<div class="form-group" id="pg_div">
						<label>PG %</label>
						<?php
							$appl_pg_pct_data = array(
													'name'	=> 'appl_pg_pct', 	
													'id'	=> 'appl_pg_pct',
													'value' =>  '',	
													'maxlength'=>'5',	
													'tabindex'=>"13",						
													'class'	=>	'col-xs-11 col-sm-11 input-number-decimal'
					            				);
							echo form_input($appl_pg_pct_data);
						?>
					</div>
				</div>				
			</div>
			
			<!--Row 6 -->
			<div class="row deputed">
				<div class="col-lg-6 col-sm-6">
					<div class="form-group">
						<label>Deputed Organization Name</label>
						<?php
							$appl_dep_org_name_data = array(
													'name'	=> 'appl_dep_org_name', 	
													'id'	=> 'appl_dep_org_name',
													'value' =>  '',	
													'maxlength'=>'50',	
													'tabindex'=>"14",						
													'class'	=>	'col-xs-11 col-sm-11'
					            				);
							echo form_input($appl_dep_org_name_data);
						?>
					</div>
				</div>
				<div class="col-lg-6 col-sm-6">
					<div class="form-group">
						<label>Deputed Organization Address</label>
						<?php
							$appl_dep_org_addr_data = array(
													'name'	=> 'appl_dep_org_addr', 	
													'id'	=> 'appl_dep_org_addr',
													'value' =>  '',	
													'maxlength'=>'200',	
													'tabindex'=>"15",						
													'class'	=>	'col-xs-11 col-sm-11'
					            				);
							echo form_input($appl_dep_org_addr_data);
						?>
					</div>
				</div>	
			</div>
			
			<!--Row 7 -->
			<div class="row deputed">
				<div class="col-lg-6 col-sm-6">
					<div class="form-group">
						<label>Appointment Date</label>
						<?php
							$appl_dep_apnt_date_data = array(
													'name'	=> 'appl_dep_apnt_date', 	
													'id'	=> 'appl_dep_apnt_date',
													'value' =>  '',	
													'maxlength'=>'10',	
													'tabindex'=>"16",						
													'class'	=>	'col-xs-6 col-sm-6 datepicker '
					            				);
							echo form_input($appl_dep_apnt_date_data);
						?>
					</div>
				</div>
				<div class="col-lg-6 col-sm-6">
					<div class="form-group">
						<label>Approve Appointment Date</label>
						<?php
							$appl_dep_apnt_date_data = array(
													'name'	=> 'appl_dep_apprv_date', 	
													'id'	=> 'appl_dep_apprv_date',
													'value' =>  '',	
													'maxlength'=>'10',	
													'tabindex'=>"17",						
													'class'	=>	'col-xs-6 col-sm-6 datepicker '
					            				);
							echo form_input($appl_dep_apnt_date_data);
						?>
					</div>
				</div>	
			</div>
			
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12 col-sm-12 top-mrg-md" style="padding-left: 0;">
						<button type="button" class="btn btn-default cancel-btn">Cancel</button>
						<button type="button" class="btn btn-success save-btn">Proceed..</button>&nbsp;
						<input type="hidden" name="form_action" id="form_action" value="add">
					</div>
				</div>
			</div>
			
			<?php	
				echo form_close();
			?>	
		</div>
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
	
	$('.input-number-decimal').keyup(function (){
		var $this = $(this);
    	$this.val($this.val().replace(/[^\d.]/g, ''));
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


	$("#appl_ctgr").on('change',function() {
		hide_show_deputed();
	});
	
	$("#appl_last_exam").on('change',function() {
		hide_show_pg();
	});
	
	$("#appl_method_type").on('change',function() {
		getMethodPaper1();
	});
	
	$("#appl_method_paper1").on('change',function() {
		getMethodPaper2();
	});
	
	$(document).on('click','.cancel-btn',function() {
		onload_form();
	});	
	
	//onclick on Proceed button form information will be stored into session and control will navigate to next page.
	$(document).on('click','.save-btn',function() {
		if(formValidationStepOne()){
			jConfirm(confirmMessageTemplate(), $('#appl_name').val()+' PLEASE CONFIRM', function(e) {
				if (e) {
					$('#addeditform').submit();	
				}
			})
		}
	});	
	
	function formValidationStepOne(){
		$('.error-msg').remove();
		$('input').removeClass('form-error');
		$('select').removeClass('form-error');
		
		var message = '';
		message += formValidationGeneral();
		message += formValidationMarks();
		message += formValidationDeputed();
		
		if(message == ''){
			return true;
		}else{
			$('#addeditform').before("<div class='error-msg'></div>");
			//$('.error-msg').html(message);
			jAlert('<b>Your form contains some error. Please check.</b><br/>'+message);
			return false;
		}
		return true;
	}
	
	function confirmMessageTemplate(){
		var message = 'Are you sure want to submit the form with the below information. ';
			message += '\n Once application submited can\'t be revoked. ';
			message += '\n Don\'t use back button or press F5. ';
		 return message;	
	}
	
	function formValidationGeneral(){
		var msg = '';
		if($("#appl_ctgr").val() == '' || $("#appl_ctgr").val() ==  'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Please select student category<br/></span>"; 
			$('#appl_ctgr').addClass('form-error');
		}
		if($("#appl_last_exam").val() == '' || $("#appl_last_exam").val() ==  'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Please select last exam of the student<br/></span>"; 
			$('#appl_last_exam').addClass('form-error');
		}
		if($("#appl_name").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Please entered student name<br/></span>"; 
			$('#appl_name').addClass('form-error');
		}
		if($("#appl_method_type").val() == '' || $("#appl_method_type").val() ==  'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Please select method type<br/></span>"; 
			$('#appl_method_type').addClass('form-error');
		}
		if($("#appl_method_paper1").val() == '' || $("#appl_method_paper1").val() ==  'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Please select method paper-I<br/></span>"; 
			$('#appl_method_paper1').addClass('form-error');
		}
		if($("#appl_method_paper2").val() == '' || $("#appl_method_paper2").val() ==  'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Please select method paper-II<br/></span>"; 
			$('#appl_method_paper2').addClass('form-error');
		}
		return msg;
	}
	
	function formValidationMarks(){
		var msg = '';
		if($("#appl_mp_pct").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Please entered 10th standard number in %.<br/></span>"; 
			$('#appl_mp_pct').addClass('form-error');
		}
		if($("#appl_hs_pct").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Please entered 12th standard number in %.<br/></span>"; 
			$('#appl_hs_pct').addClass('form-error');
		}
		if($("#appl_ug_pct").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Please entered graduation number in %.<br/></span>"; 
			$('#appl_ug_pct').addClass('form-error');
		}
		if($("#appl_ug_ctgry").val() == 'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Please select Graduation type. <br/></span>"; 
			$('#appl_ug_ctgry').addClass('form-error');
		}
		$temp_val = $("#appl_pg_pct").val();
		if(hide_show_pg()){
			$("#appl_pg_pct").val($temp_val);
			if($("#appl_pg_pct").val() == ''){
				msg += "<span><i class='fa fa-arrow-right'></i>Please entered post graduation number in %.<br/></span>"; 
				$('#appl_pg_pct').addClass('form-error');
			}
		}
		return msg;
	}
	
	function formValidationDeputed(){
		var msg = '';
		if(hide_show_deputed()){
			if($("#appl_dep_org_name").val() == ''){
				msg += "<span><i class='fa fa-arrow-right'></i>Please entered organization name<br/></span>"; 
				$('#appl_dep_org_name').addClass('form-error');
			}
			if($("#appl_dep_org_addr").val() == ''){
				msg += "<span><i class='fa fa-arrow-right'></i>Please entered organization address<br/></span>"; 
				$('#appl_dep_org_addr').addClass('form-error');
			}
			if($("#appl_dep_apnt_date").val() == ''){
				msg += "<span><i class='fa fa-arrow-right'></i>Please entered appointment date<br/></span>"; 
				$('#appl_dep_apnt_date').addClass('form-error');
			}
			if($("#appl_dep_apprv_date").val() == ''){
				msg += "<span><i class='fa fa-arrow-right'></i>Please entered appintment approve date<br/></span>"; 
				$('#appl_dep_apprv_date').addClass('form-error');
			}
		}
		return msg;
	}
	
	function onload_form(){
		fill_form_with_updated_value();
	}
	
	function fill_form_with_updated_value(){
		$("#appl_ctgr").val("<?php echo $appl_ctgr; ?>");
		
		hide_show_deputed();
		
		$("#appl_last_exam").val ("<?php echo $appl_last_exam; ?>");
		
		hide_show_pg();
		
		$("#appl_name").val ("<?php echo $appl_name; ?>");
		$("#appl_reservation").val ("<?php echo $appl_reservation; ?>");
		$("#appl_is_pwd").val ("<?php echo $appl_is_pwd; ?>");
		$("#appl_method_type").val("<?php echo $appl_method_type; ?>");
		
		getMethodPaper1();
		
		$("#appl_method_paper1").val("<?php echo $appl_method_paper1; ?>");
		
		getMethodPaper2();
		
		$("#appl_method_paper2").val("<?php echo $appl_method_paper2; ?>");
		
		$("#appl_mp_pct").val("<?php echo $appl_mp_pct; ?>");
		$("#appl_hs_pct").val("<?php echo $appl_hs_pct; ?>");
		$("#appl_ug_pct").val("<?php echo $appl_ug_pct; ?>");
		$("#appl_ug_ctgry").val("<?php echo $appl_ug_ctgry; ?>");
		$("#appl_pg_pct").val("<?php echo $appl_pg_pct; ?>");
		
		
		$("#appl_dep_org_name").val("<?php echo $appl_dep_org_name; ?>");
		$("#appl_dep_org_addr").val("<?php echo $appl_dep_org_addr; ?>");
		$("#appl_dep_apnt_date").val("<?php echo $appl_dep_apnt_date; ?>");
		$("#appl_dep_apprv_date").val("<?php echo $appl_dep_apprv_date; ?>");
		
	}
	
	function getMethodPaper1(){
		var params = "appl_method_type="+$("#appl_method_type").val();
		$.ajax({
			url: "<?php echo $this->config->base_url();?>admissions/getMethodOnePaperOptionByMethodType",
			type: "post",
			data: params,
			dataType: "json",
			success: function(response){
				//console.log(response);
				SetPaperOptionForMethod(response, 'appl_method_paper1');
			 }
		});
	}
	
	function getMethodPaper2(){
		var params = "appl_method_paper1="+$("#appl_method_paper1").val();
		$.ajax({
			url: "<?php echo $this->config->base_url();?>admissions/getMethodTwoPaperOptionByMethodOnePaper",
			type: "post",
			data: params,
			dataType: "json",
			success: function(response){
				//console.log(response);
				SetPaperOptionForMethod(response, 'appl_method_paper2');
			 }
		});
	}
	
	
	function SetPaperOptionForMethod(data, ids){
		var papers = data;
		$('#'+ids).html('');
		var option_item = "<option value='EMPTY'></option>";
		for(var i=0; i<data.length; i++){
			option_item += '<option value="'+data[i]['subj_code']+'">'+data[i]['subj_name']+'</option>';
		}
		$('#'+ids).html(option_item);
	}
	
	function hide_show_deputed(){
		var status = false;
		var ctgry = $("#appl_ctgr").val();
		if(ctgry == 'D'){
			$(".deputed").show();
			status = true;
		}else{
			$(".deputed").hide();
		}
		return status;
	}
	
	function hide_show_pg(){
		var status = false;
		var ctgry = $("#appl_last_exam").val();
		var arr = ctgry.split('-');
		if(arr[1] == 'M'){
			$("#pg_div").show();
			status = true;
		}else{
			$("#pg_div").hide();
		}
		$("#appl_pg_pct").val("");
		return status;
	}
	
	onload_form();
</script>


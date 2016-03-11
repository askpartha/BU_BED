<div class="page-title">
	<h2>Student Information</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Admissions</li>
		<li class="">Confirm Payment</li>
	</ul>
</div>	<!-- /heading -->

<div class="container-fluid">
	<div class="row">
	<?php
		$form = array(
						'class'	=>	'form-horizontal lft-pad-nm',
						'role'	=>	'form',
						'id' => 'searchform'
					);	
		echo form_open('students/searchappl', $form);
	?>
		<input type="hidden" id="user_action" name="user_action" value="prepayment" />
		
		<div class="col-sm-3">
			<div class="form-group">
				<label>Application Form Number</label>
				<?php
					$appl_num = array(
			              					'name'        	=> 'appl_code',
											'id'          	=> 'appl_code',
											'tabindex'      => '1',
											'class'			=>	'col-xs-11 col-sm-11'
			            				);

					echo form_input($appl_num);
				?>
			</div>
		</div>
		<div class="col-sm-3">	
			<div class="form-group">
				<label>Mobile Number</label>
				<?php
					$appl_phone = array(
			              					'name'        	=> 'appl_phone',
											'id'          	=> 'appl_phone',
											'tabindex'      => '2',
											'maxlength'		=> '10',
											'class'			=>	'col-xs-11 col-sm-11'
			            				);

					echo form_input($appl_phone);
				?>
			</div>
		</div>
		<div class="col-sm-3">	
			<div class="form-group">
				<label>&nbsp;</label>
				<button type="button" class="btn btn-success search-btn">Search</button>
			</div>
		</div>
		<div class="col-sm-3 passwd" style="display:none;">
			<h5>Application Code: <span class='new_passwd'></span></h5>
			<p class="alert alert-success">Payments successfully updated.</p>
		</div>	
		<?php	
			echo form_close();
		?>
	</div>
	
	
	<div class="row">
		<div class="col-sm-12">
			<h4>Please check once more before revoke the payment.</h4>
			<div class="box">
				<table class="wrl-table btm-mrgn-xs">
					<thead>
						<tr>
							<th style="width:5%;">Photo</th>
							<th style="width:18%;">Student Name</th>
							<th style="width:10%;">Application No.</th>
							<th style="width:14%;">Application Status.</th>
							<th style="width:8%;">Pmt Amt.</th>
							<th style="width:10%;">Pmt By.</th>
							<th style="width:15%;">Pmt Code.</th>
							<th style="width:13%;"></th>
						</tr>
					</thead>
					<tbody id="tbl-content">
					<?php
						if(count($info) == 1) {
							for($i=0; $i<count($info); $i++)
							{
					?>
						<tr>
							<td><img height="40px" width="42px" src="<?php echo $info[$i]['appl_profile_pic'];?>"/></td>
							<td><?php echo $info[$i]['appl_name'];?></td>
							<td><?php echo $info[$i]['appl_code'];?></td>
							<td id="<?php echo $info[$i]['appl_code'];?>"><?php echo getApplicationStatus($info[$i]['appl_status']);?></td>
							<td> INR - <?php echo applicationFeesAmount();?></td>
							<td>
								<select name="pmt_type" id="pmt_type" value="<?php echo $info[$i]['appl_pmt_type'];?>">
									<option value="DRAFT">Draft</option>
									<option value="CASH">Cash</option>
									<option value="CHALLAN">Challan</option>
								</select>
							</td>
							<td>
								<input type="text" id="pmt_code" name="pmt_code" class="number" maxlength="20" value="<?php echo $info[$i]['appl_pmt_code'];?>"/>
							</td>
							<td style="text-align: center;">
								<?php if($info[$i]['appl_status'] == 1){?>
								<button type="button" class="btn btn-info submit-btn" data-val="<?php echo $info[$i]['appl_code'];?>">
								Submit
								</button>
								<?php } ?>
								
								<?php if($info[$i]['appl_status'] == 2){?>
								<button type="button" class="btn btn-info submit-btn" data-val="<?php echo $info[$i]['appl_code'];?>">
								Modify
								</button>
								<?php } ?>
							</td>
						</tr>
					<?php
							}			
						} else if(count($info)  >1){
							echo "<tr><td colspan='7'>There are some error please contact with system administrator</td></tr>";
						}else{
							echo "<tr><td colspan='7'>No data available</td></tr>";
						}
					?>
					</tbody>
				</table>
			</div>	<!-- /box -->
		</div>
	</div>
	
<?php
	$this->load->view('footer');
?>
<script type="text/javascript">

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

$(document).on('click','.search-btn',function() {
	$flag = true;
	if($('#appl_code').val().trim()=='' && $('#appl_phone').val().trim()=='' ){
		$flag = false;
	}
	if($flag){
		$('#searchform').submit();	
	}else{
		jAlert('Please serach by atleast one search criteria.');
	}
});	


$(document).on('click','.submit-btn',function() {
	
	var appl_code = $(this).attr('data-val');
	var pmt_type  = $("#pmt_type").val();
	var pmt_code  = $("#pmt_code").val();
	
	jConfirm('Would you like to confirm the payment <br/> of <b>'+appl_code+'</b> on <b>'+pmt_code+'</b>', 'PLEASE CONFIRM', function(e) {
		if (e) {
			var params = "appl_code="+appl_code+"&pmt_type="+pmt_type+"&pmt_code="+pmt_code;
			
			$.ajax({
					url: "<?php echo $this->config->base_url();?>admissions/updateconfirmpayment/"+new Date().getTime(),
					type: "post",
					data: params,
					dataType: "html",
					success: function(response){
						console.log(response);
						if(response.trim() == 'TRUE'){
							//show message
							$('.passwd').show();
							$('.new_passwd').html(appl_code);
							$('.submit-btn').attr('disabled', true);
						}
					 }
				});	
		}
	})
});		
</script>	
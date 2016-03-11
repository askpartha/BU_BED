<div class="page-title">
	<h2>Payment Files</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Admissions</li>
		<li class="">Payment File</li>
	</ul>
</div>	<!-- /heading -->

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-8 data-content">
			<?php
				if($this->session->flashdata('success')) {
					echo "<div class='alert alert-success action-message'>" . $this->session->flashdata('success') . "</div>";
				} else if($this->session->flashdata('failure')) {
					echo "<div class='alert alert-danger action-message'>" . $this->session->flashdata('failure') . "</div>";
				}
			?>	
			<div class="box">
				<table class="wrl-table btm-mrgn-xs">
					<thead>
						<tr>
							<th style="width:10%;">Sl</th>
							<th style="width:15%;">Date</th>
							<th style="width:40%;">File</th>
							<th style="width:15%;">Processed Date</th>
							<th style="width:20%;">Action</th>
						</tr>
					</thead>
					<tbody id="tbl-content"></tbody>
				</table>
				<div class="paginator pull-right btm-mrgn-sm"></div>
			</div>	<!-- /box -->
		</div>
		
		<div class="col-sm-4">
			<div class="box">
				<div class="title">
					<h3 class="addedit-label">Create Payment File</h3>
				</div>
				<div class="content">	
					<?php
						$form = array(
										'class'	=>	'form-horizontal lft-pad-nm',
										'role'	=>	'form',
										'id' => 'addeditform',
										'enctype'=>'multipart//form-data'
									);	
						echo form_open_multipart('admissions/createpaymentfile', $form);
					?>
						<div class="form-group">
							<label>Payment File Generation Date<small>(DD-MM-YYYY)</small></label>
							<?php
								$upload_file_date = array(
					              					'name'        	=> 'upload_file_date',
													'id'          	=> 'upload_file_date',
													'value'       	=> '',
													'tabindex'		=> '',
													'class'			=>	'col-xs-5 col-sm-5 datepicker'
					            				);
								echo form_input($upload_file_date);
							?>
						</div>
						<div class="form-group">
							<label>Select Payment File To Upload</label>
							<input type="file" name="userfile" id="userfile" multiple="multiple"  />
						</div>
			
						<div class="form-group">
							<button class="btn btn-primary addedit-btn" type="button">Save</button>
							<button type="button" class="btn btn-default cancel-btn">Cancel</button>
						</div>	
						
						<input type="hidden" name="record_id" id="record_id">
						<input type="hidden" name="form_action" id="form_action" value="add">
					<?php	
						echo form_close();
					?>	
				</div>
			</div>	
		</div>
		
		
	</div>
</div>

<?php
	$this->load->view('footer');
?>		

<script type="text/javascript">
var payment_files = '<?php echo json_encode($payment_files);?>';
var payment_files_data = jQuery.parseJSON(payment_files);

$(document).ready(function() {
	printAllPaymentFile(payment_files_data);
});	

function printAllPaymentFile(arr) {
	var s = "";
	if(arr.length > 0) {
			for(var i=0; i<arr.length; i++) {
				var payment_files = '<a href="<?php echo $this->config->base_url(); ?>upload/payments/'+arr[i].upload_file_name+'" target="_blank">'+arr[i].upload_file_name+'</a>';
				s += "<tr>";
				s += "<td>" + (i+1) + "</td>";
				s += "<td>" + arr[i].upload_file_date + "</td>";
				s += "<td>" + payment_files + "</td>";
				if(arr[i].is_upload_file_processed == 1)
					s += "<td>" +  arr[i].processed_on + "</td>";
				else
					s += "<td></td>";
				
				s += "<td class='text-center'>"
				if(arr[i].is_upload_file_processed == 0){
					s += "<a href='javascript:void(0);' id='edit_" + i + "' class='btn btn-primary btn-xs edit-record'>Edit</a>&nbsp;&nbsp;";	 	
					s += "<a href='javascript:void(0);' id='del_" + i + "' class='btn btn-danger btn-xs delete-record'>Delete</a>";
				}
				s += "</td>";
				s += "</tr>"
			}
		}else {
	
		s += '<tr><td colspan="100%"><h3 class="top-mrgn-sm btm-mrgn-sm">No data available</h3></td></tr>';
	}
	$('#tbl-content').html(s);
}

//edit record
$(document).on('click','.edit-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	$('.addedit-label').html('Edit Uploaded Payment File');
	$('#upload_file_date').val(payment_files_data[index].upload_file_date);
	$('#record_id').val(payment_files_data[index].upload_file_id);
	$('#form_action').val('edit');
});

$(document).on('click','.delete-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	var upload_file_id = payment_files_data[index].upload_file_id;
	var params = "id="+upload_file_id;			
	var loadUrl = "<?php echo $this->config->base_url();?>admissions/deletepaymentfile/"+new Date().getTime();
	jConfirm('Are you sure want to delete?', 'Please Confirm', function(e) {
		if (e) {	
			$.ajax({
			    type: "POST",
			    url: loadUrl,
			    data: params,
			    success: function(res){
			    	if(res == 'DELETED') {
						$.ajax({
								url: "<?php echo $this->config->base_url();?>admissions/loadpaymentfiles",
								type: "post",
								dataType: "json",
								success: function(response){
													//show message
													console.log(response);
													printAllPaymentFile(response);
													payment_files_data = response;
													
													$('.action-message').remove();
													$('<div>').attr({
													    class: 'alert alert-success action-message'
													}).html('Record deleted succesfully').prependTo('.data-content');
					
												 }
							});
						
						
						
			    	}
			    }
			});    		
		}
	});	
	
});	

//cancel action
$(document).on('click','.cancel-btn',function() {
	$('.addedit-label').html('Upload Payment File');
	$('#form_action').val('add');
	$('#upload_file_date').val('');
	$('#record_id').val(0);
});

//validates form
$(document).on('click','.addedit-btn',function() {
	$('.error-msg').remove();
	$('input').removeClass('form-error');
	$('textarea').removeClass('form-error');
	
	var upload_file_date = $('#upload_file_date').val();
	
	var error = false;
	var msg = "<h4><strong>Ohh!</strong> Change a few things up and try submitting again.</h4>";
	
	if(upload_file_date == '') {
		error = true;
		$('#upload_file_date').addClass('form-error');
	}
	
	if(error) {
		$('#addeditform').before("<div class='error-msg'></div>");
		$('.error-msg').html(msg);
		return false;
	} else {
		$('#addeditform').submit();
	}
});	
</script>
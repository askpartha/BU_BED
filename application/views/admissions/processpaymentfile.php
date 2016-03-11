<div class="page-title">
	<h2>Process Payment Files</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Admissions</li>
		<li class="">Process Payment File</li>
	</ul>
</div>	<!-- /heading -->

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-7 data-content">
			<div class="box">
				<table class="wrl-table btm-mrgn-xs">
					<thead>
						<tr>
							<th style="width:10%;">Sl</th>
							<th style="width:15%;">Process Date</th>
							<th style="width:40%;">Process File</th>
							<th style="width:20%;">Action</th>
						</tr>
					</thead>
					<tbody id="tbl-content"></tbody>
				</table>
				<div class="paginator pull-right btm-mrgn-sm"></div>
			</div>	<!-- /box -->
		</div>
		
		<div class="col-sm-5">
			<?php
				if($this->session->flashdata('success')) {
					echo "<div class='alert alert-success action-message'>" . $this->session->flashdata('success') . "</div>";
				} else if($this->session->flashdata('failure')) {
					echo "<div class='alert alert-danger action-message'>" . $this->session->flashdata('failure') . "</div>";
				}
			?>	
			<div class="box">
				<div class="title">
					<h3 class="addedit-label">Unprocess Payment File</h3>
				</div>
				<div class="content">	
					<?php
						$form = array(
										'class'	=>	'form-horizontal lft-pad-nm',
										'role'	=>	'form',
										'id' => 'processform'
									);	
						echo form_open('admissions/verifypaymentfile', $form);
					?>
						<div class="form-group">
							<label>Unprocess Payment Files</label>
							<?php
								$unprocess_payment_file = 'id="upload_file_id" class="col-xs-10 col-sm-10"';				
	
								echo form_dropdown('upload_file_id', $unprocess_payment_files, null, $unprocess_payment_file)
							?>
						</div>
			
						<div class="form-group">
							<button class="btn btn-primary process-btn" type="button">Process</button>
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
				s += "<td>" +  arr[i].processed_on + "</td>";
				s += "<td>" + payment_files + "</td>";
				s += "<td class='text-center'>"
				s += "<a href='javascript:void(0);' id='edit_" + i + "' class='btn btn-info btn-xs generate-record'>Non Verified Record</a>&nbsp;&nbsp;";
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

$(document).on('click','.generate-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	var upload_file_id = payment_files_data[index].upload_file_id;
	var params = "id="+upload_file_id;			
	var loadUrl = "<?php echo $this->config->base_url();?>admissions/downloadnonverifiedrecord/"+upload_file_id+"/"+new Date().getTime();
	window.open(loadUrl);	
});	

//validates form
$(document).on('click','.process-btn',function() {	
	var upload_file_id = $('#upload_file_id').val();
	
	var error = false;
	var msg = "<h4><strong>Ohh!</strong> Change a few things up and try submitting again.</h4>";
	
	if(upload_file_id == 'EMPTY') {
		error = true;
		$('#upload_file_id').addClass('form-error');
	}
	
	if(error) {
		$('#processform').before("<div class='error-msg'></div>");
		$('.error-msg').html(msg);
		return false;
	} else {
		$('#processform').submit();
	}
});	
</script>
<div class="page-title">
	<h2>Methods</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Master Data</li>
		<li class="">Method Paper Association</li>
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
							<th style="width:5%;">Sl</th>
							<th style="width:25%;">Method Type</th>
							<th style="width:25%;">Method Paper 1</th>
							<th style="width:25%;">Method Paper 2</th>
							<th style="width:18%;">Action</th>
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
					<h3 class="addedit-label">Associate Method Subject</h3>
				</div>
				<div class="content">	
					<?php
						$form = array(
										'class'	=>	'form-horizontal lft-pad-nm',
										'role'	=>	'form',
										'id' => 'addeditform'
									);	
						echo form_open('configs/createmethodsubject', $form);
					?>
						
						<div class="form-group">
							<label>Method Type</label>
							<?php
								$methods = 'id="method_code" class="col-xs-10 col-sm-10"';				
	
								echo form_dropdown('method_code', $methods_option, null, $methods)
							?>
						</div>
						
						<div class="form-group">
							<label>Method Paper-1</label>
							<?php
								$method_subject1 = 'id="method_subject1" class="col-xs-10 col-sm-10 "';				
	
								echo form_dropdown('method_subject1', $subjects_option, null, $method_subject1)
							?>
						</div>
						
						<div class="form-group">
							<label>Method Paper-2</label>
							<?php
								$method_subject2 = 'id="method_subject2" class="col-xs-10 col-sm-10 "';				
	
								echo form_dropdown('method_subject2', $subjects_option, null, $method_subject2)
							?>
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
var methodsubject = '<?php echo json_encode($methodsubject);?>';
var methodsubject_data = jQuery.parseJSON(methodsubject);

$(document).ready(function() {
	printAllMethods(methodsubject_data);
});	

function printAllMethods(arr) {
	console.log(arr);
	var s = "";
	if(arr.length > 0) {
			for(var i=0; i<arr.length; i++) {
				s += "<tr>";
				s += "<td>" + (i+1) + "</td>";
				s += "<td>" + arr[i].method_name + "</td>";
				s += "<td>" + arr[i].subj_name_1 + "</td>";
				s += "<td>" + arr[i].subj_name_2 + "</td>";
				s += "<td class='text-center'>"
				s += "<a href='javascript:void(0);' id='edit_" + i + "' class='btn btn-primary btn-xs edit-record'>Edit</a>&nbsp;&nbsp;";
				s += "<a href='javascript:void(0);' id='del_" + i + "' class='btn btn-danger btn-xs delete-record'>Delete</a>";
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
	$('.addedit-label').html('Edit Method Subject Association');
	$('#method_code').val(methodsubject_data[index].method_code);
	$('#method_subject1').val(methodsubject_data[index].method_subject1);
	$('#method_subject2').val(methodsubject_data[index].method_subject2);
	
	$('#record_id').val(methodsubject_data[index].method_subject_id);
	$('#form_action').val('edit');
});

$(document).on('click','.delete-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	var method_subject_id = methodsubject_data[index].method_subject_id;
	var params = "id="+method_subject_id;			
	var loadUrl = "<?php echo $this->config->base_url();?>configs/deletemethodsubject/"+new Date().getTime();
	
	jConfirm('Are you sure want to delete?', 'Please Confirm', function(e) {
		if (e) {	
			$.ajax({
			    type: "POST",
			    url: loadUrl,
			    data: params,
			    success: function(res){
			    	if(res == 'DELETED') {
						$.ajax({
								url: "<?php echo $this->config->base_url();?>configs/loadmethodsubjects",
								type: "post",
								dataType: "json",
								success: function(response){
													//show message
													printAllMethods(response);
													methodsubject_data = response;
													
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
	$('.addedit-label').html('Create Method');
	$('#form_action').val('add');
	$('#method_code').val('EMPTY');
	$('#method_subject1').val('EMPTY');
	$('#method_subject2').val('EMPTY');
	$('#record_id').val(0);
});

//validates form
$(document).on('click','.addedit-btn',function() {
	$('.error-msg').remove();
	$('input').removeClass('form-error');
	
	var method_code = $('#method_code').val();
	var method_subject1 = $('#method_subject1').val();
	var method_subject2 = $('#method_subject2').val();
	
	var error = false;
	var msg = "<h4><strong>Ohh!</strong> Change a few things up and try submitting again.</h4>";
	
	if(method_code == 'EMPTY') {
		error = true;
		$('#method_code').addClass('form-error');
	}
	
	if(method_subject1 == 'EMPTY') {
		error = true;
		$('#method_subject1').addClass('form-error');
	}
	
	if(method_subject2 == 'EMPTY') {
		error = true;
		$('#method_subject2').addClass('form-error');
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
<div class="page-title">
	<h2>Search Student Application</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Admissions</li>
		<li class="">Application</li>
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
		<input type="hidden" id="user_action" name="user_action" value="application" />
		
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
				<label>Applicant's Name</label>
				<?php
					$appl_name = array(
			              					'name'        	=> 'appl_name',
											'id'          	=> 'appl_name',
											'tabindex'      => '3',
											'maxlength'		=> '20',
											'class'			=>	'col-xs-11 col-sm-11'
			            				);

					echo form_input($appl_name);
				?>
			</div>
		</div>
		<div class="col-sm-3">	
			<div class="form-group">
				<label>&nbsp;</label>
				<button type="button" class="btn btn-success search-btn">Search</button>
			</div>
		</div>
		<?php	
			echo form_close();
		?>
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<h4>To verify more please download the application from DOWNLOAD link.</h4>
			<div class="box">
				<table class="wrl-table btm-mrgn-xs">
					<thead>
						<tr>
							<th style="width:5%;">Photo</th>
							<th style="width:18%;">Student Name</th>
							<th style="width:12%;">Application No.</th>
							<th style="width:18%;">Gurdian's Name</th>
							<th style="width:10%;">Method</th>
							<th style="width:10%;">Mobile No.</th>
							<th style="width:14%;">Application Status.</th>
							<th style="width:13%;"></th>
						</tr>
					</thead>
					<tbody id="tbl-content">
					<?php
						if(count($info) > 0) {
							for($i=0; $i<count($info); $i++)
							{
					?>
						<tr>
							<td><img height="40px" width="42px" src="<?php echo $info[$i]['appl_profile_pic'];?>"/></td>
							<td><?php echo $info[$i]['appl_name'];?></td>
							<td><?php echo $info[$i]['appl_code'];?></td>
							<td><?php echo $info[$i]['appl_gurd_name'];?></td>
							<td><?php echo $info[$i]['method_name'];?></td>
							<td><?php echo $info[$i]['appl_phone'];?></td>
							<td><?php echo getApplicationStatus($info[$i]['appl_status']);?></td>
							<td style="text-align: center;"><button type="button" class="btn btn-info download-btn" data-val="<?php echo $info[$i]['appl_code'];?>">Download</button></td>
						</tr>
					<?php
							}			
						} else {
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
$(document).on('click','.search-btn',function() {
	$flag = true;
	if($('#appl_code').val().trim()=='' && $('#appl_phone').val().trim()=='' && $('#appl_name').val().trim()==''){
		$flag = false;
	}
	if($flag){
		$('#searchform').submit();	
	}else{
		jAlert('Please serach by atleast one search criteria.');
	}
});	


$(document).on('click','.download-btn',function() {
	var params = "appl_code="+$(this).attr('data-val');
	window.open("<?php echo $this->config->base_url();?>admissions/downloadapplform/"+$(this).attr('data-val'));
	
});	
</script>	
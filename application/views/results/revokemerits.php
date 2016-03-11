<div class="page-title">
	<h2>Revoke Merit List</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Operations </li>
		<li class="">Revoke Meritlist</li>
	</ul>
</div>	<!-- /heading -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-6">
				<p class="alert alert-success success"  style="display:none;">
					Meritlist of selected category  has successfully revoked. 
				</p>
				<p class="alert alert-danger failure"  style="display:none;">
					Meritlist of selected category  has not successfully revoked.
				</p>
		</div>
	</div>
		
	<div class="row">
	<?php
		$form = array(
						'class'	=>	'form-horizontal lft-pad-nm',
						'role'	=>	'form',
						'id' => 'searchform'
					);	
		echo form_open('results/generatemeritlist', $form);
	?>
		<div class="col-sm-3">
			<div class="form-group">
				<label>Candidate Category</label>
					<?php
						$ctgry_data = 'id="cand_ctgry" class="col-xs-10 col-sm-10 "';				
						echo form_dropdown('cand_ctgry', $cand_category_option, null, $ctgry_data);
					?>
			</div>
		</div>
		<!--
		<div class="col-sm-3">
					<div class="form-group">
						<label>Method Type</label>
						<select id="method_type" name="method_type" class="col-xs-10 col-sm-10 ">
							
						</select>
					</div>
				</div>-->
		
		<div class="col-sm-3">	
			<div class="form-group">
				<label>&nbsp;</label>
				<button type="button" class="btn btn-success generate-btn">Revoke Merit List</button>
			</div>
		</div>
		<?php	
			echo form_close();
		?>
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<div class="box">
			</div>	<!-- /box -->
		</div>
	</div>
	
<?php
	$this->load->view('footer');
?>
<script type="text/javascript">
$(document).on('change','#cand_ctgry',function() {
	var page = 1;
	//loadDropDown();
});	

function loadDropDown(){
	var params = "cand_ctgry="+$("#cand_ctgry").val()+"&type=false";
	$.ajax({
			url: "<?php echo $this->config->base_url();?>results/getmethodoption/"+new Date().getTime(),
			type: "post",
			data: params,
			dataType: "json",
			success: function(response){
				PrintMethodOptiondata(response);
			 }
		});	
}

function PrintMethodOptiondata(data){
	$('#method_type').html('');
	var option_item = "<option value='EMPTY'></option>";
	for(var i=0; i<data.length; i++){
		option_item += '<option value="'+data[i]['method_code']+'">'+data[i]['method_name']+'</option>';
	}
	$('#method_type').html(option_item);
}

$(document).on('click','.generate-btn',function() {
	//var method_type = $("#method_type").val();
	var cand_ctgry  = $("#cand_ctgry").val();
	if(cand_ctgry != "" && cand_ctgry != "EMPTY" ){
		var params = "cand_ctgry="+cand_ctgry;
		$.ajax({
			url: "<?php echo $this->config->base_url();?>results/revokemeritlist/"+new Date().getTime(),
			type: "post",
			data: params,
			dataType: "html",
			success: function(response){
				if(response == 1){
					$('.success').show();
					$('.failure').hide();
					$('.generate-btn').attr('disabled', true);
					//loadDropDown();
				}else{
					$('.success').hide();
					$('.failure').show();
				}
				
			 }
		});	
	}else{
		jAlert('Please select category');
	}
});	

$("#cand_ctgry").val('EMPTY');
</script>	
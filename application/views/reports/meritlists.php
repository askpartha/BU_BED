<style>
a.result-page {
    display: inline-block;
    padding: 0px 9px;
    margin: 6px;
    border-radius: 3px;
    border: solid 1px #c0c0c0;
    background: #e9e9e9;
    box-shadow: inset 0px 1px 0px rgba(255,255,255, .8), 0px 1px 3px rgba(0,0,0, .1);
    font-size: 1em;
    font-weight: bold;
    text-decoration: none;
    color: #717171;
    text-shadow: 0px 1px 0px rgba(255,255,255, 1);
}

a.result-page:hover, a.result-page.gradient:hover {
    background: #fefefe;
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#FEFEFE), to(#f0f0f0));
    background: -moz-linear-gradient(0% 0% 270deg,#FEFEFE, #f0f0f0);
}

a.result-page.active {
    border: none;
    background: #616161;
    box-shadow: inset 0px 0px 8px rgba(0,0,0, .5), 0px 1px 0px rgba(255,255,255, .8);
    color: #f0f0f0;
    text-shadow: 0px 0px 3px rgba(0,0,0, .5);
}
</style>

<div class="page-title">
	<h2>Download Merit List</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Reports </li>
		<li class="">Download Meritlist</li>
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
		echo form_open('reports/meritlists', $form);
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
				<button type="button" class="btn btn-success download-btn">Download Merit List</button>
			</div>
		</div>
		
		<div class="col-sm-3">	
			<div class="pull-right" style="margin-right:20px;">
				<h4><a href="<?php echo $this->config->base_url();?>upload/PDF_Merge_Tool_Setup_v1.0.0.exe">Download</a> PDF merge tool</h4>
			</div>
		</div>	
		<?php	
			echo form_close();
		?>
	</div>
	
	<?php
		$record_per_page = getApplicationStatus('records_per_page');
		/*
		
				$gen_total_pages = ceil($total_pages_gen_record / $record_per_page);
				$sc_total_pages = ceil($total_pages_sc_record / $record_per_page);
				$st_total_pages = ceil($total_pages_st_record / $record_per_page);
				$pwd_total_pages = ceil($total_pages_pwd_record / $record_per_page);*/
		
	?>
	
	<div id="result-content" style="display: block">
	
	<?php 
		for($i=0; $i<count($result); $i++){
	?>
	
	<div class="row" style="border-style: solid; border-width:1px; margin-bottom: 5px;">
		<div class="col-sm-12">
			<h5 ><a><?php echo $result[$i]['description'];?></a> (No of Seats : <?php echo $result[$i]['no_of_seats'];?>)</h5>
			
			<?php
				if($result[$i]['total_record'] > 0) {
			?>
			
			<h3 class="page-click top-mrg-md btm-mrg-md" style="display:none;">Selected page: <span class="selected_page"></span> of <?php echo $result[$i]['total_record'];?></h3>
			<div class="paginator">
				<?php
					for($j=1; $j<=$result[$i]['total_pages']; $j++) {
						echo anchor('reports/downloadmerits/' . $result[$i]['reservation']. "/". $result[$i]['sl_no'] ."/". $j, $j, array('class' => 'result-page', 'data-val' => $j));
						echo "&nbsp;";
					}
				?>
				<h6>Click on page number, it will download a PDF file having <?php echo $record_per_page;?> records. Save this file in any location of your desktop.</h6>
			</div>
			
			<?php
				} else {
					echo "<h5 class='alert alert-danger'>No records found</h5>";
				}
			?>
			
		</div>
	</div>
	
	<?php
		}
	?>
	
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

$(document).on('click','.download-btn',function() {
	//var method_type = $("#method_type").val();
	var cand_ctgry  = $("#cand_ctgry").val();
	if(cand_ctgry != "" && cand_ctgry != "EMPTY" ){
		$('#searchform').submit();	
		//$('#result-content').show();	
	}else{
		$('#result-content').hide();
		jAlert('Please select method type and category');
	}
});	

$("#cand_ctgry").val('EMPTY');

$(document).on('click','.result-page',function() {
	$(this).addClass("active");
});	
</script>	
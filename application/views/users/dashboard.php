<div class="page-title">
	<h2>Dashboard</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Dashboard</li>
	</ul>
</div>	<!-- /heading -->

<div class="container-fluid">
	
	<div class="row">		
		<div class="col-sm-8">
			<h4><span class='dashboard_label'>Total Form Submitted: </span><span class='total_form_data'></span></h4>
			<h4><span class='dashboard_label'>Total Payment Received: </span><span class='total_payment_received_data'></span></h4>
			<h4><span class='dashboard_label'>Total Application Confirmed: </span><span class='total_application_confirmed_data'></span></h4>
			<h4><span class='dashboard_label'>Total Application Rejected: </span><span class='total_applicant_rejected_data'></span></h4>
		</div>
		
		<div class="col-sm-4">
			
		</div>
	</div>
</div>

<?php
	$this->load->view('footer');
?>	
<script type="text/javascript">
var stats = jQuery.parseJSON('<?php echo json_encode($stats);?>');
$(document).ready(function() {
	printDashboardStat(stats);
});	

//print dashboard stat
function printDashboardStat(data) {
	$('.total_form_data').html(data.stats[0].total_application);
	$('.total_payment_received_data').html(data.stats[0].total_payment);
	$('.total_application_confirmed_data').html(data.stats[0].total_confirm);
	$('.total_applicant_rejected_data').html(data.stats[0].total_appl_rejected);
}	

$(document).on('click','.search-btn',function() {
	$('#searchform').submit();
});	
</script>	
<div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseZero">
        	<i class="fa fa-cubes"></i> Master Data
        </a>
      </h4>
    </div>
    <div id="collapseZero" class="panel-collapse collapse">
	    <div class="panel-body">
			<ul class="nav nav-list">
				<li><?php echo anchor('configs/schedules', 'Schedules', 'title="Schedules"');?></li>
			</ul>
		</div><!-- /panel-body -->
	</div><!-- /panel-collapse -->
</div><!-- /panel panel-default -->

<div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
        	<i class="fa fa-child"></i> User Management
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse">
	    <div class="panel-body">
			<ul class="nav nav-list">
				<li><?php echo anchor('users/musers', 'Users', 'title="Users"');?></li>
				<li><?php echo anchor('users/changepass', 'Change Password', 'title="Change Password"');?></li>
				<li><?php echo anchor('users/resetpasswd', 'Reset User Password', 'title="Reset User Password"');?></li>
				<li><?php echo anchor('students/resetpasswd', 'Reset Student Password', 'title="Reset Student Password"');?></li>
			</ul>
		</div><!-- /panel-body -->
	</div><!-- /panel-collapse -->
</div><!-- /panel panel-default -->

<div class="panel panel-default">
	<div class="panel-heading">
  		<h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
	        	<i class="fa fa-graduation-cap"></i> Admissions
	        </a>
  		</h4>
	</div>
	<div id="collapseTwo" class="panel-collapse collapse">
    	<div class="panel-body">
			<ul class="nav nav-list">
				<li><?php echo anchor('admissions/notices', 'Notices', 'title="Notices"');?></li>
				<li><?php echo anchor('students/application', 'Application', 'title="Application"');?></li>
				<li><?php echo anchor('admissions/paymentfile', 'Payment File Upload', 'title="Payment File Upload"');?></li>
				<li><?php echo anchor('admissions/processpaymentfile', 'Payment File Process', 'title="Payment File Process"');?></li>
				<li><?php echo anchor('admissions/confirmpayment', 'Payment Update', 'title="Payment Update"');?></li>
				<li><?php echo anchor('admissions/revokepayment', 'Payment Revoke', 'title="Payment Revoke"');?></li>
			</ul>
		</div><!-- /panel-body -->
	</div><!-- /panel-collapse -->
</div><!-- /panel panel-default -->


<div class="panel panel-default">
	<div class="panel-heading">
  		<h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
	        	<i class="fa fa-cog"></i> Operations
	        </a>
  		</h4>
	</div>
	<div id="collapseFour" class="panel-collapse collapse">
    	<div class="panel-body">
			<ul class="nav nav-list">
				<li><?php echo anchor('results/generatemerits', 'Generate Merit List', 'title="Generate Merit List"');?></li>
				<li><?php echo anchor('results/revokemerits', 'Revoke Merit List', 'title="Revoke Merit List"');?></li>
			</ul>
		</div><!-- /panel-body -->
	</div><!-- /panel-collapse -->
</div><!-- /panel panel-default -->


<div class="panel panel-default">
	<div class="panel-heading">
  		<h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
	        	<i class="fa fa-bar-chart-o"></i> Reports
	        </a>
  		</h4>
	</div>
	<div id="collapseThree" class="panel-collapse collapse">
    	<div class="panel-body">
			<ul class="nav nav-list">
				<li><?php echo anchor('configs/seats', 'Seat Matrix', 'title="Seat Matrix"');?></li>
				<li><?php echo anchor('reports/payments', 'Payment Confirmation', 'title="Payment Confirmation"');?></li>
				<li><?php echo anchor('reports/meritlists', 'Meritlists', 'title="Meritlists"');?></li>
				<li><?php echo anchor('reports/notifications', 'Notifications', 'title="Notifications"');?></li>
			</ul>
		</div><!-- /panel-body -->
	</div><!-- /panel-collapse -->
</div><!-- /panel panel-default -->															
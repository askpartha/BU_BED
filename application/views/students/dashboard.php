<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-title">
				<div class="col-lg-8 col-sm-8">
					<h2>Welcome, <?php echo $this->session->userdata['student']['student_name'];?></h2>
				</div>
				<div class="col-lg-4 col-sm-4">
					<h3>Application Number: <?php echo $this->session->userdata('appl_code');?></h3>
				</div>
			</div>	<!-- /heading -->
		</div>
	</div>	<!-- /row -->
	
	<div class="row">
		<div class="col-lg-3 col-sm-3">
			<?php
				$this->load->view('students/sidebar');
			?>
		</div>
		
		<div class="col-lg-9 col-sm-9">
			<h3>Dashboard</h3>
			<div class="row btm-mrg-md">
				<div class="col-lg-2"></div>
				<div class="col-lg-5">
					<h4>Applied Method Type: <u><?php echo $this->session->userdata('appl_method');?></u></h4>
				</div>
				<div class="col-lg-5"><h4>Status: 
					<?php
						echo getApplicationStatus($this->session->userdata('appl_status'));
					?></h4>
				</div>	
			</div>
			
			<?php echo $this->session->userdata('appl_ctgr'); ?>
			
			<div class="row btm-mrg-md">
				<div class="col-lg-5">
					<?php
						if($this->session->userdata('appl_status') == 1) {
					?>
						<h4>Your next steps:</h4>
						<ol>
							<li><a href="<?php echo $this->config->base_url();?>students/uploadphoto">Upload your photo</a> if not uploaded</li>
							<li>Prepared a draft of INR-<?php echo applicationFeesAmount();?> at <?php echo DraftFavourOf();?> </li>
							<li>Submit the printed application form along with the draft <?php echo paymentSubmissionAddress(); ?> on or before <?php echo $apl_last_date; ?></li>
						</ol>
					<?php	
						}elseif($this->session->userdata('appl_status') == 2) {
					?>
						<h4>Your next steps:</h4>
						<ol>
							<li>The provisional meritlist will be published on <?php echo $apl_result_date; ?> .</li>
							<li>Keep on watching Merit tab in the home page of the application.</li>
							<li>You can also view your rank in dashboard of your profile page.</li>
							<li><a href="<?php echo $this->config->base_url();?>students/uploadphoto">Upload your photo</a> if not uploaded</li>
						</ol>
					<?php		
						}elseif($this->session->userdata('appl_status') == 3) {
							if($this->session->userdata['student']['student_pic'] == '') {
								echo "<h3 class='red-text btm-mrg-lg'>You didn't upload your photo.<br/>
								Unless you upload the photo, you can't download the Rank Card.</h3>";
					?>
						<h4>Your next steps:</h4>
						<ol>
							<li><a href="<?php echo $this->config->base_url();?>students/uploadphoto">Upload your photo</a></li>
							<li>Download your Rank Card</li>
							<li>You will notify by the  University of Burdwan if you are in merit list</li>
						</ol>
					<?php
							} else {
					?>
						<h4>Your next steps:</h4>
						<ol>
							<?php if($this->session->userdata('appl_status') == 3 && $this->session->userdata['student']['result_pub_flag']) { ?>
							<li>Download your Rank Card  <a href="<?php echo $this->config->base_url();?>admissions/downloadrankcard/<?php echo $this->session->userdata('appl_num');?>">here</a></li>
							<?php } ?>
							<li>Prepared a draft of <?php if($this->session->userdata['student']['student_ctgr'] == 'D') { ?> INR-<?php echo admissionFeesAmountDeputed();?> for DEPUTED candidates  <?php } ?>  <?php if($this->session->userdata['student']['student_ctgr'] == 'F') { ?> INR-<?php echo admissionFeesAmountFreshers();?> for FRESHER candidates <?php } ?> <b>in favour of <?php echo DraftFavourOf();?> </b></li>
							<li>The selected candidates will have to bring Demand Draft, Rank card, Original Testimonials along with a set of self attested photo copy at the time of admission.
					<?php
							}		
						}		
					?>	
				</div>
				<div class="col-lg-7">
				<?php
						if($this->session->userdata('appl_status') == 3 && $this->session->userdata['student']['result_pub_flag']) {
				?>
						<h4>Your Merit Rank Details:</h4>
						<div class="row btm-mrg-sm">
							<div class="col-lg-4"><label>Method Type : </label></div>
							<div class="col-lg-4"><?php echo $this->session->userdata('appl_method') ?></div>
						</div>
						<div class="row btm-mrg-sm">
							<div class="col-lg-4"><label>Student Category : </label></div>
							
							<div class="col-lg-4"><?php echo getApplicationCategory($this->session->userdata['student']['rank']['CTGR']) ?></div>
						</div>
						<div class="row btm-mrg-sm" style="margin-left: -25px;">
						<ul>
				<?php 
						if($this->session->userdata['student']['rank']['GEN'] != '' && $this->session->userdata['student']['rank']['GEN'] > 0){
							echo '<div class="row btm-mrg-sm"><b><small> ' . $this->session->userdata['student']['rank']['GEN_TYPE'] . ' :</small> </b> <span class="label label-success">'. $this->session->userdata['student']['rank']['GEN'] . '</span></div>';	
						}
						if($this->session->userdata['student']['rank']['SC'] != '' && $this->session->userdata['student']['rank']['SC'] > 0){
							echo '<div class="row btm-mrg-sm"><b><small> ' . $this->session->userdata['student']['rank']['SC_TYPE'] . ' :</small> </b> <span class="label label-success">'. $this->session->userdata['student']['rank']['SC'] . '</span></div>';	
						}
						if($this->session->userdata['student']['rank']['ST'] != '' && $this->session->userdata['student']['rank']['ST'] > 0){
							echo '<div class="row btm-mrg-sm"><b><small> ' . $this->session->userdata['student']['rank']['STTYPE'] . ' :</small> </b> <span class="label label-success">'. $this->session->userdata['student']['rank']['ST'] . '</span></div>';	
						}
						if($this->session->userdata['student']['rank']['PWD'] != '' && $this->session->userdata['student']['rank']['PWD'] > 0){
							echo '<div class="row btm-mrg-sm"><b><small> ' . $this->session->userdata['student']['rank']['PWD_TYPE'] . ' :</small> </b> <span class="label label-success">'. $this->session->userdata['student']['rank']['PWD'] . '</span></div>';
						}
					}
				?>	
					</ul>	
					</div>
				</div>
			</div>
				
		</div>	
	</div>	<!-- /row -->		
	
</div>
<?php
	$this->load->view('web_footer');
?>
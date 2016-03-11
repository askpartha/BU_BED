<div class="page-title">
	
</div>	
<div class="container-fluid">
	<div class="row" style="height: 480px; 	overflow: scroll;">
		<div class="col-sm-12 data-content" style="height: 100%">
			<h3 style="text-align: center">General Instructions</h3>
			<h4 style="text-align: center">Online Application For <?php echo admissionName();?>(<?php echo getCurrentSession();?>) in the Department of Education, B.U.</h4>
			<hr/>
			<div class="row">
				<div class="col-sm-12">
					<!--<h4><?php echo $application_notices[$i]['notice_title'] ;?></h4>-->
					<ol >
					<?php
					for($i=0; $i<count($general_notices); $i++){
					?>
					<li>
						<div style="margin-bottom: 10px;">
							<h5><b>
								<?php echo $general_notices[$i]['notice_title'] ;?>
							</b></h5>
							<p>
								<?php echo $general_notices[$i]['notice_desc'] ;?>
							</p>
							<?php
							if($general_notices[$i]['notice_file'] != ''){
							?>
							<a href="<?php echo $this->config->base_url(); ?>upload/notices/<?php echo $general_notices[$i]['notice_file'] ;?>" target="_blank">
								Download for details.
							</a>
							<?php	
							}
							?>
							
						</div>
						
					</li>
					<?php	
					}
					?>
					</ol>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	$this->load->view('footer');
?>		


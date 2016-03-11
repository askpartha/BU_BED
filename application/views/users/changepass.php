<div class="page-title">
	<h2>Change Password</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Change Password</li>
	</ul>
</div>	<!-- /heading -->

<div class="container-fluid">
	<div class="row">
		<?php
			if($this->session->flashdata('success')) {
				echo "<div class='alert alert-success action-message'>" . $this->session->flashdata('success') . "</div>";
			} else if($this->session->flashdata('failure')) {
				echo "<div class='alert alert-danger action-message'>" . $this->session->flashdata('failure') . "</div>";
			}
		?>
		<?php
			$form = array(
							'class'	=>	'form-horizontal lft-pad-nm',
							'role'	=>	'form',
							'id' => 'passwdform'
						);	
			echo form_open('users/changepass', $form);
		?>
		<div class="col-sm-6">
			<div class="form-group">
				<label>New Password</label>
				<input type="password" class="col-sm-8 col-lg-8" name="user_password" id="user_password" value="">
				<button type="button" class="btn btn-success change-btn">Change</button>
			</div>
		</div>
		
		<?php	
			echo form_close();
		?>	
	</div>
</div>

<?php
	$this->load->view('footer');
?>	
<script type="text/javascript">
$(document).on('click','.change-btn',function() {
	$('#passwdform').submit();
});	
</script>	
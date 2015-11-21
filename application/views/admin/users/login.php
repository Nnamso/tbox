<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>

<body class="login example2">
	<div class="main-login col-sm-4 col-sm-offset-4">
		<div class="logo"><img src="<?php echo base_url('assets/images/logo-small.png'); ?>" alt="login"/>
		</div>
		<!-- start: LOGIN BOX -->
		<div class="box-login">
			<h3><?php echo $this->lang->line("user_login_sign_in"); ?></h3>
			<p>
				<?php echo $this->lang->line("user_login_descirpt"); ?>
			</p>							
				<form method="post" action="<?php echo site_url(). 'admin/users/login'; ?>">	
				
				<?php echo validation_errors('<p class="errorHandler alert alert-danger">'); ?>	
				
				<?php if ($this->session->flashdata('error') != '') { ?>
					<p class="errorHandler alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
				<?php } ?>
				<?php if ($this->session->flashdata('msg') != '') { ?>
					<p class="errorHandler alert alert-success"><?php echo $this->session->flashdata('msg'); ?></p>
				<?php } ?>
				<fieldset>
					<div class="form-group">
						<span class="input-icon">
							<?php echo form_input('email', $this->input->post('email'), 'class="form-control" placeholder="'.$this->lang->line('user_email').'"'); ?>
							<i class="icon-envelope"></i> 
						</span>
					</div>
					<div class="form-group form-actions">
						<span class="input-icon">
							<?php echo form_password('password', '', 'class="form-control" placeholder="'.$this->lang->line('user_password').'"'); ?>
							<i class="icon-lock"></i>
							<!-- <a class="forgot" href="javascript:void(0);">
								<?php echo $this->lang->line("user_forgot_password"); ?>
							</a> </span> -->
					</div>
					<div class="form-actions">						
						<button type="submit" class="btn btn-primary pull-right">
							<?php echo $this->lang->line("user_login"); ?> <i class="icon-circle-arrow-right"></i>
						</button>
					</div>					
				</fieldset>
			<?php echo form_close();?>
		</div>
		<!-- end: LOGIN BOX -->
		<!-- 
		<div class="box-forgot">
			<h3><?php echo lang('user_forget_password'); ?></h3>
			<p>
				<?php echo lang('user_forget_password_email'); ?>
			</p>
			<form method="post" action="<?php echo site_url(). 'admin/users/forget_password'; ?>">	
				<fieldset>
					<div class="form-group">
						<span class="input-icon">
							<input type="email" class="form-control" name="email" placeholder="Email">
							<i class="icon-envelope"></i> </span>
					</div>
					<div class="form-actions">
						<button type="button" class="btn btn-light-grey go-back">
							<i class="icon-circle-arrow-left"></i> <?php echo lang('back'); ?>
						</button>
						<button type="submit" class="btn btn-blue pull-right">
							<?php echo lang('submit'); ?> <i class="icon-circle-arrow-right"></i>
						</button>
					</div>
				</fieldset>
			</form>
		</div>
		 -->		
		<!-- start: COPYRIGHT -->
		<div class="copyright">
			&copy; tshirtecommerce.com
		</div>
		<!-- end: COPYRIGHT -->
	</div>	
	<script src="<?php echo base_url('assets/js/login.js'); ?>"></script>	
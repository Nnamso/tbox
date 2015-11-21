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
		<div class="logo"><img src="<?php echo site_url('assets/images/9file.png'); ?>" alt="login"/>
		</div>
		<!-- start: CHANGE_PASS BOX -->
		<div class="box-login">
			<h3><?php echo $this->lang->line("user_login_change_pass"); ?></h3>
			<p>
				<?php echo $this->lang->line("user_login_change_pass_desc"); ?>
			</p>							
				<form method="post" action="<?php echo site_url(). 'admin/users/changepass/'.$key; ?>">	
				
				<?php if ($error != '') { ?>
					<p class="errorHandler alert alert-danger"><?php echo $error; ?></p>
				<?php } ?>
				<fieldset>
					<div class="form-group">
						<span class="input-icon">
							<?php echo form_password('password', '', 'class="form-control" placeholder="'.$this->lang->line('user_new_password').'"'); ?>
							<i class="icon-envelope"></i> 
						</span>
					</div>
					<div class="form-group form-actions">
						<span class="input-icon">
							<?php echo form_password('cf_password', '', 'class="form-control" placeholder="'.$this->lang->line('user_confirm_password').'"'); ?>
							<i class="icon-lock"></i>
					</div>
					<div class="form-actions">
						<!--<label for="remember" class="checkbox-inline">
							<input type="checkbox" class="grey remember" id="remember" name="remember">
							<?php echo $this->lang->line("user_login_auto"); ?>
						</label> -->
						<input type="hidden" name="action" value="change_pass" >
						<a href="<?php echo site_url()?>admin/users/login" class="btn btn-light-grey go-back">
							<i class="icon-circle-arrow-left"></i> <?php echo lang('back'); ?>
						</a>
						<button type="submit" class="btn btn-primary pull-right">
							<?php echo $this->lang->line("submit"); ?> <i class="icon-circle-arrow-right"></i>
						</button>
					</div>					
				</fieldset>
			<?php echo form_close();?>
		</div>
		<!-- end: Change pass BOX -->		
		<!-- start: COPYRIGHT -->
		<div class="copyright">
			<?php echo lang("copyright"); ?>
		</div>
		<!-- end: COPYRIGHT -->
	</div>
	<script src="<?php echo base_url('assets/plugins/jquery-validation/dist/jquery.validate.min.js'); ?>"></script>
	<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

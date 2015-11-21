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
<script src="<?php echo site_url();?>assets/plugins/validate/validate.js"></script>	
<?php 
	if($this->session->flashdata('error') != '')
		echo '<div class="alert alert-danger">'.$this->session->flashdata('error').'</div>';
	elseif($this->session->flashdata('msg') != '')
		echo '<div class="alert alert-success">'.$this->session->flashdata('msg').'</div>';
?>
<div class="col-sm-12">
	<form id="fr-forgot" class="form-horizontal" method="POST" action="<?php echo site_url().'users/forgotpassword';?>">
		<h2><?php echo lang('user_forgot_password_title');?></h2>
		<span class="help-block"><?php echo lang('user_forgot_password_help');?></span>
		<div class="form-group">
			<label class="col-sm-2"><?php echo lang('email');?></label>
			<div class="col-sm-6">
				<input class="form-control validate required" type="text" data-msg="<?php echo lang('user_edit_msg_validate_email');?>" data-type="email" placeholder="<?php echo lang('email');?>" name="data[email]" value="<?php echo set_value('data[email]', '');?>"/>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2"></label>
			<div class="col-sm-6">
				<button class="btn btn-primary" type="submit"><?php echo lang('send');?></button>
				<a href="<?php echo site_url().'user/login';?>"><?php echo lang('user_register_or_login');?></a>
			</div>
		</div>
		<?php echo $this->auth->getToken(); ?>
	</form>
</div>

<script type="text/javascript">
	jQuery('#fr-forgot').validate();
</script>
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
<?php if($this->session->flashdata('error') != ''){  ?>
	<div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
<?php }  ?>
<?php if($this->session->flashdata('msg') != ''){  ?>
	<div class="alert alert-success"><?php echo $this->session->flashdata('msg'); ?></div>
<?php }  ?>
<form id="fr-change-pass" class="form-horizontal" method="POST" action="<?php echo site_url().'users/changepass';?>">
	<?php if(isset($this->user['id']) && $this->user['id'] != ''){?>
		<div class="form-group">
			<label class="col-md-2"><?php echo lang('old_password');?></label>
			<div class="col-md-6">
				<input class="form-control validate required" type="password" data-msg="<?php echo lang('user_change_password_validate_old_password');?>" data-maxlength="128" data-minlength="6" placeholder="<?php echo lang('old_password');?>" name="data[old_password]">
			</div>
		</div>
	<?php } ?>
	
	<div class="form-group">
		<label class="col-md-2"><?php echo lang('new_password');?></label>
		<div class="col-md-6">
			<input class="form-control validate required" type="password" data-msg="<?php echo lang('user_change_password_validate_new_password');?>" data-maxlength="128" data-minlength="6" placeholder="<?php echo lang('new_password');?>" name="data[password]">
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-md-2"><?php echo lang('cf_password');?></label>
		<div class="col-md-6">
			<input class="form-control validate required" type="password" data-msg="<?php echo lang('user_change_password_validate_confirm_password');?>" data-maxlength="128" data-minlength="6" placeholder="<?php echo lang('cf_password');?>" name="cf_password">
		</div>
	</div>
	<input type="hidden" value="<?php echo $key;?>" name="key">
	<?php echo $this->auth->getToken(); ?>
	<div class="form-group">
		<label class="col-md-2"></label>
		<div class="col-md-6">
			<a href="<?php echo site_url('user/login'); ?>" class="btn btn-danger" ><?php echo lang('cancel'); ?></a>
			<button class="btn btn-primary" type="submit"><?php echo lang('save');?></button>
		</div>
	</div>
</form>

<script type="text/javascript">
	jQuery('#fr-change-pass').validate();
</script>
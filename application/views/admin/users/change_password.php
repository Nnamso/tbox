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
<script src="<?php echo base_url('assets/plugins/validate/validate.js'); ?>"></script>
<form id="fr-change_pass" method="post" action="<?php echo site_url().'admin/users/changepass';?>">
<div class="row">
	<div class="col-sm-12">
		<p class="pull-right">
			<button type="submit" class="btn btn-primary" ><?php echo lang('save'); ?></button>
			<a href="<?php echo base_url().'admin/dashboard'?>" class="btn btn-danger" ><?php echo lang('cancel'); ?></a>
		</p>
	</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
		<i class="fa fa-external-link-square icon-external-link-sign"></i>
		<?php echo lang('user_change_password');?>
		
	</div>
	<div class="modal-body">
	
		<?php if(isset($msg)){?>
			<div class="alert alert-success"><?php echo $msg;?></div>
		<?php } ?>
		<?php if($error != ''){?>
			<div class="alert alert-danger"><?php echo $error;?></div>
		<?php } ?>
			
		<div class="row">
			
			<div class="form-group" style="display: table; width: 100%;">
				<label class="control-label col-md-2"><?php echo lang('user_old_password');?><span class="symbol required"></span></label>
				<div class="col-md-4">
					<input class="form-control validate required" type="password" data-msg="<?php echo lang('user_change_password_validate_old_password');?>" data-maxlength="100" data-minlength="6" name="old_password" placeholder="<?php echo lang('user_old_password');?>">
				</div>
			</div>
			
			<div class="form-group" style="display: table; width: 100%;">
				<label class="control-label col-md-2"><?php echo lang('user_password');?><span class="symbol required"></span></label>
				<div class="col-md-4">
					<input class="form-control validate required" type="password" data-msg="<?php echo lang('user_change_password_validate_new_password');?>" data-maxlength="100" data-minlength="6" name="password" placeholder="<?php echo lang('user_password');?>">
				</div>
			</div>
			
			<div class="form-group" style="display: table; width: 100%;">
				<label class="control-label col-md-2"><?php echo lang('user_confirm_password');?><span class="symbol required"></span></label>
				<div class="col-md-4">
					<input class="form-control validate required" type="password" data-msg="<?php echo lang('user_change_password_validate_confirm_password');?>" data-maxlength="100" data-minlength="6" name="cf_password" placeholder="<?php echo lang('user_confirm_password');?>">
				</div>
			</div>
		</div>
	</div>
</div>
</form>

<script type="text/javascript">
	jQuery('#fr-change_pass').validate();
</script>
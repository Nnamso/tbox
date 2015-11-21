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
<form id="fr-register" class="form-horizontal" method="POST" action="<?php echo site_url().'users/register';?>">
	<h2><?php echo lang('user_register_user_registrations');?></h2>
	<div class="form-group">
		<label class="col-md-2"><?php echo lang('username');?></label>
		<div class="col-md-6">
			<?php $data_fields = $this->session->flashdata('data_fields'); ?>
			<input class="form-control validate required" type="text" data-msg="<?php echo lang('user_edit_msg_validate_username');?>" data-maxlength="200" data-minlength="2" placeholder="<?php echo lang('username');?>" name="data[username]" value="<?php if(isset($data_fields['username'])) echo $data_fields['username'];?>"/>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-md-2"><?php echo lang('email');?></label>
		<div class="col-md-6">
			<input class="form-control validate required" type="text" data-msg="<?php echo lang('user_edit_msg_validate_email');?>" data-type="email" placeholder="<?php echo lang('email');?>" name="data[email]" value="<?php if(isset($data_fields['email'])) echo $data_fields['email'];?>"/>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-md-2"><?php echo lang('password');?></label>
		<div class="col-md-6">
			<input class="form-control validate required" type="password" data-msg="<?php echo lang('user_edit_msg_validate_password');?>" data-maxlength="128" data-minlength="6" placeholder="<?php echo lang('password');?>" name="data[password]">
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-md-2"><?php echo lang('cf_password');?></label>
		<div class="col-md-6">
			<input class="form-control validate required" type="password" data-msg="<?php echo lang('user_edit_msg_validate_confirm_password');?>" data-maxlength="128" data-minlength="6" placeholder="<?php echo lang('cf_password');?>" name="cf_password">
		</div>
	</div>
<?php 
	foreach($forms as $form)
	{ 
?>	
	<div class="form-group">
		<?php 
			if($form->title != '') echo '<label class="form-label col-md-2">'.$form->title.'</label>';
			$params = json_decode($form->params);
			if($form->type == 'text'){
				echo '<div class="col-md-6">';
				if($form->edit == 0)
				{
					if($form->validate == 1)
						echo '<input class="form-control validate required" type="text" name="'.$form->name.'" placeholder="'.$form->title.'" data-minlength="2" data-maxlength="200" data-msg="'.$form->title.' must be at least 2 to 200 characters." value="'.set_value($form->name, $form->value).'">';
					else
						echo '<input class="form-control" type="text" name="'.$form->name.'" value="'.set_value($form->name, $form->value).'">';
				}
				else
				{
					if(!isset($data_fields[$form->id]))
						$data_fields[$form->id] = '';
						
					if($form->validate == 1)
						echo '<input class="form-control validate required" type="text" name="fields['.$form->id.']" placeholder="'.$form->title.'" data-minlength="2" data-maxlength="200" data-msg="'.$form->title.' must be at least 2 to 200 characters." value="'.$data_fields[$form->id].'">';
					else
					{
						$temp = $data_fields('fields');
						echo '<input class="form-control" type="text" name="'.$form->name.'" value="'.$temp[$form->id].'">';
					}
				}
				echo '</div>';
			}elseif($form->type == 'email'){
				echo '<div class="col-md-6">';
				if($form->validate == 1)
					echo '<input class="form-control validate required" type="text" name="'.$form->name.'" placeholder="'.$form->title.'" data-type="email" data-msg="Email format is incorrect" value="'.set_value($form->name, $form->value).'">';
				else
					echo '<input class="form-control" type="text" name="'.$form->name.'" value="'.set_value($form->name, $form->value).'">';
				echo '</div>';
			}elseif($form->type == 'password'){
				echo '<div class="col-md-6">';
				if($form->validate == 1)
					echo '<input class="form-control validate required" type="password" name="'.$form->name.'" placeholder="'.$form->title.'" data-minlength="6" data-maxlength="128" data-msg="'.$form->title.' must be at least 6 to 128 characters." value="'.set_value($form->name, $form->value).'">';
				else
					echo '<input class="form-control" type="password" name="'.$form->name.'" value="'.set_value($form->name, $form->value).'">';
				echo '</div>';
			}elseif($form->type == 'radio'){
				echo '<div class="col-md-6">';
					$value = json_decode($form->value, true);
					if(is_array($value))
					{
						foreach($value as $key=>$val)
						{
							echo '<input id="'.str_replace(" ", "", $key).'" type="radio" name="'.$form->name.'" value="'.$val.'">';
							echo '<label for="'.str_replace(" ", "", $key).'" ></label>';
						}
					}
				echo '</div>';
			}
		?>
	</div>
<?php } ?>
<?php echo $this->auth->getToken(); ?>
	<div class="form-group">
		<label class="col-md-2"></label>
		<div class="col-md-6">
			<button class="btn btn-primary" type="submit"><?php echo lang('register');?></button>
			<a href="<?php echo site_url().'user/login';?>"><?php echo lang('user_register_or_login');?></a>
		</div>
	</div>
</form>

<script type="text/javascript">
	jQuery('#fr-register').validate();
</script>
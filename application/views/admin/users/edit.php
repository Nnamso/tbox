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
<form id="fr-edit" class="form-horizontal" method="post" action="<?php echo site_url().'admin/users/edit/'.$id;?>">
<div class="row">
	<div class="col-sm-12">
		<p class="pull-right">
			<button type="submit" class="btn btn-primary" ><?php echo lang('save'); ?></button>
			<a href="<?php echo site_url().'admin/users'?>" class="btn btn-danger" ><?php echo lang('cancel'); ?></a>
		</p>
	</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
		<i class="fa fa-external-link-square icon-external-link-sign"></i>
		<?php if($id != '') echo lang('user_shop_edit'); else echo lang('user_shop_add');?>
	</div>
	<div class="modal-body" style="display: table; width: 100%;">
		<?php if($error != ''){?>
			<div class="alert alert-danger"><?php echo $error;?></div>
		<?php } ?>
		<?php echo validation_errors('<p class="alert alert-danger">'); ?>
		
		<div class="col-sm-6">
			
			<div class="form-group">
				<label class="control-label col-md-4"><?php echo lang('user_name');?><span class="symbol required"></span></label>
				<div class="col-md-8">
					<input class="form-control validate required" type="text" data-msg="<?php echo lang('user_edit_msg_validate_name');?>" data-maxlength="255" data-minlength="2" placeholder="<?php echo lang('user_edit_name_place')?>" value="<?php echo $user->name;?>" name="data[name]">
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label col-md-4"><?php echo lang('user_user_name');?><span class="symbol required"></span></label>
				<div class="col-md-8">
					<?php if($id == ''){?>
						<input class="form-control validate required" type="text" data-msg="<?php echo lang('user_edit_msg_validate_username');?>" data-maxlength="150" data-minlength="2" placeholder="<?php echo lang('user_edit_username_place');?>" value="<?php echo $user->username;?>" name="data[username]">
					<?php }else{ echo $user->username;}?>
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label col-md-4"><?php echo lang('user_email');?><span class="symbol required"></span></label>
				<div class="col-md-8">
					<?php if($id == ''){?>
						<input autocomplete="off" class="form-control validate required" type="text" data-msg="<?php echo lang('user_edit_msg_validate_email');?>" data-type="email" placeholder="<?php echo lang('user_edit_email_place');?>" value="<?php echo  $user->email;?>" name="data[email]">
					<?php }else{ echo $user->email;}?>
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label col-md-4"><?php echo lang('user_add_group');?></label>
				<div class="col-md-8">
					<?php
						$gr = array();
						$default = '';
							
						foreach($groups as $group)
						{
							$gr[$group->id] = $group->title;
							if($group->default == 1)
								$default = $group->id;
						}
						if($user->group != '')
							$default = $user->group;
						echo form_dropdown('data[group]', $gr, $default, 'class="form-control"');
					?>
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label col-md-4"><?php if($id == ''){echo lang('user_password'); echo '<span class="symbol required"></span>';}else{ echo lang('user_new_password');}?></label>
				<div class="col-md-8">
					<input class="form-control <?php if($id == '') echo 'validate required'; ?>" type="password" data-msg="<?php echo lang('user_edit_msg_validate_password');?>" data-maxlength="128" data-minlength="6" name="data[password]">
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label col-md-4"><?php if($id == ''){ echo lang('user_confirm_password'); echo '<span class="symbol required"></span>'; }else{echo lang('user_confirm_password');}?></label>
				<div class="col-md-8">
					<input class="form-control <?php if($id == '') echo 'validate required'; ?>" type="password" data-msg="<?php echo lang('user_edit_msg_validate_confirm_password');?>" data-maxlength="128" data-minlength="6" name="cf_password">
				</div>
			</div>
		</div>
		
		<div class="col-sm-6">
			<?php 
				if(count($forms) > 0)
				{
				foreach($forms as $form)
				{ 
			?>	
				<div class="form-group">
					<?php 
						if($form->title != '') echo '<label class="control-label col-md-4">'.$form->title.'</label>';
						$params = json_decode($form->params);
						if($form->type == 'text'){
							echo '<div class="col-md-8">';
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
									echo '<input class="form-control" type="text" name="'.$form->name.'" value="'.$data_fields('fields')[$form->id].'">';
							}
							echo '</div>';
						}else if($form->type == 'email'){
							echo '<div class="col-md-8">';
							if($form->validate == 1)
								echo '<input class="form-control validate required" type="text" name="'.$form->name.'" placeholder="'.$form->title.'" data-type="email" data-msg="Email format is incorrect" value="'.set_value($form->name, $form->value).'">';
							else
								echo '<input class="form-control" type="text" name="'.$form->name.'" value="'.set_value($form->name, $form->value).'">';
							echo '</div>';
						}else if($form->type == 'password'){
							echo '<div class="col-md-8">';
							if($form->validate == 1)
								echo '<input class="form-control validate required" type="password" name="'.$form->name.'" placeholder="'.$form->title.'" data-minlength="6" data-maxlength="128" data-msg="'.$form->title.' must be at least 6 to 128 characters." value="'.set_value($form->name, $form->value).'">';
							else
								echo '<input class="form-control" type="password" name="'.$form->name.'" value="'.set_value($form->name, $form->value).'">';
							echo '</div>';
						}else if($form->type == 'radio'){
							echo '<div class="col-md-8">';
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
			}	}	?>
			</div>
		</div>
	</div>
</div>
</form>

<script type="text/javascript">
	jQuery('#fr-edit').validate();
</script>
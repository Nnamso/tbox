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
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/select2.css'); ?>">
<script src="<?php echo base_url('assets/plugins/select2/select2.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/validate/validate.js'); ?>"></script>
<form id="fr-edit" method="post" action="<?php echo site_url().'admin/users/editgroup/'.$id;?>">
<div class="row">
	<div class="col-sm-12">
		<p class="pull-right">
			<button type="submit" class="btn btn-primary" ><?php echo lang('save'); ?></button>
			<a href="<?php echo site_url().'admin/users/groups'?>" class="btn btn-danger" ><?php echo lang('cancel'); ?></a>
		</p>
	</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
		<i class="fa fa-external-link-square icon-external-link-sign"></i>
		<?php if($id != '') echo lang('user_edit_group'); else echo lang('user_add_group');?>
	</div>
	<div class="modal-body">
		<div class="row">
			<?php if(isset($error)){?>
				<div class="alert alert-danger"><?php echo $error;?></div>
			<?php } ?>
			<?php echo validation_errors('<p class="alert alert-danger">'); ?>
		</div>
		
		<div class="row">
			
			<div class="form-group" style="display: table; width: 100%;">
				<label class="control-label col-md-2"><?php echo lang('title');?><span class="symbol required"></span></label>
				<div class="col-md-10">
					<input class="form-control validate required" type="text" data-msg="<?php echo lang('user_edit_group_title_validate_msg');?>" data-maxlength="200" data-minlength="2" placeholder="<?php echo lang('user_edit_group_title_place')?>" value="<?php echo set_value('title', $group->title);?>" name="title">
				</div>
			</div>
			
			<div class="form-group" style="display: table; width: 100%;">
				<label class="control-label col-md-2"><?php echo lang('permission');?><span class="symbol required"></span></label>
				<div class="col-md-10">
					<div class="col-md-12" style="background: #f5f5f5; border: 1px solid #ccc; overflow: auto; max-height: 250px; padding: 15px; margin-bottom: 5px;">
						<?php 
							$permiss = json_decode($group->permissions);
							if(!is_array($permiss))
								$permiss = array();
								
							if(in_array('edit_user', $permiss))
								echo '<input id="checkbox_edit_user" class="check" type="checkbox" checked="checked" name="permission[]" value="edit_user"> <label for="checkbox_edit_user" style="margin-left: 5px;">'.lang('user_allow_edit_group').'</label><br/>';
							else
								echo '<input id="checkbox_edit_user" class="check" type="checkbox" name="permission[]" value="edit_user"> <label for="checkbox_edit_user" style="margin-left: 5px;">'.lang('user_allow_edit_group').'</label><br/>';
								
							foreach($control as $key=>$val)
							{	
								if(in_array($key, $permiss))
									echo '<input id="checkbox_'.$key.'" class="check" type="checkbox" checked="checked" name="permission[]" value="'.$key.'"> <label for="checkbox_'.$key.'" style="margin-left: 5px;">'.$val.'</label><br/>';
								else
									echo '<input id="checkbox_'.$key.'" class="check" type="checkbox" name="permission[]" value="'.$key.'"> <label for="checkbox_'.$key.'" style="margin-left: 5px;">'.$val.'</label><br/>';
							}
						?>
					</div>
					<p class="pull-right help-block"><?php echo lang('user_edit_group_note'); ?></p>
					<a href="javascript:void(0);" id="check_all">Check All</a> | <a href="javascript:void(0);" id="un_check_all">UnCheck All</a>
				</div>
			</div>
		</div>
	</div>
</div>
</form>

<script type="text/javascript">
	jQuery('#fr-edit').validate();
	jQuery('#check_all').click(function() {
        jQuery('.check').prop('checked', true);
    });
	jQuery('#un_check_all').click(function() {
        jQuery('.check').prop('checked', false);
    });
</script>
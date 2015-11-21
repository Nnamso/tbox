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
<form id="fr-edit" method="post" action="<?php echo site_url().'admin/settings/fields/edit/'.$id;?>">
<div class="row">
	<div class="col-sm-12">
		<p class="pull-right">
			<button type="submit" class="btn btn-primary" ><?php echo lang('save'); ?></button>
			<a href="<?php echo site_url().'admin/settings/fields'?>" class="btn btn-danger" ><?php echo lang('cancel'); ?></a>
		</p>
	</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
		<i class="fa fa-external-link-square icon-external-link-sign"></i>
		<?php if($id != '') echo lang('field_edit'); else echo lang('field_add');?>
	</div>
	<div class="modal-body">
		<div class="row">
			<?php if($error != ''){?>
				<div class="alert alert-danger"><?php echo $error;?></div>
			<?php } ?>
			<?php echo validation_errors('<p class="alert alert-danger">'); ?>
		</div>
		
		<div class="row">
			
			<div class="form-group" style="display: table; width: 100%;">
				<label class="control-label col-md-2"><?php echo lang('title');?><span class="symbol required"></span></label>
				<div class="col-md-4">
					<input class="form-control validate required" type="text" placeholder="<?php echo lang('title')?>" value="<?php echo set_value('data[title]', $field->title);?>" name="data[title]" data-minlength="2" data-maxlength="200" data-msg="<?php echo lang('field_admin_title_validate');?>">
					<small><span class="symbol required"></span><i> <?php echo lang('field_title_required');?></i></small>
				</div>
			</div>
			
			<div class="form-group" style="display: table; width: 100%;">
				<label class="control-label col-md-2"><?php echo lang('name');?><span class="symbol required"></span></label>
				<div class="col-md-4">
					<input class="form-control validate required" type="text" placeholder="<?php echo lang('name')?>" value="<?php echo set_value('data[name]', $field->name);?>" name="data[name]" data-minlength="2" data-maxlength="200" data-msg="<?php echo lang('field_admin_name_validate');?>">
					<small><span class="symbol required"></span><i> <?php echo lang('field_name_required');?></i></small>
				</div>
			</div>
			
			<div class="form-group" style="display: table; width: 100%;">
				<label class="control-label col-md-2"><?php echo lang('type');?></label>
				<div class="col-md-2">
					<?php 
						$field_type = array(
							'text'=>lang('text'),
							'email'=>lang('email'),
							'password'=>lang('password'),
							'radio'=>lang('radio'),
							'checkbox'=>lang('checkbox'),
							'select'=>lang('select'),
							'textarea'=>lang('textarea'),
							'country'=>lang('country'),
							'state'=>lang('state'),
						);
						echo form_dropdown('data[type]', $field_type, set_value('data[type]', $field->type), 'id="field_type" class="form-control"');
					?>
				</div>
			</div>
			
			<div class="form-group" style="display: table; width: 100%;">
				<label class="control-label col-md-2"><?php echo lang('required');?></label>
				<div class="col-md-2">
					<?php 
						$validate = array(
							'1'=>lang('yes'),
							'0'=>lang('no'),
						);
						echo form_dropdown('data[validate]', $validate, set_value('data[validate]', $field->validate), 'class="form-control"');
					?>
				</div>
			</div>
			
			<div class="form-group" style="display: table; width: 100%;">
				<label class="control-label col-md-2"><?php echo lang('publish');?></label>
				<div class="col-md-2">
					<?php 
						$publish = array(
							'1'=>lang('publish'),
							'0'=>lang('unpublish'),
						);
						echo form_dropdown('data[publish]', $publish, set_value('data[publish]', $field->publish), 'class="form-control"');
					?>
				</div>
			</div>
			
			<div class="form-group" style="display: table; width: 100%;">
				<label class="control-label col-md-2"><?php echo lang('forms');?> <span class="symbol required"></span></label>
				<div class="col-md-2">
					<?php 
						$form = array(
							'checkout'=>lang('checkout'),
							'contact'=>lang('contact'),
							'register'=>lang('register'),
						);
						$forms = json_decode($field->forms);
						echo form_dropdown('form[]', $form, set_value('form', $forms), 'id="mt_select" multiple=""');
					?>
					<small><i> <?php echo lang('field_admin_field_form_display');?></i></small>
				</div>
			</div>
			<?php
				$params = $field->params;
				if($params != '')
					$param = json_decode($field->params);
				else
					$param = array();
			?>
			
			<?php 
				$value = json_decode($field->value, true);
				if(is_array($value)){
					echo '<div id="add_field_custom">';
					echo '<div class="form-group" style="display: table; width: 100%;">';
					echo '<label class="control-label col-md-2"></label>';
					echo '<div class="col-md-4">';
					echo '<div style="text-align: center; float: left; width: 41%;"> Title </div>';
					echo '<div style="text-align: center; width: 82%;"> Value </div>';
					echo '</div>';
					echo '</div>';
					$i = 1;
					foreach($value as $key=>$val)
					{
						echo '<div class="form-group" style="display: table; width: 100%;">';
						echo '<label class="control-label col-md-2">'.lang('field_add_value').'</label>';
						echo '<div class="col-md-4">';
						echo '<input class="form-control" type="text" placeholder="Title" style="width: 46%; float: left; margin-right: 5px;" name="title[]" value="'.$key.'">';
						echo '<input class="form-control" type="text" placeholder="Value" style="float: left; width: 30%;" name="value[]" value="'.$val.'">';
						if($i == count($value))
						{
							echo '<button type="button" class="btn btn-primary" style="float: right;" onclick="addValue(this);"><i class="glyphicon glyphicon-plus"></i></button>';
						}else
						{
							echo '<button type="button" class="btn btn-danger" style="float: right;" onclick="removeField(this);"><i class="fa fa-times"></i></button>';
						}
						echo '</div>';
						echo '</div>';
						$i++;
					}
					echo '</div>';
					echo '<div id="value_field" class="form-group" style="display: table; width: 100%;">';
					echo '<label class="control-label col-md-2">'.lang('value').'</label>';
					echo '<div class="col-md-4">';
					echo '<input class="form-control" type="text" placeholder="'.lang('value').'" name="val">';
					echo '</div>';
					echo '</div>';
				}else{ ?>
				<div id="add_field_custom"></div>
				<div id="value_field" class="form-group" style="display: table; width: 100%;">
					<label class="control-label col-md-2"><?php echo lang('value');?></label>
					<div class="col-md-4">
						<input class="form-control" type="text" placeholder="<?php echo lang('value')?>" value="<?php if(isset($field->value))echo $field->value; ?>" name="val">
					</div>
				</div>
			<?php }?>
			
			<div class="form-group" style="display: table; width: 100%;">
				<label class="control-label col-md-2"><?php echo lang('order');?></label>
				<div class="col-md-4">
					<input class="form-control" type="text" placeholder="<?php echo lang('order')?>" value="<?php echo $field->order; ?>" name="order">
				</div>
			</div>
			<div class="form-group" style="display: table; width: 100%;">
				<label class="control-label col-md-2"><?php echo lang('class_sfx');?></label>
				<div class="col-md-4">
					<input class="form-control" type="text" placeholder="<?php echo lang('class_sfx')?>" value="<?php if(isset($param->style))echo $param->style; ?>" name="style">
				</div>
			</div>
			
		</div>
	</div>
</div>
</form>

<script type="text/javascript">
	jQuery('#mt_select').select2();
	jQuery('#fr-edit').validate();
	
	jQuery('#field_type').change(function(){
		var type = jQuery('#field_type').val();
		if(type == 'radio' || type == 'select')
		{
			jQuery('#value_field').hide();
			if(jQuery('#add_field_custom').html() == '')
			{
				var html = '';
				html += '<div class="form-group" style="display: table; width: 100%;">';
				html += '<label class="control-label col-md-2"></label>';
				html += '<div class="col-md-4">';
				html += '<div style="text-align: center; float: left; width: 41%;"> Title </div>';
				html += '<div style="text-align: center; width: 82%;"> Value </div>';
				html += '</div>';
				html += '</div>';
				jQuery('#add_field_custom').html(html);
				addField();
			}
		}else
		{
			jQuery('#value_field').show();
			jQuery('#add_field_custom').html('');
		}
	});
	
	function addValue(e)
	{
		jQuery(e).attr('onclick', 'removeField(this)');
		jQuery(e).attr('class', 'btn btn-danger');
		jQuery(e).html('<i class="fa fa-times"></i>');
		addField();
	};
	
	function removeField(e)
	{
		jQuery(e).parent('div').parent('div').remove();
	}
	
	function addField()
	{
		var html = '';
		html += jQuery('#add_field_custom').html();
		html += '<div class="form-group" style="display: table; width: 100%;">';
		html += '<label class="control-label col-md-2"><?php echo lang('user_admin_field_add_value');?></label>';
		html += '<div class="col-md-4">';
		html += '<input class="form-control" type="text" placeholder="Title" style="width: 46%; float: left; margin-right: 5px;" name="title[]">';
		html += '<input class="form-control" type="text" placeholder="Value" style="float: left; width: 30%;" name="value[]">';
		html += '<button type="button" class="btn btn-primary" style="float: right;" onclick="addValue(this);"><i class="glyphicon glyphicon-plus"></i></button>';
		html += '</div>';
		html += '</div>';
		jQuery('#add_field_custom').html(html);
	}
	
	<?php if(is_array($value)){ ?>
		jQuery('#value_field').hide();
	<?php } ?>
</script>
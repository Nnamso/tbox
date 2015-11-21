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
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title"><?php if($id != '') echo lang('colors_edit_title'); else  echo lang('colors_add_title'); ?></h4>
		</div>

		<!--add-->
		<?php echo validation_errors(); ?>
		<?php
		$attribute = array('class'=>'form-horizontal', 'name'=>'form_edit', 'id' => 'form-edit');
		echo form_open(site_url().'admin/settings/edit/colors/'.$id, $attribute);
		 ?>
		<div class="modal-body">
			<div id="row">
				<div class="form-group">
					<label for="inputlang" class="col-sm-4 control-label"><?php echo lang('colors_name_title'); ?> <span class="symbol required"></span></label>
							<div class="col-md-5">
								<?php 
									$att_name = array('name' => 'data[title]', 'id' => 'color_title', 'data-minlength'=>'2', 'data-maxlength'=>'255', 'data-msg'=>lang('colors_title_name_validate'), 'placeholder'=>lang('colors_title_name_place'), 'class' => 'form-control validate', 'value' => $data->title);
									echo form_input($att_name);
								?>
							</div>
				</div>
				<div class="form-group">
					<label for="inputlang" class="col-sm-4 control-label"><?php echo lang('hex'); ?> <span class="symbol required"></span></label>
							<div class="col-md-5">
								<?php 
									$att_name = array('name' => 'data[hex]', 'id' => 'color_hex', 'data-minlength'=>'3', 'data-maxlength'=>'6', 'data-msg'=>lang('colors_validate_length_hex'),'class' => 'color form-control validate', 'value' => $data->hex);
									echo form_input($att_name);
								?>
							</div>
				</div>
				<div class="form-group" style="display: none;">
					<label for="inputlang" class="col-sm-4 control-label"><?php echo lang('colors_lang_code'); ?> <span class="symbol required"></span></label>
							<div class="col-md-4">
								<?php $lang = array('en'=>'English'); ?>
								<?php echo form_dropdown('data[lang_code]', $lang, $data->lang_code, 'class="form-control"'); ?>
							</div>
				</div>
				<div class="form-group" style="display: none;">
					<label for="inputlang" class="col-sm-4 control-label"><?php echo lang('type'); ?></label>
							<div class="col-md-4">
								<?php $option = array('basic'=>lang('basic'), 'general'=>lang('general'));?>
								<?php echo form_dropdown('data[type]', $option, $data->type, 'class="form-control"'); ?>
							</div>
				</div>
				<div class="form-group">
					<label for="inputlang" class="col-sm-4 control-label"><?php echo lang('publish'); ?></label>
							<div class="col-md-4">
								<?php $option = array(1=>lang('publish'), 0=>lang('unpublish')); ?>
								<?php echo form_dropdown('data[published]', $option, $data->published, 'class="form-control"'); ?>
							</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" data-dismiss="modal" class="btn modal-close"><?php echo lang('close');?></button>
				<button type="button" class="btn btn-primary" onclick="dgUI.ajax.submit('.form-horizontal','#form-edit',load,update)"><?php echo lang('save');?></button>
		</div>
	</div>
</div>
		<?php echo form_close(); ?>
		<script type="text/javascript">
			jscolor.init();
		</script>
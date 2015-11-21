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
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title"><?php if($data->id != '') echo lang('countries_edit'); echo lang('countries_add'); ?></h4>
</div>
	<?php 
		$url= site_url().'admin/settings/edit/countries/'.$data->id;
		$att_form = array('class' => 'form-horizontal','role' => 'form','method' => 'post','name' => 'countries-form','id'=>'form-validate');
		echo form_open($url,$att_form);
	?>
<div class="modal-body">		
	<div class="panel-body">
			<div class="form-group">
				<label class="col-sm-4 control-label" for="country-name">
					<?php echo lang('countries_name');?>
					<span class="symbol required"></span>
				</label>
				<div class="col-sm-6">	
					<?php
						$att_name = array('name' => 'data[name]', 'id' => 'country-name', 'class' => 'form-control validate', 'placeholder' => lang('countries_name'), 'value' => $data->name,'data-minlength'=>'2','data-maxlength'=>'200','data-msg'=>lang('countries_validate_length_name'));
						echo form_input($att_name)				
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label" for="country-code">
					<?php echo lang('countries_code_2');?>
					<span class="symbol required"></span>
				</label>
				<div class="col-sm-6">	
					<?php
						$att_code = array('name' =>'data[code_2]','id' => 'country-code','class' => 'form-control validate', 'placeholder' => lang('countries_code_2'),'value' => $data->code_2, 'data-minlength'=>'2','data-maxlength'=>'2','data-msg'=>lang('countries_validate_length_code_2'));
						echo form_input($att_code)				
					?>
				</div>
				<span class="help-block"><?php echo lang('countries_code_2_help');?></span>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label" for="country-code">
					<?php echo lang('countries_code_3');?>
					<span class="symbol required"></span>
				</label>
				<div class="col-sm-6">	
					<?php
						$att_code = array('name' =>'data[code_3]','id' => 'country-code','class' => 'form-control validate', 'placeholder' => lang('countries_code_3'),'value' => $data->code_3, 'data-minlength'=>'3','data-maxlength'=>'3','data-msg'=>lang('countries_validate_length_code_3'));
						echo form_input($att_code)				
					?>
				</div>
				<span class="help-block"><?php echo lang('countries_code_3_help');?></span>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label" for="publish"><?php echo lang('publish');?></label>
				<div class="col-sm-3">	
					<?php
						$publish = array(
							'1'=>lang('yes'),
							'0'=>lang('no'),
						);
						echo form_dropdown('data[published]', $publish, $data->published, 'class="form-control"');
					?>
				</div>
			</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" data-dismiss="modal" class="btn modal-close"><?php echo lang('close');?></button>
	<button onclick="dgUI.ajax.submit('.form-horizontal','#form-validate',load,update)" class="btn btn-primary" type="button"><?php echo lang('save');?></button>
</div>
</form>
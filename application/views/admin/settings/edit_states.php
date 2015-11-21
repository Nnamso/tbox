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
	<h4 class="modal-title"><?php if($data->id != '') echo lang('states_edit'); else echo lang('states_add'); ?></h4>
</div>
	<?php 
		$url= site_url().'admin/settings/edit/states/'.$data->id;
		$att_form = array('class' => 'form-horizontal','role' => 'form','method' => 'post','name' => 'states-form','id'=>'form-validate');
		echo form_open($url,$att_form);
	?>
<div class="modal-body">		
	<div class="panel-body">
			<div class="form-group">
				<label class="col-sm-4 control-label" for="state-name">
					<?php echo lang('states_name');?>
					<span class="symbol required"></span>
				</label>
				<div class="col-sm-6">	
					<?php
						$att_name = array('name' => 'data[name]', 'id' => 'state-name', 'class' => 'form-control validate', 'placeholder' => lang('states_name'), 'value' => $data->name,'data-minlength'=>'2','data-maxlength'=>'200','data-msg'=>lang('states_validate_length_name'));
						echo form_input($att_name)				
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label" for="state-code">
					<?php echo lang('states_code');?>
					<span class="symbol required"></span>
				</label>
				<div class="col-sm-6">	
					<?php
						$att_code = array('name' =>'data[code]', 'id' => 'state-code', 'class' => 'form-control validate', 'placeholder' => lang('states_code'),'value' => $data->code, 'data-minlength'=>'1','data-maxlength'=>'3','data-msg'=>lang('states_validate_length_code'));
						echo form_input($att_code)				
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label" for="publish"><?php echo lang('states_list_countries');?></label>
				<div class="col-sm-6">	
					<?php
						$data_countries = array();
						if(count($countries) > 0)
						{
							foreach($countries as $country)
							{
								$data_countries[$country->id] = $country->name;
							}
						}
						echo form_dropdown('data[published]', $data_countries, $data->country_id, 'class="form-control"');
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label" for="publish"><?php echo lang('publish');?></label>
				<div class="col-sm-6">	
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
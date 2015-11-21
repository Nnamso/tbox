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
	<h4 class="modal-title"><?php echo lang('currencies_edit'); ?></h4>
</div>
<?php echo validation_errors(); ?>
<?php
$attribute = array('class'=>'form-horizontal', 'name'=>'form_edit', 'id'=>'form-edit');
echo form_open(site_url().'admin/settings/edit/currencies/'.$data->currency_id, $attribute);
 ?>
<div class="modal-body">
    <div id="row">
        <div class="form-group">
		<label for="inputcurrencies" class="col-sm-4 control-label"><?php echo lang('publish'); ?></label>
                <div class="col-md-4">
                    <?php $option = array(1=>lang('yes'), 0=>lang('no')); ?>
                    <?php echo form_dropdown('data[published]', $option, $data->published, 'class="form-control"'); ?>
                </div>
	</div>
	<div class="form-group">
		<label for="inputcurrencies" class="col-sm-4 control-label"><?php echo lang('currencies_name'); ?> <span class="symbol required"></span></label>
                <div class="col-md-5">
                    <?php 
                        $att_name = array('name' => 'data[currency_name]', 'id' => 'lang-title', 'data-minlength'=>'2', 'data-maxlength'=>'200', 'data-msg'=>lang('currencies_validate_length_name'), 'class' => 'form-control validate', 'placeholder'=>lang('currencies_name'), 'value' => $data->currency_name);
                        echo form_input($att_name);
                    ?>
                </div>
	</div>
        <div class="form-group">
		<label for="inputcurrencies" class="col-sm-4 control-label"><?php echo lang('currencies_code'); ?> <span class="symbol required"></span></label>
                <div class="col-md-5">
                    <?php 
                        $att_name = array('name' => 'data[currency_code]', 'id' => 'currencies-code', 'data-minlength'=>'1', 'data-maxlength'=>'3', 'data-msg'=>lang('currencies_validate_length_code'),'class' => 'form-control validate', 'placeholder'=>lang('currencies_code'), 'value' => $data->currency_code);
                        echo form_input($att_name);
                    ?>
                </div>
	</div>
	<div class="form-group">
		<label for="inputcurrencies" class="col-sm-4 control-label"><?php echo lang('currencies_symbol'); ?> <span class="symbol required"></span></label>
                <div class="col-md-5">
                    <?php 
                        $att_name = array('name' => 'data[currency_symbol]', 'id' => 'currencies_symbol', 'data-minlength'=>'1', 'data-maxlength'=>'10', 'data-msg'=>lang('currencies_validate_length_symbol'), 'class' => 'form-control validate', 'placeholder'=>lang('currencies_symbol'), 'value' => $data->currency_symbol);
                        echo form_input($att_name);
                    ?>
                </div>
	</div>
    </div>
</div>
<div class="modal-footer">
	<button type="button" data-dismiss="modal" class="btn modal-close"><?php echo lang('close');?></button>
        <button type="button" class="btn btn-primary" onclick="dgUI.ajax.submit('.form-horizontal','#form-edit',load, update)"><?php echo lang('save');?></button>
</div>
<?php echo form_hidden('data[currency_id]', $data->currency_id); ?>
<?php echo form_close(); ?>
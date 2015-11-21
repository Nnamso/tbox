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
<?php if($error != ''){?>
	<div class="alert alert-danger"><?php echo $error;?></div>
<?php } ?>
<?php echo validation_errors('<p class="alert alert-danger">'); ?>
<form id="fr-edit" method="post" action="<?php echo site_url().'admin/coupon/edit/'.$id;?>">
	<div class="row">
		<div class="col-md-12">
			<p class="pull-right">
				<button type="submit" class="btn btn-primary" ><?php echo lang('save'); ?></button>
				<a href="<?php echo base_url().'admin/coupon'?>" class="btn btn-danger" ><?php echo lang('cancel'); ?></a>
			</p>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-external-link-square icon-external-link-sign"></i>
			<?php if($id != '') echo lang('coupon_edit'); else echo lang('coupon_add');?>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="form-group" style="display: table; width: 100%;">
					<label class="control-label col-md-2"><?php echo lang('coupon_name');?><span class="symbol required"></span></label>
					<div class="col-md-4">
						<input class="form-control validate required" type="text" data-maxlength="150" data-minlength="2" data-msg="<?php echo lang('coupon_edit_msg_validate_name');?>" placeholder="<?php echo lang('coupon_edit_name_place')?>" value="<?php echo set_value('data[name]', $coupon->name);?>" name="data[name]">
					</div>
				</div>
				
				<div class="form-group" style="display: table; width: 100%;">
					<label class="control-label col-md-2"><?php echo lang('coupon_value');?> ($) <span class="symbol required"></span></label>
					<div class="col-md-4">
						<input class="form-control validate required" type="text" data-msg="<?php echo lang('coupon_edit_msg_validate_value');?>" data-maxlength="10" data-minlength="1" placeholder="<?php echo lang('coupon_edit_value_place');?>" value="<?php echo set_value('data[value]', $coupon->value);?>" name="data[value]">
					</div>
				</div>
				
				<div class="form-group" style="display: table; width: 100%;">
					<label class="control-label col-md-2"><?php echo lang('coupon_minimum');?> ($) <span class="symbol required"></span></label>
					<div class="col-md-4">
						<input class="form-control validate required" type="text" data-msg="<?php echo lang('coupon_edit_msg_validate_minimum');?>" data-maxlength="10" data-minlength="1" placeholder="<?php echo lang('coupon_edit_minimum_place');?>" value="<?php echo set_value('data[minimum]', $coupon->minimum);?>" name="data[minimum]">
					</div>
				</div>
				
				<div class="form-group" style="display: table; width: 100%;">
					<div class="col-sm-2">
						<label><?php echo lang('coupon_percent_or_total');?></label>
					</div>
					<div class="col-sm-4">
						<input id="total_coupon" class="pull-left" type="radio" name="data[discount_type]" value="t" style="margin-right: 5px;" <?php if(set_value('data[discount_type]', $coupon->discount_type) == 't') echo 'checked=""';?>/>
						<label for="total_coupon" class="pull-left"  style="margin-right: 20px;"><?php echo lang('coupon_total');?></label>
						
						<input id="percent_coupon" class="pull-left" type="radio" name="data[discount_type]" value="p" style="margin-right: 5px;" <?php if(set_value('data[discount_type]', $coupon->discount_type) == 'p') echo 'checked=""';?>/>
						<label for="percent_coupon" class="pull-left"><?php echo lang('coupon_percent');?></label>
					</div>
				</div>
				
				<div class="form-group" style="display: table; width: 100%;">
					<label class="control-label col-md-2"><?php echo lang('coupon_type');?></label>
					<div class="col-md-2">
						<?php 
							$coupon_type = array(
								'p'=>lang('coupon_permanent'),
								'g'=>lang('coupon_gift'),
							);
							
							echo form_dropdown('data[coupon_type]', $coupon_type, set_value('data[coupon_type]', $coupon->coupon_type), 'class="form-control"');
						?>
					</div>
				</div>
				
				<div class="form-group" style="display: table; width: 100%;">
					<label class="control-label col-md-2"><?php echo lang('coupon_start_date');?><span class="symbol required"></span></label>
					<div class="col-md-2">
						<input id="start_date" class="form-control validate required datepicker date_time" type="text" data-msg="<?php echo lang('coupon_edit_msg_validate_start_date');?>" placeholder="<?php echo lang('coupon_edit_start_date_place');?>" data-maxlength="100" data-minlength="2" name="data[start_date]">
					</div>
				</div>
				
				<div class="form-group" style="display: table; width: 100%;">
					<label class="control-label col-md-2"><?php echo lang('coupon_end_date');?><span class="symbol required"></span></label>
					<div class="col-md-2">
						<input id="end_date" class="form-control validate required datepicker date_time" type="text" data-msg="<?php echo lang('coupon_edit_msg_validate_end_date');?>" placeholder="<?php echo lang('coupon_edit_end_date_place');?>" data-maxlength="100" data-minlength="2" name="data[end_date]">
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<script type="text/javascript">
	jQuery('#fr-edit').validate();
	jQuery('.datepicker').datepicker();
	jQuery('.datepicker').datepicker("option", "dateFormat", "yy-mm-dd");
	jQuery('#start_date').val('<?php $date = date_create($coupon->start_date); echo set_value('data[start_date]', date_format($date, 'Y-m-d'));?>');
	jQuery('#end_date').val('<?php $date = date_create($coupon->end_date); echo set_value('data[end_date]', date_format($date, 'Y-m-d'));?>');
</script>
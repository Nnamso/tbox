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
<script type="text/javascript">
    jQuery(document).on('click change', 'input[name="check_all"]', function() {
        var checkboxes = $(this).closest('table').find(':checkbox').not($(this));
        if ($(this).prop('checked')) {
            checkboxes.prop('checked', true);
        } else {
            checkboxes.prop('checked', false);
        }
    });
</script>

<?php if($this->session->flashdata('error') != ''){?>
	<div class="alert alert-danger"><?php echo $this->session->flashdata('error');?></div>
<?php } ?>
<?php if($this->session->flashdata('msg') != ''){?>
	<div class="alert alert-success"><?php echo $this->session->flashdata('msg');?></div>
<?php } ?>
<?php
$attribute = array('class' => 'fr-coupon', 'id' => 'fr-coupon');
echo form_open(site_url().'admin/coupon', $attribute);
?>
<div class="row">
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-2">
				<?php $options = array('' => lang('all'), '5'=>5, '10'=>10, '15'=>15, '20'=>20, '25'=>25, '100'=>100); ?>
				<?php echo form_dropdown('per_page', $options, $per_page, 'class="form-control" id="per_page"'); ?>
			</div>
			<div class="col-md-4">
				<?php 
					$searchs = array('name' => 'search', 'id' => 'search', 'class' => 'form-control datepicker', 'placeholder' => lang('coupon_search_enter_key'), 'autocomplete'=>'off', 'value'=>$search);
					echo form_input($searchs);
				?>
			</div>
			<div class="col-md-4">
				<?php 
					$options = array('name' => lang('coupon_search_name'), 'date' => lang('coupon_search_date'));
					echo form_dropdown('option', $options, $option, 'class="form-control" id="option_s"'); 
				?>
			</div>
			<div class="col-md-2">
				<button type="submit" class="btn btn-primary"><?php echo lang('search');?></button>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<p style="text-align:right;">
			<a class="btn btn-primary tooltips" title="<?php echo lang('add'); ?>" href="<?php echo site_url(); ?>admin/coupon/edit">
				<i class="glyphicon glyphicon-plus"></i>
			</a>
			<a id="btn-publish" class="btn btn-green tooltips" title="<?php echo lang('publish'); ?>" href="javascript:void(0);">
				<i class="glyphicon glyphicon-ok-sign"></i>
			</a>
			<a id="btn-unpublish" class="btn btn-danger tooltips" title="<?php echo lang('unpublish'); ?>" href="javascript:void(0);">
				<i class="clip-radio-checked"></i>
			</a>
			<a id="btn-delete" class="btn btn-bricky tooltips" title="<?php echo lang('delete'); ?>" href="javascript:void(0);" > 
				<i class="fa fa-trash-o"></i>
			</a>
		</p>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square icon-external-link-sign"></i>
		<?php echo lang('coupon_list'); ?>
	</div>
	<div class="panel-body" id="panelbody">
		<table id="sample-table-1" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th class="center">
			<div class="checkbox-table">
				<label>
					<input id="select_all" type="checkbox" name='check_all'>
				</label>
			</div>
			</th>
			<th class="center"><?php echo lang('name'); ?></th>
			<th class="center"><?php echo lang('coupon_code'); ?></th>
			<th class="center"><?php echo lang('value'); ?></th>
			<th class="center"><?php echo lang('type'); ?></th>
			<th class="center"><?php echo lang('minimum'); ?></th>
			<th class="center"><?php echo lang('publish'); ?></th>
			<th class="center"><?php echo lang('count'); ?></th>
			<th class="center"><?php echo lang('date_start'); ?></th>
			<th class="center"><?php echo lang('date_end'); ?></th>
			<th class="center"><?php echo lang('action'); ?></th>
			</tr>
			</thead>
			<tbody>
				<?php if (count($coupons) > 0) foreach ($coupons as $coupon) { ?>
						<tr>
							<td class="center">
								<div class="checkbox-table">
									<label>
										<input type="checkbox" name="checkb[]" class="checkb" name="check" value="<?php echo $coupon->id; ?>">
									</label>
								</div>
							</td>
							<td><a href="<?php echo site_url().'admin/coupon/edit/'.$coupon->id;?>"><?php echo $coupon->name; ?></a></td>
							<td class="center"><?php echo $coupon->code; ?></td>
							<td class="center">
								<?php 
									if($coupon->discount_type == 't')
										echo $coupon->value.'$'; 
									else
										echo $coupon->value.'%'; 
								?>
							</td>
							<td class="center">
								<?php 
									if($coupon->coupon_type == 'p')echo 'Permanent'; 
									else echo 'Gift';
								?>
							</td>
							<td class="center"><?php echo $coupon->minimum.'$'; ?></td>
							<td class="center">
								<?php 
									if($coupon->publish == 1)
									{
										echo '<a href="'.site_url().'admin/coupon/unpublish/'.$coupon->id.'" class="btn btn-success btn-xs">'.lang('publish').'</a>'; 
									}else
									{
										echo '<a href="'.site_url().'admin/coupon/publish/'.$coupon->id.'" class="btn btn-danger btn-xs">'.lang('unpublish').'</a>'; 
									}
								?>
							</td>
							<td class="center">
								<?php 
									if($coupon->coupon_type == 'g')
									{
										if($coupon->count > 0)
											echo '<i class="fa fa-check"></i>'; 
									}else
									{
										echo $coupon->count; 
									}
								?>
							</td>
							<td class="center"><?php $date = date_create($coupon->start_date); echo date_format($date, 'Y-m-d'); ?></td>
							<td class="center"><?php $date = date_create($coupon->end_date); echo date_format($date, 'Y-m-d'); ?></td>
							<td class="center">
								<div class="visible-md visible-lg hidden-sm hidden-xs">
									<a href="<?php echo site_url(); ?>admin/coupon/edit/<?php echo $coupon->id; ?>" class="btn btn-teal tooltips" data-placement="top" data-original-title="<?php echo lang('edit');?>">
										<i class="fa fa-edit"></i>
									</a>
									<a class="remove btn btn-bricky tooltips" data-placement="top" data-original-title="<?php echo lang('remove');?>" href="<?php echo site_url(); ?>admin/coupon/delete/<?php echo $coupon->id; ?>" onclick="return confirm('<?php echo lang('coupon_confirm_delete');?>');">
										<i class="fa fa-times"></i>
									</a>
								</div>
							</td>
						</tr>
					<?php } ?>    
			</tbody>
		</table>
		<div class="pull-right">
			<?php echo $links;?>
		</div>
	</div>     
</div> 
<?php echo form_close(); ?>   	

<script type="text/javascript">
	jQuery('.tooltips').tooltip();
	
	jQuery('#btn-delete').click(function(){
		if(jQuery('.checkb').is(':checked')){
			var cf = confirm("<?php echo lang('coupon_confirm_delete');?>");
			if(cf)
				jQuery('#fr-coupon').attr('action', '<?php echo site_url().'admin/coupon/delete';?>').submit();
		}else{
			alert('<?php echo lang('coupon_error_not_checbox');?>');
		}
	});
	jQuery('#per_page').change(function(){
		jQuery('#fr-coupon').submit();
	});
	
	if(jQuery('#option_s').val() == 'date')
	{
		jQuery('.datepicker').datepicker();
		jQuery('.datepicker').datepicker("option", "dateFormat", "yy-mm-dd");
	}
		
	jQuery('#option_s').change(function(){
		var check = jQuery(this).val();
		if(check == 'date')
		{
			jQuery('.datepicker').datepicker();
			jQuery('.datepicker').datepicker("option", "dateFormat", "yy-mm-dd");
		}else
		{
			jQuery('.datepicker').datepicker('destroy');
		}
	});
	
	jQuery('#btn-publish').click(function(){
		if(jQuery('.checkb').is(':checked')){
			jQuery('#fr-coupon').attr('action', '<?php echo site_url().'admin/coupon/publish';?>').submit();
		}else{
			alert('<?php echo lang('coupon_error_not_checbox');?>');
		}
	});
	
	jQuery('#btn-unpublish').click(function(){
		if(jQuery('.checkb').is(':checked')){
			jQuery('#fr-coupon').attr('action', '<?php echo site_url().'admin/coupon/unpublish';?>').submit();
		}else{
			alert('<?php echo lang('coupon_error_not_checbox');?>');
		}
	});
	
</script>
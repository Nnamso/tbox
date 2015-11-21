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

<div class="row">
<?php if($this->session->flashdata('msg') != ''){?> 
	<div class="col-md-12">
		<div class="alert alert-success">
			<button class="close" data-dismiss="alert"> × </button>
			<i class="fa fa-check-circle"></i>
			<?php echo $this->session->flashdata('msg');?>
		</div>
	</div>
<?php }?>
<?php if($this->session->flashdata('error') != ''){?> 
	<div class="col-md-12">
		<div class="alert alert-danger">
			<button class="close" data-dismiss="alert"> × </button>
			<i class="fa fa-times-circle"></i>
			<?php echo $this->session->flashdata('error');?>
		</div>
	</div>
<?php }?>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square icon-external-link-sign"></i>
		<?php echo lang('orders_admin_orders_title'); ?>           
	</div>
	<?php
	$attribute = array('class' => 'form-orders', 'id' => 'form-orders');		
	echo form_open(site_url('admin/orders'), $attribute);
	?>
	<div class="panel-body" id="panelbody">
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-2">
						<?php $option_s = array(''=>  lang('all'), '5'=>5, '10'=>10, '15'=>15, '20'=>20, '25'=>25, '100'=>100); ?>
						<?php echo form_dropdown('per_page', $option_s, $per_page, 'class="form-control" id="per_page"'); ?>
					</div>
					<div class="col-md-4">
						<?php 
							$search = array('name' => 'search', 'id' => 'search', 'class' => 'form-control datepicker', 'placeholder' => lang('orders_admin_search_place'), 'autocomplete'=>'off', 'value'=>$search);
							echo form_input($search);
						?>
					</div>
					<div class="col-md-4">
						<?php 
							if(isset($myorders))
								$option_s = array('order_number' => lang('orders_admin_search_order_number'), 'date' => lang('orders_admin_search_date'));
							else
								$option_s = array('order_number' => lang('orders_admin_search_order_number'), 'customer' => lang('orders_admin_search_customer'), 'date' => lang('orders_admin_search_date'));
							echo form_dropdown('option', $option_s, $option, 'class="form-control" id="option_s"'); 
						?>
					</div>
					<div class="col-md-2">
						<button type="submit" class="btn btn-primary"><?php echo lang('search');?></button>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<p style="text-align:right;">
					<a id="btn-delete" class="btn btn-bricky tooltips" title="<?php echo lang('delete'); ?>" href="javascript:void(0);" > 
						<i class="fa fa-trash-o"></i>
					</a>
				</p>
			</div>
		</div>
		<table id="sample-table-1" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th class="center">
						<div class="checkbox-table">
							<label>
								<input id="select_all" type="checkbox" name='check_all' />
							</label>
						</div>
					</th>
					<th class="center"><?php echo lang('orders_admin_order_number_title'); ?></th>
					<th class="center"><?php echo lang('orders_admin_customer_title'); ?></th>
					<th class="center"><?php echo lang('total'); ?></th>
					<th class="center"><?php echo lang('status'); ?></th>
					<th class="center"><?php echo lang('date'); ?></th>
					<th class="center"><?php echo lang('action'); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php if (count($orders)) { ?>
			
				<?php foreach($orders as $order) { ?>
				<tr>
					<td class="center">
						<div class="checkbox-table">
							<label>
								<input type="checkbox" name="checkb[]" class="checkb" name="check" value="<?php echo $order->id; ?>">
							</label>
						</div>
					</td>
					<td class="center">
						<a href="<?php echo site_url('admin/orders/detail/'.$order->id); ?>"><?php echo $order->order_number; ?></a>
					</td>
					<td class="center"><a href="<?php if(isset($myorders)) echo $myorders; else echo site_url('admin/users/edit/'.$order->user_id); ?>"><?php echo $order->name; ?></a></td>
					<td class="center"><?php echo settingValue($setting, 'currency_symbol', '$'); ?><?php echo number_format($order->total, 2); ?></td>
					<td class="center">
						<div class="visible-md visible-lg hidden-sm hidden-xs">
							<?php if ($order->status == 'pending') { ?>	
								<div class="btn-group">
									<a class="btn btn btn-yellow btn-xs tooltips dropdown-toggle" data-toggle="dropdown" href="javascript:void();" data-original-title="<?php echo lang('orders_status_setting');?>">
										<?php echo lang('pending');?><span class="caret" style="margin-left: 5px;"></span>
									</a>
									<ul class="dropdown-menu" role="menu">
										<li>
											<a href="<?php echo site_url('admin/orders/status/completed/'.$order->id); ?>"><i style='margin-right: 5px;' class='clip-checkmark-circle'></i><?php echo lang('completed');?></a>
										</li>
										<li>
											<a href="<?php echo site_url('admin/orders/status/refused/'.$order->id); ?>"><i style='margin-right: 5px;' class='clip-radio-checked'></i><?php echo lang('refused');?></a>
										</li>
									</ul>
								</div>
							<?php } elseif ($order->status == 'completed') { ?>
								<div class="btn-group">
									<a class="btn btn btn-success btn-xs tooltips dropdown-toggle" data-toggle="dropdown" href="javascript:void();" data-original-title="<?php echo lang('orders_status_setting');?>">
										<?php echo lang('completed');?><span class="caret" style="margin-left: 5px;"></span>
									</a>
									<ul class="dropdown-menu" role="menu">
										<li>
											<a href="<?php echo site_url('admin/orders/status/pending/'.$order->id); ?>"><i style='margin-right: 5px;' class='clip-warning'></i><?php echo lang('pending');?></a>
										</li>
										<li>
											<a href="<?php echo site_url('admin/orders/status/refused/'.$order->id); ?>"><i style='margin-right: 5px;' class='clip-radio-checked'></i><?php echo lang('refused');?></a>
										</li>
									</ul>
								</div>
							<?php }else{ ?>
								<div class="btn-group">
									<a class="btn btn btn-danger btn-xs tooltips dropdown-toggle" data-toggle="dropdown" href="javascript:void();" data-original-title="<?php echo lang('orders_status_setting');?>">
										<?php echo lang('refused');?><span class="caret" style="margin-left: 5px;"></span>
									</a>
									<ul class="dropdown-menu" role="menu">
										<li>
											<a href="<?php echo site_url('admin/orders/status/completed/'.$order->id); ?>"><i style='margin-right: 5px;' class='clip-checkmark-circle'></i><?php echo lang('completed');?></a>
										</li>
										<li>
											<a href="<?php echo site_url('admin/orders/status/pending/'.$order->id); ?>"><i style='margin-right: 5px;' class='clip-warning'></i><?php echo lang('pending');?></a>
										</li>
									</ul>
								</div>
							<?php } ?>	
						</div>
					</td>
					<td class="center"><?php echo date("Y-m-d", strtotime($order->created_on)); ?></td>
					<td class="center">
						<a class="remove btn btn-bricky tooltips" onclick="return confirm('<?php echo lang('orders_admin_confirm_delete');?>');" href="<?php echo site_url('admin/orders/delete/'.$order->id); ?>" data-original-title="<?php echo lang('remove');?>" data-placement="top">
							<i class="fa fa-trash-o"></i>
						</a>
					</td>
				</tr>
				<?php } ?>
				
			<?php } ?>
			</tbody>
		</table>
		<div class="pull-right">
			<?php echo $links; ?>
		</div>
	</div>
	<?php echo form_close(); ?>        
</div>   

<script type="text/javascript">
	jQuery('.pagination').css('margin', '0px');
	jQuery('.tooltips').tooltip();
	
	if(jQuery('#option_s').val() == 'date')
	{
		jQuery('.datepicker').datepicker({
			setDate: '2015-02-07',
			dateFormat: 'yy-mm-dd'
		});		
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
	
	jQuery('#btn-delete').click(function(){
		if(jQuery('.checkb').is(':checked')){
			var cf = confirm("<?php echo lang('orders_admin_confirm_delete');?>");
			if(cf)
				jQuery('#form-orders').attr('action', '<?php echo site_url('admin/orders/delete');?>').submit();
		}else{
			alert('<?php echo lang('orders_admin_error_not_checbox_msg');?>');
		}
	});
	
	jQuery('#per_page').change(function(){
		jQuery('#form-orders').submit();
	});
	
</script>
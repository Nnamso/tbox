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
<link rel="stylesheet" type="text/css" href="<?php echo site_url().'assets/plugins/jquery-fancybox/jquery.fancybox.css'; ?>" media="screen" />
<script type="text/javascript" src="<?php echo site_url().'assets/plugins/jquery-fancybox/jquery.fancybox.js'; ?>"></script>

<?php if (count($order)) { ?>

<div id="order_detail_body">
	<div class="row">
		<div class="col-md-9">
			<div class="tabbable">
				<!-- table label -->
				<ul id="myTab4" class="nav nav-tabs">
					<li class="active">
						<a data-toggle="tab" href="#order_tab_1"><?php echo lang('orders_admin_detail_tab_customer_title');?></a>
					</li>
					<li class="">
						<a data-toggle="tab" href="#order_tab_2"><?php echo lang('orders_admin_detail_tab_history_title');?></a>
					</li>
					<li class="">
						<a data-toggle="tab" href="#order_tab_3"><?php echo lang('orders_admin_detail_tab_clipart_title');?></a>
					</li>
				</ul>
				
				<!-- tabs content -->
				<div class="tab-content">
					<div id="order_tab_1" class="tab-pane active">
						<div class="row">
							<!-- user info -->
							<div class="col-sm-5 pull-left">
								<div class="order_detail">
									<h4><?php echo lang('orders_admin_billing_details_title');?></h4>
									<div class="row">
										<label class="col-sm-5 text-right"><?php echo lang('name'); ?>:</label>
										<span class="col-sm-7 text-left">
											<a href="<?php site_url('admin/users/edit/'.$order->user_id); ?>" title="<?php echo $order->name; ?>">
												<strong><?php echo $order->name; ?></strong>
											</a>
										</span>
									</div>
									
									<div class="row">
										<label class="col-sm-5 text-right"><?php echo lang('username'); ?>:</label>
										<span class="col-sm-7 text-left">
											<a href="<?php site_url('admin/users/edit/'.$order->user_id); ?>" title="<?php echo $order->username; ?>">
												<strong><?php echo $order->username; ?></strong>
											</a>
										</span>
									</div>
									
									<div class="row">
										<label class="col-sm-5 text-right"><?php echo lang('email'); ?>:</label>
										<span class="col-sm-7 text-left"><?php echo $order->email; ?></span>
									</div>
								</div>								
							</div>
							
							<!-- user Shipping  info -->
							<div class="col-sm-5 pull-right">
								<div class="order_detail">
									<h4><?php echo lang('orders_admin_shipping_details_title');?></h4>
									
									<?php if ($address !== false) { ?>
										
										<?php foreach ($address as $key => $value) { ?>
										<div class="row">
											<label class="col-sm-5 text-right"><?php echo $key; ?>:</label>
											<span class="col-sm-7 text-left"><?php echo $value; ?></span>
										</div>
										<?php } ?>
										
									<?php } ?>
									
								</div>								
							</div>
						</div>
					</div>
					
					<!-- order history -->
					<div id="order_tab_2" class="tab-pane">
						<table id="table_order_history" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="center" style="width: 10%;"><?php echo lang('number'); ?></th>
									<th class="center" style="width: 10%;"><?php echo lang('type'); ?></th>
									<th class="center"><?php echo lang('name'); ?></th>
									<th class="center" style="width: 15%;"><?php echo lang('status'); ?></th>
									<th class="center" style="width: 20%;"><?php echo lang('date'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php $count = 1; ?>
								<?php foreach($histories as $history){ ?>
									<tr>
										<td class="center"><?php echo $count;?></td>
									<?php foreach($history as $key=>$val){ ?>
											<?php 
												if($key == 'content')
												{
													$item = json_decode($val);
													foreach($item as $k=>$v)
													{
														echo '<td>'.$k.'</td>';
														echo '<td>'.$v.'</td>';
													}
												}elseif($key == 'label')
												{
													if($val == 'order_status')
														echo '<td class="center">'.lang('orders_admin_order_title').'</td>';
													elseif($val == 'item_status')
														echo '<td class="center">'.lang('orders_admin_order_item_title').'</td>';
													else
														echo '<td class="center">'.lang('orders_admin_payment_title').'</td>';
												}elseif($key == 'date')
												{
													echo '<td class="center">'.$val.'</td>';
												}
											?>
									<?php } ?>
									</tr>
									<?php $count++; ?>
								<?php } ?>
							</tbody>
						</table>
					</div>
					
					<!-- order cliparts -->
					<div id="order_tab_3" class="tab-pane">
						<table id="table_order_clipart" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="center"><?php echo lang('name'); ?></th>
									<th class="center" style="width: 25%;"><?php echo lang('images'); ?></th>
									<th class="center" style="width: 25%;"><?php echo lang('designer'); ?></th>
									<th class="center" style="width: 20%;"><?php echo lang('price'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($listClipart as $clipart) { ?>
									<tr>
										<td><a target="_blank" href="<?php echo site_url().'/admin/art/index?art_id='.$clipart['clipart_id'];?>"><?php echo $clipart['title'];?></a></td>
										<td class="center">
											<?php 
												$art->user_id = $clipart['id'];
												$art->file_name = $clipart['file_name'];
												$art->fle_url = $clipart['fle_url'];
												$art->clipart_id = $clipart['clipart_id'];
												$url_image = imageArt($art)
											?>
											<a target="_blank" href="<?php echo site_url().'/admin/art/index?art_id='.$clipart['clipart_id'];?>"><img style="width: 60px;" src="<?php echo $url_image->thumb;?>" alt=""/></a>
										</td>
										<td><a target="_blank" href="http://store.9file.net/en/user/files/<?php echo $clipart['username'];?>"><?php echo $clipart['username'];?></a></td>
										<td><?php echo getPrice($clipart['price']);?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<!-- order info -->
		<div class="col-md-3">
			<h4 id="orders_info"><?php echo lang('orders_admin_orders_info_title');?></h4>
			<div class="row">
				<label class="col-sm-5"><?php echo lang('orders_admin_order_number_title');?>:</label>
				<a href=""><?php echo $order->order_number; ?></a>
			</div>
			<div class="row">
				<label class="col-sm-5"><?php echo lang('orders_admin_order_date_title');?>:</label>
				<span><?php echo date("Y-m-d", strtotime($order->created_on)); ?></a></span>
			</div>
			<div class="row">
				<label class="col-sm-5"><?php echo lang('orders_admin_order_status_title');?>:</label>
				<span><strong><?php echo $order->status; ?></strong></span>
			</div>
			<div class="row">
				<div class="col-sm-12"><a target="_blank" href="<?php echo site_url().'admin/orders/pdf/'.$order->id;?>"><?php echo lang('orders_admin_download_invoice_title');?></a></div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<table id="table_order_detail" class="table table-bordered table-hover" style="margin-top: 20px;">
				<thead>
					<tr>
						<th class="center" style="width: 7%;"><?php echo lang('orders_admin_view_design_title'); ?></th>
						<th class="center" style="width: 18%;"><?php echo lang('name'); ?></th>
						<th class="center" style="width: 6%;"><?php echo lang('sku'); ?></th>
						<th class="center" style="width: 12%;"><?php echo lang('orders_admin_status_of_order_product_title'); ?></th>
						<th class="center" style="width: 7%;"><?php echo lang('orders_admin_product_price_title'); ?></th>
						<th class="center" style="width: 7%;"><?php echo lang('orders_admin_print_price_title'); ?></th>
						<th class="center" style="width: 7%;"><?php echo lang('orders_admin_product_clipart_title'); ?></th>
						<th class="center" style="width: 7%;"><?php echo lang('orders_admin_product_attributes_title'); ?></th>
						<th class="center" style="width: 7%;"><?php echo lang('orders_admin_product_qty_title'); ?></th>
						<th class="center" style="width: 14%;"><?php echo lang('orders_admin_product_option_title'); ?></th>
						<th class="center"  style="width: 10%;"><?php echo lang('total'); ?></th>
					</tr>
				</thead>
				<tbody>					
					<?php 
						$total = 0;
						$count = 1;
						$shipping_price = $order->shipping_price;
						$payment_price = 0.0;
					?>
					<?php foreach($items as $product){?>
						<tr>
							<td class="center"><a class="fancybox fancybox.iframe" href="<?php echo site_url().'admin/orders/view/'.$product->id;?>" ><?php echo lang('view');?></a></td>
							<td>
								<a href="<?php echo site_url('admin/products/edit/'.$product->product_id); ?>" title="<?php echo $product->product_name; ?>">
									<strong><?php echo $product->product_name; ?></strong>
								</a>
							</td>
							<td><?php echo $product->product_sku;?></td>
							<td class="left">
								<?php 
									$option = array(
										'pending'=>lang('pending'),
										'completed'=>lang('completed'),
										'refused'=>lang('refused'),
									);
									echo form_dropdown('status', $option, $product->poduct_status, 'class="form-control input-sm order_product_status" style="width: 70%; padding: 2px; float: left;"');
								?>
								<a href="javascript:void(0)" onclick="changeStatus(this)" rel="" data-id="<?php echo $product->id;?>" class="save_product_status tooltips" data-toggle="tooltip" data-placement="top" title="<?php echo lang('orders_admin_change_status_tooltip');?>"><i class="fa fa-save"></i></a>
							</td>
							<td class="right"><?php echo $setting->currency_symbol.number_format($product->product_price, 2);?></td>
							<td class="right"><?php echo $setting->currency_symbol.number_format($product->price_print, 2);?></td>
							<td class="right"><?php echo $setting->currency_symbol.number_format($product->price_clipart, 2);?></td>
							<td class="right"><?php echo $setting->currency_symbol.number_format($product->price_attributes, 2);?></td>
							<td class="right"><?php echo $product->quantity;?></td>
							<td class="left">
								<?php
									
									if($product->attributes != '' && $product->attributes != '"[]"')
									{
										$size = json_decode(json_decode($product->attributes), true);										
										if (count($size) > 0)
										{
											foreach($size as $option) { ?>
												<div>
													<strong><?php echo $option['name']; ?>: </strong>
													<?php 
														if (is_string($option['value'])) echo $option['value'];
														elseif (is_array($option['value']) && count($option['value']))
														{
															foreach($option['value'] as $v=>$value)
															{
																if ($option['type'] == 'textlist')
																	echo $v .' - '.$value.'; ';
																else
																	echo $value.'; ';
															}
														}
													?>
												</div>
											<?php }
										}
									}
								?>
							</td>
							<?php $total_row = $product->quantity*($product->product_price+$product->price_print+$product->price_clipart)+$product->price_attributes;?>
							<td class="right"><?php echo $setting->currency_symbol.number_format($total_row, 2);?></td>
						</tr>
						<?php 
							$total = $total+$total_row;
							$count++;
						?>
					<?php } ?>
					<!-- shipping -->
					<tr>
						<td colspan="10" class="right">
							<?php echo lang('orders_admin_shipment_fee_title');?>
							
							<?php if (count($shipping)) { ?>								
								<br><small><?php echo lang('orders_admin_shipping_method'); ?>: <a href="<?php echo site_url('admin/settings/shipping'); ?>"><strong><?php echo $shipping->title; ?></strong></a></small>
								<br><small><?php echo $shipping->description; ?></small>
							<?php } ?>
							
						</td>
						<td class="right"><?php echo $setting->currency_symbol.number_format($shipping_price, 2);?></td>
					</tr>
					
					<!-- payment -->
					<tr>
						<td colspan="10" class="right">
							<?php echo lang('orders_admin_payment_fee_title');?>
							
							<?php if (count($payment)) { ?>								
								<br><small><?php echo lang('orders_admin_payment_method'); ?>: <a href="<?php echo site_url('admin/settings/payment'); ?>"><strong><?php echo $payment->title; ?></strong></a></small>
								<br><small><?php echo $payment->description; ?></small>
							<?php } ?>
						</td>
						<td class="right"><?php echo $setting->currency_symbol.number_format($payment_price, 2) ;?></td>
					</tr>
					
					<!-- discount -->
					<tr>
						<td colspan="10" class="right">
							<?php echo lang('orders_admin_discount');?>
							
							<?php if (count($discount)) { ?>								
								<br><small><?php echo $discount->name; ?>: <a href="<?php echo site_url('admin/coupon/edit/'.$discount->id); ?>"><strong><?php echo $discount->code; ?></strong></a></small>								
							<?php } ?>
						</td>
						<td class="right"><?php echo $setting->currency_symbol.number_format($order->discount, 2) ;?></td>
					</tr>
					
					<!-- total -->
					<tr>
						<?php $total = $total + $shipping_price - $order->discount; ?>
						<td colspan="10" class="right"><?php echo lang('orders_admin_total_title');?></td>
						<td class="right" colspan="7"><strong><?php echo $setting->currency_symbol.number_format($total, 2);?><strong></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<?php } else { ?>
	<div class="row">
		<div class="col-md-12">
			<?php echo lang('data_not_found'); ?>
		</div>
	</div>
</div>
<?php } ?>
<script type="text/javascript">
	jQuery('document').ready(function(){
		chooseStatus();
		jQuery('.tooltips').tooltip();
		jQuery('.fancybox').fancybox();
	});
	
	function changeStatus(attrb)
	{
		load();
		var status = jQuery(attrb).attr('rel');
		var id = jQuery(attrb).attr('data-id');
		jQuery.ajax({
			type: "POST",
			url: '<?php echo site_url().'admin/orders/status/';?>',
			dataType: 'html',
			data: {status : status, id : id, order_id : '<?php echo $order->id; ?>'},
			success: function(data){
				if(data != '')
				{
					jQuery('#table_order_detail').html(data);
					if(jQuery('#table_order_detail .main-container').length > 0)
						window.location.reload();
				}else
				{	
					alert('<?php echo lang('orders_admin_cannot_change_status_msg');?>');
				}
				jQuery('.tooltips').tooltip();
				chooseStatus();
				jQuery('#order_detail_body').unblock();
			}
		});
		
		jQuery.ajax({
			type: "POST",
			url: '<?php echo site_url().'admin/orders/history/';?>',
			dataType: 'html',
			data: {id : '<?php echo $order->id; ?>'},
			success: function(data){
				if(data != '')
				{
					jQuery('#table_order_history').html(data);
					if(jQuery('#table_order_history .main-container').length > 0)
						window.location.reload();
				}
				jQuery('#order_detail_body').unblock();
			}
		});
	}
	
	function chooseStatus()
	{
		jQuery('.order_product_status').change(function(){
			var status = jQuery(this).val();
			jQuery(this).parent('td').children('a').attr('rel', status);
			jQuery('.save_product_status').hide();
			jQuery(this).parent('td').children('a').show();
		});
	}
	
	function load() 
	{
        jQuery('#order_detail_body').block({
            overlayCSS: {
                backgroundColor: '#fff'
            },
            message: '<img src="<?php echo base_url('assets/images/loading.gif');?>" /> <?php echo lang('load_text'); ?>',
            css: {
                border: 'none',
                color: '#333',
                background: 'none'
            }
        });
    }
	
</script>
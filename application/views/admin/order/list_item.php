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
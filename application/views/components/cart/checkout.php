<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * shopping cart layout
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$cart	= $this->session->userdata('cart');

// check shipping
if (isset($cart->shipping) && isset($cart->shipping->price))
	$shipping_active	= $cart->shipping->price;
else
	$shipping_active	= 0;
?>
<div class="page-cart">
<form id="cartCheckout" method="POST" action="<?php echo site_url('payment'); ?>">
	<!-- cart head -->
	<div class="row">
		<div class="col-sm-6 text-left">
			<h2><?php echo lang('cart_your_cart_title');?></h2>
		</div>
		<div class="col-sm-6 text-right">
			<a class="btn btn-primary" href="<?php echo site_url(); ?>"><?php echo lang('cart_continue_designer_btn');?></a>
		</div>
	</div>
	
	<hr />
	
	<div class="row">		
		<div class="col-xs-12 col-sm-7 col-md-8 col-lg-9 pull-left">
			<!-- BEGIN:: user info -->
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><?php echo lang('cart_address_and_shipping');?></h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="form-horizontal col-sm-12">
						
						<?php if ( count($forms) > 0 ) { ?>
						
							<?php foreach($forms as $field) { ?>
							<div class="form-group">
							
								<label class="col-sm-4 col-md-2 control-label"><?php echo $field->title; ?></label>
								<div class="col-sm-8 col-md-6">
									<?php 
									if ( isset($profiles[$field->id]) )
									{
										echo $fields->display($field, $profiles[$field->id]);
									}
									else
									{
										echo $fields->display($field);
									}
									?>
								</div>
								
							</div>
							<?php } ?>
						
						<?php } ?>
							
						</div>
					</div>
				</div>
			</div>
			<!-- END:: user info -->
			
			<div class="row">
			
				<!-- BEGIN:: shipping method -->
				<div class="col-xs-12 col-sm-6 col-md-6 pull-left">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"><?php echo lang('cart_shipping_method_title');?></h3>
						</div>
						<div class="panel-body">
							<div class="row">								
								<?php if (count($shipping) > 0) { ?>
									
									<?php
									$cart = $this->session->userdata('cart');
									foreach($shipping as $ship) {
										if (isset($cart->shipping->id))
										{
											if ($cart->shipping->id == $ship->id)
											{
												$checked 	= 'checked="checked"';
												$ship_price = $ship->price;
											}
											else
											{
												$checked = '';
											}
										}
										else
										{
											if ($ship->default == 1) 
											{
												$checked = 'checked="checked"';
												$ship_price = $ship->price;
											}
											else 
											{
												$checked = '';
											}
										}										
									?>
										<div class="form-group">
											<div class="checkbox">
												<label>
													<input class="choose-shipping" type="radio" name="shipping" onclick="apps.shipping(<?php echo $ship->id;?>)" value="<?php echo $ship->id;?>" <?php echo $checked;?> id="ship_<?php echo $ship->id;?>"/>
													 <strong><?php echo $ship->title;?> <span class="text-success"><?php echo $ship->price;?></span></strong>
												</label>
												
												<?php if ($ship->description != ''){?>
												<p class="help-block"><?php echo $ship->description;?></p>
												<?php } ?>
											</div>
										</div>
									<?php } ?>
									
								<?php }else{ ?>
									<div class="form-group"><?php echo $error; ?></div>
								<?php } ?>							
							</div>
						</div>
					</div>
				</div>
				<!-- END:: shipping method -->
				
				<!-- BEGIN:: payment method -->
				<div class="col-xs-12 col-sm-6 col-md-6 pull-right">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"><?php echo lang('cart_payment_method_title');?></h3>
						</div>
						<div class="panel-body">
							<div class="row">								
								
							<?php 
							if (count($payments) > 0)
							{								
								foreach($payments as $payment) 
								{
									if ($payment->default == 1) 
									{
										$checked = 'checked="checked"';										
									}
									else 
									{
										$checked = '';
									}
							?>
								<div class="form-group">
									<div class="checkbox">
										<label>
											<input type="radio" name="payment" value="<?php echo $payment->id;?>" <?php echo $checked;?> id="payment_<?php echo $payment->id;?>" onclick="payment_toggle(this)" />											
											 <strong><?php echo $payment->title;?></strong>
										</label>
										
										<?php if ($payment->description != ''){?>
										<p class="help-block"> <?php echo $payment->description;?></p>
										<?php } ?>
										<?php 
											$file = ROOTPATH .DS. 'application' .DS. 'payments' .DS. $payment->type .DS.'form.php';
											if (file_exists($file))
											{
										?>
											<div class="box_payment" <?php if($checked == '') echo 'style="display: none;"';?>>
												<?php include_once($file);?>
											</div>
										<?php 
											} 
										?>
									</div>
								</div>
							<?php }
							} 
							?>
							</div>
						</div>
					</div>
				</div>
				<!-- END:: payment method -->
			</div>
		</div>
		
		<!-- BEGIN:: Min Cart -->
		<div class="col-xs-12 col-sm-5 col-md-4 col-lg-3 pull-right">
			<div class="cart_info">
				<div class="row">
					<div class="col-sm-12">
						<h5 class="pull-left"><strong><?php echo lang('cart_your_cart_summary');?></strong></h5>
						<a href="<?php echo site_url('cart'); ?>" class="pull-right"><?php echo lang('edit'); ?></a>
					</div>
				</div>
				<div class="row">					
				<?php $total=0; if (count($items) != 0) { ?>
				
					<table class="table">
					<?php foreach($items as $key=>$item){?>
						<tr>
							<td class="left" width="40%">
								<img src="<?php echo base_url($designs[$key]['images']['front']);?>" alt="<?php echo $item['name']; ?>" class="img-thumbnail img-responsive" />
							</td>
							
							<td class="left" width="60%">
								<h5><a href="" title=""><?php echo $item['name']; ?></a></h5>
								
								<?php if ($item['options']) { ?>
								<div class="cart-more">
									<div class="cart-more-display" style="display:none;">
										<div class="form-group">
											<strong><?php echo lang('color');?></strong>
											<p><span class="bg-colors" style="background-color:#<?php echo $designs[$key]['color'] ?>"></span></p>
										</div>
																				
										<?php foreach($item['options'] as $option) { ?>										
											<strong><?php echo $option['name']; ?>: </strong>
											<p>
											<?php 
												if (is_string($option['value'])) echo $option['value'];
												else if (is_array($option['value']) && count($option['value']))
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
											</p>
										<?php } ?>										
									</div>
									<p><a onclick="" href="#" class="text-success"><i class="fa fa-angle-down"></i> <small>Click here for more detail</small></a></p>
								</div>
								<?php } ?>
								<p class="pull-left"><?php echo lang('cart_edit_quantity_place');?>: <?php echo $item['qty']; ?></p>
								<strong class="pull-right"><?php echo $item['symbol'] . number_format(($item['subtotal'] + $item['customPrice']), 2, '.', ','); ?></strong>
							</td>
						</tr>
						<?php 
							$total = $total + $item['subtotal'] + $item['customPrice'];
							$symbol = $item['symbol'];
						?>
					<?php } ?>						
						<tr>
							<td class="text-right"><strong><?php echo lang('cart_your_cart_subtotal');?></strong></td>
							<td class="text-right">							
								<span class="pull-right"><?php echo $symbol . number_format($total, 2, '.', ','); ?></span>
							</td>						
						</tr>
						<tr>
							<td class="text-right border-no"><strong><?php echo lang('cart_shipping');?></strong></td>
							<td class="text-right border-no">							
								<span class="pull-right">
								<?php if ($ship_price == 0) echo 'Free Shipping'; else echo $symbol . number_format($ship_price, 2, '.', ','); ?>
								</span>							
							</td>						
						</tr>
						<?php
						// check discount
						if (isset($cart->discount) && isset($cart->discount->id))
						{
							if ($cart->discount->discount_type == 't')
							{
								$discount	= $total - $cart->discount->value;
							}
							else
							{
								$discount	= ($total * $cart->discount->value)/100;
							}
							$code	= $cart->discount->code;
						}
						else
						{
							$discount	= 0;
							$code		= '';
						}
						?>
						
						<?php if ($discount > 0) { ?>
						<tr>
							<td class="text-right border-no">
								<strong><?php echo lang('cart_discount');?></strong>
								<small style="display:block; clear:both;">
								<?php echo 'Coupon '.$cart->discount->code;?>
								</small>
							</td>
							<td class="text-right border-no">							
								<span class="pull-right">
								<?php echo $symbol . number_format($discount, 2, '.', ','); ?>
								</span>							
							</td>						
						</tr>
						<?php } ?>
						
						<tr>
							<td class="text-right border-no"><strong><?php echo lang('total');?></strong></td>
							<td class="text-right border-no">
								<strong class="pull-right"><?php echo $symbol . number_format($total + $ship_price - $discount, 2, '.', ','); ?></strong>							
							</td>						
						</tr>
					</table>
					
				<?php } ?>
				</div>
				
				<div class="row">
					<hr style="margin-top: 0px;"/>
					<div class="col-sm-12">					
						<p><?php echo lang('cart_coupon_code');?></p>
						<div class="input-group">							
							<input type="text" class="form-control input-sm" value="<?php echo $code; ?>" name="coupon" id="coupon_code" placeholder="Add coupon">
							<span class="input-group-btn">
								<button type="button" class="btn btn-default btn-sm" onclick="apps.discount(this)"><?php echo lang('apply'); ?></button>
							</span>
						</div>					
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-sm-12 text-center">
						<button type="button" id="btn_pay" onclick="apps.checkout()" class="btn btn-primary"><?php echo lang('confirm_payment');?></button>
					</div>
				</div>				
			</div>
		</div>
		<!-- END Min Cart -->
	</div>

	<hr />
	<div class="row">
		<div class="col-sm-4 col-md-2 text-right pull-right">
			<button type="button" id="btn_pay" onclick="apps.checkout()" class="btn btn-primary"><?php echo lang('confirm_payment');?></button>
		</div>
	</div>
</form>
</div>
<script>
	var baseURL	= '<?php echo base_url(); ?>';
	jQuery('.text-success').click(function(event){
		event.preventDefault();
		jQuery(this).parents('.cart-more').find('.cart-more-display').toggle();
	});
	if (jQuery('#coupon_code').val() != '')
	{
		apps.discount();
	}
	apps.shipping(jQuery('choose-shipping:checked').val());
	if (jQuery('#field-country').length > 0)
	{
		var state_id	= jQuery('#field-state').data('id');
		if (state_id != null)
			apps.state(document.getElementById('field-country'), state_id);
		else
			apps.state(document.getElementById('field-country'));
	}
	
	function payment_toggle(e)
	{
		var dt = jQuery(e).val();
		if(dt != '')
		{
			jQuery('.box_payment').hide();
			jQuery('.box_payment').find('input').removeClass('required');
			jQuery(e).parent('label').parent('div').children('.box_payment').show();
			jQuery(e).parent('label').parent('div').children('.box_payment').find('input').addClass('required');
		}
	}
</script>
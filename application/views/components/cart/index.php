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

?>
<div class="page-cart">
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
	
	<?php if (count($items) == 0) { ?>
	<!-- data not found -->
	<div class="row">
		<div class="col-sm-12 text-center">	
			<br>
			<strong><?php echo lang('cart_empty'); ?></strong>
		</div>	
	</div>
	<?php } else { ?>
	
	<div id="cart" class="step-cart">
		<!-- BEGIN:: cart items -->
		<div class="row">
			<div class="col-sm-12">				
				<div class="cart_detail">
					<form method="POST" action="" id="fr-tools-cart">
						<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th class="col-sm-4 center"><?php echo lang('preview');?></th>
									<th class="col-sm-4 center"><?php echo lang('description');?></th>
									<th class="col-sm-2 center"><?php echo lang('quantity');?></th>
									<th class="col-sm-1 center"><?php echo lang('price');?></th>
									<th class="col-sm-1 center"><?php echo lang('total');?></th>
								</tr>
							</thead>
							
							<tbody>
								<?php $total = 0; 
								foreach($items as $key=>$item){ ?>
								<tr>
									<!-- product images -->
									<td class="center">
										<div class="row">
											<div class="col-sm-12">											
												<img src="<?php echo base_url($designs[$key]['images']['front']);?>" class="img-responsive" alt="<?php echo $item['name']; ?>" />											
											</div>
										</div>
										<div class="row">
											<?php if (isset($designs[$key]['images']['back'])) { ?>
											<div class="col-md-4">
												<a href="javascript:void(0);"><img src="<?php echo base_url($designs[$key]['images']['back']);?>" class="img-responsive img-thumbnail" alt="" /></a></li>
											</div>
											<?php } ?>
											<?php if (isset($designs[$key]['images']['left'])) { ?>
											<div class="col-md-4">
												<a href="javascript:void(0);"><img src="<?php echo base_url($designs[$key]['images']['left']);?>" class="img-responsive img-thumbnail" alt="" /></a></li>
											</div>
											<?php } ?>
											<?php if (isset($designs[$key]['images']['right'])) { ?>
											<div class="col-md-4">
												<a href="javascript:void(0);"><img src="<?php echo base_url($designs[$key]['images']['right']);?>" class="img-responsive img-thumbnail" alt="" /></a></li>
											</div>
											<?php } ?>
										</div>
									</td>
									<td class="left">
										<!-- product name -->
										<div class="row">
											<div class="col-sm-12 text-left">
												<a href="<?php echo site_url('product/'.$item['product_id']); ?>" title="<?php echo $item['name']; ?>"><strong class="title_product"><?php echo $item['name']; ?></strong></a>
											</div>
										</div>
										<hr />
										
										<!-- product color -->
										<div class="row">
											<div class="col-sm-12 text-left">
												<div class="form-group">
													<strong><?php echo lang('color'); ?>: </strong>
												</div>
												<div class="form-group">
													<span class="bg-colors" style="background-color:#<?php echo $designs[$key]['color'] ?>"></span>
												</div>
											</div>
										</div>
										
										<!-- product options -->
										<div class="row">
										<?php if ($item['options']) { ?>
										
											<?php foreach($item['options'] as $option) { ?>
												<div class="col-sm-12 text-left">
													<strong><?php echo $option['name']; ?>: </strong>
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
												</div>
											<?php } ?>
											
										<?php } ?>
										</div>	
										
										<!-- list team -->
										<div class="row">		
												
											<?php if (isset($item['teams']) && isset($item['teams']['name']) && count($item['teams']['name']) > 0) { ?>
												<div class="col-sm-12 text-left table-responsive">
													<strong><?php echo lang('cart_team_title'); ?></strong>
													<table class="table table-bordered">
														<thead>
															<tr>
																<th><strong><?php echo lang('cart_team_name');?></strong></th>
																<th><strong><?php echo lang('cart_team_number');?></strong></th>
																<th><strong><?php echo lang('cart_team_size');?></strong></th>
															</tr>
														</thead>
														<tbody>
														<?php foreach($item['teams']['name'] as $ii=>$name) {?>
														<tr>
															<td><?php echo $name; ?></td>
															<td><?php echo $item['teams']['number'][$ii]; ?></td>
															<td>
															<?php $size = explode('::', $item['teams']['size'][$ii]); echo $size[0]; ?>
															</td>
														</tr>
														<?php } ?>
														</tbody>
													</table>
												</div>
											<?php } ?>
												
										</div>
										<!-- end team -->
									</td>
									
									<td class="center padding-top-55">										
										<div class="input-group" style="width:80px">
											<input type="text" class="form-control input-sm text-center edit_qty" value="<?php echo $item['qty']; ?>" readonly/>
											<a class="clear_qty input-group-addon" onclick="apps.removeCart('<?php echo $key; ?>', this)" href="javascript:void(0);"><i class="fa fa-trash-o"></i></a>
										</div>										
									</td>
									<td class="center padding-top-55"><?php echo $item['symbol'] . number_format(($item['subtotal'] + $item['customPrice']), 2, '.', ','); ?></td>
									<td class="center padding-top-55"><strong><?php echo $item['symbol'] . number_format(($item['subtotal'] + $item['customPrice']), 2, '.', ','); ?><strong></td>
								</tr>
								<?php 
									$total = $total + $item['subtotal'] + $item['customPrice'];
									$symbol = $item['symbol'];
								} 
								?>
								<tr>
									<td class="text-right" colspan="4"><strong><?php echo lang('total');?></strong></td>
									<td><strong><?php echo $symbol . number_format($total, 2, '.', ','); ?></strong></td>
								</tr>
							</tbody>
						</table>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- END:: cart items -->
		
		<!-- BEGIN:: user login -->
		<?php if (empty($user['id'])) { ?>
		<div class="row" id="user-form-cart">
			
			<!-- login -->
			<div class="col-sm-5 pull-left">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo lang('cart_login_and_checkout_title');?></div>
					<div class="panel-body">
						<form id="fr-cart-login" method="POST" action="<?php echo site_url('users/login');?>" class="form-horizontal">						
							<div class="col-sm-10">
								<div class="form-group">
									<label class="col-sm-5"><?php echo lang('cart_email_address_label');?></label>
									<div class="col-sm-7">
										<input type="text" name="data[email]" class="form-control required validate input-sm" data-type="email" data-msg="<?php echo lang('cart_email_validate_msg');?>" placeholder="<?php echo lang('cart_email_place');?>"/>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-5"><?php echo lang('cart_password_label');?></label>
									<div class="col-sm-7">
										<input type="password" name="data[password]" class="form-control required validate input-sm" data-minlength="6" data-maxlength="32" data-msg="<?php echo lang('cart_password_validate_msg');?>"/>
									</div>
								</div>
							</div>
							<?php echo $this->auth->getToken(); ?>
							<input type="hidden" name="return" value="cart/checkout">
							<div class="col-sm-2">															
								<div class="form-group">
									<button type="submit" class="btn btn-primary btn-sm"><?php echo lang('login');?></button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			
			<!-- register -->
			<div class="col-md-5 pull-right">
				<div class="panel panel-default">
					<div class="panel-heading"><strong><?php echo lang('cart_register_and_checkout_title');?></strong></div>
					<div class="panel-body">					
						<form  id="fr-cart-register" method="POST" action="<?php echo site_url('users/register');?>" class="form-horizontal">						
							<div class="col-sm-10">									
								<div class="form-group">
									<label class="col-sm-5"><?php echo lang('cart_user_name_label');?></label>
									<div class="col-sm-7">
										<input type="text" name="data[username]" class="input-sm form-control required validate"  data-minlength="2" data-maxlength="200" data-msg="<?php echo lang('cart_user_name_validate_msg');?>" placeholder="<?php echo lang('cart_user_name_place');?>"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-5"><?php echo lang('cart_email_address_label');?></label>
									<div class="col-sm-7">
										<input class="form-control required validate input-sm" type="text" name="data[email]" data-type="email" data-msg="<?php echo lang('cart_email_validate_msg');?>" placeholder="<?php echo lang('cart_email_place');?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-5"><?php echo lang('cart_password_label');?></label>
									<div class="col-sm-7">
										<input class="form-control required validate input-sm" name="data[password]" type="password" data-minlength="6" data-maxlength="32" data-msg="<?php echo lang('cart_password_validate_msg');?>"/>
									</div>
								</div>
							</div>
							<div class="col-sm-2">								
								<div class="form-group">
									<button type="submit" class="btn btn-primary" id="register-buttoncart"><?php echo lang('register');?></button>
								</div>								
							</div>
							<?php echo $this->auth->getToken(); ?>
							<input type="hidden" name="return" value="cart/checkout">
							<input type="hidden" name="ajax" value="1">
						</form>
					</div>
				</div>				
			</div>		
		</div>
		<?php } ?>
		<!-- END:: user login -->
	</div>			
	
	<hr />
	
	<!-- button -->
	<div class="row">
		<div class="col-sm-6 text-left">
			<a class="btn btn-default" href="<?php echo site_url(); ?>"><?php echo lang('cart_continue_designer_btn');?></a>
		</div>
		<div class="col-sm-6 text-right">
			<a class="btn btn-primary" href="<?php echo site_url('cart/checkout'); ?>"><?php echo lang('checkout');?></a>			
		</div>		
	</div>
	
	
	<script type="text/javascript">
		var baseURL = '<?php echo base_url(); ?>';
		jQuery('.choose_login').change(function(){
			var check = jQuery(this).val();
			if(check == 'login')
			{
				jQuery('#cart #fr-cart-login').show();
				jQuery('#cart #fr-cart-register').hide();
			}
			else
			{
				jQuery('#cart #fr-cart-login').hide();
				jQuery('#cart #fr-cart-register').show();
			}
		});
	</script>
	<?php } ?>
</div>
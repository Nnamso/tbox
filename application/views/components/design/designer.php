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
<link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">

<script src="<?php echo base_url('assets/js/add-ons.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.ui.rotatable.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/language.js'); ?>"></script>	
<script src="<?php echo base_url('assets/js/design.js'); ?>"></script>	
<script src="<?php echo base_url('assets/js/main.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/canvg.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/validate.js'); ?>"></script>	

<script type="text/javascript">
	var baseURL = '<?php echo base_url(); ?>';	
	var urlCase = '<?php echo base_url('image-tool/thumbs.php'); ?>';
	var loginError = '<?php echo $this->lang->line('login_error_msg');?>';
	var myAccount = '<?php echo $this->lang->line('my_account');?>';
	var logOut = '<?php echo $this->lang->line('logout');?>';
	var passError = '<?php echo $this->lang->line('change_pass_error_msg');?>';
	var passSuccess = '<?php echo $this->lang->line('change_pass_success_msg');?>';
	var registerError = '<?php echo $this->lang->line('ursername_or_email_exit_msg');?>';
	<?php if ( isset($user['id']) ) { ?>
	var user_id = <?php echo $user['id']; ?>;
	<?php }else{ ?>
	var user_id = 0;
	<?php } ?>
</script>

<div id="dg-wapper">
	<div id="dg-mask" class="loading"></div>
	
	<!-- Begin main -->
	<div id="dg-designer">
		<div class="col-left">
			<div class="text-center product-btn-info">					
				<a href="javascript:void(0)" data-target="#modal-product-info" data-toggle="modal" class="btn btn-default pull-left btn-sm"><i class="fa fa-info"></i> <span><?php echo lang('design_product_info'); ?></span></a>
				<a href="javascript:void(0)" data-target="#modal-product-size" data-toggle="modal" class="btn btn-default pull-right btn-sm"><i class="fa fa-male"></i> <span><?php echo lang('design_size_chart'); ?></span></a>
			</div>
			
			<div id="dg-left" class="width-100">
				<div class="dg-box width-100">
					<ul class="menu-left">
						<li>
							<a href="javascript:void(0)" class="view_change_products" title="" data-toggle="modal" data-target="#dg-products">
								<i class="glyphicons t-shirt"></i> <?php echo $lang['designer_menu_choose_product']; ?>
							</a>
						</li>
						
						<li>
							<a href="javascript:void(0)" class="add_item_text" title="">
								<i class="glyphicons text_bigger"></i> <?php echo $lang['designer_menu_add_text']; ?>
							</a>
						</li>
						
						<li>
							<a href="javascript:void(0)" class="add_item_clipart" title="" data-toggle="modal" data-target="#dg-cliparts">
								<i class="glyphicons picture"></i> <?php echo $lang['designer_menu_add_art']; ?>
							</a>
						</li>
						
						<!--
						<li>
							<a href="javascript:void(0)" title="" data-toggle="modal" data-target="#dg-designidea">
								<i class="glyphicons sun"></i> <?php echo $lang['designer_menu_design_idea']; ?>
							</a>
						</li>
						-->
						<li>
							<a href="javascript:void(0)" title="" data-toggle="modal" data-target="#dg-myclipart">
								<i class="glyphicons cloud-upload"></i> <?php echo $lang['designer_menu_upload_image']; ?>
							</a>
						</li>
						
						<li>
							<a href="javascript:void(0)" class="add_item_team" title="">
								<i class="glyphicons soccer_ball"></i> <?php echo $lang['designer_menu_name_number']; ?>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)" class="add_item_mydesign">
								<i class="glyphicons user"></i> <?php echo $lang['designer_menu_my_design']; ?>
							</a>
						</li>
						<!--
						<li>
							<a href="javascript:void(0)" title="">
								<i class="glyphicons qrcode"></i> <?php echo $lang['designer_menu_add_qrcode']; ?>
							</a>
						</li>
						-->
					</ul>
				</div>
				
				<div class="dg-box width-100 div-layers no-active">
					<div class="layers-toolbar">
						<button type="button" class="btn btn-default">
							<i class="fa fa-long-arrow-down"></i>
							<i class="fa fa-long-arrow-up"></i>
						</button>
						<button type="button" class="btn btn-default btn-sm">
							<i class="fa fa-angle-right"></i>						
						</button>
					</div>
						
					<div class="accordion">
						<h3><?php echo $lang['designer_menu_login_layers']; ?></h3>
						<div id="dg-layers">
							<ul id="layers">									
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-xs-12 col-md-12 col-center align-center">
			<!-- Begin sidebar -->
			<div id="dg-sidebar">
				<ul class="dg-tools">
					<li>
						<a data-target="#dg-help" id="tools-help" data-toggle="modal" href="javascript:void(0)">
							<i class="glyphicons circle_question_mark"></i>
							<span><?php echo $lang['designer_top_help']; ?></span>
						</a>
					</li>				
					<li>
						<a href="javascript:void(0)" data-type="preview" class="dg-tool">
							<i class="glyphicons eye_open"></i>
							<span><?php echo $lang['designer_top_preview']; ?></span>
						</a>
					</li>
					<!--
					<li>
						<a href="javascript:void(0)" data-type="undo" class="dg-tool">
							<i class="glyphicons undo"></i>
							<span>undo</span>
						</a>
					</li>
					<li>
						<a href="javascript:void(0)" data-type="redo" class="dg-tool">
							<i class="glyphicons redo"></i>
							<span>redo</span>
						</a>
					</li>
					-->
					<li>
						<a href="javascript:void(0)" data-type="zoom" title="Zoom" class="dg-tool">
							<i class="glyphicons search"></i>
							<span><?php echo $lang['designer_top_zoom']; ?></span>
						</a>
					</li>
					<li>
						<a href="javascript:void(0)" data-type="reset" title="Reset Design" class="dg-tool">
							<i class="glyphicons bin"></i>
							<span><?php echo $lang['designer_top_reset']; ?></span>
						</a>
					</li>					
				</ul>
			</div>
			<!-- Begin sidebar -->
			
			<!-- design area -->
			<div id="design-area" class="div-design-area">
				<div id="app-wrap" class="div-design-area">
				<?php if ($product == false || (isset($product->design) && $product->design == false)) { ?>
					<div id="view-front" class="labView active">
						<div class="product-design">
							<strong><?php echo $lang['designer_product_data_found']; ?></strong>
						</div>
					</div>
				<?php } else { ?>
					
					<!-- begin front design -->						
					<div id="view-front" class="labView active">
						<div class="product-design"></div>
						<div class="design-area"><div class="content-inner"></div></div>
					</div>						
					<!-- end front design -->
					
					<!-- begin back design -->
					<div id="view-back" class="labView">
						<div class="product-design"></div>
						<div class="design-area"><div class="content-inner"></div></div>
					</div>
					<!-- end back design -->
					
					<!-- begin left design -->
					<div id="view-left" class="labView">
						<div class="product-design"></div>
						<div class="design-area"><div class="content-inner"></div></div>
					</div>
					<!-- end left design -->
					
					<!-- begin right design -->
					<div id="view-right" class="labView">
						<div class="product-design"></div>
						<div class="design-area"><div class="content-inner"></div></div>
					</div>
					<!-- end right design -->
					
				<?php } ?>
				</div>
			</div>
			
			<div class="" id="product-thumbs"></div>
		</div>	  
		
		<div class="col-right">
			<span class="arrow-mobile" data="right"><i class="glyphicons chevron-left"></i></span>
			<div id="dg-right">
				<!-- share -->
				<div class="dg-share">
					<div class="row align-center">
						<label><img src="<?php echo base_url('assets/images/label-share.png'); ?>" alt="Save and share this design" /></label>
					</div>
					<div class="row align-center">
						<div class="dg-box">
							<a href="javascript:void(0)" onclick="design.save()" class="btn btn-sm btn-warning btn-margin pull-left" title="save"><?php echo $lang['designer_save_btn']; ?></a>
							<ul class="list-share pull-right">
								<li>
									<span class="icon-25 share-email" data-type="email"></span>
									<span class="icon-25 share-facebook" data-type="facebook"></span>
									<span class="icon-25 share-twitter" data-type="twitter"></span>
									<span class="icon-25 share-pinterest" data-type="pinterest"></span>
								</li>
							</ul>
						</div>
					</div>
				</div>
				
				<!-- product -->
				<div class="align-center" id="right-options">
					<div class="dg-box">
						<div class="accordion">
							<h3><?php echo $lang['designer_right_product_options']; ?></h3>
							<div class="product-options contentHolder" id="product-details">
							<?php if ($product != false) { ?>
								<div class="content-y">									
									<?php if (isset($product->design) && $product->design != false) { ?>
									<div class="product-info">
										<div class="form-group product-fields">
											<label for="fields"><?php echo $lang['designer_right_choose_product_color']; ?></label>
											<div class="list-colors" id="product-list-colors">
												<?php for ($i=0; $i<count($product->design->color_hex); $i++) { ?>
												<span class="bg-colors dg-tooltip <?php if ($i==0) echo 'active'; ?>" onclick="design.products.changeColor(this, <?php echo $i; ?>)" data-color="<?php echo $product->design->color_hex[$i]; ?>" style="background-color:#<?php echo $product->design->color_hex[$i]; ?>" data-placement="top" data-original-title="<?php echo $product->design->color_title[$i]; ?>"></span>
												<?php } ?>
											</div>
										</div>										
									</div>
									<?php } ?>
									
									<form method="POST" id="tool_cart" name="tool_cart" action="">
									<div class="product-info" id="product-attributes">
										<?php if (isset($product->attribute)) { ?>
											<?php echo $product->attribute; ?>
										<?php } ?>										
									</div>
									</form>									
								</div>
							<?php } ?>
							</div>
							
							<h3><?php echo $lang['designer_right_color_used']; ?></h3>
							<div class="color-used"></div>
							
							<h3><?php echo $lang['designer_right_screen_size']; ?></h3>
							<div class="screen-size"></div>
							<!--
							<h3>Extra</h3>
							<div>
								Extra
							</div>
							-->
						</div>
						<div class="product-prices">
							<div id="product-price">
								<span class="product-price-title"><?php echo $lang['designer_right_total']; ?></span>
								<div class="product-price-list">
									<span id="product-price-old"><?php echo settingValue($setting, 'currency_symbol', '$'); ?><span class="price-old-number">123</span></span>
									<span id="product-price-sale"><?php echo settingValue($setting, 'currency_symbol', '$'); ?><span class="price-sale-number">100</span></span>
								</div>
								<span class="price-restart" title="Click to get price" onclick="design.ajax.getPrice()"><i class="glyphicons restart"></i></span>
							</div>
							<button type="button" class="btn btn-warning btn-addcart" onclick="design.ajax.addJs(this)"><i class="glyphicons shopping_cart"></i><?php echo $lang['designer_right_buy_now']; ?></button>								
						</div>
					</div>
				</div>
			</div>
		</div>						
	</div>
	<!-- End main -->			
</div>

<div id="screen_colors_body" style="display:none;">
	<div id="screen_colors">
		<div class="screen_colors_top">
			<div class="col-xs-5 col-md-5 text-left" id="screen_colors_images">
			</div>
			<div class="col-xs-7 col-md-7 text-left">
				<h4><?php echo $lang['designer_color_select_ink_colors']; ?></h4>
				<span class="help-block"><?php echo $lang['designer_color_select_the_colors_that_appear']; ?></span>
				<span class="help-block"><?php echo $lang['designer_color_this_helps_us_determine']; ?></span>
				<p><strong> <?php echo $lang['designer_color_note']; ?></strong></p>
				<span id="screen_colors_error"></span>
				<div id="screen_colors_list" class="list-colors"></div>
			</div>
		</div>
		<div class="screen_colors_botton">
			<button type="button" class="btn btn-primary" onclick="design.item.setColor()"><?php echo $lang['designer_color_choose_colors']; ?></button>
		</div>
	</div>
</div>
			
<div id="dg-modal">
	<!-- Begin product info -->
	<div class="modal fade" id="modal-product-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<div class="products-detail col-sm-12">
						<div class="product-detail">
							<div class="row text-right">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							</div>
							<div class="row">
								<div class="col-xs-6 col-md-6">
									<img src="<?php echo base_url($product->image); ?>" class="img-responsive img-thumbnail product-detail-image" alt="<?php echo $product->title; ?>" />
								</div>
								<div class="col-xs-6 col-md-6">
									<h3 class="margin-top product-detail-title"><?php echo $product->title; ?></h3>
									<p><?php echo $lang['designer_product_id']; ?>: <strong class="product-detail-id"><?php echo $product->id; ?></strong></p>
									<p><?php echo $lang['designer_product_sku']; ?>: <strong class="product-detail-sku"><?php echo $product->sku; ?></strong></p>
									<p class="product-detail-short_description"><?php echo $product->short_description; ?></p>
								</div>
							</div>
							<div class="row col-sm-12">
								<h4><?php echo $lang['designer_product_description']; ?></h4>										
								<div class="product-detail-description"><?php echo $product->description; ?></div>
							</div>								
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End product info -->
	
	<!-- Begin product size -->
	<div class="modal fade" id="modal-product-size" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<div class="text-right clearfix">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="row">
						<div class="col-md-12 product-detail-size">
							<?php echo $product->size; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End product info -->
	
	<!-- Begin Login -->
	<div class="modal fade" id="f-login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div id="f-login-content" class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel"><?php echo $lang['designer_user_login_now_or_sign_up']; ?></h4>
		  </div>
		  <div class="modal-body">
			<div class="row">
				<!-- login form -->
				<div class="col-md-6">
					<h3><?php echo $lang['designer_user_login']; ?></h3>
					<form id="fr-login" role="form" style="margin-bottom: 5px;">						  						 
					  <div class="form-group">
						<label><?php echo $lang['designer_user_your_email']; ?>:</label>
						<input type="text" name="data[email]" id="login-email" class="form-control input-sm validate required" data-msg="<?php echo $lang['designer_user_email_validate_msg']; ?>" data-type="email" placeholder="<?php echo $lang['designer_user_your_email']; ?>">
					  </div>
					  <div class="form-group">
						<label><?php echo $lang['designer_user_your_password']; ?>:</label>
						<input type="password" name="data[password]" id="login-password" class="form-control input-sm validate required" data-msg="<?php echo $lang['designer_user_password_validate_msg']; ?>" data-maxlength="32" data-minlength="6" placeholder="<?php echo $lang['designer_user_your_password']; ?>">
					  </div>
					  <a href="javascript:void(0)" title="" class="btn btn-default btn-primary" onclick="facebook_login()">
						<span class="login-facebook"></span>
						<?php echo $lang['designer_user_login_with_facebook']; ?>
					  </a>
					  <button type="button" onclick="login(this)" autocomplete="off" class="btn btn-default btn-warning" data-loading-text="Loading"><?php echo $lang['designer_user_login_btn']; ?></button> 
					  <?php echo $this->auth->getToken(); ?>
					  <input type="hidden" name="ajax" value="1">
					</form>
					
					<a id="click_forgot" href="javascript:void(0)"><?php echo $lang['designer_user_i_forgot_password']; ?></a>
				</div>
				
				<!-- create account -->
				<div class="col-md-6">
					<h3><?php echo $lang['designer_user_create_account']; ?></h3>
					<form id="fr-register" role="form">						 
					  <div class="form-group">
						<label><?php echo $lang['designer_user_username']; ?>:</label>
						<input type="text" name="data[username]" id="create_username" class="form-control input-sm validate required" data-msg="<?php echo $lang['designer_user_username_validate_msg']; ?>" data-maxlength="200" data-minlength="2" placeholder="<?php echo $lang['designer_user_username']; ?>">
					  </div>
					  <div class="form-group">
						<label><?php echo $lang['designer_user_email_address']; ?>:</label>
						<input type="email" name="data[email]" class="form-control input-sm validate required" id="create_email" data-msg="<?php echo $lang['designer_user_email_validate_msg']; ?>" data-type="email" placeholder="<?php echo $lang['designer_user_enter_email']; ?>">
					  </div>
					  <div class="form-group">
						<label><?php echo $lang['designer_user_password']; ?>:</label>
						<input type="password" class="form-control input-sm validate required" name="data[password]" id="create_password" data-msg="<?php echo $lang['designer_user_password_validate_msg']; ?>" data-maxlength="32" data-minlength="6" placeholder="<?php echo $lang['designer_user_password']; ?>">
					  </div>						  						 
					  <button type="button" onclick="login('register')" autocomplete="off" data-loading-text="<?php echo $lang['designer_user_login']; ?>Loading" class="btn btn-default btn-primary"><?php echo $lang['designer_user_register_btn']; ?></button>
						<?php echo $this->auth->getToken(); ?>
						<input type="hidden" name="ajax" value="1">
					</form>
				</div>
			</div>
		  </div>			 
		</div>
	  </div>
	  
	  <div id="f-forgot-content" class="modal-dialog" style="display:none">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel"><?php echo $lang['designer_user_forgot_password']; ?></h4>
		  </div>
		  <div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<form id="fr-forgot" role="form" style="margin-bottom: 5px;">						  						 
							<div class="form-group" style="display: table; width: 100%;">
								<label class="col-md-4"><?php echo $lang['designer_user_your_email']; ?>:</label>
								<div class="col-md-6">
									<input type="text" name="email" id="forgot-email" class="form-control input-sm validate required" data-msg="<?php echo $lang['designer_user_email_validate_msg']; ?>" data-type="email" placeholder="<?php echo $lang['designer_user_your_email']; ?>">
								</div>
							</div>
							<div class="form-group" style="display: table; width: 100%;">
								<label class="col-md-4"><?php echo $lang['designer_user_new_password']; ?>:</label>
								<div class="col-md-6">
									<input type="password" class="form-control input-sm validate required" name="forgot-password" id="forgot-password" data-msg="<?php echo $lang['designer_user_new_password_validate_msg']; ?>" data-maxlength="32" data-minlength="6" placeholder="<?php echo $lang['designer_user_new_password']; ?>">
								</div>	
							</div>	
							<div class="form-group" style="display: table; width: 100%;"> 
								<label class="col-md-4"><?php echo $lang['designer_user_confirm_new_password']; ?>:</label>
								<div class="col-md-6">
									<input type="password" class="form-control input-sm validate required" name="forgot-cfpassword" id="forgot-cfpassword" data-msg="<?php echo $lang['designer_user_confirm_new_password_validate_msg']; ?>" data-maxlength="32" data-minlength="6" placeholder="<?php echo $lang['designer_user_confirm_new_password']; ?>">
								</div>	
							</div>
							<div class="form-group" style="display: table; width: 100%;">
								<label class="col-md-4"></label>
								<div class="col-md-6">
									<button type="button" data-loading-text="Loading" id="forgot-button" class="btn btn-default btn-warning" data-loading-text="<?php echo $lang['designer_loading_btn']; ?>"><?php echo $lang['designer_user_send_btn']; ?></button>
									<a style="margin-left: 5px;" id="click_login" href="javascript:void(0)"><?php echo $lang['designer_user_login_or_register']; ?></a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		  </div>			 
		</div>
	  </div>
	</div>
	<!-- End Login -->
	
	<!-- Begin products -->
	<div class="modal fade" id="dg-products" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<div class="row">							
						<div class="col-sm-11" id="list-categories">
							<?php if ( count ($product->categories) ) { ?>
							<div class="col-xs-4 col-md-3">
								<select data-level="1" id="parent-categories-1" class="form-control input-sm" onchange="design.products.changeCategory(this)">
									<option value="0"> - <?php echo $lang['designer_product_select_category']; ?> - </option>
									<?php 
									foreach ($product->categories as $category) { 
									if ($category->parent_id > 0) continue;
									?>
									<option value="<?php echo $category->id; ?>"><?php echo $category->title; ?></option>
									<?php } ?>
									
								</select>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<div class="row">
						<!-- list product category -->
						<div class="product-list col-sm-12">
						</div>
						
						<!-- product detail -->
						<div class="products-detail col-sm-12">
							<button type="button" class="btn btn-danger btn-sm" id="close-product-detail">Close</button>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang['designer_close_btn']; ?></button>
					<button type="button" class="btn btn-primary" id="loading-change-product" data-loading-text="<?php echo $lang['designer_loading_btn']; ?>..." onclick="design.products.changeDesign(this)"><?php echo $lang['designer_product_change_product']; ?></button>
				</div>
			</div>
		</div>
	</div>
	<!-- End products -->
	
	<!-- Begin clipart -->
	<div class="modal fade" id="dg-cliparts" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header" style="overflow: hidden;">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<div class="col-xs-4 col-md-3">
						<h4 class="modal-title"><?php echo lang('design_art_select'); ?></h4>
					</div>
					<div class="col-xs-7 col-md-4">
						<div class="input-group">
						  <input type="text" id="art-keyword" autocomplete="off" class="form-control input-sm" placeholder="Search for...">
						  <span class="input-group-btn">
							<button class="btn btn-default btn-sm" onclick="design.designer.art.arts(0)" type="button">Search</button>
						  </span>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<div class="row align-center">
						<div id="dag-art-panel">
							<a href="javascript:void(0)" title="Click to show categories">
								<?php echo $lang['designer_clipart_shop_library']; ?> <span class="caret"></span>
							</a>
							<a href="javascript:void(0)" title="Click to show categories">
								<?php echo $lang['designer_clipart_store_design']; ?> <span class="caret"></span>
							</a>
						</div>
					</div>						
					
					<div class="row">
						<div id="dag-art-categories" class="row col-xs-4 col-md-3"></div>
						<div class="col-xs-8 col-md-9">
							<div id="dag-list-arts"></div>
							<div id="dag-art-detail">
								<button type="button" class="btn btn-danger btn-xs"><?php echo $lang['designer_close_btn']; ?></button>
							</div>
						</div>								
					</div>
				</div>
				
				<div class="modal-footer">
					<div class="align-right" id="arts-pagination" style="display:none">
						<ul class="pagination">
							<li><a href="javascript:void(0)">&laquo;</a></li>
							<li class="active"><a href="javascript:void(0)">1</a></li>
							<li><a href="javascript:void(0)">2</a></li>
							<li><a href="javascript:void(0)">3</a></li>
							<li><a href="javascript:void(0)">4</a></li>
							<li><a href="javascript:void(0)">5</a></li>
							<li><a href="javascript:void(0)">&raquo;</a></li>
						</ul>
						<input type="hidden" value="0" autocomplete="off" id="art-number-page">
					</div>
					<div class="align-right" id="arts-add" style="display:none">
						<div class="art-detail-price"></div>
						<button type="button" class="btn btn-primary"><?php echo $lang['designer_add_design_btn']; ?></button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End clipart -->
	
	<!-- Begin Upload -->
	<div class="modal fade" id="dg-myclipart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
					<ul role="tablist" id="upload-tabs">
						<li class="active"><a href="#upload-conputer" role="tab" data-toggle="tab"><?php echo $lang['designer_upload_upload_photo']; ?></a></li>
						<!--<li><a href="#upload-facebook" role="tab" data-toggle="tab">Facebook</a></li>-->
						<li><a href="#uploaded-art" role="tab" data-toggle="tab"><?php echo $lang['designer_upload_photo_uploaded']; ?></a></li>
						<!--
						<li><a href="#upload-instagram" role="tab" data-toggle="tab"><i class="fa fa-instagram"></i> Instagram</a></li>
						<li><a href="#upload-facebook" role="tab" data-toggle="tab"><i class="fa fa-flickr"></i> Flickr</a></li>
						-->
					</ul>
				</div>
				<div class="modal-body">
					<div class="tab-content">
						<div class="tab-pane active" id="upload-conputer">
							<div class="row">
								<div class="col-xs-6 col-md-6">
									<div class="form-group">
										<label><?php echo $lang['designer_upload_choose_a_file_upload']; ?></label>
										<input type="file" id="files-upload" autocomplete="off"/>											
									</div>
									
									<div class="checkbox" style="display:none;">
										<label>
										  <input type="checkbox" autocomplete="off" id="remove-bg"> <span class="help-block"><?php echo $lang['designer_upload_remove_white_background']; ?></span>
										</label>
									</div>
								</div>
								
								<div class="col-xs-6 col-md-6">
									<div class="form-group">
										<label><strong><?php echo $lang['designer_upload_accepted_file_types']; ?></strong> <small>(<?php echo $lang['designer_upload_max_file_size']; ?>: <?php echo settingValue($setting, 'site_upload_max', '0.5'); ?>MB)</small></label>
										<p><?php echo $lang['designer_upload_accept_the_following']; ?>: <strong>PNG, JPG, GIF</strong></p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="checkbox">
										<label>
										  <input type="checkbox" autocomplete="off" id="upload-copyright"> <span class="help-block"><?php echo $lang['designer_upload_please_read']; ?> <a href="<?php echo settingValue($setting, 'site_upload_terms', '#'); ?>" target="_blank"><?php echo $lang['designer_upload_copyright_terms']; ?></a>. <?php echo $lang['designer_upload_if_you_do_not_have_the_complete']; ?></span>
										</label>
									</div>
									<div class="form-group">
										<button type="button" class="btn btn-primary" id="action-upload"><?php echo $lang['designer_upload_upload_btn']; ?></button>
									</div>
								</div>
							</div>
						</div>
						
						<div class="tab-pane" id="upload-facebook">
							<?php echo $lang['designer_upload_facebook']; ?>
						</div>
						<div class="tab-pane" id="uploaded-art">
							<div class="row" id="dag-files-images">
							</div>
							
							<div id="drop-area"></div>
							<div class="row col-md-12">
								<span class="help-block"><?php echo $lang['designer_upload_click_image_to_add_design']; ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Upload -->
	
	<!-- Begin Note -->
	<div class="modal fade" id="dg-note" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel"><?php echo $lang['designer_note_add_note']; ?></h4>
				</div>
				<div class="modal-body">
				...
				</div>
			</div>
		</div>
	</div>
	<!-- End Note -->
	
	<!-- Begin Help -->
	<div class="modal fade" id="dg-help" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel"><?php echo $lang['designer_help_designer_help']; ?></h4>
				</div>
				<div class="modal-body">
					<p><?php echo $lang['designer_help_online_designer_allows_you_to']; ?></p>
					<ul>
					  <li><?php echo $lang['designer_help_upload_images']; ?></li>
					  <li><?php echo $lang['designer_help_create']; ?></li>
					  <li><?php echo $lang['designer_help_mix_design']; ?></li>						  
					</ul>
					
					<div id="help-tabs">
						<ul>
							<li><a href="help/product.html"><?php echo $lang['designer_help_product_design']; ?></a></li>
							<li><a href="help/text.html"><?php echo $lang['designer_help_add_text']; ?></a></li>
							<li><a href="help/art.html"><?php echo $lang['designer_help_add_art']; ?></a></li>
							<li><a href="help/upload.html"><?php echo $lang['designer_help_upload']; ?></a></li>
							<li><a href="help/design_idea.html"><?php echo $lang['designer_help_designer_idea']; ?></a></li>
							<li><a href="help/tool.html"><?php echo $lang['designer_help_tools']; ?></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Help -->
	
	<!-- Begin My design -->
	<div class="modal fade" id="dg-mydesign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel"><?php echo $lang['designer_my_design']; ?></h4>
				</div>
				<div class="modal-body">
				...
				</div>
			</div>
		</div>
	</div>
	<!-- End my design -->
	
	<!-- Begin design ideas -->
	<div class="modal fade" id="dg-designidea" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel"><?php echo $lang['designer_design_ideas']; ?></h4>
				</div>
				<div class="modal-body">
				...
				</div>
			</div>
		</div>
	</div>
	<!-- End design ideas -->	
	
	<!-- Begin team -->
	<div class="modal fade" id="dg-item_team_list" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel"><?php echo $lang['designer_team_enter_name']; ?></h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="alert alert-danger fade in col-md-8" id="team_msg_error" style="display: none;"></div>
						<button class="btn btn-primary input-sm pull-right" onclick="design.team.addMember()" type="button"><?php echo $lang['designer_team_add_team_member_btn']; ?></button>
					</div>
					<div class="row">
						<div class="col-md-12 table-box-team-list">
							<table class="table" id="table-team-list">
						<thead>
							<tr>
								<th width="5%"><?php echo $lang['designer_team_order']; ?></th>
								<th width="40%"><?php echo $lang['designer_team_name']; ?></th>
								<th width="25%"><?php echo $lang['designer_team_number']; ?></th>
								<th width="20%"><?php echo $lang['designer_team_size']; ?></th>
								<th width="10%"><?php echo $lang['designer_team_remove']; ?></th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang['designer_close_btn']; ?></button>
					<button type="button" class="btn btn-primary" onclick="design.team.save()"><?php echo $lang['designer_save_btn']; ?></button>
				</div>
			</div>
		</div>
	</div>
	<!-- End design ideas -->			
	
	<!-- Begin fonts -->
	<div class="modal fade" id="dg-fonts" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>						
					<div class="btn-group">
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							<?php echo $lang['designer_fonts_font_categories']; ?> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu font-categories" role="menu"></ul>
					</div>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12 list-fonts"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End fonts -->
	
	<!-- Begin preview -->
	<div class="modal fade" id="dg-preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>						
				</div>
				<div class="modal-body" id="dg-main-slider">					
				</div>
			</div>
		</div>
	</div>
	<!-- End preview -->
	
	<!-- Begin Share -->
	<div class="modal fade" id="dg-share" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>						
					<h4><?php echo $lang['designer_share_save_completed']; ?></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="exampleInputEmail1"><?php echo $lang['designer_share_your_design_link']; ?>:</label>
						<input type="text" class="form-control" id="link-design-saved" value="" readonly>
					</div>
					
					<div class="form-group row">
						<label class="col-md-1" style="line-height: 24px;"><?php echo $lang['designer_share']; ?>: </label>
						<div class="col-md-1">
							<a href="javascript:void(0)" onclick="design.share.email()" class="icon-25 share-email" title="Email"></a>
						</div>
						<div class="col-md-1">
							<a href="javascript:void(0)" onclick="design.share.facebook()" class="icon-25 share-facebook" title="Facebook"></a> 
						</div>
						<div class="col-md-1">
							<a href="javascript:void(0)" onclick="design.share.twitter()" class="icon-25 share-twitter" title="Twitter"></a>
						</div>
						<div class="col-md-1">
							<a href="javascript:void(0)" onclick="design.share.pinterest()" class="icon-25 share-pinterest" title="Pinterest"></a> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Share -->
</div>

<div class="popover right" id="dg-popover">
		<div class="arrow"></div>
		<h3 class="popover-title"><span><?php echo $lang['designer_clipart_edit_size_position']; ?></span> <a href="javascript:void(0)" class="popover-close"><i class="glyphicons remove_2 glyphicons-12 pull-right"></i></a></h3>
		<div class="popover-content">
		
			<!-- BEGIN clipart edit options -->
			<div id="options-add_item_clipart" class="dg-options">
				<div class="dg-options-toolbar">
					<div aria-label="First group" role="group" class="btn-group btn-group-lg">						
						<button class="btn btn-default btn-action-edit" type="button" data-type="edit">
							<i class="glyphicon glyphicon-tint"></i> <small class="clearfix">Edit</small>
						</button>
						<button class="btn btn-default btn-action-colors" type="button" data-type="colors">
							<i class="glyphicon glyphicon-tint"></i> <small class="clearfix">Colors</small>
						</button>
						<button class="btn btn-default" type="button" data-type="size">
							<i class="fa fa-text-height"></i> <small class="clearfix">Size</small>
						</button>
						<button class="btn btn-default" type="button" data-type="rotate">
							<i class="fa fa-rotate-right"></i> <small class="clearfix">Rotate</small>
						</button>
						<button class="btn btn-default" type="button" data-type="functions">
							<i class="fa fa-cogs"></i> <small class="clearfix">Functions</small>
						</button>
					</div>
				</div>
				
				<div class="dg-options-content">
					<div class="row toolbar-action-edit">					
						<div id="item-print-colors">
						</div>
					</div>
					<div class="row toolbar-action-size">
						<div class="col-xs-3 col-lg-3 align-center">
							<div class="form-group">
								<small><?php echo $lang['designer_clipart_edit_width']; ?></small>
								<input type="text" size="2" id="clipart-width" readonly disabled>
							</div>
						</div>
						<div class="col-xs-3 col-lg-3 align-center">
							<div class="form-group">
								<small><?php echo $lang['designer_clipart_edit_height']; ?></small>
								<input type="text" size="2" id="clipart-height" readonly disabled>
							</div>
						</div>
						<div class="col-xs-6 col-lg-6 align-left">
							<div class="form-group">
								<small><?php echo $lang['designer_clipart_edit_unlock_proportion']; ?></small><br />
								<input type="checkbox" class="ui-lock" id="clipart-lock" />
							</div>
						</div>
					</div>
					
					<div class="row toolbar-action-rotate">					
						<div class="form-group col-lg-12">
							<div class="row">
								<div class="col-xs-6 col-lg-6">
									<small><?php echo $lang['designer_clipart_edit_rotate']; ?></small>
								</div>
								<div class="col-xs-6 col-lg-6 align-right">
									<span class="rotate-values"><input type="text" value="0" class="input-small rotate-value" id="clipart-rotate-value" />&deg;</span>
									<span class="rotate-refresh glyphicons refresh"></span>
								</div>
							</div>						
						</div>
					</div>
					
					<div class="row toolbar-action-colors">
						<div id="clipart-colors">
							<div class="form-group col-lg-12 text-left position-static">
								<small><?php echo $lang['designer_clipart_edit_choose_your_color']; ?></small>
								<div id="list-clipart-colors" class="list-colors"></div>
							</div>
						</div>
					</div>
					
					<div class="row toolbar-action-functions">	
						<div class="col-lg-12 form-group">
							<span class="btn btn-default btn-xs" onclick="design.item.flip('x')">
								<i class="glyphicons transfer glyphicons-12"></i>
								 <?php echo $lang['designer_clipart_edit_flip']; ?>
							</span>							
							<span class="btn btn-default btn-xs" onclick="design.item.center()">
								<i class="glyphicons align_center glyphicons-12"></i>
								 <?php echo $lang['designer_clipart_edit_center']; ?>
							</span>
						</div>
					</div>
				</div>
			</div>
			<!-- END clipart edit options -->
			
			<!-- BEGIN Text edit options -->
			<div id="options-add_item_text" class="dg-options">
				<div class="dg-options-toolbar">
					<div aria-label="First group" role="group" class="btn-group btn-group-lg">
						<button class="btn btn-default" type="button" data-type="text">
							<i class="fa fa-pencil"></i> <small class="clearfix">Text</small>
						</button>
						<button class="btn btn-default" type="button" data-type="fonts">
							<i class="fa fa-font"></i> <small class="clearfix">Fonts</small>
						</button>
						<button class="btn btn-default" type="button" data-type="style">
							<i class="fa fa-align-justify"></i> <small class="clearfix">Style</small>
						</button>
						<button class="btn btn-default" type="button" data-type="outline">
							<i class="fa fa-crop"></i> <small class="clearfix">Outline</small>
						</button>
						<button class="btn btn-default" type="button" data-type="size">
							<i class="fa fa-text-height"></i> <small class="clearfix">Size</small>
						</button>
						<button class="btn btn-default" type="button" data-type="rotate">
							<i class="fa fa-rotate-right"></i> <small class="clearfix">Rotate</small>
						</button>
						<button class="btn btn-default" type="button" data-type="functions">
							<i class="fa fa-cogs"></i> <small class="clearfix">Functions</small>
						</button>
					</div>
				</div>
				
				<div class="dg-options-content">
					<!-- edit text -->
					<div class="row toolbar-action-text">
						<div class="col-xs-12">
							<textarea class="form-control text-update" data-event="keyup" data-label="text" id="enter-text"></textarea>
						</div>
					</div>
					
					<div class="row toolbar-action-fonts">
						<div class="col-xs-8">
							<div class="form-group">
								<small><?php echo $lang['designer_clipart_edit_choose_a_font']; ?></small>
								<div class="dropdown" data-target="#dg-fonts" data-toggle="modal">
									<a id="txt-fontfamily" class="pull-left" href="javascript:void(0)">
									<?php echo $lang['designer_clipart_edit_arial']; ?>
									</a>
									<span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s pull-right"></span>
								</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<small><?php echo $lang['designer_clipart_edit_text_color']; ?></small>
								<div class="list-colors">
									<a class="dropdown-color" id="txt-color" title="Click to change color" href="javascript:void(0)" data-color="black" data-label="color" style="background-color:black">
										<span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"></span>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="clear-line"></div>
					<div class="clear"></div>
					
					<div class="row toolbar-action-style">
						<div class="col-xs-6">
							<small><?php echo $lang['designer_clipart_edit_text_style']; ?></small>
							<div id="text-style">
								<span id="text-style-i" class="text-update btn btn-default btn-xs glyphicons italic glyphicons-12" data-event="click" data-label="styleI"></span>
								<span id="text-style-b" class="text-update btn btn-default btn-xs glyphicons bold glyphicons-12" data-event="click" data-label="styleB"></span>							
								<span id="text-style-u" class="text-update btn btn-default btn-xs glyphicons text_underline glyphicons-12" data-event="click" data-label="styleU"></span>
							</div>
						</div>
						<div class="col-xs-6">
							<small><?php echo $lang['designer_clipart_edit_text_align']; ?></small>
							<div id="text-align">
								<span id="text-align-left" class="text-update btn btn-default btn-xs glyphicons align_left glyphicons-12" data-event="click" data-label="alignL"></span>
								<span id="text-align-center" class="text-update btn btn-default btn-xs glyphicons align_center glyphicons-12" data-event="click" data-label="alignC"></span>
								<span id="text-align-right" class="text-update btn btn-default btn-xs glyphicons align_right glyphicons-12" data-event="click" data-label="alignR"></span>
							</div>
						</div>
					</div>
					
					<div class="clear"></div>
					
					<div class="row toolbar-action-outline">
						<!--
						<div class="col-xs-6">
							<small>Text Options</small>
							<div id="text-shape">
								<div class="dropdown">
									<a href="#" class="pull-left" data-toggle="dropdown">
									Normal <i class="caret"></i>
									</a>								
									<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
										<li><span class="text-update" data-label="wspacing" data-event="click">Word Spacing</span></li>
										<li><span class="text-update" data-label="style" data-value="letter-spacing:2" data-event="click">Letter Spacing</span></li>									
									</ul>
								</div>
							</div>
						</div>
						-->
						<div class="col-xs-6">
							<small><?php echo $lang['designer_clipart_edit_out_line']; ?></small>
							<div class="option-outline">							
								<div class="list-colors">
									<a class="dropdown-color bg-none" data-label="outline" data-placement="top" data-original-title="Click to change color" href="javascript:void(0)" data-color="none">
										<span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"></span>
									</a>
								</div>
								<div class="dropdown-outline">
									<a data-toggle="dropdown" class="dg-outline-value" href="javascript:void(0)"><span class="outline-value pull-left">0</span> <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s pull-right"></span></a>
									<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
										<li><div id="dg-outline-width"></div></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row" style="display:none;">
						<div class="col-lg-12">
							<small><?php echo $lang['designer_clipart_edit_adjust_shape']; ?></small>
							<div id="dg-shape-width"></div>
						</div>
					</div>
									
					<div class="clear"></div>
					
					<div class="row toolbar-action-size">
						<div class="col-xs-3 col-lg-3 align-center">
							<div class="form-group">
								<small><?php echo $lang['designer_clipart_edit_width']; ?></small>
								<input type="text" size="2" id="text-width" readonly disabled>
							</div>
						</div>
						<div class="col-xs-3 col-lg-3 align-center">
							<div class="form-group">
								<small><?php echo $lang['designer_clipart_edit_height']; ?></small>
								<input type="text" size="2" id="text-height" readonly disabled>
							</div>
						</div>
						<div class="col-xs-6 col-lg-6 align-left">
							<div class="form-group">
								<small><?php echo $lang['designer_clipart_edit_unlock_proportion']; ?></small><br />
								<input type="checkbox" class="ui-lock" id="text-lock" />
							</div>
						</div>
					</div>
					
					<div class="row toolbar-action-rotate">					
						<div class="form-group col-lg-12">
							<div class="row">
								<div class="col-xs-6 col-lg-6">
									<small><?php echo $lang['designer_clipart_edit_rotate']; ?></small>
								</div>
								<div class="col-xs-6 col-lg-6 align-right">
									<span class="rotate-values"><input type="text" value="0" class="input-small rotate-value" id="text-rotate-value" />&deg;</span>
									<span class="rotate-refresh glyphicons refresh"></span>
								</div>
							</div>						
						</div>
					</div>
					
					<div class="row toolbar-action-functions">	
						<div class="col-lg-12">
							<span class="btn btn-default btn-xs" onclick="design.item.flip('x')">
								<i class="glyphicons transfer glyphicons-12"></i>
								<?php echo $lang['designer_clipart_edit_flip']; ?>
							</span>
							<span class="btn btn-default btn-xs" onclick="design.item.center()">
								<i class="glyphicons align_center glyphicons-12"></i>
								<?php echo $lang['designer_clipart_edit_center']; ?>
							</span>
						</div>
					</div>
				</div>
			</div>
			<!-- END clipart edit options -->
			
			<!-- BEGIN team edit options -->
			<div id="options-add_item_team" class="dg-options">
				<div class="dg-options-toolbar">
					<div aria-label="First group" role="group" class="btn-group btn-group-lg">
						<button class="btn btn-default" type="button" data-type="name-number">
							<i class="glyphicons soccer_ball glyphicons-small"></i> <small class="clearfix">Add Name</small>
						</button>
						<button class="btn btn-default" type="button" data-type="teams">
							<i class="fa fa-users"></i> <small class="clearfix">Teams</small>
						</button>
						<button class="btn btn-default" type="button" data-type="add-list">
							<i class="fa fa-user"></i> <small class="clearfix">Add Team</small>
						</button>						
					</div>
				</div>
				
				<div class="dg-options-content">
					<input type="hidden" id="team-height" value="">
					<input type="hidden" id="team-width" value="">
					<input type="hidden" id="team-rotate-value" value="0">
					<div class="row toolbar-action-name-number">
						<div class="col-md-12 position-static">
							<div class="checkbox">
								<label>
									<input type="checkbox" id="team_add_name" onclick="design.team.addName(this)" autocomplete="off"> <strong><?php echo $lang['designer_clipart_edit_add_name']; ?></strong>
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" id="team_add_number" onclick="design.team.addNumber(this)" autocomplete="off"> <strong><?php echo $lang['designer_clipart_edit_add_number']; ?></strong>
								</label>
							</div>
							
							<div class="form-group row">
								<div class="col-xs-3 col-md-3 position-static">
									<div class="list-colors">
										<a class="dropdown-color" id="team-name-color" data-placement="right" title="Click to change color" href="javascript:void(0)" data-color="000000" data-label="colorT" style="background-color:black">
											<span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"></span>
										</a>
									</div>
								</div>
								<div class="col-xs-9 col-md-9">
									<div data-toggle="modal" data-target="#dg-fonts" class="dropdown">
										<a href="javascript:void(0)" class="pull-left" id="txt-team-fontfamly"><?php echo $lang['designer_clipart_edit_arial']; ?></a>
										<span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s pull-right"></span>
									</div>
								</div>
							</div>
						</div>
					</div>					
					
					<div class="row toolbar-action-teams">
						<div class="col-md-12">
							<span class="help-block">
								<?php echo $lang['designer_clipart_edit_enter_your_full_list']; ?>
							</span>
						</div>
						
						<div class="col-md-12">
							<div class="clear-line"></div><br>
						</div>
						
						<div class="col-md-12 div-box-team-list">
							<table id="item_team_list" class="table table-bordered">
								<thead>
									<tr>
										<td width="70%"><strong><?php echo $lang['designer_clipart_edit_name']; ?></strong></td>
										<td width="10%"><strong><?php echo $lang['designer_clipart_edit_number']; ?></strong></td>
										<td width="20%"><strong><?php echo $lang['designer_clipart_edit_size']; ?></strong></td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td align="left"> </td>
										<td align="center"> </td>
										<td align="center"> </td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="clear-line"></div><br>
					<div class="row toolbar-action-add-list">
						<div class="col-md-12">
							<center><button class="btn btn-primary input-sm" data-target="#dg-item_team_list" data-toggle="modal" type="button"><?php echo $lang['designer_clipart_edit_add_list_name']; ?></button><center>
						</div>
					</div>
				</div>
			</div>
			<!-- END team edit options -->
		</div>
    </div>
	
	<!-- BEGIN colors system -->
	<div class="o-colors" style="display:none;">		
		<div class="other-colors"></div>
	</div>
	<!-- END colors system -->
	
	
	<div id="cacheText"></div>
	
	<?php if (isset($product->design)) {?>
	<script type="text/javascript">
		var min_order = '<?php echo $product->min_order; ?>';
		var product_id = '<?php echo $product->id; ?>';
		var print_type = '<?php echo $product->print_type; ?>';
		var uploadSize = [];
		uploadSize['max']  = '<?php echo settingValue($setting, 'site_upload_max', '10'); ?>';
		uploadSize['min']  = '<?php echo settingValue($setting, 'site_upload_min', '0.5'); ?>';
		var items = {};
		items['design'] = {};
		<?php 
		$js = '';
		$elment = count($product->design->color_hex);
		for($i=0; $i<$elment; $i++)
		{			
			$js .= "items['design'][$i] = {};";
			$js .= "items['design'][$i]['color'] = \"".$product->design->color_hex[$i]."\";";
			$js .= "items['design'][$i]['title'] = \"".$product->design->color_title[$i]."\";";
			$postions	= array('front', 'back', 'left', 'right');
			foreach ($postions as $v)
			{
				$view = $product->design->$v;				
				if (count($view) > 0) 
				{
					if (isset($view[$i]) == true)
					{
						$item = (string) $view[$i];						
						$js .= "items['design'][".$i."]['".$v."']=\"".$item."\";";						
					}
					else
					{
						$js .= "items['design'][$i]['$v'] = '';";
					}
				}
				else
				{
					$js .= "items['design'][$i]['$v'] = '';";
				}				
			}
		}
		echo $js;
		?>
		items['area']	= {};
		items['area']['front'] 	= "<?php echo $product->design->area->front; ?>";
		items['area']['back'] 	= "<?php echo $product->design->area->back; ?>";
		items['area']['left'] 	= "<?php echo $product->design->area->left; ?>";
		items['area']['right']	= "<?php echo $product->design->area->right; ?>";		
		items['params']	= [];		
		items['params']['front']	= "<?php echo $product->design->params->front; ?>";		
		items['params']['back']	= "<?php echo $product->design->params->back; ?>";		
		items['params']['left']	= "<?php echo $product->design->params->left; ?>";		
		items['params']['right']	= "<?php echo $product->design->params->right; ?>";		
	</script>
	<?php } ?>
	
	<!-- BEGIN: popup cart -->
	<div class="modal fade" id="cart_notice" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			</div>
			<div class="modal-body">        
				<h5><strong><?php echo $lang['cart_mgs']; ?></strong></h5>
				<div class="row">
					<div class="col-md-5 cart-added-img"></div>
					<div class="col-md-7 cart-added-info"></div>
				</div>
				<div class="row cart-button">
					<div class="col-md-6 pull-left text-left">
						<button type="button" class="btn btn-default input-sm" data-dismiss="modal"><?php echo $lang['continue_design']; ?></button>
					</div>
					<div class="col-md-6 pull-right text-right">
						<a href="<?php echo site_url('cart'); ?>" class="btn btn-primary input-sm"><?php echo $lang['checkout']; ?></a>
					</div>
				</div>
			</div>
		</div>
	  </div>
	</div>	
	<!--end-->
	
	<div id="save-confirm" title="Save Your Design" style="display:none;">
		<p>You have a saved design. Do you want to replace it or enter a new design?</p>
	</div>

	<!--end-->
	<!--facebook-->
	<div id="id_login"></div>
	<script src="http://connect.facebook.net/en_US/all.js"></script>
	<!--End facebook-->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/design_upload.js"></script>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		<?php if( (string)$color  !== '0' ){ ?>
		design.imports.productColor('<?php echo (string)$color; ?>');
		<?php } ?>
		
		<?php if( $design_id  != '' ){ ?>
		design.imports.loadDesign('<?php echo $design_id; ?>');
		<?php } ?>
	});
		
	//Minh.js
	<?php $settings = getSettings(); ?>
	window.fbAsyncInit = function() {
		FB.init({
		  appId      : '<?php if(isset($settings->app_id))echo $settings->app_id;?>', // App ID
		  status     : true, // check login status
		  cookie     : true, // enable cookies to allow the server to access the session
		  xfbml      : true  // parse XFBML
		});
	}
	
	function facebook_login(){
		FB.login(function(response) {
			if (response.authResponse) 
			{
				FB.api('/me', function(response) {
					var email_address = response.email;
					if(email_address != '')
					{
						login('facebook');
					}
				});
			}
			else
			{
				console.log('User cancelled login or did not fully authorize.');
			}
		},{scope:'email,user_photos'});
		return false;
	};
	
	<?php if(isset($this->session->userdata('user')->status) && $this->session->userdata('user')->status == 1){ ?>
		jQuery('document').ready(function(){
			login('logged');
		});
	<?php }else{ ?>
		jQuery('.menu-top').children('ul').show();
	<?php } ?>
	
	<?php if($this->session->flashdata('msg') != ''){?>
		alert('<?php echo $this->session->flashdata('msg');?>');
	<?php } ?>
	</script>
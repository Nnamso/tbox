<?php 
	$CI =& get_instance();
	$segments = $CI->uri->segment_array();
?>
<div class="navbar-content">
	<!-- start: SIDEBAR -->
	<div class="main-navigation navbar-collapse collapse">
		<!-- start: MAIN MENU TOGGLER BUTTON -->
		<a class="main_left_visit_shop" style="float: left; margin: 15px 0px 0px 15px; font-weight: bold;" href="<?php echo site_url(); ?>" target="_blank">Visit Shop</a>
		<div class="navigation-toggler">
			<i class="clip-chevron-left"></i>
			<i class="clip-chevron-right"></i>
		</div>
		<!-- end: MAIN MENU TOGGLER BUTTON -->
		<!-- start: MAIN NAVIGATION MENU -->
		<ul class="main-navigation-menu">
			<li <?php if($segments[2] == 'dashboard' || $segments[2] == '') echo 'class="active open"' ?>>
				<a href="<?php echo site_url("admin/dashboard"); ?>"><i class="clip-home-3"></i>
					<span class="title"> <?php echo lang('menu_left_dashboard'); ?> </span><span class="selected"></span>
				</a>
			</li>
			<li <?php if($segments[2] == 'products') echo 'class="active open"' ?>>
				<a href="javascript:void(0)"><i class="clip-t-shirt"></i>
					<span class="title"> <?php echo lang('menu_left_products'); ?> </span><i class="icon-arrow"></i>
					<span class="selected"></span>
				</a>
				<ul class="sub-menu">
					<li <?php if((isset($segments[3]) && $segments[3] == 'index' && $segments[2] == 'products') || (empty($segments[3]) && $segments[2] == 'products')) echo 'class="open"'?>>
						<a href="<?php echo site_url("admin/products"); ?>">
							<span class="title"> <?php echo lang('menu_left_products'); ?> </span>
						</a>
					</li>
					<li <?php if($segments[2] == 'products' && (isset($segments[3]) && $segments[3] == 'edit')) echo 'class="open"'?>>
						<a href="<?php echo site_url("admin/products/edit"); ?>">
							<span class="title"> <?php echo lang('product_add_product'); ?> </span>
						</a>
					</li>	
					<li <?php if($segments[2] == 'products' && (isset($segments[3]) && ($segments[3] == 'categories' || $segments[3] == 'categoryedit'))) echo 'class="open"'?>>
						<a href="<?php echo site_url("admin/products/categories"); ?>">
							<span class="title"><?php echo lang('page_left_admin_product_categories');?></span>
						</a>
					</li>					
				</ul>
			</li>
			<li <?php if($segments[2] == 'art' || $segments[2] == 'idea') echo 'class="active open"' ?>>
				<a href="javascript:void(0)">
					<i class="clip-pictures"></i>
					<span class="title"><?php echo lang('page_left_admin_art');?></span>
					<i class="icon-arrow"></i>
					<span class="selected"></span>
				</a>
				<ul class="sub-menu">
					<li <?php if($segments[2] == 'art') echo 'class="active open"'; ?>>
						<a href="<?php echo site_url("admin/art"); ?>">
						<span class="title"><?php echo lang('page_left_admin_list_clipart');?></span>
						</a>
					</li>
					<li <?php if(($segments[2] == 'idea' && empty($segments[3])) || ($segments[2] == 'idea' && isset($segments[3]) && ($segments[3] == 'edit' || $segments[3] == 'index'))) echo 'class="active"'; ?>>
						<a href="<?php echo site_url("admin/idea"); ?>">
						<span class="title"><?php echo lang('page_left_admin_design_template');?></span>
						</a>
					</li>
					<li <?php if($segments[2] == 'idea' && isset($segments[3]) && ($segments[3] == 'categories' || $segments[3] == 'editcategory')) echo 'class="active open"'; ?>>
						<a href="<?php echo site_url("admin/idea/categories"); ?>">
						<span class="title"><?php echo lang('page_left_admin_categories_template');?></span>
						</a>
					</li>
				</ul>		
			</li>
			<li <?php if($segments[2] == 'orders') echo 'class="active open"' ?>>
				<a href="javascript:void(0)">
					<i class="fa fa-shopping-cart"></i>
					<span class="title"><?php echo lang('page_left_admin_list_orders');?></span>
					<i class="icon-arrow"></i>
					<span class="selected"></span>
				</a>
				<ul class="sub-menu">
					<li <?php if($segments[2] == 'orders') echo 'class="active open"'; ?>>
						<a href="<?php echo site_url("admin/orders"); ?>">
							<span class="title"><?php echo lang('page_left_admin_customer_orders');?></span>
						</a>
					</li>
					<!--<li>
						<a href="<?php echo site_url("orders/myorder"); ?>">
							<span class="title">
								<?php echo lang('page_left_admin_my_orders');?><br>
								<small><i><?php echo lang('page_left_admin_list_all_order_title');?></i></small>
							</span>
						</a>
					</li>
					-->
				</ul>
			</li>
			<li <?php if($segments[2] == 'users') echo 'class="active open"' ?>>
				<a href="javascript:void(0);">
					<i class="clip-users"></i>
					<span class="title"><?php echo lang('page_left_admin_users');?></span>
					<i class="icon-arrow"></i>
					<span class="selected"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php if($segments[2] == 'users' && (!isset($segments[3]) || $segments[3] == 'edit')) echo 'active';?>">
						<a href="<?php echo site_url("admin/users"); ?>">
							<span class="title"><?php echo lang('page_left_admin_list_users');?></span>
						</a>
					</li>
					<li class="<?php if(isset($segments[3]) && ($segments[3] == 'groups' || $segments[3] == 'editgroup')) echo 'active';?>">
						<a href="<?php echo site_url("admin/users/groups"); ?>">
							<span class="title"><?php echo lang('page_left_admin_user_group');?></span>
						</a>
					</li>
				</ul>
			</li>
			<li <?php if($segments[2] == 'design') echo 'class="active open"' ?>>
				<a href="<?php echo site_url("admin/design"); ?>">
					<i class="clip-pictures"></i>
					<span class="title"><?php echo lang('page_left_admin_list_design');?></span>
				</a>
			</li>		
			
			<!-- Custom front-end -->
			<li <?php if($segments[2] == 'custom' || $segments[2] == 'page' || $segments[2] == 'layout' || $segments[2] == 'menu') echo 'class="active open"' ?>>
				<a href="javascript:void(0)"><i class="fa fa-pencil"></i>
					<span class="title"><?php echo lang('page_left_admin_custom_frontend');?></span><i class="icon-arrow"></i>
					<span class="selected"></span>
				</a>
				<ul class="sub-menu">
					<li <?php if((isset($segments[3]) && $segments[3] == 'article') || isset($segments[3]) && $segments[3] == 'edit') echo 'class="active open"' ?>>
						<a href="<?php echo site_url("admin/custom/article"); ?>">
							<span class="title"><?php echo lang('page_left_admin_article');?></span></i>
						</a>
					</li>
					<li <?php if($segments[2] == 'custom' && ((isset($segments[3]) && $segments[3] == 'categories') || isset($segments[3]) && $segments[3] == 'editcategory')) echo 'class="active open"' ?>>
						<a href="<?php echo site_url("admin/custom/categories"); ?>">
							<span class="title"><?php echo lang('page_left_admin_categories_article');?></span></i>
						</a>
					</li>
					<li <?php if($segments[2] == 'page') echo 'class="active open"' ?>>
						<a href="<?php echo site_url("admin/page"); ?>">
							<span class="title"><?php echo lang('page_left_admin_page');?></span></i>
						</a>
					</li>
					<li <?php if($segments[2] == 'menu') echo 'class="active open"' ?>>
						<a href="<?php echo site_url("admin/menu"); ?>">
							<span class="title"><?php echo lang('page_left_admin_menu');?></span></i>
						</a>
					</li>
					<li <?php if($segments[2] == 'layout') echo 'class="active open"' ?>>
						<a href="<?php echo site_url("admin/layout"); ?>">
							<span class="title"><?php echo lang('page_left_admin_layout');?></span></i>
						</a>
					</li>
				</ul>
			</li>	
			
			<!-- marketing -->
			<li <?php if($segments[2] == 'coupon') echo 'class="active open"' ?>>
				<a href="javascript:void(0)">
					<i class="fa fa-share-alt"></i>
					<span class="title"><?php echo lang('page_left_admin_marketing');?></span>
					<i class="icon-arrow"></i>
					<span class="selected"></span>
				</a>
				<ul class="sub-menu">
					<li <?php if($segments[2] == 'coupon') echo 'class="active"' ?>>
						<a href="<?php echo site_url("admin/coupon"); ?>">
							<span class="title"><?php echo lang('page_left_admin_coupon');?></span>
						</a>
					</li>
				</ul>
			</li>
			
			<!-- setting menu -->
			<li <?php if($segments[2] == 'settings') echo 'class="active open"' ?>>
				<a href="javascript:void(0)"><i class="	clip-settings"></i>
					<span class="title"><?php echo lang('page_left_admin_settings');?></span><i class="icon-arrow"></i>
					<span class="selected"></span>
				</a>
				<ul class="sub-menu">
					<li <?php if(!isset($segments[3]) && $segments[2] == 'settings') echo 'class="active open"' ?>>
						<a href="<?php echo site_url("admin/settings"); ?>">
							<span class="title"><?php echo lang('page_left_admin_configuaration');?></span></i>
						</a>
					</li>
					<li <?php if(isset($segments[3]) && $segments[3] == 'shipping') echo 'class="active open"' ?>>
						<a href="<?php echo site_url("admin/settings/shipping"); ?>">
							<span class="title"><?php echo lang('page_left_admin_shipping_method');?></span>
						</a>
					</li>
					<li <?php if(isset($segments[3]) && $segments[3] == 'payment') echo 'class="active open"' ?>>
						<a href="<?php echo site_url("admin/settings/payment"); ?>">
							<span class="title"><?php echo lang('page_left_admin_payments');?></span>
						</a>
					</li>
					<li <?php if(isset($segments[3]) && $segments[3] == 'colors') echo 'class="active open"' ?>>
						<a href="<?php echo site_url("admin/settings/colors"); ?>">
							<span class="title"><?php echo lang('page_left_admin_colors');?></span>
						</a>
					</li>
					<li <?php if(isset($segments[3]) && ($segments[3] == 'fonts' || $segments[3] == 'fontgoogle')) echo 'class="active open"' ?>>
						<a href="<?php echo site_url("admin/settings/fonts"); ?>">
							<span class="title"><?php echo lang('page_left_admin_fonts');?></span>
						</a>
					</li>	
					<li <?php if(isset($segments[3]) && $segments[3] == 'emails') echo 'class="active open"' ?>>
						<a href="<?php echo site_url("admin/settings/emails"); ?>">
							<span class="title"><?php echo lang('page_left_admin_emails');?></span>
						</a>
					</li>
					<li <?php if(isset($segments[3]) && $segments[3] == 'currencies') echo 'class="active open"' ?>>
						<a href="<?php echo site_url("admin/settings/currencies"); ?>">
							<span class="title"><?php echo lang('page_left_admin_currencies');?></span>
						</a>
					</li>
					<li class="<?php if(isset($fields) || isset($field)) echo 'active';?>">
						<a href="<?php echo site_url("admin/settings/fields"); ?>">
							<span class="title"><?php echo lang('page_left_admin_custom_fields');?></span>
						</a>
					</li>
					<li <?php if(isset($segments[3]) && $segments[3] == 'countries') echo 'class="active open"' ?>>
						<a href="<?php echo site_url("admin/settings/countries"); ?>">
							<span class="title"><?php echo lang('page_left_admin_countries');?></span>
						</a>
					</li>
					<li <?php if(isset($segments[3]) && $segments[3] == 'states') echo 'class="active open"' ?>>
						<a href="<?php echo site_url("admin/settings/states"); ?>">
							<span class="title"><?php echo lang('page_left_admin_states');?></span>
						</a>
					</li>
				</ul>
			</li>

			<!-- Media menu -->
			<li <?php if($segments[2] == 'media') echo 'class="active open"' ?>>
				<a href="<?php echo site_url("admin/media"); ?>">
					<i class="fa fa-folder-open"></i>
					<span class="title"><?php echo lang('media');?></span>
					<span class="selected"></span>
				</a>
			</li>
		</ul>
		<!-- end: MAIN NAVIGATION MENU -->
	</div>
	<!-- end: SIDEBAR -->
</div>
<!-- start: PAGE -->
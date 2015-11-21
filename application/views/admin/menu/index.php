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
<!-- List menu -->
<script src="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/plugins/tinymce/tinymce.min.js'); ?>" type="text/javascript"></script>
<link href="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.css'); ?>" rel="stylesheet"/>
<script src="<?php echo base_url('assets/admin/js/grid.js'); ?>"></script>
<link href="<?php echo base_url('assets/admin/css/grid.css'); ?>" rel="stylesheet">

<?php if($this->session->flashdata('error') != ''){  ?>
	<div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
<?php }  ?>

<form name="admin" action="<?php echo site_url('admin/menu/save'); ?>" method="POST">
<div class="row">
	<div class="col-md-3 text-left">
		<div class="btn-group">
			<button type="button" class="btn btn-default" style="max-width: 200px; overflow: hidden;">
				<?php if ($menu->title != '') echo $menu->title; else echo 'Select a menu to edit'; ?>
			</button>
			
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
				<span class="caret"></span>
				<span class="sr-only"><?php echo lang('menu_toggle_dropdown');?></span>
			</button>
			<ul class="dropdown-menu" role="menu">
			
			<?php if ( count($menu_type)> 0 ) { ?>
			
				<?php foreach($menu_type as $row) { if ($row->id == $menu->id) $active = 'class="active"'; else $active = ''; ?>
				<li <?php echo $active; ?>><a href="<?php echo site_url('admin/menu/index/'.$row->id); ?>"><?php echo $row->title; ?></a></li>
				<?php } ?>
				
			<?php } ?>
				
				
				<li class="divider"></li>
				<li><a href="<?php echo site_url('admin/menu/index'); ?>"><?php echo lang('menu_add_new_menu');?></a></li>
			</ul>
		</div>
	</div>
	<div class="col-md-3 text-left">		
		<input type="text" class="form-control" name="menu[title]" value="<?php echo $menu->title; ?>" placeholder="<?php echo lang('menu_add_menu_title');?>">		
		<input type="hidden" class="form-control" name="menu[id]" value="<?php echo $menu->id; ?>">		
	</div>
	
	<div class="col-md-6 text-right">
		<button type="submit" class="btn btn-primary"><?php echo lang('save');?></button>
	</div>
</div>

<hr/>

<!-- main menu items -->
<div class="row">
	<!-- menu type -->
	<div class="col-sm-4">
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			
			<!-- BEGIN home page -->
			<div class="panel panel-dg">
				<div class="panel-heading" role="tab" id="menu-home">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#content-home" aria-expanded="true" aria-controls="content-home"><?php echo lang('menu_system_items');?></a>
						<span class="fa fa-caret-right pull-right"></span>
					</h4>
				</div>
				<div id="content-home" class="panel-collapse collapse" role="tabpanel" aria-labelledby="menu-home">
					<div class="panel-body" data-link="" data-type="Menu items">
						<div class="checkbox">
							<label>
							  <input type="checkbox" data-link="home" data-title="Home Page"> <?php echo lang('menu_home_page');?>
							</label>
						 </div>
						 
						 <div class="checkbox">
							<label>
							  <input type="checkbox" data-link="cart" data-title="Cart"> <?php echo lang('menu_cart');?>
							</label>
						 </div>
						 
						 <div class="checkbox">
							<label>
							  <input type="checkbox" data-link="cart/checkout" data-title="Checkout"> <?php echo lang('menu_checkout');?>
							</label>
						 </div>
						 
						  <div class="checkbox">
							<label>
							  <input type="checkbox" data-link="user/login" data-title="Login"> <?php echo lang('menu_login');?>
							</label>
						 </div>
						 
						 <div class="checkbox">
							<label>
							  <input type="checkbox" data-link="user/register" data-title="Register"> <?php echo lang('menu_register');?>
							</label>
						 </div>
						<br>
						<div class="form-group text-right">
							<button type="button" class="btn btn-default btn-sm" data-loading-text="Loading..." autocomplete="off" onclick="grid.menu.add(this)"><?php echo lang('menu_add_to_menu');?></button>
						</div>
					</div>
				</div>
			</div>
			<!-- END home page -->
			
			
			<!-- BEGIN static page -->
			<div class="panel panel-dg">
				<div class="panel-heading" role="tab" id="menu-page">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#content-page" aria-expanded="true" aria-controls="content-home"><?php echo lang('menu_static_page');?></a>
						<span class="fa fa-caret-right pull-right"></span>
					</h4>
				</div>
				<div id="content-page" class="panel-collapse collapse" role="tabpanel" aria-labelledby="menu-home">
					<div class="panel-body" data-link="page" data-type="page">
						
						<?php for($i=0; $i<count($pages); $i++) { ?>
						<div class="checkbox">
							<label>
							  <input type="checkbox" data-link="/<?php echo $pages[$i]->id.'-'.$pages[$i]->slug; ?>" data-title="<?php echo $pages[$i]->title; ?>"> <?php echo $pages[$i]->title; ?>
							</label>
						 </div>
						 <?php } ?>
						 
						<br>
						<div class="form-group text-right">
							<button type="button" class="btn btn-default btn-sm" data-loading-text="Loading..." autocomplete="off" onclick="grid.menu.add(this)"><?php echo lang('menu_add_to_menu');?></button>
						</div>
					</div>
				</div>
			</div>
			<!-- END static page -->
			
			
			<!-- BEGIN products -->
			<div class="panel panel-dg">
				<div class="panel-heading" role="tab" id="menu-products">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#content-products" aria-expanded="true" aria-controls="content-products"><?php echo lang('menu_products');?></a>
						<span class="fa fa-caret-right pull-right"></span>
					</h4>
				</div>
				<div id="content-products" class="panel-collapse collapse" role="tabpanel" aria-labelledby="menu-products">
					<div class="panel-body" data-type="product" data-link="">
						<ul class="nav nav-tabs" role="tablist">
							 <li role="presentation" class="active"><a href="#product-categories" aria-controls="product-categories" role="tab" data-toggle="tab"><?php echo lang('menu_categories');?></a></li>
							 <li role="presentation"><a href="#product-design" aria-controls="product-design" role="tab" data-toggle="tab"><?php echo lang('menu_designer');?></a></li>
							 <li role="presentation"><a href="#product-products" aria-controls="product-products" role="tab" data-toggle="tab"><?php echo lang('menu_products');?></a></li>
						</ul>
						
						<div class="tab-content">
							<!-- categories -->
							<div role="tabpanel" class="tab-pane active" id="product-categories">
							<?php if (count($categories) > 0) { ?>
								
								<?php foreach($categories as $data) { ?>
								<div class="checkbox">
									<label>
									  <input type="checkbox" data-link="categories/<?php echo $data->id; ?>-<?php echo $data->slug; ?>" data-title="<?php echo $data->title; ?>"> <?php echo $data->title; ?>
									</label>
								 </div>
								<?php } ?>
							
							<?php } else { echo '<p>'.lang('menu_data_not_found').'</p>'; }?>
							</div>
							
							<!-- designer -->
							<div role="tabpanel" class="tab-pane" id="product-design">
								<div class="checkbox">
									<label>
									  <input type="checkbox" data-link="design" data-title="Design Your Own"> <?php echo lang('menu_designer');?>
									</label>
								 </div>
							</div>
							
							<!-- products -->
							<div role="tabpanel" class="tab-pane" id="product-products">
							<?php if (count($products) > 0) { ?>
								
								<?php foreach($products as $data) { ?>
								<div class="checkbox">
									<label>
									  <input type="checkbox" data-link="product/<?php echo $data->id; ?>-<?php echo $data->slug; ?>" data-title="<?php echo $data->title; ?>"> <?php echo $data->title; ?>
									</label>
								 </div>
								<?php } ?>
							
							<?php } else { echo '<p>'.lang('menu_data_not_found').'</p>'; }?>
							</div>
						</div>
						
						<br>
						<div class="form-group text-right">
							<button type="button" class="btn btn-default btn-sm" data-loading-text="Loading..." autocomplete="off" onclick="grid.menu.add(this)"><?php echo lang('menu_add_to_menu');?></button>
						</div>
					</div>
				</div>
			</div>
			<!-- END products -->
			
			<!-- BEGIN Design Idea -->
			<div class="panel panel-dg">
				<div class="panel-heading" role="tab" id="menu-idea">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#content-idea" aria-expanded="true" aria-controls="content-home"><?php echo lang('menu_design_idea');?></a>
						<span class="fa fa-caret-right pull-right"></span>
					</h4>
				</div>
				<div id="content-idea" class="panel-collapse collapse" role="tabpanel" aria-labelledby="menu-home">
					<div class="panel-body" data-link="idea" data-type="Design idea">
						
						<div class="checkbox">
							<label>
							  <input type="checkbox" data-link="" data-title="List categories"> <?php echo lang('menu_list_all_categories');?>
							</label>
						 </div>
						 
						 <hr />
						 <p><strong><?php echo lang('menu_design_idea_categories');?></strong></p>
						<?php for($i=0; $i<count($idea_categories); $i++) { ?>
						<div class="checkbox">
							<label>
							  <input type="checkbox" data-link="/<?php echo $idea_categories[$i]->id.'-'.$idea_categories[$i]->slug; ?>" data-title="<?php echo $idea_categories[$i]->title; ?>"> <?php echo $idea_categories[$i]->title; ?>
							</label>
						 </div>
						 <?php } ?>
						 
						<br>
						<div class="form-group text-right">
							<button type="button" class="btn btn-default btn-sm" data-loading-text="Loading..." autocomplete="off" onclick="grid.menu.add(this)"><?php echo lang('menu_add_to_menu');?></button>
						</div>
					</div>
				</div>
			</div>
			<!-- END Design Idea -->
			
			<!-- BEGIN Blog -->
			<div class="panel panel-dg">
				<div class="panel-heading" role="tab" id="menu-blog">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#content-blog" aria-expanded="true" aria-controls="content-blog"><?php echo lang('menu_blog');?></a>
						<span class="fa fa-caret-right pull-right"></span>
					</h4>
				</div>
				<div id="content-blog" class="panel-collapse collapse" role="tabpanel" aria-labelledby="menu-blog">
					<div class="panel-body" data-link="blog" data-type="blog">
						
						<div class="checkbox">
							<label>
							  <input type="checkbox" data-link="" data-title="Blog home page"> <?php echo lang('menu_blog_home_page');?>
							</label>
						 </div>
						 
						  <hr />
						 <p><strong><?php echo lang('menu_design_idea_categories');?></strong></p>
						 
						<?php for($i=0; $i<count($blog_categories); $i++) { ?>
						<div class="checkbox">
							<label>
							  <input type="checkbox" data-link="/category/<?php echo $blog_categories[$i]->id.'-'.$blog_categories[$i]->slug; ?>" data-title="<?php echo $blog_categories[$i]->title; ?>"> <?php echo $blog_categories[$i]->title; ?>
							</label>
						 </div>
						 <?php } ?>
						 
						<br>
						<div class="form-group text-right">
							<button type="button" class="btn btn-default btn-sm" data-loading-text="Loading..." autocomplete="off" onclick="grid.menu.add(this)"><?php echo lang('menu_add_to_menu');?></button>
						</div>
					</div>
				</div>
			</div>
			<!-- END Blog -->
			
			<!-- BEGIN custom link -->
			<div class="panel panel-dg">
				<div class="panel-heading" role="tab" id="menu-link">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#content-link" aria-expanded="true" aria-controls="content-link"><?php echo lang('menu_custom_links');?></a>
						<span class="fa fa-caret-right pull-right"></span>
					</h4>
				</div>
				<div id="content-link" class="panel-collapse collapse" role="tabpanel" aria-labelledby="menu-link">
					<div class="panel-body">
						<div class="form-group">
							<label><?php echo lang('menu_url');?></label>
							<input type="text" class="form-control input-sm custom-url" placeholder="URL">
						</div>
						<div class="form-group">
							<label><?php echo lang('menu_link_title');?></label>
							<input type="text" class="form-control input-sm custom-title" placeholder="Menu item">
						</div>
						
						<div class="form-group text-right">
							<button type="button" class="btn btn-default btn-sm" data-loading-text="Loading..." autocomplete="off" onclick="grid.menu.addCustom(this)"><?php echo lang('menu_add_to_menu');?></button>
						</div>
					</div>
				</div>
			</div>
			<!-- END custom link -->
		</div>
	</div>
	
	<!-- menu item -->
	<div class="col-sm-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="clip-list"></i>
				<?php echo lang('menu_menu_items');?>
				<div class="panel-tools">
					<a class="btn btn-xs btn-link panel-collapse collapses" href="javascript:void(0);"></a>						
				</div>
			</div>
			<div class="panel-body">
				<h4><?php echo lang('menu_menu_structure');?></h4>
				<p class="center-block"><small><?php echo lang('menu_menu_structure_help');?></small></p>
				<hr>
				<ul class="menu-items">
				
				<?php if (count($items) > 0) { ?>
				
					<?php foreach ($items as $item) {
					
						if (is_object($item) === false) break;
						$options = json_decode($item->options);
						if (empty($options->responsive)) $options->responsive = 'r';
					?>
					
					<li data-id="<?php echo $item->id; ?>" data-link="<?php echo $item->url; ?>" data-attribute="<?php echo $item->attribute; ?>" class="menu-item">
						<input type="hidden" name="items[title][]" value="<?php echo $item->title; ?>" class="hiden-items-title">
						<input type="hidden" name="items[url][]" value="<?php echo $item->url; ?>" class="hiden-items-url">						
						<input type="hidden" name="items[attribute][]" value="<?php echo $item->attribute; ?>" class="hiden-items-attribute">
						
						<input type="hidden" name="items[options][responsive][]" class="hiden-items-options-responsive" value="<?php echo $options->responsive; ?>">
						<input type="hidden" name="items[options][type][]" value="<?php echo $options->type; ?>">
						
						<textarea name="items[subitem][]" class="hiden-items-subitem" style="display:none;"><?php echo $item->subitem; ?></textarea>
						<textarea name="items[html][]" class="hiden-items-html" style="display:none;"><?php echo $item->html; ?></textarea>
						
						<label class="menu-title"><?php echo $item->title; ?></label> 
						
						<span class="pull-right item-config"><?php echo $options->type; ?> <i class="fa fa-caret-down"></i></span>
					</li>
					
					<?php } ?>
					
				<?php } ?>
				
				</ul>
			</div>
		</div>
	</div>
</div>

</form>

<!-- config, edit menu items -->
<div class="menu-items-config">
	<div class="items-sidebar text-right">
		<div class="col-sm-2 text-left"><i class="glyphicon glyphicon-cog"></i> <?php echo lang('menu_item_settings');?></div>		
		<span class="text-success" style="display:none;"><?php echo lang('menu_save_success');?></span>
		<button type="button" class="btn btn-primary btn-xs" onclick="grid.menu.save()"><i class="fa fa-save"></i></button> 
		<button type="button" class="close" style="padding-top: 5px;"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="items-content">
		<div class="items-left">
			<ul class="items-menu">
				<li data-tab="base" class="active"><?php echo lang('menu_base');?> <i class="fa fa-caret-right pull-right"></i></li>
				<li data-tab="submenu"><?php echo lang('menu_submenu');?> <i class="fa fa-caret-right pull-right"></i></li>				
			</ul>
		</div>
		<div class="items-right">
			<div id="main-config">
				<br />
				<!-- base menu info -->
				<div class="col-sm-12 config-tabs config-tab-base active">					
					<div class="col-sm-3">
						<div class="form-group">
							<label><?php echo lang('menu_navigation_label');?></label>
							<input type="text" class="form-control config-item-title" placeholder="">
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label><?php echo lang('menu_url');?></label>
							<input type="text" class="form-control config-item-url" placeholder="">
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label><?php echo lang('menu_title_attribute');?></label>
							<input type="text" class="form-control config-item-attribute" placeholder="">
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label>&nbsp;</label><br>
							<button class="btn btn-default" type="submit" onclick="grid.menu.remove()"><?php echo lang('menu_remove');?></button>
						</div>
					</div>
				</div>
				
				
				<div class="col-sm-12 config-tabs config-tab-submenu">					
					<div class="col-sm-2">
						<div class="form-group">
							<strong><?php echo lang('menu_submenu_layout');?></strong>
						</div>
						<div class="form-group">												
							<select class="form-control input-sm option-menu-responsive">
								<option value="r"><?php echo lang('menu_responsive');?></option>
								<option value="f"><?php echo lang('menu_full_page');?></option>
							</select>								
						</div>
						<div class="form-group text-center">							
							<a title="Click to add a row" class="btn btn-primary" href="javascript:void(0)" onclick="grid.row.add()" id="add-row">
								<span aria-hidden="true" class="glyphicon glyphicon-plus"></span> <?php echo lang('menu_add_row');?>
							</a>								
						</div>
					</div>
					<div class="col-sm-10">
						<div id="main-app" class="container-fluid">							
						</div>
					</div>
				</div>			
			</div>
		</div>
	</div>
</div>

<!-- Bengin layout of row -->
<div class="modal fade" id="layout-row">
	<div class="modal-dialog g-modal modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo lang('menu_row_layout');?></h4>
			</div>
			
			<div class="modal-body">
				<div class="form-group">
					<label class="control-label"><?php echo lang('menu_row_layout');?>: <span class="number-row font-bold">1 <?php echo lang('menu_row');?></span></label>
					<div class="center-block"><small><?php echo lang('menu_drag_and_drop');?></small></div>
					<div id="slider-number-row" class="grid-slider"></div>
				</div>
				<div class="form-group">
					<label class="control-label font-bold"><?php echo lang('menu_custom_your_layout');?></label>
					<span class="center-block"><small><?php echo lang('menu_custom_your_layout_help');?></small></span>
					<div class="layout-col-list row"></div>
				</div>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close');?></button>
				<button type="button" class="btn btn-primary" id="layout-save" data-loading-text="Loading..."><?php echo lang('menu_save_change');?></button>
			</div>
		</div>
	</div>
</div>
<!-- end layout of row -->


<!-- show list module -->
<div class="modal fade" id="list-modules">
	<div class="modal-dialog g-modal modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo lang('menu_add_element');?></h4>
			</div>
			
			<div class="modal-body" style="min-height: 400px;">
			
				<div role="tabpanel" id="list-menu-title">
				
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						 <li role="presentation" class="active">
							<a href="#sub-tab-home" aria-controls="sub-tab-home" role="tab" data-toggle="tab"><?php echo lang('menu_home');?></a>
						</li>
						<li role="presentation">
							<a href="#sub-tab-page" aria-controls="sub-tab-page" role="tab" data-toggle="tab"><?php echo lang('menu_page');?></a>
						</li>
						<li role="presentation">
							<a href="#sub-tab-products" aria-controls="sub-tab-products" role="tab" data-toggle="tab"><?php echo lang('menu_products');?></a>
						</li>
						<li role="presentation">
							<a href="#sub-tab-idea" aria-controls="sub-tab-idea" role="tab" data-toggle="tab"><?php echo lang('menu_design_idea');?></a>
						</li>
						<li role="presentation">
							<a href="#sub-tab-blog" aria-controls="sub-tab-blog" role="tab" data-toggle="tab"><?php echo lang('menu_blog');?></a>
						</li>						
						<li role="presentation">
							<a href="#sub-tab-links" aria-controls="sub-tab-links" role="tab" data-toggle="tab"><?php echo lang('menu_custom_links');?></a>
						</li>
						<li role="presentation">
							<a href="#sub-tab-contents" aria-controls="sub-tab-contents" role="tab" data-toggle="tab"><?php echo lang('menu_custom_content');?></a>
						</li>
					</ul>
					
					<!-- Tab panes -->
					<div class="tab-content" style="min-height: 300px;">
						<!-- home page menu -->
						<div role="tabpanel" class="tab-pane active" id="sub-tab-home">
							<div class="checkbox">
								<label>
								  <input type="checkbox" data-title="Home Page" data-link=""> <?php echo lang('menu_home_page');?>
								</label>
							 </div>
						</div>
						
						<!-- static page -->
						<div role="tabpanel" class="tab-pane" id="sub-tab-page">
							<?php for($i=0; $i<count($pages); $i++) { ?>
							<div class="checkbox">
								<label>
								  <input type="checkbox" data-link="page/<?php echo $pages[$i]->id.'-'.$pages[$i]->slug; ?>" data-title="<?php echo $pages[$i]->title; ?>"> <?php echo $pages[$i]->title; ?>
								</label>
							 </div>
							 <?php } ?>
						</div>
						
						<!-- products menu -->
						<div role="tabpanel" class="tab-pane" id="sub-tab-products">
							<div class="row" role="tabpanel">
								<div class="col-sm-4">
									<ul class="list-group item-tabs" role="tablist">									
										<li role="presentation" class="list-group-item active">
											<a href="#sub-product-design" aria-controls="sub-product-design" role="tab" data-toggle="tab"><?php echo lang('menu_design_tool');?></a>
										</li>
										<li role="presentation" class="list-group-item">
											<a href="#sub-product-categories" aria-controls="sub-product-categories" role="tab" data-toggle="tab"><?php echo lang('menu_product_categories');?></a>
										</li>
										<li role="presentation" class="list-group-item">
											<a href="#sub-product-list" aria-controls="sub-product-list" role="tab" data-toggle="tab"><?php echo lang('menu_list_products');?></a>
										</li>								  
									</ul>
								</div>
							
								<div class="col-sm-8 item-tabs">
									<div role="tabpanel" class="tab-pane active" id="sub-product-design">
										<div class="checkbox">
											<label>
											  <input type="checkbox" data-title="Design Your Own" data-link="design"> <?php echo lang('menu_designer');?>
											</label>
										 </div>
									</div>
									
									<!-- categories -->
									<div role="tabpanel" class="tab-pane" id="sub-product-categories">
									<?php if (count($categories) > 0) { ?>
								
										<?php foreach($categories as $data) { ?>
										<div class="checkbox">
											<label>
											  <input type="checkbox" data-link="categories/<?php echo $data->id; ?>-<?php echo $data->slug; ?>" data-title="<?php echo $data->title; ?>"> <?php echo $data->title; ?>
											</label>
										 </div>
										<?php } ?>
									
									<?php } else { echo '<p>'.lang('menu_data_not_found').'</p>'; }?>
									</div>
									
									<!-- products -->
									<div role="tabpanel" class="tab-pane" id="sub-product-list">
									<?php if (count($products) > 0) { ?>
								
										<?php foreach($products as $data) { ?>
										<div class="checkbox">
											<label>
											  <input type="checkbox" data-link="product/<?php echo $data->id; ?>-<?php echo $data->slug; ?>" data-title="<?php echo $data->title; ?>"> <?php echo $data->title; ?>
											</label>
										 </div>
										<?php } ?>
									
									<?php } else { echo '<p>'.lang('menu_data_not_found').'</p>'; }?>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Design idea -->
						<div role="tabpanel" class="tab-pane" id="sub-tab-idea">
							<div class="checkbox">
								<label>
								  <input type="checkbox" data-link="idea" data-title="List categories"> <?php echo lang('menu_list_all_categories');?>
								</label>
							 </div>
							 
							 <hr />
							 <p><strong><?php echo lang('menu_design_idea_categories');?></strong></p>
							<?php for($i=0; $i<count($idea_categories); $i++) { ?>
							<div class="checkbox">
								<label>
								  <input type="checkbox" data-link="idea/<?php echo $idea_categories[$i]->id.'-'.$idea_categories[$i]->slug; ?>" data-title="<?php echo $idea_categories[$i]->title; ?>"> <?php echo $idea_categories[$i]->title; ?>
								</label>
							 </div>
							 <?php } ?>
						</div>
						
						<!-- Blog -->
						<div role="tabpanel" class="tab-pane" id="sub-tab-blog">
							<div class="checkbox">
								<label>
								  <input type="checkbox" data-link="blog" data-title="Blog home page"> <?php echo lang('menu_blog_home_page');?>
								</label>
							 </div>
							 
							  <hr />
							 <p><strong><?php echo lang('menu_design_idea_categories');?></strong></p>
							 
							<?php for($i=0; $i<count($blog_categories); $i++) { ?>
							<div class="checkbox">
								<label>
								  <input type="checkbox" data-link="blog/category/<?php echo $blog_categories[$i]->id.'-'.$blog_categories[$i]->slug; ?>" data-title="<?php echo $blog_categories[$i]->title; ?>"> <?php echo $blog_categories[$i]->title; ?>
								</label>
							 </div>
							 <?php } ?>
						</div>
						
						<!-- custom url -->
						<div role="tabpanel" class="tab-pane" id="sub-tab-links">
							<div class="form-group">
								<label><?php echo lang('menu_url');?></label>
								<input type="text" placeholder="URL" class="form-control input-sm custom-url">
							</div>
							<div class="form-group">
								<label><?php echo lang('menu_link_title');?></label>
								<input type="text" placeholder="Menu item" class="form-control input-sm custom-title">
							</div>
						</div>
						
						<!-- custom content -->
						<div role="tabpanel" class="tab-pane" id="sub-tab-contents">
							<div class="text-edittor"></div>
						</div>
					</div>
					
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close');?></button>
				<button type="button" class="btn btn-primary" onclick="grid.menu.sumenu(this)"><?php echo lang('menu_save_change');?></button>
			</div>
		</div>
	</div>
</div>
<!-- end list modules -->

<script>
var base_url = '<?php echo base_url(); ?>';
var site_url = '<?php echo site_url(); ?>';
jQuery(function() {
    jQuery( ".menu-items-config" ).resizable({
      maxHeight: 600,
      minHeight: 34,
	  handles: "n"
    });
	grid.menu.ini();
	jQuery('.menu-items').sortable();
	
	jQuery('#list-modules').on('show.bs.modal', function (e) {
		tinymce.init({
			selector: ".text-edittor",
			menubar: false,
			toolbar_items_size: 'small',
			statusbar: false,
			height : 200,
			convert_urls: false,	
			plugins: [
				"advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks code fullscreen",
				"insertdatetime media table contextmenu paste textcolor dgmedia"
			],
			toolbar: "code | insertfile undo redo | styleselect | forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify | numlist outdent indent | image dgmedia"
		});
	});
});
var url = '<?php echo base_url(); ?>';
var areaZoom = 10;
function descriptMedia(images){
	if(images.length > 0)
	{
		var html = '';
		for(i=0; i<images.length; i++)
		{
			html = html + '<img src="'+images[i]+'" alt="" />';
		}
		tinymce.activeEditor.execCommand('mceInsertContent', false, html);
		jQuery.fancybox.close();
	}
}
tinymce.PluginManager.add('dgmedia', function(editor, url) {
    // Add a button that opens a window
    editor.addButton('dgmedia', {
        text: 'Add Image',
        icon: false,		
        onclick: function() {
			jQuery.fancybox( {href : base_url + 'admin/media/modals/descriptMedia/2', type: 'iframe'} );
        }
    });	
});
tinymce.init({
	selector: ".text-edittor",
	menubar: false,
	toolbar_items_size: 'small',
	statusbar: false,
	height : 200,
	convert_urls: false,	
	plugins: [
		"advlist autolink lists link image charmap print preview anchor",
		"searchreplace visualblocks code fullscreen",
		"insertdatetime media table contextmenu paste textcolor dgmedia"
	],
	toolbar: "code | insertfile undo redo | styleselect | forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify | numlist outdent indent | image dgmedia"
});
 </script>
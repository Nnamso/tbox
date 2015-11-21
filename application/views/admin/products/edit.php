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
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/chosen/chosen.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/jQuery-Tags-Input/jquery.tagsinput.css'); ?>">

<script src="<?php echo base_url('assets/plugins/validate/validate.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/chosen/chosen.jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/tinymce/tinymce.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/jQuery-Tags-Input/jquery.tagsinput.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/bootstrap-modal/js/bootstrap-modal.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/ui-modals.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jscolor.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.css'); ?>">

<script type="text/javascript">
var base_url = '<?php echo site_url(); ?>';
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
        text: 'Add images',
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
	height : 150,
	convert_urls: false,	
	setup: function(editor) {
		editor.addButton('mybutton', {
			text: 'My button',
			icon: false,
			onclick: function() {
				editor.insertContent('Main button');
			}
		});
	},
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu dgmedia"
    ],
    toolbar: "code | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | dgmedia"
});
</script>
<div class="row">
	<?php echo validation_errors('<p class="alert alert-danger">'); ?>
	<form id="fr-product" accept-charset="utf-8" method="post" action="<?php echo site_url(). 'admin/products/save'; ?>">
		<div class="tabbable col-md-12">
			<ul id="myTab" class="nav nav-tabs tab-bricky">
				<li class="active">
					<a href="#panel_tab2_example1" data-toggle="tab">
						<i class="green fa fa-home"></i> <?php echo lang('product_info'); ?>
					</a>
				</li>
				<li>
					<a href="#panel_tab2_example2" data-toggle="tab">
						<i class="green fa fa-home"></i> <?php echo lang('product_design'); ?>
					</a>
				</li>
				<li class="pull-right">
					<button type="submit" onclick="return saveProduct(this);" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-save"></i> <?php echo lang('product_save_product'); ?></button>
					 <button type="button" onclick="window.location ='<?php echo base_url("admin/products"); ?>'" class="btn btn-danger"><?php echo lang('close'); ?></button>
				</li>
			</ul>
			
			<div class="tab-content">
				<div class="tab-pane active" id="panel_tab2_example1">
					<!-- Begin left -->
					<div class="col-sm-8 col-md-8">						
						<div class="form-group">
							<input type="text" name="product[data][title]" value="<?php echo $product->title; ?>" placeholder="<?php echo lang('product_product_name'); ?>" id="product-name" data-minlength="2" data-maxlength="250" data-msg="<?php echo lang('product_validate_msg') . lang('product_product_name');?>" class="form-control validate required">
						</div>
						
						<div class="form-group">
							<label ><?php echo lang('product_short_description'); ?></label>
							<textarea name="product[data][short_description]" class="form-control" rows="3"><?php echo $product->short_description; ?></textarea>
						</div>
						
						<div class="form-group">
							<label ><?php echo lang('product_description'); ?></label>
							<textarea name="product[data][description]" class="text-edittor" style="width:100%"><?php echo $product->description; ?></textarea>
						</div>
						
						<div class="form-group">
							<label ><?php echo lang('product_site_info'); ?></label>
							<textarea name="product[data][size]" class="text-edittor" style="width:100%"><?php echo $product->size; ?></textarea>
						</div>
						
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="clip-data"></i>
								<?php echo lang('product_data'); ?>
								<div class="panel-tools">
									<a href="javascript:void(0);" class="btn btn-xs btn-link panel-collapse collapses"></a>										
								</div>
							</div>
							
							<div id="tabs" class="tabs-left panel-body">
								<ul class="tabs-nav-left col-md-3">
									<li><a href="#tabs-1"><?php echo lang('product_general'); ?></a></li>
									<li><a href="#tabs-2"><?php echo lang('product_order'); ?></a></li>
									<li><a href="#tabs-3"><?php echo lang('product_attribute'); ?></a></li>
								</ul>
								<div class="tabs-content-right col-md-9">
									<div id="tabs-1">
										<div class="form-group">
											<label class="col-sm-3 control-label">
												<?php echo lang('published'); ?>
											</label>
											<div class="col-sm-4">
												<input type="checkbox" name="product[data][published]" <?php if($product->published == 1) echo 'checked="checked"'; ?> value="<?php echo $product->published; ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">
												<?php echo lang('layout'); ?>
											</label>
											<div class="col-sm-4">
												<?php if(count($layouts) > 0) { ?>
													
													<select class="form-control input-sm" name="product[data][layout]">
														<option value="">- Select a layout -</option>
													<?php foreach($layouts as $layout) { ?>
														<?php if ($product->layout == $layout->id) { ?>
														<option selected="selected" value="<?php echo $layout->id; ?>"><?php echo $layout->title; ?></option>
														<?php } else { ?>
														<option value="<?php echo $layout->id; ?>"><?php echo $layout->title; ?></option>
														<?php } ?>
													<?php } ?>
													
													</select>
												
												<?php } else { ?>
													<a href="<?php echo site_url('admin/page'); ?>">Please add layout</a>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">
												<?php echo lang('product_print_type'); ?>
											</label>
											<div class="col-sm-4">
												<?php 
												$print_types = array(
													'screen'=>lang('print_screen'),
													'DTG'=>lang('print_DTG'),
													'sublimation'=>lang('print_sublimation'),
													'embroidery'=>lang('print_embroidery'),
												);
												echo form_dropdown('product[data][print_type]', $print_types, $product->print_type, 'class="form-control input-sm"');
												?>												
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">
												<?php echo lang('product_sku'); ?>
											</label>
											<div class="col-sm-4">
												<input type="text" class="form-control input-sm validate required" name="product[data][sku]" value="<?php echo $product->sku; ?>" data-minlength="2" data-maxlength="250" data-msg="<?php echo lang('product_validate_msg') . lang('product_sku');?>" placeholder="<?php echo lang('product_sku'); ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">
												<?php echo lang('add_slug'); ?>
											</label>
											<div class="col-sm-4">
												<input type="text" class="form-control input-sm" name="product[data][slug]" value="<?php echo $product->slug; ?>" placeholder="<?php echo lang('add_slug'); ?>">
											</div>
										</div>
										<div class="clear-line"></div>
										<div class="form-group">
											<label class="col-sm-3 control-label">
												<?php echo lang('product_regular_price'); ?>
											</label>
											<div class="col-sm-4">
												<input type="text" class="form-control input-sm" name="product[data][price]" value="<?php echo $product->price; ?>" placeholder="<?php echo lang('product_regular_price'); ?>">
											</div>
											<div class="col-sm-5">
												<div class="row">
													<?php $setting = json_decode($shop->settings); ?>
													
													<?php if (isset($setting->currency_id)) { ?>
														<?php if (isset($setting->currency_symbol)) echo $setting->currency_symbol; ?>
														<input type="hidden" value="<?php echo $setting->currency_id; ?>" name="product[data][currency_id]">
													<?php } else { ?>
													
														<?php $currencies = getCurrencies(1, array('currency_id', 'currency_name', 'currency_symbol')); ?>
														<select name="product[data][currency_id]" class="form-control input-sm">
														
														<?php foreach($currencies as $currency) {
															if( $currency['currency_id'] == $product->currency_id ) $checked = 'selected="selected"';
															else $checked = '';
														?>
															<option <?php echo $checked; ?> value="<?php echo $currency['currency_id']; ?>"><?php echo $currency['currency_symbol'] .' - '. $currency['currency_name']; ?></option>
														<?php } ?>
														
														</select>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="form-group" id="prices-quantity">
											<div class="row-prices">
												<label class="col-sm-3 control-label">
													<?php echo lang('product_sale_price'); ?>
												</label>
												<div class="col-sm-9">
													<div class="form-group row">
														<div class="col-sm-5">
															<input type="text" value="<?php echo $product->sale_price; ?>" class="form-control input-sm" name="product[data][sale_price]" placeholder="<?php echo lang('product_sale_price'); ?>">
														</div>
														<div class="col-sm-7">
															<span class="help-block" style="margin-top: -5px;"><small><?php echo lang('product_sale_price_des'); ?></small></span>
														</div>
													</div>
												</div>
											</div>
											
											<div class="row-prices">
												<label class="col-sm-3 control-label"></label>
												<div class="col-sm-9">
													<div class="form-group">
														<a href="javascript:void(0);" onclick="dgUI.product.priceQuantity();" title="<?php echo lang('product_quantity_price'); ?>"><?php echo lang('add_new_quantity_price'); ?></a>
													</div>
												</div>
											</div>
											
											<!-- price with quantity -->
											<?php if( isset($prices) && count($prices) ){
												$qPrice = json_decode($prices[0]->price); 
												$qMin 	= json_decode($prices[0]->min_quantity); 
												$qMax 	= json_decode($prices[0]->max_quantity); 
											?>
											<?php for( $i=0; $i<count($qPrice); $i++ ){ ?>
											<div class="row-prices">
												<label class="col-sm-3 control-label"><?php echo lang('product_quantity_price'); ?></label>
												<div class="col-sm-9">
													<div class="form-group row">
														<div class="col-sm-5">
															<input type="text" value="<?php echo $qPrice[$i]; ?>" class="form-control input-sm" name="product[prices][price][]" placeholder="<?php echo lang('product_sale_price'); ?>">
														</div>
														<div class="col-sm-5">
															<a href="javascript:void(0);" onclick="dgUI.product.priceQuantity(this);" title="<?php echo lang('remove'); ?>"><?php echo lang('remove'); ?></a>
														</div>
													</div>
													<div class="form-group row">
														<div class="col-sm-5">
															<input type="text" value="<?php echo $qMin[$i]; ?>" class="form-control input-sm" name="product[prices][min_quantity][]" placeholder="<?php echo lang('product_quantity_min'); ?>">
														</div>
														<div class="col-sm-5">
															<input type="text" value="<?php echo $qMax[$i]; ?>" class="form-control input-sm" name="product[prices][max_quantity][]" placeholder="<?php echo lang('product_quantity_max'); ?>">
														</div>
													</div>
												</div>
											</div>
											<?php } ?>
											<?php } ?>
											
										</div>
									</div>
									<div id="tabs-2">
										<div class="form-group">
											<label class="col-sm-5 control-label">
												<?php echo lang('product_order_min'); ?>
											</label>
											<div class="col-sm-3">
												<input type="text" name="product[data][min_order]" value="<?php echo $product->min_order; ?>" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-5 control-label">
												<?php echo lang('product_order_max'); ?>
											</label>
											<div class="col-sm-3">
												<input type="text" name="product[data][max_oder]" value="<?php echo $product->max_oder; ?>" />
											</div>
										</div>
									</div>
									<div id="tabs-3">
										<div class="customfields">
											<?php for($i=0; $i< count($fields['name']); $i++) { ?>
											<div class="panel panel-simple" data-attribute="<?php echo $i; ?>">
												<div class="panel-heading">									
													<span class="attribute-title"><?php echo lang('product_data'); ?></span>
													<a href="javascript:void(0);" onclick="dgUI.product.field(this, 'add')" data-id="<?php echo $i; ?>" class="btn btn-default btn-xs">
														<?php echo lang('add_new'); ?>
													</a>									
													<div class="panel-tools">									
														<a href="javascript:void(0);" class="btn btn-xs btn-link panel-collapse collapses"></a>
														<a href="javascript:void(0);" onclick="dgUI.product.attribute(this)" class="btn btn-xs btn-link">
															<i class="glyphicon glyphicon-remove"></i>
														</a>
													</div>
												</div>
								
												<div class="panel-body">
													<div class="col-md-4">
														<div class="row">
															<div class="form-group">
																<label for="form-field-22"><?php echo lang('attribute_name'); ?></label>
																<input type="text" class="form-control input-sm" value="<?php echo $fields['name'][$i]; ?>" name="product[fields][<?php echo $i; ?>][name]">
																<div class="add-attribute"></div>
															</div>
														</div>
														
														<div class="row">
															<div class="form-group">
																<label><?php echo lang('attribute_type'); ?></label>
																<select name="product[fields][<?php echo $i; ?>][type]" class="fields-type form-control input-sm">
																	<option value="selectbox" <?php if ($fields['type'][$i] == 'selectbox') echo 'selected="selected"'; ?>><?php echo lang('product_select_dropdown');?></option>
																	<option value="textlist" <?php if ($fields['type'][$i] == 'textlist') echo 'selected="selected"'; ?>><?php echo lang('product_text_list');?></option>
																	<option value="checkbox" <?php if ($fields['type'][$i] == 'checkbox') echo 'selected="selected"'; ?>><?php echo lang('product_checkbox');?></option>
																	<option value="radio" <?php if ($fields['type'][$i] == 'radio') echo 'selected="selected"'; ?>><?php echo lang('product_button_radio');?></option>
																</select>
															</div>
														</div>
													</div>
													<div class="col-md-8">
														<div class="attrbutes-fields">
															<div class="row form-group">
																<div class="col-md-3 pull-right">
																	<center>
																	<?php echo lang('remove'); ?>
																	</center>
																</div>
																<div class="col-md-3 pull-right">
																	<center>
																	<?php echo lang('price'); ?>
																	<br />
																	<small>+/-</small>
																	</center>
																</div>
																<div class="col-md-5 pull-right">
																	<?php echo lang('title'); ?>
																</div>
															</div>
															<?php if (isset($fields['titles']) && count($fields['titles']) > 0){
																for($j=0; $j<count($fields['titles'][$i]); $j++) { ?>
																
																<div class="row form-group row-fields">
																	<div class="col-md-3 pull-right">
																		<center><small><a href="javascript:void(0);" onclick="dgUI.product.field(this,'remove')"><i class="clip-close"></i></a></small></center>
																	</div>
																	<div class="col-md-3 pull-right">
																		<input type="text" class="form-control input-sm" value="<?php echo $fields['prices'][$i][$j]; ?>" name="product[fields][<?php echo $i; ?>][prices][]">
																	</div>
																	<div class="col-md-5 pull-right">
																		<input type="text" class="form-control input-sm" value="<?php echo $fields['titles'][$i][$j]; ?>"  name="product[fields][<?php echo $i; ?>][titles][]">
																	</div>
																</div>
																
																<?php } ?>
															<?php } ?>
														</div>
													</div>
												</div>
											</div>
											<?php } ?>
										</div>
										<div class="form-group">
											<a href="javascript:void(0);" onclick="dgUI.product.attribute('add')" class="btn btn-primary white">
												<?php echo lang('add_new'); ?>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- End left -->
					
					<!-- Begin righ -->
					<div class="col-sm-4 col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="clip-list"></i>
								<?php echo lang('product_categories'); ?>
								<div class="panel-tools">
									<a href="javascript:void(0);" class="btn btn-xs btn-link panel-collapse collapses"></a>						
								</div>
							</div>
							<div class="panel-body">
								<label id="product_categories-lable"><?php echo lang('product_add_categories'); ?></label>
								<button type="button" autocomplete="off" onclick="dgUI.product.removeCate(this);" id="loading-example-btn" data-loading-text="Loading..." class="btn btn-sm pull-right btn-primary">
								  <?php echo lang('remove'); ?>
								</button>								
								<div class="form-group" id="product_categories">									
									<?php echo dispayTree( $categories, 0, array('type'=>'checkbox', 'name'=>'product[category][]'), $cate_checked ); ?>
								</div>
								<div class="form-group">
									<a href="javascript:void(0)" onclick="dgUI.product.addCategoryJs(this)"><?php echo lang('product_add_category'); ?></a>
								</div>
								
								<div class="form-group">
									<div class="add-new-category" style="display:none;">
										
										<!-- category language -->
										<div class="form-group">
											<input type="text" class="add_new_category form-control input-sm" placeholder="<?php echo lang('product_title_category'); ?>" autocomplete="off">
										</div>
										
										<div class="form-group">
										
											<select class="form-control" id="product-category-parent">
												<option value="0"><?php echo lang('product_parent_category'); ?></option>
												<?php echo dispayTree( $categories, 0, array('type'=>'select', 'name'=>'') ); ?>
											</select>
										
										</div>
										<div class="form-group">
											<a href="javascript:void(0)" class="btn btn-default btn-sm" onclick="dgUI.product.addCategoryJs(this, 'save')"><?php echo lang('product_add_category'); ?></a>
										</div>
									</div>
								</div>
								
							</div>
						</div>
						
						<!-- product image -->
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="clip-image"></i>
								<?php echo lang('product_image'); ?>
								<div class="panel-tools">
									<a href="javascript:void(0);" class="btn btn-xs btn-link panel-collapse collapses"></a>						
								</div>
							</div>
							<div class="panel-body">
								<input type="hidden" name="product[data][image]" value="<?php echo $product->image; ?>" id="products_image" />
								<?php if($product->image != '') { ?>
									<img width="100" alt="" class="pull-right" src="<?php echo base_url($product->image); ?>">
								<?php } ?>
								<a href="javascript:void(0)" class="btn btn-default btn-sm" onclick="jQuery.fancybox( {href : '<?php echo base_url('admin/media/modals/productImg/1') ?>', type: 'iframe'} );"><?php echo lang('product_add_image'); ?></a>
							</div>
						</div>
						
						<!-- product gallery -->
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="clip-images-2"></i> <?php echo lang('product_gallery'); ?>
								<div class="panel-tools">
									<a href="javascript:void(0);" class="btn btn-xs btn-link panel-collapse collapses"></a>						
								</div>
							</div>
							<div class="panel-body">
								<div class="product-gallery"></div>
								<br />
								<input type="hidden" name="product[data][gallery]" id="product_gallery" value="<?php echo $product->gallery; ?>" />
								
								<a href="javascript:void(0)" class="btn btn-default btn-sm" onclick="jQuery.fancybox( {href : '<?php echo base_url('admin/media/modals/gallery/2') ?>', type: 'iframe'} );"><?php echo lang('product_add_gallery'); ?></a>
								
								<br /><br /><i class="glyphicon glyphicon-move"></i>: <small><?php echo lang('product_help_move'); ?></small>
								<br /><i class="glyphicon glyphicon-trash"></i>: <small><?php echo lang('product_help_remove'); ?></small>
							</div>
						</div>
						
						<!-- meta info -->
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="clip-key-2"></i>
								<?php echo lang('products_meta_data'); ?>
								<div class="panel-tools">
									<a href="javascript:void(0);" class="btn btn-xs btn-link panel-collapse collapses"></a>						
								</div>
							</div>
							<div class="panel-body">								
								<div class="form-group">
									<label><?php echo lang('products_meta_data_title'); ?></label>
									<textarea rows="1" class="form-control" name="product[data][meta_title]"><?php echo $product->meta_title; ?></textarea>
								</div>
								<div class="form-group">
									<label><?php echo lang('products_meta_keywords'); ?></label>
									<textarea rows="1" class="form-control" name="product[data][meta_keywords]"><?php echo $product->meta_keywords; ?></textarea>
								</div>
								<div class="form-group">
									<label><?php echo lang('products_meta_description'); ?></label>
									<textarea rows="2" class="form-control" name="product[data][meta_description]"><?php echo $product->meta_description; ?></textarea>
								</div>
							</div>
						</div>
					</div>
					<!-- End righ -->
				</div>
				
				<div class="tab-pane" id="panel_tab2_example2">
					
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="clip-t-shirt"></i>
							<?php echo lang('product_view_color'); ?>
							<div class="panel-tools">
								<a href="javascript:void(0);" class="btn btn-xs btn-link panel-collapse collapses"></a>
							</div>
						</div>
						
						<div class="panel-body">
							<div class="col-md-12">
								<div class="form-group pull-right">
									<a href="javascript:void(0);" id="add-new-color" class="btn btn-primary white"><i class="fa icon-plus"> <?php echo lang('product_add_color'); ?></i></a>									
								</div>
							</div>
							<div class="clear-line"></div>
							
							<div class="table-responsive">
								<table class="table table-bordered table-hover" id="product-design">
									<thead>
										<tr>
											<th rowspan="2" class="center" width="5%"><?php echo lang('color'); ?></th>
											<th rowspan="2" class="center" width="10%"><?php echo lang('product_color_title'); ?></th>
											<th rowspan="2" class="center" width="5%"><?php echo lang('price'); ?> <small><?php lang('extra'); ?></small></th>
											<!--<th rowspan="2" class="center" width="5%"><?php echo lang('default'); ?></th>-->
											<th colspan="4" class="center" width="60%"><?php echo lang('view'); ?></th>
											<th rowspan="2" class="center" width="5%"><?php echo lang('ordering'); ?></th>
											<th rowspan="2" class="center" width="10%"><?php echo lang('action'); ?></th>
										</tr>
										<tr class="title center">
											<th class="center"><?php echo lang('front'); ?></th>
											<th class="center"><?php echo lang('back'); ?></th>
											<th class="center"><?php echo lang('left'); ?></th>
											<th class="center"><?php echo lang('right'); ?></th>
										</tr>
									</thead>
									
									<tbody>
									<?php if( isset($design->options) && count($design->options)) { ?>
									
									<?php for( $i=0; $i<count($design->options); $i++ ) { ?>
									
										<tr id="color_<?php echo $i; ?>">
											<td class="center">
												<input type="hidden" value="<?php  echo $design->options[$i]['color_hex']; ?>" name="product[design][color_hex][]">
												<?php $colors = explode(';', $design->options[$i]['color_hex']); ?>
												
												<?php for($ij=0; $ij<count($colors); $ij++) { ?>
												<a style="background-color:#<?php  echo $colors[$ij]; ?>" data-color="<?php  echo $colors[$ij]; ?>" onclick="dgUI.product.color.edit('<?php echo $i; ?>.<?php echo $ij; ?>')" href="javascript:void(0)" class="color"></a>
												<?php } ?>
											</td>
											
											<td class="center"><input type="text" value="<?php  echo $design->options[$i]['color_title']; ?>" name="product[design][color_title][]"></td>
											<td class="center"><input type="text" name="product[design][price][]" value="<?php  echo $design->options[$i]['price']; ?>" class="input-small"></td>											
											
											<td class="center">
												<input type="hidden" id="front-products-design-<?php echo $i; ?>" value="<?php  echo $design->options[$i]['front']; ?>" name="product[design][front][]">
												<img width="50" id="front-products-img-<?php echo $i; ?>" src="<?php echo helperProduct::getImgage($design->options[$i]['front']); ?>" alt=""> <br>
												<a onclick="dgUI.product.design(this, 'front')" href="javascript:void(0)"><?php echo lang('configure');?></a>
											</td>
											
											<td class="center">
												<input type="hidden" id="back-products-design-<?php echo $i; ?>" value="<?php  echo $design->options[$i]['back']; ?>" name="product[design][back][]">
												<img width="50" id="back-products-img-<?php echo $i; ?>" src="<?php echo helperProduct::getImgage($design->options[$i]['back']); ?>" alt=""> <br>
												<a onclick="dgUI.product.design(this, 'back')" href="javascript:void(0)"><?php echo lang('configure');?></a>
											</td>
											
											<td class="center">
												<input type="hidden" id="left-products-design-<?php echo $i; ?>" value="<?php  echo $design->options[$i]['left']; ?>" name="product[design][left][]">
												<img width="50" id="left-products-img-<?php echo $i; ?>" src="<?php echo helperProduct::getImgage($design->options[$i]['left']); ?>" alt=""> <br>
												<a onclick="dgUI.product.design(this, 'left')" href="javascript:void(0)"><?php echo lang('configure');?></a>
											</td>
											
											<td class="center">
												<input type="hidden" id="right-products-design-<?php echo $i; ?>" value="<?php echo $design->options[$i]['right']; ?>" name="product[design][right][]">
												<img width="50" id="right-products-img-<?php echo $i; ?>" src="<?php echo helperProduct::getImgage($design->options[$i]['right']); ?>" alt=""> <br>
												<a onclick="dgUI.product.design(this, 'right')" href="javascript:void(0)"><?php echo lang('configure');?></a>
											</td>
											
											<td class="center"><input type="text" name="product[design][ordering][]" value="<?php echo $design->options[$i]['ordering']; ?>" class="input-small ordering"></td>
											
											<td class="center"><a onclick="dgUI.product.removeColor(this)" href="javascript:void(0)"><?php echo lang('remove'); ?></a></td>
										</tr>
									
									<?php } ?>
									
									<?php } ?>
									</tbody>
									<tfoot>
										<input type="hidden" value="<?php echo $design->params->front; ?>" id="products-design-print-front" name="product[design][params][front]" />
										<input type="hidden" value="<?php echo $design->params->back; ?>" id="products-design-print-back" name="product[design][params][back]" />
										<input type="hidden" value="<?php echo $design->params->left; ?>" id="products-design-print-left" name="product[design][params][left]" />
										<input type="hidden" value="<?php echo $design->params->right; ?>" id="products-design-print-right" name="product[design][params][right]" />
										<input type="hidden" value="<?php echo $design->area->front; ?>" id="products-design-area-front" name="product[design][area][front]" />
										<input type="hidden" value="<?php echo $design->area->back; ?>" id="products-design-area-back" name="product[design][area][back]" />
										<input type="hidden" value="<?php echo $design->area->left; ?>" id="products-design-area-left" name="product[design][area][left]" />
										<input type="hidden" value="<?php echo $design->area->right; ?>" id="products-design-area-right" name="product[design][area][right]" />										
										<input type="hidden" value="<?php echo $product->id; ?>" name="product[id]" />
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				
				</div>
			</div>
		</div>
	</form>
</div>
<div id="add-view" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"><?php echo lang('product_create_product_view');?></h4>
			</div>
			
			<div class="modal-body">
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('cancel');?></button>
				<button type="button" class="btn btn-primary"><?php echo lang('save');?></button>
			</div>
		</div>
	</div>
</div>

<div id="ajax-modal" class="modal fade" tabindex="-1" style="display: none;"></div>

<script type="text/javascript">
	var files_type = '<option value="selectbox"><?php echo lang('product_select_dropdown');?></option><option value="textlist"><?php echo lang('product_text_list');?></option><option value="checkbox"><?php echo lang('product_checkbox');?></option><option value="radia"><?php echo lang('product_button_radio');?></option>';
	jQuery(".chosen-select").chosen();
	function productImg(images)
	{
		if(images.length > 0)
		{
			var e = jQuery('#products_image');
			e.val(images[0].replace(url, ''));
			if(e.parent().children('img').length > 0)
				e.parent().children('img').attr('src', images[0]);
			else
				e.parent().append('<img src="'+images[0]+'" class="pull-right" alt="" width="100" />');
			jQuery.fancybox.close();
		}
	}
	function gallery(images, addUrl)
	{
		if (typeof addUrl == 'undefined') addUrl = '';
		dgUI.product.gallery(images, addUrl);		
	}
	function design(images)
	{
		dgUI.product.addDesign(images);		
	}
	jQuery(function() {
		jQuery('#add-new-color').on('click', function(){
			UIModals.init('<?php echo site_url('colors'); ?>');
			setTimeout(function(){ jscolor.init();}, 1000);
		});
		jQuery( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		jQuery( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
		
		jQuery('.tag').tagsInput({
			width: 'auto',
			autocomplete_url: '<?php echo site_url('ajax/tags'); ?>'		
		});
	});	
	function saveProduct(e){
		tinyMCE.triggerSave();
		var check = jQuery('#fr-product').validate({event: 'click', obj: e});		
		return check;
	}
	
	<?php if($product->id > 0 && $product->gallery != '') { ?>
		var imgaes = '<?php echo $product->gallery; ?>';
		gallery(imgaes.split(';'), url);
	<?php } ?>
</script>
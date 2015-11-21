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

if ($this->session->flashdata('success')) { 

?>
<div class="row">
	<div class="col-md-12">
		<div class=" alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
	</div>
</div>
<?php } ?>
<form id="adminForm" method="post" name="adminForm" action="<?php echo site_url('/admin/products/index'); ?>">
<div class="row">
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-2">				
				<?php echo perPage($per_page); ?>
			</div>
			<div class="col-md-4">
				<input type="text" placeholder="<?php echo lang('product_search');?>" class="form-control" value="<?php echo $keyword; ?>" name="keyword">		               
			</div>
			<div class="col-md-4">
				<button class="btn btn-primary" type="submit"><?php echo lang('search');?></button>
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<p class="pull-right">
			<a href="<?php echo site_url('/admin/products/edit'); ?>" class="btn btn-primary tooltips" title="<?php echo lang('add_new'); ?>">
				<i class="glyphicon glyphicon-plus"></i>
			</a>
			<a href="javascript:void(0);" onclick="submit('publish');" class="btn btn-green action tooltips" title="<?php echo lang('publish'); ?> ">
				<i class="glyphicon glyphicon-ok-sign"></i>                       
			</a>
			<a href="javascript:void(0);" onclick="submit('unpublish')" class="btn btn-danger action tooltips" title="<?php echo lang('unpublish'); ?>">
				<i class="clip-radio-checked"></i>                        
			</a>
			<a href="javascript:void(0);" onclick="submit('delete')" class="btn btn-bricky action tooltips" title="<?php echo lang('delete'); ?>">
				<i class="fa fa-trash-o"></i>
			</a>
		<p>
	</div>
</div>
<div class="table-responsive">
	<table class="table table-bordered table-hover" id="admin-list-page">
		<thead>
			<tr>
				<th class="center" width="5%">
					<input type="checkbox" onclick="dgUI.checkAll(this)" id="select_all">
				</th>
				<th width="25%"><?php echo lang('product_product_name'); ?></th>
				<th width="10%" class="center"><?php echo lang('product_sku'); ?></th>
				<th width="10%" class="center"><?php echo lang('product_sale_price'); ?></th>
				<th width="20%" class="center"><?php echo lang('product_image'); ?></th>
				<th width="5%" class="center"><?php echo lang('featured'); ?></th>
				<th width="5%" class="center"><?php echo lang('default'); ?></th>
				<th width="10%" class="center"><?php echo lang('published'); ?></th>
				<th width="10%" class="center"><?php echo lang('action'); ?></th>
				<th width="5%" class="center"><?php echo lang('id'); ?></th>
			</tr>
		</thead>
		<tbody>	
		<?php if (count($products) > 0) { ?>
		<?php for($i=0; $i<count($products); $i++) { $product = $products[$i]; ?>
			
			<tr>
				<td class="center">
					<input type="checkbox" class="checkb" value="<?php echo $product->id; ?>" name="ids[]" />
				</td>
				<td>
					<a href="<?php echo site_url('/admin/products/edit') . '/' . $product->id; ?>" title=""><?php echo $product->title; ?></a>
				</td>
				<td class="center">
					<?php echo $product->sku; ?>
				</td>
				<td class="center">
					<?php if ($product->sale_price != 0) echo $product->sale_price; else echo $product->price; ?>
				</td>
				<td class="center">
					<img src="<?php echo base_url($product->image); ?>" alt="" width="150"/>
				</td>
				<td class="center">
					<?php if ($product->future == 1){ ?>
					<a href="<?php echo site_url('/admin/products/unfeatured') . '/' . $product->id; ?>" class="btn btn-success btn-xs tooltips" title="<?php echo lang('click_unfeatured'); ?>">
						<i class="fa fa-flag-o"></i>
					</a>
					<?php } else { ?>
					<a href="<?php echo site_url('/admin/products/featured') . '/' . $product->id; ?>" class="btn btn-bricky btn-xs tooltips" title="<?php echo lang('click_featured'); ?>">
						<i class="fa fa-flag-o"></i>
					</a>
					<?php } ?>
				</td>
				<td class="center">
					<?php if ($product->default == 1){ ?>
					<a href="<?php echo site_url('/admin/products/setdefault') . '/' . $product->id; ?>" class="btn btn-success btn-xs tooltips" title="<?php echo lang('click_setdefault'); ?>">
						<i class="fa fa-star"></i>
					</a>
					<?php } else { ?>
					<a href="<?php echo site_url('/admin/products/setdefault') . '/' . $product->id; ?>" class="btn btn-bricky btn-xs tooltips" title="<?php echo lang('click_setdefault'); ?>">
						<i class="fa fa-star"></i>
					</a>
					<?php } ?>
				</td>
				<td class="center">
					<?php if ($product->published == 1){ ?>
						<a href="<?php echo site_url('/admin/products/unpublish/product') . '/' . $product->id; ?>" class="btn btn-success btn-xs tooltips" title="<?php echo lang('click_unpublish'); ?>"><?php echo lang('publish'); ?></a>
					<?php }else{ ?>
						<a href="<?php echo site_url('/admin/products/publish/product') . '/' . $product->id; ?>" class="btn btn-bricky btn-xs tooltips" title="<?php echo lang('click_publish'); ?>"><?php echo lang('unpublish'); ?></a>
					<?php } ?>
				</td>
				<td class="center">
					<div class="btn-group">
						<button type="button" class="btn btn-teal btn-xs">
							<i class="glyphicon glyphicon-cog"></i>
						</button>
						<button type="button" class="btn btn-teal btn-xs dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo site_url('/admin/products/edit') . '/' . $product->id; ?>"><i class="fa fa-pencil"></i> <?php echo lang('edit'); ?></a></li>
							<li><a href="<?php echo site_url('/admin/products/setdefault') . '/' . $product->id; ?>"><i class="fa fa-star"></i> <?php echo lang('default'); ?></a></li>
							<li><a href="<?php echo site_url('/admin/products/delete/product') . '/' . $product->id; ?>"><i class="glyphicon glyphicon-trash"></i> <?php echo lang('remove'); ?></a></li> 							
						</ul>
					</div>
				</td>
				<td class="center">
					<?php echo $product->id; ?>
				</td>
			</tr>
			
		<?php } ?>
		<?php } ?>
		</tbody>
	</table>
</div>
	<input type="hidden" value="1" name="action" id="submit-action" />
</form>

<div class="row">
	<div class="dataTables_paginate paging_bootstrap pull-right">
		<div class="col-md-12">
		<?php echo $links;?>
		</div>
	</div>
</div>
<script type="text/javascript">
function submit(type){
	var ids = '';
	jQuery('.checkb').each(function(){
		if (jQuery(this).is(':checked'))
		{
			if (ids == '') ids = jQuery(this).val();
			else ids = ids + '-' + jQuery(this).val();
		}
	});
	if (ids == ''){
		alert('<?php echo lang('check_box_mgs'); ?>');
		return;
	}
	
	var url = '<?php echo site_url('/admin/products'). '/'; ?>' + type +'/product/';
	jQuery('#adminForm').attr('action', url);
	jQuery('#adminForm').submit();
}
</script>
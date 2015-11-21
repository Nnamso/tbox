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
    jQuery(document).ready(function() {
        dgUI.ajax.ini('lang');
    });
</script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.jeditable.js'); ?>"></script>

<?php if ($this->session->flashdata('msg') != '') { ?> 
	<div class="alert alert-success">
		<button class="close" data-dismiss="alert"> × </button>
		<i class="fa fa-check-circle"></i>
		<?php echo $this->session->flashdata('msg'); ?>
	</div>
<?php } ?>

<?php if ($this->session->flashdata('error') != '') { ?> 
	<div class="alert alert-danger">
		<button class="close" data-dismiss="alert"> × </button>
		<i class="fa fa-times-circle"></i>
		<?php echo $this->session->flashdata('error'); ?>
	</div>
<?php } ?>
<?php
$attribute = array('class' => 'fr-categories', 'id' => 'fr-categories');
echo form_open(site_url('admin/products/categories'), $attribute);
?>
<div class="row">
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-2">
				<?php $option = array('all'=>lang('all'), '5'=>5, '10'=>10, '15'=>15, '20'=>20, '25'=>25, '100'=>100); ?>
				<?php echo form_dropdown('per_page', $option, $per_page, 'class="form-control option_perpage" id="per_page"'); ?>
			</div>
			
			<div class="col-md-4">
				<?php 
					$search = array('name' => 'search_category', 'id' => 'search_category', 'class' => 'form-control', 'placeholder' => lang('products_search_category_place'), 'value'=>$search);
					echo form_input($search);
				?>
			</div>
			<div class="col-md-2">
				<button type="submit" class="btn btn-primary"><?php echo lang('search');?></button>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<p style="text-align:right;">
			<a class="btn btn-primary tooltips" title="<?php echo lang('add'); ?>" href="<?php echo site_url().'admin/products/categoryedit'; ?>">
				<i class="glyphicon glyphicon-plus"></i>
			</a>
			<a class="btn btn-green tooltips" id="btn-publish" title="<?php echo lang('publish'); ?>" href="javascript:void(0);">
				<i class="glyphicon glyphicon-ok-sign"></i>
			</a>
			<a class="btn btn-danger tooltips" id="btn-unpublish" title="<?php echo lang('unpublish'); ?>" href="javascript:void(0);">
				<i class="clip-radio-checked"></i>
			</a>
			<a class="btn btn-bricky tooltips" id="btn-delete" title="<?php echo lang('delete'); ?>" href="javascript:void(0);"> 
				<i class="fa fa-trash-o"></i>
			</a>
		</p>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square icon-external-link-sign"></i>
		<?php echo lang('categories'); ?>
	</div>
	<div class="panel-body" id="panelbody">
		<table id="sample-table-1" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th class="center">
			<div class="checkbox-table">
				<label>
					<input id="select_all" type="checkbox" name='check_all'>
				</label>
			</div>
			</th>
			<th class="center"><?php echo lang('title'); ?></th>
			<th class="center"><?php echo lang('description'); ?></th>
			<th class="center" style="width: 70px;"><?php echo lang('ordering'); ?></th>
			<th class="center"><?php echo lang('image'); ?></th>
			<th class="center"><?php echo lang('publish'); ?></th>
			<th class="center"><?php echo lang('action'); ?></th>
			</tr>
			</thead>
			<tbody>
				<?php 
					//sort categories.
					$categories = allGroupCategories($categories);
					/*$categoriesTree = categoriesToTree($categories);
					if(count($categoriesTree) > 0)
						$categories = groupCategories($categoriesTree);
					*/

					if (count($categories) && $categories != '') foreach ($categories as $category) { 
				?>
					<tr>
						<td class="center">
							<div class="checkbox-table">
								<label>
									<input type="checkbox" name="checkb[]" class="checkb" name="check" value="<?php echo $category->id; ?>">
								</label>
							</div>
						</td>
						<td><a href="<?php echo site_url().'admin/products/categoryedit/'.$category->id; ?>" ><?php echo $category->title; ?></a></td>
						<td>
							<?php 
								$str_desc = strip_tags($category->description); 
								echo substr($str_desc, 0, 80);
							?>
						</td>
						<td class="center click_edit" data-label="<?php echo $category->id; ?>"><?php echo $category->order;?></td>
						<td class="center"><?php if($category->image != '') echo '<img src="'.base_url($category->image).'" style="height: 70px;"/>'; ?></td>
						<td class="center"><?php if ($category->published == 1) { ?>					   
								<a class="btn btn-success btn-xs tooltips" href="<?php echo site_url().'admin/products/unpublish/category/'.$category->id; ?>" title="Click Publish Category"><?php echo lang('publish'); ?></a>
							<?php } else { ?>
								<a class="btn btn-danger btn-xs tooltips" href="<?php echo site_url().'admin/products/publish/category/'.$category->id; ?>" title="click publish category"><?php echo lang('unpublish'); ?></a>
							<?php } ?>
						</td>
						<td class="center">
							<div class="visible-md visible-lg hidden-sm hidden-xs">
								<a class="btn btn-teal tooltips" data-original-title="Edit" data-placement="top" href="<?php echo site_url().'admin/products/categoryedit/'.$category->id; ?>">
									<i class="fa fa-edit"></i>
								</a>
								<a class="btn btn-bricky tooltips" href="<?php echo site_url().'admin/products/delete/category/'.$category->id; ?>" data-original-title="<?php echo lang('remove');?>" data-placement="top" onclick="return confirm('<?php echo lang('products_categories_confirm_delete_msg');?>');"/>
									<i class="fa fa-times"></i>
								</a>
							</div>
						</td>
					</tr>
				<?php } ?>    
			</tbody>
		</table>
		<div class="row">
			<div class="dataTables_paginate paging_bootstrap" style="float: right;">
				<div class="col-sm-12">
					<?php echo $links; ?>
				</div>
			</div>
		</div>
	</div>    
</div>    
<?php echo form_close(); ?>    

<script type="text/javascript">
	
	jQuery('.option_perpage').change(function(){
		jQuery('#fr-categories').submit();
	});

	jQuery('.tooltips').tooltip();
	jQuery('#btn-publish').click(function(){
		if(jQuery('input.checkb').is(':checked'))
		{
			jQuery('#fr-categories').attr('action', '<?php echo site_url().'admin/products/publish/category'?>');
			jQuery('#fr-categories').submit();
		}else
		{
			alert('<?php echo lang('products_categories_checked_checkbox_msg');?>');
		}
   });
   
   jQuery('#btn-unpublish').click(function(){
		if(jQuery('input.checkb').is(':checked'))
		{
			jQuery('#fr-categories').attr('action', '<?php echo site_url().'admin/products/unpublish/category'?>');
			jQuery('#fr-categories').submit();
		}else
		{
			alert('<?php echo lang('products_categories_checked_checkbox_msg');?>');
		}
   });
   
   jQuery('#btn-delete').click(function(){
		if(jQuery('input.checkb').is(':checked'))
		{
			cf = confirm('<?php echo lang('products_categories_confirm_delete_msg');?>');
			if(cf)
			{
				jQuery('#fr-categories').attr('action', '<?php echo site_url().'admin/products/delete/category'?>');
				jQuery('#fr-categories').submit();
			}
		}else
		{
			alert('<?php echo lang('products_categories_checked_checkbox_msg');?>');
		}
   });
   
   // edit ordering categories.
   jQuery('.click_edit').editable(function(value, settings) {
		console.log(this);
		console.log(value);
		console.log(settings);
		return(value);
	},{ 
		submit : '<a href="javascript: void(0);" onclick="save_order(this)"><i class="fa fa-save"></i></a>',
	});
	
	function save_order(e)
	{
		var value = jQuery(e).parent('form').children('input').val();
		var id = jQuery(e).parent('form').parent('td').attr('data-label');
		if($.isNumeric(value) && (value % 1 == 0) && value >= 0)
		{
			jQuery.ajax({
				type: "POST",
				url: '<?php echo site_url().uri_string(); ?>',
				data: {order_id: id, order_number: value},
				dataType: 'html',
				success: function(data){
					if(data != '')
					{
						alert('<?php echo lang('products_categories_save_order_success_msg');?>');
					}else
					{
						alert('<?php echo lang('products_categories_save_order_error_msg');?>');
					}
				}
			});
		}
	}
</script>
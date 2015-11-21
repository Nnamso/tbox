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
</script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.jeditable.js'); ?>"></script>

<?php if($this->session->flashdata('error') != ''){?>
	<div class="alert alert-danger"><?php echo $this->session->flashdata('error');?></div>
<?php } ?>
<?php if($this->session->flashdata('msg') != ''){?>
	<div class="alert alert-success"><?php echo $this->session->flashdata('msg');?></div>
<?php } ?>

<?php
	$attribute = array('class' => 'fr-category', 'id' => 'fr-category');
	echo form_open(site_url('admin/idea/categories'), $attribute);
?>
<div class="row">
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-2">
				<?php 
					$option = array('all'=>  lang('all'), '5'=>5, '10'=>10, '15'=>15, '20'=>20, '25'=>25, '100'=>100);
					echo form_dropdown('per_page', $option, $per_page, 'class="form-control" id="per_page"');
				?>
			</div>
			
			<div class="col-md-4">
				<?php
					$search = array('name' => 'search_category', 'id' => 'search', 'class' => 'form-control', 'placeholder' => lang('idea_search_title'), 'value'=>$search);
					echo form_input($search);
				?>
			</div>
			<div class="col-md-2">
				<button type="submit" class="btn btn-primary"><?php echo lang('search');?></button>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<p style="text-align:right;">
			<a class="btn btn-primary tooltips" title="<?php echo lang('add'); ?>" href="<?php echo site_url('admin/idea/editcategory'); ?>" >
				<i class="glyphicon glyphicon-plus"></i>
			</a>
			<a id="btn-publish" class="btn btn-green tooltips" title="<?php echo lang('publish'); ?>" href="javascript:void(0);">
				<i class="glyphicon glyphicon-ok-sign"></i>
			</a>
			<a id="btn-unpublish" class="btn btn-danger tooltips" title="<?php echo lang('unpublish'); ?>" href="javascript:void(0);">
				<i class="clip-radio-checked"></i>
			</a>
			<a id="btn-delete" class="btn btn-bricky tooltips" title="<?php echo lang('delete'); ?>" href="javascript:void(0);" > 
				<i class="fa fa-trash-o"></i>
			</a>
		</p>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square icon-external-link-sign"></i>
		<?php echo lang('idea_admin_categories_list_title'); ?>
	</div>
   
	<div class="panel-body" id="panelbody">
		<table id="sample-table-1" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th class="center" style="width: 4%;">
						<div class="checkbox-table">
							<label>
								<input id="select_all" type="checkbox" name='check_all'>
							</label>
						</div>
					</th>
					<th class="center" style="width: 15%;"><?php echo lang('idea_admin_categories_title_title'); ?></th>
					<th class="center"><?php echo lang('idea_admin_categories_description_title'); ?></th>
					<th class="center" style="width: 70px;"><?php echo lang('ordering'); ?></th>
					<th class="center" style="width: 10%;"><?php echo lang('idea_admin_categories_image_title'); ?></th>
					<th class="center" style="width: 10%;"><?php echo lang('publish'); ?></th>
					<th class="center" style="width: 15%;"><?php echo lang('action'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php 
					//sort categories.
					$categories = allGroupCategories($categories);
					/*
					$categories = categoriesToTree($categories); 
					if(count($categories))
						$categories = groupCategories($categories);
					*/
					foreach ($categories as $category) { 
				?>
					<tr>
						<td class="center">
							<div class="checkbox-table">
								<label>
									<input type="checkbox" name="checkb[]" class="checkb" name="check" value="<?php echo $category->id; ?>">
								</label>
							</div>
						</td>
						<td><a href="<?php echo site_url('admin/idea/editcategory/'.$category->id); ?>"><?php echo $category->title; ?></a></td>						
						<td><?php echo substr(strip_tags($category->description), 0, 80); ?></td>
						<td class="center click_edit" data-label="<?php echo $category->id; ?>"><?php echo $category->order;?></td>
						<td class="center">
							<?php if($category->image != '') echo '<img style="height: 70px;" src="'.base_url($category->image).'">'; ?>
						</td>
						<td class="center">
							<?php if ($category->published == 1) { ?>					   
								<a href="<?php echo site_url('admin/idea/unpublishcategory/'.$category->id); ?>" class="btn btn-success btn-xs tooltips" type="button" data-original-title="<?php echo lang('idea_click_unpublish');?>" data-placement="top" ><?php echo lang('publish'); ?></a>
							<?php } else { ?>
								<a href="<?php echo site_url('admin/idea/publishcategory/'.$category->id); ?>" class="btn btn-danger btn-xs tooltips" type="button" data-original-title="<?php echo lang('idea_click_publish');?>" data-placement="top" ><?php echo lang('unpublish'); ?></a>
							<?php } ?>
						</td> 
						<td class="center">
							<div class="visible-md visible-lg hidden-sm hidden-xs">
								<a href="<?php echo site_url('admin/idea/editcategory/'.$category->id); ?>" class="btn btn-teal tooltips" data-placement="top" data-original-title="<?php echo lang('edit');?>">
									<i class="fa fa-edit"></i>
								</a>
								<a class="remove btn btn-bricky tooltips" data-placement="top" data-original-title="<?php echo lang('remove');?>" href="<?php echo site_url(); ?>admin/idea/delcategory/<?php echo $category->id; ?>" onclick="return confirm('<?php echo lang('idea_admin_categories_confirm_delete');?>');">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</td>
					</tr>
				<?php } ?>    
			</tbody>
		</table>
		<div class="pull-right">
			<?php echo $links;?>
		</div>
	</div>
	<?php echo form_close(); ?>        
</div>  

<script type="text/javascript">
	jQuery('.pagination').css('margin', '0px');
	jQuery('.tooltips').tooltip();
	
	jQuery('#btn-unpublish').click(function(){
		if(jQuery('.checkb').is(':checked')){
			jQuery('#fr-category').attr('action', '<?php echo site_url('admin/idea/unpublishcategory');?>').submit();
		}else{
			alert('<?php echo lang('idea_admin_categories_not_check_error');?>');
		}
	});
	
	jQuery('#btn-publish').click(function(){
		if(jQuery('.checkb').is(':checked')){
			jQuery('#fr-category').attr('action', '<?php echo site_url('admin/idea/publishcategory');?>').submit();
		}else{
			alert('<?php echo lang('idea_admin_categories_not_check_error');?>');
		}
	});
	
	jQuery('#btn-delete').click(function(){
		if(jQuery('.checkb').is(':checked')){
			var cf = confirm("<?php echo lang('idea_admin_categories_confirm_delete');?>");
			if(cf)
				jQuery('#fr-category').attr('action', '<?php echo site_url('admin/idea/delcategory');?>').submit();
		}else{
			alert('<?php echo lang('idea_admin_categories_not_check_error');?>');
		}
	});
	
	jQuery('#per_page').change(function(){
		jQuery('#fr-category').submit();
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
						alert('<?php echo lang('idea_admin_categories_save_order_success_msg');?>');
					}else
					{
						alert('<?php echo lang('idea_admin_categories_save_order_error_msg');?>');
					}
				}
			});
		}
	}
</script>
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

<?php if($this->session->flashdata('error') != ''){?>
	<div class="alert alert-danger"><?php echo $this->session->flashdata('error');?></div>
<?php } ?>
<?php if($this->session->flashdata('msg') != ''){?>
	<div class="alert alert-success"><?php echo $this->session->flashdata('msg');?></div>
<?php } ?>

<?php
	$attribute = array('class' => 'fr-form', 'id' => 'fr-form');
	echo form_open(site_url().'admin/users/fields', $attribute);
?>
<div class="row">
	<div class="col-md-12">
		<p style="text-align:right;">
			<a class="btn btn-primary tooltips" href="<?php echo site_url().'admin/settings/fields/edit'?>" title="<?php echo lang('add'); ?>">
				<i class="glyphicon glyphicon-plus"></i>
			</a>
			<a id="btn-publish" class="btn btn-green tooltips" href="javascript:void(0);" title="<?php echo lang('publish'); ?>">
				<i class="glyphicon glyphicon-ok-sign"></i>
			</a>
			<a id="btn-unpublish" class="btn btn-danger tooltips" href="javascript:void(0);" title="<?php echo lang('unpublish'); ?>">
				<i class="clip-radio-checked"></i>
			</a>
			<a id="btn-delete" class="btn btn-bricky tooltips" href="javascript:void(0);" title="<?php echo lang('delete'); ?>"> 
				<i class="fa fa-trash-o"></i>
			</a>
		</p>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square icon-external-link-sign"></i>
		<?php echo lang('field_list_fields'); ?>
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
			<th class="center"><?php echo lang('name'); ?></th>
			<th class="center"><?php echo lang('type'); ?></th>
			<th class="center"><?php echo lang('layout'); ?></th>
			<th class="center"><?php echo lang('order'); ?></th>
			<th class="center"><?php echo lang('publish'); ?></th>
			<th class="center"><?php echo lang('action'); ?></th>
			</tr>
			</thead>
			<tbody>
				<?php foreach ($fields as $field) { ?>
						<tr>
							<td class="center">
								<div class="checkbox-table">
									<label>
										<input type="checkbox" name="checkb[]" class="checkb" name="check" value="<?php echo $field->id; ?>">
									</label>
								</div>
							</td>
							<td><a href="<?php echo site_url(); ?>admin/settings/fields/edit/<?php echo $field->id; ?>"><?php echo $field->title; ?></a></td>
							<td><?php echo $field->name; ?></td>
							<td><?php echo $field->type; ?></td>
							<td>
								<?php 
									$forms = json_decode($field->forms);
									$i=1;
									foreach($forms as $form)
									{
										if($i == count($forms))
											echo $form;
										else
											echo $form.', ';
										$i++;
									}
								?>
							</td>
							<td class="center">
								<?php echo $field->order; ?>	
							</td>
							<td class="center"><?php if ($field->publish == 1) { ?>					   
									<a href="<?php echo site_url(); ?>admin/settings/unpublished/<?php echo $field->id; ?>" class="btn btn-success btn-xs tooltips" type="button" data-original-title="<?php echo lang('click_unpublish');?>" data-placement="top" ><?php echo lang('publish'); ?></a>
								<?php } else { ?>
									<a href="<?php echo site_url(); ?>admin/settings/published/<?php echo $field->id; ?>" class="btn btn-danger btn-xs tooltips" type="button" data-original-title="<?php echo lang('click_publish');?>" data-placement="top" ><?php echo lang('unpublish'); ?></a>
								<?php } ?>
							</td> 
							<td class="center">
								<div class="visible-md visible-lg hidden-sm hidden-xs">
									<a href="<?php echo site_url(); ?>admin/settings/fields/edit/<?php echo $field->id; ?>" class="btn btn-teal tooltips" data-placement="top" data-original-title="<?php echo lang('edit');?>">
										<i class="fa fa-edit"></i>
									</a>
									<a class="remove btn btn-bricky tooltips" data-placement="top" data-original-title="<?php echo lang('remove');?>" href="<?php echo site_url(); ?>admin/settings/deletefield/<?php echo $field->id; ?>" onclick="return confirm('<?php echo lang('field_confirm_delete');?>');">
										<i class="fa fa-times"></i>
									</a>
								</div>
							</td>
						</tr>
					<?php } ?>    
			</tbody>
		</table>
	</div>
	<?php echo form_close(); ?>        
</div>   

<script type="text/javascript">
	jQuery('.pagination').css('margin', '0px');
	jQuery('.tooltips').tooltip();
	
	jQuery('#btn-publish').click(function(){
		if(jQuery('.checkb').is(':checked')){
			jQuery('#fr-form').attr('action', '<?php echo site_url().'admin/settings/published';?>').submit();
		}else{
			alert('<?php echo lang('field_error_not_checbox');?>');
		}
	});
	
	jQuery('#btn-unpublish').click(function(){
		if(jQuery('.checkb').is(':checked')){
			jQuery('#fr-form').attr('action', '<?php echo site_url().'admin/settings/unpublished';?>').submit();
		}else{
			alert('<?php echo lang('field_error_not_checbox');?>');
		}
	});
	
	jQuery('#btn-delete').click(function(){
		if(jQuery('.checkb').is(':checked')){
			var cf = confirm("<?php echo lang('field_confirm_delete');?>");
			if(cf)
				jQuery('#fr-form').attr('action', '<?php echo site_url().'admin/settings/deletefield';?>').submit();
		}else{
			alert('<?php echo lang('field_error_not_checbox');?>');
		}
	});
</script>
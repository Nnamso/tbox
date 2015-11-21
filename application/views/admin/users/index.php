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
	$attribute = array('class' => 'fr-user', 'id' => 'fr-user');
	echo form_open(site_url().'admin/users', $attribute);
?>
<div class="row">
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-2">
				<?php $options = array(''=>  lang('all'), '5'=>5, '10'=>10, '15'=>15, '20'=>20, '25'=>25, '100'=>100); ?>
				<?php echo form_dropdown('per_page', $options, $per_page, 'class="form-control" id="per_page"'); ?>
			</div>
			<div class="col-md-4">
				<?php 
					$search = array('name' => 'search', 'id' => 'search', 'class' => 'form-control', 'placeholder' => lang('user_search_enter_key'), 'value'=>$search);
					echo form_input($search);
				?>
			</div>
			<div class="col-md-4">
				<?php 
					$option_s = array('name' => lang('user_search_name'), 'email' => lang('user_search_email'));
					echo form_dropdown('option', $option_s, $option, 'class="form-control" id="option_s"'); 
				?>
			</div>
			<div class="col-md-2">
				<button type="submit" class="btn btn-primary"><?php echo lang('search');?></button>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<p style="text-align:right;">
			<a class="btn btn-primary tooltips" title="<?php echo lang('add'); ?>" href="<?php echo site_url().'admin/users/edit'?>" >
				<i class="glyphicon glyphicon-plus"></i>
			</a>
			<a id="btn-unblock" class="btn btn-green tooltips" title="<?php echo lang('unblock'); ?>" href="javascript:void(0);">
				<i class="glyphicon glyphicon-ok-sign"></i>
			</a>
			<a id="btn-block" class="btn btn-danger tooltips" title="<?php echo lang('block'); ?>" href="javascript:void(0);">
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
		<?php echo lang('user_list'); ?>
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
			<th class="center"><?php echo lang('user_name'); ?></th>
			<th class="center"><?php echo lang('user_user_name'); ?></th>
			<th class="center"><?php echo lang('user_email'); ?></th>
			<th class="center"><?php echo lang('user_group'); ?></th>
			<th class="center"><?php echo lang('user_block'); ?></th>
			<th class="center"><?php echo lang('user_register_date'); ?></th>
			<th class="center"><?php echo lang('action'); ?></th>
			</tr>
			</thead>
			<tbody>
				<?php if (count($users) != '') foreach ($users as $user) { ?>
						<tr>
							<td class="center">
								<div class="checkbox-table">
									<label>
										<input type="checkbox" name="checkb[]" class="checkb" value="<?php echo $user->id; ?>">
									</label>
								</div>
							</td>
							<td><a href="<?php echo site_url(); ?>admin/users/edit/<?php echo $user->id; ?>"><?php echo $user->name; ?></a></td>
							<td><?php echo $user->username; ?></td>
							<td><?php echo $user->email; ?></td>
							<td class="center">
								<?php 
									foreach($groups as $group)
									{
										if($group->id == $user->group)
											echo $group->title; 
									}
								?>
							</td>
							<td class="center"><?php if ($user->block == 1) { ?>					   
									<a href="<?php echo site_url(); ?>admin/users/unblock/<?php echo $user->id; ?>" class="btn btn-danger btn-xs tooltips" type="button" data-original-title="<?php echo lang('user_click_unblock');?>" data-placement="top" ><?php echo lang('block'); ?></a>
								<?php } else { ?>
									<a href="<?php echo site_url(); ?>admin/users/block/<?php echo $user->id; ?>" class="btn btn-success btn-xs tooltips" type="button" data-original-title="<?php echo lang('user_click_block');?>" data-placement="top" ><?php echo lang('unblock'); ?></a>
								<?php } ?>
							</td> 
							<td class="center"><?php $date = new DateTime($user->register_date); echo $date->format("Y-m-d");; ?></td>
							<td class="center">
								<div class="visible-md visible-lg hidden-sm hidden-xs">
									<a href="<?php echo site_url(); ?>admin/users/edit/<?php echo $user->id; ?>" class="btn btn-teal tooltips" data-placement="top" data-original-title="<?php echo lang('edit');?>">
										<i class="fa fa-edit"></i>
									</a>
									<a class="remove btn btn-bricky tooltips" data-placement="top" data-original-title="<?php echo lang('remove');?>" href="<?php echo site_url(); ?>admin/users/delete/<?php echo $user->id; ?>" onclick="return confirm('<?php echo lang('user_confirm_delete');?>');">
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
	
	jQuery('#btn-unblock').click(function(){
		if(jQuery('.checkb').is(':checked')){
			jQuery('#fr-user').attr('action', '<?php echo site_url().'admin/users/unblock';?>').submit();
		}else{
			alert('<?php echo lang('user_error_not_checbox');?>');
		}
	});
	
	jQuery('#btn-block').click(function(){
		if(jQuery('.checkb').is(':checked')){
			jQuery('#fr-user').attr('action', '<?php echo site_url().'admin/users/block';?>').submit();
		}else{
			alert('<?php echo lang('user_error_not_checbox');?>');
		}
	});
	
	jQuery('#btn-delete').click(function(){
		if(jQuery('.checkb').is(':checked')){
			var cf = confirm("<?php echo lang('user_confirm_delete');?>");
			if(cf)
				jQuery('#fr-user').attr('action', '<?php echo site_url().'admin/users/delete';?>').submit();
		}else{
			alert('<?php echo lang('user_error_not_checbox');?>');
		}
	});
	
	jQuery('#per_page').change(function(){
		jQuery('#fr-user').submit();
	});
</script>
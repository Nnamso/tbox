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
	$attribute = array('class' => 'fr-group', 'id' => 'fr-group');
	echo form_open(site_url().'admin/users/groups', $attribute);
?>
<div class="row">
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-2">
				<?php $option = array('all'=>  lang('all'), '5'=>5, '10'=>10, '15'=>15, '20'=>20, '25'=>25, '100'=>100);
					echo form_dropdown('per_page', $option, $per_page, 'spadding: 5px;" class="form-control" id="per_page"');
				?>
			</div>
			<div class="col-md-4">
				<?php 
					$search = array('name' => 'search', 'id' => 'search', 'class' => 'form-control', 'placeholder' => lang('user_search_enter_key'), 'value'=>$search);
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
			<a class="btn btn-primary tooltips" title="<?php echo lang('add'); ?>" href="<?php echo site_url().'admin/users/editgroup'?>" >
				<i class="glyphicon glyphicon-plus"></i>
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
		<?php echo lang('user_list_group'); ?>
	</div>
   
	<div class="panel-body" id="panelbody">
		<table id="sample-table-1" class="table table-bordered table-hover">
			<thead>
				<tr>
			<th style="width: 6%;" class="center">
				<div class="checkbox-table">
					<label>
						<input id="select_all" type="checkbox" name='check_all'>
					</label>
				</div>
			</th>
			<th class="center"><?php echo lang('title'); ?></th>
			<th style="width: 30%;" class="center"><?php echo lang('permission'); ?></th>
			<th style="width: 10%;" class="center"><?php echo lang('default'); ?></th>
			<th style="width: 10%;" class="center"><?php echo lang('action'); ?></th>
			</tr>
			</thead>
			<tbody>
				<?php if (count($groups) != '') foreach ($groups as $group) { ?>
						<tr>
							<td class="center">
								<div class="checkbox-table">
									<label>
										<input type="checkbox" name="checkb[]" class="checkb" name="check" value="<?php echo $group->id; ?>">
									</label>
								</div>
							</td>
							<td><a href="<?php echo site_url(); ?>admin/users/editgroup/<?php echo $group->id; ?>"><?php echo $group->title; ?></a></td>
							<td><?php 
									$permiss = json_decode($group->permissions, true);
									$html = '';
									$i = 1;
									if(is_array($permiss))
									{
										foreach($permiss as $key=>$val)
										{
											if($i == count($permiss))
												$html .= ucfirst($val);
											else
												$html .= ucfirst($val).', ';
											$i++;
										}
									}
									echo $html;
								?>
							</td>
							<td class="center">
								<?php 
									if($group->default == 0)
									{
										echo '<a class="tooltips" data-placement="top" data-original-title="Click to default" href="'.site_url().'admin/users/defaultgroup/'.$group->id.'">
											<i class="fa fa-square-o" style="font-size: 20px;"></i>
										</a>';
									}else
									{
										echo '<a class="tooltips" data-placement="top" data-original-title="Click to default" href="javascript:void(0);">
											<i class="fa fa-check-square-o" style="font-size: 20px;"></i>
										</a>';
									}
								?>
							</td>
							<td class="center">
								<div class="visible-md visible-lg hidden-sm hidden-xs">
									<a href="<?php echo site_url(); ?>admin/users/editgroup/<?php echo $group->id; ?>" class="btn btn-teal tooltips btn-sm" data-placement="top" data-original-title="<?php echo lang('edit');?>">
										<i class="fa fa-edit"></i>
									</a>
									<a class="remove btn btn-bricky tooltips btn-sm" data-placement="top" data-original-title="<?php echo lang('remove');?>" href="<?php echo site_url(); ?>admin/users/delete_group/<?php echo $group->id; ?>" onclick="return confirm('<?php echo lang('user_confirm_delete_group');?>');">
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
	
	jQuery('#btn-delete').click(function(){
		if(jQuery('.checkb').is(':checked')){
			var cf = confirm("<?php echo lang('user_confirm_delete_group');?>");
			if(cf)
				jQuery('#fr-group').attr('action', '<?php echo site_url().'admin/users/deletegroup';?>').submit();
		}else{
			alert('<?php echo lang('user_error_not_checbox');?>');
		}
	});
	
	jQuery('#per_page').change(function(){
		jQuery('#fr-group').submit();
	});
</script>
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
<form id="adminForm" method="post" name="adminForm" action="<?php echo site_url(). 'admin/layout/index'; ?>">
	<div class="row">	
		<div class="col-md-7 pull-right">
			<p style="text-align:right;">
				<a class="btn btn-green tooltips" onclick="submit('copy')" href="javascript:void(0);" data-placement="top" data-original-title="<?php echo 'Copy Layout'; ?>">
					<i class="fa fa-copy"></i>
				</a>
				<a class="btn btn-primary tooltips" href="<?php echo site_url()?>admin/layout/add" data-placement="top" data-original-title="<?php echo lang('add'); ?>">
					<i class="glyphicon glyphicon-plus"></i>
				</a>		
				<a id="btn-delete" class="btn btn-bricky tooltips" onclick="submit('delete')" href="javascript:void(0);" data-placement="top" data-original-title="<?php echo lang('delete');?>"> 
					<i class="fa fa-trash-o"></i>				
				</a>
			</p>
		</div>
	</div>
	<hr />
	
	<?php if ($this->session->flashdata('success')) { ?>
	<div class="row">
		<div class="col-md-12">
			<div class=" alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
		</div>
	</div>
	<?php } ?>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-external-link-square icon-external-link-sign"></i>
					<?php echo lang('layout_list'); ?>
				</div>
				
				<div class="panel-body">
					<table class="table table-bordered table-hover" id="sample-table-1">
						<thead>
							<tr>
								<th class="center" style="width: 5%;">
									<input type="checkbox" onclick="dgUI.checkAll(this)" id="select_all">
								</th>							
								<th class="center" style="width: 30%;"><?php echo lang('layout_title'); ?></th>
								<th class="center" style="width: 20%;"><?php echo lang('layout_type'); ?></th>							
								<th class="center" style="width: 10%;"><?php echo lang('default'); ?></th>							
								<th class="center" style="width: 30%;"><?php echo lang('description'); ?></th>
								<th class="center" style="width: 5%;"><?php echo lang('id'); ?></th>
							</tr>
						</thead>
						
						<?php if(count($data)) { ?>
						<tbody>
							
							<?php foreach($data as $layout) { ?>
							<tr>
								<td class="center">									
									<input type="checkbox" class="checkb" value="<?php echo $layout->id; ?>" name="ids[]" />
								</td>
								
								<td class="text-left">
									<a href="<?php echo site_url('admin/layout/add/'.$layout->id); ?>" title="<?php echo $layout->title; ?>"><?php echo $layout->title; ?></a>
								</td>
								
								<td class="text-left">
									<?php echo $layout->layout; ?>
								</td>
								
								<td class="text-center">
									<?php if ($layout->default == 1) {?>
										<a class="btn btn-success btn-xs" href="javascript:void(0)">
											<i class="fa fa-star"></i>
										</a>
									<?php } else {?>
									<?php } ?>
								</td>
								
								<td class="text-left">
									<?php echo $layout->description; ?>
								</td>
								
								<td class="text-center">
									<?php echo $layout->id; ?>
								</td>
							</tr>
							<?php } ?>
							
						</tbody>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>
	</div>
</form>
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
	
	var url = '<?php echo site_url(). 'admin/layout/'; ?>' + type;
	jQuery('#adminForm').attr('action', url);
	jQuery('#adminForm').submit();
}
</script>
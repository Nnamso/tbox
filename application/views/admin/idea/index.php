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
<form id="adminForm" method="post" name="adminForm" action="<?php echo site_url('admin/idea/index'); ?>">
<!-- Start: Head tool -->
<div class="row">
	<div class="col-md-3">
		<input type="text" class="form-control" value="<?php echo $keyword; ?>" placeholder="Search art" name="keyword">
	</div>
	<div class="col-md-2">
		<button type="submit" class="btn btn-primary"><?php echo lang('search');?></button>
	</div>

	<div class="col-md-7">
		<p style="text-align:right;">
			<a class="btn btn-primary tooltips" title="<?php echo lang('add'); ?>" href="<?php echo site_url('admin/idea/edit')?>" >
				<i class="glyphicon glyphicon-plus"></i>
			</a>			
			<a id="btn-delete" class="btn btn-bricky tooltips" title="<?php echo lang('remove'); ?>" onclick="submit('remove')" href="javascript:void(0);" > 
				<i class="fa fa-trash-o"></i>
			</a>
		</p>
	</div>
</div>
<!-- End: Head tool -->

<!-- Start: list items -->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square icon-external-link-sign"></i>
				<?php echo lang('idea_title'); ?>
			</div>
		   
			<div class="panel-body" id="panelbody">
				<table id="sample-table-1" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th class="center">							
								<input id="select_all" type="checkbox" name='check_all'>							
							</th>
							<th class="center"><?php echo lang('title'); ?></th>
							<th class="center"><?php echo lang('slug'); ?></th>
							<th class="center"><?php echo lang('description'); ?></th>
							<th class="center"><?php echo lang('category'); ?></th>
							<th class="center"><?php echo lang('image'); ?></th>
							<th class="center"><?php echo lang('action'); ?></th>
						</tr>
					</thead>
					
					<tbody>
						
						<?php for($i=0; $i<count($items); $i++) { ?>
						<tr>
							
							<td class="center">								
								<input type="checkbox" name="ids[]" class="checkb" value="<?php echo $items[$i]->id; ?>">
							</td>
								
							<td class="center">
								<a href="<?php echo site_url('admin/idea/edit/'.$items[$i]->id); ?>" title="<?php echo $items[$i]->title; ?>">
									<?php echo $items[$i]->title; ?>
								</a>
							</td>
							
							<td class="center"><?php echo $items[$i]->slug; ?></td>
							
							<td class="center">								
								<?php echo $items[$i]->description; ?>								
							</td>
							
							<td class="center">
								<a href="<?php echo site_url('admin/idea/editcategory/'.$items[$i]->cate_id); ?>" title="<?php echo $items[$i]->cate_name; ?>">
									<?php echo $items[$i]->cate_name; ?>
								</a>
							</td>
							
							<td class="center">
							
							<?php 
							if ($items[$i]->image != '')
							{
								$images = explode(';', $items[$i]->image);
								echo '<img src="'.base_url($images[0]).'" width="100">';
							}
							?>
							
							</td>
							
							<td class="center">
								<a class="btn btn-danger btn-sm tooltips" href="<?php echo site_url('admin/idea/remove/'.$items[$i]->id); ?>" title="<?php echo lang('remove'); ?>">
									<i class="glyphicon glyphicon-trash"></i>
								</a>
							</td>
							
						</tr>
						<?php } ?>
						
					</tbody>
				</table>
				
				<div class="row">
					<div class="col-md-12 text-right">
						<?php echo $links; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" name="action" value="1"/>
</form>
<!-- End: list items -->
<script type="text/javascript">
jQuery('#select_all').click(function(){
	if ( jQuery(this).is(':checked') == true )
	{
		jQuery('.checkb').prop('checked', true);
	}
	else
	{
		jQuery('.checkb').prop('checked', false);
	}
});

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
	
	var url = '<?php echo site_url('admin/idea'); ?>/'+type;
	jQuery('#adminForm').attr('action', url);
	jQuery('#adminForm').submit();
}
</script>


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
<div id="refresh">
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
		<th class="center"><?php echo lang('id'); ?></th>
		<th class="center"><?php echo lang('colors_name_title'); ?></th>
		<th class="center"><?php echo lang('hex'); ?></th>
		<th class="center"><?php echo lang('published'); ?></th>
		<th class="center"><?php echo lang('action'); ?></th>
		</tr>
		</thead>
		<tbody>
			<?php if($colors)foreach ($colors as $color) { ?>
				<tr>
					<td class="center">
						<div class="checkbox-table">
							<label>
								<input type="checkbox" name="checkb[]" class="checkb" name="check" value="<?php echo $color->id; ?>">
							</label>
						</div>
					</td>
					<td class="center"><?php echo $color->id; ?></td>
					<td><?php echo $color->title; ?></td>
					<td class="center"><span class="tooltips" style="margin: 5px auto; display: block; height: 25px; width: 50px; background: #<?php echo $color->hex; ?>; border: 1px solid #CCCCCC;" data-original-title="#<?php echo $color->hex; ?>"></span></td>
					<td class="center"><?php if ($color->published == 1) { ?>					   
							<a class="btn btn-success btn-xs tooltips action" href="javascript:void(0);" data-original-title="<?php echo lang('click_publish');?>" data-placement="top" rel="unpublish" data-id="<?php echo $color->id; ?>" data-flag="1"><?php echo lang('publish'); ?></a>
						<?php } else { ?>
							<a class="btn btn-danger btn-xs tooltips action" href="javascript:void(0);" data-original-title="<?php echo lang('click_publish');?>" data-placement="top" rel="publish" data-id="<?php echo $color->id; ?>" data-flag="0"><?php echo lang('unpublish'); ?></a>
						<?php } ?>
					</td>
					<td class="center">
						<div class="visible-md visible-lg hidden-sm hidden-xs">
							<a href="javascript:;" rel="edit" class="btn btn-teal tooltips" data-placement="top" data-original-title="<?php echo lang('edit');?>" onclick="UIModals.init('<?php echo site_url(); ?>admin/settings/edit/colors/<?php echo $color->id;?>')">
								<i class="fa fa-edit"></i>
							</a>
							<a rel="del" class="remove btn btn-bricky tooltips action" data-placement="top" data-original-title="<?php echo lang('remove');?>" href="javascript:;" data-id="<?php echo $color->id; ?>">
							<i class="fa fa-times"></i></a>
						</div>
					</td>
				</tr>
			<?php } ?>    
		</tbody>
	</table>
	<div class="row">
		<div class="dataTables_paginate paging_bootstrap" style="float: right;">
			<div class="col-md-12">
			<?php echo $links;?>
			</div>
	   </div>
	</div>
</div>
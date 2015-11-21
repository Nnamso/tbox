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
			<th class="center"><?php echo lang('price'); ?></th>
			<th class="center"><?php echo lang('date'); ?></th>
			<th class="center"><?php echo lang('default'); ?></th>
			<th class="center"><?php echo lang('publish'); ?></th>
			<th class="center"><?php echo lang('action'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php if (is_array($shipping)) foreach ($shipping as $ship) { ?>
				<tr>
					<td class="center">
						<div class="checkbox-table">
							<label>
								<input type="checkbox" name="checkb[]" class="checkb" name="check" value="<?php echo $ship->id; ?>">
							</label>
						</div>
					</td>
					<td><?php echo $ship->title; ?></td>
					<td><?php echo $ship->description; ?></td>
					<td class="center"><?php echo $ship->price; ?></td>
					<td class="center">
						<?php 
							$date = new DateTime($ship->date);
							echo $date->format('Y-m-d');
						?>
					</td>
					<td class="center">
						<?php if($ship->default == 1){?>
							<a class="tooltips" href="javascript:void(0)" data-original-title="<?php echo lang('click_default');?>" data-placement="top"><i class="fa fa-check-square-o" style="font-size: 20px;"></i></a>
						<?php }else{ ?>
							<a class="tooltips action" href="javascript:void(0)" rel="default" data-id="<?php echo $ship->id; ?>" data-original-title="<?php echo lang('click_default');?>" data-placement="top"><i class="fa fa-square-o" style="font-size: 20px;"></i></a>
						<?php } ?>
					</td>
					<td class="center"><?php if ($ship->published == 1) { ?>					   
							<a class="btn btn-success btn-xs tooltips action" type="button" data-original-title="<?php echo lang('click_publish');?>" data-placement="top" rel="unpublish" data-id="<?php echo $ship->id; ?>" data-flag="1"><?php echo lang('publish'); ?></a>
						<?php } else { ?>
							<a class="btn btn-danger btn-xs tooltips action" type="button" data-original-title="<?php echo lang('click_publish');?>" data-placement="top" rel="publish" data-id="<?php echo $ship->id; ?>" data-flag="0"><?php echo lang('unpublish'); ?></a>
						<?php } ?>
					</td>
					<td class="center">
						<div class="visible-md visible-lg hidden-sm hidden-xs">
							<a href="javascript:;" rel="edit" class="btn btn-teal tooltips" data-placement="top" data-original-title="<?php echo lang('edit');?>" onclick="UIModals.init('<?php echo site_url(); ?>admin/settings/edit/shipping/<?php echo $ship->id; ?>')">
								<i class="fa fa-edit"></i>
							</a>
							<?php if($ship->default == 0) { ?>
								<a rel="del" class="remove btn btn-bricky tooltips action" data-placement="top" data-original-title="<?php echo lang('remove');?>" href="javascript:void(0);" data-id="<?php echo $ship->id; ?>">
									<i class="fa fa-times"></i>
								</a>
							<?php }else{ ?>
								<a class="remove btn btn-default tooltips" data-placement="top" data-original-title="<?php echo lang('remove');?>" href="javascript:void(0);">
									<i class="fa fa-times"></i>
								</a>
							<?php } ?>
						</div>
					</td>
				</tr>
			<?php } ?>    
	</tbody>
</table>
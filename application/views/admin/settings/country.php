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
<table id="sample-table-1" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th class="center">
			<div class="checkbox-table">
				<label>
					<input type="checkbox" name="check_all">
				</label>
			</div>
			</th>
			<th class="center"><?php echo lang('countries_name') ?></th>
			<th class="center"><?php echo lang('countries_code_2') ?></th>
			<th class="center"><?php echo lang('countries_code_3') ?></th>
			<th class="center"><?php echo lang('published') ?></th>
			<th class="center"><?php echo lang('id') ?></th>
			<th class="center"><?php echo lang('action') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php $stt = 0; ?>
		<?php foreach ($countries as $country): ?>
			<?php $stt++; ?>
			<tr>
				<td class="center">
				<div class="checkbox-table">
					<label>
						<input type="checkbox" class="checkb" value="<?php echo $country->id; ?>" name="checkb[]">
					</label>
				</div>
				</td>
				<td><?php echo $country->name; ?></td>
				<td class="center"><?php echo $country->code_2; ?></td>
				<td class="center"><?php echo $country->code_3; ?></td>
				<td class="center">
					<?php
					if ($country->published == 0)
						echo '<a class="btn btn-danger btn-xs tooltips action" type="button" data-original-title="'.lang('click_publish').'" data-placement="top" rel="publish" data-id="' . $country->id . '" data-flag="0">' . lang('unpublish') . '</a>';
					if ($country->published == 1)
						echo '<a class="btn btn-success btn-xs tooltips action" type="button" data-original-title="'.lang('click_unpublish').'" data-placement="top" rel="unpublish" data-id="' . $country->id . '" data-flag="1">' . lang('publish') . '</a>';
					?>
				</td>
				<td class="center"><?php echo $country->id; ?></td>
				<td class="center">
					<div class="visible-md visible-lg hidden-sm hidden-xs" id="dg-getid">
						<a data-original-title="<?php echo lang('edit');?>" data-placement="top" class="btn btn-teal tooltips" onclick="UIModals.init('<?php echo site_url('admin/settings/edit/countries/'.$country->id); ?>');">
							<i class="fa fa-edit"></i>
						</a>
						<a data-original-title="<?php echo lang('remove');?>" data-placement="top" class="btn btn-bricky tooltips action" data-id="<?php echo $country->id; ?>" rel="del">
							<i class="fa fa-times"></i>
						</a>
					</div>
					<div class="visible-xs visible-sm hidden-md hidden-lg">
						<div class="btn-group">
							<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-sm">
								<i class="icon-cog"></i> <span class="caret"></span>
							</a>
							<ul class="dropdown-menu pull-right" role="menu">
								<li role="presentation">
									<a href="#" tabindex="-1" role="menuitem">
										<i class="icon-edit"></i><?php echo lang('edit') ?>
									</a>
								</li>
								<li role="presentation">
									<a href="#" tabindex="-1" role="menuitem">
										<i class="icon-remove"></i> <?php echo lang('remove') ?>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<div class="row">
	<div class="dataTables_paginate paging_bootstrap" style="float: right;">
		<div class="col-md-12">
		<?php echo $links;?>
		</div>
   </div>
</div>
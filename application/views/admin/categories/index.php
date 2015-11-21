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
<section>
	<h2><?php echo lang('category_pages');?></h2>
	<?php echo anchor('admin/page/edit', '<i class="icon-plus"></i> Add a page'); ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th><?php echo lang('category_title');?></th>
				<th><?php echo lang('category_parent');?></th>
				<th><?php echo lang('category_edit');?></th>
				<th><?php echo lang('category_title');?></th>
			</tr>
		</thead>
		<tbody>
<?php if(count($pages)): foreach($pages as $page): ?>	
		<tr>
			<td><?php echo anchor('admin/page/edit/' . $page->id, $page->title); ?></td>
			<td><?php echo $page->parent_slug; ?></td>
			<td><?php echo btn_edit('admin/page/edit/' . $page->id); ?></td>
			<td><?php echo btn_delete('admin/page/delete/' . $page->id); ?></td>
		</tr>
<?php endforeach; ?>
<?php else: ?>
		<tr>
			<td colspan="3"><?php echo lang('category_find_pages');?></td>
		</tr>
<?php endif; ?>	
		</tbody>
	</table>
</section>
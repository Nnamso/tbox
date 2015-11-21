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
<table id="table_order_history" class="table table-bordered table-hover">
	<thead>
		<tr>
			<th class="center" style="width: 10%;"><?php echo lang('number'); ?></th>
			<th class="center" style="width: 10%;"><?php echo lang('type'); ?></th>
			<th class="center"><?php echo lang('name'); ?></th>
			<th class="center" style="width: 15%;"><?php echo lang('status'); ?></th>
			<th class="center" style="width: 20%;"><?php echo lang('date'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php $count = 1; ?>
		<?php foreach($histories as $history){ ?>
			<tr>
				<td class="center"><?php echo $count;?></td>
			<?php foreach($history as $key=>$val){ ?>
					<?php 
						if($key == 'content')
						{
							$item = json_decode($val);
							foreach($item as $k=>$v)
							{
								echo '<td>'.$k.'</td>';
								echo '<td>'.$v.'</td>';
							}
						}elseif($key == 'label')
						{
							if($val == 'order_status')
								echo '<td class="center">'.lang('orders_admin_order_title').'</td>';
							else
								echo '<td class="center">'.lang('orders_admin_order_item_title').'</td>';
						}elseif($key == 'date')
						{
							echo '<td class="center">'.$val.'</td>';
						}
					?>
			<?php } ?>
			</tr>
			<?php $count++; ?>
		<?php } ?>
	</tbody>
</table>
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

<div class="row">
	
<?php if (count($categories) > 0 ) {?>
			
	<?php foreach($categories as $row) { ?>
	<div class="col-xs-4 col-sm-3 col-md-2 text-center form-group">
		
		<a href="<?php echo site_url('idea/'.$row->id.'-'.$row->slug); ?>" title="<?php echo $row->title; ?>">
		<?php if ($row->image == '') { ?>
			<img src="<?php echo base_url('assets/images/default.png'); ?>" alt="<?php echo $row->title; ?>" class="img-responsive img-thumbnail">
		<?php } else { ?>
			<img src="<?php echo base_url($row->image); ?>" alt="<?php echo $row->title; ?>" class="img-responsive img-thumbnail">
		<?php } ?>
		</a>
		
		<a href="<?php echo site_url('idea/'.$row->id.'-'.$row->slug); ?>" title="<?php echo $row->title; ?>"><?php echo $row->title; ?></a>
	</div>
	<?php } ?>	
	
<?php } else { ?>
	<!-- product not found -->
	<h3><?php echo lang('data_not_found'); ?></h3>	
<?php } ?>

</div>
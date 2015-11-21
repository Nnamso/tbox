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

<!-- main image -->
<?php if ($product->image != '') { ?>
<div class="main-image text-center">
	<a href="#" title="<?php echo $product->title; ?>">
		<img src="<?php echo base_url($product->image); ?>" alt="<?php echo $product->title; ?>" data-zoom-image="<?php echo base_url($product->image); ?>" class="img-thumbnail img-responsive">
	</a>
</div>
<?php } ?>
<br/>
<!-- List images -->
<?php 
if ($product->gallery != '') {
	$gallery = explode(';', $product->gallery);
?>
<div class="main-gallery">
	<?php foreach ($gallery as $image) { ?>
	<a href="javascript:void(0)" class="outline-none" data-zoom-image="<?php echo base_url($image); ?>">
		<img src="<?php echo base_url($image); ?>" width="50" alt="<?php echo $product->title; ?>" class="img-thumbnail img-responsive">
	</a>
	<?php } ?>
</div>
<?php } ?>
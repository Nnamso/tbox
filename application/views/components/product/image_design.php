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
<?php 
if ( $product->design->front != '' && isset($product->design->front[$index]) && $product->design->front[$index] != '' ) {
?>
<div class="main-image text-center">
	<a href="#" title="<?php echo $product->title; ?>">		
		<img src="<?php echo site_url('api/image/'.$product->id.'/front/'.$index.'.png'); ?>" alt="<?php echo $product->title; ?>" class="img-thumbnail img-responsive">		
	</a>
</div>
<?php } ?>

<div class="main-gallery">
	<?php if ( $product->design->front != '' && isset($product->design->front[$index])  && $product->design->front[$index] != '' ) { ?>
	<a href="javascript:void(0)" class="outline-none" data-zoom-image="<?php echo site_url('api/image/'.$product->id.'/front/'.$index); ?>">
		<img src="<?php echo site_url('api/image/'.$product->id.'/front/'.$index); ?>" width="50" alt="<?php echo $product->title; ?>" class="img-thumbnail img-responsive">
	</a>
	<?php } ?>
	
	<?php if ( $product->design->back != '' && isset($product->design->back[$index])  && $product->design->back[$index] != '' ) { ?>
	<a href="javascript:void(0)" class="outline-none" data-zoom-image="<?php echo site_url('api/image/'.$product->id.'/back/'.$index); ?>">
		<img src="<?php echo site_url('api/image/'.$product->id.'/back/'.$index); ?>" width="50" alt="<?php echo $product->title; ?>" class="img-thumbnail img-responsive">
	</a>
	<?php } ?>
	
	<?php if ( $product->design->left != '' && isset($product->design->left[$index])  && $product->design->left[$index] != '' ) { ?>
	<a href="javascript:void(0)" class="outline-none" data-zoom-image="<?php echo site_url('api/image/'.$product->id.'/left/'.$index); ?>">
		<img src="<?php echo site_url('api/image/'.$product->id.'/left/'.$index); ?>" width="50" alt="<?php echo $product->title; ?>" class="img-thumbnail img-responsive">
	</a>
	<?php } ?>
	
	<?php if ( $product->design->right != '' && isset($product->design->right[$index])  && $product->design->right[$index] != '' ) { ?>
	<a href="javascript:void(0)" class="outline-none" data-zoom-image="<?php echo site_url('api/image/'.$product->id.'/right/'.$index); ?>">
		<img src="<?php echo site_url('api/image/'.$product->id.'/right/'.$index); ?>" width="50" alt="<?php echo $product->title; ?>" class="img-thumbnail img-responsive">
	</a>
	<?php } ?>
</div>
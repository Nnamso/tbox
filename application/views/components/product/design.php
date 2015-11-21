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

//echo '<pre>'; print_r($design); exit;
$design		= $product->design;
$colors 	= count($design->color_hex);
?>

<div class="color-swatches" id="product-colors">

	<?php 
	for($i=0; $i<$colors; $i++ ){
		if ($i === $index) $active = 'active';
		else $active = '';
	?>
	<a href="<?php echo site_url('product/'.$product->id.'-'.$product->slug.'/'.$i.'-'.url_title($design->color_title[$i])); ?>" class="color-swatch color-sm <?php echo $active; ?>" data-toggle="tooltip" data-placement="top" style="background-color:#<?php echo $design->color_hex[$i]; ?>" title="<?php echo $design->color_title[$i]; ?>"></a>
	<?php } ?>
	<input type="hidden" value="<?php echo $index; ?>" name="colors" class="product_color_active">
</div>
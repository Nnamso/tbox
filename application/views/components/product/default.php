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


// ech price
if ($product->sale_price > 0)
{
	$sale 	= true;
	$price 	= $product->sale_price;
}
else
{
	$sale = false;
	$price 	= $product->price;
}

$currency	= $product_m->getCurrency($product->currency_id);
$link 		= site_url('product/'.$product->id .'-'. $product->slug);
?>

<?php if (count($product)) { ?>	
	<script src="<?php echo base_url('assets/plugins/easyzoom/js/jquery.elevatezoom.js'); ?>"></script>
	<div class="row">
		<!-- product image -->
		<div class="col-md-6">
			<?php
			if ($color_load === true)
			{
				$this->load->view('components/product/image_design', array('index'=>$index, 'product'=>$product));
			}
			else
			{
				$this->load->view('components/product/image', array('product'=>$product));
			}
			?>			
		</div>
		
		<!-- product info -->
		<div class="col-md-6">
			<div class="page-header">
				<h2>
					<?php echo $product->title; ?>
					
					<?php if (isset($color_active)) { ?>
					<small><?php echo $color_active; ?></small>
					<?php } ?>
				</h2>
			</div>
			
			<!-- rating -->
			
			<!-- SKU -->
			<p><?php echo lang('sku'); ?>: <strong><?php echo $product->sku; ?></strong></p>
			
			<!-- product short description -->
			<div class="form-group">
				<?php echo $product->short_description; ?>
			</div>
			
			<!-- product price -->
			<div class="form-group">
				<p class="price">
					<?php echo lang('price'); ?>: 
					<?php if($price != $product->price) { ?>
					<span class="price-old text-muted">
						<del><small><?php echo $currency->currency_symbol .''. $product->price; ?></small></del>
					</span>
					<?php } ?>
					
					<span class="price-new text-danger">
						<strong><?php echo $currency->currency_symbol .''. $price; ?></strong>
					</span>
				</p>
			</div>
			
			<!-- product attribute -->
			<?php if (isset($product->attributes)) { ?>
			<div class="form-group">
				<?php echo $product->attributes; ?>
			</div>
			<?php } ?>			
			
			<!-- product design -->
			<?php if (isset($product->design)) { ?>
			<div class="form-group">
				<?php $this->load->view('components/product/design', array('index'=>$index, 'product'=>$product)); ?>
			</div>
			<?php } ?>
			
			<!-- form -->
			<div class="form-group clearfix">
				<form name="addtocart" class="addtocart" action="" method="post">
					<!--
					<button type="button" class="btn btn-primary pull-left"><i class="fa fa-shopping-cart"></i> Add To Cart</button>
					-->
					
					<?php if (isset($product->design) && $product->design->front != '') { ?>
					<a class="btn btn-primary pull-left" title="Click to custom this product" href="<?php echo site_url('design/index/'.$product->id.'-'.$product->slug); ?>"><i class="glyphicon glyphicon-pencil"></i> Start Designing</a>
					<?php } ?>
				</form>
			</div>
			
			<!-- share -->
			<hr class="clearfix">
			<div class="form-group clearfix">
				<a  target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $link; ?>" class="btn btn-primary btn-circle btn-facebook" title="Facebook"><i class="fa fa-facebook"></i></a>
				<a  target="_blank" href="https://twitter.com/home?status=<?php echo $link; ?>" class="btn btn-primary btn-circle btn-twitter" title="twitter"><i class="fa fa-twitter"></i></a>
				<a  target="_blank" href="https://plus.google.com/share?url=<?php echo $link; ?>" class="btn btn-primary btn-circle btn-google" title="google"><i class="fa fa-google-plus"></i></a>
				<a  target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php echo $link; ?>&amp;media=<?php echo $product->image; ?>&amp;description=<?php echo $product->short_description; ?>" class="btn btn-primary btn-circle btn-pinterest" title="pinterest"><i class="fa fa-pinterest"></i></a>
			</div>
		</div>
	</div>
	
	<!-- product tab -->
	<div class="row">
		<div class="col-md-12">
			 <ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
					<a href="#product-description" class="outline-none" aria-controls="product-description" role="tab" data-toggle="tab">Description</a>
				</li>
				<li role="presentation">
					<a href="#product-reviews" class="outline-none" aria-controls="product-reviews" role="tab" data-toggle="tab">Reviews</a>
				</li>
			</ul>
			
			<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=435908239812114&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

			<div class="tab-content tab-content-border">
				<div role="tabpanel" class="tab-pane active" id="product-description">
					<?php echo $product->description; ?>
				</div>
				<div role="tabpanel" class="tab-pane" id="product-reviews">
					<div class="fb-comments" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
				</div>			
			</div>
		</div>
	</div>
	
	<!-- RELATED PRODUCTS -->
	<div class="row">
		<?php $this->load->view('components/product/related', array('index'=>$index, 'products'=>$products, 'product_m'=>$product_m)); ?>
	</div>
	
<script type="text/javascript">
jQuery(function() {
	jQuery( ".list-number input.size-number" ).spinner({
		min: 0,
		max: 100,
	});
	jQuery('[data-toggle="tooltip"]').tooltip();
	jQuery(".main-image img").elevateZoom();
	jQuery('.main-gallery a').click(function(){
		jQuery('.main-image img').attr('src', jQuery(this).data('zoom-image'));
		jQuery('.main-image img').attr('data-zoom-image', jQuery(this).data('zoom-image'));
		var ez = jQuery('.main-image img').data('elevateZoom');	
		ez.swaptheimage(jQuery(this).data('zoom-image'), jQuery(this).data('zoom-image'));
	});
});
</script>	

<?php } else { ?>
<div class="row">
	<!-- product not found -->
	<h3><?php echo lang('data_not_found'); ?></h3>
	<p><?php echo lang('categories_default_product_not_found_desc'); ?></p>
</div>
<?php } ?>
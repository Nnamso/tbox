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

$count = count($products) + count($designs) + count($blog);
$this->load->helper('text');
?>
<div class="row">
	<div class="col-sm-6 text-left">
		<h2><?php echo lang('search_results'); ?></h2>
		<p><?php echo lang('search_all_your_search_for'); ?> <strong><?php echo $keyword; ?></strong> <?php echo lang('search_all_returned'); ?> <?php echo $count; ?> <?php echo lang('search_all_results'); ?></p>
	</div>
	
	<div class="col-sm-6 text-right">
		<br/>
		<div class="text-left pull-right">
			<p><?php echo lang('search_filter_by'); ?></p>
			<a href="#" class="btn btn-default btn-sm"><span class="badge"><?php echo $count; ?></span> <?php echo lang('all'); ?></a>
			 <a href="#" class="btn btn-default btn-sm"><span class="badge"><?php echo count($products); ?></span> <?php echo lang('products'); ?></a>
			 <a href="#" class="btn btn-default btn-sm"><span class="badge"><?php echo count($designs); ?></span> <?php echo lang('designs'); ?></a>
			 <a href="#" class="btn btn-default btn-sm"><span class="badge"><?php echo count($blog); ?></span> <?php echo lang('posts'); ?></a>
		</div>
	</div>
</div>

<!-- list products -->
<?php if (count($products)) { ?>
<hr />
<h3><?php echo lang('products'); ?></h3>
<div class="row">
	<div class="category-products clearfix" style="display: table; width: 100%;">
		
		<?php foreach($products as $product) { ?>
		<div class="col-xs-6 col-sm-4 col-md-2 text-center form-group" style="display:inline-block;float:none;">
			
			<div class="thumbnail layout-product">
				<a title="<?php echo $product->title; ?>" href="<?php echo site_url('product/'.$product->id.'-'.$product->slug); ?>">
					<img class="img-responsive" alt="<?php echo $product->title; ?>" src="<?php echo base_url($product->image); ?>">
					<br />
					<center><?php echo $product->title; ?></center>
				</a>
			</div>
			
		</div>
		<?php } ?>
		
	</div>
</div>
<?php } ?>

<!-- list design -->
<?php if (count($designs)) { ?>
<h3><?php echo lang('designs'); ?></h3>
<hr />
<div class="row">
	<div class="category-products clearfix">
		
		<?php foreach($designs as $design) { ?>
		<div class="col-xs-6 col-sm-4 col-md-2 text-center form-group" style="display:inline-block;float:none;">
			
			<div class="thumbnail layout-product">
				<a title="<?php echo $design->title; ?>" href="<?php echo site_url('design/index/'.$design->product_id.'/'.$design->product_options.'/'.$design->design_key); ?>">
					<img class="img-responsive" alt="<?php echo $design->title; ?>" src="<?php echo base_url($design->image); ?>">
					<br />
					<center><?php echo $design->title; ?></center>
				</a>
			</div>
			
		</div>
		<?php } ?>
		
	</div>
</div>
<?php } ?>

<!-- list blog -->
<?php if (count($blog)) { ?>
<h3><?php echo lang('page_blog_posts'); ?></h3>
<hr />
<div class="row">
	<div class="category-products clearfix">
		
		<?php foreach($blog as $post) { ?>
		<div class="col-md-12 form-group article-show">			
			<h5>
			<a title="<?php echo $post->title; ?>" href="<?php echo site_url('blog/post/'.$post->id.'-'.$post->slug); ?>">
				<strong><?php echo $post->title; ?></strong>
			</a>
			</h5>
			<p>
				<?php echo word_limiter(strip_tags($post->description), 40); ?>
			</p>
			<a title="<?php echo $post->title; ?>" href="<?php echo site_url('blog/post/'.$post->id.'-'.$post->slug); ?>" class="btn btn-xs btn-primary"> <?php echo lang('page_blog_readmore_title'); ?></a>			
			
		</div>
		
		<?php } ?>
		
	</div>
</div>
<?php } ?>

<?php if ($count == 0) { ?>
<hr />
<h3><?php echo lang('data_not_found'); ?></h3>
<br />
<?php } ?>
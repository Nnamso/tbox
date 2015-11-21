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
	
<?php if (count($category) > 0 ) {?>
	
	<!-- category info -->
	<div class="category-info clearfix">
		<div class="page-header">
		  <h1><?php echo $category->title; ?></h1>
		</div>
		
		<?php if ($category->image != '' || $category->description != '') { ?>
		<div class="media">
			<?php if ($category->image != '') { ?>
			<a class="pull-left col-xs-4 col-sm-3 col-md-3 thumbnail" href="">
				<img src="<?php echo base_url($category->image); ?>" alt="<?php echo $category->title; ?>" class="img-responsive media-object">
			</a>
			<?php } ?>
			
			<?php if ($category->description != '') { ?>
			<div class="media-body col-xs-7 col-sm-8 col-md-8">
				<div class="text-block"><?php echo $category->description; ?></div>
			</div>
			<?php } ?>
			
		</div>
		<?php } ?>
	</div>
	
	<!-- List subcategory -->
	<?php if ( isset($category->children) && count($category->children) > 0 ) { ?>
	<hr />
	<h3><?php echo lang('idea_category_list_categories'); ?></h3>
	<div class="row category-sub clearfix">
		
		<?php foreach($category->children as $row) { ?>
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
		
	</div>
	<?php } ?>
	
	<!-- list design idea -->
	<?php if ( count($category->items) > 0) { ?>
	
		<hr />
		<h3><?php echo lang('idea_category_desigh_ideas'); ?></h3>
		
		<div class="toolbar product-filter clearfix row">
			<?php //echo $this->load->view('components/categories/filter', array('category'=>$category, 'page'=>$page)); ?>
		</div>
		
		<div class="row list-idea">
			<?php foreach ( $category->items as $design) { ?>
			<div class="col-xs-6 col-sm-4 col-md-3 text-center form-group">
				<div class="thumbnail layout-product">
				<?php
					$images = explode(';', $design->image);
					for($i=0; $i<count($images); $i++){
						echo '<img src="'.base_url($images[$i]).'" alt="'.$design->title.'" class="img-responsive">';
					}
				?>
					<div class="text-center">					
						<a href="<?php echo site_url('design/index/'.$design->product_id.'/'.$design->product_options.'/'.$design->design_key); ?>" title="<?php echo $design->title; ?>"><?php echo $design->title; ?></a>					
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
		
		<!-- pagination -->
		<?php if ($pagination != '') { ?>
		<hr>
		<div class="row text-right">
			<div class="col-md-12">
				<?php echo $pagination; ?>
			</div>
		</div>
		<?php } ?>
		
	<?php } ?>
	
<?php } else { ?>
	<!-- product not found -->
	<h3><?php echo lang('data_not_found'); ?></h3>	
<?php } ?>

</div>
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

$data 	= json_decode(json_encode($data));
?>

<script src="<?php echo base_url('assets/plugins/tinymce/tinymce.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.css'); ?>">

<form action="<?php echo site_url('admin/idea/save'); ?>" method="post" id="fr-product">

<div class="row">
	<div class="col-md-5 text-right pull-right">
		<button type="submit" class="btn btn-primary tooltips" title="<?php echo lang('save'); ?>"><i class="glyphicon glyphicon-floppy-disk"></i></button>
		<a href="<?php echo site_url('admin/idea'); ?>" class="btn btn-danger tooltips" title="<?php echo lang('close'); ?>"><i class="glyphicon glyphicon-remove"></i></a>
	</div>
</div>
<hr />
<div class="row">
	<!-- art template info -->
	<div class="col-sm-7 col-md-7 pull-left">
		<div class="form-group">
			<label ><?php echo lang('title'); ?></label>
			<input type="text" name="data[title]" value="<?php echo $data->title; ?>" placeholder="<?php echo lang('title'); ?>" class="form-control validate required">
		</div>
		
		<div class="form-group">
			<label ><?php echo lang('slug'); ?></label>
			<input type="text" name="data[slug]" value="<?php echo $data->slug; ?>" placeholder="<?php echo lang('title'); ?>" class="form-control validate required">
		</div>
		
		<div class="form-group">
			<label><?php echo lang('choose_category'); ?></label>
			<select class="form-control" name="data[cate_id]">
			<?php 
				$cate_val = array(
					'0'=>set_value('data[cate_id]', $data->cate_id)
				);				
				echo dispayCateTree($categories, 0, $cate_val);				
			?>
			</select>
		</div>
												
		<div class="form-group">
			<label ><?php echo lang('description'); ?></label>
			<textarea name="data[description]" rows="8" class="text-edittor" style="width:100%"><?php echo $data->description; ?></textarea>
		</div>
	</div>
	
	<!-- art design -->
	<div class="col-sm-4 col-md-4 pull-right">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="clip-list"></i>
				<?php echo lang('page_left_admin_list_clipart'); ?>
			</div>
			<div class="panel-body">
				<?php
					$images 	= explode(';', $data->image);
				?>
				<div class="product-gallery">					
				</div>
				<input id="product_gallery" type="hidden" value="<?php echo $data->image; ?>" name="data[image]">
			</div>
			<div class="panel-footer text-right">
				<a class="btn btn-default btn-xs tooltips" href="#" onclick="jQuery.fancybox( {href : '<?php echo site_url('admin/media/modals/gallery/2') ?>', type: 'iframe'} );" title="<?php echo lang('add_images');?>"><i class="glyphicon glyphicon-plus"></i> <?php echo lang('add_images'); ?></a>
				<a class="btn btn-primary btn-xs tooltips" onclick="jQuery.fancybox( {href : '<?php echo site_url('admin/design/modal') ?>', type: 'iframe'} );" style="color:#FFF;" href="#" role="button" title="<?php echo lang('choose_design');?>"><i class="glyphicon glyphicon-plus"></i> <?php echo lang('choose_design'); ?></a>
			</div>
		</div>
	</div>
	
	<!-- art meta -->
	<div class="col-sm-4 col-md-4 pull-right">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="clip-list"></i>
				<?php echo lang('meta_info'); ?>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label><?php echo lang('products_edit_category_meta_title'); ?></label>
					<input type="text" class="form-control" name="data[meta_title]" value="<?php echo $data->meta_title; ?>">
				</div>
				<div class="form-group">
					<label><?php echo lang('products_edit_category_meta_keyword'); ?></label>
					<textarea rows="2" class="form-control" name="data[meta_keywords]"><?php echo $data->meta_keywords; ?></textarea>
				</div>
				<div class="form-group">
					<label><?php echo lang('products_edit_category_meta_description'); ?></label>
					<textarea rows="2" class="form-control" name="data[meta_description]"><?php echo $data->meta_description; ?></textarea>
				</div>
			</div>
		</div>
	</div>
</div>
	<input type="hidden" value="<?php echo $data->design_id; ?>" name="data[design_id]" id="design_id">
	<input type="hidden" value="<?php echo $data->id; ?>" name="data[id]" id="design_id">
</form>
<script type="text/javascript">

jQuery('.tooltips').tooltip();

var base_url = '<?php echo site_url(); ?>';
var url = '<?php echo base_url(); ?>';
function gallery(images, addUrl)
{
	if (typeof addUrl == 'undefined') addUrl = '';
	dgUI.product.gallery(images, addUrl);		
}
<?php if ($data->image != '') { ?>
	var images = [];
	
	<?php for($i=0; $i<count($images); $i++){ ?>
	images.push('<?php echo base_url($images[$i]); ?>');
	<?php } ?>

	dgUI.product.gallery(images);
<?php } ?>

function Insertdesign(id, image)
{
	var images = [image];
	jQuery('#design_id').val(id);
	gallery(images);
}
</script>
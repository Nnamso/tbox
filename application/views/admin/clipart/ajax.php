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

if($arts)
{	
	foreach($arts as $art)
	{							
		$images = imageArt($art);
?>
	<div class="col-sm-3 col-md-2 box-art">
		<a class="box-image" data-toggle="modal" href="javascript:void(0)" title="<?php echo $art->title; ?>">
			<img src="<?php echo $images->thumb; ?>" alt="" class="img-responsive">
		</a>
		<a class="box-edit" href="javascript:void(0);" onclick="UIModals.init('<?php echo site_url('admin/art/edit/'.$art->clipart_id.'/?cate_id='.$art->cate_id); ?>')" title="<?php lang('edit'); ?>">
			<i class="fa fa-pencil"></i>								
		</a>
		<span class="box-publish">
			<input type="checkbox" class="checkb" name="ids[]" value="<?php echo $art->clipart_id; ?>">
		</span>
		
		<?php if ($art->system == 1 && $art->system_id > 0 ){ ?>
			<span class="box-art-cart fa fa-plus" title="This art is added in store"></span>
		<?php } ?>
		<?php if ($art->add_price > 0 ){ ?>
			<div class="box-detail-price">$<?php echo $art->add_price; ?></div>
		<?php } ?>
	</div>
<?php 
	}
?>
	<!-- begin pagination -->
	<div class="clear-line clear-line-head col-md-12"></div>
	<div id="arts-pagination" class="pull-right col-md-12 text-right">
		<?php echo $this->pagination->create_links(); ?>
	</div>
	<!-- end pagination -->
<?php 
}else{
	echo '<div class="col-md-2 col-sm-3 box-art">' . lang('data_not_found') .'</div>';
}
?>	
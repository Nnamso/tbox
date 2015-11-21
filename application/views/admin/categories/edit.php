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
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title"><?php echo lang('category_edit'); ?></h4>
</div>

<form class="form-horizontal" id="art-add-category" method="post" action="<?php echo site_url('admin/categories/edit'); ?>">
<div class="modal-body">	
	<div class="form-group">
		<label for="inputPassword" class="col-sm-2"><?php echo lang('parent'); ?></label>
		<div class="col-sm-10">	
			<select name="cateLang[parent_id]" class="form-control form-control input-sm" id="product-category-parent">
				<option value="0"><?php echo lang('art_parent_category'); ?></option>
				<?php echo dispayTree( $categories, 0, array('type'=>'select', 'name'=>''), array($category->parent_id) ); ?>
			</select>			
		</div>
	</div>	
  
	<ul id="nav-tabs-lang" class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#"><?php echo lang('art_category_info'); ?></a></li>		
	</ul>
	<div class="tab-content" id="tab-content-lang">
		<div id="en" class="tab-pane active">			
			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo lang('title'); ?></label>
				<div class="col-sm-6">
					<input type="text" value="<?php echo $category->title; ?>" placeholder="<?php echo lang('add_title'); ?>" class="form-control" name="cateLang[title]">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo lang('slug'); ?></label>
				<div class="col-sm-6">
					<input type="text" value="<?php echo $category->slug; ?>" placeholder="<?php echo lang('add_slug'); ?>" class="form-control" name="cateLang[slug]">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo lang('description'); ?></label>
				<div class="col-sm-10">
					<textarea placeholder="<?php echo lang('add_description'); ?>" class="form-control textarea-tinymce" name="cateLang[description]"><?php echo $category->description; ?></textarea>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" data-dismiss="modal" class="btn modal-close"><?php echo lang('close'); ?></button>
	<button type="button" id="loading-example-btn" data-loading-text="<?php echo lang('save'); ?>..." class="btn btn-primary" onclick="dgUI.ajax.getfrom('#art-add-category')"><?php echo lang('save'); ?></button>
</div>
<input type="hidden" value="<?php echo $category->id; ?>" name="clip_id">
<?php echo form_close(); ?>
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
	<h4 class="modal-title"><?php echo $title; ?></h4>
</div>
		
<?php if(count($art)) { ?>

	<?php
	$attribute = array('class'=>'form-horizontal', 'id'=>'add-clipart', 'enctype'=>'multipart/form-data');
	echo form_open('', $attribute);
	 ?>
	<div class="modal-body">
		<!-- upload -->
		<div class="form-group">
			<div class="alert alert-warning fade in">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>Choose file upload</strong><br>
				<small>we supported file .jpg, .gif, .png, .svg</small><br>
				<small>Max size 5MB</small>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-4">
				<?php echo lang('art_upload_file'); ?>				
			</label>
			<div class="col-sm-8" style="overflow: hidden;">
				<?php echo form_upload('file', '', 'id="dg-file"'); ?>
				<div id="image-list">
					<?php if (isset($images->fle_url) && $images->fle_url != '') { ?>
						<?php $images = imageArt($art); ?>
						<img src="<?php echo $images->thumb; ?>" />
					<?php } ?>
				</div>
				<div id="response"></div>
				<div id="file-data">
					<input type="hidden" value="<?php echo $art->fle_url; ?>" name="art[fle_url]" id="fle_url">
					<input type="hidden" value="<?php echo $art->file_name; ?>" name="art[file_name]" id="file_name">
					<input type="hidden" value="<?php echo $art->file_type; ?>" name="art[file_type]" id="file_type">
					<input type="hidden" value='<?php echo $art->colors; ?>' name="art[colors]" id="file_colors">					
				</div>
			</div>
		</div>
				
		<!-- change color -->
		<div class="form-group">
			<label class="col-sm-4"><?php echo lang('art_change_color'); ?></label>
			<div class="col-sm-8">
				<?php echo form_checkbox('art[change_color]', 1, $art->change_color); ?>
			</div>
		</div>
				
		<!-- my category -->
		<div class="form-group">
			<label class="col-sm-4">
				<?php echo lang('category_my'); ?>
				<i title="<?php echo lang('category_my_description'); ?>" class="glyphicon glyphicon-question-sign popover-dismiss tooltips"></i>
			</label>
			<div class="col-sm-5">
				<select name="art[cate_id]" class="form-control form-control input-sm">					
					<?php echo dispayTree( $categories, 0, array('type'=>'select', 'name'=>''), array($art->cate_id) ); ?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4"><?php echo lang('type'); ?></label>
			<div class="col-sm-5">
				<?php echo form_dropdown('art[type]', array('vector', 'photo', 'icon'), $art->type, ' class="form-control"'); ?>
			</div>
		</div>		
		
		<ul id="nav-tabs-lang" class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#"><?php echo lang('art_info'); ?></a></li>		
		</ul>
		<div class="tab-content" id="tab-content-lang">
			<div id="en" class="tab-pane active">			
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo lang('title'); ?></label>
					<div class="col-sm-6">
						<input type="text" placeholder="<?php echo lang('add_title'); ?>" value="<?php echo $art->title; ?>" class="form-control" id="artlang_title" name="art[title]">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo lang('slug'); ?></label>
					<div class="col-sm-6">
						<input type="text" placeholder="<?php echo lang('add_slug'); ?>" value="<?php echo $art->slug; ?>" class="form-control" name="art[slug]">
					</div>
				</div>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo lang('description'); ?></label>
					<div class="col-sm-10">
						<textarea placeholder="<?php echo lang('add_description'); ?>" class="form-control textarea-tinymce" name="art[description]"><?php echo $art->description; ?></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" data-dismiss="modal" class="btn modal-close"><?php echo lang('close');?></button>
		<button type="button" class="btn btn-primary" onclick="dgUI.art.validation()"><?php echo lang('save');?></button>
	</div>
	<?php echo form_hidden('action', 'save'); ?>	
	<?php echo form_hidden('clipart_id', $art->clipart_id); ?>
	<?php echo form_close(); ?>
	
	<script type="text/javascript">
		var vail = new Array();
		vail['art_msg_upload_choose'] = '<?php echo lang('art_msg_upload_choose'); ?>';
		vail['art_msg_upload'] = '<?php echo lang('art_msg_upload'); ?>';
		vail['art_msg_price'] = '<?php echo lang('art_msg_price'); ?>';
		vail['art_msg_info'] = '<?php echo lang('art_msg_info'); ?>';					
	</script>
<?php }else{ ?>

	<div class="modal-body">
		<?php echo lang('data_not_found'); ?>
	</div>
	
	<div class="modal-footer">
		<button type="button" data-dismiss="modal" class="btn modal-close"><?php echo lang('close');?></button>		
	</div>
<?php } ?>

<script type="text/javascript">
	jQuery('.tooltips').tooltip();
</script>
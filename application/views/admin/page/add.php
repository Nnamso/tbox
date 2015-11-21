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
<script type="text/javascript">
var base_url = '<?php echo site_url(); ?>';
jQuery(document).ready(function() {
	jQuery('#module-setting').on('hidden.bs.modal', function (e) {		
		if (typeof tinymce != 'undefined' && tinymce.activeEditor != null)
		{
			tinymce.activeEditor.destroy();
		}
	});
});
</script>
<style>#list-modules ul.nav-tabs li:last-child{display:none;}</style>
<script src="<?php echo base_url('assets/admin/js/grid.js'); ?>"></script>
<link href="<?php echo base_url('assets/admin/css/grid.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url('assets/admin/js/jscolor/jscolor.js'); ?>"></script>

<div class="row">
	<div class="col-md-6 pull-left text-left">
		<?php if ($page->title != '') { ?>
		<h3><?php echo $page->title; ?></h3>
		<?php } else { ?>
			<h3 class="padding-0"><?php echo 'Add New'; ?></h3>
		<?php }?>
		
	</div>
	<div class="col-md-5 pull-right text-right">
		<button type="button" class="btn btn-primary" onclick="grid.page.view(this)"><?php echo lang('save'). '&' .lang('edit'); ?></button>
		<a class="btn btn-danger" href="<?php echo site_url('admin/page'); ?>" title="Close"><?php echo lang('close'); ?></a>
	</div>
</div>
<hr />

<!-- begin main app -->
<div class="panel panel-default">
	<div class="panel-heading">
		<i class="clip-fullscreen"></i> <?php echo lang('page_name'); ?>
		
		<div class="panel-tools">
			<a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>			
			<a class="btn btn-xs btn-link panel-expand" href="#">
				<i class="clip-fullscreen"></i>
			</a>			
		</div>
	</div>
	<div class="panel-body">
		<div class="container-fluid" id="main-app"><?php echo $page->content; ?></div>
	</div>
</div>
<!-- End main app -->


<center>
	<a id="add-row" onclick="grid.row.add()" href="javascript:void(0)" class="btn btn-primary" title="Click to add a row">
		<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <?php echo lang('page_add_row'); ?>
	</a>	
</center>

<!-- show list module -->
<div class="modal fade" id="list-modules">
	<div class="modal-dialog g-modal modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo lang('page_add_element'); ?></h4>
			</div>
			
			<div class="modal-body"></div>		
		</div>
	</div>
</div>
<!-- end list modules -->


<!-- Bengin layout of row -->
<div class="modal fade" id="layout-row">
	<div class="modal-dialog g-modal modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo lang('page_row_layout'); ?></h4>
			</div>
			
			<div class="modal-body">
				<div class="form-group">
					<label class="control-label"><?php echo lang('page_row_layout'); ?>: <span class="number-row font-bold">1 <?php echo lang('page_row'); ?></span></label>
					<div class="center-block"><small><?php echo lang('page_drag_and_drop'); ?></small></div>
					<div id="slider-number-row" class="grid-slider"></div>
				</div>
				<div class="form-group">
					<label class="control-label font-bold"><?php echo lang('page_custom_your_layout'); ?></label>
					<span class="center-block"><small><?php echo lang('page_custom_your_layout_help'); ?></small></span>
					<div class="layout-col-list row"></div>
				</div>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
				<button type="button" class="btn btn-primary" id="layout-save" data-loading-text="Loading..."><?php echo lang('page_save_change'); ?></button>
			</div>
		</div>
	</div>
</div>
<!-- end layout of row -->

<!-- Module setting -->
<div class="modal fade" id="module-setting">
	<div class="modal-dialog g-modal">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo lang('page_module_setting'); ?></h4>
			</div>
			
			<div class="modal-body"></div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn_back"><?php echo lang('page_list_modules'); ?></button>
				<button type="button" class="btn btn-primary btn_save" data-loading-text="Loading..." onclick="grid.module.save(this)"><?php echo lang('page_save_change'); ?></button>
			</div>
		</div>
	</div>
</div>


<!-- page save -->
<div class="modal fade" id="page-setting">
	<div class="modal-dialog g-modal">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo lang('page_save'); ?></h4>
			</div>
			
			<div class="modal-body">
				<form name="page-save" class="page-save" action="<?php echo site_url('admin/page/save'); ?>" method="POST">
					 <div class="form-group">
						<label class="font-bold"><?php echo lang('page_page_title'); ?></label>
						<input type="text" class="form-control input-sm" value="<?php echo $page->title; ?>" name="page[title]">
					 </div>
					 
					 <div class="form-group">
						<label class="font-bold"><?php echo lang('slug'); ?></label>
						<input type="text" class="form-control input-sm" value="<?php echo $page->slug; ?>" name="page[slug]">
					 </div>
					 
					 <div class="form-group">
						<label class="font-bold"><?php echo lang('page_meta_title'); ?></label>
						<textarea class="form-control input-sm" rows="2" name="page[meta_title]"><?php echo $page->meta_title; ?></textarea>
					 </div>
					 
					 <div class="form-group">
						<label class="font-bold"><?php echo lang('page_meta_description'); ?></label>
						<textarea class="form-control input-sm" rows="2" name="page[meta_description]"><?php echo $page->meta_description; ?></textarea>
					 </div>
					 
					 <div class="form-group">
						<label class="font-bold"><?php echo lang('page_meta_keywords'); ?></label>
						<textarea class="form-control input-sm" rows="2" name="page[meta_keywords]"><?php echo $page->meta_keywords; ?></textarea>
					 </div>
					 
					 <textarea class="form-control input-sm" style="display:none;" rows="2" id="page_content" name="page[content]"></textarea>
					 <textarea class="form-control input-sm" style="display:none;" rows="2" id="page_file" name="file"></textarea>
					 
					 <input type="hidden" value="<?php echo $page->id; ?>" name="id">
				</form>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
				<button type="button" class="btn btn-primary" onclick="grid.page.save(this)"><?php echo lang('page_save_change'); ?></button>
			</div>
		</div>
	</div>
</div>
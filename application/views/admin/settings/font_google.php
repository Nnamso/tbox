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
<link href='http://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
<div class="row">
	<div class="col-md-5 pull-right text-right">
		<a href="<?php echo base_url().'admin/settings/fonts'?>" class="btn btn-danger" ><?php echo lang('cancel'); ?></a>
	</div>
</div>

<hr />

<div id="ajax-modal" class="panel panel-default">
    <div class="panel-heading">
		<i class="fa fa-external-link-square icon-external-link-sign"></i>
		<?php echo lang('fonts_system'); ?>
		<div class="panel-tools">
			<a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>			
		</div>
	</div>
	<div class="modal-body">
		<h4><?php echo lang('fonts_choose_system_font');?></h4>
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label>Script:</label>
					<select class="form-control fonts-categories" onchange="dgUI.product.fonts.ajax(0)">
					
					<?php foreach($google as $key => $value) { ?>
					<option value="<?php echo $key; ?>"><?php echo $key; ?></option>
					<?php } ?>
					
					</select>
				</div>
				
				<div class="form-group">
					<label>Find a font: <strong id="fonts-counts"><?php echo count($google['latin']); ?></strong> font shown</label>
					<input type="text" class="form-control input-sm" onkeyup="dgUI.product.color.find('key', this)">
				</div>
			</div>				
			<div class="col-md-6">					
				<div class="form-group">
					<label><strong>Fonts added:</strong></label>
					<p class="text-muted"><small>Click on each font to remove it.</small></p>					
					<ul class="fonts" id="list-font-add"></ul>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label><strong>List categories:</strong></label>
					<p class="text-muted"><small>Choose a category and add all font selected.</small></p>
					
					<select class="form-control font-cate_id">
						<?php for($i=0; $i<count($categories); $i++) { ?>
							<option value="<?php echo $categories[$i]->id; ?>"><?php echo $categories[$i]->title; ?></option>
						<?php } ?>
					</select>
				</div>
				
				<div class="form-group">
					<button type="button" class="btn btn-primary" data-loading-text="Loading..."  autocomplete="off" onclick="dgUI.product.fonts.save(this)">Save</button>
					<div class="alert alert-success" role="alert" style="padding: 10px 12px; display: none;">Saved</div>
				</div>
			</div>
		</div>
		
		<hr />
		
		<div class="row">
			<div class="col-md-12">				
				<ul class="colors" id="list-fonts"></ul>					
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12 text-center">
				<br />
				<button type="button" class="btn btn-primary" onclick="dgUI.product.fonts.load()">Load More</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
var base_url 	= '<?php echo base_url(); ?>';
var fonts 	= [];
var fonts_added 	= <?php echo $fonts; ?>;
var page 	= 0;
jQuery(document).ready(function() {
	dgUI.product.fonts.ajax(0);
});
</script>
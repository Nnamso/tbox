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
<script src="<?php echo base_url('assets/plugins/bootstrap-modal/js/bootstrap-modal.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/ui-modals.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jscolor.js'); ?>"></script>
<script type="text/javascript">
	var url = '<?php echo site_url();?>';
	jQuery(document).on('click change','input[name="check_all"]',function() {
		var checkboxes = $(this).closest('table').find(':checkbox').not($(this));
        if($(this).prop('checked')) {
          checkboxes.prop('checked', true);
        } else {
          checkboxes.prop('checked', false);
        }
	});
	jQuery(document).ready(function(){
		dgUI.ajax.ini('colors');
		jQuery('select').change(function (){
			var search_vl = jQuery('.txt_search').val();
			var per_page = jQuery('.per_page_op').val();
			jQuery('#search_input').val(search_vl);
			jQuery('#per_page_input').val(per_page);
			dgUI.ajax.submit('#panel-form',true,load,update);
		});
		
		jQuery('form').submit(function() {
			return false;
		});
		
		jQuery(".txt_search").keyup(function(e){ 
			if(e.keyCode == 13)
			{
				var search_vl = jQuery('.txt_search').val();
				var per_page = jQuery('.per_page_op').val();
				jQuery('#search_input').val(search_vl);
				jQuery('#per_page_input').val(per_page);
				dgUI.ajax.submit('#panel-form',true,load,update);
			}
		});
	});
	
	function submit_fr_colors()
	{ 
		var search_vl = jQuery('.txt_search').val();
		var per_page = jQuery('.per_page_op').val();
		jQuery('#search_input').val(search_vl);
		jQuery('#per_page_input').val(per_page);
		dgUI.ajax.submit('#panel-form',true,load,update);
	};
</script>

<div class="row">
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-2">
				<?php 
					$option = array('all'=> lang('all'), '5'=>5, '10'=>10, '15'=>15, '20'=>20, '25'=>25, '100'=>100);
					echo form_dropdown('per_page', $option, $per_page, 'class="form-control per_page_op"');
				?>
			</div>
			<div class="col-md-4">
				<?php
					$search_cl = array('name' => 'search_vl', 'id' => 'color_search', 'class' => 'form-control txt_search', 'placeholder' => 'Search color', 'value'=>$this->session->userdata('search_colors'));
					echo form_input($search_cl);
				?>
			</div>
			<div class="col-md-2">
				<button class="btn btn-primary" type="button" onclick="submit_fr_colors()"><?php echo lang('search');?></button>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<p style="text-align:right;">
			<a class="btn btn-primary tooltips" title="<?php echo lang('add'); ?>" href="javascript:;" id="add-new-color">
				<i class="glyphicon glyphicon-plus"></i>
			</a>
			<a class="btn btn-green action tooltips" title="<?php echo lang('publish'); ?>" href="javascript:;" rel="publish-all" data-flag="0">
				<i class="glyphicon glyphicon-ok-sign"></i>
			</a>
			<a class="btn btn-danger action tooltips" href="javascript:;" title="<?php echo lang('unpublish'); ?>" rel="unpublish-all" data-flag="1">
				<i class="clip-radio-checked"></i>
			</a>
			<a class="btn btn-bricky action tooltips" title="<?php echo lang('delete'); ?>" href="javascript:;" rel="del-all"> 
				<i class="fa fa-trash-o"></i>
			</a>
		</p>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square icon-external-link-sign"></i>
		<?php echo lang('colors_list_title'); ?>
	</div>
	<?php echo validation_errors(); ?>
	<?php
		$attribute = array('class'=>'form-color','id'=>'panel-form');
		echo form_open('', $attribute);
	?>
	<div class="panel-body" id="panelbody">
		<div id="refresh">
			<table id="sample-table-1" class="table table-bordered table-hover">
				<thead>
				<tr>
				<th class="center">
					<div class="checkbox-table">
						<label>
							<input id="select_all" type="checkbox" name='check_all'>
						</label>
					</div>
				</th>
				<th class="center"><?php echo lang('id'); ?></th>
				<th class="center"><?php echo lang('colors_name_title'); ?></th>
				<th class="center"><?php echo lang('hex'); ?></th>
				<th class="center"><?php echo lang('published'); ?></th>
				<th class="center"><?php echo lang('action'); ?></th>
				</tr>
				</thead>
				<tbody>
					<?php if($colors)foreach ($colors as $color) { ?>
						<tr>
							<td class="center">
								<div class="checkbox-table">
									<label>
										<input type="checkbox" name="checkb[]" class="checkb" name="check" value="<?php echo $color->id; ?>">
									</label>
								</div>
							</td>
							<td class="center"><?php echo $color->id; ?></td>
							<td><?php echo $color->title; ?></td>
							<td class="center"><span class="tooltips" style="margin: 5px auto; display: block; height: 25px; width: 50px; background: #<?php echo $color->hex; ?>; border: 1px solid #CCCCCC;" data-original-title="#<?php echo $color->hex; ?>"></span></td>
							<td class="center"><?php if ($color->published == 1) { ?>					   
									<a class="btn btn-success btn-xs tooltips action" href="javascript:void(0);" data-original-title="<?php echo lang('click_publish');?>" data-placement="top" rel="unpublish" data-id="<?php echo $color->id; ?>" data-flag="1"><?php echo lang('publish'); ?></a>
								<?php } else { ?>
									<a class="btn btn-danger btn-xs tooltips action" href="javascript:void(0);" data-original-title="<?php echo lang('click_publish');?>" data-placement="top" rel="publish" data-id="<?php echo $color->id; ?>" data-flag="0"><?php echo lang('unpublish'); ?></a>
								<?php } ?>
							</td>
							<td class="center">
								<div class="visible-md visible-lg hidden-sm hidden-xs">
									<a href="javascript:;" rel="edit" class="btn btn-teal tooltips" data-placement="top" data-original-title="<?php echo lang('edit');?>" onclick="UIModals.init('<?php echo site_url(); ?>admin/settings/edit/colors/<?php echo $color->id;?>')">
										<i class="fa fa-edit"></i>
									</a>
									<a rel="del" class="remove btn btn-bricky tooltips action" data-placement="top" data-original-title="<?php echo lang('remove');?>" href="javascript:void(0);" data-id="<?php echo $color->id; ?>">
									<i class="fa fa-times"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>    
				</tbody>
			</table>
			<div class="row">
				<div class="dataTables_paginate paging_bootstrap" style="float: right;">
					<div class="col-md-12">
					<?php echo $links;?>
					</div>
			   </div>
			</div>
		</div>
	</div>
	<input type="hidden" id="flag" name="action" value="1">
	<input type="hidden" id="search_input" name="search_vl">
	<input type="hidden" id="per_page_input" name="per_page">
	<?php echo form_close(); ?> 
</div>    

<div id="ajax-modal" class="modal fade" tabindex="-1" style="display: none;"></div>

<script type="text/javascript">

	jQuery('#add-new-color').on('click', function(){
		UIModals.init('<?php echo site_url().'admin/settings/edit/colors'; ?>');
	});

	function update(){
		jQuery('.form-color,.modal-body').unblock();
		jQuery('.modal-close').click();
		jQuery.post( "<?php echo site_url()?>admin/settings/color", function( data) {
			document.getElementById('refresh').innerHTML = data;
			jQuery('.tooltips').tooltip();
			jQuery('#panel-form').attr('action', "<?php echo site_url()?>admin/settings/colors");
		});
	}
	function load(){
		jQuery('.form-color,.modal-body').block({
			overlayCSS: {
				backgroundColor: '#fff'
			},
			message: '<img src="'+ url +'assets/images/loading.gif" /> <?php echo lang('load_text');?>',
			css: {
				border: 'none',
				color: '#333',
				background: 'none'
			}
		});
	}
	var conf = '<?php echo lang('colors_delete_color_msg');?>';
</script>
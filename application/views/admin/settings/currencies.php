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
<link href="<?php echo base_url('assets/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css'); ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('assets/plugins/bootstrap-modal/css/bootstrap-modal.css'); ?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/plugins/bootstrap-modal/js/bootstrap-modal.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/ui-modals.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/validate/validate.js'); ?>"></script>

<script type="text/javascript">
	var url = '<?php echo site_url();?>';
    jQuery(document).on('click change', 'input[name="check_all"]', function() {
        var checkboxes = $(this).closest('table').find(':checkbox').not($(this));
        if ($(this).prop('checked')) {
            checkboxes.prop('checked', true);
        } else {
            checkboxes.prop('checked', false);
        }
    });
    jQuery(document).ready(function(){
		dgUI.ajax.ini('currencies');
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
	
	function submit_fr_currency()
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
					$option = array(
						'all'=> lang('all'),
						'5'=>5, 
						'10'=>10, 
						'15'=>15, 
						'20'=>20, 
						'25'=>25, 
						'100'=>100
					);
					echo form_dropdown('per_page', $option, $per_page, 'class="form-control per_page_op"');
				?>
			</div>
			<div class="col-md-4">
				<?php
					$search_c = array('name' => 'search_c', 'id' => 'color_search', 'class' => 'form-control txt_search', 'placeholder' => 'Search Currencies', 'value'=>$this->session->userdata('search_currency'));
					echo form_input($search_c);
				?>
			</div>
			<div class="col-md-2">
				<button class="btn btn-primary" type="button" onclick="submit_fr_currency()"><?php echo lang('search');?></button>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<p style="text-align:right;">
			<a class="btn btn-primary tooltips" title="<?php echo lang('add'); ?>" rel="add" href="javascript:void(0);" onclick="UIModals.init('<?php echo site_url(); ?>admin/settings/edit/currencies')">
				<i class="fa fa-plus"></i>
			</a>
			<a class="btn btn-green action tooltips" title="<?php echo lang('publish'); ?>" href="javascript:void(0);" rel="publish-all" data-flag="0">
				<i class="glyphicon glyphicon-ok-sign"></i>
			</a>
			<a class="btn btn-danger action tooltips" title="<?php echo lang('unpublish'); ?>" href="javascript:void(0);" rel="unpublish-all" data-flag="1">
				<i class="clip-radio-checked"></i>
			</a>
			<a class="btn btn-bricky action tooltips" title="<?php echo lang('delete'); ?>" href="javascript:void(0);" rel="del-all"> 
				<i class="fa fa-trash-o"></i>
			</a>
		</p>
	</div>
</div>

<div class="panel panel-default">
	<?php
		$attribute = array('class' => 'form-currencies', 'id' => 'panel-form');
		echo form_open('', $attribute);
	?>
	<div class="panel-heading">
		<i class="fa fa-external-link-square icon-external-link-sign"></i>
		<?php echo lang('currencies'); ?>
	</div>
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
						<th class="center"><?php echo lang('order'); ?></th>
						<th class="center"><?php echo lang('currencies_name'); ?></th>
						<th class="center"><?php echo lang('currencies_code'); ?></th>
						<th class="center"><?php echo lang('currencies_symbol'); ?></th>
						<th class="center"><?php echo lang('id'); ?></th>
						<th class="center"><?php echo lang('published'); ?></th>
						<th class="center"><?php echo lang('action'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php $number = 0; ?>
					<?php if ($currencies) foreach ($currencies as $currencie) { ?>
							<?php $number++; ?>
							<tr>
								<td class="center">
									<div class="checkbox-table">
										<label>
											<input type="checkbox" name="checkb[]" class="checkb" name="check" value="<?php echo $currencie->currency_id; ?>">
										</label>
									</div>
								</td>
								<td class="center"><?php echo $number; ?></td>
								<td class="center"><?php echo $currencie->currency_name; ?></td>
								<td class="center"><?php echo $currencie->currency_code; ?></td>
								<td class="center"><?php echo $currencie->currency_symbol; ?></td>
								<td class="center"><?php echo $currencie->currency_id; ?></td>
								<td class="center"><?php if ($currencie->published == 1) { ?>					   
										<a class="btn btn-success btn-xs tooltips action" type="button" data-original-title="<?php echo lang('click_publish');?>" data-placement="top" rel="unpublish" data-id="<?php echo $currencie->currency_id; ?>" data-flag="1"><?php echo lang('publish'); ?></a>
									<?php } else { ?>
										<a class="btn btn-danger btn-xs tooltips action" type="button" data-original-title="<?php echo lang('click_publish');?>" data-placement="top" rel="publish" data-id="<?php echo $currencie->currency_id; ?>" data-flag="0"><?php echo lang('unpublish'); ?></a>
									<?php } ?>
								</td>
								<td class="center">
									<div class="visible-md visible-lg hidden-sm hidden-xs">
										<a href="javascript:;" rel="edit" class="btn btn-teal tooltips" data-placement="top" data-original-title="<?php echo lang('edit');?>" onclick="UIModals.init('<?php echo site_url(); ?>admin/settings/edit/currencies/<?php echo $currencie->currency_id; ?>')">
											<i class="fa fa-edit"></i>
										</a>
										<a rel="del" class="remove btn btn-bricky tooltips action" data-placement="top" data-original-title="<?php echo lang('remove');?>" href="javascript:;" data-id="<?php echo $currencie->currency_id; ?>">
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
	<input type="hidden" id="search_input" name="search_c">
	<input type="hidden" id="per_page_input" name="per_page">
	<?php echo form_close(); ?>        
</div>    

<div id="ajax-modal" class="modal fade" tabindex="-1" style="display: none;"></div>

<script type="text/javascript">
    function update() {
        jQuery('.form-currencies,.modal-body').unblock();
        jQuery('.modal-close').click();
        jQuery.post("<?php echo site_url()?>admin/settings/currencie", function(data) {
            document.getElementById('refresh').innerHTML = data;
            jQuery('.tooltips').tooltip();
            jQuery('#panel-form').attr('action', "<?php echo site_url()?>admin/settings/currencies");
        });
    }
    function load() {
        var pathArray = window.location.href.split('/');
        jQuery('.form-currencies,.modal-body').block({
            overlayCSS: {
                backgroundColor: '#fff'
            },
            message: '<img src="<?php echo base_url().'/assets/images/loading.gif'?>" /> <?php echo lang('load_text') ?>',
            css: {
                border: 'none',
                color: '#333',
                background: 'none'
            }
        });
    }
    var conf = '<?php echo lang('msg_delete'); ?>';
</script>
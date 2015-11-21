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
<script>
	var url = '<?php echo site_url();?>';
    jQuery(document).on('click change', 'input[name="check_all"]', function() {
        var checkboxes = $(this).closest('table').find(':checkbox').not($(this));
        if ($(this).prop('checked')) {
            checkboxes.prop('checked', true);
        } else {
            checkboxes.prop('checked', false);
        }
    });
    jQuery(document).ready(function() {
        dgUI.ajax.ini('states');
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
	
	function submit_fr_state()
	{ 
		var search_vl = jQuery('.txt_search').val();
		var per_page = jQuery('.per_page_op').val();
		jQuery('#search_input').val(search_vl);
		jQuery('#per_page_input').val(per_page);
		dgUI.ajax.submit('#panel-form',true,load,update);
	};
</script>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square icon-external-link-sign"></i>
                <?php echo lang('states') ?>
            </div>
            <form id="panel-form" method="post">
                <div class="panel-body" id="panelbody">
                    <div class="row">
                        <div class="col-md-6">
							<div class="row">
								<div class="col-md-2">
									<?php 
									   $option = array(
											'all'=>  lang('all'),
											'5'=>5, 
											'10'=>10, 
											'15'=>15, 
											'20'=>20, 
											'25'=>25, 
											'100'=>100,
										);
										echo form_dropdown('per_page', $option, $per_page, 'class="form-control per_page_op"');
									?>
								</div>
								<div class="col-md-4">
									<?php
										$search_c = array('name' => 'search', 'id' => 'states_search', 'class' => 'form-control txt_search', 'placeholder' => 'Search states', 'value'=>$this->session->userdata('search_state'));
										echo form_input($search_c);
									?>
								</div>
								<div class="col-md-2">
									<button class="btn btn-primary" type="button" onclick="submit_fr_state()"><?php echo lang('search');?></button>
								</div>
							</div>
                        </div>
                        <div class="col-md-6">
                            <p style="text-align:right;">
                                <a href="javascript:;" class="btn btn-primary tooltips" title="<?php echo lang('add') ?>" onclick="UIModals.init('<?php echo site_url(); ?>admin/settings/edit/states');">
                                    <i class="fa fa-plus"></i>
                                </a>
                                <a href="javascript:;" class="btn btn-green action tooltips" title="<?php echo lang('publish') ?>" rel="publish-all" data-flag="0">
                                    <i class="glyphicon glyphicon-ok-sign"></i>
                                </a>
                                <a href="javascript:;" class="btn btn-danger action tooltips" title="<?php echo lang('unpublish') ?>" rel="unpublish-all" data-flag="1">
                                    <i class="clip-radio-checked "></i>
                                </a>	
                                <a href="javascript:;" class="btn btn-bricky action tooltips" title="<?php echo lang('delete') ?>" rel="del-all"> 
                                    <i class="fa fa-trash-o"></i>
                                </a>

                            </p>
                        </div>
                    </div>
                    <div id="refresh">
                    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="center">
								<div class="checkbox-table">
									<label>
										<input type="checkbox" name="check_all">
									</label>
								</div>
                                </th>
                                <th class="center"><?php echo lang('states_name') ?></th>
                                <th class="center"><?php echo lang('states_code') ?></th>
                                <th class="center"><?php echo lang('states_country_id') ?></th>
                                <th class="center"><?php echo lang('id') ?></th>
								<th class="center"><?php echo lang('published') ?></th>
                                <th class="center"><?php echo lang('action') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $stt = 0; ?>
                            <?php foreach ($states as $state): ?>
                                <?php $stt++; ?>
                                <tr>
                                    <td class="center">
									<div class="checkbox-table">
										<label>
											<input type="checkbox" class="checkb" value="<?php echo $state->id; ?>" name="checkb[]">
										</label>
									</div>
									</td>
                                    <td><?php echo $state->name; ?></td>
                                    <td class="center"><?php echo $state->code; ?></td>
                                    <td class="center"><?php echo $state->country_id; ?></td>
									<td class="center"><?php echo $state->id; ?></td>
                                    <td class="center">
                                        <?php
                                        if ($state->published == 0)
                                            echo '<a class="btn btn-danger btn-xs tooltips action" type="button" data-original-title="'.lang('click_publish').'" data-placement="top" rel="publish" data-id="' . $state->id . '" data-flag="0">' . lang('unpublish') . '</a>';
                                        if ($state->published == 1)
                                            echo '<a class="btn btn-success btn-xs tooltips action" type="button" data-original-title="'.lang('click_unpublish').'" data-placement="top" rel="unpublish" data-id="' . $state->id . '" data-flag="1">' . lang('publish') . '</a>';
                                        ?>
                                    </td>
                                    <td class="center">
                                        <div class="visible-md visible-lg hidden-sm hidden-xs" id="dg-getid">
                                            <a data-original-title="<?php echo lang('edit');?>" data-placement="top" class="btn btn-teal tooltips" onclick="UIModals.init('<?php echo site_url('admin/settings/edit/states/'.$state->id); ?>');">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a data-original-title="<?php echo lang('remove');?>" data-placement="top" class="btn btn-bricky tooltips action" data-id="<?php echo $state->id; ?>" rel="del">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                        <div class="visible-xs visible-sm hidden-md hidden-lg">
                                            <div class="btn-group">
                                                <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-sm">
                                                    <i class="icon-cog"></i> <span class="caret"></span>
                                                </a>
                                                <ul class="dropdown-menu pull-right" role="menu">
                                                    <li role="presentation">
                                                        <a href="#" tabindex="-1" role="menuitem">
                                                            <i class="icon-edit"></i><?php echo lang('edit') ?>
                                                        </a>
                                                    </li>
                                                    <li role="presentation">
                                                        <a href="#" tabindex="-1" role="menuitem">
                                                            <i class="icon-remove"></i> <?php echo lang('remove') ?>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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
            </form>
        </div>
    </div>
</div>
<div id="ajax-modal" class="modal fade" tabindex="-1" style="display: none;"></div>

<script type="text/javascript">
    function update() {
        jQuery('#panel-form,.modal-body').unblock();
        jQuery('.modal-close').click();
        jQuery.post("<?php echo site_url() ?>admin/settings/state", function(data) {
            document.getElementById('refresh').innerHTML = data;
            jQuery('.tooltips').tooltip();
			jQuery('#panel-form').attr('action', "<?php echo site_url()?>admin/settings/states");
        });
    }
    function load() {
        var pathArray = window.location.href.split('/');
        jQuery('#panel-form,.modal-body').block({
            overlayCSS: {
                backgroundColor: '#fff'
            },
            message: '<img src="<?php echo base_url().'assets/images/loading.gif'?>" /> <?php echo lang('load_text') ?>',
            css: {
                border: 'none',
                color: '#333',
                background: 'none'
            }
        });
    }
    var conf = '<?php echo lang('msg_delete') ?>';
</script>

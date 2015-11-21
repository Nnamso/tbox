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
    jQuery(document).on('click change', 'input[name="check_all"]', function() {
        var checkboxes = $(this).closest('table').find(':checkbox').not($(this));
        if ($(this).prop('checked')) {
            checkboxes.prop('checked', true);
        } else {
            checkboxes.prop('checked', false);
        }
    });
    jQuery(document).ready(function() {
        dgUI.ajax.ini('shipping');
    });
	var url = '<?php echo site_url();?>';
</script>


<?php
$attribute = array('class' => 'form-shipping', 'id' => 'panel-form');
echo form_open('', $attribute);
?>
<p style="text-align:right;">
	<a class="btn btn-primary tooltips" rel="add" href="javascript:void(0);" title="<?php echo lang('add'); ?>" onclick="UIModals.init('<?php echo site_url(); ?>admin/settings/edit/shipping')">
		<i class="glyphicon glyphicon-plus"></i>
	</a>
	<a class="btn btn-green action tooltips" title="<?php echo lang('publish'); ?>" href="javascript:void(0);" rel="publish-all" data-flag="0">
		<i class="glyphicon glyphicon-ok-sign"></i>
	</a>
	<a class="btn btn-danger action tooltips" href="javascript:void(0);" title="<?php echo lang('unpublish'); ?>" rel="unpublish-all" data-flag="1">
		<i class="clip-radio-checked"></i>
	</a>
	<a class="btn btn-bricky action tooltips" href="javascript:void(0);" title="<?php echo lang('delete'); ?>" rel="del-all"> 
		<i class="fa fa-trash-o"></i>
	</a>
</p>
<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square icon-external-link-sign"></i>
		<?php echo lang('setting_admin_shipping'); ?>
	</div>
	<div class="panel-body" id="panelbody">
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
					<th class="center"><?php echo lang('title'); ?></th>
					<th class="center"><?php echo lang('description'); ?></th>
					<th class="center"><?php echo lang('price'); ?></th>
					<th class="center"><?php echo lang('date'); ?></th>
					<th class="center"><?php echo lang('default'); ?></th>
					<th class="center"><?php echo lang('publish'); ?></th>
					<th class="center"><?php echo lang('action'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if (is_array($shipping)) foreach ($shipping as $ship) { ?>
						<tr>
							<td class="center">
								<div class="checkbox-table">
									<label>
										<input type="checkbox" name="checkb[]" class="checkb" name="check" value="<?php echo $ship->id; ?>">
									</label>
								</div>
							</td>
							<td><?php echo $ship->title; ?></td>
							<td><?php echo $ship->description; ?></td>
							<td class="center"><?php echo $ship->price; ?></td>
							<td class="center">
								<?php 
									$date = new DateTime($ship->date);
									echo $date->format('Y-m-d');
								?>
							</td>
							<td class="center">
								<?php if($ship->default == 1){?>
									<a class="tooltips" href="javascript:void(0)" data-original-title="<?php echo lang('click_default');?>" data-placement="top"><i class="fa fa-check-square-o" style="font-size: 20px;"></i></a>
								<?php }else{ ?>
									<a class="tooltips action" href="javascript:void(0)" rel="default" data-id="<?php echo $ship->id; ?>" data-original-title="<?php echo lang('click_default');?>" data-placement="top"><i class="fa fa-square-o" style="font-size: 20px;"></i></a>
								<?php } ?>
							</td>
							<td class="center"><?php if ($ship->published == 1) { ?>					   
									<a class="btn btn-success btn-xs tooltips action" type="button" data-original-title="<?php echo lang('click_publish');?>" data-placement="top" rel="unpublish" data-id="<?php echo $ship->id; ?>" data-flag="1"><?php echo lang('publish'); ?></a>
								<?php } else { ?>
									<a class="btn btn-danger btn-xs tooltips action" type="button" data-original-title="<?php echo lang('click_publish');?>" data-placement="top" rel="publish" data-id="<?php echo $ship->id; ?>" data-flag="0"><?php echo lang('unpublish'); ?></a>
								<?php } ?>
							</td>
							<td class="center">
								<div class="visible-md visible-lg hidden-sm hidden-xs">
									<a href="javascript:;" rel="edit" class="btn btn-teal tooltips" data-placement="top" data-original-title="<?php echo lang('edit');?>" onclick="UIModals.init('<?php echo site_url(); ?>admin/settings/edit/shipping/<?php echo $ship->id; ?>')">
										<i class="fa fa-edit"></i>
									</a>
									<?php if($ship->default == 0) { ?>
										<a rel="del" class="remove btn btn-bricky tooltips action" data-placement="top" data-original-title="<?php echo lang('remove');?>" href="javascript:void(0);" data-id="<?php echo $ship->id; ?>">
											<i class="fa fa-times"></i>
										</a>
									<?php }else{ ?>
										<a class="remove btn btn-default tooltips" data-placement="top" data-original-title="<?php echo lang('remove');?>" href="javascript:void(0);">
											<i class="fa fa-times"></i>
										</a>
									<?php } ?>
								</div>
							</td>
						</tr>
					<?php } ?>    
			</tbody>
		</table>
	</div>
	<input type="hidden" id="flag" name="action">
		   
</div>  
<?php echo form_close(); ?>        

<div id="ajax-modal" class="modal fade" tabindex="-1" style="display: none;"></div>

<script type="text/javascript">
    function update() {
        jQuery('#panel-form,.modal-body').unblock();
        jQuery('.modal-close').click();
        jQuery.post("ship", function(data) {
            document.getElementById('sample-table-1').innerHTML = data;
            jQuery('.tooltips').tooltip();
            jQuery('#panel-form').attr('action', "<?php echo site_url()?>admin/settings/shipping");
        });
    }
    function load() {
        jQuery('#panel-form,.modal-body').block({
            overlayCSS: {
                backgroundColor: '#fff'
            },
            message: '<img src="' + url + '/assets/images/loading.gif" /> <?php echo lang('load_text') ?>',
            css: {
                border: 'none',
                color: '#333',
                background: 'none'
            }
        });
    }
    var conf = '<?php echo lang('default_shipping_delete_confirm'); ?>';
</script>
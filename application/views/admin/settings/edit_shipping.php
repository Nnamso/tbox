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
	<h4 class="modal-title"><?php if($id != '')echo lang('setting_admin_shipping_edit_title'); else echo lang('setting_admin_shipping_add_title'); ?></h4>
</div>

<?php
$attribute = array('class'=>'form-horizontal', 'name'=>'form_edit', 'id' => 'form-edit');
echo form_open(site_url().'admin/settings/edit/shipping/'.$id, $attribute);
 ?>
<div class="modal-body">		
    <div class="panel-body">
		<div class="form-group">
            <label class="col-sm-4 control-label" for="publish"><?php echo lang('publish'); ?></label>
            <div class="col-sm-4">	
				<?php 
					$option = array(
						'1'=>lang('publish'),
						'0'=>lang('unpublish')
					);
					
					echo form_dropdown('data[published]', $option, $data->published, 'class = "form-control" id="publish"');
				?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label" for="order-title">
                <?php echo lang('title'); ?>
                <span class="symbol required"></span>
            </label>
            <div class="col-sm-8">	
                <?php
                $att_name = array('name' => 'data[title]', 'value'=>$data->title, 'id' => 'order-title', 'class' => 'form-control validate', 'placeholder' => lang('setting_admin_shipping_title_place'), 'data-minlength' => '2', 'data-maxlength' => '200', 'data-msg' => lang('setting_admin_shipping_title_validate'));
                echo form_input($att_name)
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label" for="order-code">
                <?php echo lang('price'); ?>
                <span class="symbol required"></span>
            </label>
            <div class="col-sm-8">	
                <?php
                $att_code = array('name' => 'data[price]', 'value'=>$data->price, 'class' => 'form-control validate', 'placeholder' => lang('setting_admin_shipping_price_place'), 'data-minlength' => '1', 'data-maxlength' => '10', 'data-msg' => lang('setting_admin_shipping_price_validate'));
                echo form_input($att_code)
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label" for="description">
                <?php echo lang('description'); ?>
            </label>
            <div class="col-sm-8">	
                <?php
                $att_des = array('name' => 'data[description]', 'value'=>$data->description, 'id' => 'description', 'rows'=>3, 'class' => 'form-control', 'placeholder' => lang('orders_description_place'));
                echo form_textarea($att_des)
                ?>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn modal-close"><?php echo lang('close'); ?></button>
    <button onclick="dgUI.ajax.submit('.form-horizontal', '#form-edit', load, update)" class="btn btn-primary click" type="button"><?php echo lang('save'); ?></button>
</div>
<?php if($id == ''){?>
	<input type="hidden" name="data[date]" value="<?php echo date('Y-m-d H:i:s');?>"/>
<?php } ?>
<?php
echo form_close()
?>
<script type="text/javascript">
</script>
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
<script src="<?php echo base_url('assets/plugins/tinymce/tinymce.min.js'); ?>"></script>
<script type="text/javascript">
var base_url = '<?php echo base_url(); ?>';
var url = '<?php echo base_url(); ?>';
var areaZoom = 10;
function descriptMedia(images){
	if(images.length > 0)
	{
		var html = '';
		for(i=0; i<images.length; i++)
		{
			html = html + '<img src="'+images[i]+'" alt="" />';
		}
		tinymce.activeEditor.execCommand('mceInsertContent', false, html);
		jQuery.fancybox.close();
	}
}
tinymce.PluginManager.add('dgmedia', function(editor, url) {
    // Add a button that opens a window
    editor.addButton('dgmedia', {
        text: 'Add images',
        icon: false,
        onclick: function() {
			jQuery.fancybox( {href : base_url + 'admin/media/modals/descriptMedia/1', type: 'iframe'} );
        }
    }); 
});
tinymce.init({
    selector: ".text-edittor",
	menubar: false,
	toolbar_items_size: 'small',
	statusbar: false,
	setup: function(editor) {
		editor.addButton('mybutton', {
			text: 'My button',
			icon: false,
			onclick: function() {
				editor.insertContent('Main button');
			}
		});
	},
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste dgmedia"
    ],
    toolbar: "code | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | dgmedia"
});
</script>
<div id="edit_payment">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title"><?php if($id != '')echo lang('setting_admin_shipping_edit_title'); else echo lang('setting_admin_shipping_add_title'); ?></h4>
	</div>
	
	<div class="modal-body">	
		<form method="POST" action="<?php echo site_url().'admin/settings/edit/payment/'.$id;?>" id="fr-add-payment" class="form-horizontal">
			<div class="tabbable panel-tabs">
				<ul class="nav nav-tabs tab-padding tab-blue">
					<li class="active">
						<a href="#panel_tab_1" data-toggle="tab"><?php if($id != '')echo lang('settings_payment_admin_edit_title');else echo lang('settings_payment_admin_edit_add_title');?></a>
					</li>
					<li class="">
						<a href="#panel_tab_2" data-toggle="tab"><?php echo lang('settings_payment_admin_edit_config_payment_title');?></a>
					</li>
				</ul>
				<div style="position: absolute; right: 30px; top: 27px;">
					<button type="button" class="btn btn-primary btn-sm" onclick="dgUI.ajax.submit('.form-horizontal', '#fr-add-payment', load, update, tinyMCE.triggerSave())"><?php echo lang('save');?></button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-hidden="true"><?php echo lang('close');?></button>
				</div>				
			</div>
			<div class="tab-content">
				<div id="panel_tab_1" class="tab-pane active">
					<div class="top-20">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-4"><?php echo lang('settings_payment_admin_add_payment_name');?></label>
								<div class="col-sm-8">
									<input type="text" name="data[title]" class="form-control input-sm validate required" data-minlength="2" data-maxlength="200" data-msg="<?php echo lang('settings_payment_admin_add_payment_name_validate');?>" placeholder="<?php echo lang('settings_payment_admin_add_payment_name_place');?>" value="<?php echo $data->title;?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4"><?php echo lang('settings_payment_admin_add_payment_desc');?></label>
								<div class="col-sm-8">
									<input type="text" name="data[description]" class="form-control input-sm validate required" data-minlength="2" data-maxlength="200" data-msg="<?php echo lang('settings_payment_admin_add_payment_description_validate');?>" placeholder="<?php echo lang('settings_payment_admin_add_payment_desc_place');?>" value="<?php echo $data->description;?>" />
								</div>
							</div>
							<?php if($id == ''){?>
							<div class="form-group">
								<label class="col-sm-4"><?php echo lang('settings_payment_admin_add_choose_payment');?></label>
								<div class="col-sm-4">
									<?php $folder_payment = getPayment();?>
									<select name="data[type]" class="form-control input-sm" >
										<?php foreach($folder_payment as $k=>$v){ ?>
											<option value='<?php echo $k;?>'><?php echo $v;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div id="panel_tab_2" class="tab-pane">
					<div class="top-20">
						<?php 
							if($id == '')
							{
								echo lang('settings_payment_admin_add_not_config');
							}else
							{
								$this->load->library('form');
								$form = new form();
								$form_field = ROOTPATH.DS.'application'.DS.'payments'.DS.$data->type.DS.$data->type.'.xml';
								$data_config = array();
								$pay_config = json_decode($data->configs);
								if(count($pay_config) > 0)
								foreach($pay_config as $key=>$val)
								{
									$data_config['config['.$key.']'] = stripslashes($val);
								}
								if(count($data_config) > 0)
									$form = $form->field($form_field, $data_config);
								else
									$form = $form->field($form_field);
									
								foreach($form as $val)
								{
									echo $val;
								}
							}
						?>
					</div>
				</div>
			</div>
			<?php if($id == ''){ ?>
				<input type="hidden" name="data[date]" value="<?php echo date('Y-m-d H:i:s');?>"/>
			<?php } ?>
		</form>
	</div>
</div>
<script type="text/javascript">
	jQuery('.tooltips').tooltip();
</script>
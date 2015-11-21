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
<script src="<?php echo base_url('assets/plugins/validate/validate.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<link href="<?php echo base_url('assets/css/lightbox.css'); ?>" rel="stylesheet" type="text/css"/>
<script>
    var loadingImage = '<?php echo base_url('assets/images/loading.gif'); ?>'; 
    var closeButton = '<?php echo base_url('assets/images/close.gif'); ?>';
</script>
<div class="row">
    <!--add-->
    <?php
    $attribute = array('class' => 'fr-edit-fonts form-horizontal', 'id' => 'panel-form');
    echo form_open_multipart(site_url() . 'admin/settings/upload/'.$id, $attribute);
    ?>
    <?php if ($error != '') { ?> 
        <div class="col-md-12">
			<div class="alert alert-danger">
                <button class="close" data-dismiss="alert"> × </button>
                <i class="fa fa-times-circle" style="margin-right: 5px; float:left;"></i>
                <?php echo $error; ?>
            </div>
		</div>
	<?php } ?>
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-external-link-square icon-external-link-sign"></i>
					<?php if($id == '')echo lang('fonts_add'); else echo lang('fonts_edit');?>
					<div class="modal-header">
						
					</div>
				</div>
				<div class="modal-body">					
					<div class="panel-body">
						<div class="form-group">
							<label class="col-sm-4 control-label" for="font-title">
								<?php echo lang('title'); ?>
								<span class="symbol required"></span>
							</label>
							<div class="col-sm-6">	
								<?php
								if($data != ''){
									$att_title = array('name' => 'data[title]', 'id' => 'font-title', 'class' => 'form-control validate', 'value' => $data['title'], 'data-minlength' => '2', 'data-maxlength' => '30', 'data-msg' => lang('fonts_edit_title_validate'), 'placeholder' => lang('fonts_edit_title_place'));
								}else{
									$att_title = array('name' => 'data[title]', 'id' => 'font-title', 'class' => 'form-control validate', 'value' => $font->title, 'data-minlength' => '2', 'data-maxlength' => '30', 'data-msg' => lang('fonts_edit_title_validate'), 'placeholder' => lang('fonts_edit_title_place'));
								}
								echo form_input($att_title)
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label" for="font-subtitle">
								<?php echo lang('fonts_subtitle'); ?>
							</label>
							<div class="col-sm-6">	
								<?php
								if($data != ''){
									$att_subtitle = array('name' => 'data[subtitle]', 'id' => 'font-subtitle', 'class' => 'form-control', 'value' => $data['subtitle'], 'placeholder' => lang('fonts_edit_subtitle_place'));
								}else{
									$att_subtitle = array('name' => 'data[subtitle]', 'id' => 'font-subtitle', 'class' => 'form-control', 'value' => $font->subtitle, 'placeholder' => lang('fonts_edit_subtitle_place'));
								}
								echo form_input($att_subtitle)
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label" for="font-woff">
								<?php echo lang('fonts_select_woff'); ?> <i class="glyphicon glyphicon-question-sign tooltips" data-original-title="<?php echo lang('fonts_font_suports_woff')?>"></i>
							</label>
							<div class="col-sm-4">	
								<?php
								$att_file = array('name' => 'font', 'id' => 'font-woff', 'type' => 'file', 'autocomplete' => 'off');
								echo form_input($att_file)
								?>
							</div>
							<div class="col-sm-2">
								<?php 
									$fonts_name = json_decode($font->filename, true);
									if(is_array($fonts_name)){
											foreach ($fonts_name as $k=>$v){
													if($k != 'ttf'){
														echo $v;
													}
											}
									}else{
										echo $font->filename;
									}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label" for="font-filename">
								<?php echo lang('fonts_select_ttf'); ?> <i class="glyphicon glyphicon-question-sign tooltips" data-original-title="<?php echo lang('fonts_font_suports_ttf')?>"></i>
							</label>
							<div class="col-sm-4">	
								<?php
								$att_file = array('name' => 'font_ttf', 'id' => 'font-ttf', 'type' => 'file', 'autocomplete' => 'off');
								echo form_input($att_file)
								?>
							</div>
							<div class="col-sm-2">
								<?php
									$fonts_name = json_decode($font->filename, true);
									if(is_array($fonts_name)){
											foreach ($fonts_name as $k=>$v){
													if($k != 'woff'){
														echo $v;
													}
											}
									}else{
										echo $font->filename;
									}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label" for="font-thumb">
								<?php echo lang('select_thumb'); ?> <i class="glyphicon glyphicon-question-sign tooltips" data-original-title="<?php echo lang('fonts_thumb_suports')?>"></i>
							</label>
							<div class="col-sm-4">	
								<?php
								$att_file = array('name' => 'thumb', 'id' => 'font-thumb', 'type' => 'file', 'autocomplete' => 'off');
								echo form_input($att_file)
								?>
							</div>
							<div class="col-sm-2">
								<a href="<?php echo site_url().'media/fonts/'.$font->thumb; ?>" rel="lightbox" class="tooltips" data-original-title="<?php echo $font->thumb; ?>">
									<img style="height: 25px; width: 50px;" src="<?php echo site_url().'media/fonts/'.$font->thumb; ?>" alt="<?php echo $font->thumb; ?>">
								</a>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-10">
								<div class="pull-right">
									<button type="submit" class="btn btn-primary" onclick="return sub();"><?php echo lang('save'); ?></button>
									<a class="btn modal-close btn-danger" href="<?php echo site_url() ?>admin/settings/fonts"><?php echo lang('close'); ?></a>
								</div>
							</div>
						</div>
					</div>				
				</div>
			</div>
		</div>
        <div class="col-md-4">
            <div style="margin-bottom: 0px;" class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square icon-external-link-sign"></i>
					<?php echo lang('categories')?>
					<div class="modal-header"></div>
                </div>
                <div id="add_cat">
					<div class="modal-body">
						<div style="margin-bottom: 0px;" class="form-group">
							<div class="col-md-10">
								<label for="form-field-select-4">
									<?php echo lang('select_cate')?>
								</label>
							</div>
							<div class="col-md-9">	
								<?php 
									$option = array(
										'0'=>'Choose category'
									);
									foreach($cate as $value)
									{
										$option[$value->id] = $value->title;
									}
									echo form_dropdown('data[cate_id]', $option, $font->cate_id, 'class="form-control" id="list-cate-font"');
								?>
							</div>
							<div class="col-md-3" style="padding: 5px 0px;">
								<a href="javascript:void(0)" onclick="editCateFont()" class="btn btn-primary btn-xs tooltips" data-toggle="modal" data-target="#modal_edit_cate" data-toggle="tooltip" data-placement="top" title="<?php echo lang('fonts_edit_edit_cate_tooltip');?>"><i class="fa fa-pencil-square-o"></i></a>
								<a onclick="removeCateFont()" href="javascript:void(0)" class="btn btn-bricky btn-xs tooltips" data-toggle="tooltip" data-placement="top" title="<?php echo lang('fonts_edit_remove_cate_tooltip');?>"><i class="fa fa-trash-o"></i></a>
							</div>
							<div class="col-md-10">
								<a href="javascript:void(0);" onclick="add()"><?php echo lang('fonts_add_category')?></a>
							</div>
						</div>
					</div>
                </div>
            </div>	
        </div>
    <?php echo form_hidden('action', 'upload') ?>
    <?php echo form_hidden('font_file', $font->filename) ?>
    <?php echo form_hidden('font_thumb', $font->thumb) ?>
    <?php echo form_close(); ?>
	<div class="col-md-4 pull-right"><div id="add_form"></div></div>
	
	<!-- Modal -->
	<div class="modal fade" id="modal_edit_cate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="<?php echo site_url().'admin/settings/editcate'?>" method="post" id="fr-edit-cate">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel"><?php echo lang('fonts_edit_edit_cate_title');?></h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label class="col-sm-4"><?php echo lang('fonts_edit_form_cate_title');?></label>
							<div class="col-sm-8">
								<input id="edit-cate-title" type="text" class="form-control input-sm validate required" data-msg="<?php echo lang('fonts_edit_edit_cate_validate');?>" data-maxlength="50" data-minlength="2" name="title"/>
							</div>
						</div>
						<input id="edit-cate-font" type="hidden" name="id" value=""/>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick="subCate(this)"><?php echo lang('save');?></button>
						<button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo lang('close');?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div style="display: none;">
		<form action="<?php echo site_url().'admin/settings/delcate'?>" method="post" id="fr-del-cate">
			<input id="del-cate-font" type="hidden" name="id" value=""/>
			<input type="hidden" name="del" value="del"/>
		</form>
	</div>
</div>
<script type="text/javascript">
    function add() {
        var html = '';
            html = html + '<div id="tab-content-lang" class="tab-content form-horizontal">';
            html = html + '<span class="help-block"><i class="glyphicon glyphicon-info-sign"></i> <?php echo lang('fonts_choose_category');?></span>';
            html = html + '<form method="post" action="<?php echo site_url()?>admin/settings/fonts/add_fonts" id="form-add" class="form-add">';
            html = html + '<div id="title">';
			html = html + '<div class="form-group">';
			html = html + '<div class="col-md-12">';
			html = html + '<input type="text" name="catename" id="fonts_title" data-maxlength = "100" data-msg="<?php echo lang('fonts_category_name_validate_msg')?>" class="form-control validate category_title" placeholder="<?php echo lang('fonts_category_name_place')?>" />';
			html = html + '</div>';
			html = html + '</div>';
			html = html + '</div>';
            
            html = html + '<div class="form-group">';
            html = html + '<div class="col-md-12">';
            html = html + '<div class="pull-right">';
            html = html + '<button type="button" class="btn btn-primary" onclick="save()"><?php echo lang('save');?></button>';
			html = html + '<a class="btn modal-close btn-danger" style="margin-left: 10px;" onclick="closecate()"><?php echo lang('close');?></a>';
            html = html + '</div>';
            html = html + '<input type="hidden" name="action" value="add_cate" />';
            html = html + '</div>';
            html = html + '</div>';
			html = html + '<?php echo form_close(); ?>';
			
            html = html + '</div>';
            document.getElementById('add_form').innerHTML = html;
    }
	
	function editCateFont()
	{
		var cate = jQuery('#list-cate-font').val();
		var text = jQuery('#list-cate-font option:selected').text();
		jQuery('#edit-cate-font').val(cate);
		jQuery('#edit-cate-title').val(text);
	}
	
	function removeCateFont()
	{
		var cate = jQuery('#list-cate-font').val();
		if(cate != 0)
		{
			var cf = confirm('<?php echo lang('fonts_delete_cate_confirm')?>');
			if(cf)
			{
				jQuery('#del-cate-font').val(cate);
				dgUI.ajax.submit('#fr-del-cate', true, load, update);
			}
		}else
		{
			alert('<?php echo lang('fonts_cate_system_del_error_msg');?>');
		}
	}
	
	function sub()
	{
		<?php if($id == ''){ ?>
			if(jQuery('#font-woff').val() == ''){
				alert('<?php echo lang('fonts_select_file_font_msg')?>');
				return false;
			}else if(jQuery('#font-thumb').val() == '')
			{
				alert('<?php echo lang('fonts_select_file_thumb_msg')?>');
				return false;
			}
		<?php } ?>
		var cate = jQuery('#list-cate-font').val();
		if(cate != 0)
		{
			if(fileSize('font-woff') > 2048 || fileSize('font-file') > 2048 || fileSize('font-thumb') > 2048){
				alert('<?php echo lang('fonts_add_file_size_error_msg') ?>');
				return false;
			}
		}else
		{
			alert('<?php echo lang('fonts_add_choose_cate_msg') ?>');
            return false;
		}
	}
	
	function fileSize(e){
        var uploadedFile = document.getElementById(e);
        return uploadedFile.files[0].size/1024;
    }
	
	jQuery('.fr-edit-fonts').validate();
	
	function subCate()
	{
		var val = jQuery('#edit-cate-font').val();
		if(val != 0)
		{
			var check = jQuery('#fr-edit-cate').validate({event: 'click'});	
			dgUI.ajax.submit('#fr-edit-cate', check, load, update);
		}else
		{
			 alert('<?php echo lang('fonts_cate_update_system_error_msg') ?>');
		}
	}

    function closecate() {
        document.getElementById('add_form').innerHTML = '';
    }

    function save() {
        var category = jQuery('.category_title').val();
		if(category != ''){
			dgUI.ajax.submit('.form-add', true, load, update);
		}else{
			alert('<?php echo lang('fonts_insert_category_error_msg')?>');
		}
    }

    function update() {
        jQuery('#panel-form,.modal-body').unblock();
        jQuery.post("<?php echo site_url() ?>admin/settings/fonts/add_cate", function(data) {
            document.getElementById('add_cat').innerHTML = data;
            jQuery('.tooltips').tooltip();
			jQuery('#add_form').html('');
			jQuery('.close').click();
        });
    }
    function load() {
        var pathArray = window.location.href.split('/');
        jQuery('#panel-form,.modal-body').block({
            overlayCSS: {
                backgroundColor: '#fff'
            },
            message: '<img src="<?php echo base_url()?>assets/images/loading.gif" /> <?php echo lang('load_text'); ?>',
            css: {
                border: 'none',
                color: '#333',
                background: 'none'
            }
        });
    }
    var conf = '<?php echo lang('fonts_delete_category_confirm'); ?>';
</script>
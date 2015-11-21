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
<script src="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/plugins/tinymce/tinymce.min.js'); ?>" type="text/javascript"></script>
<link href="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.css'); ?>" rel="stylesheet"/>

<form name="setting" class="setting-save" method="POST" action="<?php echo site_url('popup/admin/setting/save/'.$id); ?>">
<div class="tabpanel" role="tabpanel">

	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#tab-general" aria-controls="tab-general" role="tab" data-toggle="tab"><?php echo lang('general');?></a></li>
		<li role="presentation"><a href="#tab-design" aria-controls="tab-design" role="tab" data-toggle="tab"><?php echo lang('design_options'); ?></a></li>  
		<li class="button-back pull-right"><a href="javascript:void(0)" onclick="grid.module.setting('popup')" title="Back to list"><i class="clip-arrow-left-2"></i></a></li>    
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="tab-general">	
			<div class="form-group">
				<label><?php echo lang('title');?><span class="symbol required"></span></label>
				<input type="text" class="form-control input-sm validate required" name="title" placeholder="<?php echo lang('title');?>" value="<?php echo $popup->title; ?>" data-minlength="2" data-maxlength="200" data-msg="<?php echo lang('popup_admin_setting_title_validate');?>"> 
			</div>
			
			<?php
				$options = json_decode($popup->options);
			?>
			
			<div class="form-group">
				<div class="row">
					<div class="col-sm-6">
						<label><?php echo lang('popup_admin_setting_popup_type_title');?></label>
						<?php
							$type = array(
								'image'=>lang('popup_admin_setting_image_only_title'),
								'video'=>lang('popup_admin_setting_video_only_title'),
								'text'=>lang('popup_admin_setting_text_only_title'),
							); 
							if(isset($options->type))
								$default = $options->type;
							else
								$default = '';
							echo form_dropdown('options[type]', $type, $default, 'class="form-control input-sm fancybox_popup"');
						?>
					</div>
					<div class="col-sm-6">
						<label><?php echo lang('popup_admin_setting_popup_show_title');?></label>
						<?php
							$show = array(
								'click'=>lang('popup_admin_setting_show_on_click_title'),
								'onload'=>lang('popup_admin_setting_show_onload_title'),
							); 
							if(isset($options->show))
								$default = $options->show;
							else
								$default = '';
							echo form_dropdown('options[show]', $show, $default, 'class="form-control input-sm"');
						?>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div id="content_popup">
					<?php
						if(isset($options->type) && $options->type == 'text')
						{	
							echo '<label>'.lang('popup_admin_setting_content_title').'</label><br/>';
							echo '<textarea class="text-edittor" name="content" rows="7" >'.$popup->content.'</textarea>';
						}else if(isset($options->type) && $options->type == 'video')
						{
							echo '<label>'.lang('popup_admin_setting_url_title').'</label><br/>';
							echo '<input type="text" name="content" class="form-control input-sm" value="'.$popup->content.'" placeholder="'.lang('popup_admin_setting_url_title').'"/>';
						}else
						{
							echo '<label>'.lang('popup_admin_setting_image_title').'</label><br/>';
							if($popup->content != '')
							{
								echo '<div id="image-box-img-bg" style="display:inline;">';
								echo '<img src="'.base_url($popup->content).'" class="pull-left box-image" style="width: 80px;" alt="" width="100" />';
							}else
							{
								echo '<div id="image-box-img-bg" style="display:none;">';
							}
					?>
							<a href="javascript:void(0)" class="gird-box-bg-remove" onclick="removeImg(this)"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
						</div>
						<input type="hidden" name="content" id="gird-box-img-view" value="<?php echo $popup->content; ?>">
						<a class="gird-box-image" href="javascript:void(0)" onclick="jQuery.fancybox( {href : '<?php echo site_url().'admin/media/modals/imageImg/1'; ?>', type: 'iframe'} );"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
					<?php
						}
					?>
				</div>
			</div>
		</div>
		
		<!-- design options -->
		<?php 
			$params = json_decode($popup->params, true);
		?>
		<div role="tabpanel" class="tab-pane" id="tab-design">
			<div class="design-box">
				<div class="design-box-left">
					<div class="box-css">
						<label><?php echo lang('css');?></label>
						<div class="box-margin">
							<label><?php echo lang('margin');?></label>
							<input type="text" class="box-input" name="params[margin][left]" value="<?php echo setParams($params, 'margin', 'left'); ?>" id="margin-left">
							<input type="text" class="box-input" name="params[margin][right]" value="<?php echo setParams($params, 'margin', 'right'); ?>" id="margin-right">
							<input type="text" class="box-input" name="params[margin][top]" value="<?php echo setParams($params, 'margin', 'top'); ?>" id="margin-top">
							<input type="text" class="box-input" name="params[margin][bottom]" value="<?php echo setParams($params, 'margin', 'bottom'); ?>" id="margin-bottom">
							
							<div class="box-border">
								<label><?php echo lang('border');?></label>
								<input type="text" class="box-input" name="params[border][left]" value="<?php echo setParams($params, 'border', 'left'); ?>" id="border-left">
								<input type="text" class="box-input" name="params[border][right]" value="<?php echo setParams($params, 'border', 'right'); ?>" id="border-right">
								<input type="text" class="box-input" name="params[border][top]" value="<?php echo setParams($params, 'border', 'top'); ?>" id="border-top">
								<input type="text" class="box-input" name="params[border][bottom]" value="<?php echo setParams($params, 'border', 'bottom'); ?>" id="border-bottom">
								
								<div class="box-padding">
									<label><?php echo lang('padding');?></label>
									<input type="text" class="box-input" name="params[padding][left]" value="<?php echo setParams($params, 'padding', 'left'); ?>" id="padding-left">
									<input type="text" class="box-input" name="params[padding][right]" value="<?php echo setParams($params, 'padding', 'right'); ?>" id="padding-right">
									<input type="text" class="box-input" name="params[padding][top]" value="<?php echo setParams($params, 'padding', 'top'); ?>" id="padding-top">
									<input type="text" class="box-input" name="params[padding][bottom]" value="<?php echo setParams($params, 'padding', 'bottom'); ?>" id="padding-bottom">
									
									<div class="box-elment">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="design-box-right">
					<label><?php echo lang('border');?></label>
					<div class="row col-md-12">
						<div class="form-group pick-color">						
							<div class="input-group">							
								<input type="text" class="form-control color input-sm" name="params[borderColor]" value="<?php echo setParams($params, 'borderColor'); ?>">
								<div class="input-group-addon pick-color-btn"><?php echo lang('select_color');?></div>
							</div>
							<a href="#" class="btn btn-default btn-sm pick-color-clear"><?php echo lang('clear');?></a>
						</div>
					</div>
					<div class="row col-md-12">
						<div class="form-group">
							<?php $options = array('Defaults', 'Solid','Dotted','Dashed','None','Hidden','Double','Groove','Ridge','Inset','Outset','Initial','Inherit'); ?>
							<select class="form-control input-sm" name="params[borderStyle]">
								
								<?php for($i=0; $i<12; $i++){ ?>
									<?php $border_style = setParams($params, 'borderStyle'); 
										if($border_style == $options[$i])
											$check = 'selected="selected"';
										else
											$check = '';
									?>
									<option value="<?php echo $options[$i]; ?>" <?php echo $check;?>><?php echo $options[$i]; ?></option>
								<?php } ?>
								
							</select>
						</div>
					</div>
					
					<label><?php echo lang('background');?></label>
					<div class="row col-md-12">
						<div class="form-group pick-color">						
							<div class="input-group">							
								<input type="text" class="form-control color input-sm" name="params[background][color]" value="<?php echo setParams($params, 'background', 'color'); ?>">
								<div class="input-group-addon pick-color-btn"><?php echo lang('select_color');?></div>
							</div>
							<a href="#" class="btn btn-default btn-sm pick-color-clear"><?php echo lang('clear');?></a>
						</div>
					</div>
					<div class="row col-md-12">
						<div class="form-group">	
							<?php 
								$image = setParams($params, 'background', 'image'); 
								if($image != '')
								{
									echo '<div id="gird-box-bg" style="display:inline;">';
									echo '<img src="'.base_url($image).'" class="pull-left box-image" style="width: 80px;" alt="" width="100" />';
								}else
								{
									echo '<div id="gird-box-bg" style="display:none;">';
								}
							?>
								<a href="javascript:void(0)" class="gird-box-bg-remove" onclick="gridRemoveImg(this)"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
							</div>
							<input type="hidden" name="params[background][image]" id="gird-box-bg-img" value="<?php echo $image; ?>">
							<a class="gird-box-image" href="javascript:void(0)" onclick="jQuery.fancybox( {href : '<?php echo site_url().'admin/media/modals/productImg/1'; ?>', type: 'iframe'} );"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
						</div>
					</div>
					<div class="row col-md-12">
						<div class="form-group">
							<?php $options = array('Defaults','Repeat','No repeat'); ?>
								<select class="form-control input-sm" name="params[background][style]">
									
									<?php for($i=0; $i<3; $i++){ ?>
										<?php $background_style = setParams($params, 'background', 'style'); 
											if($background_style == $options[$i])
												$check = 'selected="selected"';
											else
												$check = '';
										?>
										<option value="<?php echo $options[$i]; ?>" <?php echo $check; ?>><?php echo $options[$i]; ?></option>
									<?php } ?>
									
								</select>
						</div>
					</div>
				</div>
			</div>
		</div>    
	</div>
</div>
</form>
<script type="text/javascript">
	function imageImg(images)
	{
		if(images.length > 0)
		{
			var e = jQuery('#image-box-img-bg');			
			if(e.children('img').length > 0)
				e.children('img').attr('src', images[0]);
			else
				e.append('<img src="'+images[0]+'" class="pull-left box-image" style="width: 80px;" alt="" width="100" />');
			e.css('display', 'inline');
			var str = images[0];
			str = str.replace("<?php echo base_url();?>", "");
			jQuery('#gird-box-img-view').val(str);
			jQuery.fancybox.close();
		}
	}

	function removeImg(e){
		var e = jQuery('#image-box-img-bg');
		e.children('img').remove();
		e.css('display', 'none');
		jQuery('#gird-box-img-view').val('');
	}

	jQuery('.fancybox_popup').change(function(){
		var type = jQuery(this).val();
		
		if(type == 'image')
		{	
			var html = '';
			html += '<label><?php echo lang('popup_admin_setting_image_title'); ?></label><br/>';
			html +='<div id="image-box-img-bg" style="display:none;">';
			html +='<a href="javascript:void(0)" class="gird-box-bg-remove" onclick="removeImg(this)"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';
			html +='</div>';
			html +='<input type="hidden" name="content" id="gird-box-img-view" value="">';
			html +='<a class="gird-box-image" href="javascript:void(0)" onclick="jQuery.fancybox( {href : \'<?php echo site_url().'admin/media/modals/imageImg/1'; ?>\', type: \'iframe\'} );"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>';
			html +='</div>';
			jQuery('#content_popup').html(html);
		}else if(type == 'video')
		{	
			var html = '';
			html += '<label><?php echo lang('popup_admin_setting_url_title'); ?></label><br/>';
			html +='<input type="text" class="form-control input-sm" name="content" placeholder="<?php echo lang('popup_admin_setting_url_title'); ?>"/>';
			jQuery('#content_popup').html(html);
		}else
		{
			addMceTiny();
		}
	});
	
	function addMceTiny()
	{
		var html = '';
		html += '<label><?php echo lang('popup_admin_setting_content_title'); ?></label><br/>';
		html += '<textarea class="text-edittor" name="content" rows="7" ></textarea>';
		jQuery('#content_popup').html(html);
		
		tinymce.PluginManager.add('dgmedia', function(editor, url) {
			// Add a button that opens a window
			editor.addButton('dgmedia', {
				text: 'Add Image',
				icon: false,		
				onclick: function() {
					jQuery.fancybox( {href : base_url + 'admin/media/modals/descriptMedia/2', type: 'iframe'} );
				}
			}); 
		});
		tinymce.init({
			selector: ".text-edittor",
			menubar: false,
			toolbar_items_size: 'small',
			statusbar: false,
			convert_urls: false,
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
			toolbar: "code | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | numlist outdent indent | image dgmedia"
		});
	}
	
	var base_url = '<?php echo site_url(); ?>';
	var url = '<?php echo base_url(); ?>';
	var areaZoom = 10;

	tinymce.PluginManager.add('dgmedia', function(editor, url) {
		// Add a button that opens a window
		editor.addButton('dgmedia', {
			text: 'Add Image',
			icon: false,		
			onclick: function() {
				jQuery.fancybox( {href : base_url + 'admin/media/modals/descriptMedia/2', type: 'iframe'} );
			}
		}); 
	});
	tinymce.init({
		selector: ".text-edittor",
		menubar: false,
		toolbar_items_size: 'small',
		statusbar: false,
		convert_urls: false,
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
		toolbar: "code | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | numlist outdent indent | image dgmedia"
	});

	function descriptMedia(images)
	{
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
</script>
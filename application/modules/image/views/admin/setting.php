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
<script src="<?php echo base_url('assets/plugins/validate/validate.js'); ?>" type="text/javascript"></script>
<link href="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.css'); ?>" rel="stylesheet"/>

<form name="setting" class="setting-save" method="POST" action="<?php echo site_url('image/admin/setting/save/'.$id); ?>">
<div class="tabpanel" role="tabpanel">

	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#tab-general" aria-controls="tab-general" role="tab" data-toggle="tab"><?php echo lang('general');?></a></li>
		<li role="presentation"><a href="#tab-design" aria-controls="tab-design" role="tab" data-toggle="tab"><?php echo lang('design_options'); ?></a></li>   
		<li class="button-back pull-right"><a href="javascript:void(0)" onclick="grid.module.setting('image')" title="Back to list"><i class="clip-arrow-left-2"></i></a></li>    
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="tab-general">	
			<div class="form-group">
				<label><?php echo lang('image_admin_setting_widget_title');?><span class="symbol required"></span></label>
				<input type="text" class="form-control input-sm validate required" name="title" placeholder="<?php echo lang('title');?>" value="<?php echo $image->title; ?>" data-minlength="2" data-maxlength="200" data-msg="<?php echo lang('image_admin_setting_widget_title_validate');?>"> 
				<p class="help-block"><?php echo lang('image_admin_setting_widget_title_eg');?></p>
			</div>
			
			<div class="form-group" style="display: table;">
				<label><?php echo lang('image');?><span class="symbol required"></span></label><br/>
				<?php 
					if($image->content != '')
					{
						echo '<div id="image-box-img-bg" style="display:inline;">';
						echo '<img src="'.base_url($image->content).'" class="pull-left box-image" style="width: 80px;" alt="" width="100" />';
					}else
					{
						echo '<div id="image-box-img-bg" style="display:none;">';
					}
				?>
					<a href="javascript:void(0)" class="gird-box-bg-remove" onclick="removeImg(this)"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
				</div>
				<input type="hidden" name="image" id="gird-box-img-view" value="<?php echo $image->content; ?>">
				<a class="gird-box-image" href="javascript:void(0)" onclick="jQuery.fancybox( {href : '<?php echo site_url().'admin/media/modals/imageImg/1'; ?>', type: 'iframe'} );"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
			</div>
			
			<div class="form-group">
				<label><?php echo lang('image_admin_setting_css_animation_title');?></label>
				<div class="row">
					<div class="col-sm-4">
						<?php 
							$options = json_decode($image->options);
							$animation = array(
								''=>lang('no'),
								'top-to-bottom'=>lang('image_admin_setting_top_to_bottom'),
								'bottom-to-top'=>lang('image_admin_setting_bottom_to_top'),
								'left-to-right'=>lang('image_admin_setting_left_to_right'),
								'right-to-left'=>lang('image_admin_setting_right_to_left'),
								'appear-center'=>lang('image_admin_setting_appear_center'),
							);
							if(isset($options->animation))
								$animation_data = $options->animation;
							else
								$animation_data = '';
							echo form_dropdown('options[animation]', $animation, $animation_data, 'class="form-control input-sm"');
						?>
					</div>
				</div>
				<p class="help-block"><?php echo lang('image_admin_setting_css_animation_eg');?></p>
			</div>
			
			<div class="form-group">
				<div class="row">
					<div class="col-sm-6">
						<label><?php echo lang('image_admin_setting_image_width_title');?></label>
						<?php
							if(isset($options->width))
								$width = $options->width;
							else
								$width = '';
						?>
						<input type="text" class="form-control input-sm" name="options[width]" placeholder="<?php echo lang('image_admin_setting_image_width_title');?>" value="<?php echo $width; ?>">
					</div>
					<div class="col-sm-6">
						<label><?php echo lang('image_admin_setting_image_height_title');?></label>
						<?php
							if(isset($options->height))
								$height = $options->height;
							else
								$height = '';
						?>
						<input type="text" class="form-control input-sm" name="options[height]" placeholder="<?php echo lang('image_admin_setting_image_height_title');?>" value="<?php echo $height; ?>">
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label><?php echo lang('image_admin_setting_image_alignment_title');?></label>
				<div class="row">
					<div class="col-sm-4">
						<?php 
							$alignment = array(
								'left'=>lang('image_admin_setting_align_left'),
								'right'=>lang('image_admin_setting_align_right'),
								'center'=>lang('image_admin_setting_align_center')
							);
							if(isset($options->alignment))
								$alignment_data = $options->alignment;
							else
								$alignment_data = '';
							echo form_dropdown('options[alignment]', $alignment, $alignment_data, 'class="form-control input-sm"');
						?>
					</div>
				</div>
				<p class="help-block"><?php echo lang('image_admin_setting_css_animation_eg');?></p>
			</div>
			
			<div class="form-group">
				<label><?php echo lang('image_admin_setting_image_style_title');?></label>
				<div class="row">
					<div class="col-sm-4">
						<?php 
							$style = array(
								''=>lang('image_admin_setting_default'),
								'img-rounded'=>lang('image_admin_setting_rounded'),
								'img-circle'=>lang('image_admin_setting_circle'),
								'img-thumbnail'=>lang('image_admin_setting_thumbnail'),
							);
							if(isset($options->style))
								$style_data = $options->style;
							else
								$style_data = '';
							echo form_dropdown('options[style]', $style, $style_data, 'class="form-control input-sm"');
						?>
					</div>
					<span style="height: 30px; display: block; float: left; width: 30px; text-align: center; border-radius: 5px; line-height: 27px; background: #ccc; font-size: 8px;"><?php echo lang('image_admin_setting_rounded');?></span>
					<span style="height: 30px; display: block; float: left; width: 30px; text-align: center; border-radius: 100%; line-height: 27px; background: #ccc; margin-left: 5px; font-size: 8px;"><?php echo lang('image_admin_setting_circle');?></span>
					<span style="height: 30px; display: block; float: left; width: 40px; border: 1px solid #ccc; padding: 1px; line-height: 26px; background: #ccc; margin-left: 5px; font-size: 8px;"><?php echo lang('image_admin_setting_thumbnail');?></span>
				</div>
			</div>
			
			<div class="form-group">
				<label><?php echo lang('image_admin_setting_image_link_title');?></label>
				<?php
					if(isset($options->link))
						$link_data = $options->link;
					else
						$link_data = '';
				?>
				<input type="text" class="form-control input-sm" name="options[link]" placeholder="<?php echo lang('image_admin_setting_image_link_title');?>" value="<?php if($link_data != '') echo $link_data; else echo 'http://'; ?>">
				<p class="help-block"><?php echo lang('image_admin_setting_image_link_eg');?></p>
			</div>
			
			<div class="form-group">
				<label><?php echo lang('image_admin_setting_extra_class_name_title');?></label>
				<?php
					if(isset($options->class_sfx))
						$class_sfx_data = $options->class_sfx;
					else
						$class_sfx_data = '';
				?>
				<input type="text" class="form-control input-sm" name="options[class_sfx]" placeholder="<?php echo lang('image_admin_setting_extra_class_name_title');?>" value="<?php echo $class_sfx_data; ?>">
				<p class="help-block"><?php echo lang('image_admin_setting_extra_class_name_eg');?></p>
			</div>
		</div>
		
		<!-- design options -->
		<?php 
			$params = json_decode($image->params, true);
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
											$check = 'selected=""';
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
												$check = 'selected=""';
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
function productImg(images)
{
	if(images.length > 0)
	{
		var e = jQuery('#gird-box-bg');			
		if(e.children('img').length > 0)
			e.children('img').attr('src', images[0]);
		else
			e.append('<img src="'+images[0]+'" class="pull-left box-image" style="width: 80px;" alt="" width="100" />');
		e.css('display', 'inline');
		var str = images[0];
		str = str.replace("<?php echo base_url();?>", "");
		jQuery('#gird-box-bg-img').val(str);
		jQuery.fancybox.close();
	}
}

function gridRemoveImg(e){
	var e = jQuery('#gird-box-bg');
	e.children('img').remove();
	e.css('display', 'none');
	jQuery('#gird-box-bg-img').val('');
}

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
</script>
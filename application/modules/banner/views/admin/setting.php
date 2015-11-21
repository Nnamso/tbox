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

<form name="setting" class="setting-save form-horizontal" method="POST" action="<?php echo site_url('banner/admin/setting/save/'.$id); ?>">
<div class="tabpanel" role="tabpanel">

	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#tab-general" aria-controls="tab-general" role="tab" data-toggle="tab"><?php echo lang('general');?></a></li>
		<li role="presentation"><a href="#tab-design" aria-controls="tab-design" role="tab" data-toggle="tab"><?php echo lang('design_options');?></a></li>  
		<li class="button-back pull-right"><a href="javascript:void(0)" onclick="grid.module.setting('banner')" title="Back to list"><i class="clip-arrow-left-2"></i></a></li>    		
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="tab-general">
			<div class="form-group">
				<label class="col-sm-2"><?php echo lang('title');?></label>
				<div class="col-sm-10">
					<input type="text" class="form-control input-sm" name="title" placeholder="<?php echo lang('title');?>" value="<?php echo $banner->title; ?>" />
				</div>
			</div>
			<div id="banner_image">
				<div class="form-group">
					<label class="col-sm-2"></label>
					<div class="col-sm-6">
						<a class="btn btn-default btn-sm" onclick="jQuery.fancybox( {href : '<?php echo site_url().'admin/media/modals/bannerImg/1'; ?>', type: 'iframe'} );" href="javascript:void(0)"><?php echo lang('add_image');?></a>
					</div>
				</div>
				<?php
					$images = json_decode($banner->images, true);
					$captions = json_decode($banner->captions, true);
					if(is_array($images))
					{
						foreach($images as $key=>$image)
						{
							if(isset($captions[$key]))
								$caption = $captions[$key];
							else
								$caption = '';
							echo '<div class="form-group">
									<div class="col-sm-2">'.lang('image').'</div>
									<div class="col-sm-3">
										<img src="'.base_url($image).'" alt="slider" class="img-thumbnail" />
										<i onclick="removeImg(this)" class="glyphicon glyphicon-remove" style="position: absolute; color: #d9534f; border-bottom: 1px solid #ccc; border-left: 1px solid #ccc; padding: 2px; top: 0px; right: 17px; cursor: pointer;"></i>
									</div>
									<div class="col-sm-7">
										<input type="hidden" name="images[]" value="'.$image.'">
										<textarea name="caption[]" class="form-control" rows="3" placeholder="'.lang('caption').'">'.$caption.'</textarea>
									</div>
								</div>
							';
						}
					}
					
					$settings = json_decode($banner->settings, true);
				?>
			</div>
			<div class="form-group">
				<label class="col-sm-2"><?php echo lang('banner_option_mode_label');?></label> 
				<div class="col-sm-4">
					<?php
						$mode = array(
							'horizontal'=>lang('banner_option_horizontal_option'),
							'vertical'=>lang('banner_option_vertical_option'),
							'fade'=>lang('banner_option_fade_option'),
						);
						if(isset($settings['mode']))
							$default = $settings['mode'];
						else	
							$default = '';
						echo form_dropdown('setting[mode]', $mode, $default, 'class="form-control input-sm"');
					?>
				</div>
				<div class="col-sm-6">
					<p class="help-block" style="margin-top: 0px;"><?php echo lang('banner_option_mode_eg');?></p>
				</div>	
			</div>	
			<div class="form-group">
				<label class="col-sm-2"><?php echo lang('banner_option_caption_title');?></label> 
				<div class="col-sm-4">
					<?php
						$caption = array(
							'true'=>lang('yes'),
							'false'=>lang('no'),
						);
						if(isset($settings['captions']))
							$default = $settings['captions'];
						else	
							$default = '';
						echo form_dropdown('setting[captions]', $caption, $default, 'class="form-control input-sm"');
					?>
				</div>
				<div class="col-sm-6">
					<p class="help-block" style="margin-top: 0px;"><?php echo lang('banner_option_caption_eg');?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2"><?php echo lang('banner_option_infinite_loop_title');?></label> 
				<div class="col-sm-4">
					<?php
						$infiniteLoop = array(
							'true'=>lang('yes'),
							'false'=>lang('no'),
						);
						if(isset($settings['infiniteLoop']))
							$default = $settings['infiniteLoop'];
						else	
							$default = '';
						echo form_dropdown('setting[infiniteLoop]', $infiniteLoop, $default, 'class="form-control input-sm"');
					?>
				</div>
				<div class="col-sm-6">
					<p class="help-block" style="margin-top: 0px;"><?php echo lang('banner_option_infinite_loop_eg');?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2"><?php echo lang('banner_option_autoControls_title');?></label> 
				<div class="col-sm-4">
					<?php
						$autoControls = array(
							'true'=>lang('yes'),
							'false'=>lang('no'),
						);
						if(isset($settings['autoControls']))
							$default = $settings['autoControls'];
						else	
							$default = '';
						echo form_dropdown('setting[autoControls]', $autoControls, $default, 'class="form-control input-sm"');
					?>
				</div>
				<div class="col-sm-6">
					<p class="help-block" style="margin-top: 0px;"><?php echo lang('banner_option_autoControls_eg');?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2"><?php echo lang('banner_option_hide_control_on_end');?></label> 
				<div class="col-sm-4">
					<?php
						$hideControlOnEnd = array(
							'true'=>lang('yes'),
							'false'=>lang('no'),
						);
						if(isset($settings['hideControlOnEnd']))
							$default = $settings['hideControlOnEnd'];
						else	
							$default = '';
						echo form_dropdown('setting[hideControlOnEnd]', $hideControlOnEnd, $default, 'class="form-control input-sm"');
					?>
				</div>
				<div class="col-sm-6">
					<p class="help-block" style="margin-top: 0px;"><?php echo lang('banner_option_hide_control_eg');?></p>
				</div>
			</div>
			<div class="form-group">	
				<label class="col-sm-2"><?php echo lang('banner_option_max_slide_title');?></label> 
				<div class="col-sm-4">
					<?php
						if(isset($settings['maxSlides']))
							$default = $settings['maxSlides'];
						else	
							$default = '1';
					?>
					<input type="text" name="setting[maxSlides]" class="form-control input-sm" value="<?php echo $default;?>">
				</div>
				<div class="col-sm-6">
					<p class="help-block" style="margin-top: 0px;"><?php echo lang('banner_option_minimum_number_eg');?></p>
				</div>
			</div>
			<div class="form-group">	
				<label class="col-sm-2"><?php echo lang('banner_option_slide_width_title');?></label> 
				<div class="col-sm-4">
					<input type="text" name="setting[slideWidth]" class="form-control input-sm" value="<?php if(isset($settings['slideWidth'])) echo $settings['slideWidth'];?>">
				</div>
				<div class="col-sm-6">
					<p class="help-block" style="margin-top: 0px;"><?php echo lang('banner_option_slide_width_help');?></p>
				</div>
			</div>
		</div>
		
		<!-- design options -->
		<?php 
			$params = json_decode($banner->params, true);
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
						
					<div class="col-md-12">
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
</div>
</form>

<script type="text/javascript">
	function bannerImg(images)
	{
		if(images.length > 0)
		{
			var e = jQuery('#banner_image');	
			var html = e.html();
			var str = images[0];
			str = str.replace("<?php echo base_url();?>", "");
			html += '<div class="form-group">';
			html += '<div class="col-sm-2">Image';
			html += '</div>';
			html += '<div class="col-sm-3">';
			html += '<img src="'+images[0]+'" alt="slider" class="img-thumbnail" />';
			html += '<i onclick="removeImg(this)" class="glyphicon glyphicon-remove" style="position: absolute; color: #d9534f; border-bottom: 1px solid #ccc; border-left: 1px solid #ccc; padding: 2px; top: 0px; right: 17px; cursor: pointer;"></i>';
			html += '</div>';
			html += '<div class="col-sm-7">';
			html += '<input type="hidden" name="images[]" value="'+str+'">';
			html += '<textarea name="caption[]" class="form-control" rows="3" placeholder="<?php echo lang('caption');?>"></textarea>';
			html += '</div>';
			html += '</div>';
			e.html(html);
			jQuery.fancybox.close();
		}
	}
	
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
	
	function removeImg(e){
		jQuery(e).parent('div').parent('div').remove();
	}
	
</script>
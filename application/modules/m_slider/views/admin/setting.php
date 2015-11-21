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

$settings = json_decode($slider->options, true);
$j = 0;
?>
<script src="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/plugins/validate/validate.js'); ?>" type="text/javascript"></script>
<link href="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.css'); ?>" rel="stylesheet"/>

<form name="setting" class="setting-save form-horizontal" method="POST" action="<?php echo site_url('m_slider/admin/setting/save/'.$id); ?>">
<div class="tabpanel" role="tabpanel">

	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#tab-general" aria-controls="tab-general" role="tab" data-toggle="tab"><?php echo lang('general');?></a></li>
		<li role="presentation"><a href="#tab-design" aria-controls="tab-design" role="tab" data-toggle="tab"><?php echo lang('design_options');?></a></li>  
		<li class="button-back pull-right"><a href="javascript:void(0)" onclick="grid.module.setting('m_slider')" title="Back to list"><i class="clip-arrow-left-2"></i></a></li>    		
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="tab-general">
			<div class="form-group">
				<label class="col-sm-2"><?php echo lang('title');?></label>
				<div class="col-sm-10">
					<input type="text" class="form-control input-sm" name="title" placeholder="<?php echo lang('title');?>" value="<?php echo $slider->title; ?>" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2"><?php echo lang('slider_option_mode_label');?></label> 
				<div class="col-sm-4">
					<?php
						$mode = array(
							'horizontal'=>lang('slider_option_horizontal_option'),
							'vertical'=>lang('slider_option_vertical_option'),
							'fade'=>lang('slider_option_fade_option'),
						);
						if(isset($settings['mode']))
							$default = $settings['mode'];
						else	
							$default = '';
						echo form_dropdown('setting[mode]', $mode, $default, 'class="form-control input-sm"');
					?>
				</div>
				<div class="col-sm-6">
					<p class="help-block" style="margin-top: 0px;"><?php echo lang('slider_option_mode_eg');?></p>
				</div>	
			</div>	
			<div class="form-group">
				<label class="col-sm-2"><?php echo lang('slider_option_infinite_loop_title');?></label> 
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
					<p class="help-block" style="margin-top: 0px;"><?php echo lang('slider_option_infinite_loop_eg');?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2"><?php echo lang('slider_option_auto_title');?></label> 
				<div class="col-sm-4">
					<?php
						$auto = array(
							'true'=>lang('yes'),
							'false'=>lang('no'),
						);
						if(isset($settings['auto']))
							$default = $settings['auto'];
						else	
							$default = '';
						echo form_dropdown('setting[auto]', $auto, $default, 'class="form-control input-sm"');
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2"><?php echo lang('slider_option_autoControls_title');?></label> 
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
					<p class="help-block" style="margin-top: 0px;"><?php echo lang('slider_option_autoControls_eg');?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2"><?php echo lang('slider_option_hide_control_on_end');?></label> 
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
					<p class="help-block" style="margin-top: 0px;"><?php echo lang('slider_option_hide_control_eg');?></p>
				</div>
			</div>
			<div class="form-group">	
				<label class="col-sm-2"><?php echo lang('slider_option_max_slide_title');?></label> 
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
					<p class="help-block" style="margin-top: 0px;"><?php echo lang('slider_option_minimum_number_eg');?></p>
				</div>
			</div>
			
			<div class="form-group">	
				<label class="col-sm-2"><?php echo lang('slider_option_time_title');?></label> 
				<div class="col-sm-4">
					<input type="text" name="setting[speed]" class="form-control input-sm" value="<?php if(isset($settings['speed'])) echo $settings['speed']; else echo '400'; ?>">
				</div>
			</div>
			
			<div class="form-group">	
				<label class="col-sm-2"><?php echo lang('slider_option_slide_width_title');?></label> 
				<div class="col-sm-4">
					<input type="text" name="setting[slideWidth]" class="form-control input-sm" value="<?php if(isset($settings['slideWidth'])) echo $settings['slideWidth'];?>">
				</div>
				<div class="col-sm-6">
					<p class="help-block" style="margin-top: 0px;"><?php echo lang('slider_option_slide_width_help');?></p>
				</div>
			</div>
			
			<div class="form-group">	
				<label class="col-sm-2"><?php echo lang('slider_option_slide_height_title');?></label> 
				<div class="col-sm-4">
					<input type="text" name="setting[slideHeight]" class="form-control input-sm" value="<?php if(isset($settings['slideHeight'])) echo $settings['slideHeight'];?>">
				</div>
				<div class="col-sm-6">
					<p class="help-block" style="margin-top: 0px;"><?php echo lang('slider_option_slide_height_help');?></p>
				</div>
			</div>
			
			<div id="List-m_slider">
				<div class="panel-group" id="accordion" aria-multiselectable="true" role="tablist">
					<?php
						
						$data = json_decode($slider->content, true);
						if(isset($data['images']) && is_array($data['images']))
						{
							$i = 0;
							foreach($data['images'] as $key=>$image)
							{ 
					?>
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="heading-<?php echo $i;?>">
									<i class="glyphicon glyphicon-remove pull-right" onclick="remove_accordion(this);" style="color: #D9534F; cursor: pointer;"></i>
									<h4 class="panel-title">
										<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo $i;?>" aria-expanded="false" aria-controls="collapse-<?php echo $i;?>">
											<?php echo lang('slider_option_add_item_title');?>
										</a>
									</h4>
								</div>
								<div id="collapse-<?php echo $i;?>" class="panel-collapse collapse" role="tabpanel" aria-expanded="false" aria-labelledby="heading-<?php echo $i;?>">
									<div class="panel-body">
										<div class="form-group">
											<div class="col-md-3"><a class="btn btn-default btn-sm" onclick="add_image_slide(this);" href="javascript:void(0)"><?php echo lang('add_image');?></a></div>
											<div class="imagebox col-md-3" class="col-md-4 col-sm-6 col-xs-9">
												<input type="hidden" name="data[images][]" value="<?php echo $image; ?>" class="imagevalue"/> 
												<img src="<?php echo base_url($image); ?>" class="pull-left box-image img-thumbnail" alt="image" />
												<a class="gird-box-bg-remove" onclick="removeImg(this)" href="javascript:void(0)" style="right: 20px;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-md-3"><?php echo lang('slider_option_video_url_title');?></label>
											<div class="col-md-8">
												<input type="text" class="form-control input-sm" name="data[video_url][]" value="<?php echo $data['video_url'][$key]; ?>" placeholder="<?php echo lang('slider_option_video_url_place');?>"/>
											</div>
											<div class="col-md-3"></div>
											<div class="col-md-9">
												<p class="help-block" style="margin-top: 0px;"><?php echo lang('slider_option_slide_video_url_help');?></p>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-md-3"><?php echo lang('slider_option_display_title');?></label>
											<div class="col-md-6">
												<select name="data[display][]" class="form-control input-sm">
													<option <?php if($data['display'][$key] == 'image') echo 'selected="selected"'; ?> value="image"><?php echo lang('slider_option_image');?></option>
													<option <?php if($data['display'][$key] == 'video') echo 'selected="selected"'; ?> value="video"><?php echo lang('slider_option_video');?></option>
												</select>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-md-3"><?php echo lang('slider_option_target_title');?></label>
											<div class="col-md-6">
												<select name="data[target][]" class="form-control input-sm">
													<option <?php if($data['target'][$key] == '_sef') echo 'selected="selected"'; ?> value="_sef"><?php echo lang('slider_option_sef');?></option>
													<option <?php if($data['target'][$key] == '_blank') echo 'selected="selected"'; ?> value="_blank"><?php echo lang('slider_option_blank');?></option>
												</select>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-md-3"><?php echo lang('slider_option_thumbnail_title');?></label>
											<div class="col-md-6">
												<select name="data[thumbnail][]" class="form-control input-sm">
													<option <?php if($data['thumbnail'][$key] == 'show') echo 'selected="selected"'; ?> value="show"><?php echo lang('slider_option_show_thumb');?></option>
													<option <?php if($data['thumbnail'][$key] == 'hide') echo 'selected="selected"'; ?> value="hide"><?php echo lang('slider_option_hide_thumb');?></option>
												</select>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-md-3"><?php echo lang('slider_option_link_url_title');?></label>
											<div class="col-md-6">
												<input type="text" class="form-control input-sm" name="data[url][]" value="<?php echo $data['url'][$key]; ?>" placeholder="<?php echo lang('slider_option_link_url_place');?>"/>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php $i++; $j++; } ?>
					<?php } ?>
				</div>
				<div style="text-align: center; margin: 10px; 0px;"><button type="button" class="btn btn-primary btn-sm" onclick="add_item_m_slider(this);"><i class="glyphicon glyphicon-plus"></i></button></div>
			</div>
			
		</div>
		
		<!-- design options -->
		<?php 
			$params = json_decode($slider->params, true);
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
								<a class="gird-box-image" href="javascript:void(0)" onclick="removeImg(this)"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
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
	var count =  <?php echo $j;?>;
	var active =  {};
	function add_image_slide(e)
	{
		active = e;
		jQuery.fancybox( {href : '<?php echo site_url().'admin/media/modals/m_sliderImg/1'; ?>', type: 'iframe'} );
	}
	
	function add_item_m_slider()
	{
		var e = jQuery('#accordion');	
		var html = e.html();
			html += '<div class="panel panel-default">';
			html += '<div class="panel-heading" role="tab" id="heading-'+count+'">';
			html += '<i class="glyphicon glyphicon-remove pull-right" onclick="remove_accordion(this);" style="color: #D9534F; cursor: pointer;"></i>';
			html += '<h4 class="panel-title">';
			html += '<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse-'+count+'" aria-expanded="false" aria-controls="collapse-'+count+'">';
			html += '<?php echo lang('slider_option_add_item_title');?>';
			html += '</a>';
			html += '</h4>';
			html += '</div>';
			html += '<div id="collapse-'+count+'" class="panel-collapse collapse" role="tabpanel" aria-expanded="false" aria-labelledby="heading-'+count+'">',
			html += '<div class="panel-body">';
			html += '<div class="form-group">';
			html += '<div class="col-md-3"><a class="btn btn-default btn-sm" onclick="add_image_slide(this);" href="javascript:void(0)"><?php echo lang('add_image');?></a></div>';
			html += '<div class="imagebox col-md-3" class="col-md-4 col-sm-6 col-xs-9">';
			html += '<input type="hidden" name="data[images][]" value="" class="imagevalue"/> ';
			html += '</div> ';
			html += '</div> ';
					
			html += '<div class="form-group">';
			html += '<label class="col-md-3"><?php echo lang('slider_option_video_url_title');?></label>';
			html += '<div class="col-md-8">';
			html += '<input type="text" class="form-control input-sm" name="data[video_url][]" value="" placeholder="<?php echo lang('slider_option_video_url_place');?>"/>';
			html += '<div class="col-md-3"></div>';
			html += '<div class="col-md-9">';
			html += '<p class="help-block" style="margin-top: 0px;"><?php echo lang('slider_option_slide_video_url_help');?></p>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
					
			html += '<div class="form-group">';
			html += '<label class="col-md-3"><?php echo lang('slider_option_display_title');?></label>';
			html += '<div class="col-md-6">';
			html += '<select name="data[display][]" class="form-control input-sm">';
			html += '<option value="image"><?php echo lang('slider_option_image');?></option>';
			html += '<option value="video"><?php echo lang('slider_option_video');?></option>';
			html += '</select>';
			html += '</div>';
			html += '</div>';
					
			html += '<div class="form-group">';
			html += '<label class="col-md-3"><?php echo lang('slider_option_target_title');?></label>';
			html += '<div class="col-md-6">';
			html += '<select name="data[target][]" class="form-control input-sm">';
			html += '<option value="_sef"><?php echo lang('slider_option_sef');?></option>';
			html += '<option value="_blank"><?php echo lang('slider_option_blank');?></option>';
			html += '</select>';
			html += '</div>';
			html += '</div>';
					
			html += '<div class="form-group">';
			html += '<label class="col-md-3"><?php echo lang('slider_option_thumbnail_title');?></label>';
			html += '<div class="col-md-6">';
			html += '<select name="data[thumbnail][]" class="form-control input-sm">';
			html += '<option value="show"><?php echo lang('slider_option_show_thumb');?></option>';
			html += '<option value="hide"><?php echo lang('slider_option_hide_thumb');?></option>';
			html += '</select>';
			html += '</div>';
			html += '</div>';
					
			html += '<div class="form-group">';
			html += '<label class="col-md-3"><?php echo lang('slider_option_link_url_title');?></label>';
			html += '<div class="col-md-6">';
			html += '<input type="text" class="form-control input-sm" name="data[url][]" value="" placeholder="<?php echo lang('slider_option_link_url_place');?>"/>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			count = count + 1;
			e.html(html);
	}
	
	function m_sliderImg(images)
	{
		if(images.length > 0)
		{	
			e = jQuery(active).parent('div').parent('div').children('.imagebox');
			if(e.children('img').length > 0)
				e.children('img').attr('src', images[0]);
			else
				e.append('<img src="'+images[0]+'" class="pull-left box-image img-thumbnail" alt="image" /><a class="gird-box-bg-remove" onclick="removeImg(this)" href="javascript:void(0)" style="right: 20px;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>');
			e.css('display', 'inline');
			var str = images[0];
			str = str.replace("<?php echo base_url();?>", "");
			jQuery(e).children('.imagevalue').val(str);
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
	
	function remove_accordion(e){
		jQuery(e).parent('div').parent('div').remove();
	}
	
	function removeImg(e){
		jQuery(e).parent('div').children('.box-image').remove();
		jQuery(e).parent('div').children('.imagevalue').val('');
		jQuery(e).parent('div').children('.gird-box-bg-remove').remove();
	}
	
</script>
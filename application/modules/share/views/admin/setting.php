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

<form name="setting" class="setting-save" method="POST" action="<?php echo site_url('share/admin/setting/save/'.$id); ?>">
<div class="tabpanel" role="tabpanel">

	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#tab-general" aria-controls="tab-general" role="tab" data-toggle="tab"><?php echo lang('general');?></a></li>
		<li role="presentation"><a href="#tab-design" aria-controls="tab-design" role="tab" data-toggle="tab"><?php echo lang('design_options'); ?></a></li>  
		<li class="button-back pull-right"><a href="javascript:void(0)" onclick="grid.module.setting('share')" title="Back to list"><i class="clip-arrow-left-2"></i></a></li>    
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="tab-general">	
			<div class="form-group">
				<label><?php echo lang('title');?><span class="symbol required"></span></label>
				<input type="text" class="form-control input-sm validate required" name="title" placeholder="<?php echo lang('title');?>" value="<?php echo $share->title; ?>" data-minlength="2" data-maxlength="200" data-msg="<?php echo lang('share_admin_setting_title_validate');?>"> 
			</div>
			<span class="help-block"><?php echo lang('share_admin_setting_url_help');?></span>
			<div class="form-group">
				<?php
					$content = json_decode($share->content);
				?>
				<div class="row">
					<div class="col-sm-6">
						<label><?php echo lang('share_admin_setting_facebook_title');?></label>
						<input type="text" class="form-control input-sm" name="data[facebook][link]" placeholder="<?php echo lang('share_admin_setting_link_place');?>" value="<?php if(isset($content->facebook->link)) echo $content->facebook->link;?>"> 
					</div>
					
					<div class="col-sm-4">
						<label><?php echo lang('share_admin_setting_option_title');?></label><br/>
						<?php
							$option_fb = array(
								'box_count'=>lang('share_admin_setting_option_box_count'),
								'button_count'=>lang('share_admin_setting_option_button_count'),
								'button'=>lang('share_admin_setting_option_button'),
								'icon_link'=>lang('share_admin_setting_option_icon_link'),
								'icon'=>lang('share_admin_setting_option_icon'),
								'link'=>lang('share_admin_setting_option_link'),
							);
							if(isset($content->facebook->option))
								$default = $content->facebook->option;
							else
								$default = '';
							echo form_dropdown('data[facebook][option]', $option_fb, $default, 'class="form-control input-sm"');
						?>
					</div>
					
					<div class="col-sm-2">
						<label><?php echo lang('share_admin_setting_publish_title');?></label><br/>
						<?php
							$publish = array(
								'yes'=>lang('yes'),
								'no'=>lang('no'),
							);
							if(isset($content->facebook->publish))
								$default = $content->facebook->publish;
							else
								$default = '';
							echo form_dropdown('data[facebook][publish]', $publish, $default, 'class="form-control input-sm"');
						?>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="row">
					<div class="col-sm-6">
						<label><?php echo lang('share_admin_setting_google_title');?></label>
						<input type="text" class="form-control input-sm" name="data[google][link]" placeholder="<?php echo lang('share_admin_setting_link_place');?>" value="<?php if(isset($content->google->link)) echo $content->google->link;?>"> 
					</div>
					
					<div class="col-sm-4">
						<label><?php echo lang('share_admin_setting_option_title');?></label><br/>
						<?php
							$option_gg = array(
								'none'=>lang('share_admin_setting_option_none'),
								'inline'=>lang('share_admin_setting_option_inline'),
								'bubble'=>lang('share_admin_setting_option_bubble'),
								'vertical-bubble'=>lang('share_admin_setting_vertical_bubble'),
							);
							if(isset($content->google->option))
								$default = $content->google->option;
							else
								$default = '';
							echo form_dropdown('data[google][option]', $option_gg, $default, 'class="form-control input-sm"');
						?>
					</div>
					
					<div class="col-sm-2">
						<label><?php echo lang('share_admin_setting_publish_title');?></label><br/>
						<?php
							$publish = array(
								'yes'=>lang('yes'),
								'no'=>lang('no'),
							);
							if(isset($content->google->publish))
								$default = $content->google->publish;
							else
								$default = '';
							echo form_dropdown('data[google][publish]', $publish, $default, 'class="form-control input-sm"');
						?>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="row">
					<div class="col-sm-6">
						<label><?php echo lang('share_admin_setting_tweet_title');?></label>
						<input type="text" class="form-control input-sm" name="data[google][link]" placeholder="<?php echo lang('share_admin_setting_link_place');?>" value="<?php if(isset($content->google->link)) echo $content->google->link;?>"> 
					</div>
					
					<div class="col-sm-4">
						<label><?php echo lang('share_admin_setting_option_title');?></label><br/>
						<?php
							$option_tw = array(
								'none'=>lang('share_admin_setting_option_none'),
								'count'=>lang('share_admin_setting_option_count'),
							);
							if(isset($content->tweet->option))
								$default = $content->tweet->option;
							else
								$default = '';
							echo form_dropdown('data[tweet][option]', $option_tw, $default, 'class="form-control input-sm"');
						?>
					</div>
					
					<div class="col-sm-2">
						<label><?php echo lang('share_admin_setting_publish_title');?></label><br/>
						<?php
							$publish = array(
								'yes'=>lang('yes'),
								'no'=>lang('no'),
							);
							if(isset($content->tweet->publish))
								$default = $content->tweet->publish;
							else
								$default = '';
							echo form_dropdown('data[tweet][publish]', $publish, $default, 'class="form-control input-sm"');
						?>
					</div>
				</div>
			</div>
			
			<div class="form-group">	
				<div class="row">
					<div class="col-sm-6">
						<label><?php echo lang('share_admin_setting_pinterest_title');?></label>
						<input type="text" class="form-control input-sm" name="data[pinterest][link]" placeholder="<?php echo lang('share_admin_setting_link_place');?>" value="<?php if(isset($content->pinterest->link)) echo $content->pinterest->link;?>"> 
					</div>
					
					<div class="col-sm-4">
						<label><?php echo lang('share_admin_setting_option_title');?></label><br/>
						<?php
							$option_pi = array(
								'none'=>lang('share_admin_setting_option_none'),
								'above'=>lang('share_admin_setting_option_above_count'),
								'beside'=>lang('share_admin_setting_option_beside_count'),
							);
							if(isset($content->pinterest->option))
								$default = $content->pinterest->option;
							else
								$default = '';
							echo form_dropdown('data[pinterest][option]', $option_pi, $default, 'class="form-control input-sm"');
						?>
					</div>
					
					<div class="col-sm-2">
						<label><?php echo lang('share_admin_setting_publish_title');?></label><br/>
						<?php
							$publish = array(
								'yes'=>lang('yes'),
								'no'=>lang('no'),
							);
							if(isset($content->pinterest->publish))
								$default = $content->pinterest->publish;
							else
								$default = '';
							echo form_dropdown('data[pinterest][publish]', $publish, $default, 'class="form-control input-sm"');
						?>
					</div>
				</div>
			</div>
			
			<div class="form-group">	
				<div class="row">
					<div class="col-sm-6">
						<label><?php echo lang('share_admin_setting_linkedin_title');?></label>
						<input type="text" class="form-control input-sm" name="data[linkedin][link]" placeholder="<?php echo lang('share_admin_setting_link_place');?>" value="<?php if(isset($content->linkedin->link)) echo $content->linkedin->link;?>"> 
					</div>
					
					<div class="col-sm-4">
						<label><?php echo lang('share_admin_setting_option_title');?></label><br/>
						<?php
							$option_in = array(
								''=>lang('share_admin_setting_option_none'),
								'top'=>lang('share_admin_setting_vetical_count'),
								'right'=>lang('share_admin_setting_horizontal_count'),
							);
							if(isset($content->linkedin->option))
								$default = $content->linkedin->option;
							else
								$default = '';
							echo form_dropdown('data[linkedin][option]', $option_in, $default, 'class="form-control input-sm"');
						?>
					</div>
					
					<div class="col-sm-2">
						<label><?php echo lang('share_admin_setting_publish_title');?></label><br/>
						<?php
							$publish = array(
								'yes'=>lang('yes'),
								'no'=>lang('no'),
							);
							if(isset($content->linkedin->publish))
								$default = $content->linkedin->publish;
							else
								$default = '';
							echo form_dropdown('data[linkedin][publish]', $publish, $default, 'class="form-control input-sm"');
						?>
					</div>
				</div>
			</div>
		</div>
		
		<!-- design options -->
		<?php 
			$params = json_decode($share->params, true);
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
</script>
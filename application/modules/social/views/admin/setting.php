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


<form name="setting" class="setting-save" method="POST" action="<?php echo site_url('social/admin/setting/save/'.$id); ?>">
<div class="tabpanel" role="tabpanel">

	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#tab-general" aria-controls="tab-general" role="tab" data-toggle="tab"><?php echo lang('general');?></a></li>
		<li role="presentation"><a href="#tab-design" aria-controls="tab-design" role="tab" data-toggle="tab"><?php echo lang('design_options'); ?></a></li>  
		<li class="button-back pull-right"><a href="javascript:void(0)" onclick="grid.module.setting('social')" title="Back to list"><i class="clip-arrow-left-2"></i></a></li>    
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="tab-general">	
			<div class="form-group">
				<label><?php echo lang('title');?><span class="symbol required"></span></label>
				<input type="text" class="form-control input-sm validate required" name="title" placeholder="<?php echo lang('title');?>" value="<?php echo $social->title; ?>" data-minlength="2" data-maxlength="200" data-msg="<?php echo lang('social_admin_setting_title_validate');?>"> 
			</div>
			<span class="help-block"><i class="fa fa-question-circle"></i> <?php echo lang('social_admin_setting_add_icon_help');?></span>
			<div class="form-group">
				<?php
					$content = json_decode($social->content);
				?>
				<div class="row">
					<div class="col-sm-3">
						<label><?php echo lang('social_admin_setting_facebook_title');?></label><br/>
						<a class="btn btn-sm btn-primary tooltips" href="javascript: void(0);?>" onclick="jQuery.fancybox( {href : '<?php echo site_url(); ?>admin/media/modals/facebookIcon/1', type: 'iframe'} );" title="<?php echo lang('social_admin_setting_add_icon_title');?>"><i class="fa fa-plus"></i></a> 
						<div id="fa_icon" style="float: right;">
							<?php
								if(isset($content->facebook->icon) && $content->facebook->icon != '')
								{
									echo '<img src="'.base_url($content->facebook->icon).'" style="width: 32px; height: 32px;" />';
									$facebook_icon = $content->facebook->icon;
								}else
								{
									$facebook_icon = '';
								}
							?>
						</div>
						<input type="hidden" id="fa_icon_input" name="data[facebook][icon]" value="<?php echo $facebook_icon; ?>"> 
					</div>
					<div class="col-sm-6">
						<label><?php echo lang('social_admin_setting_facebook_link_title');?></label>
						<input type="text" class="form-control input-sm" name="data[facebook][link]" placeholder="<?php echo lang('social_admin_setting_facebook_link_title');?>" value="<?php if(isset($content->facebook->link)) echo $content->facebook->link; else echo 'http://';?>"> 
					</div>
					
					<div class="col-sm-3">
						<label><?php echo lang('social_admin_setting_publish_title');?></label><br/>
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
					<div class="col-sm-3">
						<label><?php echo lang('social_admin_setting_twitter_title');?></label><br/>
						<a class="btn btn-sm btn-primary tooltips" href="javascript: void(0);?>" onclick="jQuery.fancybox( {href : '<?php echo site_url(); ?>admin/media/modals/twitterIcon/1', type: 'iframe'} );" title="<?php echo lang('social_admin_setting_add_icon_title');?>"><i class="fa fa-plus"></i></a> 
						<div id="tw_icon" style="float: right;">
							<?php
								if(isset($content->twitter->icon) && $content->twitter->icon != '')
								{
									echo '<img src="'.base_url($content->twitter->icon).'" style="width: 32px; height: 32px;" />';
									$twitter_icon = $content->twitter->icon;
								}else
								{
									$twitter_icon = '';
								}
							?>
						</div>
						<input type="hidden" id="tw_icon_input" name="data[twitter][icon]" value="<?php echo $twitter_icon; ?>"> 
					</div>
					<div class="col-sm-6">
						<label><?php echo lang('social_admin_setting_twitter_link_title');?></label>
						<input type="text" class="form-control input-sm" name="data[twitter][link]" placeholder="<?php echo lang('social_admin_setting_twitter_link_title');?>" value="<?php if(isset($content->twitter->link)) echo $content->twitter->link; else echo 'http://';?>"> 
					</div>
					
					<div class="col-sm-3">
						<label><?php echo lang('social_admin_setting_publish_title');?></label>
						<?php
							if(isset($content->twitter->publish))
								$default = $content->twitter->publish;
							else
								$default = '';
							echo form_dropdown('data[twitter][publish]', $publish, $default, 'class="form-control input-sm"');
						?>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="row">
					<div class="col-sm-3">
						<label><?php echo lang('social_admin_setting_google_title');?></label><br/>
						<a class="btn btn-sm btn-primary tooltips" href="javascript: void(0);?>" onclick="jQuery.fancybox( {href : '<?php echo site_url(); ?>admin/media/modals/googleIcon/1', type: 'iframe'} );" title="<?php echo lang('social_admin_setting_add_icon_title');?>"><i class="fa fa-plus"></i></a> 
						<div id="gg_icon" style="float: right;">
							<?php
								if(isset($content->google->icon) && $content->google->icon != '')
								{
									echo '<img src="'.base_url($content->google->icon).'" style="width: 32px; height: 32px;" />';
									$google_icon = $content->google->icon;
								}else
								{
									$google_icon = '';
								}
							?>
						</div>
						<input type="hidden" id="gg_icon_input" name="data[google][icon]" value="<?php echo $google_icon; ?>"> 
					</div>
					<div class="col-sm-6">
						<label><?php echo lang('social_admin_setting_google_link_title');?></label>
						<input type="text" class="form-control input-sm" name="data[google][link]" placeholder="<?php echo lang('social_admin_setting_google_link_title');?>" value="<?php if(isset($content->google->link)) echo $content->google->link; else echo 'http://';?>"> 
					</div>
					
					<div class="col-sm-3">
						<label><?php echo lang('social_admin_setting_publish_title');?></label>
						<?php
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
					<div class="col-sm-3">
						<label><?php echo lang('social_admin_setting_instagram_title');?></label><br/>
						<a class="btn btn-sm btn-primary tooltips" href="javascript: void(0);?>" onclick="jQuery.fancybox( {href : '<?php echo site_url(); ?>admin/media/modals/instagramIcon/1', type: 'iframe'} );" title="<?php echo lang('social_admin_setting_add_icon_title');?>"><i class="fa fa-plus"></i></a> 
						<div id="in_icon" style="float: right;">
							<?php
								if(isset($content->instagram->icon) && $content->instagram->icon != '')
								{
									echo '<img src="'.base_url($content->instagram->icon).'" style="width: 32px; height: 32px;" />';
									$instagram_icon = $content->instagram->icon;
								}else
								{
									$instagram_icon = '';
								}
							?>
						</div>
						<input type="hidden" id="in_icon_input" name="data[instagram][icon]" value="<?php echo $instagram_icon; ?>"> 
					</div>
					<div class="col-sm-6">
						<label><?php echo lang('social_admin_setting_instagram_link_title');?></label>
						<input type="text" class="form-control input-sm" name="data[instagram][link]" placeholder="<?php echo lang('social_admin_setting_instagram_link_title');?>" value="<?php if(isset($content->instagram->link)) echo $content->instagram->link; else echo 'http://';?>"> 
					</div>
					
					<div class="col-sm-3">
						<label><?php echo lang('social_admin_setting_publish_title');?></label>
						<?php
							if(isset($content->instagram->publish))
								$default = $content->instagram->publish;
							else
								$default = '';
							echo form_dropdown('data[instagram][publish]', $publish, $default, 'class="form-control input-sm"');
						?>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="row">
					<div class="col-sm-3">
						<label><?php echo lang('social_admin_setting_pinterest_title');?></label><br/>
						<a class="btn btn-sm btn-primary tooltips" href="javascript: void(0);?>" onclick="jQuery.fancybox( {href : '<?php echo site_url(); ?>admin/media/modals/pinterestIcon/1', type: 'iframe'} );" title="<?php echo lang('social_admin_setting_add_icon_title');?>"><i class="fa fa-plus"></i></a> 
						<div id="pi_icon" style="float: right;">
							<?php
								if(isset($content->pinterest->icon) && $content->pinterest->icon != '')
								{
									echo '<img src="'.base_url($content->pinterest->icon).'" style="width: 32px; height: 32px;" />';
									$pinterest_icon = $content->pinterest->icon;
								}else
								{
									$pinterest_icon = '';
								}
							?>
						</div>
						<input type="hidden" id="pi_icon_input" name="data[pinterest][icon]" value="<?php echo $pinterest_icon; ?>"> 
					</div>
					<div class="col-sm-6">
						<label><?php echo lang('social_admin_setting_pinterest_link_title');?></label>
						<input type="text" class="form-control input-sm" name="data[pinterest][link]" placeholder="<?php echo lang('social_admin_setting_pinterest_link_title');?>" value="<?php if(isset($content->pinterest->link)) echo $content->pinterest->link; else echo 'http://';?>"> 
					</div>
					
					<div class="col-sm-3">
						<label><?php echo lang('social_admin_setting_publish_title');?></label>
						<?php
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
					<div class="col-sm-3">
						<label><?php echo lang('social_admin_setting_linkedin_title');?></label><br/>
						<a class="btn btn-sm btn-primary tooltips" href="javascript: void(0);?>" onclick="jQuery.fancybox( {href : '<?php echo site_url(); ?>admin/media/modals/linkedinIcon/1', type: 'iframe'} );" title="<?php echo lang('social_admin_setting_add_icon_title');?>"><i class="fa fa-plus"></i></a> 
						<div id="li_icon" style="float: right;">
							<?php
								if(isset($content->linkedin->icon) && $content->linkedin->icon != '')
								{
									echo '<img src="'.base_url($content->linkedin->icon).'" style="width: 32px; height: 32px;" />';
									$linkedin_icon = $content->linkedin->icon;
								}else
								{
									$linkedin_icon = '';
								}
							?>
						</div>
						<input type="hidden" id="li_icon_input" name="data[linkedin][icon]" value="<?php echo $linkedin_icon; ?>"> 
					</div>
					<div class="col-sm-6">
						<label><?php echo lang('social_admin_setting_linkedin_link_title');?></label>
						<input type="text" class="form-control input-sm" name="data[linkedin][link]" placeholder="<?php echo lang('social_admin_setting_linkedin_link_title');?>" value="<?php if(isset($content->linkedin->link)) echo $content->linkedin->link; else echo 'http://';?>"> 
					</div>
					
					<div class="col-sm-3">
						<label><?php echo lang('social_admin_setting_publish_title');?></label>
						<?php
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
			$params = json_decode($social->params, true);
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
jQuery('.tooltips').tooltip();
function facebookIcon(images)
{
	if(images.length > 0)
	{
		var e = jQuery('#fa_icon');			
		if(e.children('img').length > 0)
			e.children('img').attr('src', images[0]);
		else
			e.append('<img src="'+images[0]+'" style="width: 32px; height: 32px;" />');
		var str = images[0];
		str = str.replace("<?php echo base_url();?>", "");
		jQuery('#fa_icon_input').val(str);
		jQuery.fancybox.close();
	}
}
function twitterIcon(images)
{
	if(images.length > 0)
	{
		var e = jQuery('#tw_icon');			
		if(e.children('img').length > 0)
			e.children('img').attr('src', images[0]);
		else
			e.append('<img src="'+images[0]+'" style="width: 32px; height: 32px;" />');
		var str = images[0];
		str = str.replace("<?php echo base_url();?>", "");
		jQuery('#tw_icon_input').val(str);
		jQuery.fancybox.close();
	}
}
function googleIcon(images)
{
	if(images.length > 0)
	{
		var e = jQuery('#gg_icon');			
		if(e.children('img').length > 0)
			e.children('img').attr('src', images[0]);
		else
			e.append('<img src="'+images[0]+'" style="width: 32px; height: 32px;" />');
		var str = images[0];
		str = str.replace("<?php echo base_url();?>", "");
		jQuery('#gg_icon_input').val(str);
		jQuery.fancybox.close();
	}
}
function instagramIcon(images)
{
	if(images.length > 0)
	{
		var e = jQuery('#in_icon');			
		if(e.children('img').length > 0)
			e.children('img').attr('src', images[0]);
		else
			e.append('<img src="'+images[0]+'" style="width: 32px; height: 32px;" />');
		var str = images[0];
		str = str.replace("<?php echo base_url();?>", "");
		jQuery('#in_icon_input').val(str);
		jQuery.fancybox.close();
	}
}
function pinterestIcon(images)
{
	if(images.length > 0)
	{
		var e = jQuery('#pi_icon');			
		if(e.children('img').length > 0)
			e.children('img').attr('src', images[0]);
		else
			e.append('<img src="'+images[0]+'" style="width: 32px; height: 32px;" />');
		var str = images[0];
		str = str.replace("<?php echo base_url();?>", "");
		jQuery('#pi_icon_input').val(str);
		jQuery.fancybox.close();
	}
}
function linkedinIcon(images)
{
	if(images.length > 0)
	{
		var e = jQuery('#li_icon');			
		if(e.children('img').length > 0)
			e.children('img').attr('src', images[0]);
		else
			e.append('<img src="'+images[0]+'" style="width: 32px; height: 32px;" />');
		var str = images[0];
		str = str.replace("<?php echo base_url();?>", "");
		jQuery('#li_icon_input').val(str);
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
</script>
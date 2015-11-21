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
<script src="<?php echo base_url('assets/plugins/validate/validate.js'); ?>" type="text/javascript"></script>
<link href="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.css'); ?>" rel="stylesheet"/>
<style type="text/css">
	#add_glyphicons{
		list-style: none;
		padding: 0px;
	}
	
	#add_glyphicons li{
		border: 1px solid #ccc;
		float: left;
		margin: 5px;
		padding: 5px 10px;
		cursor: pointer;
	}
</style>
<script type="text/javascript">
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

<form name="setting" class="setting-save" method="POST" action="<?php echo site_url('tab/admin/setting/save/'.$id); ?>">
<div class="tabpanel" role="tabpanel">

	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#tab-general" aria-controls="tab-general" role="tab" data-toggle="tab"><?php echo lang('general');?></a></li>
		<li role="presentation"><a href="#tab-design" aria-controls="tab-design" role="tab" data-toggle="tab"><?php echo lang('design_options'); ?></a></li>  
		<li class="button-back pull-right"><a href="javascript:void(0)" onclick="grid.module.setting('tab')" title="Back to list"><i class="clip-arrow-left-2"></i></a></li>    
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="tab-general">	
			<div class="form-group">
				<label><?php echo lang('title');?><span class="symbol required"></span></label>
				<input type="text" class="form-control input-sm validate required" name="title" placeholder="<?php echo lang('title');?>" value="<?php echo $tab->title; ?>" data-minlength="2" data-maxlength="200" data-msg="<?php echo lang('tab_admin_setting_title_validate');?>"> 
			</div>
			<?php
				$options = json_decode($tab->options);
			?>
			<div class="form-group">
				<label><?php echo lang('tab_admin_setting_theme_title');?></label>
				<div class="row">
					<div class="col-sm-4">
						<span class="glyphicon glyphicon-ok tab_theme" style="font-size: 20px; color: green; border: 2px solid green; padding: 5px; position: absolute; left: 15px; display: <?php if(isset($options->tab_type) && $options->tab_type == 'top') echo 'block'; else if(!isset($options->tab_type) || $options->tab_type == '') echo 'block'; else echo 'none';?>;"></span>
						<input type="radio" name="layout[tab_type]" value="top" id="tab_top" style="display: none" <?php if(isset($options->tab_type) && $options->tab_type == 'top') echo 'checked=""'; else if(!isset($options->tab_type) || $options->tab_type == '') echo 'checked=""';?>/>
						<label for="tab_top" onclick="tabTheme(this);"><img src="<?php echo base_url('media/modules/tab/images/tab_1.png');?>" style="width: 100%; cursor: pointer; border: 1px solid #ccc;" /></label>
					</div>
					
					<div class="col-sm-4">
						<span class="glyphicon glyphicon-ok tab_theme" style="font-size: 20px; color: green; border: 2px solid green; padding: 5px; position: absolute; left: 15px; display: <?php if(isset($options->tab_type) && $options->tab_type == 'left') echo 'block'; else echo 'none'; ?>;"></span>
						<input type="radio" name="layout[tab_type]" value="left" id="tab_left" style="display: none" <?php if(isset($options->tab_type) && $options->tab_type == 'left') echo 'checked=""'; ?>/>
						<label for="tab_left" onclick="tabTheme(this);"><img src="<?php echo site_url('media/modules/tab/images/tab_2.png');?>" style="width: 100%; cursor: pointer; border: 1px solid #ccc;" /></label>
					</div>
					
					<div class="col-sm-4">
						<span class="glyphicon glyphicon-ok tab_theme" style="font-size: 20px; color: green; border: 2px solid green; padding: 5px; position: absolute; left: 15px; display: <?php if(isset($options->tab_type) && $options->tab_type == 'accordions') echo 'block'; else echo 'none'; ?>;"></span>
						<input type="radio" name="layout[tab_type]" value="accordions" id="tab_accordions" style="display: none" <?php if(isset($options->tab_type) && $options->tab_type == 'accordions') echo 'checked=""'; ?>/>
						<label for="tab_accordions" onclick="tabTheme(this);"><img src="<?php echo site_url('media/modules/tab/images/tab_3.png');?>" style="width: 100%; cursor: pointer; border: 1px solid #ccc;" /></label>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="row">
					<div class="col-sm-4">
						<label>Color</label>
						<select class="form-control input-sm" name="layout[color]">
							<option style="color: #364f6a" value="tab-blue" <?php if(isset($options->color) && $options->color == 'tab-blue') echo 'selected=""';?>><?php echo lang('tab_admin_setting_color_blue_title');?></option>
							<option style="color: #c83a2a" value="tab-bricky" <?php if(isset($options->color) && $options->color == 'tab-bricky') echo 'selected=""';?>><?php echo lang('tab_admin_setting_color_bricky_title');?></option>
							<option style="color: #3d9400" value="tab-green" <?php if(isset($options->color) && $options->color == 'tab-green') echo 'selected=""';?>><?php echo lang('tab_admin_setting_color_green_title');?></option>
							<option style="color: #ffb848" value="tab-yellow" <?php if(isset($options->color) && $options->color == 'tab-yellow') echo 'selected=""';?>><?php echo lang('tab_admin_setting_color_yellow_title');?></option>
						</select>
					</div>
					<div class="col-sm-8">
						<label><?php echo lang('tab_admin_setting_name_title');?></label>
						<div class="row">
							<div class="col-sm-8">
								<input type="text" class="form-control input-sm" id="tab_name" placeholder="<?php echo lang('tab_admin_setting_name_title');?>" > 
							</div>
							<div class="col-sm-4">
								<button class="btn btn-primary btn-sm" type="button" onclick="addTab();"><i class="fa fa-plus"></i> <?php echo lang('tab_admin_setting_add_title');?></button>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist" id="tab_list">
				<?php 
					$content = json_decode($tab->content, true);
					if(isset($content['name']) && is_array($content['name']))
					{
						$i=0;
						foreach($content['name'] as $key=>$val)
						{
							if($i == 0)
								$active = 'class="active"';
							else
								$active = '';
							if(!isset($content['icon'][$i]))
								$content['icon'][$i] = '';
							echo '<li role="presentation" '.$active.'><a rel="'.$key.'" href="#tab-tab-'.$key.'" aria-controls="tab-tab-'.$key.'" role="tab" data-toggle="tab"><span id="tab-icon-'.$key.'" class="'.$content['icon'][$i].'"></span> '.$val.' <i class="glyphicon glyphicon-remove" style="color: #d9534f; cursor: pointer;" onclick="removeTab(this)"></i></a></li>';
							$i++;
						}
					}
				?>
			</ul>
			
			<!-- Tab panes -->
			<div class="tab-content" id="tab_content">
				<?php
					if(isset($content['content']) && is_array($content['content']))
					{
						$i=0;
						$html = '';
						foreach($content['content'] as $key=>$val)
						{
							if($i == 0)
								$active = 'active';
							else
								$active = '';
							if(!isset($content['name'][$i]))
								$content['name'][$i] = '';
							if(!isset($content['icon'][$i]))
								$content['icon'][$i] = '';
								
							$html .= '<div role="tabpanel" class="tab-pane '.$active.'" id="tab-tab-'.$key.'">';
							$html .= '<div class="form-group">';
							$html .= '<div class="row">';
							$html .= '<div class="col-sm-6">';
							$html .= '<label>'.lang('tab_admin_setting_add_icon_title').'</label><br/>';
							$html .= '<button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#modal-icon"><i class="fa fa-plus"></i></button>';
							$html .= '<input id="input-icon-'.$key.'" name="data[icon][]" type="hidden" value="'.$content['icon'][$i].'"></span>';
							$html .= '<span id="icon-tab-'.$key.'" style="margin-left: 15px;" class="'.$content['icon'][$i].'"></span>';
							$html .= '<i class="glyphicon glyphicon-remove pull-right" style="margin-right: 100px; margin-top: 5px; color: #d9534f; cursor: pointer;" onclick="removeIcon(this)"></i>';
							$html .= '</div>';
							$html .= '<div class="col-sm-6">';
							$html .= '<label>'.lang('tab_admin_setting_name_title').'</label>';
							$html .= '<input type="text" class="form-control input-sm" name="data[name][]" value="'.$content['name'][$i].'">';
							$html .= '</div>';
							$html .= '</div>';
							$html .= '</div>';
							$html .= '<div class="form-group">';
							$html .= '<label>'.lang('content').'</label>';
							$html .= '<textarea class="text-edittor text-edittor-'.$key.'" name="data[content][]" rows="7" >'.$val.'</textarea>';
							$html .= '</div>';
							$html .= '</div>';
							$i++;
						}
						echo $html;
					}
				?>
			</div>
		</div>
		
		<!-- design options -->
		<?php 
			$params = json_decode($tab->params, true);
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
								<a href="javascript:void(0)" class="gird-box-bg-remove" onclick="gridRemoveImg(this)"><span class="glyphicon glyphicon-remove"></span></a>
							</div>
							<input type="hidden" name="params[background][image]" id="gird-box-bg-img" value="<?php echo $image; ?>">
							<a class="gird-box-image" href="javascript:void(0)" onclick="jQuery.fancybox( {href : '<?php echo site_url().'admin/media/modals/productImg/1'; ?>', type: 'iframe'} );"><span class="glyphicon glyphicon-plus"></span></a>
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

<div class="modal fade" id="modal-icon" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content" style="display: table;">
			<ul id="add_glyphicons">
				<li class="tooltips" title="asterisk">
				  <span class="glyphicon glyphicon-asterisk"></span>
				</li>
			  
				<li class="tooltips" title="plus">
				  <span class="glyphicon glyphicon-plus"></span>
				</li>
			  
				<li class="tooltips" title="euro">
				  <span class="glyphicon glyphicon-euro"></span>
				</li>
			  
				<li class="tooltips" title="minus">
				  <span class="glyphicon glyphicon-minus"></span>
				</li>
			  
				<li class="tooltips" title="cloud">
				  <span class="glyphicon glyphicon-cloud"></span>
				</li>
			  
				<li class="tooltips" title="envelope">
				  <span class="glyphicon glyphicon-envelope"></span>
				</li>
			  
				<li class="tooltips" title="pencil">
				  <span class="glyphicon glyphicon-pencil"></span>
				</li>
			  
				<li class="tooltips" title="glass">
				  <span class="glyphicon glyphicon-glass"></span>
				</li>
			  
				<li class="tooltips" title="music">
				  <span class="glyphicon glyphicon-music"></span>
				</li>
			  
				<li class="tooltips" title="search">
				  <span class="glyphicon glyphicon-search"></span>
				</li>
			  
				<li class="tooltips" title="heart">
				  <span class="glyphicon glyphicon-heart"></span>
				  </li>
			  
				<li class="tooltips" title="star">
				  <span class="glyphicon glyphicon-star"></span>
				  </li>
			  
				<li class="tooltips" title="star-empty">
				  <span class="glyphicon glyphicon-star-empty"></span>
				  </li>
			  
				<li class="tooltips" title="user">
				  <span class="glyphicon glyphicon-user"></span>
				  </li>
			  
				<li class="tooltips" title="film">
				  <span class="glyphicon glyphicon-film"></span>
				  </li>
			  
				<li class="tooltips" title="th-large">
				  <span class="glyphicon glyphicon-th-large"></span>
				  </li>
			  
				<li class="tooltips" title="th">
				  <span class="glyphicon glyphicon-th"></span>
				  </li>
			  
				<li class="tooltips" title="th-list">
				  <span class="glyphicon glyphicon-th-list"></span>
				  </li>
			  
				<li class="tooltips" title="ok">
				  <span class="glyphicon glyphicon-ok"></span>
				  </li>
			  
				<li class="tooltips" title="remove">
				  <span class="glyphicon glyphicon-remove"></span>
				  </li>
			  
				<li class="tooltips" title="zoom-in">
				  <span class="glyphicon glyphicon-zoom-in"></span>
				  </li>
			  
				<li class="tooltips" title="zoom-out">
				  <span class="glyphicon glyphicon-zoom-out"></span>
				  </li>
			  
				<li class="tooltips" title="off">
				  <span class="glyphicon glyphicon-off"></span>
				  </li>
			  
				<li class="tooltips" title="signal">
				  <span class="glyphicon glyphicon-signal"></span>
				  </li>
			  
				<li class="tooltips" title="cog">
				  <span class="glyphicon glyphicon-cog"></span>
				  </li>
			  
				<li class="tooltips" title="trash">
				  <span class="glyphicon glyphicon-trash"></span>
				  </li>
			  
				<li class="tooltips" title="home">
				  <span class="glyphicon glyphicon-home"></span>
				  </li>
			  
				<li class="tooltips" title="file">
				  <span class="glyphicon glyphicon-file"></span>
				  </li>
			  
				<li class="tooltips" title="time">
				  <span class="glyphicon glyphicon-time"></span>
				  </li>
			  
				<li class="tooltips" title="road">
				  <span class="glyphicon glyphicon-road"></span>
				  </li>
			  
				<li class="tooltips" title="download-alt">
				  <span class="glyphicon glyphicon-download-alt"></span>
				  </li>
			  
				<li class="tooltips" title="download">
				  <span class="glyphicon glyphicon-download"></span>
				  </li>
			  
				<li class="tooltips" title="upload">
				  <span class="glyphicon glyphicon-upload"></span>
				  </li>
			  
				<li class="tooltips" title="inbox">
				  <span class="glyphicon glyphicon-inbox"></span>
				  </li>
			  
				<li class="tooltips" title="play-circle">
				  <span class="glyphicon glyphicon-play-circle"></span>
				  </li>
			  
				<li class="tooltips" title="repeat">
				  <span class="glyphicon glyphicon-repeat"></span>
				  </li>
			  
				<li class="tooltips" title="refresh">
				  <span class="glyphicon glyphicon-refresh"></span>
				  </li>
			  
				<li class="tooltips" title=" list-alt">
				  <span class="glyphicon glyphicon-list-alt"></span>
				 </li>
			  
				<li class="tooltips" title="lock">
				  <span class="glyphicon glyphicon-lock"></span>
				  </li>
			  
				<li class="tooltips" title="flag">
				  <span class="glyphicon glyphicon-flag"></span>
				  </li>
			  
				<li class="tooltips" title="headphones">
				  <span class="glyphicon glyphicon-headphones"></span>
				  </li>
			  
				<li class="tooltips" title="volume-off">
				  <span class="glyphicon glyphicon-volume-off"></span>
				  </li>
			  
				<li class="tooltips" title="volume-down">
				  <span class="glyphicon glyphicon-volume-down"></span>
				  </li>
			  
				<li class="tooltips" title="volume-up">
				  <span class="glyphicon glyphicon-volume-up"></span>
				  </li>
			  
				<li class="tooltips" title="qrcode">
				  <span class="glyphicon glyphicon-qrcode"></span>
				  </li>
			  
				<li class="tooltips" title="barcode">
				  <span class="glyphicon glyphicon-barcode"></span>
				  </li>
			  
				<li class="tooltips" title="tag">
				  <span class="glyphicon glyphicon-tag"></span>
				  </li>
			  
				<li class="tooltips" title="tags">
				  <span class="glyphicon glyphicon-tags"></span>
				  </li>
			  
				<li class="tooltips" title="book">
				  <span class="glyphicon glyphicon-book"></span>
				  </li>
			  
				<li class="tooltips" title="bookmark">
				  <span class="glyphicon glyphicon-bookmark"></span>
				  </li>
			  
				<li class="tooltips" title="print">
				  <span class="glyphicon glyphicon-print"></span>
				  </li>
			  
				<li class="tooltips" title="camera">
				  <span class="glyphicon glyphicon-camera"></span>
				  </li>
			  
				<li class="tooltips" title="font">
				  <span class="glyphicon glyphicon-font"></span>
				  </li>
			  
				<li class="tooltips" title="bold">
				  <span class="glyphicon glyphicon-bold"></span>
				  </li>
			  
				<li class="tooltips" title="italic">
				  <span class="glyphicon glyphicon-italic"></span>
				  </li>
			  
				<li class="tooltips" title="text-height">
				  <span class="glyphicon glyphicon-text-height"></span>
				  </li>
			  
				<li class="tooltips" title="text-width">
				  <span class="glyphicon glyphicon-text-width"></span>
				  </li>
			  
				<li class="tooltips" title="align-left">
				  <span class="glyphicon glyphicon-align-left"></span>
				  </li>
			  
				<li class="tooltips" title="align-center">
				  <span class="glyphicon glyphicon-align-center"></span>
				  </li>
			  
				<li class="tooltips" title="align-right">
				  <span class="glyphicon glyphicon-align-right"></span>
				  </li>
			  
				<li class="tooltips" title="align-justify">
				  <span class="glyphicon glyphicon-align-justify"></span>
				  </li>
			  
				<li class="tooltips" title="list">
				  <span class="glyphicon glyphicon-list"></span>
				  </li>
			  
				<li class="tooltips" title="indent-left">
				  <span class="glyphicon glyphicon-indent-left"></span>
				  </li>
			  
				<li class="tooltips" title="indent-right">
				  <span class="glyphicon glyphicon-indent-right"></span>
				  </li>
			  
				<li class="tooltips" title="facetime-video">
				  <span class="glyphicon glyphicon-facetime-video"></span>
				  </li>
			  
				<li class="tooltips" title="picture">
				  <span class="glyphicon glyphicon-picture"></span>
				  </li>
			  
				<li class="tooltips" title="map-marker">
				  <span class="glyphicon glyphicon-map-marker"></span>
				  </li>
			  
				<li class="tooltips" title="adjust">
				  <span class="glyphicon glyphicon-adjust"></span>
				  </li>
			  
				<li class="tooltips" title="tint">
				  <span class="glyphicon glyphicon-tint"></span>
				  </li>
			  
				<li class="tooltips" title="edit">
				  <span class="glyphicon glyphicon-edit"></span>
				  </li>
			  
				<li class="tooltips" title="share">
				  <span class="glyphicon glyphicon-share"></span>
				  </li>
			  
				<li class="tooltips" title="check">
				  <span class="glyphicon glyphicon-check"></span>
				  </li>
			  
				<li class="tooltips" title="move">
				  <span class="glyphicon glyphicon-move"></span>
				  </li>
			  
				<li class="tooltips" title="step-backward">
				  <span class="glyphicon glyphicon-step-backward"></span>
				  </li>
			  
				<li class="tooltips" title="fast-backward">
				  <span class="glyphicon glyphicon-fast-backward"></span>
				  </li>
			  
				<li class="tooltips" title="backward">
				  <span class="glyphicon glyphicon-backward"></span>
				  </li>
			  
				<li class="tooltips" title="play">
				  <span class="glyphicon glyphicon-play"></span>
				  </li>
			  
				<li class="tooltips" title="pause">
				  <span class="glyphicon glyphicon-pause"></span>
				  </li>
			  
				<li class="tooltips" title="stop">
				  <span class="glyphicon glyphicon-stop"></span>
				  </li>
			  
				<li class="tooltips" title="forward">
				  <span class="glyphicon glyphicon-forward"></span>
				  </li>
			  
				<li class="tooltips" title="fast-forward">
				  <span class="glyphicon glyphicon-fast-forward"></span>
				  </li>
			  
				<li class="tooltips" title="step-forward">
				  <span class="glyphicon glyphicon-step-forward"></span>
				  </li>
			  
				<li class="tooltips" title="eject">
				  <span class="glyphicon glyphicon-eject"></span>
				  </li>
			  
				<li class="tooltips" title="chevron-left">
				  <span class="glyphicon glyphicon-chevron-left"></span>
				  </li>
			  
				<li class="tooltips" title="chevron-right">
				  <span class="glyphicon glyphicon-chevron-right"></span>
				  </li>
			  
				<li class="tooltips" title="plus-sign">
				  <span class="glyphicon glyphicon-plus-sign"></span>
				  </li>
			  
				<li class="tooltips" title="minus-sign">
				  <span class="glyphicon glyphicon-minus-sign"></span>
				  </li>
			  
				<li class="tooltips" title="remove-sign">
				  <span class="glyphicon glyphicon-remove-sign"></span>
				  </li>
			  
				<li class="tooltips" title="ok-sign">
				  <span class="glyphicon glyphicon-ok-sign"></span>
				  </li>
			  
				<li class="tooltips" title="question-sign">
				  <span class="glyphicon glyphicon-question-sign"></span>
				  </li>
			  
				<li class="tooltips" title="info-sign">
				  <span class="glyphicon glyphicon-info-sign"></span>
				  </li>
			  
				<li class="tooltips" title="screenshot">
				  <span class="glyphicon glyphicon-screenshot"></span>
				  </li>
			  
				<li class="tooltips" title="remove-circle">
				  <span class="glyphicon glyphicon-remove-circle"></span>
				  </li>
			  
				<li class="tooltips" title="ok-circle">
				  <span class="glyphicon glyphicon-ok-circle"></span>
				  </li>
			  
				<li class="tooltips" title="ban-circle">
				  <span class="glyphicon glyphicon-ban-circle"></span>
				  </li>
			  
				<li class="tooltips" title="arrow-left">
				  <span class="glyphicon glyphicon-arrow-left"></span>
				  </li>
			  
				<li class="tooltips" title="arrow-right">
				  <span class="glyphicon glyphicon-arrow-right"></span>
				  </li>
			  
				<li class="tooltips" title="arrow-up">
				  <span class="glyphicon glyphicon-arrow-up"></span>
				  </li>
			  
				<li class="tooltips" title="arrow-down">
				  <span class="glyphicon glyphicon-arrow-down"></span>
				  </li>
			  
				<li class="tooltips" title="share-alt">
				  <span class="glyphicon glyphicon-share-alt"></span>
				  </li>
			  
				<li class="tooltips" title="resize-full">
				  <span class="glyphicon glyphicon-resize-full"></span>
				  </li>
			  
				<li class="tooltips" title="resize-small">
				  <span class="glyphicon glyphicon-resize-small"></span>
				  </li>
			  
				<li class="tooltips" title="exclamation-sign">
				  <span class="glyphicon glyphicon-exclamation-sign"></span>
				  </li>
			  
				<li class="tooltips" title="gift">
				  <span class="glyphicon glyphicon-gift"></span>
				  </li>
			  
				<li class="tooltips" title="leaf">
				  <span class="glyphicon glyphicon-leaf"></span>
				  </li>
			  
				<li class="tooltips" title="fire">
				  <span class="glyphicon glyphicon-fire"></span>
				  </li>
			  
				<li class="tooltips" title="eye-open">
				  <span class="glyphicon glyphicon-eye-open"></span>
				  </li>
			  
				<li class="tooltips" title="eye-close">
				  <span class="glyphicon glyphicon-eye-close"></span>
				  </li>
			  
				<li class="tooltips" title="warning-sign">
				  <span class="glyphicon glyphicon-warning-sign"></span>
				  </li>
			  
				<li class="tooltips" title="plane">
				  <span class="glyphicon glyphicon-plane"></span>
				  </li>
			  
				<li class="tooltips" title="calendar">
				  <span class="glyphicon glyphicon-calendar"></span>
				  </li>
			  
				<li class="tooltips" title="random">
				  <span class="glyphicon glyphicon-random"></span>
				  </li>
			  
				<li class="tooltips" title="comment">
				  <span class="glyphicon glyphicon-comment"></span>
				  </li>
			  
				<li class="tooltips" title="magnet">
				  <span class="glyphicon glyphicon-magnet"></span>
				  </li>
			  
				<li class="tooltips" title="chevron-up">
				  <span class="glyphicon glyphicon-chevron-up"></span>
				  </li>
			  
				<li class="tooltips" title="chevron-down">
				  <span class="glyphicon glyphicon-chevron-down"></span>
				  </li>
			  
				<li class="tooltips" title="retweet">
				  <span class="glyphicon glyphicon-retweet"></span>
				  </li>
			  
				<li class="tooltips" title="shopping-cart">
				  <span class="glyphicon glyphicon-shopping-cart"></span>
				  </li>
			  
				<li class="tooltips" title="folder-close">
				  <span class="glyphicon glyphicon-folder-close"></span>
				  </li>
			  
				<li class="tooltips" title="folder-open">
				  <span class="glyphicon glyphicon-folder-open"></span>
				  </li>
			  
				<li class="tooltips" title="resize-vertical">
				  <span class="glyphicon glyphicon-resize-vertical"></span>
				  </li>
			  
				<li class="tooltips" title="resize-horizontal">
				  <span class="glyphicon glyphicon-resize-horizontal"></span>
				  </li>
			  
				<li class="tooltips" title="hdd">
				  <span class="glyphicon glyphicon-hdd"></span>
				  </li>
			  
				<li class="tooltips" title="bullhorn">
				  <span class="glyphicon glyphicon-bullhorn"></span>
				  </li>
			  
				<li class="tooltips" title="bell">
				  <span class="glyphicon glyphicon-bell"></span>
				  </li>
			  
				<li class="tooltips" title="certificate">
				  <span class="glyphicon glyphicon-certificate"></span>
				  </li>
			  
				<li class="tooltips" title="thumbs-up">
				  <span class="glyphicon glyphicon-thumbs-up"></span>
				  </li>
			  
				<li class="tooltips" title="thumbs-down">
				  <span class="glyphicon glyphicon-thumbs-down"></span>
				  </li>
			  
				<li class="tooltips" title="hand-right">
				  <span class="glyphicon glyphicon-hand-right"></span>
				  </li>
			  
				<li class="tooltips" title="hand-left">
				  <span class="glyphicon glyphicon-hand-left"></span>
				  </li>
			  
				<li class="tooltips" title="hand-up">
				  <span class="glyphicon glyphicon-hand-up"></span>
				  </li>
			  
				<li class="tooltips" title="hand-down">
				  <span class="glyphicon glyphicon-hand-down"></span>
				  </li>
			  
				<li class="tooltips" title="circle-arrow-right">
				  <span class="glyphicon glyphicon-circle-arrow-right"></span>
				  </li>
			  
				<li class="tooltips" title="circle-arrow-left">
				  <span class="glyphicon glyphicon-circle-arrow-left"></span>
				  </li>
			  
				<li class="tooltips" title="circle-arrow-up">
				  <span class="glyphicon glyphicon-circle-arrow-up"></span>
				  </li>
			  
				<li class="tooltips" title="circle-arrow-down">
				  <span class="glyphicon glyphicon-circle-arrow-down"></span>
				  </li>
			  
				<li class="tooltips" title="globe">
				  <span class="glyphicon glyphicon-globe"></span>
				  </li>
			  
				<li class="tooltips" title="wrench">
				  <span class="glyphicon glyphicon-wrench"></span>
				  </li>
			  
				<li class="tooltips" title="tasks">
				  <span class="glyphicon glyphicon-tasks"></span>
				  </li>
			  
				<li class="tooltips" title="filter">
				  <span class="glyphicon glyphicon-filter"></span>
				  </li>
			  
				<li class="tooltips" title="briefcase">
				  <span class="glyphicon glyphicon-briefcase"></span>
				  </li>
			  
				<li class="tooltips" title="fullscreen">
				  <span class="glyphicon glyphicon-fullscreen"></span>
				  </li>
			  
				<li class="tooltips" title="dashboard">
				  <span class="glyphicon glyphicon-dashboard"></span>
				  </li>
			  
				<li class="tooltips" title="paperclip">
				  <span class="glyphicon glyphicon-paperclip"></span>
				  </li>
			  
				<li class="tooltips" title="heart-empty">
				  <span class="glyphicon glyphicon-heart-empty"></span>
				  </li>
			  
				<li class="tooltips" title="link">
				  <span class="glyphicon glyphicon-link"></span>
				  </li>
			  
				<li class="tooltips" title="phone">
				  <span class="glyphicon glyphicon-phone"></span>
				  </li>
			  
				<li class="tooltips" title="pushpin">
				  <span class="glyphicon glyphicon-pushpin"></span>
				  </li>
			  
				<li class="tooltips" title="usd">
				  <span class="glyphicon glyphicon-usd"></span>
				  </li>
			  
				<li class="tooltips" title="gbp">
				  <span class="glyphicon glyphicon-gbp"></span>
				  </li>
			  
				<li class="tooltips" title="sort">
				  <span class="glyphicon glyphicon-sort"></span>
				  </li>
			  
				<li class="tooltips" title="sort-by-alphabet">
				  <span class="glyphicon glyphicon-sort-by-alphabet"></span>
				  </li>
			  
				<li class="tooltips" title="sort-by-alphabet-alt">
				  <span class="glyphicon glyphicon-sort-by-alphabet-alt"></span>
				 </li>
			  
				<li class="tooltips" title="sort-by-order">
				  <span class="glyphicon glyphicon-sort-by-order"></span>
				  </li>
			  
				<li class="tooltips" title="sort-by-order-alt">
				  <span class="glyphicon glyphicon-sort-by-order-alt"></span>
				  </li>
			  
				<li class="tooltips" title="sort-by-attributes">
				  <span class="glyphicon glyphicon-sort-by-attributes"></span>
				  </li>
			  
				<li class="tooltips" title="sort-by-attributes-alt">
				  <span class="glyphicon glyphicon-sort-by-attributes-alt"></span>
				  </li>
			  
				<li class="tooltips" title="unchecked">
				  <span class="glyphicon glyphicon-unchecked"></span>
				  </li>
			  
				<li class="tooltips" title="expand">
				  <span class="glyphicon glyphicon-expand"></span>
				  </li>
			  
				<li class="tooltips" title="collapse-down">
				  <span class="glyphicon glyphicon-collapse-down"></span>
				  </li>
			  
				<li class="tooltips" title="collapse-up">
				  <span class="glyphicon glyphicon-collapse-up"></span>
				  </li>
			  
				<li class="tooltips" title="log-in">
				  <span class="glyphicon glyphicon-log-in"></span>
				  </li>
			  
				<li class="tooltips" title="flash">
				  <span class="glyphicon glyphicon-flash"></span>
				  </li>
			  
				<li class="tooltips" title="log-out">
				  <span class="glyphicon glyphicon-log-out"></span>
				  </li>
			  
				<li class="tooltips" title="new-window">
				  <span class="glyphicon glyphicon-new-window"></span>
				  </li>
			  
				<li class="tooltips" title="record">
				  <span class="glyphicon glyphicon-record"></span>
				  </li>
			  
				<li class="tooltips" title="save">
				  <span class="glyphicon glyphicon-save"></span>
				  </li>
			  
				<li class="tooltips" title="open">
				  <span class="glyphicon glyphicon-open"></span>
				  </li>
			  
				<li class="tooltips" title="saved">
				  <span class="glyphicon glyphicon-saved"></span>
				  </li>
			  
				<li class="tooltips" title="import">
				  <span class="glyphicon glyphicon-import"></span>
				  </li>
			  
				<li class="tooltips" title="export">
				  <span class="glyphicon glyphicon-export"></span>
				  </li>
			  
				<li class="tooltips" title="send">
				  <span class="glyphicon glyphicon-send"></span>
				  </li>
			  
				<li class="tooltips" title="floppy-disk">
				  <span class="glyphicon glyphicon-floppy-disk"></span>
				  </li>
			  
				<li class="tooltips" title="floppy-saved">
				  <span class="glyphicon glyphicon-floppy-saved"></span>
				  </li>
			  
				<li class="tooltips" title="floppy-remove">
				  <span class="glyphicon glyphicon-floppy-remove"></span>
				  </li>
			  
				<li class="tooltips" title="floppy-save">
				  <span class="glyphicon glyphicon-floppy-save"></span>
				  </li>
			  
				<li class="tooltips" title="floppy-open">
				  <span class="glyphicon glyphicon-floppy-open"></span>
				  </li>
			  
				<li class="tooltips" title="credit-card">
				  <span class="glyphicon glyphicon-credit-card"></span>
				  </li>
			  
				<li class="tooltips" title="transfer">
				  <span class="glyphicon glyphicon-transfer"></span>
				  </li>
			  
				<li class="tooltips" title="cutlery">
				  <span class="glyphicon glyphicon-cutlery"></span>
				  </li>
			  
				<li class="tooltips" title="header">
				  <span class="glyphicon glyphicon-header"></span>
				  </li>
			  
				<li class="tooltips" title="compressed">
				  <span class="glyphicon glyphicon-compressed"></span>
				  </li>
			  
				<li class="tooltips" title="earphone">
				  <span class="glyphicon glyphicon-earphone"></span>
				  </li>
			  
				<li class="tooltips" title="phone-alt">
				  <span class="glyphicon glyphicon-phone-alt"></span>
				  </li>
			  
				<li class="tooltips" title="tower">
				  <span class="glyphicon glyphicon-tower"></span>
				  </li>
			  
				<li class="tooltips" title="stats">
				  <span class="glyphicon glyphicon-stats"></span>
				  </li>
			  
				<li class="tooltips" title="sd-video">
				  <span class="glyphicon glyphicon-sd-video"></span>
				  </li>
			  
				<li class="tooltips" title="hd-video">
				  <span class="glyphicon glyphicon-hd-video"></span>
				  </li>
			  
				<li class="tooltips" title="subtitles">
				  <span class="glyphicon glyphicon-subtitles"></span>
				  </li>
			  
				<li class="tooltips" title="sound-stereo">
				  <span class="glyphicon glyphicon-sound-stereo"></span>
				  </li>
			  
				<li class="tooltips" title="sound-dolby">
				  <span class="glyphicon glyphicon-sound-dolby"></span>
				  </li>
			  
				<li class="tooltips" title="sound-5-1">
				  <span class="glyphicon glyphicon-sound-5-1"></span>
				  </li>
			  
				<li class="tooltips" title="sound-6-1">
				  <span class="glyphicon glyphicon-sound-6-1"></span>
				  </li>
			  
				<li class="tooltips" title="sound-7-1">
				  <span class="glyphicon glyphicon-sound-7-1"></span>
				  </li>
			  
				<li class="tooltips" title="copyright-mark">
				  <span class="glyphicon glyphicon-copyright-mark"></span>
				  </li>
			  
				<li class="tooltips" title="registration-mark">
				  <span class="glyphicon glyphicon-registration-mark"></span>
				  </li>
			  
				<li class="tooltips" title="cloud-upload">
				  <span class="glyphicon glyphicon-cloud-download"></span>
				  </li>
			  
				<li class="tooltips" title="cloud-upload">
				  <span class="glyphicon glyphicon-cloud-upload"></span>
				  </li>
			  
				<li class="tooltips" title="tree-conifer">
				  <span class="glyphicon glyphicon-tree-conifer"></span>
				  </li>
			  
				<li class="tooltips" title="tree-deciduous">
				  <span class="glyphicon glyphicon-tree-deciduous"></span>
				  </li>
			  
			</ul>
		</div>
	</div>
</div>
			
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

function tabTheme(e)
{
	jQuery('.tab_theme').hide();
	jQuery(e).parent('div').children('span').show();
}

jQuery('#add_glyphicons').children('li').click(function(){
	var icon_class = jQuery(this).children('span').attr('class');
	var tab_id = jQuery('#tab_list').children('.active').children('a').attr('rel');
	jQuery('#input-icon-'+tab_id).val(icon_class);
	jQuery('#tab-icon-'+tab_id).attr('class', icon_class);
	jQuery('#icon-tab-'+tab_id).attr('class', icon_class);
	jQuery('#modal-icon').modal('hide');
});

jQuery('.tooltips').tooltip();
var tab_id = 0;
tab_id_1 = jQuery('#tab_list').children('li').last().children('a').attr('rel');
if(typeof(tab_id_1) !== 'undefined')
	tab_id = parseInt(tab_id_1)+1;
function addTab()
{
	var active = '';
	if(tab_id == 0)
		active = 'class="active"';
	var tab_name = jQuery('#tab_name').val();
	var tablist = '<li role="presentation" '+active+'><a rel="'+tab_id+'" href="#tab-tab-'+tab_id+'" aria-controls="tab-tab-'+tab_id+'" role="tab" data-toggle="tab"><span id="tab-icon-'+tab_id+'"></span> '+tab_name+' <i class="glyphicon glyphicon-remove" style="color: #d9534f; cursor: pointer;" onclick="removeTab(this)"></i></a></li>';
	jQuery('#tab_list').append(tablist);
	
	var html = '<div role="tabpanel" class="tab-pane active" id="tab-tab-'+tab_id+'">';
		html += '<div class="form-group">';
		html += '<div class="row">';
		html += '<div class="col-sm-6">';
		html += '<label><?php echo lang('tab_admin_setting_add_icon_title');?></label><br/>';
		html += '<button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#modal-icon"><i class="fa fa-plus"></i></button>';
		html += '<input id="input-icon-'+tab_id+'" name="data[icon][]" type="hidden" value=""></span>';
		html += '<span id="icon-tab-'+tab_id+'" style="margin-left: 15px;"></span>';
		html += '<i class="glyphicon glyphicon-remove pull-right" style="margin-right: 100px; margin-top: 5px; color: #d9534f; cursor: pointer;" onclick="removeIcon(this)"></i>';
		html += '</div>';
		html += '<div class="col-sm-6">';
		html += '<label><?php echo lang('tab_admin_setting_name_title');?></label>';
		html += '<input type="text" class="form-control input-sm" name="data[name][]" value="'+tab_name+'">';
		html += '</div>';
		html += '</div>';
		html += '</div>';
		html += '<div class="form-group">';
		html += '<label><?php echo lang('content');?></label>';
		html += '<textarea class="text-edittor text-edittor-'+tab_id+'" name="data[content][]" rows="7" ></textarea>';
		html += '</div>';
		html += '</div>';
		
	jQuery('#tab_content').append(html);
	jQuery('#tab_name').val('');
	
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
		selector: ".text-edittor-"+tab_id,
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

	tab_id++;
}

function removeTab(e)
{
	var tab_id = jQuery(e).parent('a').attr('rel');
	jQuery(e).parent('a').parent('li').remove();
	jQuery('#tab-tab-'+tab_id).remove();
}

function removeIcon(e)
{
	jQuery(e).parent('div').children('input').val('');
	jQuery(e).parent('div').children('span').removeClass();
}
</script>
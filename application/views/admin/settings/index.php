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
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/chosen/chosen.jquery.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.jeditable.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/chosen/chosen.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.css'); ?>">

<?php if ($this->session->flashdata('msg') != '') { ?> 
	<div class="alert alert-success">
		<button class="close" data-dismiss="alert"> × </button>
		<i class="fa fa-check-circle"></i>
		<?php echo $this->session->flashdata('msg'); ?>
	</div>
<?php } ?>

<?php if ($this->session->flashdata('error') != '') { ?> 
	<div class="alert alert-danger">
		<button class="close" data-dismiss="alert"> × </button>
		<i class="fa fa-times-circle"></i>
		<?php echo $this->session->flashdata('error'); ?>
	</div>
<?php } ?>

<form method="post" action="<?php echo site_url(); ?>admin/settings/config">
<ul class="nav nav-tabs">
  <li class="active"><a href="#home" data-toggle="tab"><?php echo lang('setting_tab_your_shop'); ?></a></li>
  <!-- <li><a href="#designer" data-toggle="tab"><?php echo lang('setting_tab_designer'); ?></a></li> -->
  <li><a href="#price" data-toggle="tab"><?php echo lang('setting_tab_your_price'); ?></a></li>
  <li><a href="#shop" data-toggle="tab"><?php echo lang('setting_tab_config'); ?></a></li>
  <li><a href="#language" data-toggle="tab"><?php echo lang('setting_tab_setting_lang'); ?></a></li>
  <li class="pull-right"><button type="submit" class="btn btn-primary"><?php echo lang('save'); ?></button></li>
</ul>

<!-- Tab panes --> 
<div class="tab-content">
	<!-- begin shop info -->
	<div class="tab-pane active" id="home">
		<div class="row">
			<div class="col-md-8">
				
				<div class="form-group row">
					<label class="col-sm-3 control-label"><?php echo lang('setting_shop_site_name'); ?></label>
					<div class="col-sm-6">
						<input type="text" class="form-control input-sm" value="<?php echo $setting->site_name; ?>" name="setting[site_name]">
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-sm-3 control-label">
						<?php echo lang('setting_shop_site_description'); ?>
						<span class="dgtooltip fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="<?php echo lang('setting_shop_site_description_des'); ?>"></span>
					</label>
					<div class="col-sm-8">
						<textarea rows="3" cols="60" class="form-control" name="setting[meta_description]"><?php echo $setting->meta_description; ?></textarea>
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-sm-3 control-label">
						<?php echo lang('setting_shop_site_keywords'); ?>
						<span class="dgtooltip fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="<?php echo lang('setting_shop_site_keywords_des'); ?>"></span>
					</label>
					<div class="col-sm-8">
						<textarea rows="3" cols="60" class="form-control" name="setting[meta_keywords]"><?php echo $setting->meta_keywords; ?></textarea>
					</div>
				</div>
			</div>
			
			<div class="col-md-4" style="display:none;">
				<?php echo lang('setting_shop_your_key_title'); ?> <code><?php if(isset($key->key)) echo $key->key;?></code>
			</div>
		</div>
	</div>
	<!-- end shop info -->
	
	<!-- start price -->
	<div style=" min-height: 350px;" class="tab-pane" id="price">
		<div class="row">
			<div class="col-md-8">
				<div class="form-group row">
					<label class="col-sm-3 control-label"><?php echo lang('setting_shop_choose_currencies'); ?></label>
					<div class="col-sm-4">
						<select name="setting[currency_id]" onchange="dgUI.currency.change(this)" class="form-control chosen-select" data-placeholder="Choose a Currencies">
							<option value="0"> - <?php echo lang('setting_shop_please_choose_currency_option'); ?> - </option>
						<?php
						if (!isset($setting->currency_id)) $setting->currency_id = 0;
						foreach($currencies as $currencie){
							if ($currencie->currency_id == $setting->currency_id)
								echo '<option selected="selected" value="'.$currencie->currency_id.'" data-code="'.$currencie->currency_code.'" data-symbol="'.$currencie->currency_symbol.'">'.$currencie->currency_name .' - '.$currencie->currency_symbol.'</option>';
							else
								echo '<option value="'.$currencie->currency_id.'" data-code="'.$currencie->currency_code.'" data-symbol="'.$currencie->currency_symbol.'">'.$currencie->currency_name .' - '.$currencie->currency_symbol.'</option>';
						}						
						?>
						</select>
					</div>
					<div class="col-sm-3">						
						<label><?php echo lang('setting_shop_currency_symbol_label'); ?></label>						
					</div>
					<div class="col-sm-2">
						<input name="setting[currency_symbol]" type="text" class="form-control input-sm" value="<?php if (isset($setting->currency_symbol)) echo $setting->currency_symbol; ?>" id="shop-currency_symbol" placeholder="<?php echo lang('setting_shop_currency_symbol_place'); ?>">
						<input name="setting[currency_code]" type="hidden" id="shop-currency_code" value="<?php if (isset($setting->currency_code)) echo $setting->currency_code; ?>">
					</div>
				</div>
				
				<!-- print config -->
				<?php //echo '<pre>'; print_r($setting); exit; ?>
				<div class="row col-md-12">
					<h4><?php echo lang('settings_print'); ?></h4>
					
					<div class="form-group row">
						<label class="col-sm-3 control-label">
							<?php echo lang('settings_print_DTG'); ?><br />
							<span class="help-block"><small><?php echo lang('settings_print_DTG_des'); ?></small></span>
						</label>
						<div class="col-sm-3">
							<span class="help-block"><?php echo lang('settings_print_size_a4'); ?></span>
							<input type="text" name="setting[prints][DTG][4]" value="<?php echo settingPrint($setting, 'DTG', 4, 0); ?>" class="form-control input-sm">
						</div>
						<div class="col-sm-3">
							<span class="help-block"><?php echo lang('settings_print_size_a3'); ?></span>
							<input type="text" name="setting[prints][DTG][3]" value="<?php echo settingPrint($setting, 'DTG', 3, 0); ?>" class="form-control input-sm">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 control-label">
							<?php echo lang('settings_print_screen'); ?><br />
							<span class="help-block"><small><?php echo lang('settings_print_screen_des'); ?></small></span>
						</label>
						<div class="col-sm-3">
							<span class="help-block"><?php echo lang('settings_print_size_color_a4'); ?></span>
							<input type="text" name="setting[prints][screen][4]" value="<?php echo settingPrint($setting, 'screen', 4, 0); ?>" class="form-control input-sm">
						</div>
						<div class="col-sm-3">
							<span class="help-block"><?php echo lang('settings_print_size_color_a3'); ?></span>
							<input type="text" name="setting[prints][screen][3]" value="<?php echo settingPrint($setting, 'screen', 3, 0); ?>" class="form-control input-sm">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 control-label">
							<?php echo lang('settings_print_sublimation'); ?><br />
							<span class="help-block"><small><?php echo lang('settings_print_sublimation_des'); ?></small></span>
						</label>
						<div class="col-sm-3">
							<span class="help-block"><?php echo lang('settings_print_size_a4'); ?></span>
							<input type="text" name="setting[prints][sublimation][4]" value="<?php echo settingPrint($setting, 'sublimation', 4, 0); ?>" class="form-control input-sm">
						</div>
						<div class="col-sm-3">
							<span class="help-block"><?php echo lang('settings_print_size_a3'); ?></span>
							<input type="text" name="setting[prints][sublimation][3]" value="<?php echo settingPrint($setting, 'sublimation', 3, 0); ?>" class="form-control input-sm">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 control-label">
							<?php echo lang('settings_print_embroidery'); ?><br />
							<span class="help-block"><small><?php echo lang('settings_print_embroidery_des'); ?></small></span>
						</label>
						<div class="col-sm-3">
							<span class="help-block"><?php echo lang('settings_print_size_color_a4'); ?></span>
							<input type="text" name="setting[prints][embroidery][4]" value="<?php echo settingPrint($setting, 'embroidery', 4, 0); ?>" class="form-control input-sm">
						</div>
						<div class="col-sm-3">
							<span class="help-block"><?php echo lang('settings_print_size_color_a3'); ?></span>
							<input type="text" name="setting[prints][embroidery][3]" value="<?php echo settingPrint($setting, 'embroidery', 3, 0); ?>" class="form-control input-sm">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end price -->

	<!-- start designer -->
	<div class="tab-pane" id="designer" style="display:none;">
		<div class="row" id="dg-designer">
			<div id="tabs" style="border: none;">
				<ul>
					<li><a href="#tabs-1"><?php echo lang('all');?></a></li>
					<li><a href="#tabs-2"><?php echo lang('left');?></a></li>
					<li><a href="#tabs-3"><?php echo lang('top');?></a></li>
					<li><a href="#tabs-4"><?php echo lang('right');?></a></li>
				</ul>
				<div id="tabs-1">
					<div class="col-left">
						<span class="arrow-mobile" data="left"><i class="glyphicons chevron-right"></i></span>
						<div id="dg-left" class="width-100">
							<div class="dg-box width-100">
								<ul class="menu-left">
									<li>
										<a href="javascript:void(0)">
											<i class="glyphicons t-shirt"></i> Choose Product
											<i id="left_1" type="button" style="float: right; padding: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="right"></i>
										</a>
										
									</li>
									
									<li>
										<a href="javascript:void(0)">
											<i class="glyphicons text_bigger"></i> Add Text
											<i id="left_2" type="button" style="float: right; padding: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="right"></i>
										</a>
									</li>
									
									<li>
										<a href="javascript:void(0)">
											<i class="glyphicons picture"></i> Add Art
											<i id="left_3" type="button" style="float: right; padding: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="right"></i>
										</a>
									</li>
									
									<li>
										<a href="javascript:void(0)">
											<i class="glyphicons cloud-upload"></i> Upload image
											<i id="left_4" type="button" style="float: right; padding: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="right"></i>
										</a>
									</li>
									
									<li>
										<a href="javascript:void(0)">
											<i class="glyphicons soccer_ball"></i> Name &amp; Number
											<i id="left_5" type="button" style="float: right; padding: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="right"></i>
										</a>
									</li>
									
									<li>
										<a href="javascript:void(0)">
											<i class="glyphicons notes"></i> Add Note
											<i id="left_6" type="button" style="float: right; padding: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="right"></i>
										</a>
									</li>
									
									<li>
										<a href="javascript:void(0)">
											<i class="glyphicons qrcode"></i> Add QRcode
											<i id="left_7" type="button" style="float: right; padding: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="right"></i>
										</a>
									</li>
									
									<li>
										<a href="javascript:void(0)">
											<i class="glyphicons user"></i> My Design
											<i id="left_8" type="button" style="float: right; padding: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="right"></i>
										</a>
									</li>
									
									<li>
										<a href="javascript:void(0)">
											<i class="glyphicons sun"></i> Design Idea
											<i id="left_9" type="button" style="float: right; padding: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="right"></i>
										</a>
									</li>
								</ul>
							</div>
							
							<div class="dg-box width-100">
								<div role="tablist" class="accordion ui-accordion ui-widget ui-helper-reset">
									<h3 tabindex="0" aria-expanded="true" aria-selected="true" aria-controls="dg-layers" id="ui-accordion-1-header-0" role="tab" class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-header-active ui-state-active ui-corner-top ui-accordion-icons">Layers
										<i id="left_10" type="button" style="float: right; padding: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="right"></i>
									</h3>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-xs-12 col-md-12 col-center align-center" style="float: left;">
						<!-- Begin sidebar -->
						<div id="dg-sidebar">
							<ul class="dg-tools">
								<li data-title="dg-product">
									<i class="glyphicons circle_question_mark"></i>
									<i id="top_1" type="button" style="text-align: center" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="top"></i>
									<span>Help</span>
								</li>				
								<li data-title="dg-text">
									<i class="glyphicons eye_open"></i>
									<i id="top_2" type="button" style="text-align: center" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="top"></i>
									<span>Preview</span>
								</li>
								<li data-title="dg-product">
									<i class="glyphicons undo"></i>
									<i id="top_3" type="button" style="text-align: center" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="top"></i>
									<span>undo</span>
								</li>
								<li data-title="dg-product">
									<i class="glyphicons redo"></i>
									<i id="top_4" type="button" style="text-align: center" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="top"></i>
									<span>redo</span>
								</li>
								<li data-title="dg-product">
									<i class="glyphicons search"></i>
									<i id="top_5" type="button" style="text-align: center" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="top"></i>
									<span>zoom</span>
								</li>
								<li data-title="dg-product">
									<i class="glyphicons bin"></i>
									<i id="top_6" type="button" style="text-align: center" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="top"></i>
									<span>trash</span>
								</li>					
							</ul>
						</div>
						<!-- Begin sidebar -->
						
						<!-- design area -->
						<div id="design-area">
							<div id="app-wrap">
													
								<!-- begin front design -->						
								<div id="view-front" class="labView active">
									<div class="product-design"><img style="width: 85px; height: 60px; top: 8px; left: 126.5px; z-index: 300;" src="<?php echo site_url('assets/images/1-1.png')?>" id="front-img-images-0" class="modelImage"><img style="width: 220px; height: 370px; top: 0px; left: 108.5px; z-index: 100;" src="<?php echo site_url('assets/images/case.png')?>" id="front-img-images-1" class="modelImage"></div>
									<div style="height: 342px; width: 178px; left: 130px; top: 10px; border-radius: 25px; z-index: 200;" class="design-area"><div class="content-inner"></div></div>
								</div>						
								<!-- end front design -->
								
								<!-- begin back design -->
								<div id="view-back" class="labView">
									<div class="product-design"></div>
									<div class="design-area"><div class="content-inner"></div></div>
								</div>
								<!-- end back design -->
								
								<!-- begin left design -->
								<div id="view-left" class="labView">
									<div class="product-design"></div>
									<div class="design-area"><div class="content-inner"></div></div>
								</div>
								<!-- end left design -->
								
								<!-- begin right design -->
								<div id="view-right" class="labView">
									<div class="product-design"></div>
									<div class="design-area"><div class="content-inner"></div></div>
								</div>
								<!-- end right design -->
								
							</div>
						</div>
					</div>	  
					
					<div class="col-right">
						<span class="arrow-mobile" data="right"><i class="glyphicons chevron-left"></i></span>
						<div id="dg-right">
							<!-- share -->
							<div class="dg-share">
								<div class="row align-center">
									<label style="font-family: Garamond; font-size: 20px;">Save and share this design<i id="right_1" type="button" style="float: right; margin: 10px 0px 0px 5px; font-size: 55%; cursor: pointer;" class="fa fa-pencil edit_text" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i></label>
								</div>
							</div>
							
							<!-- product -->
							<div class="align-center" id="right-options">
								<div class="dg-box">
									<div role="tablist" class="accordion ui-accordion ui-widget ui-helper-reset">
										<h3 tabindex="0" aria-expanded="true" aria-selected="true" aria-controls="product-details" id="ui-accordion-2-header-0" role="tab" class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-header-active ui-state-active ui-corner-top ui-accordion-icons">Product Options
											<i id="right_2" type="button" style="float: right; margin-right: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
										</h3>										
										<h3 tabindex="-1" aria-expanded="false" aria-selected="false" aria-controls="ui-accordion-2-panel-1" id="ui-accordion-2-header-1" role="tab" class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all ui-accordion-icons">Color used
											<i id="right_3" type="button" style="float: right; margin-right: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
										</h3>										
										<h3 tabindex="-1" aria-expanded="false" aria-selected="false" aria-controls="ui-accordion-2-panel-2" id="ui-accordion-2-header-2" role="tab" class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all ui-accordion-icons">Screen size
											<i id="right_4" type="button" style="float: right; margin-right: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
										</h3>										
										<h3 tabindex="-1" aria-expanded="false" aria-selected="false" aria-controls="ui-accordion-2-panel-3" id="ui-accordion-2-header-3" role="tab" class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all ui-accordion-icons">Extra
											<i id="right_5" type="button" style="float: right; margin-right: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
										</h3>
										<!--
										<div aria-hidden="true" role="tabpanel" aria-labelledby="ui-accordion-2-header-3" id="ui-accordion-2-panel-3" style="display: none;" class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
											Extra
											<i id="right_1" type="button" style="float: right; margin: 4px 0px 0px 5px; font-size: 80%;" class="fa fa-pencil edit_text" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
										</div>
										-->
									</div>
									<div class="product-prices">
										<button type="button" class="btn btn-warning" style="margin: 5px 0;">Add to cart</button>
										<i id="right_6" type="button" style="float: right; padding: 10px; font-size: 80%; cursor: pointer;" class="fa fa-pencil edit_text" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
									</div>
								</div>
							</div>
						</div>
					</div>	
					<!-- footer -->
					<div style="display: table; width: 103%;" class="row footer">
						<div id="footer">
							<div class="col-md-4 pull-left">
								<span class="copyright">Copyright © <a href="http://9file.net/">9file.net</a> / All Rights Reserved</span>
							</div>
							<div class="col-md-8 pull-right align-right">
								<span class="phone-support">
									+84 123 456 789 
										<i id="bottom_1" type="button" style="padding: 5px; font-size: 80%; cursor: pointer;" class="fa fa-pencil edit_text" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
									<small>For support
										<i id="bottom_2" type="button" style="padding: 5px; font-size: 80%; cursor: pointer;" class="fa fa-pencil edit_text" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
									</small>
								</span>
							</div>
						</div>
					</div>
				</div>
				
				<div id="tabs-2">
					<div class="col-left" style="position: relative;">
						<span class="arrow-mobile" data="left"><i class="glyphicons chevron-right"></i></span>
						<div id="dg-left" class="width-100;">
							<div class="dg-box width-100">
								<ul class="menu-left">
									<li>
										<a href="javascript:void(0)">
											<i class="glyphicons t-shirt"></i> Choose Product
											<i id="left_1" type="button" style="float: right; padding: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="right"></i>
										</a>
										
									</li>
									
									<li>
										<a href="javascript:void(0)">
											<i class="glyphicons text_bigger"></i> Add Text
											<i id="left_2" type="button" style="float: right; padding: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="right"></i>
										</a>
									</li>
									
									<li>
										<a href="javascript:void(0)">
											<i class="glyphicons picture"></i> Add Art
											<i id="left_3" type="button" style="float: right; padding: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="right"></i>
										</a>
									</li>
									
									<li>
										<a href="javascript:void(0)">
											<i class="glyphicons cloud-upload"></i> Upload image
											<i id="left_4" type="button" style="float: right; padding: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="right"></i>
										</a>
									</li>
									
									<li>
										<a href="javascript:void(0)">
											<i class="glyphicons soccer_ball"></i> Name &amp; Number
											<i id="left_5" type="button" style="float: right; padding: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="right"></i>
										</a>
									</li>
									
									<li>
										<a href="javascript:void(0)">
											<i class="glyphicons notes"></i> Add Note
											<i id="left_6" type="button" style="float: right; padding: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="right"></i>
										</a>
									</li>
									
									<li>
										<a href="javascript:void(0)">
											<i class="glyphicons qrcode"></i> Add QRcode
											<i id="left_7" type="button" style="float: right; padding: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="right"></i>
										</a>
									</li>
									
									<li>
										<a href="javascript:void(0)">
											<i class="glyphicons user"></i> My Design
											<i id="left_8" type="button" style="float: right; padding: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="right"></i>
										</a>
									</li>
									
									<li>
										<a href="javascript:void(0)">
											<i class="glyphicons sun"></i> Design Idea
											<i id="left_9" type="button" style="float: right; padding: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="right"></i>
										</a>
									</li>
								</ul>
							</div>
							
							<div class="dg-box width-100">
								<div role="tablist" class="accordion ui-accordion ui-widget ui-helper-reset">
									<h3 tabindex="0" aria-expanded="true" aria-selected="true" aria-controls="dg-layers" id="ui-accordion-1-header-0" role="tab" class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-header-active ui-state-active ui-corner-top ui-accordion-icons">Layers
										<i id="left_10" type="button" style="float: right; padding: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="right"></i>
									</h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="tabs-3">
					<div class="col-left" style="position: relative">
						<!-- Begin sidebar -->
						<div id="dg-sidebar">
							<ul class="dg-tools" style="width: 50%;">	
								<li style="float: none;" data-title="dg-product">
									<span>Help <i id="top_1" type="button" style="float: right;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="top"></i></span>
								</li>				
								<li style="float: none;" data-title="dg-text">
									<span>Preview <i id="top_2" type="button" style="float: right;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="top"></i></span>
								</li>
								<li style="float: none;" data-title="dg-product">
									<span>Undo <i id="top_3" type="button" style="float: right;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="top"></i></span>
								</li>
								<li style="float: none;" data-title="dg-product">
									<span>Redo <i id="top_4" type="button" style="float: right;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="top"></i></span>
								</li>
								<li style="float: none;" data-title="dg-product">
									<span>Zoom <i id="top_5" type="button" style="float: right;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="top"></i></span>
								</li>
								<li style="float: none;" data-title="dg-product">
									<span>Trash <i id="top_6" type="button" style="float: right;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="top"></i></span>
								</li>	
								<li style="float: none;" data-title="dg-product">
									<span>Login <i id="top_7" type="button" style="float: right;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="top"></i></span>
								</li>	
								<li style="float: none;" data-title="dg-product">
									<span>Register <i id="top_8" type="button" style="float: right;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="top"></i></span>
								</li>								
							</ul>
						</div>
						<!-- Begin sidebar -->
					</div>	
				</div>
				<div id="tabs-4">
					<div class="col-left" style="position: relative;">
						<span class="arrow-mobile" data="right"><i class="glyphicons chevron-left"></i></span>
						<div id="dg-right">
							<!-- product -->
							<div class="align-center" id="right-options">
								<div class="dg-box">
									<div role="tablist" class="accordion ui-accordion ui-widget ui-helper-reset">
										<h3 tabindex="0" aria-expanded="true" aria-selected="true" aria-controls="product-details" id="ui-accordion-2-header-0" role="tab" class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-header-active ui-state-active ui-corner-top ui-accordion-icons">Product Options
											<i id="right_2" type="button" style="float: right; margin-right: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
										</h3>
										<!--
										<div aria-hidden="false" role="tabpanel" aria-labelledby="ui-accordion-2-header-0" style="display: block;" class="product-options contentHolder ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active ps-container" id="product-details">
										<div class="content-y">
											
											<div class="product-info">
												<div class="form-group product-fields">
													<label for="fields">Choose Product Color
														<i id="right_1" type="button" style="float: right; margin: 4px 0px 0px 5px; font-size: 80%;" class="fa fa-pencil edit_text" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
													</label>
												</div>										
											</div>
																				
											<div class="product-info" id="product-attributes">										
												<div class="form-group product-fields"><label for="fields">size
													<i id="right_1" type="button" style="float: right; margin: 4px 0px 0px 5px; font-size: 80%;" class="fa fa-pencil edit_text" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
												</label><div class="dg-poduct-fields"><label class="checkbox-inline">S
													<i id="right_1" type="button" style="float: right; margin: 4px 0px 0px 5px; font-size: 80%;" class="fa fa-pencil edit_text" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
												</label><label class="checkbox-inline"> M
													<i id="right_1" type="button" style="float: right; margin: 4px 0px 0px 5px; font-size: 80%;" class="fa fa-pencil edit_text" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
												</label><label class="checkbox-inline"> L
													<i id="right_1" type="button" style="float: right; margin: 4px 0px 0px 5px; font-size: 80%;" class="fa fa-pencil edit_text" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
												</label></div></div>																				
											</div>									
											
											<br>
											<a class="pull-left" href="javascript:void(0)" title="">Change product
												<i id="right_1" type="button" style="float: right; margin: 4px 0px 0px 5px; font-size: 80%;" class="fa fa-pencil edit_text" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
											</a> 
											<a class="pull-right" href="javascript:void(0)" title="">Product info
												<i id="right_1" type="button" style="float: right; margin: 4px 0px 0px 5px; font-size: 80%;" class="fa fa-pencil edit_text" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
											</a>
											</div>
											<div style="width: 198px; display: inherit; left: 0px; bottom: 3px;" class="ps-scrollbar-x-rail"><div style="left: 0px; width: 179px;" class="ps-scrollbar-x"></div></div><div style="top: 0px; height: 186px; display: inherit; right: 3px;" class="ps-scrollbar-y-rail"><div style="top: 0px; height: 167px;" class="ps-scrollbar-y"></div></div></div>
										-->
										<h3 tabindex="-1" aria-expanded="false" aria-selected="false" aria-controls="ui-accordion-2-panel-1" id="ui-accordion-2-header-1" role="tab" class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all ui-accordion-icons">Color used
											<i id="right_3" type="button" style="float: right; margin-right: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
										</h3>
										<!--
										<div aria-hidden="true" role="tabpanel" aria-labelledby="ui-accordion-2-header-1" id="ui-accordion-2-panel-1" style="display: none;" class="color-used ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
											Color used
											<i id="right_1" type="button" style="float: right; margin: 4px 0px 0px 5px; font-size: 80%;" class="fa fa-pencil edit_text" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
										</div>
										-->
										<h3 tabindex="-1" aria-expanded="false" aria-selected="false" aria-controls="ui-accordion-2-panel-2" id="ui-accordion-2-header-2" role="tab" class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all ui-accordion-icons">Screen size
											<i id="right_4" type="button" style="float: right; margin-right: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
										</h3>
										<!--
										<div aria-hidden="true" role="tabpanel" aria-labelledby="ui-accordion-2-header-2" id="ui-accordion-2-panel-2" style="display: none;" class="screen-size ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
											Screen size
											<i id="right_1" type="button" style="float: right; margin: 4px 0px 0px 5px; font-size: 80%;" class="fa fa-pencil edit_text" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
										</div>
										-->
										<h3 tabindex="-1" aria-expanded="false" aria-selected="false" aria-controls="ui-accordion-2-panel-3" id="ui-accordion-2-header-3" role="tab" class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all ui-accordion-icons">Extra
											<i id="right_5" type="button" style="float: right; margin-right: 5px; font-size: 80%;" class="fa fa-gear option" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
										</h3>
										<!--
										<div aria-hidden="true" role="tabpanel" aria-labelledby="ui-accordion-2-header-3" id="ui-accordion-2-panel-3" style="display: none;" class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
											Extra
											<i id="right_1" type="button" style="float: right; margin: 4px 0px 0px 5px; font-size: 80%;" class="fa fa-pencil edit_text" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
										</div>
										-->
									</div>
									<div class="product-prices">
										<button type="button" class="btn btn-warning" style="margin: 5px 0;">Add to cart</button>
										<i id="right_6" type="button" style="float: right; padding: 15px; font-size: 80%; cursor: pointer;" class="fa fa-pencil edit_text" data-container="body" data-toggle="popover" data-html="true" data-placement="left"></i>
									</div>
								</div>
							</div>
						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>
	<!-- end price -->
	
	<!-- start config -->
	<div class="tab-pane" id="shop">
		<!-- upload -->
		<div class="pull-left col-md-6">
			<h4><?php echo lang('settings_upload'); ?></h4>
			<div class="form-group row">
				<label class="col-sm-3 control-label"><?php echo lang('settings_upload_min'); ?></label>
				<div class="col-sm-6">
					<input type="text" class="form-control input-sm" value="<?php echo settingValue($setting, 'site_upload_min', 0.5); ?>" name="setting[site_upload_min]">
				</div>
				<div class="col-sm-2">MB</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3 control-label"><?php echo lang('settings_upload_max'); ?></label>
				<div class="col-sm-6">
					<input type="text" class="form-control input-sm" value="<?php echo settingValue($setting, 'site_upload_max', 10); ?>" name="setting[site_upload_max]">
				</div>
				<div class="col-sm-2">MB</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3 control-label"><?php echo lang('settings_upload_terms'); ?></label>
				<div class="col-sm-6">
					<input type="text" class="form-control input-sm" value="<?php echo settingValue($setting, 'site_upload_terms', '#'); ?>" name="setting[site_upload_terms]">
					<span class="help-block"><small><?php echo lang('settings_upload_terms_des'); ?></small></span>
				</div>				
			</div>
		</div> 
		<div class="pull-right col-md-6">
			<h4><?php echo lang('settings_shop'); ?></h4>
			<div class="form-group row">
				<label class="col-sm-3 control-label"><?php echo lang('settings_email'); ?></label>
				<div class="col-sm-6">
					<input type="text" class="form-control input-sm" value="<?php echo settingValue($setting, 'admin_email', ''); ?>" name="setting[admin_email]" placeholder="<?php echo lang('settings_email_place'); ?>">
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-sm-3 control-label"><?php echo lang('settings_app_id_facebook_title'); ?></label>
				<div class="col-sm-6">
					<input type="text" class="form-control input-sm" value="<?php echo settingValue($setting, 'app_id', ''); ?>" name="setting[app_id]" placeholder="<?php echo lang('settings_app_id_facebook_place'); ?>">
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-sm-3 control-label"><?php echo lang('settings_app_secret_facebook_title'); ?></label>
				<div class="col-sm-6">
					<input type="text" class="form-control input-sm" value="<?php echo settingValue($setting, 'app_secret', ''); ?>" name="setting[app_secret]" placeholder="<?php echo lang('settings_app_secret_facebook_place'); ?>">
				</div>
			</div>
			
		</div>
		
		<div class="pull-right col-md-6">
			<h4><?php echo 'Themes'; ?></h4>
			<div class="form-group row">
				<label class="col-sm-3 control-label"><?php echo 'Choose theme'; ?></label>
				<div class="col-sm-6">
					<?php
					$this->load->library('file');
					$themes	= $this->file->folders(APPPATH .DS. 'views'. DS. 'themes');					
					$theme_active = settingValue($setting, 'theme', '');
					?>
					<select name="setting[theme]" class="form-control input-sm">
						<option value=""> - Select theme - </option>
						<?php 
						for ($i=0; $i< count($themes); $i++) {
							if ($theme_active == $themes[$i]) $selected = 'selected="selected"';
							else $selected = '';
						?>
						<option <?php echo $selected; ?> value="<?php echo $themes[$i]; ?>"> <?php echo $themes[$i]; ?> </option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div class="pull-left col-md-6">
			<h4><?php echo lang('settings_invoice_pdf'); ?></h4>
			<div class="form-group row">
				<label class="col-sm-3 control-label">
					<?php echo lang('settings_change_logo_invoice'); ?>
					<span class="help-block"><?php echo lang('settings_invoice_width_help_block'); ?></span>
				</label>
				<div class="col-sm-3">
					<a onclick="jQuery.fancybox( {href : '<?php echo site_url().'admin/media/modals/productImg/1'; ?>', type: 'iframe'} );" class="btn btn-default btn-sm" href="javascript:void(0)"><?php echo lang('setting_invoice_logo_change'); ?></a>
				</div>
				<div class="col-sm-3" id="shop-logo">
					<?php if(isset($setting->invoice_logo) && $setting->invoice_logo != ''){ echo '<img src="'.base_url($setting->invoice_logo).'" id="invoice_logo" width="60" />';} ?>
					<input type="hidden" value="<?php if(isset($setting->invoice_logo)) echo $setting->invoice_logo; ?>" id="value_site_logo" name="setting[invoice_logo]">
				</div>
			</div>
		</div>
	</div>
	<!-- end Config -->
	
	<!-- start setting lang -->
	<div style=" height: 520px;overflow: auto;" class="tab-pane" id="language">
		<div class="alert alert-info">
			<button class="close" data-dismiss="alert"> × </button>
			<i class="fa fa-info-circle"></i>
			<strong><?php echo lang('settings_lang_training_edit_language_title');?></strong>
			<ol>
				<li><?php echo lang('settings_lang_training_edit_language_1');?></li>
				<li><?php echo lang('settings_lang_training_edit_language_2');?></li>
				<li><?php echo lang('settings_lang_training_edit_language_3');?></li>
			</ol>
		</div>
		<a id="save_language" data-loading-text="Saving" href="javascript:void(0)" class="btn btn-primary btn-sm pull-right"><?php echo lang('settings_lang_save_language_btn');?></a>
		<ul class="edit_language">
			<?php foreach($lang as $key=>$val){ ?>
				<li><p class="click_edit" data-label="<?php echo $key;?>"><?php echo stripslashes($val);?></p></li>
			<?php } ?>
		</ul>
	</div>
	<!-- end setting lang -->
</div>
</form>
<script type="text/javascript">
	
	function productImg(images)
	{
		if(images.length > 0)
		{
			jQuery('#invoice_logo').attr('src', images[0]);
			var str = images[0];
			str = str.replace("<?php echo site_url();?>", "");
			jQuery('#value_site_logo').attr('value', str);			
			jQuery.fancybox.close();
		}
	}
	
	jQuery('.click_edit').editable(function(value, settings) {
		console.log(this);
		console.log(value);
		console.log(settings);
		return(value);
	},{ 
		submit : '<?php echo lang('ok');?>',
		tooltip : '<?php echo lang('settings_lang_click_to_edit_tooltip');?>',
	});
	
	function langOk(ok)
	{
		jQuery(ok).parent('form').parent('p').css('color', '#ff0000');
		return true;
	}
	
	jQuery('#save_language').click(function(){
		
		var langs = {};
		jQuery('.click_edit').each(function($langs){
			var label = jQuery(this).attr('data-label');
			langs[label] = jQuery(this).html();
			return langs;
		});
		var btn = $(this);
		btn.button('loading');
		jQuery.ajax({
			type: "POST",
			url: '<?php echo site_url().'admin/settings/editlang'?>',
			data: {language:''+JSON.stringify(langs)+''},
			dataType: 'html',
			success: function(data){
				if(data == 1)
					alert('<?php echo lang('settings_lang_update_sucess_msg');?>');
				else
					alert('<?php echo lang('settings_lang_update_error_msg');?>');
				btn.button('reset');
			}
		});
	});

	jQuery(function() {
		var tabs = jQuery( "#tabs" ).tabs();
		tabs.find( ".ui-tabs-nav" ).sortable({
			axis: "x",
			stop: function() {
				tabs.tabs( "refresh" );
			}
		});
	});

	jQuery('.option').popover({
		content: function(){	
			var id = jQuery(this).attr('id');
			var value = jQuery.trim(jQuery(this).parent().text());
			return "<div class='form-group'><input type='text' class='form-control input-sm form-input' name='lang_"+id+"' value='"+value+"' placeholder='Change title'></div><div class='form-group'><input type='radio' class='form-input' name='"+id+"' value='1' checked='checked'> Show <input class='form-input' type='radio' name='"+id+"' value='0'> Hidden <button class='btn btn-primary btn-xs' type='button' onclick='submit()'>Save</button></div>";
		}
	});
	
	jQuery('.edit_text').popover({
		content: function(){	
			var id = jQuery(this).attr('id');
			var value = jQuery.trim(jQuery(this).parent().text());
			return "<div class='form-group'><input type='text' class='form-control input-sm form-input' name='lang_"+id+"' value='"+value+"' placeholder='Change title'></div><button class='btn btn-primary btn-xs' type='button' onclick='submit()'>Save</button>";
		}
	});
	
	jQuery('body').on('click', function (e) {
		jQuery('.option, .edit_text').each(function () {
			if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
				$(this).popover('hide');
			}
		});
	});
	
	function submit(){
		jQuery.ajax({
			type: "POST",
			url: "<?php echo site_url();?>/admin/settings/configuaration",
			data: jQuery('.form-input').serialize(),
			dataType: 'html',
		});
	}
	
	var values = "<?php echo $setting->currency_id;?>";
	jQuery('.chosen-select').val(values.split(','));
	jQuery(".chosen-select").chosen({width: '90%'});
	jQuery(".default").css('width', '100%');
	
	var bootstrapTooltip = $.fn.tooltip.noConflict();
	$.fn.bstooltip = bootstrapTooltip;
	$('.dgtooltip').bstooltip();
</script>
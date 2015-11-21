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
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/css/view_design.css'); ?>"/>
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/canvg.js'); ?>"></script>
<div class="modal-header">
	<h4 class="modal-title"><?php echo lang('orders_admin_detail_view_title');?></h4>
	<span class="help-block"><?php echo lang('orders_admin_detail_view_title_help');?></span>
</div>
	<div class="modal-body">
		<div class="row">
			<?php if(isset($product->vectors)){ ?>
			<?php $vectors = json_decode($product->vectors, true); ?>
			<?php if(is_array($vectors))foreach($vectors as $key=>$vector){?>
				<?php if(count($vector) != 0){ ?>
					<div class="col-sm-12">
						<fieldset>
							<legend><?php echo lang('designer_view_lightbox_design_'.$key.'_legend');?></legend>
							<div class="col-sm-5 view_product">
								<?php if(isset($product->image)){ ?>
									<a target="_blank" href="<?php echo site_url('design/index/'.$product->product_id.'/'.$product->product_options.'/'.$product->design_id); ?>" title="Click to edit design">
									<img id="view_product-<?php echo $key; ?>" src="<?php echo base_url(str_replace('front', $key, $product->image));?>" alt=""/>
									</a>
								<?php } ?>
								<span>
								<?php echo lang('designer_view_lightbox_download_design');?>:
								<a href="<?php echo site_url('admin/orders/download/'. $product->id.'/'.$key.'/'.$product->product_id );?>"><strong>SVG</strong></a>
								 | <a href="javascript:void(0)" onclick="downloadPNG('<?php echo site_url('admin/orders/download/'. $product->id.'/'.$key.'/'.$product->product_id .'/png' );?>')"><strong>PNG</strong></a>
								</span>
							</div>
							
							<div class="col-sm-7 view_vector">
								<?php foreach($vector as $value){?>
									<div class="row">
										<?php if(isset($value['type'])){?>
											<label class="col-sm-3"><?php echo lang('designer_view_lightbox_add_'.$value['type'].'_label');?></label>
										<?php }?>
										<div class="col-sm-9">
										<?php if(isset($value['text'])){ ?>
											<p class="text"><?php echo $value['text']; ?></p>
										<?php }elseif(isset($value['thumb'])){ ?>
											<img class="clipart_thumb" src="<?php echo $value['thumb'];?>" alt=""/>
										<?php } ?>
											<ul>
												<?php foreach($value as $k=>$v){ ?>
													<?php if($k != 'text' && $k != 'zIndex' && $k != 'type' && $k != 'svg' && $k != 'outlineC' && $k != 'outlineW' && $k != 'title' && $k != 'file_name' && $k != 'file' && $k != 'thumb' && $k != 'url' && $k != 'change_color'){ ?>
														
														<li>
															<span><?php echo lang($k) ?></span>
															<?php if ($k == 'fontFamily') { ?>
																<link href='http://fonts.googleapis.com/css?family=<?php echo str_replace(' ', '+', $v); ?>' rel='stylesheet' type='text/css'>
																<a target="_blank" href="http://www.google.com/fonts/specimen/<?php echo str_replace(' ', '+', $v); ?>" title="Click to download this font" style="font-family:'<?php echo $v; ?>'"><?php echo $v; ?></a>
																
															<?php } else { ?>
															
																<?php echo $v; ?>
																
															<?php } ?>
														</li>
														
													<?php }elseif(($k == 'outlineC' || $k == 'outlineW') && $v != 'none'){?>
														<li><span><?php echo lang($k); ?></span><?php echo $v; ?></li>
													<?php } ?>
												<?php } ?>
											</ul>
										</div>
									</div>
								<?php } ?>
							</div>
						</fieldset>
					</div>
				<?php } ?>
			<?php } ?>
			<?php }else{ echo '<div class="col-sm-12"><div class="alert alert-danger" role="alert">'.lang('orders_admin_detail_view_not_found_msg').'</div></div>';} ?>
		</div>
	</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="parent.jQuery.fancybox.close();"><?php echo lang('close');?></button>
</div>
<script type="text/javascript">
function downloadPNG(url)
{
	$('body').css('opacity', '0.2');
	$.ajax({
		url: url + '.svg',
		 dataType: "text",
	}).done(function(svg) {
		if ($('#output-download').length == 0)
			$('body').append('<div id="output-download" style="position: fixed;left: -999px;">'+svg+'</div>');
		else
			$('#output-download').html(svg);
				
		setTimeout(function(){
			var image = new Image();
			image.src = 'data:image/svg+xml;base64,' + window.btoa($('#output-download').html());
			var canvas = document.createElement('canvas');
			canvas.width = image.width;
			canvas.height = image.height;
			var context = canvas.getContext('2d');			
			//context.drawSvg(svg, 0, 0);
			context.drawImage(image, 0, 0);

			var a = document.createElement('a');
			a.download = "print.png";
			a.href = canvas.toDataURL('image/png');
			document.body.appendChild(a);
			a.click();
			$('body').css('opacity', 1);
		}, 2000);
	});
}
</script>
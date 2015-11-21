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
<script src="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox-media.js'); ?>" type="text/javascript"></script>
<link href="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.css'); ?>" rel="stylesheet"/>
<?php
	echo $css;
	$options = json_decode($popup->options);
	
	if(isset($options->type) && $options->type == 'image')
	{
		if(isset($options->show) && $options->show == 'onload')
			echo '<a class="fancybox" href="'.base_url($popup->content).'" title="'.$popup->title.'"><img class="thumbnail" src="'.base_url($popup->content).'" alt="'.$popup->title.'" style="display: none;"/></a>';
		else
			echo '<a class="fancybox" href="'.base_url($popup->content).'" title="'.$popup->title.'"><img class="thumbnail" src="'.base_url($popup->content).'" alt="'.$popup->title.'"/></a>';
	}else if(isset($options->type) && $options->type == 'video')
	{
		if(isset($options->show) && $options->show == 'onload')
			echo '<a class="fancybox-media" href="'.$popup->content.'"></a>';
		else
			echo '<a class="fancybox-media" href="'.$popup->content.'">'.$popup->title.'</a>';
	}else if(isset($options->type) && $options->type == 'text')
	{
		if(isset($options->show) && $options->show == 'onload')
			echo '<a class="fancybox" href="#popup_content_fancybox" title="'.$popup->title.'"></a>';
		else
			echo '<a class="fancybox" href="#popup_content_fancybox" title="'.$popup->title.'">'.$popup->title.'</a>';
		echo '<div id="popup_content_fancybox" style="display: none;">';
		echo $popup->content;
		echo '</div>';
	}
	
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
	
		<?php if(isset($options->type) && $options->type == 'video') { ?>
			jQuery('.fancybox-media')
			.attr('rel', 'media-gallery')
			.fancybox({
				openEffect : 'none',
				closeEffect : 'none',
				prevEffect : 'none',
				nextEffect : 'none',

				arrows : false,
				helpers : {
					media : {},
					buttons : {}
				}
			});
		<?php }else{ ?>
			jQuery(".fancybox").fancybox();
		<?php } ?>
		
		<?php 
			if(isset($options->show) && $options->show == 'onload')
			{
				echo 'jQuery(".fancybox").trigger("click");';
				echo 'jQuery(".fancybox-media").trigger("click");';
			}
		?>
	});
</script>

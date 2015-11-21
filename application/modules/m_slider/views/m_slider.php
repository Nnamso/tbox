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
$data = json_decode($slider->content, true);
$options = json_decode($slider->options);
?>
	<script src="<?php echo base_url('media/modules/slider/jquery.fitvids.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.js'); ?>" type="text/javascript"></script>
	<link href="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.css'); ?>" rel="stylesheet"/>
<?php echo $css; ?>
<ul id="bx-slider-<?php echo $slider->id; ?>">
	<?php 
		if(isset($data['images']) && is_array($data['images']))
		foreach($data['images'] as $key=>$image)
		{
			if(isset($data['display'][$key]) && $data['display'][$key] == 'image') // display image.
			{
				if($data['url'][$key] != '') // show url
				{
					if($data['thumbnail'][$key] == 'show')
						echo '<li><a href="'.base_url($image).'" title="image" class="popup-lighbox-'.$slider->id.'"><img src="'.base_url($image).'" alt="image"/></a></li>';
					else
						echo '<li><a target="'.$data['thumbnail'][$key].'" href="'.$data['url'][$key].'" title="image"><img src="'.base_url($image).'" alt="image"/></a></li>';
				}else
				{
					if($data['thumbnail'][$key] == 'show')
						echo '<li><a href="'.base_url($image).'" title="image" class="popup-lighbox-'.$slider->id.'"><img src="'.base_url($image).'" alt="image"/></a></li>';
					else
						echo '<li><img src="'.base_url($image).'" alt="image"/></li>';
				}
			}else
			{
				if($options->slideWidth == '')
					$options->slideWidth = '500';
				if($options->slideHeight == '') 
					$options->slideHeight = '280'; 
				echo '<li><iframe src="'.$data['video_url'][$key].'" width="'.$options->slideWidth.'" height="'.$options->slideHeight.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></li>';
			}
		}
	?>
</ul>
<script type="text/javascript">
	jQuery('#bx-slider-<?php echo $slider->id; ?>').bxSlider({
		<?php 
			foreach($options as $key=>$val)
			{
				if(($key == 'slideWidth' || $key == 'slideHeight') && $val == '')
				{
					echo '';
				}else if($val === 'true' || $val === 'false')
					echo $key.': '.$val.',';
				else
					echo $key.': "'.$val.'",';
			}
		?>
		video: true
	});
	
	jQuery(".popup-lighbox-<?php echo $slider->id; ?>").fancybox();
</script>
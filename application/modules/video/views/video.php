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

	echo $css;
	$content = json_decode($video->content);
	if(isset($content->url))
	{
		if(strpos($content->url, 'www.youtube.com/watch?v=') > 0) //Youtube.
		{
			$url_video = '//www.youtube.com/embed/'.substr($content->url, 32, strlen($content->url));
		}else if(strpos($content->url, 'www.dailymotion.com/video/') > 0) //dailymotion.
		{
			$str = substr($content->url, 33, strlen($content->url));
			$url_video = '//www.dailymotion.com/embed/video/'.substr($str, 0, strpos($str, '_'));
		}else if(strpos($content->url, 'vimeo.com/') > 0) //vimeo.
		{
			$url_video = '//player.vimeo.com/video/'.substr($content->url, 17, strlen($content->url));
		}else if(strpos($content->url, 'metacafe.com/') > 0) //metacafe.
		{
			$str = substr($content->url, 30, strlen($content->url));
			$url_video = 'http://www.metacafe.com/embed/'.substr($str, 0, strpos($str, '/'));
		}
?>
		<div class="module-video">
			<div class="video <?php if(isset($content->responsive) && $content->responsive == 'yes') echo 'video-responsive';?> <?php if(isset($content->sfx)) echo $content->sfx;?>">
				<iframe style="<?php if(isset($content->width) && $content != '') echo 'width: '.$content->width.'px;'; else echo 'width: 100%;'; if(isset($content->height) && $content != '') echo 'height: '.$content->height.'px;'; else echo 'height: 100%;';?> frameborder: none;" src="<?php echo $url_video;?>" allowfullscreen></iframe>
			</div>
		</div>
<?php 
	}
?>

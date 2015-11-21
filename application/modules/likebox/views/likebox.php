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
	if(count($likebox) > 0)
	{
		$content = json_decode($likebox->content);
	?>
	
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&appId=<?php if(isset($content->appid)) echo $content->appid;?>&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	
	<div class="fb-like-box" data-href="<?php if(isset($content->url)) echo $content->url;?>" data-colorscheme="<?php if(isset($content->color)) echo $content->color;?>" data-show-faces="<?php if(isset($content->show_faces) && $content->show_faces == true) echo 'true'; else echo 'false'; ?>" data-header="<?php if(isset($content->show_header) && $content->show_header == true) echo 'true'; else echo 'false';?>" data-stream="<?php if(isset($content->show_post) && $content->show_post ==true) echo 'true'; else echo 'false';?>" data-show-border="<?php if(isset($content->show_border) && $content->show_border == true) echo 'true'; else echo 'false';?>" <?php if(isset($content->width) && $content->width != '') echo 'data-width="'.$content->width.'"';?> <?php if(isset($content->height) && $content->height != '') echo 'data-height="'.$content->height.'"';?>></div>

<?php
	}else
	{
		echo 'Data not found';
	}
?>

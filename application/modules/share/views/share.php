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
<?php
	echo $css;
	if(count($share) > 0)
	{
		$content = json_decode($share->content);
		echo '<div class="share">';
		if(isset($content->facebook->publish) && $content->facebook->publish == 'yes')
		{ ?>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1462457697321605&version=v2.0";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			
			<div class="fb-share-button" data-href="<?php if(isset($content->facebook->link)) echo $content->facebook->link; ?>" data-layout="<?php if(isset($content->facebook->option)) echo $content->facebook->option; ?>"></div>
		<?php
		}
		if(isset($content->google->publish) && $content->google->publish == 'yes')
		{ ?>
		
			<script src="https://apis.google.com/js/platform.js" async defer></script>
			<div class="g-plus" data-action="share" <?php if(isset($content->google->option) && $content->google->option != '') echo 'data-annotation="'.$content->google->option.'"'; ?> <?php if(isset($content->google->link) && $content->google->link != '') echo 'data-href="'.$content->google->link.'"'; ?>></div>
		<?php
		}
		if(isset($content->tweet->publish) && $content->tweet->publish == 'yes')
		{ ?>
			<a href="<?php if(isset($content->tweet->link)) echo $content->tweet->link; ?>" class="twitter-share-button" <?php if(isset($content->tweet->option) && $content->tweet->option != '') echo 'data-count="'.$content->tweet->option.'"'; ?>>Tweet</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
		<?php
		}
		if(isset($content->pinterest->publish) && $content->pinterest->publish == 'yes')
		{ ?>
			<a href="//www.pinterest.com/pin/create/button/?url=<?php if(isset($content->pinterest->link)) echo $content->pinterest->link; ?>" data-pin-do="buttonPin" data-pin-config="<?php if(isset($content->pinterest->option)) echo $content->pinterest->option; ?>" data-pin-color="red" data-pin-height="20"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_red_28.png" alt="pinterest icon"/></a>
			<!-- Please call pinit.js only once per page -->
			<script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>

		<?php
		}
		if(isset($content->linkedin->publish) && $content->linkedin->publish == 'yes')
		{ ?>
			<script src="//platform.linkedin.com/in.js" type="text/javascript">
			  lang: en_US
			</script>
			<script type="IN/Share" <?php if(isset($content->pinterest->option) && $content->pinterest->option != '') echo 'data-counter="'.$content->pinterest->option.'"'; ?>></script>

		<?php
		}
		echo '</div>';
	}else
	{
		echo 'Data not found';
	}
?>
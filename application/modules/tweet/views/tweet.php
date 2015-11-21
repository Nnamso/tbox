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
	if(count($tweet) > 0)
	{
		$content = json_decode($tweet->content);
		if(isset($content->publish) && $content->publish == 'yes')
		{
			include_once('TwitterAPIExchange.php');
			
			if(empty($content->username))
				$content->username = '';
			if(empty($content->accesstoken))
				$content->accesstoken = '';
			if(empty($content->accesstokensecret))
				$content->accesstokensecret = '';
			if(empty($content->key))
				$content->key = '';
			if(empty($content->secret))
				$content->secret = '';
			if(empty($content->number))
				$content->number = '';
				
				
			/*twitter settings*/
			$settings = array(
				'oauth_access_token' => $content->accesstoken,
				'oauth_access_token_secret' => $content->accesssecret,
				'consumer_key' => $content->key,
				'consumer_secret' => $content->secret
			);
			
			/*URL - Twitter Timeline*/
			$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
			$getfield = '?screen_name='.$content->username.'&count='.$content->number;
			$twitter = new TwitterAPIExchange($settings);
			$string = json_decode($twitter->setGetfield($getfield)->buildOauth($url, 'GET')->performRequest(),$assoc = TRUE);
			if(isset($content->add_link) && $content->add_link == 'yes')
			{
				function addLink($string)
				{
					$pattern = '/((ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?)/i';
					$replacement = '<a class="tweet_url" href="$1">$1</a>';
					$string = preg_replace($pattern, $replacement, $string);
					return $string;
				}
			}else
			{
				function addLink($string)
				{
					return $string;
				}
			}
			echo '<div id="twitter-feed">';
			echo '<div class="twitter-username"><img src="'.base_url('media/modules/tweet/twitter_bird.png').'" width="45" height="30" alt="Follow us on Twitter">
			Follow <a href="http://twitter.com/'.$content->username.'" target="_blank">'.$content->username.'</a> on Twitter</div>';
			if(is_array($string) && empty($string['errors']))
			{
				foreach($string as $items)
				{
					echo '<div class="twitter-article">';
					if(isset($content->show_picture) && $content->show_picture == 'show'){
						echo '<div class="twitter-pic"><a href="https://twitter.com/'.$items['user']['screen_name'].'" ><img src="'.$items['user']['profile_image_url_https'].'" width="42" height="42" alt="twitter avatar" /></a></div>';
					}
					echo '<div class="twitter-text"><p><span class="tweetprofilelink"><strong><a href="https://twitter.com/'.$items['user']['screen_name'].'" >'.$items['user']['name'].'</a></strong> <a href="https://twitter.com/'.$items['user']['screen_name'].'" >@'.$items['user']['screen_name'].'</a></span><span class="tweet-time"><a href="https://twitter.com/'.$items['user']['screen_name'].'/status/'.$items['id_str'].'"></a></span><br/>'.addLink($items['text']).'</p></div>';
					echo '</div>';
				}
			}
			echo '</div>';
		}
	}else
	{
		echo 'Data not found';
	}
?>

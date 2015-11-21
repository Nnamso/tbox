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

	if(count($articles))
	{
		echo $css;
		$options = json_decode($most_article->options);
		
		if(isset($options->class_sfx) && $options->class_sfx != '')
			echo '<div class="module-most_article '.$options->class_sfx.'">';
		else
			echo '<div class="module-most_article">';
		
		//show title.
		if(isset($options->show_title) && $options->show_title == 'yes')
			echo '<h4>'.$most_article->title.'</h4>';
			
		foreach($articles as $article)
		{
			echo '<div class="most_article">';
			echo '<div class="row">';
			// show thumbnail.
			if($article->image != '' && (isset($options->show_thumb) && $options->show_thumb == 'yes'))
			{
				echo '<div class="col-xs-4">';
				echo '<img class="thumbnail" src="'.base_url($article->image).'" alt="'.$article->title.'" />';
				echo '</div>';
				echo '<div class="col-xs-8">';
				
				// show title.
				if(strlen($article->description) <= 25)
					echo '<h5><a href="'.site_url().'blog/post/'.$article->id.'-'.$article->slug.'" title="'.$article->title.'">'.$article->title.'</a></h5>';
				else
					echo '<h5><a href="'.site_url().'blog/post/'.$article->id.'-'.$article->slug.'" title="'.$article->title.'">'.substr($article->title, 0, 25).' ...</a></h5>';
				
				// show date.
				if(isset($options->show_date) && $options->show_date == 'yes')
				{
					$date = date_create($article->date);
					echo '<span class="help-block"><small><i class="fa fa-calendar"></i> '.date_format($date, 'F d,Y').'</small></span>';
				}
				
				// show intro text.
				if(isset($options->show_intro) && $options->show_intro == 'yes')
				{
					if(strlen($article->description) <= 50)
						echo '<p>'.strip_tags($article->description).'</p>';
					else
						echo '<p>'.substr(strip_tags($article->description), 0, 50).' [...]</p>';
				}
				
			}else
			{
				echo '<div class="col-xs-12">';
				
				// show title.
				if(strlen($article->description) <= 40)
					echo '<h5><a href="'.site_url().'blog/post/'.$article->id.'-'.$article->slug.'" title="'.$article->title.'">'.$article->title.'</a></h5>';
				else
					echo '<h5><a href="'.site_url().'blog/post/'.$article->id.'-'.$article->slug.'" title="'.$article->title.'">'.substr($article->title, 0, 40).' ...</a></h5>';
				
				// show date.
				if(isset($options->show_date) && $options->show_date == 'yes')
				{
					$date = date_create($article->date);
					echo '<span class="help-block"><small><i class="fa fa-calendar"></i> '.date_format($date, 'F d,Y').'</small></span>';
				}
				
				// show intro text.
				if(isset($options->show_intro) && $options->show_intro == 'yes')
				{
					if(strlen($article->description) <= 70)
						echo '<p>'.strip_tags($article->description).'</p>';
					else
						echo '<p>'.substr(strip_tags($article->description), 0, 70).' [...]</p>';
				}
			
			}
			
			echo '</div>';
			echo '</div>';
			echo '</div>';
		}
		echo '</div>';
	}
?>


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
	if(isset($image->content))
	{
		$options = json_decode($image->options);
		if(!isset($options->animation))
			$options->animation = '';
		if(!isset($options->class_sfx))
			$options->class_sfx = '';
		if(!isset($options->alignment))
			$options->alignment = '';
		if(!isset($options->width))
			$options->width = '';
		if(!isset($options->height))
			$options->height = '';
		if(!isset($options->style))
			$options->style = '';
			
		echo '<div class="module-image  '.$options->animation.' '.$options->class_sfx.'" style="text-align: '.$options->alignment.'" >';
		if(!isset($options->size))
			$options->size = '';
		if(!isset($options->style))
			$options->style = '';
			
		if($options->width != '' && $options->height != '')
			$size = 'width: '.$options->width.'px; height: '.$options->height.'px';
		else if($options->width != '')
			$size = 'width: '.$options->width.'px;';
		else if($options->height != '')
			$size = 'height: '.$options->height.'px;';
		else
			$size = '';
			
		$responsive = 'img-responsive';
		if(isset($options->link) && $options->link != '' && strlen($options->link) > 7)
			echo '<a href="'.$options->link.'"><img src="'.base_url($image->content).'" style="'.$size.'" alt="'.$image->title.'" class="'.$options->style.' '.$responsive.'"></a>'; 
		else
			echo '<img src="'.base_url($image->content).'" style="'.$size.'" alt="'.$image->title.'" class="'.$options->style.' '.$responsive.'">'; 
		echo '</div>';
	}
?>
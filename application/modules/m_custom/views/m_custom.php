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
	if(count($custom) > 0)
	{
		$options = json_decode($custom->options);
		if(isset($options->class_sfx))
			echo '<div class="'.$options->class_sfx.'">';
		else
			echo '<div>';
		
		echo $custom->content; 
		echo '</div>';
	}else
	{
		echo 'Data not found';
	}
?>
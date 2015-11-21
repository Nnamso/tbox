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
	$content = json_decode($tab->content, true);
	
	$options = json_decode($tab->options, true);
	if(!isset($options['tab_type']))
		$options['tab_type'] = 'top';
	if(!isset($options['color']))
		$options['color'] = 'tab-bricky';
	
	echo '<div class="module-tab">';
	if($options['tab_type'] == 'accordions')
	{
		echo '<div id="'.$tab->key.'" class="'.$options['color'].'">';
		
		if(isset($content['content']) && is_array($content['content']))
		{	
			$i=0;
			foreach($content['content'] as $key=>$val)
			{
				if(!isset($content['name'][$i]))
					$content['name'][$i] = '';
				
				if($i == 0)
					echo '<h3><span class="glyphicon glyphicon-minus"></span> '.$content['name'][$i].'</h3>';
				else
					echo '<h3><span class="glyphicon glyphicon-plus"></span> '.$content['name'][$i].'</h3>';
				echo '<div>';
				echo $val;
				echo '</div>';
				$i++;
			}
		}
		echo '</div>';
	}else
	{
		echo '<div class="'.$options['color'].'">';
		if($options['tab_type'] == 'left')
			echo  '<div id="'.$tab->key.'" class="ui-tabs-vertical">';
		else
			echo '<div id="'.$tab->key.'">';
		echo '<ul>';
		
		if(isset($content['name']) && is_array($content['name']))
		{
			$i=0;
			foreach($content['name'] as $key=>$val)
			{
				if(isset($content['icon'][$i]))
					echo '<li><a href="#'.$tab->key.'-'.$key.'"><i class="'.$content['icon'][$i].'" ></i> '.$val.'</a></li>';
				else
					echo '<li><a href="#'.$tab->key.'-'.$key.'">'.$val.'</a></li>';
				$i++;
			} 
		} 
		echo '</ul>';
		
		if(isset($content['content']) && is_array($content['content']))
		{
			foreach($content['content'] as $key=>$val)
			{
				echo '<div id="'.$tab->key.'-'.$key.'" >';
				echo $val;
				echo '</div>';
			}
		}
		echo '</div>';
		echo '</div>';
	}
	echo '</div>';	
?>

<script type="text/javascript">
	jQuery(function(){
		<?php 
			if($options['tab_type'] == 'accordions')
			{
				echo 'jQuery("#'.$tab->key.'").accordion({collapsible: true});';
				echo 'jQuery(".ui-accordion-header").click(function(){
					jQuery(".ui-accordion-header").children(".glyphicon").addClass("glyphicon-plus");
					var classicon = jQuery(this).children("span").hasClass("glyphicon-minus");
					if(classicon)
					{
						jQuery(this).children(".glyphicon").addClass("glyphicon-plus");
						jQuery(this).children(".glyphicon").removeClass("glyphicon-minus");
					}else
					{
						jQuery(".ui-accordion-header").children(".glyphicon").removeClass("glyphicon-minus");
						jQuery(this).children(".glyphicon").removeClass("glyphicon-plus");
						jQuery(this).children(".glyphicon").addClass("glyphicon-minus");
					}
				});';
			}else if($options['tab_type'] == 'left')
			{
				echo 'jQuery("#'.$tab->key.'").tabs();';
				echo 'jQuery("#'.$tab->key.'").addClass("ui-tabs-vertical ui-helper-clearfix");';
			}else
			{
				echo 'jQuery("#'.$tab->key.'").tabs();';
			}
		?>
	});
	
</script>
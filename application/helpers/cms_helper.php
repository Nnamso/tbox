<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * main helper
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function allGroupCategories($categories)
{

    $map = array();	
    $maps = array();	

    foreach ($categories as $category) {
        $category->subcategories = array();
        $map[$category->id] = $category;
    }
    foreach ($categories as $category) {		
        $map[$category->parent_id]->subcategories[] = $category;
    }
	//echo '<pre>'; print_r($map);exit;
	if(isset($map[0]->subcategories))
		$maps = groupCategories($map[0]->subcategories);
	$maps = joinGroupCategories($map, $maps);
	
	return $maps;
}

function joinGroupCategories($categories, $catedata = array())
{
	$arr = array();
	foreach($catedata as $value)
	{
		$arr[$value->id] = $value->id;
	}
	
	if(count($categories) && is_array($categories))
	{
		foreach($categories as $key=>$category)
		{
			if($key != 0 && isset($category->id) && !in_array($category->id, $arr))
			{
				$cate = new stdClass();
				$cate->id = $category->id;
				$cate->type = $category->type;
				$cate->title = $category->title;
				$cate->slug = $category->slug;
				$cate->parent_id = $category->parent_id;
				$cate->description = $category->description;
				$cate->meta_title = $category->meta_title;
				$cate->meta_keyword = $category->meta_keyword;
				$cate->meta_description = $category->meta_description;
				$cate->image = $category->image;
				$cate->published = $category->published;
				$cate->order = $category->order;
				$cate->created = $category->created;
				$cate->params = $category->params;
				$cate->language = $category->language;
				$cate->level = $category->level;
				$cate->layout = $category->layout;
				$catedata[] = $cate;
			}
		}
	}
	return $catedata;
}

function htmlTag($str, $tags = '<style><center><table><tr><td><label><a><p><h1><h2><h3><h4><h5><h6><img><strong><div><ul><li><b><br><i><u><i><span><button><input><select>')
{
	if ($str == '') return '';
	
	$str = strip_tags($str, $tags);
	
	$search = array('/onmouseover=(.*)/s', '/onchange=(.*)>/i', '/onclick=(.*)>/i', '/onmouseout=(.*)>/i', '/onload=(.*)>/i', '/onkeydown=(.*)>/i'); 
	$replace = array('', '', '', '', ''); 
	$str = preg_replace($search, $replace, $str);

	return $str;
}

function saveField($data = array(), $id = '')
{
	$CI =& get_instance();
	$CI->load->model('users_m');
	$CI->users_m->_table_name = 'fields_value';
	if($id != '')
		$CI->users_m->save($data, $id);
	else
		$CI->users_m->save($data);		
}

// show css of modules
function getCss($data, $type = '')
{
	$elm = $data->key;
	$params = json_decode($data->params);
	
	//echo '<pre>'; print_r($params); exit;
	
	$color = '';
	if (isset($params->fontColor) && $params->fontColor != '') $color = 'color:#'.$params->fontColor.';';
	
	$margin	= '';
	if(isset($params->margin) && is_object($params->margin))
	{
		foreach($params->margin as $key => $value)
		{
			if ($value != '') $margin .= 'margin-'.$key.':'.$value.'px;';
		}
	}
	
	$padding	= '';
	if(isset($params->padding) && is_object($params->padding))
	{
		foreach($params->padding as $key => $value)
		{
			if ($value != '') $padding .= 'padding-'.$key.':'.$value.'px;';
		}
	}
	if (!isset($params->borderColor) || $params->borderColor == '') $borderColor = 'FFFFFF';
	else $borderColor = $params->borderColor;
	
	if (!isset($params->borderStyle) || $params->borderStyle == 'defaults') $borderStyle = 'solid';
	else $borderStyle = $params->borderStyle;
	
	$border	= '';
	if(isset($params->border) && is_object($params->border))
	{
		foreach($params->border as $key => $value)
		{
			if ($value != '') $border .= 'border-'.$key.':'.$value.'px '.$params->borderStyle.' #'.$borderColor.';';
		}
	}
	
	$background	= '';
	if (isset($params->background->color) && $params->background->color != '') $background .= 'background-color:#'.$params->background->color.';';
	if (isset($params->background->image) && $params->background->image != '') $background .= 'background-image:url("'.$params->background->image.'");';
	if (isset($params->background->image) && $params->background->image != '') $background .= 'background-image:url("'.$params->background->image.'");';
	if (isset($params->background->style) && $params->background->style != '' && $params->background->style != 'Defaults') $background .= 'background-repeat:'.$params->background->style.';';
	
	if ($type == 'row')
	{
		$css = '.module-'.$elm.'{'.$margin.$padding.$border.$background.$color.'}';
	}
	else
	{
		$css = '.module-margin.module-'.$elm.'{'.$margin.'}';
		$css .= '.module-'.$elm.' .module-border{'.$border.'}';
		$css .= '.module-'.$elm.' .module-padding{'.$padding.'}';
		$css .= '.module-'.$elm.' .module-content{'.$background.'}';
		
		$css = '<style>'.$css.'</style>';
	}
	
	return $css;
}

function getSettings($email = '')
{
	$CI =& get_instance();
	$query = $CI->db->get('settings');
	return json_decode($query->row()->settings);
}

function getEmail($email = '')
{
	$CI =& get_instance();
	$query = $CI->db->get('settings');
	$setting = json_decode($query->row()->settings);
	if(isset($setting->admin_email) && $setting->admin_email != '')
		return $setting->admin_email;
	else
		return $email;
}

function getSiteName($site_name = '')
{
	$CI =& get_instance();
	$query = $CI->db->get('settings');
	$setting = json_decode($query->row()->settings);
	if(isset($setting->site_name) && $setting->site_name != '')
		return $setting->site_name;
	else
		return $site_name;
}

function getField($form = '', $object = '', $field_id)
{
	$CI =& get_instance();
	$CI->db->where('field_id', $field_id);
	$CI->db->where('form_field', $form);
	$CI->db->where('object', $object);
	$query = $CI->db->get('fields_value');
	return $query->row()->value;
}

function svgJs($document){ 
	$search = array('@<script[^>]*?>.*?</script>@si', '@onkeydown=.*?[ ]@si', '@onclick=.*?[ ]@si', '@onmouseover=.*?[ ]@si', '@onchange=.*?[ ]@si', '@onmouseout=.*?[ ]@si', '@onload=.*?[ ]@si'); 
	$text = preg_replace($search, '', $document); 
	return $text; 
}

// get url of image in clipart
function imageArt($art)
{	
	$url  = site_url('media/cliparts');
	$image = str_replace($art->file_name, '', $art->fle_url);
	
	$images = new stdClass();
	$images->thumb  	= $url .'/'. $image . 'thumbs/' . md5($art->clipart_id) .'.png';
	$images->medium 	= $url .'/'. $image .'medium/' . md5($art->clipart_id.'medium') .'.png';
	
	return $images;
}

function setParams($params = array(), $field1 = '', $field2 = '')
{
	if($field2 != '')
	{
		if(isset($params[$field1][$field2]))
			$default = $params[$field1][$field2];
		else
			$default = '';
	}
	else
	{
		if(isset($params[$field1]))
			$default = $params[$field1];
		else
			$default = '';
	}
	return $default;
}

function categoriesToTree($categories, $cate_id = 0)
{

    $map = array();	

    foreach ($categories as $category) {
        $category->subcategories = array();
        $map[$category->id] = $category;
    }
    foreach ($categories as $category) {		
        $map[$category->parent_id]->subcategories[] = $category;
    }
	if (isset($map[$cate_id]))
		return $map[$cate_id]->subcategories;
	else
		return array();
}

function dispayCateTree($categories, $level = 0, $cate_checked = array() , $remove_id = '')
{
	if (!is_array($categories) OR empty($categories)) return '';
	
	$html = '';
	
	if(count($categories))
	{
		foreach($categories as $category)
		{	
			if($category->id != $remove_id)
			{
				$checked = '';
				if( in_array($category->id, $cate_checked) ) $checked = 'selected="selected"';				
				
				$html .= '<option '.$checked.' value="'.$category->id.'">'. str_repeat('&emsp;', $level) .str_repeat(' ', $level). $category->title . '</option>';
				
				if(count($category->subcategories) > 0)
				{
					$html .= dispayCateTree($category->subcategories, $level + 1, $cate_checked, $remove_id);
				}
			}
		}
	}
	return $html;
}

function dispayTree($categories, $level = 0, $options = array('type'=>'checkbox', 'name'=>'category'), $cate_checked = array() )
{
	if (!is_array($categories) OR empty($categories)) return '';
	
	$html = '';
	
	if(count($categories))
	{
		foreach($categories as $category)
		{	
			$checked = '';
			if($options['type'] == 'checkbox')
			{
				if( in_array( $category->id, $cate_checked) ) $checked = 'checked="checked"';			
				
				$html .= str_repeat('&emsp;&emsp;', $level) .'<input type="checkbox" '.$checked.' name="'.$options['name'].'" value="'.$category->id.'"/> '. $category->title . '<br />';
			}
			else if($options['type'] == 'select')
			{
				if( in_array($category->id, $cate_checked) ) $checked = 'selected="selected"';				
				
				$html .= '<option '.$checked.' value="'.$category->id.'">'. str_repeat('&emsp;', $level) .str_repeat('- ', $level). $category->title . '</option>';
			}
			
			if(count($category->subcategories) > 0)
			{
				$html .= dispayTree($category->subcategories, $level + 1, $options, $cate_checked);
			}
		}
	}
	return $html;
}

function dispayListCate($categories, $level = 0, $link = 'categories/')
{
	if (!is_array($categories) OR empty($categories)) return '';
	
	$html = '';
	
	if(count($categories))
	{
		$cate_id = array();
		foreach($categories as $category)
		{
			if($link.$category->id.'-'.$category->slug == uri_string())
			{
				$icon = '<span class="glyphicon glyphicon-minus" onclick="module_show_list_cate(this);"></span>';
				$style = 'style="display: block"';
				$active = 'class="active"';
			}else
			{
				$icon = '<span class="glyphicon glyphicon-plus" onclick="module_show_list_cate(this);"></span>';
				$style = 'style="display: none"';
				$active = '';
			}
			
			if($level == 0)
			{
				if(count($category->subcategories) > 0)
					$html .= '<li '.$active.'>'.$icon.'<a href="'.site_url().$link.$category->id.'-'.$category->slug.'">' . $category->title . '</a>';
				else
					$html .= '<li '.$active.'><a href="'.site_url().$link.$category->id.'-'.$category->slug.'">'. $category->title . '</a>';
				
				if(count($category->subcategories) > 0)
				{
					$html .= '<ul '.$style.' class="nav nav-list">';
					$html .= dispayListCate($category->subcategories, $level, $link);
					$html .= '</ul>';
				}
				$html .= '</li>';
			}
			else if($category->id == $level || $category->parent_id == $level || in_array($category->parent_id, $cate_id))
			{
				$cate_id[] = $category->id;
				if(count($category->subcategories) > 0)
					$html .= '<li>'.$icon.'<a href="'.site_url().$link.$category->id.'-'.$category->slug.'">'. $category->title . '</a>';
				else
					$html .= '<li><a href="'.site_url().$link.$category->id.'-'.$category->slug.'">'. $category->title . '</a>';
				
				if(count($category->subcategories) > 0)
				{
					$html .= '<ul '.$style.'>';
					$html .= dispayListCate($category->subcategories, $level, $link);
					$html .= '</ul>';
				}
				$html .= '</li>';
			}
			else
			{
				$html .= dispayListCate($category->subcategories, $level, $link);
			}
		}
	}
	return $html;
}

function dispayThumbCate($categories, $level = 0, $show = 'no', $link = 'categories/')
{
	if (!is_array($categories) OR empty($categories)) return '';
	
	$html = '';
	
	if(count($categories))
	{
		$cate_id = array();
		foreach($categories as $category)
		{
			if ($category->image == '')
			{
				$category->image = base_url('assets/images/default.png');
			}
			else
			{
				$category->image = base_url($category->image);
			}
			
			if($link.$category->id.'-'.$category->slug == uri_string())
				$style = 'style="background: #f1f1f1; border: 1px solid #428bca;"';
			else
				$style = '';
			
			if($show == 'yes')
			{
				if($level == 0)
				{
					$html .= '<li><a href="'.site_url().$link.$category->id.'-'.$category->slug.'"><img '.$style.' class="img-thumbnail" src="'.$category->image.'" alt="'.$category->title.'"/></a></li>';
				}
				else if($category->id == $level)
				{
					$html .= '<li><a href="'.site_url().$link.$category->id.'-'.$category->slug.'"><img '.$style.' class="img-thumbnail" src="'.$category->image.'" alt="'.$category->title.'"/></a></li>';
				}
				else
				{
					$html .= dispayThumbCate($category->subcategories, $level, $show, $link);
				}
			}
			else
			{
				if($level == 0)
				{
					$html .= '<li><a href="'.site_url().$link.$category->id.'-'.$category->slug.'"><img '.$style.' class="img-thumbnail" src="'.$category->image.'" alt="'.$category->title.'"/></a></li>';
					
					if(count($category->subcategories) > 0)
					{
						$html .= dispayThumbCate($category->subcategories, $level, $show, $link);
					}
				}
				else if($category->id == $level || $category->parent_id == $level || in_array($category->parent_id, $cate_id))
				{
					$cate_id[] = $category->id;
					$html .= '<li><a href="'.site_url().$link.$category->id.'-'.$category->slug.'"><img '.$style.' class="img-thumbnail" src="'.$category->image.'" alt="'.$category->title.'"/></a></li>';
					
					if(count($category->subcategories) > 0)
					{
						$html .= dispayThumbCate($category->subcategories, $level, $show, $link);
					}
				}
				else
				{
					$html .= dispayThumbCate($category->subcategories, $level, $show, $link);
				}
			}
		}
	}
	return $html;
}

// group display categories manager in admin.

function groupCategories($categories = array(), $catedata = array(), $level = 0)
{
	if (!is_array($categories) OR empty($categories)) return '';
	
	if(count($categories))
	{
		foreach($categories as $category)
		{	
			$cate = new stdClass();
			$cate->id = $category->id;
			$cate->type = $category->type;
			$cate->title = str_repeat('-- ', $level).$category->title;
			$cate->slug = $category->slug;
			$cate->parent_id = $category->parent_id;
			$cate->description = $category->description;
			$cate->meta_title = $category->meta_title;
			$cate->meta_keyword = $category->meta_keyword;
			$cate->meta_description = $category->meta_description;
			$cate->image = $category->image;
			$cate->published = $category->published;
			$cate->order = $category->order;
			$cate->created = $category->created;
			$cate->params = $category->params;
			$cate->language = $category->language;
			$cate->level = $category->level;
			$cate->layout = $category->layout;
			$catedata[] = $cate;
			
			if(count($category->subcategories) > 0)
			{
				$catedata = groupCategories($category->subcategories, $catedata, $level+1);
			}
		}
	}
	return $catedata;
}

// get children category.
function getChildCate($categories, $catedata = array())
{
	if (!is_array($categories) OR empty($categories)) return array();
	
	foreach($categories as $category)
	{
		$catedata[] = $category->id;
			
		if(count($category->subcategories) > 0)
		{
			$catedata = getChildCate($category->subcategories, $catedata);
		}
	}
	return $catedata;
}

function getPayment()
{
	$folder = opendir(ROOTPATH.DS.'application'.DS.'payments');
	$folder_payment = array();
	while (false !== ($foldername = readdir($folder))) {
		if($foldername != '.' && $foldername != '..'){
			$folder_payment[$foldername] = $foldername;
		}
	}
	return $folder_payment;
}

function createFile($data, $prefix = '', $filename = '', $file_url = '')
{
	$path = ROOTPATH .DS. 'media' .DS. 'assets' .DS. 'system';
	$CI = get_instance();
	if ($file_url == '')
	{
		$CI->load->library('file');
		$file 		= new file();
			
		$date 	= new DateTime();		
		$year	= $date->format('Y');
		$file->create($path .DS. $year, 0755);	
	
		$month 	= $date->format('m');
		$file->create($path .DS. $year .DS. $month, 0755);
		
		
		if ($filename == '')
			$file 		= $prefix .'_'. strtotime("now") . '.png';
		else
			$file 		= $prefix .'_'. $filename .'.png';
			
		$path_file	= $path .DS. $year .DS. $month .DS. $file;
		$file		= 'media/assets/system/'.$year .'/'. $month .'/'. $file;
	}
	else
	{
		$path_file	= $path .DS. str_replace('/', DS, $file_url);
	}
	
	$temp 		= explode(';base64,', $data);
	$buffer		= base64_decode($temp[1]);
	$CI->load->helper('file');
	
	if ( ! write_file($path_file, $buffer))
		return '';
	else
		return $file;
}

function add_meta_title ($string)
{
	$CI =& get_instance();
	$CI->data['meta_title'] = e($string) . ' - ' . $CI->data['meta_title'];
}

function settingPrint($setting, $type, $paper, $value = 0){
	if (empty($setting->prints))
		return $value;
	
	if (empty($setting->prints->$type))
		return $value;
	
	if (empty($setting->prints->$type->$paper))
		return $value;
		
	return $setting->prints->$type->$paper;
}

function settingValue($setting, $key, $value = '')
{
	if (isset($setting->$key))
		return $setting->$key;
	else
		return $value;
}

function getLang()
{
	$CI =& get_instance();
	$CI->db->where('published', 1);
	$query = $CI->db->get('languages');		
	$rows = $query->result();
	$lang = array();
	
	if(count($rows)){
		foreach($rows as $row)
		{
			$lang[$row->lang_code] = $row->title;
		}
	}
	
	return $lang;
}

function getCurrencies($published = 1, $fields = array())
{
	$CI =& get_instance();
	$CI->load->driver('cache');
	if (!$currencies = $CI->cache->file->get('currencies'))
	{
		$CI->db->where('published', $published);
		$query = $CI->db->get('currencies');		
		$currencies = $query->result();
		$CI->cache->file->save('currencies', $currencies, 300000);
	}
	
	if(count($fields))
	{
		$rows = array();
		$i = 0;
		foreach($currencies as $currency)
		{
			foreach($fields as $field)
			{
				$rows[$i][$field]	= $currency->$field;
			}
			$i++;
		}
		return $rows;
	}
	
	return $currencies;
}

function btn_edit ($uri)
{
	return anchor($uri, '<i class="icon-edit"></i>');
}

function btn_delete ($uri)
{
	return anchor($uri, '<i class="icon-remove"></i>', array(
		'onclick' => "return confirm('You are about to delete a record. This cannot be undone. Are you sure?');"
	));
}

function article_link($article){
	return 'article/' . intval($article->id) . '/' . e($article->slug);
}
function article_links($articles){
	$string = '<ul>';
	foreach ($articles as $article) {
		$url = article_link($article);
		$string .= '<li>';
		$string .= '<h3>' . anchor($url, e($article->title)) .  ' ›</h3>';
		$string .= '<p class="pubdate">' . e($article->pubdate) . '</p>';
		$string .= '</li>';
	}
	$string .= '</ul>';
	return $string;
}

function get_excerpt($article, $numwords = 50){
	$string = '';
	$url = article_link($article);
	$string .= '<h2>' . anchor($url, e($article->title)) .  '</h2>';
	$string .= '<p class="pubdate">' . e($article->pubdate) . '</p>';
	$string .= '<p>' . e(limit_to_numwords(strip_tags($article->body), $numwords)) . '</p>';
	$string .= '<p>' . anchor($url, 'Read more ›', array('title' => e($article->title))) . '</p>';
	return $string;
}

function limit_to_numwords($string, $numwords){
	$excerpt = explode(' ', $string, $numwords + 1);
	if (count($excerpt) >= $numwords) {
		array_pop($excerpt);
	}
	$excerpt = implode(' ', $excerpt);
	return $excerpt;
}

function e($string){
	return htmlentities($string);
}

function get_menu ($array, $child = FALSE)
{
	$CI =& get_instance();
	$str = '';
	
	if (count($array)) {
		$str .= $child == FALSE ? '<ul class="nav">' . PHP_EOL : '<ul class="dropdown-menu">' . PHP_EOL;
		
		foreach ($array as $item) {
			
			$active = $CI->uri->segment(1) == $item['slug'] ? TRUE : FALSE;
			if (isset($item['children']) && count($item['children'])) {
				$str .= $active ? '<li class="dropdown active">' : '<li class="dropdown">';
				$str .= '<a  class="dropdown-toggle" data-toggle="dropdown" href="' . site_url(e($item['slug'])) . '">' . e($item['title']);
				$str .= '<b class="caret"></b></a>' . PHP_EOL;
				$str .= get_menu($item['children'], TRUE);
			}
			else {
				$str .= $active ? '<li class="active">' : '<li>';
				$str .= '<a href="' . site_url($item['slug']) . '">' . e($item['title']) . '</a>';
			}
			$str .= '</li>' . PHP_EOL;
		}
		
		$str .= '</ul>' . PHP_EOL;
	}
	
	return $str;
}

/*Config settings send email*/
function configEmail($field, $params=array())
{
	$settingEmail = array(
		'sub_register'=>'Thank you for sign up',
		'register'=>'<p>Dear {username}!</p><p>Thank you register for tshirt</p><p>Your Login ID: {email}</p><p>Please Click <a target="_blank" href="{confirm_url}">here</a> to confirm account</p><p>Regards</p>',
		'sub_change_pass'=>'Change pass',
		'change_pass'=>'<p>Hi, {username}!</p><p>Please have change password.</p><p>Regards</p>',
		'sub_forget_pass'=>'Forgot password',
		'forget_pass'=>'<p>Hi, {username}!</p><p>Please click <a target="blank_" href="{confirm_url}">here</a> to change your password!</p><p>Regards</p>',
		'sub_save_design'=>'Saved Your Design',
		'save_design'=>'<p>Hi, {username}!</p><p>Thanks you use designer of shop. Please click <a target="_blank" href="{url_design}">here</a> to edit design.</p><p>Regards</p>',
		'sub_order_detai'=>'Buy product by shop',
		'order_detai'=>'<p>Thank you for order by shop</p><p>Order info:</p> {table}',
		'sub_order_status'=>'You have new order status',
		'order_status'=>'<p>Hi, {username}. </p><p>The status of your order number {order_number} is changed to {status}</p><p>Regards</p>',
	);

	$CI =& get_instance();
	$query = $CI->db->get('config_emails');
	$settings = $query->result();
	$res = '';
	$count = 0;
	
	for($i=0; $i<count($settings); $i++)
	{
		foreach($settings[$i] as $key=>$val)
		{
			if($key == 'label' && $val == $field)
			{
				$record = $val;
				$count = $i;
			}
			if(isset($record) && $key == 'message' && $count == $i)
			{
				$res = $val;
			}
			if($res != '')
				break;
		}
	}
	
	if($res != '')
	{
		foreach($params as $key=>$val)
		{
			$res = str_replace('{'.$key.'}', $val, $res);
		}
	}else
	{
		$res = $settingEmail[$field];
		foreach($params as $key=>$val)
		{
			$res = str_replace('{'.$key.'}', $val, $res);
		}
	}
	return $res;
}

/**
 * Dump helper. Functions to dump variables to the screen, in a nicley formatted manner.
 * @author Joost van Veen
 * @version 1.0
 */
if (!function_exists('dump')) {
    function dump ($var, $label = 'Dump', $echo = TRUE)
    {
        // Store dump in variable 
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        
        // Add formatting
        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
        $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">' . $label . ' => ' . $output . '</pre>';
        
        // Output
        if ($echo == TRUE) {
            echo $output;
        }
        else {
            return $output;
        }
    }
}


if (!function_exists('dump_exit')) {
    function dump_exit($var, $label = 'Dump', $echo = TRUE) {
        dump ($var, $label, $echo);
        exit;
    }
}
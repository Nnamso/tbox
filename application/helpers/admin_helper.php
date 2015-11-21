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

function perPage($value = 5)
{
	$number = array('5', '10', '15', '20', '25', '50', '70', '100', 'all');
	
	if(!in_array($value, $number))
		$value = 'all';
	
	$html = '<select name="per_page" onchange="document.adminForm.submit();" class="form-control">';
	
	foreach ($number as $n){
		if ($n == $value) $selected = 'selected="selected"';
		else $selected = '';
		$html .= '<option '.$selected.' value="'.$n.'">'.$n.'</option>';
	}
	$html .= '</select>';
	
	return $html;
}

function profile()
{	
	$CI = &get_instance();
	$CI->db->join('user_profiles', 'user_profiles.user_id = users.id');
	$CI->db->where('id', $CI->user['id']);
	$query = $CI->db->get('users');
	return $query->row();
}
?>
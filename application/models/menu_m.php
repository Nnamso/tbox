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

class Menu_m extends MY_Model
{
	public $_table_name = 'menu_type';
	public $_primary_key = 'id';
	
	public function getNew($type = 'items')
	{
		$data = new stdClass();
		if ($type == 'items')
		{
			$this->_table_name	= 'menus';
			$data->id			= 0;
			$data->title		= '';
			$data->attribute	= '';
			$data->url			= '';
			$data->subitem		= '';
			$data->html			= '';
			$data->options		= '';
			$data->published	= 1;
			$data->menu_type_id	= 0;
		}
		else
		{
			$this->_table_name	= 'menu_type';
			$data->id			= 0;
			$data->title		= '';
			$data->description	= '';
			$data->params		= '';
		}
		return $data;
	}
	
	public function remove($id)
	{
		$this->db->where('menu_type_id', $id);
		$this->db->delete('menus'); 
	}
}
	
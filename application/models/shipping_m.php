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

class Shipping_m extends MY_Model
{
	public $_table_name = 'shippings';
	public $_primary_key = 'id';
	public $_timestamps = False;
	
	public function getNew()
	{
		$ship = new stdClass();
		$ship->title = '';
		$ship->description = '';
		$ship->default = '';
		$ship->price = '';
		$ship->published = '';
		$ship->date = '';
		return $ship;
	}
	
	function getData($id = '')
	{	
		if($id == '')
		{
			$query = $this->db->get('shippings');
			return $query->result();
		}
		else
		{
			$this->db->where('id ', $id);
			$query = $this->db->get('shippings');
			return $query->row();
		}
	}
	
	public function checkData($data, $id = '')
	{
		$this->db->where('title', $data['title']);
        if($id != '')
			$this->db->where('id !=', $id);
		$query = $this->db->get('shippings');
		if($query->num_rows != '')
		   return false;
		else
		   return true;
    }
	
	function delete($id = '')
	{
		if($id != ''){
			$this->db->where('id ',$id);
			$this->db->where('default', 0);
			if($this->db->delete('shippings')) 
				return true; 
			else 
				return false;
		}else
		{
			return true;
		}
	}
	
	function shippingDefault($id = '')
	{
		if($id != ''){
			$data['default'] = 1;
			$this->db->where('id ',$id);
			if($this->db->update('shippings', $data))
				return true;
			else
				return false;
		}else
		{
			$this->db->where('default ', 1);
			$query = $this->db->get('shippings');
			return $query->row();
		}
	}
}
?>
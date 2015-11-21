<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * payment
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_m extends MY_Model
{
	public $_table_name = 'payments';
	public $_primary_key = 'id';
	public $_timestamps = False;
	
	public function getNew()
	{
		$pay = new stdClass();
		$pay->title = '';
		$pay->description = '';
		$pay->default = '';
		$pay->configs = '[]';
		$pay->published = '';
		$pay->date = '';
		return $pay;
	}
	
	function getData($id = '')
	{	
		if($id == ''){
			$query = $this->db->get('payments');
			return $query->result();
		}else
		{
			$this->db->where('id ', $id);
			$query = $this->db->get('payments');
			return $query->row();
		}
	}
	
	public function checkData($data, $id = '')
	{
		$this->db->where('title', $data['title']);
        if($id != '')
			$this->db->where('id !=', $id);
		$query = $this->db->get('payments');
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
			if($this->db->delete('payments')) 
				return true; 
			else 
				return false;
		}else
		{
			return true;
		}
	}
	
	function paymentDefault($id = '')
	{
		if($id != ''){
			$data['default'] = 1;
			$this->db->where('id ',$id);
			if($this->db->update('payments', $data))
				return true;
			else
				return false;
		}else
		{
			$this->db->where('default ', 1);
			$query = $this->db->get('payments');
			return $query->row();
		}
	}
}
?>
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

class Coupon_m extends MY_Model
{
	
	public $_table_name = 'coupon';
	public $_order_by = 'name';
	public $_primary_key = 'id';

	function __construct ()
	{
		parent::__construct();
	}

	public function getCoupons($count = false, $search = '', $option = '', $number = '', $segment = '')
	{
		if($option == 'name')
		{
			$this->db->like('name', $search);
		}
		
		if($option == 'date')
		{
			$this->db->like('start_date', $search);
		}
		
		$this->db->order_by('start_date', 'DESC');
		if($count == true)
		{
			$query = $this->db->get('coupon');
			return count($query->result());
		}else
		{
			$query = $this->db->get('coupon', $number, $segment);
			return $query->result();
		}
	}
	
	public function getCoupon($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('coupon');
		return $query->row();
	}
	
	public function delete($id)
	{
		$this->db->where('id', $id);
		if($this->db->delete('coupon'))
			return true;
		else
			return false;
	}
	
	public function getNew()
	{
		$data = new stdClass();
		$data->name = '';
		$data->code = '';
		$data->value = '';
		$data->discount_type = 't';
		$data->coupon_type = '';
		$data->minimum = '';
		$data->default = '';
		$data->start_date = '';
		$data->end_date = '';
		return $data;
	}
}
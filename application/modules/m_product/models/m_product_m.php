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

class M_Product_m extends MY_Model
{
	public $_table_name = 'modules';
	public $_primary_key = 'id';
	
	function __construct ()
	{
		parent::__construct();
		$this->db = $this->load->database('', true);
	}
	
	public function getProducts($count, $type)
	{
		if($type == 'lastest')
			$this->db->order_by('created', 'DESC');
		else if($type == 'future')
			$this->db->where('future', 1);
		else if($type == 'sale_price')
			$this->db->where('sale_price !=', 0);
		$this->db->where('published', 1);
		$this->db->limit($count);
		$query = $this->db->get('products');
		return $query->result();
	}
	
	public function getMProducts($count = false, $number = '', $segment = '')
	{
		$this->db->where('type', 'm_product');
		$this->db->order_by('title', 'ASC');
		if($count == true)
		{
			$query = $this->db->get('modules');
			return count($query->result());
		}else
		{
			$query = $this->db->get('modules', $number, $segment);
			return $query->result();
		}
	}
	
	public function getM_product($id = '')
	{
		$this->db->where('id', $id);
		$this->db->where('type', 'm_product');
		$query = $this->db->get('modules');
		return $query->row();
	}
	
	public function getNew()
	{
		$m_product = new stdClass();
		$m_product->title = '';
		$m_product->content = '[]';
		$m_product->options = '[]';
		$m_product->params = '[]';
		return $m_product;
	}
	
	public function delete($id = '')
	{
		$this->db->where('id', $id);
		$this->db->where('type', 'm_product');
		if($this->db->delete('modules'))
			return true;
		else
			return false;
	}
}
?>
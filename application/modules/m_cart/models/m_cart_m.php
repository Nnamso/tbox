<?php
/**
 * @author 9File - www.9file.net
 * @date: 2015-01-10
 * 
 * Save m_cart html, Get m_cart html data.
 * 
 * @copyright  Copyright (C) 2015 9file.net. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Cart_m extends MY_Model
{
	public $_table_name = 'modules';
	public $_primary_key = 'id';
	
	function __construct ()
	{
		parent::__construct();
		$this->db = $this->load->database('', true);
	}
	
	public function getMCarts($count = false, $number = '', $segment = '')
	{
		$this->db->where('type', 'm_cart');
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
	
	public function getMCart($id = '')
	{
		$this->db->where('id', $id);
		$this->db->where('type', 'm_cart');
		$query = $this->db->get('modules');
		return $query->row();
	}
	
	public function getNew()
	{
		$m_cart = new stdClass();
		$m_cart->title = '';
		$m_cart->content = '[]';
		$m_cart->options = '';
		$m_cart->params = '[]';
		return $m_cart;
	}
	
	public function delete($id = '')
	{
		$this->db->where('id', $id);
		$this->db->where('type', 'm_cart');
		if($this->db->delete('modules'))
			return true;
		else
			return false;
	}
}
?>
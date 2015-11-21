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

class Layout_m extends MY_Model
{
	
	public $_table_name 	= 'layout';
	protected $_order_by 	= 'id';
	public $_primary_key 	= 'id';

	function __construct ()
	{
		parent::__construct();
	}

	public function getLayouts($group = '')
	{
		$this->db->select('id, title, layout');
		if ($group != '')
		{
			if (is_string($group))
			{
				$this->db->like('layout', $group . '/', 'after');
			}
			else if(is_array($group))
			{
				for($i=0; $i<count($group); $i++)
				{
					$this->db->or_like('layout', $group[$i] . '/', 'after');
				}
			}
		}
		
		$query = $this->db->get('layout');
		return $query->result();
	}
	
	// get product layout
	// Input: product id
	public function getProductPage($id, $obj = 'products')
	{
		$this->db->select('layout.layout, html');
		$this->db->from('layout');
		$this->db->join($obj, "layout.id = $obj.layout");
		$this->db->where($obj.'.id', $id);

		$query = $this->db->get();
		
		$row = $query->result();
		
		if (count($row) == 0)
			return '';
		else
			return $row[0]->html;
	}
	
	public function getNew()
	{
		$data = new stdClass();
		
		$data->id					= 0;
		$data->title				= '';
		$data->layout				= '';
		$data->default				= 0;
		$data->content				= '';
		$data->description			= '';
		$data->published			= 1;
		$data->params				= '';
		
		return $data;
	}
	
	public function getUsersGroup($group = '')
	{
		$this->db->where('group', $group);
		$query = $this->db->get('users');
		return $query->result();
	}
}
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

class Design_M extends MY_Model
{
	
	protected $_table_name = 'users_designs';
	protected $_order_by = 'created';
	protected $_timestamps = true;
	
	function __construct ()
	{
		parent::__construct();
	}
	
	// get all design
	public function getDesigns($count = false, $number, $segment, $search='', $o_search='')
	{
		$this->db->select('users_designs.id, users_designs.design_id, users_designs.user_id, users.name, products.title, users_designs.product_id, users_designs.product_options, users_designs.teams, users_designs.image, users_designs.created');
		$this->db->join('users', 'users.id = users_designs.user_id');		
		$this->db->join('products', 'products.id = users_designs.product_id');
		
		if($o_search == 'design' && $search != '')
		{
			$this->db->like('users_designs.design_id', $search);
		}
		elseif($o_search == 'user' && $search != '')
		{			
			$this->db->like('users.username', $search);
		}
		elseif($o_search == 'product' && $search != '')
		{
			$this->db->like('products.title', $search);
		}
		$this->db->order_by('users_designs.created', 'DESC');
		
		if($count == true)
		{
			$query = $this->db->get('users_designs');
			return count($query->result());
		}
		else
		{
			$query = $this->db->get('users_designs', $number, $segment);
			return $query->result();
		}
	}
	
	public function getDesign($options)
	{
		$design = $this->get_by($options, TRUE);
		
		return $design;
	}
	
	public function getUserDesigns($user_id)
	{
		$this->db->where('user_id', $user_id);		
		
		return parent::get();
	}
	
	public function removeUserDesign($designer_id, $id)
	{
		$options = array(
			'id'=>$id,
			'user_id'=>$designer_id			
		);
		
		return $this->db->delete('users_designs', $options); 
	}
}
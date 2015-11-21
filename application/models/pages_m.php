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

class Pages_m extends MY_Model
{
	
	public $_table_name 	= 'pages';
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
			elseif(is_array($group))
			{
				for($i=0; $i<count($group); $i++)
				{
					$this->db->or_like('layout', $group[$i] . '/', 'after');
				}
			}
		}
		
		$query = $this->db->get('pages');
		return $query->result();
	}
	
	public function getNew()
	{
		$data = new stdClass();
		
		$data->id					= 0;
		$data->title				= '';		
		$data->slug					= '';		
		$data->content				= '';
		$data->meta_title			= '';
		$data->meta_keywords		= '';
		$data->meta_description		= '';
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
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

class Tab_m extends MY_Model
{
	public $_table_name = 'modules';
	public $_primary_key = 'id';
	
	function __construct ()
	{
		parent::__construct();
		$this->db = $this->load->database('', true);
	}
	
	public function getTabs($count = false, $number = '', $segment = '')
	{
		$this->db->order_by('title', 'ASC');
		$this->db->where('type', 'tab');
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
	
	public function getTab($id = '')
	{
		$this->db->where('id', $id);
		$this->db->where('type', 'tab');
		$query = $this->db->get('modules');
		return $query->row();
	}
	
	public function getNew()
	{
		$tab = new stdClass();
		$tab->title = '';
		$tab->content = '[]';
		$tab->options = '';
		$tab->params = '[]';
		return $tab;
	}
	
	public function delete($id = '')
	{
		$this->db->where('id', $id);
		$this->db->where('type', 'tab');
		if($this->db->delete('modules'))
			return true;
		else
			return false;
	}
}
?>
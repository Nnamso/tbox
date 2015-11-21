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

class popup_m extends MY_Model
{
	public $_table_name = 'modules';
	public $_primary_key = 'id';
	
	function __construct ()
	{
		parent::__construct();
		$this->db = $this->load->database('', true);
	}
	
	public function getPopups($count = false, $number = '', $segment = '')
	{
		$this->db->where('type', 'popup');
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
	
	public function getPopup($id = '')
	{
		$this->db->where('id', $id);
		$this->db->where('type', 'popup');
		$query = $this->db->get('modules');
		return $query->row();
	}
	
	public function getNew()
	{
		$popup = new stdClass();
		$popup->title = '';
		$popup->content = '';
		$popup->options = '[]';
		$popup->params = '[]';
		return $popup;
	}
	
	public function delete($id = '')
	{
		$this->db->where('id', $id);
		$this->db->where('type', 'popup');
		if($this->db->delete('modules'))
			return true;
		else
			return false;
	}
}
?>
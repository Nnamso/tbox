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

class M_Slider_m extends MY_Model
{
	public $_table_name = 'modules';
	public $_primary_key = 'id';
	
	function __construct ()
	{
		parent::__construct();
		$this->db = $this->load->database('', true);
	}
	
	public function getSliders($count = false, $number = '', $segment = '')
	{
		$this->db->where('type', 'slider');
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
	
	public function getslider($id = '')
	{
		$this->db->where('id', $id);
		$query = $this->db->get('modules');
		return $query->row();
	}
	
	public function getNew()
	{
		$slider = new stdClass();
		$slider->title = '';
		$slider->content = '[]';
		$slider->options = '[]';
		$slider->params = '[]';
		return $slider;
	}
}
?>
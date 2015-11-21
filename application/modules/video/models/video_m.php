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

class Video_m extends MY_Model
{
	public $_table_name = 'modules';
	public $_primary_key = 'id';
	
	function __construct ()
	{
		parent::__construct();
		$this->db = $this->load->database('', true);
	}
	
	public function getvideos($count = false, $number = '', $segment = '')
	{
		$this->db->where('type', 'video');
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
	
	public function getvideo($id = '')
	{
		$this->db->where('id', $id);
		$this->db->where('type', 'video');
		$query = $this->db->get('modules');
		return $query->row();
	}
	
	public function getNew()
	{
		$video = new stdClass();
		$video->title = '';
		$video->content = '[]';
		$video->options = '';
		$video->params = '[]';
		return $video;
	}
	
	public function delete($id = '')
	{
		$this->db->where('id', $id);
		$this->db->where('type', 'video');
		if($this->db->delete('modules'))
			return true;
		else
			return false;
	}
}
?>
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

class Fonts_m extends MY_Model
{
	public $_table_name = 'fonts';
	public $_primary_key = 'id';
	public $_order_by = 'title asc';
		
	public function getNew()
	{
		$font = new stdClass();
		$font->title 		= '';			
		$font->type 		= '';			
		$font->filename 	= '';
		$font->thumb 		= '';
		$font->published 	= 1;
		$font->path 		= '';
		$font->subtitle 	= '';
		$font->cate_id 		= '';
		return $font;
	}
	
	public function getFonts($count = false, $search = '', $cate = '', $number = '', $offset = '')
	{	
		$this->db->select('fonts.title, categories.title as catename, filename, thumb, fonts.published, fonts.id, fonts.type, path, cate_id');
		$this->db->join('categories', 'categories.id = fonts.cate_id');
		
		if($search != '')
			$this->db->like('fonts.title', $search);
			
		if($cate != '')
			$this->db->where('categories.id', $cate);
		
		if($count == TRUE)
		{
			$query = $this->db->get('fonts');
			return count($query->result());
		}
		else
		{
			$query = $this->db->get('fonts', $number, $offset);
			return $query->result();
		}
	}
	
	public function getFont($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('fonts');
		return $query->row();
	}
	
	public function getCategories()
	{
		$this->db->where('type', 'font');
		$query = $this->db->get('categories');
		return $query->result();
	}	
	
	public function checkCate($title, $id = '')
	{
		if($id != '')
			$this->db->where('id !=', $id);
			
		$this->db->where('title', $title);
		$this->db->where('type', 'font');
		$query = $this->db->get('categories');
		if($query->num_rows() > 0)
			return true;
		else
			return false;
	}
	
	public function delete($id)
	{
		$this->db->where('id', $id);
		if($this->db->delete($this->_table_name))
			return true;
		else
			return false;
	}
}
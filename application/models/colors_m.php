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

class Colors_m extends MY_Model {
    public $_table_name     = 'colors';
    public $_order_by       = 'title asc';
    public $_primary_key    = 'id';
	
	public function getColors($count = false, $search = '', $number = 10000, $offset = 0)
	{
        if($search != '')
			$this->db->like('title', $search);
			
		$this->db->order_by('title', 'ASC');
			
        if($count == TRUE){
			$query = $this->db->get('colors');
			return count($query->result());
        }else{
            $query = $this->db->get('colors', $number, $offset);
            return $query->result();
        }
    }
	
	public function getNew()
	{
		$color = new stdClass();
		$color->hex = '';
		$color->title = '';
		$color->type = '';
		$color->lang_code = '';
		$color->published = '';
		return $color;
	}
	
	public function getData($id)
	{
		$this->db->like('id', $id);
		$query = $this->db->get('colors');
		return $query->row();
	}
	
	public function checkData($data, $id = '')
	{
		if(isset($data['title']))
		{
			if($id != '')
				$this->db->where('id !=', $id);
				
			$this->db->where('title', $data['title']);
			$query = $this->db->get('colors');
			if($query->num_rows() > 0)
				return false;
			else
				return true;
		}else{
			return false;
		}
	}
	
	public function delete($id)
	{
		$this->db->where('id', $id);
		if($this->db->delete('colors'))
			return true;
		else
			return false;
	}
}
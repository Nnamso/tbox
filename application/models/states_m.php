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


class States_m extends MY_Model {

    protected $_table_name = 'states';
    protected $_primary_key = 'id';
    protected $_order_by = 'name asc';

    function __construct() {
        parent::__construct();
    }

    function getData($id = '') {
        if ($id != '') {
            $this->db->where($this->_primary_key, $id);
            $query = $this->db->get($this->_table_name);
            return $query->row();
        }
    }
	
	public function getCountries()
	{
		$query = $this->db->get('country');
		return $query->result();
	}

    public function getStates($count = false, $search = '', $number = '', $segment = '') 
	{
        if($search != '')
			$this->db->like('name', $search);
			
		$this->db->order_by('name', 'ASC');
		
		if($count == true)
		{
			$query = $this->db->get('states');
			return count($query->result());
		}else
		{
			$query = $this->db->get('states', $number, $segment);
			return $query->result();
		}
    }
	
	public function getNew()
	{
		$country = new stdClass();
		$country->id = '';
		$country->country_id = '';
		$country->name = '';
		$country->code = '';
		$country->published = '';
		return $country;
	}

    function checkData($data, $id = '') 
	{
		/*
        if ($id != '') 
            $query = $this->db->query('SELECT * FROM `dg_states` WHERE (`id` != \''.$id.'\' AND (`name` = \''.$data['name'].'\' OR `code` = \''.$data['code'].'\'))');
		else
            $query = $this->db->query('SELECT * FROM `dg_states` WHERE (`name` = \''.$data['name'].'\' OR `code` = \''.$data['code'].'\')');
			
		if ($query->num_rows() > 0)
			return false;
		else
			return true;
		*/
		return true;
    }

    function delete($id = '') 
	{
		$this->db->where('id ', $id);
		if ($this->db->delete('states'))
			return true;
		else
			return false;
    }

}

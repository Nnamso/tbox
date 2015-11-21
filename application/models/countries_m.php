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

class Countries_m extends MY_Model {

    protected $_table_name = 'country';
    protected $_primary_key = 'id';
    protected $_order_by = 'name asc';

    function __construct() {
        parent::__construct();
    }

    function getData($id = null) {
        if ($id != NULL) {
            $this->db->where($this->_primary_key, $id);
            $query = $this->db->get($this->_table_name);
            return $query->row();
        }
    }

    public function getCountries($count = false, $search = '', $number = '', $segment = '') {
        if($search != '')
			$this->db->like('name', $search);
			
		$this->db->order_by('name', 'ASC');
		
		if($count == true)
		{
			$query = $this->db->get('country');
			return count($query->result());
		}else
		{
			$query = $this->db->get('country', $number, $segment);
			return $query->result();
		}
    }
	
	public function getNew()
	{
		$country = new stdClass();
		$country->id = '';
		$country->name = '';
		$country->code_2 = '';
		$country->code_3 = '';
		$country->published = '';
		return $country;
	}

    function checkData($data, $id = '') 
	{
        if ($id != '') 
            $query = $this->db->query('SELECT * FROM `dg_country` WHERE (`id` != \''.$id.'\' AND (`name` = \''.$data['name'].'\' OR `code_2` = \''.$data['code_2'].'\' OR `code_3` = \''.$data['code_3'].'\'))');
		else
            $query = $this->db->query('SELECT * FROM `dg_country` WHERE (`name` = \''.$data['name'].'\' OR `code_2` = \''.$data['code_2'].'\' OR `code_3` = \''.$data['code_3'].'\')');
		
		if ($query->num_rows() > 0)
			return false;
		else
			return true;
    }

    function delete($id = '') 
	{
		$this->db->where('id ', $id);
		if ($this->db->delete('country'))
			return true;
		else
			return false;
    }

}

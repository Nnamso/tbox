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

class currencies_m extends MY_Model {

    public $_table_name 	= 'currencies';
    public $_order_by 		= 'currency_name';
    public $_primary_key 	= 'currency_id';
       
    public function getData($id = null)
	{
        if ($id != NULL) {
            $this->db->where($this->_primary_key, $id);
            $query = $this->db->get($this->_table_name);
            return $query->row();
        }
    }
	
	public function getNew()
	{
		$currency = new stdClass();
		$currency->currency_id = '';
		$currency->currency_name = '';
		$currency->currency_code = '';
		$currency->currency_symbol = '';
		$currency->published = '';
		return $currency;
	}
    
    public function getCurrencies($count = false, $search = '', $number = '', $offset = '')
	{
		$this->db->order_by($this->_order_by, 'ASC');
		if($search != '')
			$this->db->like('currency_name', $search);
			
        if($count == true)
		{
			$query = $this->db->get($this->_table_name);
            return count($query->result());
		}else
		{
			$query = $this->db->get($this->_table_name, $number, $offset);
            return $query->result();
		}
    }
    
    public function checkData($data, $id = null){
        if($id != NULL){
            $this->db->select('currency_id, currency_name, currency_code');
            $this->db->where('currency_code', $data['currency_code']);
            $this->db->where($this->_primary_key.' !=', $id);
            $this->db->or_where('currency_name', $data['currency_name']);
            $this->db->where($this->_primary_key.' !=', $id);
            $query = $this->db->get($this->_table_name);
            if($query->num_rows == ''){
                return true;
            }else{
                return false;
            }
        }else{
            $this->db->select('currency_name, currency_code');
            $this->db->where('currency_code', $data['currency_code']);
            $this->db->or_where('currency_name', $data['currency_name']);
            $query = $this->db->get($this->_table_name);
            if($query->num_rows != ''){
               return false;
            }else{
                return true;
            }
         }
    }
	function delete($id = Null){
		if($id != null){
			$this->db->where('currency_id ',$id);
			$query = $this->db->delete('currencies');
			if(!$query) return false; 
			else return true;
		}
		return true;
	}
}

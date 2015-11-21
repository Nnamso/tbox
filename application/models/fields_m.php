<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * Field
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fields_m extends MY_Model
{
	
	public $_table_name 	= 'fields_value';
	protected $_order_by 	= 'id';
	public $_primary_key 	= 'id';

	function __construct ()
	{
		parent::__construct();
	}
	
	// add fields
	function add($fields)
	{
		if ( count($fields) == 0)
			return;
			
		foreach( $fields as $field )
		{
			$this->db->select('id');
			$this->db->where('field_id', $field['field_id']);
			$this->db->where('form_field', $field['form_field']);
			$this->db->where('object', $field['object']);
			
			$row = $this->get();		
			
			if (count($row) == 0)
			{
				$this->save($field, null);
			}
			else
			{
				$this->save($field, $row[0]->id);
			}
		}
	}
	
	// get field
	public function getField($id)
	{
		$this->_table_name	= 'custom_fields';
		$this->db->select('title, type');
		$row 	= $this->get($id, true);
		
		if ( count($row) )
			return $row;
		else
			return '';
	}
	
	// get country
	public function getCountry($id)
	{
		$this->_table_name	= 'country';
		$this->db->select('name');
		$row 	= $this->get($id, true);
		
		if ( count($row) )
			return $row->name;
		else
			return '';
	}
	
	// get state
	public function getState($id)
	{
		$this->_table_name	= 'states';
		$this->db->select('name');
		$row 	= $this->get($id, true);
		
		if ( count($row) )
			return $row->name;
		else
			return '';
	}
	
	// get all object values
	public function getFiels($form, $obj)
	{
		$this->db->where('form_field', $form);
		$this->db->where('object', $obj);
		
		$rows = $this->get();		
			
		if (count($rows) == 0)
		{
			return false;
		}
		else
		{
			$profile = array();
			foreach($rows as $row)
			{
				$profile[$row->field_id]	= $row->value;
			}
			
			return $profile;
		}
	}
}
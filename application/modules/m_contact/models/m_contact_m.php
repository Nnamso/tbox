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

class M_Contact_m extends MY_Model
{
	public $_table_name = 'contact';
	public $_primary_key = 'id';
	
	function __construct ()
	{
		parent::__construct();
		$this->db = $this->load->database('', true);
	}
	
	public function getContacts($count = false, $number = '', $segment = '')
	{
		$this->db->order_by('title', 'ASC');
		if($count == true)
		{
			$query = $this->db->get('contact');
			return count($query->result());
		}else
		{
			$query = $this->db->get('contact', $number, $segment);
			return $query->result();
		}
	}
	
	public function getContact($id = '')
	{
		$this->db->where('id', $id);
		$query = $this->db->get('contact');
		return $query->row();
	}
	
	public function getNew()
	{
		$contact = new stdClass();
		$contact->title = '';
		$contact->subject = '';
		$contact->email = '';
		$contact->message = '';
		$contact->copy = '';
		$contact->params = '[]';
		return $contact;
	}
	
	public function getFormField($res)
	{
		$this->db->where('publish', 1);
		$this->db->like('forms', $res);
		$query = $this->db->get('custom_fields');
		return $query->result();
	}
}
?>
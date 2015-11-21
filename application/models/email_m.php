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

class Email_m extends MY_Model {
    public $_table_name     = 'config_emails';
    public $_order_by       = 'id desc';
    public $_primary_key    = 'id';
	
	public function getEmail()
	{
		$query = $this->db->get('config_emails');
		return $query->result();
	}
	
	public function update($data, $label)
	{
		$this->db->where('label', $label);
		if($this->db->update('config_emails', $data))
			return true;
		else
			return false;
	}
}
?>
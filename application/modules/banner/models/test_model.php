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

class test_model extends CI_model
{
	
	function __construct ()
	{
		parent::__construct();
		$this->db = $this->load->database();
	}
	
	public function absx($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('banner');
		return $query->row();
	}
	
	public function getBanner($id = '')
	{
		$this->db->where('id', $id);
		$query = $this->db->get('banner');
		return $query->row();
	}
}
?>
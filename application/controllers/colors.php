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

class Colors extends Frontend_Controller
{

	public function __construct ()
	{
		parent::__construct();
		
	}
	
	function index($f = null, $id = null)
	{	
		$this->db->where('published', 1);
		$query = $this->db->get('colors');
		
		$data['content'] = $query->result();
		$data['function'] = $f;
		$data['id'] = $id;
		
		$this->load->view('components/colors/index', $data);
	}
	
	function getColor($f = null, $id = null){		
		$this->db->where('published', 1);		
		$query 	= $this->db->get('colors');
		
		$data['content'] = $query->result();
		$data['function'] = $f;
		$data['id'] = $id;
		
		$this->load->view('components/colors/index', $data);
	}
}
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

class Setting extends Admin_Controller
{
	public function __construct ()
	{
		parent::__construct();
		
		$this->load->model('modules_m');
	}
	
	public function index()
	{		
		$this->edit();
	}

	public function edit($id = 0)
	{ 
		
		if($id == 0)
		{
			$module = $this->modules_m->get_new();
		}
		else
		{
			$module = $this->modules_m->get($id, true);		
		}
		
		$this->data['id'] 		= $id;		
		$this->data['module'] 	= $module;		
		
		$this->load->view('admin/setting', $this->data);
	}
	
	public function save($id = '')
	{
		$data 			= $this->input->post();
		
		$content 		= $this->modules_m->save_m('row', $data, $id);
		
		if($content['error'] == 0)
		{
			$content['element']		= 'row';
			$content['class_sfx']	= $data['options']['class_sfx'];
		}
		
		echo json_encode($content);
		exit;
	}
}
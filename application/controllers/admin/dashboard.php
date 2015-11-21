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

class Dashboard extends Admin_Controller {

	public function __construct ()
	{
		parent::__construct();
		$this->lang->load('user');		
		$this->user = $this->session->userdata('user');
	}
	
	public function index()
	{
		$this->data['meta_title'] = lang('dashboard_admin_meta_title');
		$this->data['breadcrumb'] = lang('dashboard_admin_breadcrumb');
		$this->data['sub_title'] = lang('dashboard_admin_sub_title');
		
		if(file_exists($this->session->flashdata('path_file_update')))
		{
			unlink($this->session->flashdata('path_file_update'));
		}
		
		$this->load->model('users_m');
		$this->data['count_users'] = $this->users_m->getCountUsers();
		$this->data['count_cliparts'] = $this->users_m->getCountCliparts();
		$this->data['count_products'] = $this->users_m->getCountProducts();
		$this->data['count_orders'] = $this->users_m->getCountOrders();
		
		$this->data['subview'] = 'admin/dashboard/index';
    	$this->load->view('admin/_layout_main', $this->data);
	}
}
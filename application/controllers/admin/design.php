<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * List all design saved
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Design extends Admin_Controller
{

	public function __construct ()
	{
		parent::__construct();
		
		// check user permission		
		$this->users_m->userPermission('design');
		
		$this->load->language('designer');
	}

	public function index ()
	{
		
		$this->data['breadcrumb'] = lang('designer_list');
        $this->data['meta_title'] = lang('designer_list');
        $this->data['sub_title'] = '';
		
		$this->load->model('design_m');
		
		// pagination
        $this->load->library('pagination'); 
        $this->load->helper('url');
        $config['base_url'] = base_url('admin/design/index'); 
		
		if($this->input->post('option'))
		{
			$this->session->set_userdata('search_design', $this->input->post('search'));
			$this->session->set_userdata('option_design', $this->input->post('option'));
		}
			
        $config['total_rows'] = $this->design_m->getDesigns(true, 0, 0, $this->session->userdata('search_design'), $this->session->userdata('option_design'));
		
		if ($this->input->post('option'))
		{
			if($this->input->post('per_page') == 'all')
				$this->session->set_userdata('per_page', $config['total_rows']);
			else
				$this->session->set_userdata('per_page', $this->input->post('per_page'));
		}
		
		if($this->session->userdata('per_page') != '')
			$config['per_page'] = $this->session->userdata('per_page');
		else
			$config['per_page'] 	= 10;
			
        $config['uri_segment'] = 4; 
        $config['next_link'] = lang('next'); 
        $config['prev_link'] = lang('prev'); 
        $config['first_link'] = lang('first'); 
        $config['last_link'] = lang('last'); 
        $config['num_links']	= 2;                 
        $this->pagination->initialize($config); 
        $this->data['links'] = $this->pagination->create_links();
		$this->data['per_page'] = $config['per_page'];
		$this->data['option'] = $this->session->userdata('option_design');
		$this->data['search'] = $this->session->userdata('search_design');			
		
		// Fetch all users
		$this->data['designs'] = $this->design_m->getDesigns(false, $config['per_page'], $this->uri->segment(4), $this->session->userdata('search_design'), $this->session->userdata('option_design'));
		
		// Load view
		$this->data['subview'] = 'admin/design/index';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function modal ()
	{
		
		$this->data['breadcrumb'] = lang('designer_list');
        $this->data['meta_title'] = lang('designer_list');
        $this->data['sub_title'] = '';
		
		$this->load->model('design_m');
		
		// pagination
		if($this->input->post('per_page'))
		{
			$this->session->set_userdata('search_design_m', $this->input->post('search'));
			$this->session->set_userdata('option_design_m', $this->input->post('option_s'));
		}
        $this->load->library('pagination'); 
        $this->load->helper('url');
        $config['base_url'] = base_url('admin/design/index'); 
        $config['total_rows'] = $this->design_m->getDesigns(true, 0, 0, $this->session->userdata('search_design_m'), $this->session->userdata('option_design_m'));
		
		if($this->input->post('per_page'))
		{
            if($this->input->post('per_page') == 'all'){
				$this->session->set_userdata('per_page', $config['total_rows']);
            }
			else
			{
				$this->session->set_userdata('per_page', $this->input->post('per_page'));
            }
        }
		
		if($this->session->userdata('per_page') != '')
			$config['per_page'] = $this->session->userdata('per_page');
		else
			$config['per_page'] = 5;
			
        $config['uri_segment'] = 4; 
        $config['next_link'] = lang('next'); 
        $config['prev_link'] = lang('prev'); 
        $config['first_link'] = lang('first'); 
        $config['last_link'] = lang('last'); 
        $config['num_links']	= 2;                 
        $this->pagination->initialize($config); 
        $this->data['links'] = $this->pagination->create_links();
		$this->data['per_page'] = $config['per_page'];
		$this->data['search'] = $this->session->userdata('search_design_m');
		$this->data['search_o'] = $this->session->userdata('option_design_m');			
		
		$this->data['designs'] = $this->design_m->getDesigns(false, $config['per_page'], $this->uri->segment(4), $this->session->userdata('search_design_m'), $this->session->userdata('option_design_m'));
		
		// Load view		
		$this->load->view('admin/design/modal', $this->data);
	}
	
	// remove design
	function delete($id = '')
	{
		$this->load->model('design_m');
		if((int) $id > 0)
		{
			$this->design_m->delete($id);			
		}
		else
		{
			$ids 	= $this->input->post('checkb');
			for($i=0; $i<count($ids); $i++)
			{
				$this->design_m->delete($ids[$i]);
			}			
		}
		$this->session->set_flashdata('msg', lang('designer_admin_delete_order_success_msg'));
		redirect(site_url('admin/design'));
	}
	
}
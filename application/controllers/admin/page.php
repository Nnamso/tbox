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


class Page extends Admin_Controller
{
	public function __construct ()
	{
		parent::__construct();
		
		// check user permission		
		$this->users_m->userPermission('page');

		$this->load->model('pages_m');
	}
	
	public function index ()
	{
		$this->data['breadcrumb'] 	= lang('page_title');
		$this->data['meta_title'] 	= lang('page_title');
		$this->data['sub_title'] 	= lang('page_title_sub');
		
		$data 						= $this->pages_m->get();
		$this->data['pages'] 		= $data;
		
		$this->data['subview'] 		= 'admin/page/index';
		
		$this->load->view('admin/_layout_main', $this->data);		
	}
	
	public function add($id = null)
	{
		$this->data['breadcrumb'] = lang('page_add');
		$this->data['meta_title'] = lang('page_add');
		$this->data['sub_title'] = lang('page_add_description');	

		// load data
		if ($id == null)
		{
			$page = $this->pages_m->getNew();
		}
		else
		{
			$page = $this->pages_m->get($id);			
		}		
		$this->data['page'] = $page;
		
		$this->data['subview'] = 'admin/page/add';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function save()
	{
		$data 				= $this->input->post('page');
		$page_id 			= $this->input->post('id');
		
		// save file layout
		$html 				= $this->input->post('file');
		
		$data['published'] 	= 1;
		$data['params'] 	= '';
		$data['html'] 		= $html;
		
		if ($data['slug'] == '')
			$data['slug'] = $data['title'];
			
		 $data['slug'] = url_title($data['slug'], '-', true);
		
		if ((int)$page_id > 0)
			$id 				= $this->pages_m->save($data, $page_id);
		else
			$id 				= $this->pages_m->save($data);
		
		redirect( site_url('admin/page/add/'.$id ) );
	}
	
	// copy a page
	public function copy()
	{
		$ids 	= $this->input->post('ids');
		
		$check = false;
		if (count($ids))
		{
			$data 			= $this->pages_m->get($ids[0]);
			
			if (count($data))
			{
				$check = true;
				
				$data->id 		= null;
				$data->title 	= $data->title .' copy';
				
				$data			= json_decode(json_encode($data), true);
				
				$this->pages_m->save($data);
			}
			
		}
		
		if ($check !== false)
		{
			$this->session->set_flashdata('success', lang('copy_data_success'));
		}
		else
		{
			$this->session->set_flashdata('success', lang('delete_data_false'));
		}
		
		redirect( site_url('admin/page/') );
	}
	
	// delete a page
	public function delete()
	{
		$ids 	= $this->input->post('ids');
		
		$check = false;
		if (count($ids))
		{
			foreach($ids as $id)
			{
				$check = $this->pages_m->delete($id);
			}
		}
		
		if ($check !== false)
		{
			$this->session->set_flashdata('success', lang('delete_data_success'));
		}
		else
		{
			$this->session->set_flashdata('success', lang('delete_data_false'));
		}
		
		redirect( site_url('admin/page/') );
	}
}
?>
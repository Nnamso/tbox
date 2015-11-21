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

class Layout extends Admin_Controller
{
	public function __construct ()
	{
		parent::__construct();
		
		// check user permission		
		$this->users_m->userPermission('layout');

		$this->load->model('layout_m');
	}
	
	public function index ()
	{
		$this->data['breadcrumb'] 	= lang('page_left_admin_layout');
		$this->data['meta_title'] 	= lang('page_left_admin_layout');
		$this->data['sub_title'] 	= lang('page_left_admin_layout_sub');
		
		$data 						= $this->layout_m->get();
		$this->data['data'] 		= $data;
		
		$this->data['subview'] 		= 'admin/layout/index';
		
		$this->load->view('admin/_layout_main', $this->data);		
	}
	
	public function add($id = null)
	{
		$this->data['breadcrumb'] = lang('layout_add');
		$this->data['meta_title'] = lang('layout_add');
		$this->data['sub_title'] = 'Drag and drop to add element after click "save"';
		
		// get all layouts
		$this->load->library('xml');
		$xml = new Xml();		
		$file = APPPATH .DS. 'views' .DS. 'layouts' .DS. 'layouts.xml';
		
		$layouts = $xml->parse($file);
		if(count($layouts))
		{
			$arr	= array();
			
			foreach($layouts['group'] as $key => $group)
			{				
				$arr[$group['@attributes']['name']] 	= array();
				if ($group['layout'])
				{					
					if (isset($group['layout'][0]) == true)
					{
						foreach ($group['layout'] as $layout)
						{						
							$arr[ $group['@attributes']['name'] ][ $layout['name'] ] 					= array();
							$arr[ $group['@attributes']['name'] ][ $layout['name'] ][ 'title' ] 		= $layout['title'];
							$arr[ $group['@attributes']['name'] ][ $layout['name' ]][ 'description' ] 	= $layout['description'];
						}
					}
					else
					{
						$arr[ $group['@attributes']['name'] ][ $group['layout']['name'] ] 					= array();
						$arr[ $group['@attributes']['name'] ][ $group['layout']['name'] ][ 'title' ] 		= $group['layout']['title'];
						$arr[ $group['@attributes']['name'] ][ $group['layout']['name'] ][ 'description' ] 	= $group['layout']['description'];						
					}
				}			
			}
		}
		//echo '<pre>'; print_r($arr); exit;		
		$this->data['layouts'] = $arr;

		// load data
		if ($id == null)
		{
			$layout = $this->layout_m->getNew();
		}
		else
		{
			$layout = $this->layout_m->get($id);			
		}		
		$this->data['page'] = $layout;
		
		$this->data['subview'] = 'admin/layout/add';
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
		
		if ((int)$page_id > 0)
			$id 				= $this->layout_m->save($data, $page_id);
		else
			$id 				= $this->layout_m->save($data);
		
		if ($data['default'] == 1)
		{
			$file 				= APPPATH .'views' .DS. 'layouts' .DS. $data['layout'].'.php';
			$this->load->helper('file');
			write_file($file, $html);		
		}
		
		redirect( site_url('admin/layout/add/'.$id ) );
	}
	
	// copy a page
	public function copy()
	{
		$ids 	= $this->input->post('ids');
		
		$check = false;
		if (count($ids))
		{
			$data 			= $this->layout_m->get($ids[0]);
			
			if (count($data))
			{
				$check = true;
				
				$data->id 		= null;
				$data->title 	= $data->title .' copy';
				
				$data			= json_decode(json_encode($data), true);
				
				$this->layout_m->save($data);
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
		
		redirect( site_url('admin/layout') );
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
				$check = $this->layout_m->delete($id);
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
		
		redirect( site_url('admin/layout') );
	}
}
?>
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

class Menu extends Admin_Controller
{
	public function __construct ()
	{
		parent::__construct();
		
		// check user permission		
		$this->users_m->userPermission('menu');		
	}
	
	// add menu title, menu items
	public function index ($id = 0)
	{
		$this->data['breadcrumb'] 	= lang('page_left_admin_menu');
		$this->data['meta_title'] 	= lang('page_left_admin_menu');
		$this->data['sub_title'] 	= lang('');		
		
		// load menu type
		$this->load->model('menu_m');
		$menu_type	= $this->menu_m->get();
		$this->data['menu_type']	= $menu_type;
		
		// load menu data
		$id 	= (int) $id;
		if ($id == 0)
		{	
			$menu 	= $this->menu_m->getNew('menu');
			$items 	= $this->menu_m->getNew();
		}
		else
		{
			$menu	= $this->menu_m->get($id);
			if ( count($menu) == 0 )
				$menu 	= $this->menu_m->getNew('menu');
			
			$this->menu_m->_table_name	= 'menus';
			$this->menu_m->db->where('menu_type_id', $id);
			$items 		= $this->menu_m->get();		
		}
		
		$this->data['menu']		= $menu;
		$this->data['items']	= $items;
		
		// load static page
		$this->load->model('pages_m');
		$pages	= $this->pages_m->get();
		$this->data['pages']	= $pages;
		
		// load products
		$this->load->model('product_m');
		$this->product_m->db->select('id, title, slug');
		$this->product_m->db->where('published', 1);
		$products				= $this->product_m->get();
		$this->data['products']	= $products;
		
		// product category
		$this->load->model('categories_m');
		$this->categories_m->db->select('id, title, slug');
		$this->categories_m->db->where('published', 1);
		$this->categories_m->db->where('type', 'product');
		$categories				= $this->categories_m->get();
		$this->data['categories']	= $categories;
		
		// get design idea categories
		$this->categories_m->db->select('id, title, slug');
		$this->categories_m->db->where('published', 1);
		$this->categories_m->db->where('type', 'idea');
		$idea_categories			= $this->categories_m->get();
		$this->data['idea_categories']	= $idea_categories;
		
		// get blog categories
		$this->categories_m->db->select('id, title, slug');
		$this->categories_m->db->where('published', 1);
		$this->categories_m->db->where('type', 'article');
		$blog_categories			= $this->categories_m->get();
		$this->data['blog_categories']	= $blog_categories;
		
		$this->data['subview'] 		= 'admin/menu/index';
		
		$this->load->view('admin/_layout_main', $this->data);		
	}
	
	public function save()
	{
		$menu 	= $this->input->post('menu');		
		$items 	= $this->input->post('items');
				
		$this->form_validation->set_rules('menu[title]', lang('menu_title_validate') . lang('product_product_name'), 'trim|required|xss_clean');            
		
		
		// Process form
		if ($this->form_validation->run() == false || $menu['title'] == '')
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('admin/menu/index/' . $menu['id']);
		}
		
		// add menu type
		$this->load->model('menu_m');
		$data 			= $this->menu_m->getNew('menu_type');
		$data->title 	= $menu['title'];
		
		if ( $menu['id'] > 0 )
		{
			// remove all old item menu
			$id = $menu['id'];
			$this->menu_m->remove($menu['id']);
		}
		else
		{
			$id = null;
		}
		$data->id 		= $id;
		
		$data 			= json_decode(json_encode($data), true);		
		$menu_id		= $this->menu_m->save( $data, $id );
		
		if ($menu_id > 0)
		{
			// add menu items
			$data 				= $this->menu_m->getNew();
			$data				= json_decode (json_encode($data), true);
			$data['menu_type_id']	= $menu_id;
			
			$n 					= count( $items['title'] );			
			for($i=0; $i<$n; $i++)
			{
				$data['id'] 	= null;
				
				$data['title']		= $items['title'][$i];
				$data['url']		= $items['url'][$i];
				$data['attribute']	= $items['attribute'][$i];				
				$data['subitem']	= $items['subitem'][$i];
				$data['html']		= $items['html'][$i];
				$options			= array();
				$options['type']		= $items['options']['type'][$i];
				$options['responsive']	= $items['options']['responsive'][$i];
				
				$data['options']	= json_encode($options);
				
				$this->menu_m->save( $data, $data['id'] );
			}
						
			redirect('admin/menu/index/' . $menu_id);
		}
		else
		{
			$this->session->set_flashdata('error', lang('menu_add_error'));
			redirect('admin/menu/index/' . $menu['id']);
		}
	}
}
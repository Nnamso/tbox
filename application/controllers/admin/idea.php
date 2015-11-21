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

class Idea extends Admin_Controller
{
	public function __construct ()
	{
		parent::__construct();
		
		// check user permission		
		$this->users_m->userPermission('idea');
		
		$this->lang->load('idea');
		$this->lang->load('metadata');
		$this->load->model('idea_m');
	}

	// list all items
	public function index ($page = 0)
	{
		$this->data['breadcrumb'] = lang('idea_title');
        $this->data['meta_title'] = lang('idea_title');
        $this->data['sub_title'] = '';
		
		// search
		if($this->input->post('action'))
			$this->session->set_userdata('search_idea', $this->input->post('keyword'));
		
		$this->load->library('pagination');
		$config['base_url'] 	= site_url('admin/idea/index'); 
        $config['total_rows'] 	= $this->idea_m->getDesigns(true, 0, $this->session->userdata('search_idea'));
		$config['per_page'] 	= 20;
			
        $config['uri_segment'] 	= 4;         
        $config['num_links']	= 2; 
		$config['next_link'] = lang('next'); 
        $config['prev_link'] = lang('prev'); 
        $config['first_link'] = lang('first'); 
        $config['last_link'] = lang('last');		
        $this->pagination->initialize($config); 
        $this->data['links'] = $this->pagination->create_links();
		$this->data['keyword']	= $this->session->userdata('search_idea');
		
		$this->load->model('idea_m');
		$items	= $this->idea_m->getDesigns(false, $page, $this->session->userdata('search_idea'));		
		$this->data['items']	= $items;
		
		$this->data['subview'] = 'admin/idea/index';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	// add, edit items
	public function edit($id = 0)
	{
		$this->load->model('idea_m');
		
		if ($id == 0)
		{
			$lang 	= 'add';
			$data	= $this->idea_m->getNew();
		}			
		else
		{
			$data	= $this->idea_m->get($id, true);
			$lang 	= 'edit';
		}
		
		// get all category
		$this->load->model('categories_m');
		$categories = $this->categories_m->getAllCategories('idea', true);
		$this->data['categories'] = categoriesToTree($categories);
			
		$this->data['breadcrumb'] = lang('idea_title_'.$lang);
        $this->data['meta_title'] = lang('idea_title_'.$lang);
		
        $this->data['data'] 	= $data;
		
		$this->data['subview'] = 'admin/idea/edit';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	// save design idea
	public function save()
	{
		$data 	= $this->input->post('data');
		
		$this->form_validation->set_rules('data[title]', lang('field_validate_msg'). 'title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('data[design_id]', lang('field_validate_msg'). 'design id', 'trim|required|xss_clean');      
		
		
		// Process form
		if ($this->form_validation->run() == false)
		{		
			redirect('admin/idea/edit/' . $data['id']);
		}
		else
		{
			if ($data['slug'] == '')
			{
				$data['slug']	= $data['title'];
			}
			$data['slug']	= url_title($data['slug']);
			
			$this->load->model('idea_m');
			
			if ($data['id'] > 0)
			{
				$id		= $data['id'];
				unset($data['id']);
				$this->idea_m->save($data, $id);
			}
			else
			{
				$data['id']	= null;
				$id 	= $this->idea_m->save($data, null);
			}
		}
		
		redirect('admin/idea/edit/' . $id);
	}
	
	// remove
	public function remove($id = 0)
	{
		$this->load->model('idea_m');
		if ($id > 0)
		{
			$this->idea_m->delete($id);
		}
		else
		{
			$ids 	= $this->input->post('ids');
			for($i=0; $i<count($ids); $i++)
			{
				$this->idea_m->delete($ids[$i]);
			}
		}
		
		redirect('admin/idea');
	}
	
	public function categories ()
	{
		$this->data['breadcrumb'] = lang('idea_admin_categories_breadcrumb');
        $this->data['meta_title'] = lang('idea_admin_categories_meta_title');
        $this->data['sub_title'] = lang('idea_admin_categories_sub_title');
		
		// ordering categories.
		if($id = $this->input->post('order_id'))
		{
			$this->load->model('categories_m');
			$order_number = $this->input->post('order_number');
			if(is_numeric($order_number))
			{
				$data['order'] = $order_number;
				if($this->categories_m->save($data, $id))
				{
					echo '1';
				}
			}
			return;
		}
		
		if($this->input->post('per_page'))
			$this->session->set_userdata('search_category_idea', $this->input->post('search_category'));
		
		// pagination
        $this->load->library('pagination'); 
        $this->load->helper('url');
        $config['base_url'] 	= site_url('admin/idea/categories'); 
        $config['total_rows'] 	= $this->idea_m->getCategories(true, $this->session->userdata('search_category_idea'));
		
		$config['per_page'] = 20;		
		if($this->input->post('per_page'))
		{
			if($this->input->post('per_page') == 'all')
				$config['per_page'] = $this->session->set_userdata('per_page', $config['total_rows']);
			else
				$config['per_page'] = $this->session->set_userdata('per_page', $this->input->post('per_page'));	
		}
		
		if($this->session->userdata('per_page') != '')
			$config['per_page'] = $this->session->userdata('per_page');
		
        $config['uri_segment'] = 4; 
        $config['next_link'] = lang('next'); 
        $config['prev_link'] = lang('prev'); 
        $config['first_link'] = lang('first'); 
        $config['last_link'] = lang('last'); 
        $config['num_links']	= 2;                 
        $this->pagination->initialize($config); 
        $this->data['links'] = $this->pagination->create_links();
		$this->data['per_page'] = $config['per_page'];
		$this->data['search'] = $this->session->userdata('search_category_idea');
		
		$this->data['categories'] = $this->idea_m->getCategories(false, $this->data['search'], $config['per_page'], $this->uri->segment(4));
		
		// Load view
		$this->data['subview'] = 'admin/idea/categories';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function editCategory ($id = '')
	{
		$this->data['id'] = $id;
		$this->load->library('form_validation');
		$this->load->model('categories_m');
		
		$this->session->set_flashdata('edit_id', $id);
		
		$categories = $this->categories_m->getCategories('idea');
		$this->data['categories'] = categoriesToTree($categories);
		
		$this->data['category'] = $this->idea_m->getNewCategory();
					
		//edit
		if($id == '')
		{
			$this->data['breadcrumb'] = lang('idea_admin_idea_add_category_breadcrumb');
			$this->data['meta_title'] = lang('idea_admin_idea_add_category_meta_title');
			$this->data['sub_title'] = lang('idea_admin_idea_add_category_sub_title');
		}else
		{
			$this->data['breadcrumb'] = lang('idea_admin_idea_edit_category_breadcrumb');
			$this->data['meta_title'] = lang('idea_admin_idea_edit_category_meta_title');
			$this->data['sub_title'] = lang('idea_admin_idea_edit_category_sub_title');
			
			$category = $this->categories_m->getCategorie('idea', $id);
			if(count($category) > 0)
				$this->data['category'] = $category;
			else
				redirect(site_url().'admin/idea/categories');
		}
		
		if($data = $this->input->post('data'))
		{
			$this->form_validation->set_rules('data[title]', lang('title'), 'trim|required|min_length[2]|max_length[200]');
			$this->form_validation->set_rules('data[parent_id]', lang('categories'), 'trim|required|is_natural');
			$this->form_validation->set_rules('data[published]', lang('publish'), 'trim|required|is_natural');
			$this->form_validation->set_rules('data[language]', lang('language'), 'trim|required|alpha');
			if ($this->form_validation->run() == TRUE)
			{
				if($data['slug'] == '')
					$data['slug'] = $data['title'];
					
				if(!preg_match('/^[a-zA-Z0-9._]+?[a-zA-Z0-9]+$/D', $data['slug']))
				{
					$this->load->helper('text');
					$data['slug'] = url_title($data['slug']);
				}
				
				$data['slug'] = strtolower($data['slug']);
						
				if($id == '')
				{
					$data['type'] = 'idea';
					$data['created'] = date('Y-m-d H:i:s');
					$cate_id = $this->categories_m->save($data);
					if($cate_id != '')
					{
						$this->session->set_flashdata('msg', lang('idea_admin_categories_add_category_success_msg'));
						redirect(site_url().'admin/idea/categories');
					}else
					{
						$this->session->set_flashdata('error', lang('idea_admin_categories_add_category_error_msg'));
						redirect(site_url().'admin/idea/categories');
					}
				}else
				{
					if($this->categories_m->save($data, $id))
					{
						$this->session->set_flashdata('msg', lang('idea_admin_categories_edit_category_success_msg'));
						redirect(site_url().'admin/idea/categories');
					}else
					{
						$this->session->set_flashdata('error', lang('idea_admin_categories_edit_category_error_msg'));
						redirect(site_url().'admin/idea/categories');
					}
				}
			}else
			{
				$this->data['data'] = $data;
			}
		}
			
		// Load the view
		$this->data['subview'] = 'admin/idea/edit_category';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function publishCategory($id = '')
	{
		$data['published'] = 1;
		$this->load->model('categories_m');
		if($id != '')
		{
			$this->categories_m->save($data, $id);
		}else
		{
			if($checkb = $this->input->post('checkb'))
			{
				if(is_array($checkb))
				{
					foreach($checkb as $id)
					{
						$this->categories_m->save($data, $id);
					}
				}
			}
		}
		redirect(site_url().'admin/idea/categories');
	}
	
	public function unPublishCategory($id = '')
	{
		$data['published'] = 0;
		$this->load->model('categories_m');
		if($id != '')
		{
			$this->categories_m->save($data, $id);
		}else
		{
			if($checkb = $this->input->post('checkb'))
			{
				if(is_array($checkb))
				{
					foreach($checkb as $id)
					{
						$this->categories_m->save($data, $id);
					}
				}
			}
		}
		redirect(site_url().'admin/idea/categories');
	}
	
	public function delCategory($id = '')
	{
		$this->load->model('categories_m');
		if($id != '')
		{
			$categories = $this->categories_m->getAllCategories('idea');
			$categories = categoriesToTree($categories, $id);
			$categories = getChildCate($categories);
			$data['parent_id'] = 0;
			
			if($this->categories_m->delete($id))
			{
				// update parent_id.
				foreach($categories as $cate_id)
				{
					$this->categories_m->save($data, $cate_id);
				}
				
				$this->session->set_flashdata('msg', lang('idea_admin_categories_delete_success_msg'));
			}else
			{
				$this->session->set_flashdata('error', lang('idea_admin_categories_delete_error_msg'));
			}
		}else
		{
			if($checkb = $this->input->post('checkb'))
			{
				if(is_array($checkb))
				{
					$categories = $this->categories_m->getAllCategories('idea');
					$data['parent_id'] = 0;
					
					foreach($checkb as $id)
					{
						if($this->categories_m->delete($id))
						{
							$categories = categoriesToTree($categories, $id);
							$categories = getChildCate($categories);
							// update parent_id.
							foreach($categories as $cate_id)
							{
								$this->categories_m->save($data, $cate_id);
							}
							$this->session->set_flashdata('msg', lang('idea_admin_categories_delete_success_msg'));
						}else
						{
							$this->session->set_flashdata('error', lang('idea_admin_categories_delete_some_error_msg'));
							break;
						}
					}
				}
			}
		}
		redirect(site_url().'admin/idea/categories');
	}
}
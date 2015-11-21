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
	
class Custom extends Admin_Controller
{
	public function __construct ()
	{
		parent::__construct();
		
		// check user permission		
		$this->users_m->userPermission('custom');
	
		$this->lang->load('custom');
		$this->lang->load('metadata');
		$this->load->model('custom_m');
		$this->load->library('session');
		$this->user = $this->session->userdata('user');
	}
	
	public function index ()
	{	
		$this->data['breadcrumb'] = lang('custom_admin_custom_frontend_breadcrumb');
		$this->data['meta_title'] = lang('custom_admin_custom_frontend_meta_title');
		$this->data['sub_title'] = lang('custom_admin_custom_frontend_sub_title');
		exit;
	}
	
	public function article()
	{
		$this->data['breadcrumb'] = lang('custom_admin_article_breadcrumb');
		$this->data['meta_title'] = lang('custom_admin_article_meta_title');
		$this->data['sub_title'] = lang('custom_admin_article_sub_title');
		
		if($this->input->post('per_page'))
			$this->session->set_userdata('search_article', $this->input->post('search_article'));
			
		// pagination
		$this->load->library('pagination'); 
		$this->load->helper('url');
		$config['base_url'] = base_url('admin/custom/article'); 
		$config['total_rows'] = $this->custom_m->getArticles(true, $this->session->userdata('search_article'));
		
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
		$this->data['search'] = $this->session->userdata('search_article');
		
		$categories = $this->custom_m->getCateArticle();
		$article_categories = array();
		if(is_array($categories))
		{
			foreach($categories as $category)
			{
				$article_categories[$category->id] = $category->title;
			}
		}
		$this->data['article_categories'] = $article_categories;
		$this->data['articles'] = $this->custom_m->getArticles(false, $this->data['search'], $config['per_page'], $this->uri->segment(4));
		
		// Load view
		$this->data['subview'] = 'admin/custom/article';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function edit($id = '')
	{
		$this->data['id'] = $id;
		$this->load->model('categories_m');
		$categories = $this->categories_m->getAllCategories('article', true);
		$cate = categoriesToTree($categories);
		$tree_option['0'] = lang('root');
		$this->data['categories'] = categoriesToTree($categories);
		
		$this->data['breadcrumb'] = lang('custom_admin_edit_article_breadcrumb');
		$this->data['meta_title'] = lang('custom_admin_edit_article_meta_title');
		$this->data['sub_title'] = lang('custom_admin_edit_article_sub_title');
		
		$this->session->set_userdata('edit_id', $id);
		$this->load->library('form_validation');
		if($data = $this->input->post('data'))
		{
			// Set form  
			$this->form_validation->set_rules('data[title]', lang('title'), 'trim|required|min_length[2]|max_length[255]|xss_clean'); 
			$this->form_validation->set_rules('data[cate_id]', lang('categories'), 'trim|required|is_natural');					
			if($this->form_validation->run() == TRUE)
			{
				// check slug.
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
					$data['date'] = date('Y-m-d H:i:s');
					if($this->custom_m->save($data))
					{
						$this->session->set_flashdata('msg', lang('custom_admin_add_article_success_msg'));
						redirect(site_url().'admin/custom/article');
					}else
					{
						$this->data['error'] = lang('custom_admin_add_article_error_msg');
					}
				}else
				{
					if($this->custom_m->save($data, $id))
					{
						$this->session->set_flashdata('msg', lang('custom_admin_edit_article_success_msg'));
						redirect(site_url().'admin/custom/article');
					}else
					{
						$this->data['error'] = lang('custom_admin_edit_article_error_msg');
					}
				}
			}else
			{
				$this->data['data'] = $this->input->post('data');
			}
		}
		
		if($id == '')
			$this->data['article'] = $this->custom_m->getNew();
		else
			$this->data['article'] = $this->data['article'] = $this->custom_m->getArticle($id);
		
		$this->data['subview'] = 'admin/custom/edit_article';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function editCategory($id = '')
	{
		$this->data['id'] = $id;
		$this->load->model('categories_m');
		$categories = $this->categories_m->getAllCategories('article', true);
		$cate = categoriesToTree($categories);
		$tree_option['0'] = lang('root');
		$this->data['categories'] = categoriesToTree($categories);
		
		$this->data['category'] = $this->categories_m->getNew();
		
		if($id == '')
		{
			$this->data['breadcrumb'] = lang('custom_admin_add_category_breadcrumb');
			$this->data['meta_title'] = lang('custom_admin_add_category_meta_title');
			$this->data['sub_title'] = lang('custom_admin_add_category_sub_title');
		}else
		{
			$this->data['breadcrumb'] = lang('custom_admin_edit_category_breadcrumb');
			$this->data['meta_title'] = lang('custom_admin_edit_category_meta_title');
			$this->data['sub_title'] = lang('custom_admin_edit_category_sub_title');
			$category = $this->categories_m->getCategorie('article', $id);
			if(count($category) > 0)
				$this->data['category'] = $category;
			else
				redirect(site_url().'admin/custom/categories');
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
					$data['type'] = 'article';
					$data['created'] = date('Y-m-d H:i:s');
					$cate_id = $this->categories_m->save($data);
					if($cate_id != '')
					{
						$this->session->set_flashdata('msg', lang('custom_add_category_susscess_msg'));
						redirect(site_url().'admin/custom/categories');
					}else
					{
						$this->session->set_flashdata('error', lang('custom_add_category_error_msg'));
						redirect(site_url().'admin/custom/categories');
					}
				}else
				{
					if($this->categories_m->save($data, $id))
					{
						$this->session->set_flashdata('msg', lang('custom_edit_category_susscess_msg'));
						redirect(site_url().'admin/custom/categories');
					}else
					{
						$this->session->set_flashdata('error', lang('custom_edit_category_error_msg'));
						redirect(site_url().'admin/custom/categories');
					}
				}
			}else
			{
				$this->data['data'] = $data;
			}
		}
		
		$this->data['subview'] = 'admin/custom/edit_category';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function publish($id = '')
	{
		if($data = $this->input->post('checkb'))
		{
			$update['publish'] = 1;
			foreach($data as $id)
			{
				$this->custom_m->save($update, $id);
			}
		}elseif($id != '')
		{
			$update['publish'] = 1;
			$this->custom_m->save($update, $id);
		}
		redirect(site_url().'admin/custom/article');
	}
	
	public function publishCate($id = '')
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
		redirect(site_url().'admin/custom/categories');
	}
	
	public function unPublish($id = '')
	{
		if($data = $this->input->post('checkb'))
		{
			$update['publish'] = 0;
			foreach($data as $id)
			{
				$this->custom_m->save($update, $id);
			}
		}elseif($id != '')
		{
			$update['publish'] = 0;
			$this->custom_m->save($update, $id);
		}
		redirect(site_url().'admin/custom/article');
	}
	
	public function unPublishCate($id = '')
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
		redirect(site_url().'admin/custom/categories');
	}
	
	public function delete($id = '')
	{
		if($data = $this->input->post('checkb'))
		{
			foreach($data as $id)
			{
				if($this->custom_m->delete($id))
				{
					$this->session->set_flashdata('msg', lang('custom_admin_delete_success_msg'));
				}else
				{
					$this->session->set_flashdata('error', lang('custom_admin_some_delete_error_msg'));
					break;
				}
			}
		}elseif($id != '')
		{
			if($this->custom_m->delete($id))
				$this->session->set_flashdata('msg', lang('custom_admin_delete_success_msg'));
			else
				$this->session->set_flashdata('error', lang('custom_admin_delete_error_msg'));
		}
		redirect(site_url().'admin/custom/article');
	}
	
	public function delCategory($id = '')
	{
		$this->load->model('categories_m');
		
		if($id != '')
		{
			$categories = $this->categories_m->getAllCategories('article');
			$categories = categoriesToTree($categories, $id);
			$categories = getChildCate($categories);
			$data['parent_id'] = 0;
		 
			if($this->categories_m->delete($id))
			{
				$this->session->set_flashdata('msg', lang('custom_category_delete_success_msg'));
				
				// update parent_id.
				foreach($categories as $cate_id)
				{
					$this->categories_m->save($data, $cate_id);
				}
			}else
			{
				$this->session->set_flashdata('error', lang('custom_category_delete_error_msg'));
			}
		}else
		{
			if($checkb = $this->input->post('checkb'))
			{
				if(is_array($checkb))
				{
					$categories = $this->categories_m->getAllCategories('article');
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
							$this->session->set_flashdata('msg', lang('custom_category_delete_success_msg'));
						}else
						{
							$this->session->set_flashdata('error', lang('custom_category_delete_some_error_msg'));
							break;
						}
					}
				}
			}
		}
		redirect(site_url().'admin/custom/categories');
	}
	
	function categories()
	{
		$this->data['breadcrumb'] = lang('custom_admin_categories_breadcrumb');
		$this->data['meta_title'] = lang('custom_admin_categories_meta_title');
		$this->data['sub_title'] = lang('custom_admin_categories_sub_title');
		$this->load->model('categories_m');
		// ordering categories.
		if($id = $this->input->post('order_id'))
		{
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
			$this->session->set_userdata('search_category_blog', $this->input->post('search_category'));
			
		// pagination
		$this->load->library('pagination'); 
		$this->load->helper('url');
		$config['base_url'] = base_url('admin/custom/categories'); 
		$config['total_rows'] = $this->categories_m->getCategories('article', true, $this->session->userdata('search_category_blog'));
		
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
		$this->data['search'] = $this->session->userdata('search_category_blog');
		
		$this->data['categories'] = $this->categories_m->getCategories('article', false, true, $this->data['search'], $config['per_page'], $this->uri->segment(4));
		$this->data['subview'] = 'admin/custom/categories';
		$this->load->view('admin/_layout_main', $this->data);
	}
}
?>
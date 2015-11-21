<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * arts
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Art extends Admin_Controller
{

	public function __construct ()
	{
		parent::__construct();
		
		// check user permission		
		$this->users_m->userPermission('art');
		
		$this->load->model('art_m');
		$this->lang->load('art');
		$this->lang->load('metadata');
		
		$this->user =  $this->session->userdata('user');
	}
	
	// link en/admin/art/index/layout/cate_id/page_number
	public function index ($layout = 'default', $cateID = 0, $limit = 0)
	{		
		$this->lang->load('categories');
		$this->data['breadcrumb'] 	= lang('art_admin_clipart_breadcrumb');
		$this->data['meta_title'] 	= lang('art_admin_clipart_meta_title');
		$this->data['sub_title'] 	= lang('art_admin_clipart_sub_title');
				
		$config['base_url'] 		= site_url(). '/admin/art/index/default/'.$cateID;
		
		$config['per_page'] 		= 24;
		$config['uri_segment'] 		= 6;
		$config['prev_link'] 		= '&larr;';
		$config['next_link'] 		= '&rarr;';
		$config['first_link']		= '&laquo;';
		$config['last_link'] 		= '&raquo;';
		
		$count = $this->uri->segment_array();	
		
		$art_id	= $this->input->get('art_id');
		$art_id = (int) $art_id;		
		
		if($this->input->post('search'))
			$this->session->set_userdata('keyword', $this->input->post('keyword'));
			
		if ( count($count) == $config['uri_segment']  )
		{
			$limit 					= (int) $this->uri->segment($config['uri_segment']);
		}
		else
		{
			$limit 					= 0;
		}		
		
		if ($cateID != null)
		{
			$config['total_rows']		= $this->art_m->getArts($cateID, true, 0, $art_id, $this->session->userdata('keyword'));
			$arts						= $this->art_m->getArts($cateID, false, $limit, $art_id, $this->session->userdata('keyword'));
		}
		else
		{
			$config['total_rows']		= $this->art_m->getArts('', true, 0, $art_id, $this->session->userdata('keyword'));
			$arts						= $this->art_m->getArts('', false, $limit, $art_id, $this->session->userdata('keyword'));
		}
		$this->data['arts'] 			= $arts;
		
		$this->load->library('pagination');
		$this->pagination->initialize($config); 

		
		$this->data['subview'] 			= 'admin/clipart/index';
		
		if ($layout == 'ajax')
			$this->load->view('admin/clipart/ajax', $this->data);
		else
			$this->load->view('admin/_layout_main', $this->data);
	}		
	
	// remove all clipart checked
	function remove()
	{
		$ids 	= $this->input->post('ids');
		if($ids > 0)
		{
			foreach($ids as $id)
			{
				$this->art_m->delete($id);
			}
			$this->session->set_flashdata('success', 'Remove success');
		}
		
		redirect('admin/art');	
	}
	
	// add, edit art
	function edit($id = null)
	{
		
		$art 	= 	$this->input->post('art');
		
		// save data
		if(count($art) > 3)
		{
			$upload = false;
			
			// upload file
			if (isset($_FILES["file"]["name"]) && $_FILES["file"]["name"] != '')
			{
				$upload 		= true;
				
				// check folder and create
				$this->root		= ROOTPATH .DS. 'media' .DS. 'cliparts' .DS. $art['cate_id'];
				if (!file_exists($this->root))
				{
					 mkdir($this->root, 0755, TRUE);
				}
				
				$config['upload_path'] = $this->root .DS. 'print';
				if(!is_dir($config['upload_path']))
				{
					mkdir($config['upload_path'], 0755, TRUE);
				}
				
				$config['allowed_types'] 	= 'gif|png|jpg|jpge|svg';	
				$config['max_size']			= '5120'; // 5MB		

				$this->load->library('upload', $config);
				if(!$this->upload->do_upload('file'))
				{
					$this->session->set_flashdata('error', $this->upload->display_errors());
					redirect('admin/art');
				}
				
				$file = $this->upload->data();
				
				$art['fle_url'] 	= $art['cate_id'].'/'.$file['file_name'];
				$art['file_name'] 	= $file['file_name'];
				$art['file_type'] 	= str_replace('.', '', $file['file_ext']);
				
				// get color of image
				$art['colors'] 		= '0';
				if($art['file_type'] == 'svg')
				{
					$this->load->library('svg');
					$colors 		= $this->svg->getColors($file['full_path']);
					if(count($colors))
						$art['colors'] = json_encode($colors);
				}
			}
			//echo '<pre>';print_r($art); echo '</pre>'; exit;
		
			if (!isset ($art['change_color']) ) $art['change_color'] = '0';
			
			if ($art['slug'] == '')
			{
				$art['slug'] = $art['title'];
			}
			$art['slug']	= url_title($art['slug']);
			
			if($art['fle_url'] != '' && $art['file_name'] != '' && $art['file_type'] != '')
			{
				$clipart_id 	= $this->input->post('clipart_id');
				if($clipart_id > 0)
				{
					$clipart_id 	= $this->art_m->save($art, $clipart_id);
					
				}
				else
				{								
					$clipart_id 		= $this->art_m->save($art, NULL);
				}
			}
			
			if($clipart_id > 0)
			{				
				// create thumb
				if($upload == true)
				{
					$this->load->library('thumb');
					$this->thumb->file	= $file['full_path'];				
					
					$thumbs	= $this->root .DS. 'thumbs';				
					if(!is_dir($thumbs)) mkdir($thumbs, 0755, TRUE);				
					$this->thumb->resize($thumbs .DS. md5($clipart_id), array('width'=>100, 'height'=>100));
					
					
					$medium	= $this->root .DS. 'medium';
					if(!is_dir($medium)) mkdir($medium, 0755, TRUE);
					$this->thumb->resize($medium .DS. md5($clipart_id.'medium'), array('width'=>300, 'height'=>300));
					
					$large	= $this->root .DS. 'large';
					if(!is_dir($large)) mkdir($large, 0755, TRUE);
					$this->thumb->resize($large .DS. md5($clipart_id.'large'), array('width'=>800, 'height'=>800));									
				}
			}
			redirect('admin/art');
		}
		else
		{		
			// get data edit
			$data 	= array();
			
			// add and edit clipart
			$this->load->model('categories_m');
			$categories 				= $this->categories_m->getCategories('clipart');			
			if (count($categories) > 0)
			{
				$categories				= categoriesToTree($categories);	
				$data['categories']		= $categories;
			} 
			else 
			{
				$data['categories']	 	= array();
			}
			
			// add new
			if($id == null)
			{
				$data['title']		= lang('art_add');
				$art				= $this->art_m->getNew();			
				$art->category		= $this->input->get('cate_id');	
				$art->tags			= '';
				$data['art']		= $art;
			}
			else
			{
				$data['title']	= lang('art_edit');
				
				$cate_id 		= $this->input->get('cate_id');
				$data['art'] 	= new stdclass();
				if($cate_id > 0)
				{
					$this->load->model('categories_m');
					$category 	= $this->categories_m->getCategory('clipart', $cate_id);								
				}
				$art 			= $this->art_m->getArt($id);
							
				$art->category 	= $category;				
				
				$data['art']	= $art;
				
			}
		}
		
		$this->load->view('admin/clipart/edit', $data);
	}
}
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

class Categories extends Admin_Controller
{

	public function __construct ()
	{
		parent::__construct();
		
		// check user permission		
		$this->users_m->userPermission('categories');
		
		$this->load->model('categories_m');
		$this->lang->load('categories');
	}

	public function index ()
	{
	}
	
	public function add($type, $clip_id = null, $parent_id = 0)
	{
	
		$data['type'] 		= $type;
		
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
		
		// add category
		if($clip_id == null || (int) $clip_id == 0)
		{
			$data['clip_id'] 	= 0;
			
			$data['parent_id'] 	= $parent_id;
			
			if($data['parent_id'] == 0)
			{
				$data['parent']	= lang('root');
				$data['level']	= 1;
			}
			else
			{	
				$category = $this->categories_m->getCategory($data['parent_id'], $data['type']);
				$data['parent']	= $category->title;
				$data['level']	= $category->level + 1;
			}

			$this->load->view('admin/categories/add', $data);
		}
		else
		{
			$category 	= $this->categories_m->getCategory('clipart', $clip_id);
			
			if (count($category) == 0)
			{
				$category = new stdClass();
				$category->id			= 0;
				$category->published	= 1;
				$category->parent_id	= 0;
				$category->title		= '';
				$category->slug			= '';
				$category->description	= '';
			}
			$data['category'] = $category;
			$this->load->view('admin/categories/edit', $data);
		}		
	}
	
	public function edit()
	{
		$cateInfo 	= $this->input->post('cateLang');		
		$clip_id 	= $this->input->post('clip_id');		
		
		if ($cateInfo['title'] == '')
		{
			$errors['error'] 	= "1";
			$errors['msg']		= lang('category_add_info');
			echo json_encode($errors);
			exit;
		}
		
		$id 		= $clip_id;
		
		if ($id > 0)
		{
			$is_new = false;			
		} 
		else 
		{
			$is_new = true;
			$id 	= null;			
		}
		$data 	= $this->categories_m->getNew();
		$data 	= json_decode(json_encode($data), true);

		if ($data['parent_id'] == 0)
		{
			$data['level'] = 1;
		}
		else
		{
			$parent = $this->categories_m->getCategory($data['parent_id'], 'clipart');
			$data['level'] = $parent->level + 1;
		}
					
		$data['type'] 			= 'clipart';
		$data['title'] 			= $cateInfo['title'];
		$data['slug'] 			= url_title($cateInfo['slug'], '-', TRUE);
		$data['description'] 	= $cateInfo['description'];
		$data['parent_id'] 		= $cateInfo['parent_id'];
		$data['published'] 		= 1;
		$data['description'] 	= $cateInfo['description'];
		
		$id = $this->categories_m->save($data, $id);
				
		$errors['error'] 	= "0";
		$errors['msg']		= 'ok';
		echo json_encode($errors);
		return;
	}
	
	public function delete ($type = '', $id = null)
	{
		if($id == null)
		{
			$type 	= $this->uri->segment(5);
			$id 	= $this->uri->segment(6);
		}
		$this->categories_m->_primary_key = 'id';
		$this->categories_m->_table_name = 'categories';
		if($this->categories_m->delete($id))
		{
			//udpate children cate.
			$categories = $this->categories_m->getAllCategories('article');
			$categories = categoriesToTree($categories, $id);
			$categories = getChildCate($categories);
			$data['parent_id'] = 0;
			// update parent_id.
			foreach($categories as $cate_id)
			{
				$this->categories_m->save($data, $cate_id);
			}
		}
	}
	
	function sorting()
	{
		$child	= $this->input->post('child', '');
		$parent	= $this->input->post('parent', '');
		
		// action = (over, before, after) 
		$action	= $this->input->post('action', '');
		
		if($child > 0 && $parent > 0)
		{
			if($action == 'over')
			{
				$data = array(
					'parent_id'=>$parent
				);
				$this->categories_m->update($data, $child);
			}
			elseif($action == 'before' || $action == 'after')
			{
				$cate = $this->categories_m->get($parent);
				$order = $cate->order + 1;
				
				if($action == 'after')
					$order = $cate->order - 1;
				
				$data = array(
					'order'=>$order					
				);
				$this->categories_m->update($data, $child);
				
				/* sort and over ()
				 *	check parent of 2 node
				 *	if parent node 1 = parent node 2 => sort
				 *	else sort and over
				*/
				$cateC = $this->categories_m->get($child);
				if($cateC->parent_id != $cate->parent_id)
				{
					$data = array(
						'parent_id'=>$cate->parent_id					
					);
					$this->categories_m->update($data, $child);
				}
			}			
		}
	}
}
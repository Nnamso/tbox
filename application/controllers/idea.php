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

class Idea extends Frontend_Controller 
{
    function __construct()
    {
        parent::__construct();
    }
	
	/**
	 *  get all categories or category
	 *	
	 * @param    string
	 */
	public function index($id = '')
	{
		$id 	= (int) $id;
		
		$found 	= true;
		$data 	= array();
		
		$this->load->model('categories_m');
		
		// get all categories with level 0
		if ($id == 0)
		{
			$this->categories_m->db->where('type', 'idea');
			$this->categories_m->db->where('parent_id', 0);
			$this->categories_m->db->where('published', 1);
			
			$categories 	= $this->categories_m->get();
			
			$this->data['categories']	= $categories;
			
			$content		= $this->load->view('components/idea/categories', $this->data, true);
		}
		else
		{
			// load a category					
			$category = $this->categories_m->getCate($id);
			
			if ( count($category) == 0)
			{
				$found 	= false;
			}
			else
			{
				// load sub category
				$category->children 	= $this->categories_m->getChildren($id);
				
				// load meta data
				if ($category->meta_title != '')
				$data['title']	= $category->meta_title;
			
				if ($category->meta_keyword != '')
					$data['meta_keywords']	= $category->meta_keyword;
				
				if ($category->meta_description != '')
					$data['meta_description']	= $category->meta_description;
					
				// load design idea
				$this->load->model('idea_m');
				$this->idea_m->db->where('cate_id', $id);
				$category->items	= $this->idea_m->getDesigns(false);				
				
				$this->data['category']	= $category;
				
				$this->data['pagination']	= '';
				
				$content		= $this->load->view('components/idea/category', $this->data, true);
			}
		}
		
		if ($found === false)
		{
			// load 404
			$data['subview'] = $this->load->view('layouts/404/404', array(), true);
		}
		else
		{
			$data['content']= $content;
			
			$layout = $this->load->view('layouts/idea/categories', array(), true);
			$data['subview']	= $layout;
		}
		
		$this->theme($data, 'idea');
	}	
}
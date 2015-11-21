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

class Categories extends Frontend_Controller 
{
    function __construct()
    {
        parent::__construct();
    }
	
	// list categories of product
	public function index($string = '', $page = 0)
	{
		// get id of category
		$id 	= (int) $string;
		
		$found 	= true;
		if ($id == 0)
		{
			$found 	= false;
		}
		else
		{
			// load categories
			$this->load->model('categories_m');			
			
			// get category info
			$category = $this->categories_m->getCate($id);
			
			if ( count($category) == 0)
			{
				$found 	= false;
			}
		}
		
		$data		= array();
		
		if ($found === false)
		{
			// load 404
			$data['subview'] = $this->load->view('layouts/404/404', array(), true);
		}
		else
		{
			
			// load category data
			$this->data					= array();
			$this->data['categories_m']	= $this->categories_m;
			
			// get all sub categories
			$category->children 	= $this->categories_m->getChildren($id);
				
			// get all products of this category							
			$total 					= $this->categories_m->getProducts($id, 1, true);
				
			// filter
			$orderby	= $this->input->get('orderby');
			if ($orderby == '') $orderby = 'id';	
				
			$order	= $this->input->get('order');
			if ($order == '' || ($order != 'asc' && $order != 'desc')) $order = 'asc';
			if ($order == 'asc') $new_order = 'desc';
			else $new_order = 'asc';
				
			$limit		= $this->input->get('limit');
			if ($limit == '') $limit = 12;
				
			$suffix		= '/?orderby='.$orderby.'&order='.$order.'&limit='.$limit;
				
			$pagination 			= $this->categories_m->getPagination('categories/'.$id.'-'.$category->slug.'/', $total, $suffix);
						
			$this->data['page'] = $page.'/';
			
			$this->data['pagination'] = $pagination;
			
			$options	= array(
				'orderby' => $orderby,
				'order' => $order,
				'limit' => $limit,
				'offset' => $page * $limit,
			);
			$category->products		= $this->categories_m->getProducts($id, 1, false, $options);
			
			$this->data['category']	= $category;
			
			$content					= $this->load->view('components/categories/default', $this->data, true);
			
			$data['content']	= $content;
			
			// load layout of category
			$this->load->model('layout_m');
			$layout = $this->layout_m->getProductPage($id, 'categories');			
			if ($layout == '')
			{
				$layout = $this->load->view('layouts/categories/default', array(), true);
			}
			
			$data['subview']	= $layout;
		}
		
		$this->theme($data, 'categories');
	}	
}
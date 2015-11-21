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

class Search extends Frontend_Controller 
{
    function __construct()
    {
        parent::__construct();
    }
		
	public function index()
	{		
		$keyword	= $this->input->get('keyword');
		
		$this->data = array();
		
		$this->data['keyword']	= $keyword;
		
		if($keyword != '')
		{
			// get products
			$this->load->model('product_m');
			$products 				= $this->product_m->getProducts($keyword, 30, 0, false, true);
			$this->data['products']	= $products;
		
			// get design template
			$this->load->model('idea_m');
			$designs				= $this->idea_m->getDesigns(false, 0, $keyword, 30);
			$this->data['designs']	= $designs;
		
			// get blog
			$this->custom_m = $this->load->pmodel('custom_m');
			$blog				= $this->custom_m->getArticles(false, $keyword, 30, 0);
			$this->data['blog']	= $blog;
		}else
		{
			$this->data['products']	= array();
			$this->data['designs']	= array();
			$this->data['blog']	= array();
		}
		
		$data = array();
		
		$data['title']	= lang('search_results').': '.$keyword;
		
		$data['content'] = $this->load->view('components/search/all', $this->data, true);
		
		$data['subview'] = $this->load->view('layouts/search/all', array(), true);	
		
		$this->theme($data, 'search');
	}	
}
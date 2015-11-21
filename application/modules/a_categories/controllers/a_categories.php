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

class A_Categories extends Frontend_Controller{ 

	public function __construct(){ 
		parent::__construct();		
		$this->load->helper('url');
	} 
	
	public function index($id = ''){
		$this->a_categories_m = $this->load->model('a_categories/a_categories_m');		
		$cate = $this->a_categories_m->getCategory($id);
		$category = $this->a_categories_m->getCate();
		$tree_option['0'] = lang('root');
		if(count($cate) > 0)
		{
			$css = getCss($cate, 'module');
			$this->data['css']	= $css;	
			$this->data['category'] = $cate;	
			$this->data['categories'] = categoriesToTree($category);
			$this->load->view('a_categories', $this->data);
		}
	}
}
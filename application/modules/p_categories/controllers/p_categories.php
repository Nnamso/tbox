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

class P_Categories extends Frontend_Controller{ 

	public function __construct(){ 
		parent::__construct();		
		$this->load->helper('url');
	} 
	
	public function index($id = ''){
		$this->p_categories_m = $this->load->model('p_categories/p_categories_m');		
		$cate = $this->p_categories_m->getCategory($id);
		$category = $this->p_categories_m->getCate();
		$tree_option['0'] = lang('root');
		if(count($cate) > 0)
		{
			$css = getCss($cate, 'module');
			$this->data['css']	= $css;	
			$this->data['category'] = $cate;	
			$this->data['categories'] = categoriesToTree($category);
			$this->load->view('p_categories', $this->data);
		}
	}
}
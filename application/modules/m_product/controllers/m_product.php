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

class M_Product extends Frontend_Controller{ 

	public function __construct(){ 
		parent::__construct();		
		$this->load->helper('url');
	} 
	
	public function index($id = ''){
		$this->m_product_m = $this->load->model('m_product/m_product_m');		
		$m_product = $this->m_product_m->getM_product($id);
		if(count($m_product) > 0)
		{
			$css = getCss($m_product, 'module');
			$this->data['css']	= $css;	
			$this->data['m_product'] = $m_product;
			$options = json_decode($m_product->options);
			if(isset($options->count) && is_numeric($options->count))
				$count = $options->count;
			else
				$count = 8;
			if(isset($options->show_product) && $options->show_product != '')
			{
				$products = $this->m_product_m->getProducts($count, $options->show_product);
			}else 
			{
				$products = array();
			}	
			$this->data['products'] = $products;
			$this->load->view('m_product', $this->data);
		}
	}
}
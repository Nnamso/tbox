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

class Product extends Frontend_Controller 
{
    function __construct()
    {
        parent::__construct();
    }
	
	// get product detail
	public function index($string = '', $color = '')
	{
		$id 	= (int) $string;
		
		// page not found
		$found 	= true;
		if ($id == 0)
		{
			$found 	= false;
		}
		else
		{
			// load product info
			$this->load->model('product_m');
			$row	= $this->product_m->getProduct( array( 'id'=> $id, 'published' => 1 ) );
			if (empty($row[0]) || count($row[0]) == 0)
			{
				$found = false;
			}
		}
		
		$data 		= array();
		if ($found === false)
		{
			// load 404
			$data['subview'] = $this->load->view('layouts/404/404', array(), true);
		}
		else
		{
			$this->data			= array();
			$product 			= $row[0];
			
			// get attributes
			$attribute 			= $this->product_m->getAttribute($id);
			if (count($attribute)) 
			{
				$this->load->helper('product');
				$help_product 		= new helperProduct();
				
				$product->attributes	= $help_product->displayAttributes($attribute);
			}

			// get product design
			$design 	= $this->product_m->getProductDesign($id);
			if (count($design))
			{
				$product->design		= $help_product->getDesign($design);
			}
			
			// product color
			$this->data['color_load']	= false;
			$this->data['index']		= '';
			if ($color != '')
			{
				$index 	= (int) $color;
				if (isset($product->design->color_hex[$index]))
				{					
					$this->data['index']		= $index;
					$this->data['color_load']	= true;
					$this->data['color_active']	= str_replace($index.'-', '', $color);
				}				
			}
			
			$this->data['product_m']	= $this->product_m;
			$this->data['product']		= $product;
			
			// load Related
			$product_cate = $this->product_m->getProductCate($id);
			$cate_id = array();
			foreach($product_cate as $cate)
			{
				$cate_id[] = $cate->cate_id;
			}
			$this->data['products'] = $this->product_m->getRelated($cate_id, $id);
			
			// load view data
			$content			= $this->load->view('components/product/default', $this->data, true);
			$data['content']	= $content;
			
			// load layout of each product
			$this->load->model('layout_m');
			$layout = $this->layout_m->getProductPage($id);			
			if ($layout == '')
			{
				$layout = $this->load->view('layouts/product/default', array(), true);
			}
			$data['subview'] = $layout;
			
			// load Meta
			if ($product->meta_title != '')
				$data['title']	= $product->meta_title;
			
			if ($product->meta_keywords != '')
				$data['meta_keywords']	= $product->meta_keywords;
			
			if ($product->meta_description != '')
				$data['meta_description']	= $product->meta_description;
		}
		
		$this->theme($data, 'product');
	}	
}
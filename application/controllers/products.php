<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * get product of designer
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends Frontend_Controller {
	
	public function __construct(){
        parent::__construct();		
    }
	
	// get categories and sub categories of product
	function getCategories($id = null)
	{
		if ($id == null)
		{
			$id 	= $this->input->post('id');
		}
		$id 		= (int) $id;
		
		$this->load->model('categories_m');
		$categories	= $this->categories_m->getChildren($id);
		
		$data = array();
		
		if (count($categories))
			$data['status'] = 1;
		else
			$data['status'] = 0;
		
		$data['categories'] = $categories;
		
		echo json_encode($data);
		exit();		
	}
	
	// get all product of category
	function getproducts()
	{
		
		$cate_id 	= $this->input->post('id');
		
		$this->load->model('categories_m');
		$products = $this->categories_m->getProducts($cate_id);
		
		$data = array();
		
		if ($products === false)
		{
			$data['status'] = 0;
			$data['error'] = lang('sys_try_again');
		}
		else
		{
			$data['status'] = 1;
		}
		
		$data['products'] = $products;
		
		echo json_encode($data);
		exit();	
	}
	
	function getDesign($id = '')
	{
		$data 	= array();
		
		if ($id == '')
		{
			$this->msgError();
		}
		
		$this->load->model('product_m');
		
		// get product info
		$fields = array('id'=>$id, 'published'=>1);
		$rows 	= $this->product_m->getProduct($fields);
		
		// check product
		if ($rows == false)
		{
			$this->msgError();
		}
		
		$product	= $rows[0];
		
		
		// product design
		$design = $this->product_m->getProductDesign($id);
		if (count($design) == 0)
		{
			$this->msgError();
		}
		$this->load->helper('product');
		$help_design		= new helperProduct();
		$product->design 	= $help_design->getDesign($design);
		
		
		// get product attribute
		$attribute 				= $this->product_m->getAttribute($id);
		if (count($attribute)) 
		{					
			$product->attribute = $help_design->displayAttributes($attribute);
		}
		else
		{
			$product->attribute = '';
		}						
		$product->attribute 	= $help_design->quantity($product->min_order) . $product->attribute;					
		
		
		$data = array();
		$data['status'] = 1;
		
		$data['product'] = $product;
		
		echo json_encode($data);
		exit();	
	}
	
	function msgError()
	{
		$data['status'] = 0;
		$data['error'] = 'Data design of this product not found';
		echo json_encode($data);
		exit();
	}
}

?>
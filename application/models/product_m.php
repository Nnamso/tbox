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


class Product_m extends MY_Model
{
	public $_table_name 	= 'products';
	public $_order_by 		= 'created desc';
	public $_primary_key 	= 'id';
	public $_timestamps 	= TRUE;
	public $validate = array(
		array(
            'field' => 'title', 'label' => 'Product title', 'rules' => 'trim|required|max_length[15]|xss_clean|alpha_numeric'
        ),
	);
	
	/*
	 * get product with where field
	 *	fields = array("field_name"=>"value");
	*/
	public function getProduct($fields = array())
	{
		//$this->db->cache_on();
		$this->db->select('*');
		
		if( count($fields) )
		{
			foreach( $fields as $key => $value ) {
				$this->db->where($key, $value);
			}
		}
		
		$this->db->order_by('default', 'DESC');
		$this->db->limit(1, 0);
		
		$product = parent::get();
		
		//$this->db->cache_off();
		
		if ( count($product) )
			return $product;
		else
			return false;
	}
	
	function remove($id)
	{
		// remove product price		
		$this->db->where('product_id', $id);
		$this->db->limit(1);
		$this->db->delete('product_prices');
		
		// remove categories
		$this->db->where('product_id', $id);
		$this->db->limit(1);
		$this->db->delete('product_categories');
		
		// remove product design
		$this->db->where('product_id', $id);
		$this->db->limit(1);
		$this->db->delete('products_design');
		
		// remove product attribute
		$this->db->where('product_id', $id);
		$this->db->limit(1);
		$this->db->delete('attributes');
		
		// remove product
		$this->db->where('id', $id);
		$this->db->limit(1);
		$this->db->delete('products');
	}
	
	public function getProducts($keyword = '', $number = '', $offset = '', $count = false, $frontEnd = false){
		
		$this->db->select('*');
		
		$this->db->order_by('created', 'DESC');
		
		if ($keyword != '')
			$this->db->like('title', $keyword);	

		if ($frontEnd == true)
		{
			$this->db->where('published', 1);
		}
		
		if ( $count == true )
		{
			$query = $this->db->get('products');
			return count($query->result());
		} 
		else 
		{
			$query = $this->db->get('products', $number, $offset);			
			return $query->result();
		}
	}
	
	// get all categories of product
	function getProductCategories($id, $all = true)
	{
		$this->_table_name = 'product_categories';
		$this->_order_by = 'id DESC';
		$this->db->select('id, cate_id');
		$this->db->where('product_id', $id);		
		
		if($all)
		{
			return parent::get();
		}
		else
		{
			$rows = parent::get();
			$categories = array();
			for($i=0; $i<count($rows); $i++)
			{
				$categories[] 	= $rows[$i]->cate_id;
			}
			
			return $categories;
		}
	}
	
	public function getAttribute($product_id)
	{
		$this->_timestamps	= false;
		$this->_order_by	= 'id DESC';
		$this->_table_name 	= 'attributes';
		$this->db->where('product_id', 	$product_id);
		$this->db->limit(1);		
		
		$row = parent::get(null, true);	
		if ( isset($row->id) )
			return $row;
		else
			return false;
	}
		
	public function getProductPrice($id)
	{
		$this->_table_name = 'product_prices';
		$this->_order_by = 'id DESC';
		$this->db->where('product_id', $id);
		
		return parent::get();
	}
	
	public function getProductPrices($product_id)
	{
		$this->db->select('min_quantity, max_quantity, price');
		$this->db->where('product_id', $product_id);
		
		$query = $this->db->get('product_prices');
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			return $row;
		}
		return false;
	}
	
	// get currency info
	public function getCurrency($id)
	{
		$this->db->select = '*';
		$this->db->where('currency_id', $id);		
		
		$query = $this->db->get('currencies');
		return $query->row();
	}
	
	// get design info
	function getProductDesign($id)
	{
		$this->_table_name = 'products_design';
		$this->_order_by = 'id DESC';
		$this->db->where('product_id', $id);
		
		return parent::get(null, true);
	}
	
	public function getNew($type = '')
	{
		switch( $type ){
			case 'design':
				$data = array();
				$data['status'] 		= 1;
				$data['color_hex'] 		= '';
				$data['color_title'] 	= '';
				$data['price'] 			= '';
				$data['default'] 		= '';
				$data['front'] 			= '';
				$data['back'] 			= '';
				$data['left'] 			= '';
				$data['right'] 			= '';
				$data['area'] 			= '';
				$data['params'] 		= '';
				$data['ordering'] 		= '';
				break;
			default:
				$data 	= new stdClass();
				
				$data->id 			= null;
				$data->title 		= '';
				$data->slug 		= '';
				$data->page 		= '';
				$data->description 	= '';
				$data->size 		= '';
				$data->short_description 	= '';
				$data->sku 			= '';
				$data->print_type	= '';
				$data->price 		= '';
				$data->sale_price	= '';
				$data->image 		= '';
				$data->gallery 		= '';
				$data->min_order 	= '';
				$data->max_oder 	= '';				
				$data->published 	= 1;
				$data->created 		= '';
				$data->ordering 	= 0;
				$data->currency_id 	= 0;
				$data->params 		= '';
				$data->meta_title	= '';
				$data->meta_keywords= '';
				$data->meta_description	= '';
				break;
		}
		
		return $data;
	}
	
	// Get cate_id product.
	public function getProductCate($id = '')
	{
		$this->db->where('product_id', $id);
		$query = $this->db->get('product_categories');
		return $query->result();
	}
	
	// get Related.
	public function getRelated($cate_id = array(), $id = '')
	{
		$this->db->select('products.*' );
		$this->db->join('product_categories', 'product_categories.product_id = products.id');
		$this->db->where('products.id !=', $id);
		$this->db->where_in('product_categories.cate_id', $cate_id);
		$this->db->group_by('product_categories.product_id');
		$this->db->order_by('products.future', 'DESC');
		$this->db->order_by('created', 'DESC');
		$query = $this->db->get('products');
		return $query->result();
	}
}
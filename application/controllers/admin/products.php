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

class Products extends Admin_Controller
{
	
	function __construct()
	{
		parent::__construct();
		
		// check user permission		
		$this->users_m->userPermission('products');
		
		$this->lang->load('products');
	}
	
	// load list products
	function index()
	{
		$this->data['breadcrumb'] 	= lang('products_breadcrumb');
		$this->data['meta_title'] 	= lang('products_meta_title');
		$this->data['sub_title'] 	= lang('products_sub_title');
		
		$this->load->model('product_m');
		
		// pagination		
		$this->load->library('pagination');
		$config['base_url'] = site_url('/admin/products/index');
		
		if($this->input->post('per_page'))
			$this->session->set_userdata('search_product', $this->input->post('keyword'));
			
		$config['total_rows'] = $this->product_m->getProducts($this->session->userdata('search_product'), '', '', true);
			
		if($perpage = $this->input->post('per_page'))
		{
			if($perpage == 'all')
				$this->session->set_userdata('per_page', $config['total_rows']);
			else
				$this->session->set_userdata('per_page', $perpage);
		}
		
		if($this->session->userdata('per_page') != '')
			$config['per_page'] = $this->session->userdata('per_page');
		else
			$config['per_page'] 	= 10;
			
		$this->load->helper('admin');
		$config['uri_segment'] 		= 4; 
		$config['next_link'] 		= lang('next'); 
		$config['prev_link'] 		= lang('prev'); 
		$config['first_link'] 		= lang('first'); 
		$config['last_link'] 		= lang('last'); 
		$config['num_links']		= 5;                 
		$this->pagination->initialize($config); 
		
		$this->data['links'] 		= $this->pagination->create_links();
		$this->data['per_page'] 	= $config['per_page'];
		$this->data['keyword'] 		= $this->session->userdata('search_product');
			
		$products = $this->product_m->getProducts($this->session->userdata('search_product'), $config['per_page'], (int) $this->uri->segment(4));
		
		$this->data['products'] 	= $products;		
		
		$this->data['subview'] 		= 'admin/products/index';
	
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	// load product categories
	function categories()
	{
		$this->data['breadcrumb'] = lang('products_admin_categories_breadcrumb');
		$this->data['meta_title'] = lang('products_admin_categories_meta_title');
		$this->data['sub_title'] = lang('products_admin_categories_sub_title');
		
		$this->load->model('categories_m');
		
		// ordering categories.
		if($id = $this->input->post('order_id'))
		{
			$order_number = $this->input->post('order_number');
			if(is_numeric($order_number))
			{
				$data['order'] = $order_number;
				if($this->categories_m->save($data, $id))
				{
					echo '1';
				}
			}
			return;
		}
		
		if($this->input->post('per_page'))
			$this->session->set_userdata('search_category_product', $this->input->post('search_category'));
		
		// pagination		
		$this->load->library('pagination');
		$config['base_url'] = site_url('/admin/products/categories');
			
		$config['total_rows'] = $this->categories_m->getCategories('product', true, '', $this->session->userdata('search_category_product'));
		
		$config['per_page'] = 20;		
		if($this->input->post('per_page'))
		{
			if($this->input->post('per_page') == 'all')
				$config['per_page'] = $this->session->set_userdata('per_page', $config['total_rows']);
			else
				$config['per_page'] = $this->session->set_userdata('per_page', $this->input->post('per_page'));	
		}
		
		if($this->session->userdata('per_page') != '')
			$config['per_page'] = $this->session->userdata('per_page');
		
		$this->load->helper('admin');
		$config['uri_segment'] 		= 4; 
		$config['next_link'] 		= lang('next'); 
		$config['prev_link'] 		= lang('prev'); 
		$config['first_link'] 		= lang('first'); 
		$config['last_link'] 		= lang('last'); 
		$config['num_links']		= 5;                 
		$this->pagination->initialize($config); 
		$this->data['links'] 		= $this->pagination->create_links();
		$this->data['per_page'] 	= $config['per_page'];
		$this->data['search'] 	= $this->session->userdata('search_category_product');
		
		$this->data['categories'] = $this->categories_m->getCategories('product', false, true, $this->data['search'], $config['per_page'], (int) $this->uri->segment(4));
		$this->data['subview'] = 'admin/products/categories';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	// add edit category
	function categoryEdit($id = '')
	{
		$this->data['id'] = $id;
		$this->data['error'] = '';
		
		$this->load->model('categories_m');
		$this->data['category'] = $this->categories_m->getNew();
		
		if($id == '')
		{
			$this->data['breadcrumb'] = lang('products_admin_add_category_breadcrumb');
			$this->data['meta_title'] = lang('products_admin_add_category_meta_title');
			$this->data['sub_title'] = lang('products_admin_add_category_sub_title');
		}
		else
		{
			$this->data['breadcrumb'] = lang('products_admin_edit_category_breadcrumb');
			$this->data['meta_title'] = lang('products_admin_edit_category_meta_title');
			$this->data['sub_title'] = lang('products_admin_edit_category_sub_title');
			$category = $this->categories_m->getCategorie('product', $id);
			if(count($category) > 0)
				$this->data['category'] = $category;
			else
				redirect(site_url().'/admin/products/categories');
		}
		
		if($data = $this->input->post('data'))
		{
			$this->form_validation->set_rules('data[title]', lang('title'), 'trim|required|min_length[2]|max_length[200]');
			if ($this->form_validation->run() == TRUE)
			{
				if($data['slug'] == '')
					$data['slug'] = $data['title'];
						
				if(!preg_match('/^[a-zA-Z0-9._]+?[a-zA-Z0-9]+$/D', $data['slug']))
				{
					$this->load->helper('text');
					$data['slug'] = url_title($data['slug']);
				}
						
				if($id == '')
				{
					$data['type'] = 'product';
					$data['created'] = date('Y-m-d H:i:s');
					$cate_id = $this->categories_m->save($data);
					if($cate_id != '')
					{
						$this->session->set_flashdata('msg', lang('products_add_category_susscess_msg'));
						redirect(site_url('/admin/products/categories'));
					}else
					{
						$this->session->set_flashdata('error', lang('products_add_category_error'));
						redirect(site_url('/admin/products/categories'));
					}
				}else
				{
					if($this->categories_m->save($data, $id))
					{
						$this->session->set_flashdata('msg', lang('products_edit_category_susscess_msg'));
						redirect(site_url().'admin/products/categories');
					}else
					{
						$this->session->set_flashdata('error', lang('products_edit_category_error'));
						redirect(site_url('/admin/products/categories'));
					}
				}
			}
		}
		
		// get page layout
		$this->load->model('layout_m');
		$this->data['layouts']	= $this->layout_m->getLayouts(array('categories','category'));
			
		$categories = $this->categories_m->getCategories('product');
		$this->data['categories'] = categoriesToTree($categories);
		$this->data['subview'] = 'admin/products/edit_cate';
		$this->load->view('admin/_layout_main', $this->data);	
	}
	
	
	// Management product category: add, remove in product page 
	function category($task = null)
	{
		$this->load->model('categories_m');
		
		switch($task)
		{
			// add category
			case 'add':
				$data = array();
				$data['error'] = 0;
				$data['mgs'] = '';
		
				$title = $this->input->post('title');							
				
				// check title
				if($title == '')
				{
					$data['error'] = 1;
					$data['mgs'] 	= lang('product_title_mgs');
					echo json_encode($data); 
					exit();
				}
				
				$cateid 			= $this->input->post('cateid');
				
				// load category field					
				$data 				= $this->categories_m->getNew();
				
				$data->title 		= $title;
				$data->slug 		= url_title($title);
				$data->parent_id 	= $cateid;
				$data->type 		= 'product';
				// save category
				$id = $this->categories_m->save(json_decode(json_encode($data), true), null);			
				
				// load all category with tree
				$data 				= array();				
				$data['id'] 		= $id;
				break;
			case 'remove':				
				$ids 	= $this->input->post('ids');				
				// remove categories
				$this->categories_m->remove($ids);
				
				$data				= array();
				break;
		}
		
		$categories 		= $this->categories_m->getCategories('product', false);
		$categories			= categoriesToTree($categories);
		$data['content'] 	= dispayTree( $categories, 0, array('type'=>'checkbox', 'name'=>'product[category][]') );				
		$data['list'] 		= '<option value="0">'. lang('product_parent_category') . '</option>' . dispayTree( $categories, 0, array('type'=>'select', 'name'=>'') );				
		echo json_encode($data);
		exit(); 		
	}

	// add edit product
	function edit($id = null)
	{
		$this->load->model('product_m');
		$this->lang->load('products');
			
		$this->data['breadcrumb'] 	= lang('products_breadcrumb');
		$this->data['meta_title'] 	= lang('products_meta_title');
		$this->data['sub_title'] 	= lang('products_sub_title');			
		
		// check product exist
		if($id != null)
		{
			$product = $this->product_m->getProduct( array( 'id'=>$id ) );
			if (count($product) == 0) $id = null;
		}
		
		if($id == null)
		{
			// add new product
			$this->data['sub_title'] 	= lang('product_add');
			
			$product 					= $this->product_m->getNew();
			
			$this->data['product'] 		= $product;
			$this->data['cate_checked'] = array();
		}
		else
		{
			// edit product
			$this->data['sub_title'] 	= lang('product_edit');
			
			// load product info
			$product 					= $this->product_m->getProduct( array( 'id'=>$id ) );
			
			if( count($product) )
			{
				$this->data['product'] 	= $product[0];
				$this->data['id'] 		= $id;
			}
			else
			{
				$product = $this->product_m->getNew();
				$this->data['product'] 	= $product;
			}
			
			$this->data['cate_checked']	= $this->product_m->getProductCategories($id, false);
			
			// product prices
			$prices 					= $this->product_m->getProductPrice($id);			
			$this->data['prices'] 		= $prices;
			
			// product design
			$design						= $this->product_m->getProductDesign($id);
			
			// product attribute
			$attribute 					= $this->product_m->getAttribute($id);
		}
		
		
		// load attribute of product		
		if(isset($attribute) && $attribute !== false)
		{			
			$fields 				= array();
			$fields['name'] 		= json_decode($attribute->name);
			$fields['type'] 		= json_decode($attribute->type);
			$fields['titles'] 		= json_decode($attribute->titles);
			$fields['prices'] 		= json_decode($attribute->prices);
			
		}
		else
		{
			$fields = array(
				'name'=>array(''), 
				'type'=> array(''), 
				'titles'=>array(), 
				'prices'=>array()
			);
		}
		$this->data['fields'] = $fields;
		
		
		if( isset($design) && count($design) )
		{
			$this->load->helper('product');
			$design = helperProduct::json($design);
			$design->options = helperProduct::sortDesign($design);		
		}
		else
		{
			$design 				= new stdClass();
			$design->params 		= new stdClass();
			$design->area			= new stdClass();
			
			$design->params->front 	= "{'width':'21','height':'29','lockW':true,'lockH':true,'setbg':false,'shape':'square','shapeVal':0}";
			$design->params->back	= "{'width':'21','height':'29','lockW':true,'lockH':true,'setbg':false,'shape':'square','shapeVal':0}";
			$design->params->left 	= "{'width':'21','height':'29','lockW':true,'lockH':true,'setbg':false,'shape':'square','shapeVal':0}";
			$design->params->right 	= "{'width':'21','height':'29','lockW':true,'lockH':true,'setbg':false,'shape':'square','shapeVal':0}";
			$design->area->front 	= "{'width':204,'height':283,'left':'135px','top':'90px','radius':'0px','zIndex':''}";
			$design->area->back 	= "{'width':204,'height':283,'left':'135px','top':'90px','radius':'0px','zIndex':''}";
			$design->area->left 	= "{'width':204,'height':283,'left':'135px','top':'90px','radius':'0px','zIndex':''}";
			$design->area->right 	= "{'width':204,'height':283,'left':'135px','top':'90px','radius':'0px','zIndex':''}";
		}		
		
		$this->load->model('settings_m');
		$shop 							= $this->settings_m->getSetting();
		$this->data['shop'] 			= $shop;
		
		$this->data['design'] 			= $design;				
		
		// get categories		
		$this->load->model('categories_m');
		$categories 					= $this->categories_m->getCategories('product', false);			
		
		if (count($categories)){
			$categories					= categoriesToTree($categories);	
			$this->data['categories']	= $categories;
		} else {
			$this->data['categories'] 	= array();
		}
		
		$this->load->model('layout_m');
		$this->data['layouts'] 			= $this->layout_m->getLayouts('product');
		
		$this->data['subview'] 			= 'admin/products/edit';
		
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	
	// save product
	function save()
	{
		$product 	= $this->input->post('product');		
		$this->form_validation->set_rules('product[data][title]', lang('product_validate_msg') . lang('product_product_name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('product[data][sku]', lang('product_validate_msg') . lang('product_sku'), 'trim|required|xss_clean');      
		
		
		// Process form
		if ($this->form_validation->run() == false || $product['data']['title'] == '')
		{			
			redirect('admin/products/edit/' . $product['id']);
		}
		
		if ($product['data']['slug'] == '')
			$product['data']['slug'] = url_title($product['data']['title'], '-', TRUE);
		
		
		
		$this->load->model('product_m');
		if( isset($product['data']) )
		{			
			if($product['id'] > 0)
				$id 	= $this->product_m->save( $product['data'], $product['id'] );
			else
				$id 	= $this->product_m->save( $product['data'] );
		}
		
		// get all category of this product
		$categories = $this->product_m->getProductCategories($id);
	
		$add = array();
		// remove categories not choose
		if( count($categories) )
		{
			if ((isset($product['category']) && count($product['category']) == 0) || empty($product['category']))
				$product['category'] = array();
			$this->product_m->_table_name = 'product_categories';
			foreach($categories as $category)
			{
				if( in_array($category->cate_id, $product['category']) == false )
				{
					 $this->product_m->delete($category->id);
				}
				else
				{
					$add[] = $category->cate_id;
				}
			}
		}
			
		
		// add product category
		if( isset($product['category']) && count($product['category']) > 0 )
		{
			$this->product_m->_table_name = 'product_categories';
			$this->product_m->_timestamps = false;
			$data = array();
			$data['product_id']	= $id;
			
			for($i=0; $i<count($product['category']); $i++)
			{
				if( in_array($product['category'][$i], $add) == false )
				{
					$data['cate_id'] = $product['category'][$i];
					$this->product_m->save($data);
				}
			}
		}
		
		/* product price */
		$this->product_m->_table_name = 'product_prices';
		$this->product_m->_timestamps = false;
		
		$productPrice = $this->product_m->getProductPrice($id);
		
		if( isset($product["prices"]["price"]) )
		{
			$prices 	= $product["prices"]["price"];
			$minPrice 	= $product["prices"]["min_quantity"];
			$maxPrice 	= $product["prices"]["max_quantity"];
			if( count($prices) && $prices[0] != '' && count($minPrice) && $minPrice[0] != '' && count($maxPrice) && $maxPrice[0] != '' )
			{
				if( count($productPrice) ) $price_id = 	$productPrice[0]->id;
				else $price_id = null;
				
				$data = array();
				$data['product_id'] 	= $id;
				$data['price'] 			= json_encode($prices);
				$data['min_quantity'] 	= json_encode($minPrice);
				$data['max_quantity'] 	= json_encode($maxPrice);
				
				$this->product_m->save($data, $price_id);
			}
			else
			{
				if( count($productPrice) )
				{
					$this->product_m->delete($productPrice[0]->id);
				}
			}
		}
		else
		{
			if( count($productPrice) )
			{
				$this->product_m->delete($productPrice[0]->id);
			}
		}
		
		/* product design */
		$pDesign	= $this->product_m->getProductDesign($id);
		$this->product_m->_table_name = 'products_design';
		$this->product_m->_timestamps = false;
		if( isset($product['design']) )
		{
			$design 				= $this->product_m->getNew('design');
			$design['product_id'] 	= $id;
			
			foreach( $product['design'] as $key => $value )
			{
				$design[$key]		= json_encode($value);
			}
			
			if( count($pDesign) )
			{
				$this->product_m->save($design, $pDesign->id);
			}
			else
			{
				$this->product_m->save($design);
			}
		}else{
			if( count($pDesign) )
			{
				$this->product_m->delete($pDesign->id);
			}
		}
		
		// product attribute
		$attribute = $this->product_m->getAttribute($id);		
		$this->product_m->_table_name = 'attributes';
		$this->product_m->_timestamps = false;
		if (isset($product['fields']) && count($product['fields']) > 0)
		{	
			$fields = array();
			$i = 0;
			foreach ($product['fields'] as $field){
				if($field['name'] != '')
				{
					$fields['name'][] 	= $field['name'];
					$fields['titles'][] = $field['titles'];
					$fields['prices'][] = $field['prices'];				
					$fields['type'][] 	= $field['type'];						
				}
			}
			
			if(count($fields))
			{
				$data = array(
					'name' 		=> json_encode($fields['name']),
					'titles' 	=> json_encode($fields['titles']),
					'prices' 	=> json_encode($fields['prices']),
					'type' 		=> json_encode($fields['type']),
					'product_id'=> $id					
				);
				
				if (isset($attribute->id) && count($attribute))
					$this->product_m->save($data, $attribute->id);
				else
					$this->product_m->save($data, null);
			}
		}
		else
		{
			if (count($attribute))
				$this->product_m->delete($attribute->id);
		}
		
		redirect('admin/products/edit/'.$id);
	}
	
	// view box design with change area
	function design()
	{
		$this->data['position'] 	= $this->input->post('position');
		$this->data['color'] 		= $this->input->post('color');
		$this->data['title'] 		= $this->input->post('title');
		$this->data['number'] 		= $this->input->post('number');
		
		$this->load->view('admin/products/design', $this->data);
	}
	
	// set product default in design tool
	function setDefault($id = null){
		if($id != null)
		{
			$this->load->model('product_m');
			$product = $this->product_m->getProduct( array( 'id'=>$id ) );
			if ( count($product) > 0 )
			{
				// add default = 0 with all product
				$data = array(
				   'default' => '0'				   
				);				
				$this->db->update('products', $data);

				// set default to this product
				$data = array(
				   'default' => '1'				   
				);
				$this->product_m->db->where('id', $id);
				$this->db->update('products', $data);
			}
		}
		redirect('admin/products');
	}
	
	public function publish($type = '', $id = '')
	{		
		$data = array('published'=> 1);
		
		// publish with product category
		if($type == 'category')
		{
			$this->load->model('categories_m');
			// publish with one item
			if($id != '')
			{
				if ((int) $id > 0)
					$this->categories_m->save($data, $id);
			}
			else
			{
				// publish with many items
				if($checkb = $this->input->post('checkb'))
				{
					if(is_array($checkb))
					{
						foreach($checkb as $id)
						{
							$this->categories_m->save($data, $id);
						}
					}
				}
			}
			redirect(site_url('/admin/products/categories'));
		}
		// publish with products
		elseif($type == 'product')
		{
			$this->load->model('product_m');
			// publish with one item
			if($id != '')
			{
				if ((int)$id > 0)
				$this->product_m->save($data, $id);
			}
			else
			{
				// publish with many items
				if($checkb = $this->input->post('ids'))
				{
					if(is_array($checkb))
					{
						foreach($checkb as $id)
						{
							$this->product_m->save($data, $id);
						}
					}
				}
			}
			redirect(site_url('/admin/products'));
		}
	}
	
	public function unPublish($type = '', $id = '')
	{
		$data = array('published'=> 0);
		
		if($type == 'category')
		{			
			$this->load->model('categories_m');
			if($id != '' && (int) $id > 0)
			{
				$this->categories_m->save($data, $id);
			}
			else
			{
				if($checkb = $this->input->post('checkb'))
				{
					if(is_array($checkb))
					{
						foreach($checkb as $id)
						{
							$this->categories_m->save($data, $id);
						}
					}
				}
			}
			redirect(site_url('/admin/products/categories'));
		}
		elseif($type == 'product')
		{
			$this->load->model('product_m');
			if($id != '' && (int) $id > 0)
			{
				$this->product_m->save($data, $id);
			}
			else
			{
				if($checkb = $this->input->post('ids'))
				{
					if(is_array($checkb))
					{
						foreach($checkb as $id)
						{
							$this->product_m->save($data, $id);
						}
					}
				}
			}
			redirect(site_url('/admin/products'));
		}
	}
	
	public function featured($id = '')
	{		
		$data = array('future'=> 1);
		
		// featured with products
		$this->load->model('product_m');
		// publish with one item
		if($id != '')
		{
			if ((int)$id > 0)
			$this->product_m->save($data, $id);
		}
		redirect(site_url('/admin/products'));
	}
	
	public function unFeatured($id = '')
	{		
		$data = array('future'=> 0);
		
		// featured with products
		$this->load->model('product_m');
		// publish with one item
		if($id != '')
		{
			if ((int)$id > 0)
			$this->product_m->save($data, $id);
		}
		redirect(site_url('/admin/products'));
	}
	
	public function delete($type = '', $id = '')
	{
		if($type == 'category')
		{
			$this->load->model('categories_m');
			if($id != '')
			{
				$categories = $this->categories_m->getAllCategories('product');
				$categories = categoriesToTree($categories, $id);
				$categories = getChildCate($categories);
				$data['parent_id'] = 0;
			
				if($this->categories_m->delete($id))
				{
					$this->session->set_flashdata('msg', lang('products_category_delete_success_msg'));
					// update parent_id.
					foreach($categories as $cate_id)
					{
						$this->categories_m->save($data, $cate_id);
					}
				}else
				{
					$this->session->set_flashdata('error', lang('products_category_delete_error_msg'));
				}
			}
			else
			{
				if($checkb = $this->input->post('checkb'))
				{
					if(is_array($checkb))
					{
						$check = true;
						foreach($checkb as $id)
						{
							if(!$this->categories_m->delete($id))
							{
								$check = false;
								break;
							}
						}
						if($check == true)
							$this->session->set_flashdata('msg', lang('products_category_delete_success_msg'));
						else
							$this->session->set_flashdata('error', lang('products_category_delete_some_error_msg'));
					}
				}
			}
			redirect(site_url('/admin/products/categories'));
		}
		elseif($type == 'product')
		{
			$this->load->model('product_m');			
			if($id != '')
			{
				if ((int)$id > 0)
					$this->product_m->remove($id);
			}
			else
			{
				// publish with many items
				if($checkb = $this->input->post('ids'))
				{
					if(is_array($checkb))
					{
						foreach($checkb as $id)
						{
							$this->product_m->remove($id);
						}
					}
				}
			}
			redirect(site_url('/admin/products'));
		}
	}
}
?>